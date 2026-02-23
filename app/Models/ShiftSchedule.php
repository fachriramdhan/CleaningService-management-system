<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class ShiftSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'cs_profile_id',
        'schedule_year',
        'schedule_month',
        'schedule_date',
        'shift_type',
        'shift_start',
        'shift_end',
        'status',
        'notes',
        'created_by',
        'published_at',
    ];

    protected $casts = [
        'schedule_year' => 'integer',
        'schedule_month' => 'integer',
        'schedule_date' => 'date',
        'shift_start' => 'datetime:H:i',
        'shift_end' => 'datetime:H:i',
        'published_at' => 'datetime',
    ];

    protected $appends = ['shift_type_label', 'status_label'];

    /**
     * Relationships
     */
    public function csProfile()
    {
        return $this->belongsTo(CsProfile::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Attributes
     */
    public function getShiftTypeLabelAttribute()
    {
        return $this->shift_type === 'work' ? 'Kerja' : 'Libur';
    }

    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'scheduled' => 'Terjadwal',
            'worked' => 'Sudah Kerja',
            'absent' => 'Tidak Hadir',
            'leave' => 'Cuti',
            default => 'Unknown',
        };
    }

    /**
     * Scopes
     */
    public function scopeByMonth($query, $year, $month)
    {
        return $query->where('schedule_year', $year)
                    ->where('schedule_month', $month);
    }

    public function scopeWorkDays($query)
    {
        return $query->where('shift_type', 'work');
    }

    public function scopeOffDays($query)
    {
        return $query->where('shift_type', 'off');
    }

    public function scopePublished($query)
    {
        return $query->whereNotNull('published_at');
    }

    public function scopeUnpublished($query)
    {
        return $query->whereNull('published_at');
    }

    /**
     * Helper Methods
     */

    // Generate schedule for entire month with 6/7 pattern
    public static function generateMonthlySchedule($csProfileId, $year, $month, $dayOffPattern, $userId)
    {
        $startDate = Carbon::create($year, $month, 1);
        $endDate = $startDate->copy()->endOfMonth();
        $period = CarbonPeriod::create($startDate, $endDate);

        $schedules = [];
        $dayCounter = 0;

        foreach ($period as $date) {
            $isOffDay = ($dayCounter % 7) === $dayOffPattern; // 0-6 untuk pola hari libur

            $schedules[] = [
                'cs_profile_id' => $csProfileId,
                'schedule_year' => $year,
                'schedule_month' => $month,
                'schedule_date' => $date->format('Y-m-d'),
                'shift_type' => $isOffDay ? 'off' : 'work',
                'shift_start' => '08:00:00',
                'shift_end' => '17:00:00',
                'status' => 'scheduled',
                'created_by' => $userId,
                'published_at' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            $dayCounter++;
        }

        // Bulk insert
        self::insert($schedules);

        return count($schedules);
    }

    // Publish schedule (send to CS on 25th)
    public static function publishSchedule($year, $month)
    {
        return self::byMonth($year, $month)
            ->unpublished()
            ->update(['published_at' => now()]);
    }

    // Get CS work days count for a month
    public static function getWorkDaysCount($csProfileId, $year, $month)
    {
        return self::where('cs_profile_id', $csProfileId)
            ->byMonth($year, $month)
            ->workDays()
            ->count();
    }

    // Get CS off days count for a month
    public static function getOffDaysCount($csProfileId, $year, $month)
    {
        return self::where('cs_profile_id', $csProfileId)
            ->byMonth($year, $month)
            ->offDays()
            ->count();
    }

    // Mark as worked (after CS actually works on that day)
    public function markAsWorked()
    {
        $this->update(['status' => 'worked']);
        return $this;
    }

    // Mark as absent
    public function markAsAbsent()
    {
        $this->update(['status' => 'absent']);
        return $this;
    }

    // Mark as leave
    public function markAsLeave()
    {
        $this->update(['status' => 'leave']);
        return $this;
    }

    // Check if schedule is editable (before 25th of previous month)
    public function isEditable()
    {
        $lockDate = Carbon::create($this->schedule_year, $this->schedule_month, 1)->subDays(7); // 25th of previous month
        return now()->lt($lockDate);
    }

    // Apply shift request (change work day to off day)
    public static function applyShiftRequest($csProfileId, $requestedDate, $userId)
    {
        $schedule = self::where('cs_profile_id', $csProfileId)
            ->where('schedule_date', $requestedDate)
            ->first();

        if ($schedule) {
            $schedule->update([
                'shift_type' => 'off',
                'notes' => 'Libur sesuai request CS',
                'created_by' => $userId,
            ]);

            return $schedule;
        }

        return null;
    }
}
