<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermintaanInventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'cs_profile_id',
        'inventory_id',
        'jenis_permintaan',
        'jumlah',
        'alasan',
        'status',
        'keterangan_admin',
        'tanggal_approved',
    ];

    protected $casts = [
        'jumlah' => 'integer',
        'tanggal_approved' => 'datetime',
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
     * Relasi ke Inventory (Many to One)
     */
    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
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
     * Get nama item
     */
    public function getNamaItemAttribute()
    {
        return $this->inventory->nama_item;
    }

    /**
     * Approve permintaan
     */
    public function approve($keteranganAdmin = null)
    {
        $this->status = 'approved';
        $this->keterangan_admin = $keteranganAdmin;
        $this->tanggal_approved = now();
        $this->save();

        // Jika permintaan, kurangi stok
        if ($this->jenis_permintaan === 'permintaan') {
            $this->inventory->kurangiStok(
                $this->jumlah,
                $this->cs_profile_id,
                "Permintaan disetujui - {$this->alasan}"
            );
        }

        // Jika pergantian, catat di log
        if ($this->jenis_permintaan === 'pergantian') {
            $this->inventory->inventoryLogs()->create([
                'cs_profile_id' => $this->cs_profile_id,
                'tipe' => 'pergantian',
                'jumlah' => $this->jumlah,
                'tanggal' => now(),
                'keterangan' => "Pergantian alat - {$this->alasan}",
            ]);
        }

        return $this;
    }

    /**
     * Reject permintaan
     */
    public function reject($keteranganAdmin)
    {
        $this->status = 'rejected';
        $this->keterangan_admin = $keteranganAdmin;
        $this->save();

        return $this;
    }

    /**
     * Get status badge color
     */
    public function getStatusBadgeColorAttribute()
    {
        return match($this->status) {
            'pending' => 'yellow',
            'approved' => 'green',
            'rejected' => 'red',
            default => 'gray',
        };
    }

    /**
     * Scope untuk filter pending
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope untuk filter approved
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /**
     * Scope untuk filter rejected
     */
    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }
}
