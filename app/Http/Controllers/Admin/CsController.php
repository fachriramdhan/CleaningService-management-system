<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\CsProfile;
use App\Models\Area;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class CsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $csProfiles = CsProfile::with(['user', 'areas'])
            ->latest()
            ->paginate(10);

        return view('admin.cs.index', compact('csProfiles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $areas = Area::where('is_active', true)->get();
        return view('admin.cs.create', compact('areas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'tanggal_mulai_kerja' => 'required|date',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'areas' => 'required|array|min:1',
        ]);

        // Buat User
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'cs',
            'is_active' => true,
        ]);

        // Handle upload foto
        $fotoPath = 'default-avatar.png';
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('cs-photos', 'public');
        }

        // Hitung lama kerja
        $tanggalMulai = Carbon::parse($request->tanggal_mulai_kerja);
        $sekarang = Carbon::now();
        $diff = $tanggalMulai->diff($sekarang);

        // Buat CS Profile
        $csProfile = CsProfile::create([
            'user_id' => $user->id,
            'foto' => $fotoPath,
            'tanggal_mulai_kerja' => $request->tanggal_mulai_kerja,
            'lama_kerja_tahun' => $diff->y,
            'lama_kerja_bulan' => $diff->m,
            'is_active' => true,
        ]);

        // Assign areas
        $csProfile->areas()->attach($request->areas);

        return redirect()->route('admin.cs.index')
            ->with('success', 'Data CS berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $csProfile = CsProfile::with(['user', 'areas', 'absensis', 'laporanAtms'])
            ->findOrFail($id);

        // Statistik
        $stats = [
            'total_absensi' => $csProfile->absensis()->count(),
            'total_laporan' => $csProfile->laporanAtms()->count(),
            'absensi_bulan_ini' => $csProfile->absensis()
                ->whereMonth('tanggal', Carbon::now()->month)
                ->count(),
            'laporan_bulan_ini' => $csProfile->laporanAtms()
                ->whereMonth('tanggal', Carbon::now()->month)
                ->count(),
        ];

        return view('admin.cs.show', compact('csProfile', 'stats'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $csProfile = CsProfile::with(['user', 'areas'])->findOrFail($id);
        $areas = Area::where('is_active', true)->get();

        return view('admin.cs.edit', compact('csProfile', 'areas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $csProfile = CsProfile::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $csProfile->user_id,
            'tanggal_mulai_kerja' => 'required|date',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'areas' => 'required|array|min:1',
            'is_active' => 'boolean',
        ]);

        // Update User
        $csProfile->user->update([
            'name' => $request->name,
            'email' => $request->email,
            'is_active' => $request->has('is_active'),
        ]);

        // Update password jika diisi
        if ($request->filled('password')) {
            $request->validate([
                'password' => 'min:8|confirmed',
            ]);
            $csProfile->user->update([
                'password' => Hash::make($request->password),
            ]);
        }

        // Handle upload foto baru
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika bukan default
            if ($csProfile->foto !== 'default-avatar.png') {
                Storage::disk('public')->delete($csProfile->foto);
            }
            $fotoPath = $request->file('foto')->store('cs-photos', 'public');
            $csProfile->foto = $fotoPath;
        }

        // Hitung ulang lama kerja
        $tanggalMulai = Carbon::parse($request->tanggal_mulai_kerja);
        $sekarang = Carbon::now();
        $diff = $tanggalMulai->diff($sekarang);

        // Update CS Profile
        $csProfile->update([
            'tanggal_mulai_kerja' => $request->tanggal_mulai_kerja,
            'lama_kerja_tahun' => $diff->y,
            'lama_kerja_bulan' => $diff->m,
            'is_active' => $request->has('is_active'),
        ]);

        // Update areas
        $csProfile->areas()->sync($request->areas);

        return redirect()->route('admin.cs.index')
            ->with('success', 'Data CS berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $csProfile = CsProfile::findOrFail($id);

        // Hapus foto jika bukan default
        if ($csProfile->foto !== 'default-avatar.png') {
            Storage::disk('public')->delete($csProfile->foto);
        }

        // Hapus user (akan cascade ke cs_profile)
        $csProfile->user->delete();

        return redirect()->route('admin.cs.index')
            ->with('success', 'Data CS berhasil dihapus!');
    }

    /**
     * Toggle active status
     */
    public function toggleStatus($id)
    {
        $csProfile = CsProfile::findOrFail($id);
        $csProfile->is_active = !$csProfile->is_active;
        $csProfile->user->is_active = $csProfile->is_active;
        $csProfile->save();
        $csProfile->user->save();

        $status = $csProfile->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return redirect()->route('admin.cs.index')
            ->with('success', "CS berhasil {$status}!");
    }
}
