<?php

namespace App\Http\Controllers\CS\Shift;

use App\Http\Controllers\Controller;
use App\Models\ShiftRequest;
use App\Models\ShiftSchedule;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ShiftRequestController extends Controller
{
    /**
     * Display CS's shift requests
     */
    public function index()
    {
        $csProfile = auth()->user()->csProfile;

        $requests = ShiftRequest::where('cs_profile_id', $csProfile->id)
            ->with('approver')
            ->latest()
            ->paginate(10);

        return view('cs.shift.requests', compact('requests'));
    }

    /**
     * Show form to request day off (only on 23-24)
     */
    public function create()
    {
        $csProfile = auth()->user()->csProfile;

        // Check if in request period (23-24)
        if (!ShiftRequest::isRequestPeriod()) {
            return redirect()->route('cs.shift.index')
                ->withErrors(['period' => 'Request libur hanya bisa dilakukan tanggal 23-24 setiap bulan.']);
        }

        // Target month is next month
        $nextMonth = now()->addMonth();
        $year = $nextMonth->year;
        $month = $nextMonth->month;

        // Get existing requests for next month
        $existingRequests = ShiftRequest::where('cs_profile_id', $csProfile->id)
            ->where('request_year', $year)
            ->where('request_month', $month)
            ->get();

        // Check if schedule exists for next month
        $scheduleExists = ShiftSchedule::where('cs_profile_id', $csProfile->id)
            ->where('schedule_year', $year)
            ->where('schedule_month', $month)
            ->exists();

        if (!$scheduleExists) {
            return redirect()->route('cs.shift.index')
                ->withErrors(['schedule' => 'Jadwal untuk bulan depan belum dibuat oleh Admin.']);
        }

        return view('cs.shift.request-create', compact('year', 'month', 'existingRequests'));
    }

    /**
     * Store shift request
     */
    public function store(Request $request)
    {
        $csProfile = auth()->user()->csProfile;

        // Check if in request period
        if (!ShiftRequest::isRequestPeriod()) {
            return back()->withErrors(['period' => 'Request libur hanya bisa dilakukan tanggal 23-24 setiap bulan.']);
        }

        $validated = $request->validate([
            'requested_date' => 'required|date|after:today',
            'reason' => 'nullable|string|max:500',
        ]);

        $requestedDate = Carbon::parse($validated['requested_date']);
        $year = $requestedDate->year;
        $month = $requestedDate->month;

        // Check if already requested this date
        $exists = ShiftRequest::where('cs_profile_id', $csProfile->id)
            ->where('requested_date', $validated['requested_date'])
            ->whereIn('status', ['pending', 'approved'])
            ->exists();

        if ($exists) {
            return back()->withErrors(['requested_date' => 'Anda sudah pernah request tanggal ini.']);
        }

        // Check if schedule exists for this date
        $schedule = ShiftSchedule::where('cs_profile_id', $csProfile->id)
            ->where('schedule_date', $validated['requested_date'])
            ->first();

        if (!$schedule) {
            return back()->withErrors(['requested_date' => 'Jadwal untuk tanggal ini belum dibuat.']);
        }

        // Check if already off day
        if ($schedule->shift_type === 'off') {
            return back()->withErrors(['requested_date' => 'Tanggal ini sudah hari libur Anda.']);
        }

        // Create request
        ShiftRequest::create([
            'cs_profile_id' => $csProfile->id,
            'request_year' => $year,
            'request_month' => $month,
            'requested_date' => $validated['requested_date'],
            'reason' => $validated['reason'],
            'status' => 'pending',
            'request_submitted_at' => now(),
        ]);

        return redirect()->route('cs.shift.requests.index')
            ->with('success', 'Request libur berhasil dikirim. Menunggu persetujuan Admin.');
    }

    /**
     * Show request detail
     */
    public function show($id)
    {
        $csProfile = auth()->user()->csProfile;

        $request = ShiftRequest::where('cs_profile_id', $csProfile->id)
            ->with('approver')
            ->findOrFail($id);

        return view('cs.shift.request-show', compact('request'));
    }

    /**
     * Cancel pending request
     */
    public function cancel($id)
    {
        $csProfile = auth()->user()->csProfile;

        $shiftRequest = ShiftRequest::where('cs_profile_id', $csProfile->id)
            ->findOrFail($id);

        // Can only cancel if pending
        if ($shiftRequest->status !== 'pending') {
            return back()->withErrors(['status' => 'Hanya request yang masih pending yang bisa dibatalkan.']);
        }

        // Can only cancel during request period
        if (!ShiftRequest::isRequestPeriod()) {
            return back()->withErrors(['period' => 'Cancel request hanya bisa dilakukan tanggal 23-24.']);
        }

        $shiftRequest->delete();

        return redirect()->route('cs.shift.requests.index')
            ->with('success', 'Request libur berhasil dibatalkan.');
    }

    /**
     * Show request guide/info
     */
    public function guide()
    {
        $csProfile = auth()->user()->csProfile;
        $isRequestPeriod = ShiftRequest::isRequestPeriod();
        $today = now()->day;

        // Calculate days until request period
        $daysUntilRequestPeriod = 0;
        if ($today < 23) {
            $daysUntilRequestPeriod = 23 - $today;
        } elseif ($today > 24) {
            $nextMonth = now()->addMonth();
            $daysUntilRequestPeriod = $nextMonth->day(23)->diffInDays(now());
        }

        return view('cs.shift.request-guide', compact('isRequestPeriod', 'daysUntilRequestPeriod'));
    }
}
