@extends('layouts.app-dashboard')

@section('title', 'Buat Laporan ATM')

@section('nav-links')
    <a href="{{ route('cs.dashboard') }}" class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium text-gray-500 hover:text-gray-700">
        Dashboard
    </a>
    <a href="{{ route('cs.laporan.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 border-indigo-400 text-sm font-medium text-gray-900">
        Laporan ATM
    </a>
@endsection

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Buat Laporan Pembersihan ATM</h1>
        <p class="mt-1 text-sm text-gray-600">{{ now()->format('l, d F Y') }}</p>
    </div>

    <!-- Alert -->
    @if(session('error'))
        <div class="mb-6 bg-red-50 border-l-4 border-red-400 p-4 rounded-lg">
            <p class="text-sm text-red-700">{{ session('error') }}</p>
        </div>
    @endif

    <!-- Info Box -->
    <div class="mb-6 bg-blue-50 border-l-4 border-blue-400 p-4 rounded-lg">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm text-blue-700">
                    <span class="font-medium">Penting!</span> Gunakan aplikasi Timestamp untuk mengambil ketiga foto. Pastikan foto jelas dan menunjukkan kondisi ATM dengan baik.
                </p>
            </div>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow">
        <form action="{{ route('cs.laporan.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="p-6 space-y-6">
                <!-- Pilih ATM -->
                <div>
                    <label for="atm_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Pilih ATM <span class="text-red-500">*</span>
                    </label>
                    <select name="atm_id"
                            id="atm_id"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 @error('atm_id') border-red-500 @enderror"
                            required>
                        <option value="">-- Pilih ATM --</option>
                        @foreach($atms as $atm)
                            <option value="{{ $atm->id }}" {{ old('atm_id') == $atm->id ? 'selected' : '' }}>
                                {{ $atm->nama_atm }} - {{ $atm->lokasi }}
                            </option>
                        @endforeach
                    </select>
                    <p class="mt-1 text-xs text-gray-500">Area: {{ $absensi->area->nama_area }}</p>
                    @error('atm_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <hr class="border-gray-200">

                <!-- Foto Sebelum -->
                <div>
                    <label for="foto_sebelum" class="block text-sm font-medium text-gray-700 mb-2">
                        Foto Sebelum Dibersihkan <span class="text-red-500">*</span>
                    </label>
                    <input type="file"
                           name="foto_sebelum"
                           id="foto_sebelum"
                           accept="image/*"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 @error('foto_sebelum') border-red-500 @enderror"
                           onchange="previewImage(event, 'preview-sebelum')"
                           required>
                    <p class="mt-1 text-xs text-gray-500">Format: JPG, PNG. Maksimal 5MB.</p>
                    @error('foto_sebelum')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror

                    <!-- Preview -->
                    <div id="preview-sebelum-container" class="mt-3 hidden">
                        <img id="preview-sebelum" src="" alt="Preview" class="w-full max-w-sm rounded-lg border-2 border-gray-300">
                    </div>
                </div>

                <!-- Foto Sesudah -->
                <div>
                    <label for="foto_sesudah" class="block text-sm font-medium text-gray-700 mb-2">
                        Foto Sesudah Dibersihkan <span class="text-red-500">*</span>
                    </label>
                    <input type="file"
                           name="foto_sesudah"
                           id="foto_sesudah"
                           accept="image/*"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 @error('foto_sesudah') border-red-500 @enderror"
                           onchange="previewImage(event, 'preview-sesudah')"
                           required>
                    <p class="mt-1 text-xs text-gray-500">Format: JPG, PNG. Maksimal 5MB.</p>
                    @error('foto_sesudah')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror

                    <!-- Preview -->
                    <div id="preview-sesudah-container" class="mt-3 hidden">
                        <img id="preview-sesudah" src="" alt="Preview" class="w-full max-w-sm rounded-lg border-2 border-gray-300">
                    </div>
                </div>

                <!-- Foto Lokasi -->
                <div>
                    <label for="foto_lokasi" class="block text-sm font-medium text-gray-700 mb-2">
                        Foto Lokasi ATM <span class="text-red-500">*</span>
                    </label>
                    <input type="file"
                           name="foto_lokasi"
                           id="foto_lokasi"
                           accept="image/*"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 @error('foto_lokasi') border-red-500 @enderror"
                           onchange="previewImage(event, 'preview-lokasi')"
                           required>
                    <p class="mt-1 text-xs text-gray-500">Format: JPG, PNG. Maksimal 5MB.</p>
                    @error('foto_lokasi')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror

                    <!-- Preview -->
                    <div id="preview-lokasi-container" class="mt-3 hidden">
                        <img id="preview-lokasi" src="" alt="Preview" class="w-full max-w-sm rounded-lg border-2 border-gray-300">
                    </div>
                </div>

                <hr class="border-gray-200">

                <!-- Catatan -->
                <div>
                    <label for="catatan" class="block text-sm font-medium text-gray-700 mb-2">
                        Catatan / Kendala
                    </label>
                    <textarea name="catatan"
                              id="catatan"
                              rows="4"
                              placeholder="Tambahkan catatan jika ada kendala atau hal penting (misal: AC rusak, pintu macet, dll)"
                              class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 @error('catatan') border-red-500 @enderror">{{ old('catatan') }}</textarea>
                    @error('catatan')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end space-x-3 rounded-b-lg">
                <a href="{{ route('cs.laporan.index') }}"
                   class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50">
                    Batal
                </a>
                <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Simpan Laporan
                </button>
            </div>
        </form>
    </div>
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
