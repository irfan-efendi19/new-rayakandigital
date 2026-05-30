<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Rayakan Digital') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gray-50 text-gray-900">
        <!-- Navigation -->
        <nav class="bg-white border-b border-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <!-- Logo -->
                        <div class="shrink-0 flex items-center">
                            <a href="{{ route('home') }}" class="font-bold text-xl text-indigo-600">
                                Rayakan<span class="text-gray-900">Digital</span>
                            </a>
                        </div>
                    </div>

                    <div class="flex items-center">
                        @if (Route::has('login'))
                            <div class="hidden sm:flex sm:items-center sm:ml-6 space-x-4">
                                @auth
                                    <a href="{{ route('dashboard') }}" class="text-gray-600 hover:text-gray-900 font-medium">Dashboard</a>
                                @else
                                    <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-900 font-medium">Masuk</a>
                                    @if (Route::has('register'))
                                        <a href="{{ route('register') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-md font-medium hover:bg-indigo-700 transition">Daftar Gratis</a>
                                    @endif
                                @endauth
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </nav>

        <div class="min-h-screen bg-gray-50">
            {{ $slot }}
        </div>

        <!-- Footer -->
        <footer class="bg-white border-t border-gray-200">
            <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
                <p class="text-center text-base text-gray-500">
                    &copy; {{ date('Y') }} Rayakan Digital. All rights reserved.
                </p>
            </div>
        </footer>
    </body>
</html>
