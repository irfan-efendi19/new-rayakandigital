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
                            <span class="bg-gradient-to-r from-primary to-primary-600 bg-clip-text text-transparent italic">Rayakan</span><span class="text-secondary-800 dark:text-neutral-100">&nbsp;Digital</span>
                        </span>
                    </a>
                </div>

                {{-- Desktop Nav Links --}}
                <div class="hidden space-x-1 sm:-my-px sm:ms-8 sm:flex sm:items-center h-16">
                    @php
                        $navLinks = [
                            ['route' => 'dashboard', 'label' => 'Dashboard', 'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
                            ['route' => 'dashboard.invitations.create', 'label' => 'Buat Undangan', 'icon' => 'M12 4v16m8-8H4'],
                            ['route' => 'dashboard.checkout', 'label' => 'Paket & Harga', 'icon' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4'],
                        ];
                    @endphp

                    @foreach($navLinks as $link)
                        @php $isActive = request()->routeIs($link['route']); @endphp
                        <a href="{{ route($link['route']) }}"
                           class="nav-link-pill relative inline-flex items-center gap-1.5 px-3 py-1 text-sm font-medium transition-colors duration-200 rounded-lg
                               {{ $isActive
                                   ? 'text-primary dark:text-primary-400 bg-primary-50 dark:bg-primary-900/30 active'
                                   : 'text-neutral-600 dark:text-neutral-400 hover:text-secondary-800 dark:hover:text-neutral-200 hover:bg-neutral-100/70 dark:hover:bg-secondary-800/70'
                               }}">
                            {{ $link['label'] }}
                        </a>
                    @endforeach

                    @if(Auth::user()->isAdmin())
                        <a href="{{ route('admin.impersonate.index') }}"
                           class="nav-link-pill relative inline-flex items-center gap-1.5 px-3 py-1 text-sm font-medium text-neutral-600 dark:text-neutral-400 hover:text-secondary-800 dark:hover:text-neutral-200 hover:bg-neutral-100/70 dark:hover:bg-secondary-800/70 rounded-lg transition-colors duration-200">
                            Intip Pengguna
                        </a>
                        <a href="/admin"
                           class="nav-link-pill relative inline-flex items-center gap-1.5 px-3 py-1 text-sm font-medium text-neutral-600 dark:text-neutral-400 hover:text-secondary-800 dark:hover:text-neutral-200 hover:bg-neutral-100/70 dark:hover:bg-secondary-800/70 rounded-lg transition-colors duration-200">
                            Admin Panel
                        </a>
                    @endif
                </div>
            </div>

            {{-- Right side: Dark mode + User menu --}}
            <div class="hidden sm:flex sm:items-center sm:gap-2">
                {{-- Dark Mode Toggle --}}
                <button @click="$store.darkMode.toggle()"
                    class="relative p-2 rounded-xl text-neutral-400 dark:text-neutral-500 hover:text-amber-500 dark:hover:text-amber-400 bg-neutral-100/50 dark:bg-secondary-800/50 hover:bg-amber-50 dark:hover:bg-secondary-700 focus:outline-none focus:ring-2 focus:ring-primary-400/50 transition-all duration-200"
                    title="Ganti tema">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" x-show="!$store.darkMode.on">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.72 9.72 0 0118 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 003 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 009.002-5.998z" />
                    </svg>
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" x-show="$store.darkMode.on" style="display: none;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" />
                    </svg>
                </button>

                {{-- User Dropdown --}}
                <x-dropdown align="right" width="56">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center gap-2.5 pl-1.5 pr-3 py-1.5 rounded-xl border border-neutral-200/80 dark:border-secondary-700 bg-white/80 dark:bg-secondary-800/80 hover:bg-white dark:hover:bg-secondary-700 hover:border-primary-200 dark:hover:border-primary-800/60 focus:outline-none focus:ring-2 focus:ring-primary-400/50 focus:ring-offset-1 dark:focus:ring-offset-secondary-900 transition-all duration-200 backdrop-blur-sm">
                            {{-- Avatar with ring --}}
                            <div class="relative">
                                <div class="w-7 h-7 rounded-lg bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center text-white font-bold text-xs overflow-hidden ring-2 ring-white dark:ring-secondary-800">
                                    @if(Auth::user()->avatar)
                                        <img src="{{ Auth::user()->avatar }}" alt="" class="w-full h-full object-cover">
                                    @else
                                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                    @endif
                                </div>
                                <span class="absolute -bottom-0.5 -right-0.5 w-2 h-2 bg-green-500 rounded-full border border-white dark:border-secondary-800"></span>
                            </div>
                            <span class="hidden lg:block text-sm font-medium text-secondary-800 dark:text-neutral-200 max-w-[120px] truncate">{{ Auth::user()->name }}</span>
                            <svg class="w-3.5 h-3.5 text-neutral-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        {{-- User info header --}}
                        <div class="px-4 py-3.5 border-b border-neutral-100 dark:border-secondary-700">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center text-white font-bold text-sm overflow-hidden flex-shrink-0">
                                    @if(Auth::user()->avatar)
                                        <img src="{{ Auth::user()->avatar }}" alt="" class="w-full h-full object-cover">
                                    @else
                                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                    @endif
                                </div>
                                <div class="min-w-0">
                                    <p class="text-sm font-semibold text-secondary-800 dark:text-neutral-200 truncate">{{ Auth::user()->name }}</p>
                                    <p class="text-xs text-neutral-500 dark:text-neutral-400 truncate">{{ Auth::user()->email }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="py-1">
                            <x-dropdown-link :href="route('dashboard')">
                                <div class="flex items-center gap-2.5">
                                    <svg class="w-4 h-4 text-neutral-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                    </svg>
                                    Dashboard
                                </div>
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('dashboard.invitations.create')">
                                <div class="flex items-center gap-2.5">
                                    <svg class="w-4 h-4 text-neutral-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                    Buat Undangan
                                </div>
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('dashboard.checkout')">
                                <div class="flex items-center gap-2.5">
                                    <svg class="w-4 h-4 text-neutral-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                    </svg>
                                    Paket & Harga
                                </div>
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('profile.edit')">
                                <div class="flex items-center gap-2.5">
                                    <svg class="w-4 h-4 text-neutral-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    Profil Saya
                                </div>
                            </x-dropdown-link>
                        </div>

                        <div class="border-t border-neutral-100 dark:border-secondary-700 py-1">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                    <div class="flex items-center gap-2.5 text-red-500 dark:text-red-400">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                        </svg>
                                        Keluar
                                    </div>
                                </x-dropdown-link>
                            </form>
                        </div>
                    </x-slot>
                </x-dropdown>
            </div>

            {{-- Mobile: Dark toggle + Avatar + Hamburger --}}
            <div class="flex items-center gap-1.5 sm:hidden">
                <button @click="$store.darkMode.toggle()"
                    class="p-2 rounded-xl text-neutral-400 dark:text-neutral-500 hover:text-amber-500 dark:hover:text-amber-400 bg-neutral-100/50 dark:bg-secondary-800/50 hover:bg-amber-50 dark:hover:bg-secondary-700 transition-all duration-200"
                    title="Ganti tema">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" x-show="!$store.darkMode.on">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.72 9.72 0 0118 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 003 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 009.002-5.998z" />
                    </svg>
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" x-show="$store.darkMode.on" style="display: none;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" />
                    </svg>
                </button>
                <div class="relative">
                    <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center text-white font-bold text-sm overflow-hidden">
                        @if(Auth::user()->avatar)
                            <img src="{{ Auth::user()->avatar }}" alt="" class="w-full h-full object-cover">
                        @else
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        @endif
                    </div>
                    <span class="absolute -bottom-0.5 -right-0.5 w-2 h-2 bg-green-500 rounded-full border border-white dark:border-secondary-900"></span>
                </div>
                <button @click="open = !open"
                    class="p-2 rounded-xl text-neutral-500 dark:text-neutral-500 hover:text-primary dark:hover:text-primary-400 bg-neutral-100/50 dark:bg-secondary-800/50 hover:bg-primary-50 dark:hover:bg-secondary-700 transition-all duration-200">
                    <svg class="h-5 w-5" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': !open}" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': !open, 'inline-flex': open}" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Mobile Menu --}}
    <div x-cloak :class="{'block': open, 'hidden': !open}" class="hidden sm:hidden bg-white/95 dark:bg-secondary-900/95 backdrop-blur-xl border-t border-neutral-200/70 dark:border-secondary-700/60">
        {{-- User info --}}
        <div class="px-4 py-4 bg-primary-50/50 dark:bg-secondary-800/50">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center text-white font-bold text-base overflow-hidden flex-shrink-0">
                    @if(Auth::user()->avatar)
                        <img src="{{ Auth::user()->avatar }}" alt="" class="w-full h-full object-cover">
                    @else
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    @endif
                </div>
                <div class="min-w-0">
                    <p class="font-semibold text-sm text-secondary-800 dark:text-neutral-200 truncate">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-neutral-500 dark:text-neutral-400 truncate">{{ Auth::user()->email }}</p>
                </div>
            </div>
        </div>

        <div class="px-3 pt-2 pb-3 space-y-0.5">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-neutral-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Dashboard
                </div>
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('dashboard.invitations.create')" :active="request()->routeIs('dashboard.invitations.create')">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-neutral-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Buat Undangan
                </div>
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('dashboard.checkout')" :active="request()->routeIs('dashboard.checkout')">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-neutral-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                    Paket & Harga
                </div>
            </x-responsive-nav-link>

            @if(Auth::user()->isAdmin())
                <x-responsive-nav-link :href="route('admin.impersonate.index')" :active="request()->routeIs('admin.impersonate.*')">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-neutral-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        Intip Pengguna
                    </div>
                </x-responsive-nav-link>
                <x-responsive-nav-link href="/admin" :active="request()->is('admin')">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-neutral-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                        Admin Panel
                    </div>
                </x-responsive-nav-link>
            @endif
        </div>

        <div class="border-t border-neutral-200/70 dark:border-secondary-700/60 px-3 pt-2 pb-3 space-y-0.5">
            <x-responsive-nav-link :href="route('profile.edit')">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-neutral-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    Profil Saya
                </div>
            </x-responsive-nav-link>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                    <div class="flex items-center gap-3 text-red-500">
                        <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        Keluar
                    </div>
                </x-responsive-nav-link>
            </form>
        </div>
    </div>
</nav>