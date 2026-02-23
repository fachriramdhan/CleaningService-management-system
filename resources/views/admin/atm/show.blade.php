@extends('layouts.app-dashboard')

@section('title', 'Detail ATM')

@section('nav-links')
    <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 rounded-xl text-sm font-semibold text-gray-600 hover:text-blue-600 hover:bg-blue-50 transition-all">Dashboard</a>
    <a href="{{ route('admin.atm.index') }}" class="px-4 py-2 rounded-xl text-sm font-bold bg-gradient-to-r from-blue-500 to-indigo-600 text-white shadow-md hover:shadow-lg transition-all">Kelola ATM</a>
@endsection

@section('mobile-nav-links')
    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-3 rounded-xl text-base font-semibold text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-all mb-2">Dashboard</a>
    <a href="{{ route('admin.atm.index') }}" class="block px-4 py-3 rounded-xl text-base font-bold bg-gradient-to-r from-blue-500 to-indigo-600 text-white mb-2">Kelola ATM</a>
@endsection

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-3xl md:text-4xl font-bold bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">🏧 {{ $atm->nama_atm }}</h1>
            <p class="mt-2 text-gray-600">Detail informasi ATM</p>
        </div>
        <div class="flex flex-col sm:flex-row gap-2 self-start">
            <a href="{{ route('admin.atm.edit', $atm->id) }}" class="inline-flex items-center justify-center px-5 py-2.5 bg-gradient-to-r from-yellow-500 to-orange-500 text-white rounded-xl font-semibold hover:from-yellow-600 hover:to-orange-600 transition shadow-lg space-x-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                <span>Edit</span>
            </a>
            <a href="{{ route('admin.atm.index') }}" class="inline-flex items-center justify-center px-5 py-2.5 bg-gradient-to-r from-gray-600 to-gray-700 text-white rounded-xl font-semibold hover:from-gray-700 hover:to-gray-800 transition shadow-lg space-x-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                <span>Kembali</span>
            </a>
        </div>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-purple-500 to-pink-500 px-6 py-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        </div>
                        <h3 class="text-base font-bold text-white">Informasi ATM</h3>
                    </div>
                </div>
                <div class="p-6 space-y-4">
                    <div class="p-3 bg-purple-50 rounded-xl border border-purple-100">
                        <p class="text-xs font-bold text-purple-600 uppercase tracking-wider mb-1">🏧 Nama ATM</p>
                        <p class="text-sm font-bold text-gray-900">{{ $atm->nama_atm }}</p>
                    </div>
                    <div class="p-3 bg-blue-50 rounded-xl border border-blue-100">
                        <p class="text-xs font-bold text-blue-600 uppercase tracking-wider mb-1">📍 Area</p>
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-bold bg-blue-500 text-white">{{ $atm->area->nama_area }}</span>
                    </div>
                    <div class="p-3 bg-green-50 rounded-xl border border-green-100">
                        <p class="text-xs font-bold text-green-600 uppercase tracking-wider mb-1">🗺️ Lokasi</p>
                        <p class="text-sm font-bold text-gray-900">{{ $atm->lokasi }}</p>
                    </div>
                    @if($atm->alamat_lengkap)
                    <div class="p-3 bg-gray-50 rounded-xl border border-gray-200">
                        <p class="text-xs font-bold text-gray-600 uppercase tracking-wider mb-1">📮 Alamat Lengkap</p>
                        <p class="text-sm text-gray-700 leading-relaxed">{{ $atm->alamat_lengkap }}</p>
                    </div>
                    @endif
                    <div class="p-3 bg-gradient-to-br from-gray-50 to-gray-100 rounded-xl border border-gray-200">
                        <p class="text-xs font-bold text-gray-600 uppercase tracking-wider mb-2">⚡ Status</p>
                        @if($atm->is_active)
                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-bold bg-gradient-to-r from-green-100 to-teal-100 text-green-800 border-2 border-green-300">
                            <span class="w-2 h-2 mr-2 bg-green-500 rounded-full animate-pulse"></span>Aktif
                        </span>
                        @else
                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-bold bg-red-100 text-red-800 border-2 border-red-300">
                            <span class="w-2 h-2 mr-2 bg-red-500 rounded-full"></span>Nonaktif
                        </span>
                        @endif
                    </div>
                    <div class="p-4 bg-purple-50 rounded-xl border border-purple-200 text-center">
                        <svg class="w-8 h-8 mx-auto mb-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        <p class="text-xs text-purple-600 font-semibold mb-1">Total Laporan</p>
                        <p class="text-2xl font-black text-purple-700">{{ $atm->laporanAtms->count() }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-indigo-500 to-purple-600 px-6 py-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-9 h-9 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <h3 class="text-base font-bold text-white">📊 Riwayat Laporan Pembersihan</h3>
                    </div>
                </div>
                <div class="p-6">
                    @if($atm->laporanAtms->count() > 0)
                    <div class="space-y-3">
                        @foreach($atm->laporanAtms->take(10) as $laporan)
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl border border-gray-200 hover:border-purple-300 hover:bg-purple-50 transition">
                            <div class="flex items-center flex-1 min-w-0">
                                <img src="{{ $laporan->csProfile->foto === 'default-avatar.png' ? 'https://ui-avatars.com/api/?name=' . urlencode($laporan->csProfile->user->name) . '&size=80&background=a855f7&color=fff' : asset('storage/' . $laporan->csProfile->foto) }}" alt="{{ $laporan->csProfile->user->name }}" class="w-10 h-10 rounded-full object-cover border-2 border-purple-300 shadow flex-shrink-0">
                                <div class="ml-3 flex-1 min-w-0">
                                    <p class="text-sm font-bold text-gray-900 truncate">{{ $laporan->csProfile->user->name }}</p>
                                    <p class="text-xs text-gray-500">📅 {{ $laporan->tanggal->format('d M Y') }} • ⏰ {{ $laporan->created_at->format('H:i') }}</p>
                                </div>
                            </div>
                            <div class="ml-3 flex-shrink-0 text-right">
                                @if($laporan->catatan)
                                <p class="text-xs text-gray-600 max-w-xs truncate">💬 {{ $laporan->catatan }}</p>
                                @else
                                <p class="text-xs text-gray-400 italic">Tidak ada catatan</p>
                                @endif
                            </div>
                        </div>
                        @endforeach
                        @if($atm->laporanAtms->count() > 10)
                        <p class="text-sm text-gray-500 text-center pt-2">Dan {{ $atm->laporanAtms->count() - 10 }} laporan lainnya...</p>
                        @endif
                    </div>
                    @else
                    <div class="text-center py-12">
                        <div class="w-16 h-16 mx-auto mb-3 bg-gray-100 rounded-full flex items-center justify-center">
                            <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                        <h3 class="text-sm font-bold text-gray-700">Belum ada laporan</h3>
                        <p class="text-sm text-gray-500 mt-1">ATM ini belum pernah dibersihkan</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
