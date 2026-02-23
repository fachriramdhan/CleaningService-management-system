@extends('layouts.app-dashboard')

@section('title', 'Permintaan Alat/Chemical')

@section('nav-links')
    <a href="{{ route('cs.dashboard') }}" class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium text-gray-500 hover:text-gray-700">Dashboard</a>
    <a href="{{ route('cs.absensi.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium text-gray-500 hover:text-gray-700">Absensi</a>
    <a href="{{ route('cs.laporan.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium text-gray-500 hover:text-gray-700">Laporan ATM</a>
    <a href="{{ route('cs.permintaan.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 border-indigo-400 text-sm font-medium text-gray-900">Permintaan Alat</a>
@endsection

@section('mobile-nav-links')
    <a href="{{ route('cs.dashboard') }}" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50">Dashboard</a>
    <a href="{{ route('cs.absensi.index') }}" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50">Absensi</a>
    <a href="{{ route('cs.laporan.index') }}" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50">Laporan ATM</a>
    <a href="{{ route('cs.permintaan.index') }}" class="block pl-3 pr-4 py-2 border-l-4 border-indigo-400 text-base font-medium text-indigo-700 bg-indigo-50">Permintaan Alat</a>
@endsection

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

    <!-- Header -->
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-3xl md:text-4xl font-bold bg-gradient-to-r from-teal-600 to-cyan-600 bg-clip-text text-transparent">
                📦 Permintaan Alat/Chemical
            </h1>
            <p class="mt-2 text-gray-600 flex items-center space-x-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
                <span>Ajukan permintaan pinjam atau ambil alat/chemical</span>
            </p>
        </div>
        <a href="{{ route('cs.permintaan.create') }}"
           class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-teal-500 to-cyan-600 text-white rounded-xl font-bold hover:from-teal-600 hover:to-cyan-700 transition shadow-lg hover:shadow-xl space-x-2 self-start">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            <span>Ajukan Permintaan</span>
        </a>
    </div>

    <!-- Alert Success -->
    @if(session('success'))
        <div class="mb-6 bg-green-50 border-l-4 border-green-400 p-4 rounded-xl flex items-center space-x-3">
            <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center flex-shrink-0">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <p class="text-sm text-green-700 font-medium">{{ session('success') }}</p>
        </div>
    @endif

    <!-- Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
        @forelse($permintaans as $permintaan)
            <div class="group bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden hover:shadow-xl transition-all">

                <!-- Card Header sesuai status -->
                <div class="px-5 py-4
                    @if($permintaan->status === 'pending') bg-gradient-to-r from-yellow-400 to-orange-500
                    @elseif($permintaan->status === 'approved') bg-gradient-to-r from-green-400 to-teal-500
                    @else bg-gradient-to-r from-red-400 to-pink-500
                    @endif">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <div class="w-8 h-8 bg-white/20 backdrop-blur-sm rounded-lg flex items-center justify-center">
                                @if($permintaan->inventory->jenis === 'alat')
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                @else
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                                    </svg>
                                @endif
                            </div>
                            <div>
                                <p class="text-white font-bold text-sm truncate max-w-[140px]">{{ $permintaan->inventory->nama_item }}</p>
                                <p class="text-white/70 text-xs">{{ ucfirst($permintaan->inventory->jenis) }}</p>
                            </div>
                        </div>
                        <span class="px-2 py-1 bg-white/20 backdrop-blur-sm text-white text-xs font-bold rounded-full">
                            @if($permintaan->status === 'pending') ⏳ Pending
                            @elseif($permintaan->status === 'approved') ✅ Disetujui
                            @else ❌ Ditolak
                            @endif
                        </span>
                    </div>
                </div>

                <!-- Card Body -->
                <div class="p-5">
                    <!-- Info Grid -->
                    <div class="grid grid-cols-2 gap-2 mb-4">
                        <div class="p-2 bg-gray-50 rounded-xl text-center">
                            <p class="text-xs text-gray-500">Jenis</p>
                            <p class="text-xs font-bold text-gray-900 mt-0.5 capitalize">{{ $permintaan->jenis_permintaan }}</p>
                        </div>
                        <div class="p-2 bg-gray-50 rounded-xl text-center">
                            <p class="text-xs text-gray-500">Jumlah</p>
                            <p class="text-xs font-bold text-gray-900 mt-0.5">{{ $permintaan->jumlah }} {{ $permintaan->inventory->satuan }}</p>
                        </div>
                    </div>

                    <!-- Alasan -->
                    <div class="mb-3 p-3 bg-gray-50 rounded-xl">
                        <p class="text-xs text-gray-500 mb-1">📝 Alasan</p>
                        <p class="text-xs text-gray-700">{{ Str::limit($permintaan->alasan, 70) }}</p>
                    </div>

                    <!-- Keterangan Admin -->
                    @if($permintaan->keterangan_admin)
                        <div class="mb-3 p-3 rounded-xl border
                            @if($permintaan->status === 'approved') bg-green-50 border-green-200
                            @else bg-red-50 border-red-200
                            @endif">
                            <p class="text-xs font-bold mb-1
                                @if($permintaan->status === 'approved') text-green-700
                                @else text-red-700
                                @endif">
                                💬 Keterangan Admin
                            </p>
                            <p class="text-xs
                                @if($permintaan->status === 'approved') text-green-700
                                @else text-red-700
                                @endif">
                                {{ Str::limit($permintaan->keterangan_admin, 60) }}
                            </p>
                        </div>
                    @endif

                    <!-- Tanggal -->
                    <p class="text-xs text-gray-400 mb-4">
                        🕐 {{ $permintaan->created_at->format('d M Y, H:i') }}
                        @if($permintaan->tanggal_approved)
                            · Diproses {{ $permintaan->tanggal_approved->format('d M Y') }}
                        @endif
                    </p>

                    <!-- Button -->
                    <a href="{{ route('cs.permintaan.show', $permintaan->id) }}"
                       class="flex items-center justify-center w-full px-4 py-2.5 bg-gradient-to-r from-teal-500 to-cyan-600 text-white rounded-xl text-sm font-semibold hover:from-teal-600 hover:to-cyan-700 transition shadow space-x-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        <span>Lihat Detail</span>
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-3 bg-white rounded-2xl shadow-lg border border-gray-100 p-16 text-center">
                <div class="w-24 h-24 mx-auto mb-5 bg-gradient-to-br from-teal-100 to-cyan-100 rounded-full flex items-center justify-center">
                    <svg class="h-12 w-12 text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </div>
                <p class="text-base font-bold text-gray-900 mb-1">Belum ada permintaan</p>
                <p class="text-sm text-gray-500 mb-6">Mulai ajukan permintaan alat atau chemical yang kamu butuhkan</p>
                <a href="{{ route('cs.permintaan.create') }}"
                   class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-teal-500 to-cyan-600 text-white rounded-xl font-bold hover:from-teal-600 hover:to-cyan-700 transition shadow-lg space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <span>Ajukan Permintaan</span>
                </a>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($permintaans->hasPages())
        <div class="mt-6">{{ $permintaans->links() }}</div>
    @endif
</div>
@endsection
