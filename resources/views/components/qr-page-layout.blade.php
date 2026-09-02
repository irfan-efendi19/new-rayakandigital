@props([
    'title',
    'description',
    'section',
    'heading',
    'intro',
    'couple',
    'backUrl',
    'wide' => false,
])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <x-meta :title="$title" :description="$description" theme-color="#f97316" />

    @vite(['resources/css/app.css', 'resources/js/qr-pages.js'])
</head>
<body {{ $attributes->merge(['class' => 'qr-page']) }}>
    <div class="qr-page__frame {{ $wide ? 'qr-page__frame--wide' : '' }}">
        <nav class="qr-topbar" aria-label="Navigasi halaman">
            <a href="{{ $backUrl }}" class="qr-brand" aria-label="Kembali ke undangan {{ $couple }}">
                <span class="qr-brand__mark" aria-hidden="true">R</span>
                <span>Rayakan</span>
            </a>

            <div class="qr-topbar__actions">
                <a href="{{ $backUrl }}" class="qr-back-link">
                    <span>Undangan</span>
                </a>
                <button type="button" class="qr-theme-toggle" data-theme-toggle aria-label="Ganti tema warna">
                    <svg class="qr-theme-toggle__sun" viewBox="0 0 24 24" aria-hidden="true">
                        <circle cx="12" cy="12" r="3.5" fill="none" stroke="currentColor" stroke-width="1.7" />
                        <path d="M12 2.5v2M12 19.5v2M4.6 4.6 6 6M18 18l1.4 1.4M2.5 12h2M19.5 12h2M4.6 19.4 6 18M18 6l1.4-1.4" fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="1.7" />
                    </svg>
                    <svg class="qr-theme-toggle__moon" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M20 15.1A8.5 8.5 0 0 1 8.9 4a8.5 8.5 0 1 0 11.1 11.1Z" fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="1.7" />
                    </svg>
                </button>
            </div>
        </nav>

        <header class="qr-masthead">
            <div>
                <p class="qr-kicker">{{ $section }} · {{ $couple }}</p>
                <h1>{{ $heading }}</h1>
            </div>
            <p class="qr-masthead__intro">{{ $intro }}</p>
        </header>

        <main>
            {{ $slot }}
        </main>

        <footer class="qr-footer">
            <span>{{ config('app.name') }}</span>
            <span aria-hidden="true">—</span>
            <span>{{ date('Y') }}</span>
        </footer>
    </div>
</body>
</html>
