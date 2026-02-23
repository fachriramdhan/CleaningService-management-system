@extends('layouts.app-dashboard')

@section('title', 'Detail Item Inventory')

@section('nav-links')
    <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 rounded-xl text-sm font-semibold text-gray-600 hover:text-blue-600 hover:bg-blue-50 transition-all">Dashboard</a>
    <a href="{{ route('admin.inventory.index') }}" class="px-4 py-2 rounded-xl text-sm font-bold bg-gradient-to-r from-blue-500 to-indigo-600 text-white shadow-md hover:shadow-lg transition-all">Kelola Inventory</a>
@endsection

@section('mobile-nav-links')
    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-3 rounded-xl text-base font-semibold text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-all mb-2">Dashboard</a>
    <a href="{{ route('admin.inventory.index') }}" class="block px-4 py-3 rounded-xl text-base font-bold bg-gradient-to-r from-blue-500 to-indigo-600 text-white mb-2">Kelola Inventory</a>
@endsection

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

    <!-- Header -->
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-3xl md:text-4xl font-bold bg-gradient-to-r from-cyan-600 to-blue-600 bg-clip-text text-transparent">📦 {{ $inventory->nama_item }}</h1>
            <p class="mt-2 text-gray-600">Detail informasi inventory</p>
        </div>
        <div class="flex flex-col sm:flex-row gap-2 self-start">
            <a href="{{ route('admin.inventory.edit', $inventory->id) }}" class="inline-flex items-center justify-center px-5 py-2.5 bg-gradient-to-r from-yellow-500 to-orange-500 text-white rounded-xl font-semibold hover:from-yellow-600 hover:to-orange-600 transition shadow-lg space-x-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                <span>Edit</span>
            </a>
            <a href="{{ route('admin.inventory.index') }}" class="inline-flex items-center justify-center px-5 py-2.5 bg-gradient-to-r from-gray-600 to-gray-700 text-white rounded-xl font-semibold hover:from-gray-700 hover:to-gray-800 transition shadow-lg space-x-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                <span>Kembali</span>
            </a>
        </div>
    </div>

    <!-- Alert Success -->
    @if(session('success'))
        <div class="mb-6 bg-green-50 border-l-4 border-green-400 p-4 rounded-xl flex items-center space-x-3">
            <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center flex-shrink-0">
                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
            </div>
            <p class="text-sm text-green-700 font-medium">{{ session('success') }}</p>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- LEFT SIDEBAR: Info Item + Stok Management -->
        <div class="lg:col-span-1 space-y-6">

            <!-- Card Informasi Item -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-cyan-500 to-blue-500 px-6 py-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                        </div>
                        <h3 class="text-base font-bold text-white">Informasi Item</h3>
                    </div>
                </div>

                <div class="p-6 space-y-4">
                    <div class="p-3 bg-cyan-50 rounded-xl border border-cyan-100">
                        <p class="text-xs font-bold text-cyan-600 uppercase tracking-wider mb-1">📦 Nama Item</p>
                        <p class="text-sm font-bold text-gray-900">{{ $inventory->nama_item }}</p>
                    </div>

                    <div class="p-3 bg-gray-50 rounded-xl border border-gray-200">
                        <p class="text-xs font-bold text-gray-600 uppercase tracking-wider mb-2">🏷️ Jenis</p>
                        @if($inventory->jenis === 'alat')
                            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-bold bg-blue-500 text-white">🔧 Alat</span>
                        @else
                            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-bold bg-purple-500 text-white">🧪 Chemical</span>
                        @endif
                    </div>

                    @if($inventory->keterangan)
                        <div class="p-3 bg-gray-50 rounded-xl border border-gray-200">
                            <p class="text-xs font-bold text-gray-600 uppercase tracking-wider mb-1">📝 Keterangan</p>
                            <p class="text-sm text-gray-700 leading-relaxed">{{ $inventory->keterangan }}</p>
                        </div>
                    @endif

                    <div class="p-3 bg-gradient-to-br from-gray-50 to-gray-100 rounded-xl border border-gray-200">
                        <p class="text-xs font-bold text-gray-600 uppercase tracking-wider mb-2">⚡ Status</p>
                        @if($inventory->is_active)
                            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-bold bg-gradient-to-r from-green-100 to-teal-100 text-green-800 border-2 border-green-300">
                                <span class="w-2 h-2 mr-2 bg-green-500 rounded-full animate-pulse"></span>Aktif
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-bold bg-red-100 text-red-800 border-2 border-red-300">
                                <span class="w-2 h-2 mr-2 bg-red-500 rounded-full"></span>Nonaktif
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Card Stok Management -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-indigo-500 to-purple-600 px-6 py-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                        </div>
                        <h3 class="text-base font-bold text-white">Kelola Stok</h3>
                    </div>
                </div>

                <div class="p-6">
                    <!-- Big Stok Display -->
                    <div class="p-6 {{ $inventory->isStokRendah() ? 'bg-gradient-to-br from-red-50 to-orange-50 border-2 border-red-300' : 'bg-gradient-to-br from-cyan-50 to-blue-50 border-2 border-cyan-300' }} rounded-2xl text-center mb-4">
                        <p class="text-xs font-bold {{ $inventory->isStokRendah() ? 'text-red-600' : 'text-cyan-600' }} uppercase tracking-wider mb-2">📊 Stok Saat Ini</p>
                        <p class="text-6xl font-black {{ $inventory->isStokRendah() ? 'text-red-600' : 'text-gray-900' }}">{{ $inventory->stok }}</p>
                        <p class="text-sm text-gray-600 mt-2 font-semibold">{{ $inventory->satuan }}</p>

                        @if($inventory->isStokRendah())
                            <div class="mt-4 p-3 bg-red-100 border border-red-300 rounded-xl">
                                <p class="text-sm text-red-800 flex items-center justify-center font-bold">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                    ⚠️ Stok Rendah!
                                </p>
                            </div>
                        @endif
                    </div>

                    <!-- Action Buttons -->
                    <div class="space-y-3">
                        <button onclick="openTambahStokModal()" class="w-full px-5 py-3 bg-gradient-to-r from-green-500 to-teal-500 text-white rounded-xl font-bold hover:from-green-600 hover:to-teal-600 transition shadow-lg hover:shadow-xl flex items-center justify-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                            <span>Tambah Stok</span>
                        </button>

                        <button onclick="openKurangiStokModal()" class="w-full px-5 py-3 bg-gradient-to-r from-red-500 to-pink-500 text-white rounded-xl font-bold hover:from-red-600 hover:to-pink-600 transition shadow-lg hover:shadow-xl flex items-center justify-center space-x-2 {{ $inventory->stok == 0 ? 'opacity-50 cursor-not-allowed' : '' }}" {{ $inventory->stok == 0 ? 'disabled' : '' }}>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path></svg>
                            <span>Kurangi Stok</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- RIGHT: Riwayat Transaksi -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-orange-500 to-amber-500 px-6 py-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-9 h-9 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <h3 class="text-base font-bold text-white">📜 Riwayat Transaksi</h3>
                    </div>
                </div>

                <div class="p-6">
                    @if($logs->count() > 0)
                        <div class="space-y-3">
                            @foreach($logs as $log)
                                <div class="flex items-start p-4 {{ $log->tipe === 'masuk' ? 'bg-green-50 border-l-4 border-green-400' : 'bg-red-50 border-l-4 border-red-400' }} rounded-xl hover:shadow-md transition">
                                    <div class="flex-shrink-0">
                                        <div class="w-10 h-10 {{ $log->tipe === 'masuk' ? 'bg-green-500' : 'bg-red-500' }} rounded-xl flex items-center justify-center">
                                            @if($log->tipe === 'masuk')
                                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                            @else
                                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path></svg>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="ml-3 flex-1 min-w-0">
                                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-1">
                                            <p class="text-sm font-bold {{ $log->tipe === 'masuk' ? 'text-green-900' : 'text-red-900' }}">
                                                {{ $log->tipe === 'masuk' ? '📈 Stok Masuk' : '📉 Stok Keluar' }}
                                            </p>
                                            <p class="text-base font-black {{ $log->tipe === 'masuk' ? 'text-green-900' : 'text-red-900' }}">
                                                {{ $log->tipe === 'masuk' ? '+' : '-' }}{{ $log->jumlah }} {{ $inventory->satuan }}
                                            </p>
                                        </div>
                                        <p class="text-xs text-gray-600 mt-1 flex flex-wrap items-center gap-x-2">
                                            <span>📅 {{ $log->tanggal->format('d M Y, H:i') }}</span>
                                            <span>•</span>
                                            <span>👤 @if($log->csProfile){{ $log->csProfile->user->name }}@else Admin @endif</span>
                                        </p>
                                        @if($log->keterangan)
                                            <div class="mt-2 p-2 bg-white/50 rounded-lg border border-gray-200">
                                                <p class="text-sm text-gray-700">💬 {{ $log->keterangan }}</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        @if($logs->hasPages())
                            <div class="mt-4">{{ $logs->links() }}</div>
                        @endif
                    @else
                        <div class="text-center py-12">
                            <div class="w-16 h-16 mx-auto mb-3 bg-gray-100 rounded-full flex items-center justify-center">
                                <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            </div>
                            <h3 class="text-sm font-bold text-gray-700">Belum ada riwayat transaksi</h3>
                            <p class="text-sm text-gray-500 mt-1">Transaksi akan muncul di sini</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Stok -->
<div id="tambahStokModal" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-md w-full shadow-2xl overflow-hidden">
        <div class="bg-gradient-to-r from-green-500 to-teal-500 px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-9 h-9 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    </div>
                    <h3 class="text-lg font-bold text-white">➕ Tambah Stok</h3>
                </div>
                <button onclick="closeTambahStokModal()" class="text-white/80 hover:text-white transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
        </div>
        <form action="{{ route('admin.inventory.tambah-stok', $inventory->id) }}" method="POST">
            @csrf
            <div class="p-6 space-y-4">
                <div>
                    <label for="jumlah_tambah" class="block text-xs font-bold text-gray-600 mb-2 uppercase tracking-wider">🔢 Jumlah</label>
                    <input type="number" name="jumlah" id="jumlah_tambah" min="1" class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition" required placeholder="Masukkan jumlah...">
                </div>
                <div>
                    <label for="keterangan_tambah" class="block text-xs font-bold text-gray-600 mb-2 uppercase tracking-wider">📝 Keterangan</label>
                    <textarea name="keterangan" id="keterangan_tambah" rows="3" class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition" placeholder="Opsional - tambahkan catatan..."></textarea>
                </div>
            </div>
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex flex-col-reverse sm:flex-row justify-end gap-3">
                <button type="button" onclick="closeTambahStokModal()" class="px-5 py-2.5 border-2 border-gray-300 rounded-xl text-sm font-semibold text-gray-700 hover:bg-gray-100 transition">Batal</button>
                <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-green-500 to-teal-500 text-white rounded-xl text-sm font-bold hover:from-green-600 hover:to-teal-600 transition shadow-lg">Tambah Stok</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Kurangi Stok -->
<div id="kurangiStokModal" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-md w-full shadow-2xl overflow-hidden">
        <div class="bg-gradient-to-r from-red-500 to-pink-500 px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-9 h-9 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path></svg>
                    </div>
                    <h3 class="text-lg font-bold text-white">➖ Kurangi Stok</h3>
                </div>
                <button onclick="closeKurangiStokModal()" class="text-white/80 hover:text-white transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
        </div>
        <form action="{{ route('admin.inventory.kurangi-stok', $inventory->id) }}" method="POST">
            @csrf
            <div class="p-6 space-y-4">
                <div>
                    <label for="jumlah_kurang" class="block text-xs font-bold text-gray-600 mb-2 uppercase tracking-wider">🔢 Jumlah</label>
                    <input type="number" name="jumlah" id="jumlah_kurang" min="1" max="{{ $inventory->stok }}" class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-transparent transition" required placeholder="Masukkan jumlah...">
                    <p class="mt-1 text-xs text-gray-500">Maksimal: <strong>{{ $inventory->stok }} {{ $inventory->satuan }}</strong></p>
                </div>
                <div>
                    <label for="keterangan_kurang" class="block text-xs font-bold text-gray-600 mb-2 uppercase tracking-wider">📝 Keterangan</label>
                    <textarea name="keterangan" id="keterangan_kurang" rows="3" class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-transparent transition" placeholder="Opsional - tambahkan catatan..."></textarea>
                </div>
            </div>
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex flex-col-reverse sm:flex-row justify-end gap-3">
                <button type="button" onclick="closeKurangiStokModal()" class="px-5 py-2.5 border-2 border-gray-300 rounded-xl text-sm font-semibold text-gray-700 hover:bg-gray-100 transition">Batal</button>
                <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-red-500 to-pink-500 text-white rounded-xl text-sm font-bold hover:from-red-600 hover:to-pink-600 transition shadow-lg">Kurangi Stok</button>
            </div>
        </form>
    </div>
</div>

<script>
function openTambahStokModal() {
    document.getElementById('tambahStokModal').classList.remove('hidden');
}
function closeTambahStokModal() {
    document.getElementById('tambahStokModal').classList.add('hidden');
}
function openKurangiStokModal() {
    document.getElementById('kurangiStokModal').classList.remove('hidden');
}
function closeKurangiStokModal() {
    document.getElementById('kurangiStokModal').classList.add('hidden');
}
</script>
@endsection
