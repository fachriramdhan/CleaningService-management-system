<?php

namespace App\Http\Controllers\CS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PermintaanInventory;
use App\Models\Inventory;

class PermintaanInventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $csProfile = auth()->user()->csProfile;

        $permintaans = PermintaanInventory::where('cs_profile_id', $csProfile->id)
            ->with('inventory')
            ->latest()
            ->paginate(15);

        return view('cs.permintaan.index', compact('permintaans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $inventories = Inventory::where('is_active', true)->get();

        return view('cs.permintaan.create', compact('inventories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $csProfile = auth()->user()->csProfile;

        $request->validate([
            'inventory_id' => 'required|exists:inventories,id',
            'jenis_permintaan' => 'required|in:pinjam,ambil',
            'jumlah' => 'required|integer|min:1',
            'alasan' => 'required|string|max:500',
        ]);

        PermintaanInventory::create([
            'cs_profile_id' => $csProfile->id,
            'inventory_id' => $request->inventory_id,
            'jenis_permintaan' => $request->jenis_permintaan,
            'jumlah' => $request->jumlah,
            'alasan' => $request->alasan,
            'status' => 'pending',
        ]);

        return redirect()->route('cs.permintaan.index')
            ->with('success', 'Permintaan berhasil diajukan! Menunggu persetujuan admin.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $csProfile = auth()->user()->csProfile;

        $permintaan = PermintaanInventory::where('cs_profile_id', $csProfile->id)
            ->with('inventory')
            ->findOrFail($id);

        return view('cs.permintaan.show', compact('permintaan'));
    }
}
