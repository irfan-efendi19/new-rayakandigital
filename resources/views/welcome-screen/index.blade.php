<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Layar Sapa — {{ $invitation->title }}</title>
    <link rel="stylesheet" href="{{ asset('welcome-screen/style.css') }}">
    @if($themeHtmlContent)
        {!! $themeHtmlContent !!}
    @endif
</head>
<body data-welcome-screen data-theme="{{ $screenData['theme'] }}">
    <div class="screen-background" data-screen-background aria-hidden="true"></div>
    <div class="screen-shade" aria-hidden="true"></div>
    <main class="screen-layout">
        <section class="screen-intro" aria-label="Sambutan pernikahan">
            <p class="screen-eyebrow">The wedding celebration</p>
            <p class="screen-title" data-screen-title>{{ $screenData['title'] }}</p>
            <h1 class="screen-names" data-screen-names>{{ $screenData['names'] }}</h1>
            <span class="screen-divider" aria-hidden="true">✦</span>
            @if($firstEvent?->event_date || $invitation->event_date)
                <p class="screen-date">{{ ($firstEvent?->event_date ?? $invitation->event_date)->translatedFormat('d F Y') }}</p>
            @endif
            <p class="screen-note">Terima kasih telah menjadi bagian dari hari bahagia kami.</p>
        </section>
        <section class="screen-gallery" data-screen-gallery aria-label="Galeri pernikahan" hidden></section>
        <section class="screen-wishes" data-screen-wishes aria-label="Doa dan ucapan tamu" hidden>
            <p class="screen-eyebrow">Doa & ucapan</p>
            <blockquote><p data-wish-message></p><footer data-wish-name></footer></blockquote>
        </section>
    </main>
    <section class="checkin-overlay" data-screen-checkin role="status" aria-live="polite" aria-atomic="true" hidden>
        <div class="checkin-card">
            <span class="screen-divider" aria-hidden="true">✦</span>
            <p class="screen-eyebrow">Selamat datang</p>
            <h2 data-guest-name></h2>
            <p>Terima kasih telah hadir dan berbagi kebahagiaan bersama kami.</p>
            <p class="checkin-order" data-guest-order></p>
            <div class="checkin-progress" data-checkin-progress aria-hidden="true"></div>
        </div>
    </section>
    <footer class="screen-footer">{{ config('app.name') }}</footer>
    <div class="screen-controls">
        <span data-screen-status role="status"></span>
        <button type="button" data-screen-fullscreen aria-label="Aktifkan layar penuh">Layar penuh ⛶</button>
    </div>
    @include('welcome-screen.runtime')
</body>
</html>
