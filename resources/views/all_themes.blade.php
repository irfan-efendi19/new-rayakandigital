<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <x-meta title="Katalog Tema Undangan - Rayakan Digital"
        description="Jelajahi katalog desain undangan digital premium. Lihat pratinjau langsung dengan data contoh dan pilih tema favorit Anda."
        keywords="tema undangan, desain undangan digital, template undangan pernikahan, katalog tema"
        image="{{ asset('img/thumnail.jpg') }}" />

    @stack('meta')

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/landingpage.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    <script>
        if (localStorage.getItem('dark-mode') === 'true' || (!('dark-mode' in localStorage) && window.matchMedia(
                '(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    <style>
        /* ── Page base ── */
        body { background-color: #FDFCFA; }
        .dark body, .dark { background-color: #0A0A0A; }

        /* ── Grain texture ── */
        .grain::before {
            content: '';
            position: fixed;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.025'/%3E%3C/svg%3E");
            pointer-events: none;
            z-index: 0;
        }

        /* ── Filter pills ── */
        .filter-pill {
            position: relative;
            transition: all 0.2s cubic-bezier(.4,0,.2,1);
        }
        .filter-pill.active {
            color: #fff;
        }
        .filter-pill.active::before {
            content: '';
            position: absolute;
            inset: 0;
            background: #FF7A00;
            border-radius: inherit;
            z-index: -1;
        }

        /* ── Theme card ── */
        .theme-card {
            transition: transform 0.35s cubic-bezier(.4,0,.2,1), box-shadow 0.35s cubic-bezier(.4,0,.2,1);
        }
        .theme-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 32px 64px -16px rgba(0,0,0,0.22);
        }
        .theme-card:hover .card-overlay {
            opacity: 1;
        }
        .theme-card:hover .card-thumb {
            transform: scale(1.05);
        }
        .theme-card:hover .accent-bar {
            transform: scaleX(1);
        }

        .card-thumb {
            transition: transform 0.6s cubic-bezier(.4,0,.2,1);
        }
        .card-overlay {
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        .accent-bar {
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.45s cubic-bezier(.4,0,.2,1);
        }

        /* ── Hero number ── */
        .hero-number {
            font-size: clamp(7rem, 18vw, 14rem);
            line-height: 0.85;
            font-weight: 900;
            letter-spacing: -0.04em;
            background: linear-gradient(135deg, #FF7A00 0%, #FFD0A3 50%, transparent 100%);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            pointer-events: none;
            user-select: none;
        }

        /* ── Search input ── */
        #theme-search:focus {
            outline: none;
            border-color: #FF7A00;
            box-shadow: 0 0 0 3px rgba(255,122,0,0.12);
        }

        /* ── Scrollbar ── */
        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #FF7A00; border-radius: 3px; }

        /* ── Empty state ── */
        @keyframes float {
            0%,100% { transform: translateY(0); }
            50%      { transform: translateY(-12px); }
        }
        .float-anim { animation: float 3.5s ease-in-out infinite; }
    </style>
</head>

<body class="font-sans antialiased text-secondary-800 dark:text-neutral-200 grain">
    <x-public-navbar />
    <div class="h-16"></div>

    <div x-data="{
        filter: 'all',
        search: '',
        get activeLabel() {
            return this.filter === 'all' ? 'Semua' : document.querySelector('[data-cat-name][data-cat-id=\'' + this.filter + '\']')?.dataset.catName ?? ''
        }
    }" class="min-h-screen">

        {{-- ═══════════════════════════════════════
             PAGE HEADER — Editorial
        ═══════════════════════════════════════ --}}
        <header class="relative overflow-hidden bg-[#FDFCFA] dark:bg-secondary-900 border-b border-neutral-100 dark:border-secondary-800">

            {{-- Background grid --}}
            <div class="absolute inset-0 pointer-events-none"
                style="background-image: linear-gradient(rgba(148,163,184,.05) 1px, transparent 1px), linear-gradient(90deg, rgba(148,163,184,.05) 1px, transparent 1px); background-size: 40px 40px;">
            </div>

            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-8 pt-14 pb-12">

                    {{-- Left: Title block --}}
                    <div class="relative">
                        {{-- Giant decorative number --}}
                        <div class="absolute -top-6 -left-4 pointer-events-none select-none hidden lg:block">
                            <span class="hero-number">{{ $themes->count() }}</span>
                        </div>

                        <div class="relative z-10 lg:pl-2">
                            <div class="flex items-center gap-2.5 mb-4">
                                <a href="{{ route('home') }}"
                                    class="inline-flex items-center gap-1.5 text-xs text-neutral-400 hover:text-primary-500 transition-colors duration-200">
                                    <i class="fas fa-home text-[10px]"></i>
                                    Beranda
                                </a>
                                <i class="fas fa-chevron-right text-[9px] text-neutral-300"></i>
                                <span class="text-xs text-primary-500 font-semibold">Katalog Tema</span>
                            </div>

                            <h1 class="font-heading text-4xl md:text-5xl lg:text-6xl font-bold text-secondary-900 dark:text-neutral-100 leading-[1.05] mb-4">
                                Pilih Desain<br>
                                <span class="text-primary-500">Undanganmu.</span>
                            </h1>
                            <p class="text-neutral-500 dark:text-neutral-400 text-base max-w-md leading-relaxed">
                                Pratinjau langsung dengan data contoh nyata. Temukan tema yang paling mencerminkan kisah cintamu.
                            </p>
                        </div>
                    </div>

                    {{-- Right: Search + stats --}}
                    <div class="flex flex-col gap-4 lg:items-end">
                        {{-- Search --}}
                        <div class="relative w-full lg:w-72">
                            <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-neutral-400 text-sm pointer-events-none"></i>
                            <input
                                id="theme-search"
                                type="text"
                                x-model="search"
                                placeholder="Cari nama tema..."
                                class="w-full pl-10 pr-4 py-3 rounded-2xl border border-neutral-200 dark:border-secondary-700 bg-white dark:bg-secondary-800 text-sm text-secondary-800 dark:text-neutral-200 placeholder-neutral-400 transition-all duration-200">
                        </div>

                        {{-- Stats row --}}
                        <div class="flex items-center gap-5 text-xs text-neutral-400">
                            <div class="flex items-center gap-1.5">
                                <span class="font-bold text-secondary-800 dark:text-neutral-200 text-lg">{{ $themes->count() }}</span>
                                <span>Tema Tersedia</span>
                            </div>
                            <span class="w-px h-5 bg-neutral-200 dark:bg-secondary-700"></span>
                            <div class="flex items-center gap-1.5">
                                <i class="fas fa-star text-amber-400 text-xs"></i>
                                <span>Rating 4.9/5</span>
                            </div>
                            <span class="w-px h-5 bg-neutral-200 dark:bg-secondary-700"></span>
                            <div class="flex items-center gap-1.5">
                                <i class="fas fa-gem text-emerald-400 text-xs"></i>
                                <span>Ada yang gratis</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        {{-- ═══════════════════════════════════════
             FILTER BAR — Sticky
        ═══════════════════════════════════════ --}}
        <div class="sticky top-16 z-30 bg-[#FDFCFA]/90 dark:bg-secondary-900/90 backdrop-blur-md border-b border-neutral-100 dark:border-secondary-800">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center gap-2 py-3 overflow-x-auto hide-scrollbar">

                    {{-- Active label indicator --}}
                    <span class="hidden md:flex items-center gap-1.5 text-xs text-neutral-400 flex-shrink-0 mr-2">
                        <i class="fas fa-filter text-primary-400"></i>
                        Filter:
                    </span>

                    {{-- All button --}}
                    <button @click="filter = 'all'"
                        :class="filter === 'all'
                            ? 'bg-primary-500 text-white border-primary-500 shadow-md shadow-primary-200/50'
                            : 'bg-white dark:bg-secondary-800 text-neutral-600 dark:text-neutral-400 border-neutral-200 dark:border-secondary-700 hover:border-primary-300 hover:text-primary-600'"
                        class="flex-shrink-0 flex items-center gap-1.5 px-4 py-2 rounded-full text-xs font-semibold border transition-all duration-200">
                        <i class="fas fa-th-large text-[10px]"></i>
                        Semua
                        <span :class="filter === 'all' ? 'bg-white/25 text-white' : 'bg-neutral-100 dark:bg-secondary-700 text-neutral-500'"
                            class="inline-flex items-center justify-center w-5 h-5 rounded-full text-[10px] font-bold">
                            {{ $themes->count() }}
                        </span>
                    </button>

                    @if($categories->isNotEmpty())
                        <div class="w-px h-5 bg-neutral-200 dark:bg-secondary-700 flex-shrink-0 mx-1"></div>
                        @foreach($categories as $category)
                            <button @click="filter = '{{ $category->id }}'"
                                data-cat-id="{{ $category->id }}"
                                data-cat-name="{{ $category->name }}"
                                :class="filter === '{{ $category->id }}'
                                    ? 'bg-primary-500 text-white border-primary-500 shadow-md shadow-primary-200/50'
                                    : 'bg-white dark:bg-secondary-800 text-neutral-600 dark:text-neutral-400 border-neutral-200 dark:border-secondary-700 hover:border-primary-300 hover:text-primary-600'"
                                class="flex-shrink-0 flex items-center gap-1.5 px-4 py-2 rounded-full text-xs font-semibold border transition-all duration-200">
                                <i class="fas {{ $category->icon ?? 'fa-folder' }} text-[10px]"></i>
                                {{ $category->name }}
                                <span :class="filter === '{{ $category->id }}' ? 'bg-white/25 text-white' : 'bg-neutral-100 dark:bg-secondary-700 text-neutral-500'"
                                    class="inline-flex items-center justify-center w-5 h-5 rounded-full text-[10px] font-bold">
                                    {{ $category->themes_count }}
                                </span>
                            </button>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>

        {{-- ═══════════════════════════════════════
             THEME GRID
        ═══════════════════════════════════════ --}}
        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

            {{-- Result count --}}
            <div class="flex items-center justify-between mb-8">
                <p class="text-xs text-neutral-400">
                    Menampilkan <span class="font-semibold text-secondary-800 dark:text-neutral-200">{{ $themes->count() }}</span> tema
                    <span x-show="filter !== 'all'" class="text-primary-500">
                        — <span x-text="activeLabel"></span>
                    </span>
                </p>
                <p class="text-xs text-neutral-400 hidden sm:block">
                    Klik thumbnail untuk pratinjau langsung
                </p>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4 lg:gap-5">
                @forelse($themes as $theme)
                    <div
                        x-show="
                            (filter === 'all' || filter === '{{ $theme->theme_category_id ?? '0' }}') &&
                            (search === '' || '{{ strtolower($theme->name) }}'.includes(search.toLowerCase()))
                        "
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 scale-95"
                        x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 scale-100"
                        x-transition:leave-end="opacity-0 scale-95"
                        class="theme-card rounded-2xl overflow-hidden shadow-[0_2px_16px_rgba(0,0,0,0.07)] dark:shadow-[0_2px_16px_rgba(0,0,0,0.3)] border border-neutral-100 dark:border-secondary-700 bg-white dark:bg-secondary-800">

                        {{-- ── Thumbnail zone ── --}}
                        <div class="relative aspect-[3/4] overflow-hidden bg-neutral-100 dark:bg-secondary-700">

                            {{-- Background image --}}
                            @if($theme->thumbnail_portrait)
                                <img
                                    src="{{ Storage::url($theme->thumbnail_portrait) }}"
                                    alt="{{ $theme->name }}"
                                    loading="lazy"
                                    class="card-thumb absolute inset-0 w-full h-full object-cover">
                            @else
                                {{-- Placeholder --}}
                                <div class="absolute inset-0 bg-gradient-to-br from-primary-50 to-tertiary dark:from-secondary-700 dark:to-secondary-800 flex items-center justify-center">
                                    <div class="text-center">
                                        <i class="fas fa-images text-3xl text-primary-300 dark:text-primary-600 mb-2 block"></i>
                                        <span class="text-xs text-neutral-400 px-3 text-center leading-snug">{{ $theme->name }}</span>
                                    </div>
                                </div>
                            @endif

                            {{-- Dark scrim top --}}
                            <div class="absolute inset-0 bg-gradient-to-b from-black/30 via-transparent to-black/10 pointer-events-none"></div>

                            {{-- Badges top-left --}}
                            <div class="absolute top-2.5 left-2.5 z-10">
                                @if($theme->is_premium)
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold bg-gradient-to-r from-amber-400 to-amber-500 text-white shadow-md">
                                        <i class="fas fa-crown" style="font-size:8px"></i> Premium
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold bg-white/90 backdrop-blur-sm text-emerald-700 border border-emerald-200/60">
                                        <i class="fas fa-gem" style="font-size:8px"></i> Gratis
                                    </span>
                                @endif
                            </div>

                            {{-- Rating badge top-right --}}
                            @if($theme->rating)
                                <div class="absolute top-2.5 right-2.5 z-10 inline-flex items-center gap-1 px-2 py-1 rounded-full text-[10px] font-semibold bg-white/90 backdrop-blur-sm text-amber-700 border border-amber-200/60 shadow-sm">
                                    <i class="fas fa-star text-amber-400" style="font-size:8px"></i>
                                    {{ $theme->rating }}
                                </div>
                            @endif

                            {{-- Hover overlay — click to preview --}}
                            <a href="{{ route('theme.preview', str_replace('themes.', '', $theme->view_path)) }}"
                                target="_blank"
                                class="card-overlay absolute inset-0 z-20 flex flex-col items-center justify-end pb-5"
                                style="background: linear-gradient(to top, rgba(0,0,0,0.75) 0%, rgba(0,0,0,0.2) 50%, transparent 100%);">
                                <span class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-white text-xs font-bold hover:scale-105 transition-transform duration-200"
                                    style="background: rgba(255,255,255,0.15); backdrop-filter: blur(8px); border: 1px solid rgba(255,255,255,0.25);">
                                    <i class="fas fa-eye text-xs"></i>
                                    Lihat Pratinjau
                                </span>
                            </a>
                        </div>

                        {{-- ── Accent line on hover ── --}}
                        <div class="accent-bar h-0.5 bg-gradient-to-r from-primary-400 to-primary-600"></div>

                        {{-- ── Card body ── --}}
                        <div class="p-4">
                            <h3 class="font-bold text-sm text-secondary-800 dark:text-neutral-200 leading-snug mb-1.5 truncate">
                                {{ $theme->name }}
                            </h3>

                            @if($theme->category)
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-primary-50 dark:bg-primary-900/20 text-primary-600 dark:text-primary-400 rounded text-[10px] font-semibold mb-3">
                                    <i class="fas fa-tag" style="font-size:8px"></i>
                                    {{ $theme->category->name }}
                                </span>
                            @else
                                <div class="mb-3"></div>
                            @endif

                            {{-- CTA buttons --}}
                            <div class="flex items-center gap-2">
                                @auth
                                    <a href="{{ route('dashboard.invitations.create', ['theme' => str_replace('themes.', '', $theme->view_path)]) }}"
                                        class="flex-1 flex items-center justify-center gap-1.5 py-2.5 rounded-xl bg-primary-500 hover:bg-primary-600 text-white text-xs font-bold transition-colors duration-200 shadow-sm hover:shadow-md active:scale-95">
                                        <i class="fas fa-magic" style="font-size:9px"></i>
                                        Gunakan
                                    </a>
                                @else
                                    <a href="{{ route('register', ['theme' => str_replace('themes.', '', $theme->view_path)]) }}"
                                        class="flex-1 flex items-center justify-center gap-1.5 py-2.5 rounded-xl bg-primary-500 hover:bg-primary-600 text-white text-xs font-bold transition-colors duration-200 shadow-sm hover:shadow-md active:scale-95">
                                        <i class="fas fa-magic" style="font-size:9px"></i>
                                        Gunakan
                                    </a>
                                @endauth

                                <a href="{{ route('theme.preview', str_replace('themes.', '', $theme->view_path)) }}"
                                    target="_blank"
                                    title="Lihat Pratinjau"
                                    class="flex items-center justify-center w-9 h-9 rounded-xl border border-neutral-200 dark:border-secondary-600 text-neutral-400 hover:border-primary-400 hover:text-primary-500 dark:hover:border-primary-500 dark:hover:text-primary-400 transition-all duration-200 hover:bg-primary-50 dark:hover:bg-primary-900/20 active:scale-95 flex-shrink-0">
                                    <i class="fas fa-eye text-xs"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    {{-- Empty state --}}
                    <div class="col-span-full py-24 flex flex-col items-center justify-center text-center">
                        <div class="float-anim mb-6">
                            <div class="w-24 h-24 rounded-3xl bg-primary-50 dark:bg-primary-900/20 flex items-center justify-center mx-auto">
                                <i class="fas fa-paintbrush text-4xl text-primary-300 dark:text-primary-600"></i>
                            </div>
                        </div>
                        <h3 class="font-heading text-2xl font-bold text-secondary-800 dark:text-neutral-200 mb-2">
                            Belum ada tema tersedia
                        </h3>
                        <p class="text-neutral-400 text-sm max-w-xs leading-relaxed mb-6">
                            Tim kami sedang menyiapkan desain-desain baru yang akan membuatmu terpesona.
                        </p>
                        <a href="https://wa.me/62895349823366"
                            class="inline-flex items-center gap-2 px-6 py-3 bg-secondary-900 dark:bg-secondary-700 text-white text-sm font-bold rounded-2xl hover:bg-secondary-800 transition-colors duration-200">
                            <i class="fab fa-whatsapp text-green-400"></i>
                            Hubungi Admin
                        </a>
                    </div>
                @endforelse
            </div>

            {{-- ── No search results ── --}}
            <div x-show="search !== '' && {{ $themes->count() }} > 0"
                x-cloak
                class="hidden" {{-- Fallback — Alpine handles visibility --}}>
            </div>

        </main>

        {{-- ═══════════════════════════════════════
             BOTTOM CTA STRIP
        ═══════════════════════════════════════ --}}
        <div class="border-t border-neutral-100 dark:border-secondary-800 bg-[#FDFCFA] dark:bg-secondary-900">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-6 bg-secondary-900 dark:bg-black/40 rounded-3xl px-8 py-8">
                    <div>
                        <h3 class="font-heading text-xl font-bold text-white mb-1">Tidak menemukan tema yang pas?</h3>
                        <p class="text-neutral-400 text-sm">Kami bisa bantu rekomendasi tema terbaik untuk acara Anda.</p>
                    </div>
                    <div class="flex flex-col sm:flex-row gap-3 flex-shrink-0">
                        <a href="https://wa.me/62895349823366?text=Halo%20Rayakan%20Digital%2C%20saya%20ingin%20rekomendasi%20tema%20undangan."
                            target="_blank"
                            class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-primary-500 hover:bg-primary-600 text-white text-sm font-bold rounded-2xl transition-all duration-200 shadow-lg shadow-primary-900/30 hover:shadow-primary-900/50">
                            <i class="fab fa-whatsapp"></i>
                            Minta Rekomendasi
                        </a>
                        @guest
                            <a href="{{ route('register') }}"
                                class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-white/8 border border-white/15 text-white text-sm font-semibold rounded-2xl hover:bg-white/15 transition-all duration-200">
                                <i class="fas fa-gem text-amber-400 text-xs"></i>
                                Daftar Gratis
                            </a>
                        @endguest
                    </div>
                </div>
            </div>
        </div>

    </div>{{-- end x-data --}}

    <x-public-footer />
    <script src="{{ asset('js/landingpage.js') }}"></script>
</body>

</html>