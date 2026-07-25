@extends('errors::layout')

@section('title', __('Error') . ' ' . View::yieldContent('code') . ' — ' . config('app.name', 'Rayakan Digital'))

@section('content')
    <div class="flex-1 flex items-center justify-center p-4 sm:p-6 lg:p-8">
        <div class="w-full max-w-md">
            <!-- Logo -->
            <div class="text-center mb-8">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-2.5 group">
                    <img src="{{ asset('img/logoraya.png') }}" alt="Rayakan Digital"
                        class="h-9 w-auto">
                    <span class="text-xl font-bold bg-gradient-to-r from-orange-500 to-orange-600 bg-clip-text text-transparent font-heading italic">
                        Rayakan
                    </span>
                    <span class="text-xl font-bold text-gray-900 dark:text-neutral-100">
                        Digital
                    </span>
                </a>
            </div>

            <!-- Card -->
            <div class="bg-white dark:bg-secondary-800 rounded-xl shadow-soft p-8 sm:p-10 text-center">
                <!-- Icon -->
                @hasSection('icon')
                    <div class="mb-5">
                        <i class="fas @yield('icon') text-4xl text-primary dark:text-primary-400"></i>
                    </div>
                @endif

                <!-- Error code -->
                <h1 class="font-heading font-bold text-6xl sm:text-7xl md:text-8xl leading-none mb-4 bg-gradient-to-r from-orange-500 to-orange-600 bg-clip-text text-transparent">
                    @yield('code')
                </h1>

                <div class="w-12 h-0.5 bg-primary/30 dark:bg-primary-600/50 rounded-full mx-auto mb-5"></div>

                <p class="text-neutral-500 dark:text-neutral-400 text-base sm:text-lg leading-relaxed mb-8">
                    @yield('message')
                </p>

                <div class="flex items-center justify-center gap-3 flex-wrap">
                    <a href="javascript:history.back()"
                        class="inline-flex items-center gap-2 bg-gradient-to-r from-orange-500 to-orange-600 text-white font-semibold px-5 py-2.5 rounded-xl text-sm hover:shadow-lg hover:scale-[1.02] active:scale-[0.97] transition-all duration-200">
                        <i class="fas fa-arrow-left text-sm"></i>
                        Kembali
                    </a>
                    <a href="/"
                        class="inline-flex items-center gap-2 bg-transparent text-secondary-600 dark:text-neutral-400 font-semibold px-5 py-2.5 rounded-xl text-sm border border-secondary-200 dark:border-secondary-700 hover:bg-secondary-50 dark:hover:bg-secondary-700 hover:border-primary-300 dark:hover:border-primary-500 transition-all active:scale-[0.97]">
                        <i class="fas fa-house text-sm"></i>
                        Beranda
                    </a>
                </div>
            </div>

            <!-- Footer -->
            <div class="mt-8 text-center">
                <p class="text-sm text-neutral-400 dark:text-neutral-500">
                    &copy; {{ date('Y') }} {{ config('app.name', 'Rayakan Digital') }}. All rights reserved.
                </p>
            </div>
        </div>
    </div>
@endsection