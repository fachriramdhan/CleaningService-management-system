@extends('layouts.app-dashboard')

@section('title', 'Monitoring Absensi')

@section('nav-links')
    <a href="{{ route('koordinator.dashboard') }}" class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium text-gray-500 hover:text-gray-700">
        Dashboard
    </a>
    <a href="{{ route('koordinator.monitoring.absensi') }}" class="inline-flex items-center px-1 pt-1 border-b-2 border-indigo-400 text-sm font-medium text-gray-900">
        Monitoring Absensi
    </a>
    <a href="{{ route('koordinator.monitoring.laporan') }}" class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium text-gray-500 hover:text-gray-700">
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
    <a href="{{ route('koordinator.monitoring.absensi') }}" class="block pl-3 pr-4 py-2 border-l-4 border-indigo-400 text-base font-medium text-indigo-700 bg-indigo-50">
        Monitoring Absensi
    </a>
    <a href="{{ route('koordinator.monitoring.laporan') }}" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50">
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
        <h1 class="text-3xl md:text-4xl font-bold bg-gradient-to-r from-green-600 to-teal-600 bg-clip-text text-transparent">
            🗓️ Monitoring Absensi
        </h1>
        <p class="mt-2 text-gray-600 flex items-center space-x-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span>Pantau kehadiran cleaning service secara real-time</span>
        </p>
    </div>

   <!-- Filter Section -->
<div
    x-data="{ open: false }"
    class="mb-6 bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden"
>

    <!-- Header -->
    <div class="bg-gradient-to-r from-green-500 to-teal-500 px-6 py-4">
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
                <h2 class="text-lg font-semibold text-white">Filter Absensi</h2>
            </div>

            <!-- Toggle Button (Mobile Only) -->
            <button
                @click="open = !open"
                class="lg:hidden bg-white/20 hover:bg-white/30 text-white px-3 py-2 rounded-lg text-sm transition"
            >
                <span x-show="!open">Tampilkan</span>
                <span x-show="open">Sembunyikan</span>
            </button>

        </div>
    </div>

    <!-- Form Container -->
    <div
        x-show="open || window.innerWidth >= 1024"
        x-transition
        class="p-6"
    >

        <form method="GET" action="{{ route('koordinator.monitoring.absensi') }}"
              class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">

            <!-- Tanggal -->
            <div>
                <label class="block text-xs font-bold text-gray-600 mb-2 uppercase tracking-wider">
                    📅 Tanggal
                </label>
                <input type="date" name="tanggal"
                    value="{{ request('tanggal', now()->format('Y-m-d')) }}"
                    class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition text-sm">
            </div>

            <!-- CS -->
            <div>
                <label class="block text-xs font-bold text-gray-600 mb-2 uppercase tracking-wider">
                    👤 CS
                </label>
                <select name="cs_profile_id"
                    class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition text-sm">
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
                    class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition text-sm">
                    <option value="">Semua Area</option>
                    @foreach($areas as $area)
                        <option value="{{ $area->id }}" {{ request('area_id') == $area->id ? 'selected' : '' }}>
                            {{ $area->nama_area }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Status -->
            <div>
                <label class="block text-xs font-bold text-gray-600 mb-2 uppercase tracking-wider">
                    🔖 Status
                </label>
                <select name="status"
                    class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition text-sm">
                    <option value="">Semua Status</option>
                    <option value="hadir" {{ request('status') == 'hadir' ? 'selected' : '' }}>✅ Hadir</option>
                    <option value="izin" {{ request('status') == 'izin' ? 'selected' : '' }}>📋 Izin</option>
                    <option value="sakit" {{ request('status') == 'sakit' ? 'selected' : '' }}>🤒 Sakit</option>
                </select>
            </div>

            <!-- Button -->
            <div class="flex items-end">
                <button type="submit"
                    class="w-full px-6 py-3 bg-gradient-to-r from-green-500 to-teal-500 text-white rounded-xl hover:from-green-600 hover:to-teal-600 transition font-semibold shadow-lg hover:shadow-xl flex items-center justify-center space-x-2">
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


    <!-- Mobile Cards View -->
    <div class="lg:hidden space-y-4 mb-6">
        @forelse($absensis as $absensi)
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <!-- Card Top -->
                <div class="bg-gradient-to-r from-{{ $absensi->status === 'hadir' ? 'green-400 to-teal-500' : ($absensi->status === 'izin' ? 'yellow-400 to-orange-400' : 'red-400 to-pink-500') }} p-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <!-- Foto -->
                            <img src="{{ asset('storage/' . $absensi->foto_wajah) }}"
                                 alt="Foto"
                                 class="w-14 h-14 rounded-full object-cover border-2 border-white shadow-lg cursor-pointer"
                                 onclick="openModal('{{ asset('storage/' . $absensi->foto_wajah) }}')">
                            <div>
                                <p class="text-white font-bold">{{ $absensi->csProfile->user->name }}</p>
                                <p class="text-white/80 text-xs">{{ $absensi->csProfile->user->email }}</p>
                            </div>
                        </div>
                        <!-- Status Badge -->
                        <span class="px-3 py-1 bg-white/20 backdrop-blur-sm text-white text-xs font-bold rounded-full">
                            @if($absensi->status === 'hadir') ✅ Hadir
                            @elseif($absensi->status === 'izin') 📋 Izin
                            @else 🤒 Sakit
                            @endif
                        </span>
                    </div>
                </div>
                <!-- Card Body -->
                <div class="p-4 grid grid-cols-3 gap-3">
                    <div class="text-center p-2 bg-gray-50 rounded-xl">
                        <p class="text-xs text-gray-500">Tanggal</p>
                        <p class="text-xs font-bold text-gray-900">{{ $absensi->tanggal->format('d M Y') }}</p>
                    </div>
                    <div class="text-center p-2 bg-gray-50 rounded-xl">
                        <p class="text-xs text-gray-500">Jam</p>
                        <p class="text-xs font-bold text-gray-900">{{ $absensi->jam_absen }}</p>
                    </div>
                    <div class="text-center p-2 bg-blue-50 rounded-xl">
                        <p class="text-xs text-gray-500">Area</p>
                        <p class="text-xs font-bold text-blue-700">{{ Str::limit($absensi->area->nama_area, 12) }}</p>
                    </div>
                    @if($absensi->keterangan)
                        <div class="col-span-3 p-2 bg-yellow-50 rounded-xl border border-yellow-200">
                            <p class="text-xs text-gray-600"><span class="font-semibold">Ket:</span> {{ $absensi->keterangan }}</p>
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-12 text-center">
                <div class="w-20 h-20 mx-auto mb-4 bg-gray-100 rounded-full flex items-center justify-center">
                    <svg class="h-10 w-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <p class="text-sm font-semibold text-gray-900">Tidak ada data absensi</p>
                <p class="text-xs text-gray-500 mt-1">Coba ubah filter pencarian</p>
            </div>
        @endforelse
    </div>

    <!-- Desktop Table View -->
    <div class="hidden lg:block bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">No</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Foto</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Nama CS</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Jam</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Area</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Keterangan</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($absensis as $index => $absensi)
                        <tr class="hover:bg-gradient-to-r hover:from-green-50 hover:to-teal-50 transition-all">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="w-8 h-8 bg-gradient-to-br from-green-500 to-teal-600 rounded-full flex items-center justify-center text-white font-bold text-xs">
                                    {{ $absensis->firstItem() + $index }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="relative group">
                                    <img src="{{ asset('storage/' . $absensi->foto_wajah) }}"
                                         alt="Foto"
                                         class="w-12 h-12 rounded-full object-cover cursor-pointer border-2 border-transparent group-hover:border-green-400 transition shadow-md"
                                         onclick="openModal('{{ asset('storage/' . $absensi->foto_wajah) }}')">
                                    <div class="absolute inset-0 rounded-full bg-black/20 opacity-0 group-hover:opacity-100 transition flex items-center justify-center cursor-pointer"
                                         onclick="openModal('{{ asset('storage/' . $absensi->foto_wajah) }}')">
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                        </svg>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-gradient-to-br from-green-400 to-teal-500 rounded-full flex items-center justify-center mr-3 flex-shrink-0">
                                        <span class="text-white font-bold text-sm">{{ substr($absensi->csProfile->user->name, 0, 1) }}</span>
                                    </div>
                                    <div>
                                        <div class="text-sm font-semibold text-gray-900">{{ $absensi->csProfile->user->name }}</div>
                                        <div class="text-xs text-gray-500">{{ $absensi->csProfile->user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $absensi->tanggal->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-3 py-1 bg-gray-100 text-gray-800 text-sm font-bold rounded-lg">
                                    🕐 {{ $absensi->jam_absen }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-gradient-to-r from-blue-100 to-cyan-100 text-blue-800 border border-blue-200">
                                    📍 {{ $absensi->area->nama_area }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($absensi->status === 'hadir')
                                    <span class="px-3 py-1 inline-flex items-center text-xs leading-5 font-semibold rounded-full bg-gradient-to-r from-green-100 to-teal-100 text-green-800 border border-green-200">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                        Hadir
                                    </span>
                                @elseif($absensi->status === 'izin')
                                    <span class="px-3 py-1 inline-flex items-center text-xs leading-5 font-semibold rounded-full bg-gradient-to-r from-yellow-100 to-orange-100 text-yellow-800 border border-yellow-200">
                                        <span class="w-2 h-2 bg-yellow-500 rounded-full mr-2"></span>
                                        Izin
                                    </span>
                                @else
                                    <span class="px-3 py-1 inline-flex items-center text-xs leading-5 font-semibold rounded-full bg-gradient-to-r from-red-100 to-pink-100 text-red-800 border border-red-200">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                        </svg>
                                        Sakit
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600 max-w-xs">
                                @if($absensi->keterangan)
                                    <span class="px-2 py-1 bg-yellow-50 text-yellow-800 rounded-lg text-xs border border-yellow-200">
                                        {{ $absensi->keterangan }}
                                    </span>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-16 text-center">
                                <div class="w-20 h-20 mx-auto mb-4 bg-gray-100 rounded-full flex items-center justify-center">
                                    <svg class="h-10 w-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                                <p class="text-sm font-semibold text-gray-900">Tidak ada data absensi</p>
                                <p class="text-xs text-gray-500 mt-1">Coba ubah filter pencarian</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <!-- Pagination -->
        @if($absensis->hasPages())
            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                {{ $absensis->links() }}
            </div>
        @endif
    </div>

    <!-- Mobile Pagination -->
    @if($absensis->hasPages())
        <div class="lg:hidden mt-4">
            {{ $absensis->links() }}
        </div>
    @endif
</div>

<!-- Photo Modal -->
<div id="imageModal" class="hidden fixed inset-0 bg-black/80 backdrop-blur-sm z-50 flex items-center justify-center p-4" onclick="closeModal()">
    <div class="relative max-w-lg w-full" onclick="event.stopPropagation()">
        <button onclick="closeModal()" class="absolute -top-4 -right-4 w-10 h-10 bg-white rounded-full flex items-center justify-center shadow-xl hover:bg-gray-100 transition z-10">
            <svg class="w-5 h-5 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
        <div class="bg-white rounded-2xl overflow-hidden shadow-2xl">
            <div class="bg-gradient-to-r from-green-500 to-teal-500 px-4 py-3">
                <p class="text-white font-semibold text-sm">📸 Foto Absensi</p>
            </div>
            <img id="modalImage" src="" alt="Foto Absensi" class="w-full h-auto">
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
