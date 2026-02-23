<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\LeaveRequest;
use App\Models\LeaveBalanceHistory;
use App\Models\CsProfile;

class LeaveQuota extends Model
{
    use HasFactory;

    protected $fillable = [
        'cs_profile_id',
        'year',
        'annual_quota',
        'annual_used',
        'sick_used',
        'emergency_used',
        'unpaid_used',
    ];

    protected $casts = [
        'year' => 'integer',
        'annual_quota' => 'integer',
        'annual_used' => 'integer',
        'sick_used' => 'integer',
        'emergency_used' => 'integer',
        'unpaid_used' => 'integer',
    ];

    /**
     * Relationships
     */
    public function csProfile()
    {
        return $this->belongsTo(CsProfile::class);
    }

    public function leaveRequests()
    {
        return $this->hasMany(LeaveRequest::class, 'cs_profile_id', 'cs_profile_id')
            ->whereYear('start_date', $this->year);
    }

    public function balanceHistory()
    {
        return $this->hasMany(LeaveBalanceHistory::class);
    }

    /**
     * Helper Methods
     */

    // Sisa cuti tahunan
    public function getRemainingAnnualAttribute()
    {
        return $this->annual_quota - $this->annual_used;
    }

    // Apakah cuti tahunan masih tersedia
    public function hasAnnualLeaveAvailable($days = 1)
    {
        return $this->remainingAnnual >= $days;
    }

    // Get or create quota untuk tahun tertentu
    public static function getOrCreate($csProfileId, $year = null)
    {
        $year = $year ?? now()->year;

        return self::firstOrCreate(
            [
                'cs_profile_id' => $csProfileId,
                'year' => $year,
            ],
            [
                'annual_quota' => 6, // Default 6 hari per tahun
                'annual_used' => 0,
                'sick_used' => 0,
                'emergency_used' => 0,
                'unpaid_used' => 0,
            ]
        );
    }

    // Use leave (kurangi saldo)
    public function useLeave($type, $days, $leaveRequestId = null, $userId = null)
    {
        $column = $type . '_used';
        $balanceBefore = $this->$column;

        $this->increment($column, $days);
        $this->refresh();

        // Create history record
        LeaveBalanceHistory::create([
            'leave_quota_id' => $this->id,
            'leave_request_id' => $leaveRequestId,
            'leave_type' => $type,
            'transaction_type' => 'used',
            'amount' => $days,
            'balance_before' => $balanceBefore,
            'balance_after' => $this->$column,
            'notes' => "Cuti {$type} digunakan sebanyak {$days} hari",
            'created_by' => $userId ?? auth()->id(),
        ]);

        return $this;
    }

    // Refund leave (kembalikan saldo)
    public function refundLeave($type, $days, $leaveRequestId = null, $userId = null)
    {
        $column = $type . '_used';
        $balanceBefore = $this->$column;

        $this->decrement($column, $days);
        $this->refresh();

        // Create history record
        LeaveBalanceHistory::create([
            'leave_quota_id' => $this->id,
            'leave_request_id' => $leaveRequestId,
            'leave_type' => $type,
            'transaction_type' => 'refund',
            'amount' => $days,
            'balance_before' => $balanceBefore,
            'balance_after' => $this->$column,
            'notes' => "Cuti {$type} dikembalikan sebanyak {$days} hari",
            'created_by' => $userId ?? auth()->id(),
        ]);

        return $this;
    }

    // Reset cuti tahunan (dipanggil setiap awal tahun)
    public static function resetAnnualLeaveForYear($year, $userId = null)
    {
        $quotas = self::where('year', $year)->get();

        foreach ($quotas as $quota) {
            $quota->update([
                'annual_quota' => 6,
                'annual_used' => 0,
            ]);

            LeaveBalanceHistory::create([
                'leave_quota_id' => $quota->id,
                'leave_request_id' => null,
                'leave_type' => 'annual',
                'transaction_type' => 'reset',
                'amount' => 6,
                'balance_before' => 0,
                'balance_after' => 6,
                'notes' => "Reset cuti tahunan untuk tahun {$year}",
                'created_by' => $userId ?? 1, // System user
            ]);
        }

        return $quotas->count();
    }
}
