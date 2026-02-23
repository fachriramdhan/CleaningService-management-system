<?php

namespace App\Http\Controllers\Koordinator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LaporanAtm;
use App\Models\Absensi;
use App\Models\CsProfile;
use App\Models\Area;
use Carbon\Carbon;

class MonitoringController extends Controller
{
    /**
     * Monitoring Absensi
     */
    public function absensi(Request $request)
    {
        $query = Absensi::with(['csProfile.user', 'area']);

        // Filter by date
        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal', $request->tanggal);
        } else {
            $query->whereDate('tanggal', Carbon::today());
        }

        if ($request->filled('cs_profile_id')) {
            $query->where('cs_profile_id', $request->cs_profile_id);
        }

        if ($request->filled('area_id')) {
            $query->where('area_id', $request->area_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $absensis = $query->latest('tanggal')->latest('jam_absen')->paginate(20);

        $csProfiles = CsProfile::with('user')->where('is_active', true)->get();
        $areas = Area::where('is_active', true)->get();

        return view('koordinator.monitoring.absensi', compact('absensis', 'csProfiles', 'areas'));
    }

    /**
     * Monitoring Laporan ATM
     */
    public function laporan(Request $request)
    {
        $query = LaporanAtm::with(['csProfile.user', 'atm.area', 'absensi']);

        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal', $request->tanggal);
        } else {
            $query->whereDate('tanggal', Carbon::today());
        }

        if ($request->filled('cs_profile_id')) {
            $query->where('cs_profile_id', $request->cs_profile_id);
        }

        if ($request->filled('area_id')) {
            $query->whereHas('atm', function($q) use ($request) {
                $q->where('area_id', $request->area_id);
            });
        }

        $laporans = $query->latest('tanggal')->latest('created_at')->paginate(20);

        $csProfiles = CsProfile::with('user')->where('is_active', true)->get();
        $areas = Area::where('is_active', true)->get();

        $summary = [
            'total_laporan' => LaporanAtm::whereDate('tanggal', $request->filled('tanggal') ? $request->tanggal : Carbon::today())->count(),
            'total_cs_aktif' => Absensi::whereDate('tanggal', $request->filled('tanggal') ? $request->tanggal : Carbon::today())->distinct('cs_profile_id')->count(),
        ];

        return view('koordinator.monitoring.laporan', compact('laporans', 'csProfiles', 'areas', 'summary'));
    }

    /**
     * Detail Laporan
     */
    public function detailLaporan($id)
    {
        $laporan = LaporanAtm::with(['csProfile.user', 'atm.area', 'absensi'])
            ->findOrFail($id);

        return view('koordinator.monitoring.detail-laporan', compact('laporan'));
    }
}
