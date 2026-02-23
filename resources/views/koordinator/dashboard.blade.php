@extends('layouts.app-dashboard')

@section('title', 'Dashboard Koordinator')

@section('nav-links')
    <a href="{{ route('koordinator.dashboard') }}" class="inline-flex items-center px-1 pt-1 border-b-2 border-indigo-400 text-sm font-medium text-gray-900">
        Dashboard
    </a>
    <a href="{{ route('koordinator.monitoring.absensi') }}" class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300">
        Monitoring Absensi
    </a>
    <a href="{{ route('koordinator.monitoring.laporan') }}" class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300">
        Monitoring Laporan
    </a>
     <a href="{{ route('koordinator.permintaan.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300">
        Permintaan
    </a>
@endsection

@section('mobile-nav-links')
    <a href="{{ route('koordinator.dashboard') }}" class="block pl-3 pr-4 py-2 border-l-4 border-indigo-400 text-base font-medium text-indigo-700 bg-indigo-50">
        Dashboard
    </a>
    <a href="{{ route('koordinator.monitoring.absensi') }}" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300">
        Monitoring Absensi
    </a>
    <a href="{{ route('koordinator.monitoring.laporan') }}" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300">
        Monitoring Laporan
    </a>
     <a href="{{ route('koordinator.permintaan.index') }}" class="block pl-3 pr-4 py-2 border-l-4 border-indigo-400 text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300">
        Permintaan
    </a>
@endsection

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Page Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl md:text-4xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                    👋 Hey, Koordinator!
                </h1>
                <p class="mt-2 text-gray-600 flex items-center space-x-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <span>{{ now()->format('l, d F Y') }}</span>
                </p>
            </div>
            <!-- Welcome Badge (Desktop) -->
            <div class="hidden md:flex items-center space-x-3 bg-gradient-to-r from-blue-50 to-purple-50 px-6 py-3 rounded-2xl border border-blue-100">
                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center shadow-lg">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-semibold text-gray-900">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-gray-600">Koordinator Dashboard</p>
                </div>
            </div>
        </div>
    </div>

   <!-- Statistics Cards -->
<div class="grid grid-cols-2 lg:grid-cols-4 gap-5 mb-8">

    <!-- ================= CARD ================= -->
    <div class="relative bg-white rounded-3xl shadow-sm hover:shadow-md transition-all duration-300 p-5 min-h-[150px] flex flex-col justify-between">

        <!-- Badge -->
        <span class="absolute top-4 right-4 text-[11px] px-3 py-1 bg-blue-50 text-blue-600 font-medium rounded-full">
            Active
        </span>

        <!-- Top Section -->
        <div class="flex items-center gap-4">

            <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center shadow-md">
                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
            </div>

            <div>
                <p class="text-sm text-gray-500 font-medium">
                    Total CS
                </p>
                <p class="text-3xl font-bold text-gray-900 leading-tight mt-1">
                    {{ $data['total_cs'] }}
                </p>
            </div>

        </div>

        <!-- Bottom -->
        <div class="pt-4 mt-4 border-t border-gray-100">
            <div class="flex items-center justify-between text-sm font-medium text-blue-600">
                <span>View all CS</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5l7 7-7 7"/>
                </svg>
            </div>
        </div>

    </div>


    <!-- ================= ABSENSI ================= -->
    <div class="relative bg-white rounded-3xl shadow-sm hover:shadow-md transition-all duration-300 p-5 min-h-[150px] flex flex-col justify-between">

        <span class="absolute top-4 right-4 text-[11px] px-3 py-1 bg-green-50 text-green-600 font-medium rounded-full">
            Today
        </span>

        <div class="flex items-center gap-4">

            <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-green-500 to-green-600 flex items-center justify-center shadow-md">
                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>

            <div>
                <p class="text-sm text-gray-500 font-medium">
                    Absensi Hari Ini
                </p>
                <p class="text-3xl font-bold text-gray-900 leading-tight mt-1">
                    {{ $data['absensi_hari_ini'] }}
                </p>
            </div>

        </div>

        <div class="pt-4 mt-4 border-t border-gray-100">
            <div class="flex items-center justify-between text-sm font-medium text-green-600">
                <span>View details</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5l7 7-7 7"/>
                </svg>
            </div>
        </div>

    </div>


    <!-- ================= LAPORAN ================= -->
    <div class="relative bg-white rounded-3xl shadow-sm hover:shadow-md transition-all duration-300 p-5 min-h-[150px] flex flex-col justify-between">

        <span class="absolute top-4 right-4 text-[11px] px-3 py-1 bg-purple-50 text-purple-600 font-medium rounded-full">
            Reports
        </span>

        <div class="flex items-center gap-4">

            <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-purple-500 to-purple-600 flex items-center justify-center shadow-md">
                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>

            <div>
                <p class="text-sm text-gray-500 font-medium">
                    Laporan Hari Ini
                </p>
                <p class="text-3xl font-bold text-gray-900 leading-tight mt-1">
                    {{ $data['laporan_hari_ini'] }}
                </p>
            </div>

        </div>

        <div class="pt-4 mt-4 border-t border-gray-100">
            <div class="flex items-center justify-between text-sm font-medium text-purple-600">
                <span>View reports</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5l7 7-7 7"/>
                </svg>
            </div>
        </div>

    </div>


    <!-- ================= PENDING ================= -->
    <div class="relative bg-white rounded-3xl shadow-sm hover:shadow-md transition-all duration-300 p-5 min-h-[150px] flex flex-col justify-between">

        <span class="absolute top-4 right-4 text-[11px] px-3 py-1 bg-orange-50 text-orange-600 font-medium rounded-full">
            Pending
        </span>

        <div class="flex items-center gap-4">

            <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-orange-500 to-orange-600 flex items-center justify-center shadow-md">
                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>

            <div>
                <p class="text-sm text-gray-500 font-medium">
                    Permintaan Pending
                </p>
                <p class="text-3xl font-bold text-gray-900 leading-tight mt-1">
                    {{ $data['permintaan_pending'] }}
                </p>
            </div>

        </div>

        <div class="pt-4 mt-4 border-t border-gray-100">
            <div class="flex items-center justify-between text-sm font-medium text-orange-600">
                <span>Admin only</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5l7 7-7 7"/>
                </svg>
            </div>
        </div>

    </div>

</div>


    <!-- Two Column Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Absensi Terbaru -->
        <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-shadow duration-300 border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-blue-500 to-cyan-500 px-6 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                        <h2 class="text-lg font-semibold text-white">Absensi Terbaru</h2>
                    </div>
                    <a href="{{ route('koordinator.monitoring.absensi') }}" class="text-sm text-white/90 hover:text-white font-medium flex items-center space-x-1">
                        <span>View All</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            </div>
            <div class="p-6">
                @if($data['absensi_terbaru']->count() > 0)
                    <div class="space-y-3">
                        @foreach($data['absensi_terbaru'] as $absensi)
                            <div class="flex items-center justify-between p-4 bg-gradient-to-r from-gray-50 to-blue-50 rounded-xl hover:from-blue-50 hover:to-blue-100 transition-all border border-blue-100">
                                <div class="flex items-center space-x-3">
                                    <div class="w-12 h-12 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center flex-shrink-0 shadow-lg">
                                        <span class="text-white font-bold text-sm">{{ substr($absensi->csProfile->user->name, 0, 1) }}</span>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-gray-900">{{ $absensi->csProfile->user->name }}</p>
                                        <p class="text-xs text-gray-600 flex items-center space-x-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                            </svg>
                                            <span>{{ $absensi->area->nama_area }}</span>
                                        </p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-bold text-gray-900 mb-1">{{ $absensi->jam_absen }}</p>
                                    @if($absensi->status === 'hadir')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700 border border-green-200">
                                            ✓ Hadir
                                        </span>
                                    @elseif($absensi->status === 'izin')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-700 border border-yellow-200">
                                            ⓘ Izin
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700 border border-red-200">
                                            ✕ Sakit
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <div class="w-20 h-20 mx-auto mb-4 bg-gray-100 rounded-full flex items-center justify-center">
                            <svg class="h-10 w-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                        <p class="text-sm font-medium text-gray-900 mb-1">No attendance yet</p>
                        <p class="text-xs text-gray-500">Belum ada absensi hari ini</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Laporan Terbaru -->
        <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-shadow duration-300 border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-green-500 to-teal-500 px-6 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <h2 class="text-lg font-semibold text-white">Laporan Terbaru</h2>
                    </div>
                    <a href="{{ route('koordinator.monitoring.laporan') }}" class="text-sm text-white/90 hover:text-white font-medium flex items-center space-x-1">
                        <span>View All</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            </div>
            <div class="p-6">
                @if($data['laporan_terbaru']->count() > 0)
                    <div class="space-y-3">
                        @foreach($data['laporan_terbaru'] as $laporan)
                            <div class="flex items-start p-4 bg-gradient-to-r from-gray-50 to-green-50 rounded-xl hover:from-green-50 hover:to-green-100 transition-all border border-green-100">
                                <div class="w-12 h-12 bg-gradient-to-br from-green-400 to-green-600 rounded-full flex items-center justify-center flex-shrink-0 shadow-lg">
                                    <span class="text-white font-bold text-sm">{{ substr($laporan->csProfile->user->name, 0, 1) }}</span>
                                </div>
                                <div class="ml-3 flex-1">
                                    <p class="text-sm font-semibold text-gray-900">{{ $laporan->atm->nama_atm }}</p>
                                    <p class="text-xs text-gray-600 flex items-center space-x-1 mt-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        </svg>
                                        <span>{{ $laporan->atm->area->nama_area }}</span>
                                    </p>
                                    <p class="text-xs text-gray-500 mt-1 flex items-center space-x-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                        <span>{{ $laporan->csProfile->user->name }}</span>
                                    </p>
                                </div>
                                <div class="text-right">
                                    <div class="px-2 py-1 bg-white rounded-lg shadow-sm">
                                        <p class="text-xs font-semibold text-gray-900">{{ $laporan->created_at->format('H:i') }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <div class="w-20 h-20 mx-auto mb-4 bg-gray-100 rounded-full flex items-center justify-center">
                            <svg class="h-10 w-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <p class="text-sm font-medium text-gray-900 mb-1">No reports yet</p>
                        <p class="text-xs text-gray-500">Belum ada laporan hari ini</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
  <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
    <div class="bg-gradient-to-r from-purple-500 to-pink-500 px-6 py-4">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                </svg>
            </div>
            <h2 class="text-lg font-semibold text-white">Quick Actions</h2>
        </div>
    </div>
    <div class="p-4 sm:p-6">
        <div class="grid grid-cols-2 gap-3 sm:gap-4">

            <a href="{{ route('koordinator.monitoring.absensi') }}" class="group flex flex-col sm:flex-row items-center sm:items-center p-3 sm:p-5 border-2 border-gray-200 rounded-xl hover:border-blue-500 hover:bg-blue-50 transition-all duration-300">
                <div class="w-10 h-10 sm:w-14 sm:h-14 bg-gradient-to-br from-blue-400 to-blue-600 rounded-lg sm:rounded-xl flex items-center justify-center mb-2 sm:mb-0 sm:mr-4 shadow-lg group-hover:scale-110 transition-transform">
                    <svg class="h-5 w-5 sm:h-7 sm:w-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                    </svg>
                </div>
                <div class="flex-1 text-center sm:text-left">
                    <span class="text-xs sm:text-base font-semibold text-gray-900 group-hover:text-blue-600 transition leading-tight block">Absensi</span>
                    <p class="hidden sm:block text-sm text-gray-500 mt-1">Lihat daftar absensi CS</p>
                </div>
                <svg class="hidden sm:block w-5 h-5 text-gray-400 group-hover:text-blue-500 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>

            <a href="{{ route('koordinator.monitoring.laporan') }}" class="group flex flex-col sm:flex-row items-center sm:items-center p-3 sm:p-5 border-2 border-gray-200 rounded-xl hover:border-green-500 hover:bg-green-50 transition-all duration-300">
                <div class="w-10 h-10 sm:w-14 sm:h-14 bg-gradient-to-br from-green-400 to-green-600 rounded-lg sm:rounded-xl flex items-center justify-center mb-2 sm:mb-0 sm:mr-4 shadow-lg group-hover:scale-110 transition-transform">
                    <svg class="h-5 w-5 sm:h-7 sm:w-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <div class="flex-1 text-center sm:text-left">
                    <span class="text-xs sm:text-base font-semibold text-gray-900 group-hover:text-green-600 transition leading-tight block">Laporan</span>
                    <p class="hidden sm:block text-sm text-gray-500 mt-1">Laporan pembersihan</p>
                </div>
                <svg class="hidden sm:block w-5 h-5 text-gray-400 group-hover:text-green-500 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>

        </div>
    </div>
</div>
</div>
@endsection
