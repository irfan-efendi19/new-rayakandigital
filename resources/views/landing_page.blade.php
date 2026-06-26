<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <x-meta title="Rayakan Digital | Solusi Digital Acara Modern"
        description="Rayakan Digital menyediakan undangan online, buku tamu digital, QR code, dan live streaming untuk acara modern Anda. Buat momen berkesan jadi lebih praktis!"
        keywords="rayakan digital, undangan digital, undangan online, undangan pernikahan, QR code tamu, buku tamu digital, live streaming acara, website undangan, acara modern, undangan web"
        image="{{ asset('img/thumnail.jpg') }}" />

    @stack('meta')

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    <link rel="stylesheet" href="{{ asset('css/landingpage.css') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        if (localStorage.getItem('dark-mode') === 'true' || (!('dark-mode' in localStorage) && window.matchMedia(
            '(prefers-color-scheme: dark)').matches)) {
        document.documentElement.classList.add('dark');
    } else {
        document.documentElement.classList.remove('dark');
    }
    </script>
</head>

<body class="font-sans antialiased bg-gray-50 dark:bg-secondary-900 text-gray-900 dark:text-neutral-100">
    <x-public-navbar />

    <!-- Spacer to prevent content from hiding behind fixed navbar -->
    <div class="h-16"></div>

    <section
        class="relative overflow-hidden bg-gradient-to-br from-white via-primary-50/30 to-secondary-50 dark:from-secondary-900 dark:via-secondary-900 dark:to-secondary-900 py-20 md:py-28 lg:py-32">
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute inset-0 bg-gradient-to-tr from-primary-500/[0.03] to-transparent"></div>
            <div class="absolute inset-0"
                style="background-image: radial-gradient(circle, #94a3b8 1px, transparent 1px); background-size: 32px 32px; opacity: 0.15;">
            </div>
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row items-center gap-12 lg:gap-16">

                <!-- Left Content -->
                <div class="flex-1 text-center lg:text-left">
                    <!-- Badge / Label -->
                    <div
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-primary-100 text-primary-700 text-sm font-semibold mb-6 shadow-sm">
                        <span class="relative flex h-2 w-2">
                            <span
                                class="animate-ping absolute inline-flex h-full w-full rounded-full bg-primary-500 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-primary-600"></span>
                        </span>
                        <span>The Modern Heritage</span>
                    </div>

                    <!-- Main Heading -->
                    <h1
                        class="font-heading text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-bold text-secondary-900 dark:text-neutral-100 leading-tight mb-6">
                        Cara Mudah Buat
                        <span class="relative inline-block">
                            Undangan Digital!
                        </span>
                    </h1>

                    <p class="text-xl md:text-2xl text-primary-600 font-semibold mb-4">
                        Rayakan Cinta dengan Sentuhan Digital
                    </p>

                    <p class="text-base md:text-lg text-neutral-600 dark:text-neutral-300 max-w-2xl mx-auto lg:mx-0 mb-8">
                        Bikin undangan pernikahan online dalam 5 menit. Praktis, elegan, lengkap dengan
                        fitur kirim
                        otomatis via WhatsApp & Check-in QR Code.
                    </p>

                    <!-- CTA Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                        <a href="{{ route('register') }}"
                            class="group inline-flex items-center justify-center gap-2 px-8 py-4 bg-gradient-to-r from-primary-500 to-primary-600 text-white text-base font-semibold rounded-xl shadow-lg hover:shadow-xl hover:from-primary-600 hover:to-primary-700 transition-all duration-300 transform hover:-translate-y-0.5">
                            <i class="fas fa-gem text-lg group-hover:rotate-12 transition-transform duration-300"></i>
                            <span>Buat Undangan Gratis Sekarang</span>
                            <i
                                class="fas fa-arrow-right text-sm group-hover:translate-x-1 transition-transform duration-300"></i>
                        </a>

                        <!-- <a href="#"
                            class="group inline-flex items-center justify-center gap-2 px-8 py-4 bg-white dark:bg-secondary-800 border-2 border-primary-200 text-primary-600 text-base font-semibold rounded-xl hover:bg-primary-50 hover:border-primary-300 hover:text-primary-700 transition-all duration-300 shadow-sm">
                            <i class="fas fa-play-circle text-lg"></i>
                            <span>Lihat Demo</span>
                        </a> -->
                    </div>

                    <!-- Trust Badges / Stats -->
                    <div
                        class="flex flex-wrap items-center gap-6 justify-center lg:justify-start mt-8 pt-4 border-t border-neutral-200 dark:border-secondary-700">
                        <!-- <div class="flex items-center gap-2">
                            <i class="fas fa-check-circle text-emerald-500 text-sm"></i>
                            <span class="text-xs text-neutral-500">10.000+ Undangan Terbuat</span>
                        </div> -->
                        <div class="flex items-center gap-2">
                            <i class="fas fa-star text-amber-400 text-sm"></i>
                            <span class="text-xs text-neutral-500">Rating 4.9/5</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="fas fa-clock text-primary-500 text-sm"></i>
                            <span class="text-xs text-neutral-500">5 Menit Jadi</span>
                        </div>
                    </div>
                </div>

                <!-- Right Content - Mockup / Preview -->
                <div class="flex-1 relative">
                    <!-- Decorative rings -->
                    <div class="absolute -top-10 -right-10 w-40 h-40 border-2 border-primary-200/30 rounded-full">
                    </div>
                    <div class="absolute -bottom-10 -left-10 w-40 h-40 border-2 border-primary-200/30 rounded-full">
                    </div>

                    <!-- Main Mockup Card -->
                    <div
                        class="relative bg-white dark:bg-secondary-800 rounded-3xl shadow-2xl overflow-hidden transform hover:scale-105 transition-transform duration-500 ease-out">
                        <!-- Mockup Header -->
                        <div class="bg-gradient-to-r from-primary-500 to-primary-600 px-6 py-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <div class="w-3 h-3 bg-white/30 rounded-full"></div>
                                    <div class="w-3 h-3 bg-white/30 rounded-full"></div>
                                    <div class="w-3 h-3 bg-white/30 rounded-full"></div>
                                </div>
                                <span class="text-white/80 text-xs font-medium">Undangan Digital</span>
                                <i class="fas fa-envelope-open-text text-white/60 text-sm"></i>
                            </div>
                        </div>

                        <!-- Mockup Content -->
                        <div class="p-6 bg-gradient-to-br from-neutral-50 to-white dark:from-secondary-800 dark:to-secondary-800">
                            <!-- Wedding Couple Illustration -->
                            <div class="text-center mb-4">
                                <div
                                    class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-primary-100 mb-3">
                                    <i class="fas fa-heart text-3xl text-primary-500"></i>
                                </div>
                                <h3 class="font-heading text-xl font-bold text-secondary-800 dark:text-neutral-200">
                                    Rayakan
                                    Digital</h3>
                                <p class="text-sm text-neutral-500">Pernikahan & Acara Spesial</p>
                            </div>

                            <!-- Mockup Features -->
                            <div class="space-y-3">
                                <div class="flex items-center gap-3 p-2 rounded-lg bg-primary-50/50">
                                    <i class="fas fa-qrcode text-primary-500 w-5"></i>
                                    <span class="text-sm text-neutral-700 dark:text-neutral-200">Check-in via QR
                                        Code</span>
                                </div>
                                <div class="flex items-center gap-3 p-2 rounded-lg bg-primary-50/50">
                                    <i class="fab fa-whatsapp text-emerald-500 w-5"></i>
                                    <span class="text-sm text-neutral-700 dark:text-neutral-200">Kirim Otomatis
                                        WA</span>
                                </div>
                                <div class="flex items-center gap-3 p-2 rounded-lg bg-primary-50/50">
                                    <i class="fas fa-map-marker-alt text-red-500 w-5"></i>
                                    <span class="text-sm text-neutral-700 dark:text-neutral-200">Live GPS
                                        Location</span>
                                </div>
                            </div>

                            <!-- Mockup Button -->
                            <div
                                class="mt-4 p-3 bg-gradient-to-r from-primary-500 to-primary-600 rounded-xl text-center">
                                <p class="text-white text-xs font-semibold">✨ Buka Undangan ✨</p>
                            </div>
                        </div>

                        <!-- Mockup Footer -->
                        <div class="bg-neutral-100 dark:bg-secondary-800 px-6 py-3 flex justify-between items-center">
                            <div class="flex gap-1">
                                <i class="fas fa-circle text-[6px] text-neutral-400"></i>
                                <i class="fas fa-circle text-[6px] text-neutral-400"></i>
                                <i class="fas fa-circle text-[6px] text-neutral-400"></i>
                            </div>
                            <span class="text-xs text-neutral-400">themodernheritage.com</span>
                        </div>
                    </div>

                    <!-- Floating Elements -->
                    <div class="absolute -top-5 -right-5 animate-bounce-slow">
                        <div class="bg-white dark:bg-secondary-800 rounded-xl shadow-lg px-3 py-2 flex items-center gap-2">
                            <i class="fas fa-check-circle text-emerald-500"></i>
                            <span class="text-xs font-semibold text-secondary-700 dark:text-neutral-200">+5 menit
                                selesai!</span>
                        </div>
                    </div>

                    <div class="absolute -bottom-5 -left-5 animate-bounce-slow animation-delay-1000">
                        <div class="bg-white dark:bg-secondary-800 rounded-xl shadow-lg px-3 py-2 flex items-center gap-2">
                            <i class="fab fa-whatsapp text-emerald-500"></i>
                            <span class="text-xs font-semibold text-secondary-700 dark:text-neutral-200">Kirim ke 100+
                                tamu</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Exclusive Services Section - Alternative Layout -->
    <section id="services" x-data="reveal" :class="visible || 'opacity-0 translate-y-8'"
        class="py-20 bg-gradient-to-br from-white via-tertiary/30 to-white dark:from-secondary-900 dark:via-secondary-900 dark:to-secondary-900 transition-all duration-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Section Header (same as above) -->
            <div class="text-center max-w-3xl mx-auto mb-16">
                <span
                    class="inline-block px-4 py-1.5 rounded-full bg-primary-50 text-primary-600 text-sm font-semibold tracking-wide mb-4">
                    <i class="fas fa-crown mr-2 text-xs"></i>Exclusive Services
                </span>
                <h2 class="font-heading text-4xl md:text-5xl font-bold text-secondary-900 dark:text-neutral-100 mb-5">
                    Layanan <span class="text-primary-500">Premium</span>
                </h2>
                <div class="w-24 h-1 bg-gradient-to-r from-primary-400 to-primary-600 rounded-full mx-auto mb-6">
                </div>
                <p class="text-xl text-neutral-600 dark:text-neutral-300">
                    Solusi digital terlengkap untuk menyempurnakan setiap detail perayaan momen spesial
                    Anda.
                </p>
            </div>

            <!-- Services Cards with Numbers -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

                <!-- Service 1 -->
                <div
                    class="group relative bg-white dark:bg-secondary-800 rounded-2xl shadow-soft hover:shadow-xl transition-all duration-300 hover:-translate-y-2 p-8">
                    <div class="absolute -top-4 left-6">
                        <div
                            class="w-10 h-10 bg-gradient-to-r from-primary-500 to-primary-600 rounded-xl flex items-center justify-center shadow-lg">
                            <span class="text-white font-bold text-lg">01</span>
                        </div>
                    </div>
                    <div class="mt-4">
                        <div
                            class="w-14 h-14 rounded-xl bg-primary-100 text-primary-600 flex items-center justify-center mb-5 group-hover:bg-primary-500 group-hover:text-white transition-all duration-300">
                            <i class="fas fa-envelope-open-text text-xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-secondary-800 dark:text-neutral-200 mb-3">Undangan Web</h3>
                        <p class="text-neutral-500 leading-relaxed mb-5">
                            Undangan digital eksklusif dengan desain responsif, musik latar, galeri foto,
                            dan
                            countdown otomatis.
                        </p>
                        <a href="{{ route('undangan-web') }}"
                            class="inline-flex items-center gap-1 text-primary-600 font-medium group-hover:gap-2 transition-all">
                            Selengkapnya <i class="fas fa-chevron-right text-xs"></i>
                        </a>
                    </div>
                </div>

                <!-- Service 2 -->
                <div
                    class="group relative bg-white dark:bg-secondary-800 rounded-2xl shadow-soft hover:shadow-xl transition-all duration-300 hover:-translate-y-2 p-8">
                    <div class="absolute -top-4 left-6">
                        <div
                            class="w-10 h-10 bg-gradient-to-r from-emerald-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg">
                            <span class="text-white font-bold text-lg">02</span>
                        </div>
                    </div>
                    <div class="mt-4">
                        <div
                            class="w-14 h-14 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center mb-5 group-hover:bg-emerald-500 group-hover:text-white transition-all duration-300">
                            <i class="fas fa-qrcode text-xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-secondary-800 dark:text-neutral-200 mb-3">Buku Tamu Digital
                        </h3>
                        <p class="text-neutral-500 leading-relaxed mb-5">
                            Manajemen tamu modern dengan sistem QR Code. Check-in lebih cepat, terorganisir,
                            data tersimpan otomatis.
                        </p>
                        <a href="{{ route('buku-tamu') }}"
                            class="inline-flex items-center gap-1 text-emerald-600 font-medium group-hover:gap-2 transition-all">
                            Selengkapnya <i class="fas fa-chevron-right text-xs"></i>
                        </a>
                    </div>
                </div>

                <!-- Service 3 -->
                <div
                    class="group relative bg-white dark:bg-secondary-800 rounded-2xl shadow-soft hover:shadow-xl transition-all duration-300 hover:-translate-y-2 p-8">
                    <div class="absolute -top-4 left-6">
                        <div
                            class="w-10 h-10 bg-gradient-to-r from-purple-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg">
                            <span class="text-white font-bold text-lg">03</span>
                        </div>
                    </div>
                    <div class="mt-4">
                        <div
                            class="w-14 h-14 rounded-xl bg-purple-100 text-purple-600 flex items-center justify-center mb-5 group-hover:bg-purple-500 group-hover:text-white transition-all duration-300">
                            <i class="fas fa-broadcast-tower text-xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-secondary-800 dark:text-neutral-200 mb-3">Live Streaming</h3>
                        <p class="text-neutral-500 leading-relaxed mb-5">
                            Hubungkan tamu yang tidak bisa hadir secara fisik melalui integrasi live
                            streaming
                            berkualitas tinggi.
                        </p>
                        <a href="{{ route('live-streaming') }}"
                            class="inline-flex items-center gap-1 text-purple-600 font-medium group-hover:gap-2 transition-all">
                            Selengkapnya <i class="fas fa-chevron-right text-xs"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- CTA Section -->
            <div class="mt-16 text-center">
                <div
                    class="bg-gradient-to-r from-primary-50 to-tertiary dark:from-secondary-800 dark:to-secondary-800 rounded-2xl p-8 md:p-10">
                    <h3 class="text-2xl font-bold text-secondary-800 dark:text-neutral-200 mb-3">
                        Siap Membuat Acara Spesial Anda?
                    </h3>
                    <p class="text-neutral-600 dark:text-neutral-300 mb-6">
                        Konsultasikan kebutuhan Anda dengan tim kami secara gratis.
                    </p>
                    <a href="https://wa.me/62895349823366?text=Halo%20Rayakan%20Digital%2C%20saya%20ingin%20konsultasi%20tentang%20layanan%20undangan%20digital."
                        class="inline-flex items-center gap-2 px-8 py-3 bg-primary-500 text-white rounded-xl font-semibold hover:bg-primary-600 transition-all duration-200 shadow-md hover:shadow-lg">
                        <i class="fas fa-headset"></i>
                        <span>Hubungi Kami Sekarang</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section - Modernized -->
    <section id="how-it-works" class="relative py-24 px-4 overflow-hidden bg-tertiary dark:bg-secondary-900">
        <div
            class="absolute inset-0 bg-gradient-to-br from-white via-tertiary to-primary-50/30 dark:from-secondary-900 dark:via-secondary-900 dark:to-secondary-900">
        </div>
        <div class="absolute inset-0 pointer-events-none"
            style="background-image: radial-gradient(circle, #94a3b8 1px, transparent 1px); background-size: 32px 32px; opacity: 0.12;">
        </div>

        <div class="relative max-w-7xl mx-auto">
            <!-- Header -->
            <div class="text-center max-w-3xl mx-auto mb-16">
                <div
                    class="inline-flex items-center gap-2 px-4 py-2 bg-white/70 backdrop-blur-sm rounded-full shadow-soft mb-6 border border-white/50">
                    <i class="fas fa-bolt text-primary-500 text-sm"></i>
                    <span class="text-sm font-semibold text-primary-600">WORKFLOW</span>
                </div>
                <h2 class="font-heading text-4xl md:text-5xl font-bold text-secondary-900 dark:text-neutral-100 mb-4">
                    Cara Kerja <span class="text-primary-500">Rayakan Digital</span>
                </h2>
                <div class="w-24 h-1 bg-gradient-to-r from-primary-400 to-primary-600 rounded-full mx-auto mb-6">
                </div>
                <p class="text-xl text-neutral-600 dark:text-neutral-300 max-w-2xl mx-auto">
                    Dari memilih desain hingga menyebarkan undangan, semua bisa dilakukan dalam hitungan
                    menit.
                </p>
            </div>

            <!-- Steps Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8">

                <!-- Step 1 -->
                <div class="group relative" x-data="{ hover: false }" @mouseenter="hover = true"
                    @mouseleave="hover = false">
                    <div class="relative h-full bg-white dark:bg-secondary-800 rounded-2xl p-6 text-center transition-all duration-500 hover:shadow-2xl hover:-translate-y-2 border border-neutral-200/50 dark:border-secondary-700/50"
                        :class="{ 'shadow-xl bg-white dark:bg-secondary-800': hover }">
                        <!-- Step Number Background -->
                        <div
                            class="absolute -top-3 -left-3 w-12 h-12 bg-gradient-to-br from-primary-500 to-primary-600 rounded-xl flex items-center justify-center shadow-lg z-10">
                            <span class="text-xl font-bold text-white">1</span>
                        </div>

                        <!-- Icon -->
                        <div class="mb-5 mt-4">
                            <div
                                class="w-20 h-20 mx-auto bg-gradient-to-br from-primary-100 to-primary-50 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-palette text-3xl text-primary-500"></i>
                            </div>
                        </div>

                        <h3
                            class="text-xl font-bold text-secondary-800 dark:text-neutral-200 mb-3 group-hover:text-primary-600 transition-colors">
                            Pilih Tema
                        </h3>
                        <p class="text-neutral-500 leading-relaxed">
                            Jelajahi katalog desain undangan premium dan pratinjau langsung sebelum memilih.
                        </p>

                        <!-- Decorative Line -->
                        <div
                            class="absolute bottom-0 left-1/2 transform -translate-x-1/2 w-0 h-0.5 bg-gradient-to-r from-primary-400 to-primary-600 group-hover:w-1/2 transition-all duration-500">
                        </div>
                    </div>
                </div>

                <!-- Step 2 -->
                <div class="group relative" x-data="{ hover: false }" @mouseenter="hover = true"
                    @mouseleave="hover = false">
                    <div class="relative h-full bg-white dark:bg-secondary-800 rounded-2xl p-6 text-center transition-all duration-500 hover:shadow-2xl hover:-translate-y-2 border border-neutral-200/50 dark:border-secondary-700/50"
                        :class="{ 'shadow-xl bg-white dark:bg-secondary-800': hover }">
                        <div
                            class="absolute -top-3 -left-3 w-12 h-12 bg-gradient-to-br from-secondary-600 to-secondary-700 rounded-xl flex items-center justify-center shadow-lg z-10">
                            <span class="text-xl font-bold text-white">2</span>
                        </div>

                        <div class="mb-5 mt-4">
                            <div
                                class="w-20 h-20 mx-auto bg-gradient-to-br from-secondary-100 to-neutral-100 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-user-plus text-3xl text-secondary-600"></i>
                            </div>
                        </div>

                        <h3
                            class="text-xl font-bold text-secondary-800 dark:text-neutral-200 mb-3 group-hover:text-secondary-600 transition-colors">
                            Daftar & Isi Data
                        </h3>
                        <p class="text-neutral-500 leading-relaxed">
                            Buat akun gratis lalu isi informasi acara, detail mempelai, dan preferensi
                            undangan.
                        </p>

                        <div
                            class="absolute bottom-0 left-1/2 transform -translate-x-1/2 w-0 h-0.5 bg-gradient-to-r from-secondary-400 to-secondary-600 group-hover:w-1/2 transition-all duration-500">
                        </div>
                    </div>
                </div>

                <!-- Step 3 -->
                <div class="group relative" x-data="{ hover: false }" @mouseenter="hover = true"
                    @mouseleave="hover = false">
                    <div class="relative h-full bg-white dark:bg-secondary-800 rounded-2xl p-6 text-center transition-all duration-500 hover:shadow-2xl hover:-translate-y-2 border border-neutral-200/50 dark:border-secondary-700/50"
                        :class="{ 'shadow-xl bg-white dark:bg-secondary-800': hover }">
                        <div
                            class="absolute -top-3 -left-3 w-12 h-12 bg-gradient-to-br from-amber-500 to-orange-500 rounded-xl flex items-center justify-center shadow-lg z-10">
                            <span class="text-xl font-bold text-white">3</span>
                        </div>

                        <div class="mb-5 mt-4">
                            <div
                                class="w-20 h-20 mx-auto bg-gradient-to-br from-amber-100 to-orange-50 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-rocket text-3xl text-amber-500"></i>
                            </div>
                        </div>

                        <h3
                            class="text-xl font-bold text-secondary-800 dark:text-neutral-200 mb-3 group-hover:text-amber-600 transition-colors">
                            Aktivasi Paket
                        </h3>
                        <p class="text-neutral-500 leading-relaxed">
                            Pilih paket sesuai kebutuhan, bayar via berbagai metode, fitur premium langsung
                            aktif.
                        </p>

                        <div
                            class="absolute bottom-0 left-1/2 transform -translate-x-1/2 w-0 h-0.5 bg-gradient-to-r from-amber-400 to-orange-500 group-hover:w-1/2 transition-all duration-500">
                        </div>
                    </div>
                </div>

                <!-- Step 4 -->
                <div class="group relative" x-data="{ hover: false }" @mouseenter="hover = true"
                    @mouseleave="hover = false">
                    <div class="relative h-full bg-white dark:bg-secondary-800 rounded-2xl p-6 text-center transition-all duration-500 hover:shadow-2xl hover:-translate-y-2 border border-neutral-200/50 dark:border-secondary-700/50"
                        :class="{ 'shadow-xl bg-white dark:bg-secondary-800': hover }">
                        <div
                            class="absolute -top-3 -left-3 w-12 h-12 bg-gradient-to-br from-emerald-500 to-teal-500 rounded-xl flex items-center justify-center shadow-lg z-10">
                            <span class="text-xl font-bold text-white">4</span>
                        </div>

                        <div class="mb-5 mt-4">
                            <div
                                class="w-20 h-20 mx-auto bg-gradient-to-br from-emerald-100 to-teal-50 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-share-alt text-3xl text-emerald-500"></i>
                            </div>
                        </div>

                        <h3
                            class="text-xl font-bold text-secondary-800 dark:text-neutral-200 mb-3 group-hover:text-emerald-600 transition-colors">
                            Sebarkan
                        </h3>
                        <p class="text-neutral-500 leading-relaxed">
                            Generate link personal per tamu, pantau RSVP, dan kirim undangan via WhatsApp
                            massal.
                        </p>

                        <div
                            class="absolute bottom-0 left-1/2 transform -translate-x-1/2 w-0 h-0.5 bg-gradient-to-r from-emerald-400 to-teal-500 group-hover:w-1/2 transition-all duration-500">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Connector Lines (Desktop only) -->
            <div class="hidden lg:block relative mt-8">
                <div
                    class="absolute left-[12.5%] top-1/2 transform -translate-y-1/2 w-[25%] h-0.5 bg-gradient-to-r from-primary-300 via-primary-400 to-primary-300 opacity-30">
                </div>
                <div
                    class="absolute left-[37.5%] top-1/2 transform -translate-y-1/2 w-[25%] h-0.5 bg-gradient-to-r from-secondary-300 via-secondary-400 to-secondary-300 opacity-30">
                </div>
                <div
                    class="absolute left-[62.5%] top-1/2 transform -translate-y-1/2 w-[25%] h-0.5 bg-gradient-to-r from-amber-300 via-amber-400 to-amber-300 opacity-30">
                </div>
            </div>

            <!-- Stats / Trust Indicators -->
            <div class="mt-20 grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- <div class="text-center">
                    <div class="flex items-center justify-center gap-2 mb-2">
                        <i class="fas fa-users text-primary-500 text-2xl"></i>
                        <span class="text-3xl font-bold text-secondary-800 dark:text-neutral-200">10K+</span>
                    </div>
                    <p class="text-sm text-neutral-500">Undangan Terbuat</p>
                </div> -->
                <div class="text-center">
                    <div class="flex items-center justify-center gap-2 mb-2">
                        <i class="fas fa-smile text-primary-500 text-2xl"></i>
                        <span class="text-3xl font-bold text-secondary-800 dark:text-neutral-200">98%</span>
                    </div>
                    <p class="text-sm text-neutral-500">Kepuasan Pelanggan</p>
                </div>
                <div class="text-center">
                    <div class="flex items-center justify-center gap-2 mb-2">
                        <i class="fas fa-bolt text-primary-500 text-2xl"></i>
                        <span class="text-3xl font-bold text-secondary-800 dark:text-neutral-200">5 Menit</span>
                    </div>
                    <p class="text-sm text-neutral-500">Setup Cepat</p>
                </div>
                <div class="text-center">
                    <div class="flex items-center justify-center gap-2 mb-2">
                        <i class="fas fa-shield-alt text-primary-500 text-2xl"></i>
                        <span class="text-3xl font-bold text-secondary-800 dark:text-neutral-200">100%</span>
                    </div>
                    <p class="text-sm text-neutral-500">Data Terenkripsi</p>
                </div>
            </div>

            <!-- CTA -->
            <div class="mt-16 text-center">
                <!-- <div class="inline-flex flex-col sm:flex-row gap-4 items-center justify-center">
                    <a href="#"
                        class="inline-flex items-center gap-2 px-8 py-4 bg-gradient-to-r from-primary-500 to-primary-600 text-white rounded-xl font-semibold transition-all duration-300 hover:shadow-xl hover:shadow-primary-200 hover:-translate-y-0.5 active:scale-95 group">
                        <i class="fas fa-gem text-sm"></i>
                        <span>Mulai Sekarang Gratis</span>
                        <i
                            class="fas fa-arrow-right text-sm group-hover:translate-x-1 transition-transform duration-300"></i>
                    </a>
                    <a href="#"
                        class="inline-flex items-center gap-2 px-8 py-4 bg-white dark:bg-secondary-800 border border-neutral-200 dark:border-secondary-700 text-secondary-700 dark:text-neutral-200 rounded-xl font-semibold transition-all duration-300 hover:shadow-md hover:bg-tertiary group">
                        <i class="fas fa-play-circle text-primary-500"></i>
                        <span>Lihat Demo</span>
                    </a>
                </div> -->
                <div class="flex items-center justify-center gap-4 mt-6">
                    <div class="flex items-center gap-1 text-sm text-neutral-500">
                        <i class="fas fa-credit-card text-primary-400"></i>
                        <span>Tidak perlu kartu kredit</span>
                    </div>
                    <div class="w-1 h-1 bg-neutral-300 rounded-full"></div>
                    <div class="flex items-center gap-1 text-sm text-neutral-500">
                        <i class="fas fa-times-circle text-primary-400"></i>
                        <span>Batalkan kapan saja</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Theme Catalog Section -->
    <!-- Themes Catalog Section - Modernized -->
    <section id="themes" x-data="{ filter: 'all' }"
        class="py-20 bg-tertiary dark:bg-secondary-900 transition-all duration-700 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Section Header -->
            <div class="text-center max-w-3xl mx-auto mb-12">
                <span
                    class="inline-block px-4 py-1.5 rounded-full bg-primary-50 text-primary-600 text-sm font-semibold tracking-wide mb-4">
                    <i class="fas fa-palette mr-2 text-xs"></i>Katalog Tema
                </span>
                <h2 class="font-heading text-4xl md:text-5xl font-bold text-secondary-900 dark:text-neutral-100 mb-5">
                    Pilih Desain <span class="text-primary-500">Undangan Anda</span>
                </h2>
                <div class="w-24 h-1 bg-gradient-to-r from-primary-400 to-primary-600 rounded-full mx-auto mb-6">
                </div>
                <p class="text-xl text-neutral-600 dark:text-neutral-300">
                    Lihat pratinjau langsung dengan data contoh. Klik "Gunakan Tema Ini" untuk langsung
                    mulai.
                </p>
            </div>

            <!-- Category Filters -->
            @if($categories->isNotEmpty())
                <div class="flex flex-wrap justify-center gap-3 mb-8">
                    <!-- All Themes Button -->
                    <button @click="filter = 'all'"
                        :class="filter === 'all' ? 'bg-primary-500 text-white border-primary-500 shadow-md shadow-primary-200' : 'bg-white text-secondary-700 dark:text-neutral-200 border-neutral-200 dark:border-secondary-700 hover:border-primary-300 hover:text-primary-600'"
                        class="relative px-5 py-2.5 rounded-full text-sm font-semibold transition-all duration-200 border-2 shadow-sm">
                        <i class="fas fa-th-large mr-2 text-xs"></i>
                        Semua
                        <span
                            class="ml-1.5 inline-flex items-center justify-center min-w-[20px] h-5 px-1.5 rounded-full text-xs font-bold"
                            :class="filter === 'all' ? 'bg-white/20 text-white' : 'bg-neutral-100 text-neutral-600'">
                            {{ $themes->count() }}
                        </span>
                    </button>

                    <!-- Category Buttons -->
                    @foreach($categories as $category)
                        <button @click="filter = '{{ $category->id }}'"
                            :class="filter === '{{ $category->id }}' ? 'bg-primary-500 text-white border-primary-500 shadow-md shadow-primary-200' : 'bg-white text-secondary-700 dark:text-neutral-200 border-neutral-200 dark:border-secondary-700 hover:border-primary-300 hover:text-primary-600'"
                            class="relative px-5 py-2.5 rounded-full text-sm font-semibold transition-all duration-200 border-2 shadow-sm">
                            <i class="fas {{ $category->icon ?? 'fa-folder' }} mr-2 text-xs"></i>
                            {{ $category->name }}
                            <span
                                class="ml-1.5 inline-flex items-center justify-center min-w-[20px] h-5 px-1.5 rounded-full text-xs font-bold"
                                :class="filter === '{{ $category->id }}' ? 'bg-white/20 text-white' : 'bg-neutral-100 text-neutral-600'">
                                {{ $category->themes_count }}
                            </span>
                        </button>
                    @endforeach
                </div>
            @endif

            <!-- Horizontal Scroll Container -->
            {{-- Scroll Container --}}
            <div class="relative">
                <button @click="$refs.scrollContainer.scrollLeft -= 300"
                    class="absolute left-0 top-1/2 -translate-y-1/2 z-10 hidden lg:flex items-center justify-center w-10 h-10 rounded-full transition-all duration-200 cursor-pointer bg-white/80 dark:bg-white/10 border border-neutral-300 dark:border-white/15 text-neutral-600 dark:text-white/80 backdrop-blur-sm hover:bg-white dark:hover:bg-white/20">
                    <i class="fas fa-chevron-left text-sm"></i>
                </button>

                <button @click="$refs.scrollContainer.scrollLeft += 300"
                    class="absolute right-0 top-1/2 -translate-y-1/2 z-10 hidden lg:flex items-center justify-center w-10 h-10 rounded-full transition-all duration-200 cursor-pointer bg-white/80 dark:bg-white/10 border border-neutral-300 dark:border-white/15 text-neutral-600 dark:text-white/80 backdrop-blur-sm hover:bg-white dark:hover:bg-white/20">
                    <i class="fas fa-chevron-right text-sm"></i>
                </button>

                <div x-ref="scrollContainer" class="overflow-x-auto overflow-y-hidden pb-6 scroll-smooth"
                    style="scrollbar-width: thin; scrollbar-color: #d4d4d8 transparent; -webkit-overflow-scrolling: touch;">

                    <div class="flex gap-5 lg:gap-6" style="min-width: min-content;">
                        @forelse($themes as $theme)
                            <div x-show="filter === 'all' || filter === '{{ $theme->theme_category_id ?? '0' }}'"
                                x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95"
                                x-transition:enter-end="opacity-100 scale-100"
                                class="rounded-2xl transition-all duration-500 ease-out hover:shadow-[0_24px_60px_-20px_rgba(15,23,42,0.25)] hover:-translate-y-1.5 shadow-[0_12px_30px_-18px_rgba(15,23,42,0.18)]"
                                style="width: 300px; flex-shrink: 0;">

                                <div
                                    class="group relative rounded-2xl overflow-hidden border border-neutral-100 dark:border-secondary-700/50 bg-white/95 dark:bg-secondary-800/95">

                                {{-- Full-card background image --}}
                                @if($theme->thumbnail_portrait)
                                    <img src="{{ Storage::url($theme->thumbnail_portrait) }}" alt="{{ $theme->name }}"
                                        class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 ease-out group-hover:scale-105">
                                @endif

                                {{-- Content overlay --}}
                                <div class="relative z-10 flex flex-col">
                                    {{-- Thumbnail spacer area --}}
                                    <div class="relative aspect-[4/5]">
                                        @if(!$theme->thumbnail_portrait)
                                            <div class="absolute inset-0 bg-gradient-to-br from-secondary-50 to-tertiary flex items-center justify-center">
                                                <div class="text-center">
                                                    <div class="w-20 h-20 mx-auto bg-gradient-to-br from-primary-100 to-primary-50 rounded-2xl flex items-center justify-center mb-3">
                                                        <i class="fas fa-images text-3xl text-primary-400"></i>
                                                    </div>
                                                    <span class="text-sm text-neutral-400">{{ $theme->name }}</span>
                                                </div>
                                            </div>
                                        @else
                                            <div class="absolute inset-0 bg-gradient-to-b from-black/20 to-transparent"></div>
                                        @endif

                                        {{-- Badge --}}
                                        <div class="absolute top-3 left-3 z-20">
                                            @if($theme->is_premium)
                                                <span
                                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-gradient-to-r from-amber-400 to-amber-500 text-white shadow-lg shadow-amber-200/50">
                                                    <i class="fas fa-crown text-xs"></i>
                                                    Premium
                                                </span>
                                            @else
                                                <span
                                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-white/90 backdrop-blur-sm text-emerald-700 shadow-sm border border-emerald-200/50">
                                                    <i class="fas fa-gem text-xs"></i>
                                                    Gratis
                                                </span>
                                            @endif
                                        </div>

                                        {{-- Rating badge --}}
                                        @if($theme->rating)
                                            <div class="absolute top-3 right-3 z-20 inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-semibold bg-white/90 backdrop-blur-sm text-amber-700 shadow-sm border border-amber-200/50">
                                                <i class="fas fa-star text-amber-400 text-[10px]"></i>
                                                <span>{{ $theme->rating }}</span>
                                            </div>
                                        @endif

                                        {{-- Hover overlay --}}
                                        <div class="absolute inset-0 z-10 opacity-0 group-hover:opacity-100 transition-all duration-300 flex items-center justify-center"
                                            style="background: linear-gradient(to top, rgba(0,0,0,0.7) 0%, rgba(0,0,0,0.15) 50%, transparent 100%);">
                                            <a href="{{ route('theme.preview', str_replace('themes.', '', $theme->view_path)) }}" target="_blank"
                                                class="flex items-center gap-2 px-5 py-2.5 rounded-xl text-white text-sm font-semibold transition-all duration-200 hover:scale-105"
                                                style="background: rgba(255,255,255,0.15); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.25);">
                                                <i class="fas fa-eye text-xs"></i> Lihat Pratinjau
                                            </a>
                                        </div>
                                    </div>

                                {{-- Accent gradient bar on hover --}}
                                <div class="h-0.5 bg-gradient-to-r from-primary-400 via-primary-500 to-primary-600 scale-x-0 group-hover:scale-x-100 transition-transform duration-500 ease-out origin-left"></div>

                                {{-- Card Body --}}
                                <div class="p-5 bg-white/70 dark:bg-secondary-800/70 backdrop-blur-xl">
                                    <h3
                                        class="text-lg font-bold text-secondary-800 dark:text-neutral-200 group-hover:text-primary-600 transition-colors leading-snug mb-2">
                                        {{ $theme->name }}
                                    </h3>

                                    @if($theme->category)
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-primary-50 dark:bg-primary-900/30 text-primary-600 dark:text-primary-300 rounded-lg text-xs font-medium">
                                            <i class="fas fa-tag text-[10px]"></i>{{ $theme->category->name }}
                                        </span>
                                    @endif

                                    <div class="flex items-center gap-2 mt-4">
                                        @auth
                                            <a href="{{ route('dashboard.invitations.create', ['theme' => str_replace('themes.', '', $theme->view_path)]) }}"
                                                class="flex-1 text-center px-4 py-2.5 bg-gradient-to-r from-primary-500 to-primary-600 text-white rounded-xl text-sm font-semibold hover:from-primary-600 hover:to-primary-700 transition-all duration-200 shadow-sm hover:shadow-md active:scale-95">
                                                <i class="fas fa-magic mr-1.5"></i> Gunakan
                                            </a>
                                        @else
                                            <a href="{{ route('register', ['theme' => str_replace('themes.', '', $theme->view_path)]) }}"
                                                class="flex-1 text-center px-4 py-2.5 bg-gradient-to-r from-primary-500 to-primary-600 text-white rounded-xl text-sm font-semibold hover:from-primary-600 hover:to-primary-700 transition-all duration-200 shadow-sm hover:shadow-md active:scale-95">
                                                <i class="fas fa-magic mr-1.5"></i> Gunakan
                                            </a>
                                        @endauth
                                        <a href="{{ route('theme.preview', str_replace('themes.', '', $theme->view_path)) }}" target="_blank"
                                            class="flex items-center justify-center w-11 h-11 rounded-xl border-2 border-neutral-200 dark:border-secondary-600 text-neutral-500 dark:text-neutral-400 hover:border-primary-200 hover:text-primary-600 dark:hover:border-primary-500 dark:hover:text-primary-400 transition-all duration-200 hover:bg-primary-50 dark:hover:bg-primary-900/20 active:scale-95"
                                            title="Pratinjau">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            </div>
                            </div>
                        @empty
                            <div class="col-span-full py-16 text-center" style="min-width: 100%;">
                                <div
                                    class="w-20 h-20 mx-auto bg-neutral-100 dark:bg-secondary-700 rounded-2xl flex items-center justify-center mb-4">
                                    <i class="fas fa-paintbrush text-3xl text-neutral-400"></i>
                                </div>
                                <p class="text-lg font-semibold text-secondary-800 dark:text-neutral-200">Belum ada tema
                                    tersedia</p>
                                <p class="text-sm text-neutral-500 mt-1">Silakan hubungi admin untuk menambahkan tema.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- View All Themes Button -->
            @if($totalThemes > 8)
                <div class="mt-12 text-center">
                    <a href="{{ route('themes.index') }}"
                        class="inline-flex items-center gap-2 px-8 py-3.5 border-2 border-primary-200 text-primary-600 font-semibold rounded-xl bg-white dark:bg-secondary-800 hover:bg-primary-50 hover:border-primary-300 hover:text-primary-700 transition-all duration-200 shadow-sm group">
                        <i class="fas fa-th-large text-sm"></i>
                        <span>Lihat Semua Tema ({{ $totalThemes }})</span>
                        <i class="fas fa-arrow-right text-sm group-hover:translate-x-1 transition-transform duration-200"></i>
                    </a>
                </div>
            @endif
        </div>
    </section>

    <!-- Feature Section -->
    <section x-data="reveal" :class="visible || 'opacity-0 translate-y-8'"
        class="py-20 bg-gradient-to-br from-white via-tertiary/30 to-white dark:from-secondary-900 dark:via-secondary-900 dark:to-secondary-900 transition-all duration-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Section Header -->
            <div class="text-center max-w-3xl mx-auto">
                <span
                    class="inline-block px-4 py-1.5 rounded-full bg-primary-50 text-primary-600 text-sm font-semibold tracking-wide mb-4">
                    <i class="fas fa-star mr-2 text-xs"></i>Fitur Unggulan
                </span>
                <h2 class="font-heading text-4xl md:text-5xl font-bold text-secondary-900 dark:text-neutral-100 mb-5">
                    Semua Yang <span class="text-primary-500">Anda Butuhkan</span>
                </h2>
                <div class="w-24 h-1 bg-gradient-to-r from-primary-400 to-primary-600 rounded-full mx-auto mb-6">
                </div>
                <p class="text-xl text-neutral-500">
                    Rayakan Digital menyediakan fitur lengkap untuk mempermudah tamu dan mempercantik
                    undangan
                    Anda.
                </p>
            </div>

            <!-- Features Grid -->
            <div class="mt-16">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

                    <!-- Feature 1 - RSVP Management -->
                    <div
                        class="group relative bg-white dark:bg-secondary-800 rounded-2xl shadow-soft hover:shadow-xl transition-all duration-300 hover:-translate-y-1 p-6">
                        <div
                            class="absolute inset-0 bg-gradient-to-br from-primary-500/5 to-transparent rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        </div>
                        <div class="relative">
                            <div
                                class="w-14 h-14 rounded-2xl bg-gradient-to-br from-primary-500 to-primary-600 text-white flex items-center justify-center mb-5 shadow-lg shadow-primary-200">
                                <i class="fas fa-calendar-check text-2xl"></i>
                            </div>
                            <h3 class="text-xl font-bold text-secondary-800 dark:text-neutral-200 mb-3">Manajemen RSVP
                            </h3>
                            <p class="text-neutral-500 leading-relaxed">
                                Ketahui siapa saja yang akan hadir ke acara Anda. Sistem RSVP terintegrasi
                                langsung di dashboard dengan notifikasi real-time.
                            </p>
                            <div class="mt-4 flex items-center text-primary-600 text-sm font-semibold">
                                <span>Real-time tracking</span>
                                <i class="fas fa-arrow-right ml-2 text-xs group-hover:translate-x-1 transition-transform"></i>
                                </div>
                                </div>
                                </div>
                                
                                <!-- Feature 2 - Personal Links -->
                                <div
                                    class="group relative bg-white dark:bg-secondary-800 rounded-2xl shadow-soft hover:shadow-xl transition-all duration-300 hover:-translate-y-1 p-6">
                                    <div class="relative">
                                        <div
                                            class="w-14 h-14 rounded-2xl bg-gradient-to-br from-emerald-500 to-emerald-600 text-white flex items-center justify-center mb-5 shadow-lg shadow-emerald-200">
                                            <i class="fas fa-link text-2xl"></i>
                                        </div>
                            <h3 class="text-xl font-bold text-secondary-800 dark:text-neutral-200 mb-3">Link Personal
                            </h3>
                            <p class="text-neutral-500 leading-relaxed">
                                Sapa tamu dengan nama mereka. Generate link khusus untuk setiap tamu lengkap
                                dengan template pesan WhatsApp otomatis.
                            </p>
                            <div class="mt-4 flex items-center text-emerald-600 text-sm font-semibold">
                                <span>Personalized greeting</span>
                                <i class="fas fa-arrow-right ml-2 text-xs group-hover:translate-x-1 transition-transform"></i>
                                </div>
                                </div>
                                </div>
                                
                                <!-- Feature 3 - Digital Gift -->
                                <div
                                    class="group relative bg-white dark:bg-secondary-800 rounded-2xl shadow-soft hover:shadow-xl transition-all duration-300 hover:-translate-y-1 p-6">
                                    <div class="relative">
                                        <div
                                            class="w-14 h-14 rounded-2xl bg-gradient-to-br from-amber-500 to-amber-600 text-white flex items-center justify-center mb-5 shadow-lg shadow-amber-200">
                                            <i class="fas fa-gift text-2xl"></i>
                                        </div>
                            <h3 class="text-xl font-bold text-secondary-800 dark:text-neutral-200 mb-3">Digital Gift
                                (Angpao)</h3>
                            <p class="text-neutral-500 leading-relaxed">
                                Mudahkan tamu untuk memberikan kado atau angpao melalui transfer bank, QRIS,
                                atau scan e-wallet favorit mereka.
                            </p>
                            <div class="mt-4 flex items-center text-amber-600 text-sm font-semibold">
                                <span>Multi payment method</span>
                                <i class="fas fa-arrow-right ml-2 text-xs group-hover:translate-x-1 transition-transform"></i>
                                </div>
                                </div>
                                </div>
                                
                                <!-- Feature 4 - Guest Book -->
                                <div
                                    class="group relative bg-white dark:bg-secondary-800 rounded-2xl shadow-soft hover:shadow-xl transition-all duration-300 hover:-translate-y-1 p-6">
                                    <div class="relative">
                                        <div
                                            class="w-14 h-14 rounded-2xl bg-gradient-to-br from-purple-500 to-purple-600 text-white flex items-center justify-center mb-5 shadow-lg shadow-purple-200">
                                            <i class="fas fa-book-open text-2xl"></i>
                                        </div>
                            <h3 class="text-xl font-bold text-secondary-800 dark:text-neutral-200 mb-3">Buku Tamu
                                Interaktif</h3>
                            <p class="text-neutral-500 leading-relaxed">
                                Terima ucapan dan doa dari para tamu undangan secara real-time di halaman
                                undangan Anda dengan emoji dan stiker.
                            </p>
                            <div class="mt-4 flex items-center text-purple-600 text-sm font-semibold">
                                <span>Real-time messages</span>
                                <i class="fas fa-arrow-right ml-2 text-xs group-hover:translate-x-1 transition-transform"></i>
                                </div>
                                </div>
                                </div>
                                
                                <!-- Feature 5 - Gallery Photo -->
                                <div
                                    class="group relative bg-white dark:bg-secondary-800 rounded-2xl shadow-soft hover:shadow-xl transition-all duration-300 hover:-translate-y-1 p-6">
                                    <div class="relative">
                                        <div
                                            class="w-14 h-14 rounded-2xl bg-gradient-to-br from-rose-500 to-rose-600 text-white flex items-center justify-center mb-5 shadow-lg shadow-rose-200">
                                            <i class="fas fa-images text-2xl"></i>
                                        </div>
                            <h3 class="text-xl font-bold text-secondary-800 dark:text-neutral-200 mb-3">Galeri Foto &
                                Video</h3>
                            <p class="text-neutral-500 leading-relaxed">
                                Unggah foto dan video kenangan manis Anda. Tamu juga bisa mengirim foto
                                mereka
                                ke galeri bersama.
                            </p>
                            <div class="mt-4 flex items-center text-rose-600 text-sm font-semibold">
                                <span>Unlimited uploads*</span>
                                <i class="fas fa-arrow-right ml-2 text-xs group-hover:translate-x-1 transition-transform"></i>
                                </div>
                                </div>
                                </div>
                                
                                <!-- Feature 6 - Countdown Timer -->
                                <div
                                    class="group relative bg-white dark:bg-secondary-800 rounded-2xl shadow-soft hover:shadow-xl transition-all duration-300 hover:-translate-y-1 p-6">
                                    <div class="relative">
                                        <div
                                            class="w-14 h-14 rounded-2xl bg-gradient-to-br from-blue-500 to-blue-600 text-white flex items-center justify-center mb-5 shadow-lg shadow-blue-200">
                                            <i class="fas fa-hourglass-half text-2xl"></i>
                                        </div>
                            <h3 class="text-xl font-bold text-secondary-800 dark:text-neutral-200 mb-3">Countdown Timer
                            </h3>
                            <p class="text-neutral-500 leading-relaxed">
                                Tampilkan hitung mundur menuju hari H acara Anda. Buat tamu semakin antusias
                                dan
                                tidak lupa tanggal.
                            </p>
                            <div class="mt-4 flex items-center text-blue-600 text-sm font-semibold">
                                <span>Auto countdown</span>
                                <i class="fas fa-arrow-right ml-2 text-xs group-hover:translate-x-1 transition-transform"></i>
                                </div>
                                </div>
                                </div>
                                
                                <!-- Feature 7 - Location Maps -->
                                <div
                                    class="group relative bg-white dark:bg-secondary-800 rounded-2xl shadow-soft hover:shadow-xl transition-all duration-300 hover:-translate-y-1 p-6">
                                    <div class="relative">
                                        <div
                                            class="w-14 h-14 rounded-2xl bg-gradient-to-br from-indigo-500 to-indigo-600 text-white flex items-center justify-center mb-5 shadow-lg shadow-indigo-200">
                                            <i class="fas fa-map-marker-alt text-2xl"></i>
                                        </div>
                            <h3 class="text-xl font-bold text-secondary-800 dark:text-neutral-200 mb-3">Peta Lokasi
                                Terintegrasi
                            </h3>
                            <p class="text-neutral-500 leading-relaxed">
                                Tampilkan peta Google Maps langsung di undangan. Tamu bisa buka navigasi
                                dengan
                                satu klik.
                            </p>
                            <div class="mt-4 flex items-center text-indigo-600 text-sm font-semibold">
                                <span>Google Maps integration</span>
                                <i class="fas fa-arrow-right ml-2 text-xs group-hover:translate-x-1 transition-transform"></i>
                                </div>
                                </div>
                                </div>
                                
                                <!-- Feature 8 - WhatsApp Integration -->
                                <div
                                    class="group relative bg-white dark:bg-secondary-800 rounded-2xl shadow-soft hover:shadow-xl transition-all duration-300 hover:-translate-y-1 p-6">
                                    <div class="relative">
                                        <div
                                            class="w-14 h-14 rounded-2xl bg-gradient-to-br from-green-500 to-green-600 text-white flex items-center justify-center mb-5 shadow-lg shadow-green-200">
                                            <i class="fab fa-whatsapp text-2xl"></i>
                                        </div>
                            <h3 class="text-xl font-bold text-secondary-800 dark:text-neutral-200 mb-3">Broadcast
                                WhatsApp</h3>
                            <p class="text-neutral-500 leading-relaxed">
                                Kirim pengingat otomatis ke semua tamu via WhatsApp. Template pesan sudah
                                tersedia dan bisa diedit.
                            </p>
                            <div class="mt-4 flex items-center text-green-600 text-sm font-semibold">
                                <span>Auto reminder</span>
                                <i class="fas fa-arrow-right ml-2 text-xs group-hover:translate-x-1 transition-transform"></i>
                                </div>
                                </div>
                                </div>
                                
                                <!-- Feature 9 - Analytics Dashboard -->
                                <div
                                    class="group relative bg-white dark:bg-secondary-800 rounded-2xl shadow-soft hover:shadow-xl transition-all duration-300 hover:-translate-y-1 p-6">
                                    <div class="relative">
                                        <div
                                            class="w-14 h-14 rounded-2xl bg-gradient-to-br from-slate-500 to-slate-600 text-white flex items-center justify-center mb-5 shadow-lg shadow-slate-200">
                                            <i class="fas fa-chart-line text-2xl"></i>
                                        </div>
                            <h3 class="text-xl font-bold text-secondary-800 dark:text-neutral-200 mb-3">Analytics &
                                Insight</h3>
                            <p class="text-neutral-500 leading-relaxed">
                                Pantau jumlah pengunjung, RSVP, dan interaksi tamu. Lihat data real-time
                                dashboard lengkap.
                            </p>
                            <div class="mt-4 flex items-center text-slate-600 text-sm font-semibold">
                                <span>Real-time analytics</span>
                                <i class="fas fa-arrow-right ml-2 text-xs group-hover:translate-x-1 transition-transform"></i>
                                </div>
                                </div>
                                </div>
                                </div>
                                </div>
                                
                                <!-- CTA Bottom -->
                                <div class="mt-16 text-center">
                                    <p class="text-neutral-500 mb-4">*Fitur tersedia sesuai dengan paket yang dipilih</p>
                <!-- <a href="#pricing"
                                                                                                                    class="inline-flex items-center gap-2 px-8 py-3 bg-primary-500 text-white font-semibold rounded-xl hover:bg-primary-600 transition-all duration-200 shadow-md hover:shadow-lg">
                                                                                                                    Lihat Paket Harga
                                                                                                                    <i class="fas fa-arrow-right text-sm"></i>
                                </a> -->
            </div>
        </div>
    </section>

    <!-- Pricing Section - Modernized -->
    {{-- Pricing & Services Section with Tab Navigation --}}
    {{-- Pricing & Services Section with Tab Navigation --}}
    <section x-data="{ activeTab: 'undangan' }" class="py-20 bg-tertiary dark:bg-secondary-900 transition-all duration-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Section Header --}}
            <div class="text-center max-w-3xl mx-auto mb-12">
                <span
                    class="inline-block px-4 py-1.5 rounded-full bg-primary-50 text-primary-600 text-sm font-semibold tracking-wide mb-4">
                    <i class="fas fa-layer-group mr-2 text-xs"></i>Layanan Kami
                </span>
                <h2 class="font-heading text-4xl md:text-5xl font-bold text-secondary-900 dark:text-neutral-100 mb-5">
                    Semua Kebutuhan <span class="text-primary-500">Pernikahan Anda</span>
                </h2>
                <div class="w-24 h-1 bg-gradient-to-r from-primary-400 to-primary-600 rounded-full mx-auto mb-6">
                </div>
                <p class="text-xl text-neutral-600 dark:text-neutral-300">
                    Undangan digital, buku tamu, hingga siaran langsung — semuanya dalam satu platform.
                </p>
            </div>

            {{-- Tab Navigation --}}
            <div class="flex justify-center mb-12">
                <div
                    class="flex flex-col md:flex-row flex-wrap bg-white dark:bg-secondary-800 rounded-2xl p-1.5 shadow-soft border border-neutral-100 dark:border-secondary-700 gap-2 w-full md:w-auto">
                    {{-- Tab: Undangan Digital --}}
                    <button @click="activeTab = 'undangan'"
                        :class="activeTab === 'undangan' ? 'bg-primary-500 text-white shadow-md shadow-primary-200' : 'text-secondary-600 hover:text-primary-600 hover:bg-primary-50'"
                        class="w-full md:w-auto flex items-center gap-2 px-3 py-2 rounded-xl text-xs md:text-sm font-semibold transition-all duration-200">
                        <i class="fas fa-heart text-xs"></i>
                        <span>Undangan Digital</span>
                    </button>

                    {{-- Tab: Buku Tamu --}}
                    <button @click="activeTab = 'buku-tamu'"
                        :class="activeTab === 'buku-tamu' ? 'bg-primary-500 text-white shadow-md shadow-primary-200' : 'text-secondary-600 hover:text-primary-600 hover:bg-primary-50'"
                        class="w-full md:w-auto flex items-center gap-2 px-3 py-2 rounded-xl text-xs md:text-sm font-semibold transition-all duration-200">
                        <i class="fas fa-book text-xs"></i>
                        <span>Buku Tamu</span>
                    </button>

                    {{-- Tab: Live Streaming --}}
                    <button @click="activeTab = 'live-streaming'"
                        :class="activeTab === 'live-streaming' ? 'bg-primary-500 text-white shadow-md shadow-primary-200' : 'text-secondary-600 hover:text-primary-600 hover:bg-primary-50'"
                        class="w-full md:w-auto flex items-center gap-2 px-3 py-2 rounded-xl text-xs md:text-sm font-semibold transition-all duration-200">
                        <i class="fas fa-video text-xs"></i>
                        <span>Live Streaming</span>
                        <!-- <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold"
                            :class="activeTab === 'live-streaming' ? 'bg-white/20 text-white' : 'bg-emerald-100 text-emerald-700'">
                            Baru
                        </span> -->
                    </button>
                </div>
            </div>


            {{-- ============================================================ --}}
            {{-- PANEL: UNDANGAN DIGITAL (kode asli dari catalog themes) --}}
            {{-- ============================================================ --}}
            <div x-show="activeTab === 'undangan'" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">

                <!-- Themes Catalog Section - Modernized -->
                <div class="mt-16 space-y-6 sm:space-y-0 sm:grid sm:grid-cols-2 lg:grid-cols-4 sm:gap-6">
                    @forelse($packages as $package)
                        <div
                            class="group relative bg-white dark:bg-secondary-800 rounded-2xl shadow-soft transition-all duration-300 hover:shadow-xl hover:-translate-y-1 {{ $package->is_popular ? 'ring-2 ring-primary-500 shadow-lg' : 'border border-neutral-200' }}">

                            <!-- Popular Badge -->
                            @if($package->is_popular)
                                <div class="absolute -top-3 left-1/2 -translate-x-1/2 z-10">
                                    <span
                                        class="inline-flex items-center gap-1.5 bg-gradient-to-r from-primary-500 to-primary-600 px-4 py-1.5 rounded-full text-xs font-bold text-white shadow-md">
                                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                        Best Seller
                                    </span>
                                </div>
                            @endif

                            <!-- Card Content -->
                            <div class="p-6">
                                <!-- Package Name -->
                                <h3
                                    class="font-heading text-xl font-bold {{ $package->is_popular ? 'text-primary-600 dark:text-primary-400' : 'text-secondary-800 dark:text-neutral-100' }}">
                                    {{ $package->package_name }}
                                </h3>

                                <!-- Description -->
                                @if($package->description)
                                    <p class="mt-2 text-sm text-neutral-500">
                                        {{ $package->description }}
                                    </p>
                                @endif

                                <!-- Price -->
                                <div class="mt-6">
                                    @if($package->slashed_price && $package->slashed_price > $package->price)
                                        <span class="text-neutral-400 line-through text-sm">Rp
                                            {{ number_format($package->slashed_price, 0, ',', '.') }}</span>
                                    @endif
                                    <div class="flex items-baseline flex-wrap gap-1 mt-1">
                                        <span class="text-3xl font-bold text-secondary-900 dark:text-neutral-100 shrink-0">Rp</span>
                                        <span class="text-5xl font-extrabold text-secondary-900 dark:text-neutral-100 break-words">
                                            {{ number_format($package->price, 0, ',', '.') }}
                                        </span>
                                        @if($package->price > 0)
                                            <span class="text-neutral-400 text-sm ml-1 whitespace-nowrap">
                                                /
                                                {{ $package->active_period_days === 0 ? 'Lifetime' : $package->active_period_days . ' Hari' }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <!-- CTA Button -->
                                @auth
                                    @if($package->package_code === 'free')
                                        <div
                                            class="mt-6 w-full bg-neutral-100 dark:bg-secondary-800 text-neutral-500 rounded-xl py-3 text-sm font-semibold text-center cursor-default">
                                            ✅ Paket Aktif
                                        </div>
                                    @else
                                        <a href="{{ route('dashboard.checkout') }}"
                                            class="mt-6 flex items-center justify-center gap-2 w-full rounded-xl py-3 text-sm font-semibold text-center transition-all duration-200 {{ $package->is_popular ? 'bg-primary-500 text-white hover:bg-primary-600 shadow-md hover:shadow-lg' : 'bg-primary-50 border border-primary-200 text-primary-700 hover:bg-primary-100' }}">
                                            Pilih {{ $package->package_name }}
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                            </svg>
                                        </a>
                                    @endif
                                @else
                                    @if($package->package_code === 'free')
                                        <a href="{{ route('register') }}"
                                            class="mt-6 flex items-center justify-center gap-2 w-full bg-secondary-800 text-white rounded-xl py-3 text-sm font-semibold text-center hover:bg-secondary-900 transition-colors">
                                            Daftar Gratis
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                            </svg>
                                        </a>
                                    @else
                                        <a href="{{ route('register') }}"
                                            class="mt-6 flex items-center justify-center gap-2 w-full rounded-xl py-3 text-sm font-semibold text-center transition-all duration-200 {{ $package->is_popular ? 'bg-primary-500 text-white hover:bg-primary-600 shadow-md hover:shadow-lg' : 'bg-primary-50 border border-primary-200 text-primary-700 hover:bg-primary-100' }}">
                                            Pilih {{ $package->package_name }}
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                            </svg>
                                        </a>
                                    @endif
                                @endauth
                            </div>

                            <!-- Features List -->
                            <div class="border-t border-neutral-100 dark:border-secondary-700 pt-5 pb-6 px-6">
                                <div class="flex items-center gap-2 mb-4">
                                    <svg class="w-4 h-4 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    <h4 class="text-xs font-semibold text-neutral-400 uppercase tracking-wider">
                                        Fitur
                                        Termasuk</h4>
                                </div>
                                <ul class="space-y-3">
                                    @forelse($package->features as $feature)
                                        <li class="flex items-start gap-2.5 text-sm text-neutral-600 dark:text-neutral-300">
                                            <svg class="w-5 h-5 text-emerald-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                            <span>{{ $feature->feature_name }}</span>
                                        </li>
                                    @empty
                                        <li class="text-sm text-neutral-400 italic">Fitur dasar</li>
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                    @empty
                    <div class="col-span-full py-16 text-center">
                        <div
                            class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-neutral-100 dark:bg-secondary-800 mb-4">
                            <svg class="w-8 h-8 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                            </svg>
                        </div>
                        <p class="text-lg font-medium text-secondary-800 dark:text-neutral-200">Belum ada paket tersedia
                        </p>
                        <p class="text-neutral-500 mt-1">Silakan hubungi admin untuk informasi lebih lanjut.
                        </p>
                    </div>
                    @endforelse
                </div>
            </div>{{-- end panel undangan --}}

            {{-- =============================== --}}
            {{-- PANEL: BUKU TAMU --}}
            {{-- =============================== --}}
            <div x-show="activeTab === 'buku-tamu'" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">

                <div class="max-w-2xl mx-auto">
                    {{-- Icon & Heading --}}
                    <div class="text-center mb-10">
                        <div class="inline-flex items-center justify-center w-20 h-20 rounded-2xl bg-emerald-50 mb-5">
                            <i class="fas fa-book-open text-4xl text-emerald-500"></i>
                        </div>
                        <h3 class="font-heading text-3xl font-bold text-secondary-900 dark:text-neutral-100 mb-3">Buku
                            Tamu
                            Digital</h3>
                        <p class="text-neutral-600 dark:text-neutral-300 text-lg">
                            Catat kehadiran tamu secara modern. Tamu cukup scan QR, isi nama, dan tinggalkan
                            ucapan —
                            semua tersimpan otomatis.
                        </p>
                    </div>

                    {{-- Feature List --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-10">
                        <div
                            class="flex items-start gap-3 bg-white dark:bg-secondary-800 rounded-2xl p-4 shadow-soft border border-neutral-100 dark:border-secondary-700">
                            <div class="flex-shrink-0 w-9 h-9 rounded-xl bg-emerald-50 flex items-center justify-center">
                                <i class="fas fa-qrcode text-emerald-500 text-base"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-secondary-800 dark:text-neutral-200 text-sm">QR Code Tamu
                                </p>
                                <p class="text-xs text-neutral-500 mt-0.5">Tamu scan langsung dari ponsel,
                                    tanpa perlu
                                    download aplikasi</p>
                            </div>
                        </div>
                        <div
                            class="flex items-start gap-3 bg-white dark:bg-secondary-800 rounded-2xl p-4 shadow-soft border border-neutral-100 dark:border-secondary-700">
                            <div class="flex-shrink-0 w-9 h-9 rounded-xl bg-emerald-50 flex items-center justify-center">
                                <i class="fas fa-comment-dots text-emerald-500 text-base"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-secondary-800 dark:text-neutral-200 text-sm">Ucapan & Doa
                                </p>
                                <p class="text-xs text-neutral-500 mt-0.5">Kumpulkan pesan dan ucapan dari
                                    seluruh tamu
                                    undangan</p>
                            </div>
                        </div>
                        <div
                            class="flex items-start gap-3 bg-white dark:bg-secondary-800 rounded-2xl p-4 shadow-soft border border-neutral-100 dark:border-secondary-700">
                            <div class="flex-shrink-0 w-9 h-9 rounded-xl bg-emerald-50 flex items-center justify-center">
                                <i class="fas fa-file-excel text-emerald-500 text-base"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-secondary-800 dark:text-neutral-200 text-sm">Ekspor Data
                                </p>
                                <p class="text-xs text-neutral-500 mt-0.5">Unduh data kehadiran tamu dalam
                                    format
                                    Excel/CSV</p>
                            </div>
                        </div>
                        <div
                            class="flex items-start gap-3 bg-white dark:bg-secondary-800 rounded-2xl p-4 shadow-soft border border-neutral-100 dark:border-secondary-700">
                            <div class="flex-shrink-0 w-9 h-9 rounded-xl bg-emerald-50 flex items-center justify-center">
                                <i class="fas fa-chart-bar text-emerald-500 text-base"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-secondary-800 dark:text-neutral-200 text-sm">Rekap
                                    Real-time</p>
                                <p class="text-xs text-neutral-500 mt-0.5">Pantau jumlah kehadiran tamu
                                    secara langsung
                                    dari dashboard</p>
                            </div>
                        </div>
                    </div>

                    {{-- CTA Contact Sales --}}
                    <div
                        class="bg-gradient-to-br from-emerald-50 to-teal-50 dark:from-secondary-800 dark:to-secondary-800 border border-emerald-100 dark:border-emerald-900/30 rounded-2xl p-8 text-center">
                        <p class="text-secondary-700 dark:text-neutral-200 font-medium mb-1">Tertarik dengan layanan
                            ini?</p>
                        <p class="text-neutral-500 text-sm mb-6">Hubungi tim kami untuk informasi harga dan
                            demo gratis
                        </p>
                        <div class="flex flex-col sm:flex-row gap-3 justify-center">
                            <a href="https://wa.me/{{ config('app.whatsapp_number', '62895349823366') }}?text={{ urlencode('Halo, saya tertarik dengan layanan Buku Tamu Digital. Bisa tolong jelaskan lebih lanjut?') }}"
                                target="_blank"
                                class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-emerald-500 text-white rounded-xl text-sm font-semibold hover:bg-emerald-600 transition-all duration-200 shadow-sm hover:shadow-md">
                                <i class="fab fa-whatsapp text-base"></i>
                                Hubungi via WhatsApp
                            </a>
                        </div>
                    </div>
                </div>
            </div>{{-- end panel buku tamu --}}

            {{-- =============================== --}}
            {{-- PANEL: LIVE STREAMING --}}
            {{-- =============================== --}}
            <div x-show="activeTab === 'live-streaming'" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">

                <div class="max-w-2xl mx-auto">
                    {{-- Icon & Heading --}}
                    <div class="text-center mb-10">
                        <div class="inline-flex items-center justify-center w-20 h-20 rounded-2xl bg-primary-50 mb-5">
                            <i class="fas fa-video text-4xl text-primary-500"></i>
                        </div>
                        <h3 class="font-heading text-3xl font-bold text-secondary-900 dark:text-neutral-100 mb-3">Live
                            Streaming
                            Pernikahan
                        </h3>
                        <p class="text-neutral-600 dark:text-neutral-300 text-lg">
                            Siarkan momen spesial secara langsung kepada keluarga dan sahabat di seluruh
                            penjuru dunia —
                            tanpa harus hadir secara fisik.
                        </p>
                    </div>

                    {{-- Feature List --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-10">
                        <div
                            class="flex items-start gap-3 bg-white dark:bg-secondary-800 rounded-2xl p-4 shadow-soft border border-neutral-100 dark:border-secondary-700">
                            <div class="flex-shrink-0 w-9 h-9 rounded-xl bg-primary-50 flex items-center justify-center">
                                <i class="fas fa-film text-primary-500 text-base"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-secondary-800 dark:text-neutral-200 text-sm">HD Streaming
                                </p>
                                <p class="text-xs text-neutral-500 mt-0.5">Kualitas video jernih hingga Full
                                    HD untuk
                                    pengalaman terbaik</p>
                            </div>
                        </div>
                        <div
                            class="flex items-start gap-3 bg-white dark:bg-secondary-800 rounded-2xl p-4 shadow-soft border border-neutral-100 dark:border-secondary-700">
                            <div class="flex-shrink-0 w-9 h-9 rounded-xl bg-primary-50 flex items-center justify-center">
                                <i class="fas fa-lock text-primary-500 text-base"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-secondary-800 dark:text-neutral-200 text-sm">Link Privat
                                </p>
                                <p class="text-xs text-neutral-500 mt-0.5">Hanya tamu undangan yang bisa
                                    menonton dengan
                                    link eksklusif</p>
                            </div>
                        </div>
                        <div
                            class="flex items-start gap-3 bg-white dark:bg-secondary-800 rounded-2xl p-4 shadow-soft border border-neutral-100 dark:border-secondary-700">
                            <div class="flex-shrink-0 w-9 h-9 rounded-xl bg-primary-50 flex items-center justify-center">
                                <i class="fas fa-cloud-download-alt text-primary-500 text-base"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-secondary-800 dark:text-neutral-200 text-sm">Rekaman Video
                                </p>
                                <p class="text-xs text-neutral-500 mt-0.5">Siaran otomatis direkam dan
                                    tersedia untuk
                                    diunduh setelah acara</p>
                            </div>
                        </div>
                        <div
                            class="flex items-start gap-3 bg-white dark:bg-secondary-800 rounded-2xl p-4 shadow-soft border border-neutral-100 dark:border-secondary-700">
                            <div class="flex-shrink-0 w-9 h-9 rounded-xl bg-primary-50 flex items-center justify-center">
                                <i class="fas fa-users text-primary-500 text-base"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-secondary-800 dark:text-neutral-200 text-sm">Unlimited
                                    Penonton</p>
                                <p class="text-xs text-neutral-500 mt-0.5">Tidak ada batasan jumlah penonton
                                    yang bisa
                                    menyaksikan siaran</p>
                            </div>
                        </div>
                    </div>
                    {{-- CTA Contact Sales --}}
                    <div
                        class="bg-gradient-to-br from-primary-50 to-secondary-50 dark:from-secondary-800 dark:to-secondary-800 border border-primary-100 dark:border-primary-900/30 rounded-2xl p-8 text-center">
                        <p class="text-secondary-700 dark:text-neutral-200 font-medium mb-1">Tertarik dengan layanan
                            ini?</p>
                        <p class="text-neutral-500 text-sm mb-6">Hubungi tim kami untuk informasi harga dan
                            demo gratis
                        </p>
                        <div class="flex flex-col sm:flex-row gap-3 justify-center">
                            <a href="https://wa.me/{{ config('app.whatsapp_number', '62895349823366') }}?text={{ urlencode('Halo, saya tertarik dengan layanan Live Streaming Pernikahan. Bisa tolong jelaskan lebih lanjut?') }}"
                                target="_blank"
                                class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-gradient-to-r from-primary-500 to-primary-600 text-white rounded-xl text-sm font-semibold hover:from-primary-600 hover:to-primary-700 transition-all duration-200 shadow-sm hover:shadow-md">
                                <i class="fab fa-whatsapp text-base"></i>
                                Hubungi via WhatsApp
                            </a>
                        </div>
                    </div>
                </div>
            </div>{{-- end panel live streaming --}}
        </div>
    </section>
    <section
        class="relative py-16 px-4 bg-gradient-to-br from-orange-50 via-white to-orange-50/30 dark:from-secondary-900 dark:via-secondary-900 dark:to-secondary-900">
        <div class="max-w-3xl mx-auto">
            <!-- Header -->
            <div class="text-center mb-10">
                <div class="inline-flex items-center gap-2 px-3 py-1 bg-orange-100 dark:bg-secondary-800 rounded-full mb-3">
                    <span class="text-xs font-semibold text-orange-600 dark:text-orange-400">FAQ</span>
                </div>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-neutral-100 mb-2">
                    Paling Sering Ditanyakan
                </h2>
                <div class="w-20 h-1 bg-gradient-to-r from-orange-400 to-orange-600 mx-auto rounded-full">
                </div>
            </div>

            <!-- FAQ Items -->
            <div class="space-y-3">
                <!-- Item 1 -->
                <div
                    class="group bg-white/60 dark:bg-secondary-800/60 backdrop-blur-sm rounded-xl border border-white/50 dark:border-secondary-700/50 shadow-sm hover:shadow-md transition-all">
                    <details class="group">
                        <summary class="flex items-center justify-between cursor-pointer list-none p-5">
                            <div class="flex items-center gap-3">
                                <h3
                                    class="font-semibold text-gray-800 dark:text-neutral-200 group-open:text-orange-600 transition-colors">
                                    Bagaimana cara membuat undangan digital?
                                </h3>
                            </div>
                            <div class="text-gray-400 group-open:rotate-180 transition-transform duration-300">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                    </div>
                                    </summary>
                                    <div class="px-5 pb-5 pt-0 border-t border-gray-100 dark:border-secondary-700 mt-2">
                                        <p class="text-gray-600 dark:text-neutral-300 leading-relaxed">
                                            Setelah melakukan pemesanan, Anda akan mendapatkan akses dashboard untuk
                                            mengisi data
                                            acara,
                                            foto, galeri, lokasi, dan informasi lainnya secara mandiri tanpa perlu
                                            menunggu admin.
                                        </p>
                                    </div>
                                    </details>
                                    </div>
                                    
                                    <!-- Item 2 -->
                                    <div
                                        class="group bg-white/60 dark:bg-secondary-800/60 backdrop-blur-sm rounded-xl border border-white/50 dark:border-secondary-700/50 shadow-sm hover:shadow-md transition-all">
                                        <details class="group">
                                            <summary class="flex items-center justify-between cursor-pointer list-none p-5">
                                                <div class="flex items-center gap-3">
                                                    <h3
                                                        class="font-semibold text-gray-800 dark:text-neutral-200 group-open:text-orange-600 transition-colors">
                                                        Apakah data undangan bisa diubah setelah dibuat?
                                                    </h3>
                                                </div>
                                                <div class="text-gray-400 group-open:rotate-180 transition-transform duration-300">
                                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                    </div>
                                    </summary>
                                    <div class="px-5 pb-5 pt-0 border-t border-gray-100 dark:border-secondary-700 mt-2">
                                        <p class="text-gray-600 dark:text-neutral-300 leading-relaxed">
                                            Ya. Anda dapat mengubah nama mempelai, jadwal acara, foto, galeri, lokasi,
                                            maupun
                                            informasi
                                            lainnya kapan saja melalui dashboard selama masa aktif undangan.
                                        </p>
                                    </div>
                                    </details>
                                    </div>
                                    
                                    <!-- Item 3 -->
                                    <div
                                        class="group bg-white/60 dark:bg-secondary-800/60 backdrop-blur-sm rounded-xl border border-white/50 dark:border-secondary-700/50 shadow-sm hover:shadow-md transition-all">
                                        <details class="group">
                                            <summary class="flex items-center justify-between cursor-pointer list-none p-5">
                                                <div class="flex items-center gap-3">
                                                    <h3
                                                        class="font-semibold text-gray-800 dark:text-neutral-200 group-open:text-orange-600 transition-colors">
                                                        Apakah tersedia nama tamu otomatis?
                                                    </h3>
                                                </div>
                                                <div class="text-gray-400 group-open:rotate-180 transition-transform duration-300">
                                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                    </div>
                                    </summary>
                                    <div class="px-5 pb-5 pt-0 border-t border-gray-100 dark:border-secondary-700 mt-2">
                                        <p class="text-gray-600 dark:text-neutral-300 leading-relaxed">
                                            Tentu. Anda dapat membuat link khusus untuk setiap tamu sehingga nama tamu
                                            akan tampil
                                            otomatis
                                            saat undangan dibuka.
                                        </p>
                                    </div>
                                    </details>
                                    </div>
                                    
                                    <!-- Item 4 -->
                                    <div
                                        class="group bg-white/60 dark:bg-secondary-800/60 backdrop-blur-sm rounded-xl border border-white/50 dark:border-secondary-700/50 shadow-sm hover:shadow-md transition-all">
                                        <details class="group">
                                            <summary class="flex items-center justify-between cursor-pointer list-none p-5">
                                                <div class="flex items-center gap-3">
                                                    <h3
                                                        class="font-semibold text-gray-800 dark:text-neutral-200 group-open:text-orange-600 transition-colors">
                                                        Apakah undangan bisa dibagikan ke WhatsApp?
                                                    </h3>
                                                </div>
                                                <div class="text-gray-400 group-open:rotate-180 transition-transform duration-300">
                                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                    </div>
                                    </summary>
                                    <div class="px-5 pb-5 pt-0 border-t border-gray-100 dark:border-secondary-700 mt-2">
                                        <p class="text-gray-600 dark:text-neutral-300 leading-relaxed">
                                            Ya. Link undangan dapat dibagikan melalui WhatsApp, Instagram, Telegram,
                                            Facebook,
                                            email,
                                            maupun media sosial lainnya.
                                        </p>
                                    </div>
                                    </details>
                                    </div>
                                    
                                    <!-- Item 5 -->
                                    <div
                                        class="group bg-white/60 dark:bg-secondary-800/60 backdrop-blur-sm rounded-xl border border-white/50 dark:border-secondary-700/50 shadow-sm hover:shadow-md transition-all">
                                        <details class="group">
                                            <summary class="flex items-center justify-between cursor-pointer list-none p-5">
                                                <div class="flex items-center gap-3">
                                                    <h3
                                                        class="font-semibold text-gray-800 dark:text-neutral-200 group-open:text-orange-600 transition-colors">
                                                        Apakah tersedia RSVP dan buku tamu?
                                                    </h3>
                                                </div>
                                                <div class="text-gray-400 group-open:rotate-180 transition-transform duration-300">
                                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                    </div>
                                    </summary>
                                    <div class="px-5 pb-5 pt-0 border-t border-gray-100 dark:border-secondary-700 mt-2">
                                        <p class="text-gray-600 dark:text-neutral-300 leading-relaxed">
                                            Ya. Tamu dapat mengisi konfirmasi kehadiran (RSVP) serta memberikan ucapan
                                            dan doa
                                            langsung
                                            melalui halaman undangan.
                                        </p>
                                    </div>
                                    </details>
                                    </div>
                                    
                                    <!-- Item 6 -->
                                    <div
                                        class="group bg-white/60 dark:bg-secondary-800/60 backdrop-blur-sm rounded-xl border border-white/50 dark:border-secondary-700/50 shadow-sm hover:shadow-md transition-all">
                                        <details class="group">
                                            <summary class="flex items-center justify-between cursor-pointer list-none p-5">
                                                <div class="flex items-center gap-3">
                                                    <h3
                                                        class="font-semibold text-gray-800 dark:text-neutral-200 group-open:text-orange-600 transition-colors">
                                                        Apakah saya akan mendapatkan bantuan jika mengalami kesulitan?
                                                    </h3>
                                                </div>
                                                <div class="text-gray-400 group-open:rotate-180 transition-transform duration-300">
                                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                    </div>
                                    </summary>
                                    <div class="px-5 pb-5 pt-0 border-t border-gray-100 dark:border-secondary-700 mt-2">
                                        <p class="text-gray-600 dark:text-neutral-300 leading-relaxed">
                                            Tentu. Tim support kami siap membantu melalui WhatsApp jika Anda mengalami
                                            kendala saat
                                            membuat atau mengelola undangan.
                                        </p>
                                    </div>
                                    </details>
                                    </div>
                                    </div>
                                    
                                    <!-- Additional Help -->
                                    <div class="mt-8 text-center">
                                        <p class="text-gray-500 dark:text-neutral-400 text-sm">
                                            Tidak menemukan jawaban?
                    <a href="https://wa.me/62895349823366"
                        class="text-orange-500 hover:text-orange-600 dark:text-orange-400 font-medium">Klik di
                        sini untuk
                        bantuan</a>
                </p>
            </div>
        </div>
    </section>
    <!-- WA -->
    <button x-show="showBackToTop" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-4"
        onclick="window.open('https://wa.me/62895349823366?text=Halo%2C%20saya%20ingin%20bertanya%20tentang%20...', '_blank')"
        class="fixed bottom-6 right-6 z-50 p-3.5 rounded-full bg-green-500 text-white shadow-lg hover:bg-green-600 hover:shadow-xl transition-all duration-200 cursor-pointer">
        <i class="fa-brands fa-whatsapp"></i>
        <span class="ml-2">Hubungi Kami</span>
    </button>
    <x-public-footer />

    <!-- SCRIPTS -->
    <script src="{{ asset('js/landingpage.js') }}"></script>
</body>

</html>