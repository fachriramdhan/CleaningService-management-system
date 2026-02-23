@extends('layouts.app-dashboard')

@section('title', 'Detail Absensi')

@section('nav-links')
    <a href="{{ route('cs.dashboard') }}" class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium text-gray-500 hover:text-gray-700">
        Dashboard
    </a>
    <a href="{{ route('cs.absensi.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 border-indigo-400 text-sm font-medium text-gray-900">
        Absensi
    </a>
@endsection

@section('mobile-nav-links')
    <a href="{{ route('cs.dashboard') }}" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50">
        Dashboard
    </a>
    <a href="{{ route('cs.absensi.index') }}" class="block pl-3 pr-4 py-2 border-l-4 border-indigo-400 text-base font-medium text-indigo-700 bg-indigo-50">
        Absensi
    </a>
@endsection

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

    <!-- Header -->
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-3xl md:text-4xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">
                🗓️ Detail Absensi
            </h1>
            <p class="mt-2 text-gray-600 flex items-center space-x-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <span>{{ $absensi->tanggal->format('l, d F Y') }}</span>
            </p>
        </div>
        <a href="{{ route('cs.absensi.index') }}"
           class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-gray-600 to-gray-700 text-white rounded-xl hover:from-gray-700 hover:to-gray-800 transition font-semibold shadow-lg space-x-2 self-start">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            <span>Kembali</span>
        </a>
    </div>

    <!-- Hero Status Banner -->
    <div class="mb-8 rounded-2xl shadow-xl overflow-hidden">
        <div class="
            @if($absensi->status === 'hadir') bg-gradient-to-r from-green-400 via-teal-500 to-green-500
            @elseif($absensi->status === 'izin') bg-gradient-to-r from-yellow-400 via-orange-400 to-yellow-500
            @else bg-gradient-to-r from-red-400 via-pink-500 to-red-500
            @endif p-6 text-white">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div class="flex items-center space-x-4">
                    <div class="w-16 h-16 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center flex-shrink-0">
                        @if($absensi->status === 'hadir')
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        @elseif($absensi->status === 'izin')
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        @else
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                        @endif
                    </div>
                    <div>
                        <p class="text-white/80 text-sm">Status Kehadiran</p>
                        <p class="text-2xl font-bold">
                            @if($absensi->status === 'hadir') ✅ Hadir
                            @elseif($absensi->status === 'izin') 📋 Izin
                            @else 🤒 Sakit
                            @endif
                        </p>
                    </div>
                </div>
                <!-- 3 quick info badges -->
                <div class="grid grid-cols-3 gap-2 sm:gap-3">
                    <div class="bg-white/15 backdrop-blur-sm rounded-xl p-3 text-center">
                        <p class="text-white/70 text-xs">Tanggal</p>
                        <p class="text-white font-bold text-xs mt-1">{{ $absensi->tanggal->format('d M Y') }}</p>
                    </div>
                    <div class="bg-white/15 backdrop-blur-sm rounded-xl p-3 text-center">
                        <p class="text-white/70 text-xs">Jam Masuk</p>
                        <p class="text-white font-bold text-sm mt-1">{{ $absensi->jam_absen }}</p>
                    </div>
                    <div class="bg-white/15 backdrop-blur-sm rounded-xl p-3 text-center">
                        <p class="text-white/70 text-xs">Area</p>
                        <p class="text-white font-bold text-xs mt-1">{{ Str::limit($absensi->area->nama_area, 12) }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 2 Column Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        <!-- LEFT: Info Absensi -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-blue-500 to-indigo-600 px-5 py-4">
                <div class="flex items-center space-x-3">
                    <div class="w-9 h-9 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-base font-bold text-white">Informasi Absensi</h3>
                </div>
            </div>
            <div class="p-5 space-y-3">
                <!-- Tanggal -->
                <div class="p-3 bg-gray-50 rounded-xl">
                    <p class="text-xs text-gray-500 mb-1">Tanggal</p>
                    <p class="text-sm font-bold text-gray-900">{{ $absensi->tanggal->format('d F Y') }}</p>
                    <p class="text-xs text-gray-500">{{ $absensi->tanggal->format('l') }}</p>
                </div>

                <!-- Jam Absen -->
                <div class="p-3 bg-gray-50 rounded-xl">
                    <p class="text-xs text-gray-500 mb-1">Jam Masuk</p>
                    <span class="inline-flex items-center px-3 py-1 bg-gray-200 text-gray-800 text-sm font-bold rounded-lg">
                        🕐 {{ $absensi->jam_absen }}
                    </span>
                </div>

                <!-- Area -->
                <div class="p-3 bg-blue-50 rounded-xl border border-blue-100">
                    <p class="text-xs text-gray-500 mb-1">Area Tugas</p>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-gradient-to-r from-blue-100 to-indigo-100 text-blue-800 border border-blue-200">
                        📍 {{ $absensi->area->nama_area }}
                    </span>
                </div>

                <!-- Status -->
                <div class="p-3 bg-gray-50 rounded-xl">
                    <p class="text-xs text-gray-500 mb-2">Status</p>
                    @if($absensi->status === 'hadir')
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-gradient-to-r from-green-100 to-teal-100 text-green-800 border border-green-200">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            Hadir
                        </span>
                    @elseif($absensi->status === 'izin')
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-gradient-to-r from-yellow-100 to-orange-100 text-yellow-800 border border-yellow-200">
                            <span class="w-2 h-2 bg-yellow-500 rounded-full mr-2"></span>
                            Izin
                        </span>
                    @else
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-gradient-to-r from-red-100 to-pink-100 text-red-800 border border-red-200">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                            </svg>
                            Sakit
                        </span>
                    @endif
                </div>

                @if($absensi->keterangan)
                    <!-- Keterangan -->
                    <div class="p-3 bg-yellow-50 rounded-xl border border-yellow-200">
                        <p class="text-xs text-gray-500 mb-1">Keterangan</p>
                        <p class="text-sm text-yellow-800 font-medium">{{ $absensi->keterangan }}</p>
                    </div>
                @endif

                <!-- Waktu Input -->
                <div class="p-3 bg-gray-50 rounded-xl">
                    <p class="text-xs text-gray-500 mb-1">Waktu Input Sistem</p>
                    <p class="text-sm font-semibold text-gray-900 flex items-center space-x-1">
                        <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>{{ $absensi->created_at->format('d M Y, H:i') }} WIB</span>
                    </p>
                </div>
            </div>
        </div>

        <!-- RIGHT: Foto Wajah -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-green-500 to-teal-500 px-5 py-4">
                <div class="flex items-center space-x-3">
                    <div class="w-9 h-9 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-white">Foto Absensi</h3>
                        <p class="text-white/70 text-xs">Klik untuk memperbesar</p>
                    </div>
                </div>
            </div>
            <div class="p-5">
                <!-- Foto -->
                <div class="group cursor-pointer rounded-2xl overflow-hidden border-2 border-green-200 shadow-lg mb-4"
                     onclick="openModal('{{ asset('storage/' . $absensi->foto_wajah) }}')">
                    <div class="relative">
                        <img src="{{ asset('storage/' . $absensi->foto_wajah) }}"
                             alt="Foto Absensi"
                             class="w-full h-72 object-cover group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-all flex items-center justify-center">
                            <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition shadow-xl">
                                <svg class="w-6 h-6 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path>
                                </svg>
                            </div>
                        </div>
                        <span class="absolute top-2 left-2 px-2 py-1 bg-green-500 text-white text-xs font-bold rounded-lg">
                            📸 Timestamp
                        </span>
                    </div>
                </div>

                <!-- Info Box -->
                <div class="bg-gradient-to-r from-blue-50 to-cyan-50 p-4 rounded-xl border border-blue-100">
                    <div class="flex items-start space-x-3">
                        <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center flex-shrink-0">
                            <svg class="h-4 w-4 text-white" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <p class="text-xs text-blue-700 leading-relaxed">
                            Foto diambil menggunakan aplikasi <strong>Timestamp</strong> yang mencatat waktu secara otomatis pada gambar sebagai bukti kehadiran.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom Back Button -->
    <div class="mt-8 flex justify-center">
        <a href="{{ route('cs.absensi.index') }}"
           class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-2xl hover:from-blue-600 hover:to-indigo-700 transition font-bold shadow-xl hover:shadow-2xl space-x-2 text-lg">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z"></path>
            </svg>
            <span>Kembali ke Riwayat Absensi</span>
        </a>
    </div>
</div>

<!-- Photo Modal -->
<div id="imageModal" class="hidden fixed inset-0 bg-black/85 backdrop-blur-sm z-50 flex items-center justify-center p-4" onclick="closeModal()">
    <div class="relative max-w-lg w-full" onclick="event.stopPropagation()">
        <button onclick="closeModal()" class="absolute -top-4 -right-4 w-10 h-10 bg-white rounded-full flex items-center justify-center shadow-xl hover:bg-gray-100 transition z-10">
            <svg class="w-5 h-5 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
        <div class="bg-white rounded-2xl overflow-hidden shadow-2xl">
            <div class="bg-gradient-to-r from-green-500 to-teal-500 px-4 py-3 flex items-center space-x-2">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                </svg>
                <p class="text-white font-semibold text-sm">📸 Foto Absensi · ESC untuk tutup</p>
            </div>
            <img id="modalImage" src="" alt="Foto Absensi" class="w-full h-auto max-h-[80vh] object-contain bg-gray-900">
        </div>
    </div>
</div>

<script>
function openModal(src) {
    document.getElementById('modalImage').src = src;
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
