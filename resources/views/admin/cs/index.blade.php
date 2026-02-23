@extends('layouts.app-dashboard')

@section('title', 'Kelola CS')

@section('nav-links')
    <a href="{{ route('admin.dashboard') }}"
       class="px-4 py-2 rounded-xl text-sm font-semibold text-gray-600 hover:text-blue-600 hover:bg-blue-50 transition-all">
        Dashboard
    </a>
    <a href="{{ route('admin.cs.index') }}"
       class="px-4 py-2 rounded-xl text-sm font-bold bg-gradient-to-r from-blue-500 to-indigo-600 text-white shadow-md hover:shadow-lg transition-all">
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
       class="px-4 py-2 rounded-xl text-sm font-semibold text-gray-600 hover:text-blue-600 hover:bg-blue-50 transition-all">
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
       class="block px-4 py-3 rounded-xl text-base font-bold bg-gradient-to-r from-blue-500 to-indigo-600 text-white mb-2">
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
       class="block px-4 py-3 rounded-xl text-base font-semibold text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-all mb-2">
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
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-3xl md:text-4xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">
                👥 Kelola Cleaning Service
            </h1>
            <p class="mt-2 text-gray-600">Manajemen data pekerja cleaning service</p>
        </div>
        <a href="{{ route('admin.cs.create') }}"
           class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-xl font-bold hover:from-blue-600 hover:to-indigo-700 transition shadow-lg hover:shadow-xl space-x-2 self-start">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            <span>Tambah CS Baru</span>
        </a>
    </div>

    <!-- Alert Success -->
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

   <div class="lg:hidden grid grid-cols-2 gap-3 mb-6">
    @forelse($csProfiles as $index => $cs)
        <div class="bg-white rounded-2xl shadow-md border border-gray-100 overflow-hidden flex flex-col justify-between">
            <div>
                <div class="bg-gradient-to-br from-blue-500 to-indigo-600 p-3 relative">
                    <div class="flex flex-col items-center text-center space-y-2">
                        <div class="relative">
                            <img src="{{ $cs->foto === 'default-avatar.png' ? 'https://ui-avatars.com/api/?name=' . urlencode($cs->user->name) . '&size=80&background=10b981&color=fff' : asset('storage/' . $cs->foto) }}"
                                 alt="{{ $cs->user->name }}"
                                 class="w-14 h-14 rounded-full object-cover border-2 border-white shadow-sm">

                            <span class="absolute bottom-0 right-0 w-4 h-4 {{ $cs->is_active ? 'bg-green-400' : 'bg-red-400' }} border-2 border-white rounded-full"></span>
                        </div>
                        <div>
                            <p class="text-white font-bold text-xs truncate w-32 leading-tight">{{ $cs->user->name }}</p>
                            <p class="text-white/70 text-[10px] truncate w-32 italic">{{ $cs->user->email }}</p>
                        </div>
                    </div>
                </div>

                <div class="p-3 space-y-3">
                    <div class="grid grid-cols-1 gap-1.5">
                        <div class="px-2 py-1.5 bg-gray-50 rounded-lg border border-gray-100">
                            <p class="text-[9px] uppercase tracking-wider text-gray-400 font-semibold">Mulai Kerja</p>
                            <p class="text-[10px] font-bold text-gray-800">{{ $cs->tanggal_mulai_kerja->format('d/m/y') }}</p>
                        </div>
                        <div class="px-2 py-1.5 bg-gray-50 rounded-lg border border-gray-100">
                            <p class="text-[9px] uppercase tracking-wider text-gray-400 font-semibold">Lama Kerja</p>
                            <p class="text-[10px] font-bold text-gray-800">{{ $cs->lama_kerja_tahun }}th {{ $cs->lama_kerja_bulan }}bl</p>
                        </div>
                    </div>

                    <div>
                        <p class="text-[10px] text-gray-500 mb-1 font-medium">📍 Area Tugas</p>
                        <div class="flex flex-wrap gap-1 max-h-12 overflow-y-auto no-scrollbar">
                            @foreach($cs->areas as $area)
                                <span class="px-1.5 py-0.5 bg-blue-50 text-blue-700 text-[9px] font-bold rounded-md border border-blue-100 uppercase">
                                    {{ $area->nama_area }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-2 pt-0 grid grid-cols-3 gap-1">
                <a href="{{ route('admin.cs.show', $cs->id) }}"
                   class="flex items-center justify-center py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                </a>
                <a href="{{ route('admin.cs.edit', $cs->id) }}"
                   class="flex items-center justify-center py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                </a>
                <form action="{{ route('admin.cs.destroy', $cs->id) }}" method="POST" class="w-full" onsubmit="return confirm('Yakin ingin menghapus CS ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full flex items-center justify-center py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    @empty
        <div class="col-span-2 bg-white rounded-2xl shadow-lg border border-gray-100 p-8 text-center">
            <div class="w-16 h-16 mx-auto mb-4 bg-blue-50 rounded-full flex items-center justify-center">
                <svg class="h-8 w-8 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
            </div>
            <p class="text-sm font-bold text-gray-700">Belum ada data CS</p>
            <a href="{{ route('admin.cs.create') }}" class="mt-3 inline-block text-xs font-bold text-blue-600">Tambah Data +</a>
        </div>
    @endforelse
</div>

    <!-- DESKTOP: Table (≥ 1024px) -->
    <div class="hidden lg:block bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr class="bg-gradient-to-r from-blue-500 to-indigo-600">
                        <th class="px-4 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">No</th>
                        <th class="px-4 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Foto</th>
                        <th class="px-4 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Nama & Email</th>
                        <th class="px-4 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Area Tugas</th>
                        <th class="px-4 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Mulai Kerja</th>
                        <th class="px-4 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Lama Kerja</th>
                        <th class="px-4 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Status</th>
                        <th class="px-4 py-4 text-center text-xs font-bold text-white uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse($csProfiles as $index => $cs)
                        <tr class="hover:bg-gradient-to-r hover:from-blue-50 hover:to-indigo-50 transition-colors">
                            <td class="px-4 py-4 whitespace-nowrap">
                                <div class="w-8 h-8 bg-gradient-to-br from-blue-400 to-indigo-500 rounded-full flex items-center justify-center">
                                    <span class="text-white font-bold text-xs">{{ $csProfiles->firstItem() + $index }}</span>
                                </div>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap">
                                <img src="{{ $cs->foto === 'default-avatar.png' ? 'https://ui-avatars.com/api/?name=' . urlencode($cs->user->name) . '&size=80&background=10b981&color=fff' : asset('storage/' . $cs->foto) }}"
                                     alt="{{ $cs->user->name }}"
                                     class="w-10 h-10 rounded-full object-cover border-2 border-blue-300 shadow">
                            </td>
                            <td class="px-4 py-4">
                                <div class="text-sm font-bold text-gray-900">{{ $cs->user->name }}</div>
                                <div class="text-xs text-gray-500">{{ $cs->user->email }}</div>
                            </td>
                            <td class="px-4 py-4">
                                <div class="flex flex-wrap gap-1">
                                    @foreach($cs->areas as $area)
                                        <span class="px-2 py-0.5 bg-blue-100 text-blue-800 text-xs font-semibold rounded-full">{{ $area->nama_area }}</span>
                                    @endforeach
                                </div>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 bg-gray-100 text-gray-700 text-xs font-semibold rounded-lg">
                                    {{ $cs->tanggal_mulai_kerja->format('d M Y') }}
                                </span>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap">
                                <span class="text-xs font-bold text-gray-900">{{ $cs->lama_kerja_tahun }}th {{ $cs->lama_kerja_bulan }}bl</span>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap">
                                @if($cs->is_active)
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
                                    <a href="{{ route('admin.cs.show', $cs->id) }}"
                                       class="p-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition shadow-sm"
                                       title="Detail">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </a>
                                    <a href="{{ route('admin.cs.edit', $cs->id) }}"
                                       class="p-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition shadow-sm"
                                       title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </a>
                                    <form action="{{ route('admin.cs.destroy', $cs->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus CS ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="p-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition shadow-sm"
                                                title="Hapus">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center">
                                <div class="w-20 h-20 mx-auto mb-4 bg-gradient-to-br from-blue-100 to-indigo-100 rounded-full flex items-center justify-center">
                                    <svg class="h-10 w-10 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                    </svg>
                                </div>
                                <p class="text-base font-bold text-gray-700">Belum ada data CS</p>
                                <p class="text-sm text-gray-500 mt-1">Tambahkan cleaning service pertama</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($csProfiles->hasPages())
            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                {{ $csProfiles->links() }}
            </div>
        @endif
    </div>

    <!-- Mobile Pagination -->
    @if($csProfiles->hasPages())
        <div class="lg:hidden mt-4">
            {{ $csProfiles->links() }}
        </div>
    @endif

</div>
@endsection
