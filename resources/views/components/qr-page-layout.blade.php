@props([
    'title',
    'description',
    'section',
    'heading',
    'intro',
    'couple',
    'hubUrl',
    'icon' => 'grid',
    'wide' => false,
])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <x-meta :title="$title" :description="$description" theme-color="#FF7A00" />

    @vite(['resources/css/app.css', 'resources/js/qr-pages.js'])
</head>
<body {{ $attributes->merge(['class' => 'qr-page']) }}>
    <a href="#qr-main" class="qr-skip-link">Lewati ke konten</a>
    <div class="qr-page__frame {{ $wide ? 'qr-page__frame--wide' : '' }}">
        <nav class="qr-topbar" aria-label="Navigasi halaman">
            <a href="{{ $hubUrl }}" class="qr-brand" aria-label="Rayakan Digital — pusat acara {{ $couple }}">
                <img src="{{ asset('img/logo.png') }}" alt="" width="40" height="40" class="qr-brand__logo">
                <span class="qr-brand__wordmark"><span>Rayakan</span> Digital</span>
            </a>

            <div class="qr-topbar__actions">
                <button type="button" class="qr-theme-toggle" data-theme-toggle aria-label="Aktifkan mode gelap" aria-pressed="false">
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

        <div class="qr-page__body">
            <header class="qr-masthead">
                <div class="qr-masthead__symbol" aria-hidden="true"><x-qr-icon :name="$icon" /></div>
                <div class="qr-masthead__body">
                    <p class="qr-kicker">{{ $section }}</p>
                    <h1>{{ $heading }}</h1>
                    <p class="qr-masthead__intro">{{ $intro }}</p>
                    <p class="qr-couple"><x-qr-icon name="heart" /> <span>{{ $couple }}</span></p>
                </div>
            </header>

            <main id="qr-main" tabindex="-1">
                {{ $slot }}
            </main>
        </div>

        <footer class="qr-footer">
            <a href="{{ route('home') }}" class="qr-footer__brand">
                <img src="{{ asset('img/logo.png') }}" alt="" width="24" height="24">
                <span>Rayakan Digital</span>
            </a>
            <span>Temani setiap momen berharga · {{ date('Y') }}</span>
        </footer>
    </div>
</body>
</html>
