<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'inventory_id',
        'cs_profile_id',
        'tipe',
        'jumlah',
        'tanggal',
        'keterangan',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'jumlah' => 'integer',
    ];

    // RELATIONSHIPS

    /**
     * Relasi ke Inventory (Many to One)
     */
    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }

    /**
     * Relasi ke CS Profile (Many to One)
     */
    public function csProfile()
    {
        return $this->belongsTo(CsProfile::class);
    }

    // HELPER METHODS

    /**
     * Get nama item
     */
    public function getNamaItemAttribute()
    {
        return $this->inventory->nama_item;
    }

    /**
     * Get nama CS (jika ada)
     */
    public function getNamaCsAttribute()
    {
        return $this->csProfile ? $this->csProfile->nama : '-';
    }

    /**
     * Get badge color berdasarkan tipe
     */
    public function getTipeBadgeColorAttribute()
    {
        return match($this->tipe) {
            'penggunaan' => 'red',
            'penambahan' => 'green',
            'pengurangan' => 'orange',
            'pergantian' => 'blue',
            default => 'gray',
        };
    }
}
