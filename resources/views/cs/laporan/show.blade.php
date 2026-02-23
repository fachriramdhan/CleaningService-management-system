@extends('layouts.app-dashboard')

@section('title', 'Detail Laporan ATM')

@section('nav-links')
    <a href="{{ route('cs.dashboard') }}" class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium text-gray-500 hover:text-gray-700">
        Dashboard
    </a>
    <a href="{{ route('cs.laporan.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 border-indigo-400 text-sm font-medium text-gray-900">
        Laporan ATM
    </a>
@endsection

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Detail Laporan Pembersihan</h1>
            <p class="mt-1 text-sm text-gray-600">{{ $laporan->atm->nama_atm }} - {{ $laporan->tanggal->format('d F Y') }}</p>
        </div>
        <a href="{{ route('cs.laporan.index') }}"
           class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
            Kembali
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Informasi Laporan -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Laporan</h3>

                <div class="space-y-4">
                    <div>
                        <p class="text-xs text-gray-500">Nama ATM</p>
                        <p class="text-sm font-medium text-gray-900">{{ $laporan->atm->nama_atm }}</p>
                    </div>

                    <div>
                        <p class="text-xs text-gray-500">Lokasi</p>
                        <p class="text-sm text-gray-700">{{ $laporan->atm->lokasi }}</p>
                    </div>

                    @if($laporan->atm->alamat_lengkap)
                        <div>
                            <p class="text-xs text-gray-500">Alamat Lengkap</p>
                            <p class="text-sm text-gray-700">{{ $laporan->atm->alamat_lengkap }}</p>
                        </div>
                    @endif

                    <div>
                        <p class="text-xs text-gray-500">Area</p>
                        <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-blue-100 text-blue-800">
                            {{ $laporan->atm->area->nama_area }}
                        </span>
                    </div>

                    <div>
                        <p class="text-xs text-gray-500">Tanggal Pembersihan</p>
                        <p class="text-sm font-medium text-gray-900">{{ $laporan->tanggal->format('d F Y') }}</p>
                    </div>

                    <div>
                        <p class="text-xs text-gray-500">Waktu Input</p>
                        <p class="text-sm text-gray-700">{{ $laporan->created_at->format('d M Y, H:i') }}</p>
                    </div>

                    @if($laporan->catatan)
                        <div>
                            <p class="text-xs text-gray-500">Catatan / Kendala</p>
                            <div class="mt-1 p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
                                <p class="text-sm text-gray-700">{{ $laporan->catatan }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Info Absensi -->
            <div class="mt-6 bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Info Absensi</h3>

                <div class="space-y-3">
                    <div>
                        <p class="text-xs text-gray-500">Jam Absen</p>
                        <p class="text-sm font-medium text-gray-900">{{ $laporan->absensi->jam_absen }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Status Absensi</p>
                        @if($laporan->absensi->status === 'hadir')
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Hadir
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Dokumentasi Foto -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Dokumentasi Pembersihan</h3>

                <div class="space-y-6">
                    <!-- Foto Sebelum -->
                    <div>
                        <div class="flex items-center mb-2">
                            <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center mr-2">
                                <span class="text-red-600 font-semibold text-sm">1</span>
                            </div>
                            <h4 class="text-sm font-semibold text-gray-900">Sebelum Dibersihkan</h4>
                        </div>
                        <div class="rounded-lg overflow-hidden border-2 border-gray-300 shadow-sm">
                            <img src="{{ asset('storage/' . $laporan->foto_sebelum) }}"
                                 alt="Foto Sebelum"
                                 class="w-full h-auto cursor-pointer hover:opacity-90 transition"
                                 onclick="openModal('{{ asset('storage/' . $laporan->foto_sebelum) }}')">
                        </div>
                        <p class="mt-1 text-xs text-gray-500">Klik foto untuk memperbesar</p>
                    </div>

                    <!-- Foto Sesudah -->
                    <div>
                        <div class="flex items-center mb-2">
                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mr-2">
                                <span class="text-green-600 font-semibold text-sm">2</span>
                            </div>
                            <h4 class="text-sm font-semibold text-gray-900">Sesudah Dibersihkan</h4>
                        </div>
                        <div class="rounded-lg overflow-hidden border-2 border-gray-300 shadow-sm">
                            <img src="{{ asset('storage/' . $laporan->foto_sesudah) }}"
                                 alt="Foto Sesudah"
                                 class="w-full h-auto cursor-pointer hover:opacity-90 transition"
                                 onclick="openModal('{{ asset('storage/' . $laporan->foto_sesudah) }}')">
                        </div>
                        <p class="mt-1 text-xs text-gray-500">Klik foto untuk memperbesar</p>
                    </div>

                    <!-- Foto Lokasi -->
                    <div>
                        <div class="flex items-center mb-2">
                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mr-2">
                                <span class="text-blue-600 font-semibold text-sm">3</span>
                            </div>
                            <h4 class="text-sm font-semibold text-gray-900">Lokasi ATM</h4>
                        </div>
                        <div class="rounded-lg overflow-hidden border-2 border-gray-300 shadow-sm">
                            <img src="{{ asset('storage/' . $laporan->foto_lokasi) }}"
                                 alt="Foto Lokasi"
                                 class="w-full h-auto cursor-pointer hover:opacity-90 transition"
                                 onclick="openModal('{{ asset('storage/' . $laporan->foto_lokasi) }}')">
                        </div>
                        <p class="mt-1 text-xs text-gray-500">Klik foto untuk memperbesar</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal untuk zoom foto -->
<div id="imageModal" class="hidden fixed inset-0 bg-black bg-opacity-75 z-50 flex items-center justify-center p-4" onclick="closeModal()">
    <div class="relative max-w-5xl w-full">
        <button onclick="closeModal()" class="absolute top-4 right-4 text-white bg-black bg-opacity-50 rounded-full p-2 hover:bg-opacity-75">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
        <img id="modalImage" src="" alt="Zoom" class="w-full h-auto rounded-lg">
    </div>
</div>

<script>
function openModal(src) {
    document.getElementById('modalImage').src = src;
    document.getElementById('imageModal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('imageModal').classList.add('hidden');
}

// Close modal with ESC key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeModal();
    }
});
</script>
@endsection
