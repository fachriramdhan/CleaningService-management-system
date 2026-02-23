<nav x-data="{ open: false, scrolled: false }"
     @scroll.window="scrolled = (window.pageYOffset > 20) ? true : false"
     :class="{ 'bg-white/80 backdrop-blur-md shadow-lg': scrolled, 'bg-white': !scrolled }"
     class="sticky top-0 z-50 border-b border-gray-100 transition-all duration-300 transform-gpu">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20"> <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route(auth()->user()->role . '.dashboard') }}" class="hover:scale-110 transition-transform duration-300">
                        <x-application-logo class="block h-10 w-auto fill-current text-blue-600" />
                    </a>
                </div>

                <div class="hidden space-x-4 sm:-my-px sm:ms-10 sm:flex items-center">
                    <x-nav-link :href="route(auth()->user()->role . '.dashboard')"
                                :active="request()->routeIs(auth()->user()->role . '.dashboard')"
                                class="rounded-xl px-4 py-2 hover:bg-blue-50 transition-all duration-200 border-none font-bold">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <div class="ms-3 relative">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-4 py-2 rounded-2xl bg-gray-50 text-sm font-black text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-all duration-200 focus:outline-none border border-transparent active:scale-95">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-gradient-to-tr from-blue-600 to-indigo-500 flex items-center justify-center text-white text-[10px] shadow-sm">
                                        {{ substr(Auth::user()->name, 0, 1) }}
                                    </div>
                                    {{ Auth::user()->name }}
                                </div>

                                <div class="ms-2">
                                    <svg class="fill-current h-4 w-4 opacity-50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <div class="p-2 space-y-1">
                                <x-dropdown-link :href="route('profile.edit')" class="rounded-lg font-bold text-gray-600 hover:bg-blue-50 hover:text-blue-600">
                                    ✨ {{ __('Profile') }}
                                </x-dropdown-link>

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link :href="route('logout')"
                                            class="rounded-lg font-bold text-red-500 hover:bg-red-50"
                                            onclick="event.preventDefault(); this.closest('form').submit();">
                                        👋 {{ __('Log Out') }}
                                    </x-dropdown-link>
                                </form>
                            </div>
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-3 rounded-xl text-gray-400 hover:text-blue-600 hover:bg-blue-50 focus:outline-none transition duration-200">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div x-show="open"
         x-cloak
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
         class="sm:hidden bg-white border-t border-gray-100 shadow-inner">
        <div class="pt-2 pb-3 space-y-1 px-4">
            <x-responsive-nav-link :href="route(auth()->user()->role . '.dashboard')" :active="request()->routeIs(auth()->user()->role . '.dashboard')"
                                   class="rounded-xl font-bold">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <div class="pt-4 pb-1 border-t border-gray-100 bg-gray-50/50">
            <div class="px-6 flex items-center gap-4">
                <div class="w-10 h-10 rounded-full bg-blue-600 flex items-center justify-center text-white font-black shadow-md">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div>
                    <div class="font-black text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-xs text-gray-500">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-4 space-y-1 px-4 pb-4">
                <x-responsive-nav-link :href="route('profile.edit')" class="rounded-xl font-bold">
                    Profile Settings
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            class="rounded-xl font-bold text-red-500 hover:bg-red-50"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                        Logout
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
