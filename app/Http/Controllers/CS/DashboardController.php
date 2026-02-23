<?php

namespace App\Http\Controllers\CS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CsProfile;
use App\Models\Absensi;
use App\Models\LaporanAtm;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $csProfile = auth()->user()->csProfile;

        // Cek apakah CS sudah absen hari ini
        $sudahAbsen = $csProfile->sudahAbsenHariIni();

        $data = [
            'cs_profile' => $csProfile,
            'sudah_absen' => $sudahAbsen,
            'area_tugas' => $csProfile->areas,
            'laporan_bulan_ini' => LaporanAtm::where('cs_profile_id', $csProfile->id)
                ->whereMonth('tanggal', Carbon::now()->month)
                ->count(),

            // Absensi hari ini
            'absensi_hari_ini' => Absensi::where('cs_profile_id', $csProfile->id)
                ->whereDate('tanggal', Carbon::today())
                ->first(),

            // Laporan hari ini
            'laporan_hari_ini' => LaporanAtm::where('cs_profile_id', $csProfile->id)
                ->whereDate('tanggal', Carbon::today())
                ->with('atm')
                ->get(),
        ];

        return view('cs.dashboard', compact('data'));
    }
}
