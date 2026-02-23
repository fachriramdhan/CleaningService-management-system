<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanAtm extends Model
{
    use HasFactory;

    protected $fillable = [
        'absensi_id',
        'cs_profile_id',
        'atm_id',
        'tanggal',
        'foto_sebelum',
        'foto_sesudah',
        'foto_lokasi',
        'catatan',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    // RELATIONSHIPS

    /**
     * Relasi ke Absensi (Many to One)
     */
    public function absensi()
    {
        return $this->belongsTo(Absensi::class);
    }

    /**
     * Relasi ke CS Profile (Many to One)
     */
    public function csProfile()
    {
        return $this->belongsTo(CsProfile::class);
    }

    /**
     * Relasi ke ATM (Many to One)
     */
    public function atm()
    {
        return $this->belongsTo(Atm::class);
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
     * Get nama ATM
     */
    public function getNamaAtmAttribute()
    {
        return $this->atm->nama_atm;
    }

    /**
     * Get lokasi ATM
     */
    public function getLokasiAtmAttribute()
    {
        return $this->atm->lokasi;
    }
}
