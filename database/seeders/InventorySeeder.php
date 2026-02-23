<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Inventory;

class InventorySeeder extends Seeder
{
    public function run(): void
    {
        // ALAT-ALAT
        Inventory::create([
            'nama_item' => 'Sapu',
            'jenis' => 'alat',
            'stok' => 15,
            'satuan' => 'pcs',
            'keterangan' => 'Sapu ijuk untuk membersihkan area ATM',
            'is_active' => true,
        ]);

        Inventory::create([
            'nama_item' => 'Pel',
            'jenis' => 'alat',
            'stok' => 12,
            'satuan' => 'pcs',
            'keterangan' => 'Pel lantai untuk area ATM',
            'is_active' => true,
        ]);

        Inventory::create([
            'nama_item' => 'Kain Lap Microfiber',
            'jenis' => 'alat',
            'stok' => 30,
            'satuan' => 'pcs',
            'keterangan' => 'Kain lap khusus untuk layar ATM',
            'is_active' => true,
        ]);

        Inventory::create([
            'nama_item' => 'Ember',
            'jenis' => 'alat',
            'stok' => 10,
            'satuan' => 'pcs',
            'keterangan' => 'Ember untuk menampung air',
            'is_active' => true,
        ]);

        Inventory::create([
            'nama_item' => 'Sikat',
            'jenis' => 'alat',
            'stok' => 20,
            'satuan' => 'pcs',
            'keterangan' => 'Sikat untuk area sulit dijangkau',
            'is_active' => true,
        ]);

        Inventory::create([
            'nama_item' => 'Vacuum Cleaner',
            'jenis' => 'alat',
            'stok' => 5,
            'satuan' => 'unit',
            'keterangan' => 'Vacuum cleaner portable',
            'is_active' => true,
        ]);

        // CHEMICAL
        Inventory::create([
            'nama_item' => 'Cairan Pembersih Kaca',
            'jenis' => 'chemical',
            'stok' => 25,
            'satuan' => 'liter',
            'keterangan' => 'Untuk membersihkan kaca dan layar ATM',
            'is_active' => true,
        ]);

        Inventory::create([
            'nama_item' => 'Cairan Pembersih Lantai',
            'jenis' => 'chemical',
            'stok' => 40,
            'satuan' => 'liter',
            'keterangan' => 'Pembersih lantai area ATM',
            'is_active' => true,
        ]);

        Inventory::create([
            'nama_item' => 'Disinfektan Spray',
            'jenis' => 'chemical',
            'stok' => 18,
            'satuan' => 'liter',
            'keterangan' => 'Disinfektan untuk sterilisasi',
            'is_active' => true,
        ]);

        Inventory::create([
            'nama_item' => 'Sabun Cuci Tangan',
            'jenis' => 'chemical',
            'stok' => 22,
            'satuan' => 'liter',
            'keterangan' => 'Sabun untuk CS',
            'is_active' => true,
        ]);

        Inventory::create([
            'nama_item' => 'Pembersih Serbaguna',
            'jenis' => 'chemical',
            'stok' => 8,
            'satuan' => 'liter',
            'keterangan' => 'Pembersih untuk berbagai permukaan',
            'is_active' => true,
        ]);

        Inventory::create([
            'nama_item' => 'Pengharum Ruangan',
            'jenis' => 'chemical',
            'stok' => 15,
            'satuan' => 'botol',
            'keterangan' => 'Pengharum spray untuk area ATM',
            'is_active' => true,
        ]);
    }
}
