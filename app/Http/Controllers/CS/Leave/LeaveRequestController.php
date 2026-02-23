<?php

namespace App\Http\Controllers\CS\Leave;

use App\Http\Controllers\Controller;
use App\Models\LeaveRequest;
use App\Models\LeaveQuota;
use Illuminate\Http\Request;

class LeaveRequestController extends Controller
{
    /**
     * Display CS's own leave requests
     */
    public function index()
    {
        $csProfile = auth()->user()->csProfile;

        $leaveRequests = LeaveRequest::where('cs_profile_id', $csProfile->id)
            ->latest()
            ->paginate(10);

        // Get current year quota
        $quota = LeaveQuota::getOrCreate($csProfile->id, now()->year);

        return view('cs.leave.index', compact('leaveRequests', 'quota'));
    }

    /**
     * Show the form for creating a new leave request
     */
    public function create()
    {
        $csProfile = auth()->user()->csProfile;
        $quota = LeaveQuota::getOrCreate($csProfile->id, now()->year);

        return view('cs.leave.create', compact('quota'));
    }

    /**
     * Store a newly created leave request
     */
    public function store(Request $request)
    {
        $csProfile = auth()->user()->csProfile;

        $validated = $request->validate([
            'leave_type' => 'required|in:annual,sick,emergency,unpaid',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'required|string|max:1000',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        // Calculate total days
        $startDate = \Carbon\Carbon::parse($validated['start_date']);
        $endDate = \Carbon\Carbon::parse($validated['end_date']);
        $totalDays = LeaveRequest::calculateDays($startDate, $endDate);

        // Check annual leave balance
        if ($validated['leave_type'] === 'annual') {
            $quota = LeaveQuota::getOrCreate($csProfile->id, $startDate->year);

            if (!$quota->hasAnnualLeaveAvailable($totalDays)) {
                return back()->withErrors([
                    'leave_type' => "Saldo cuti tahunan tidak mencukupi. Sisa: {$quota->remainingAnnual} hari."
                ])->withInput();
            }
        }

        // Handle file upload
        if ($request->hasFile('attachment')) {
            $validated['attachment'] = $request->file('attachment')->store('leave-attachments', 'public');
        }

        // Create leave request
        $validated['cs_profile_id'] = $csProfile->id;
        $validated['total_days'] = $totalDays;
        $validated['status'] = 'pending';

        $leaveRequest = LeaveRequest::create($validated);

        // Check for overlaps
        if ($leaveRequest->hasOverlap()) {
            $leaveRequest->delete();
            return back()->withErrors([
                'dates' => 'Tanggal cuti bertabrakan dengan cuti yang sudah disetujui.'
            ])->withInput();
        }

        return redirect()->route('cs.leave.index')
            ->with('success', 'Pengajuan cuti berhasil dikirim. Menunggu persetujuan Koordinator.');
    }

    /**
     * Display the specified leave request
     */
    public function show($id)
    {
        $csProfile = auth()->user()->csProfile;

        $leaveRequest = LeaveRequest::with(['koordinator', 'admin'])
            ->where('cs_profile_id', $csProfile->id)
            ->findOrFail($id);

        $quota = LeaveQuota::getOrCreate($csProfile->id, $leaveRequest->start_date->year);

        return view('cs.leave.show', compact('leaveRequest', 'quota'));
    }

    /**
     * Show leave balance and history
     */
    public function balance()
    {
        $csProfile = auth()->user()->csProfile;
        $year = request()->get('year', now()->year);

        $quota = LeaveQuota::getOrCreate($csProfile->id, $year);
        $history = $quota->balanceHistory()->with('leaveRequest')->latest()->paginate(15);
        $leaveRequests = LeaveRequest::where('cs_profile_id', $csProfile->id)
            ->whereYear('start_date', $year)
            ->latest()
            ->get();

        return view('cs.leave.balance', compact('quota', 'history', 'leaveRequests', 'year'));
    }

    /**
     * Cancel a pending leave request
     */
    public function cancel($id)
    {
        $csProfile = auth()->user()->csProfile;

        $leaveRequest = LeaveRequest::where('cs_profile_id', $csProfile->id)
            ->findOrFail($id);

        // Can only cancel if still pending
        if ($leaveRequest->status !== 'pending') {
            return back()->withErrors([
                'status' => 'Hanya pengajuan cuti yang masih menunggu yang bisa dibatalkan.'
            ]);
        }

        $leaveRequest->delete();

        return redirect()->route('cs.leave.index')
            ->with('success', 'Pengajuan cuti berhasil dibatalkan.');
    }
}
