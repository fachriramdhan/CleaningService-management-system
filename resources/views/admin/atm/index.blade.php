@extends('layouts.app-dashboard')

@section('title', 'Kelola ATM')

@section('nav-links')
    <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 rounded-xl text-sm font-semibold text-gray-600 hover:text-blue-600 hover:bg-blue-50 transition-all">Dashboard</a>
    <a href="{{ route('admin.cs.index') }}" class="px-4 py-2 rounded-xl text-sm font-semibold text-gray-600 hover:text-blue-600 hover:bg-blue-50 transition-all"> Team CS</a>
    <a href="{{ route('admin.area.index') }}" class="px-4 py-2 rounded-xl text-sm font-semibold text-gray-600 hover:text-blue-600 hover:bg-blue-50 transition-all">Area</a>
    <a href="{{ route('admin.atm.index') }}" class="px-4 py-2 rounded-xl text-sm font-bold bg-gradient-to-r from-blue-500 to-indigo-600 text-white shadow-md hover:shadow-lg transition-all">ATM</a>
    <a href="{{ route('admin.inventory.index') }}" class="px-4 py-2 rounded-xl text-sm font-semibold text-gray-600 hover:text-blue-600 hover:bg-blue-50 transition-all">Inventory</a>
    <a href="{{ route('admin.permintaan.index') }}" class="px-4 py-2 rounded-xl text-sm font-semibold text-gray-600 hover:text-blue-600 hover:bg-blue-50 transition-all">Permintaan</a>
    <a href="{{ route('admin.monitoring.laporan') }}" class="px-4 py-2 rounded-xl text-sm font-semibold text-gray-600 hover:text-blue-600 hover:bg-blue-50 transition-all">Monitoring</a>
@endsection

@section('mobile-nav-links')
    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-3 rounded-xl text-base font-semibold text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-all mb-2">Dashboard</a>
    <a href="{{ route('admin.cs.index') }}" class="block px-4 py-3 rounded-xl text-base font-semibold text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-all mb-2">Team CS</a>
    <a href="{{ route('admin.area.index') }}" class="block px-4 py-3 rounded-xl text-base font-semibold text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-all mb-2">Area</a>
    <a href="{{ route('admin.atm.index') }}" class="block px-4 py-3 rounded-xl text-base font-bold bg-gradient-to-r from-blue-500 to-indigo-600 text-white mb-2">ATM</a>
    <a href="{{ route('admin.inventory.index') }}" class="block px-4 py-3 rounded-xl text-base font-semibold text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-all mb-2">Inventory</a>
    <a href="{{ route('admin.permintaan.index') }}" class="block px-4 py-3 rounded-xl text-base font-semibold text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-all mb-2">Permintaan</a>
    <a href="{{ route('admin.monitoring.laporan') }}" class="block px-4 py-3 rounded-xl text-base font-semibold text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-all mb-2">Monitoring</a>
@endsection

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-3xl md:text-4xl font-bold bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">🏧 Kelola ATM</h1>
            <p class="mt-2 text-gray-600">Manajemen lokasi ATM yang dibersihkan</p>
        </div>
        <a href="{{ route('admin.atm.create') }}" class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-purple-500 to-pink-500 text-white rounded-xl font-bold hover:from-purple-600 hover:to-pink-600 transition shadow-lg hover:shadow-xl space-x-2 self-start">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            <span>Tambah ATM</span>
        </a>
    </div>
    @if(session('success'))
    <div class="mb-6 bg-green-50 border-l-4 border-green-400 p-4 rounded-xl flex items-center space-x-3">
        <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center flex-shrink-0"><svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg></div>
        <p class="text-sm text-green-700 font-medium">{{ session('success') }}</p>
    </div>
    @endif
    @if(session('error'))
    <div class="mb-6 bg-red-50 border-l-4 border-red-400 p-4 rounded-xl flex items-center space-x-3">
        <div class="w-8 h-8 bg-red-500 rounded-full flex items-center justify-center flex-shrink-0"><svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg></div>
        <p class="text-sm text-red-700 font-medium">{{ session('error') }}</p>
    </div>
    @endif
    <div class="lg:hidden space-y-4 mb-6">
        @forelse($atms as $index => $atm)
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-purple-500 to-pink-500 px-4 py-3">
                <div class="flex items-center justify-between">
                    <div class="flex-1 min-w-0"><p class="text-white font-bold text-sm truncate">{{ $atm->nama_atm }}</p><p class="text-white/70 text-xs truncate">📍 {{ $atm->lokasi }}</p></div>
                    @if($atm->is_active)<span class="px-2 py-1 bg-white/20 backdrop-blur-sm text-white text-xs font-bold rounded-full flex-shrink-0">✓ Aktif</span>@else<span class="px-2 py-1 bg-white/20 backdrop-blur-sm text-white text-xs font-bold rounded-full flex-shrink-0">✗ Off</span>@endif
                </div>
            </div>
            <div class="p-4 space-y-3">
                <div class="grid grid-cols-2 gap-2">
                    <div class="p-2 bg-blue-50 rounded-xl"><p class="text-xs text-blue-600">Area</p><p class="text-xs font-bold text-blue-800 truncate">{{ $atm->area->nama_area }}</p></div>
                    <div class="p-2 bg-purple-50 rounded-xl"><p class="text-xs text-purple-600">Laporan</p><p class="text-xs font-bold text-purple-800">{{ $atm->laporanAtms->count() }}</p></div>
                </div>
                @if($atm->alamat_lengkap)<div class="p-2 bg-gray-50 rounded-xl border border-gray-200"><p class="text-xs text-gray-600 line-clamp-2">{{ $atm->alamat_lengkap }}</p></div>@endif
                <div class="flex space-x-2 pt-2"><a href="{{ route('admin.atm.show', $atm->id) }}" class="flex-1 flex items-center justify-center px-3 py-2 bg-purple-500 text-white rounded-lg text-xs font-semibold hover:bg-purple-600 transition"><svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>Detail</a><a href="{{ route('admin.atm.edit', $atm->id) }}" class="flex items-center justify-center px-3 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg></a><form action="{{ route('admin.atm.destroy', $atm->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin?')">@csrf @method('DELETE')<button type="submit" class="flex items-center justify-center px-3 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></button></form></div>
            </div>
        </div>
        @empty
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-12 text-center"><div class="w-20 h-20 mx-auto mb-4 bg-gradient-to-br from-purple-100 to-pink-100 rounded-full flex items-center justify-center"><svg class="h-10 w-10 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg></div><p class="text-base font-bold text-gray-700">Belum ada ATM</p></div>
        @endforelse
    </div>
    <div class="hidden lg:block bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden"><div class="overflow-x-auto"><table class="min-w-full divide-y divide-gray-200"><thead><tr class="bg-gradient-to-r from-purple-500 to-pink-500"><th class="px-4 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">No</th><th class="px-4 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Nama ATM</th><th class="px-4 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Area</th><th class="px-4 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Lokasi</th><th class="px-4 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Alamat</th><th class="px-4 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Status</th><th class="px-4 py-4 text-center text-xs font-bold text-white uppercase tracking-wider">Aksi</th></tr></thead><tbody class="bg-white divide-y divide-gray-100">@forelse($atms as $index => $atm)<tr class="hover:bg-gradient-to-r hover:from-purple-50 hover:to-pink-50 transition-colors"><td class="px-4 py-4 whitespace-nowrap"><div class="w-8 h-8 bg-gradient-to-br from-purple-400 to-pink-500 rounded-full flex items-center justify-center"><span class="text-white font-bold text-xs">{{ $atms->firstItem() + $index }}</span></div></td><td class="px-4 py-4"><div class="text-sm font-bold text-gray-900">{{ $atm->nama_atm }}</div></td><td class="px-4 py-4 whitespace-nowrap"><span class="px-3 py-1 bg-blue-100 text-blue-800 text-xs font-bold rounded-full border border-blue-200">{{ $atm->area->nama_area }}</span></td><td class="px-4 py-4 whitespace-nowrap text-sm text-gray-600">{{ $atm->lokasi }}</td><td class="px-4 py-4 text-sm text-gray-500 max-w-xs truncate">{{ $atm->alamat_lengkap ?? '-' }}</td><td class="px-4 py-4 whitespace-nowrap">@if($atm->is_active)<span class="px-3 py-1 inline-flex items-center text-xs font-bold rounded-full bg-gradient-to-r from-green-100 to-teal-100 text-green-800 border border-green-200"><span class="w-1.5 h-1.5 bg-green-500 rounded-full mr-1.5 animate-pulse"></span>Aktif</span>@else<span class="px-3 py-1 inline-flex items-center text-xs font-bold rounded-full bg-red-100 text-red-800 border border-red-200"><span class="w-1.5 h-1.5 bg-red-500 rounded-full mr-1.5"></span>Nonaktif</span>@endif</td><td class="px-4 py-4 whitespace-nowrap text-center"><div class="flex items-center justify-center space-x-2"><a href="{{ route('admin.atm.show', $atm->id) }}" class="p-2 bg-purple-500 text-white rounded-lg hover:bg-purple-600 transition shadow-sm" title="Detail"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg></a><a href="{{ route('admin.atm.edit', $atm->id) }}" class="p-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition shadow-sm" title="Edit"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg></a><form action="{{ route('admin.atm.destroy', $atm->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin?')">@csrf @method('DELETE')<button type="submit" class="p-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition shadow-sm" title="Hapus"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></button></form></div></td></tr>@empty<tr><td colspan="7" class="px-6 py-12 text-center"><div class="w-20 h-20 mx-auto mb-4 bg-gradient-to-br from-purple-100 to-pink-100 rounded-full flex items-center justify-center"><svg class="h-10 w-10 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg></div><p class="text-base font-bold text-gray-700">Belum ada ATM</p></td></tr>@endforelse</tbody></table></div>@if($atms->hasPages())<div class="px-6 py-4 border-t border-gray-200 bg-gray-50">{{ $atms->links() }}</div>@endif</div>@if($atms->hasPages())<div class="lg:hidden mt-4">{{ $atms->links() }}</div>@endif
</div>
@endsection
