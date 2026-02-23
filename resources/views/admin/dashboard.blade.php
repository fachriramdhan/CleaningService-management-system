@extends('layouts.app-dashboard')

@section('title', 'Dashboard Admin')

@section('nav-links')
    <a href="{{ route('admin.dashboard') }}"
       class="px-4 py-2 rounded-xl text-sm font-bold bg-gradient-to-r from-blue-500 to-indigo-600 text-white shadow-md hover:shadow-lg transition-all">
        Dashboard
    </a>
    <a href="{{ route('admin.cs.index') }}"
       class="px-4 py-2 rounded-xl text-sm font-semibold text-gray-600 hover:text-blue-600 hover:bg-blue-50 transition-all">
        Team CS
    </a>
    <a href="{{ route('admin.area.index') }}"
       class="px-4 py-2 rounded-xl text-sm font-semibold text-gray-600 hover:text-blue-600 hover:bg-blue-50 transition-all">
         Area
    </a>
    <a href="{{ route('admin.atm.index') }}"
       class="px-4 py-2 rounded-xl text-sm font-semibold text-gray-600 hover:text-blue-600 hover:bg-blue-50 transition-all">
         ATM
    </a>
    <a href="{{ route('admin.inventory.index') }}"
       class="px-4 py-2 rounded-xl text-sm font-semibold text-gray-600 hover:text-blue-600 hover:bg-blue-50 transition-all">
        Inventory
    </a>
    <a href="{{ route('admin.permintaan.index') }}"
       class="px-4 py-2 rounded-xl text-sm font-semibold text-gray-600 hover:text-blue-600 hover:bg-blue-50 transition-all">
        Permintaan
    </a>
    <a href="{{ route('admin.monitoring.laporan') }}"
       class="px-4 py-2 rounded-xl text-sm font-semibold text-gray-600 hover:text-blue-600 hover:bg-blue-50 transition-all">
        Monitoring
    </a>
@endsection

@section('mobile-nav-links')
    <a href="{{ route('admin.dashboard') }}"
       class="block px-4 py-3 rounded-xl text-base font-bold bg-gradient-to-r from-blue-500 to-indigo-600 text-white mb-2">
        Dashboard
    </a>
    <a href="{{ route('admin.cs.index') }}"
       class="block px-4 py-3 rounded-xl text-base font-semibold text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-all mb-2">
        Kelola CS
    </a>
    <a href="{{ route('admin.area.index') }}"
       class="block px-4 py-3 rounded-xl text-base font-semibold text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-all mb-2">
        Kelola Area
    </a>
    <a href="{{ route('admin.atm.index') }}"
       class="block px-4 py-3 rounded-xl text-base font-semibold text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-all mb-2">
        Kelola ATM
    </a>
    <a href="{{ route('admin.inventory.index') }}"
       class="block px-4 py-3 rounded-xl text-base font-semibold text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-all mb-2">
        Inventory
    </a>
    <a href="{{ route('admin.permintaan.index') }}"
       class="block px-4 py-3 rounded-xl text-base font-semibold text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-all mb-2">
        Permintaan
    </a>
    <a href="{{ route('admin.monitoring.laporan') }}"
       class="block px-4 py-3 rounded-xl text-base font-semibold text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-all mb-2">
        Monitoring
    </a>
@endsection

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

    <!-- ── HEADER ── -->
    <div class="mb-8">
        <h1 class="text-3xl md:text-4xl font-bold bg-gradient-to-r from-violet-600 to-indigo-600 bg-clip-text text-transparent">
            👑 Dashboard Admin
        </h1>
        <p class="mt-2 text-gray-600 flex items-center space-x-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            <span>{{ now()->format('l, d F Y') }}</span>
        </p>
    </div>

    <!-- ── ALERT BANNER: STOK RENDAH ── -->
    @if($data['stok_rendah'] > 0)
        <div class="mb-4 bg-gradient-to-r from-yellow-400 to-orange-500 rounded-2xl shadow-lg p-4 text-white">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="h-5 w-5 text-white" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div>
                        <p class="font-bold text-sm">⚠️ Stok Rendah!</p>
                        <p class="text-white/80 text-xs">{{ $data['stok_rendah'] }} item inventory perlu segera diisi ulang</p>
                    </div>
                </div>
                <a href="{{ route('admin.inventory.index') }}"
                   class="inline-flex items-center px-4 py-2 bg-white text-orange-600 rounded-xl text-xs font-bold hover:bg-orange-50 transition shadow self-start sm:self-auto">
                    Lihat Inventory →
                </a>
            </div>
        </div>
    @endif

    <!-- ── ALERT BANNER: PERMINTAAN PENDING ── -->
    @if($data['permintaan_pending'] > 0)
        <div class="mb-6 bg-gradient-to-r from-orange-500 to-pink-500 rounded-2xl shadow-lg p-4 text-white">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="h-5 w-5 text-white" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div>
                        <p class="font-bold text-sm">📋 Permintaan Menunggu!</p>
                        <p class="text-white/80 text-xs">{{ $data['permintaan_pending'] }} permintaan inventory belum diproses</p>
                    </div>
                </div>
                <a href="{{ route('admin.permintaan.index') }}"
                   class="inline-flex items-center px-4 py-2 bg-white text-pink-600 rounded-xl text-xs font-bold hover:bg-pink-50 transition shadow self-start sm:self-auto">
                    Proses Sekarang →
                </a>
            </div>
        </div>
    @endif

    <!-- ── STATS ROW 1: 4 CARDS ── -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-6">

        <!-- CS Aktif -->
        <div class="group bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden hover:shadow-xl transition-shadow">
            <div class="p-5 md:p-6">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-11 h-11 bg-gradient-to-br from-blue-400 to-blue-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                        <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                    <span class="hidden sm:inline-flex px-2 py-0.5 bg-blue-100 text-blue-700 text-xs font-bold rounded-full">Active</span>
                </div>
                <p class="text-2xl md:text-3xl font-black text-gray-900">{{ $data['total_cs_aktif'] }}</p>
                <p class="text-xs text-gray-500 mt-1 font-medium">CS Aktif</p>
            </div>
            <div class="px-5 pb-3">
                <a href="{{ route('admin.cs.index') }}" class="text-xs text-blue-600 font-semibold hover:underline">Kelola CS →</a>
            </div>
        </div>

        <!-- Total Area -->
        <div class="group bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden hover:shadow-xl transition-shadow">
            <div class="p-5 md:p-6">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-11 h-11 bg-gradient-to-br from-green-400 to-teal-500 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                        <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <span class="hidden sm:inline-flex px-2 py-0.5 bg-green-100 text-green-700 text-xs font-bold rounded-full">Area</span>
                </div>
                <p class="text-2xl md:text-3xl font-black text-gray-900">{{ $data['total_area'] }}</p>
                <p class="text-xs text-gray-500 mt-1 font-medium">Total Area</p>
            </div>
            <div class="px-5 pb-3">
                <a href="{{ route('admin.area.index') }}" class="text-xs text-green-600 font-semibold hover:underline">Kelola Area →</a>
            </div>
        </div>

        <!-- Total ATM -->
        <div class="group bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden hover:shadow-xl transition-shadow">
            <div class="p-5 md:p-6">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-11 h-11 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                        <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                    <span class="hidden sm:inline-flex px-2 py-0.5 bg-yellow-100 text-yellow-700 text-xs font-bold rounded-full">ATM</span>
                </div>
                <p class="text-2xl md:text-3xl font-black text-gray-900">{{ $data['total_atm'] }}</p>
                <p class="text-xs text-gray-500 mt-1 font-medium">Total ATM</p>
            </div>
            <div class="px-5 pb-3">
                <a href="{{ route('admin.atm.index') }}" class="text-xs text-yellow-600 font-semibold hover:underline">Kelola ATM →</a>
            </div>
        </div>

        <!-- Absensi Hari Ini -->
        <div class="group bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden hover:shadow-xl transition-shadow">
            <div class="p-5 md:p-6">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-11 h-11 bg-gradient-to-br from-purple-400 to-pink-500 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                        <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                        </svg>
                    </div>
                    <span class="hidden sm:inline-flex px-2 py-0.5 bg-purple-100 text-purple-700 text-xs font-bold rounded-full">Today</span>
                </div>
                <p class="text-2xl md:text-3xl font-black text-gray-900">{{ $data['absensi_hari_ini'] }}</p>
                <p class="text-xs text-gray-500 mt-1 font-medium">Absensi Hari Ini</p>
            </div>
            <div class="px-5 pb-3">
                <a href="{{ route('admin.monitoring.absensi') }}" class="text-xs text-purple-600 font-semibold hover:underline">Lihat semua →</a>
            </div>
        </div>
    </div>

    <!-- ── STATS ROW 2: 3 CARDS ── -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-6 mb-8">

        <!-- Laporan Hari Ini -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-5 md:p-6 flex items-center justify-between hover:shadow-xl transition-shadow">
            <div>
                <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Laporan Hari Ini</p>
                <p class="text-3xl font-black text-gray-900 mt-1">{{ $data['laporan_hari_ini'] }}</p>
                <a href="{{ route('admin.monitoring.laporan') }}" class="text-xs text-blue-600 font-semibold hover:underline mt-1 inline-block">Lihat semua →</a>
            </div>
            <div class="w-14 h-14 bg-gradient-to-br from-blue-100 to-indigo-100 rounded-2xl flex items-center justify-center">
                <svg class="h-7 w-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            </div>
        </div>

        <!-- Permintaan Pending -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-5 md:p-6 flex items-center justify-between hover:shadow-xl transition-shadow">
            <div>
                <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Permintaan Pending</p>
                <p class="text-3xl font-black text-gray-900 mt-1">{{ $data['permintaan_pending'] }}</p>
                <a href="{{ route('admin.permintaan.index') }}" class="text-xs text-orange-600 font-semibold hover:underline mt-1 inline-block">Proses →</a>
            </div>
            <div class="w-14 h-14 bg-gradient-to-br from-orange-100 to-red-100 rounded-2xl flex items-center justify-center">
                <svg class="h-7 w-7 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>

        <!-- Stok Rendah -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-5 md:p-6 flex items-center justify-between hover:shadow-xl transition-shadow">
            <div>
                <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Item Stok Rendah</p>
                <p class="text-3xl font-black {{ $data['stok_rendah'] > 0 ? 'text-red-600' : 'text-gray-900' }} mt-1">{{ $data['stok_rendah'] }}</p>
                <a href="{{ route('admin.inventory.index') }}" class="text-xs text-red-600 font-semibold hover:underline mt-1 inline-block">Cek Inventory →</a>
            </div>
            <div class="w-14 h-14 bg-gradient-to-br from-red-100 to-pink-100 rounded-2xl flex items-center justify-center">
                <svg class="h-7 w-7 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- ── LAPORAN + ABSENSI 2 COLUMN ── -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">

        <!-- Laporan Terbaru -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-blue-500 to-indigo-600 px-6 py-4 flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-9 h-9 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <h2 class="text-base font-bold text-white">📄 Laporan Terbaru</h2>
                </div>
                <a href="{{ route('admin.monitoring.laporan') }}" class="text-white/80 hover:text-white text-xs font-semibold transition">Lihat Semua →</a>
            </div>
            <div class="p-5">
                @if($data['laporan_terbaru']->count() > 0)
                    <div class="space-y-3">
                        @foreach($data['laporan_terbaru'] as $laporan)
                            <div class="flex items-center space-x-3 p-3 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl border border-blue-100 hover:border-blue-300 transition group">
                                <div class="w-10 h-10 bg-gradient-to-br from-blue-400 to-indigo-500 rounded-full flex items-center justify-center flex-shrink-0 shadow">
                                    <span class="text-white font-bold text-sm">{{ substr($laporan->csProfile->user->name, 0, 1) }}</span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-bold text-gray-900 truncate">{{ $laporan->csProfile->user->name }}</p>
                                    <p class="text-xs text-gray-600 truncate">🏧 {{ $laporan->atm->nama_atm }} · {{ $laporan->atm->area->nama_area }}</p>
                                    <p class="text-xs text-gray-400">{{ $laporan->created_at->diffForHumans() }}</p>
                                </div>
                                <a href="{{ route('admin.monitoring.detail-laporan', $laporan->id) }}"
                                   class="flex-shrink-0 px-3 py-1.5 bg-blue-500 text-white rounded-lg text-xs font-semibold hover:bg-blue-600 transition">
                                    Detail
                                </a>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-10">
                        <div class="w-16 h-16 mx-auto mb-3 bg-gradient-to-br from-blue-100 to-indigo-100 rounded-full flex items-center justify-center">
                            <svg class="h-8 w-8 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <p class="text-sm font-bold text-gray-700">Belum ada laporan hari ini</p>
                        <p class="text-xs text-gray-500 mt-1">Laporan CS akan muncul di sini</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Absensi Hari Ini -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-green-500 to-teal-500 px-6 py-4 flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-9 h-9 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                        </svg>
                    </div>
                    <h2 class="text-base font-bold text-white">✅ Absensi Hari Ini</h2>
                </div>
                <a href="{{ route('admin.monitoring.absensi') }}" class="text-white/80 hover:text-white text-xs font-semibold transition">Lihat Semua →</a>
            </div>
            <div class="p-5">
                @if($data['absensi_terbaru']->count() > 0)
                    <div class="space-y-3">
                        @foreach($data['absensi_terbaru'] as $absensi)
                            <div class="flex items-center justify-between p-3 bg-gradient-to-r from-green-50 to-teal-50 rounded-xl border border-green-100 hover:border-green-300 transition">
                                <div class="flex items-center space-x-3">
                                    <img src="{{ asset('storage/' . $absensi->foto_wajah) }}"
                                         alt="{{ $absensi->csProfile->user->name }}"
                                         class="w-10 h-10 rounded-full object-cover border-2 border-green-300 shadow flex-shrink-0"
                                         onerror="this.onerror=null;this.src='https://ui-avatars.com/api/?name={{ urlencode($absensi->csProfile->user->name) }}&size=40&background=10b981&color=fff'">
                                    <div>
                                        <p class="text-sm font-bold text-gray-900">{{ $absensi->csProfile->user->name }}</p>
                                        <p class="text-xs text-gray-500">📍 {{ $absensi->area->nama_area }} · 🕐 {{ $absensi->jam_absen }}</p>
                                    </div>
                                </div>
                                @if($absensi->status === 'hadir')
                                    <span class="px-2.5 py-1 inline-flex items-center text-xs font-bold rounded-full bg-gradient-to-r from-green-100 to-teal-100 text-green-800 border border-green-200 flex-shrink-0">
                                        <span class="w-1.5 h-1.5 bg-green-500 rounded-full mr-1.5 animate-pulse"></span>Hadir
                                    </span>
                                @elseif($absensi->status === 'izin')
                                    <span class="px-2.5 py-1 inline-flex items-center text-xs font-bold rounded-full bg-yellow-100 text-yellow-800 border border-yellow-200 flex-shrink-0">
                                        <span class="w-1.5 h-1.5 bg-yellow-500 rounded-full mr-1.5"></span>Izin
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 inline-flex items-center text-xs font-bold rounded-full bg-red-100 text-red-800 border border-red-200 flex-shrink-0">
                                        <span class="w-1.5 h-1.5 bg-red-500 rounded-full mr-1.5"></span>Sakit
                                    </span>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-10">
                        <div class="w-16 h-16 mx-auto mb-3 bg-gradient-to-br from-green-100 to-teal-100 rounded-full flex items-center justify-center">
                            <svg class="h-8 w-8 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                        <p class="text-sm font-bold text-gray-700">Belum ada absensi hari ini</p>
                        <p class="text-xs text-gray-500 mt-1">Data absensi CS akan muncul di sini</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- ── QUICK ACTIONS ── -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="bg-gradient-to-r from-violet-500 to-purple-600 px-6 py-4">
            <div class="flex items-center space-x-3">
                <div class="w-9 h-9 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <h2 class="text-base font-bold text-white">⚡ Quick Actions</h2>
            </div>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">

                <!-- Tambah CS Baru -->
                <a href="{{ route('admin.cs.create') }}"
                   class="group flex flex-col items-center p-4 md:p-6 border-2 border-blue-300 rounded-2xl hover:bg-blue-50 hover:border-blue-500 hover:scale-105 active:scale-95 transition-all">
                    <div class="w-12 h-12 md:w-14 md:h-14 bg-gradient-to-br from-blue-400 to-blue-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:shadow-blue-200 mb-2 md:mb-3">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                        </svg>
                    </div>
                    <span class="text-xs md:text-sm font-bold text-gray-800 text-center leading-tight">Tambah CS</span>
                </a>

                <!-- Tambah Area -->
                <a href="{{ route('admin.area.create') }}"
                   class="group flex flex-col items-center p-4 md:p-6 border-2 border-green-300 rounded-2xl hover:bg-green-50 hover:border-green-500 hover:scale-105 active:scale-95 transition-all">
                    <div class="w-12 h-12 md:w-14 md:h-14 bg-gradient-to-br from-green-400 to-teal-500 rounded-2xl flex items-center justify-center shadow-lg group-hover:shadow-green-200 mb-2 md:mb-3">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                    </div>
                    <span class="text-xs md:text-sm font-bold text-gray-800 text-center leading-tight">Tambah Area</span>
                </a>

                <!-- Monitoring Laporan -->
                <a href="{{ route('admin.monitoring.laporan') }}"
                   class="group flex flex-col items-center p-4 md:p-6 border-2 border-yellow-300 rounded-2xl hover:bg-yellow-50 hover:border-yellow-500 hover:scale-105 active:scale-95 transition-all">
                    <div class="w-12 h-12 md:w-14 md:h-14 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-2xl flex items-center justify-center shadow-lg group-hover:shadow-yellow-200 mb-2 md:mb-3">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <span class="text-xs md:text-sm font-bold text-gray-800 text-center leading-tight">Monitoring</span>
                </a>

                <!-- Kelola Inventory -->
                <a href="{{ route('admin.inventory.index') }}"
                   class="group flex flex-col items-center p-4 md:p-6 border-2 border-purple-300 rounded-2xl hover:bg-purple-50 hover:border-purple-500 hover:scale-105 active:scale-95 transition-all">
                    <div class="w-12 h-12 md:w-14 md:h-14 bg-gradient-to-br from-purple-400 to-pink-500 rounded-2xl flex items-center justify-center shadow-lg group-hover:shadow-purple-200 mb-2 md:mb-3">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                    <span class="text-xs md:text-sm font-bold text-gray-800 text-center leading-tight">Inventory</span>
                </a>

            </div>
        </div>
    </div>

</div>
@endsection
