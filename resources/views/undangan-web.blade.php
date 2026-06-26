<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <x-meta title="Undangan Web - Rayakan Digital"
        description="Buat undangan pernikahan online dalam 5 menit. Praktis, elegan, lengkap dengan fitur kirim otomatis via WhatsApp, galeri foto, musik latar, dan Check-in QR Code."
        keywords="undangan web, undangan online, undangan pernikahan digital, buat undangan online, undangan interaktif" />

    @stack('meta')

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    <link rel="stylesheet" href="{{ asset('css/landingpage.css') }}">
    <script>
        if (localStorage.getItem('dark-mode') === 'true' || (!('dark-mode' in localStorage) && window.matchMedia(
            '(prefers-color-scheme: dark)').matches)) {
        document.documentElement.classList.add('dark');
    } else {
        document.documentElement.classList.remove('dark');
    }
    </script>
</head>

<body class="font-sans antialiased bg-neutral-50 dark:bg-secondary-900 text-secondary-800 dark:text-neutral-200">
    <x-public-navbar />
    <div class="h-16"></div>

    <!-- =========== HERO =========== -->
    <section
        class="relative overflow-hidden bg-gradient-to-br from-white via-primary-50/30 to-secondary-50 dark:from-secondary-900 dark:via-secondary-900 dark:to-secondary-900 pt-28 pb-16"
        id="layanan">
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute inset-0 bg-gradient-to-tr from-primary-500/[0.03] to-transparent"></div>
            <div class="absolute inset-0"
                style="background-image: radial-gradient(circle, #94a3b8 1px, transparent 1px); background-size: 32px 32px; opacity: 0.12;">
            </div>
        </div>
        <div class="absolute -bottom-20 -left-20 w-96 h-96 bg-secondary-200/20 rounded-full blur-3xl dark:bg-secondary-800/20">
        </div>
        <div
            class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] bg-primary-100/10 rounded-full blur-3xl">
        </div>
        </div>
        <div class="relative max-w-6xl mx-auto px-6 grid md:grid-cols-2 gap-12 items-center">
            <div>
                <span
                    class="fade-up inline-flex items-center gap-2 bg-primary-100 border border-primary-200 text-primary-700 text-xs font-semibold px-3 py-1.5 rounded-full mb-5">
                    <i class="fa-solid fa-star text-primary-500 text-[10px]"></i>
                    Undangan Digital Modern #1
                </span>
                <h1
                    class="fade-up delay-1 font-heading text-[2.6rem] md:text-5xl font-bold leading-tight text-secondary-900 dark:text-neutral-100 mb-3">
                    Rayakan Momen<br>Berharga Dengan<br>
                    <span class="text-primary-500">Sentuhan Digital.</span>
                </h1>
                <p class="fade-up delay-2 text-neutral-500 text-[15px] leading-relaxed max-w-sm mb-8">
                    Buat undangan pernikahan, ulang tahun, atau acara korporat dalam hitungan menit. Elegan, interaktif,
                    dan mudah dibagikan.
                </p>
                <div class="fade-up delay-3 flex items-center gap-3">
                    <a href="{{ route('register') }}"
                        class="inline-flex items-center gap-2 bg-primary-500 hover:bg-primary-600 text-white font-semibold px-6 py-3 rounded-full transition shadow-soft">
                        Buat Sekarang <i class="fa-solid fa-arrow-right text-sm"></i>
                    </a>
                </div>
            </div>
            <div class="relative flex justify-center fade-up delay-4">
                <div class="relative w-56 md:w-64 mx-auto">
                    <div class="bg-[#1c1c1e] rounded-[2.5rem] p-2 shadow-2xl">
                        <div class="bg-[#2d1b0e] rounded-[2rem] overflow-hidden relative" style="aspect-ratio:9/19">
                            <div class="absolute top-3 left-1/2 -translate-x-1/2 w-16 h-3 bg-black/70 rounded-full z-10">
                            </div>
                            <div class="w-full h-full flex flex-col items-center justify-center bg-gradient-to-b from-[#3d2010] to-[#7a4020]">
                                <div class="mt-8 text-center px-4">
                                    <p class="font-heading text-white/60 text-xs tracking-widest uppercase mb-1">The
                                        Wedding of</p>
                                    <h2 class="font-heading text-white text-xl font-bold leading-snug">Aditya
                                        &<br />Arini</h2>
                                    <p class="text-white/50 text-[10px] mt-2">Minggu, 14 Juli 2024</p>
                                    <div class="mt-4 w-10 h-0.5 bg-primary-500 mx-auto rounded"></div>
                                </div>
                                <div class="absolute top-10 right-4 w-16 h-16 rounded-full bg-primary-500/20 blur-xl">
                                </div>
                                <div class="absolute bottom-20 left-4 w-20 h-20 rounded-full bg-primary-500/10 blur-2xl">
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                    <div
                        class="absolute top-8 -right-4 md:right-0 bg-white dark:bg-secondary-800 shadow-soft rounded-2xl px-4 py-3 flex items-center gap-3 w-44">
                        <div class="w-8 h-8 bg-primary-500 rounded-full flex items-center justify-center flex-shrink-0">
                            <i class="fa-solid fa-music text-white text-xs"></i>
                        </div>
                        <div>
                            <p class="text-[10px] text-neutral-400 font-medium">Background Music</p>
                        <p class="text-xs text-secondary-800 dark:text-neutral-200 font-semibold truncate">Sandaran Hati
                        </p>
                    </div>
                </div>
            </div>
        </div>
        </section>
        
        <!-- =========== FITUR =========== -->
        <section class="py-20 bg-white dark:bg-secondary-800" id="fitur">
            <div class="max-w-6xl mx-auto px-6">
                <div class="text-center mb-12">
                <h2 class="font-heading text-3xl md:text-4xl font-bold text-secondary-900 dark:text-neutral-100 mb-3">
                    Fitur Interaktif Tanpa
                    Batas</h2>
                <p class="text-neutral-500 text-[15px] max-w-md mx-auto">Pengalaman yang lebih dari sekadar teks.
                    Hadirkan
                    emosi dan kemudahan dalam satu genggaman tamu Anda.</p>
            </div>
            <div class="grid md:grid-cols-2 gap-5">
                <div class="bg-neutral-50 dark:bg-secondary-800 rounded-3xl p-6 overflow-hidden relative shadow-soft">
                    <div class="w-10 h-10 bg-primary-100 rounded-xl flex items-center justify-center mb-4">
                        <i class="fa-regular fa-images text-primary-500 text-lg"></i>
                    </div>
                    <h3 class="font-semibold text-secondary-900 dark:text-neutral-100 text-lg mb-1">Galeri Foto & Video
                    </h3>
                    <p class="text-neutral-500 text-sm leading-relaxed max-w-xs">Bagikan momen pre-wedding terbaik Anda
                        dalam tampilan slideshow premium yang memukau.</p>
                    <div class="mt-5 grid grid-cols-4 gap-1.5 rounded-xl overflow-hidden">
                        <div class="col-span-2 row-span-2 bg-primary-200 rounded-xl h-24"
                            style="background: linear-gradient(135deg,#fed7aa,#fb923c)"></div>
                        <div class="bg-primary-100 rounded-xl h-11" style="background:linear-gradient(135deg,#fde68a,#fbbf24)"></div>
                        <div class="bg-primary-300 rounded-xl h-11" style="background:linear-gradient(135deg,#fca5a5,#f87171)"></div>
                        <div class="bg-primary-200 rounded-xl h-11" style="background:linear-gradient(135deg,#bbf7d0,#4ade80)"></div>
                        <div class="bg-primary-100 rounded-xl h-11" style="background:linear-gradient(135deg,#bfdbfe,#60a5fa)"></div>
                    </div>
                </div>
                <div class="bg-neutral-50 dark:bg-secondary-800 rounded-3xl p-6 relative overflow-hidden shadow-soft">
                    <div class="w-10 h-10 bg-primary-100 rounded-xl flex items-center justify-center mb-4">
                        <i class="fa-solid fa-location-dot text-primary-500 text-lg"></i>
                    </div>
                    <h3 class="font-semibold text-secondary-900 dark:text-neutral-100 text-lg mb-1">Navigasi Peta</h3>
                    <p class="text-neutral-500 text-sm leading-relaxed max-w-xs">Terintegrasi langsung dengan Google
                        Maps &
                        Waze untuk memudahkan tamu hadir tepat waktu.</p>
                    <div class="mt-5 w-full h-24 rounded-2xl overflow-hidden relative bg-blue-50">
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="w-full h-full" style="background:linear-gradient(135deg,#e0f2fe,#bae6fd); position:relative;">
                                <div class="absolute inset-0 opacity-30"
                                    style="background-image: repeating-linear-gradient(0deg,#93c5fd 0,#93c5fd 1px,transparent 1px,transparent 20px), repeating-linear-gradient(90deg,#93c5fd 0,#93c5fd 1px,transparent 1px,transparent 20px);">
                                </div>
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <div class="w-8 h-8 bg-primary-500 rounded-full flex items-center justify-center shadow-soft">
                                        <i class="fa-solid fa-location-dot text-white text-sm"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
                        </div>
                        <div class="bg-primary-500 rounded-3xl p-6 text-white shadow-soft">
                            <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center mb-4">
                                <i class="fa-solid fa-music text-white text-lg"></i>
                            </div>
                            <h3 class="font-semibold text-lg mb-1">Background Music</h3>
                            <p class="text-white/70 text-sm leading-relaxed">Auto-diputar, pilihan untuk suasana spesial.</p>
                            <div class="mt-5 flex items-end gap-1 h-10">
                                <div class="w-2 h-3 bg-white/30 rounded-full animate-bounce" style="animation-delay:0s"></div>
                                <div class="w-2 h-7 bg-white/50 rounded-full animate-bounce" style="animation-delay:0.1s"></div>
                                <div class="w-2 h-5 bg-white/40 rounded-full animate-bounce" style="animation-delay:0.2s"></div>
                                <div class="w-2 h-9 bg-white/60 rounded-full animate-bounce" style="animation-delay:0.15s">
                                </div>
                                <div class="w-2 h-4 bg-white/30 rounded-full animate-bounce" style="animation-delay:0.3s"></div>
                                <div class="w-2 h-7 bg-white/50 rounded-full animate-bounce" style="animation-delay:0.05s">
                                </div>
                                <div class="w-2 h-6 bg-white/40 rounded-full animate-bounce" style="animation-delay:0.25s">
                                </div>
                                <div class="w-2 h-10 bg-white/70 rounded-full animate-bounce" style="animation-delay:0.1s">
                                </div>
                            </div>
                        </div>
                        <div class="bg-neutral-50 dark:bg-secondary-800 rounded-3xl p-6 shadow-soft">
                            <div class="w-10 h-10 bg-primary-100 rounded-xl flex items-center justify-center mb-4">
                                <i class="fa-solid fa-envelope-open-text text-primary-500 text-lg"></i>
                            </div>
                            <h3 class="font-semibold text-secondary-900 dark:text-neutral-100 text-lg mb-1">RSVP & Ucapan</h3>
                            <p class="text-neutral-500 text-sm leading-relaxed">Manajemen tamu dan buku ucapan digital yang
                                rapi.
                            </p>
                            <div class="mt-5 space-y-2">
                        <div class="flex items-center gap-3 bg-white dark:bg-secondary-800 rounded-xl px-3 py-2 shadow-sm">
                            <div class="w-7 h-7 rounded-full bg-green-100 flex items-center justify-center">
                                <i class="fa-solid fa-check text-green-500 text-xs"></i>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-secondary-800 dark:text-neutral-200">Rina &
                                    Keluarga</p>
                                <p class="text-[10px] text-neutral-400">Hadir · 3 orang</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 bg-white dark:bg-secondary-800 rounded-xl px-3 py-2 shadow-sm">
                            <div class="w-7 h-7 rounded-full bg-primary-100 flex items-center justify-center">
                                <i class="fa-solid fa-clock text-primary-500 text-xs"></i>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-secondary-800 dark:text-neutral-200">Budi Santoso
                                </p>
                                <p class="text-[10px] text-neutral-400">Menunggu konfirmasi</p>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
                </div>
                </section>
                
                <!-- =========== HARGA =========== -->
                <section class="py-20 bg-neutral-50 dark:bg-secondary-900" id="harga">
                    <div class="max-w-6xl mx-auto px-6">
                        <div class="mb-10">
                <h2 class="font-heading text-3xl md:text-4xl font-bold text-secondary-900 dark:text-neutral-100 mb-2">
                    Pilih Paket Sesuai
                    Kebutuhan</h2>
                <p class="text-neutral-500 text-sm max-w-sm">Semua paket mendapatkan domain kustom dan masa aktif
                    panjang.
                    Pilih yang terbaik untuk momen sekali seumur hidup Anda.</p>
            </div>


            <div class="mt-10 space-y-6 sm:space-y-0 sm:grid sm:grid-cols-2 lg:grid-cols-4 sm:gap-6">
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
                                        class="mt-6 flex items-center justify-center gap-2 w-full rounded-xl py-3 text-sm font-semibold text-center transition-all duration-200 {{ $package->is_popular ? 'bg-primary-500 text-white hover:bg-primary-600 shadow-md hover:shadow-lg' : 'bg-primary-50 dark:bg-secondary-800 border border-primary-200 dark:border-primary-800 text-primary-700 dark:text-primary-400 hover:bg-primary-100 dark:hover:bg-secondary-700' }}">
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
                                        class="mt-6 flex items-center justify-center gap-2 w-full rounded-xl py-3 text-sm font-semibold text-center transition-all duration-200 {{ $package->is_popular ? 'bg-primary-500 text-white hover:bg-primary-600 shadow-md hover:shadow-lg' : 'bg-primary-50 dark:bg-secondary-800 border border-primary-200 dark:border-primary-800 text-primary-700 dark:text-primary-400 hover:bg-primary-100 dark:hover:bg-secondary-700' }}">
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
                        <p class="text-lg font-medium text-secondary-800 dark:text-neutral-200">Belum ada paket tersedia</p>
                        <p class="text-neutral-500 mt-1">Silakan hubungi admin untuk informasi lebih lanjut.
                        </p>
                    </div>
                @endforelse
            </div>
        </div>
        </div>
    </section>

    <!-- =========== CTA =========== -->
    <section class="py-16 px-6">
        <div
            class="max-w-4xl mx-auto bg-gradient-to-br from-primary-600 to-primary-800 rounded-3xl p-10 md:p-14 text-center relative overflow-hidden">
            <div
                class="absolute top-0 left-0 w-48 h-48 bg-white/10 rounded-full -translate-x-1/2 -translate-y-1/2 blur-2xl">
            </div>
            <div
                class="absolute bottom-0 right-0 w-64 h-64 bg-black/10 rounded-full translate-x-1/3 translate-y-1/3 blur-2xl">
            </div>
            <h2 class="font-heading text-3xl md:text-4xl font-bold text-white relative z-10 mb-3">
                Siap Membuat Undangan Anda?
            </h2>
            <p class="text-white/75 text-sm relative z-10 max-w-sm mx-auto mb-8">
                Hanya butuh 5 menit untuk membuat undangan digital pertama Anda. Gratis coba semua fitur di dashboard.
            </p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-3 relative z-10">
                <a href="{{ route('register') }}"
                    class="bg-white dark:bg-secondary-800 text-primary-500 font-semibold px-7 py-3 rounded-full hover:bg-primary-50 dark:hover:bg-secondary-700 transition shadow-md">
                    Buat Undangan Sekarang
                </a>
                <a href="https://wa.me/62895349823366?text=Halo%20Rayakan%20Digital%2C%20saya%20ingin%20konsultasi%20mengenai%20undangan%20digital."
                    class="border-2 border-white/50 text-white font-semibold px-7 py-3 rounded-full hover:bg-white/10 transition flex items-center gap-2">
                    <i class="fa-brands fa-whatsapp text-lg"></i> Konsultasi WhatsApp
                </a>
            </div>
        </div>
    </section>
    <x-public-footer />
</body>

</html>