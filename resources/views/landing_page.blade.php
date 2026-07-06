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

    <style>
        /* ── Grain overlay ── */
        .grain-bg::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.85' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.035'/%3E%3C/svg%3E");
            pointer-events: none;
            z-index: 0;
        }

        /* ── Changing text animation ── */
        .changing-texts {
            height: 1.15em;
            display: inline-block;
            vertical-align: bottom;
            overflow: hidden;
        }
        .changing-texts-track {
            display: block;
            animation: slide 9s ease-in-out infinite;
        }
        .changing-texts-track span {
            display: block;
            height: 1.15em;
            line-height: 1.15;
            white-space: nowrap;
        }
        @keyframes slide {
            0%,20%   { transform: translateY(0); }
            25%,45%  { transform: translateY(-25%); }
            50%,70%  { transform: translateY(-50%); }
            75%,95%  { transform: translateY(-75%); }
            100%     { transform: translateY(-75%); }
        }

        /* ── Orb glow ── */
        .orb-orange {
            background: radial-gradient(circle, rgba(255,122,0,0.22) 0%, transparent 70%);
        }
        .orb-warm {
            background: radial-gradient(circle, rgba(255,180,100,0.14) 0%, transparent 70%);
        }

        /* ── Marquee ── */
        @keyframes marquee {
            from { transform: translateX(0); }
            to   { transform: translateX(-50%); }
        }
        .marquee-track {
            display: flex;
            width: max-content;
            animation: marquee 28s linear infinite;
        }
        .marquee-track:hover { animation-play-state: paused; }

        /* ── Bounce slow ── */
        @keyframes bounce-slow {
            0%,100% { transform: translateY(0); }
            50%     { transform: translateY(-10px); }
        }
        .animate-bounce-slow { animation: bounce-slow 3s ease-in-out infinite; }
        .animation-delay-1000 { animation-delay: 1s; }

        /* ── Timeline ── */
        .timeline-line {
            position: absolute;
            left: 2rem;
            top: 0;
            bottom: 0;
            width: 2px;
            background: linear-gradient(to bottom, #FF7A00, #FFD0A3, transparent);
        }

        /* ── Feature chip ── */
        .feature-chip {
            transition: all 0.25s cubic-bezier(.4,0,.2,1);
        }
        .feature-chip:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 32px -8px rgba(255,122,0,0.2);
        }

        /* ── FAQ ── */
        .faq-item details[open] summary { color: #FF7A00; }
        .faq-item details[open] .faq-arrow { transform: rotate(180deg); }
        .faq-arrow { transition: transform 0.3s ease; }

        /* ── Pricing popular ring pulse ── */
        @keyframes ring-pulse {
            0%,100% { box-shadow: 0 0 0 0 rgba(255,122,0,0.3); }
            50%     { box-shadow: 0 0 0 8px rgba(255,122,0,0); }
        }
        .popular-pulse { animation: ring-pulse 2.5s ease-in-out infinite; }

        /* ── Dark scrollbar ── */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #FF7A00; border-radius: 3px; }

        @media (max-width:1024px) {
            .animate-bounce-slow { animation: none; }
        }
    </style>
</head>

<body class="font-sans antialiased bg-[#FDFCFA] dark:bg-secondary-900 text-gray-900 dark:text-neutral-100 overflow-x-hidden">
    <x-public-navbar />

    <div class="h-16"></div>

    {{-- ═══════════════════════════════════════════════
         HERO — Asymmetric editorial split
    ═══════════════════════════════════════════════ --}}
    <section class="relative min-h-[92vh] flex items-center overflow-hidden bg-[#FDFCFA] dark:bg-secondary-900 grain-bg">

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
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-primary-500 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-primary-600"></span>
                            </span>
                        </div>
                        <span class="text-xs font-bold tracking-[0.2em] text-primary-600 uppercase">Rayakan Digital</span>
                        <div class="h-px flex-1 bg-gradient-to-r from-primary-200 to-transparent max-w-[80px]"></div>
                    </div>

                    {{-- Main headline --}}
                    <h1 class="font-heading max-sm:text-4xl text-5xl sm:text-6xl lg:text-7xl font-bold leading-[1.05] text-secondary-900 dark:text-neutral-100 mb-6">
                        Cara Mudah<br>
                        Bikin<br>
                        <span class="changing-texts text-primary-500">
                            <span class="changing-texts-track">
                                <span>Undangan Digital</span>
                                <span>Buku Tamu</span>
                                <span>LIVE Streaming</span>
                                <span>Undangan Digital</span>
                            </span>
                        </span>
                    </h1>

                    <p class="text-lg text-neutral-500 dark:text-neutral-400 max-w-md leading-relaxed mb-10">
                        Undangan pernikahan online siap dalam <strong class="text-secondary-800 dark:text-neutral-200">5 menit</strong>.
                        Kirim otomatis via WhatsApp, check-in QR Code, lengkap dengan musik & galeri.
                    </p>

                    {{-- CTA row --}}
                    <div class="flex flex-col sm:flex-row gap-4 mb-12">
                        <a href="{{ route('register') }}" id="hero-cta-register"
                            class="group inline-flex items-center justify-center gap-2.5 px-8 py-4 bg-primary-500 hover:bg-primary-600 text-white text-sm font-bold rounded-2xl shadow-[0_8px_32px_-8px_rgba(255,122,0,0.5)] hover:shadow-[0_12px_40px_-8px_rgba(255,122,0,0.65)] transition-all duration-300 hover:-translate-y-0.5">
                            <i class="fas fa-gem"></i>
                            <span>Mulai Gratis Sekarang</span>
                            <i class="fas fa-arrow-right text-xs group-hover:translate-x-1 transition-transform duration-300"></i>
                        </a>
                        <a href="{{ route('themes.index') }}" id="hero-cta-themes"
                            class="inline-flex items-center justify-center gap-2.5 px-8 py-4 bg-white dark:bg-secondary-800 border border-neutral-200 dark:border-secondary-700 text-secondary-700 dark:text-neutral-300 text-sm font-semibold rounded-2xl hover:border-primary-300 hover:text-primary-600 transition-all duration-300 shadow-sm">
                            <i class="fas fa-palette text-primary-500"></i>
                            <span>Lihat Tema</span>
                        </a>
                    </div>

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
                <div data-aos="fade-left" data-aos-delay="150" class="relative flex items-center justify-center lg:justify-end">

                    {{-- Ring decoration --}}
                    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[420px] h-[420px] rounded-full border-2 border-primary-200/20 pointer-events-none"></div>
                    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[520px] h-[520px] rounded-full border border-primary-100/15 pointer-events-none"></div>

                    <div class="relative z-10 w-full max-w-sm lg:max-w-md">
                        {{-- Floating badge top --}}
                        <div class="absolute -top-4 -right-4 z-20 animate-bounce-slow">
                            <div class="bg-white dark:bg-secondary-800 rounded-2xl shadow-[0_8px_24px_rgba(0,0,0,0.12)] px-4 py-2.5 flex items-center gap-2 border border-neutral-100 dark:border-secondary-700">
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
                        <div class="rounded-3xl overflow-hidden shadow-[0_32px_80px_-16px_rgba(0,0,0,0.25)] hover:shadow-[0_40px_100px_-16px_rgba(255,122,0,0.2)] transition-shadow duration-500 ring-1 ring-black/5">
                            <img src="{{ asset('img/mockup.png') }}" alt="Rayakan Digital - Preview Undangan" class="w-full h-full object-cover">
                        </div>

                        {{-- Floating badge bottom --}}
                        <div class="absolute -bottom-4 -left-4 z-20 animate-bounce-slow animation-delay-1000">
                            <div class="bg-white dark:bg-secondary-800 rounded-2xl shadow-[0_8px_24px_rgba(0,0,0,0.12)] px-4 py-2.5 flex items-center gap-2 border border-neutral-100 dark:border-secondary-700">
                                <div class="w-7 h-7 rounded-full bg-green-100 flex items-center justify-center">
                                    <i class="fab fa-whatsapp text-green-600 text-sm"></i>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-secondary-800 dark:text-neutral-200">Kirim ke 100+ tamu</p>
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
                    <span class="px-8 flex items-center gap-2"><i class="fas fa-heart text-xs opacity-70"></i> Undangan Digital Premium</span>
                    <span class="px-8 flex items-center gap-2"><i class="fas fa-qrcode text-xs opacity-70"></i> QR Code Check-in</span>
                    <span class="px-8 flex items-center gap-2"><i class="fas fa-broadcast-tower text-xs opacity-70"></i> Live Streaming Pernikahan</span>
                    <span class="px-8 flex items-center gap-2"><i class="fab fa-whatsapp text-xs opacity-70"></i> WhatsApp Blast Otomatis</span>
                    <span class="px-8 flex items-center gap-2"><i class="fas fa-images text-xs opacity-70"></i> Galeri Foto & Video</span>
                    <span class="px-8 flex items-center gap-2"><i class="fas fa-gift text-xs opacity-70"></i> Digital Angpao / Gift</span>
                    <span class="px-8 flex items-center gap-2"><i class="fas fa-map-marker-alt text-xs opacity-70"></i> Peta Lokasi Terintegrasi</span>
                    <span class="px-8 flex items-center gap-2"><i class="fas fa-star text-xs opacity-70"></i> Rating 4.9 / 5</span>
                </div>
            @endforeach
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════
         SERVICES — Bento-style layout
    ═══════════════════════════════════════════════ --}}
    <section id="services" data-aos="fade-up" class="py-24 bg-[#FDFCFA] dark:bg-secondary-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Header --}}
            <div class="mb-16">
                <p class="text-xs font-bold tracking-[0.2em] text-primary-500 uppercase mb-3">Layanan Kami</p>
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
                    <h2 class="font-heading text-4xl md:text-5xl font-bold text-secondary-900 dark:text-neutral-100 leading-tight">
                        Satu Platform,<br>
                        <span class="text-primary-500">Semua Kebutuhan</span>
                    </h2>
                    <p class="text-neutral-500 dark:text-neutral-400 max-w-xs text-sm leading-relaxed">
                        Solusi digital terlengkap untuk setiap detail perayaan momen spesial Anda.
                    </p>
                </div>
            </div>

            {{-- Bento grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">

                {{-- Card 1: Undangan Web — large --}}
                <div data-aos="fade-up" data-aos-delay="100"
                    class="group relative lg:col-span-2 rounded-3xl overflow-hidden bg-gradient-to-br from-primary-50 to-[#FFF4EB] dark:from-secondary-800 dark:to-secondary-800 border border-primary-100/50 dark:border-secondary-700 p-8 hover:shadow-[0_20px_60px_-12px_rgba(255,122,0,0.2)] transition-all duration-500">
                    <div class="absolute -right-8 -bottom-8 w-48 h-48 bg-primary-500/10 rounded-full blur-2xl pointer-events-none group-hover:scale-150 transition-transform duration-700"></div>
                    <div class="relative z-10">
                        <div class="flex items-start justify-between mb-6">
                            <div class="w-14 h-14 rounded-2xl bg-primary-500 text-white flex items-center justify-center shadow-lg shadow-primary-200 group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-envelope-open-text text-xl"></i>
                            </div>
                            <span class="text-[80px] font-black text-primary-100 dark:text-primary-900/30 leading-none select-none">01</span>
                        </div>
                        <h3 class="text-2xl font-bold text-secondary-900 dark:text-neutral-100 mb-2">Undangan Web</h3>
                        <p class="text-neutral-500 dark:text-neutral-400 leading-relaxed mb-6 max-w-md">
                            Undangan digital eksklusif dengan desain responsif, musik latar, galeri foto, dan countdown otomatis. Siap dalam 5 menit.
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
                    <div class="absolute -right-6 -bottom-6 w-36 h-36 bg-emerald-400/10 rounded-full blur-2xl pointer-events-none group-hover:scale-150 transition-transform duration-700"></div>
                    <div class="relative z-10">
                        <div class="flex items-start justify-between mb-6">
                            <div class="w-14 h-14 rounded-2xl bg-emerald-500 text-white flex items-center justify-center shadow-lg shadow-emerald-200 group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-qrcode text-xl"></i>
                            </div>
                            <span class="text-[80px] font-black text-emerald-100 dark:text-emerald-900/20 leading-none select-none">02</span>
                        </div>
                        <h3 class="text-2xl font-bold text-secondary-900 dark:text-neutral-100 mb-2">Buku Tamu Digital</h3>
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
                    <div class="absolute -right-6 -bottom-6 w-36 h-36 bg-purple-400/10 rounded-full blur-2xl pointer-events-none group-hover:scale-150 transition-transform duration-700"></div>
                    <div class="relative z-10">
                        <div class="flex items-start justify-between mb-6">
                            <div class="w-14 h-14 rounded-2xl bg-purple-500 text-white flex items-center justify-center shadow-lg shadow-purple-200 group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-broadcast-tower text-xl"></i>
                            </div>
                            <span class="text-[80px] font-black text-purple-100 dark:text-purple-900/20 leading-none select-none">03</span>
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
         HOW IT WORKS — Vertical timeline
    ═══════════════════════════════════════════════ --}}
    <section id="how-it-works" data-aos="fade-up" class="py-24 bg-secondary-900 dark:bg-black/20 overflow-hidden relative">
        <div class="absolute inset-0 pointer-events-none"
            style="background-image: radial-gradient(circle at 80% 50%, rgba(255,122,0,0.06) 0%, transparent 60%);">
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-start">

                {{-- Left: Header sticky-ish --}}
                <div data-aos="fade-right" class="lg:sticky lg:top-24">
                    <p class="text-xs font-bold tracking-[0.2em] text-primary-500 uppercase mb-4">Workflow</p>
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
                <div class="relative pl-12" data-aos="fade-left" data-aos-delay="100">
                    <div class="timeline-line"></div>

                    {{-- Step 1 --}}
                    <div class="relative mb-10">
                        <div class="absolute -left-8 top-2 w-8 h-8 rounded-full bg-primary-500 flex items-center justify-center shadow-[0_0_0_4px_rgba(255,122,0,0.15)]">
                            <span class="text-white text-xs font-black">1</span>
                        </div>
                        <div class="bg-white/5 hover:bg-white/8 border border-white/8 hover:border-primary-500/30 rounded-2xl p-6 transition-all duration-300 group cursor-default">
                            <div class="flex items-start gap-4">
                                <div class="w-12 h-12 rounded-xl bg-primary-500/15 flex items-center justify-center flex-shrink-0 group-hover:bg-primary-500/25 transition-colors duration-300">
                                    <i class="fas fa-palette text-primary-400 text-lg"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-white mb-1.5">Pilih Tema Favorit</h3>
                                    <p class="text-neutral-400 text-sm leading-relaxed">Jelajahi katalog desain premium dan pratinjau langsung sebelum memilih.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Step 2 --}}
                    <div class="relative mb-10">
                        <div class="absolute -left-8 top-2 w-8 h-8 rounded-full bg-secondary-600 border border-white/15 flex items-center justify-center">
                            <span class="text-white text-xs font-black">2</span>
                        </div>
                        <div class="bg-white/5 hover:bg-white/8 border border-white/8 hover:border-white/20 rounded-2xl p-6 transition-all duration-300 group cursor-default">
                            <div class="flex items-start gap-4">
                                <div class="w-12 h-12 rounded-xl bg-blue-500/15 flex items-center justify-center flex-shrink-0 group-hover:bg-blue-500/25 transition-colors duration-300">
                                    <i class="fas fa-user-plus text-blue-400 text-lg"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-white mb-1.5">Daftar & Isi Data Acara</h3>
                                    <p class="text-neutral-400 text-sm leading-relaxed">Buat akun gratis, lalu isi info mempelai, jadwal, dan preferensi undangan.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Step 3 --}}
                    <div class="relative mb-10">
                        <div class="absolute -left-8 top-2 w-8 h-8 rounded-full bg-secondary-600 border border-white/15 flex items-center justify-center">
                            <span class="text-white text-xs font-black">3</span>
                        </div>
                        <div class="bg-white/5 hover:bg-white/8 border border-white/8 hover:border-amber-500/30 rounded-2xl p-6 transition-all duration-300 group cursor-default">
                            <div class="flex items-start gap-4">
                                <div class="w-12 h-12 rounded-xl bg-amber-500/15 flex items-center justify-center flex-shrink-0 group-hover:bg-amber-500/25 transition-colors duration-300">
                                    <i class="fas fa-rocket text-amber-400 text-lg"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-white mb-1.5">Aktivasi Paket</h3>
                                    <p class="text-neutral-400 text-sm leading-relaxed">Pilih paket sesuai kebutuhan, bayar via berbagai metode, fitur aktif seketika.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Step 4 --}}
                    <div class="relative">
                        <div class="absolute -left-8 top-2 w-8 h-8 rounded-full bg-emerald-500 flex items-center justify-center shadow-[0_0_0_4px_rgba(16,185,129,0.15)]">
                            <span class="text-white text-xs font-black">4</span>
                        </div>
                        <div class="bg-white/5 hover:bg-white/8 border border-white/8 hover:border-emerald-500/30 rounded-2xl p-6 transition-all duration-300 group cursor-default">
                            <div class="flex items-start gap-4">
                                <div class="w-12 h-12 rounded-xl bg-emerald-500/15 flex items-center justify-center flex-shrink-0 group-hover:bg-emerald-500/25 transition-colors duration-300">
                                    <i class="fas fa-share-alt text-emerald-400 text-lg"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-white mb-1.5">Sebar & Pantau RSVP</h3>
                                    <p class="text-neutral-400 text-sm leading-relaxed">Generate link personal per tamu, kirim via WhatsApp massal, pantau RSVP real-time.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Footer note --}}
                    <div class="mt-8 flex items-center gap-3 text-xs text-neutral-500">
                        <i class="fas fa-credit-card text-neutral-600"></i>
                        <span>Tidak perlu kartu kredit untuk mulai</span>
                        <span>·</span>
                        <i class="fas fa-times-circle text-neutral-600"></i>
                        <span>Batalkan kapan saja</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

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
                    <h2 class="font-heading text-4xl md:text-5xl font-bold text-secondary-900 dark:text-neutral-100 leading-tight">
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
                <button @click="$refs.scrollContainer.scrollLeft -= 320"
                    class="absolute left-0 top-1/2 -translate-y-1/2 z-10 hidden lg:flex items-center justify-center w-10 h-10 rounded-full bg-white dark:bg-secondary-800 border border-neutral-200 dark:border-secondary-700 text-neutral-600 dark:text-neutral-300 shadow-md hover:shadow-lg hover:border-primary-300 transition-all duration-200">
                    <i class="fas fa-chevron-left text-xs"></i>
                </button>
                <button @click="$refs.scrollContainer.scrollLeft += 320"
                    class="absolute right-0 top-1/2 -translate-y-1/2 z-10 hidden lg:flex items-center justify-center w-10 h-10 rounded-full bg-white dark:bg-secondary-800 border border-neutral-200 dark:border-secondary-700 text-neutral-600 dark:text-neutral-300 shadow-md hover:shadow-lg hover:border-primary-300 transition-all duration-200">
                    <i class="fas fa-chevron-right text-xs"></i>
                </button>

                <div x-ref="scrollContainer"
                    class="overflow-x-auto overflow-y-hidden pb-6 scroll-smooth"
                    style="scrollbar-width: thin; scrollbar-color: #FFD0A3 transparent; -webkit-overflow-scrolling: touch;">
                    <div class="flex gap-5" style="min-width: min-content;">
                        @forelse($themes as $theme)
                            <div x-show="filter === 'all' || filter === '{{ $theme->theme_category_id ?? '0' }}'"
                                x-transition:enter="transition ease-out duration-300"
                                x-transition:enter-start="opacity-0 scale-95"
                                x-transition:enter-end="opacity-100 scale-100"
                                style="width: 280px; flex-shrink: 0;">
                                <div class="group relative rounded-2xl overflow-hidden border border-neutral-100 dark:border-secondary-700 bg-white dark:bg-secondary-800 shadow-[0_4px_20px_rgba(0,0,0,0.06)] hover:shadow-[0_20px_60px_-12px_rgba(0,0,0,0.18)] hover:-translate-y-1.5 transition-all duration-400">

                                    {{-- Thumbnail --}}
                                    @if($theme->thumbnail_portrait)
                                        <img src="{{ Storage::url($theme->thumbnail_portrait) }}" alt="{{ $theme->name }}"
                                            class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 ease-out group-hover:scale-105">
                                    @endif

                                    <div class="relative z-10 flex flex-col">
                                        <div class="relative aspect-[3/4]">
                                            @if(!$theme->thumbnail_portrait)
                                                <div class="absolute inset-0 bg-gradient-to-br from-secondary-50 to-primary-50/30 flex items-center justify-center">
                                                    <div class="text-center">
                                                        <i class="fas fa-images text-3xl text-primary-300 mb-2"></i>
                                                        <span class="text-xs text-neutral-400 block">{{ $theme->name }}</span>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="absolute inset-0 bg-gradient-to-b from-black/20 to-transparent"></div>
                                            @endif

                                            {{-- Badges --}}
                                            <div class="absolute top-3 left-3 z-20">
                                                @if($theme->is_premium)
                                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-gradient-to-r from-amber-400 to-amber-500 text-white shadow-md">
                                                        <i class="fas fa-crown text-[9px]"></i> Premium
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-white/90 backdrop-blur-sm text-emerald-700 border border-emerald-200/50">
                                                        <i class="fas fa-gem text-[9px]"></i> Gratis
                                                    </span>
                                                @endif
                                            </div>
                                            @if($theme->rating)
                                                <div class="absolute top-3 right-3 z-20 inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-semibold bg-white/90 backdrop-blur-sm text-amber-700 border border-amber-200/50">
                                                    <i class="fas fa-star text-amber-400 text-[9px]"></i>
                                                    {{ $theme->rating }}
                                                </div>
                                            @endif

                                            {{-- Hover preview overlay --}}
                                            <div class="absolute inset-0 z-10 opacity-0 group-hover:opacity-100 transition-all duration-300 flex items-center justify-center"
                                                style="background: linear-gradient(to top, rgba(0,0,0,0.75) 0%, rgba(0,0,0,0.1) 50%, transparent 100%);">
                                                <a href="{{ route('theme.preview', str_replace('themes.', '', $theme->view_path)) }}"
                                                    target="_blank"
                                                    class="flex items-center gap-2 px-4 py-2.5 rounded-xl text-white text-xs font-semibold hover:scale-105 transition-transform duration-200"
                                                    style="background: rgba(255,255,255,0.15); backdrop-filter: blur(8px); border: 1px solid rgba(255,255,255,0.25);">
                                                    <i class="fas fa-eye text-xs"></i> Lihat Pratinjau
                                                </a>
                                            </div>
                                        </div>

                                        {{-- Accent line --}}
                                        <div class="h-0.5 bg-gradient-to-r from-primary-400 to-primary-600 scale-x-0 group-hover:scale-x-100 transition-transform duration-500 ease-out origin-left"></div>

                                        {{-- Card body --}}
                                        <div class="p-4 bg-white/80 dark:bg-secondary-800/80 backdrop-blur-xl">
                                            <h3 class="text-sm font-bold text-secondary-800 dark:text-neutral-200 group-hover:text-primary-600 transition-colors leading-snug mb-1.5">
                                                {{ $theme->name }}
                                            </h3>
                                            @if($theme->category)
                                                <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-primary-50 dark:bg-primary-900/30 text-primary-600 dark:text-primary-300 rounded text-[10px] font-medium mb-3">
                                                    <i class="fas fa-tag text-[8px]"></i>{{ $theme->category->name }}
                                                </span>
                                            @endif

                                            <div class="flex items-center gap-2">
                                                @auth
                                                    <a href="{{ route('dashboard.invitations.create', ['theme' => str_replace('themes.', '', $theme->view_path)]) }}"
                                                        class="flex-1 flex items-center justify-center gap-1.5 px-3 py-2 rounded-lg bg-primary-500 text-white text-xs font-bold hover:bg-primary-600 transition-colors duration-200">
                                                        <i class="fas fa-magic text-[10px]"></i> Gunakan
                                                    </a>
                                                @else
                                                    <a href="{{ route('register') }}"
                                                        class="flex-1 flex items-center justify-center gap-1.5 px-3 py-2 rounded-lg bg-primary-500 text-white text-xs font-bold hover:bg-primary-600 transition-colors duration-200">
                                                        <i class="fas fa-magic text-[10px]"></i> Gunakan
                                                    </a>
                                                @endauth
                                                <a href="{{ route('theme.preview', str_replace('themes.', '', $theme->view_path)) }}"
                                                    target="_blank"
                                                    class="flex items-center justify-center w-9 h-9 rounded-lg border border-neutral-200 dark:border-secondary-600 text-neutral-400 hover:border-primary-300 hover:text-primary-600 transition-all duration-200"
                                                    title="Pratinjau">
                                                    <i class="fas fa-eye text-xs"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
                        <i class="fas fa-arrow-right text-sm group-hover:translate-x-1 transition-transform duration-200"></i>
                    </a>
                </div>
            @endif
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════
         FEATURES — Staggered bento
    ═══════════════════════════════════════════════ --}}
    <section data-aos="fade-up" class="py-24 bg-[#F5F3EF] dark:bg-secondary-900/60">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Header --}}
            <div class="mb-16 text-center">
                <p class="text-xs font-bold tracking-[0.2em] text-primary-500 uppercase mb-3">Fitur Unggulan</p>
                <h2 class="font-heading text-4xl md:text-5xl font-bold text-secondary-900 dark:text-neutral-100 mb-4">
                    Semua Yang<br><span class="text-primary-500">Anda Butuhkan</span>
                </h2>
                <p class="text-neutral-500 dark:text-neutral-400 max-w-lg mx-auto text-sm">
                    Rayakan Digital hadir dengan fitur lengkap — dari manajemen tamu hingga analitik real-time.
                </p>
            </div>

            {{-- Feature chips grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">

                @php
                $features = [
                    ['icon' => 'fa-calendar-check', 'color' => 'primary', 'title' => 'Manajemen RSVP', 'desc' => 'Ketahui siapa saja yang hadir. Sistem RSVP terintegrasi dashboard dengan notifikasi real-time.', 'tag' => 'Real-time tracking'],
                    ['icon' => 'fa-link', 'color' => 'emerald', 'title' => 'Link Personal Tamu', 'desc' => 'Sapa tamu dengan nama. Link khusus setiap tamu lengkap dengan template WhatsApp otomatis.', 'tag' => 'Personalized greeting'],
                    ['icon' => 'fa-gift', 'color' => 'amber', 'title' => 'Digital Gift (Angpao)', 'desc' => 'Transfer bank, QRIS, atau e-wallet. Tamu bisa kirim hadiah dari mana saja.', 'tag' => 'Multi payment'],
                    ['icon' => 'fa-book-open', 'color' => 'purple', 'title' => 'Buku Tamu Interaktif', 'desc' => 'Ucapan dan doa real-time di halaman undangan, dilengkapi emoji dan stiker.', 'tag' => 'Real-time messages'],
                    ['icon' => 'fa-images', 'color' => 'rose', 'title' => 'Galeri Foto & Video', 'desc' => 'Unggah foto kenangan. Tamu juga bisa kirim foto mereka ke galeri bersama.', 'tag' => 'Unlimited uploads*'],
                    ['icon' => 'fa-hourglass-half', 'color' => 'blue', 'title' => 'Countdown Timer', 'desc' => 'Hitung mundur menuju hari H. Buat tamu semakin antusias dan tidak lupa tanggal.', 'tag' => 'Auto countdown'],
                    ['icon' => 'fa-map-marker-alt', 'color' => 'indigo', 'title' => 'Peta Lokasi', 'desc' => 'Google Maps langsung di undangan. Tamu buka navigasi dengan satu klik.', 'tag' => 'Google Maps'],
                    ['icon' => 'fa-whatsapp fab', 'color' => 'green', 'title' => 'Broadcast WhatsApp', 'desc' => 'Kirim pengingat otomatis ke semua tamu. Template pesan siap pakai dan bisa diedit.', 'tag' => 'Auto reminder'],
                    ['icon' => 'fa-chart-line', 'color' => 'slate', 'title' => 'Analytics & Insight', 'desc' => 'Pantau pengunjung, RSVP, dan interaksi tamu. Data real-time di dashboard lengkap.', 'tag' => 'Real-time analytics'],
                ];
                $colorMap = [
                    'primary' => ['bg' => 'bg-primary-500', 'light' => 'bg-primary-50 dark:bg-primary-900/20', 'text' => 'text-primary-500', 'tag' => 'bg-primary-100 text-primary-700 dark:bg-primary-900/30 dark:text-primary-300'],
                    'emerald' => ['bg' => 'bg-emerald-500', 'light' => 'bg-emerald-50 dark:bg-emerald-900/20', 'text' => 'text-emerald-500', 'tag' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300'],
                    'amber'   => ['bg' => 'bg-amber-500', 'light' => 'bg-amber-50 dark:bg-amber-900/20', 'text' => 'text-amber-500', 'tag' => 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-300'],
                    'purple'  => ['bg' => 'bg-purple-500', 'light' => 'bg-purple-50 dark:bg-purple-900/20', 'text' => 'text-purple-500', 'tag' => 'bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-300'],
                    'rose'    => ['bg' => 'bg-rose-500', 'light' => 'bg-rose-50 dark:bg-rose-900/20', 'text' => 'text-rose-500', 'tag' => 'bg-rose-100 text-rose-700 dark:bg-rose-900/30 dark:text-rose-300'],
                    'blue'    => ['bg' => 'bg-blue-500', 'light' => 'bg-blue-50 dark:bg-blue-900/20', 'text' => 'text-blue-500', 'tag' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300'],
                    'indigo'  => ['bg' => 'bg-indigo-500', 'light' => 'bg-indigo-50 dark:bg-indigo-900/20', 'text' => 'text-indigo-500', 'tag' => 'bg-indigo-100 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-300'],
                    'green'   => ['bg' => 'bg-green-500', 'light' => 'bg-green-50 dark:bg-green-900/20', 'text' => 'text-green-500', 'tag' => 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-300'],
                    'slate'   => ['bg' => 'bg-slate-500', 'light' => 'bg-slate-50 dark:bg-slate-900/20', 'text' => 'text-slate-500', 'tag' => 'bg-slate-100 text-slate-700 dark:bg-slate-900/30 dark:text-slate-300'],
                ];
                @endphp

                @foreach($features as $i => $feat)
                    @php $c = $colorMap[$feat['color']]; $delay = ($i % 3 + 1) * 100; @endphp
                    <div data-aos="fade-up" data-aos-delay="{{ $delay }}"
                        class="feature-chip group bg-white dark:bg-secondary-800 rounded-2xl p-6 border border-neutral-100/70 dark:border-secondary-700 shadow-[0_2px_12px_rgba(0,0,0,0.04)]">
                        <div class="flex items-start gap-4">
                            <div class="flex-shrink-0 w-11 h-11 rounded-xl {{ $c['light'] }} flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                <i class="{{ str_contains($feat['icon'], 'fab') ? 'fab ' . str_replace(' fab', '', $feat['icon']) : 'fas ' . $feat['icon'] }} {{ $c['text'] }}"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="font-bold text-secondary-800 dark:text-neutral-200 mb-1 text-sm">{{ $feat['title'] }}</h3>
                                <p class="text-neutral-500 dark:text-neutral-400 text-xs leading-relaxed mb-3">{{ $feat['desc'] }}</p>
                                <span class="inline-block px-2 py-0.5 rounded text-[10px] font-bold {{ $c['tag'] }}">{{ $feat['tag'] }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <p class="text-center text-xs text-neutral-400 mt-8">*Fitur tersedia sesuai paket yang dipilih</p>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════
         PRICING & SERVICES — Tab with bold pricing
    ═══════════════════════════════════════════════ --}}
    <section x-data="{ activeTab: 'undangan' }" data-aos="fade-up"
        class="py-24 bg-[#FDFCFA] dark:bg-secondary-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Header --}}
            <div class="mb-14 text-center">
                <p class="text-xs font-bold tracking-[0.2em] text-primary-500 uppercase mb-3">Layanan & Harga</p>
                <h2 class="font-heading text-4xl md:text-5xl font-bold text-secondary-900 dark:text-neutral-100 mb-4">
                    Semua Kebutuhan<br><span class="text-primary-500">Pernikahan Anda</span>
                </h2>
                <p class="text-neutral-500 dark:text-neutral-400 max-w-md mx-auto text-sm">
                    Undangan digital, buku tamu, hingga siaran langsung — semuanya dalam satu platform.
                </p>
            </div>

            {{-- Tab navigation --}}
            <div class="flex justify-center mb-12">
                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-1 p-1.5 bg-neutral-100 dark:bg-secondary-800 rounded-2xl sm:rounded-2xl border border-neutral-200/50 dark:border-secondary-700">
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
            <div x-show="activeTab === 'undangan'"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-2"
                x-transition:enter-end="opacity-100 translate-y-0">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                    @forelse($packages as $package)
                        <div class="group relative bg-white dark:bg-secondary-800 rounded-3xl transition-all duration-300
                            {{ $package->is_popular
                                ? 'border-2 border-primary-500 shadow-[0_8px_32px_-8px_rgba(255,122,0,0.25)] popular-pulse'
                                : 'border border-neutral-200 dark:border-secondary-700 hover:border-primary-200 hover:shadow-xl' }}">

                            @if($package->is_popular)
                                <div class="absolute -top-3.5 left-0 right-0 flex justify-center">
                                    <span class="inline-flex items-center gap-1.5 bg-primary-500 px-4 py-1.5 rounded-full text-xs font-bold text-white shadow-md">
                                        <i class="fas fa-star text-[9px]"></i> Best Seller
                                    </span>
                                </div>
                            @endif

                            <div class="p-6 pt-{{ $package->is_popular ? '8' : '6' }}">
                                <h3 class="font-bold text-lg {{ $package->is_popular ? 'text-primary-600 dark:text-primary-400' : 'text-secondary-800 dark:text-neutral-100' }} mb-1">
                                    {{ $package->package_name }}
                                </h3>
                                @if($package->description)
                                    <p class="text-xs text-neutral-400 mb-5">{{ $package->description }}</p>
                                @endif

                                {{-- Price --}}
                                <div class="mb-6">
                                    @if($package->slashed_price && $package->slashed_price > $package->price)
                                        <span class="text-neutral-400 line-through text-xs">Rp {{ number_format($package->slashed_price, 0, ',', '.') }}</span>
                                    @endif
                                    <div class="flex items-baseline gap-1 mt-0.5">
                                        <span class="text-lg font-bold text-secondary-900 dark:text-neutral-100">Rp</span>
                                        <span class="text-4xl font-extrabold text-secondary-900 dark:text-neutral-100">{{ number_format($package->price, 0, ',', '.') }}</span>
                                    </div>
                                    @if($package->price > 0)
                                        <span class="text-xs text-neutral-400">/ {{ $package->active_period_days === 0 ? 'Lifetime' : $package->active_period_days . ' Hari' }}</span>
                                    @endif
                                </div>

                                {{-- CTA --}}
                                @auth
                                    @if($package->package_code === 'free')
                                        <div class="w-full bg-neutral-100 dark:bg-secondary-700 text-neutral-500 rounded-xl py-3 text-xs font-bold text-center">
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
                                <p class="text-[10px] font-bold text-neutral-400 uppercase tracking-widest mb-3">Fitur Termasuk</p>
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
            <div x-show="activeTab === 'buku-tamu'"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-2"
                x-transition:enter-end="opacity-100 translate-y-0">
                <div class="max-w-3xl mx-auto">
                    <div class="text-center mb-10">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-emerald-50 dark:bg-emerald-900/20 mb-4">
                            <i class="fas fa-book-open text-3xl text-emerald-500"></i>
                        </div>
                        <h3 class="font-heading text-3xl font-bold text-secondary-900 dark:text-neutral-100 mb-2">Buku Tamu Digital</h3>
                        <p class="text-neutral-500 dark:text-neutral-400">Catat kehadiran tamu secara modern. Scan QR, isi nama, tinggalkan ucapan — semua tersimpan otomatis.</p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-10">
                        @foreach([
                            ['icon'=>'fa-qrcode','color'=>'emerald','title'=>'QR Code Tamu','desc'=>'Scan dari ponsel, tanpa download aplikasi'],
                            ['icon'=>'fa-comment-dots','color'=>'emerald','title'=>'Ucapan & Doa','desc'=>'Kumpulkan pesan dari seluruh tamu undangan'],
                            ['icon'=>'fa-file-excel','color'=>'emerald','title'=>'Ekspor Data','desc'=>'Unduh data kehadiran format Excel/CSV'],
                            ['icon'=>'fa-chart-bar','color'=>'emerald','title'=>'Rekap Real-time','desc'=>'Pantau kehadiran langsung dari dashboard'],
                        ] as $feat)
                            <div class="flex items-start gap-3 bg-white dark:bg-secondary-800 rounded-2xl p-4 border border-neutral-100 dark:border-secondary-700 shadow-sm">
                                <div class="w-10 h-10 rounded-xl bg-emerald-50 dark:bg-emerald-900/20 flex items-center justify-center flex-shrink-0">
                                    <i class="fas {{ $feat['icon'] }} text-emerald-500"></i>
                                </div>
                                <div>
                                    <p class="font-semibold text-secondary-800 dark:text-neutral-200 text-sm">{{ $feat['title'] }}</p>
                                    <p class="text-xs text-neutral-400 mt-0.5">{{ $feat['desc'] }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="bg-gradient-to-br from-emerald-50 to-teal-50 dark:from-secondary-800 dark:to-secondary-800 border border-emerald-100 dark:border-emerald-900/30 rounded-2xl p-8 text-center">
                        <p class="font-semibold text-secondary-800 dark:text-neutral-200 mb-1">Tertarik dengan layanan ini?</p>
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
            <div x-show="activeTab === 'live-streaming'"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-2"
                x-transition:enter-end="opacity-100 translate-y-0">
                <div class="max-w-3xl mx-auto">
                    <div class="text-center mb-10">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-primary-50 dark:bg-primary-900/20 mb-4">
                            <i class="fas fa-video text-3xl text-primary-500"></i>
                        </div>
                        <h3 class="font-heading text-3xl font-bold text-secondary-900 dark:text-neutral-100 mb-2">Live Streaming Pernikahan</h3>
                        <p class="text-neutral-500 dark:text-neutral-400">Siarkan momen spesial kepada keluarga di seluruh penjuru dunia — tanpa harus hadir secara fisik.</p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-10">
                        @foreach([
                            ['icon'=>'fa-film','title'=>'HD Streaming','desc'=>'Kualitas video jernih hingga Full HD'],
                            ['icon'=>'fa-lock','title'=>'Link Privat','desc'=>'Hanya tamu undangan yang bisa menonton'],
                            ['icon'=>'fa-cloud-download-alt','title'=>'Rekaman Video','desc'=>'Siaran direkam dan tersedia untuk diunduh'],
                            ['icon'=>'fa-users','title'=>'Unlimited Penonton','desc'=>'Tidak ada batasan jumlah penonton'],
                        ] as $feat)
                            <div class="flex items-start gap-3 bg-white dark:bg-secondary-800 rounded-2xl p-4 border border-neutral-100 dark:border-secondary-700 shadow-sm">
                                <div class="w-10 h-10 rounded-xl bg-primary-50 dark:bg-primary-900/20 flex items-center justify-center flex-shrink-0">
                                    <i class="fas {{ $feat['icon'] }} text-primary-500"></i>
                                </div>
                                <div>
                                    <p class="font-semibold text-secondary-800 dark:text-neutral-200 text-sm">{{ $feat['title'] }}</p>
                                    <p class="text-xs text-neutral-400 mt-0.5">{{ $feat['desc'] }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="bg-gradient-to-br from-primary-50 to-secondary-50 dark:from-secondary-800 dark:to-secondary-800 border border-primary-100 dark:border-primary-900/30 rounded-2xl p-8 text-center">
                        <p class="font-semibold text-secondary-800 dark:text-neutral-200 mb-1">Tertarik dengan layanan ini?</p>
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
         FAQ — Split layout
    ═══════════════════════════════════════════════ --}}
    <section data-aos="fade-up" class="py-24 bg-[#F5F3EF] dark:bg-secondary-900/60">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-16">

                {{-- Left: Header --}}
                <div class="lg:col-span-4 lg:sticky lg:top-24 self-start">
                    <p class="text-xs font-bold tracking-[0.2em] text-primary-500 uppercase mb-4">FAQ</p>
                    <h2 class="font-heading text-4xl font-bold text-secondary-900 dark:text-neutral-100 leading-tight mb-6">
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
                        ['q'=>'Bagaimana cara membuat undangan digital?', 'a'=>'Setelah melakukan pemesanan, Anda mendapatkan akses dashboard untuk mengisi data acara, foto, galeri, lokasi, dan informasi lainnya secara mandiri — tanpa perlu menunggu admin.'],
                        ['q'=>'Apakah data undangan bisa diubah setelah dibuat?', 'a'=>'Ya. Nama mempelai, jadwal acara, foto, galeri, lokasi, dan informasi lainnya dapat diubah kapan saja melalui dashboard selama masa aktif undangan.'],
                        ['q'=>'Apakah tersedia nama tamu otomatis?', 'a'=>'Tentu. Anda dapat membuat link khusus untuk setiap tamu sehingga nama tamu akan tampil otomatis saat undangan dibuka — terasa lebih personal.'],
                        ['q'=>'Apakah undangan bisa dibagikan ke WhatsApp?', 'a'=>'Ya. Link undangan dapat dibagikan melalui WhatsApp, Instagram, Telegram, Facebook, email, maupun media sosial lainnya.'],
                        ['q'=>'Apakah tersedia RSVP dan buku tamu?', 'a'=>'Ya. Tamu dapat mengisi konfirmasi kehadiran (RSVP) serta memberikan ucapan dan doa langsung melalui halaman undangan.'],
                        ['q'=>'Apakah saya akan mendapatkan bantuan jika mengalami kesulitan?', 'a'=>'Tentu. Tim support kami siap membantu melalui WhatsApp jika Anda mengalami kendala saat membuat atau mengelola undangan.'],
                    ] as $i => $item)
                        <div data-aos="fade-up" data-aos-delay="{{ ($i % 3 + 1) * 60 }}"
                            class="bg-white dark:bg-secondary-800 rounded-2xl border border-neutral-100 dark:border-secondary-700 overflow-hidden hover:border-primary-200 dark:hover:border-primary-800 transition-colors duration-200">
                            <details>
                                <summary class="flex items-center justify-between cursor-pointer list-none p-5 gap-4">
                                    <h3 class="font-semibold text-secondary-800 dark:text-neutral-200 text-sm leading-snug">{{ $item['q'] }}</h3>
                                    <div class="faq-arrow flex-shrink-0 w-7 h-7 rounded-full bg-neutral-100 dark:bg-secondary-700 flex items-center justify-center text-neutral-400">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    </div>
                                </summary>
                                <div class="px-5 pb-5 border-t border-neutral-100 dark:border-secondary-700 pt-4">
                                    <p class="text-neutral-500 dark:text-neutral-400 text-sm leading-relaxed">{{ $item['a'] }}</p>
                                </div>
                            </details>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════
         FINAL CTA — Bold dark section
    ═══════════════════════════════════════════════ --}}
    <section data-aos="fade-up" class="relative py-28 bg-secondary-900 overflow-hidden">
        {{-- Glow --}}
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px]"
                style="background: radial-gradient(circle, rgba(255,122,0,0.12) 0%, transparent 70%);"></div>
        </div>

        {{-- Grid overlay --}}
        <div class="absolute inset-0 pointer-events-none"
            style="background-image: linear-gradient(rgba(255,255,255,0.02) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,0.02) 1px, transparent 1px); background-size: 64px 64px;">
        </div>

        <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p class="text-xs font-bold tracking-[0.2em] text-primary-500 uppercase mb-6">Mulai Sekarang</p>
            <h2 class="font-heading text-5xl md:text-6xl lg:text-7xl font-bold text-white leading-tight mb-8">
                Rayakan momen<br>
                <span class="text-primary-500">terbaik hidupmu</span><br>
                <span class="text-neutral-500 text-4xl md:text-5xl lg:text-6xl">dengan cara yang berbeda.</span>
            </h2>
            <p class="text-neutral-400 text-lg max-w-lg mx-auto mb-12 leading-relaxed">
                Bergabunglah dan buat undangan digital yang memorable — tidak perlu keahlian, tidak perlu waktu lama.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('register') }}" id="final-cta-register"
                    class="group inline-flex items-center justify-center gap-2.5 px-10 py-4.5 bg-primary-500 hover:bg-primary-600 text-white font-bold rounded-2xl shadow-[0_8px_32px_-8px_rgba(255,122,0,0.6)] hover:shadow-[0_12px_40px_-8px_rgba(255,122,0,0.75)] transition-all duration-300 hover:-translate-y-0.5 text-base">
                    <i class="fas fa-gem"></i>
                    Buat Undangan Gratis
                    <i class="fas fa-arrow-right text-sm group-hover:translate-x-1 transition-transform duration-300"></i>
                </a>
                <a href="https://wa.me/62895349823366?text=Halo%2C%20saya%20ingin%20bertanya%20tentang%20layanan%20Rayakan%20Digital."
                    target="_blank" id="final-cta-wa"
                    class="inline-flex items-center justify-center gap-2.5 px-10 py-4.5 bg-white/8 border border-white/15 text-white font-semibold rounded-2xl hover:bg-white/15 hover:border-white/30 transition-all duration-300 text-base">
                    <i class="fab fa-whatsapp text-green-400"></i>
                    Konsultasi Gratis
                </a>
            </div>
            <p class="mt-8 text-xs text-neutral-600">Tidak perlu kartu kredit &nbsp;·&nbsp; Batalkan kapan saja &nbsp;·&nbsp; Support via WhatsApp</p>
        </div>
    </section>

    {{-- WhatsApp floating button --}}
    <button x-data="{ show: false }" x-init="setTimeout(() => show = true, 2000)"
        x-show="show"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4"
        x-transition:enter-end="opacity-100 translate-y-0"
        onclick="window.open('https://wa.me/62895349823366?text=Halo%2C%20saya%20ingin%20bertanya%20tentang%20...', '_blank')"
        class="fixed bottom-6 right-6 z-50 flex items-center gap-2 px-4 py-3 rounded-2xl bg-green-500 text-white text-sm font-bold shadow-[0_8px_24px_-4px_rgba(34,197,94,0.5)] hover:bg-green-600 hover:shadow-[0_12px_32px_-4px_rgba(34,197,94,0.65)] transition-all duration-200 cursor-pointer">
        <i class="fab fa-whatsapp text-lg"></i>
        <span>Hubungi Kami</span>
    </button>

    <x-public-footer />

    <script src="{{ asset('js/landingpage.js') }}"></script>
</body>

</html>