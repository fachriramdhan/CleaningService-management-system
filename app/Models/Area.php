<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_area',
        'keterangan',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // RELATIONSHIPS

    /**
     * Relasi ke CS Profiles (Many to Many)
     */
    public function csProfiles()
    {
        return $this->belongsToMany(CsProfile::class, 'cs_area');
    }

    /**
     * Relasi ke ATMs (One to Many)
     */
    public function atms()
    {
        return $this->hasMany(Atm::class);
    }

    /**
     * Relasi ke Absensi (One to Many)
     */
    public function absensis()
    {
        return $this->hasMany(Absensi::class);
    }

    // HELPER METHODS

    /**
     * Get ATM yang aktif di area ini
     */
    public function getAtmsAktifAttribute()
    {
        return $this->atms()->where('is_active', true)->get();
    }
}
