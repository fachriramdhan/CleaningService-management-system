<?php

namespace App\Http\Controllers\Koordinator\Performance;

use App\Http\Controllers\Controller;
use App\Models\PerformanceReview;
use App\Models\PerformanceKpiTemplate;
use App\Models\CsProfile;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PerformanceReviewController extends Controller
{
    /**
     * Display list of reviews (team only)
     */
    public function index(Request $request)
    {
        $query = PerformanceReview::with(['csProfile.user', 'admin'])
            ->latest('review_year')
            ->latest('review_month');

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

        return view('koordinator.performance.index', compact('reviews'));
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

            // Check if review already exists
            $exists = PerformanceReview::where('cs_profile_id', $csProfileId)
                ->where('review_year', $year)
                ->where('review_month', $month)
                ->exists();

            if ($exists) {
                return redirect()->route('koordinator.performance.index')
                    ->withErrors(['review' => 'Review untuk CS ini pada bulan tersebut sudah ada.']);
            }
        }

        return view('koordinator.performance.create', compact('csProfiles', 'kpiTemplates', 'csProfile', 'year', 'month'));
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
            'punctuality_score' => 'required|integer|min:1|max:5',
            'work_quality_score' => 'required|integer|min:1|max:5',
            'attendance_score' => 'required|integer|min:1|max:5',
            'checkout_time_score' => 'required|integer|min:1|max:5',
            'koordinator_notes' => 'nullable|string|max:1000',
            'overall_notes' => 'nullable|string|max:1000',
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
        $validated['koordinator_id'] = auth()->id();
        $validated['koordinator_reviewed_at'] = now();
        $validated['status'] = 'submitted_koordinator';

        $review = PerformanceReview::create($validated);
        $review->calculateScores();

        return redirect()->route('koordinator.performance.show', $review->id)
            ->with('success', 'Performance review berhasil dibuat dan dikirim ke Admin.');
    }

    /**
     * Display the specified review
     */
    public function show($id)
    {
        $review = PerformanceReview::with([
            'csProfile.user',
            'csProfile.area',
            'admin'
        ])->findOrFail($id);

        $kpiTemplates = PerformanceKpiTemplate::active()->ordered()->get();

        return view('koordinator.performance.show', compact('review', 'kpiTemplates'));
    }

    /**
     * Show the form for editing the review (only if not yet finalized)
     */
    public function edit($id)
    {
        $review = PerformanceReview::with('csProfile.user')->findOrFail($id);

        // Can only edit if not yet completed
        if ($review->status === 'completed') {
            return redirect()->route('koordinator.performance.show', $id)
                ->withErrors(['status' => 'Review sudah difinalisasi oleh Admin, tidak bisa diedit.']);
        }

        $kpiTemplates = PerformanceKpiTemplate::active()->ordered()->get();

        return view('koordinator.performance.edit', compact('review', 'kpiTemplates'));
    }

    /**
     * Update the specified review
     */
    public function update(Request $request, $id)
    {
        $review = PerformanceReview::findOrFail($id);

        // Can only update if not yet completed
        if ($review->status === 'completed') {
            return back()->withErrors([
                'status' => 'Review sudah difinalisasi oleh Admin, tidak bisa diupdate.'
            ]);
        }

        $validated = $request->validate([
            'punctuality_score' => 'required|integer|min:1|max:5',
            'work_quality_score' => 'required|integer|min:1|max:5',
            'attendance_score' => 'required|integer|min:1|max:5',
            'checkout_time_score' => 'required|integer|min:1|max:5',
            'koordinator_notes' => 'nullable|string|max:1000',
            'overall_notes' => 'nullable|string|max:1000',
        ]);

        $review->update($validated);
        $review->calculateScores();

        return redirect()->route('koordinator.performance.show', $review->id)
            ->with('success', 'Performance review berhasil diupdate.');
    }

    /**
     * Auto-calculate scores from attendance data
     */
    public function autoCalculate($id)
    {
        $review = PerformanceReview::findOrFail($id);

        // Can only auto-calculate if not yet completed
        if ($review->status === 'completed') {
            return back()->withErrors([
                'status' => 'Review sudah difinalisasi, tidak bisa dihitung ulang.'
            ]);
        }

        // Auto-calculate punctuality and attendance
        $review->autoCalculatePunctuality();
        $review->autoCalculateAttendance();
        $review->calculateScores();

        return back()->with('success', 'Score berhasil dihitung otomatis dari data absensi.');
    }

    /**
     * Show team performance summary
     */
    public function summary(Request $request)
    {
        $year = $request->get('year', now()->year);
        $month = $request->get('month');

        $query = PerformanceReview::with('csProfile.user')
            ->where('review_year', $year)
            ->whereIn('status', ['submitted_koordinator', 'completed']);

        if ($month) {
            $query->where('review_month', $month);
        }

        $reviews = $query->get();

        // Calculate statistics
        $stats = [
            'total_reviews' => $reviews->count(),
            'average_score' => $reviews->avg('average_score'),
            'completed' => $reviews->where('status', 'completed')->count(),
            'pending_admin' => $reviews->where('status', 'submitted_koordinator')->count(),
        ];

        return view('koordinator.performance.summary', compact('reviews', 'stats', 'year', 'month'));
    }
}
