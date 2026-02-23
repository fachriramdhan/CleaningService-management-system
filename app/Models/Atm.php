<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Atm extends Model
{
    use HasFactory;

    protected $fillable = [
        'area_id',
        'nama_atm',
        'lokasi',
        'alamat_lengkap',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // RELATIONSHIPS

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
     * Get nama area
     */
    public function getNamaAreaAttribute()
    {
        return $this->area->nama_area;
    }
}
