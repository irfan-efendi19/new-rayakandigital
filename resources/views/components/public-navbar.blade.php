<nav class="fixed top-0 left-0 right-0 z-50 backdrop-blur-lg bg-white/80 border-b border-white/20 shadow-sm"
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
                        class="text-xl ml-2 font-bold text-gray-900 group-hover:text-orange-600 transition-colors duration-300">
                        Digital
                    </span>
                </div>
                <!-- Animated underline -->
            </a>

            <!-- Desktop Menu -->
            <div class="hidden md:flex items-center gap-1 lg:gap-2">
                <a href="#"
                    class="relative px-4 py-2 text-gray-600 hover:text-orange-600 text-sm font-medium transition-all duration-300 group">
                    Fitur
                    <span
                        class="absolute bottom-0 left-1/2 w-0 h-0.5 bg-orange-500 transition-all duration-300 group-hover:w-full group-hover:left-0"></span>
                </a>
                <a href="#"
                    class="relative px-4 py-2 text-gray-600 hover:text-orange-600 text-sm font-medium transition-all duration-300 group">
                    Harga
                    <span
                        class="absolute bottom-0 left-1/2 w-0 h-0.5 bg-orange-500 transition-all duration-300 group-hover:w-full group-hover:left-0"></span>
                </a>
                <a href="#"
                    class="relative px-4 py-2 text-gray-600 hover:text-orange-600 text-sm font-medium transition-all duration-300 group">
                    Contoh
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
                        class="px-4 py-2 text-gray-600 hover:text-orange-600 font-medium transition-all duration-300 hover:scale-105">
                        Dashboard
                    </a>
                    @else
                    <a href="{{ route('login') }}"
                        class="px-4 py-2 text-gray-600 hover:text-orange-600 font-medium transition-all duration-300 hover:scale-105">
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

                <!-- Hamburger Button with animation -->
                <button @click="mobileMenuOpen = !mobileMenuOpen"
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
    <div x-show="mobileMenuOpen" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-4"
        class="md:hidden absolute top-16 left-0 right-0 backdrop-blur-xl bg-white/95 border-b border-white/20 shadow-xl">

        <div class="px-4 py-6 space-y-3 max-h-[calc(100vh-4rem)] overflow-y-auto">
            <a href="#"
                class="block px-4 py-3 text-gray-700 hover:text-orange-600 hover:bg-orange-50 rounded-xl text-base font-medium transition-all duration-300 transform hover:translate-x-2">
                Fitur
            </a>
            <a href="#"
                class="block px-4 py-3 text-gray-700 hover:text-orange-600 hover:bg-orange-50 rounded-xl text-base font-medium transition-all duration-300 transform hover:translate-x-2">
                Harga
            </a>
            <a href="#"
                class="block px-4 py-3 text-gray-700 hover:text-orange-600 hover:bg-orange-50 rounded-xl text-base font-medium transition-all duration-300 transform hover:translate-x-2">
                Contoh
            </a>

            <div class="pt-4 border-t border-gray-100">
                @if (Route::has('login'))
                @auth
                <a href="{{ route('dashboard') }}"
                    class="block px-4 py-3 text-gray-700 hover:text-orange-600 hover:bg-orange-50 rounded-xl font-medium transition-all duration-300">
                    Dashboard
                </a>
                @else
                <a href="{{ route('login') }}"
                    class="block px-4 py-3 text-gray-700 hover:text-orange-600 hover:bg-orange-50 rounded-xl font-medium transition-all duration-300">
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