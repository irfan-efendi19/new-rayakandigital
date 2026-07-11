<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <x-meta />

    @stack('meta')

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link
        href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800|playfair-display:400,500,600,700&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        if (localStorage.getItem('dark-mode') === 'true' || (!('dark-mode' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>

<body class="font-sans antialiased bg-neutral-50 dark:bg-secondary-900 text-secondary-800 dark:text-neutral-200">
    <div class="min-h-screen flex flex-col">
        @include('layouts.navigation')

        @isset($header)
            <header
                class="bg-white dark:bg-secondary-800 border-b border-neutral-200 dark:border-secondary-700 shadow-soft">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        @if(Auth::check() && Auth::user()->is_impersonated ?? false)
            <div
                class="bg-amber-500 dark:bg-amber-600 text-white text-sm font-medium px-4 py-2.5 flex items-center justify-center gap-2">
                <i class="fa-solid fa-eye text-sm flex-shrink-0"></i>
                <span>Anda sedang mengintip dasbor sebagai <strong>{{ Auth::user()->name }}</strong></span>
                <form action="{{ route('admin.impersonate.leave') }}" method="POST" class="inline-flex">
                    @csrf
                    <button type="submit"
                        class="ml-2 inline-flex items-center gap-1 px-3 py-1 bg-white/20 hover:bg-white/30 rounded-lg text-xs font-semibold transition-colors">
                        Kembali ke Admin
                        <i class="fa-solid fa-arrow-right text-[11px]"></i>
                    </button>
                </form>
            </div>
        @endif

        <main class="flex-1">
            {{ $slot }}
        </main>

        <footer class="bg-white dark:bg-secondary-800 border-t border-neutral-200 dark:border-secondary-700 py-6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <p class="text-center text-sm text-neutral-500 dark:text-neutral-400">
                    &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
                </p>
            </div>
        </footer>
    </div>
    @if(request()->is('dashboard/*') && !request()->is('*/edit*') && !request()->is('*/create*'))
    <a href="https://wa.me/{{ config('app.whatsapp_number', '62895349823366') }}?text={{ urlencode('Halo, saya ingin bertanya terkait layanan undangan digital.') }}"
        target="_blank" rel="noopener noreferrer"
        class="fixed bottom-4 right-4 z-50 inline-flex items-center gap-2 rounded-full bg-emerald-500 hover:bg-emerald-600 px-4 py-3 text-white shadow-lg shadow-emerald-500/30 transition-all duration-200 hover:scale-105">
        <i class="fa-brands fa-whatsapp text-xl"></i>
        <span class="text-sm font-semibold">Butuh Bantuan?</span>
    </a>
    @endif
    <x-sweet-alert />
</body>

</html>