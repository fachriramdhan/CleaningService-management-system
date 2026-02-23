@extends('layouts.app-dashboard')

@section('title', 'Absen Sekarang')

@section('nav-links')
    <a href="{{ route('cs.dashboard') }}" class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium text-gray-500 hover:text-gray-700">
        Dashboard
    </a>
    <a href="{{ route('cs.absensi.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 border-indigo-400 text-sm font-medium text-gray-900">
        Absensi
    </a>
@endsection

@section('mobile-nav-links')
    <a href="{{ route('cs.dashboard') }}" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50">
        Dashboard
    </a>
    <a href="{{ route('cs.absensi.index') }}" class="block pl-3 pr-4 py-2 border-l-4 border-indigo-400 text-base font-medium text-indigo-700 bg-indigo-50">
        Absensi
    </a>
@endsection

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl md:text-4xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">
            ✅ Absen Sekarang
        </h1>
        <p class="mt-2 text-gray-600 flex items-center space-x-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span id="live-clock">{{ now()->format('l, d F Y · H:i') }}</span>
        </p>
    </div>

    <!-- Alert Error -->
    @if(session('error'))
        <div class="mb-6 bg-red-50 border-l-4 border-red-400 p-4 rounded-xl flex items-center space-x-3">
            <div class="w-8 h-8 bg-red-500 rounded-full flex items-center justify-center flex-shrink-0">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </div>
            <p class="text-sm text-red-700 font-medium">{{ session('error') }}</p>
        </div>
    @endif

    <!-- Info Box -->
    <div class="mb-6 bg-gradient-to-r from-blue-50 to-cyan-50 border-l-4 border-blue-500 p-4 rounded-xl">
        <div class="flex items-start space-x-3">
            <div class="w-9 h-9 bg-blue-500 rounded-full flex items-center justify-center flex-shrink-0">
                <svg class="h-4 w-4 text-white" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                </svg>
            </div>
            <div>
                <p class="text-sm font-bold text-blue-800">Panduan Foto Timestamp</p>
                <p class="text-xs text-blue-700 mt-0.5">
                    Gunakan aplikasi <strong>Timestamp</strong> di HP untuk mengambil foto wajah dengan waktu otomatis. Pastikan wajah terlihat jelas dan terang.
                </p>
            </div>
        </div>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="bg-gradient-to-r from-blue-500 to-indigo-600 px-6 py-4">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-white">Form Absensi</h2>
                    <p class="text-white/70 text-xs">Isi semua field yang bertanda *</p>
                </div>
            </div>
        </div>

        <form action="{{ route('cs.absensi.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="p-6 space-y-6">

                <!-- Area Tugas -->
                <div>
                    <label for="area_id" class="block text-xs font-bold text-gray-600 mb-2 uppercase tracking-wider">
                        📍 Pilih Area Tugas <span class="text-red-500">*</span>
                    </label>
                    <select name="area_id" id="area_id"
                            class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition text-sm @error('area_id') border-red-400 @enderror"
                            required>
                        <option value="">-- Pilih Area --</option>
                        @foreach($areas as $area)
                            <option value="{{ $area->id }}" {{ old('area_id') == $area->id ? 'selected' : '' }}>
                                {{ $area->nama_area }}
                            </option>
                        @endforeach
                    </select>
                    @error('area_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status Kehadiran -->
                <div>
                    <label class="block text-xs font-bold text-gray-600 mb-3 uppercase tracking-wider">
                        🔖 Status Kehadiran <span class="text-red-500">*</span>
                    </label>
                    <div class="grid grid-cols-3 gap-3">
                        <!-- Hadir -->
                        <label class="relative cursor-pointer">
                            <input type="radio" name="status" value="hadir"
                                   {{ old('status', 'hadir') === 'hadir' ? 'checked' : '' }}
                                   class="peer sr-only">
                            <div class="flex flex-col items-center p-4 border-2 border-gray-200 rounded-xl peer-checked:border-green-500 peer-checked:bg-green-50 hover:border-green-300 transition">
                                <span class="text-2xl mb-1">✅</span>
                                <span class="text-xs font-bold text-gray-700 peer-checked:text-green-700">Hadir</span>
                            </div>
                            <div class="absolute top-2 right-2 w-4 h-4 rounded-full border-2 border-gray-300 peer-checked:border-green-500 peer-checked:bg-green-500 hidden peer-checked:flex items-center justify-center">
                            </div>
                        </label>

                        <!-- Izin -->
                        <label class="relative cursor-pointer">
                            <input type="radio" name="status" value="izin"
                                   {{ old('status') === 'izin' ? 'checked' : '' }}
                                   class="peer sr-only">
                            <div class="flex flex-col items-center p-4 border-2 border-gray-200 rounded-xl peer-checked:border-yellow-500 peer-checked:bg-yellow-50 hover:border-yellow-300 transition">
                                <span class="text-2xl mb-1">📋</span>
                                <span class="text-xs font-bold text-gray-700 peer-checked:text-yellow-700">Izin</span>
                            </div>
                        </label>

                        <!-- Sakit -->
                        <label class="relative cursor-pointer">
                            <input type="radio" name="status" value="sakit"
                                   {{ old('status') === 'sakit' ? 'checked' : '' }}
                                   class="peer sr-only">
                            <div class="flex flex-col items-center p-4 border-2 border-gray-200 rounded-xl peer-checked:border-red-500 peer-checked:bg-red-50 hover:border-red-300 transition">
                                <span class="text-2xl mb-1">🤒</span>
                                <span class="text-xs font-bold text-gray-700 peer-checked:text-red-700">Sakit</span>
                            </div>
                        </label>
                    </div>
                    @error('status')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="border-t border-gray-100"></div>

                <!-- Foto Wajah -->
                <div>
                    <label for="foto_wajah" class="block text-xs font-bold text-gray-600 mb-2 uppercase tracking-wider">
                        🤳 Foto Wajah (Timestamp) <span class="text-red-500">*</span>
                    </label>
                    <input type="file"
                           name="foto_wajah"
                           id="foto_wajah"
                           accept="image/*"
                           class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition text-sm @error('foto_wajah') border-red-400 @enderror"
                           onchange="previewImage(event)"
                           required>
                    <p class="mt-1.5 text-xs text-gray-500">Format: JPG, PNG · Maksimal 5MB · Gunakan aplikasi Timestamp</p>
                    @error('foto_wajah')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror

                    <!-- Preview Foto -->
                    <div id="preview-container" class="mt-3 hidden">
                        <div class="relative rounded-xl overflow-hidden border-2 border-blue-200 shadow-md max-w-sm">
                            <img id="preview-image" src="" alt="Preview Foto" class="w-full h-64 object-cover">
                            <div class="absolute top-2 left-2 px-2 py-1 bg-blue-500 text-white text-xs font-bold rounded-lg">
                                📸 Preview
                            </div>
                        </div>
                    </div>
                </div>

                <div class="border-t border-gray-100"></div>

                <!-- Keterangan -->
                <div>
                    <label for="keterangan" class="block text-xs font-bold text-gray-600 mb-2 uppercase tracking-wider">
                        📝 Keterangan <span class="text-gray-400 font-normal normal-case">(opsional)</span>
                    </label>
                    <textarea name="keterangan"
                              id="keterangan"
                              rows="3"
                              placeholder="Tambahkan keterangan jika perlu (misal: terlambat karena macet)"
                              class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition text-sm @error('keterangan') border-red-400 @enderror">{{ old('keterangan') }}</textarea>
                    @error('keterangan')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Buttons -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 rounded-b-2xl flex flex-col sm:flex-row justify-end gap-3">
                <a href="{{ route('cs.dashboard') }}"
                   class="inline-flex items-center justify-center px-6 py-3 bg-white border-2 border-gray-300 rounded-xl font-semibold text-sm text-gray-700 hover:bg-gray-50 transition">
                    Batal
                </a>
                <button type="submit"
                        class="inline-flex items-center justify-center px-8 py-3 bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-xl font-bold text-sm hover:from-blue-600 hover:to-indigo-700 transition shadow-lg hover:shadow-xl space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span>Simpan Absensi</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function previewImage(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('preview-image').src = e.target.result;
            document.getElementById('preview-container').classList.remove('hidden');
        }
        reader.readAsDataURL(file);
    }
}

// Live clock
function updateClock() {
    const now = new Date();
    const days = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
    const months = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
    const day = days[now.getDay()];
    const date = now.getDate();
    const month = months[now.getMonth()];
    const year = now.getFullYear();
    const h = String(now.getHours()).padStart(2,'0');
    const m = String(now.getMinutes()).padStart(2,'0');
    document.getElementById('live-clock').textContent = `${day}, ${date} ${month} ${year} · ${h}:${m}`;
}
updateClock();
setInterval(updateClock, 1000);
</script>
@endsection
