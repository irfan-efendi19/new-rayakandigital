<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <x-meta
        :title="View::yieldContent('title') ?: config('app.name', 'Rayakan Digital')"
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
    <div class="min-h-full flex items-center justify-center p-6">
        <div class="text-center max-w-md">
            <div class="font-mono font-bold text-[clamp(36px,8vw,56px)] text-secondary-900 dark:text-neutral-100 mb-4">
                @yield('message')
            </div>
            <div class="w-9 h-0.5 bg-secondary-900 dark:bg-neutral-100 rounded-full mx-auto mb-4"></div>
            <p class="text-neutral-500 dark:text-neutral-400 text-sm">
                Silakan coba lagi atau hubungi tim dukungan jika masalah berlanjut.
            </p>
        </div>
    </div>
</body>
</html>
