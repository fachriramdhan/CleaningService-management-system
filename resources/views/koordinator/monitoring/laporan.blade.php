@extends('layouts.app-dashboard')

@section('title', 'Monitoring Laporan ATM')

@section('nav-links')
    <a href="{{ route('koordinator.dashboard') }}" class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium text-gray-500 hover:text-gray-700">
        Dashboard
    </a>
    <a href="{{ route('koordinator.monitoring.absensi') }}" class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium text-gray-500 hover:text-gray-700">
        Monitoring Absensi
    </a>
    <a href="{{ route('koordinator.monitoring.laporan') }}" class="inline-flex items-center px-1 pt-1 border-b-2 border-indigo-400 text-sm font-medium text-gray-900">
        Monitoring Laporan
    </a>
    <a href="{{ route('koordinator.permintaan.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium text-gray-500 hover:text-gray-700">
        Permintaan
    </a>
@endsection

@section('mobile-nav-links')
    <a href="{{ route('koordinator.dashboard') }}" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50">
        Dashboard
    </a>
    <a href="{{ route('koordinator.monitoring.absensi') }}" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50">
        Monitoring Absensi
    </a>
    <a href="{{ route('koordinator.monitoring.laporan') }}" class="block pl-3 pr-4 py-2 border-l-4 border-indigo-400 text-base font-medium text-indigo-700 bg-indigo-50">
        Monitoring Laporan
    </a>
    <a href="{{ route('koordinator.permintaan.index') }}" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50">
        Permintaan
    </a>
@endsection

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl md:text-4xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
            🗓️ Monitoring Laporan ATM
        </h1>
        <p class="mt-2 text-gray-600 flex items-center space-x-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
            </svg>
            <span>Pantau laporan pembersihan ATM dari semua CS</span>
        </p>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-2 gap-3 sm:gap-4 md:gap-6 mb-8">

    <!-- Total Laporan -->
    <div class="group bg-white rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 border border-gray-100 p-4 sm:p-6">

        <div class="flex items-start justify-between mb-3">
            <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-gradient-to-br from-indigo-400 to-indigo-600 flex items-center justify-center shadow-md group-hover:scale-105 transition-transform">
                <svg class="h-5 w-5 sm:h-6 sm:w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                    </path>
                </svg>
            </div>

            <span class="px-2 py-1 bg-indigo-50 text-indigo-600 text-[10px] sm:text-xs font-semibold rounded-full">
                Today
            </span>
        </div>

        <p class="text-xs sm:text-sm font-medium text-gray-500 mb-1">
            Total Laporan
        </p>

        <p class="text-xl sm:text-3xl font-bold text-gray-900">
            {{ $summary['total_laporan'] }}
        </p>

        <p class="text-[10px] sm:text-xs text-indigo-600 mt-2 leading-tight">
            Laporan pembersihan hari ini
        </p>
    </div>


    <!-- CS Aktif -->
    <div class="group bg-white rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 border border-gray-100 p-4 sm:p-6">

        <div class="flex items-start justify-between mb-3">
            <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-gradient-to-br from-purple-400 to-purple-600 flex items-center justify-center shadow-md group-hover:scale-105 transition-transform">
                <svg class="h-5 w-5 sm:h-6 sm:w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                    </path>
                </svg>
            </div>

            <span class="px-2 py-1 bg-purple-50 text-purple-600 text-[10px] sm:text-xs font-semibold rounded-full">
                Active
            </span>
        </div>

        <p class="text-xs sm:text-sm font-medium text-gray-500 mb-1">
            CS Aktif Hari Ini
        </p>

        <p class="text-xl sm:text-3xl font-bold text-gray-900">
            {{ $summary['total_cs_aktif'] }}
        </p>

        <p class="text-[10px] sm:text-xs text-purple-600 mt-2 leading-tight">
            Cleaning service yang sudah absen
        </p>
    </div>

</div>


   <!-- Filter Section -->
<div
    x-data="{ open: false }"
    class="mb-6 bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden"
>

    <!-- Header -->
    <div class="bg-gradient-to-r from-indigo-500 to-purple-600 px-6 py-4">
        <div class="flex items-center justify-between">

            <!-- Title -->
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z">
                        </path>
                    </svg>
                </div>
                <h2 class="text-lg font-semibold text-white">Filter Laporan</h2>
            </div>

            <!-- Toggle Button (Mobile Only) -->
            <button
                @click="open = !open"
                class="lg:hidden flex items-center gap-2 bg-white/20 hover:bg-white/30 text-white px-3 py-2 rounded-lg text-sm transition"
            >
                <span x-text="open ? 'Sembunyikan' : 'Tampilkan'"></span>

                <!-- Arrow Icon -->
                <svg
                    class="w-4 h-4 transition-transform duration-300"
                    :class="open ? 'rotate-180' : ''"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>

        </div>
    </div>

    <!-- Form -->
    <div
        x-cloak
        x-show="open || window.innerWidth >= 1024"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 -translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-2"
        class="p-6"
    >
        <form method="GET" action="{{ route('koordinator.monitoring.laporan') }}"
              class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

            <!-- Tanggal -->
            <div>
                <label class="block text-xs font-bold text-gray-600 mb-2 uppercase tracking-wider">
                    📅 Tanggal
                </label>
                <input type="date" name="tanggal"
                    value="{{ request('tanggal', now()->format('Y-m-d')) }}"
                    class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition text-sm">
            </div>

            <!-- CS -->
            <div>
                <label class="block text-xs font-bold text-gray-600 mb-2 uppercase tracking-wider">
                    👤 CS
                </label>
                <select name="cs_profile_id"
                    class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition text-sm">
                    <option value="">Semua CS</option>
                    @foreach($csProfiles as $cs)
                        <option value="{{ $cs->id }}" {{ request('cs_profile_id') == $cs->id ? 'selected' : '' }}>
                            {{ $cs->user->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Area -->
            <div>
                <label class="block text-xs font-bold text-gray-600 mb-2 uppercase tracking-wider">
                    📍 Area
                </label>
                <select name="area_id"
                    class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition text-sm">
                    <option value="">Semua Area</option>
                    @foreach($areas as $area)
                        <option value="{{ $area->id }}" {{ request('area_id') == $area->id ? 'selected' : '' }}>
                            {{ $area->nama_area }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Button -->
            <div class="flex items-end">
                <button type="submit"
                    class="w-full px-6 py-3 bg-gradient-to-r from-indigo-500 to-purple-600 text-white rounded-xl hover:from-indigo-600 hover:to-purple-700 transition font-semibold shadow-lg hover:shadow-xl flex items-center justify-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z">
                        </path>
                    </svg>
                    <span>Cari</span>
                </button>
            </div>

        </form>
    </div>
</div>


    <!-- Laporan Grid Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($laporans as $laporan)
            <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-100 overflow-hidden">

                <!-- Card Header -->
                <div class="bg-gradient-to-r from-indigo-500 to-purple-600 p-4">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <h3 class="text-base font-bold text-white">{{ $laporan->atm->nama_atm }}</h3>
                            <p class="text-white/80 text-xs flex items-center mt-1">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                </svg>
                                {{ $laporan->atm->area->nama_area }}
                            </p>
                        </div>
                        <span class="px-3 py-1 bg-white/20 backdrop-blur-sm text-white text-xs font-bold rounded-full">
                            ✅ Selesai
                        </span>
                    </div>
                </div>

                <!-- CS Info -->
                <div class="px-4 pt-4 pb-3 flex items-center space-x-3 border-b border-gray-100">
                    <div class="w-10 h-10 bg-gradient-to-br from-indigo-400 to-purple-500 rounded-full flex items-center justify-center flex-shrink-0">
                        <span class="text-white font-bold text-sm">{{ substr($laporan->csProfile->user->name, 0, 1) }}</span>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-900">{{ $laporan->csProfile->user->name }}</p>
                        <p class="text-xs text-gray-500 flex items-center">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ $laporan->tanggal->format('d M Y') }} · {{ $laporan->created_at->format('H:i') }}
                        </p>
                    </div>
                </div>

                <!-- 3 Foto Grid -->
                <div class="p-4">
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">📸 Dokumentasi</p>
                    <div class="grid grid-cols-3 gap-2">
                        <!-- Foto Sebelum -->
                        <div class="relative group/foto">
                            <div class="aspect-square bg-gray-100 rounded-xl overflow-hidden">
                                <img src="{{ asset('storage/' . $laporan->foto_sebelum) }}"
                                     alt="Sebelum"
                                     class="w-full h-full object-cover group-hover/foto:scale-110 transition-transform duration-300 cursor-pointer"
                                     onclick="openPhotoModal('{{ asset('storage/' . $laporan->foto_sebelum) }}', 'Foto Sebelum')">
                            </div>
                            <span class="absolute bottom-1 left-1 right-1 text-center text-xs font-bold text-white bg-black/50 rounded py-0.5">
                                Sebelum
                            </span>
                        </div>
                        <!-- Foto Sesudah -->
                        <div class="relative group/foto">
                            <div class="aspect-square bg-gray-100 rounded-xl overflow-hidden">
                                <img src="{{ asset('storage/' . $laporan->foto_sesudah) }}"
                                     alt="Sesudah"
                                     class="w-full h-full object-cover group-hover/foto:scale-110 transition-transform duration-300 cursor-pointer"
                                     onclick="openPhotoModal('{{ asset('storage/' . $laporan->foto_sesudah) }}', 'Foto Sesudah')">
                            </div>
                            <span class="absolute bottom-1 left-1 right-1 text-center text-xs font-bold text-white bg-black/50 rounded py-0.5">
                                Sesudah
                            </span>
                        </div>
                        <!-- Foto Lokasi -->
                        <div class="relative group/foto">
                            <div class="aspect-square bg-gray-100 rounded-xl overflow-hidden">
                                <img src="{{ asset('storage/' . $laporan->foto_lokasi) }}"
                                     alt="Lokasi"
                                     class="w-full h-full object-cover group-hover/foto:scale-110 transition-transform duration-300 cursor-pointer"
                                     onclick="openPhotoModal('{{ asset('storage/' . $laporan->foto_lokasi) }}', 'Foto Lokasi')">
                            </div>
                            <span class="absolute bottom-1 left-1 right-1 text-center text-xs font-bold text-white bg-black/50 rounded py-0.5">
                                Lokasi
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Catatan -->
                @if($laporan->catatan)
                    <div class="px-4 pb-3">
                        <div class="p-3 bg-yellow-50 border border-yellow-200 rounded-xl">
                            <p class="text-xs text-yellow-800">
                                <span class="font-bold">📝 Catatan:</span> {{ Str::limit($laporan->catatan, 60) }}
                            </p>
                        </div>
                    </div>
                @endif

                <!-- Action Button -->
                <div class="px-4 pb-4">
                    <a href="{{ route('koordinator.monitoring.detail-laporan', $laporan->id) }}"
                       class="group/btn flex items-center justify-center w-full px-4 py-3 bg-gradient-to-r from-indigo-500 to-purple-600 text-white rounded-xl hover:from-indigo-600 hover:to-purple-700 transition font-semibold shadow-lg hover:shadow-xl space-x-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        <span>Lihat Detail</span>
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-1 md:col-span-2 lg:col-span-3">
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 py-16 text-center">
                    <div class="w-24 h-24 mx-auto mb-4 bg-gradient-to-br from-indigo-100 to-purple-100 rounded-full flex items-center justify-center">
                        <svg class="h-12 w-12 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-base font-bold text-gray-900 mb-1">Tidak ada laporan</h3>
                    <p class="text-sm text-gray-500">Belum ada laporan untuk filter yang dipilih</p>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($laporans->hasPages())
        <div class="mt-6">
            {{ $laporans->appends(request()->query())->links() }}
        </div>
    @endif
</div>

<!-- Photo Modal -->
<div id="photoModal" class="hidden fixed inset-0 bg-black/80 backdrop-blur-sm z-50 flex items-center justify-center p-4" onclick="closePhotoModal()">
    <div class="relative max-w-lg w-full" onclick="event.stopPropagation()">
        <button onclick="closePhotoModal()" class="absolute -top-4 -right-4 w-10 h-10 bg-white rounded-full flex items-center justify-center shadow-xl hover:bg-gray-100 transition z-10">
            <svg class="w-5 h-5 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
        <div class="bg-white rounded-2xl overflow-hidden shadow-2xl">
            <div class="bg-gradient-to-r from-indigo-500 to-purple-600 px-4 py-3 flex items-center space-x-2">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                <p id="modalTitle" class="text-white font-semibold text-sm">Foto</p>
            </div>
            <img id="modalPhoto" src="" alt="Foto" class="w-full h-auto">
        </div>
    </div>
</div>

<script>
function openPhotoModal(src, title) {
    document.getElementById('modalPhoto').src = src;
    document.getElementById('modalTitle').textContent = '📸 ' + title;
    document.getElementById('photoModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}
function closePhotoModal() {
    document.getElementById('photoModal').classList.add('hidden');
    document.body.style.overflow = '';
}
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closePhotoModal();
});
</script>
@endsection
