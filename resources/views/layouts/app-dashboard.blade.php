<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') - {{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        /* Force scrollbar untuk mencegah layout shift */
        html {
            overflow-y: scroll;
            scroll-behavior: smooth;
        }

        /* Hide Alpine elements before load */
        [x-cloak] {
            display: none !important;
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 10px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        ::-webkit-scrollbar-thumb {
            background: linear-gradient(to bottom, #3b82f6, #6366f1);
            border-radius: 5px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(to bottom, #2563eb, #4f46e5);
        }

        /* Smooth transitions */
        * {
            -webkit-tap-highlight-color: transparent;
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-900 h-full">
    <div class="min-h-screen flex flex-col" x-data="{ mobileMenuOpen: false, userDropdownOpen: false }">

        <!-- ══════════════════════════════════════════════════════════════════ -->
        <!-- NAVBAR - Sticky Top dengan Backdrop Blur -->
        <!-- ══════════════════════════════════════════════════════════════════ -->
        <nav class="bg-white/90 backdrop-blur-lg border-b border-gray-200 sticky top-0 z-50 shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">

                    <!-- LEFT: Logo -->
                    <div class="flex items-center flex-shrink-0">
                        <a href="{{ route(auth()->user()->role . '.dashboard') }}"
                           class="flex items-center space-x-2 group">
                            <div class="w-9 h-9 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg group-hover:shadow-blue-200 transition-all group-hover:scale-110">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                            </div>
                            <span class="text-xl font-black tracking-tight hidden lg:block">
                                <span class="bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">Cleaning</span><span class="text-gray-800">ATM</span>
                            </span>
                        </a>
                    </div>

                    <!-- CENTER: Desktop Navigation Links (ONLY on lg screens and above) -->
                    <div class="hidden lg:flex lg:items-center lg:gap-2 absolute left-1/2 transform -translate-x-1/2">
                        @yield('nav-links')
                    </div>

                    <!-- RIGHT: User Menu -->
                    <div class="flex items-center flex-shrink-0">

                        <!-- Desktop User Dropdown (only on lg+) -->
                        <div class="hidden lg:ml-6 lg:flex lg:items-center">
                            <div class="relative">
                                <button @click="userDropdownOpen = !userDropdownOpen"
                                        @click.away="userDropdownOpen = false"
                                        type="button"
                                        class="group flex items-center space-x-2 md:space-x-3 text-sm font-medium text-gray-700 hover:text-blue-600 focus:outline-none transition-all duration-200 p-2 rounded-xl hover:bg-gray-100">

                                    <!-- Name & Role (hidden on smaller screens) -->
                                    <div class="hidden lg:flex lg:flex-col lg:text-right">
                                        <span class="block text-sm font-bold leading-none text-gray-900">{{ auth()->user()->name }}</span>
                                        <span class="text-[10px] font-bold uppercase tracking-wider text-gray-400 group-hover:text-blue-500 transition-colors mt-1">
                                            {{ auth()->user()->role }}
                                        </span>
                                    </div>

                                    <!-- Avatar -->
                                    <div class="h-9 w-9 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white shadow-md group-hover:shadow-blue-300 transition-all group-hover:scale-110">
                                        <span class="font-bold text-sm">{{ substr(auth()->user()->name, 0, 1) }}</span>
                                    </div>

                                    <!-- Chevron -->
                                    <svg class="h-4 w-4 text-gray-400 transition-transform duration-200"
                                         :class="userDropdownOpen ? 'rotate-180' : ''"
                                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>

                                <!-- Dropdown Menu -->
                                <div x-show="userDropdownOpen"
                                     x-cloak
                                     x-transition:enter="transition ease-out duration-200"
                                     x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
                                     x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                     x-transition:leave="transition ease-in duration-150"
                                     x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                                     x-transition:leave-end="opacity-0 scale-95 -translate-y-2"
                                     class="absolute right-0 mt-3 w-64 rounded-2xl shadow-2xl bg-white ring-1 ring-black/5 z-50 overflow-hidden border border-gray-100">

                                    <!-- Header -->
                                    <div class="px-4 py-3 bg-gradient-to-r from-blue-500 to-indigo-600">
                                        <p class="text-xs text-white/70 uppercase font-bold tracking-wider">Signed in as</p>
                                        <p class="text-sm font-bold text-white truncate mt-1">{{ auth()->user()->email }}</p>
                                        <span class="inline-block mt-2 px-2 py-0.5 bg-white/20 backdrop-blur-sm text-white text-xs font-bold rounded-full">
                                            {{ strtoupper(auth()->user()->role) }}
                                        </span>
                                    </div>

                                    <!-- Menu Items -->
                                    <div class="py-2">
                                        <a href="{{ route('profile.edit') }}"
                                           class="flex items-center px-4 py-3 text-sm font-semibold text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors">
                                            <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                </svg>
                                            </div>
                                            My Profile
                                        </a>

                                        <div class="border-t border-gray-100 my-1"></div>

                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit"
                                                    class="flex w-full items-center px-4 py-3 text-sm font-semibold text-red-600 hover:bg-red-50 transition-colors">
                                                <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center mr-3">
                                                    <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                                    </svg>
                                                </div>
                                                Logout
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Mobile Menu Button (show on tablet & mobile, hide on lg+) -->
                        <div class="lg:hidden ml-2">
                            <button @click="mobileMenuOpen = !mobileMenuOpen"
                                    type="button"
                                    class="inline-flex items-center justify-center p-2.5 rounded-xl text-gray-500 hover:text-blue-600 hover:bg-blue-50 focus:outline-none transition-all">
                                <svg x-show="!mobileMenuOpen" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                                </svg>
                                <svg x-show="mobileMenuOpen" x-cloak class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Mobile Menu Dropdown (show on tablet & mobile, hide on lg+) -->
            <div x-show="mobileMenuOpen"
                 x-cloak
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 -translate-y-4"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 translate-y-0"
                 x-transition:leave-end="opacity-0 -translate-y-4"
                 class="lg:hidden border-t border-gray-200 bg-white shadow-lg">

                <!-- Nav Links -->
                <div class="px-4 pt-2 pb-3 space-y-1">
                    @yield('mobile-nav-links')
                </div>

                <!-- User Section -->
                <div class="border-t border-gray-200 pt-4 pb-3 px-4 bg-gradient-to-br from-gray-50 to-blue-50">
                    <div class="flex items-center">
                        <div class="h-12 w-12 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white font-bold shadow-lg">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                        <div class="ml-3 flex-1">
                            <div class="text-base font-bold text-gray-900">{{ auth()->user()->name }}</div>
                            <div class="text-sm text-gray-500">{{ auth()->user()->email }}</div>
                            <span class="inline-block mt-1 px-2 py-0.5 bg-blue-100 text-blue-700 text-xs font-bold rounded-full">
                                {{ strtoupper(auth()->user()->role) }}
                            </span>
                        </div>
                    </div>

                    <div class="mt-4 space-y-2">
                        <a href="{{ route('profile.edit') }}"
                           class="flex items-center px-4 py-2.5 rounded-xl text-sm font-semibold text-gray-700 hover:bg-white hover:text-blue-600 transition-colors">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            My Profile
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                    class="flex w-full items-center px-4 py-2.5 rounded-xl text-sm font-semibold text-red-600 hover:bg-red-50 transition-colors">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                </svg>
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        <!-- ══════════════════════════════════════════════════════════════════ -->
        <!-- MAIN CONTENT AREA -->
        <!-- ══════════════════════════════════════════════════════════════════ -->
        <main class="flex-grow py-6 md:py-8">
            @yield('content')
        </main>

        <!-- ══════════════════════════════════════════════════════════════════ -->
        <!-- FOOTER - Sticky Bottom -->
        <!-- ══════════════════════════════════════════════════════════════════ -->
        <footer class="bg-white border-t border-gray-200 py-6 mt-auto">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row justify-between items-center space-y-3 md:space-y-0">

                    <!-- Left: Copyright -->
                    <div class="flex items-center space-x-2 text-gray-600 text-sm">
                        <div class="w-6 h-6 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center">
                            <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <span>© {{ date('Y') }} <strong class="font-bold text-gray-900">CleaningATM</strong></span>
                        <span class="hidden sm:inline text-gray-400">·</span>
                        <span class="hidden sm:inline text-gray-500">Professional Monitoring System</span>
                    </div>

                    <!-- Right: Version Badge -->
                    <div class="flex items-center space-x-3">
                        <span class="px-3 py-1 bg-gradient-to-r from-blue-100 to-indigo-100 text-blue-700 text-xs font-bold rounded-full border border-blue-200">
                            v1.0.2
                        </span>
                        <span class="hidden md:inline text-xs text-gray-400">Made with ❤️</span>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>
