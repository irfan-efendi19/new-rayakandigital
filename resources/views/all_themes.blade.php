<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <x-meta
        title="Semua Tema - Rayakan Digital"
        description="Jelajahi katalog desain undangan digital premium. Lihat pratinjau langsung dengan data contoh dan pilih tema favorit Anda."
        keywords="tema undangan, desain undangan digital, template undangan pernikahan, katalog tema"
        image="{{ asset('img/thumnail.jpg') }}"
    />

    @stack('meta')

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/landingpage.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    <script>
        if (localStorage.getItem('dark-mode') === 'true' || (!('dark-mode' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
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
                    <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-secondary-900 dark:text-neutral-100 sm:text-4xl font-heading">
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

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @forelse($themes as $theme)
                            <div x-show="filter === 'all' || filter === '{{ $theme->theme_category_id ?? '0' }}'"
                                x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95"
                                x-transition:enter-end="opacity-100 scale-100"
                                class="bg-white dark:bg-secondary-800 rounded-2xl shadow-soft border border-neutral-100 dark:border-secondary-700 overflow-hidden hover:shadow-xl transition-all duration-300 group">
                                <div class="relative aspect-[9/16] bg-gradient-to-br from-neutral-100 to-neutral-50 overflow-hidden">
                                    @if($theme->thumbnail_portrait)
                                        <img src="{{ Storage::url($theme->thumbnail_portrait) }}" alt="{{ $theme->name }}"
                                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                    @else
                                        <div class="flex items-center justify-center h-full">
                                            <div class="text-center">
                                                <svg class="w-16 h-16 mx-auto text-neutral-300 mb-2" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                                <span class="text-sm text-neutral-400">{{ $theme->name }}</span>
                                            </div>
                                        </div>
                                    @endif

                                    @if($theme->is_premium)
                                        <span
                                            class="absolute top-3 right-3 inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-gradient-to-r from-amber-400 to-amber-500 text-white shadow-sm">
                                            Premium
                                        </span>
                                    @else
                                        <span
                                            class="absolute top-3 right-3 inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700">
                                            Gratis
                                        </span>
                                    @endif
                                </div>

                                <div class="p-6">
                                    <h3 class="text-xl font-bold text-secondary-900 dark:text-neutral-100 mb-3">{{ $theme->name }}</h3>

                                    <div class="flex gap-3">
                                        <a href="{{ route('theme.preview', str_replace('themes.', '', $theme->view_path)) }}" target="_blank"
                                            class="flex-1 text-center px-4 py-2.5 border-2 border-primary-200 text-primary-600 rounded-xl text-sm font-semibold hover:bg-primary-50 hover:border-primary-300 transition-all duration-200">
                                            Pratinjau
                                        </a>

                                        @auth
                                            <a href="{{ route('dashboard.invitations.create', ['theme' => str_replace('themes.', '', $theme->view_path)]) }}"
                                                class="flex-1 text-center px-4 py-2.5 bg-gradient-to-r from-primary-600 to-primary-700 text-white rounded-xl text-sm font-semibold hover:from-primary-700 hover:to-primary-800 transition-all duration-200 shadow-soft">
                                                Gunakan Tema Ini
                                            </a>
                                        @else
                                            <a href="{{ route('register', ['theme' => str_replace('themes.', '', $theme->view_path)]) }}"
                                                class="flex-1 text-center px-4 py-2.5 bg-gradient-to-r from-primary-600 to-primary-700 text-white rounded-xl text-sm font-semibold hover:from-primary-700 hover:to-primary-800 transition-all duration-200 shadow-soft">
                                                Gunakan Tema Ini
                                            </a>
                                        @endauth
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