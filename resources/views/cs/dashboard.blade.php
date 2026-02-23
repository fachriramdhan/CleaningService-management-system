@extends('layouts.app-dashboard')

@section('title', 'Dashboard CS')

@section('nav-links')
    <a href="{{ route('cs.dashboard') }}" class="inline-flex items-center px-1 pt-1 border-b-2 border-indigo-400 text-sm font-medium text-gray-900">
        Dashboard
    </a>
    <a href="{{ route('cs.absensi.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300">
        Absensi
    </a>
    <a href="{{ route('cs.laporan.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300">
        Laporan ATM
    </a>
    <a href="{{ route('cs.permintaan.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300">
        Permintaan Alat
    </a>
@endsection

@section('mobile-nav-links')
    <a href="{{ route('cs.dashboard') }}" class="block pl-3 pr-4 py-2 border-l-4 border-indigo-400 text-base font-medium text-indigo-700 bg-indigo-50">
        Dashboard
    </a>
    <a href="{{ route('cs.absensi.index') }}" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300">
        Absensi
    </a>
    <a href="{{ route('cs.laporan.index') }}" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300">
        Laporan ATM
    </a>
    <a href="{{ route('cs.permintaan.index') }}" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300">
        Permintaan Alat
    </a>
@endsection

@section('content')
@php $csProfile = auth()->user()->csProfile; @endphp
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

    <!-- ── PAGE HEADER ── -->
    <div class="mb-8">
        <h1 class="text-3xl md:text-4xl font-bold bg-gradient-to-r from-green-600 to-teal-600 bg-clip-text text-transparent">
            👋 Hey, {{ explode(' ', auth()->user()->name)[0] }}!
        </h1>
        <p class="mt-2 text-gray-600 flex items-center space-x-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            <span>{{ now()->format('l, d F Y') }}</span>
        </p>
    </div>

    <!-- ── STATUS ABSENSI BANNER ── -->
    @if(!$data['sudah_absen'])
        <div class="mb-6 bg-gradient-to-r from-yellow-400 to-orange-500 rounded-2xl shadow-lg p-5 text-white">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="h-6 w-6 text-white" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div>
                        <p class="font-bold text-base">Belum Absen Hari Ini! ⚠️</p>
                        <p class="text-white/80 text-sm mt-0.5">Absen dulu sebelum membuat laporan ya~</p>
                    </div>
                </div>
                <a href="{{ route('cs.absensi.create') }}"
                   class="inline-flex items-center justify-center px-5 py-2.5 bg-white text-orange-600 rounded-xl font-bold text-sm hover:bg-orange-50 transition shadow-lg space-x-2 self-start sm:self-auto">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>Absen Sekarang</span>
                </a>
            </div>
        </div>
    @else
        <div class="mb-6 bg-gradient-to-r from-green-400 to-teal-500 rounded-2xl shadow-lg p-5 text-white">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg class="h-6 w-6 text-white" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div>
                    <p class="font-bold text-base">Sudah Absen Hari Ini! ✅</p>
                    <p class="text-white/80 text-sm mt-0.5">
                        Jam masuk: <strong>{{ $data['absensi_hari_ini']->jam_absen ?? '-' }}</strong>
                        · Area: <strong>{{ $data['absensi_hari_ini']->area->nama_area ?? '-' }}</strong>
                    </p>
                </div>
            </div>
        </div>
    @endif

    <!-- ── STATS CARDS ── -->
    <div class="grid grid-cols-3 gap-3 sm:gap-4 md:gap-6 mb-8">

        <!-- Area Tugas -->
        <div class="group bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden hover:shadow-xl transition-shadow">
            <div class="p-4 md:p-6">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-blue-400 to-blue-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                        <svg class="h-5 w-5 md:h-6 md:w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <span class="hidden sm:inline-flex px-2 py-0.5 bg-blue-100 text-blue-700 text-xs font-bold rounded-full">Area</span>
                </div>
                <p class="text-2xl md:text-3xl font-black text-gray-900">{{ $data['area_tugas']->count() }}</p>
                <p class="text-xs text-gray-500 mt-1 font-medium">Area Tugas</p>
            </div>
            <div class="px-4 pb-3">
                <a href="#area-section" class="text-xs text-blue-600 font-semibold hover:underline">Lihat area →</a>
            </div>
        </div>

        <!-- Laporan Bulan Ini -->
        <div class="group bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden hover:shadow-xl transition-shadow">
            <div class="p-4 md:p-6">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-green-400 to-teal-500 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                        <svg class="h-5 w-5 md:h-6 md:w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <span class="hidden sm:inline-flex px-2 py-0.5 bg-green-100 text-green-700 text-xs font-bold rounded-full">Bulan</span>
                </div>
                <p class="text-2xl md:text-3xl font-black text-gray-900">{{ $data['laporan_bulan_ini'] }}</p>
                <p class="text-xs text-gray-500 mt-1 font-medium">Laporan Bulan Ini</p>
            </div>
            <div class="px-4 pb-3">
                <a href="{{ route('cs.laporan.index') }}" class="text-xs text-green-600 font-semibold hover:underline">Lihat semua →</a>
            </div>
        </div>

        <!-- Laporan Hari Ini -->
        <div class="group bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden hover:shadow-xl transition-shadow">
            <div class="p-4 md:p-6">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-purple-400 to-pink-500 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                        <svg class="h-5 w-5 md:h-6 md:w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"/>
                        </svg>
                    </div>
                    <span class="hidden sm:inline-flex px-2 py-0.5 bg-purple-100 text-purple-700 text-xs font-bold rounded-full">Today</span>
                </div>
                <p class="text-2xl md:text-3xl font-black text-gray-900">{{ $data['laporan_hari_ini'] }}</p>
                <p class="text-xs text-gray-500 mt-1 font-medium">Laporan Hari Ini</p>
            </div>
            <div class="px-4 pb-3">
                <a href="{{ route('cs.laporan.index') }}" class="text-xs text-purple-600 font-semibold hover:underline">Detail →</a>
            </div>
        </div>
    </div>

    <!-- ── PROFILE + AREA GRID ── -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">

        <!-- Profil Saya -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-green-500 to-teal-500 px-6 py-4">
                <div class="flex items-center space-x-3">
                    <div class="w-9 h-9 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <h2 class="text-base font-bold text-white">👤 Profil Saya</h2>
                </div>
            </div>
            <div class="p-6">
                @php
                    $fotoUrl = $csProfile->foto === 'default-avatar.png'
                        ? 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&size=128&background=10b981&color=fff'
                        : asset('storage/' . $csProfile->foto);
                @endphp
                <!-- Avatar + Name -->
                <div class="flex items-center space-x-4 mb-5 p-3 bg-gradient-to-r from-green-50 to-teal-50 rounded-xl border border-green-100">
                    <img src="{{ $fotoUrl }}"
                         alt="{{ auth()->user()->name }}"
                         class="w-16 h-16 rounded-full object-cover border-3 border-green-300 shadow-lg ring-2 ring-green-400">
                    <div>
                        <h3 class="text-base font-bold text-gray-900">{{ auth()->user()->name }}</h3>
                        <p class="text-xs text-gray-500">{{ auth()->user()->email }}</p>
                        @if($csProfile->is_active)
                            <span class="inline-flex items-center mt-1 px-2 py-0.5 rounded-full text-xs font-bold bg-gradient-to-r from-green-100 to-teal-100 text-green-800 border border-green-200">
                                <span class="w-1.5 h-1.5 bg-green-500 rounded-full mr-1.5 animate-pulse"></span>
                                Aktif
                            </span>
                        @else
                            <span class="inline-flex items-center mt-1 px-2 py-0.5 rounded-full text-xs font-bold bg-red-100 text-red-800 border border-red-200">
                                <span class="w-1.5 h-1.5 bg-red-500 rounded-full mr-1.5"></span>
                                Nonaktif
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Info -->
                <div class="space-y-2">
                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded-xl">
                        <span class="text-xs text-gray-500 font-medium">📅 Mulai Bekerja</span>
                        <span class="text-xs font-bold text-gray-900">{{ $csProfile->tanggal_mulai_kerja->format('d M Y') }}</span>
                    </div>
                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded-xl">
                        <span class="text-xs text-gray-500 font-medium">⏳ Lama Bekerja</span>
                        <span class="text-xs font-bold text-gray-900">{{ $csProfile->hitungLamaKerja() }}</span>
                    </div>
                </div>

                <div class="mt-4">
                    <a href="{{ route('profile.edit') }}"
                       class="flex items-center justify-center space-x-2 w-full px-4 py-2.5 bg-gradient-to-r from-green-500 to-teal-500 text-white rounded-xl text-sm font-semibold hover:from-green-600 hover:to-teal-600 transition shadow">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                        </svg>
                        <span>Edit Profil</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Area Tugas -->
        <div id="area-section" class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-blue-500 to-cyan-500 px-6 py-4">
                <div class="flex items-center space-x-3">
                    <div class="w-9 h-9 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <h2 class="text-base font-bold text-white">📍 Area Tugas</h2>
                </div>
            </div>
            <div class="p-6">
                @if($data['area_tugas']->count() > 0)
                    <div class="space-y-3">
                        @foreach($data['area_tugas'] as $area)
                            <div class="group p-4 bg-gradient-to-r from-blue-50 to-cyan-50 rounded-xl border border-blue-100 hover:border-blue-300 transition-all">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h3 class="text-sm font-bold text-gray-900">{{ $area->nama_area }}</h3>
                                        @if($area->keterangan)
                                            <p class="text-xs text-gray-500 mt-0.5">{{ $area->keterangan }}</p>
                                        @endif
                                    </div>
                                    <span class="px-3 py-1 bg-gradient-to-r from-blue-100 to-cyan-100 text-blue-800 text-xs font-bold rounded-full border border-blue-200">
                                        🏧 {{ $area->atms->count() }} ATM
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-10">
                        <div class="w-16 h-16 mx-auto mb-3 bg-gradient-to-br from-blue-100 to-cyan-100 rounded-full flex items-center justify-center">
                            <svg class="h-8 w-8 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            </svg>
                        </div>
                        <p class="text-sm font-bold text-gray-700">Belum ada area tugas</p>
                        <p class="text-xs text-gray-500 mt-1">Hubungi koordinator untuk penugasan area</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- ── LAPORAN HARI INI ── -->
    @php
        $laporanHariIni = auth()->user()->csProfile->laporanAtms()
            ->whereDate('tanggal', today())
            ->with('atm')
            ->get();
    @endphp
    @if($laporanHariIni->count() > 0)
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden mb-6">
            <div class="bg-gradient-to-r from-purple-500 to-pink-500 px-6 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-9 h-9 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                            </svg>
                        </div>
                        <h2 class="text-base font-bold text-white">📸 Laporan Hari Ini</h2>
                    </div>
                    <span class="px-3 py-1 bg-white/20 backdrop-blur-sm text-white text-xs font-bold rounded-full">
                        {{ $laporanHariIni->count() }} ATM
                    </span>
                </div>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
                    @foreach($laporanHariIni as $laporan)
                        <div class="group bg-gradient-to-br from-gray-50 to-white rounded-2xl border border-gray-200 overflow-hidden hover:shadow-lg hover:border-purple-200 transition-all">
                            <!-- Card Header -->
                            <div class="bg-gradient-to-r from-purple-500 to-pink-500 px-4 py-3 flex items-center justify-between">
                                <div>
                                    <p class="text-white font-bold text-sm truncate max-w-[150px]">{{ $laporan->atm->nama_atm }}</p>
                                    <p class="text-white/70 text-xs">{{ $laporan->atm->lokasi }}</p>
                                </div>
                                <span class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </span>
                            </div>
                            <!-- Foto 3 grid -->
                            <div class="p-3 grid grid-cols-3 gap-2">
                                <div class="aspect-square rounded-xl overflow-hidden border border-red-200 relative">
                                    <img src="{{ asset('storage/' . $laporan->foto_sebelum) }}" alt="Sebelum" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                    <span class="absolute bottom-0 inset-x-0 bg-black/50 text-white text-center text-[9px] font-bold py-0.5">Sebelum</span>
                                </div>
                                <div class="aspect-square rounded-xl overflow-hidden border border-green-200 relative">
                                    <img src="{{ asset('storage/' . $laporan->foto_sesudah) }}" alt="Sesudah" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                    <span class="absolute bottom-0 inset-x-0 bg-black/50 text-white text-center text-[9px] font-bold py-0.5">Sesudah</span>
                                </div>
                                <div class="aspect-square rounded-xl overflow-hidden border border-blue-200 relative">
                                    <img src="{{ asset('storage/' . $laporan->foto_lokasi) }}" alt="Lokasi" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                    <span class="absolute bottom-0 inset-x-0 bg-black/50 text-white text-center text-[9px] font-bold py-0.5">Lokasi</span>
                                </div>
                            </div>
                            @if($laporan->catatan)
                                <div class="px-3 pb-3">
                                    <div class="p-2 bg-yellow-50 rounded-lg border border-yellow-200">
                                        <p class="text-xs text-yellow-800">
                                            <span class="font-bold">📝</span> {{ Str::limit($laporan->catatan, 60) }}
                                        </p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    <!-- ── QUICK ACTIONS ── -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="bg-gradient-to-r from-indigo-500 to-purple-600 px-6 py-4">
            <div class="flex items-center space-x-3">
                <div class="w-9 h-9 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <h2 class="text-base font-bold text-white">⚡ Menu Cepat</h2>
            </div>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">

                @if(!$data['sudah_absen'])
                    <!-- Absen Sekarang -->
                    <a href="{{ route('cs.absensi.create') }}"
                       class="group flex flex-col items-center p-4 md:p-6 border-2 border-blue-400 rounded-2xl hover:bg-blue-50 hover:border-blue-500 hover:scale-105 active:scale-95 transition-all">
                        <div class="w-12 h-12 md:w-14 md:h-14 bg-gradient-to-br from-blue-400 to-blue-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:shadow-blue-200 mb-2 md:mb-3">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3M12 4a8 8 0 100 16 8 8 0 000-16z"/>
                            </svg>
                        </div>
                        <span class="text-xs md:text-sm font-bold text-gray-800 text-center leading-tight">Absen Sekarang</span>
                    </a>
                @else
                    <!-- Buat Laporan ATM -->
                    <a href="{{ route('cs.laporan.create') }}"
                       class="group flex flex-col items-center p-4 md:p-6 border-2 border-green-400 rounded-2xl hover:bg-green-50 hover:border-green-500 hover:scale-105 active:scale-95 transition-all">
                        <div class="w-12 h-12 md:w-14 md:h-14 bg-gradient-to-br from-green-400 to-teal-500 rounded-2xl flex items-center justify-center shadow-lg group-hover:shadow-green-200 mb-2 md:mb-3">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                        </div>
                        <span class="text-xs md:text-sm font-bold text-gray-800 text-center leading-tight">Buat Laporan</span>
                    </a>
                @endif

                <!-- Riwayat Absensi -->
                <a href="{{ route('cs.absensi.index') }}"
                   class="group flex flex-col items-center p-4 md:p-6 border-2 border-purple-400 rounded-2xl hover:bg-purple-50 hover:border-purple-500 hover:scale-105 active:scale-95 transition-all">
                    <div class="w-12 h-12 md:w-14 md:h-14 bg-gradient-to-br from-purple-400 to-purple-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:shadow-purple-200 mb-2 md:mb-3">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3M3 11h18M5 5h14a2 2 0 012 2v12a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2z"/>
                        </svg>
                    </div>
                    <span class="text-xs md:text-sm font-bold text-gray-800 text-center leading-tight">Riwayat Absensi</span>
                </a>

                <!-- Riwayat Laporan -->
                <a href="{{ route('cs.laporan.index') }}"
                   class="group flex flex-col items-center p-4 md:p-6 border-2 border-orange-400 rounded-2xl hover:bg-orange-50 hover:border-orange-500 hover:scale-105 active:scale-95 transition-all">
                    <div class="w-12 h-12 md:w-14 md:h-14 bg-gradient-to-br from-orange-400 to-orange-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:shadow-orange-200 mb-2 md:mb-3">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6M7 4h6l4 4v12a2 2 0 01-2 2H7a2 2 0 01-2-2V6a2 2 0 012-2z"/>
                        </svg>
                    </div>
                    <span class="text-xs md:text-sm font-bold text-gray-800 text-center leading-tight">Riwayat Laporan</span>
                </a>

                <!-- Permintaan -->
                <a href="{{ route('cs.permintaan.index') }}"
                   class="group flex flex-col items-center p-4 md:p-6 border-2 border-teal-400 rounded-2xl hover:bg-teal-50 hover:border-teal-500 hover:scale-105 active:scale-95 transition-all">
                    <div class="w-12 h-12 md:w-14 md:h-14 bg-gradient-to-br from-teal-400 to-teal-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:shadow-teal-200 mb-2 md:mb-3">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M5 7v10a2 2 0 002 2h10a2 2 0 002-2V7M9 11h6"/>
                        </svg>
                    </div>
                    <span class="text-xs md:text-sm font-bold text-gray-800 text-center leading-tight">Permintaan</span>
                </a>

            </div>
        </div>
    </div>
</div>
@endsection
