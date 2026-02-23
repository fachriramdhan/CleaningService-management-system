<?php

namespace App\Http\Controllers\CS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Absensi;
use App\Models\CsProfile;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class AbsensiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $csProfile = auth()->user()->csProfile;

        $absensis = Absensi::where('cs_profile_id', $csProfile->id)
            ->with('area')
            ->latest('tanggal')
            ->paginate(15);

        return view('cs.absensi.index', compact('absensis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $csProfile = auth()->user()->csProfile;

        // Cek apakah sudah absen hari ini
        $sudahAbsen = $csProfile->sudahAbsenHariIni();

        if ($sudahAbsen) {
            return redirect()->route('cs.absensi.index')
                ->with('error', 'Anda sudah absen hari ini!');
        }

        // Ambil area tugas CS
        $areas = $csProfile->areas;

        if ($areas->isEmpty()) {
            return redirect()->route('cs.dashboard')
                ->with('error', 'Anda belum memiliki area tugas. Silakan hubungi admin.');
        }

        return view('cs.absensi.create', compact('areas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $csProfile = auth()->user()->csProfile;

        // Cek apakah sudah absen hari ini
        if ($csProfile->sudahAbsenHariIni()) {
            return redirect()->route('cs.absensi.index')
                ->with('error', 'Anda sudah absen hari ini!');
        }

        $request->validate([
            'area_id' => 'required|exists:areas,id',
            'foto_wajah' => 'required|image|mimes:jpeg,png,jpg|max:5120', // Max 5MB
            'status' => 'required|in:hadir,izin,sakit',
            'keterangan' => 'nullable|string|max:500',
        ]);

        // Validasi area (harus sesuai dengan area tugas CS)
        if (!$csProfile->areas->contains($request->area_id)) {
            return back()->with('error', 'Area yang dipilih bukan area tugas Anda!')->withInput();
        }

        // Upload foto wajah
        $fotoPath = $request->file('foto_wajah')->store('absensi-photos', 'public');

        // Ambil waktu dari EXIF jika ada, atau gunakan waktu sekarang
        $jamAbsen = Carbon::now()->format('H:i:s');

        // Simpan absensi
        Absensi::create([
            'cs_profile_id' => $csProfile->id,
            'area_id' => $request->area_id,
            'tanggal' => Carbon::today(),
            'jam_absen' => $jamAbsen,
            'foto_wajah' => $fotoPath,
            'status' => $request->status,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('cs.dashboard')
            ->with('success', 'Absensi berhasil! Anda dapat membuat laporan ATM sekarang.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $csProfile = auth()->user()->csProfile;

        $absensi = Absensi::where('cs_profile_id', $csProfile->id)
            ->with('area')
            ->findOrFail($id);

        return view('cs.absensi.show', compact('absensi'));
    }
}
