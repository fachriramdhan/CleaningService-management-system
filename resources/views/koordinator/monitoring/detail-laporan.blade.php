@extends('layouts.app-dashboard')

@section('title', 'Detail Laporan ATM')

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
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-3xl md:text-4xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
                🧹 Detail Laporan
            </h1>
            <p class="mt-2 text-gray-600 flex items-center space-x-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5"></path>
                </svg>
                <span class="font-semibold text-gray-800">{{ $laporan->atm->nama_atm }}</span>
                <span class="text-gray-400">·</span>
                <span>{{ $laporan->tanggal->format('d F Y') }}</span>
            </p>
        </div>
        <a href="{{ route('koordinator.monitoring.laporan') }}"
           class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-gray-600 to-gray-700 text-white rounded-xl hover:from-gray-700 hover:to-gray-800 transition font-semibold shadow-lg space-x-2 self-start">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            <span>Kembali</span>
        </a>
    </div>

    <!-- Hero Status Banner -->
    <div class="mb-8 bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 rounded-2xl shadow-xl p-6 text-white">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center space-x-4">
                <div class="w-16 h-16 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-white/80 text-sm">Status Pembersihan</p>
                    <p class="text-2xl font-bold">✅ Selesai Dibersihkan</p>
                </div>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                <div class="bg-white/15 backdrop-blur-sm rounded-xl p-3 text-center">
                    <p class="text-white/70 text-xs">Tanggal</p>
                    <p class="text-white font-bold text-sm">{{ $laporan->tanggal->format('d M Y') }}</p>
                </div>
                <div class="bg-white/15 backdrop-blur-sm rounded-xl p-3 text-center">
                    <p class="text-white/70 text-xs">Jam Input</p>
                    <p class="text-white font-bold text-sm">{{ $laporan->created_at->format('H:i') }}</p>
                </div>
                <div class="bg-white/15 backdrop-blur-sm rounded-xl p-3 text-center col-span-2 sm:col-span-1">
                    <p class="text-white/70 text-xs">Area</p>
                    <p class="text-white font-bold text-sm">{{ $laporan->atm->area->nama_area }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- LEFT: Info Cards -->
        <div class="lg:col-span-1 space-y-6">

            <!-- Info ATM -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-blue-500 to-cyan-500 px-5 py-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-9 h-9 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                        <h3 class="text-base font-bold text-white">Informasi ATM</h3>
                    </div>
                </div>
                <div class="p-5 space-y-3">
                    <div class="p-3 bg-gray-50 rounded-xl">
                        <p class="text-xs text-gray-500 mb-1">Nama ATM</p>
                        <p class="text-sm font-bold text-gray-900">{{ $laporan->atm->nama_atm }}</p>
                    </div>
                    <div class="p-3 bg-gray-50 rounded-xl">
                        <p class="text-xs text-gray-500 mb-1">Lokasi</p>
                        <p class="text-sm font-medium text-gray-800">{{ $laporan->atm->lokasi }}</p>
                    </div>
                    @if($laporan->atm->alamat_lengkap)
                        <div class="p-3 bg-gray-50 rounded-xl">
                            <p class="text-xs text-gray-500 mb-1">Alamat Lengkap</p>
                            <p class="text-sm text-gray-700 leading-relaxed">{{ $laporan->atm->alamat_lengkap }}</p>
                        </div>
                    @endif
                    <div class="p-3 bg-blue-50 rounded-xl border border-blue-100">
                        <p class="text-xs text-gray-500 mb-1">Area</p>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-gradient-to-r from-blue-100 to-cyan-100 text-blue-800 border border-blue-200">
                            📍 {{ $laporan->atm->area->nama_area }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Info CS -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-green-500 to-teal-500 px-5 py-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-9 h-9 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <h3 class="text-base font-bold text-white">Cleaning Service</h3>
                    </div>
                </div>
                <div class="p-5 space-y-3">
                    <!-- Avatar + Name -->
                    <div class="flex items-center space-x-3 p-3 bg-gradient-to-r from-green-50 to-teal-50 rounded-xl border border-green-100">
                        <div class="w-12 h-12 bg-gradient-to-br from-green-400 to-teal-500 rounded-full flex items-center justify-center flex-shrink-0 shadow-lg">
                            <span class="text-white font-bold text-lg">{{ substr($laporan->csProfile->user->name, 0, 1) }}</span>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-gray-900">{{ $laporan->csProfile->user->name }}</p>
                            <p class="text-xs text-gray-500">{{ $laporan->csProfile->user->email }}</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div class="p-3 bg-gray-50 rounded-xl text-center">
                            <p class="text-xs text-gray-500">Tanggal</p>
                            <p class="text-xs font-bold text-gray-900 mt-1">{{ $laporan->tanggal->format('d M Y') }}</p>
                        </div>
                        <div class="p-3 bg-gray-50 rounded-xl text-center">
                            <p class="text-xs text-gray-500">Jam Absen</p>
                            <p class="text-xs font-bold text-gray-900 mt-1">🕐 {{ $laporan->absensi->jam_absen }}</p>
                        </div>
                        <div class="col-span-2 p-3 bg-gray-50 rounded-xl text-center">
                            <p class="text-xs text-gray-500">Input Laporan</p>
                            <p class="text-xs font-bold text-gray-900 mt-1">⏱️ {{ $laporan->created_at->format('H:i') }} WIB</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Catatan / Kendala -->
            @if($laporan->catatan)
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-yellow-400 to-orange-500 px-5 py-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-9 h-9 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                </svg>
                            </div>
                            <h3 class="text-base font-bold text-white">Catatan / Kendala</h3>
                        </div>
                    </div>
                    <div class="p-5">
                        <div class="p-4 bg-gradient-to-r from-yellow-50 to-orange-50 rounded-xl border border-yellow-200">
                            <p class="text-sm text-gray-800 leading-relaxed">{{ $laporan->catatan }}</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- RIGHT: Dokumentasi Foto -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-indigo-500 to-purple-600 px-6 py-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-white">Dokumentasi Pembersihan</h3>
                            <p class="text-white/70 text-xs">Klik foto untuk memperbesar</p>
                        </div>
                    </div>
                </div>

                <div class="p-6 space-y-6">
                    <!-- Foto Sebelum -->
                    <div class="group">
                        <div class="flex items-center space-x-3 mb-3">
                            <div class="w-10 h-10 bg-gradient-to-br from-red-400 to-red-600 rounded-xl flex items-center justify-center shadow-lg">
                                <span class="text-white font-bold text-sm">1</span>
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-gray-900">Sebelum Dibersihkan</h4>
                                <p class="text-xs text-gray-500">Kondisi ATM sebelum proses pembersihan</p>
                            </div>
                            <span class="ml-auto px-3 py-1 bg-red-100 text-red-700 text-xs font-semibold rounded-full border border-red-200">
                                Before
                            </span>
                        </div>
                        <div class="rounded-2xl overflow-hidden border-2 border-red-200 shadow-lg cursor-pointer hover:shadow-xl transition-shadow"
                             onclick="openModal('{{ asset('storage/' . $laporan->foto_sebelum) }}', 'Foto Sebelum Dibersihkan')">
                            <div class="relative">
                                <img src="{{ asset('storage/' . $laporan->foto_sebelum) }}"
                                     alt="Foto Sebelum"
                                     class="w-full h-72 object-cover group-hover:scale-105 transition-transform duration-500">
                                <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-all flex items-center justify-center">
                                    <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition shadow-xl">
                                        <svg class="w-6 h-6 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="border-t border-gray-100"></div>

                    <!-- Foto Sesudah -->
                    <div class="group">
                        <div class="flex items-center space-x-3 mb-3">
                            <div class="w-10 h-10 bg-gradient-to-br from-green-400 to-green-600 rounded-xl flex items-center justify-center shadow-lg">
                                <span class="text-white font-bold text-sm">2</span>
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-gray-900">Sesudah Dibersihkan</h4>
                                <p class="text-xs text-gray-500">Kondisi ATM setelah proses pembersihan</p>
                            </div>
                            <span class="ml-auto px-3 py-1 bg-green-100 text-green-700 text-xs font-semibold rounded-full border border-green-200">
                                After
                            </span>
                        </div>
                        <div class="rounded-2xl overflow-hidden border-2 border-green-200 shadow-lg cursor-pointer hover:shadow-xl transition-shadow"
                             onclick="openModal('{{ asset('storage/' . $laporan->foto_sesudah) }}', 'Foto Sesudah Dibersihkan')">
                            <div class="relative">
                                <img src="{{ asset('storage/' . $laporan->foto_sesudah) }}"
                                     alt="Foto Sesudah"
                                     class="w-full h-72 object-cover group-hover:scale-105 transition-transform duration-500">
                                <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-all flex items-center justify-center">
                                    <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition shadow-xl">
                                        <svg class="w-6 h-6 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="border-t border-gray-100"></div>

                    <!-- Foto Lokasi -->
                    <div class="group">
                        <div class="flex items-center space-x-3 mb-3">
                            <div class="w-10 h-10 bg-gradient-to-br from-blue-400 to-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                                <span class="text-white font-bold text-sm">3</span>
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-gray-900">Foto Lokasi ATM</h4>
                                <p class="text-xs text-gray-500">Dokumentasi lokasi unit ATM</p>
                            </div>
                            <span class="ml-auto px-3 py-1 bg-blue-100 text-blue-700 text-xs font-semibold rounded-full border border-blue-200">
                                Lokasi
                            </span>
                        </div>
                        <div class="rounded-2xl overflow-hidden border-2 border-blue-200 shadow-lg cursor-pointer hover:shadow-xl transition-shadow"
                             onclick="openModal('{{ asset('storage/' . $laporan->foto_lokasi) }}', 'Foto Lokasi ATM')">
                            <div class="relative">
                                <img src="{{ asset('storage/' . $laporan->foto_lokasi) }}"
                                     alt="Foto Lokasi"
                                     class="w-full h-72 object-cover group-hover:scale-105 transition-transform duration-500">
                                <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-all flex items-center justify-center">
                                    <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition shadow-xl">
                                        <svg class="w-6 h-6 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom Back Button -->
    <div class="mt-8 flex justify-center">
        <a href="{{ route('koordinator.monitoring.laporan') }}" class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-indigo-500 to-purple-600 text-white rounded-2xl hover:from-indigo-600 hover:to-purple-700 transition font-bold shadow-xl hover:shadow-2xl space-x-2 text-lg">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z"></path>
            </svg>
            <span>Kembali ke Monitoring Laporan</span>
        </a>
    </div>
</div>

<!-- Photo Modal -->
<div id="imageModal" class="hidden fixed inset-0 bg-black/85 backdrop-blur-sm z-50 flex items-center justify-center p-4" onclick="closeModal()">
    <div class="relative max-w-4xl w-full" onclick="event.stopPropagation()">
        <button onclick="closeModal()" class="absolute -top-4 -right-4 w-10 h-10 bg-white rounded-full flex items-center justify-center shadow-xl hover:bg-gray-100 transition z-10">
            <svg class="w-5 h-5 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
        <div class="bg-white rounded-2xl overflow-hidden shadow-2xl">
            <div class="bg-gradient-to-r from-indigo-500 to-purple-600 px-5 py-3 flex items-center space-x-2">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                </svg>
                <p id="modalTitle" class="text-white font-semibold text-sm">Foto</p>
                <span class="ml-auto text-white/60 text-xs">ESC atau klik luar untuk tutup</span>
            </div>
            <img id="modalImage" src="" alt="Zoom" class="w-full h-auto max-h-[80vh] object-contain bg-gray-900">
        </div>
    </div>
</div>

<script>
function openModal(src, title) {
    document.getElementById('modalImage').src = src;
    document.getElementById('modalTitle').textContent = '📸 ' + title;
    document.getElementById('imageModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}
function closeModal() {
    document.getElementById('imageModal').classList.add('hidden');
    document.body.style.overflow = '';
}
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeModal();
});
</script>
@endsection
