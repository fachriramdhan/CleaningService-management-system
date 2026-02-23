<?php

namespace App\Http\Controllers\Admin\Leave;

use App\Http\Controllers\Controller;
use App\Models\LeaveRequest;
use App\Models\LeaveQuota;
use App\Models\CsProfile;
use Illuminate\Http\Request;

class LeaveRequestController extends Controller
{
    /**
     * Display a listing of leave requests
     */
    public function index(Request $request)
    {
        $query = LeaveRequest::with(['csProfile.user', 'koordinator', 'admin'])
            ->latest();

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by leave type
        if ($request->filled('leave_type')) {
            $query->where('leave_type', $request->leave_type);
        }

        // Filter by CS
        if ($request->filled('cs_profile_id')) {
            $query->where('cs_profile_id', $request->cs_profile_id);
        }

        // Filter by year
        if ($request->filled('year')) {
            $query->whereYear('start_date', $request->year);
        }

        $leaveRequests = $query->paginate(15);
        $csProfiles = CsProfile::with('user')->get();

        return view('admin.leave.index', compact('leaveRequests', 'csProfiles'));
    }

    /**
     * Show the form for creating a new leave request (Admin can create on behalf of CS)
     */
    public function create()
    {
        $csProfiles = CsProfile::with('user')->get();
        return view('admin.leave.create', compact('csProfiles'));
    }

    /**
     * Store a newly created leave request
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'cs_profile_id' => 'required|exists:cs_profiles,id',
            'leave_type' => 'required|in:annual,sick,emergency,unpaid',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'required|string|max:1000',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        // Calculate total days
        $startDate = \Carbon\Carbon::parse($validated['start_date']);
        $endDate = \Carbon\Carbon::parse($validated['end_date']);
        $validated['total_days'] = LeaveRequest::calculateDays($startDate, $endDate);

        // Check annual leave balance
        if ($validated['leave_type'] === 'annual') {
            $quota = LeaveQuota::getOrCreate($validated['cs_profile_id'], $startDate->year);

            if (!$quota->hasAnnualLeaveAvailable($validated['total_days'])) {
                return back()->withErrors(['leave_type' => 'Saldo cuti tahunan tidak mencukupi.']);
            }
        }

        // Handle file upload
        if ($request->hasFile('attachment')) {
            $validated['attachment'] = $request->file('attachment')->store('leave-attachments', 'public');
        }

        // Create leave request
        $leaveRequest = LeaveRequest::create($validated);

        // Check for overlaps
        if ($leaveRequest->hasOverlap()) {
            $leaveRequest->delete();
            return back()->withErrors(['dates' => 'Tanggal cuti bertabrakan dengan cuti yang sudah disetujui.']);
        }

        return redirect()->route('admin.leave.index')
            ->with('success', 'Pengajuan cuti berhasil dibuat.');
    }

    /**
     * Display the specified leave request
     */
    public function show($id)
    {
        $leaveRequest = LeaveRequest::with([
            'csProfile.user',
            'csProfile.area',
            'koordinator',
            'admin'
        ])->findOrFail($id);

        // Get leave balance
        $quota = LeaveQuota::getOrCreate(
            $leaveRequest->cs_profile_id,
            $leaveRequest->start_date->year
        );

        return view('admin.leave.show', compact('leaveRequest', 'quota'));
    }

    /**
     * Show pending leave requests for approval
     */
    public function approval()
    {
        // Get leave requests that have been approved by Koordinator
        $pendingLeaves = LeaveRequest::with(['csProfile.user', 'koordinator'])
            ->where('status', 'approved_koordinator')
            ->latest()
            ->paginate(15);

        return view('admin.leave.approval', compact('pendingLeaves'));
    }

    /**
     * Approve leave request (Admin final approval)
     */
    public function approve(Request $request, $id)
    {
        $validated = $request->validate([
            'notes' => 'nullable|string|max:500',
        ]);

        $leaveRequest = LeaveRequest::findOrFail($id);

        // Check if Koordinator has approved
        if ($leaveRequest->status !== 'approved_koordinator') {
            return back()->withErrors(['status' => 'Cuti harus disetujui Koordinator terlebih dahulu.']);
        }

        // Approve and deduct balance
        $leaveRequest->approveByAdmin(auth()->id(), $validated['notes'] ?? null);

        return redirect()->route('admin.leave.approval')
            ->with('success', 'Pengajuan cuti telah disetujui. Saldo cuti telah dikurangi.');
    }

    /**
     * Reject leave request
     */
    public function reject(Request $request, $id)
    {
        $validated = $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);

        $leaveRequest = LeaveRequest::findOrFail($id);

        $leaveRequest->rejectByAdmin(auth()->id(), $validated['rejection_reason']);

        return redirect()->route('admin.leave.approval')
            ->with('success', 'Pengajuan cuti telah ditolak.');
    }

    /**
     * Cancel an approved leave request
     */
    public function cancel($id)
    {
        $leaveRequest = LeaveRequest::findOrFail($id);

        if ($leaveRequest->status !== 'approved_admin') {
            return back()->withErrors(['status' => 'Hanya cuti yang sudah disetujui yang bisa dibatalkan.']);
        }

        // Check if leave has started
        if ($leaveRequest->start_date->isPast()) {
            return back()->withErrors(['dates' => 'Tidak bisa membatalkan cuti yang sudah dimulai.']);
        }

        $leaveRequest->cancel(auth()->id());

        return back()->with('success', 'Cuti berhasil dibatalkan. Saldo cuti telah dikembalikan.');
    }

    /**
     * Show leave balance history
     */
    public function history(Request $request)
    {
        $year = $request->get('year', now()->year);

        $csProfiles = CsProfile::with(['user', 'leaveQuotas' => function($q) use ($year) {
            $q->where('year', $year);
        }])->get();

        return view('admin.leave.history', compact('csProfiles', 'year'));
    }

    /**
     * Show CS leave balance detail
     */
    public function balanceDetail($csProfileId)
    {
        $csProfile = CsProfile::with('user')->findOrFail($csProfileId);
        $year = request()->get('year', now()->year);

        $quota = LeaveQuota::getOrCreate($csProfileId, $year);
        $history = $quota->balanceHistory()->with('leaveRequest', 'creator')->latest()->paginate(20);
        $leaveRequests = LeaveRequest::where('cs_profile_id', $csProfileId)
            ->whereYear('start_date', $year)
            ->latest()
            ->get();

        return view('admin.leave.balance-detail', compact('csProfile', 'quota', 'history', 'leaveRequests', 'year'));
    }
}
