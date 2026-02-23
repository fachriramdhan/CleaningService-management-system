<?php

namespace App\Http\Controllers\Koordinator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CsProfile;
use App\Models\Absensi;
use App\Models\LaporanAtm;
use App\Models\PermintaanInventory;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'total_cs' => CsProfile::where('is_active', true)->count(),
            'absensi_hari_ini' => Absensi::whereDate('tanggal', Carbon::today())->count(),
            'laporan_hari_ini' => LaporanAtm::whereDate('tanggal', Carbon::today())->count(),
            'permintaan_pending' => PermintaanInventory::where('status', 'pending')->count(),

            // Data untuk monitoring
            'absensi_terbaru' => Absensi::with(['csProfile.user', 'area'])
                ->whereDate('tanggal', Carbon::today())
                ->latest()
                ->limit(5)
                ->get(),

            'laporan_terbaru' => LaporanAtm::with(['csProfile.user', 'atm'])
                ->whereDate('tanggal', Carbon::today())
                ->latest()
                ->limit(5)
                ->get(),
        ];

        return view('koordinator.dashboard', compact('data'));
    }
}
