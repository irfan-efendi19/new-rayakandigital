<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <x-meta />

        @stack('meta')

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800|playfair-display:400,500,600,700&display=swap" rel="stylesheet" />

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
                <header class="bg-white dark:bg-secondary-800 border-b border-neutral-200 dark:border-secondary-700 shadow-soft">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            @if(Auth::check() && Auth::user()->is_impersonated ?? false)
                <div class="bg-amber-500 dark:bg-amber-600 text-white text-sm font-medium px-4 py-2.5 flex items-center justify-center gap-2">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    <span>Anda sedang mengintip dasbor sebagai <strong>{{ Auth::user()->name }}</strong></span>
                    <form action="{{ route('admin.impersonate.leave') }}" method="POST" class="inline-flex">
                        @csrf
                        <button type="submit" class="ml-2 inline-flex items-center gap-1 px-3 py-1 bg-white/20 hover:bg-white/30 rounded-lg text-xs font-semibold transition-colors">
                            Kembali ke Admin
                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
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
        <x-sweet-alert />
    </body>
</html>
