<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <x-meta title="{{ config('app.name', 'Rayakan Digital') }}" />

    @stack('meta')

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <script>
        if (localStorage.getItem('dark-mode') === 'true' || (!('dark-mode' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html {
            height: 100%;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: 100vh;
            display: flex;
            background: #f8fafc;
        }

        /* ══════════════════════════════════
           LEFT PANEL
        ══════════════════════════════════ */
        .auth-left {
            display: none;
            position: relative;
            flex: 1;
            overflow: hidden;
            background: #0f0f1a;
        }

        @media (min-width: 1024px) {
            .auth-left {
                display: flex;
                flex-direction: column;
            }
        }

        /* Photo background */
        .auth-bg-photo {
            position: absolute;
            inset: 0;
            background-image: url('https://asset.kompas.com/crops/UHf7rMtp1EJQtR8d2M6EWse9Sz4=/0x0:1000x667/1200x800/data/photo/2024/01/31/65ba1831a03ff.jpg');
            background-size: cover;
            background-position: center;
            transform: scale(1.05);
            transition: transform 12s ease-out;
            animation: bgZoom 20s ease-in-out infinite alternate;
        }

        @keyframes bgZoom {
            from {
                transform: scale(1.0);
            }

            to {
                transform: scale(1.08);
            }
        }

        /* Multi-layer overlay */
        .auth-bg-overlay {
            position: absolute;
            inset: 0;
            background:
                linear-gradient(135deg, rgba(255, 122, 0, 0.18) 0%, transparent 50%),
                linear-gradient(180deg,
                    rgba(10, 10, 26, 0.20) 0%,
                    rgba(10, 10, 26, 0.55) 45%,
                    rgba(10, 10, 26, 0.92) 100%);
        }

        /* Floating orbs */
        .auth-orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.25;
            pointer-events: none;
        }

        .auth-orb-1 {
            width: 380px;
            height: 380px;
            top: -80px;
            left: -80px;
            background: radial-gradient(circle, #FF7A00, transparent 70%);
            animation: orbFloat1 12s ease-in-out infinite;
        }

        .auth-orb-2 {
            width: 320px;
            height: 320px;
            bottom: 100px;
            right: -60px;
            background: radial-gradient(circle, #7c3aed, transparent 70%);
            animation: orbFloat2 15s ease-in-out infinite;
        }

        .auth-orb-3 {
            width: 200px;
            height: 200px;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: radial-gradient(circle, #FF7A00, transparent 70%);
            opacity: 0.12;
            animation: orbFloat3 18s ease-in-out infinite;
        }

        @keyframes orbFloat1 {

            0%,
            100% {
                transform: translate(0, 0) scale(1);
            }

            33% {
                transform: translate(30px, 20px) scale(1.05);
            }

            66% {
                transform: translate(-15px, 35px) scale(0.97);
            }
        }

        @keyframes orbFloat2 {

            0%,
            100% {
                transform: translate(0, 0) scale(1);
            }

            50% {
                transform: translate(-25px, -20px) scale(1.08);
            }
        }

        @keyframes orbFloat3 {

            0%,
            100% {
                transform: translate(-50%, -50%) scale(1);
            }

            50% {
                transform: translate(-50%, -55%) scale(1.15);
            }
        }

        /* Floating particles */
        .auth-particles {
            position: absolute;
            inset: 0;
            overflow: hidden;
            pointer-events: none;
        }

        .auth-particle {
            position: absolute;
            width: 3px;
            height: 3px;
            background: rgba(255, 255, 255, 0.6);
            border-radius: 50%;
            animation: particleFly linear infinite;
        }

        @keyframes particleFly {
            0% {
                transform: translateY(100vh) scale(0);
                opacity: 0;
            }

            10% {
                opacity: 1;
            }

            90% {
                opacity: 0.5;
            }

            100% {
                transform: translateY(-10vh) scale(1.5);
                opacity: 0;
            }
        }

        /* Top logo badge */
        .auth-left-logo {
            position: absolute;
            top: 2.5rem;
            left: 2.5rem;
            z-index: 20;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            text-decoration: none;
        }

        .auth-left-logo-icon {
            width: auto;
            height: 2.5rem;
            padding: 30px;
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.20);
            border-radius: 0.875rem;
            display: flex;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(8px);
        }

        .auth-left-logo-name {
            font-family: 'Playfair Display', serif;
            font-size: 1.15rem;
            font-weight: 700;
            color: #fff;
            letter-spacing: 0.3px;
        }

        /* Bottom content */
        .auth-left-content {
            position: relative;
            z-index: 20;
            margin-top: auto;
            padding: 3rem;
        }

        .auth-accent-line {
            width: 3rem;
            height: 3px;
            background: linear-gradient(90deg, #FF7A00, #ff4500);
            border-radius: 9999px;
            margin-bottom: 1.5rem;
        }

        .auth-headline {
            font-family: 'Playfair Display', serif;
            font-size: clamp(2rem, 3.5vw, 2.8rem);
            font-weight: 700;
            color: #fff;
            line-height: 1.2;
            margin-bottom: 1rem;
            letter-spacing: -0.5px;
        }

        .auth-headline em {
            font-style: italic;
            color: #FF9733;
        }

        .auth-subline {
            font-size: 0.9375rem;
            color: rgba(255, 255, 255, 0.60);
            font-weight: 400;
            max-width: 32ch;
            line-height: 1.65;
            margin-bottom: 2.5rem;
        }

        /* Social proof pills */
        .auth-social-proof {
            display: flex;
            align-items: center;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .auth-avatars {
            display: flex;
        }

        .auth-avatars img,
        .auth-avatar-placeholder {
            width: 2.25rem;
            height: 2.25rem;
            border-radius: 50%;
            border: 2.5px solid rgba(255, 255, 255, 0.3);
            margin-left: -0.625rem;
            background: linear-gradient(135deg, #FF7A00, #D96500);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.7rem;
            font-weight: 600;
            color: #fff;
        }

        .auth-avatars>*:first-child {
            margin-left: 0;
        }

        .auth-proof-text {
            font-size: 0.8125rem;
            color: rgba(255, 255, 255, 0.55);
            line-height: 1.45;
        }

        .auth-proof-text strong {
            color: rgba(255, 255, 255, 0.90);
            font-weight: 600;
        }

        /* Feature pills */
        .auth-features {
            display: flex;
            flex-wrap: wrap;
            gap: 0.625rem;
            margin-bottom: 2rem;
        }

        .auth-feature-pill {
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
            padding: 0.375rem 0.875rem;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 9999px;
            font-size: 0.8125rem;
            color: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(8px);
        }

        .auth-feature-pill-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #FF7A00;
            flex-shrink: 0;
        }

        /* ══════════════════════════════════
           RIGHT PANEL
        ══════════════════════════════════ */
        .dark body {
            background: #0d0d1a;
        }

        .auth-right {
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 2rem 1.25rem;
            background: #f8fafc;
            min-height: 100vh;
        }

        .dark .auth-right {
            background: #0d0d1a;
        }

        @media (min-width: 1024px) {
            .auth-right {
                width: 520px;
                min-width: 520px;
                flex: none;
                padding: 2.5rem;
            }
        }

        /* Mobile logo */
        .auth-right-mobile-logo {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 2rem;
        }

        @media (min-width: 1024px) {
            .auth-right-mobile-logo {
                display: none;
            }
        }

        .auth-right-mobile-logo-name {
            font-family: 'Playfair Display', serif;
            font-size: 1.25rem;
            font-weight: 700;
            color: #FF7A00;
        }

        /* Card */
        .auth-card {
            width: 100%;
            max-width: 420px;
            background: #ffffff;
            border-radius: 1.5rem;
            box-shadow:
                0 0 0 1px rgba(0, 0, 0, 0.06),
                0 8px 30px -8px rgba(0, 0, 0, 0.12),
                0 40px 80px -20px rgba(0, 0, 0, 0.08);
            padding: 2.75rem 2.5rem;
            position: relative;
            overflow: hidden;
        }

        .dark .auth-card {
            background: #16162a;
            box-shadow:
                0 0 0 1px rgba(255, 255, 255, 0.06),
                0 8px 30px -8px rgba(0, 0, 0, 0.4),
                0 40px 80px -20px rgba(0, 0, 0, 0.5);
        }

        /* Subtle top accent on card */
        .auth-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, #FF7A00, #ff4500, #FF9733);
            border-radius: 1.5rem 1.5rem 0 0;
        }

        /* Glow effect */
        .auth-card::after {
            content: '';
            position: absolute;
            top: -60px;
            left: 50%;
            transform: translateX(-50%);
            width: 200px;
            height: 120px;
            background: radial-gradient(ellipse, rgba(255, 122, 0, 0.12), transparent 70%);
            pointer-events: none;
        }

        /* Footer below card */
        .auth-footer {
            margin-top: 1.75rem;
            text-align: center;
            font-size: 0.8125rem;
            color: #9ca3af;
        }

        .dark .auth-footer {
            color: #6b7280;
        }

        .auth-footer a {
            color: #FF7A00;
            font-weight: 600;
            text-decoration: none;
            transition: color 0.2s;
        }

        .auth-footer a:hover {
            color: #D96500;
            text-decoration: underline;
        }

        /* Card header styling */
        .auth-card-header {
            margin-bottom: 2rem;
        }

        .auth-card-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.75rem;
            font-weight: 600;
            color: #FF7A00;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 0.875rem;
        }

        .auth-card-eyebrow-line {
            width: 20px;
            height: 1.5px;
            background: #FF7A00;
            border-radius: 2px;
        }

        .auth-card-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.75rem;
            font-weight: 700;
            color: #0f0f1a;
            line-height: 1.25;
            margin-bottom: 0.5rem;
        }

        .dark .auth-card-title {
            color: #f1f5f9;
        }

        .auth-card-subtitle {
            font-size: 0.9rem;
            color: #6b7280;
            line-height: 1.5;
        }

        .dark .auth-card-subtitle {
            color: #9ca3af;
        }
    </style>
</head>

<body class="font-sans text-gray-900 dark:text-neutral-100 antialiased">

    {{-- ═══════════════ LEFT PANEL ═══════════════ --}}
    <div class="auth-left">
        {{-- Background layers --}}
        <div class="auth-bg-photo"></div>
        <div class="auth-bg-overlay"></div>

        {{-- Orbs --}}
        <div class="auth-orb auth-orb-1"></div>
        <div class="auth-orb auth-orb-2"></div>
        <div class="auth-orb auth-orb-3"></div>

        {{-- Particles --}}
        <div class="auth-particles" id="authParticles"></div>

        {{-- Top logo --}}
        <a href="/" class="auth-left-logo">
            <div class="auth-left-logo-icon">
                <x-application-logo />
            </div>
            <span class="auth-left-logo-name">Rayakan Digital</span>
        </a>

        {{-- Bottom content --}}
        <div class="auth-left-content">
            <div class="auth-features">
                <span class="auth-feature-pill">
                    <span class="auth-feature-pill-dot"></span>
                    Undangan Digital
                </span>
                <span class="auth-feature-pill">
                    <span class="auth-feature-pill-dot"></span>
                    Live Streaming
                </span>
                <span class="auth-feature-pill">
                    <span class="auth-feature-pill-dot"></span>
                    Buku Tamu
                </span>
            </div>

            <div class="auth-accent-line"></div>

            <h2 class="auth-headline">
                Buat Momen<br>Istimewa <em>Anda</em><br>Tak Terlupakan.
            </h2>

            <p class="auth-subline">
                Platform undangan digital terlengkap untuk pernikahan, dan berbagai acara spesial Anda.
            </p>

            <!-- <div class="auth-social-proof">
                <div class="auth-avatars">
                    <div class="auth-avatar-placeholder">AN</div>
                    <div class="auth-avatar-placeholder" style="background: linear-gradient(135deg,#7c3aed,#5b21b6)">BW
                    </div>
                    <div class="auth-avatar-placeholder" style="background: linear-gradient(135deg,#059669,#047857)">CR
                    </div>
                    <div class="auth-avatar-placeholder" style="background: linear-gradient(135deg,#db2777,#be185d)">DM
                    </div>
                </div>
                <div class="auth-proof-text">
                    <strong>10.000+ pasangan</strong><br>
                    telah mempercayai kami
                </div>
            </div> -->
        </div>
    </div>

    {{-- ═══════════════ RIGHT PANEL ═══════════════ --}}
    <div class="auth-right">

        {{-- Mobile logo --}}
        <div class="auth-right-mobile-logo">
            <a href="/">
                <x-application-logo class="w-14 h-14 fill-current text-primary" />
            </a>
            <span class="auth-right-mobile-logo-name">Rayakan Digital</span>
        </div>

        {{-- Card --}}
        <div class="auth-card">
            {{ $slot }}
        </div>

        {{-- Footer --}}
        <div class="auth-footer">
            &copy; {{ date('Y') }} Rayakan Digital · <a href="/syarat-ketentuan">Syarat</a> &amp; <a
                href="/kebijakan-privasi">Privasi</a>
        </div>
    </div>

    <x-sweet-alert />

    <script>
        // Generate floating particles
        (function () {
            const container = document.getElementById('authParticles');
            if (!container) return;
            const count = 18;
            for (let i = 0; i < count; i++) {
                const p = document.createElement('div');
                p.className = 'auth-particle';
                const size = Math.random() * 3 + 1.5;
                p.style.cssText = [
                    `width: ${size}px`,
                    `height: ${size}px`,
                    `left: ${Math.random() * 100}%`,
                    `animation-duration: ${Math.random() * 14 + 8}s`,
                    `animation-delay: ${Math.random() * 10}s`,
                    `opacity: ${Math.random() * 0.5 + 0.2}`,
                ].join(';');
                container.appendChild(p);
            }
        })();
    </script>
</body>

</html>