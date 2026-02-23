<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Atm;
use App\Models\Area;

class AtmController extends Controller
{
    public function index()
    {
        $atms = Atm::with('area')
            ->latest()
            ->paginate(15);

        return view('admin.atm.index', compact('atms'));
    }

    public function create()
    {
        $areas = Area::where('is_active', true)->get();
        return view('admin.atm.create', compact('areas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'area_id' => 'required|exists:areas,id',
            'nama_atm' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'alamat_lengkap' => 'nullable|string',
        ]);

        Atm::create([
            'area_id' => $request->area_id,
            'nama_atm' => $request->nama_atm,
            'lokasi' => $request->lokasi,
            'alamat_lengkap' => $request->alamat_lengkap,
            'is_active' => true,
        ]);

        return redirect()->route('admin.atm.index')
            ->with('success', 'ATM berhasil ditambahkan!');
    }

    public function show(string $id)
    {
        $atm = Atm::with(['area', 'laporanAtms.csProfile.user'])
            ->findOrFail($id);

        return view('admin.atm.show', compact('atm'));
    }

    public function edit(string $id)
    {
        $atm = Atm::findOrFail($id);
        $areas = Area::where('is_active', true)->get();

        return view('admin.atm.edit', compact('atm', 'areas'));
    }

    public function update(Request $request, string $id)
    {
        $atm = Atm::findOrFail($id);

        $request->validate([
            'area_id' => 'required|exists:areas,id',
            'nama_atm' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'alamat_lengkap' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $atm->update([
            'area_id' => $request->area_id,
            'nama_atm' => $request->nama_atm,
            'lokasi' => $request->lokasi,
            'alamat_lengkap' => $request->alamat_lengkap,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.atm.index')
            ->with('success', 'ATM berhasil diupdate!');
    }

    public function destroy(string $id)
    {
        $atm = Atm::findOrFail($id);

        // Cek apakah ada laporan
        if ($atm->laporanAtms()->count() > 0) {
            return redirect()->route('admin.atm.index')
                ->with('error', 'Tidak dapat menghapus ATM karena sudah ada laporan terkait!');
        }

        $atm->delete();

        return redirect()->route('admin.atm.index')
            ->with('success', 'ATM berhasil dihapus!');
    }
}
