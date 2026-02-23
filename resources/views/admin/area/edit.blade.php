@extends('layouts.app-dashboard')

@section('title', 'Edit Area')

@section('nav-links')
    <a href="{{ route('admin.dashboard') }}"
       class="px-4 py-2 rounded-xl text-sm font-semibold text-gray-600 hover:text-blue-600 hover:bg-blue-50 transition-all">
        Dashboard
    </a>
    <a href="{{ route('admin.area.index') }}"
       class="px-4 py-2 rounded-xl text-sm font-bold bg-gradient-to-r from-blue-500 to-indigo-600 text-white shadow-md hover:shadow-lg transition-all">
        Kelola Area
    </a>
@endsection

@section('mobile-nav-links')
    <a href="{{ route('admin.dashboard') }}"
       class="block px-4 py-3 rounded-xl text-base font-semibold text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-all mb-2">
        Dashboard
    </a>
    <a href="{{ route('admin.area.index') }}"
       class="block px-4 py-3 rounded-xl text-base font-bold bg-gradient-to-r from-blue-500 to-indigo-600 text-white mb-2">
        Kelola Area
    </a>
@endsection

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl md:text-4xl font-bold bg-gradient-to-r from-yellow-600 to-orange-600 bg-clip-text text-transparent">
            ✏️ Edit Area
        </h1>
        <p class="mt-2 text-gray-600">Update informasi area: {{ $area->nama_area }}</p>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="bg-gradient-to-r from-yellow-500 to-orange-500 px-6 py-4">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-white">Form Edit Area</h2>
                    <p class="text-white/70 text-xs">Update data area yang sudah ada</p>
                </div>
            </div>
        </div>

        <form action="{{ route('admin.area.update', $area->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="p-6 space-y-6">

                <!-- Nama Area -->
                <div>
                    <label for="nama_area" class="block text-xs font-bold text-gray-600 mb-2 uppercase tracking-wider">
                        📍 Nama Area <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                           name="nama_area"
                           id="nama_area"
                           value="{{ old('nama_area', $area->nama_area) }}"
                           class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition @error('nama_area') border-red-400 @enderror"
                           required>
                    @error('nama_area')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Keterangan -->
                <div>
                    <label for="keterangan" class="block text-xs font-bold text-gray-600 mb-2 uppercase tracking-wider">
                        📝 Keterangan
                    </label>
                    <textarea name="keterangan"
                              id="keterangan"
                              rows="4"
                              placeholder="Deskripsi area, lokasi sekitar, dll..."
                              class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition @error('keterangan') border-red-400 @enderror">{{ old('keterangan', $area->keterangan) }}</textarea>
                    @error('keterangan')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status Aktif -->
                <div class="p-4 bg-gray-50 rounded-xl border-2 border-gray-200">
                    <label class="flex items-start cursor-pointer">
                        <input type="checkbox"
                               name="is_active"
                               value="1"
                               {{ old('is_active', $area->is_active) ? 'checked' : '' }}
                               class="mt-1 w-5 h-5 rounded border-gray-300 text-yellow-600 focus:ring-yellow-500">
                        <div class="ml-3">
                            <span class="text-sm font-bold text-gray-900">✅ Area Aktif</span>
                            <p class="text-xs text-gray-500 mt-0.5">Nonaktifkan jika area tidak digunakan lagi</p>
                        </div>
                    </label>
                </div>
            </div>

            <!-- Footer Buttons -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex flex-col sm:flex-row justify-end gap-3">
                <a href="{{ route('admin.area.index') }}"
                   class="inline-flex items-center justify-center px-6 py-3 bg-white border-2 border-gray-300 rounded-xl font-semibold text-sm text-gray-700 hover:bg-gray-50 transition">
                    Batal
                </a>
                <button type="submit"
                        class="inline-flex items-center justify-center px-8 py-3 bg-gradient-to-r from-yellow-500 to-orange-500 text-white rounded-xl font-bold text-sm hover:from-yellow-600 hover:to-orange-600 transition shadow-lg hover:shadow-xl space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span>Update Area</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
