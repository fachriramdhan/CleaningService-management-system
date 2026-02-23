@extends('layouts.app-dashboard')

@section('title', 'Detail Permintaan')

@section('nav-links')
    <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium text-gray-500 hover:text-gray-700">Dashboard</a>
    <a href="{{ route('admin.inventory.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium text-gray-500 hover:text-gray-700">Inventory</a>
    <a href="{{ route('admin.permintaan.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 border-indigo-400 text-sm font-medium text-gray-900">Permintaan</a>
@endsection

@section('mobile-nav-links')
    <a href="{{ route('admin.dashboard') }}" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50">Dashboard</a>
    <a href="{{ route('admin.inventory.index') }}" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50">Inventory</a>
    <a href="{{ route('admin.permintaan.index') }}" class="block pl-3 pr-4 py-2 border-l-4 border-indigo-400 text-base font-medium text-indigo-700 bg-indigo-50">Permintaan</a>
@endsection

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

    <!-- Header -->
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-3xl md:text-4xl font-bold bg-gradient-to-r from-orange-600 to-pink-600 bg-clip-text text-transparent">
                📋 Detail Permintaan
            </h1>
            <p class="mt-2 text-gray-600">{{ $permintaan->inventory->nama_item }}</p>
        </div>
        <a href="{{ route('admin.permintaan.index') }}"
           class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-gray-600 to-gray-700 text-white rounded-xl font-semibold hover:from-gray-700 hover:to-gray-800 transition shadow-lg space-x-2 self-start">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            <span>Kembali</span>
        </a>
    </div>

    <!-- Alert Error -->
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

    <!-- Grid Layout: Main (2 cols) + Sidebar (1 col) on desktop -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- LEFT/MAIN: Informasi Permintaan (2 cols on lg) -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">

                <!-- Hero Status Banner -->
                <div class="
                    @if($permintaan->status === 'pending') bg-gradient-to-r from-yellow-400 via-orange-400 to-yellow-500
                    @elseif($permintaan->status === 'approved') bg-gradient-to-r from-green-400 via-teal-500 to-green-500
                    @else bg-gradient-to-r from-red-400 via-pink-500 to-red-500
                    @endif p-6 text-white">

                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div class="flex items-center space-x-4">
                            <div class="w-16 h-16 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center flex-shrink-0">
                                @if($permintaan->status === 'pending')
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                @elseif($permintaan->status === 'approved')
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                @else
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                @endif
                            </div>
                            <div>
                                <p class="text-white/80 text-sm">Status Permintaan</p>
                                <p class="text-2xl font-bold">
                                    @if($permintaan->status === 'pending') ⏳ Menunggu Persetujuan
                                    @elseif($permintaan->status === 'approved') ✅ Disetujui
                                    @else ❌ Ditolak
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-2">
                            <div class="bg-white/15 backdrop-blur-sm rounded-xl p-3 text-center">
                                <p class="text-white/70 text-xs">Jumlah</p>
                                <p class="text-white font-bold text-sm mt-1">{{ $permintaan->jumlah }} {{ $permintaan->inventory->satuan }}</p>
                            </div>
                            <div class="bg-white/15 backdrop-blur-sm rounded-xl p-3 text-center">
                                <p class="text-white/70 text-xs">Tanggal</p>
                                <p class="text-white font-bold text-xs mt-1">{{ $permintaan->created_at->format('d M Y') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card Body -->
                <div class="p-6">

                    <!-- Info Grid: CS + Item -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">

                        <!-- Info CS -->
                        <div>
                            <h3 class="text-xs font-bold text-gray-600 uppercase tracking-wider mb-3">👤 Informasi CS</h3>
                            <div class="flex items-center p-3 bg-blue-50 rounded-xl border border-blue-100">
                                <div class="w-12 h-12 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center mr-3 flex-shrink-0 shadow-lg">
                                    <span class="text-white font-bold text-lg">{{ substr($permintaan->csProfile->user->name, 0, 1) }}</span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-bold text-gray-900 truncate">{{ $permintaan->csProfile->user->name }}</p>
                                    <p class="text-xs text-gray-500 truncate">{{ $permintaan->csProfile->user->email }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Info Item -->
                        <div>
                            <h3 class="text-xs font-bold text-gray-600 uppercase tracking-wider mb-3">📦 Informasi Item</h3>
                            <div class="space-y-2">
                                <div class="p-2 bg-gray-50 rounded-xl">
                                    <p class="text-xs text-gray-500">Nama Item</p>
                                    <p class="text-sm font-bold text-gray-900">{{ $permintaan->inventory->nama_item }}</p>
                                </div>
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-xs text-gray-500">Jenis</p>
                                        @if($permintaan->inventory->jenis === 'alat')
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-800 border border-blue-200">
                                                🔧 Alat
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-bold bg-purple-100 text-purple-800 border border-purple-200">
                                                🧪 Chemical
                                            </span>
                                        @endif
                                    </div>
                                    <div class="text-right">
                                        <p class="text-xs text-gray-500">Stok Tersedia</p>
                                        <p class="text-lg font-black {{ $permintaan->inventory->stok < $permintaan->jumlah ? 'text-red-600' : 'text-green-600' }}">
                                            {{ $permintaan->inventory->stok }} <span class="text-xs">{{ $permintaan->inventory->satuan }}</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="border-t border-gray-200 mb-6"></div>

                    <!-- Detail Permintaan -->
                    <div class="space-y-4">
                        <!-- Grid Info -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            <div class="p-3 bg-gray-50 rounded-xl">
                                <p class="text-xs text-gray-500 mb-1">🔖 Jenis Permintaan</p>
                                <p class="text-sm font-bold text-gray-900 capitalize">{{ $permintaan->jenis_permintaan }}</p>
                            </div>
                            <div class="p-3 bg-gray-50 rounded-xl">
                                <p class="text-xs text-gray-500 mb-1">🔢 Jumlah Diminta</p>
                                <p class="text-sm font-bold text-gray-900">{{ $permintaan->jumlah }} {{ $permintaan->inventory->satuan }}</p>
                            </div>
                            <div class="p-3 bg-gray-50 rounded-xl">
                                <p class="text-xs text-gray-500 mb-1">📅 Tanggal Pengajuan</p>
                                <p class="text-sm font-bold text-gray-900">{{ $permintaan->created_at->format('d F Y, H:i') }}</p>
                            </div>
                            @if($permintaan->tanggal_approved)
                                <div class="p-3 bg-gray-50 rounded-xl">
                                    <p class="text-xs text-gray-500 mb-1">⚡ Tanggal Diproses</p>
                                    <p class="text-sm font-bold text-gray-900">{{ $permintaan->tanggal_approved->format('d F Y, H:i') }}</p>
                                </div>
                            @endif
                        </div>

                        <!-- Alasan -->
                        <div>
                            <p class="text-xs font-bold text-gray-600 uppercase tracking-wider mb-2">📝 Alasan / Keperluan</p>
                            <div class="p-4 bg-gray-50 rounded-xl border border-gray-200">
                                <p class="text-sm text-gray-700 leading-relaxed">{{ $permintaan->alasan }}</p>
                            </div>
                        </div>

                        <!-- Keterangan Admin (jika ada) -->
                        @if($permintaan->keterangan_admin)
                            <div>
                                <p class="text-xs font-bold text-gray-600 uppercase tracking-wider mb-2">💬 Keterangan dari Admin</p>
                                <div class="p-4 rounded-xl border
                                    @if($permintaan->status === 'approved') bg-green-50 border-green-200
                                    @else bg-red-50 border-red-200
                                    @endif">
                                    <p class="text-sm leading-relaxed
                                        @if($permintaan->status === 'approved') text-green-800
                                        @else text-red-800
                                        @endif">
                                        {{ $permintaan->keterangan_admin }}
                                    </p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- RIGHT/SIDEBAR: Action Panel (1 col on lg) -->
        <div class="lg:col-span-1">

            @if($permintaan->status === 'pending')

                <!-- Warning Stok Tidak Cukup -->
                @if($permintaan->inventory->stok < $permintaan->jumlah)
                    <div class="mb-4 bg-red-50 border-2 border-red-300 rounded-2xl p-4">
                        <div class="flex items-start space-x-3">
                            <div class="w-10 h-10 bg-red-500 rounded-xl flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-red-800 mb-1">⚠️ Stok Tidak Cukup!</p>
                                <p class="text-xs text-red-700">Tersedia: <strong>{{ $permintaan->inventory->stok }} {{ $permintaan->inventory->satuan }}</strong></p>
                                <p class="text-xs text-red-700">Diminta: <strong>{{ $permintaan->jumlah }} {{ $permintaan->inventory->satuan }}</strong></p>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Form Approve -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden mb-4">
                    <div class="bg-gradient-to-r from-green-500 to-teal-500 px-5 py-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-9 h-9 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-base font-bold text-white">✅ Setujui Permintaan</h3>
                        </div>
                    </div>

                    <form action="{{ route('admin.permintaan.approve', $permintaan->id) }}" method="POST" class="p-5">
                        @csrf
                        <div class="mb-4">
                            <label for="keterangan_approve" class="block text-xs font-bold text-gray-600 mb-2 uppercase tracking-wider">
                                💬 Keterangan (Opsional)
                            </label>
                            <textarea name="keterangan_admin"
                                      id="keterangan_approve"
                                      rows="3"
                                      placeholder="Tambahkan catatan untuk CS..."
                                      class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition text-sm"></textarea>
                        </div>
                        <button type="submit"
                                class="w-full px-6 py-3 bg-gradient-to-r from-green-500 to-teal-500 text-white rounded-xl font-bold hover:from-green-600 hover:to-teal-600 transition shadow-lg flex items-center justify-center space-x-2
                                {{ $permintaan->inventory->stok < $permintaan->jumlah ? 'opacity-50 cursor-not-allowed' : '' }}"
                                {{ $permintaan->inventory->stok < $permintaan->jumlah ? 'disabled' : '' }}
                                onclick="return {{ $permintaan->inventory->stok < $permintaan->jumlah ? 'false' : 'confirm(\'Yakin ingin menyetujui? Stok akan dikurangi.\')' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>Setujui Permintaan</span>
                        </button>
                    </form>
                </div>

                <!-- Form Reject -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-red-500 to-pink-500 px-5 py-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-9 h-9 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </div>
                            <h3 class="text-base font-bold text-white">❌ Tolak Permintaan</h3>
                        </div>
                    </div>

                    <form action="{{ route('admin.permintaan.reject', $permintaan->id) }}" method="POST" class="p-5">
                        @csrf
                        <div class="mb-4">
                            <label for="keterangan_reject" class="block text-xs font-bold text-gray-600 mb-2 uppercase tracking-wider">
                                📝 Alasan Penolakan <span class="text-red-500">*</span>
                            </label>
                            <textarea name="keterangan_admin"
                                      id="keterangan_reject"
                                      rows="3"
                                      placeholder="Jelaskan alasan penolakan..."
                                      class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-transparent transition text-sm"
                                      required></textarea>
                        </div>
                        <button type="submit"
                                class="w-full px-6 py-3 bg-gradient-to-r from-red-500 to-pink-500 text-white rounded-xl font-bold hover:from-red-600 hover:to-pink-600 transition shadow-lg flex items-center justify-center space-x-2"
                                onclick="return confirm('Yakin ingin menolak permintaan ini?')">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            <span>Tolak Permintaan</span>
                        </button>
                    </form>
                </div>

            @else

                <!-- Info Sudah Diproses -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8 text-center">
                    @if($permintaan->status === 'approved')
                        <div class="w-20 h-20 mx-auto mb-4 bg-gradient-to-br from-green-100 to-teal-100 rounded-full flex items-center justify-center">
                            <svg class="h-10 w-10 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">✅ Permintaan Disetujui</h3>
                        <p class="text-sm text-gray-600">Stok sudah dikurangi</p>
                    @else
                        <div class="w-20 h-20 mx-auto mb-4 bg-gradient-to-br from-red-100 to-pink-100 rounded-full flex items-center justify-center">
                            <svg class="h-10 w-10 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">❌ Permintaan Ditolak</h3>
                        <p class="text-sm text-gray-600">Tidak ada perubahan stok</p>
                    @endif

                    @if($permintaan->tanggal_approved)
                        <div class="mt-4 p-3 bg-gray-50 rounded-xl border border-gray-200">
                            <p class="text-xs text-gray-500">Diproses pada</p>
                            <p class="text-sm font-bold text-gray-900 mt-1">{{ $permintaan->tanggal_approved->format('d F Y, H:i') }}</p>
                        </div>
                    @endif
                </div>

            @endif
        </div>
    </div>
</div>
@endsection
