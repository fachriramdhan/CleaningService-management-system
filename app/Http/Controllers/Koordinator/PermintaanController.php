<?php

namespace App\Http\Controllers\Koordinator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PermintaanInventory;

class PermintaanController extends Controller
{
    public function index(Request $request)
    {
        $query = PermintaanInventory::with(['csProfile.user', 'inventory']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $permintaans = $query->latest()->paginate(20);

        return view('koordinator.permintaan.index', compact('permintaans'));
    }

    public function show($id)
    {
        $permintaan = PermintaanInventory::with(['csProfile.user', 'inventory'])
            ->findOrFail($id);

        return view('koordinator.permintaan.show', compact('permintaan'));
    }
}
