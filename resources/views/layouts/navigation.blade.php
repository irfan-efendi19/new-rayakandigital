<nav class="bg-white/85 dark:bg-secondary-900/85 backdrop-blur-xl border-b border-neutral-200/80 dark:border-secondary-700/60 sticky top-0 z-50"
    x-data="{ open: false }">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            {{-- Logo --}}
            <div class="flex items-center">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                        <img src="/img/logo.png" alt="Rayakan Digital" class="h-8 w-auto">
                        <span class="font-heading text-lg font-bold leading-none">
                            <span
                                class="bg-gradient-to-r from-primary to-primary-600 bg-clip-text text-transparent italic">Rayakan</span><span
                                class="text-secondary-800 dark:text-neutral-100">&nbsp;Digital</span>
                        </span>
                    </a>
                </div>

                {{-- Desktop Nav Links --}}
            </div>

            {{-- Settings Dropdown & Search --}}
            <div class="hidden lg:flex lg:items-center lg:ms-6 gap-3">

                {{-- Dark Mode Toggle --}}
                <button type="button" x-data="{ isDark: document.documentElement.classList.contains('dark') }"
                    @click="isDark = !isDark; if(isDark){ document.documentElement.classList.add('dark'); localStorage.setItem('dark-mode','true'); }else{ document.documentElement.classList.remove('dark'); localStorage.setItem('dark-mode','false'); }"
                    class="p-2 rounded-xl text-neutral-500 dark:text-neutral-400 hover:text-secondary-800 dark:hover:text-neutral-100 hover:bg-neutral-100 dark:hover:bg-secondary-800 transition-colors focus:outline-none"
                    title="Toggle Dark Mode">
                    {{-- Sun Icon (shown in dark mode) --}}
                    <svg x-show="isDark" class="w-5 h-5 text-amber-400" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" style="display:none;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    {{-- Moon Icon (shown in light mode) --}}
                    <svg x-show="!isDark" class="w-5 h-5 text-neutral-600" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                    </svg>
                </button>

                @auth
                    {{-- User Dropdown --}}
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" @click.away="open = false"
                            class="inline-flex items-center gap-2.5 px-3 py-1.5 rounded-xl border border-neutral-200 dark:border-secondary-700 bg-white/80 dark:bg-secondary-800/80 text-sm font-medium text-secondary-800 dark:text-neutral-200 hover:border-neutral-300 dark:hover:border-secondary-600 transition-all shadow-sm">
                            {{-- Avatar Initial --}}
                            <div
                                class="w-7 h-7 rounded-lg bg-gradient-to-tr from-primary-600 to-primary-400 text-white font-bold flex items-center justify-center text-xs shadow-sm">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <span class="max-w-[120px] truncate font-semibold text-xs">{{ Auth::user()->name }}</span>
                            @if(Auth::user()->is_admin)
                                <span
                                    class="px-1.5 py-0.5 rounded text-[10px] font-extrabold bg-amber-100 text-amber-800 dark:bg-amber-900/50 dark:text-amber-300 uppercase tracking-wider">Admin</span>
                            @endif
                            <svg class="w-4 h-4 text-neutral-400 transition-transform duration-200"
                                :class="{ 'rotate-180': open }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <div x-show="open" x-transition:enter="transition ease-out duration-150"
                            x-transition:enter-start="opacity-0 scale-95 translate-y-1"
                            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-100"
                            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                            x-transition:leave-end="opacity-0 scale-95 translate-y-1"
                            class="absolute right-0 mt-2 w-56 rounded-2xl bg-white dark:bg-secondary-800 border border-neutral-200/80 dark:border-secondary-700/80 shadow-xl py-2 z-50 divide-y divide-neutral-100 dark:divide-secondary-700/60"
                            style="display: none;">

                            <div class="px-4 py-2.5">
                                <p class="text-xs text-neutral-500 dark:text-neutral-400">Login sebagai</p>
                                <p class="text-sm font-bold text-secondary-800 dark:text-neutral-100 truncate">
                                    {{ Auth::user()->email }}
                                </p>
                            </div>

                            <div class="py-1">
                                <x-dropdown-link :href="route('dashboard')">
                                    <div class="flex items-center gap-2.5">
                                        <svg class="w-4 h-4 text-neutral-400" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                        </svg>
                                        Dashboard
                                    </div>
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('dashboard.checkout')">
                                    <div class="flex items-center gap-2.5">
                                        <svg class="w-4 h-4 text-neutral-400" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                        </svg>
                                        Paket & Harga
                                    </div>
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('profile.edit')">
                                    <div class="flex items-center gap-2.5">
                                        <svg class="w-4 h-4 text-neutral-400" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        Profil Saya
                                    </div>
                                </x-dropdown-link>

                                @if(Auth::user()->is_admin)
                                    <x-dropdown-link href="/admin">
                                        <div class="flex items-center gap-2.5 text-amber-600 dark:text-amber-400 font-semibold">
                                            <svg class="w-4 h-4 text-amber-500" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                            </svg>
                                            Admin Panel
                                        </div>
                                    </x-dropdown-link>
                                    <x-dropdown-link :href="route('admin.impersonate.index')">
                                        <div class="flex items-center gap-2.5 text-amber-600 dark:text-amber-400 font-semibold">
                                            <svg class="w-4 h-4 text-amber-500" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            Intip Pengguna
                                        </div>
                                    </x-dropdown-link>
                                @endif
                            </div>

                            <div class="py-1">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault(); this.closest('form').submit();">
                                        <div class="flex items-center gap-2.5 text-red-600 dark:text-red-400">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                            </svg>
                                            Keluar
                                        </div>
                                    </x-dropdown-link>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}"
                        class="text-sm font-semibold text-neutral-600 dark:text-neutral-300 hover:text-primary">Masuk</a>
                    <a href="{{ route('register') }}"
                        class="px-4 py-2 rounded-xl bg-primary hover:bg-primary-600 text-white text-sm font-semibold transition-all">Daftar</a>
                @endauth

            </div>

            {{-- Mobile Actions --}}
            <div class="-me-2 flex items-center lg:hidden">

                {{-- Dark Mode Toggle (Mobile) --}}
                <button type="button" x-data="{ isDark: document.documentElement.classList.contains('dark') }"
                    @click="isDark = !isDark; if(isDark){ document.documentElement.classList.add('dark'); localStorage.setItem('dark-mode','true'); }else{ document.documentElement.classList.remove('dark'); localStorage.setItem('dark-mode','false'); }"
                    class="p-2 rounded-xl text-neutral-500 dark:text-neutral-400 hover:text-secondary-800 dark:hover:text-neutral-100 hover:bg-neutral-100 dark:hover:bg-secondary-800 transition-colors focus:outline-none"
                    title="Toggle Dark Mode">
                    {{-- Sun Icon (shown in dark mode) --}}
                    <svg x-show="isDark" class="w-5 h-5 text-amber-400" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" style="display:none;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    {{-- Moon Icon (shown in light mode) --}}
                    <svg x-show="!isDark" class="w-5 h-5 text-neutral-600" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                    </svg>
                </button>

                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-xl text-neutral-400 hover:text-neutral-500 hover:bg-neutral-100 dark:hover:bg-secondary-800 focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Responsive Navigation Menu (Mobile) --}}
    <div :class="{'block': open, 'hidden': ! open}"
        class="hidden lg:hidden bg-white/95 dark:bg-secondary-900/95 border-b border-neutral-200 dark:border-secondary-700">
        <div class="pt-2 pb-3 space-y-1 px-3">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-neutral-400 shrink-0" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Dashboard
                </div>
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('dashboard.invitations.create')"
                :active="request()->routeIs('dashboard.invitations.create')">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-neutral-400 shrink-0" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Buat Undangan
                </div>
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('dashboard.checkout')"
                :active="request()->routeIs('dashboard.checkout')">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-neutral-400 shrink-0" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                    Paket & Harga
                </div>
            </x-responsive-nav-link>
        </div>

        @auth
            <div class="pt-4 pb-3 border-t border-neutral-200 dark:border-secondary-700 px-4">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="font-bold text-base text-secondary-800 dark:text-neutral-100">{{ Auth::user()->name }}
                        </div>
                        <div class="font-medium text-xs text-neutral-500 dark:text-neutral-400">{{ Auth::user()->email }}
                        </div>
                    </div>
                </div>

                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')">
                        Profil Saya
                    </x-responsive-nav-link>

                    @if(Auth::user()->is_admin)
                        <x-responsive-nav-link href="/admin" class="text-amber-600 dark:text-amber-400 font-bold">
                            Admin Panel
                        </x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('admin.impersonate.index')"
                            class="text-amber-600 dark:text-amber-400 font-bold">
                            Intip Pengguna
                        </x-responsive-nav-link>
                    @endif

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();"
                            class="text-red-600 dark:text-red-400">
                            Keluar
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        @endauth
    </div>
</nav>