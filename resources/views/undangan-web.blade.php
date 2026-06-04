<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Undangan Web - Rayakan Digital</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    <link rel="stylesheet" href="{{ asset('css/landingpage.css') }}">
</head>

<body class="font-sans antialiased bg-gray-50 text-gray-900">
    <x-public-navbar />
    <!-- Spacer to prevent content from hiding behind fixed navbar -->
    <div class="h-16"></div>
    <!-- =========== HERO =========== -->
    <section class="hero-bg pt-28 pb-16 overflow-hidden" id="layanan">
        <div class="max-w-6xl mx-auto px-6 grid md:grid-cols-2 gap-12 items-center">
            <!-- Left -->
            <div>
                <span
                    class="fade-up inline-flex items-center gap-2 bg-orange-light border border-orange-200 text-orange-dark text-xs font-semibold px-3 py-1.5 rounded-full mb-5">
                    <i class="fa-solid fa-star text-orange-DEFAULT text-[10px]"></i>
                    Undangan Digital Modern #1
                </span>
                <h1 class="fade-up delay-1 font-display text-[2.6rem] md:text-5xl font-bold leading-tight text-dark mb-3">
                    Rayakan Momen<br>Berharga Dengan<br>
                    <span class="text-orange-DEFAULT">Sentuhan Digital.</span>
                </h1>
                <p class="fade-up delay-2 text-gray-500 text-[15px] leading-relaxed max-w-sm mb-8">
                    Buat undangan pernikahan, ulang tahun, atau acara korporat dalam hitungan menit. Elegan, interaktif,
                    dan mudah dibagikan.
                </p>
                <div class="fade-up delay-3 flex items-center gap-3">
                    <a href="#"
                        class="inline-flex items-center gap-2 bg-orange-DEFAULT hover:bg-orange-dark text-white font-semibold px-6 py-3 rounded-full transition shadow-lg shadow-orange-200">
                        Buat Sekarang <i class="fa-solid fa-arrow-right text-sm"></i>
                    </a>
                    <a href="#contoh"
                        class="inline-flex items-center gap-2 border border-gray-300 hover:border-orange-DEFAULT text-dark font-semibold px-6 py-3 rounded-full transition text-sm">
                        Lihat Contoh
                    </a>
                </div>
            </div>
            <!-- Right: Phone Mockup -->
            <div class="relative flex justify-center fade-up delay-4">
                <!-- Phone frame -->
                <div class="phone-shadow relative w-56 md:w-64 mx-auto">
                    <div class="bg-[#1c1c1e] rounded-[2.5rem] p-2 shadow-2xl">
                        <div class="bg-[#2d1b0e] rounded-[2rem] overflow-hidden relative" style="aspect-ratio:9/19">
                            <!-- Notch -->
                            <div class="absolute top-3 left-1/2 -translate-x-1/2 w-16 h-3 bg-black/70 rounded-full z-10">
                            </div>
                            <!-- Invitation image placeholder -->
                            <div
                                class="w-full h-full flex flex-col items-center justify-center bg-gradient-to-b from-[#3d2010] to-[#7a4020]">
                                <div class="mt-8 text-center px-4">
                                    <p class="font-display text-white/60 text-xs tracking-widest uppercase mb-1">The
                                        Wedding of</p>
                                    <h2 class="font-display text-white text-xl font-bold leading-snug">Aditya
                                        &<br />Arini</h2>
                                    <p class="text-white/50 text-[10px] mt-2">Minggu, 14 Juli 2024</p>
                                    <div class="mt-4 w-10 h-0.5 bg-orange-DEFAULT mx-auto rounded"></div>
                                </div>
                                <!-- Decorative circles -->
                                <div class="absolute top-10 right-4 w-16 h-16 rounded-full bg-orange-DEFAULT/20 blur-xl">
                                </div>
                                <div class="absolute bottom-20 left-4 w-20 h-20 rounded-full bg-orange-DEFAULT/10 blur-2xl">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Floating badge -->
                <div
                    class="absolute top-8 -right-4 md:right-0 bg-white shadow-xl rounded-2xl px-4 py-3 flex items-center gap-3 w-44">
                    <div class="w-8 h-8 bg-orange-DEFAULT rounded-full flex items-center justify-center flex-shrink-0">
                        <i class="fa-solid fa-music text-white text-xs"></i>
                    </div>
                    <div>
                        <p class="text-[10px] text-gray-400 font-medium">Background Music</p>
                        <p class="text-xs text-dark font-semibold truncate">Romantic Jazz</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- =========== FITUR =========== -->
    <section class="py-20 bg-white" id="fitur">
        <div class="max-w-6xl mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="font-display text-3xl md:text-4xl font-bold text-dark mb-3">Fitur Interaktif Tanpa Batas</h2>
                <p class="text-gray-500 text-[15px] max-w-md mx-auto">Pengalaman yang lebih dari sekadar teks. Hadirkan
                    emosi dan kemudahan dalam satu genggaman tamu Anda.</p>
            </div>
            <div class="grid md:grid-cols-2 gap-5">
                <!-- Card 1: Galeri -->
                <div class="feature-card bg-gray-50 rounded-3xl p-6 overflow-hidden relative">
                    <div class="w-10 h-10 bg-orange-light rounded-xl flex items-center justify-center mb-4">
                        <i class="fa-regular fa-images text-orange-DEFAULT text-lg"></i>
                    </div>
                    <h3 class="font-semibold text-dark text-lg mb-1">Galeri Foto & Video</h3>
                    <p class="text-gray-500 text-sm leading-relaxed max-w-xs">Bagikan momen pre-wedding terbaik Anda
                        dalam tampilan slideshow premium yang memukau.</p>
                    <!-- Mini gallery grid -->
                    <div class="mt-5 grid grid-cols-4 gap-1.5 rounded-xl overflow-hidden">
                        <div class="col-span-2 row-span-2 bg-orange-200 rounded-xl h-24"
                            style="background: linear-gradient(135deg,#fed7aa,#fb923c)"></div>
                        <div class="bg-orange-100 rounded-xl h-11"
                            style="background:linear-gradient(135deg,#fde68a,#fbbf24)"></div>
                        <div class="bg-orange-300 rounded-xl h-11"
                            style="background:linear-gradient(135deg,#fca5a5,#f87171)"></div>
                        <div class="bg-orange-200 rounded-xl h-11"
                            style="background:linear-gradient(135deg,#bbf7d0,#4ade80)"></div>
                        <div class="bg-orange-100 rounded-xl h-11"
                            style="background:linear-gradient(135deg,#bfdbfe,#60a5fa)"></div>
                    </div>
                </div>
                <!-- Card 2: Navigasi Peta -->
                <div class="feature-card bg-gray-50 rounded-3xl p-6 relative overflow-hidden">
                    <div class="w-10 h-10 bg-orange-light rounded-xl flex items-center justify-center mb-4">
                        <i class="fa-solid fa-location-dot text-orange-DEFAULT text-lg"></i>
                    </div>
                    <h3 class="font-semibold text-dark text-lg mb-1">Navigasi Peta</h3>
                    <p class="text-gray-500 text-sm leading-relaxed max-w-xs">Terintegrasi langsung dengan Google Maps &
                        Waze untuk memudahkan tamu hadir tepat waktu.</p>
                    <!-- Map placeholder -->
                    <div class="mt-5 w-full h-24 rounded-2xl overflow-hidden relative bg-blue-50">
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="w-full h-full"
                                style="background:linear-gradient(135deg,#e0f2fe,#bae6fd); position:relative;">
                                <div class="absolute inset-0 opacity-30"
                                    style="background-image: repeating-linear-gradient(0deg,#93c5fd 0,#93c5fd 1px,transparent 1px,transparent 20px), repeating-linear-gradient(90deg,#93c5fd 0,#93c5fd 1px,transparent 1px,transparent 20px);">
                                </div>
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <div
                                        class="w-8 h-8 bg-orange-DEFAULT rounded-full flex items-center justify-center shadow-lg shadow-orange-300">
                                        <i class="fa-solid fa-location-dot text-white text-sm"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Card 3: Background Music -->
                <div class="feature-card bg-orange-DEFAULT rounded-3xl p-6 text-white">
                    <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center mb-4">
                        <i class="fa-solid fa-music text-white text-lg"></i>
                    </div>
                    <h3 class="font-semibold text-lg mb-1">Background Music</h3>
                    <p class="text-white/70 text-sm leading-relaxed">Auto-diputar, pilihan untuk suasana spesial.</p>
                    <!-- Music wave visualizer -->
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
                <!-- Card 4: RSVP -->
                <div class="feature-card bg-gray-50 rounded-3xl p-6">
                    <div class="w-10 h-10 bg-orange-light rounded-xl flex items-center justify-center mb-4">
                        <i class="fa-solid fa-envelope-open-text text-orange-DEFAULT text-lg"></i>
                    </div>
                    <h3 class="font-semibold text-dark text-lg mb-1">RSVP & Ucapan</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">Manajemen tamu dan buku ucapan digital yang rapi.
                    </p>
                    <!-- RSVP list -->
                    <div class="mt-5 space-y-2">
                        <div class="flex items-center gap-3 bg-white rounded-xl px-3 py-2 shadow-sm">
                            <div class="w-7 h-7 rounded-full bg-green-100 flex items-center justify-center">
                                <i class="fa-solid fa-check text-green-500 text-xs"></i>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-dark">Rina & Keluarga</p>
                                <p class="text-[10px] text-gray-400">Hadir · 3 orang</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 bg-white rounded-xl px-3 py-2 shadow-sm">
                            <div class="w-7 h-7 rounded-full bg-orange-100 flex items-center justify-center">
                                <i class="fa-solid fa-clock text-orange-DEFAULT text-xs"></i>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-dark">Budi Santoso</p>
                                <p class="text-[10px] text-gray-400">Menunggu konfirmasi</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- =========== HARGA =========== -->
    <section class="py-20 bg-gray-50" id="harga">
        <div class="max-w-6xl mx-auto px-6">
            <div class="mb-10">
                <h2 class="font-display text-3xl md:text-4xl font-bold text-dark mb-2">Pilih Paket Sesuai Kebutuhan</h2>
                <p class="text-gray-500 text-sm max-w-sm">Semua paket mendapatkan domain kustom dan masa aktif panjang.
                    Pilih yang terbaik untuk momen sekali seumur hidup Anda.</p>
            </div>
            <!-- Toggle -->
            <div class="flex items-center gap-2 mb-8">
                <button
                    class="bg-white border border-orange-DEFAULT text-orange-DEFAULT text-sm font-semibold px-5 py-2 rounded-full shadow-sm">Web
                    Invitations</button>
                <button
                    class="bg-transparent border border-gray-200 text-gray-500 text-sm font-medium px-5 py-2 rounded-full hover:border-orange-DEFAULT transition">Video
                    Only</button>
            </div>
            <div class="grid md:grid-cols-2 gap-6 max-w-3xl">
                <!-- Basic -->
                <div class="bg-white rounded-3xl p-7 border border-gray-100 shadow-sm">
                    <p class="text-xs font-semibold text-gray-400 tracking-widest uppercase mb-3">Basic Theme</p>
                    <div class="flex items-baseline gap-1 mb-6">
                        <span class="text-xl font-semibold text-dark">Rp</span>
                        <span class="font-display text-5xl font-bold text-dark">99<span class="text-2xl">k</span></span>
                        <span class="text-sm text-gray-400">/aktif lifer</span>
                    </div>
                    <ul class="space-y-3 mb-8">
                        <li class="flex items-center gap-3 text-sm text-gray-600">
                            <i class="fa-solid fa-circle-check text-orange-DEFAULT"></i> 100+ Template Elegan
                        </li>
                        <li class="flex items-center gap-3 text-sm text-gray-600">
                            <i class="fa-solid fa-circle-check text-orange-DEFAULT"></i> Galeri 5 Foto
                        </li>
                        <li class="flex items-center gap-3 text-sm text-gray-600">
                            <i class="fa-solid fa-circle-check text-orange-DEFAULT"></i> Background Music Dasar
                        </li>
                        <li class="flex items-center gap-3 text-sm text-gray-600">
                            <i class="fa-solid fa-circle-check text-orange-DEFAULT"></i> Google Maps Integration
                        </li>
                        <li class="flex items-center gap-3 text-sm text-gray-400">
                            <i class="fa-solid fa-circle-xmark text-gray-300"></i> Custom Domain Nama
                        </li>
                    </ul>
                    <button
                        class="w-full border-2 border-orange-DEFAULT text-orange-DEFAULT font-semibold py-3 rounded-full hover:bg-orange-light transition">
                        Pilih Paket
                    </button>
                </div>
                <!-- Premium -->
                <div class="pricing-popular rounded-3xl p-7 relative overflow-hidden">
                    <span
                        class="absolute top-5 right-5 bg-orange-DEFAULT text-white text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-wider">Most
                        Popular</span>
                    <p class="text-xs font-semibold text-orange-DEFAULT tracking-widest uppercase mb-3">Premium Theme
                    </p>
                    <div class="flex items-baseline gap-1 mb-6">
                        <span class="text-xl font-semibold text-white">Rp</span>
                        <span class="font-display text-5xl font-bold text-white">199<span class="text-2xl">k</span></span>
                        <span class="text-sm text-gray-400">/aktif selamanya</span>
                    </div>
                    <ul class="space-y-3 mb-8">
                        <li class="flex items-center gap-3 text-sm text-white/80">
                            <i class="fa-solid fa-circle-check text-orange-DEFAULT"></i> Semua Fitur Basic
                        </li>
                        <li class="flex items-center gap-3 text-sm text-white/80">
                            <i class="fa-solid fa-circle-check text-orange-DEFAULT"></i> E-Wallet & QR Code Angpao
                        </li>
                        <li class="flex items-center gap-3 text-sm text-white/80">
                            <i class="fa-solid fa-circle-check text-orange-DEFAULT"></i> Unlimited Gallery & Video
                        </li>
                        <li class="flex items-center gap-3 text-sm text-white/80">
                            <i class="fa-solid fa-circle-check text-orange-DEFAULT"></i> Filter Instagram Kustom
                        </li>
                        <li class="flex items-center gap-3 text-sm text-white/80">
                            <i class="fa-solid fa-circle-check text-orange-DEFAULT"></i> Domain rayakan.com/nama-anda
                        </li>
                    </ul>
                    <button
                        class="w-full bg-orange-DEFAULT hover:bg-orange-dark text-white font-semibold py-3 rounded-full transition shadow-lg shadow-orange-900/30">
                        Mulai Premium
                    </button>
                </div>
            </div>
        </div>
    </section>
    
    <!-- =========== CTA =========== -->
    <section class="py-16 px-6">
        <div class="max-w-4xl mx-auto cta-bg rounded-3xl p-10 md:p-14 text-center relative overflow-hidden">
            <!-- Decorative blobs -->
            <div
                class="absolute top-0 left-0 w-48 h-48 bg-white/10 rounded-full -translate-x-1/2 -translate-y-1/2 blur-2xl">
            </div>
            <div
                class="absolute bottom-0 right-0 w-64 h-64 bg-black/10 rounded-full translate-x-1/3 translate-y-1/3 blur-2xl">
            </div>
            <h2 class="font-display text-3xl md:text-4xl font-bold text-white relative z-10 mb-3">
                Siap Membuat Undangan Anda?
            </h2>
            <p class="text-white/75 text-sm relative z-10 max-w-sm mx-auto mb-8">
                Hanya butuh 5 menit untuk membuat undangan digital pertama Anda. Gratis coba semua fitur di dashboard.
            </p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-3 relative z-10">
                <a href="#"
                    class="bg-white text-orange-DEFAULT font-semibold px-7 py-3 rounded-full hover:bg-orange-50 transition shadow-md">
                    Buat Undangan Sekarang
                </a>
                <a href="#"
                    class="border-2 border-white/50 text-white font-semibold px-7 py-3 rounded-full hover:bg-white/10 transition flex items-center gap-2">
                    <i class="fa-brands fa-whatsapp text-lg"></i> Konsultasi WhatsApp
                </a>
            </div>
        </div>
    </section>
    <x-public-footer />
</body>

</html>