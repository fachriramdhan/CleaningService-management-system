<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PermintaanInventory;
use App\Models\InventoryLog;

class PermintaanInventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = PermintaanInventory::with(['csProfile.user', 'inventory']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $permintaans = $query->latest()->paginate(20);

        return view('admin.permintaan.index', compact('permintaans'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $permintaan = PermintaanInventory::with(['csProfile.user', 'inventory'])
            ->findOrFail($id);

        return view('admin.permintaan.show', compact('permintaan'));
    }

    /**
     * Approve permintaan
     */
    public function approve(Request $request, $id)
    {
        $permintaan = PermintaanInventory::findOrFail($id);

        if ($permintaan->status !== 'pending') {
            return back()->with('error', 'Permintaan sudah diproses sebelumnya!');
        }

        $request->validate([
            'keterangan_admin' => 'nullable|string|max:500',
        ]);

        // Cek stok mencukupi
        if ($permintaan->inventory->stok < $permintaan->jumlah) {
            return back()->with('error', 'Stok tidak mencukupi! Stok tersedia: ' . $permintaan->inventory->stok . ' ' . $permintaan->inventory->satuan);
        }

        // Approve
        $permintaan->approve($request->keterangan_admin);

        // Kurangi stok inventory
        $permintaan->inventory->kurangiStok($permintaan->jumlah);

        // Log transaksi
        InventoryLog::create([
            'inventory_id' => $permintaan->inventory_id,
            'cs_profile_id' => $permintaan->cs_profile_id,
            'tipe' => 'keluar',
            'jumlah' => $permintaan->jumlah,
            'tanggal' => now(),
            'keterangan' => 'Permintaan ' . $permintaan->jenis_permintaan . ' - ' . $permintaan->alasan,
        ]);

        return redirect()->route('admin.permintaan.index')
            ->with('success', 'Permintaan berhasil disetujui dan stok telah dikurangi!');
    }

    /**
     * Reject permintaan
     */
    public function reject(Request $request, $id)
    {
        $permintaan = PermintaanInventory::findOrFail($id);

        if ($permintaan->status !== 'pending') {
            return back()->with('error', 'Permintaan sudah diproses sebelumnya!');
        }

        $request->validate([
            'keterangan_admin' => 'required|string|max:500',
        ]);

        // Reject
        $permintaan->reject($request->keterangan_admin);

        return redirect()->route('admin.permintaan.index')
            ->with('success', 'Permintaan berhasil ditolak!');
    }
}
