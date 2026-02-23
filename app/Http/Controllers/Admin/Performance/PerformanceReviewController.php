<?php

namespace App\Http\Controllers\Admin\Performance;

use App\Http\Controllers\Controller;
use App\Models\PerformanceReview;
use App\Models\PerformanceKpiTemplate;
use App\Models\CsProfile;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PerformanceReviewController extends Controller
{
    /**
     * Display a listing of performance reviews
     */
    public function index(Request $request)
    {
        $query = PerformanceReview::with(['csProfile.user', 'koordinator', 'admin'])
            ->latest('review_year')
            ->latest('review_month');

        // Filter by CS
        if ($request->filled('cs_profile_id')) {
            $query->where('cs_profile_id', $request->cs_profile_id);
        }

        // Filter by year
        if ($request->filled('year')) {
            $query->where('review_year', $request->year);
        }

        // Filter by month
        if ($request->filled('month')) {
            $query->where('review_month', $request->month);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $reviews = $query->paginate(15);
        $csProfiles = CsProfile::with('user')->get();

        return view('admin.performance.index', compact('reviews', 'csProfiles'));
    }

    /**
     * Show the form for creating a new review
     */
    public function create(Request $request)
    {
        $csProfileId = $request->get('cs_profile_id');
        $year = $request->get('year', now()->year);
        $month = $request->get('month', now()->month);

        $csProfiles = CsProfile::with('user')->get();
        $kpiTemplates = PerformanceKpiTemplate::active()->ordered()->get();

        $csProfile = null;
        if ($csProfileId) {
            $csProfile = CsProfile::with('user')->find($csProfileId);
        }

        return view('admin.performance.create', compact('csProfiles', 'kpiTemplates', 'csProfile', 'year', 'month'));
    }

    /**
     * Store a newly created review
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'cs_profile_id' => 'required|exists:cs_profiles,id',
            'review_year' => 'required|integer|min:2020|max:2100',
            'review_month' => 'required|integer|min:1|max:12',
            'punctuality_score' => 'nullable|integer|min:1|max:5',
            'work_quality_score' => 'nullable|integer|min:1|max:5',
            'attendance_score' => 'nullable|integer|min:1|max:5',
            'checkout_time_score' => 'nullable|integer|min:1|max:5',
            'overall_notes' => 'nullable|string|max:1000',
            'improvement_plan' => 'nullable|string|max:1000',
            'achievement_notes' => 'nullable|string|max:1000',
        ]);

        // Check if review already exists
        $exists = PerformanceReview::where('cs_profile_id', $validated['cs_profile_id'])
            ->where('review_year', $validated['review_year'])
            ->where('review_month', $validated['review_month'])
            ->exists();

        if ($exists) {
            return back()->withErrors([
                'review' => 'Review untuk CS ini pada bulan tersebut sudah ada.'
            ])->withInput();
        }

        // Calculate review period
        $startDate = Carbon::create($validated['review_year'], $validated['review_month'], 1);
        $endDate = $startDate->copy()->endOfMonth();

        $validated['review_period_start'] = $startDate;
        $validated['review_period_end'] = $endDate;
        $validated['admin_id'] = auth()->id();
        $validated['admin_reviewed_at'] = now();
        $validated['status'] = 'completed';

        $review = PerformanceReview::create($validated);
        $review->calculateScores();

        return redirect()->route('admin.performance.show', $review->id)
            ->with('success', 'Performance review berhasil dibuat.');
    }

    /**
     * Display the specified review
     */
    public function show($id)
    {
        $review = PerformanceReview::with([
            'csProfile.user',
            'csProfile.area',
            'koordinator',
            'admin'
        ])->findOrFail($id);

        $kpiTemplates = PerformanceKpiTemplate::active()->ordered()->get();

        return view('admin.performance.show', compact('review', 'kpiTemplates'));
    }

    /**
     * Show the form for editing the review
     */
    public function edit($id)
    {
        $review = PerformanceReview::with('csProfile.user')->findOrFail($id);
        $kpiTemplates = PerformanceKpiTemplate::active()->ordered()->get();

        return view('admin.performance.edit', compact('review', 'kpiTemplates'));
    }

    /**
     * Update the specified review
     */
    public function update(Request $request, $id)
    {
        $review = PerformanceReview::findOrFail($id);

        $validated = $request->validate([
            'punctuality_score' => 'nullable|integer|min:1|max:5',
            'work_quality_score' => 'nullable|integer|min:1|max:5',
            'attendance_score' => 'nullable|integer|min:1|max:5',
            'checkout_time_score' => 'nullable|integer|min:1|max:5',
            'admin_notes' => 'nullable|string|max:1000',
            'overall_notes' => 'nullable|string|max:1000',
            'improvement_plan' => 'nullable|string|max:1000',
            'achievement_notes' => 'nullable|string|max:1000',
        ]);

        $review->update($validated);
        $review->calculateScores();

        return redirect()->route('admin.performance.show', $review->id)
            ->with('success', 'Performance review berhasil diupdate.');
    }

    /**
     * Finalize review submitted by Koordinator
     */
    public function finalize(Request $request, $id)
    {
        $validated = $request->validate([
            'admin_notes' => 'nullable|string|max:1000',
            'overall_notes' => 'nullable|string|max:1000',
            'improvement_plan' => 'nullable|string|max:1000',
            'achievement_notes' => 'nullable|string|max:1000',
        ]);

        $review = PerformanceReview::findOrFail($id);

        if ($review->status !== 'submitted_koordinator') {
            return back()->withErrors([
                'status' => 'Review harus disubmit oleh Koordinator terlebih dahulu.'
            ]);
        }

        $review->submitByAdmin(auth()->id(), $validated['admin_notes'] ?? null);

        // Update additional notes
        $review->update([
            'overall_notes' => $validated['overall_notes'] ?? $review->overall_notes,
            'improvement_plan' => $validated['improvement_plan'] ?? $review->improvement_plan,
            'achievement_notes' => $validated['achievement_notes'] ?? $review->achievement_notes,
        ]);

        return redirect()->route('admin.performance.show', $review->id)
            ->with('success', 'Performance review telah difinalisasi.');
    }

    /**
     * Auto-generate reviews for all CS for a specific month
     */
    public function generate(Request $request)
    {
        $validated = $request->validate([
            'year' => 'required|integer|min:2020|max:2100',
            'month' => 'required|integer|min:1|max:12',
        ]);

        $csProfiles = CsProfile::all();
        $created = 0;

        foreach ($csProfiles as $csProfile) {
            $review = PerformanceReview::generateForMonth(
                $csProfile->id,
                $validated['year'],
                $validated['month']
            );

            if ($review->wasRecentlyCreated) {
                // Auto-calculate punctuality and attendance
                $review->autoCalculatePunctuality();
                $review->autoCalculateAttendance();
                $review->calculateScores();
                $created++;
            }
        }

        return back()->with('success', "Berhasil generate {$created} review template untuk {$validated['month']}/{$validated['year']}.");
    }

    /**
     * Show performance report/analytics
     */
    public function report(Request $request)
    {
        $year = $request->get('year', now()->year);
        $csProfileId = $request->get('cs_profile_id');

        $query = PerformanceReview::with('csProfile.user')
            ->where('review_year', $year)
            ->where('status', 'completed');

        if ($csProfileId) {
            $query->where('cs_profile_id', $csProfileId);
        }

        $reviews = $query->orderBy('review_month')->get();

        // Calculate statistics
        $stats = [
            'total_reviews' => $reviews->count(),
            'average_score' => $reviews->avg('average_score'),
            'highest_score' => $reviews->max('average_score'),
            'lowest_score' => $reviews->min('average_score'),
        ];

        // Group by CS for comparison
        $csComparison = $reviews->groupBy('cs_profile_id')->map(function($csReviews) {
            return [
                'cs' => $csReviews->first()->csProfile,
                'average_score' => $csReviews->avg('average_score'),
                'total_reviews' => $csReviews->count(),
                'trend' => $csReviews->pluck('average_score')->toArray(),
            ];
        });

        $csProfiles = CsProfile::with('user')->get();

        return view('admin.performance.report', compact('reviews', 'stats', 'csComparison', 'year', 'csProfiles'));
    }

    /**
     * Delete a review
     */
    public function destroy($id)
    {
        $review = PerformanceReview::findOrFail($id);
        $review->delete();

        return redirect()->route('admin.performance.index')
            ->with('success', 'Performance review berhasil dihapus.');
    }
}
