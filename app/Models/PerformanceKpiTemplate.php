<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerformanceKpiTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'kpi_code',
        'kpi_name',
        'description',
        'weight',
        'min_score',
        'max_score',
        'scoring_guide',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'weight' => 'integer',
        'min_score' => 'integer',
        'max_score' => 'integer',
        'scoring_guide' => 'array',
        'sort_order' => 'integer',
        'is_active' => 'boolean',
    ];

    /**
     * Scopes
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }

    /**
     * Helper Methods
     */

    // Get all active KPIs ordered
    public static function getActiveKpis()
    {
        return self::active()->ordered()->get();
    }

    // Get scoring guide for a specific score
    public function getScoringDescription($score)
    {
        if (!$this->scoring_guide || !is_array($this->scoring_guide)) {
            return null;
        }

        return $this->scoring_guide[$score] ?? null;
    }

    // Validate score
    public function isValidScore($score)
    {
        return $score >= $this->min_score && $score <= $this->max_score;
    }
}
