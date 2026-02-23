<?php

namespace App\Http\Controllers\CS\Shift;

use App\Http\Controllers\Controller;
use App\Models\ShiftSchedule;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ShiftViewController extends Controller
{
    /**
     * Display CS's monthly schedule
     */
    public function index(Request $request)
    {
        $csProfile = auth()->user()->csProfile;
        $year = $request->get('year', now()->year);
        $month = $request->get('month', now()->month);

        $startDate = Carbon::create($year, $month, 1);
        $endDate = $startDate->copy()->endOfMonth();

        // Get schedules for this month
        $schedules = ShiftSchedule::where('cs_profile_id', $csProfile->id)
            ->where('schedule_year', $year)
            ->where('schedule_month', $month)
            ->orderBy('schedule_date')
            ->get()
            ->keyBy(function($item) {
                return $item->schedule_date->format('Y-m-d');
            });

        // Check if published
        $isPublished = !$schedules->isEmpty() && $schedules->first()->published_at !== null;

        // Statistics
        $stats = [
            'total_days' => $schedules->count(),
            'work_days' => $schedules->where('shift_type', 'work')->count(),
            'off_days' => $schedules->where('shift_type', 'off')->count(),
            'worked' => $schedules->where('status', 'worked')->count(),
            'remaining' => $schedules->where('status', 'scheduled')->where('shift_type', 'work')->count(),
        ];

        return view('cs.shift.index', compact('schedules', 'year', 'month', 'startDate', 'endDate', 'isPublished', 'stats'));
    }

    /**
     * Show calendar view
     */
    public function calendar(Request $request)
    {
        $csProfile = auth()->user()->csProfile;
        $year = $request->get('year', now()->year);
        $month = $request->get('month', now()->month);

        $startDate = Carbon::create($year, $month, 1);
        $endDate = $startDate->copy()->endOfMonth();

        // Get schedules
        $schedules = ShiftSchedule::where('cs_profile_id', $csProfile->id)
            ->where('schedule_year', $year)
            ->where('schedule_month', $month)
            ->orderBy('schedule_date')
            ->get();

        // Check if published
        $isPublished = !$schedules->isEmpty() && $schedules->first()->published_at !== null;

        return view('cs.shift.calendar', compact('schedules', 'year', 'month', 'startDate', 'endDate', 'isPublished'));
    }

    /**
     * Show next month preview (after 25th)
     */
    public function preview()
    {
        $csProfile = auth()->user()->csProfile;
        $nextMonth = now()->addMonth();
        $year = $nextMonth->year;
        $month = $nextMonth->month;

        // Check if today >= 25th
        if (now()->day < 25) {
            return redirect()->route('cs.shift.index')
                ->withErrors(['schedule' => 'Jadwal bulan depan akan dipublish tanggal 25.']);
        }

        $schedules = ShiftSchedule::where('cs_profile_id', $csProfile->id)
            ->where('schedule_year', $year)
            ->where('schedule_month', $month)
            ->whereNotNull('published_at')
            ->orderBy('schedule_date')
            ->get();

        if ($schedules->isEmpty()) {
            return redirect()->route('cs.shift.index')
                ->withErrors(['schedule' => 'Jadwal bulan depan belum tersedia.']);
        }

        $startDate = Carbon::create($year, $month, 1);
        $endDate = $startDate->copy()->endOfMonth();

        return view('cs.shift.preview', compact('schedules', 'year', 'month', 'startDate', 'endDate'));
    }

    /**
     * Show schedule history
     */
    public function history(Request $request)
    {
        $csProfile = auth()->user()->csProfile;
        $year = $request->get('year', now()->year);

        // Get all months with schedules for this year
        $monthlyStats = ShiftSchedule::where('cs_profile_id', $csProfile->id)
            ->where('schedule_year', $year)
            ->selectRaw('schedule_month,
                COUNT(*) as total_days,
                SUM(CASE WHEN shift_type = "work" THEN 1 ELSE 0 END) as work_days,
                SUM(CASE WHEN shift_type = "off" THEN 1 ELSE 0 END) as off_days,
                SUM(CASE WHEN status = "worked" THEN 1 ELSE 0 END) as worked,
                SUM(CASE WHEN status = "absent" THEN 1 ELSE 0 END) as absent')
            ->groupBy('schedule_month')
            ->orderBy('schedule_month')
            ->get();

        // Get available years
        $years = ShiftSchedule::where('cs_profile_id', $csProfile->id)
            ->selectRaw('DISTINCT schedule_year')
            ->pluck('schedule_year');

        return view('cs.shift.history', compact('monthlyStats', 'year', 'years'));
    }
}
