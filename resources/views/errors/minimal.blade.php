<!DOCTYPE html>
<html lang="id" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <x-meta
        :title="__('Error') . ' ' . View::yieldContent('code') . ' — ' . config('app.name', 'Rayakan Digital')"
        description="Terjadi kesalahan. Silakan coba lagi atau hubungi tim dukungan."
        robots="noindex, nofollow"
    />

    @stack('meta')

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script>
        if (localStorage.getItem('dark-mode') === 'true' || (!('dark-mode' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>

<body class="font-sans antialiased bg-neutral-50 dark:bg-secondary-900 text-secondary-800 dark:text-neutral-200 h-full">
    <div class="min-h-full flex items-center justify-center p-6 relative overflow-hidden">
        <!-- Dot grid background -->
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute inset-0 bg-gradient-to-tr from-primary-500/[0.03] to-transparent"></div>
            <div class="absolute inset-0"
                style="background-image: radial-gradient(circle, #94a3b8 1px, transparent 1px); background-size: 32px 32px; opacity: 0.12;">
            </div>
        </div>
        <div class="absolute -bottom-20 -left-20 w-96 h-96 bg-secondary-200/20 rounded-full blur-3xl dark:bg-secondary-800/20"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] bg-primary-100/10 rounded-full blur-3xl"></div>

        <div class="relative z-10 max-w-lg w-full text-center animate-[fadeIn_0.5s_ease_both]">
            <!-- Error code (large background) -->
            <div class="font-mono font-bold text-[clamp(160px,30vw,340px)] leading-none text-secondary-900/5 dark:text-neutral-100/5 select-none pointer-events-none absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2">
                @yield('code')
            </div>

            <!-- Dot indicator -->
            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-xs font-semibold font-mono tracking-widest uppercase mb-8 bg-red-50 text-red-600 border border-red-200 dark:bg-red-900/20 dark:text-red-400 dark:border-red-800/30">
                <span class="w-1.5 h-1.5 rounded-full bg-red-600 dark:bg-red-400 animate-pulse"></span>
                HTTP Error
            </div>

            <!-- Error code -->
            <div class="font-mono font-bold text-7xl md:text-8xl text-secondary-900 dark:text-neutral-100 leading-none mb-6">
                @yield('code')
            </div>

            <!-- Divider -->
            <div class="w-9 h-0.5 bg-secondary-900 dark:bg-neutral-100 rounded-full mx-auto mb-6"></div>

            <!-- Message -->
            <p class="text-neutral-500 dark:text-neutral-400 text-lg font-light leading-relaxed mb-10">
                @yield('message')
            </p>

            <!-- Actions -->
            <div class="flex items-center justify-center gap-3 flex-wrap">
                <a href="javascript:history.back()"
                    class="inline-flex items-center gap-2 bg-secondary-900 dark:bg-neutral-100 text-white dark:text-secondary-900 font-semibold px-5 py-2.5 rounded-xl text-sm hover:opacity-80 transition-all active:scale-[0.97]">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M19 12H5M12 5l-7 7 7 7" />
                    </svg>
                    Kembali
                </a>
                <a href="/"
                    class="inline-flex items-center gap-2 bg-transparent text-secondary-600 dark:text-neutral-400 font-semibold px-5 py-2.5 rounded-xl text-sm border border-secondary-200 dark:border-secondary-700 hover:bg-secondary-50 dark:hover:bg-secondary-800 transition-all active:scale-[0.97]">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                        <polyline points="9 22 9 12 15 12 15 22" />
                    </svg>
                    Beranda
                </a>
            </div>

            <!-- Meta -->
            <div class="mt-10 pt-5 border-t border-secondary-100 dark:border-secondary-800 flex items-center justify-center gap-2 flex-wrap">
                <span class="font-mono text-[10px] tracking-widest uppercase text-neutral-400 dark:text-neutral-500">{{ config('app.name', 'Rayakan Digital') }}</span>
                <span class="w-1 h-1 rounded-full bg-secondary-300 dark:bg-secondary-600"></span>
                <span class="font-mono text-[10px] tracking-widest uppercase text-neutral-400 dark:text-neutral-500">HTTP/@yield('code')</span>
            </div>
        </div>
    </div>

    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(12px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</body>
</html>
