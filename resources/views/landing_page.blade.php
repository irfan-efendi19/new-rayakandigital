<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Rayakan Digital') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gray-50 text-gray-900">
    <nav class="bg-white border-b border-gray-100" x-data>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <div class="shrink-0 flex items-center">
                        <a href="{{ route('home') }}" class="font-bold text-xl text-indigo-600">
                            Rayakan<span class="text-gray-900">Digital</span>
                        </a>
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    @if (Route::has('login'))
                        <div class="hidden sm:flex sm:items-center sm:ml-6 space-x-4">
                            @auth
                                <a href="{{ route('dashboard') }}" class="text-gray-600 hover:text-gray-900 font-medium">Dashboard</a>
                            @else
                                <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-900 font-medium">Masuk</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}"
                                        class="bg-indigo-600 text-white px-4 py-2 rounded-md font-medium hover:bg-indigo-700 transition">Daftar
                                        Gratis</a>
                                @endif
                            @endauth
                        </div>
                    @endif
                    <button @click="mobileMenuOpen = !mobileMenuOpen"
                        class="sm:hidden p-2 rounded-lg text-gray-500 hover:text-gray-700 hover:bg-gray-100 transition-colors"
                        :aria-expanded="mobileMenuOpen">
                        <svg x-show="!mobileMenuOpen" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                        </svg>
                        <svg x-show="mobileMenuOpen" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
            <div x-show="mobileMenuOpen" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0"
                x-transition:leave-end="opacity-0 -translate-y-2" class="sm:hidden pb-4 space-y-2">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ route('dashboard') }}"
                            class="block px-3 py-2.5 text-gray-600 hover:text-gray-900 hover:bg-gray-50 rounded-lg font-medium transition-colors">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}"
                            class="block px-3 py-2.5 text-gray-600 hover:text-gray-900 hover:bg-gray-50 rounded-lg font-medium transition-colors">Masuk</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                                class="block px-3 py-2.5 bg-indigo-600 text-white rounded-lg font-medium hover:bg-indigo-700 transition-colors text-center">Daftar
                                Gratis</a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>
    </nav>

    <div class="min-h-screen bg-gray-50">
        <div x-data="landing">

            <!-- Hero Section -->
            <div class="relative bg-gradient-to-br from-indigo-50 via-white to-rose-50 overflow-hidden">
                <div class="absolute inset-0 opacity-10">
                    <div class="absolute top-20 left-10 w-72 h-72 bg-indigo-300 rounded-full mix-blend-multiply filter blur-xl animate-pulse"></div>
                    <div class="absolute top-40 right-10 w-72 h-72 bg-rose-300 rounded-full mix-blend-multiply filter blur-xl animate-pulse" style="animation-delay: 2s"></div>
                    <div class="absolute bottom-20 left-1/3 w-72 h-72 bg-amber-200 rounded-full mix-blend-multiply filter blur-xl animate-pulse" style="animation-delay: 4s"></div>
                </div>

                <div class="max-w-7xl mx-auto relative z-10">
                    <div class="relative pb-8 sm:pb-16 md:pb-20 lg:max-w-2xl lg:w-full lg:pb-28 xl:pb-32">
                        <main class="mt-10 mx-auto max-w-7xl px-4 sm:mt-12 sm:px-6 md:mt-16 lg:mt-20 lg:px-8 xl:mt-28">
                            <div class="sm:text-center lg:text-left">
                                <h1 class="text-4xl tracking-tight font-extrabold text-gray-900 sm:text-5xl md:text-6xl">
                                    <span class="block xl:inline">Rayakan momen spesial</span>
                                    <span class="block text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-rose-500 xl:inline">dengan cara digital</span>
                                </h1>
                                <p class="mt-3 text-base text-gray-500 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl lg:mx-0">
                                    Platform undangan digital masa kini. Buat, kelola, dan sebar undangan pernikahan Anda dalam hitungan menit dengan desain elegan dan fitur interaktif.
                                </p>
                                <div class="mt-5 sm:mt-8 sm:flex sm:justify-center lg:justify-start">
                                    <div class="rounded-md shadow">
                                        <button @click="scrollTo('themes')" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-lg text-white bg-gradient-to-r from-indigo-600 to-indigo-700 hover:from-indigo-700 hover:to-indigo-800 md:py-4 md:text-lg md:px-10 transition-all duration-300 shadow-lg shadow-indigo-200 hover:shadow-xl hover:shadow-indigo-300 cursor-pointer">
                                            Pilih Tema Sekarang
                                        </button>
                                    </div>
                                    <div class="mt-3 sm:mt-0 sm:ml-3">
                                        <button @click="scrollTo('pricing')" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-lg text-indigo-700 bg-indigo-100 hover:bg-indigo-200 md:py-4 md:text-lg md:px-10 transition-all duration-200 cursor-pointer">
                                            Lihat Harga
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </main>
                    </div>
                </div>
                <div class="lg:absolute lg:inset-y-0 lg:right-0 lg:w-1/2">
                    <img class="h-56 w-full object-cover sm:h-72 md:h-96 lg:w-full lg:h-full" src="https://picsum.photos/seed/wedding-hero/1769/1000" alt="Wedding celebration">
                </div>
            </div>

            <!-- How It Works Section -->
            <div x-data="reveal" :class="visible || 'opacity-0 translate-y-8'" class="py-16 bg-white transition-all duration-700">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="text-center mb-12">
                        <h2 class="text-base text-indigo-600 font-semibold tracking-wide uppercase">Cara Kerja</h2>
                        <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                            4 Langkah Mudah
                        </p>
                        <p class="mt-4 max-w-2xl text-xl text-gray-500 mx-auto">
                            Dari memilih desain hingga menyebarkan undangan, semua bisa dilakukan dalam hitungan menit.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                        <div class="text-center group">
                            <div class="w-16 h-16 mx-auto mb-4 bg-indigo-100 rounded-2xl flex items-center justify-center group-hover:bg-indigo-600 transition-colors duration-300">
                                <span class="text-2xl font-bold text-indigo-600 group-hover:text-white transition-colors duration-300">1</span>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Pilih Tema</h3>
                            <p class="text-sm text-gray-500">Jelajahi katalog desain undangan dan pratinjau langsung.</p>
                        </div>

                        <div class="text-center group">
                            <div class="w-16 h-16 mx-auto mb-4 bg-rose-100 rounded-2xl flex items-center justify-center group-hover:bg-rose-500 transition-colors duration-300">
                                <span class="text-2xl font-bold text-rose-500 group-hover:text-white transition-colors duration-300">2</span>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Daftar & Isi Data</h3>
                            <p class="text-sm text-gray-500">Buat akun lalu isi informasi acara dan mempelai.</p>
                        </div>

                        <div class="text-center group">
                            <div class="w-16 h-16 mx-auto mb-4 bg-amber-100 rounded-2xl flex items-center justify-center group-hover:bg-amber-500 transition-colors duration-300">
                                <span class="text-2xl font-bold text-amber-500 group-hover:text-white transition-colors duration-300">3</span>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Aktivasi Paket</h3>
                            <p class="text-sm text-gray-500">Pilih paket dan bayar. Fitur premium langsung aktif.</p>
                        </div>

                        <div class="text-center group">
                            <div class="w-16 h-16 mx-auto mb-4 bg-emerald-100 rounded-2xl flex items-center justify-center group-hover:bg-emerald-500 transition-colors duration-300">
                                <span class="text-2xl font-bold text-emerald-500 group-hover:text-white transition-colors duration-300">4</span>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Sebarkan</h3>
                            <p class="text-sm text-gray-500">Generate link personal per tamu dan kirim via WhatsApp.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Theme Catalog Section -->
            <div id="themes" x-data="{ filter: 'all' }" class="py-16 bg-gray-50 transition-all duration-700">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="text-center mb-12">
                        <h2 class="text-base text-indigo-600 font-semibold tracking-wide uppercase">Katalog Tema</h2>
                        <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                            Pilih Desain Undangan Anda
                        </p>
                        <p class="mt-4 max-w-2xl text-xl text-gray-500 mx-auto">
                            Lihat pratinjau langsung dengan data contoh. Klik "Gunakan Tema Ini" untuk langsung mulai.
                        </p>
                    </div>

                    @if($categories->isNotEmpty())
                    <div class="flex flex-wrap justify-center gap-3 mb-10">
                        <button
                            @click="filter = 'all'"
                            :class="filter === 'all' ? 'bg-indigo-600 text-white border-indigo-600' : 'bg-white text-gray-700 border-gray-300 hover:border-indigo-300 hover:text-indigo-600'"
                            class="px-5 py-2.5 rounded-full text-sm font-semibold transition-all duration-200 border-2 shadow-sm">
                            Semua
                            <span class="ml-1.5 inline-flex items-center justify-center min-w-[20px] h-5 px-1.5 rounded-full text-xs font-bold"
                                :class="filter === 'all' ? 'bg-white/25 text-white' : 'bg-gray-100 text-gray-600'">
                                {{ $themes->count() }}
                            </span>
                        </button>

                        @foreach($categories as $category)
                        <button
                            @click="filter = '{{ $category->id }}'"
                            :class="filter === '{{ $category->id }}' ? 'bg-indigo-600 text-white border-indigo-600' : 'bg-white text-gray-700 border-gray-300 hover:border-indigo-300 hover:text-indigo-600'"
                            class="px-5 py-2.5 rounded-full text-sm font-semibold transition-all duration-200 border-2 shadow-sm">
                            {{ $category->name }}
                            <span class="ml-1.5 inline-flex items-center justify-center min-w-[20px] h-5 px-1.5 rounded-full text-xs font-bold"
                                :class="filter === '{{ $category->id }}' ? 'bg-white/25 text-white' : 'bg-gray-100 text-gray-600'">
                                {{ $category->themes_count }}
                            </span>
                        </button>
                        @endforeach
                    </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @forelse($themes as $theme)
                            <div
                                x-show="filter === 'all' || filter === '{{ $theme->theme_category_id ?? '0' }}'"
                                x-transition:enter="transition ease-out duration-300"
                                x-transition:enter-start="opacity-0 scale-95"
                                x-transition:enter-end="opacity-100 scale-100"
                                class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl transition-all duration-300 group">
                                <div class="relative aspect-[9/16] bg-gradient-to-br from-gray-100 to-gray-50 overflow-hidden">
                                    @if($theme->thumbnail_portrait)
                                        <img src="{{ Storage::url($theme->thumbnail_portrait) }}" alt="{{ $theme->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                    @else
                                        <div class="flex items-center justify-center h-full">
                                            <div class="text-center">
                                                <svg class="w-16 h-16 mx-auto text-gray-300 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                                <span class="text-sm text-gray-400">{{ $theme->name }}</span>
                                            </div>
                                        </div>
                                    @endif

                                    @if($theme->is_premium)
                                        <span class="absolute top-3 right-3 inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-gradient-to-r from-amber-400 to-amber-500 text-white shadow-sm">
                                            Premium
                                        </span>
                                    @else
                                        <span class="absolute top-3 right-3 inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700">
                                            Gratis
                                        </span>
                                    @endif
                                </div>

                                <div class="p-6">
                                    <h3 class="text-xl font-bold text-gray-900 mb-3">{{ $theme->name }}</h3>

                                    <div class="flex gap-3">
                                        <a
                                            href="{{ route('theme.preview', str_replace('themes.', '', $theme->view_path)) }}"
                                            target="_blank"
                                            class="flex-1 text-center px-4 py-2.5 border-2 border-indigo-200 text-indigo-600 rounded-xl text-sm font-semibold hover:bg-indigo-50 hover:border-indigo-300 transition-all duration-200"
                                        >
                                            Pratinjau
                                        </a>

                                        @auth
                                            <a href="{{ route('dashboard.invitations.create', ['theme' => str_replace('themes.', '', $theme->view_path)]) }}"
                                               class="flex-1 text-center px-4 py-2.5 bg-gradient-to-r from-indigo-600 to-indigo-700 text-white rounded-xl text-sm font-semibold hover:from-indigo-700 hover:to-indigo-800 transition-all duration-200 shadow-sm"
                                            >
                                                Gunakan Tema Ini
                                            </a>
                                        @else
                                            <a href="{{ route('register', ['theme' => str_replace('themes.', '', $theme->view_path)]) }}"
                                               class="flex-1 text-center px-4 py-2.5 bg-gradient-to-r from-indigo-600 to-indigo-700 text-white rounded-xl text-sm font-semibold hover:from-indigo-700 hover:to-indigo-800 transition-all duration-200 shadow-sm"
                                            >
                                                Gunakan Tema Ini
                                            </a>
                                        @endauth
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full py-12 text-center text-gray-500">
                                <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.53 16.122a3 3 0 00-5.78 1.128 2.25 2.25 0 01-2.4 2.245 4.5 4.5 0 008.4-2.245c0-.399-.078-.78-.22-1.128zm0 0a15.998 15.998 0 003.388-1.62m-5.043-.025a15.994 15.994 0 011.622-3.395m3.42 3.42a15.995 15.995 0 004.764-4.648l3.876-5.814a1.151 1.151 0 00-1.597-1.597L14.146 6.32a15.996 15.996 0 00-4.649 4.763m3.42 3.42a6.776 6.776 0 00-3.42-3.42" />
                                </svg>
                                <p class="text-lg">Belum ada tema tersedia. Silakan hubungi admin.</p>
                            </div>
                        @endforelse
                    </div>

                    @if($totalThemes > 9)
                        <div class="mt-10 text-center">
                            <a href="{{ route('themes.index') }}"
                               class="inline-flex items-center px-8 py-3.5 border border-gray-300 text-base font-semibold rounded-xl text-gray-700 bg-white hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 shadow-sm"
                            >
                                Lihat Semua Tema ({{ $totalThemes }})
                                <svg class="ml-2 w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                </svg>
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Feature Section -->
            <div x-data="reveal" :class="visible || 'opacity-0 translate-y-8'" class="py-16 bg-white transition-all duration-700">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="lg:text-center">
                        <h2 class="text-base text-indigo-600 font-semibold tracking-wide uppercase">Fitur Unggulan</h2>
                        <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                            Semua yang Anda butuhkan
                        </p>
                        <p class="mt-4 max-w-2xl text-xl text-gray-500 lg:mx-auto">
                            Rayakan Digital menyediakan fitur lengkap untuk mempermudah tamu dan mempercantik undangan Anda.
                        </p>
                    </div>

                    <div class="mt-10">
                        <div class="space-y-10 md:space-y-0 md:grid md:grid-cols-2 md:gap-x-8 md:gap-y-10">
                            <div class="relative">
                                <dt>
                                    <div class="absolute flex items-center justify-center h-12 w-12 rounded-xl bg-indigo-500 text-white">
                                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                                        </svg>
                                    </div>
                                    <p class="ml-16 text-lg leading-6 font-medium text-gray-900">Manajemen RSVP</p>
                                </dt>
                                <dd class="mt-2 ml-16 text-base text-gray-500">
                                    Ketahui siapa saja yang akan hadir ke acara Anda. Sistem RSVP terintegrasi langsung di dashboard.
                                </dd>
                            </div>

                            <div class="relative">
                                <dt>
                                    <div class="absolute flex items-center justify-center h-12 w-12 rounded-xl bg-indigo-500 text-white">
                                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                                        </svg>
                                    </div>
                                    <p class="ml-16 text-lg leading-6 font-medium text-gray-900">Link Personal</p>
                                </dt>
                                <dd class="mt-2 ml-16 text-base text-gray-500">
                                    Sapa tamu dengan nama mereka. Generate link khusus untuk setiap tamu lengkap dengan template pesan WhatsApp.
                                </dd>
                            </div>

                            <div class="relative">
                                <dt>
                                    <div class="absolute flex items-center justify-center h-12 w-12 rounded-xl bg-indigo-500 text-white">
                                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <p class="ml-16 text-lg leading-6 font-medium text-gray-900">Digital Gift (Angpao)</p>
                                </dt>
                                <dd class="mt-2 ml-16 text-base text-gray-500">
                                    Mudahkan tamu untuk memberikan kado atau angpao melalui transfer bank atau scan e-wallet.
                                </dd>
                            </div>

                            <div class="relative">
                                <dt>
                                    <div class="absolute flex items-center justify-center h-12 w-12 rounded-xl bg-indigo-500 text-white">
                                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z" />
                                        </svg>
                                    </div>
                                    <p class="ml-16 text-lg leading-6 font-medium text-gray-900">Buku Tamu Interaktif</p>
                                </dt>
                                <dd class="mt-2 ml-16 text-base text-gray-500">
                                    Terima ucapan dan doa dari para tamu undangan secara real-time di halaman undangan Anda.
                                </dd>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pricing Section -->
            <div id="pricing" x-data="reveal" :class="visible || 'opacity-0 translate-y-8'" class="bg-gradient-to-b from-gray-50 to-white py-16 transition-all duration-700">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="sm:flex sm:flex-col sm:align-center">
                        <h2 class="text-3xl font-extrabold text-gray-900 sm:text-center">Paket Harga Transparan</h2>
                        <p class="mt-5 text-xl text-gray-500 sm:text-center">Mulai dari gratis, upgrade kapan saja sesuai kebutuhan acara Anda.</p>
                    </div>
                    <div class="mt-12 space-y-4 sm:mt-16 sm:space-y-0 sm:grid sm:grid-cols-2 sm:gap-6 lg:max-w-4xl lg:mx-auto xl:max-w-none xl:mx-0 xl:grid-cols-4">

                        @forelse($packages as $package)
                            <div class="border rounded-2xl shadow-sm divide-y divide-gray-200 hover:shadow-lg transition-shadow duration-300 relative
                                {{ $package->is_popular ? 'border-2 border-indigo-500 shadow-lg' : 'border-gray-200' }}
                            ">
                                @if($package->is_popular)
                                    <div class="absolute top-0 right-0 -translate-y-1/2 translate-x-1/4">
                                        <span class="inline-flex rounded-full bg-gradient-to-r from-indigo-500 to-indigo-600 px-4 py-1 text-sm font-bold text-white shadow-lg shadow-indigo-200">Best Seller</span>
                                    </div>
                                @endif
                                <div class="p-6">
                                    <h2 class="text-lg leading-6 font-medium {{ $package->is_popular ? 'text-indigo-600' : 'text-gray-900' }}">
                                        {{ $package->package_name }}
                                    </h2>
                                    @if($package->description)
                                        <p class="mt-4 text-sm text-gray-500">{{ $package->description }}</p>
                                    @endif
                                    <p class="mt-8">
                                        @if($package->slashed_price && $package->slashed_price > $package->price)
                                            <span class="text-lg text-gray-400 line-through">Rp {{ number_format($package->slashed_price, 0, ',', '.') }}</span>
                                        @endif
                                        <span class="text-4xl font-extrabold text-gray-900">Rp {{ number_format($package->price, 0, ',', '.') }}</span>
                                        @if($package->price > 0)
                                            <span class="text-sm text-gray-500 ml-1">/ {{ $package->active_period_days === 0 ? 'Lifetime' : $package->active_period_days . ' Hari' }}</span>
                                        @endif
                                    </p>
                                    @auth
                                        @if($package->package_code === 'free')
                                            <p class="mt-8 block w-full bg-gray-100 text-gray-500 rounded-xl py-2.5 text-sm font-semibold text-center cursor-default">Paket Aktif</p>
                                        @else
                                            <a href="{{ route('dashboard.checkout') }}" class="mt-8 block w-full rounded-xl py-2.5 text-sm font-semibold text-center transition-all duration-200
                                                {{ $package->is_popular
                                                    ? 'bg-gradient-to-r from-indigo-600 to-indigo-700 text-white hover:from-indigo-700 hover:to-indigo-800 shadow-sm'
                                                    : 'bg-indigo-50 border border-indigo-200 text-indigo-700 hover:bg-indigo-100' }}
                                            ">Pilih {{ $package->package_name }}</a>
                                        @endif
                                    @else
                                        @if($package->package_code === 'free')
                                            <a href="{{ route('register') }}" class="mt-8 block w-full bg-gray-800 border border-gray-800 rounded-xl py-2.5 text-sm font-semibold text-white text-center hover:bg-gray-900 transition-colors">Daftar Gratis</a>
                                        @else
                                            <a href="{{ route('register') }}" class="mt-8 block w-full rounded-xl py-2.5 text-sm font-semibold text-center transition-all duration-200
                                                {{ $package->is_popular
                                                    ? 'bg-gradient-to-r from-indigo-600 to-indigo-700 text-white hover:from-indigo-700 hover:to-indigo-800 shadow-sm'
                                                    : 'bg-indigo-50 border border-indigo-200 text-indigo-700 hover:bg-indigo-100' }}
                                            ">Pilih {{ $package->package_name }}</a>
                                        @endif
                                    @endauth
                                </div>
                                <div class="pt-6 pb-8 px-6">
                                    <h3 class="text-xs font-medium text-gray-900 tracking-wide uppercase">Fitur Termasuk</h3>
                                    <ul role="list" class="mt-6 space-y-4">
                                        @forelse($package->features as $feature)
                                            <li class="flex space-x-3 text-sm text-gray-500">
                                                <span class="text-emerald-500 flex-shrink-0">&#10003;</span>
                                                <span>{{ $feature->feature_name }}</span>
                                            </li>
                                        @empty
                                            <li class="text-sm text-gray-400 italic">Fitur dasar</li>
                                        @endforelse
                                    </ul>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full py-12 text-center text-gray-500">
                                <p class="text-lg">Belum ada paket tersedia. Silakan hubungi admin.</p>
                            </div>
                        @endforelse

                    </div>
                </div>
            </div>

            <!-- Back to Top -->
            <button x-show="showBackToTop"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0"
                    x-transition:leave-end="opacity-0 translate-y-4"
                    @click="window.scrollTo({ top: 0, behavior: 'smooth' })"
                    class="fixed bottom-6 right-6 z-50 p-3.5 rounded-full bg-indigo-600 text-white shadow-lg hover:bg-indigo-700 hover:shadow-xl transition-all duration-200 cursor-pointer">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5" />
                </svg>
            </button>
        </div>
    </div>

    <footer class="bg-white border-t border-gray-200">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
            <p class="text-center text-base text-gray-500">
                &copy; {{ date('Y') }} Rayakan Digital. All rights reserved.
            </p>
        </div>
    </footer>
</body>
</html>
