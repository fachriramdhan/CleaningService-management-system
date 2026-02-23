@extends('layouts.app-dashboard')

@section('title', 'Ajukan Permintaan')

@section('nav-links')
    <a href="{{ route('cs.dashboard') }}" class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium text-gray-500 hover:text-gray-700">Dashboard</a>
    <a href="{{ route('cs.permintaan.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 border-indigo-400 text-sm font-medium text-gray-900">Permintaan Alat</a>
@endsection

@section('mobile-nav-links')
    <a href="{{ route('cs.dashboard') }}" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50">Dashboard</a>
    <a href="{{ route('cs.permintaan.index') }}" class="block pl-3 pr-4 py-2 border-l-4 border-indigo-400 text-base font-medium text-indigo-700 bg-indigo-50">Permintaan Alat</a>
@endsection

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl md:text-4xl font-bold bg-gradient-to-r from-teal-600 to-cyan-600 bg-clip-text text-transparent">
            📤 Ajukan Permintaan
        </h1>
        <p class="mt-2 text-gray-600">Isi form untuk mengajukan permintaan alat atau chemical</p>
    </div>

    <!-- Info Box: Perbedaan Pinjam & Ambil -->
    <div class="mb-6 bg-gradient-to-r from-blue-50 to-cyan-50 border-l-4 border-blue-500 p-4 rounded-xl">
        <div class="flex items-start space-x-3">
            <div class="w-9 h-9 bg-blue-500 rounded-full flex items-center justify-center flex-shrink-0">
                <svg class="h-4 w-4 text-white" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                </svg>
            </div>
            <div>
                <p class="text-sm font-bold text-blue-800 mb-1">Perbedaan Pinjam & Ambil</p>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 mt-2">
                    <div class="flex items-start space-x-2">
                        <span class="w-5 h-5 bg-orange-400 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                            <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                        </span>
                        <p class="text-xs text-blue-700"><strong>Pinjam</strong> — barang dikembalikan setelah digunakan</p>
                    </div>
                    <div class="flex items-start space-x-2">
                        <span class="w-5 h-5 bg-teal-400 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                            <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </span>
                        <p class="text-xs text-blue-700"><strong>Ambil</strong> — barang habis pakai, tidak dikembalikan</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="bg-gradient-to-r from-teal-500 to-cyan-600 px-6 py-4">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-white">Form Permintaan</h2>
                    <p class="text-white/70 text-xs">Isi semua field yang bertanda *</p>
                </div>
            </div>
        </div>

        <form action="{{ route('cs.permintaan.store') }}" method="POST">
            @csrf
            <div class="p-6 space-y-6">

                <!-- Pilih Item -->
                <div>
                    <label for="inventory_id" class="block text-xs font-bold text-gray-600 mb-2 uppercase tracking-wider">
                        📦 Pilih Alat/Chemical <span class="text-red-500">*</span>
                    </label>
                    <select name="inventory_id" id="inventory_id"
                            class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-transparent transition text-sm @error('inventory_id') border-red-400 @enderror"
                            required onchange="updateStokInfo()">
                        <option value="">-- Pilih Item --</option>
                        @foreach($inventories as $item)
                            <option value="{{ $item->id }}"
                                    data-stok="{{ $item->stok }}"
                                    data-satuan="{{ $item->satuan }}"
                                    data-jenis="{{ $item->jenis }}"
                                    {{ old('inventory_id') == $item->id ? 'selected' : '' }}>
                                {{ $item->nama_item }} (Stok: {{ $item->stok }} {{ $item->satuan }}) — {{ ucfirst($item->jenis) }}
                            </option>
                        @endforeach
                    </select>

                    <!-- Stok Info -->
                    <div id="stok-info" class="mt-2 hidden">
                        <div class="p-3 bg-teal-50 rounded-xl border border-teal-200 flex items-center space-x-3">
                            <div class="w-8 h-8 bg-teal-400 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-teal-600 font-bold">Info Stok</p>
                                <p id="stok-text" class="text-sm font-bold text-teal-800"></p>
                            </div>
                        </div>
                    </div>
                    @error('inventory_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Jenis Permintaan -->
                <div>
                    <label class="block text-xs font-bold text-gray-600 mb-3 uppercase tracking-wider">
                        🔖 Jenis Permintaan <span class="text-red-500">*</span>
                    </label>
                    <div class="grid grid-cols-2 gap-3">
                        <!-- Pinjam -->
                        <label class="relative cursor-pointer">
                            <input type="radio" name="jenis_permintaan" value="pinjam"
                                   {{ old('jenis_permintaan', 'pinjam') === 'pinjam' ? 'checked' : '' }}
                                   class="peer sr-only">
                            <div class="flex flex-col p-4 border-2 border-gray-200 rounded-xl peer-checked:border-orange-400 peer-checked:bg-orange-50 hover:border-orange-300 transition">
                                <div class="flex items-center space-x-2 mb-2">
                                    <div class="w-8 h-8 bg-orange-100 peer-checked:bg-orange-400 rounded-lg flex items-center justify-center">
                                        <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                        </svg>
                                    </div>
                                    <span class="text-sm font-bold text-gray-900">🔄 Pinjam</span>
                                </div>
                                <p class="text-xs text-gray-500">Dikembalikan setelah digunakan</p>
                            </div>
                        </label>

                        <!-- Ambil -->
                        <label class="relative cursor-pointer">
                            <input type="radio" name="jenis_permintaan" value="ambil"
                                   {{ old('jenis_permintaan') === 'ambil' ? 'checked' : '' }}
                                   class="peer sr-only">
                            <div class="flex flex-col p-4 border-2 border-gray-200 rounded-xl peer-checked:border-teal-400 peer-checked:bg-teal-50 hover:border-teal-300 transition">
                                <div class="flex items-center space-x-2 mb-2">
                                    <div class="w-8 h-8 bg-teal-100 rounded-lg flex items-center justify-center">
                                        <svg class="w-4 h-4 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </div>
                                    <span class="text-sm font-bold text-gray-900">📤 Ambil</span>
                                </div>
                                <p class="text-xs text-gray-500">Habis pakai / tidak dikembalikan</p>
                            </div>
                        </label>
                    </div>
                    @error('jenis_permintaan')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="border-t border-gray-100"></div>

                <!-- Jumlah -->
                <div>
                    <label for="jumlah" class="block text-xs font-bold text-gray-600 mb-2 uppercase tracking-wider">
                        🔢 Jumlah <span class="text-red-500">*</span>
                    </label>
                    <input type="number"
                           name="jumlah"
                           id="jumlah"
                           value="{{ old('jumlah', 1) }}"
                           min="1"
                           class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-transparent transition text-sm @error('jumlah') border-red-400 @enderror"
                           required>
                    @error('jumlah')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Alasan -->
                <div>
                    <label for="alasan" class="block text-xs font-bold text-gray-600 mb-2 uppercase tracking-wider">
                        📝 Alasan / Keperluan <span class="text-red-500">*</span>
                    </label>
                    <textarea name="alasan"
                              id="alasan"
                              rows="4"
                              placeholder="Jelaskan untuk keperluan apa dan mengapa membutuhkan item ini..."
                              class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-transparent transition text-sm @error('alasan') border-red-400 @enderror"
                              required>{{ old('alasan') }}</textarea>
                    @error('alasan')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Buttons -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 rounded-b-2xl flex flex-col sm:flex-row justify-end gap-3">
                <a href="{{ route('cs.permintaan.index') }}"
                   class="inline-flex items-center justify-center px-6 py-3 bg-white border-2 border-gray-300 rounded-xl font-semibold text-sm text-gray-700 hover:bg-gray-50 transition">
                    Batal
                </a>
                <button type="submit"
                        class="inline-flex items-center justify-center px-8 py-3 bg-gradient-to-r from-teal-500 to-cyan-600 text-white rounded-xl font-bold text-sm hover:from-teal-600 hover:to-cyan-700 transition shadow-lg hover:shadow-xl space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span>Ajukan Permintaan</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function updateStokInfo() {
    const select = document.getElementById('inventory_id');
    const stokInfo = document.getElementById('stok-info');
    const stokText = document.getElementById('stok-text');
    const selectedOption = select.options[select.selectedIndex];

    if (selectedOption.value) {
        const stok = selectedOption.dataset.stok;
        const satuan = selectedOption.dataset.satuan;
        const jenis = selectedOption.dataset.jenis;
        stokInfo.classList.remove('hidden');
        stokText.textContent = `Stok tersedia: ${stok} ${satuan} · Jenis: ${jenis}`;
        document.getElementById('jumlah').max = stok;
    } else {
        stokInfo.classList.add('hidden');
    }
}
document.addEventListener('DOMContentLoaded', updateStokInfo);
</script>
@endsection
