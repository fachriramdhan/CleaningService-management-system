<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_item',
        'jenis',
        'stok',
        'satuan',
        'keterangan',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'stok' => 'integer',
    ];

    // RELATIONSHIPS

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
     * Tambah stok
     */
    public function tambahStok($jumlah, $keterangan = null)
    {
        $this->stok += $jumlah;
        $this->save();

        // Catat di log
        $this->inventoryLogs()->create([
            'tipe' => 'penambahan',
            'jumlah' => $jumlah,
            'tanggal' => now(),
            'keterangan' => $keterangan,
        ]);

        return $this;
    }

    /**
     * Kurangi stok
     */
    public function kurangiStok($jumlah, $csProfileId = null, $keterangan = null)
    {
        if ($this->stok < $jumlah) {
            return false; // Stok tidak cukup
        }

        $this->stok -= $jumlah;
        $this->save();

        // Catat di log
        $this->inventoryLogs()->create([
            'cs_profile_id' => $csProfileId,
            'tipe' => 'penggunaan',
            'jumlah' => $jumlah,
            'tanggal' => now(),
            'keterangan' => $keterangan,
        ]);

        return $this;
    }

    /**
     * Cek apakah stok rendah (kurang dari 10)
     */
    public function isStokRendah()
    {
        return $this->stok < 10;
    }

    /**
     * Get history penggunaan
     */
    public function getHistoryPenggunaan($limit = 10)
    {
        return $this->inventoryLogs()
            ->where('tipe', 'penggunaan')
            ->with('csProfile.user')
            ->latest()
            ->limit($limit)
            ->get();
    }
}
