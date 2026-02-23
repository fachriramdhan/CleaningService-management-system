<?php

namespace App\Http\Controllers\Admin\Shift;

use App\Http\Controllers\Controller;
use App\Models\ShiftSchedule;
use App\Models\ShiftRequest;
use App\Models\CsProfile;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class ShiftScheduleController extends Controller
{
    /**
     * Display shift schedule calendar
     */
    public function index(Request $request)
    {
        $year = $request->get('year', now()->year);
        $month = $request->get('month', now()->month);

        $startDate = Carbon::create($year, $month, 1);
        $endDate = $startDate->copy()->endOfMonth();

        // Get all schedules for this month
        $schedules = ShiftSchedule::with('csProfile.user')
            ->where('schedule_year', $year)
            ->where('schedule_month', $month)
            ->get()
            ->groupBy('cs_profile_id');

        $csProfiles = CsProfile::with('user')->get();

        // Check if schedule is published
        $isPublished = ShiftSchedule::where('schedule_year', $year)
            ->where('schedule_month', $month)
            ->whereNotNull('published_at')
            ->exists();

        return view('admin.shift.index', compact('schedules', 'csProfiles', 'year', 'month', 'startDate', 'endDate', 'isPublished'));
    }

    /**
     * Show form to generate new schedule
     */
    public function create()
    {
        $nextMonth = now()->addMonth();
        $year = $nextMonth->year;
        $month = $nextMonth->month;

        // Check if schedule already exists
        $exists = ShiftSchedule::where('schedule_year', $year)
            ->where('schedule_month', $month)
            ->exists();

        if ($exists) {
            return redirect()->route('admin.shift.index', ['year' => $year, 'month' => $month])
                ->withErrors(['schedule' => 'Jadwal untuk bulan tersebut sudah ada.']);
        }

        $csProfiles = CsProfile::with('user')->get();

        // Get pending shift requests for this month
        $pendingRequests = ShiftRequest::with('csProfile.user')
            ->where('request_year', $year)
            ->where('request_month', $month)
            ->where('status', 'pending')
            ->get()
            ->groupBy('cs_profile_id');

        return view('admin.shift.create', compact('csProfiles', 'year', 'month', 'pendingRequests'));
    }

    /**
     * Generate monthly schedule for all CS
     */
    public function generate(Request $request)
    {
        $validated = $request->validate([
            'year' => 'required|integer|min:2020|max:2100',
            'month' => 'required|integer|min:1|max:12',
        ]);

        $year = $validated['year'];
        $month = $validated['month'];

        // Check if schedule already exists
        $exists = ShiftSchedule::where('schedule_year', $year)
            ->where('schedule_month', $month)
            ->exists();

        if ($exists) {
            return back()->withErrors(['schedule' => 'Jadwal untuk bulan tersebut sudah ada.']);
        }

        $csProfiles = CsProfile::all();
        $totalSchedules = 0;

        // Generate schedule for each CS with rotating day off (0-6 for Sun-Sat)
        foreach ($csProfiles as $index => $csProfile) {
            $dayOffPattern = $index % 7; // Each CS gets different day off

            $count = ShiftSchedule::generateMonthlySchedule(
                $csProfile->id,
                $year,
                $month,
                $dayOffPattern,
                auth()->id()
            );

            $totalSchedules += $count;
        }

        return redirect()->route('admin.shift.requests', ['year' => $year, 'month' => $month])
            ->with('success', "Jadwal berhasil digenerate untuk {$csProfiles->count()} CS ({$totalSchedules} hari). Silakan review request libur dari CS.");
    }

    /**
     * Show shift requests for approval
     */
    public function requests(Request $request)
    {
        $year = $request->get('year', now()->addMonth()->year);
        $month = $request->get('month', now()->addMonth()->month);

        $requests = ShiftRequest::with('csProfile.user')
            ->where('request_year', $year)
            ->where('request_month', $month)
            ->latest()
            ->paginate(20);

        return view('admin.shift.requests', compact('requests', 'year', 'month'));
    }

    /**
     * Approve shift request
     */
    public function approveRequest(Request $request, $id)
    {
        $shiftRequest = ShiftRequest::findOrFail($id);

        if ($shiftRequest->status !== 'pending') {
            return back()->withErrors(['status' => 'Request sudah diproses.']);
        }

        $shiftRequest->approve(auth()->id());

        return back()->with('success', 'Request libur disetujui. Jadwal telah diupdate.');
    }

    /**
     * Reject shift request
     */
    public function rejectRequest(Request $request, $id)
    {
        $validated = $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);

        $shiftRequest = ShiftRequest::findOrFail($id);

        if ($shiftRequest->status !== 'pending') {
            return back()->withErrors(['status' => 'Request sudah diproses.']);
        }

        $shiftRequest->reject(auth()->id(), $validated['rejection_reason']);

        return back()->with('success', 'Request libur ditolak.');
    }

    /**
     * Publish schedule (on 25th)
     */
    public function publish(Request $request)
    {
        $validated = $request->validate([
            'year' => 'required|integer',
            'month' => 'required|integer',
        ]);

        $count = ShiftSchedule::publishSchedule($validated['year'], $validated['month']);

        return back()->with('success', "Jadwal bulan {$validated['month']}/{$validated['year']} telah dipublish ({$count} hari).");
    }

    /**
     * Edit specific schedule date
     */
    public function edit($id)
    {
        $schedule = ShiftSchedule::with('csProfile.user')->findOrFail($id);

        if ($schedule->isEditable() === false) {
            return back()->withErrors(['schedule' => 'Jadwal sudah terkunci, tidak bisa diedit.']);
        }

        return view('admin.shift.edit', compact('schedule'));
    }

    /**
     * Update specific schedule
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'shift_type' => 'required|in:work,off',
            'notes' => 'nullable|string|max:500',
        ]);

        $schedule = ShiftSchedule::findOrFail($id);

        if ($schedule->isEditable() === false) {
            return back()->withErrors(['schedule' => 'Jadwal sudah terkunci, tidak bisa diedit.']);
        }

        $schedule->update($validated);

        return back()->with('success', 'Jadwal berhasil diupdate.');
    }

    /**
     * Show schedule summary/report
     */
    public function summary(Request $request)
    {
        $year = $request->get('year', now()->year);
        $month = $request->get('month', now()->month);

        $csProfiles = CsProfile::with(['user', 'shiftSchedules' => function($q) use ($year, $month) {
            $q->where('schedule_year', $year)
              ->where('schedule_month', $month);
        }])->get();

        $summary = $csProfiles->map(function($cs) use ($year, $month) {
            $workDays = ShiftSchedule::getWorkDaysCount($cs->id, $year, $month);
            $offDays = ShiftSchedule::getOffDaysCount($cs->id, $year, $month);

            return [
                'cs' => $cs,
                'work_days' => $workDays,
                'off_days' => $offDays,
                'total_days' => $workDays + $offDays,
            ];
        });

        return view('admin.shift.summary', compact('summary', 'year', 'month'));
    }

    /**
     * Delete schedule (if not yet published)
     */
    public function destroy(Request $request)
    {
        $validated = $request->validate([
            'year' => 'required|integer',
            'month' => 'required|integer',
        ]);

        $isPublished = ShiftSchedule::where('schedule_year', $validated['year'])
            ->where('schedule_month', $validated['month'])
            ->whereNotNull('published_at')
            ->exists();

        if ($isPublished) {
            return back()->withErrors(['schedule' => 'Jadwal yang sudah dipublish tidak bisa dihapus.']);
        }

        $count = ShiftSchedule::where('schedule_year', $validated['year'])
            ->where('schedule_month', $validated['month'])
            ->delete();

        return redirect()->route('admin.shift.index')
            ->with('success', "Jadwal bulan {$validated['month']}/{$validated['year']} berhasil dihapus ({$count} hari).");
    }
}
