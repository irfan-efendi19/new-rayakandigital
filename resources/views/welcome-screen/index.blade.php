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
    @vite(['resources/css/app.css'])
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #0f0f1a 0%, #1a1a2e 50%, #16213e 100%);
            color: #fff;
            overflow: hidden;
            height: 100vh;
            width: 100vw;
            display: flex;
            align-items: center;
            justify-content: center;
            user-select: none;
        }

        /* Decorative background particles */
        .bg-particles {
            position: fixed;
            inset: 0;
            pointer-events: none;
            z-index: 0;
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
            z-index: 1;
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
            z-index: 2;
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
        .guest-content { display: none; flex-direction: column; align-items: center; gap: 1rem; }

        .guest-enter-icon {
            font-size: clamp(2rem, 4vw, 3.5rem);
            opacity: 0;
            animation: fadeInDown 0.8s ease forwards;
        }

        .guest-label {
            font-size: clamp(0.9rem, 1.2vw, 1.1rem);
            color: rgba(255,255,255,0.5);
            font-weight: 400;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            opacity: 0;
            animation: fadeInDown 0.8s ease 0.2s forwards;
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
            opacity: 0;
            animation: fadeInUp 1s ease 0.4s forwards;
        }

        .guest-message {
            font-size: clamp(1.1rem, 1.8vw, 1.6rem);
            color: rgba(255,255,255,0.6);
            font-weight: 300;
            opacity: 0;
            animation: fadeInUp 0.8s ease 0.8s forwards;
        }

        .guest-decoration {
            display: flex;
            align-items: center;
            gap: 1rem;
            opacity: 0;
            animation: fadeIn 0.8s ease 1s forwards;
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
            opacity: 0;
            animation: fadeIn 0.8s ease 1.2s forwards;
        }

        /* Transitions */
        .fade-transition {
            transition: opacity 0.6s ease, transform 0.6s ease;
        }

        .hidden-state { display: none !important; }

        /* Animations */
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(40px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes fadeInDown { from { opacity: 0; transform: translateY(-20px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes fadeOut { from { opacity: 1; } to { opacity: 0; } }

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
            z-index: 3;
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
            z-index: 3;
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
            z-index: 2;
            font-size: 0.75rem;
            color: rgba(255,255,255,0.15);
            font-weight: 300;
            letter-spacing: 0.05em;
        }

        /* Hide scrollbar */
        ::-webkit-scrollbar { display: none; }
    </style>
</head>
<body>
    {{-- Background particles --}}
    <div class="bg-particles" id="particles"></div>

    {{-- Corner decorations --}}
    <div class="corner corner-tl"></div>
    <div class="corner corner-tr"></div>
    <div class="corner corner-bl"></div>
    <div class="corner corner-br"></div>

    {{-- Countdown bar --}}
    <div class="countdown-bar idle" id="countdownBar"></div>

    {{-- Queue indicator --}}
    <div class="queue-indicator" id="queueIndicator"></div>

    {{-- Main screen --}}
    <div class="screen">
        {{-- Idle state --}}
        <div class="idle-content" id="idleContent">
            <div class="idle-icon">
                <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.3)" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/>
                </svg>
            </div>
            <div class="idle-decoration"></div>
            <div class="idle-title">Selamat Datang</div>
            <div class="idle-subtitle">
                {{ $invitation->bride_nickname ?? $invitation->bride_name }}
                &amp;
                {{ $invitation->groom_nickname ?? $invitation->groom_name }}
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
        <div class="guest-content" id="guestContent">
            <div class="guest-enter-icon" id="guestIcon">🎉</div>
            <div class="guest-label">Tamu Hadir</div>
            <div class="guest-name" id="guestName"></div>
            <div class="guest-message" id="guestMessage">Terima kasih telah hadir</div>
            <div class="guest-decoration">
                <span class="line"></span>
                <span class="diamond"></span>
                <span class="line"></span>
            </div>
            <div class="guest-order" id="guestOrder"></div>
        </div>
    </div>

    <div class="screen-footer">{{ config('app.name') }}</div>

    <script>
        const API_URL = @json(route('dashboard.welcome-screen.latest-checkin', $invitation));
        const DISPLAY_DURATION = 7000;
        const POLL_INTERVAL = 3000;

        let queue = [];
        let isDisplaying = false;
        let lastCheckedInAt = null;
        let pollTimer = null;
        let displayTimer = null;
        let countdownTimer = null;
        let knownIds = new Set();

        const idleContent = document.getElementById('idleContent');
        const guestContent = document.getElementById('guestContent');
        const guestName = document.getElementById('guestName');
        const guestOrder = document.getElementById('guestOrder');
        const guestMessage = document.getElementById('guestMessage');
        const guestIcon = document.getElementById('guestIcon');
        const countdownBar = document.getElementById('countdownBar');
        const queueIndicator = document.getElementById('queueIndicator');

        function showIdle() {
            guestContent.style.display = 'none';
            idleContent.style.display = 'flex';

            countdownBar.classList.add('idle');
            countdownBar.style.transform = 'scaleX(1)';
            countdownBar.style.transition = 'none';
        }

        function showGuest(guest) {
            idleContent.style.display = 'none';
            guestContent.style.display = 'flex';

            guestName.textContent = guest.name;

            const icons = ['🎉', '👋', '✨', '🎊', '🌟', '💐', '🥂', '🎵'];
            guestIcon.textContent = icons[guest.id % icons.length];

            if (guest.checkin_order) {
                guestOrder.textContent = 'Tamu ke-' + guest.checkin_order;
            } else {
                guestOrder.textContent = '';
            }

            guestContent.style.opacity = '0';
            requestAnimationFrame(() => {
                guestContent.style.opacity = '1';
            });

            countdownBar.classList.remove('idle');
            countdownBar.style.transition = 'none';
            countdownBar.style.transform = 'scaleX(1)';
            requestAnimationFrame(() => {
                countdownBar.style.transition = 'transform ' + (DISPLAY_DURATION / 1000) + 's linear';
                countdownBar.style.transform = 'scaleX(0)';
            });
        }

        function processQueue() {
            if (queue.length === 0) {
                isDisplaying = false;
                showIdle();
                return;
            }

            isDisplaying = true;
            const guest = queue.shift();
            updateQueueIndicator();
            showGuest(guest);

            clearTimeout(displayTimer);
            displayTimer = setTimeout(() => {
                processQueue();
            }, DISPLAY_DURATION);
        }

        function enqueueGuests(guests) {
            let newGuests = guests.filter(g => !knownIds.has(g.id));
            if (newGuests.length === 0) return;

            newGuests.forEach(g => knownIds.add(g.id));
            queue.push(...newGuests);

            updateQueueIndicator();

            if (!isDisplaying) {
                processQueue();
            }
        }

        function updateQueueIndicator() {
            const total = queue.length + (isDisplaying ? 1 : 0);
            queueIndicator.innerHTML = '';
            for (let i = 0; i < Math.min(total, 8); i++) {
                const dot = document.createElement('span');
                dot.className = 'queue-dot';
                if (i === 0 && isDisplaying) dot.classList.add('active');
                else if (i > 0 || !isDisplaying) dot.classList.add('queued');
                queueIndicator.appendChild(dot);
            }
        }

        async function poll() {
            try {
                const params = new URLSearchParams();
                if (lastCheckedInAt) {
                    params.set('since', lastCheckedInAt);
                }
                const url = API_URL + (params.toString() ? '?' + params.toString() : '');

                const response = await fetch(url, {
                    headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') }
                });
                const data = await response.json();

                if (data.success && data.guests.length > 0) {
                    const serverTime = data.server_time;
                    if (data.guests.length > 0) {
                        const latest = data.guests[data.guests.length - 1];
                        if (latest.checked_in_at > (lastCheckedInAt || '')) {
                            lastCheckedInAt = latest.checked_in_at;
                        }
                    }

                    enqueueGuests(data.guests);
                }
            } catch (e) {
                console.warn('Poll failed:', e);
            }

            pollTimer = setTimeout(poll, POLL_INTERVAL);
        }

        function initParticles() {
            const container = document.getElementById('particles');
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

        initParticles();
        showIdle();

        poll();
    </script>
</body>
</html>
