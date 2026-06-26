<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <x-meta title="Semua Tema - Rayakan Digital"
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
</head>

<body class="font-sans antialiased bg-tertiary dark:bg-secondary-900 text-secondary-800 dark:text-neutral-200">
    <x-public-navbar />

    <!-- Spacer to prevent content from hiding behind fixed navbar -->
    <div class="h-16"></div>

    <div class="min-h-screen bg-tertiary dark:bg-secondary-900">
        <div class="py-16 bg-tertiary dark:bg-secondary-900 min-h-screen">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-base text-primary-600 font-semibold tracking-wide uppercase">Katalog Tema</h2>
                    <p
                        class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-secondary-900 dark:text-neutral-100 sm:text-4xl font-heading">
                        Semua Desain Undangan
                    </p>
                    <p class="mt-4 max-w-2xl text-xl text-neutral-500 mx-auto">
                        Lihat pratinjau langsung dengan data contoh. Klik "Gunakan Tema Ini" untuk langsung mulai.
                    </p>
                </div>

                <div x-data="{ filter: 'all' }">
                    @if($categories->isNotEmpty())
                        <div class="flex flex-wrap justify-center gap-3 mb-10">
                            <button @click="filter = 'all'"
                                :class="filter === 'all' ? 'bg-primary-600 text-white border-primary-600' : 'bg-white text-secondary-600 border-neutral-200 dark:border-secondary-700 hover:border-primary-300 hover:text-primary-600'"
                                class="px-5 py-2.5 rounded-full text-sm font-semibold transition-all duration-200 border-2 shadow-soft">
                                Semua
                                <span
                                    class="ml-1.5 inline-flex items-center justify-center min-w-[20px] h-5 px-1.5 rounded-full text-xs font-bold"
                                    :class="filter === 'all' ? 'bg-white/25 text-white' : 'bg-neutral-100 text-secondary-500'">
                                    {{ $themes->count() }}
                                </span>
                            </button>

                            @foreach($categories as $category)
                                <button @click="filter = '{{ $category->id }}'"
                                    :class="filter === '{{ $category->id }}' ? 'bg-primary-600 text-white border-primary-600' : 'bg-white text-secondary-600 border-neutral-200 dark:border-secondary-700 hover:border-primary-300 hover:text-primary-600'"
                                    class="px-5 py-2.5 rounded-full text-sm font-semibold transition-all duration-200 border-2 shadow-soft">
                                    {{ $category->name }}
                                    <span
                                        class="ml-1.5 inline-flex items-center justify-center min-w-[20px] h-5 px-1.5 rounded-full text-xs font-bold"
                                        :class="filter === '{{ $category->id }}' ? 'bg-white/25 text-white' : 'bg-neutral-100 text-secondary-500'">
                                        {{ $category->themes_count }}
                                    </span>
                                </button>
                            @endforeach
                        </div>
                    @endif

                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-4 gap-6">
                        @forelse($themes as $theme)
                            <div x-show="filter === 'all' || filter === '{{ $theme->theme_category_id ?? '0' }}'"
                                x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95"
                                x-transition:enter-end="opacity-100 scale-100"
                                class="rounded-2xl transition-all duration-500 ease-out hover:shadow-2xl hover:-translate-y-1.5 shadow-soft">

                                <div class="relative rounded-2xl overflow-hidden border border-neutral-100 dark:border-secondary-700/50 group">

                                    {{-- Full-card background image --}}
                                    @if($theme->thumbnail_portrait)
                                        <img src="{{ Storage::url($theme->thumbnail_portrait) }}" alt="{{ $theme->name }}"
                                            class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 ease-out group-hover:scale-105">
                                    @endif

                                    {{-- Content overlay --}}
                                    <div class="relative z-10 flex flex-col">
                                        <div class="relative aspect-[4/5]">
                                            @if(!$theme->thumbnail_portrait)
                                                <div class="absolute inset-0 bg-gradient-to-br from-secondary-50 to-tertiary flex items-center justify-center">
                                                    <div class="text-center">
                                                        <div
                                                            class="w-20 h-20 mx-auto bg-gradient-to-br from-primary-100 to-primary-50 rounded-2xl flex items-center justify-center mb-3">
                                                            <i class="fas fa-images text-3xl text-primary-400"></i>
                                                        </div>
                                                        <span class="text-sm text-neutral-400">{{ $theme->name }}</span>
                                                        </div>
                                                        </div>
                                            @else
                                                <div class="absolute inset-0 bg-gradient-to-b from-black/20 to-transparent"></div>
                                            @endif

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

                                            @if($theme->rating)
                                                <div
                                                    class="absolute top-3 right-3 z-20 inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-semibold bg-white/90 backdrop-blur-sm text-amber-700 shadow-sm border border-amber-200/50">
                                                    <i class="fas fa-star text-amber-400 text-[10px]"></i>
                                                    <span>{{ $theme->rating }}</span>
                                                </div>
                                            @endif

                                            <div class="absolute inset-0 z-10 opacity-0 group-hover:opacity-100 transition-all duration-300 flex items-center justify-center"
                                                style="background: linear-gradient(to top, rgba(0,0,0,0.7) 0%, rgba(0,0,0,0.15) 50%, transparent 100%);">
                                                <a href="{{ route('theme.preview', str_replace('themes.', '', $theme->view_path)) }}" target="_blank"
                                                    class="flex items-center gap-2 px-5 py-2.5 rounded-xl text-white text-sm font-semibold transition-all duration-200 hover:scale-105"
                                                    style="background: rgba(255,255,255,0.15); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.25);">
                                                    <i class="fas fa-eye text-xs"></i> Lihat Pratinjau
                                                </a>
                                            </div>
                                            </div>

                                            <div
                                                class="h-0.5 bg-gradient-to-r from-primary-400 via-primary-500 to-primary-600 scale-x-0 group-hover:scale-x-100 transition-transform duration-500 ease-out origin-left">
                                            </div>

                                            <div class="p-5 bg-white/70 dark:bg-secondary-800/70 backdrop-blur-xl">
                                                <h3
                                                    class="text-lg font-bold text-secondary-800 dark:text-neutral-200 group-hover:text-primary-600 transition-colors leading-snug mb-2">
                                                    {{ $theme->name }}
                                                </h3>

                                            @if($theme->category)
                                                <span
                                                    class="inline-flex items-center gap-1 px-2.5 py-1 bg-primary-50 dark:bg-primary-900/30 text-primary-600 dark:text-primary-300 rounded-lg text-xs font-medium">
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
                            <div class="col-span-full py-12 text-center text-neutral-500">
                                <svg class="w-16 h-16 mx-auto text-neutral-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M9.53 16.122a3 3 0 00-5.78 1.128 2.25 2.25 0 01-2.4 2.245 4.5 4.5 0 008.4-2.245c0-.399-.078-.78-.22-1.128zm0 0a15.998 15.998 0 003.388-1.62m-5.043-.025a15.994 15.994 0 011.622-3.395m3.42 3.42a15.995 15.995 0 004.764-4.648l3.876-5.814a1.151 1.151 0 00-1.597-1.597L14.146 6.32a15.996 15.996 0 00-4.649 4.763m3.42 3.42a6.776 6.776 0 00-3.42-3.42" />
                                </svg>
                                <p class="text-lg">Belum ada tema tersedia. Silakan hubungi admin.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-public-footer />
    <script src="{{ asset('js/landingpage.js') }}"></script>
</body>

</html>