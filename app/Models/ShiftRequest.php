<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ShiftRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'cs_profile_id',
        'request_year',
        'request_month',
        'requested_date',
        'reason',
        'status',
        'approved_by',
        'approved_at',
        'rejection_reason',
        'request_submitted_at',
    ];

    protected $casts = [
        'request_year' => 'integer',
        'request_month' => 'integer',
        'requested_date' => 'date',
        'approved_at' => 'datetime',
        'request_submitted_at' => 'datetime',
    ];

    protected $appends = ['status_label'];

    /**
     * Relationships
     */
    public function csProfile()
    {
        return $this->belongsTo(CsProfile::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Attributes
     */
    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'pending' => 'Menunggu Persetujuan',
            'approved' => 'Disetujui',
            'rejected' => 'Ditolak',
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

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    public function scopeByMonth($query, $year, $month)
    {
        return $query->where('request_year', $year)
                    ->where('request_month', $month);
    }

    public function scopeInRequestPeriod($query)
    {
        // Request period: 23-24 of current month
        $today = now();
        $day = $today->day;

        if ($day >= 23 && $day <= 24) {
            return $query->whereDate('request_submitted_at', '>=', $today->startOfDay())
                        ->whereDate('request_submitted_at', '<=', $today->endOfDay());
        }

        return $query->whereRaw('1 = 0'); // No results if not in request period
    }

    /**
     * Helper Methods
     */

    // Check if current date is in request period (23-24)
    public static function isRequestPeriod()
    {
        $day = now()->day;
        return $day >= 23 && $day <= 24;
    }

    // Check if CS can submit request
    public function canSubmit()
    {
        // Only can submit during 23-24
        if (!self::isRequestPeriod()) {
            return false;
        }

        // Check if already submitted for this month
        $exists = self::where('cs_profile_id', $this->cs_profile_id)
            ->where('request_year', $this->request_year)
            ->where('request_month', $this->request_month)
            ->where('requested_date', $this->requested_date)
            ->whereIn('status', ['pending', 'approved'])
            ->exists();

        return !$exists;
    }

    // Approve request
    public function approve($userId)
    {
        $this->update([
            'status' => 'approved',
            'approved_by' => $userId,
            'approved_at' => now(),
            'rejection_reason' => null,
        ]);

        // Apply to shift schedule
        ShiftSchedule::applyShiftRequest(
            $this->cs_profile_id,
            $this->requested_date,
            $userId
        );

        return $this;
    }

    // Reject request
    public function reject($userId, $reason)
    {
        $this->update([
            'status' => 'rejected',
            'approved_by' => $userId,
            'approved_at' => now(),
            'rejection_reason' => $reason,
        ]);

        return $this;
    }

    // Auto-reject expired requests (after schedule is published)
    public static function autoRejectExpired()
    {
        $expiredRequests = self::pending()
            ->where(function($query) {
                $query->where('request_submitted_at', '<', now()->subDays(7));
            })
            ->get();

        foreach ($expiredRequests as $request) {
            $request->reject(1, 'Otomatis ditolak karena jadwal sudah dipublish');
        }

        return $expiredRequests->count();
    }

    // Get pending requests for current month
    public static function getPendingForCurrentMonth()
    {
        $nextMonth = now()->addMonth();

        return self::pending()
            ->where('request_year', $nextMonth->year)
            ->where('request_month', $nextMonth->month)
            ->get();
    }
}
