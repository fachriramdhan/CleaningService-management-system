@extends('layouts.app-dashboard')

@section('title', 'Kelola Area')

@section('nav-links')
    <a href="{{ route('admin.dashboard') }}"
       class="px-4 py-2 rounded-xl text-sm font-semibold text-gray-600 hover:text-blue-600 hover:bg-blue-50 transition-all">
        Dashboard
    </a>
    <a href="{{ route('admin.cs.index') }}"
       class="px-4 py-2 rounded-xl text-sm font-semibold text-gray-600 hover:text-blue-600 hover:bg-blue-50 transition-all">
        Team CS
    </a>
    <a href="{{ route('admin.area.index') }}"
       class="px-4 py-2 rounded-xl text-sm font-bold bg-gradient-to-r from-blue-500 to-indigo-600 text-white shadow-md hover:shadow-lg transition-all">
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
       class="block px-4 py-3 rounded-xl text-base font-semibold text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-all mb-2">
        Dashboard
    </a>
    <a href="{{ route('admin.cs.index') }}"
       class="block px-4 py-3 rounded-xl text-base font-semibold text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-all mb-2">
        Kelola CS
    </a>
    <a href="{{ route('admin.area.index') }}"
       class="block px-4 py-3 rounded-xl text-base font-bold bg-gradient-to-r from-blue-500 to-indigo-600 text-white mb-2">
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

    <!-- Header -->
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-3xl md:text-4xl font-bold bg-gradient-to-r from-green-600 to-teal-600 bg-clip-text text-transparent">
                📍 Kelola Area
            </h1>
            <p class="mt-2 text-gray-600">Manajemen area tugas cleaning service</p>
        </div>
        <a href="{{ route('admin.area.create') }}"
           class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-green-500 to-teal-500 text-white rounded-xl font-bold hover:from-green-600 hover:to-teal-600 transition shadow-lg hover:shadow-xl space-x-2 self-start">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            <span>Tambah Area</span>
        </a>
    </div>

    <!-- Alerts -->
    @if(session('success'))
        <div class="mb-6 bg-green-50 border-l-4 border-green-400 p-4 rounded-xl flex items-center space-x-3">
            <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center flex-shrink-0">
                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
            </div>
            <p class="text-sm text-green-700 font-medium">{{ session('success') }}</p>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 bg-red-50 border-l-4 border-red-400 p-4 rounded-xl flex items-center space-x-3">
            <div class="w-8 h-8 bg-red-500 rounded-full flex items-center justify-center flex-shrink-0">
                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
            </div>
            <p class="text-sm text-red-700 font-medium">{{ session('error') }}</p>
        </div>
    @endif

    <!-- Grid Cards: 2 cols mobile, 3 cols tablet, 4 cols desktop -->
    <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-4 md:gap-6">
        @forelse($areas as $area)
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden hover:shadow-2xl hover:-translate-y-1 transition-all duration-300">
                <!-- Header Card -->
                <div class="bg-gradient-to-r from-green-500 to-teal-500 px-4 py-3">
                    <div class="flex items-center justify-between">
                        <div class="w-10 h-10 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        @if($area->is_active)
                            <span class="px-2 py-1 bg-white/90 text-green-700 text-xs font-bold rounded-full">✓ Aktif</span>
                        @else
                            <span class="px-2 py-1 bg-white/90 text-red-700 text-xs font-bold rounded-full">✗ Nonaktif</span>
                        @endif
                    </div>
                </div>

                <!-- Body Card -->
                <div class="p-4">
                    <h3 class="text-base font-bold text-gray-900 mb-2 line-clamp-1">{{ $area->nama_area }}</h3>

                    @if($area->keterangan)
                        <p class="text-xs text-gray-500 mb-3 line-clamp-2">{{ $area->keterangan }}</p>
                    @else
                        <p class="text-xs text-gray-400 mb-3 italic">Tidak ada keterangan</p>
                    @endif

                    <!-- Stats Grid -->
                    <div class="grid grid-cols-2 gap-2 mb-4">
                        <div class="p-2 bg-blue-50 rounded-xl border border-blue-100">
                            <div class="flex items-center space-x-1 mb-1">
                                <svg class="w-3 h-3 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                                <span class="text-xs text-blue-600 font-semibold">ATM</span>
                            </div>
                            <p class="text-lg font-black text-blue-700">{{ $area->atms_count }}</p>
                        </div>
                        <div class="p-2 bg-green-50 rounded-xl border border-green-100">
                            <div class="flex items-center space-x-1 mb-1">
                                <svg class="w-3 h-3 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                                <span class="text-xs text-green-600 font-semibold">CS</span>
                            </div>
                            <p class="text-lg font-black text-green-700">{{ $area->cs_profiles_count }}</p>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="grid grid-cols-3 gap-2">
                        <a href="{{ route('admin.area.show', $area->id) }}"
                           class="flex items-center justify-center p-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition"
                           title="Detail">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </a>
                        <a href="{{ route('admin.area.edit', $area->id) }}"
                           class="flex items-center justify-center p-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition"
                           title="Edit">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                        </a>
                        <form action="{{ route('admin.area.destroy', $area->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus area ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="w-full p-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition"
                                    title="Hapus">
                                <svg class="w-4 h-4 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-2 md:col-span-3 xl:col-span-4 bg-white rounded-2xl shadow-lg border border-gray-100 p-12 text-center">
                <div class="w-20 h-20 mx-auto mb-4 bg-gradient-to-br from-green-100 to-teal-100 rounded-full flex items-center justify-center">
                    <svg class="h-10 w-10 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                    </svg>
                </div>
                <h3 class="text-base font-bold text-gray-700 mb-1">Belum ada area</h3>
                <p class="text-sm text-gray-500 mb-5">Mulai dengan menambahkan area baru</p>
                <a href="{{ route('admin.area.create') }}"
                   class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-green-500 to-teal-500 text-white rounded-xl font-bold hover:from-green-600 hover:to-teal-600 transition shadow-lg space-x-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <span>Tambah Area</span>
                </a>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($areas->hasPages())
        <div class="mt-8">
            {{ $areas->links() }}
        </div>
    @endif
</div>
@endsection
