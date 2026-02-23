<x-guest-layout>
    <div class="relative group transition-all duration-500">

        <div class="absolute -inset-1 bg-gradient-to-r from-blue-600 to-cyan-400 rounded-3xl blur opacity-25 group-hover:opacity-50 transition duration-1000 group-hover:duration-200"></div>

        <div class="relative bg-white/90 backdrop-blur-xl px-8 py-10 rounded-3xl shadow-2xl border border-white/20">

            <div class="mb-10 text-center relative">
                <div class="flex justify-center mb-6">
                    <div class="relative">
                        <div class="w-24 h-24 bg-gradient-to-tr from-blue-600 via-indigo-600 to-purple-600 rounded-3xl flex items-center justify-center shadow-[0_20px_50px_rgba(31,_38,_135,_0.3)] transform group-hover:rotate-6 transition-transform duration-500">
                            <svg class="h-12 w-12 text-white drop-shadow-lg" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                        <div class="absolute -inset-2 rounded-[2rem] border-2 border-dashed border-blue-400/30 animate-[spin_10s_linear_infinite]"></div>
                    </div>
                </div>

                <h2 class="text-3xl font-black tracking-tighter text-gray-800 mb-2">
                    Welcome <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600">Back!</span>
                </h2>
                <p class="text-sm font-medium text-gray-500">Ready to make those ATMs sparkle? ✨</p>
            </div>

            <x-auth-session-status class="mb-4" :status="session('status')" />
            @if($errors->any())
                <div class="mb-6 p-4 bg-red-50/50 border-l-4 border-red-500 rounded-r-xl flex items-center space-x-3 animate-head-shake">
                    <span class="text-xl">⚠️</span>
                    <p class="text-xs text-red-700 font-bold uppercase tracking-tight">Opps! Login gagal nih, cek lagi ya.</p>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <div class="space-y-2">
                    <label for="email" class="ml-1 text-[11px] font-black text-blue-600 uppercase tracking-[0.2em]">
                        Email
                    </label>
                    <div class="relative group/input">
                        <input id="email" type="email" name="email" value="{{ old('email') }}"
                               class="w-full px-5 py-4 bg-gray-50/50 border-2 border-gray-100 rounded-2xl text-sm focus:bg-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all duration-300 outline-none placeholder:text-gray-400"
                               placeholder="yourname@work.com" required autofocus>
                        <div class="absolute right-4 top-4 opacity-0 group-focus-within/input:opacity-100 transition-opacity">
                            <span class="text-blue-500 font-bold text-xs">Nice!</span>
                        </div>
                    </div>
                </div>

                <div class="space-y-2">
                    <label for="password" class="ml-1 text-[11px] font-black text-blue-600 uppercase tracking-[0.2em]">
                        Password
                    </label>
                    <div class="relative group/input" x-data="{ show: false }">
                        <input id="password" :type="show ? 'text' : 'password'" name="password"
                               class="w-full px-5 py-4 bg-gray-50/50 border-2 border-gray-100 rounded-2xl text-sm focus:bg-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all duration-300 outline-none placeholder:text-gray-400"
                               placeholder="••••••••" required>
                        <button type="button" @click="show = !show" class="absolute right-4 top-4 text-gray-400 hover:text-blue-600 transition">
                            <template x-if="!show">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </template>
                            <template x-if="show">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                            </template>
                        </button>
                    </div>
                </div>

                <div class="flex items-center justify-between px-1">
                    <label class="flex items-center group cursor-pointer">
                        <input type="checkbox" name="remember" class="w-5 h-5 rounded-lg border-2 border-gray-200 text-blue-600 focus:ring-0 transition-all cursor-pointer">
                        <span class="ml-3 text-sm font-semibold text-gray-600 group-hover:text-blue-600 transition">Tetap login!</span>
                    </label>
                    <a class="text-sm font-bold text-indigo-600 hover:text-purple-600 transition-colors" href="{{ route('password.request') }}">
                        Forgot?
                    </a>
                </div>

                <button type="submit"
                        class="relative w-full py-4 group overflow-hidden rounded-2xl bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 text-white font-black text-lg shadow-[0_10px_30px_rgba(79,_70,_229,_0.4)] hover:shadow-[0_20px_40px_rgba(79,_70,_229,_0.5)] transition-all duration-300 active:scale-[0.98]">
                    <span class="relative z-10 flex items-center justify-center space-x-2">
                        <span>LET'S GOOO!</span>
                        <svg class="w-5 h-5 group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </span>
                    <div class="absolute inset-0 bg-white/20 translate-y-full group-hover:translate-y-0 transition-transform duration-300"></div>
                </button>
            </form>

            <div class="mt-12 text-center">
                <p class="text-[10px] font-black text-gray-300 uppercase tracking-[0.4em]">
                    Powered by Innovation
                </p>
                <div class="mt-4 flex justify-center space-x-1">
                    <div class="h-1.5 w-8 bg-blue-600 rounded-full"></div>
                    <div class="h-1.5 w-2 bg-indigo-400 rounded-full"></div>
                    <div class="h-1.5 w-2 bg-purple-300 rounded-full"></div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
