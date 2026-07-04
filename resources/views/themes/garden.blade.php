<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @php
        $coupleName = $invitation->couple_name;
        $displayEvents = $guestEvents ?? $invitation->events;
        $isBrideFirst = $invitation->bride_groom_order === 'female_first';
        $brideLabel = $invitation->bride_nickname ?: $invitation->bride_name;
        $groomLabel = $invitation->groom_nickname ?: $invitation->groom_name;
        $coupleFirst = $isBrideFirst ? $brideLabel : $groomLabel;
        $coupleSecond = $isBrideFirst ? $groomLabel : $brideLabel;
    @endphp
    <x-meta :title="'Pernikahan ' . $coupleName" :description="'Undangan pernikahan digital ' . $coupleName . '. Informasi lengkap acara, lokasi, waktu, dan galeri foto. Kirimkan doa dan kehadiran Anda secara virtual di sini.'" image="{{ $invitation->cover_photo ? asset('storage/' . $invitation->cover_photo) : null }}" />

    @stack('meta')
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;1,400;1,600&amp;family=Lora:ital,wght@0,400;0,500;1,400&amp;display=swap"
        rel="stylesheet">
    <link rel="stylesheet"
        href="{{ asset('themes/garden/assets/css/style.css') }}?v={{ filemtime(public_path('themes/garden/assets/css/style.css')) }}">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
</head>

<body class="loading-active">

    <!-- ==================== LOADING OVERLAY ==================== -->
    <div id="loadingOverlay" class="loading-overlay">
        <div class="loading-spinner">
            <div class="loading-ring"></div>
            <div class="loading-spinner-img">
                <img src="{{ asset('themes/garden/assets/images/logonew.png') }}" alt="Logo">
            </div>
            <p class="loading-text">Dua hati bersatu dalam satu asa...</p>

        </div>
    </div>
    <script>
        (function () {
            var o = document.getElementById('loadingOverlay');
            if (!o) return;

            var loaded = false;

            function done() {
                if (loaded) return;
                loaded = true;
                o.dataset.done = '1';
                o.classList.add('hidden');
                document.body.classList.remove('loading-active');
                setTimeout(function () {
                    o.style.display = 'none';
                }, 600);
            }

            // Tunggu DOM dan semua asset (gambar, iframe, dll)
            if (document.readyState === 'complete') {
                done();
            } else {
                window.addEventListener('load', done);
            }

            // Tunggu font hanya jika ada yang loading
            if (document.fonts && document.fonts.status === 'loading') {
                document.fonts.ready.then(done).catch(done);
            }

            // Fallback timeout - lebih panjang untuk safety
            setTimeout(done, 8000);

            // Opsional: tambahkan progress tracking untuk UX lebih baik
            // console.log('Loading assets...');
        })();
    </script>

    <!-- ==================== COVER ==================== -->
    <div id="cover" class="cover">
        <div class="cover-bg"></div>
        <div class="cover-content">
            @if($invitation->cover_photo)
                <div class="cover-frame">
                    <div class="cover-frame-inner">
                        <img src="{{ asset('storage/' . $invitation->cover_photo) }}" alt="Cover" class="cover-frame-img">
                    </div>
                </div>
            @else
                <div class="cover-frame" style="display: none;"></div>
            @endif
            <p class="cover-subtitle">Undangan Pernikahan</p>
            <h1 class="cover-title">
                {{ $coupleFirst }}
                <span class="cover-title-sep">&amp;</span>
                {{ $coupleSecond }}
            </h1>
            @php
                $firstEvent = $displayEvents->sortBy(['event_date', 'start_time'])->first();
            @endphp
            @if($firstEvent)
                <p class="cover-date">{{ \Carbon\Carbon::parse($firstEvent->event_date)->translatedFormat('l, d F Y') }}</p>
            @elseif($invitation->event_date)
                <p class="cover-date">{{ \Carbon\Carbon::parse($invitation->event_date)->translatedFormat('l, d F Y') }}</p>
            @endif
            @if($guest)
                <div class="cover-guest">
                    <p class="cover-guest-label">Kepada Yth.</p>
                    <p class="cover-guest-name">{{ $guest->name }}</p>
                </div>
            @endif
            <br>
            <button id="openBtn" class="cover-btn">Buka Undangan</button>
        </div>
    </div>

    <!-- ==================== MUSIC ==================== -->
    <audio id="bgAudio" loop preload="none">
        @if($invitation->music_url)
            <source src="{{ asset('storage/' . $invitation->music_url) }}" type="audio/mpeg">
        @else
            @php $defaultMusic = \App\Models\PreviewData::getPreview()->music_url; @endphp
            @if($defaultMusic)
                <source src="{{ asset('storage/' . $defaultMusic) }}" type="audio/mpeg">
            @endif
        @endif
    </audio>
    <button id="musicToggle" class="music-btn" aria-label="Toggle Music">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="music-icon">
            <path d="M9 18V5l12-2v13" />
            <circle cx="6" cy="18" r="3" />
            <circle cx="18" cy="16" r="3" />
        </svg>
    </button>

    <!-- ==================== LIGHTBOX ==================== -->
    <div id="lightbox" class="lightbox">
        <span id="lightboxClose" class="lightbox-close">&times;</span>
        <img id="lightboxImg" src="" alt="">
    </div>

    <!-- SEBELAH KANAN -->
    <!-- ==================== MAIN ==================== -->
    <div class="invitation-split">
        <div class="split-content">
            <main id="main" class="main">
                <!-- Introduction Section -->
                <section class="section intro-section">
                    <div class="intro-content">
                        <div class="intro-decor-top">
                            <svg viewBox="0 0 100 100" class="botanical-svg" xmlns="http://www.w3.org/2000/svg">
                                <path d="M50 85 C 50 60, 45 45, 25 35 C 42 48, 47 65, 50 85 Z" fill="#8B9D83"
                                    opacity="0.3" />
                                <path d="M50 85 C 50 60, 55 45, 75 35 C 58 48, 53 65, 50 85 Z" fill="#8B9D83"
                                    opacity="0.3" />
                                <path d="M50 85 L 50 15" stroke="#8B9D83" stroke-width="1.5" stroke-dasharray="2,2"
                                    opacity="0.4" />
                                <circle cx="50" cy="15" r="3" fill="#c9a84c" />
                            </svg>
                        </div>
                        <span class="intro-subtitle">THE WEDDING OF</span>
                        <div class="intro-couple">
                            @php $isBrideFirst = $invitation->bride_groom_order === 'female_first'; @endphp
                            @if($isBrideFirst)
                                <h1 class="intro-name">{{ $invitation->bride_nickname ?: $invitation->bride_name }}</h1>
                                <div class="intro-amp">&amp;</div>
                                <h1 class="intro-name">{{ $invitation->groom_nickname ?: $invitation->groom_name }}</h1>
                            @else
                                <h1 class="intro-name">{{ $invitation->groom_nickname ?: $invitation->groom_name }}</h1>
                                <div class="intro-amp">&amp;</div>
                                <h1 class="intro-name">{{ $invitation->bride_nickname ?: $invitation->bride_name }}</h1>
                            @endif
                        </div>
                        @php
                            $firstEvent = $displayEvents->sortBy(['event_date', 'start_time'])->first();
                            $eventDate = $firstEvent ? $firstEvent->event_date : $invitation->event_date;
                        @endphp
                        @if($eventDate)
                            <p class="intro-date">{{ \Carbon\Carbon::parse($eventDate)->translatedFormat('d . m . y') }}</p>
                        @endif
                        <div class="intro-scroll-hint">
                            <span class="scroll-line"></span>
                            <span class="scroll-text">SCROLL</span>
                        </div>
                    </div>
                </section>
                <!-- Hero Section -->
                <section class="section hero-section">
                    <div class="container text-center">
                        <p class="section-subtitle">Assalamu&rsquo;alaikum Warahmatullahi Wabarakatuh</p>
                        <p class="hero-text">Dengan memohon rahmat dan ridha Allah SWT, kami bermaksud menyelenggarakan
                            pernikahan putra-putri kami:</p>
                        @php $isBrideFirst = $invitation->bride_groom_order === 'female_first'; @endphp
                        <div class="hero-couple">
                            <div class="couple-grid">
                                <div class="couple-card">
                                    @if($isBrideFirst)
                                        <div class="couple-photo">
                                            @if($invitation->bride_photo)
                                                <img src="{{ asset('storage/' . $invitation->bride_photo) }}"
                                                    alt="{{ $invitation->bride_name }}">
                                            @else
                                                <img src="https://ui-avatars.com/api/?name={{ urlencode($invitation->bride_name) }}&amp;background=8B9D83&amp;color=fff&amp;size=400"
                                                    alt="{{ $invitation->bride_name }}">
                                            @endif
                                        </div>
                                        <h2 class="couple-name">{{ $invitation->bride_name }}</h2>
                                        @if($invitation->bride_nickname)
                                            <p class="couple-nickname">{{ $invitation->bride_nickname }}</p>
                                        @endif
                                        <p class="couple-parents">
                                            @php
                                                $brideParentsText = $invitation->bride_parents ?: 'Putri dari Bapak ... & Ibu ...';
                                                $brideParentsParts = explode(' & ', $brideParentsText, 2);
                                            @endphp
                                            {{ $brideParentsParts[0] }}@if(isset($brideParentsParts[1]))<br>
                                            & {{ $brideParentsParts[1] }}@endif
                                        </p>
                                    @else
                                        <div class="couple-photo">
                                            @if($invitation->groom_photo)
                                                <img src="{{ asset('storage/' . $invitation->groom_photo) }}"
                                                    alt="{{ $invitation->groom_name }}">
                                            @else
                                                <img src="https://ui-avatars.com/api/?name={{ urlencode($invitation->groom_name) }}&amp;background=2D5016&amp;color=fff&amp;size=400"
                                                    alt="{{ $invitation->groom_name }}">
                                            @endif
                                        </div>
                                        <h2 class="couple-name">{{ $invitation->groom_name }}</h2>
                                        @if($invitation->groom_nickname)
                                            <p class="couple-nickname">{{ $invitation->groom_nickname }}</p>
                                        @endif
                                        <p class="couple-parents">
                                            @php
                                                $groomParentsText = $invitation->groom_parents ?: 'Putra dari Bapak ... & Ibu ...';
                                                $groomParentsParts = explode(' & ', $groomParentsText, 2);
                                            @endphp
                                            {{ $groomParentsParts[0] }}@if(isset($groomParentsParts[1]))<br>
                                            & {{ $groomParentsParts[1] }}@endif
                                        </p>
                                    @endif
                                </div>
                                <div class="couple-amp">&amp;</div>
                                <div class="couple-card">
                                    @if($isBrideFirst)
                                        <div class="couple-photo">
                                            @if($invitation->groom_photo)
                                                <img src="{{ asset('storage/' . $invitation->groom_photo) }}"
                                                    alt="{{ $invitation->groom_name }}">
                                            @else
                                                <img src="https://ui-avatars.com/api/?name={{ urlencode($invitation->groom_name) }}&amp;background=2D5016&amp;color=fff&amp;size=400"
                                                    alt="{{ $invitation->groom_name }}">
                                            @endif
                                        </div>
                                        <h2 class="couple-name">{{ $invitation->groom_name }}</h2>
                                        @if($invitation->groom_nickname)
                                            <p class="couple-nickname">{{ $invitation->groom_nickname }}</p>
                                        @endif
                                        <p class="couple-parents">
                                            @php
                                                $groomParentsText = $invitation->groom_parents ?: 'Putra dari Bapak ... & Ibu ...';
                                                $groomParentsParts = explode(' & ', $groomParentsText, 2);
                                            @endphp
                                            {{ $groomParentsParts[0] }}@if(isset($groomParentsParts[1]))<br>
                                            & {{ $groomParentsParts[1] }}@endif
                                        </p>
                                    @else
                                        <div class="couple-photo">
                                            @if($invitation->bride_photo)
                                                <img src="{{ asset('storage/' . $invitation->bride_photo) }}"
                                                    alt="{{ $invitation->bride_name }}">
                                            @else
                                                <img src="https://ui-avatars.com/api/?name={{ urlencode($invitation->bride_name) }}&amp;background=8B9D83&amp;color=fff&amp;size=400"
                                                    alt="{{ $invitation->bride_name }}">
                                            @endif
                                        </div>
                                        <h2 class="couple-name">{{ $invitation->bride_name }}</h2>
                                        @if($invitation->bride_nickname)
                                            <p class="couple-nickname">{{ $invitation->bride_nickname }}</p>
                                        @endif
                                        <p class="couple-parents">
                                            @php
                                                $brideParentsText = $invitation->bride_parents ?: 'Putri dari Bapak ... & Ibu ...';
                                                $brideParentsParts = explode(' & ', $brideParentsText, 2);
                                            @endphp
                                            {{ $brideParentsParts[0] }}@if(isset($brideParentsParts[1]))<br>
                                            & {{ $brideParentsParts[1] }}@endif
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Quote Section -->
                @if($invitation->quote_content && $invitation->show_quote)
                    <section class="section quote-section">
                        <div class="container text-center">
                            <div class="quote-card">
                                <span class="quote-mark">&ldquo;</span>
                                <p class="quote-text">{{ $invitation->quote_content }}</p>
                                @if($invitation->quote_source)
                                    <p class="quote-source">&mdash; {{ $invitation->quote_source }}</p>
                                @endif
                            </div>
                        </div>
                    </section>
                @endif

                <!-- YouTube Video Section -->
                @if($invitation->show_video && $invitation->youtube_video_id)
                    <section class="section video-section">
                        <div class="container text-center">
                            <h2 class="section-title">Video</h2>
                            <div class="video-wrapper" style="margin-top:1.5rem;">
                                <iframe
                                    src="https://www.youtube.com/embed/{{ $invitation->youtube_video_id }}?autoplay=0&amp;rel=0"
                                    allowfullscreen loading="lazy"></iframe>
                            </div>
                        </div>
                    </section>
                @endif

                <!-- Countdown Section -->
                @if($firstEvent && $invitation->show_countdown)
                    <section class="section countdown-section" id="countdownSection">
                        <div class="container text-center">
                            <h2 class="section-title">Hitungan Menuju Hari Bahagia</h2>
                            <div class="countdown" id="countdown"
                                data-year="{{ \Carbon\Carbon::parse($firstEvent->event_date)->format('Y') }}"
                                data-month="{{ \Carbon\Carbon::parse($firstEvent->event_date)->format('m') }}"
                                data-day="{{ \Carbon\Carbon::parse($firstEvent->event_date)->format('d') }}"
                                data-hour="{{ $firstEvent->start_time ? \Carbon\Carbon::parse($firstEvent->start_time)->format('H') : '0' }}"
                                data-minute="{{ $firstEvent->start_time ? \Carbon\Carbon::parse($firstEvent->start_time)->format('i') : '0' }}">
                                <div class="countdown-item"><span id="cd-days">00</span><small>Hari</small></div>
                                <div class="countdown-item"><span id="cd-hours">00</span><small>Jam</small></div>
                                <div class="countdown-item"><span id="cd-minutes">00</span><small>Menit</small></div>
                                <div class="countdown-item"><span id="cd-seconds">00</span><small>Detik</small></div>
                            </div>
                        </div>
                    </section>
                @endif

                <!-- Event Detail Section -->
                @if($invitation->show_event_detail)
                    <section class="section event-section">
                        <div class="container text-center">
                            <h2 class="section-title">Waktu &amp; Tempat</h2>
                            @php $sortedEvents = $displayEvents->sortBy(['event_date', 'start_time']); @endphp
                            @forelse($sortedEvents as $event)
                                <div class="event-card">
                                    <div class="event-header">
                                        <h3 class="event-title">{{ $event->event_title }}</h3>
                                        <div class="event-divider">
                                            <svg viewBox="0 0 100 20" class="event-divider-svg"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path d="M10 10 L 40 10 M 60 10 L 90 10" stroke="#c9a84c" stroke-width="1"
                                                    opacity="0.5" />
                                                <path d="M50 5 C 47 7, 47 10, 50 15 C 53 10, 53 7, 50 5 Z" fill="#8B9D83" />
                                                <path d="M50 8 C 45 6, 42 10, 47 12" stroke="#8B9D83" fill="none"
                                                    stroke-width="0.8" />
                                                <path d="M50 8 C 55 6, 58 10, 53 12" stroke="#8B9D83" fill="none"
                                                    stroke-width="0.8" />
                                            </svg>
                                        </div>
                                    </div>

                                    <div class="event-info-box">
                                        <div class="info-date-row">
                                            <svg class="info-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2">
                                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                                <line x1="16" y1="2" x2="16" y2="6"></line>
                                                <line x1="8" y1="2" x2="8" y2="6"></line>
                                                <line x1="3" y1="10" x2="21" y2="10"></line>
                                            </svg>
                                            <span class="event-date">
                                                {{ \Carbon\Carbon::parse($event->event_date)->translatedFormat('l, d F Y') }}
                                            </span>
                                        </div>

                                        @php
                                            $tzLabel = match ($invitation->timezone ?? 'Asia/Jakarta') {
                                                'Asia/Jakarta' => 'WIB', 'Asia/Makassar' => 'WITA', 'Asia/Jayapura' => 'WIT', default => 'WIB'
                                            };
                                        @endphp
                                        <div class="info-time-row">
                                            <svg class="info-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2">
                                                <circle cx="12" cy="12" r="10"></circle>
                                                <polyline points="12 6 12 12 16 14"></polyline>
                                            </svg>
                                            <span class="event-time">
                                                Pukul
                                                {{ $event->start_time ? \Carbon\Carbon::parse($event->start_time)->format('H:i') : '-' }}
                                                @if($event->is_until_finished) - Selesai
                                                @elseif($event->end_time) -
                                                    {{ \Carbon\Carbon::parse($event->end_time)->format('H:i') }}
                                                @else - Selesai
                                                @endif {{ $tzLabel }}
                                            </span>
                                        </div>
                                    </div>

                                    <div class="event-venue-box">
                                        <h4 class="event-place">{{ $event->place_name }}</h4>
                                        <p class="event-address">{{ $event->place_address }}</p>
                                    </div>

                                    @if($event->google_maps_url)
                                        <a href="{{ $event->google_maps_url }}" target="_blank" class="event-maps-btn">
                                            <svg viewBox="0 0 24 24" fill="currentColor">
                                                <path
                                                    d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z" />
                                            </svg>
                                            Buka Google Maps
                                        </a>
                                    @endif
                                </div>
                            @empty
                                <div class="event-card">
                                    <div class="event-header">
                                        <h3 class="event-title">Acara Pernikahan</h3>
                                        <div class="event-divider">
                                            <svg viewBox="0 0 100 20" class="event-divider-svg"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path d="M10 10 L 40 10 M 60 10 L 90 10" stroke="#c9a84c" stroke-width="1"
                                                    opacity="0.5" />
                                                <path d="M50 5 C 47 7, 47 10, 50 15 C 53 10, 53 7, 50 5 Z" fill="#8B9D83" />
                                                <path d="M50 8 C 45 6, 42 10, 47 12" stroke="#8B9D83" fill="none"
                                                    stroke-width="0.8" />
                                                <path d="M50 8 C 55 6, 58 10, 53 12" stroke="#8B9D83" fill="none"
                                                    stroke-width="0.8" />
                                            </svg>
                                        </div>
                                    </div>

                                    <div class="event-info-box">
                                        <div class="info-date-row">
                                            <svg class="info-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2">
                                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                                <line x1="16" y1="2" x2="16" y2="6"></line>
                                                <line x1="8" y1="2" x2="8" y2="6"></line>
                                                <line x1="3" y1="10" x2="21" y2="10"></line>
                                            </svg>
                                            <span class="event-date">
                                                {{ $invitation->event_date ? \Carbon\Carbon::parse($invitation->event_date)->translatedFormat('l, d F Y') : '-' }}
                                            </span>
                                        </div>
                                    </div>

                                    <div class="event-venue-box">
                                        <h4 class="event-place">{{ $invitation->venue_name ?: 'Tempat Acara' }}</h4>
                                        <p class="event-address">{{ $invitation->venue_address ?: 'Alamat belum ditentukan' }}
                                        </p>
                                    </div>

                                    @if($invitation->venue_maps_url)
                                        <a href="{{ $invitation->venue_maps_url }}" target="_blank" class="event-maps-btn">
                                            <svg viewBox="0 0 24 24" fill="currentColor">
                                                <path
                                                    d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z" />
                                            </svg>
                                            Buka Google Maps
                                        </a>
                                    @endif
                                </div>
                            @endforelse
                        </div>
                    </section>
                @endif

                <!-- Gallery Section -->
                @if(
                        $invitation->show_gallery && $invitation->hasFeature('gallery_photos') &&
                        !empty($invitation->gallery_photos)
                    )
                    <section class="section gallery-section">
                        <div class="container text-center">
                            <h2 class="section-title">Galeri Foto</h2>
                            <div class="gallery-grid">
                                @foreach($invitation->gallery_photos as $photo)
                                    <div class="gallery-item">
                                        <img src="{{ str_starts_with($photo, 'http') ? $photo : asset('storage/' . $photo) }}"
                                            alt="Gallery" loading="lazy">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </section>
                @endif

                <!-- Love Story Section -->
                @php $stories = $invitation->stories; @endphp
                @if($invitation->show_stories && $stories->isNotEmpty())
                    <section class="section story-section">
                        <div class="container">
                            <h2 class="section-title text-center">Cerita Cinta</h2>
                            <div class="story-timeline">
                                @foreach($stories as $story)
                                    <div class="story-item">
                                        <div class="story-dot">
                                            <svg viewBox="0 0 24 24" class="story-heart-icon"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
                                            </svg>
                                        </div>
                                        <div class="story-card">
                                            @if($story->story_date)
                                                @php
                                                    try {
                                                        $parsedDate = \Carbon\Carbon::parse($story->story_date)->translatedFormat('d F Y');
                                                    } catch (\Exception $e) {
                                                        $parsedDate = $story->story_date;
                                                    }
                                                @endphp
                                                <div class="story-date-badge">
                                                    {{ $parsedDate }}
                                                </div>
                                            @endif
                                            @if($story->story_title)
                                                <h3 class="story-title">{{ $story->story_title }}</h3>
                                            @endif
                                            @if(!empty($story->story_image))
                                                <div class="story-photo">
                                                    <img src="{{ str_starts_with($story->story_image, 'http') ? $story->story_image : asset('storage/' . $story->story_image) }}"
                                                        alt="{{ $story->story_title ?: 'Foto cerita' }}" loading="lazy"
                                                        data-full="{{ str_starts_with($story->story_image, 'http') ? $story->story_image : asset('storage/' . $story->story_image) }}">
                                                </div>
                                            @endif
                                            @php $preview = \Illuminate\Support\Str::limit($story->story_description, 250); @endphp
                                            <div id="story-{{ $story->id }}-preview" style="display:none">
                                                {!! nl2br(e($preview)) !!}
                                            </div>
                                            <div id="story-{{ $story->id }}-full" style="display:none">
                                                {!! nl2br(e($story->story_description)) !!}
                                            </div>
                                            <div id="story-{{ $story->id }}" class="story-text" data-expanded="0">
                                                {!! nl2br(e($preview)) !!}
                                            </div>
                                            @if(mb_strlen($story->story_description) > 250)
                                                <button type="button" class="story-readmore-btn"
                                                    data-target="story-{{ $story->id }}">
                                                    Baca selengkapnya <span class="btn-arrow">&darr;</span>
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </section>
                    <script>
                        document.addEventListener('click', function (e) {
                            if (e.target && e.target.classList && e.target.classList.contains('story-readmore-btn')) {
                                var targetId = e.target.dataset.target;
                                var contentEl = document.getElementById(targetId);
                                var previewEl = document.getElementById(targetId + '-preview');
                                var fullEl = document.getElementById(targetId + '-full');
                                if (!contentEl || !previewEl || !fullEl) return;
                                var expanded = contentEl.dataset.expanded === '1';
                                if (expanded) {
                                    contentEl.innerHTML = previewEl.innerHTML;
                                    contentEl.dataset.expanded = '0';
                                    e.target.innerHTML = 'Baca selengkapnya <span class="btn-arrow">&darr;</span>';
                                } else {
                                    contentEl.innerHTML = fullEl.innerHTML;
                                    contentEl.dataset.expanded = '1';
                                    e.target.innerHTML = 'Tutup <span class="btn-arrow">&uarr;</span>';
                                }
                            }
                            var clickedImg = e.target.closest && e.target.closest('.story-photo img');
                            if (clickedImg) {
                                var src = clickedImg.getAttribute('data-full') || clickedImg.src;
                                var lb = document.getElementById('lightbox');
                                var lbImg = document.getElementById('lightboxImg');
                                if (!lb || !lbImg) return;
                                lbImg.src = src;
                                lb.style.display = 'flex';
                                lb.classList.add('open');
                            }
                        });
                        var lightboxClose = document.getElementById('lightboxClose');
                        if (lightboxClose) {
                            lightboxClose.addEventListener('click', function () {
                                var lb = document.getElementById('lightbox');
                                var lbImg = document.getElementById('lightboxImg');
                                lb.classList.remove('open');
                                setTimeout(function () { if (lb) lb.style.display = 'none'; if (lbImg) lbImg.src = ''; }, 300);
                            });
                        }
                    </script>
                @elseif($invitation->show_stories && $invitation->love_story)
                    <section class="section story-section">
                        <div class="container text-center">
                            <h2 class="section-title">Cerita Cinta</h2>
                            <p class="story-text-preview">{!! nl2br(e($invitation->love_story)) !!}</p>
                        </div>
                    </section>
                @endif

                <!-- RSVP Section -->
                @if($invitation->show_rsvp)
                    <section class="section rsvp-section">
                        <div class="container text-center">
                            <h2 class="section-title">RSVP</h2>
                            <p class="section-desc">Kehadiran Bapak/Ibu/Sdr/i sangat berarti bagi kami.</p>
                            @if($isPreview ?? false)
                                <div class="preview-notice">Fitur RSVP tidak tersedia dalam mode pratinjau.</div>
                            @elseif($invitation->isRsvpPaxLimited() && $invitation->isRsvpQuotaFull())
                                <div class="quota-full-notice">
                                    <p>Maaf, kuota kehadiran sudah penuh. Terima kasih atas perhatian Anda.</p>
                                </div>
                            @else
                                <form id="rsvpForm" class="rsvp-form" action="{{ route('rsvp.store', $invitation) }}"
                                    method="POST">
                                    @csrf
                                    <input type="text" name="guest_name" value="{{ $guest ? $guest->name : '' }}"
                                        placeholder="Nama Lengkap" required class="form-input">
                                    <select name="attendance" required class="form-input">
                                        <option value="attending">Ya, Saya Akan Hadir</option>
                                        <option value="not_attending">Maaf, Tidak Bisa Hadir</option>
                                        <option value="uncertain">Mungkin Hadir</option>
                                    </select>
                                    <select name="pax" required class="form-input">
                                        @php
                                            $maxPax = $invitation->max_pax_per_guest ?? 5;
                                            $remaining = $invitation->remainingGlobalQuota();
                                            $effectiveMax = $remaining !== null ? min($maxPax, $remaining) : $maxPax;
                                        @endphp
                                        @for($i = 1; $i <= $effectiveMax; $i++)
                                            <option value="{{ $i }}">{{ $i }} Orang</option>
                                        @endfor
                                    </select>
                                    @if($invitation->isRsvpPaxLimited())
                                        <p class="rsvp-quota-info">
                                            Sisa kuota: <strong>{{ $invitation->remainingGlobalQuota() }}</strong> dari
                                            <strong>{{ $invitation->max_global_pax_quota }}</strong> pax
                                        </p>
                                    @endif
                                    <button type="submit" class="btn btn-primary">Konfirmasi Kehadiran</button>
                                </form>
                            @endif
                        </div>
                    </section>
                @endif

                <!-- Gift Section -->
                @php
                    $giftBanks = $invitation->gift_banks ?? [];
                    $giftEwallets = $invitation->gift_ewallets ?? [];
                    if (empty($giftBanks) && ($invitation->gift_bank_name || $invitation->gift_bank_account)) {
                        $giftBanks = [
                            [
                                'bank_name' => $invitation->gift_bank_name,
                                'account_number' => $invitation->gift_bank_account,
                                'account_holder' => $invitation->gift_bank_holder
                            ]
                        ];
                    }
                    if (empty($giftEwallets) && ($invitation->gift_ewallet_name || $invitation->gift_ewallet_number)) {
                        $giftEwallets = [
                            [
                                'wallet_name' => $invitation->gift_ewallet_name,
                                'wallet_number' =>
                                    $invitation->gift_ewallet_number
                            ]
                        ];
                    }
                @endphp
                @if(
                        $invitation->show_gift && $invitation->canUseGift() && (count($giftBanks) > 0 || count($giftEwallets) > 0 ||
                            $invitation->gift_qris_image)
                    )
                    <section class="section gift-section">
                        <div class="container text-center">
                            <h2 class="section-title">Kado Digital</h2>
                            <p class="section-desc">Doa restu Anda adalah karunia terindah. Namun jika ingin memberi tanda
                                kasih,
                                Anda dapat mengirimkannya melalui:</p>
                            <div class="gift-toggle-wrap">
                                <button id="giftToggleBtn" class="btn btn-primary">Kirim Kado Digital</button>
                                <div id="giftContent" class="gift-content">
                                    @foreach($giftBanks as $bank)
                                        @php $bank = (object) $bank; @endphp
                                        @if($bank->bank_name && $bank->account_number)
                                            <div class="gift-card">
                                                <span class="gift-label">Transfer Bank</span>
                                                <h4>{{ $bank->bank_name }}</h4>
                                                <p class="gift-account">{{ $bank->account_number }}</p>
                                                <p class="gift-holder">a.n. {{ $bank->account_holder ?: 'Mempelai' }}</p>
                                                <button class="btn-copy" data-copy="{{ $bank->account_number }}">Salin
                                                    Rekening</button>
                                            </div>
                                        @endif
                                    @endforeach
                                    @foreach($giftEwallets as $ewallet)
                                        @php $ewallet = (object) $ewallet; @endphp
                                        @if($ewallet->wallet_name && $ewallet->wallet_number)
                                            <div class="gift-card">
                                                <span class="gift-label">Dompet Digital</span>
                                                <h4>{{ $ewallet->wallet_name }}</h4>
                                                <p class="gift-account">{{ $ewallet->wallet_number }}</p>
                                                <button class="btn-copy" data-copy="{{ $ewallet->wallet_number }}">Salin
                                                    Nomor</button>
                                            </div>
                                        @endif
                                    @endforeach
                                    @if($invitation->gift_qris_image)
                                        <div class="gift-card gift-qris">
                                            <span class="gift-label">Scan QRIS</span>
                                            <img src="{{ asset('storage/' . $invitation->gift_qris_image) }}" alt="QRIS"
                                                class="qris-img">
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </section>
                @endif

                <!-- QR Check-In Section -->
                @if($invitation->show_qr_checkin && $guest)
                    <section class="section qr-section">
                        <div class="container text-center">
                            <h2 class="section-title">QR Check-In</h2>
                            <p class="section-desc">Tunjukkan kode ini saat check-in acara.</p>
                            <div class="qr-card">
                                {!! $guest->qr_code_svg !!}
                                <p class="qr-name">{{ $guest->name }}</p>
                            </div>
                        </div>
                    </section>
                @endif

                <!-- Guestbook Section -->
                @if($invitation->show_comments)
                    <section class="section guestbook-section">
                        <div class="container text-center">
                            <h2 class="section-title">Buku Tamu</h2>
                            <p class="section-desc">Berikan doa dan ucapan untuk kami berdua.</p>
                            @if($isPreview ?? false)
                                <div class="preview-notice">Fitur buku tamu tidak tersedia dalam mode pratinjau.</div>
                            @else
                                <form id="wishForm" class="wish-form" action="{{ route('wish.store', $invitation) }}"
                                    method="POST">
                                    @csrf
                                    <input type="text" name="guest_name" value="{{ $guest ? $guest->name : '' }}"
                                        placeholder="Nama Anda" required class="form-input">
                                    <textarea name="message" rows="4" placeholder="Tulis ucapan dan doa..." required
                                        class="form-input"></textarea>
                                    <button type="submit" class="btn btn-primary">Kirim Ucapan</button>
                                </form>
                            @endif
                            <div id="wishContainer">
                                <div class="wish-list" id="wishList">
                                    @php
                                        $wishes = $invitation->wishes()->latest()->paginate(5);
                                    @endphp
                                    @forelse($wishes as $wish)
                                        <div class="wish-item">
                                            <h4>{{ $wish->guest_name }}</h4>
                                            <p>{{ $wish->message }}</p>
                                            <small>{{ $wish->created_at->diffForHumans() }}</small>
                                        </div>
                                    @empty
                                        <p class="wish-empty">Jadilah yang pertama memberikan ucapan.</p>
                                    @endforelse
                                </div>
                                @if($wishes->hasPages())
                                    <div class="wish-pagination">
                                        {{ $wishes->withQueryString()->links('vendor.pagination.theme') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </section>
                @endif

                <!-- Footer -->
                <footer class="footer">
                    <div class="container text-center">
                        <p class="footer-thanks">Merupakan suatu kehormatan dan kebahagiaan apabila Bapak/Ibu/Sdr/i
                            berkenan
                            hadir.</p>
                        <p class="footer-couple">{{ $coupleName }}</p>
                        @php
                            $appUrl = config('app.url');
                        @endphp
                        <p class="footer-credit">Dibuat dengan
                        </p>
                        <div class="footer-imglogo"><a href="{{ $appUrl }}" target="_blank">
                                <img src="{{ asset('themes/garden/assets/images/logo.png') }}" alt="Logo"
                                    class="footer-logo">
                            </a>
                        </div>
                    </div>
                </footer>

            </main>
        </div>

        <!-- SEBELAH KIRI -->
        <div class="split-wallpaper">
            <div class="split-text">
                @php $isBrideFirst = $invitation->bride_groom_order === 'female_first'; @endphp
                @if($isBrideFirst)
                    <h1 class="intro-name">{{ $invitation->bride_nickname ?: $invitation->bride_name }}</h1>
                    <div class="intro-amp">&amp;</div>
                    <h1 class="intro-name">{{ $invitation->groom_nickname ?: $invitation->groom_name }}</h1>
                @else
                    <h1 class="intro-name">{{ $invitation->groom_nickname ?: $invitation->groom_name }}</h1>
                    <div class="intro-amp">&amp;</div>
                    <h1 class="intro-name">{{ $invitation->bride_nickname ?: $invitation->bride_name }}</h1>
                @endif
            </div>
        </div>
    </div>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
    <script src="{{ asset('themes/garden/assets/js/script.js') }}"></script>
</body>

</html>