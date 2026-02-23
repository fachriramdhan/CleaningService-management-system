<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PerformanceReview extends Model
{
    use HasFactory;

    protected $fillable = [
        'cs_profile_id',
        'review_year',
        'review_month',
        'review_period_start',
        'review_period_end',
        'punctuality_score',
        'work_quality_score',
        'attendance_score',
        'checkout_time_score',
        'average_score',
        'total_score',
        'koordinator_id',
        'koordinator_reviewed_at',
        'koordinator_notes',
        'admin_id',
        'admin_reviewed_at',
        'admin_notes',
        'overall_notes',
        'improvement_plan',
        'achievement_notes',
        'status',
    ];

    protected $casts = [
        'review_year' => 'integer',
        'review_month' => 'integer',
        'review_period_start' => 'date',
        'review_period_end' => 'date',
        'punctuality_score' => 'integer',
        'work_quality_score' => 'integer',
        'attendance_score' => 'integer',
        'checkout_time_score' => 'integer',
        'average_score' => 'decimal:2',
        'total_score' => 'integer',
        'koordinator_reviewed_at' => 'datetime',
        'admin_reviewed_at' => 'datetime',
    ];

    protected $appends = ['rating_label', 'status_label'];

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
    public function getRatingLabelAttribute()
    {
        if (!$this->average_score) return '-';

        return match(true) {
            $this->average_score >= 4.5 => 'Sangat Baik',
            $this->average_score >= 3.5 => 'Baik',
            $this->average_score >= 2.5 => 'Cukup',
            $this->average_score >= 1.5 => 'Kurang',
            default => 'Sangat Kurang',
        };
    }

    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'draft' => 'Draft',
            'submitted_koordinator' => 'Menunggu Review Admin',
            'submitted_admin' => 'Menunggu Finalisasi',
            'completed' => 'Selesai',
            default => 'Unknown',
        };
    }

    /**
     * Scopes
     */
    public function scopeByYear($query, $year)
    {
        return $query->where('review_year', $year);
    }

    public function scopeByMonth($query, $month)
    {
        return $query->where('review_month', $month);
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopePending($query)
    {
        return $query->whereIn('status', ['draft', 'submitted_koordinator', 'submitted_admin']);
    }

    /**
     * Helper Methods
     */

    // Calculate average and total scores
    public function calculateScores()
    {
        $scores = array_filter([
            $this->punctuality_score,
            $this->work_quality_score,
            $this->attendance_score,
            $this->checkout_time_score,
        ]);

        if (empty($scores)) {
            $this->average_score = null;
            $this->total_score = null;
        } else {
            $this->total_score = array_sum($scores);
            $this->average_score = round($this->total_score / count($scores), 2);
        }

        $this->save();

        return $this;
    }

    // Auto-generate review for a CS for specific month
    public static function generateForMonth($csProfileId, $year, $month)
    {
        $startDate = Carbon::create($year, $month, 1);
        $endDate = $startDate->copy()->endOfMonth();

        return self::firstOrCreate(
            [
                'cs_profile_id' => $csProfileId,
                'review_year' => $year,
                'review_month' => $month,
            ],
            [
                'review_period_start' => $startDate,
                'review_period_end' => $endDate,
                'status' => 'draft',
            ]
        );
    }

    // Auto-calculate punctuality score based on attendance records
    public function autoCalculatePunctuality()
    {
        $attendances = Absensi::where('cs_profile_id', $this->cs_profile_id)
            ->whereBetween('tanggal', [$this->review_period_start, $this->review_period_end])
            ->where('status', 'hadir')
            ->get();

        if ($attendances->isEmpty()) {
            return null;
        }

        $lateCount = 0;
        foreach ($attendances as $attendance) {
            $jamAbsen = Carbon::parse($attendance->jam_absen);
            if ($jamAbsen->format('H:i:s') > '08:00:00') {
                $lateCount++;
            }
        }

        // Scoring: 5=0 late, 4=1-2, 3=3-5, 2=6-10, 1=>10
        $score = match(true) {
            $lateCount === 0 => 5,
            $lateCount <= 2 => 4,
            $lateCount <= 5 => 3,
            $lateCount <= 10 => 2,
            default => 1,
        };

        $this->punctuality_score = $score;
        $this->save();

        return $score;
    }

    // Auto-calculate attendance score
    public function autoCalculateAttendance()
    {
        $expectedDays = $this->review_period_start->diffInDays($this->review_period_end) + 1;

        $actualDays = Absensi::where('cs_profile_id', $this->cs_profile_id)
            ->whereBetween('tanggal', [$this->review_period_start, $this->review_period_end])
            ->where('status', 'hadir')
            ->count();

        $absentDays = $expectedDays - $actualDays;

        // Scoring: 5=0 absent, 4=1, 3=2-3, 2=4-5, 1=>5
        $score = match(true) {
            $absentDays === 0 => 5,
            $absentDays === 1 => 4,
            $absentDays <= 3 => 3,
            $absentDays <= 5 => 2,
            default => 1,
        };

        $this->attendance_score = $score;
        $this->save();

        return $score;
    }

    // Submit by Koordinator
    public function submitByKoordinator($koordinatorId, $notes = null)
    {
        $this->update([
            'status' => 'submitted_koordinator',
            'koordinator_id' => $koordinatorId,
            'koordinator_reviewed_at' => now(),
            'koordinator_notes' => $notes,
        ]);

        $this->calculateScores();

        return $this;
    }

    // Submit by Admin (final)
    public function submitByAdmin($adminId, $notes = null)
    {
        $this->update([
            'status' => 'completed',
            'admin_id' => $adminId,
            'admin_reviewed_at' => now(),
            'admin_notes' => $notes,
        ]);

        $this->calculateScores();

        return $this;
    }
}