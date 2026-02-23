<?php

namespace App\Http\Controllers\Admin;

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
            // Default: hari ini
            $query->whereDate('tanggal', Carbon::today());
        }

        // Filter by CS
        if ($request->filled('cs_profile_id')) {
            $query->where('cs_profile_id', $request->cs_profile_id);
        }

        // Filter by Area
        if ($request->filled('area_id')) {
            $query->where('area_id', $request->area_id);
        }

        // Filter by Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $absensis = $query->latest('tanggal')->latest('jam_absen')->paginate(20);

        // Data untuk filter
        $csProfiles = CsProfile::with('user')->where('is_active', true)->get();
        $areas = Area::where('is_active', true)->get();

        return view('admin.monitoring.absensi', compact('absensis', 'csProfiles', 'areas'));
    }

    /**
     * Monitoring Laporan ATM
     */
    public function laporan(Request $request)
    {
        $query = LaporanAtm::with(['csProfile.user', 'atm.area', 'absensi']);

        // Filter by date
        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal', $request->tanggal);
        } else {
            // Default: hari ini
            $query->whereDate('tanggal', Carbon::today());
        }

        // Filter by CS
        if ($request->filled('cs_profile_id')) {
            $query->where('cs_profile_id', $request->cs_profile_id);
        }

        // Filter by Area
        if ($request->filled('area_id')) {
            $query->whereHas('atm', function($q) use ($request) {
                $q->where('area_id', $request->area_id);
            });
        }

        $laporans = $query->latest('tanggal')->latest('created_at')->paginate(20);

        // Data untuk filter
        $csProfiles = CsProfile::with('user')->where('is_active', true)->get();
        $areas = Area::where('is_active', true)->get();

        // Summary
        $summary = [
            'total_laporan' => LaporanAtm::whereDate('tanggal', $request->filled('tanggal') ? $request->tanggal : Carbon::today())->count(),
            'total_cs_aktif' => Absensi::whereDate('tanggal', $request->filled('tanggal') ? $request->tanggal : Carbon::today())->distinct('cs_profile_id')->count(),
        ];

        return view('admin.monitoring.laporan', compact('laporans', 'csProfiles', 'areas', 'summary'));
    }

    /**
     * Detail Laporan
     */
    public function detailLaporan($id)
    {
        $laporan = LaporanAtm::with(['csProfile.user', 'atm.area', 'absensi'])
            ->findOrFail($id);

        return view('admin.monitoring.detail-laporan', compact('laporan'));
    }

    /**
     * Laporan Harian (Print)
     */
    public function laporanHarian(Request $request)
    {
        $tanggal = $request->filled('tanggal') ? Carbon::parse($request->tanggal) : Carbon::today();

        $laporans = LaporanAtm::with(['csProfile.user', 'atm.area'])
            ->whereDate('tanggal', $tanggal)
            ->orderBy('created_at')
            ->get();

        $absensis = Absensi::with(['csProfile.user', 'area'])
            ->whereDate('tanggal', $tanggal)
            ->get();

        return view('admin.monitoring.laporan-harian', compact('laporans', 'absensis', 'tanggal'));
    }
}
