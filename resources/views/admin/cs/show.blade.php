@extends('layouts.app-dashboard')

@section('title', 'Detail CS')

@section('nav-links')
    <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium text-gray-500 hover:text-gray-700">Dashboard</a>
    <a href="{{ route('admin.cs.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 border-indigo-400 text-sm font-medium text-gray-900">Kelola CS</a>
@endsection

@section('mobile-nav-links')
    <a href="{{ route('admin.dashboard') }}" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50">Dashboard</a>
    <a href="{{ route('admin.cs.index') }}" class="block pl-3 pr-4 py-2 border-l-4 border-indigo-400 text-base font-medium text-indigo-700 bg-indigo-50">Kelola CS</a>
@endsection

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

    <!-- Header -->
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-3xl md:text-4xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">
                👤 Detail Cleaning Service
            </h1>
            <p class="mt-2 text-gray-600">Informasi lengkap tentang {{ $csProfile->user->name }}</p>
        </div>
        <div class="flex flex-col sm:flex-row gap-2 self-start">
            <a href="{{ route('admin.cs.edit', $csProfile->id) }}"
               class="inline-flex items-center justify-center px-5 py-2.5 bg-gradient-to-r from-yellow-500 to-orange-500 text-white rounded-xl font-semibold hover:from-yellow-600 hover:to-orange-600 transition shadow-lg space-x-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                <span>Edit</span>
            </a>
            <a href="{{ route('admin.cs.index') }}"
               class="inline-flex items-center justify-center px-5 py-2.5 bg-gradient-to-r from-gray-600 to-gray-700 text-white rounded-xl font-semibold hover:from-gray-700 hover:to-gray-800 transition shadow-lg space-x-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span>Kembali</span>
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- LEFT: Profil CS Card -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-blue-500 to-indigo-600 px-6 py-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-9 h-9 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <h2 class="text-base font-bold text-white">Profil CS</h2>
                    </div>
                </div>

                <div class="p-6">
                    <div class="text-center mb-6">
                        <img src="{{ $csProfile->foto === 'default-avatar.png' ? 'https://ui-avatars.com/api/?name=' . urlencode($csProfile->user->name) . '&size=200&background=3b82f6&color=fff' : asset('storage/' . $csProfile->foto) }}"
                             alt="{{ $csProfile->user->name }}"
                             class="w-28 h-28 rounded-full mx-auto object-cover border-4 border-blue-300 shadow-lg ring-4 ring-blue-100">

                        <h2 class="mt-4 text-xl font-bold text-gray-900">{{ $csProfile->user->name }}</h2>
                        <p class="text-sm text-gray-500 mt-1">{{ $csProfile->user->email }}</p>

                        <div class="mt-4">
                            @if($csProfile->is_active)
                                <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-bold bg-gradient-to-r from-green-100 to-teal-100 text-green-800 border-2 border-green-300">
                                    <span class="w-2 h-2 mr-2 bg-green-500 rounded-full animate-pulse"></span>
                                    Aktif
                                </span>
                            @else
                                <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-bold bg-red-100 text-red-800 border-2 border-red-300">
                                    <span class="w-2 h-2 mr-2 bg-red-500 rounded-full"></span>
                                    Nonaktif
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="border-t border-gray-100 pt-5 space-y-3">
                        <div class="p-3 bg-blue-50 rounded-xl border border-blue-100">
                            <p class="text-xs font-bold text-blue-600 uppercase tracking-wider mb-1">📅 Mulai Kerja</p>
                            <p class="text-sm font-bold text-gray-900">{{ $csProfile->tanggal_mulai_kerja->format('d F Y') }}</p>
                        </div>
                        <div class="p-3 bg-indigo-50 rounded-xl border border-indigo-100">
                            <p class="text-xs font-bold text-indigo-600 uppercase tracking-wider mb-1">⏳ Lama Kerja</p>
                            <p class="text-sm font-bold text-gray-900">{{ $csProfile->lama_kerja_tahun }} tahun {{ $csProfile->lama_kerja_bulan }} bulan</p>
                        </div>
                    </div>

                    <div class="border-t border-gray-100 mt-5 pt-5">
                        <p class="text-xs font-bold text-gray-600 uppercase tracking-wider mb-3">📍 Area Tugas</p>
                        <div class="space-y-2">
                            @foreach($csProfile->areas as $area)
                                <div class="flex items-center p-2 bg-blue-50 rounded-xl border border-blue-100">
                                    <svg class="w-4 h-4 text-blue-500 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    </svg>
                                    <span class="text-sm font-semibold text-blue-800">{{ $area->nama_area }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- RIGHT: Statistik & Aktivitas -->
        <div class="lg:col-span-2 space-y-6">

            <!-- Stats Grid -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <!-- Total Absensi -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-4 hover:shadow-xl transition">
                    <div class="flex items-center justify-between mb-2">
                        <div class="w-10 h-10 bg-gradient-to-br from-purple-400 to-purple-600 rounded-xl flex items-center justify-center shadow-lg">
                            <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 font-medium">Total Absensi</p>
                    <p class="text-2xl md:text-3xl font-black text-gray-900">{{ $stats['total_absensi'] }}</p>
                </div>

                <!-- Total Laporan -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-4 hover:shadow-xl transition">
                    <div class="flex items-center justify-between mb-2">
                        <div class="w-10 h-10 bg-gradient-to-br from-green-400 to-teal-500 rounded-xl flex items-center justify-center shadow-lg">
                            <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 font-medium">Total Laporan</p>
                    <p class="text-2xl md:text-3xl font-black text-gray-900">{{ $stats['total_laporan'] }}</p>
                </div>

                <!-- Absensi Bulan Ini -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-4 hover:shadow-xl transition">
                    <div class="flex items-center justify-between mb-2">
                        <div class="w-10 h-10 bg-gradient-to-br from-blue-400 to-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                            <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 font-medium">Absensi Bulan Ini</p>
                    <p class="text-2xl md:text-3xl font-black text-blue-600">{{ $stats['absensi_bulan_ini'] }}</p>
                </div>

                <!-- Laporan Bulan Ini -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-4 hover:shadow-xl transition">
                    <div class="flex items-center justify-between mb-2">
                        <div class="w-10 h-10 bg-gradient-to-br from-orange-400 to-pink-500 rounded-xl flex items-center justify-center shadow-lg">
                            <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                            </svg>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 font-medium">Laporan Bulan Ini</p>
                    <p class="text-2xl md:text-3xl font-black text-green-600">{{ $stats['laporan_bulan_ini'] }}</p>
                </div>
            </div>

            <!-- Riwayat Aktivitas Card -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-indigo-500 to-purple-600 px-6 py-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-9 h-9 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-base font-bold text-white">📊 Riwayat Aktivitas</h3>
                    </div>
                </div>
                <div class="p-8 text-center">
                    <div class="w-20 h-20 mx-auto mb-4 bg-gradient-to-br from-indigo-100 to-purple-100 rounded-full flex items-center justify-center">
                        <svg class="h-10 w-10 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                        </svg>
                    </div>
                    <p class="text-base font-bold text-gray-700">Fitur Segera Hadir</p>
                    <p class="text-sm text-gray-500 mt-1">Riwayat aktivitas detail akan tersedia dalam update berikutnya</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
