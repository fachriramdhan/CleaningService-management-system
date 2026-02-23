<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class CsProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'foto',
        'tanggal_mulai_kerja',
        'lama_kerja_bulan',
        'lama_kerja_tahun',
        'is_active',
    ];

    protected $casts = [
        'tanggal_mulai_kerja' => 'date',
        'is_active' => 'boolean',
    ];

    // RELATIONSHIPS

    /**
     * Relasi ke User (One to One)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke Areas (Many to Many)
     */
    public function areas()
    {
        return $this->belongsToMany(Area::class, 'cs_area');
    }

    /**
     * Relasi ke Absensi (One to Many)
     */
    public function absensis()
    {
        return $this->hasMany(Absensi::class);
    }

    /**
     * Relasi ke Laporan ATM (One to Many)
     */
    public function laporanAtms()
    {
        return $this->hasMany(LaporanAtm::class);
    }

    /**
     * Relasi ke Inventory Logs (One to Many)
     */
    public function inventoryLogs()
    {
        return $this->hasMany(InventoryLog::class);
    }

    /**
     * Relasi ke Permintaan Inventory (One to Many)
     */
    public function permintaanInventories()
    {
        return $this->hasMany(PermintaanInventory::class);
    }

    // HELPER METHODS

    /**
     * Auto hitung lama kerja
     */
    public function hitungLamaKerja()
    {
        $mulai = Carbon::parse($this->tanggal_mulai_kerja);
        $sekarang = Carbon::now();

        $diff = $mulai->diff($sekarang);

        $this->lama_kerja_tahun = $diff->y;
        $this->lama_kerja_bulan = $diff->m;
        $this->save();
    }

    /**
     * Get nama lengkap CS
     */
    public function getNamaAttribute()
    {
        return $this->user->name;
    }

    /**
     * Cek apakah CS sudah absen hari ini
     */
    public function sudahAbsenHariIni()
    {
        return $this->absensis()
            ->whereDate('tanggal', Carbon::today())
            ->exists();
    }
}
