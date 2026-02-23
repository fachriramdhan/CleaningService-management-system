@extends('layouts.app-dashboard')

@section('title', 'Tambah ATM')

@section('nav-links')
    <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 rounded-xl text-sm font-semibold text-gray-600 hover:text-blue-600 hover:bg-blue-50 transition-all">Dashboard</a>
    <a href="{{ route('admin.atm.index') }}" class="px-4 py-2 rounded-xl text-sm font-bold bg-gradient-to-r from-blue-500 to-indigo-600 text-white shadow-md hover:shadow-lg transition-all">Kelola ATM</a>
@endsection

@section('mobile-nav-links')
    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-3 rounded-xl text-base font-semibold text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-all mb-2">Dashboard</a>
    <a href="{{ route('admin.atm.index') }}" class="block px-4 py-3 rounded-xl text-base font-bold bg-gradient-to-r from-blue-500 to-indigo-600 text-white mb-2">Kelola ATM</a>
@endsection

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-8">
        <h1 class="text-3xl md:text-4xl font-bold bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">➕ Tambah ATM Baru</h1>
        <p class="mt-2 text-gray-600">Tambahkan lokasi ATM baru untuk dibersihkan</p>
    </div>
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="bg-gradient-to-r from-purple-500 to-pink-500 px-6 py-4">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-white">Form Tambah ATM</h2>
                    <p class="text-white/70 text-xs">Semua field bertanda * wajib diisi</p>
                </div>
            </div>
        </div>
        <form action="{{ route('admin.atm.store') }}" method="POST">
            @csrf
            <div class="p-6 space-y-6">
                <div>
                    <label for="area_id" class="block text-xs font-bold text-gray-600 mb-2 uppercase tracking-wider">📍 Area <span class="text-red-500">*</span></label>
                    <select name="area_id" id="area_id" class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition @error('area_id') border-red-400 @enderror" required>
                        <option value="">-- Pilih Area --</option>
                        @foreach($areas as $area)
                        <option value="{{ $area->id }}" {{ old('area_id', request('area_id')) == $area->id ? 'selected' : '' }}>{{ $area->nama_area }}</option>
                        @endforeach
                    </select>
                    @error('area_id')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="nama_atm" class="block text-xs font-bold text-gray-600 mb-2 uppercase tracking-wider">🏧 Nama ATM <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_atm" id="nama_atm" value="{{ old('nama_atm') }}" placeholder="Contoh: ATM BCA Cikini" class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition @error('nama_atm') border-red-400 @enderror" required>
                    @error('nama_atm')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="lokasi" class="block text-xs font-bold text-gray-600 mb-2 uppercase tracking-wider">🗺️ Lokasi <span class="text-red-500">*</span></label>
                    <input type="text" name="lokasi" id="lokasi" value="{{ old('lokasi') }}" placeholder="Contoh: Jakarta Pusat" class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition @error('lokasi') border-red-400 @enderror" required>
                    @error('lokasi')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="alamat_lengkap" class="block text-xs font-bold text-gray-600 mb-2 uppercase tracking-wider">📮 Alamat Lengkap</label>
                    <textarea name="alamat_lengkap" id="alamat_lengkap" rows="3" placeholder="Jalan, nomor, gedung, patokan, dll..." class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition @error('alamat_lengkap') border-red-400 @enderror">{{ old('alamat_lengkap') }}</textarea>
                    <p class="mt-1 text-xs text-gray-500">Opsional - tambahkan detail alamat untuk memudahkan CS</p>
                    @error('alamat_lengkap')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div class="p-4 bg-purple-50 border-l-4 border-purple-400 rounded-xl">
                    <div class="flex items-start space-x-3">
                        <div class="w-6 h-6 bg-purple-500 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-purple-800 mb-1">💡 Info</p>
                            <p class="text-xs text-purple-700">ATM baru akan otomatis dalam status <strong>aktif</strong>. CS dapat langsung membuat laporan pembersihan setelah ATM ditambahkan.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex flex-col sm:flex-row justify-end gap-3">
                <a href="{{ route('admin.atm.index') }}" class="inline-flex items-center justify-center px-6 py-3 bg-white border-2 border-gray-300 rounded-xl font-semibold text-sm text-gray-700 hover:bg-gray-50 transition">Batal</a>
                <button type="submit" class="inline-flex items-center justify-center px-8 py-3 bg-gradient-to-r from-purple-500 to-pink-500 text-white rounded-xl font-bold text-sm hover:from-purple-600 hover:to-pink-600 transition shadow-lg hover:shadow-xl space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    <span>Simpan ATM</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
