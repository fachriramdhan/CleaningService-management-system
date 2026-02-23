@extends('layouts.app-dashboard')

@section('title', 'Kelola Permintaan Inventory')

@section('nav-links')
    <a href="{{ route('admin.dashboard') }}"
       class="px-4 py-2 rounded-xl text-sm font-semibold text-gray-600 hover:text-blue-600 hover:bg-blue-50 transition-all">
        Dashboard
    </a>
    <a href="{{ route('admin.cs.index') }}"
       class="px-4 py-2 rounded-xl text-sm font-semibold text-gray-600 hover:text-blue-600 hover:bg-blue-50 transition-all">
        Team CS
    </a>
    <a href="{{ route('admin.area.index') }}"
       class="px-4 py-2 rounded-xl text-sm font-semibold text-gray-600 hover:text-blue-600 hover:bg-blue-50 transition-all">
         Area
    </a>
    <a href="{{ route('admin.atm.index') }}"
       class="px-4 py-2 rounded-xl text-sm font-semibold text-gray-600 hover:text-blue-600 hover:bg-blue-50 transition-all">
         ATM
    </a>
    <a href="{{ route('admin.inventory.index') }}"
       class="px-4 py-2 rounded-xl text-sm font-semibold text-gray-600 hover:text-blue-600 hover:bg-blue-50 transition-all">
        Inventory
    </a>
    <a href="{{ route('admin.permintaan.index') }}"
      class="px-4 py-2 rounded-xl text-sm font-bold bg-gradient-to-r from-blue-500 to-indigo-600 text-white shadow-md hover:shadow-lg transition-all">
        Permintaan
    </a>
    <a href="{{ route('admin.monitoring.laporan') }}"
       class="px-4 py-2 rounded-xl text-sm font-semibold text-gray-600 hover:text-blue-600 hover:bg-blue-50 transition-all">
        Monitoring
    </a>
@endsection

@section('mobile-nav-links')
    <a href="{{ route('admin.dashboard') }}"
       class="block px-4 py-3 rounded-xl text-base font-semibold text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-all mb-2">
        Dashboard
    </a>
    <a href="{{ route('admin.cs.index') }}"
       class="block px-4 py-3 rounded-xl text-base font-semibold text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-all mb-2">
        Kelola CS
    </a>
    <a href="{{ route('admin.area.index') }}"
       class="block px-4 py-3 rounded-xl text-base font-semibold text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-all mb-2">
        Kelola Area
    </a>
    <a href="{{ route('admin.atm.index') }}"
       class="block px-4 py-3 rounded-xl text-base font-semibold text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-all mb-2">
        Kelola ATM
    </a>
    <a href="{{ route('admin.inventory.index') }}"
       class="block px-4 py-3 rounded-xl text-base font-semibold text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-all mb-2">
        Inventory
    </a>
    <a href="{{ route('admin.permintaan.index') }}"
       class="block px-4 py-3 rounded-xl text-base font-bold bg-gradient-to-r from-blue-500 to-indigo-600 text-white mb-2">
        Permintaan
    </a>
    <a href="{{ route('admin.monitoring.laporan') }}"
       class="block px-4 py-3 rounded-xl text-base font-semibold text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-all mb-2">
        Monitoring
    </a>
@endsection

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl md:text-4xl font-bold bg-gradient-to-r from-orange-600 to-pink-600 bg-clip-text text-transparent">
            📋 Kelola Permintaan Inventory
        </h1>
        <p class="mt-2 text-gray-600">Approve atau tolak permintaan alat/chemical dari CS</p>
    </div>

    <!-- Alerts -->
    @if(session('success'))
        <div class="mb-6 bg-green-50 border-l-4 border-green-400 p-4 rounded-xl flex items-center space-x-3">
            <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center flex-shrink-0">
                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
            </div>
            <p class="text-sm text-green-700 font-medium">{{ session('success') }}</p>
        </div>
    @endif

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

    <!-- Filter Card -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-5 mb-6">
        <form method="GET" action="{{ route('admin.permintaan.index') }}" class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
            <div class="flex-1">
                <label class="block text-xs font-bold text-gray-600 mb-2 uppercase tracking-wider">🔍 Filter Status</label>
                <select name="status"
                        class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent transition text-sm">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>⏳ Pending</option>
                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>✅ Disetujui</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>❌ Ditolak</option>
                </select>
            </div>
            <div class="sm:mt-7">
                <button type="submit"
                        class="w-full sm:w-auto px-8 py-3 bg-gradient-to-r from-orange-500 to-pink-500 text-white rounded-xl font-bold hover:from-orange-600 hover:to-pink-600 transition shadow-lg">
                    Filter
                </button>
            </div>
        </form>
    </div>

    <!-- MOBILE: Cards (< 1024px) -->
    <div class="lg:hidden space-y-4 mb-6">
        @forelse($permintaans as $index => $permintaan)
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="
                    @if($permintaan->status === 'pending') bg-gradient-to-r from-yellow-400 to-orange-500
                    @elseif($permintaan->status === 'approved') bg-gradient-to-r from-green-400 to-teal-500
                    @else bg-gradient-to-r from-red-400 to-pink-500
                    @endif px-4 py-3">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-white font-bold text-sm">{{ $permintaan->csProfile->user->name }}</p>
                            <p class="text-white/70 text-xs">{{ $permintaan->inventory->nama_item }}</p>
                        </div>
                        <span class="px-2 py-1 bg-white/20 backdrop-blur-sm text-white text-xs font-bold rounded-full">
                            @if($permintaan->status === 'pending') ⏳ Pending
                            @elseif($permintaan->status === 'approved') ✅ OK
                            @else ❌ Tolak
                            @endif
                        </span>
                    </div>
                </div>

                <div class="p-4 space-y-3">
                    <!-- Info Grid -->
                    <div class="grid grid-cols-2 gap-2">
                        <div class="p-2 bg-gray-50 rounded-xl">
                            <p class="text-xs text-gray-500">Jenis</p>
                            <p class="text-xs font-bold text-gray-900 capitalize">{{ $permintaan->jenis_permintaan }}</p>
                        </div>
                        <div class="p-2 bg-gray-50 rounded-xl">
                            <p class="text-xs text-gray-500">Jumlah</p>
                            <p class="text-xs font-bold text-gray-900">{{ $permintaan->jumlah }} {{ $permintaan->inventory->satuan }}</p>
                        </div>
                    </div>

                    <div class="p-2 bg-blue-50 rounded-xl border border-blue-100">
                        <p class="text-xs text-blue-600 font-semibold">📅 {{ $permintaan->created_at->format('d M Y, H:i') }}</p>
                    </div>

                    <!-- Button -->
                    <a href="{{ route('admin.permintaan.show', $permintaan->id) }}"
                       class="flex items-center justify-center w-full px-4 py-2.5 bg-gradient-to-r from-orange-500 to-pink-500 text-white rounded-xl text-sm font-semibold hover:from-orange-600 hover:to-pink-600 transition shadow">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        Lihat Detail
                    </a>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-12 text-center">
                <div class="w-20 h-20 mx-auto mb-4 bg-gradient-to-br from-orange-100 to-pink-100 rounded-full flex items-center justify-center">
                    <svg class="h-10 w-10 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </div>
                <p class="text-base font-bold text-gray-700">Tidak ada permintaan</p>
                <p class="text-sm text-gray-500 mt-1">Permintaan dari CS akan muncul di sini</p>
            </div>
        @endforelse
    </div>

    <!-- DESKTOP: Table (≥ 1024px) -->
    <div class="hidden lg:block bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr class="bg-gradient-to-r from-orange-500 to-pink-500">
                        <th class="px-4 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">No</th>
                        <th class="px-4 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">CS</th>
                        <th class="px-4 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Item</th>
                        <th class="px-4 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Jenis</th>
                        <th class="px-4 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Jumlah</th>
                        <th class="px-4 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Tanggal</th>
                        <th class="px-4 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Status</th>
                        <th class="px-4 py-4 text-center text-xs font-bold text-white uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse($permintaans as $index => $permintaan)
                        <tr class="hover:bg-gradient-to-r hover:from-orange-50 hover:to-pink-50 transition-colors">
                            <td class="px-4 py-4 whitespace-nowrap">
                                <div class="w-8 h-8 bg-gradient-to-br from-orange-400 to-pink-500 rounded-full flex items-center justify-center">
                                    <span class="text-white font-bold text-xs">{{ $permintaans->firstItem() + $index }}</span>
                                </div>
                            </td>
                            <td class="px-4 py-4">
                                <div class="text-sm font-bold text-gray-900">{{ $permintaan->csProfile->user->name }}</div>
                                <div class="text-xs text-gray-500">{{ $permintaan->csProfile->user->email }}</div>
                            </td>
                            <td class="px-4 py-4">
                                <span class="text-sm font-semibold text-gray-900">{{ $permintaan->inventory->nama_item }}</span>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 inline-flex text-xs font-bold rounded-full {{ $permintaan->jenis_permintaan === 'pinjam' ? 'bg-blue-100 text-blue-800 border border-blue-200' : 'bg-purple-100 text-purple-800 border border-purple-200' }}">
                                    {{ $permintaan->jenis_permintaan === 'pinjam' ? '🔄 Pinjam' : '📤 Ambil' }}
                                </span>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap">
                                <span class="text-sm font-bold text-gray-900">{{ $permintaan->jumlah }}</span>
                                <span class="text-xs text-gray-500">{{ $permintaan->inventory->satuan }}</span>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 bg-gray-100 text-gray-700 text-xs font-semibold rounded-lg">
                                    {{ $permintaan->created_at->format('d M Y') }}
                                </span>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap">
                                @if($permintaan->status === 'pending')
                                    <span class="px-3 py-1 inline-flex items-center text-xs font-bold rounded-full bg-yellow-100 text-yellow-800 border border-yellow-200">
                                        <span class="w-1.5 h-1.5 bg-yellow-500 rounded-full mr-1.5 animate-pulse"></span>Pending
                                    </span>
                                @elseif($permintaan->status === 'approved')
                                    <span class="px-3 py-1 inline-flex items-center text-xs font-bold rounded-full bg-gradient-to-r from-green-100 to-teal-100 text-green-800 border border-green-200">
                                        <span class="w-1.5 h-1.5 bg-green-500 rounded-full mr-1.5"></span>Disetujui
                                    </span>
                                @else
                                    <span class="px-3 py-1 inline-flex items-center text-xs font-bold rounded-full bg-red-100 text-red-800 border border-red-200">
                                        <span class="w-1.5 h-1.5 bg-red-500 rounded-full mr-1.5"></span>Ditolak
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap text-center">
                                <a href="{{ route('admin.permintaan.show', $permintaan->id) }}"
                                   class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-orange-500 to-pink-500 text-white rounded-lg text-xs font-semibold hover:from-orange-600 hover:to-pink-600 transition shadow-sm">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center">
                                <div class="w-20 h-20 mx-auto mb-4 bg-gradient-to-br from-orange-100 to-pink-100 rounded-full flex items-center justify-center">
                                    <svg class="h-10 w-10 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                    </svg>
                                </div>
                                <p class="text-base font-bold text-gray-700">Tidak ada permintaan</p>
                                <p class="text-sm text-gray-500 mt-1">Permintaan dari CS akan muncul di sini</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($permintaans->hasPages())
            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                {{ $permintaans->appends(request()->query())->links() }}
            </div>
        @endif
    </div>

    <!-- Mobile Pagination -->
    @if($permintaans->hasPages())
        <div class="lg:hidden mt-4">
            {{ $permintaans->appends(request()->query())->links() }}
        </div>
    @endif

</div>
@endsection
