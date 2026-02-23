@extends('layouts.app-dashboard')

@section('title', 'Detail Permintaan')

@section('nav-links')
    <a href="{{ route('koordinator.dashboard') }}" class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium text-gray-500 hover:text-gray-700">
        Dashboard
    </a>
    <a href="{{ route('koordinator.permintaan.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 border-indigo-400 text-sm font-medium text-gray-900">
        Permintaan
    </a>
@endsection

@section('mobile-nav-links')
    <a href="{{ route('koordinator.dashboard') }}" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50">
        Dashboard
    </a>
    <a href="{{ route('koordinator.permintaan.index') }}" class="block pl-3 pr-4 py-2 border-l-4 border-indigo-400 text-base font-medium text-indigo-700 bg-indigo-50">
        Permintaan
    </a>
@endsection

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between flex-wrap gap-4">
            <div>
                <h1 class="text-3xl md:text-4xl font-bold bg-gradient-to-r from-orange-600 to-pink-600 bg-clip-text text-transparent">
                    📋 Detail Permintaan
                </h1>
                <p class="mt-2 text-gray-600 flex items-center space-x-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                    <span>{{ $permintaan->inventory->nama_item }}</span>
                </p>
            </div>
            <a href="{{ route('koordinator.permintaan.index') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-gray-600 to-gray-700 text-white rounded-xl hover:from-gray-700 hover:to-gray-800 transition font-semibold shadow-lg space-x-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span>Kembali</span>
            </a>
        </div>
    </div>

    <!-- Status Card -->
    <div class="mb-8 bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="bg-gradient-to-r from-{{ $permintaan->status === 'pending' ? 'yellow-400 to-orange-500' : ($permintaan->status === 'approved' ? 'green-400 to-teal-500' : 'red-400 to-pink-500') }} p-8 text-center">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-white/20 backdrop-blur-sm rounded-full mb-4">
                @if($permintaan->status === 'pending')
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                @elseif($permintaan->status === 'approved')
                    <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                @else
                    <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                    </svg>
                @endif
            </div>
            <h3 class="text-2xl font-bold text-white mb-2">
                @if($permintaan->status === 'pending')
                    ⏳ Menunggu Persetujuan Admin
                @elseif($permintaan->status === 'approved')
                    ✅ Permintaan Disetujui
                @else
                    ❌ Permintaan Ditolak
                @endif
            </h3>
            <p class="text-white/80 text-sm">Status permintaan inventory</p>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Info Permintaan -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-blue-500 to-purple-600 px-6 py-4">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-white">Informasi Permintaan</h3>
                </div>
            </div>
            <div class="p-6 space-y-4">
                <!-- CS -->
                <div class="flex items-start space-x-3 p-3 bg-gradient-to-r from-blue-50 to-purple-50 rounded-xl">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center flex-shrink-0">
                        <span class="text-white font-bold text-sm">{{ substr($permintaan->csProfile->user->name, 0, 1) }}</span>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">CS yang Mengajukan</p>
                        <p class="text-sm font-semibold text-gray-900">{{ $permintaan->csProfile->user->name }}</p>
                        <p class="text-xs text-gray-600">{{ $permintaan->csProfile->user->email }}</p>
                    </div>
                </div>

                <!-- Item -->
                <div class="p-3 bg-gray-50 rounded-xl">
                    <p class="text-xs text-gray-500 mb-1">Item yang Diminta</p>
                    <p class="text-sm font-semibold text-gray-900">{{ $permintaan->inventory->nama_item }}</p>
                </div>

                <!-- Jenis -->
                <div class="p-3 bg-gray-50 rounded-xl">
                    <p class="text-xs text-gray-500 mb-2">Jenis Permintaan</p>
                    <span class="inline-flex items-center px-3 py-1 bg-{{ $permintaan->jenis_permintaan === 'pinjam' ? 'blue' : 'purple' }}-100 text-{{ $permintaan->jenis_permintaan === 'pinjam' ? 'blue' : 'purple' }}-700 text-sm font-semibold rounded-full">
                        {{ ucfirst($permintaan->jenis_permintaan) }}
                    </span>
                </div>

                <!-- Jumlah -->
                <div class="p-3 bg-gray-50 rounded-xl">
                    <p class="text-xs text-gray-500 mb-1">Jumlah</p>
                    <p class="text-lg font-bold text-gray-900">{{ $permintaan->jumlah }} <span class="text-sm font-normal text-gray-600">{{ $permintaan->inventory->satuan }}</span></p>
                </div>

                <!-- Tanggal -->
                <div class="p-3 bg-gray-50 rounded-xl">
                    <p class="text-xs text-gray-500 mb-1">Tanggal Pengajuan</p>
                    <p class="text-sm font-semibold text-gray-900 flex items-center space-x-2">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <span>{{ $permintaan->created_at->format('d F Y, H:i') }}</span>
                    </p>
                </div>
            </div>
        </div>

        <!-- Alasan & Keterangan Admin -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-green-500 to-teal-600 px-6 py-4">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-white">Detail & Keterangan</h3>
                </div>
            </div>
            <div class="p-6 space-y-4">
                <!-- Alasan -->
                <div>
                    <p class="text-xs text-gray-500 mb-2 font-semibold">📝 Alasan Permintaan</p>
                    <div class="p-4 bg-gradient-to-r from-blue-50 to-cyan-50 rounded-xl border border-blue-100">
                        <p class="text-sm text-gray-700 leading-relaxed">{{ $permintaan->alasan }}</p>
                    </div>
                </div>

                @if($permintaan->keterangan_admin)
                    <!-- Keterangan Admin -->
                    <div>
                        <p class="text-xs text-gray-500 mb-2 font-semibold flex items-center space-x-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>Keterangan dari Admin</span>
                        </p>
                        <div class="p-4 bg-gradient-to-r from-{{ $permintaan->status === 'approved' ? 'green-50 to-teal-50 border-green' : 'red-50 to-pink-50 border-red' }}-100 rounded-xl border">
                            <p class="text-sm font-semibold {{ $permintaan->status === 'approved' ? 'text-green-700' : 'text-red-700' }} leading-relaxed">
                                {{ $permintaan->keterangan_admin }}
                            </p>
                        </div>
                    </div>

                    @if($permintaan->tanggal_approved)
                        <!-- Tanggal Diproses -->
                        <div class="p-3 bg-gray-50 rounded-xl">
                            <p class="text-xs text-gray-500 mb-1">Tanggal Diproses</p>
                            <p class="text-sm font-semibold text-gray-900">
                                {{ \Carbon\Carbon::parse($permintaan->tanggal_approved)->format('d F Y, H:i') }}
                            </p>
                        </div>
                    @endif
                @else
                    <!-- Waiting State -->
                    <div class="p-6 bg-gradient-to-r from-yellow-50 to-orange-50 rounded-xl border border-yellow-200 text-center">
                        <div class="w-16 h-16 mx-auto mb-3 bg-yellow-100 rounded-full flex items-center justify-center">
                            <svg class="w-8 h-8 text-yellow-600 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <p class="text-sm font-semibold text-yellow-800">Menunggu Review dari Admin</p>
                        <p class="text-xs text-yellow-600 mt-1">Permintaan sedang dalam antrian</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Action Button (Back) -->
    <div class="flex justify-center">
        <a href="{{ route('koordinator.permintaan.index') }}" class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-blue-500 to-purple-600 text-white rounded-2xl hover:from-blue-600 hover:to-purple-700 transition font-bold shadow-xl hover:shadow-2xl space-x-2 text-lg">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z"></path>
            </svg>
            <span>Kembali ke Daftar Permintaan</span>
        </a>
    </div>
</div>
@endsection
