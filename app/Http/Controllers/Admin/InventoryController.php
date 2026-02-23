<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inventory;
use App\Models\InventoryLog;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $inventories = Inventory::latest()->paginate(15);

        return view('admin.inventory.index', compact('inventories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.inventory.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_item' => 'required|string|max:255',
            'jenis' => 'required|in:alat,chemical',
            'stok' => 'required|integer|min:0',
            'satuan' => 'required|string|max:50',
            'keterangan' => 'nullable|string|max:500',
        ]);

        Inventory::create([
            'nama_item' => $request->nama_item,
            'jenis' => $request->jenis,
            'stok' => $request->stok,
            'satuan' => $request->satuan,
            'keterangan' => $request->keterangan,
            'is_active' => true,
        ]);

        return redirect()->route('admin.inventory.index')
            ->with('success', 'Item inventory berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $inventory = Inventory::with(['inventoryLogs.csProfile.user'])
            ->findOrFail($id);

        // Ambil log terbaru
        $logs = InventoryLog::where('inventory_id', $id)
            ->with('csProfile.user')
            ->latest()
            ->paginate(20);

        return view('admin.inventory.show', compact('inventory', 'logs'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $inventory = Inventory::findOrFail($id);
        return view('admin.inventory.edit', compact('inventory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $inventory = Inventory::findOrFail($id);

        $request->validate([
            'nama_item' => 'required|string|max:255',
            'jenis' => 'required|in:alat,chemical',
            'stok' => 'required|integer|min:0',
            'satuan' => 'required|string|max:50',
            'keterangan' => 'nullable|string|max:500',
            'is_active' => 'boolean',
        ]);

        $inventory->update([
            'nama_item' => $request->nama_item,
            'jenis' => $request->jenis,
            'stok' => $request->stok,
            'satuan' => $request->satuan,
            'keterangan' => $request->keterangan,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.inventory.index')
            ->with('success', 'Item inventory berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $inventory = Inventory::findOrFail($id);

        // Cek apakah ada log atau permintaan
        if ($inventory->inventoryLogs()->count() > 0 || $inventory->permintaanInventories()->count() > 0) {
            return redirect()->route('admin.inventory.index')
                ->with('error', 'Tidak dapat menghapus item karena sudah ada riwayat transaksi!');
        }

        $inventory->delete();

        return redirect()->route('admin.inventory.index')
            ->with('success', 'Item inventory berhasil dihapus!');
    }

    /**
     * Tambah stok
     */
    public function tambahStok(Request $request, $id)
    {
        $inventory = Inventory::findOrFail($id);

        $request->validate([
            'jumlah' => 'required|integer|min:1',
            'keterangan' => 'nullable|string|max:500',
        ]);

        $inventory->tambahStok($request->jumlah);

        // Log transaksi
        InventoryLog::create([
            'inventory_id' => $inventory->id,
            'cs_profile_id' => null, // Admin yang tambah stok
            'tipe' => 'masuk',
            'jumlah' => $request->jumlah,
            'tanggal' => now(),
            'keterangan' => $request->keterangan ?? 'Penambahan stok oleh admin',
        ]);

        return redirect()->route('admin.inventory.show', $id)
            ->with('success', 'Stok berhasil ditambahkan!');
    }

    /**
     * Kurangi stok
     */
    public function kurangiStok(Request $request, $id)
    {
        $inventory = Inventory::findOrFail($id);

        $request->validate([
            'jumlah' => 'required|integer|min:1|max:' . $inventory->stok,
            'keterangan' => 'nullable|string|max:500',
        ]);

        $inventory->kurangiStok($request->jumlah);

        // Log transaksi
        InventoryLog::create([
            'inventory_id' => $inventory->id,
            'cs_profile_id' => null,
            'tipe' => 'keluar',
            'jumlah' => $request->jumlah,
            'tanggal' => now(),
            'keterangan' => $request->keterangan ?? 'Pengurangan stok oleh admin',
        ]);

        return redirect()->route('admin.inventory.show', $id)
            ->with('success', 'Stok berhasil dikurangi!');
    }
}
