<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <x-meta title="Rayakan Digital | Undangan Digital Pernikahan"
        description="Buat undangan digital pernikahan dengan tema pilihan, musik, galeri, dan RSVP. Pilih desain, lengkapi cerita Anda, lalu bagikan lewat WhatsApp bersama Rayakan Digital."
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

<body
    x-data="promotionCatalog" data-promotion-catalog="{{ json_encode($promotionCatalog) }}" data-promotion-url="{{ route('promotions.catalog') }}"
    class="font-sans antialiased bg-[#FDFCFA] dark:bg-secondary-900 text-gray-900 dark:text-neutral-100 overflow-x-hidden">
    <x-public-navbar />

    <div class="h-16"></div>
    <x-promotion-banner />

    {{-- ═══════════════════════════════════════════════
    HERO — Asymmetric editorial split
    ═══════════════════════════════════════════════ --}}
    <section id="hero"
        class="relative min-h-[92vh] flex items-center overflow-hidden bg-[#FDFCFA] dark:bg-secondary-900 grain-bg">

        {{-- Background orbs --}}
        <div class="orb-orange absolute -top-32 -right-32 w-[700px] h-[700px] pointer-events-none"></div>
        <div class="orb-warm absolute bottom-0 left-0 w-[500px] h-[500px] pointer-events-none"></div>

        {{-- Subtle grid --}}
        <div class="absolute inset-0 pointer-events-none"
            style="background-image: linear-gradient(rgba(148,163,184,.06) 1px, transparent 1px), linear-gradient(90deg, rgba(148,163,184,.06) 1px, transparent 1px); background-size: 48px 48px;">
        </div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full py-20 lg:py-32">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-8 items-center">

                {{-- LEFT: Typography block --}}
                <div data-aos="fade-up">

                    {{-- Eyebrow --}}
                    <div class="flex items-center gap-3 mb-8">
                        <div class="flex items-center gap-1.5">
                            <span class="relative flex h-2 w-2">
                                <span
                                    class="animate-ping absolute inline-flex h-full w-full rounded-full bg-primary-500 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-primary-600"></span>
                            </span>
                        </div>
                        <span class="text-xs font-bold tracking-[0.2em] text-primary-600 uppercase">Rayakan
                            Digital</span>
                        <div class="h-px flex-1 bg-gradient-to-r from-primary-200 to-transparent max-w-[80px]"></div>
                    </div>

                    {{-- Main headline --}}
                    <h1
                        class="font-heading max-sm:text-4xl text-5xl sm:text-6xl lg:text-7xl font-bold leading-[1.05] text-secondary-900 dark:text-neutral-100 mb-6">
                        Cara Mudah<br>
                        Bikin<br>
                        <span class="text-primary-500">Undangan Digital</span>
                    </h1>

                    <p class="text-lg text-neutral-500 dark:text-neutral-400 max-w-md leading-relaxed mb-10">
                        Undangan pernikahan online siap dalam <strong class="text-secondary-800 dark:text-neutral-200">5
                            menit</strong>.
                        Kirim otomatis via WhatsApp, check-in QR Code, lengkap dengan musik & galeri.
                    </p>


                    <div class="flex flex-col sm:flex-row gap-4 mb-4">
                        <a href="{{ route('register') }}" id="hero-cta-register"
                            class="group inline-flex items-center justify-center gap-2.5 px-8 py-4 bg-primary-500 hover:bg-primary-600 text-white text-sm font-bold rounded-2xl shadow-[0_8px_32px_-8px_rgba(255,122,0,0.5)] hover:shadow-[0_12px_40px_-8px_rgba(255,122,0,0.65)] transition-all duration-300 hover:-translate-y-0.5">
                            <i class="fas fa-gem"></i>
                            <span>Buat Undangan Gratis</span>
                            <i
                                class="fas fa-arrow-right text-xs group-hover:translate-x-1 transition-transform duration-300"></i>
                        </a>
                        <a href="#themes" id="hero-cta-themes"
                            class="inline-flex items-center justify-center gap-2.5 px-8 py-4 bg-white dark:bg-secondary-800 border border-neutral-200 dark:border-secondary-700 text-secondary-700 dark:text-neutral-300 text-sm font-semibold rounded-2xl hover:border-primary-300 hover:text-primary-600 transition-all duration-300 shadow-sm">
                            <i class="fas fa-palette text-primary-500"></i>
                            <span>Lihat Tema</span>
                        </a>
                    </div>

                    <a href="#wedding-planner" id="hero-planner-hook"
                        class="mb-10 flex max-w-md items-start gap-2.5 rounded-lg text-sm leading-relaxed text-neutral-600 transition-colors hover:text-primary-700 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-primary-500 focus-visible:ring-offset-4 dark:text-neutral-300 dark:hover:text-primary-300 dark:focus-visible:ring-offset-secondary-900">
                        <i class="fas fa-gift pt-1 text-primary-600 dark:text-primary-400" aria-hidden="true"></i>
                        <span>
                            <strong class="text-primary-700 dark:text-primary-300">Daftar undangan, dapat Wedding Planner GRATIS.</strong>
                            <span class="block">Tetap bisa dipakai meski undangan kedaluwarsa.</span>
                        </span>
                    </a>

                    {{-- Trust strip --}}
                    <div class="flex flex-wrap items-center gap-x-6 gap-y-2 text-xs text-neutral-400">
                        <div class="flex items-center gap-1.5">
                            <i class="fas fa-star text-amber-400"></i>
                            <span>Rating 4.9 / 5</span>
                        </div>
                        <span class="text-neutral-200 dark:text-neutral-700">|</span>
                        <div class="flex items-center gap-1.5">
                            <i class="fas fa-clock text-primary-400"></i>
                            <span>Selesai dalam 5 menit</span>
                        </div>
                        <span class="text-neutral-200 dark:text-neutral-700">|</span>
                        <div class="flex items-center gap-1.5">
                            <i class="fas fa-shield-alt text-emerald-400"></i>
                            <span>Data aman terenkripsi</span>
                        </div>
                    </div>
                </div>

                {{-- RIGHT: Mockup --}}
                <div data-aos="fade-left" data-aos-delay="150"
                    class="relative flex items-center justify-center lg:justify-end">

                    {{-- Ring decoration --}}
                    <div
                        class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[420px] h-[420px] rounded-full border-2 border-primary-200/20 pointer-events-none">
                    </div>
                    <div
                        class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[520px] h-[520px] rounded-full border border-primary-100/15 pointer-events-none">
                    </div>

                    <div class="relative z-10 w-full max-w-sm lg:max-w-md">
                        {{-- Floating badge top --}}
                        <div class="absolute -top-4 -right-4 z-20 animate-bounce-slow">
                            <div
                                class="bg-white dark:bg-secondary-800 rounded-2xl shadow-[0_8px_24px_rgba(0,0,0,0.12)] px-4 py-2.5 flex items-center gap-2 border border-neutral-100 dark:border-secondary-700">
                                <div class="w-7 h-7 rounded-full bg-emerald-100 flex items-center justify-center">
                                    <i class="fas fa-check text-emerald-600 text-xs"></i>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-secondary-800 dark:text-neutral-200">Selesai!</p>
                                    <p class="text-[10px] text-neutral-400">dalam 5 menit</p>
                                </div>
                            </div>
                        </div>

                        {{-- Mockup image --}}
                        <div class="overflow-hidden">
                            <img src="{{ asset('img/mockup.png') }}" alt="Rayakan Digital - Preview Undangan"
                                class="w-full h-full object-cover">
                        </div>

                        {{-- Floating badge bottom --}}
                        <div class="absolute -bottom-4 -left-4 z-20 animate-bounce-slow animation-delay-1000">
                            <div
                                class="bg-white dark:bg-secondary-800 rounded-2xl shadow-[0_8px_24px_rgba(0,0,0,0.12)] px-4 py-2.5 flex items-center gap-2 border border-neutral-100 dark:border-secondary-700">
                                <div class="w-7 h-7 rounded-full bg-green-100 flex items-center justify-center">
                                    <i class="fab fa-whatsapp text-green-600 text-sm"></i>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-secondary-800 dark:text-neutral-200">Kirim ke 100+
                                        tamu</p>
                                    <p class="text-[10px] text-neutral-400">via WhatsApp blast</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════
    MARQUEE — Social proof ticker
    ═══════════════════════════════════════════════ --}}
    <div class="relative bg-primary-500 py-4 overflow-hidden">
        <div class="marquee-track text-white text-sm font-semibold">
            @foreach(range(1, 2) as $_)
                <div class="flex items-center gap-0 whitespace-nowrap">
                    <span class="px-8 flex items-center gap-2"><i class="fas fa-heart text-xs opacity-70"></i> Undangan
                        Digital Premium</span>
                    <span class="px-8 flex items-center gap-2"><i class="fas fa-qrcode text-xs opacity-70"></i> QR Code
                        Check-in</span>
                    <span class="px-8 flex items-center gap-2"><i class="fas fa-broadcast-tower text-xs opacity-70"></i>
                        Live Streaming Pernikahan</span>
                    <span class="px-8 flex items-center gap-2"><i class="fab fa-whatsapp text-xs opacity-70"></i> WhatsApp
                        Blast Otomatis</span>
                    <span class="px-8 flex items-center gap-2"><i class="fas fa-images text-xs opacity-70"></i> Galeri Foto
                        & Video</span>
                    <span class="px-8 flex items-center gap-2"><i class="fas fa-gift text-xs opacity-70"></i> Digital Angpao
                        / Gift</span>
                    <span class="px-8 flex items-center gap-2"><i class="fas fa-map-marker-alt text-xs opacity-70"></i> Peta
                        Lokasi Terintegrasi</span>
                    <span class="px-8 flex items-center gap-2"><i class="fas fa-star text-xs opacity-70"></i> Rating 4.9 /
                        5</span>
                </div>
            @endforeach
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════
    THEME CATALOG — Horizontal scroll, editorial frame
    ═══════════════════════════════════════════════ --}}
    <section id="themes" x-data="{ filter: 'all' }" data-aos="fade-up"
        class="py-24 bg-[#FDFCFA] dark:bg-secondary-900 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Header --}}
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12">
                <div>
                    <p class="text-xs font-bold tracking-[0.2em] text-primary-500 uppercase mb-3">Katalog Tema</p>
                    <h2
                        class="font-heading text-4xl md:text-5xl font-bold text-secondary-900 dark:text-neutral-100 leading-tight">
                        Pilih <span class="text-primary-500">Desain</span><br>
                        Undangan Anda
                    </h2>
                </div>
                <p class="text-neutral-500 dark:text-neutral-400 max-w-xs text-sm leading-relaxed">
                    Pratinjau langsung dengan data contoh. Klik "Gunakan Tema" untuk langsung mulai.
                </p>
            </div>

            {{-- Category Filters --}}
            @if($categories->isNotEmpty())
                <div class="flex flex-wrap gap-2.5 mb-8">
                    <button @click="filter = 'all'" id="filter-all"
                        :class="filter === 'all'
                                ? 'bg-primary-500 text-white shadow-md shadow-primary-200/50 border-primary-500'
                                : 'bg-white dark:bg-secondary-800 text-secondary-600 dark:text-neutral-300 border-neutral-200 dark:border-secondary-700 hover:border-primary-200'"
                        class="px-5 py-2 rounded-full text-sm font-semibold transition-all duration-200 border">
                        Semua
                        <span class="ml-1 text-xs opacity-70">({{ $themes->count() }})</span>
                    </button>
                    @foreach($categories as $category)
                        <button @click="filter = '{{ $category->id }}'" id="filter-cat-{{ $category->id }}"
                            :class="filter === '{{ $category->id }}'
                                        ? 'bg-primary-500 text-white shadow-md shadow-primary-200/50 border-primary-500'
                                        : 'bg-white dark:bg-secondary-800 text-secondary-600 dark:text-neutral-300 border-neutral-200 dark:border-secondary-700 hover:border-primary-200'"
                            class="px-5 py-2 rounded-full text-sm font-semibold transition-all duration-200 border">
                            {{ $category->name }}
                            <span class="ml-1 text-xs opacity-70">({{ $category->themes_count }})</span>
                        </button>
                    @endforeach
                </div>
            @endif

            {{-- Scroll container --}}
            <div class="relative">
                <button type="button" @click="$refs.scrollContainer.scrollLeft -= 320"
                    aria-label="Geser tema ke kiri"
                    class="absolute left-0 top-1/2 z-10 hidden h-11 w-11 -translate-y-1/2 items-center justify-center rounded-full border border-neutral-200 bg-white text-neutral-600 shadow-lg transition-all duration-200 hover:border-primary-300 hover:text-primary-600 hover:shadow-xl focus:outline-none focus-visible:ring-2 focus-visible:ring-primary-500 lg:flex dark:border-secondary-700 dark:bg-secondary-800 dark:text-neutral-300">
                    <i class="fas fa-chevron-left text-xs"></i>
                </button>
                <button type="button" @click="$refs.scrollContainer.scrollLeft += 320"
                    aria-label="Geser tema ke kanan"
                    class="absolute right-0 top-1/2 z-10 hidden h-11 w-11 -translate-y-1/2 items-center justify-center rounded-full border border-neutral-200 bg-white text-neutral-600 shadow-lg transition-all duration-200 hover:border-primary-300 hover:text-primary-600 hover:shadow-xl focus:outline-none focus-visible:ring-2 focus-visible:ring-primary-500 lg:flex dark:border-secondary-700 dark:bg-secondary-800 dark:text-neutral-300">
                    <i class="fas fa-chevron-right text-xs"></i>
                </button>

                <div x-ref="scrollContainer"
                    class="-mx-4 snap-x snap-mandatory scroll-px-4 overflow-x-auto px-4 pb-8 pt-3 scroll-smooth sm:-mx-6 sm:scroll-px-6 sm:px-6 lg:mx-0 lg:px-14">
                    <div class="flex w-max gap-5 px-0.5">
                        @forelse($themes as $theme)
                            <div x-show="filter === 'all' || filter === '{{ $theme->theme_category_id ?? '0' }}'"
                                x-transition:enter="transition ease-out duration-300"
                                x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                                class="w-[78vw] max-w-[19rem] shrink-0 snap-start sm:w-72">
                                <x-theme-card :theme="$theme" variant="carousel" />
                            </div>
                        @empty
                            <div class="py-16 text-center w-full min-w-[400px]">
                                <i class="fas fa-paintbrush text-3xl text-neutral-300 mb-3"></i>
                                <p class="text-neutral-500 font-medium">Belum ada tema tersedia</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            @if($totalThemes > 8)
                <div class="mt-10 text-center">
                    <a href="{{ route('themes.index') }}" id="themes-view-all"
                        class="inline-flex items-center gap-2 px-8 py-3.5 border-2 border-primary-200 text-primary-600 font-semibold rounded-2xl bg-white dark:bg-secondary-800 hover:bg-primary-50 hover:border-primary-400 transition-all duration-200 shadow-sm group">
                        <i class="fas fa-th-large text-sm"></i>
                        <span>Lihat Semua Tema ({{ $totalThemes }})</span>
                        <i
                            class="fas fa-arrow-right text-sm group-hover:translate-x-1 transition-transform duration-200"></i>
                    </a>
                </div>
            @endif
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════
    FEATURES — Staggered bento
    ═══════════════════════════════════════════════ --}}
    <section id="features" data-aos="fade-up" class="py-24 bg-[#F5F3EF] dark:bg-secondary-900/60">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Header --}}
            <div class="mb-16 text-center">
                <p class="text-xs font-bold tracking-[0.2em] text-primary-500 uppercase mb-3">Fitur Undangan Digital</p>
                <h2 class="font-heading text-4xl md:text-5xl font-bold text-secondary-900 dark:text-neutral-100 mb-4">
                    Undangan Lebih Personal,<br><span class="text-primary-500">Persiapan Lebih Praktis</span>
                </h2>
                <p class="text-neutral-500 dark:text-neutral-400 max-w-lg mx-auto text-sm">
                    Bagikan cerita cinta Anda, sapa setiap tamu, dan pantau konfirmasi kehadiran dalam satu undangan digital.
                </p>
            </div>

            {{-- Feature chips grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">

                @php
                    $features = [
                        // 1. Mengundang Tamu
                        ['icon' => 'fa-link', 'color' => 'emerald', 'title' => 'Link Personal Tamu', 'desc' => 'Sapa tamu dengan nama. Link khusus setiap tamu lengkap dengan template WhatsApp otomatis.', 'tag' => 'Personalized greeting'],
                        ['icon' => 'fa-whatsapp fab', 'color' => 'green', 'title' => 'Broadcast WhatsApp', 'desc' => 'Kirim pengingat otomatis ke semua tamu. Template pesan siap pakai dan bisa diedit.', 'tag' => 'Auto reminder'],

                        // 2. Sebelum Acara
                        ['icon' => 'fa-calendar-check', 'color' => 'primary', 'title' => 'Manajemen RSVP', 'desc' => 'Ketahui siapa saja yang hadir. Sistem RSVP terintegrasi dashboard dengan notifikasi real-time.', 'tag' => 'Real-time tracking'],
                        ['icon' => 'fa-hourglass-half', 'color' => 'blue', 'title' => 'Countdown Timer', 'desc' => 'Hitung mundur menuju hari H. Buat tamu semakin antusias dan tidak lupa tanggal.', 'tag' => 'Auto countdown'],
                        ['icon' => 'fa-map-marker-alt', 'color' => 'indigo', 'title' => 'Peta Lokasi', 'desc' => 'Google Maps langsung di undangan. Tamu buka navigasi dengan satu klik.', 'tag' => 'Google Maps'],

                        // 3. Saat Acara
                        ['icon' => 'fa-qrcode', 'color' => 'cyan', 'title' => 'QR Code Check-in', 'desc' => 'Proses registrasi tamu lebih cepat dengan QR Code unik. Kehadiran tercatat otomatis di dashboard.', 'tag' => 'Fast check-in'],
                        ['icon' => 'fa-video', 'color' => 'orange', 'title' => 'Live Streaming', 'desc' => 'Siarkan acara secara langsung melalui YouTube atau Zoom agar keluarga dan teman tetap bisa menyaksikan.', 'tag' => 'Live event'],
                        ['icon' => 'fa-music', 'color' => 'pink', 'title' => 'Background Music', 'desc' => 'Tambahkan musik favorit sebagai latar undangan untuk menciptakan pengalaman yang lebih berkesan.', 'tag' => 'Auto play'],

                        // 4. Interaksi Tamu
                        ['icon' => 'fa-book-open', 'color' => 'purple', 'title' => 'Buku Tamu Interaktif', 'desc' => 'Ucapan dan doa real-time di halaman undangan, dilengkapi emoji dan stiker.', 'tag' => 'Real-time messages'],
                        ['icon' => 'fa-gift', 'color' => 'amber', 'title' => 'Digital Gift (Angpao)', 'desc' => 'Transfer bank, QRIS, atau e-wallet. Tamu bisa kirim hadiah dari mana saja.', 'tag' => 'Multi payment'],

                        // 5. Setelah Acara
                        ['icon' => 'fa-images', 'color' => 'rose', 'title' => 'Galeri Foto & Video', 'desc' => 'Unggah foto kenangan. Tamu juga bisa kirim foto mereka ke galeri bersama.', 'tag' => 'Unlimited uploads*'],
                        ['icon' => 'fa-chart-line', 'color' => 'slate', 'title' => 'Analytics & Insight', 'desc' => 'Pantau pengunjung, RSVP, dan interaksi tamu. Data real-time di dashboard lengkap.', 'tag' => 'Real-time analytics'],
                    ];

                    $colorMap = [
                        'primary' => ['bg' => 'bg-primary-500', 'light' => 'bg-primary-50 dark:bg-primary-900/20', 'text' => 'text-primary-500', 'tag' => 'bg-primary-100 text-primary-700 dark:bg-primary-900/30 dark:text-primary-300'],
                        'emerald' => ['bg' => 'bg-emerald-500', 'light' => 'bg-emerald-50 dark:bg-emerald-900/20', 'text' => 'text-emerald-500', 'tag' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300'],
                        'amber' => ['bg' => 'bg-amber-500', 'light' => 'bg-amber-50 dark:bg-amber-900/20', 'text' => 'text-amber-500', 'tag' => 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-300'],
                        'purple' => ['bg' => 'bg-purple-500', 'light' => 'bg-purple-50 dark:bg-purple-900/20', 'text' => 'text-purple-500', 'tag' => 'bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-300'],
                        'rose' => ['bg' => 'bg-rose-500', 'light' => 'bg-rose-50 dark:bg-rose-900/20', 'text' => 'text-rose-500', 'tag' => 'bg-rose-100 text-rose-700 dark:bg-rose-900/30 dark:text-rose-300'],
                        'blue' => ['bg' => 'bg-blue-500', 'light' => 'bg-blue-50 dark:bg-blue-900/20', 'text' => 'text-blue-500', 'tag' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300'],
                        'indigo' => ['bg' => 'bg-indigo-500', 'light' => 'bg-indigo-50 dark:bg-indigo-900/20', 'text' => 'text-indigo-500', 'tag' => 'bg-indigo-100 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-300'],
                        'green' => ['bg' => 'bg-green-500', 'light' => 'bg-green-50 dark:bg-green-900/20', 'text' => 'text-green-500', 'tag' => 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-300'],
                        'slate' => ['bg' => 'bg-slate-500', 'light' => 'bg-slate-50 dark:bg-slate-900/20', 'text' => 'text-slate-500', 'tag' => 'bg-slate-100 text-slate-700 dark:bg-slate-900/30 dark:text-slate-300'],

                        // Warna baru
                        'cyan' => ['bg' => 'bg-cyan-500', 'light' => 'bg-cyan-50 dark:bg-cyan-900/20', 'text' => 'text-cyan-500', 'tag' => 'bg-cyan-100 text-cyan-700 dark:bg-cyan-900/30 dark:text-cyan-300'],
                        'pink' => ['bg' => 'bg-pink-500', 'light' => 'bg-pink-50 dark:bg-pink-900/20', 'text' => 'text-pink-500', 'tag' => 'bg-pink-100 text-pink-700 dark:bg-pink-900/30 dark:text-pink-300'],
                        'orange' => ['bg' => 'bg-orange-500', 'light' => 'bg-orange-50 dark:bg-orange-900/20', 'text' => 'text-orange-500', 'tag' => 'bg-orange-100 text-orange-700 dark:bg-orange-900/30 dark:text-orange-300'],
                    ];
                @endphp

                @foreach($features as $i => $feat)
                    @php $c = $colorMap[$feat['color']];
                    $delay = ($i % 3 + 1) * 100; @endphp
                    <div data-aos="fade-up" data-aos-delay="{{ $delay }}"
                        class="feature-chip group bg-white dark:bg-secondary-800 rounded-2xl p-6 border border-neutral-100/70 dark:border-secondary-700 shadow-[0_2px_12px_rgba(0,0,0,0.04)]">
                        <div class="flex items-start gap-4">
                            <div
                                class="flex-shrink-0 w-11 h-11 rounded-xl {{ $c['light'] }} flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                <i
                                    class="{{ str_contains($feat['icon'], 'fab') ? 'fab ' . str_replace(' fab', '', $feat['icon']) : 'fas ' . $feat['icon'] }} {{ $c['text'] }}"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="font-bold text-secondary-800 dark:text-neutral-200 mb-1 text-sm">
                                    {{ $feat['title'] }}</h3>
                                <p class="text-neutral-500 dark:text-neutral-400 text-xs leading-relaxed mb-3">
                                    {{ $feat['desc'] }}</p>
                                <span
                                    class="inline-block px-2 py-0.5 rounded text-[10px] font-bold {{ $c['tag'] }}">{{ $feat['tag'] }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <p class="text-center text-xs text-neutral-400 mt-8">*Fitur tersedia sesuai paket yang dipilih</p>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════
    HOW IT WORKS — Vertical timeline
    ═══════════════════════════════════════════════ --}}
    <section id="how-it-works" data-aos="fade-up"
        class="py-24 bg-secondary-900 dark:bg-black/20 overflow-hidden relative">
        <div class="absolute inset-0 pointer-events-none"
            style="background-image: radial-gradient(circle at 80% 50%, rgba(255,122,0,0.06) 0%, transparent 60%);">
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-start">

                {{-- Left: Header sticky-ish --}}
                <div data-aos="fade-right" class="lg:sticky lg:top-24">
                    <p class="text-xs font-bold tracking-[0.2em] text-primary-500 uppercase mb-4">Cara Membuat Undangan</p>
                    <h2 class="font-heading text-4xl md:text-5xl font-bold text-white leading-tight mb-6">
                        Dari Pilih Desain<br>
                        ke <span class="text-primary-500">Sebar Undangan</span><br>
                        — 4 Langkah.
                    </h2>
                    <p class="text-neutral-400 leading-relaxed mb-8">
                        Tidak perlu skill desain. Tidak perlu nunggu lama. Selesai sendiri, kapan saja.
                    </p>

                    {{-- Stats --}}
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-white/5 rounded-2xl p-5 border border-white/8">
                            <p class="text-3xl font-extrabold text-primary-400 mb-1">98%</p>
                            <p class="text-sm text-neutral-400">Kepuasan Pelanggan</p>
                        </div>
                        <div class="bg-white/5 rounded-2xl p-5 border border-white/8">
                            <p class="text-3xl font-extrabold text-primary-400 mb-1">5 mnt</p>
                            <p class="text-sm text-neutral-400">Setup Tercepat</p>
                        </div>
                    </div>
                </div>

                {{-- Right: Timeline steps --}}
                <div class="relative" data-aos="fade-left" data-aos-delay="100">

                    {{-- Step 1 --}}
                    <div class="relative flex items-start gap-4 mb-8">
                        <div
                            class="absolute left-[18px] top-[18px] -translate-x-1/2 w-0.5 h-[calc(100%_+_2rem)] bg-gradient-to-b from-primary-500/70 to-primary-500/10">
                        </div>
                        <div
                            class="relative z-10 flex-shrink-0 w-9 h-9 rounded-full bg-primary-500 flex items-center justify-center shadow-[0_0_0_4px_rgba(255,122,0,0.15)]">
                            <span class="text-white text-xs font-black">1</span>
                        </div>
                        <div
                            class="flex-1 bg-white/5 hover:bg-white/8 border border-white/8 hover:border-primary-500/30 rounded-2xl p-6 transition-all duration-300 group cursor-default">
                            <div class="flex items-start gap-4">
                                <div
                                    class="w-12 h-12 rounded-xl bg-primary-500/15 flex items-center justify-center flex-shrink-0 group-hover:bg-primary-500/25 transition-colors duration-300">
                                    <i class="fas fa-palette text-primary-400 text-lg"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-white mb-1.5">Pilih Tema Favorit</h3>
                                    <p class="text-neutral-400 text-sm leading-relaxed">Jelajahi katalog desain premium
                                        dan pratinjau langsung sebelum memilih.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Step 2 --}}
                    <div class="relative flex items-start gap-4 mb-8">
                        <div
                            class="absolute left-[18px] top-[18px] -translate-x-1/2 w-0.5 h-[calc(100%_+_2rem)] bg-gradient-to-b from-secondary-600/70 to-secondary-600/10">
                        </div>
                        <div
                            class="relative z-10 flex-shrink-0 w-9 h-9 rounded-full bg-secondary-700 flex items-center justify-center shadow-[0_0_0_4px_rgba(255,255,255,0.06)]">
                            <span class="text-white text-xs font-black">2</span>
                        </div>
                        <div
                            class="flex-1 bg-white/5 hover:bg-white/8 border border-white/8 hover:border-white/20 rounded-2xl p-6 transition-all duration-300 group cursor-default">
                            <div class="flex items-start gap-4">
                                <div
                                    class="w-12 h-12 rounded-xl bg-white/10 flex items-center justify-center flex-shrink-0 group-hover:bg-white/15 transition-colors duration-300">
                                    <i class="fas fa-user-plus text-neutral-300 text-lg"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-white mb-1.5">Daftar &amp; Isi Data Acara</h3>
                                    <p class="text-neutral-400 text-sm leading-relaxed">Buat akun gratis, lalu isi info
                                        mempelai, jadwal, dan preferensi undangan.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Step 3 --}}
                    <div class="relative flex items-start gap-4 mb-8">
                        <div
                            class="absolute left-[18px] top-[18px] -translate-x-1/2 w-0.5 h-[calc(100%_+_2rem)] bg-gradient-to-b from-primary-500/70 to-primary-500/10">
                        </div>
                        <div
                            class="relative z-10 flex-shrink-0 w-9 h-9 rounded-full bg-primary-500 flex items-center justify-center shadow-[0_0_0_4px_rgba(255,122,0,0.15)]">
                            <span class="text-white text-xs font-black">3</span>
                        </div>
                        <div
                            class="flex-1 bg-white/5 hover:bg-white/8 border border-white/8 hover:border-primary-500/30 rounded-2xl p-6 transition-all duration-300 group cursor-default">
                            <div class="flex items-start gap-4">
                                <div
                                    class="w-12 h-12 rounded-xl bg-primary-500/15 flex items-center justify-center flex-shrink-0 group-hover:bg-primary-500/25 transition-colors duration-300">
                                    <i class="fas fa-rocket text-primary-400 text-lg"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-white mb-1.5">Aktivasi Paket</h3>
                                    <p class="text-neutral-400 text-sm leading-relaxed">Pilih paket sesuai kebutuhan,
                                        bayar via berbagai metode, fitur aktif seketika.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Step 4 --}}
                    <div class="relative flex items-start gap-4">
                        <div
                            class="relative z-10 flex-shrink-0 w-9 h-9 rounded-full bg-secondary-700 flex items-center justify-center shadow-[0_0_0_4px_rgba(255,255,255,0.06)]">
                            <span class="text-white text-xs font-black">4</span>
                        </div>
                        <div
                            class="flex-1 bg-white/5 hover:bg-white/8 border border-white/8 hover:border-white/20 rounded-2xl p-6 transition-all duration-300 group cursor-default">
                            <div class="flex items-start gap-4">
                                <div
                                    class="w-12 h-12 rounded-xl bg-white/10 flex items-center justify-center flex-shrink-0 group-hover:bg-white/15 transition-colors duration-300">
                                    <i class="fas fa-share-alt text-neutral-300 text-lg"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-white mb-1.5">Sebar &amp; Pantau RSVP</h3>
                                    <p class="text-neutral-400 text-sm leading-relaxed">Generate link personal per tamu,
                                        kirim via WhatsApp massal, pantau RSVP real-time.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Footer note --}}
                    <div class="mt-8 flex items-center gap-3 text-xs text-neutral-500">
                        <i class="fas fa-credit-card"></i>
                        <span>Tidak perlu kartu kredit untuk mulai</span>
                        <span>·</span>
                        <i class="fas fa-times-circle"></i>
                        <span>Batalkan kapan saja</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════
    PRICING & SERVICES — Tab with bold pricing
    ═══════════════════════════════════════════════ --}}
    <section id="pricing" x-data="{ activeTab: 'undangan' }" data-aos="fade-up" class="py-24 bg-[#FDFCFA] dark:bg-secondary-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Header --}}
            <div class="mb-14 text-center">
                <p class="text-xs font-bold tracking-[0.2em] text-primary-500 uppercase mb-3">Paket & Harga Undangan</p>
                <h2 class="font-heading text-4xl md:text-5xl font-bold text-secondary-900 dark:text-neutral-100 mb-4">
                    Undangan Impian,<br><span class="text-primary-500">Paket Sesuai Kebutuhan</span>
                </h2>
                <p class="text-neutral-500 dark:text-neutral-400 max-w-md mx-auto text-sm">
                    Pilih paket undangan untuk hari istimewa Anda. Layanan buku tamu dan live streaming juga tersedia sesuai kebutuhan acara.
                </p>
            </div>

            {{-- Tab navigation --}}
            <div class="flex justify-center mb-12">
                <div
                    class="w-full sm:w-auto flex flex-col sm:flex-row items-stretch sm:items-center gap-1 p-1.5 bg-neutral-100 dark:bg-secondary-800 rounded-2xl sm:rounded-2xl border border-neutral-200/50 dark:border-secondary-700">
                    <button @click="activeTab = 'undangan'" id="tab-undangan"
                        :class="activeTab === 'undangan' ? 'bg-white dark:bg-secondary-700 text-primary-600 shadow-sm' : 'text-neutral-500 hover:text-secondary-700 dark:hover:text-neutral-300'"
                        class="flex items-center justify-center sm:justify-start gap-2 px-5 py-3 sm:py-2.5 rounded-xl text-sm font-semibold transition-all duration-200">
                        <i class="fas fa-heart text-xs"></i> Undangan Digital
                    </button>
                    <button @click="activeTab = 'buku-tamu'" id="tab-bukutamu"
                        :class="activeTab === 'buku-tamu' ? 'bg-white dark:bg-secondary-700 text-primary-600 shadow-sm' : 'text-neutral-500 hover:text-secondary-700 dark:hover:text-neutral-300'"
                        class="flex items-center justify-center sm:justify-start gap-2 px-5 py-3 sm:py-2.5 rounded-xl text-sm font-semibold transition-all duration-200">
                        <i class="fas fa-book text-xs"></i> Buku Tamu
                    </button>
                    <button @click="activeTab = 'live-streaming'" id="tab-streaming"
                        :class="activeTab === 'live-streaming' ? 'bg-white dark:bg-secondary-700 text-primary-600 shadow-sm' : 'text-neutral-500 hover:text-secondary-700 dark:hover:text-neutral-300'"
                        class="flex items-center justify-center sm:justify-start gap-2 px-5 py-3 sm:py-2.5 rounded-xl text-sm font-semibold transition-all duration-200">
                        <i class="fas fa-video text-xs"></i> Live Streaming
                    </button>
                </div>
            </div>

            {{-- ── PANEL: UNDANGAN DIGITAL ── --}}
            <div x-show="activeTab === 'undangan'" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                    @forelse($packages as $package)
                                    <div
                                        class="group relative bg-white dark:bg-secondary-800 rounded-3xl transition-all duration-300
                                            {{ $package->is_popular
                        ? 'border-2 border-primary-500 shadow-[0_8px_32px_-8px_rgba(255,122,0,0.25)] popular-pulse'
                        : 'border border-neutral-200 dark:border-secondary-700 hover:border-primary-200 hover:shadow-xl' }}">

                                        @if($package->is_popular)
                                            <div class="absolute -top-3.5 left-0 right-0 flex justify-center">
                                                <span
                                                    class="inline-flex items-center gap-1.5 bg-primary-500 px-4 py-1.5 rounded-full text-xs font-bold text-white shadow-md">
                                                    <i class="fas fa-star text-[9px]"></i> Best Seller
                                                </span>
                                            </div>
                                        @endif

                                        <div class="p-6 pt-{{ $package->is_popular ? '8' : '6' }}">
                                            <h3
                                                class="font-bold text-lg {{ $package->is_popular ? 'text-primary-600 dark:text-primary-400' : 'text-secondary-800 dark:text-neutral-100' }} mb-1">
                                                {{ $package->package_name }}
                                            </h3>
                                            @if($package->description)
                                                <p class="text-xs text-neutral-400 mb-5">{{ $package->description }}</p>
                                            @endif

                                            {{-- Price --}}
                                            <div class="mb-6">
                                                <x-promotion-price :package="$package" :quote="$promotionCatalog['prices'][$package->package_code]" />
                                            </div>
                                            {{-- CTA --}}
                                            @auth
                                                @if($package->package_code === 'free')
                                                    <div
                                                        class="w-full bg-neutral-100 dark:bg-secondary-700 text-neutral-500 rounded-xl py-3 text-xs font-bold text-center">
                                                        ✅ Paket Aktif
                                                    </div>
                                                @else
                                                    <a href="{{ route('dashboard.checkout') }}"
                                                        class="flex items-center justify-center gap-2 w-full rounded-xl py-3 text-sm font-bold text-center transition-all duration-200
                                                                    {{ $package->is_popular ? 'bg-primary-500 text-white hover:bg-primary-600 shadow-md hover:shadow-lg' : 'bg-primary-50 border border-primary-200 text-primary-700 hover:bg-primary-100' }}">
                                                        Pilih {{ $package->package_name }}
                                                        <i class="fas fa-chevron-right text-xs"></i>
                                                    </a>
                                                @endif
                                            @else
                                                @if($package->package_code === 'free')
                                                    <a href="{{ route('register') }}"
                                                        class="flex items-center justify-center gap-2 w-full bg-secondary-800 dark:bg-secondary-700 text-white rounded-xl py-3 text-sm font-bold hover:bg-secondary-900 transition-colors">
                                                        Daftar Gratis <i class="fas fa-chevron-right text-xs"></i>
                                                    </a>
                                                @else
                                                    <a href="{{ route('register') }}"
                                                        class="flex items-center justify-center gap-2 w-full rounded-xl py-3 text-sm font-bold text-center transition-all duration-200
                                                                    {{ $package->is_popular ? 'bg-primary-500 text-white hover:bg-primary-600 shadow-md hover:shadow-lg' : 'bg-primary-50 border border-primary-200 text-primary-700 hover:bg-primary-100' }}">
                                                        Pilih {{ $package->package_name }}
                                                        <i class="fas fa-chevron-right text-xs"></i>
                                                    </a>
                                                @endif
                                            @endauth
                                        </div>

                                        {{-- Features --}}
                                        <div class="border-t border-neutral-100 dark:border-secondary-700 px-6 py-5">
                                            <p class="text-[10px] font-bold text-neutral-400 uppercase tracking-widest mb-3">Fitur
                                                Termasuk</p>
                                            <ul class="space-y-2.5">
                                                @forelse($package->features as $feature)
                                                    <li class="flex items-start gap-2 text-xs text-neutral-600 dark:text-neutral-300">
                                                        <i class="fas fa-check text-emerald-500 mt-0.5 flex-shrink-0 text-[10px]"></i>
                                                        <span>{{ $feature->feature_name }}</span>
                                                    </li>
                                                @empty
                                                    <li class="text-xs text-neutral-400 italic">Fitur dasar</li>
                                                @endforelse
                                            </ul>
                                        </div>
                                    </div>
                    @empty
                        <div class="col-span-full py-16 text-center">
                            <i class="fas fa-box-open text-3xl text-neutral-300 mb-3"></i>
                            <p class="text-neutral-500 font-medium">Belum ada paket tersedia</p>
                            <p class="text-xs text-neutral-400 mt-1">Silakan hubungi admin untuk informasi lebih lanjut.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- ── PANEL: BUKU TAMU ── --}}
            <div x-show="activeTab === 'buku-tamu'" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
                <div class="max-w-3xl mx-auto">
                    <div class="text-center mb-10">
                        <div
                            class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-emerald-50 dark:bg-emerald-900/20 mb-4">
                            <i class="fas fa-book-open text-3xl text-emerald-500"></i>
                        </div>
                        <h3 class="font-heading text-3xl font-bold text-secondary-900 dark:text-neutral-100 mb-2">Buku
                            Tamu Digital</h3>
                        <p class="text-neutral-500 dark:text-neutral-400">Catat kehadiran tamu secara modern. Scan QR,
                            isi nama, tinggalkan ucapan — semua tersimpan otomatis.</p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-10">
                        @foreach([
                                ['icon' => 'fa-qrcode', 'color' => 'emerald', 'title' => 'QR Code Tamu', 'desc' => 'Scan dari ponsel, tanpa download aplikasi'],
                                ['icon' => 'fa-comment-dots', 'color' => 'emerald', 'title' => 'Ucapan & Doa', 'desc' => 'Kumpulkan pesan dari seluruh tamu undangan'],
                                ['icon' => 'fa-file-excel', 'color' => 'emerald', 'title' => 'Ekspor Data', 'desc' => 'Unduh data kehadiran format Excel/CSV'],
                                ['icon' => 'fa-chart-bar', 'color' => 'emerald', 'title' => 'Rekap Real-time', 'desc' => 'Pantau kehadiran langsung dari dashboard'],
                            ] as $feat)
                            <div
                                class="flex items-start gap-3 bg-white dark:bg-secondary-800 rounded-2xl p-4 border border-neutral-100 dark:border-secondary-700 shadow-sm">
                                <div
                                    class="w-10 h-10 rounded-xl bg-emerald-50 dark:bg-emerald-900/20 flex items-center justify-center flex-shrink-0">
                                    <i class="fas {{ $feat['icon'] }} text-emerald-500"></i>
                                </div>
                                <div>
                                    <p class="font-semibold text-secondary-800 dark:text-neutral-200 text-sm">
                                        {{ $feat['title'] }}</p>
                                    <p class="text-xs text-neutral-400 mt-0.5">{{ $feat['desc'] }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div
                        class="bg-gradient-to-br from-emerald-50 to-teal-50 dark:from-secondary-800 dark:to-secondary-800 border border-emerald-100 dark:border-emerald-900/30 rounded-2xl p-8 text-center">
                        <p class="font-semibold text-secondary-800 dark:text-neutral-200 mb-1">Tertarik dengan layanan
                            ini?</p>
                        <p class="text-sm text-neutral-500 mb-6">Hubungi tim kami untuk demo & harga terbaik.</p>
                        <a href="https://wa.me/{{ config('app.whatsapp_number', '62895349823366') }}?text={{ urlencode('Halo, saya tertarik dengan layanan Buku Tamu Digital. Bisa tolong jelaskan lebih lanjut?') }}"
                            target="_blank" id="bukutamu-cta-wa"
                            class="inline-flex items-center gap-2 px-6 py-3 bg-emerald-500 text-white rounded-xl text-sm font-bold hover:bg-emerald-600 transition-all duration-200 shadow-sm hover:shadow-md">
                            <i class="fab fa-whatsapp"></i> Hubungi via WhatsApp
                        </a>
                    </div>
                </div>
            </div>

            {{-- ── PANEL: LIVE STREAMING ── --}}
            <div x-show="activeTab === 'live-streaming'" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
                <div class="max-w-3xl mx-auto">
                    <div class="text-center mb-10">
                        <div
                            class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-primary-50 dark:bg-primary-900/20 mb-4">
                            <i class="fas fa-video text-3xl text-primary-500"></i>
                        </div>
                        <h3 class="font-heading text-3xl font-bold text-secondary-900 dark:text-neutral-100 mb-2">Live
                            Streaming Pernikahan</h3>
                        <p class="text-neutral-500 dark:text-neutral-400">Siarkan momen spesial kepada keluarga di
                            seluruh penjuru dunia — tanpa harus hadir secara fisik.</p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-10">
                        @foreach([
                                ['icon' => 'fa-film', 'title' => 'HD Streaming', 'desc' => 'Kualitas video jernih hingga Full HD'],
                                ['icon' => 'fa-lock', 'title' => 'Link Privat', 'desc' => 'Hanya tamu undangan yang bisa menonton'],
                                ['icon' => 'fa-cloud-download-alt', 'title' => 'Rekaman Video', 'desc' => 'Siaran direkam dan tersedia untuk diunduh'],
                                ['icon' => 'fa-users', 'title' => 'Unlimited Penonton', 'desc' => 'Tidak ada batasan jumlah penonton'],
                            ] as $feat)
                            <div
                                class="flex items-start gap-3 bg-white dark:bg-secondary-800 rounded-2xl p-4 border border-neutral-100 dark:border-secondary-700 shadow-sm">
                                <div
                                    class="w-10 h-10 rounded-xl bg-primary-50 dark:bg-primary-900/20 flex items-center justify-center flex-shrink-0">
                                    <i class="fas {{ $feat['icon'] }} text-primary-500"></i>
                                </div>
                                <div>
                                    <p class="font-semibold text-secondary-800 dark:text-neutral-200 text-sm">
                                        {{ $feat['title'] }}</p>
                                    <p class="text-xs text-neutral-400 mt-0.5">{{ $feat['desc'] }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div
                        class="bg-gradient-to-br from-primary-50 to-secondary-50 dark:from-secondary-800 dark:to-secondary-800 border border-primary-100 dark:border-primary-900/30 rounded-2xl p-8 text-center">
                        <p class="font-semibold text-secondary-800 dark:text-neutral-200 mb-1">Tertarik dengan layanan
                            ini?</p>
                        <p class="text-sm text-neutral-500 mb-6">Hubungi tim kami untuk demo & harga terbaik.</p>
                        <a href="https://wa.me/{{ config('app.whatsapp_number', '62895349823366') }}?text={{ urlencode('Halo, saya tertarik dengan layanan Live Streaming Pernikahan. Bisa tolong jelaskan lebih lanjut?') }}"
                            target="_blank" id="streaming-cta-wa"
                            class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-primary-500 to-primary-600 text-white rounded-xl text-sm font-bold hover:from-primary-600 hover:to-primary-700 transition-all duration-200 shadow-sm hover:shadow-md">
                            <i class="fab fa-whatsapp"></i> Hubungi via WhatsApp
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════
    WEDDING PLANNER
    ═══════════════════════════════════════════════ --}}
    <x-landing-wedding-planner />

    {{-- ═══════════════════════════════════════════════
    SERVICES — Bento-style layout
    ═══════════════════════════════════════════════ --}}
    <section id="services" data-aos="fade-up" class="py-24 bg-[#FDFCFA] dark:bg-secondary-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Header --}}
            <div class="mb-16">
                <p class="text-xs font-bold tracking-[0.2em] text-primary-500 uppercase mb-3">Layanan untuk Perayaan Anda</p>
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
                    <h2
                        class="font-heading text-4xl md:text-5xl font-bold text-secondary-900 dark:text-neutral-100 leading-tight">
                        Dari Undangan,<br>
                        <span class="text-primary-500">hingga Hari Perayaan</span>
                    </h2>
                    <p class="text-neutral-500 dark:text-neutral-400 max-w-xs text-sm leading-relaxed">
                        Lengkapi undangan digital Anda dengan buku tamu QR Code dan live streaming untuk menyambut setiap tamu.
                    </p>
                </div>
            </div>

            {{-- Bento grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">

                {{-- Card 1: Undangan Web — large --}}
                <div data-aos="fade-up" data-aos-delay="100"
                    class="group relative lg:col-span-2 rounded-3xl overflow-hidden bg-gradient-to-br from-primary-50 to-[#FFF4EB] dark:from-secondary-800 dark:to-secondary-800 border border-primary-100/50 dark:border-secondary-700 p-8 hover:shadow-[0_20px_60px_-12px_rgba(255,122,0,0.2)] transition-all duration-500">
                    <div
                        class="absolute -right-8 -bottom-8 w-48 h-48 bg-primary-500/10 rounded-full blur-2xl pointer-events-none group-hover:scale-150 transition-transform duration-700">
                    </div>
                    <div class="relative z-10">
                        <div class="flex items-start justify-between mb-6">
                            <div
                                class="w-14 h-14 rounded-2xl bg-primary-500 text-white flex items-center justify-center shadow-lg shadow-primary-200 group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-envelope-open-text text-xl"></i>
                            </div>
                            <span
                                class="text-[80px] font-black text-primary-100 dark:text-primary-900/30 leading-none select-none">01</span>
                        </div>
                        <h3 class="text-2xl font-bold text-secondary-900 dark:text-neutral-100 mb-2">Undangan Web</h3>
                        <p class="text-neutral-500 dark:text-neutral-400 leading-relaxed mb-6 max-w-md">
                            Undangan digital eksklusif dengan desain responsif, musik latar, galeri foto, dan countdown
                            otomatis. Siap dalam 5 menit.
                        </p>
                        <a href="{{ route('undangan-web') }}" id="service-undangan-link"
                            class="inline-flex items-center gap-2 text-primary-600 font-semibold text-sm hover:gap-3 transition-all duration-200">
                            Selengkapnya <i class="fas fa-arrow-right text-xs"></i>
                        </a>
                    </div>
                </div>

                {{-- Card 2: Buku Tamu --}}
                <div data-aos="fade-up" data-aos-delay="200"
                    class="group relative rounded-3xl overflow-hidden bg-gradient-to-br from-emerald-50 to-teal-50/50 dark:from-secondary-800 dark:to-secondary-800 border border-emerald-100/50 dark:border-secondary-700 p-8 hover:shadow-[0_20px_60px_-12px_rgba(16,185,129,0.2)] transition-all duration-500">
                    <div
                        class="absolute -right-6 -bottom-6 w-36 h-36 bg-emerald-400/10 rounded-full blur-2xl pointer-events-none group-hover:scale-150 transition-transform duration-700">
                    </div>
                    <div class="relative z-10">
                        <div class="flex items-start justify-between mb-6">
                            <div
                                class="w-14 h-14 rounded-2xl bg-emerald-500 text-white flex items-center justify-center shadow-lg shadow-emerald-200 group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-qrcode text-xl"></i>
                            </div>
                            <span
                                class="text-[80px] font-black text-emerald-100 dark:text-emerald-900/20 leading-none select-none">02</span>
                        </div>
                        <h3 class="text-2xl font-bold text-secondary-900 dark:text-neutral-100 mb-2">Buku Tamu Digital
                        </h3>
                        <p class="text-neutral-500 dark:text-neutral-400 leading-relaxed mb-6">
                            Check-in QR Code. Lebih cepat, terorganisir, data tersimpan otomatis.
                        </p>
                        <a href="{{ route('buku-tamu') }}" id="service-bukutamu-link"
                            class="inline-flex items-center gap-2 text-emerald-600 font-semibold text-sm hover:gap-3 transition-all duration-200">
                            Selengkapnya <i class="fas fa-arrow-right text-xs"></i>
                        </a>
                    </div>
                </div>

                {{-- Card 3: Live Streaming --}}
                <div data-aos="fade-up" data-aos-delay="300"
                    class="group relative rounded-3xl overflow-hidden bg-gradient-to-br from-purple-50 to-indigo-50/50 dark:from-secondary-800 dark:to-secondary-800 border border-purple-100/50 dark:border-secondary-700 p-8 hover:shadow-[0_20px_60px_-12px_rgba(147,51,234,0.2)] transition-all duration-500">
                    <div
                        class="absolute -right-6 -bottom-6 w-36 h-36 bg-purple-400/10 rounded-full blur-2xl pointer-events-none group-hover:scale-150 transition-transform duration-700">
                    </div>
                    <div class="relative z-10">
                        <div class="flex items-start justify-between mb-6">
                            <div
                                class="w-14 h-14 rounded-2xl bg-purple-500 text-white flex items-center justify-center shadow-lg shadow-purple-200 group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-broadcast-tower text-xl"></i>
                            </div>
                            <span
                                class="text-[80px] font-black text-purple-100 dark:text-purple-900/20 leading-none select-none">03</span>
                        </div>
                        <h3 class="text-2xl font-bold text-secondary-900 dark:text-neutral-100 mb-2">Live Streaming</h3>
                        <p class="text-neutral-500 dark:text-neutral-400 leading-relaxed mb-6">
                            Hubungkan tamu yang tidak bisa hadir melalui siaran langsung berkualitas tinggi.
                        </p>
                        <a href="{{ route('live-streaming') }}" id="service-streaming-link"
                            class="inline-flex items-center gap-2 text-purple-600 font-semibold text-sm hover:gap-3 transition-all duration-200">
                            Selengkapnya <i class="fas fa-arrow-right text-xs"></i>
                        </a>
                    </div>
                </div>

                {{-- Card 4: CTA --}}
                <div data-aos="fade-up" data-aos-delay="400"
                    class="lg:col-span-2 rounded-3xl bg-secondary-900 dark:bg-black/40 p-8 flex flex-col sm:flex-row items-center justify-between gap-6">
                    <div>
                        <h3 class="text-xl font-bold text-white mb-2">Siap memulai perjalanan digital?</h3>
                        <p class="text-neutral-400 text-sm">Konsultasikan kebutuhan acara Anda — gratis.</p>
                    </div>
                    <a href="https://wa.me/62895349823366?text=Halo%20Rayakan%20Digital%2C%20saya%20ingin%20konsultasi%20tentang%20layanan%20undangan%20digital."
                        id="service-cta-wa"
                        class="flex-shrink-0 inline-flex items-center gap-2.5 px-6 py-3.5 bg-primary-500 hover:bg-primary-600 text-white text-sm font-bold rounded-2xl transition-all duration-200 shadow-lg shadow-primary-900/40 hover:shadow-primary-900/60">
                        <i class="fab fa-whatsapp"></i>
                        Hubungi Kami
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════
    FAQ — Split layout
    ═══════════════════════════════════════════════ --}}
    <section id="faq" data-aos="fade-up" class="py-24 bg-[#F5F3EF] dark:bg-secondary-900/60">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-16">

                {{-- Left: Header --}}
                <div class="lg:col-span-4 lg:sticky lg:top-24 self-start">
                    <p class="text-xs font-bold tracking-[0.2em] text-primary-500 uppercase mb-4">FAQ</p>
                    <h2
                        class="font-heading text-4xl font-bold text-secondary-900 dark:text-neutral-100 leading-tight mb-6">
                        Pertanyaan<br>yang sering<br><span class="text-primary-500">ditanyakan.</span>
                    </h2>
                    <p class="text-neutral-500 dark:text-neutral-400 text-sm leading-relaxed mb-8">
                        Tidak menemukan jawaban yang kamu cari? Kami siap bantu via WhatsApp.
                    </p>
                    <a href="https://wa.me/62895349823366" id="faq-wa-link"
                        class="inline-flex items-center gap-2 px-6 py-3 bg-secondary-900 dark:bg-secondary-700 text-white text-sm font-bold rounded-2xl hover:bg-secondary-800 transition-all duration-200">
                        <i class="fab fa-whatsapp text-green-400"></i>
                        Chat Sekarang
                    </a>
                </div>

                {{-- Right: FAQ items --}}
                <div class="lg:col-span-8 space-y-3 faq-item">

                    @foreach([
                            [
    'q' => 'Gimana alur cara bikin undangan di Rayakan Digital?', 
    'a' => 'Simpel banget! Pertama, kamu pilih tema favorit dari katalog premium. Kedua, daftar akun gratis dan isi detail acara. Ketiga, aktifkan paket sesuai kebutuhanmu. Terakhir, tinggal generate link personal dan sebarin deh!'
],
[
    'q' => 'Apakah saya bisa liat dulu tampilan desainnya sebelum beli?', 
    'a' => 'Bisa banget! Kamu bebas jelajahi seluruh katalog desain premium dan cek pratinjau (preview) langsungnya dulu sampai nemu yang paling cocok sebelum milih.'
],
[
    'q' => 'Apakah daftar akun di Rayakan Digital itu bayar?', 
    'a' => 'Enggak dong, daftar akun itu 100% gratis! Sekarang proses pendaftaran jauh lebih praktis karena Anda bisa daftar mudah pakai Google. Cukup dengan satu klik, Anda bisa langsung masuk, mencoba dashboard secara gratis, dan melengkapi data acara sebelum memutuskan untuk melakukan pembayaran aktivasi paket.'
],
[
    'q' => 'Apakah Wedding Planner benar-benar gratis?',
    'a' => 'Ya! Cukup daftar undangan di Rayakan Digital untuk menggunakan Wedding Planner gratis. Kamu bisa mengelola checklist, anggaran, vendor, dan jadwal tanpa perlu membeli paket undangan berbayar.'
],
[
    'q' => 'Apakah Wedding Planner tetap bisa digunakan setelah undangan expired?',
    'a' => 'Tetap bisa! Masa aktif Wedding Planner tidak mengikuti masa aktif undangan. Meski undangan sudah kedaluwarsa, kamu tetap bisa memakai planner lewat dashboard tanpa harus memperpanjang undangan.'
],
[
    'q' => 'Kapan saya harus isi info acara dan foto-foto undangan?', 
    'a' => 'Setelah bikin akun gratis, kamu langsung dapet akses ke dashboard buat melengkapi info mempelai, jadwal acara, galeri foto, hingga preferensi undangan kamu sendiri.'
],
[
    'q' => 'Kalau udah selesai bikin, datanya masih bisa diganti gak?', 
    'a' => 'Bisa banget dong! Mau ganti jadwal, foto, lokasi Google Maps, atau typo nama mempelai, tinggal edit aja lewat dashboard kapan aja selama masa aktif undangan kamu masih jalan.'
],
[
    'q' => 'Apakah saya bisa ganti tema kalau udah terlanjur milih di awal?', 
    'a' => 'Bisa banget! Selama masa aktif undangan masih ada, kamu bebas ganti ke tema premium lainnya kapan aja lewat dashboard tanpa harus ngulang isi data dari awal.'
],
[
    'q' => 'Bagaimana proses pembayaran dan aktivasi fitur undangannya?', 
    'a' => 'Tinggal pilih paket yang pas sama kebutuhanmu, lalu bayar lewat berbagai metode pembayaran yang tersedia. Begitu transaksi selesai, semua fitur undangan kamu bakal aktif seketika tanpa nunggu lama!'
],
[
    'q' => 'Gimana cara sebar undangan dan tau siapa aja yang mau dateng?', 
    'a' => 'Kamu tinggal generate link khusus buat tiap tamu, lalu kirim via WhatsApp. Nanti kamu bisa langsung pantau konfirmasi kehadiran (RSVP) mereka secara real-time dari dashboard.'
],
[
    'q' => 'Berapa banyak nama tamu yang bisa saya buatkan link khusus?', 
    'a' => 'Tanpa batas! Kamu bebas buat link personal sebanyak yang kamu mau buat disebar ke semua keluarga, teman, dan rekan kerja.'
],
[
    'q' => 'Fitur WhatsApp massal (blast) itu gimana cara pakainya?', 
    'a' => 'Tinggal rapihin daftar nama tamu di dashboard, lalu kamu bisa sebarin pesan berisi link unik tersebut ke banyak nomor WhatsApp sekaligus tanpa perlu ketik manual satu per satu.'
],
[
    'q' => 'Ada fitur RSVP sama buku tamu buat titip ucapan?', 
    'a' => 'Pasti ada! Tamu kamu bisa langsung konfirmasi dateng atau enggak (RSVP) plus nulis ucapan manis dan doa restu secara real-time di halaman undangan kamu.'
],
[
    'q' => 'Kalau bingung pas ngisi data atau aktifin paket, ada yang bantu gak?', 
    'a' => 'Santai aja, gak usah pusing! Tim support Rayakan Digital siap gercep bantu kamu via WhatsApp kalau nemu kendala pas lagi nyusun atau ngaktifin undangan.'
],
                        ] as $i => $item)
                        <div data-aos="fade-up" data-aos-delay="{{ ($i % 3 + 1) * 60 }}"
                            class="bg-white dark:bg-secondary-800 rounded-2xl border border-neutral-100 dark:border-secondary-700 overflow-hidden hover:border-primary-200 dark:hover:border-primary-800 transition-colors duration-200">
                            <details>
                                <summary class="flex items-center justify-between cursor-pointer list-none p-5 gap-4">
                                    <h3 class="font-semibold text-secondary-800 dark:text-neutral-200 text-sm leading-snug">
                                        {{ $item['q'] }}</h3>
                                    <div
                                        class="faq-arrow flex-shrink-0 w-7 h-7 rounded-full bg-neutral-100 dark:bg-secondary-700 flex items-center justify-center text-neutral-400">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </div>
                                </summary>
                                <div class="px-5 pb-5 border-t border-neutral-100 dark:border-secondary-700 pt-4">
                                    <p class="text-neutral-500 dark:text-neutral-400 text-sm leading-relaxed">
                                        {{ $item['a'] }}</p>
                                </div>
                            </details>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════
    FINAL CTA — Bold showcase section
    ═══════════════════════════════════════════════ --}}
    <section id="get-started" data-aos="fade-up" class="py-24 bg-secondary-900 text-white relative overflow-hidden">
        {{-- Glow --}}
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px]"
                style="background: radial-gradient(circle, rgba(255,122,0,0.15) 0%, transparent 70%);"></div>
        </div>

        {{-- Grid overlay --}}
        <div class="absolute inset-0 pointer-events-none"
            style="background-image: linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px); background-size: 64px 64px;">
        </div>

        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <p class="text-xs font-bold tracking-[0.2em] text-primary-400 uppercase mb-6">Mulai Sekarang</p>
            <h2 class="font-heading text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-bold leading-tight mb-8">
                Hari bahagia Anda,<br>
                <span class="text-primary-500">dimulai dari</span><br>
                <span class="text-neutral-400 text-3xl sm:text-4xl md:text-5xl lg:text-6xl">undangan yang berkesan.</span>
            </h2>
            <p class="text-neutral-400 text-lg max-w-lg mx-auto mb-12 leading-relaxed">
                Pilih desain yang Anda suka, ceritakan momen istimewa Anda, dan bagikan kabar bahagia kepada orang-orang tersayang.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('register') }}" id="final-cta-register"
                    class="group inline-flex items-center justify-center gap-2.5 px-6 sm:px-10 py-3.5 sm:py-4 bg-primary-500 hover:bg-primary-600 text-white font-bold rounded-2xl shadow-[0_8px_32px_-8px_rgba(255,122,0,0.6)] hover:shadow-[0_12px_40px_-8px_rgba(255,122,0,0.75)] transition-all duration-300 hover:-translate-y-0.5 text-sm sm:text-base w-full sm:w-auto">
                    <i class="fas fa-gem"></i>
                    Buat Undangan Gratis
                    <i
                        class="fas fa-arrow-right text-sm group-hover:translate-x-1 transition-transform duration-300"></i>
                </a>
                <a href="https://wa.me/62895349823366?text=Halo%2C%20saya%20ingin%20bertanya%20tentang%20layanan%20Rayakan%20Digital."
                    target="_blank" id="final-cta-wa"
                    class="inline-flex items-center justify-center gap-2.5 px-6 sm:px-10 py-3.5 sm:py-4 bg-white/8 border border-white/15 text-white font-semibold rounded-2xl hover:bg-white/15 hover:border-white/30 transition-all duration-300 text-sm sm:text-base w-full sm:w-auto">
                    <i class="fab fa-whatsapp text-green-400"></i>
                    Konsultasi Gratis
                </a>
            </div>
            <p class="mt-8 text-sm leading-relaxed text-neutral-300">Daftar undangan, dapat Wedding Planner gratis.<br>Tetap bisa digunakan meski masa aktif undangan berakhir.</p>
        </div>
    </section>

    <section id="reseller-affiliate" class="relative isolate overflow-hidden border-t border-neutral-200 bg-[#FAF8F5] py-16 dark:border-secondary-800 dark:bg-secondary-900 sm:py-20 lg:py-24">
        {{-- Subtle background decoration --}}
        <div class="pointer-events-none absolute -right-32 top-1/2 -translate-y-1/2 h-[28rem] w-[28rem] rounded-full bg-primary-200/30 blur-3xl dark:bg-primary-900/20" aria-hidden="true"></div>
        <div class="pointer-events-none absolute -left-20 bottom-0 h-72 w-72 rounded-full bg-amber-100/30 blur-3xl dark:bg-amber-900/10" aria-hidden="true"></div>

        <div class="relative mx-auto max-w-7xl px-6 sm:px-8 lg:px-12">
            <div class="grid items-center gap-10 lg:grid-cols-[1.15fr_0.85fr] lg:gap-16">
                {{-- Left: High-converting Copywriting --}}
                <div class="flex flex-col items-start gap-6" data-aos="fade-right">
                    {{-- Eyebrow --}}
                    <div class="inline-flex items-center gap-2.5 rounded-full border border-primary-200 bg-primary-50/80 px-3.5 py-1.5 text-[11px] font-bold uppercase tracking-wider text-primary-700 dark:border-primary-800/80 dark:bg-primary-900/30 dark:text-primary-400">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-primary-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-primary-600 dark:bg-primary-400"></span>
                        </span>
                        Peluang Tambahan Penghasilan
                    </div>

                    <h2 class="font-heading text-3xl font-bold leading-[1.15] text-secondary-900 dark:text-white sm:text-4xl lg:text-5xl">
                        Punya Klien atau Teman Menikah?<br>
                        <span class="text-primary-600 dark:text-primary-400">Rekomendasikan &amp; Raih Komisi.</span>
                    </h2>

                    <p class="max-w-xl text-base leading-7 text-neutral-600 dark:text-neutral-300">
                        Bergabung gratis sebagai Mitra Reseller &amp; Affiliate Rayakan Digital. Bagikan link referral atau kupon diskon eksklusif ke calon pengantin, dan terima komisi langsung ke rekening Anda setiap ada transaksi berhasil.
                    </p>

                    {{-- Audience chips: Who is this for --}}
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="text-xs font-semibold text-neutral-500 dark:text-neutral-400">Cocok untuk:</span>
                        <span class="rounded-lg bg-neutral-100 px-2.5 py-1 text-xs font-medium text-secondary-800 dark:bg-secondary-800 dark:text-neutral-200">Wedding Organizer</span>
                        <span class="rounded-lg bg-neutral-100 px-2.5 py-1 text-xs font-medium text-secondary-800 dark:bg-secondary-800 dark:text-neutral-200">MUA &amp; Fotografer</span>
                        <span class="rounded-lg bg-neutral-100 px-2.5 py-1 text-xs font-medium text-secondary-800 dark:bg-secondary-800 dark:text-neutral-200">MC &amp; Vendor</span>
                        <span class="rounded-lg bg-neutral-100 px-2.5 py-1 text-xs font-medium text-secondary-800 dark:bg-secondary-800 dark:text-neutral-200">Creator &amp; Umum</span>
                    </div>

                    {{-- Action buttons --}}
                    <div class="flex w-full flex-col gap-3 pt-2 sm:w-auto sm:flex-row sm:items-center">
                        <a href="{{ route('reseller-affiliate') }}" id="affiliate-cta-register"
                            class="inline-flex min-h-12 items-center justify-center gap-3 rounded-full bg-primary-600 px-8 py-3.5 text-sm font-bold text-white shadow-lg shadow-primary-500/25 transition hover:bg-primary-700 hover:shadow-primary-500/35 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-primary-500">
                            <span>Mulai Jadi Mitra Sekarang</span>
                            <i class="fa-solid fa-arrow-right text-xs" aria-hidden="true"></i>
                        </a>
                        <a href="{{ route('reseller-affiliate') }}#perhitungan-tier"
                            class="inline-flex min-h-12 items-center justify-center gap-2 rounded-full border border-neutral-300 px-6 py-3.5 text-sm font-semibold text-secondary-800 transition hover:border-primary-500 hover:bg-white hover:text-primary-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-primary-500 dark:border-secondary-700 dark:text-neutral-200 dark:hover:bg-secondary-800 dark:hover:text-primary-400">
                            <i class="fa-solid fa-calculator text-xs text-primary-500" aria-hidden="true"></i>
                            <span>Simulasi Penghasilan</span>
                        </a>
                    </div>

                    {{-- Trust inline list --}}
                    <div class="flex flex-wrap items-center gap-x-5 gap-y-2 text-xs text-neutral-500 dark:text-neutral-400">
                        <span class="flex items-center gap-1.5">
                            <i class="fa-solid fa-check text-emerald-500" aria-hidden="true"></i>
                            100% Gratis Daftar
                        </span>
                        <span class="flex items-center gap-1.5">
                            <i class="fa-solid fa-check text-emerald-500" aria-hidden="true"></i>
                            Pencairan Mulai Rp {{ number_format($affiliateSettings['minimum_payout'] ?? 50000, 0, ',', '.') }}
                        </span>
                        <span class="flex items-center gap-1.5">
                            <i class="fa-solid fa-check text-emerald-500" aria-hidden="true"></i>
                            Dashboard Pelaporan Otomatis
                        </span>
                    </div>
                </div>

                {{-- Right: High-Converting Card / Earnings Box --}}
                <div class="relative w-full" data-aos="fade-left">
                    <div class="absolute inset-0 rotate-1.5 rounded-3xl bg-gradient-to-br from-primary-400/20 to-primary-600/20 blur-sm dark:from-primary-900/30 dark:to-primary-700/20" aria-hidden="true"></div>

                    <div class="relative overflow-hidden rounded-3xl border border-neutral-200/90 bg-white p-6 shadow-xl shadow-secondary-900/5 dark:border-secondary-700 dark:bg-secondary-800 sm:p-8">
                        {{-- Card Header badge --}}
                        <div class="flex items-center justify-between border-b border-neutral-100 pb-5 dark:border-secondary-700">
                            <div class="flex items-center gap-3">
                                <div class="flex h-10 w-10 items-center justify-center rounded-2xl bg-primary-50 text-primary-600 dark:bg-primary-900/30 dark:text-primary-400">
                                    <i class="fa-solid fa-handshake text-base" aria-hidden="true"></i>
                                </div>
                                <div>
                                    <p class="text-xs font-bold uppercase tracking-wider text-neutral-500 dark:text-neutral-400">Program Mitra</p>
                                    <p class="text-sm font-extrabold text-secondary-900 dark:text-white">Rayakan Partners</p>
                                </div>
                            </div>
                            <span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2.5 py-1 text-[11px] font-bold text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400">
                                <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                Pendaftaran Aktif
                            </span>
                        </div>

                        {{-- Main Highlight: Commission --}}
                        <div class="py-6">
                            <p class="text-xs font-semibold uppercase tracking-wider text-neutral-500 dark:text-neutral-400">Komisi Penghasilan</p>
                            <div class="mt-1 flex items-baseline gap-2">
                                <span class="font-heading text-5xl sm:text-6xl font-extrabold text-primary-600 dark:text-primary-400">Hingga 30%+</span>
                            </div>
                            <p class="mt-2 text-xs leading-relaxed text-neutral-500 dark:text-neutral-400">
                                Dihitung langsung dari setiap transaksi pembelian undangan yang sukses via link atau kupon Anda.
                            </p>
                        </div>

                        {{-- Calculation Snapshot --}}
                        <div class="rounded-2xl bg-neutral-50 p-4 ring-1 ring-neutral-100 dark:bg-secondary-900/60 dark:ring-secondary-700/60">
                            <p class="text-[11px] font-bold uppercase tracking-wider text-neutral-600 dark:text-neutral-300">
                                <i class="fa-solid fa-coins text-amber-500 mr-1.5" aria-hidden="true"></i>
                                Ilustrasi Penghasilan Anda:
                            </p>
                            <div class="mt-3 space-y-2 text-xs">
                                <div class="flex items-center justify-between text-neutral-600 dark:text-neutral-300">
                                    <span>Rekomendasi 10 Undangan Gold</span>
                                    <span class="font-bold text-secondary-900 dark:text-white">Rp 198.000 – Rp 297.000</span>
                                </div>
                                <div class="flex items-center justify-between text-neutral-600 dark:text-neutral-300">
                                    <span>Rekomendasi 25 Undangan Gold</span>
                                    <span class="font-bold text-emerald-600 dark:text-emerald-400">Rp 495.000 – Rp 742.500</span>
                                </div>
                            </div>
                        </div>

                        {{-- 2 Mini Key Props --}}
                        <div class="mt-6 grid grid-cols-2 gap-3">
                            <div class="flex items-start gap-2.5 rounded-xl border border-neutral-100 bg-white p-3 dark:border-secondary-700/60 dark:bg-secondary-900/40">
                                <i class="fa-solid fa-ticket text-primary-500 mt-0.5 text-xs" aria-hidden="true"></i>
                                <div>
                                    <p class="text-[11px] font-bold text-secondary-900 dark:text-white">Kupon Diskon Klien</p>
                                    <p class="text-[10px] text-neutral-500 dark:text-neutral-400">Klien hemat, Anda dapat komisi</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-2.5 rounded-xl border border-neutral-100 bg-white p-3 dark:border-secondary-700/60 dark:bg-secondary-900/40">
                                <i class="fa-solid fa-wallet text-emerald-500 mt-0.5 text-xs" aria-hidden="true"></i>
                                <div>
                                    <p class="text-[11px] font-bold text-secondary-900 dark:text-white">Pencairan Mudah</p>
                                    <p class="text-[10px] text-neutral-500 dark:text-neutral-400">Transfer bank min. Rp {{ number_format($affiliateSettings['minimum_payout'] ?? 50000, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        </div>

                        {{-- Bottom CTA inside Card --}}
                        <div class="mt-6 pt-4 border-t border-neutral-100 dark:border-secondary-700">
                            <a href="{{ route('reseller-affiliate') }}"
                                class="flex w-full min-h-11 items-center justify-center gap-2 rounded-xl bg-secondary-900 px-5 py-3 text-xs font-bold text-white shadow transition hover:bg-secondary-800 dark:bg-primary-600 dark:hover:bg-primary-700">
                                <span>Pelajari Syarat &amp; Skema Lengkap</span>
                                <i class="fa-solid fa-arrow-right text-[10px]" aria-hidden="true"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- WhatsApp floating button --}}
    <button x-data="{ show: false }" x-init="setTimeout(() => show = true, 2000)" x-show="show"
        x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4"
        x-transition:enter-end="opacity-100 translate-y-0"
        onclick="window.open('https://wa.me/62895349823366?text=Halo%2C%20saya%20ingin%20bertanya%20tentang%20...', '_blank')"
        class="fixed bottom-6 right-6 z-50 flex items-center gap-2 px-4 py-3 rounded-2xl bg-green-500 text-white text-sm font-bold shadow-[0_8px_24px_-4px_rgba(34,197,94,0.5)] hover:bg-green-600 hover:shadow-[0_12px_32px_-4px_rgba(34,197,94,0.65)] transition-all duration-200 cursor-pointer">
        <i class="fab fa-whatsapp text-lg"></i>
        <span>Hubungi Kami</span>
    </button>

    <x-public-footer />

    <script src="{{ asset('js/landingpage.js') }}"></script>
    <script>
        document.querySelectorAll('.faq-item details').forEach(details => {
            const content = details.querySelector(':scope > div');
            if (!content) return;

            content.style.maxHeight = '0';

            details.addEventListener('toggle', () => {
                if (details.open) {
                    const open = details.querySelector(':scope > div');
                    if (open) open.style.maxHeight = open.scrollHeight + 'px';
                } else {
                    content.style.maxHeight = '0';
                }
            });
        });
    </script>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-3HKN9XXBZY"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag() { dataLayer.push(arguments); }
        gtag('js', new Date());

        gtag('config', 'G-3HKN9XXBZY');
    </script>
</body>

</html>

