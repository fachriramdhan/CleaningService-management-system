<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveBalanceHistory extends Model
{
    use HasFactory;

    protected $table = 'leave_balance_history';

    protected $fillable = [
        'leave_quota_id',
        'leave_request_id',
        'leave_type',
        'transaction_type',
        'amount',
        'balance_before',
        'balance_after',
        'notes',
        'created_by',
    ];

    protected $casts = [
        'amount' => 'integer',
        'balance_before' => 'integer',
        'balance_after' => 'integer',
    ];

    /**
     * Relationships
     */
    public function leaveQuota()
    {
        return $this->belongsTo(LeaveQuota::class);
    }

    public function leaveRequest()
    {
        return $this->belongsTo(LeaveRequest::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Scopes
     */
    public function scopeByType($query, $type)
    {
        return $query->where('leave_type', $type);
    }

    public function scopeByTransaction($query, $transactionType)
    {
        return $query->where('transaction_type', $transactionType);
    }

    public function scopeRecent($query, $days = 30)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }
}
