<?php

namespace App\Http\Controllers\CS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LaporanAtm;
use App\Models\Absensi;
use App\Models\Atm;
use Carbon\Carbon;

class LaporanAtmController extends Controller
{
    public function index()
{
    $csProfile = auth()->user()->csProfile;

    // Ambil absensi hari ini dengan eager load area
    $absensi = \App\Models\Absensi::where('cs_profile_id', $csProfile->id)
        ->whereDate('tanggal', today())
        ->with('area')           // ← eager load area sekalian
        ->first();

    // Ambil ATM hanya jika sudah absen
    $atms = collect();
    if ($absensi) {
        $atms = \App\Models\Atm::where('area_id', $absensi->area_id)
            ->where('is_active', true)
            ->orderBy('nama_atm')
            ->get();
    }

    // Ambil laporan CS ini
    $laporans = \App\Models\LaporanAtm::where('cs_profile_id', $csProfile->id)
        ->with(['atm.area'])
        ->latest()
        ->paginate(10);

    return view('cs.laporan.index', compact('laporans', 'absensi', 'atms'));
}

    public function create()
    {
        $csProfile = auth()->user()->csProfile;

        if (!$csProfile->sudahAbsenHariIni()) {
            return redirect()->route('cs.dashboard')
                ->with('error', 'Anda harus absen terlebih dahulu.');
        }

        $absensi = $csProfile->absensis()
            ->whereDate('tanggal', Carbon::today())
            ->firstOrFail();

        $atms = Atm::where('area_id', $absensi->area_id)
            ->where('is_active', true)
            ->get();

        return view('cs.laporan.create', compact('atms', 'absensi'));
    }

    public function store(Request $request)
    {
        $csProfile = auth()->user()->csProfile;

        $absensi = $csProfile->absensis()
            ->whereDate('tanggal', Carbon::today())
            ->firstOrFail();

        $request->validate([
            'atm_id' => 'required|exists:atms,id',
            'foto_sebelum' => 'required|image|max:5120',
            'foto_sesudah' => 'required|image|max:5120',
            'foto_lokasi' => 'required|image|max:5120',
            'catatan' => 'nullable|string|max:1000',
        ]);

        $laporanExists = LaporanAtm::where('cs_profile_id', $csProfile->id)
            ->where('atm_id', $request->atm_id)
            ->whereDate('tanggal', Carbon::today())
            ->exists();

        if ($laporanExists) {
            return back()->with('error', 'ATM ini sudah dilaporkan hari ini.');
        }

        LaporanAtm::create([
            'cs_profile_id' => $csProfile->id,
            'absensi_id' => $absensi->id,
            'atm_id' => $request->atm_id,
            'tanggal' => Carbon::today(),
            'foto_sebelum' => $request->file('foto_sebelum')->store('laporan/sebelum', 'public'),
            'foto_sesudah' => $request->file('foto_sesudah')->store('laporan/sesudah', 'public'),
            'foto_lokasi' => $request->file('foto_lokasi')->store('laporan/lokasi', 'public'),
            'catatan' => $request->catatan,
        ]);

        return redirect()->route('cs.laporan.index')
            ->with('success', 'Laporan berhasil disimpan.');
    }

    public function show($id)
    {
        $csProfile = auth()->user()->csProfile;

        $laporan = LaporanAtm::where('cs_profile_id', $csProfile->id)
            ->with(['atm.area', 'absensi'])
            ->findOrFail($id);

        return view('cs.laporan.show', compact('laporan'));
    }
}