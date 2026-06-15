<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <x-meta title="{{ config('app.name', 'Rayakan Digital') }}" />

    @stack('meta')

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        if (localStorage.getItem('dark-mode') === 'true' || (!('dark-mode' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=DM+Sans:wght@300;400;500&display=swap');
    
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
    
        body {
            font-family: 'DM Sans', sans-serif;
            min-height: 100vh;
            display: flex;
        }
    
        /* ── LEFT PANEL ── */
        .auth-left {
            display: none;
            position: relative;
            flex: 1;
            overflow: hidden;
            background-color: #1a1a2e;
        }
    
        @media (min-width: 1024px) {
            .auth-left {
                display: flex;
                flex-direction: column;
                justify-content: flex-end;
                padding: 3rem;
            }
        }
    
        /* Ganti URL di sini dengan gambar pilihan Anda */
        .auth-left-bg {
            position: absolute;
            inset: 0;
            background-image: url('https://asset.kompas.com/crops/UHf7rMtp1EJQtR8d2M6EWse9Sz4=/0x0:1000x667/1200x800/data/photo/2024/01/31/65ba1831a03ff.jpg');
            background-size: cover;
            background-position: center;
            transition: transform 8s ease;
        }
    
        .auth-left-bg:hover {
            transform: scale(1.04);
        }
    
        /* overlay gelap */
        .auth-left-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(160deg,
                    rgba(15, 23, 42, 0.30) 0%,
                    rgba(15, 23, 42, 0.75) 60%,
                    rgba(15, 23, 42, 0.95) 100%);
        }
    
        /* teks di atas overlay */
        .auth-left-content {
            position: relative;
            z-index: 10;
            color: #fff;
        }
    
        .auth-left-content .brand {
            font-family: 'Playfair Display', serif;
            font-size: 2.25rem;
            font-weight: 700;
            line-height: 1.2;
            margin-bottom: 1rem;
            letter-spacing: -0.5px;
        }
    
        .auth-left-content .tagline {
            font-size: 0.95rem;
            color: rgba(255, 255, 255, 0.65);
            font-weight: 300;
            max-width: 28ch;
            line-height: 1.6;
        }
    
        .auth-left-content .divider {
            width: 3rem;
            height: 2px;
            background: linear-gradient(90deg, #f59e0b, #ef4444);
            border-radius: 9999px;
            margin-bottom: 1rem;
        }
    
        /* badge kecil di pojok kiri atas */
        .auth-left-badge {
            position: absolute;
            top: 2rem;
            left: 2rem;
            z-index: 10;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
    
        .auth-left-badge svg {
            width: 2rem;
            height: 2rem;
            fill: #fff;
        }
    
        .auth-left-badge span {
            font-family: 'Playfair Display', serif;
            font-size: 1.1rem;
            font-weight: 600;
            color: #fff;
            letter-spacing: 0.5px;
        }
    
        /* ── RIGHT PANEL ── */
        .auth-right {
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background: #f8fafc;
            padding: 2.5rem 1.5rem;
        }
    
        .dark .auth-right {
            background: #1a1a2e;
        }

        @media (min-width: 1024px) {
            .auth-right {
                width: 480px;
                min-width: 480px;
                flex: none;
            }
        }
    
        /* logo mobile (hanya tampil di layar kecil) */
        .auth-right-logo {
            display: flex;
            justify-content: center;
            margin-bottom: 2rem;
        }
    
        @media (min-width: 1024px) {
            .auth-right-logo {
                display: none;
            }
        }

    .auth-right-card {
        width: 100%;
        max-width: 400px;
        background: #fff;
        border-radius: 1.25rem;
        box-shadow:
            0 0 0 1px rgba(0, 0, 0, 0.05),
            0 4px 6px -1px rgba(0, 0, 0, 0.07),
            0 20px 40px -10px rgba(0, 0, 0, 0.10);
        padding: 2.5rem;
    }

    .dark .auth-right-card {
        background: #2a2a4a;
        box-shadow:
            0 0 0 1px rgba(255, 255, 255, 0.05),
            0 4px 6px -1px rgba(0, 0, 0, 0.3),
            0 20px 40px -10px rgba(0, 0, 0, 0.4);
    }
    </style>
    </head>

<body class="font-sans text-gray-900 dark:text-neutral-200 antialiased">
    <!-- ═══════════════ LEFT PANEL ═══════════════ -->
    <div class="auth-left">
        <div class="auth-left-bg"></div>
        <div class="auth-left-overlay"></div>
    
        <!-- Logo di pojok kiri atas -->
        <div class="auth-left-badge">
            <x-application-logo />
        </div>
    
        <!-- Teks bawah -->
        <div class="auth-left-content">
            <div class="divider"></div>
            <p class="brand">Selamat Datang<br>Kembali.</p>
            <p class="tagline">Masuk ke akun Anda dan lanjutkan perjalanan Anda bersama kami.</p>
        </div>
    </div>
    
    <!-- ═══════════════ RIGHT PANEL ═══════════════ -->
    <div class="auth-right">
    
        <!-- Logo mobile -->
        <div class="auth-right-logo">
            <a href="/">
                <x-application-logo class="w-16 h-16 fill-current text-gray-500 dark:text-neutral-400" />
                </a>
                </div>

        <!-- Card form -->
        <div class="auth-right-card">
            {{ $slot }}
        </div>

    </div>

    <x-sweet-alert />
    </body>

</html>