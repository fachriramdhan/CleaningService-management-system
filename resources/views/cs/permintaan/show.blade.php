@extends('layouts.app-dashboard')

@section('title', 'Detail Permintaan')

@section('nav-links')
    <a href="{{ route('cs.dashboard') }}" class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium text-gray-500 hover:text-gray-700">Dashboard</a>
    <a href="{{ route('cs.permintaan.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 border-indigo-400 text-sm font-medium text-gray-900">Permintaan Alat</a>
@endsection

@section('mobile-nav-links')
    <a href="{{ route('cs.dashboard') }}" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50">Dashboard</a>
    <a href="{{ route('cs.permintaan.index') }}" class="block pl-3 pr-4 py-2 border-l-4 border-indigo-400 text-base font-medium text-indigo-700 bg-indigo-50">Permintaan Alat</a>
@endsection

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

    <!-- Header -->
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-3xl md:text-4xl font-bold bg-gradient-to-r from-teal-600 to-cyan-600 bg-clip-text text-transparent">
                📋 Detail Permintaan
            </h1>
            <p class="mt-2 text-gray-600 font-medium">{{ $permintaan->inventory->nama_item }}</p>
        </div>
        <a href="{{ route('cs.permintaan.index') }}"
           class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-gray-600 to-gray-700 text-white rounded-xl font-semibold hover:from-gray-700 hover:to-gray-800 transition shadow-lg space-x-2 self-start">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            <span>Kembali</span>
        </a>
    </div>

    <!-- Hero Status Banner -->
    <div class="mb-8 rounded-2xl shadow-xl overflow-hidden">
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
                <div class="grid grid-cols-2 gap-2 sm:gap-3">
                    <div class="bg-white/15 backdrop-blur-sm rounded-xl p-3 text-center">
                        <p class="text-white/70 text-xs">Diajukan</p>
                        <p class="text-white font-bold text-xs mt-1">{{ $permintaan->created_at->format('d M Y') }}</p>
                    </div>
                    <div class="bg-white/15 backdrop-blur-sm rounded-xl p-3 text-center">
                        <p class="text-white/70 text-xs">Jumlah</p>
                        <p class="text-white font-bold text-sm mt-1">{{ $permintaan->jumlah }} {{ $permintaan->inventory->satuan }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 2 Column Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <!-- LEFT: Info Permintaan -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-teal-500 to-cyan-500 px-5 py-4">
                <div class="flex items-center space-x-3">
                    <div class="w-9 h-9 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                    <h3 class="text-base font-bold text-white">Informasi Permintaan</h3>
                </div>
            </div>
            <div class="p-5 space-y-3">
                <div class="p-3 bg-gray-50 rounded-xl">
                    <p class="text-xs text-gray-500 mb-1">Nama Item</p>
                    <p class="text-sm font-bold text-gray-900">{{ $permintaan->inventory->nama_item }}</p>
                </div>

                <div class="p-3 bg-gray-50 rounded-xl flex items-center justify-between">
                    <div>
                        <p class="text-xs text-gray-500 mb-1">Jenis Item</p>
                        @if($permintaan->inventory->jenis === 'alat')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-800 border border-blue-200">
                                🔧 Alat
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-purple-100 text-purple-800 border border-purple-200">
                                🧪 Chemical
                            </span>
                        @endif
                    </div>
                    <div class="text-right">
                        <p class="text-xs text-gray-500 mb-1">Jenis Permintaan</p>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold
                            @if($permintaan->jenis_permintaan === 'pinjam') bg-orange-100 text-orange-800 border border-orange-200
                            @else bg-teal-100 text-teal-800 border border-teal-200
                            @endif">
                            {{ $permintaan->jenis_permintaan === 'pinjam' ? '🔄 Pinjam' : '📤 Ambil' }}
                        </span>
                    </div>
                </div>

                <div class="p-3 bg-teal-50 rounded-xl border border-teal-100">
                    <p class="text-xs text-gray-500 mb-1">Jumlah Diminta</p>
                    <p class="text-2xl font-black text-teal-700">{{ $permintaan->jumlah }} <span class="text-base font-semibold">{{ $permintaan->inventory->satuan }}</span></p>
                </div>

                <div class="p-3 bg-gray-50 rounded-xl">
                    <p class="text-xs text-gray-500 mb-1">🕐 Tanggal Pengajuan</p>
                    <p class="text-sm font-semibold text-gray-900">{{ $permintaan->created_at->format('d F Y, H:i') }}</p>
                </div>

                @if($permintaan->tanggal_approved)
                    <div class="p-3 bg-gray-50 rounded-xl">
                        <p class="text-xs text-gray-500 mb-1">⚡ Tanggal Diproses</p>
                        <p class="text-sm font-semibold text-gray-900">{{ $permintaan->tanggal_approved->format('d F Y, H:i') }}</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- RIGHT: Alasan & Keterangan Admin -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-indigo-500 to-purple-600 px-5 py-4">
                <div class="flex items-center space-x-3">
                    <div class="w-9 h-9 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-base font-bold text-white">Detail & Respons</h3>
                </div>
            </div>
            <div class="p-5 space-y-4">
                <!-- Alasan -->
                <div>
                    <p class="text-xs font-bold text-gray-600 uppercase tracking-wider mb-2">📝 Alasan / Keperluan</p>
                    <div class="p-4 bg-gray-50 rounded-xl border border-gray-200">
                        <p class="text-sm text-gray-700 leading-relaxed">{{ $permintaan->alasan }}</p>
                    </div>
                </div>

                <!-- Keterangan Admin -->
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
                @else
                    @if($permintaan->status === 'pending')
                        <div class="p-4 bg-yellow-50 rounded-xl border border-yellow-200 text-center">
                            <div class="w-10 h-10 bg-yellow-400 rounded-full flex items-center justify-center mx-auto mb-2">
                                <svg class="w-5 h-5 text-white animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <p class="text-sm font-bold text-yellow-800">Menunggu Respons Admin</p>
                            <p class="text-xs text-yellow-700 mt-1">Permintaan kamu sedang ditinjau</p>
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>

    <!-- Bottom Back Button -->
    <div class="mt-8 flex justify-center">
        <a href="{{ route('cs.permintaan.index') }}"
           class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-teal-500 to-cyan-600 text-white rounded-2xl hover:from-teal-600 hover:to-cyan-700 transition font-bold shadow-xl hover:shadow-2xl space-x-2 text-lg">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z"></path>
            </svg>
            <span>Kembali ke Daftar Permintaan</span>
        </a>
    </div>
</div>
@endsection
