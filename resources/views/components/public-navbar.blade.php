<nav class="fixed top-0 left-0 right-0 z-50 backdrop-blur-lg bg-white/80 dark:bg-secondary-900/80 border-b border-white/20 shadow-sm"
    x-data="{ mobileMenuOpen: false, scrolled: false }"
    x-init="window.addEventListener('scroll', () => { scrolled = window.scrollY > 20 })"
    :class="{ 'bg-white/95 shadow-lg': scrolled, 'bg-white/80': !scrolled }">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">

            <!-- Logo + Brand dengan Logo Image -->
            <a href="{{ route('home') }}" class="group relative flex items-center gap-2">

                <!-- Logo Image -->
                <div class="relative w-8 h-8 sm:w-9 sm:h-9">
                    <img src="{{ asset('img/logo.png') }}" alt="Rayakan Digital Logo"
                        class="w-full h-full object-contain">
                </div>

                <!-- Teks Brand - Hidden di mobile, muncul di desktop -->
                <div class="hidden sm:flex items-baseline">
                    <span
                        class="text-xl font-bold bg-gradient-to-r from-orange-500 to-orange-600 bg-clip-text text-transparent font-heading italic">
                        Rayakan
                    </span>
                    <span
                        class="text-xl ml-2 font-bold text-gray-900 dark:text-neutral-100 group-hover:text-orange-600 transition-colors duration-300">
                        Digital
                    </span>
                </div>
                <!-- Animated underline -->
            </a>

            <!-- Desktop Menu -->
            <div class="hidden md:flex items-center gap-1 lg:gap-2">
                <!-- DROPDOWN MENU LAYANAN -->
                <div class="relative group">
                    <button
                        class="relative px-4 py-2 text-gray-600 dark:text-neutral-300 hover:text-orange-600 text-sm font-medium transition-all duration-300 group flex items-center gap-1">
                        Layanan
                        <i class="fas fa-chevron-down text-xs transition-transform duration-300 group-hover:rotate-180"></i>
                        <span
                            class="absolute bottom-0 left-1/2 w-0 h-0.5 bg-orange-500 transition-all duration-300 group-hover:w-full group-hover:left-0"></span>
                    </button>

                    <!-- Dropdown Panel -->
                    <div
                        class="absolute left-0 mt-2 w-[700px] bg-white dark:bg-secondary-800 rounded-xl shadow-2xl border border-gray-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50">
                        <div class="p-5">
                            <div class="grid grid-cols-3 gap-4">

                                <!-- Undangan Digital -->
                                <a href="{{ route('undangan-web') }}"
                                    class="block p-3 rounded-lg hover:bg-orange-50 transition-all duration-200 group/item">
                                    <div class="flex items-center gap-3 mb-2">
                                        <div
                                            class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center text-orange-500 group-hover/item:bg-orange-500 group-hover/item:text-white transition-colors">
                                            <i class="far fa-envelope text-lg"></i>
                                        </div>
                                        <h3 class="font-semibold text-gray-800 dark:text-neutral-200 group-hover/item:text-orange-600">
                                            Undangan Digital</h3>
                                    </div>
                                    <p class="text-xs text-gray-500 leading-relaxed">
                                        Buat Website Undangan Digital kamu dengan fitur terlengkap dan pilihan tema
                                        tercantik. Edit semudah Canva.
                                    </p>
                                    <p
                                        class="text-xs text-orange-500 mt-2 font-medium opacity-0 group-hover/item:opacity-100 transition-opacity">
                                        Sebar via WhatsApp <i class="fas fa-arrow-right ml-1 text-xs"></i>
                                    </p>
                                </a>
                                <!-- Buku Tamu Digital -->
                                <a href="{{ route('buku-tamu') }}"
                                    class="block p-3 rounded-lg hover:bg-orange-50 transition-all duration-200 group/item">
                                    <div class="flex items-center gap-3 mb-2">
                                        <div
                                            class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center text-orange-500 group-hover/item:bg-orange-500 group-hover/item:text-white transition-colors">
                                            <i class="fas fa-users text-lg"></i>
                                        </div>
                                        <h3 class="font-semibold text-gray-800 dark:text-neutral-200 group-hover/item:text-orange-600">Buku
                                            Tamu Digital</h3>
                                    </div>
                                    <p class="text-xs text-gray-500 leading-relaxed">
                                        Tamu cukup isi RSVP dan otomatis mendapat QR Code tiket masuk. Semua data tamu
                                        terekam detail di Dashboard.
                                    </p>
                                    <p
                                        class="text-xs text-orange-500 mt-2 font-medium opacity-0 group-hover/item:opacity-100 transition-opacity">
                                        Kelola tamu mudah <i class="fas fa-arrow-right ml-1 text-xs"></i>
                                    </p>
                                </a>
                                <!-- Live Streaming -->
                                <a href="{{ route('live-streaming') }}"
                                    class="block p-3 rounded-lg hover:bg-orange-50 transition-all duration-200 group/item">
                                    <div class="flex items-center gap-3 mb-2">
                                        <div
                                            class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center text-orange-500 group-hover/item:bg-orange-500 group-hover/item:text-white transition-colors">
                                            <i class="fas fa-video text-lg"></i>
                                        </div>
                                        <h3 class="font-semibold text-gray-800 dark:text-neutral-200 group-hover/item:text-orange-600">Live
                                            Streaming</h3>
                                    </div>
                                    <p class="text-xs text-gray-500 leading-relaxed">
                                        Siarkan pernikahan secara virtual untuk orang yang tidak bisa hadir. Simpan
                                        kenangan menjadi rekaman lengkap.
                                    </p>
                                    <p
                                        class="text-xs text-orange-500 mt-2 font-medium opacity-0 group-hover/item:opacity-100 transition-opacity">
                                        Streaming sekarang <i class="fas fa-arrow-right ml-1 text-xs"></i>
                                    </p>
                                </a>
                            </div>
                        </div>
                        </div>
                        </div>
                        
                        <!-- TENTANG KAMI -->
                <a href="{{ route('tentang-kami') }}"
                    class="relative px-4 py-2 text-gray-600 dark:text-neutral-300 hover:text-orange-600 text-sm font-medium transition-all duration-300 group">
                    Tentang Kami
                    <span
                        class="absolute bottom-0 left-1/2 w-0 h-0.5 bg-orange-500 transition-all duration-300 group-hover:w-full group-hover:left-0"></span>
                </a>
                <!-- HUBUNGI KAMI -->
                <a href="{{ route('hubungi-kami') }}"
                    class="relative px-4 py-2 text-gray-600 dark:text-neutral-300 hover:text-orange-600 text-sm font-medium transition-all duration-300 group">
                    Hubungi Kami
                    <span
                        class="absolute bottom-0 left-1/2 w-0 h-0.5 bg-orange-500 transition-all duration-300 group-hover:w-full group-hover:left-0"></span>
                </a>
            </div>

            <!-- CTA + Auth + Hamburger -->
            <div class="flex items-center gap-3">
                @if (Route::has('login'))
                    <div class="hidden sm:flex items-center gap-3">
                        @auth
                            <a href="{{ route('dashboard') }}"
                                class="px-4 py-2 relative overflow-hidden group bg-gradient-to-r from-orange-500 to-orange-600 text-white px-5 py-2 rounded-full font-medium transition-all duration-300 hover:shadow-lg hover:scale-105 active:scale-95">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}"
                                class="px-4 py-2 text-gray-600 dark:text-neutral-300 hover:text-orange-600 font-medium transition-all duration-300 hover:scale-105">
                                Masuk
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}"
                                    class="relative overflow-hidden group bg-gradient-to-r from-orange-500 to-orange-600 text-white px-5 py-2 rounded-full font-medium transition-all duration-300 hover:shadow-lg hover:scale-105 active:scale-95">
                                    <span class="relative z-10">Daftar Gratis</span>
                                    <div
                                        class="absolute inset-0 bg-gradient-to-r from-orange-600 to-orange-700 transform translate-y-full group-hover:translate-y-0 transition-transform duration-300">
                                    </div>
                                </a>
                            @endif
                        @endauth
                    </div>
                @endif

                <!-- Dark Mode Toggle -->
                <button @click="$store.darkMode.toggle()"
                    class="relative w-10 h-10 rounded-full flex items-center justify-center transition-all duration-300 hover:bg-orange-50 group text-gray-600 dark:text-neutral-300 hover:text-orange-600 :text-orange-400 :bg-gray-800">
                    <i class="fas fa-sun text-lg" x-show="$store.darkMode.on" style="display: none;"></i>
                    <i class="fas fa-moon text-lg" x-show="!$store.darkMode.on"></i>
                </button>

                <!-- Hamburger Button with animation -->
                <button @click="mobileMenuOpen = !mobileMenuOpen" x-cloak
                    class="md:hidden relative w-10 h-10 rounded-lg flex items-center justify-center transition-all duration-300 hover:bg-orange-50 group"
                    :class="{ 'bg-orange-50': mobileMenuOpen }" :aria-expanded="mobileMenuOpen">
                    <div class="relative w-5 h-5">
                        <!-- Top bar -->
                        <span class="absolute left-0 w-5 h-0.5 bg-gray-600 rounded-full transition-all duration-300"
                            :class="{ 'rotate-45 top-2': mobileMenuOpen, '-translate-y-1.5 top-1/2': !mobileMenuOpen }"></span>
                        <!-- Middle bar -->
                        <span
                            class="absolute left-0 w-5 h-0.5 bg-gray-600 rounded-full transition-all duration-300 top-1/2 -translate-y-1/2"
                            :class="{ 'opacity-0': mobileMenuOpen }"></span>
                        <!-- Bottom bar -->
                        <span class="absolute left-0 w-5 h-0.5 bg-gray-600 rounded-full transition-all duration-300"
                            :class="{ '-rotate-45 top-2': mobileMenuOpen, 'translate-y-1.5 top-1/2': !mobileMenuOpen }"></span>
                    </div>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu with glassmorphism -->
    <div x-show="mobileMenuOpen" x-cloak x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-4"
        class="md:hidden absolute top-16 left-0 right-0 backdrop-blur-xl bg-white/95 dark:bg-secondary-900/95 border-b border-white/20 shadow-xl">

        <div class="px-4 py-6 space-y-3 max-h-[calc(100vh-4rem)] overflow-y-auto">
            <!-- DROPDOWN LAYANAN UNTUK MOBILE -->
            <div x-data="{ open: false }" class="block">
                <button @click="open = !open"
                    class="w-full flex items-center justify-between px-4 py-3 text-gray-700 dark:text-neutral-200 hover:text-orange-600 hover:bg-orange-50 rounded-xl text-base font-medium transition-all duration-300">
                    <span>Layanan</span>
                    <i class="fas fa-chevron-down text-xs transition-transform duration-300" :class="{'rotate-180': open}"></i>
                </button>

                <!-- Sub Menu Layanan (Muncul saat diklik) -->
                <div x-show="open" x-collapse class="pl-4 mt-2 space-y-2">
                    <a href="{{ route('undangan-web') }}"
                        class="flex items-start gap-3 px-4 py-3 text-gray-600 dark:text-neutral-300 hover:text-orange-600 hover:bg-orange-50 rounded-xl text-sm transition-all duration-200">
                        <i class="far fa-envelope text-orange-500 mt-0.5"></i>
                        <div>
                            <div class="font-medium">Undangan Digital</div>
                            <p class="text-xs text-gray-400 mt-0.5">Website undangan dengan fitur lengkap</p>
                        </div>
                    </a>
                    <a href="{{ route('buku-tamu') }}"
                        class="flex items-start gap-3 px-4 py-3 text-gray-600 dark:text-neutral-300 hover:text-orange-600 hover:bg-orange-50 rounded-xl text-sm transition-all duration-200">
                        <i class="fas fa-users text-orange-500 mt-0.5"></i>
                        <div>
                            <div class="font-medium">Buku Tamu Digital</div>
                            <p class="text-xs text-gray-400 mt-0.5">RSVP & QR Code tiket masuk</p>
                        </div>
                    </a>
                    <a href="{{ route('live-streaming') }}"
                        class="flex items-start gap-3 px-4 py-3 text-gray-600 dark:text-neutral-300 hover:text-orange-600 hover:bg-orange-50 rounded-xl text-sm transition-all duration-200">
                        <i class="fas fa-video text-orange-500 mt-0.5"></i>
                        <div>
                            <div class="font-medium">Live Streaming</div>
                            <p class="text-xs text-gray-400 mt-0.5">Siarkan pernikahan secara virtual</p>
                        </div>
                    </a>
                </div>
            </div>

            <a href="{{ route('tentang-kami') }}"
                class="block px-4 py-3 text-gray-700 dark:text-neutral-200 hover:text-orange-600 hover:bg-orange-50 rounded-xl text-base font-medium transition-all duration-300 transform hover:translate-x-2">
                Tentang Kami
            </a>
            <a href="{{ route('hubungi-kami') }}"
                class="block px-4 py-3 text-gray-700 dark:text-neutral-200 hover:text-orange-600 hover:bg-orange-50 rounded-xl text-base font-medium transition-all duration-300 transform hover:translate-x-2">
                Hubungi Kami
            </a>
        </div>

        <div class="pt-4 border-t border-gray-100 pd-4">
            @if (Route::has('login'))
                @auth
                    <a href="{{ route('dashboard') }}"
                        class="block px-4 py-3 text-gray-700 dark:text-neutral-200 hover:text-orange-600 hover:bg-orange-50 rounded-xl font-medium transition-all duration-300">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}"
                        class="block px-4 py-3 text-gray-700 dark:text-neutral-200 hover:text-orange-600 hover:bg-orange-50 rounded-xl font-medium transition-all duration-300">
                        Masuk
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                            class="block mt-2 px-4 py-3 bg-gradient-to-r from-orange-500 to-orange-600 text-white rounded-xl font-medium text-center transition-all duration-300 hover:shadow-lg transform hover:scale-[1.02]">
                            Daftar Gratis
                        </a>
                    @endif
                @endauth
            @endif
        </div>
    </div>
    </div>
</nav>