<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <x-meta title="Live Streaming - Rayakan Digital"
        description="Siarkan momen pernikahan Anda dengan kualitas sinematik melalui berbagai platform. Hubungkan tamu yang tidak bisa hadir secara fisik dengan live streaming berkualitas tinggi."
        keywords="live streaming pernikahan, siaran pernikahan online, streaming acara, kamera pernikahan, multi platform streaming" />

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

<body class="font-sans antialiased bg-neutral-50 dark:bg-secondary-900 text-secondary-800 dark:text-neutral-200">
    <x-public-navbar />
    <div class="h-16"></div>

    <!-- ─── HERO ──────────────────────────────────────────── -->
    <section
        class="relative overflow-hidden bg-gradient-to-br from-white via-primary-50/30 to-secondary-50 dark:from-secondary-900 dark:via-secondary-900 dark:to-secondary-900 pt-16 pb-24">
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute inset-0 bg-gradient-to-tr from-primary-500/[0.03] to-transparent"></div>
            <div class="absolute inset-0"
                style="background-image: radial-gradient(circle, #94a3b8 1px, transparent 1px); background-size: 32px 32px; opacity: 0.12;">
            </div>
        </div>

        <div class="relative max-w-6xl mx-auto px-6 grid md:grid-cols-2 gap-12 items-center">
            <!-- Left -->
            <div class="anim-fade-up">
                <span
                    class="inline-flex items-center gap-2 bg-primary-100 dark:bg-secondary-800 text-primary-700 dark:text-primary-400 text-xs font-semibold px-3 py-1.5 rounded-full mb-6">
                    <span class="w-2 h-2 rounded-full bg-primary-600 inline-block animate-pulse"></span>
                    PENGALAMAN LIVE SINEMATIK
                </span>
                <h1 class="font-heading font-black text-3xl sm:text-4xl md:text-5xl lg:text-6xl leading-tight text-secondary-900 dark:text-neutral-100 mb-4">
                    Hidupkan Setiap<br>Momen
                    <em class="text-primary-600 dark:text-primary-400 not-italic block">Berharga.</em>
                </h1>
                <p class="text-secondary-800/60 dark:text-neutral-200/60 leading-relaxed mb-8 max-w-md">
                    Siarkan momen pernikahan Anda dengan kualitas sinematik melalui berbagai platform. Pastikan tidak
                    ada satu pun orang terkasih yang melewatkan hari spesial Anda.
                </p>
                <div class="flex flex-wrap gap-4">
                    <a href="#paket"
                        class="bg-primary-600 hover:bg-primary-700 text-white font-semibold px-7 py-3.5 rounded-full transition-colors shadow-soft flex items-center gap-2">
                        <i class="fa-solid fa-wifi text-sm"></i> Hubungkan Streaming Anda
                    </a>
                    <!-- <a href="#demo"
                        class="border border-secondary-800/20 hover:border-primary-600 hover:text-primary-600 text-secondary-800 dark:text-neutral-200 font-semibold px-7 py-3.5 rounded-full transition-colors flex items-center gap-2">
                        <i class="fa-regular fa-circle-play text-sm"></i> Lihat Demo Sinematik
                    </a> -->
                </div>
            </div>

            <!-- Right — Video Mock -->
            <div class="anim-fade-up anim-d2 relative">
                <div
                    class="rounded-2xl overflow-hidden shadow-2xl aspect-video relative bg-gradient-to-br from-primary-100 to-neutral-200 dark:from-secondary-800 dark:to-secondary-800">
                    <!-- Thumbnail overlay -->
                    <img src="https://awsimages.detik.net.id/community/media/visual/2021/03/23/ilustrasi-akad-nikah.jpeg?w=600&q=90"
                        alt="Background" class="w-full h-full object-cover">
                    <!-- Play button -->
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div
                            class="w-16 h-16 rounded-full bg-white/20 backdrop-blur-sm border border-white/40 flex items-center justify-center cursor-pointer hover:bg-white/30 transition-colors">
                            <i class="fa-solid fa-play text-white text-xl ml-1"></i>
                        </div>
                    </div>
                    <!-- LIVE badge -->
                    <div
                        class="absolute top-3 left-3 flex items-center gap-1.5 bg-red-600 text-white text-xs font-bold px-2.5 py-1 rounded">
                        <span class="w-1.5 h-1.5 rounded-full bg-white dark:bg-secondary-800 inline-block animate-pulse"></span>
                        LIVE
                    </div>
                    <!-- View count -->
                    <div class="absolute top-3 right-3 flex items-center gap-1 bg-black/50 text-white text-xs px-2 py-1 rounded">
                        <i class="fa-regular fa-eye text-xs"></i> 1.248
                    </div>
                    <!-- Title -->
                    <div class="absolute bottom-12 left-4 right-4 md:right-24">
                        <p class="text-white font-heading font-bold text-sm sm:text-base md:text-lg leading-tight">Resepsi Pernikahan: Aris &amp; Sarah</p>
                        <p class="text-white/60 text-xs mt-0.5">Langsung Sinematik</p>
                    </div>
                    <!-- Controls -->
                    <div class="absolute bottom-3 left-4 right-4 flex items-center justify-end gap-3">
                        <i class="fa-solid fa-volume-high text-white/70 text-sm hover:text-white cursor-pointer"></i>
                        <i class="fa-solid fa-gear text-white/70 text-sm hover:text-white cursor-pointer"></i>
                        <i class="fa-solid fa-expand text-white/70 text-sm hover:text-white cursor-pointer"></i>
                    </div>
                </div>

                <!-- Chat panel -->
                <div
                    class="hidden md:block absolute -right-4 top-4 w-48 bg-white dark:bg-secondary-800 rounded-xl shadow-soft border border-primary-100 dark:border-secondary-700 overflow-hidden text-xs">
                    <div class="flex items-center justify-between px-3 py-2 border-b border-primary-100 dark:border-secondary-700">
                        <span class="font-semibold text-secondary-800 dark:text-neutral-200">Live Chat</span>
                        <i class="fa-solid fa-xmark text-secondary-800/40 cursor-pointer"></i>
                    </div>
                    <div class="p-3 space-y-2">
                        <div class="anim-d1">
                            <span class="font-semibold text-primary-600 dark:text-primary-400">Maya:</span>
                            <span class="text-secondary-800/70 dark:text-neutral-200/70"> Selamat! Sangat cantik
                                🌸</span>
                        </div>
                        <div class="anim-d2">
                            <span class="font-semibold text-primary-600 dark:text-primary-400">Budi:</span>
                            <span class="text-secondary-800/70 dark:text-neutral-200/70"> Terlihat luar biasa</span>
                        </div>
                        <div class="anim-d3">
                            <span class="font-semibold text-primary-600 dark:text-primary-400">Indah:</span>
                            <span class="text-secondary-800/70 dark:text-neutral-200/70"> Terharu menontonnya 😭</span>
                        </div>
                        <div class="mt-2 border-t border-primary-50 dark:border-secondary-700 pt-2">
                            <input type="text" placeholder="Katakan sesuatu…"
                                class="w-full text-xs px-2 py-1.5 rounded border border-primary-100 focus:outline-none focus:border-primary-400 bg-neutral-50 dark:bg-secondary-800 dark:text-neutral-200" />
                        </div>
                    </div>
                </div>

                <!-- Stats pills -->
                <div class="flex flex-wrap gap-2 sm:gap-3 mt-5">
                    <div
                        class="flex items-center gap-1.5 sm:gap-2 bg-white dark:bg-secondary-800 rounded-xl px-3 sm:px-4 py-2 sm:py-2.5 shadow-soft border border-primary-100 text-xs sm:text-sm">
                        <i class="fa-solid fa-users text-primary-500"></i>
                        <span class="font-semibold whitespace-nowrap">1.2K+</span>
                        <span class="text-neutral-500 dark:text-neutral-400 hidden sm:inline">Penonton</span>
                    </div>
                    <div
                        class="flex items-center gap-1.5 sm:gap-2 bg-white dark:bg-secondary-800 rounded-xl px-3 sm:px-4 py-2 sm:py-2.5 shadow-soft border border-primary-100 text-xs sm:text-sm">
                        <i class="fa-solid fa-star text-amber-400"></i>
                        <span class="font-semibold whitespace-nowrap">4.9</span>
                        <span class="text-neutral-500 dark:text-neutral-400 hidden sm:inline">Rating</span>
                    </div>
                    <div
                        class="flex items-center gap-1.5 sm:gap-2 bg-white dark:bg-secondary-800 rounded-xl px-3 sm:px-4 py-2 sm:py-2.5 shadow-soft border border-primary-100 text-xs sm:text-sm">
                        <i class="fa-solid fa-shield-halved text-green-500"></i>
                        <span class="font-semibold text-neutral-600 dark:text-neutral-300">HD</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ─── FITUR ──────────────────────────────────────────── -->
    <section id="fitur" class="py-24 bg-white dark:bg-secondary-900">
        <div class="max-w-6xl mx-auto px-6">
            <div class="text-center mb-16 reveal">
                <h2 class="font-heading font-bold text-4xl text-secondary-900 dark:text-neutral-100 mb-3">Semua yang
                    Anda Butuhkan Ada di Sini</h2>
                <p class="text-neutral-500 dark:text-neutral-400 max-w-xl mx-auto leading-relaxed">
                    Kami menyediakan berbagai fitur untuk membuat pernikahan Anda lebih mudah dan nyaman, sehingga Anda
                    tidak perlu khawatir tentang apa pun.
                </p>
            </div>
            <div class="grid md:grid-cols-3 gap-6">

                <div
                    class="reveal bg-tertiary dark:bg-secondary-900 rounded-2xl p-7 border border-primary-100 dark:border-secondary-700 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                    <div class="w-12 h-12 rounded-xl bg-primary-100 dark:bg-secondary-800 flex items-center justify-center mb-5">
                        <i class="fa-solid fa-video text-primary-600 dark:text-primary-400 text-lg"></i>
                    </div>
                    <h3 class="font-heading font-bold text-lg mb-2 text-secondary-900 dark:text-neutral-100">Pernikahan
                        Live Sinematik</h3>
                    <p class="text-neutral-500 text-sm leading-relaxed">Siarkan momen pernikahan Anda kepada orang-orang
                        terkasih secara sinematik melalui berbagai platform.</p>
                </div>

                <div
                    class="reveal bg-tertiary dark:bg-secondary-900 rounded-2xl p-7 border border-primary-100 dark:border-secondary-700 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                    <div class="w-12 h-12 rounded-xl bg-primary-100 dark:bg-secondary-800 flex items-center justify-center mb-5">
                        <i class="fa-solid fa-camera-rotate text-primary-600 dark:text-primary-400 text-lg"></i>
                    </div>
                    <h3 class="font-heading font-bold text-lg mb-2 text-secondary-900 dark:text-neutral-100">Kamera
                        Bergerak</h3>
                    <p class="text-neutral-500 text-sm leading-relaxed">Penggunaan kamera yang bergerak aktif memastikan
                        semua momen penting pernikahan Anda terekam secara optimal.</p>
                </div>

                <div
                    class="reveal bg-tertiary dark:bg-secondary-900 rounded-2xl p-7 border border-primary-100 dark:border-secondary-700 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                    <div class="w-12 h-12 rounded-xl bg-primary-100 dark:bg-secondary-800 flex items-center justify-center mb-5">
                        <i class="fa-solid fa-sliders text-primary-600 dark:text-primary-400 text-lg"></i>
                    </div>
                    <h3 class="font-heading font-bold text-lg mb-2 text-secondary-900 dark:text-neutral-100">Bingkai
                        Kustom</h3>
                    <p class="text-neutral-500 text-sm leading-relaxed">Berbagai pilihan bingkai tersedia untuk
                        memudahkan Anda menyesuaikan tampilan live stream dengan tema pernikahan Anda.</p>
                </div>

                <div
                    class="reveal bg-tertiary dark:bg-secondary-900 rounded-2xl p-7 border border-primary-100 dark:border-secondary-700 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                    <div class="w-12 h-12 rounded-xl bg-primary-100 dark:bg-secondary-800 flex items-center justify-center mb-5">
                        <i class="fa-solid fa-circle-dot text-primary-600 dark:text-primary-400 text-lg"></i>
                    </div>
                    <h3 class="font-heading font-bold text-lg mb-2 text-secondary-900 dark:text-neutral-100">Rekaman
                        Lengkap</h3>
                    <p class="text-neutral-500 text-sm leading-relaxed">Setiap momen pernikahan Anda akan direkam secara
                        penuh. Anda akan menerima hasilnya dan dapat menyimpan kenangan spesial ini selamanya.</p>
                </div>

                <div
                    class="reveal bg-tertiary dark:bg-secondary-900 rounded-2xl p-7 border border-primary-100 dark:border-secondary-700 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                    <div class="w-12 h-12 rounded-xl bg-primary-100 dark:bg-secondary-800 flex items-center justify-center mb-5">
                        <i class="fa-solid fa-shuffle text-primary-600 dark:text-primary-400 text-lg"></i>
                    </div>
                    <h3 class="font-heading font-bold text-lg mb-2 text-secondary-900 dark:text-neutral-100">Multi
                        Platform</h3>
                    <p class="text-neutral-500 text-sm leading-relaxed">Selain YouTube, siaran pernikahan Anda dapat
                        diakses melalui berbagai platform lain seperti Instagram, TikTok, Zoom, Google Meet, dan
                        lainnya.</p>
                </div>

                <div
                    class="reveal bg-tertiary dark:bg-secondary-900 rounded-2xl p-7 border border-primary-100 dark:border-secondary-700 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                    <div class="w-12 h-12 rounded-xl bg-primary-100 dark:bg-secondary-800 flex items-center justify-center mb-5">
                        <i class="fa-solid fa-desktop text-primary-600 dark:text-primary-400 text-lg"></i>
                    </div>
                    <h3 class="font-heading font-bold text-lg mb-2 text-secondary-900 dark:text-neutral-100">Kamera
                        Langsung (Live Cam)</h3>
                    <p class="text-neutral-500 text-sm leading-relaxed">Siarkan momen pernikahan Anda melalui layar di
                        lokasi acara. Jadi Anda tidak perlu khawatir tamu Anda melewatkan acara penting apa pun.</p>
                </div>

            </div>
        </div>
    </section>

    <!-- ─── TESTIMONIALS ───────────────────────────────────── -->
    <section id="testimoni" class="py-24 bg-tertiary dark:bg-secondary-800">
        <div class="max-w-6xl mx-auto px-6">
            <div class="text-center mb-16 reveal">
                <h2 class="font-heading font-bold text-4xl text-secondary-900 dark:text-neutral-100 mb-3">Apa Kata
                    Mereka?</h2>
                <p class="text-neutral-500 dark:text-neutral-400">Kebahagiaan klien adalah prioritas kami dalam
                    mengabadikan momen spesial.
                </p>
            </div>
            <div class="grid md:grid-cols-3 gap-6">

                <div
                    class="reveal bg-white dark:bg-secondary-800 rounded-2xl p-8 shadow-soft border border-primary-100 dark:border-secondary-700 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                    <div class="text-primary-400 dark:text-primary-300 text-3xl font-heading leading-none mb-4">"</div>
                    <p class="text-secondary-800/70 dark:text-neutral-200/70 text-sm leading-relaxed mb-6">"Layanan
                        streaming yang sangat
                        profesional!
                        Kualitas videonya jernih dan keluarga yang tidak bisa hadir merasa seperti berada di lokasi."
                    </p>
                    <p class="font-heading font-bold text-primary-600 dark:text-primary-400">Rian &amp; Shinta</p>
                </div>

                <div
                    class="reveal bg-white dark:bg-secondary-800 rounded-2xl p-8 shadow-soft border border-primary-100 dark:border-secondary-700 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                    <div class="text-primary-400 dark:text-primary-300 text-3xl font-heading leading-none mb-4">"</div>
                    <p class="text-secondary-800/70 dark:text-neutral-200/70 text-sm leading-relaxed mb-6">"Sangat puas
                        dengan fitur Live
                        Cam-nya.
                        Tamu di area belakang tetap bisa melihat prosesi akad dengan jelas melalui layar besar."</p>
                    <p class="font-heading font-bold text-primary-600 dark:text-primary-400">Aditya &amp; Kartika</p>
                </div>

                <div
                    class="reveal bg-white dark:bg-secondary-800 rounded-2xl p-8 shadow-soft border border-primary-100 dark:border-secondary-700 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                    <div class="text-primary-400 dark:text-primary-300 text-3xl font-heading leading-none mb-4">"</div>
                    <p class="text-secondary-800/70 dark:text-neutral-200/70 text-sm leading-relaxed mb-6">"Fitur
                        multi-platform sangat membantu.
                        Teman-teman di luar negeri bisa menonton via YouTube dengan lancar tanpa kendala."</p>
                    <p class="font-heading font-bold text-primary-600 dark:text-primary-400">Dimas &amp; Clarissa</p>
                </div>

            </div>
        </div>
    </section>

    <!-- ─── PRICING ────────────────────────────────────────── -->
    <section id="paket" class="py-24 bg-white dark:bg-secondary-900">
        <div class="max-w-6xl mx-auto px-6">
            <div class="text-center mb-16 reveal">
                <h2 class="font-heading font-bold text-4xl text-secondary-900 dark:text-neutral-100 mb-3">Pilihan Paket
                    Layanan</h2>
                <p class="text-neutral-500 dark:text-neutral-400">Pilih paket yang sesuai dengan kebutuhan momen spesial
                    Anda.</p>
            </div>

            <div class="grid md:grid-cols-3 gap-6 items-stretch">

                <!-- Silver -->
                <div
                    class="reveal flex flex-col bg-tertiary dark:bg-secondary-900 rounded-2xl border border-primary-100 dark:border-secondary-700 p-8 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                    <div class="mb-6">
                        <h3 class="font-heading font-bold text-2xl text-secondary-900 dark:text-neutral-100">Silver</h3>
                        <p class="text-neutral-500 dark:text-neutral-400 text-sm mt-1">Paket Dasar Terjangkau</p>
                        <p class="text-primary-600 dark:text-primary-400 font-semibold text-sm mt-3">Hubungi Sales</p>
                    </div>
                    <ul class="space-y-3 flex-1 mb-8">
                        <li class="flex items-center gap-3 text-sm text-secondary-800/70 dark:text-neutral-200/70">
                            <i class="fa-solid fa-circle-check text-primary-500 text-base"></i>
                            1 Kamera Statis
                        </li>
                        <li class="flex items-center gap-3 text-sm text-secondary-800/70 dark:text-neutral-200/70">
                            <i class="fa-solid fa-circle-check text-primary-500 text-base"></i>
                            Durasi 2 Jam
                        </li>
                        <li class="flex items-center gap-3 text-sm text-secondary-800/70 dark:text-neutral-200/70">
                            <i class="fa-solid fa-circle-check text-primary-500 text-base"></i>
                            1 Platform (YouTube)
                        </li>
                    </ul>
                    <!-- <a href="#"
                        class="block text-center border-2 border-primary-600 text-primary-600 hover:bg-primary-600 hover:text-white font-semibold py-3 rounded-full transition-colors">
                        Pilih Silver
                    </a> -->
                </div>

                <!-- Gold (Popular) -->
                <div
                    class="reveal relative flex flex-col bg-primary-600 rounded-2xl p-8 text-white ring-2 ring-primary-500 shadow-xl transition-all duration-300 hover:shadow-2xl hover:-translate-y-1">
                    <span
                        class="absolute -top-4 left-1/2 -translate-x-1/2 bg-amber-400 text-secondary-800 dark:text-neutral-200 text-xs font-bold px-4 py-1.5 rounded-full shadow">
                        POPULER
                    </span>
                    <div class="mb-6">
                        <h3 class="font-heading font-bold text-2xl">Gold</h3>
                        <p class="text-white/60 text-sm mt-1">Pilihan Terbaik Pasangan</p>
                        <p class="text-amber-300 font-semibold text-sm mt-3">Hubungi Sales</p>
                    </div>
                    <ul class="space-y-3 flex-1 mb-8">
                        <li class="flex items-center gap-3 text-sm text-white/90">
                            <i class="fa-solid fa-circle-check text-amber-300 text-base"></i>
                            2 Kamera (1 Bergerak)
                        </li>
                        <li class="flex items-center gap-3 text-sm text-white/90">
                            <i class="fa-solid fa-circle-check text-amber-300 text-base"></i>
                            Durasi 4 Jam
                        </li>
                        <li class="flex items-center gap-3 text-sm text-white/90">
                            <i class="fa-solid fa-circle-check text-amber-300 text-base"></i>
                            3 Platform Sekaligus
                        </li>
                        <li class="flex items-center gap-3 text-sm text-white/90">
                            <i class="fa-solid fa-circle-check text-amber-300 text-base"></i>
                            File Rekaman Lengkap
                        </li>
                    </ul>
                    <!-- <a href="#"
                        class="block text-center bg-white dark:bg-secondary-800 text-primary-700 hover:bg-primary-50 font-bold py-3 rounded-full transition-colors shadow">
                        Pilih Gold
                    </a> -->
                </div>

                <!-- Platinum -->
                <div
                    class="reveal flex flex-col bg-tertiary dark:bg-secondary-900 rounded-2xl border border-primary-100 p-8 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                    <div class="mb-6">
                        <h3 class="font-heading font-bold text-2xl text-secondary-900 dark:text-neutral-100">Platinum
                        </h3>
                        <p class="text-neutral-500 dark:text-neutral-400 text-sm mt-1">Pengalaman Premium</p>
                        <p class="text-primary-600 dark:text-primary-400 font-semibold text-sm mt-3">Hubungi Sales</p>
                    </div>
                    <ul class="space-y-3 flex-1 mb-8">
                        <li class="flex items-center gap-3 text-sm text-secondary-800/70 dark:text-neutral-200/70">
                            <i class="fa-solid fa-circle-check text-primary-500 text-base"></i>
                            3 Kamera Profesional
                        </li>
                        <li class="flex items-center gap-3 text-sm text-secondary-800/70 dark:text-neutral-200/70">
                            <i class="fa-solid fa-circle-check text-primary-500 text-base"></i>
                            Durasi Tanpa Batas
                        </li>
                        <li class="flex items-center gap-3 text-sm text-secondary-800/70 dark:text-neutral-200/70">
                            <i class="fa-solid fa-circle-check text-primary-500 text-base"></i>
                            Semua Platform
                        </li>
                        <li class="flex items-center gap-3 text-sm text-secondary-800/70 dark:text-neutral-200/70">
                            <i class="fa-solid fa-circle-check text-primary-500 text-base"></i>
                            Fitur Live Cam Lokasi
                        </li>
                    </ul>
                    <!-- <a href="#"
                        class="block text-center border-2 border-primary-600 text-primary-600 hover:bg-primary-600 hover:text-white font-semibold py-3 rounded-full transition-colors">
                        Pilih Platinum
                    </a> -->
                </div>

            </div>
        </div>
    </section>

    <!-- ─── CTA ───────────────────────────────────────────── -->
    <section class="py-24 bg-gradient-to-br from-secondary-800 to-secondary-900 relative overflow-hidden">
        <div class="absolute inset-0 pointer-events-none"
            style="background-image: radial-gradient(circle, rgba(255,255,255,0.08) 1px, transparent 1px); background-size: 32px 32px;">
        </div>
        <div class="relative max-w-3xl mx-auto px-6 text-center reveal">
            <h2 class="font-heading font-bold text-4xl md:text-5xl text-white mb-4">
                Siap Menghubungkan Semua Orang?
            </h2>
            <p class="text-white/55 leading-relaxed mb-10 max-w-xl mx-auto">
                Mulai sekarang dan buat momen spesial Anda dapat diakses oleh orang-orang terkasih, di mana pun mereka
                berada.
            </p>
            <div class="flex flex-wrap justify-center gap-4">
                <!-- <a href="#paket"
                    class="bg-primary-600 hover:bg-primary-500 text-white font-semibold px-8 py-4 rounded-full transition-colors shadow-soft flex items-center gap-2">
                    <i class="fa-solid fa-bolt text-sm"></i> Pesan Paket Sekarang
                </a> -->
                <a href="https://wa.me/62895349823366?text=Halo%20Rayakan%20Digital%2C%20saya%20tertarik%20untuk%20konsultasi%20mengenai%20layanan%20live%20streaming%20pernikahan."
                    class="border border-white/20 hover:border-white/50 text-white font-semibold px-8 py-4 rounded-full transition-colors flex items-center gap-2">
                    <i class="fa-regular fa-comment text-sm"></i> Konsultasi Gratis
                </a>
            </div>
        </div>
    </section>

    <x-public-footer />
</body>

</html>