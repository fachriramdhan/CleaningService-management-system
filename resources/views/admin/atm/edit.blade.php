@extends('layouts.app-dashboard')

@section('title', 'Edit ATM')

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
        <h1 class="text-3xl md:text-4xl font-bold bg-gradient-to-r from-yellow-600 to-orange-600 bg-clip-text text-transparent">✏️ Edit ATM</h1>
        <p class="mt-2 text-gray-600">Update informasi: {{ $atm->nama_atm }}</p>
    </div>
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="bg-gradient-to-r from-yellow-500 to-orange-500 px-6 py-4">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-white">Form Edit ATM</h2>
                    <p class="text-white/70 text-xs">Update data ATM yang sudah ada</p>
                </div>
            </div>
        </div>
        <form action="{{ route('admin.atm.update', $atm->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="p-6 space-y-6">
                <div>
                    <label for="area_id" class="block text-xs font-bold text-gray-600 mb-2 uppercase tracking-wider">📍 Area <span class="text-red-500">*</span></label>
                    <select name="area_id" id="area_id" class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition @error('area_id') border-red-400 @enderror" required>
                        <option value="">-- Pilih Area --</option>
                        @foreach($areas as $area)
                        <option value="{{ $area->id }}" {{ old('area_id', $atm->area_id) == $area->id ? 'selected' : '' }}>{{ $area->nama_area }}</option>
                        @endforeach
                    </select>
                    @error('area_id')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="nama_atm" class="block text-xs font-bold text-gray-600 mb-2 uppercase tracking-wider">🏧 Nama ATM <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_atm" id="nama_atm" value="{{ old('nama_atm', $atm->nama_atm) }}" class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition @error('nama_atm') border-red-400 @enderror" required>
                    @error('nama_atm')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="lokasi" class="block text-xs font-bold text-gray-600 mb-2 uppercase tracking-wider">🗺️ Lokasi <span class="text-red-500">*</span></label>
                    <input type="text" name="lokasi" id="lokasi" value="{{ old('lokasi', $atm->lokasi) }}" class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition @error('lokasi') border-red-400 @enderror" required>
                    @error('lokasi')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="alamat_lengkap" class="block text-xs font-bold text-gray-600 mb-2 uppercase tracking-wider">📮 Alamat Lengkap</label>
                    <textarea name="alamat_lengkap" id="alamat_lengkap" rows="3" placeholder="Jalan, nomor, gedung, patokan..." class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition @error('alamat_lengkap') border-red-400 @enderror">{{ old('alamat_lengkap', $atm->alamat_lengkap) }}</textarea>
                    @error('alamat_lengkap')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div class="p-4 bg-gray-50 rounded-xl border-2 border-gray-200">
                    <label class="flex items-start cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $atm->is_active) ? 'checked' : '' }} class="mt-1 w-5 h-5 rounded border-gray-300 text-yellow-600 focus:ring-yellow-500">
                        <div class="ml-3">
                            <span class="text-sm font-bold text-gray-900">✅ ATM Aktif</span>
                            <p class="text-xs text-gray-500 mt-0.5">Nonaktifkan jika ATM sudah tidak digunakan</p>
                        </div>
                    </label>
                </div>
            </div>
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex flex-col sm:flex-row justify-end gap-3">
                <a href="{{ route('admin.atm.index') }}" class="inline-flex items-center justify-center px-6 py-3 bg-white border-2 border-gray-300 rounded-xl font-semibold text-sm text-gray-700 hover:bg-gray-50 transition">Batal</a>
                <button type="submit" class="inline-flex items-center justify-center px-8 py-3 bg-gradient-to-r from-yellow-500 to-orange-500 text-white rounded-xl font-bold text-sm hover:from-yellow-600 hover:to-orange-600 transition shadow-lg hover:shadow-xl space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    <span>Update ATM</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
