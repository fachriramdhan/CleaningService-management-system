@extends('layouts.app-dashboard')

@section('title', 'Buat Laporan ATM')

@section('nav-links')
    <a href="{{ route('cs.dashboard') }}" class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium text-gray-500 hover:text-gray-700">
        Dashboard
    </a>
    <a href="{{ route('cs.absensi.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300">
        Absensi
    </a>
    <a href="{{ route('cs.laporan.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 border-indigo-400 text-sm font-medium text-gray-900">
        Laporan ATM
    </a>
     <a href="{{ route('cs.permintaan.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300">
        Permintaan Alat
    </a>
@endsection

@section('mobile-nav-links')
    <a href="{{ route('cs.dashboard') }}" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50">
        Dashboard
    </a>
     <a href="{{ route('cs.absensi.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300">
        Absensi
    </a>
    <a href="{{ route('cs.laporan.index') }}" class="block pl-3 pr-4 py-2 border-l-4 border-indigo-400 text-base font-medium text-indigo-700 bg-indigo-50">
        Laporan ATM
    </a>
    <a href="{{ route('cs.permintaan.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300">
        Permintaan Alat
    </a>
@endsection

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl md:text-4xl font-bold bg-gradient-to-r from-green-600 to-teal-600 bg-clip-text text-transparent">
            🧹 Laporan Pembersihan ATM
        </h1>
        <p class="mt-2 text-gray-600 flex items-center space-x-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            <span>{{ now()->format('l, d F Y') }}</span>
        </p>
    </div>

    <!-- Alert Error -->
    @if(session('error'))
        <div class="mb-6 bg-red-50 border-l-4 border-red-400 p-4 rounded-xl flex items-start space-x-3">
            <div class="w-8 h-8 bg-red-500 rounded-full flex items-center justify-center flex-shrink-0">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </div>
            <p class="text-sm text-red-700 font-medium pt-1">{{ session('error') }}</p>
        </div>
    @endif

    <!-- Alert Success -->
    @if(session('success'))
        <div class="mb-6 bg-green-50 border-l-4 border-green-400 p-4 rounded-xl flex items-start space-x-3">
            <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center flex-shrink-0">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <p class="text-sm text-green-700 font-medium pt-1">{{ session('success') }}</p>
        </div>
    @endif

    {{-- ================================================================
         CEK ABSENSI: Jika belum absen, tampilkan warning
         Jika sudah absen, tampilkan form laporan
    ================================================================ --}}
    @if($absensi)

        {{-- ── INFO ABSENSI HARI INI ── --}}
        <div class="mb-6 bg-gradient-to-r from-green-50 to-teal-50 border border-green-200 p-4 rounded-2xl">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-gradient-to-br from-green-400 to-teal-500 rounded-full flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-bold text-green-800">✅ Sudah Absen Hari Ini</p>
                    <p class="text-xs text-green-700 mt-0.5">
                        Area: <span class="font-semibold">{{ $absensi->area->nama_area }}</span>
                        · Jam Masuk: <span class="font-semibold">{{ $absensi->jam_absen }}</span>
                    </p>
                </div>
                <span class="px-3 py-1 bg-green-100 text-green-700 text-xs font-bold rounded-full border border-green-200">
                    {{ ucfirst($absensi->status) }}
                </span>
            </div>
        </div>

        {{-- ── INFO PENTING ── --}}
        <div class="mb-6 bg-gradient-to-r from-blue-50 to-cyan-50 border-l-4 border-blue-500 p-4 rounded-xl">
            <div class="flex items-start space-x-3">
                <div class="w-9 h-9 bg-blue-500 rounded-full flex items-center justify-center flex-shrink-0">
                    <svg class="h-4 w-4 text-white" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-bold text-blue-800">Panduan Pengisian</p>
                    <p class="text-xs text-blue-700 mt-0.5">
                        Gunakan aplikasi <strong>Timestamp</strong> untuk mengambil ketiga foto. Pastikan foto jelas dan menunjukkan kondisi ATM dengan baik.
                    </p>
                </div>
            </div>
        </div>

        {{-- ── FORM LAPORAN ── --}}
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-green-500 to-teal-500 px-6 py-4">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-white">Form Laporan Pembersihan</h2>
                        <p class="text-white/70 text-xs">Isi semua field yang bertanda *</p>
                    </div>
                </div>
            </div>

            <form action="{{ route('cs.laporan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="p-6 space-y-6">

                    {{-- ── PILIH ATM ── --}}
                    <div>
                        <label for="atm_id" class="block text-xs font-bold text-gray-600 mb-2 uppercase tracking-wider">
                            🏧 Pilih ATM <span class="text-red-500">*</span>
                        </label>
                        <select name="atm_id" id="atm_id"
                                class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition text-sm @error('atm_id') border-red-400 @enderror"
                                required>
                            <option value="">-- Pilih ATM --</option>
                            @foreach($atms as $atm)
                                <option value="{{ $atm->id }}" {{ old('atm_id') == $atm->id ? 'selected' : '' }}>
                                    {{ $atm->nama_atm }} - {{ $atm->lokasi }}
                                </option>
                            @endforeach
                        </select>
                        <p class="mt-1.5 text-xs text-gray-500 flex items-center space-x-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            </svg>
                            <span>Area tugas hari ini: <strong class="text-gray-700">{{ $absensi->area->nama_area }}</strong></span>
                        </p>
                        @error('atm_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="border-t border-gray-100"></div>

                    {{-- ── FOTO SEBELUM ── --}}
                    <div>
                        <label for="foto_sebelum" class="block text-xs font-bold text-gray-600 mb-2 uppercase tracking-wider">
                            📸 Foto Sebelum Dibersihkan <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="file"
                                   name="foto_sebelum"
                                   id="foto_sebelum"
                                   accept="image/*"
                                   class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition text-sm @error('foto_sebelum') border-red-400 @enderror"
                                   onchange="previewImage(event, 'preview-sebelum')"
                                   required>
                        </div>
                        <p class="mt-1.5 text-xs text-gray-500">Format: JPG, PNG · Maksimal 5MB</p>
                        @error('foto_sebelum')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <div id="preview-sebelum-container" class="mt-3 hidden">
                            <div class="relative rounded-xl overflow-hidden border-2 border-red-200 shadow-md">
                                <img id="preview-sebelum" src="" alt="Preview Sebelum" class="w-full max-w-sm h-48 object-cover">
                                <span class="absolute top-2 left-2 px-2 py-1 bg-red-500 text-white text-xs font-bold rounded-lg">Sebelum</span>
                            </div>
                        </div>
                    </div>

                    {{-- ── FOTO SESUDAH ── --}}
                    <div>
                        <label for="foto_sesudah" class="block text-xs font-bold text-gray-600 mb-2 uppercase tracking-wider">
                            ✅ Foto Sesudah Dibersihkan <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="file"
                                   name="foto_sesudah"
                                   id="foto_sesudah"
                                   accept="image/*"
                                   class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition text-sm @error('foto_sesudah') border-red-400 @enderror"
                                   onchange="previewImage(event, 'preview-sesudah')"
                                   required>
                        </div>
                        <p class="mt-1.5 text-xs text-gray-500">Format: JPG, PNG · Maksimal 5MB</p>
                        @error('foto_sesudah')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <div id="preview-sesudah-container" class="mt-3 hidden">
                            <div class="relative rounded-xl overflow-hidden border-2 border-green-200 shadow-md">
                                <img id="preview-sesudah" src="" alt="Preview Sesudah" class="w-full max-w-sm h-48 object-cover">
                                <span class="absolute top-2 left-2 px-2 py-1 bg-green-500 text-white text-xs font-bold rounded-lg">Sesudah</span>
                            </div>
                        </div>
                    </div>

                    {{-- ── FOTO LOKASI ── --}}
                    <div>
                        <label for="foto_lokasi" class="block text-xs font-bold text-gray-600 mb-2 uppercase tracking-wider">
                            📍 Foto Lokasi ATM <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="file"
                                   name="foto_lokasi"
                                   id="foto_lokasi"
                                   accept="image/*"
                                   class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition text-sm @error('foto_lokasi') border-red-400 @enderror"
                                   onchange="previewImage(event, 'preview-lokasi')"
                                   required>
                        </div>
                        <p class="mt-1.5 text-xs text-gray-500">Format: JPG, PNG · Maksimal 5MB</p>
                        @error('foto_lokasi')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <div id="preview-lokasi-container" class="mt-3 hidden">
                            <div class="relative rounded-xl overflow-hidden border-2 border-blue-200 shadow-md">
                                <img id="preview-lokasi" src="" alt="Preview Lokasi" class="w-full max-w-sm h-48 object-cover">
                                <span class="absolute top-2 left-2 px-2 py-1 bg-blue-500 text-white text-xs font-bold rounded-lg">Lokasi</span>
                            </div>
                        </div>
                    </div>

                    <div class="border-t border-gray-100"></div>

                    {{-- ── CATATAN ── --}}
                    <div>
                        <label for="catatan" class="block text-xs font-bold text-gray-600 mb-2 uppercase tracking-wider">
                            📝 Catatan / Kendala <span class="text-gray-400 font-normal normal-case">(opsional)</span>
                        </label>
                        <textarea name="catatan"
                                  id="catatan"
                                  rows="4"
                                  placeholder="Tambahkan catatan jika ada kendala atau hal penting (misal: AC rusak, pintu macet, dll)"
                                  class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition text-sm @error('catatan') border-red-400 @enderror">{{ old('catatan') }}</textarea>
                        @error('catatan')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- ── FORM BUTTONS ── --}}
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 rounded-b-2xl flex flex-col sm:flex-row justify-end gap-3">
                    <a href="{{ route('cs.dashboard') }}"
                       class="inline-flex items-center justify-center px-6 py-3 bg-white border-2 border-gray-300 rounded-xl font-semibold text-sm text-gray-700 hover:bg-gray-50 transition">
                        Batal
                    </a>
                    <button type="submit"
                            class="inline-flex items-center justify-center px-8 py-3 bg-gradient-to-r from-green-500 to-teal-500 text-white rounded-xl font-bold text-sm hover:from-green-600 hover:to-teal-600 transition shadow-lg hover:shadow-xl space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span>Simpan Laporan</span>
                    </button>
                </div>
            </form>
        </div>

    @else
        {{-- ================================================================
             BELUM ABSEN: Tampilkan warning & tombol ke absensi
        ================================================================ --}}
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-yellow-400 to-orange-500 px-6 py-4">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                    </div>
                    <h2 class="text-lg font-bold text-white">Perhatian!</h2>
                </div>
            </div>
            <div class="p-8 text-center">
                <div class="w-24 h-24 mx-auto mb-6 bg-gradient-to-br from-yellow-100 to-orange-100 rounded-full flex items-center justify-center">
                    <svg class="w-12 h-12 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Belum Absen Hari Ini</h3>
                <p class="text-gray-600 text-sm mb-2">Anda harus melakukan absensi terlebih dahulu sebelum bisa membuat laporan pembersihan ATM.</p>
                <p class="text-gray-500 text-xs mb-8">
                    📅 {{ now()->format('l, d F Y') }}
                </p>
                <div class="flex flex-col sm:flex-row gap-3 justify-center">
                    <a href="{{ route('cs.absensi.index') }}"
                       class="inline-flex items-center justify-center px-8 py-3 bg-gradient-to-r from-yellow-400 to-orange-500 text-white rounded-xl font-bold hover:from-yellow-500 hover:to-orange-600 transition shadow-lg hover:shadow-xl space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>Absen Sekarang</span>
                    </a>
                    <a href="{{ route('cs.dashboard') }}"
                       class="inline-flex items-center justify-center px-8 py-3 bg-white border-2 border-gray-300 text-gray-700 rounded-xl font-semibold hover:bg-gray-50 transition space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        <span>Kembali ke Dashboard</span>
                    </a>
                </div>
            </div>
        </div>
    @endif

</div>

<script>
function previewImage(event, previewId) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById(previewId).src = e.target.result;
            document.getElementById(previewId + '-container').classList.remove('hidden');
        }
        reader.readAsDataURL(file);
    }
}
</script>
@endsection
