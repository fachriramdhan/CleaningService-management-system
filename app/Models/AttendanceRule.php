<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class AttendanceRule extends Model
{
    use HasFactory;

    protected $fillable = [
        'rule_name',
        'description',
        'checkin_start',
        'checkin_end',
        'checkin_on_time',
        'checkout_max',
        'checkout_min',
        'late_tolerance_minutes',
        'early_checkout_penalty',
        'is_active',
    ];

    protected $casts = [
        'late_tolerance_minutes' => 'integer',
        'early_checkout_penalty' => 'integer',
        'is_active' => 'boolean',
    ];

    /**
     * Scopes
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Helper Methods
     */

    // Get active rule
    public static function getActiveRule()
    {
        return self::active()->first();
    }

    // Check if check-in time is on time
    public function isOnTime($checkinTime)
    {
        $time = Carbon::parse($checkinTime);
        $onTimeLimit = Carbon::parse($this->checkin_on_time);

        return $time->lte($onTimeLimit);
    }

    // Check if check-in time is late
    public function isLate($checkinTime)
    {
        return !$this->isOnTime($checkinTime);
    }

    // Get late minutes
    public function getLateMinutes($checkinTime)
    {
        $time = Carbon::parse($checkinTime);
        $onTimeLimit = Carbon::parse($this->checkin_on_time);

        if ($time->lte($onTimeLimit)) {
            return 0;
        }

        return $time->diffInMinutes($onTimeLimit);
    }

    // Check if check-in is within allowed window
    public function isWithinCheckinWindow($checkinTime)
    {
        $time = Carbon::parse($checkinTime);
        $start = Carbon::parse($this->checkin_start);
        $end = Carbon::parse($this->checkin_end);

        return $time->between($start, $end);
    }

    // Check if check-out is on time (before max time)
    public function isCheckoutOnTime($checkoutTime)
    {
        $time = Carbon::parse($checkoutTime);
        $maxTime = Carbon::parse($this->checkout_max);

        return $time->lte($maxTime);
    }

    // Check if check-out is late (after max time)
    public function isCheckoutLate($checkoutTime)
    {
        return !$this->isCheckoutOnTime($checkoutTime);
    }

    // Get late checkout minutes
    public function getCheckoutLateMinutes($checkoutTime)
    {
        $time = Carbon::parse($checkoutTime);
        $maxTime = Carbon::parse($this->checkout_max);

        if ($time->lte($maxTime)) {
            return 0;
        }

        return $time->diffInMinutes($maxTime);
    }

    // Calculate punctuality score (1-5) based on check-in time
    public function calculatePunctualityScore($checkinTime)
    {
        if ($this->isOnTime($checkinTime)) {
            return 5; // Tepat waktu
        }

        $lateMinutes = $this->getLateMinutes($checkinTime);

        return match(true) {
            $lateMinutes <= 15 => 4,  // Telat <= 15 menit
            $lateMinutes <= 30 => 3,  // Telat <= 30 menit
            $lateMinutes <= 60 => 2,  // Telat <= 1 jam
            default => 1,              // Telat > 1 jam
        };
    }

    // Calculate checkout score (1-5) based on check-out time
    public function calculateCheckoutScore($checkoutTime)
    {
        if ($this->isCheckoutOnTime($checkoutTime)) {
            return 5; // Pulang tepat waktu
        }

        $lateMinutes = $this->getCheckoutLateMinutes($checkoutTime);

        return match(true) {
            $lateMinutes <= 15 => 4,  // Pulang telat <= 15 menit
            $lateMinutes <= 30 => 3,  // Pulang telat <= 30 menit
            $lateMinutes <= 60 => 2,  // Pulang telat <= 1 jam
            default => 1,              // Pulang telat > 1 jam
        };
    }
}
