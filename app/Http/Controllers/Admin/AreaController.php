<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Area;
use App\Models\Atm;

class AreaController extends Controller
{
    public function index()
    {
        $areas = Area::withCount(['atms', 'csProfiles'])
            ->latest()
            ->paginate(10);

        return view('admin.area.index', compact('areas'));
    }

    public function create()
    {
        return view('admin.area.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_area' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        Area::create([
            'nama_area' => $request->nama_area,
            'keterangan' => $request->keterangan,
            'is_active' => true,
        ]);

        return redirect()->route('admin.area.index')
            ->with('success', 'Area berhasil ditambahkan!');
    }

    public function show(string $id)
    {
        $area = Area::with(['atms', 'csProfiles.user'])
            ->withCount('atms')
            ->findOrFail($id);

        return view('admin.area.show', compact('area'));
    }

    public function edit(string $id)
    {
        $area = Area::findOrFail($id);
        return view('admin.area.edit', compact('area'));
    }

    public function update(Request $request, string $id)
    {
        $area = Area::findOrFail($id);

        $request->validate([
            'nama_area' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $area->update([
            'nama_area' => $request->nama_area,
            'keterangan' => $request->keterangan,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.area.index')
            ->with('success', 'Area berhasil diupdate!');
    }

    public function destroy(string $id)
    {
        $area = Area::findOrFail($id);

        // Cek apakah ada CS yang ditugaskan
        if ($area->csProfiles()->count() > 0) {
            return redirect()->route('admin.area.index')
                ->with('error', 'Tidak dapat menghapus area karena masih ada CS yang ditugaskan!');
        }

        // Cek apakah ada ATM
        if ($area->atms()->count() > 0) {
            return redirect()->route('admin.area.index')
                ->with('error', 'Tidak dapat menghapus area karena masih ada ATM terdaftar!');
        }

        $area->delete();

        return redirect()->route('admin.area.index')
            ->with('success', 'Area berhasil dihapus!');
    }
}
