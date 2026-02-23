<x-guest-layout>
    <div class="relative group">
        <div class="absolute -inset-1 bg-gradient-to-r from-blue-600 to-indigo-500 rounded-3xl blur opacity-20 group-hover:opacity-40 transition duration-1000"></div>

        <div class="relative bg-white/90 backdrop-blur-xl px-8 py-10 rounded-3xl shadow-2xl border border-white/20">

            <div class="text-center mb-8">
                <div class="flex justify-center mb-6">
                    <div class="w-20 h-20 bg-blue-50 rounded-2xl flex items-center justify-center transform group-hover:scale-110 transition-transform duration-500">
                        <svg class="h-10 w-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                        </svg>
                    </div>
                </div>

                <h2 class="text-2xl font-black text-gray-800 tracking-tight">Lost Your <span class="text-blue-600">Key?</span></h2>
                <p class="mt-3 text-sm text-gray-500 leading-relaxed px-2">
                    Tenang, jangan panik! Masukkan email kamu di bawah, nanti kita kirimin link buat bikin password baru. ✨
                </p>
            </div>

            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
                @csrf

                <div class="space-y-2">
                    <label for="email" class="ml-1 text-[11px] font-black text-blue-600 uppercase tracking-[0.2em]">
                        Your Email Address
                    </label>
                    <div class="relative">
                        <input id="email"
                               type="email"
                               name="email"
                               value="{{ old('email') }}"
                               required
                               autofocus
                               class="w-full px-5 py-4 bg-gray-50 border-2 border-gray-100 rounded-2xl text-sm focus:bg-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-600 transition-all duration-300 outline-none"
                               placeholder="email@kantor.com">
                    </div>
                    <x-input-error :messages="$errors->get('email')" class="mt-1 ml-2" />
                </div>

                <div class="pt-2">
                    <button type="submit"
                            class="w-full py-4 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-black rounded-2xl shadow-lg shadow-blue-200 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 active:scale-[0.98]">
                        🚀 SEND RESET LINK
                    </button>
                </div>

                <div class="text-center mt-6">
                    <a href="{{ route('login') }}" class="text-sm font-bold text-gray-400 hover:text-blue-600 transition-colors flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                        Back to Sign In
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
