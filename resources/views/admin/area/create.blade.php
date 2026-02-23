@extends('layouts.app-dashboard')

@section('title', 'Tambah Area')

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
        <h1 class="text-3xl md:text-4xl font-bold bg-gradient-to-r from-green-600 to-teal-600 bg-clip-text text-transparent">
            ➕ Tambah Area Baru
        </h1>
        <p class="mt-2 text-gray-600">Tambahkan area tugas baru untuk cleaning service</p>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="bg-gradient-to-r from-green-500 to-teal-500 px-6 py-4">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-white">Form Tambah Area</h2>
                    <p class="text-white/70 text-xs">Semua field bertanda * wajib diisi</p>
                </div>
            </div>
        </div>

        <form action="{{ route('admin.area.store') }}" method="POST">
            @csrf

            <div class="p-6 space-y-6">

                <!-- Nama Area -->
                <div>
                    <label for="nama_area" class="block text-xs font-bold text-gray-600 mb-2 uppercase tracking-wider">
                        📍 Nama Area <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                           name="nama_area"
                           id="nama_area"
                           value="{{ old('nama_area') }}"
                           placeholder="Contoh: Area ATM Cikini"
                           class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition @error('nama_area') border-red-400 @enderror"
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
                              placeholder="Deskripsi area, lokasi sekitar, cakupan wilayah, dll..."
                              class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition @error('keterangan') border-red-400 @enderror">{{ old('keterangan') }}</textarea>
                    <p class="mt-1 text-xs text-gray-500">Opsional - tambahkan informasi tambahan tentang area ini</p>
                    @error('keterangan')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Info Box -->
                <div class="p-4 bg-blue-50 border-l-4 border-blue-400 rounded-xl">
                    <div class="flex items-start space-x-3">
                        <div class="w-6 h-6 bg-blue-500 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-blue-800 mb-1">💡 Info</p>
                            <p class="text-xs text-blue-700">Area baru akan otomatis dalam status <strong>aktif</strong>. Anda dapat menambahkan ATM dan menugaskan CS setelah area dibuat.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer Buttons -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex flex-col sm:flex-row justify-end gap-3">
                <a href="{{ route('admin.area.index') }}"
                   class="inline-flex items-center justify-center px-6 py-3 bg-white border-2 border-gray-300 rounded-xl font-semibold text-sm text-gray-700 hover:bg-gray-50 transition">
                    Batal
                </a>
                <button type="submit"
                        class="inline-flex items-center justify-center px-8 py-3 bg-gradient-to-r from-green-500 to-teal-500 text-white rounded-xl font-bold text-sm hover:from-green-600 hover:to-teal-600 transition shadow-lg hover:shadow-xl space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span>Simpan Area</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
