@extends('layouts.app-dashboard')

@section('title', 'Detail Area')

@section('nav-links')
    <a href="{{ route('admin.dashboard') }}"
       class="px-4 py-2 rounded-xl text-sm font-semibold text-gray-600 hover:text-blue-600 hover:bg-blue-50 transition-all">
        Dashboard
    </a>
    <a href="{{ route('admin.area.index') }}"
       class="px-4 py-2 rounded-xl text-sm font-bold bg-gradient-to-r from-blue-500 to-indigo-600 text-white shadow-md hover:shadow-lg transition-all">
        Kelola Area
    </a>
@endsection

@section('mobile-nav-links')
    <a href="{{ route('admin.dashboard') }}"
       class="block px-4 py-3 rounded-xl text-base font-semibold text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-all mb-2">
        Dashboard
    </a>
    <a href="{{ route('admin.area.index') }}"
       class="block px-4 py-3 rounded-xl text-base font-bold bg-gradient-to-r from-blue-500 to-indigo-600 text-white mb-2">
        Kelola Area
    </a>
@endsection

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

    <!-- Header -->
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-3xl md:text-4xl font-bold bg-gradient-to-r from-green-600 to-teal-600 bg-clip-text text-transparent">
                📍 {{ $area->nama_area }}
            </h1>
            <p class="mt-2 text-gray-600">Detail informasi area</p>
        </div>
        <div class="flex flex-col sm:flex-row gap-2 self-start">
            <a href="{{ route('admin.area.edit', $area->id) }}"
               class="inline-flex items-center justify-center px-5 py-2.5 bg-gradient-to-r from-yellow-500 to-orange-500 text-white rounded-xl font-semibold hover:from-yellow-600 hover:to-orange-600 transition shadow-lg space-x-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                <span>Edit</span>
            </a>
            <a href="{{ route('admin.area.index') }}"
               class="inline-flex items-center justify-center px-5 py-2.5 bg-gradient-to-r from-gray-600 to-gray-700 text-white rounded-xl font-semibold hover:from-gray-700 hover:to-gray-800 transition shadow-lg space-x-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span>Kembali</span>
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- LEFT: Info Area Card -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-green-500 to-teal-500 px-6 py-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-base font-bold text-white">Informasi Area</h3>
                    </div>
                </div>

                <div class="p-6 space-y-4">
                    <div class="p-3 bg-blue-50 rounded-xl border border-blue-100">
                        <p class="text-xs font-bold text-blue-600 uppercase tracking-wider mb-1">📌 Nama Area</p>
                        <p class="text-sm font-bold text-gray-900">{{ $area->nama_area }}</p>
                    </div>

                    @if($area->keterangan)
                        <div class="p-3 bg-gray-50 rounded-xl border border-gray-200">
                            <p class="text-xs font-bold text-gray-600 uppercase tracking-wider mb-1">📝 Keterangan</p>
                            <p class="text-sm text-gray-700 leading-relaxed">{{ $area->keterangan }}</p>
                        </div>
                    @endif

                    <div class="p-3 bg-gradient-to-br from-gray-50 to-gray-100 rounded-xl border border-gray-200">
                        <p class="text-xs font-bold text-gray-600 uppercase tracking-wider mb-2">⚡ Status</p>
                        @if($area->is_active)
                            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-bold bg-gradient-to-r from-green-100 to-teal-100 text-green-800 border-2 border-green-300">
                                <span class="w-2 h-2 mr-2 bg-green-500 rounded-full animate-pulse"></span>
                                Aktif
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-bold bg-red-100 text-red-800 border-2 border-red-300">
                                <span class="w-2 h-2 mr-2 bg-red-500 rounded-full"></span>
                                Nonaktif
                            </span>
                        @endif
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div class="p-4 bg-blue-50 rounded-xl border border-blue-200 text-center">
                            <svg class="w-8 h-8 mx-auto mb-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                            <p class="text-xs text-blue-600 font-semibold mb-1">Total ATM</p>
                            <p class="text-2xl font-black text-blue-700">{{ $area->atms_count }}</p>
                        </div>
                        <div class="p-4 bg-green-50 rounded-xl border border-green-200 text-center">
                            <svg class="w-8 h-8 mx-auto mb-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                            <p class="text-xs text-green-600 font-semibold mb-1">CS Ditugaskan</p>
                            <p class="text-2xl font-black text-green-700">{{ $area->csProfiles->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- RIGHT: Daftar ATM & CS -->
        <div class="lg:col-span-2 space-y-6">

            <!-- Daftar ATM Card -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-blue-500 to-indigo-600 px-6 py-4 flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-9 h-9 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                        <h3 class="text-base font-bold text-white">🏧 Daftar ATM</h3>
                    </div>
                    <a href="{{ route('admin.atm.create') }}?area_id={{ $area->id }}"
                       class="px-3 py-1.5 bg-white/90 hover:bg-white text-blue-600 rounded-lg text-xs font-bold transition">
                        + Tambah ATM
                    </a>
                </div>

                <div class="p-6">
                    @if($area->atms->count() > 0)
                        <div class="space-y-3">
                            @foreach($area->atms as $atm)
                                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl border border-gray-200 hover:border-blue-300 hover:bg-blue-50 transition">
                                    <div class="flex-1">
                                        <p class="text-sm font-bold text-gray-900">{{ $atm->nama_atm }}</p>
                                        <p class="text-xs text-gray-500 mt-0.5">📍 {{ $atm->lokasi }}</p>
                                    </div>
                                    <div class="flex space-x-2">
                                        <a href="{{ route('admin.atm.show', $atm->id) }}"
                                           class="p-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition"
                                           title="Detail">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                        </a>
                                        <a href="{{ route('admin.atm.edit', $atm->id) }}"
                                           class="p-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition"
                                           title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="w-16 h-16 mx-auto mb-3 bg-gray-100 rounded-full flex items-center justify-center">
                                <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                            </div>
                            <p class="text-sm font-medium text-gray-500">Belum ada ATM di area ini</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Daftar CS Card -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-green-500 to-teal-500 px-6 py-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-9 h-9 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-base font-bold text-white">👤 CS yang Ditugaskan</h3>
                    </div>
                </div>

                <div class="p-6">
                    @if($area->csProfiles->count() > 0)
                        <div class="space-y-3">
                            @foreach($area->csProfiles as $cs)
                                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl border border-gray-200 hover:border-green-300 hover:bg-green-50 transition">
                                    <div class="flex items-center flex-1 min-w-0">
                                        <img src="{{ $cs->foto === 'default-avatar.png' ? 'https://ui-avatars.com/api/?name=' . urlencode($cs->user->name) . '&size=80&background=10b981&color=fff' : asset('storage/' . $cs->foto) }}"
                                             alt="{{ $cs->user->name }}"
                                             class="w-10 h-10 rounded-full object-cover border-2 border-green-300 shadow flex-shrink-0">
                                        <div class="ml-3 flex-1 min-w-0">
                                            <p class="text-sm font-bold text-gray-900 truncate">{{ $cs->user->name }}</p>
                                            <p class="text-xs text-gray-500 truncate">{{ $cs->user->email }}</p>
                                        </div>
                                    </div>
                                    <a href="{{ route('admin.cs.show', $cs->id) }}"
                                       class="ml-3 p-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition flex-shrink-0"
                                       title="Detail">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="w-16 h-16 mx-auto mb-3 bg-gray-100 rounded-full flex items-center justify-center">
                                <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                            </div>
                            <p class="text-sm font-medium text-gray-500">Belum ada CS yang ditugaskan di area ini</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
