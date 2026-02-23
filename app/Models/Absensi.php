<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;

    protected $fillable = [
        'cs_profile_id',
        'area_id',
        'tanggal',
        'jam_absen',
        'foto_wajah',
        'status',
        'keterangan',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    // RELATIONSHIPS

    /**
     * Relasi ke CS Profile (Many to One)
     */
    public function csProfile()
    {
        return $this->belongsTo(CsProfile::class);
    }

    /**
     * Relasi ke Area (Many to One)
     */
    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    /**
     * Relasi ke Laporan ATM (One to Many)
     */
    public function laporanAtms()
    {
        return $this->hasMany(LaporanAtm::class);
    }

    // HELPER METHODS

    /**
     * Get nama CS
     */
    public function getNamaCsAttribute()
    {
        return $this->csProfile->nama;
    }

    /**
     * Get nama area
     */
    public function getNamaAreaAttribute()
    {
        return $this->area->nama_area;
    }
}
