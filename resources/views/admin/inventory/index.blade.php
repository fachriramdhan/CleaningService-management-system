@extends('layouts.app-dashboard')

@section('title', 'Kelola Inventory')

@section('nav-links')
    <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 rounded-xl text-sm font-semibold text-gray-600 hover:text-blue-600 hover:bg-blue-50 transition-all">Dashboard</a>
    <a href="{{ route('admin.cs.index') }}" class="px-4 py-2 rounded-xl text-sm font-semibold text-gray-600 hover:text-blue-600 hover:bg-blue-50 transition-all">Team CS</a>
    <a href="{{ route('admin.area.index') }}" class="px-4 py-2 rounded-xl text-sm font-semibold text-gray-600 hover:text-blue-600 hover:bg-blue-50 transition-all"> Area</a>
    <a href="{{ route('admin.atm.index') }}" class="px-4 py-2 rounded-xl text-sm font-semibold text-gray-600 hover:text-blue-600 hover:bg-blue-50 transition-all"> ATM</a>
    <a href="{{ route('admin.inventory.index') }}" class="px-4 py-2 rounded-xl text-sm font-bold bg-gradient-to-r from-blue-500 to-indigo-600 text-white shadow-md hover:shadow-lg transition-all">Inventory</a>
    <a href="{{ route('admin.permintaan.index') }}" class="px-4 py-2 rounded-xl text-sm font-semibold text-gray-600 hover:text-blue-600 hover:bg-blue-50 transition-all">Permintaan</a>
    <a href="{{ route('admin.monitoring.laporan') }}" class="px-4 py-2 rounded-xl text-sm font-semibold text-gray-600 hover:text-blue-600 hover:bg-blue-50 transition-all">Monitoring</a>
@endsection

@section('mobile-nav-links')
    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-3 rounded-xl text-base font-semibold text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-all mb-2">Dashboard</a>
    <a href="{{ route('admin.cs.index') }}" class="block px-4 py-3 rounded-xl text-base font-semibold text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-all mb-2">Team CS</a>
    <a href="{{ route('admin.area.index') }}" class="block px-4 py-3 rounded-xl text-base font-semibold text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-all mb-2">Area</a>
    <a href="{{ route('admin.atm.index') }}" class="block px-4 py-3 rounded-xl text-base font-semibold text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-all mb-2">ATM</a>
    <a href="{{ route('admin.inventory.index') }}" class="block px-4 py-3 rounded-xl text-base font-bold bg-gradient-to-r from-blue-500 to-indigo-600 text-white mb-2">Inventory</a>
    <a href="{{ route('admin.permintaan.index') }}" class="block px-4 py-3 rounded-xl text-base font-semibold text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-all mb-2">Permintaan</a>
    <a href="{{ route('admin.monitoring.laporan') }}" class="block px-4 py-3 rounded-xl text-base font-semibold text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-all mb-2">Monitoring</a>
@endsection

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-3xl md:text-4xl font-bold bg-gradient-to-r from-cyan-600 to-blue-600 bg-clip-text text-transparent">📦 Kelola Inventory</h1>
            <p class="mt-2 text-gray-600">Manajemen alat dan chemical cleaning service</p>
        </div>
        <a href="{{ route('admin.inventory.create') }}" class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-cyan-500 to-blue-500 text-white rounded-xl font-bold hover:from-cyan-600 hover:to-blue-600 transition shadow-lg hover:shadow-xl space-x-2 self-start">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            <span>Tambah Item</span>
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
    <!-- Mobile Cards (< 1024px) -->
    <div class="lg:hidden space-y-4 mb-6">
        @forelse($inventories as $item)
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-cyan-500 to-blue-500 px-4 py-3">
                <div class="flex items-center justify-between">
                    <div class="flex-1 min-w-0">
                        <p class="text-white font-bold text-sm truncate">{{ $item->nama_item }}</p>
                        <div class="flex items-center gap-2 mt-1">
                            @if($item->jenis === 'alat')
                            <span class="inline-flex items-center px-2 py-0.5 bg-white/20 backdrop-blur-sm text-white text-xs font-bold rounded-full">🔧 Alat</span>
                            @else
                            <span class="inline-flex items-center px-2 py-0.5 bg-white/20 backdrop-blur-sm text-white text-xs font-bold rounded-full">🧪 Chemical</span>
                            @endif
                        </div>
                    </div>
                    @if($item->is_active)
                    <span class="px-2 py-1 bg-white/20 backdrop-blur-sm text-white text-xs font-bold rounded-full flex-shrink-0 ml-2">✓ Aktif</span>
                    @else
                    <span class="px-2 py-1 bg-white/20 backdrop-blur-sm text-white text-xs font-bold rounded-full flex-shrink-0 ml-2">✗ Off</span>
                    @endif
                </div>
            </div>
            <div class="p-4 space-y-3">
                @if($item->keterangan)
                <div class="p-2 bg-gray-50 rounded-xl border border-gray-200"><p class="text-xs text-gray-600 line-clamp-2">{{ $item->keterangan }}</p></div>
                @endif
                <div class="p-4 {{ $item->isStokRendah() ? 'bg-gradient-to-br from-red-50 to-orange-50 border-2 border-red-200' : 'bg-gradient-to-br from-cyan-50 to-blue-50 border-2 border-cyan-200' }} rounded-xl text-center">
                    <p class="text-xs font-bold {{ $item->isStokRendah() ? 'text-red-600' : 'text-cyan-600' }} uppercase tracking-wider mb-1">📊 Stok</p>
                    <p class="text-3xl font-black {{ $item->isStokRendah() ? 'text-red-600' : 'text-gray-900' }}">{{ $item->stok }}</p>
                    <p class="text-xs text-gray-600 mt-1">{{ $item->satuan }}</p>
                    @if($item->isStokRendah())
                    <div class="mt-2 flex items-center justify-center text-xs font-bold text-red-700"><svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>Stok Rendah!</div>
                    @endif
                </div>
                <div class="flex space-x-2 pt-2">
                    <a href="{{ route('admin.inventory.show', $item->id) }}" class="flex-1 flex items-center justify-center px-3 py-2 bg-cyan-500 text-white rounded-lg text-xs font-semibold hover:bg-cyan-600 transition">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        Detail
                    </a>
                    <a href="{{ route('admin.inventory.edit', $item->id) }}" class="flex items-center justify-center px-3 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    </a>
                    <form action="{{ route('admin.inventory.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="flex items-center justify-center px-3 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-12 text-center">
            <div class="w-20 h-20 mx-auto mb-4 bg-gradient-to-br from-cyan-100 to-blue-100 rounded-full flex items-center justify-center">
                <svg class="h-10 w-10 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
            </div>
            <p class="text-base font-bold text-gray-700">Belum ada item</p>
        </div>
        @endforelse
    </div>

    <!-- Desktop Table (≥ 1024px) -->
    <div class="hidden lg:block bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr class="bg-gradient-to-r from-cyan-500 to-blue-500">
                        <th class="px-4 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">No</th>
                        <th class="px-4 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Nama Item</th>
                        <th class="px-4 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Jenis</th>
                        <th class="px-4 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Stok</th>
                        <th class="px-4 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Satuan</th>
                        <th class="px-4 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Keterangan</th>
                        <th class="px-4 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Status</th>
                        <th class="px-4 py-4 text-center text-xs font-bold text-white uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse($inventories as $index => $item)
                    <tr class="hover:bg-gradient-to-r hover:from-cyan-50 hover:to-blue-50 transition-colors">
                        <td class="px-4 py-4 whitespace-nowrap">
                            <div class="w-8 h-8 bg-gradient-to-br from-cyan-400 to-blue-500 rounded-full flex items-center justify-center">
                                <span class="text-white font-bold text-xs">{{ $inventories->firstItem() + $index }}</span>
                            </div>
                        </td>
                        <td class="px-4 py-4">
                            <div class="text-sm font-bold text-gray-900">{{ $item->nama_item }}</div>
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap">
                            @if($item->jenis === 'alat')
                            <span class="px-3 py-1 bg-blue-100 text-blue-800 text-xs font-bold rounded-full border border-blue-200">🔧 Alat</span>
                            @else
                            <span class="px-3 py-1 bg-purple-100 text-purple-800 text-xs font-bold rounded-full border border-purple-200">🧪 Chemical</span>
                            @endif
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <span class="text-xl font-black {{ $item->isStokRendah() ? 'text-red-600' : 'text-gray-900' }}">{{ $item->stok }}</span>
                                @if($item->isStokRendah())
                                <svg class="w-5 h-5 ml-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                @endif
                            </div>
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-600">{{ $item->satuan }}</td>
                        <td class="px-4 py-4 text-sm text-gray-500 max-w-xs truncate">{{ $item->keterangan ?? '-' }}</td>
                        <td class="px-4 py-4 whitespace-nowrap">
                            @if($item->is_active)
                            <span class="px-3 py-1 inline-flex items-center text-xs font-bold rounded-full bg-gradient-to-r from-green-100 to-teal-100 text-green-800 border border-green-200">
                                <span class="w-1.5 h-1.5 bg-green-500 rounded-full mr-1.5 animate-pulse"></span>Aktif
                            </span>
                            @else
                            <span class="px-3 py-1 inline-flex items-center text-xs font-bold rounded-full bg-red-100 text-red-800 border border-red-200">
                                <span class="w-1.5 h-1.5 bg-red-500 rounded-full mr-1.5"></span>Nonaktif
                            </span>
                            @endif
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap text-center">
                            <div class="flex items-center justify-center space-x-2">
                                <a href="{{ route('admin.inventory.show', $item->id) }}" class="p-2 bg-cyan-500 text-white rounded-lg hover:bg-cyan-600 transition shadow-sm" title="Detail">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                </a>
                                <a href="{{ route('admin.inventory.edit', $item->id) }}" class="p-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition shadow-sm" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </a>
                                <form action="{{ route('admin.inventory.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition shadow-sm" title="Hapus">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-12 text-center">
                            <div class="w-20 h-20 mx-auto mb-4 bg-gradient-to-br from-cyan-100 to-blue-100 rounded-full flex items-center justify-center">
                                <svg class="h-10 w-10 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                            </div>
                            <p class="text-base font-bold text-gray-700">Belum ada item inventory</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($inventories->hasPages())
        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
            {{ $inventories->links() }}
        </div>
        @endif
    </div>

    <!-- Pagination for Mobile -->
    @if($inventories->hasPages())
    <div class="lg:hidden mt-4">
        {{ $inventories->links() }}
    </div>
    @endif

</div>
@endsection
