<?php

namespace App\Http\Controllers\CS\Performance;

use App\Http\Controllers\Controller;
use App\Models\PerformanceReview;
use App\Models\PerformanceKpiTemplate;
use Illuminate\Http\Request;

class PerformanceViewController extends Controller
{
    /**
     * Display CS's own performance reviews
     */
    public function index(Request $request)
    {
        $csProfile = auth()->user()->csProfile;

        $query = PerformanceReview::where('cs_profile_id', $csProfile->id)
            ->whereIn('status', ['submitted_koordinator', 'completed'])
            ->latest('review_year')
            ->latest('review_month');

        // Filter by year
        if ($request->filled('year')) {
            $query->where('review_year', $request->year);
        }

        $reviews = $query->paginate(12);

        // Get available years
        $years = PerformanceReview::where('cs_profile_id', $csProfile->id)
            ->selectRaw('DISTINCT review_year')
            ->pluck('review_year');

        return view('cs.performance.index', compact('reviews', 'years'));
    }

    /**
     * Display the specified review
     */
    public function show($id)
    {
        $csProfile = auth()->user()->csProfile;

        $review = PerformanceReview::with(['koordinator', 'admin'])
            ->where('cs_profile_id', $csProfile->id)
            ->findOrFail($id);

        $kpiTemplates = PerformanceKpiTemplate::active()->ordered()->get();

        return view('cs.performance.show', compact('review', 'kpiTemplates'));
    }

    /**
     * Show performance history/trend
     */
    public function history(Request $request)
    {
        $csProfile = auth()->user()->csProfile;
        $year = $request->get('year', now()->year);

        $reviews = PerformanceReview::where('cs_profile_id', $csProfile->id)
            ->where('review_year', $year)
            ->where('status', 'completed')
            ->orderBy('review_month')
            ->get();

        // Calculate statistics
        $stats = [
            'total_reviews' => $reviews->count(),
            'average_score' => $reviews->avg('average_score'),
            'highest_score' => $reviews->max('average_score'),
            'lowest_score' => $reviews->min('average_score'),
            'average_punctuality' => $reviews->avg('punctuality_score'),
            'average_work_quality' => $reviews->avg('work_quality_score'),
            'average_attendance' => $reviews->avg('attendance_score'),
            'average_checkout' => $reviews->avg('checkout_time_score'),
        ];

        // Prepare chart data
        $chartData = [
            'months' => $reviews->pluck('review_month')->toArray(),
            'scores' => $reviews->pluck('average_score')->toArray(),
            'punctuality' => $reviews->pluck('punctuality_score')->toArray(),
            'work_quality' => $reviews->pluck('work_quality_score')->toArray(),
            'attendance' => $reviews->pluck('attendance_score')->toArray(),
            'checkout' => $reviews->pluck('checkout_time_score')->toArray(),
        ];

        // Get available years
        $years = PerformanceReview::where('cs_profile_id', $csProfile->id)
            ->selectRaw('DISTINCT review_year')
            ->pluck('review_year');

        return view('cs.performance.history', compact('reviews', 'stats', 'chartData', 'year', 'years'));
    }

    /**
     * Show current month review status
     */
    public function current()
    {
        $csProfile = auth()->user()->csProfile;
        $currentYear = now()->year;
        $currentMonth = now()->month;

        $review = PerformanceReview::where('cs_profile_id', $csProfile->id)
            ->where('review_year', $currentYear)
            ->where('review_month', $currentMonth)
            ->first();

        $kpiTemplates = PerformanceKpiTemplate::active()->ordered()->get();

        // Get previous month for comparison
        $previousMonth = now()->subMonth();
        $previousReview = PerformanceReview::where('cs_profile_id', $csProfile->id)
            ->where('review_year', $previousMonth->year)
            ->where('review_month', $previousMonth->month)
            ->where('status', 'completed')
            ->first();

        return view('cs.performance.current', compact('review', 'kpiTemplates', 'previousReview'));
    }
}
