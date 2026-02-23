<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CsProfile;
use App\Models\Area;
use App\Models\Atm;
use App\Models\Absensi;
use App\Models\LaporanAtm;
use App\Models\PermintaanInventory;
use App\Models\Inventory;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            // Total Master Data
            'total_cs_aktif' => CsProfile::where('is_active', true)->count(),
            'total_area' => Area::where('is_active', true)->count(),
            'total_atm' => Atm::where('is_active', true)->count(),

            // Hari Ini
            'absensi_hari_ini' => Absensi::whereDate('tanggal', Carbon::today())->count(),
            'laporan_hari_ini' => LaporanAtm::whereDate('tanggal', Carbon::today())->count(),

            // Permintaan & Inventory
            'permintaan_pending' => PermintaanInventory::where('status', 'pending')->count(),
            'stok_rendah' => Inventory::where('stok', '<', 10)->count(),

            // Data Terbaru untuk Widget
            'laporan_terbaru' => LaporanAtm::with(['csProfile.user', 'atm.area'])
                ->whereDate('tanggal', Carbon::today())
                ->latest()
                ->limit(5)
                ->get(),

            'absensi_terbaru' => Absensi::with(['csProfile.user', 'area'])
                ->whereDate('tanggal', Carbon::today())
                ->latest('jam_absen')
                ->limit(5)
                ->get(),
        ];

        return view('admin.dashboard', compact('data'));
    }
}
