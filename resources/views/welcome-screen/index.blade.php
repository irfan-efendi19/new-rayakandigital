<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <x-meta
        title="Layar Sapa - {{ $invitation->title }}"
        description="Layar sapa digital untuk {{ $invitation->title }}. Scan QR code untuk check-in dan memberikan ucapan."
        image="{{ $invitation->cover_photo ? asset('storage/' . $invitation->cover_photo) : asset('img/thumnail.jpg') }}"
    />

    @stack('meta')

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=playfair-display:400,600,700,800,900|inter:300,400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            color: #fff;
            overflow: hidden;
            height: 100vh;
            width: 100vw;
            display: flex;
            align-items: center;
            justify-content: center;
            user-select: none;
            background-color: #0f0f1a;
        }

        /* Decorative background particles */
        .bg-particles {
            position: fixed;
            inset: 0;
            pointer-events: none;
            z-index: 3;
        }

        .bg-particles span {
            position: absolute;
            width: 4px;
            height: 4px;
            background: rgba(255,255,255,0.08);
            border-radius: 50%;
            animation: float 20s infinite linear;
        }

        @keyframes float {
            0% { transform: translateY(100vh) rotate(0deg); opacity: 0; }
            10% { opacity: 1; }
            90% { opacity: 1; }
            100% { transform: translateY(-100vh) rotate(720deg); opacity: 0; }
        }

        .screen {
            position: relative;
            z-index: 4;
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 4rem;
            text-align: center;
        }

        /* Decorative border corners */
        .corner {
            position: fixed;
            width: 60px;
            height: 60px;
            border-color: rgba(255,255,255,0.12);
            border-style: solid;
            z-index: 4;
        }
        .corner-tl { top: 30px; left: 30px; border-width: 2px 0 0 2px; }
        .corner-tr { top: 30px; right: 30px; border-width: 2px 2px 0 0; }
        .corner-bl { bottom: 30px; left: 30px; border-width: 0 0 2px 2px; }
        .corner-br { bottom: 30px; right: 30px; border-width: 0 2px 2px 0; }

        /* Idle state */
        .idle-content { display: flex; flex-direction: column; align-items: center; gap: 1.5rem; }

        .idle-icon {
            width: 80px;
            height: 80px;
            border: 2px solid rgba(255,255,255,0.15);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }

        .idle-title {
            font-family: 'Playfair Display', serif;
            font-size: clamp(2.5rem, 5vw, 5rem);
            font-weight: 700;
            color: rgba(255,255,255,0.9);
            line-height: 1.2;
        }

        .idle-subtitle {
            font-size: clamp(1rem, 2vw, 1.5rem);
            color: rgba(255,255,255,0.5);
            font-weight: 300;
            letter-spacing: 0.05em;
        }

        .idle-decoration {
            width: 60px;
            height: 2px;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            margin: 0.5rem auto;
        }

        .idle-date {
            font-family: 'Playfair Display', serif;
            font-size: clamp(1.1rem, 1.5vw, 1.3rem);
            color: rgba(255,255,255,0.4);
            font-weight: 400;
        }

        /* Active (guest) state */
        .guest-content { display: flex; flex-direction: column; align-items: center; gap: 1rem; }

        .guest-enter-icon {
            font-size: clamp(2rem, 4vw, 3.5rem);
        }

        .guest-label {
            font-size: clamp(0.9rem, 1.2vw, 1.1rem);
            color: rgba(255,255,255,0.5);
            font-weight: 400;
            letter-spacing: 0.15em;
            text-transform: uppercase;
        }

        .guest-name {
            font-family: 'Playfair Display', serif;
            font-size: clamp(3rem, 8vw, 7rem);
            font-weight: 800;
            background: linear-gradient(135deg, #f6d365 0%, #fda085 50%, #f6d365 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            line-height: 1.15;
        }

        .guest-message {
            font-size: clamp(1.1rem, 1.8vw, 1.6rem);
            color: rgba(255,255,255,0.6);
            font-weight: 300;
        }

        .guest-decoration {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .guest-decoration .line {
            width: 40px;
            height: 1px;
            background: rgba(255,255,255,0.2);
        }

        .guest-decoration .diamond {
            width: 8px;
            height: 8px;
            background: rgba(255,255,255,0.2);
            transform: rotate(45deg);
        }

        .guest-order {
            font-size: clamp(0.8rem, 1vw, 1rem);
            color: rgba(255,255,255,0.3);
            font-weight: 300;
        }

        /* Pulsing dot for idle */
        .pulse-dot {
            display: inline-block;
            width: 8px;
            height: 8px;
            background: rgba(255,255,255,0.3);
            border-radius: 50%;
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 0.3; transform: scale(1); }
            50% { opacity: 1; transform: scale(1.3); }
        }

        /* Countdown bar */
        .countdown-bar {
            position: fixed;
            bottom: 0;
            left: 0;
            height: 3px;
            background: linear-gradient(90deg, #f6d365, #fda085);
            z-index: 5;
            width: 100%;
            transform-origin: left;
            transition: none;
        }

        .countdown-bar.idle {
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
            animation: idleBar 3s ease-in-out infinite;
        }

        @keyframes idleBar {
            0% { opacity: 0.2; }
            50% { opacity: 0.6; }
            100% { opacity: 0.2; }
        }

        /* Queue indicator */
        .queue-indicator {
            position: fixed;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 8px;
            z-index: 5;
        }

        .queue-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: rgba(255,255,255,0.15);
            transition: all 0.3s ease;
        }

        .queue-dot.active {
            background: #f6d365;
            transform: scale(1.5);
        }

        .queue-dot.queued {
            background: rgba(255,255,255,0.4);
        }

        /* Footer */
        .screen-footer {
            position: fixed;
            bottom: 20px;
            right: 30px;
            z-index: 4;
            font-size: 0.75rem;
            color: rgba(255,255,255,0.15);
            font-weight: 300;
            letter-spacing: 0.05em;
        }

        /* Hide scrollbar */
        ::-webkit-scrollbar { display: none; }
    </style>
</head>
<body x-data="welcomeScreen">
    {{-- Background particles --}}
    <div class="bg-particles" id="particles"></div>

    {{-- Default Background (or Custom background if uploaded) --}}
    <div class="custom-bg" style="
        position: fixed;
        inset: 0;
        z-index: 0;
        @if($invitation->screen_background_image)
            background-image: url('{{ asset('storage/' . $invitation->screen_background_image) }}');
            background-size: cover;
            background-position: center;
        @else
            background: linear-gradient(135deg, #0f0f1a 0%, #1a1a2e 50%, #16213e 100%);
        @endif
    "></div>

    {{-- Slideshow Background Container --}}
    <div x-show="isSlideshowActive"
         x-transition:enter="transition-opacity duration-1000"
         x-transition:leave="transition-opacity duration-1000"
         class="absolute inset-0 z-1"
         style="display: none;">
        <template x-for="(image, index) in galleries" :key="image.id">
            <div x-show="currentSlide === index"
                 x-transition:enter="transition-opacity duration-1000"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition-opacity duration-1000"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="absolute inset-0 bg-cover bg-center"
                 :style="'background-image: url(/storage/' + image.image_path + ')'">
            </div>
        </template>
    </div>

    {{-- Dark Overlay --}}
    <div class="screen-overlay" style="
        position: fixed;
        inset: 0;
        background-color: black;
        opacity: {{ ($invitation->screen_overlay_opacity ?? 50) / 100 }};
        z-index: 2;
    "></div>

    {{-- Corner decorations --}}
    <div class="corner corner-tl"></div>
    <div class="corner corner-tr"></div>
    <div class="corner corner-bl"></div>
    <div class="corner corner-br"></div>

    {{-- Countdown bar --}}
    <div class="countdown-bar"
         :class="{ 'idle': !isDisplaying }"
         :style="isDisplaying ? 'transform: scaleX(' + (countdownProgress / 100) + '); transition: none;' : ''"></div>

    {{-- Queue indicator --}}
    <div class="queue-indicator">
        <template x-for="n in Math.min(queue.length + (isDisplaying ? 1 : 0), 8)" :key="n">
            <span class="queue-dot" :class="{ 'active': n === 1 && isDisplaying, 'queued': n > 1 || !isDisplaying }"></span>
        </template>
    </div>

    {{-- Main screen --}}
    <div class="screen">
        {{-- Idle state --}}
        <div class="idle-content" x-show="!isDisplaying" x-transition:enter="transition-opacity duration-500" x-transition:leave="transition-opacity duration-500">
            <div class="idle-icon">
                <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.3)" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/>
                </svg>
            </div>
            <div class="idle-decoration"></div>
            <div class="idle-title">Selamat Datang</div>
            <div class="idle-subtitle">
                {{ $invitation->screen_bride_names ?: (($invitation->bride_nickname ?? $invitation->bride_name) . ' & ' . ($invitation->groom_nickname ?? $invitation->groom_name)) }}
            </div>
            @if($firstEvent)
                <div class="idle-date">
                    {{ $firstEvent->event_date?->format('l, d F Y') }}
                    @if($firstEvent->start_time)
                        &middot; {{ $firstEvent->start_time }}
                    @endif
                </div>
            @elseif($invitation->event_date)
                <div class="idle-date">{{ $invitation->event_date->format('l, d F Y') }}</div>
            @endif
            <div style="margin-top: 1rem;">
                <span class="pulse-dot"></span>
            </div>
        </div>

        {{-- Guest state --}}
        <div class="guest-content" x-show="isDisplaying" style="display: none;" x-transition:enter="transition-opacity duration-500" x-transition:leave="transition-opacity duration-500">
            <div class="guest-enter-icon" x-text="['🎉', '👋', '✨', '🎊', '🌟', '💐', '🥂', '🎵'][activeGuest ? activeGuest.id % 8 : 0]">🎉</div>
            <div class="guest-label">Tamu Hadir</div>
            <div class="guest-name" x-text="activeGuest ? activeGuest.name : ''"></div>
            <div class="guest-message">Terima kasih telah hadir</div>
            <div class="guest-decoration">
                <span class="line"></span>
                <span class="diamond"></span>
                <span class="line"></span>
            </div>
            <div class="guest-order" x-text="activeGuest && activeGuest.checkin_order ? 'Tamu ke-' + activeGuest.checkin_order : ''"></div>
        </div>
    </div>

    <div class="screen-footer">{{ config('app.name') }}</div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('welcomeScreen', () => ({
                galleries: @json($screenGalleries),
                currentSlide: 0,
                isSlideshowActive: false,
                isDisplaying: false,
                queue: [],
                activeGuest: null,
                knownIds: new Set(),
                lastCheckedInAt: null,
                countdownProgress: 100,

                idleTime: 0,
                idleTimer: null,
                pollTimer: null,
                slideshowTimer: null,
                displayTimer: null,
                progressTimer: null,

                init() {
                    this.startPolling();
                    this.resetIdleTimer();
                    this.initParticles();
                },

                resetIdleTimer() {
                    this.idleTime = 0;
                    this.isSlideshowActive = false;

                    if (this.idleTimer) clearInterval(this.idleTimer);
                    if (this.slideshowTimer) clearInterval(this.slideshowTimer);

                    this.idleTimer = setInterval(() => {
                        if (!this.isDisplaying) {
                            this.idleTime++;
                            if (this.idleTime >= 30) {
                                this.startSlideshow();
                                clearInterval(this.idleTimer);
                            }
                        } else {
                            this.idleTime = 0;
                        }
                    }, 1000);
                },

                startSlideshow() {
                    if (this.galleries.length === 0) return;
                    this.isSlideshowActive = true;
                    this.currentSlide = 0;

                    if (this.slideshowTimer) clearInterval(this.slideshowTimer);
                    this.slideshowTimer = setInterval(() => {
                        this.currentSlide = (this.currentSlide + 1) % this.galleries.length;
                    }, 5000);
                },

                async poll() {
                    try {
                        const params = new URLSearchParams();
                        if (this.lastCheckedInAt) {
                            params.set('since', this.lastCheckedInAt);
                        }
                        const url = @json(route('dashboard.welcome-screen.latest-checkin', $invitation)) + 
                            (params.toString() ? '?' + params.toString() : '');

                        const response = await fetch(url, {
                            headers: { 
                                'Accept': 'application/json', 
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') 
                            }
                        });
                        const data = await response.json();

                        if (data.success && data.guests.length > 0) {
                            const latest = data.guests[data.guests.length - 1];
                            if (!this.lastCheckedInAt || latest.checked_in_at > this.lastCheckedInAt) {
                                this.lastCheckedInAt = latest.checked_in_at;
                            }
                            this.enqueueGuests(data.guests);
                        }
                    } catch (e) {
                        console.warn('Poll failed:', e);
                    }
                },

                startPolling() {
                    this.poll();
                    this.pollTimer = setInterval(() => this.poll(), 3000);
                },

                enqueueGuests(guests) {
                    let newGuests = guests.filter(g => !this.knownIds.has(g.id));
                    if (newGuests.length === 0) return;

                    newGuests.forEach(g => this.knownIds.add(g.id));
                    this.queue.push(...newGuests);

                    if (!this.isDisplaying) {
                        this.processQueue();
                    }
                },

                processQueue() {
                    if (this.queue.length === 0) {
                        this.isDisplaying = false;
                        this.activeGuest = null;
                        this.resetIdleTimer();
                        return;
                    }

                    // Stop slideshow immediately when a guest is checked in
                    this.isSlideshowActive = false;
                    if (this.slideshowTimer) clearInterval(this.slideshowTimer);
                    if (this.idleTimer) clearInterval(this.idleTimer);

                    this.isDisplaying = true;
                    this.activeGuest = this.queue.shift();

                    // Animate progress bar
                    this.startProgressAnimation();

                    if (this.displayTimer) clearTimeout(this.displayTimer);
                    this.displayTimer = setTimeout(() => {
                        this.processQueue();
                    }, 7000);
                },

                startProgressAnimation() {
                    this.countdownProgress = 100;
                    if (this.progressTimer) clearInterval(this.progressTimer);

                    const duration = 7000;
                    const interval = 50;
                    const step = (interval / duration) * 100;

                    this.progressTimer = setInterval(() => {
                        this.countdownProgress -= step;
                        if (this.countdownProgress <= 0) {
                            this.countdownProgress = 0;
                            clearInterval(this.progressTimer);
                        }
                    }, interval);
                },

                initParticles() {
                    const container = document.getElementById('particles');
                    if (!container) return;
                    for (let i = 0; i < 30; i++) {
                        const span = document.createElement('span');
                        span.style.left = Math.random() * 100 + '%';
                        span.style.width = (Math.random() * 4 + 2) + 'px';
                        span.style.height = span.style.width;
                        span.style.animationDelay = Math.random() * 20 + 's';
                        span.style.animationDuration = (Math.random() * 15 + 15) + 's';
                        container.appendChild(span);
                    }
                }
            }));
        });
    </script>
</body>
</html>
