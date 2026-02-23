<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class LeaveRequest extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'cs_profile_id',
        'leave_type',
        'start_date',
        'end_date',
        'total_days',
        'reason',
        'attachment',
        'status',
        'koordinator_id',
        'koordinator_approved_at',
        'koordinator_notes',
        'admin_id',
        'admin_approved_at',
        'admin_notes',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'total_days' => 'integer',
        'koordinator_approved_at' => 'datetime',
        'admin_approved_at' => 'datetime',
    ];

    protected $appends = ['status_label', 'leave_type_label'];

    /**
     * Relationships
     */
    public function csProfile()
    {
        return $this->belongsTo(CsProfile::class);
    }

    public function koordinator()
    {
        return $this->belongsTo(User::class, 'koordinator_id');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    /**
     * Attributes
     */
    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'pending' => 'Menunggu Approval Koordinator',
            'approved_koordinator' => 'Disetujui Koordinator - Menunggu Admin',
            'approved_admin' => 'Disetujui',
            'rejected_koordinator' => 'Ditolak oleh Koordinator',
            'rejected_admin' => 'Ditolak oleh Admin',
            default => 'Unknown',
        };
    }

    public function getLeaveTypeLabelAttribute()
    {
        return match($this->leave_type) {
            'annual' => 'Cuti Tahunan',
            'sick' => 'Cuti Sakit',
            'emergency' => 'Cuti Darurat',
            'unpaid' => 'Cuti Tanpa Gaji',
            default => 'Unknown',
        };
    }

    /**
     * Scopes
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApprovedKoordinator($query)
    {
        return $query->where('status', 'approved_koordinator');
    }

    public function scopeFullyApproved($query)
    {
        return $query->where('status', 'approved_admin');
    }

    public function scopeRejected($query)
    {
        return $query->whereIn('status', ['rejected_koordinator', 'rejected_admin']);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('leave_type', $type);
    }

    public function scopeByYear($query, $year)
    {
        return $query->whereYear('start_date', $year);
    }

    /**
     * Helper Methods
     */

    // Calculate total days automatically
    public static function calculateDays(Carbon $startDate, Carbon $endDate)
    {
        return $startDate->diffInDays($endDate) + 1; // +1 karena inclusive
    }

    // Check if leave request overlaps with existing approved leaves
    public function hasOverlap()
    {
        return self::where('cs_profile_id', $this->cs_profile_id)
            ->where('id', '!=', $this->id)
            ->whereIn('status', ['approved_koordinator', 'approved_admin'])
            ->where(function($query) {
                $query->whereBetween('start_date', [$this->start_date, $this->end_date])
                    ->orWhereBetween('end_date', [$this->start_date, $this->end_date])
                    ->orWhere(function($q) {
                        $q->where('start_date', '<=', $this->start_date)
                          ->where('end_date', '>=', $this->end_date);
                    });
            })
            ->exists();
    }

    // Approve by Koordinator
    public function approveByKoordinator($koordinatorId, $notes = null)
    {
        $this->update([
            'status' => 'approved_koordinator',
            'koordinator_id' => $koordinatorId,
            'koordinator_approved_at' => now(),
            'koordinator_notes' => $notes,
        ]);

        return $this;
    }

    // Approve by Admin (final approval)
    public function approveByAdmin($adminId, $notes = null)
    {
        $this->update([
            'status' => 'approved_admin',
            'admin_id' => $adminId,
            'admin_approved_at' => now(),
            'admin_notes' => $notes,
        ]);

        // Deduct leave balance
        if ($this->leave_type === 'annual') {
            $quota = LeaveQuota::getOrCreate($this->cs_profile_id, $this->start_date->year);
            $quota->useLeave('annual', $this->total_days, $this->id, $adminId);
        } else {
            $quota = LeaveQuota::getOrCreate($this->cs_profile_id, $this->start_date->year);
            $quota->useLeave($this->leave_type, $this->total_days, $this->id, $adminId);
        }

        return $this;
    }

    // Reject by Koordinator
    public function rejectByKoordinator($koordinatorId, $reason)
    {
        $this->update([
            'status' => 'rejected_koordinator',
            'koordinator_id' => $koordinatorId,
            'koordinator_approved_at' => now(),
            'koordinator_notes' => $reason,
        ]);

        return $this;
    }

    // Reject by Admin
    public function rejectByAdmin($adminId, $reason)
    {
        $this->update([
            'status' => 'rejected_admin',
            'admin_id' => $adminId,
            'admin_approved_at' => now(),
            'admin_notes' => $reason,
        ]);

        return $this;
    }

    // Cancel approved leave (refund balance)
    public function cancel($userId = null)
    {
        if ($this->status === 'approved_admin') {
            $quota = LeaveQuota::getOrCreate($this->cs_profile_id, $this->start_date->year);
            $quota->refundLeave($this->leave_type, $this->total_days, $this->id, $userId);
        }

        $this->delete();

        return true;
    }
}
