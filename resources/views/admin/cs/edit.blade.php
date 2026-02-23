@extends('layouts.app-dashboard')

@section('title', 'Edit Data CS')

@section('nav-links')
    <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium text-gray-500 hover:text-gray-700">Dashboard</a>
    <a href="{{ route('admin.cs.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 border-indigo-400 text-sm font-medium text-gray-900">Kelola CS</a>
@endsection

@section('mobile-nav-links')
    <a href="{{ route('admin.dashboard') }}" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50">Dashboard</a>
    <a href="{{ route('admin.cs.index') }}" class="block pl-3 pr-4 py-2 border-l-4 border-indigo-400 text-base font-medium text-indigo-700 bg-indigo-50">Kelola CS</a>
@endsection

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl md:text-4xl font-bold bg-gradient-to-r from-yellow-600 to-orange-600 bg-clip-text text-transparent">
            ✏️ Edit Data CS
        </h1>
        <p class="mt-2 text-gray-600">Update informasi cleaning service: {{ $csProfile->user->name }}</p>
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
                    <h2 class="text-lg font-bold text-white">Form Edit CS</h2>
                    <p class="text-white/70 text-xs">Isi field yang ingin diubah</p>
                </div>
            </div>
        </div>

        <form action="{{ route('admin.cs.update', $csProfile->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="p-6 space-y-6">

                <!-- SECTION: Informasi Akun -->
                <div>
                    <h3 class="text-base font-bold text-gray-900 mb-4 flex items-center">
                        <div class="w-6 h-6 bg-blue-500 rounded-lg flex items-center justify-center mr-2">
                            <span class="text-white text-xs font-bold">1</span>
                        </div>
                        Informasi Akun
                    </h3>

                    <!-- Nama -->
                    <div class="mb-4">
                        <label for="name" class="block text-xs font-bold text-gray-600 mb-2 uppercase tracking-wider">
                            👤 Nama Lengkap <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="name" id="name"
                               value="{{ old('name', $csProfile->user->name) }}"
                               class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition @error('name') border-red-400 @enderror"
                               required>
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="mb-4">
                        <label for="email" class="block text-xs font-bold text-gray-600 mb-2 uppercase tracking-wider">
                            📧 Email <span class="text-red-500">*</span>
                        </label>
                        <input type="email" name="email" id="email"
                               value="{{ old('email', $csProfile->user->email) }}"
                               class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition @error('email') border-red-400 @enderror"
                               required>
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="password" class="block text-xs font-bold text-gray-600 mb-2 uppercase tracking-wider">
                                🔒 Password Baru
                            </label>
                            <input type="password" name="password" id="password"
                                   class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition @error('password') border-red-400 @enderror">
                            <p class="mt-1 text-xs text-gray-500">Kosongkan jika tidak ingin mengubah</p>
                            @error('password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="password_confirmation" class="block text-xs font-bold text-gray-600 mb-2 uppercase tracking-wider">
                                🔒 Konfirmasi Password
                            </label>
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                   class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition">
                        </div>
                    </div>
                </div>

                <div class="border-t border-gray-200"></div>

                <!-- SECTION: Informasi Profil -->
                <div>
                    <h3 class="text-base font-bold text-gray-900 mb-4 flex items-center">
                        <div class="w-6 h-6 bg-green-500 rounded-lg flex items-center justify-center mr-2">
                            <span class="text-white text-xs font-bold">2</span>
                        </div>
                        Informasi Profil
                    </h3>

                    <!-- Foto Preview + Upload -->
                    <div class="mb-4">
                        <label class="block text-xs font-bold text-gray-600 mb-2 uppercase tracking-wider">
                            📸 Foto Profil
                        </label>

                        <div class="flex flex-col sm:flex-row sm:items-center sm:space-x-4">
                            <div class="mb-3 sm:mb-0">
                                <p class="text-xs text-gray-500 mb-2">Foto saat ini:</p>
                                <img src="{{ $csProfile->foto === 'default-avatar.png' ? 'https://ui-avatars.com/api/?name=' . urlencode($csProfile->user->name) . '&size=200&background=f59e0b&color=fff' : asset('storage/' . $csProfile->foto) }}"
                                     alt="{{ $csProfile->user->name }}"
                                     id="current-photo"
                                     class="w-24 h-24 rounded-full object-cover border-4 border-yellow-300 shadow-lg">
                            </div>
                            <div class="flex-1">
                                <input type="file" name="foto" id="foto" accept="image/*"
                                       class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition text-sm @error('foto') border-red-400 @enderror"
                                       onchange="previewImage(event)">
                                <p class="mt-1 text-xs text-gray-500">JPG/PNG, max 2MB. Kosongkan jika tidak ingin mengubah</p>
                                @error('foto')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Tanggal Mulai Kerja -->
                    <div class="mb-4">
                        <label for="tanggal_mulai_kerja" class="block text-xs font-bold text-gray-600 mb-2 uppercase tracking-wider">
                            📅 Tanggal Mulai Kerja <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="tanggal_mulai_kerja" id="tanggal_mulai_kerja"
                               value="{{ old('tanggal_mulai_kerja', $csProfile->tanggal_mulai_kerja->format('Y-m-d')) }}"
                               class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition @error('tanggal_mulai_kerja') border-red-400 @enderror"
                               required>
                        @error('tanggal_mulai_kerja')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Area Tugas -->
                    <div class="mb-4">
                        <label class="block text-xs font-bold text-gray-600 mb-2 uppercase tracking-wider">
                            📍 Area Tugas <span class="text-red-500">*</span>
                        </label>
                        <div class="border-2 border-gray-200 rounded-xl p-4 space-y-2 max-h-48 overflow-y-auto bg-gray-50 @error('areas') border-red-400 @enderror">
                            @foreach($areas as $area)
                                <label class="flex items-center p-2 hover:bg-white rounded-lg cursor-pointer transition">
                                    <input type="checkbox" name="areas[]" value="{{ $area->id }}"
                                           {{ in_array($area->id, old('areas', $csProfile->areas->pluck('id')->toArray())) ? 'checked' : '' }}
                                           class="w-4 h-4 rounded border-gray-300 text-yellow-600 focus:ring-yellow-500">
                                    <span class="ml-3 text-sm font-medium text-gray-700">{{ $area->nama_area }}</span>
                                </label>
                            @endforeach
                        </div>
                        <p class="mt-1 text-xs text-gray-500">Pilih minimal 1 area tugas</p>
                        @error('areas')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status Aktif -->
                    <div class="p-4 bg-gray-50 rounded-xl border-2 border-gray-200">
                        <label class="flex items-start cursor-pointer">
                            <input type="checkbox" name="is_active" value="1"
                                   {{ old('is_active', $csProfile->is_active) ? 'checked' : '' }}
                                   class="mt-1 w-5 h-5 rounded border-gray-300 text-green-600 focus:ring-green-500">
                            <div class="ml-3">
                                <span class="text-sm font-bold text-gray-900">✅ CS Aktif</span>
                                <p class="text-xs text-gray-500 mt-0.5">Nonaktifkan jika CS tidak bertugas lagi</p>
                            </div>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Footer Buttons -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex flex-col sm:flex-row justify-end gap-3">
                <a href="{{ route('admin.cs.index') }}"
                   class="inline-flex items-center justify-center px-6 py-3 bg-white border-2 border-gray-300 rounded-xl font-semibold text-sm text-gray-700 hover:bg-gray-50 transition">
                    Batal
                </a>
                <button type="submit"
                        class="inline-flex items-center justify-center px-8 py-3 bg-gradient-to-r from-yellow-500 to-orange-500 text-white rounded-xl font-bold text-sm hover:from-yellow-600 hover:to-orange-600 transition shadow-lg hover:shadow-xl space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span>Update Data</span>
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
            document.getElementById('current-photo').src = e.target.result;
        }
        reader.readAsDataURL(file);
    }
}
</script>
@endsection
