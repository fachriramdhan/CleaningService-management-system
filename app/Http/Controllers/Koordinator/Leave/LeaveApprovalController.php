<?php

namespace App\Http\Controllers\Koordinator\Leave;

use App\Http\Controllers\Controller;
use App\Models\LeaveRequest;
use App\Models\LeaveQuota;
use Illuminate\Http\Request;

class LeaveApprovalController extends Controller
{
    /**
     * Display pending leave requests for Koordinator approval
     */
    public function index()
    {
        $pendingLeaves = LeaveRequest::with(['csProfile.user', 'csProfile.area'])
            ->where('status', 'pending')
            ->latest()
            ->paginate(15);

        return view('koordinator.leave.approval', compact('pendingLeaves'));
    }

    /**
     * Show detail of leave request for approval
     */
    public function show($id)
    {
        $leaveRequest = LeaveRequest::with(['csProfile.user', 'csProfile.area'])
            ->findOrFail($id);

        // Get CS leave balance
        $quota = LeaveQuota::getOrCreate(
            $leaveRequest->cs_profile_id,
            $leaveRequest->start_date->year
        );

        // Get CS's other leave requests this year
        $otherLeaves = LeaveRequest::where('cs_profile_id', $leaveRequest->cs_profile_id)
            ->where('id', '!=', $leaveRequest->id)
            ->whereYear('start_date', $leaveRequest->start_date->year)
            ->whereIn('status', ['approved_koordinator', 'approved_admin'])
            ->get();

        return view('koordinator.leave.show', compact('leaveRequest', 'quota', 'otherLeaves'));
    }

    /**
     * Approve leave request (Koordinator level)
     */
    public function approve(Request $request, $id)
    {
        $validated = $request->validate([
            'notes' => 'nullable|string|max:500',
        ]);

        $leaveRequest = LeaveRequest::findOrFail($id);

        // Check if still pending
        if ($leaveRequest->status !== 'pending') {
            return back()->withErrors([
                'status' => 'Pengajuan cuti ini sudah diproses.'
            ]);
        }

        // Check balance for annual leave
        if ($leaveRequest->leave_type === 'annual') {
            $quota = LeaveQuota::getOrCreate(
                $leaveRequest->cs_profile_id,
                $leaveRequest->start_date->year
            );

            if (!$quota->hasAnnualLeaveAvailable($leaveRequest->total_days)) {
                return back()->withErrors([
                    'balance' => 'Saldo cuti tahunan CS tidak mencukupi.'
                ]);
            }
        }

        // Approve by Koordinator (forwards to Admin)
        $leaveRequest->approveByKoordinator(auth()->id(), $validated['notes'] ?? null);

        return redirect()->route('koordinator.leave.approval')
            ->with('success', 'Pengajuan cuti telah disetujui. Menunggu persetujuan Admin.');
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

        // Check if still pending
        if ($leaveRequest->status !== 'pending') {
            return back()->withErrors([
                'status' => 'Pengajuan cuti ini sudah diproses.'
            ]);
        }

        $leaveRequest->rejectByKoordinator(auth()->id(), $validated['rejection_reason']);

        return redirect()->route('koordinator.leave.approval')
            ->with('success', 'Pengajuan cuti telah ditolak.');
    }

    /**
     * Show history of leave approvals
     */
    public function history(Request $request)
    {
        $query = LeaveRequest::with(['csProfile.user'])
            ->whereNotNull('koordinator_id')
            ->latest('koordinator_approved_at');

        // Filter by status
        if ($request->filled('status')) {
            if ($request->status === 'approved') {
                $query->whereIn('status', ['approved_koordinator', 'approved_admin']);
            } else if ($request->status === 'rejected') {
                $query->where('status', 'rejected_koordinator');
            }
        }

        $leaveHistory = $query->paginate(20);

        return view('koordinator.leave.history', compact('leaveHistory'));
    }

    /**
     * Show team leave summary
     */
    public function summary()
    {
        $year = request()->get('year', now()->year);

        // Get all CS with their leave quotas
        $teamSummary = \App\Models\CsProfile::with([
            'user',
            'leaveQuotas' => function($q) use ($year) {
                $q->where('year', $year);
            },
            'leaveRequests' => function($q) use ($year) {
                $q->whereYear('start_date', $year)
                  ->whereIn('status', ['approved_koordinator', 'approved_admin']);
            }
        ])->get();

        return view('koordinator.leave.summary', compact('teamSummary', 'year'));
    }
}
