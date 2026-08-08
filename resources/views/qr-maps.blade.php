<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Petunjuk Lokasi & Maps — {{ $invitation->couple_name }}</title>

    <x-meta title="Petunjuk Lokasi & Maps {{ $invitation->couple_name }}"
        description="Petunjuk arah lokasi venue, titik parkir, dan navigasi langsung ke {{ $invitation->venue_name ?? 'Lokasi Acara' }}." />

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link
        href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800|playfair-display:400,500,600,700&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />

    @vite(['resources/css/app.css'])

    <script>
        if (localStorage.getItem('dark-mode') === 'true' || (!('dark-mode' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    <style>
        body {
            background-image:
                radial-gradient(ellipse at 20% 10%, rgba(16, 185, 129, 0.12) 0%, transparent 50%),
                radial-gradient(ellipse at 80% 90%, rgba(59, 130, 246, 0.10) 0%, transparent 50%),
                radial-gradient(ellipse at 50% 50%, rgba(16, 185, 129, 0.04) 0%, transparent 70%);
            background-attachment: fixed;
        }

        @keyframes float-in {
            from { opacity: 0; transform: translateY(20px) scale(0.96); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }

        .animate-float-in { animation: float-in 0.5s cubic-bezier(0.22, 0.61, 0.36, 1) both; }
    </style>
</head>

<body class="font-sans antialiased bg-neutral-50 dark:bg-secondary-900 text-secondary-800 dark:text-neutral-200 min-h-screen flex items-center justify-center p-4 sm:p-6">

    <!-- Dark Mode Toggle -->
    <button type="button" id="theme-toggle"
        class="fixed top-4 right-4 z-50 w-11 h-11 rounded-full bg-white/80 dark:bg-secondary-800/80 backdrop-blur-md shadow-lg border border-neutral-200/60 dark:border-secondary-700/60 flex items-center justify-center text-neutral-600 dark:text-neutral-300 hover:text-emerald-500 transition-all">
        <i class="fa-solid fa-sun dark:hidden text-base"></i>
        <i class="fa-solid fa-moon hidden dark:block text-base"></i>
    </button>

    <div class="w-full max-w-lg animate-float-in">
        <!-- Main Card Container -->
        <div class="bg-white/90 dark:bg-secondary-800/90 backdrop-blur-xl rounded-3xl border border-neutral-200/80 dark:border-secondary-700/80 shadow-2xl shadow-emerald-500/10 overflow-hidden">
            
            <!-- Header Header Gradient Banner -->
            <div class="bg-gradient-to-r from-emerald-600 via-teal-600 to-emerald-800 text-white p-6 sm:p-7 text-center relative overflow-hidden">
                <div class="absolute -right-6 -top-6 w-32 h-32 bg-white/10 rounded-full blur-2xl pointer-events-none"></div>
                <div class="absolute -left-6 -bottom-6 w-32 h-32 bg-emerald-400/20 rounded-full blur-2xl pointer-events-none"></div>

                <div class="relative z-10">
                    <div class="w-14 h-14 mx-auto rounded-2xl bg-white/20 backdrop-blur-md border border-white/30 flex items-center justify-center text-white mb-3 shadow-lg">
                        <i class="fa-solid fa-map-location-dot text-2xl"></i>
                    </div>

                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold bg-white/20 backdrop-blur-md text-white uppercase tracking-wider mb-2">
                        <i class="fa-solid fa-compass text-xs"></i> Navigasi & Arah
                    </span>

                    <h1 class="font-heading text-2xl sm:text-3xl font-bold tracking-tight">
                        {{ $invitation->couple_name }}
                    </h1>
                    <p class="text-xs sm:text-sm text-emerald-100 mt-1">
                        Petunjuk Lokasi Acara & Navigasi Direct
                    </p>
                </div>
            </div>

            <!-- Content Area -->
            <div class="p-6 sm:p-8 space-y-6">

                @php
                    $firstEvent = $invitation->events->first();
                    $venueName = $invitation->venue_name ?: ($firstEvent?->place_name ?? 'Lokasi Acara');
                    $venueAddress = $invitation->venue_address ?: ($firstEvent?->place_address ?? '');
                @endphp

                <!-- Venue Info Card -->
                <div class="bg-neutral-50 dark:bg-secondary-700/50 rounded-2xl p-5 border border-neutral-200/70 dark:border-secondary-600/50 space-y-3">
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 rounded-xl bg-emerald-100 dark:bg-emerald-900/40 text-emerald-600 dark:text-emerald-400 flex items-center justify-center flex-shrink-0 mt-0.5">
                            <i class="fa-solid fa-building-user text-lg"></i>
                        </div>
                        <div>
                            <h2 class="font-bold text-base text-secondary-800 dark:text-neutral-100">
                                {{ $venueName }}
                            </h2>
                            @if($venueAddress)
                                <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-1 leading-relaxed">
                                    <i class="fa-solid fa-location-dot text-emerald-500 me-1"></i> {{ $venueAddress }}
                                </p>
                            @endif
                        </div>
                    </div>

                    @if($invitation->event_date)
                        <div class="pt-2 border-t border-neutral-200/60 dark:border-secondary-600/40 flex items-center justify-between text-xs text-neutral-600 dark:text-neutral-300">
                            <span class="flex items-center gap-1.5 font-medium">
                                <i class="fa-regular fa-calendar-check text-emerald-500"></i> {{ $invitation->event_date->translatedFormat('l, d F Y') }}
                            </span>
                            @if($invitation->event_time)
                                <span class="font-medium bg-emerald-100 dark:bg-emerald-900/40 text-emerald-700 dark:text-emerald-300 px-2 py-0.5 rounded-md">
                                    {{ $invitation->event_time }} WIB
                                </span>
                            @endif
                        </div>
                    @endif
                </div>

                <!-- Direct Navigation Apps Buttons -->
                <div class="space-y-3">
                    <p class="text-xs font-bold uppercase tracking-wider text-neutral-400 dark:text-neutral-500">
                        <i class="fa-solid fa-location-arrow me-1"></i> Navigasi Acara
                    </p>

                    @php
                        $firstEvent = $invitation->events->first();
                        $mapsUrl = $invitation->venue_maps_url 
                            ?: ($firstEvent?->google_maps_url 
                            ?: ('https://www.google.com/maps/search/?api=1&query=' . urlencode(($firstEvent?->place_name ?? $invitation->venue_name ?? '') . ' ' . ($firstEvent?->place_address ?? $invitation->venue_address ?? ''))));
                    @endphp

                    <div>
                        <a href="{{ $mapsUrl }}" target="_blank" rel="noopener noreferrer"
                            class="flex items-center justify-center gap-2.5 px-6 py-4 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 active:scale-[0.98] text-white rounded-2xl font-bold text-sm shadow-xl shadow-emerald-600/20 transition-all w-full text-center">
                            <i class="fa-solid fa-map-location-dot text-lg"></i>
                            Buka di Google Maps
                        </a>
                    </div>
                </div>

                <!-- Parking & Gate Entrance Info -->
                <div class="bg-amber-50/70 dark:bg-amber-950/20 rounded-2xl p-5 border border-amber-200/70 dark:border-amber-800/40 space-y-2">
                    <div class="flex items-center gap-2 text-amber-800 dark:text-amber-300 font-bold text-sm">
                        <div class="w-7 h-7 rounded-lg bg-amber-100 dark:bg-amber-900/50 flex items-center justify-center text-amber-600 dark:text-amber-400">
                            <i class="fa-solid fa-square-parking text-sm"></i>
                        </div>
                        Petunjuk Titik Parkir & Akses Masuk
                    </div>

                    <div class="text-xs text-amber-900/80 dark:text-amber-200/80 leading-relaxed space-y-1.5 pt-1">
                        @if($invitation->venue_parking_info)
                            {!! nl2br(e($invitation->venue_parking_info)) !!}
                        @else
                            <p><i class="fa-solid fa-circle-info text-amber-500 me-1"></i> Area parkir kendaraan roda 2 dan roda 4 disiapkan di pelataran lokasi venue.</p>
                            <p><i class="fa-solid fa-user-shield text-amber-500 me-1"></i> Harap ikuti arahan dari panitia / juru parkir di lokasi acara untuk akses pintu masuk utama.</p>
                        @endif
                    </div>
                </div>

                <!-- Back to Main Invitation -->
                <div class="pt-2 text-center">
                    <a href="{{ route('invitation.show', $invitation->slug) }}"
                        class="inline-flex items-center gap-2 text-xs font-semibold text-neutral-500 dark:text-neutral-400 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">
                        <i class="fa-solid fa-arrow-left"></i> Buka Website Undangan Utama
                    </a>
                </div>
            </div>

            <!-- Footer -->
            <div class="px-6 py-4 bg-neutral-100/60 dark:bg-secondary-900/60 border-t border-neutral-200/60 dark:border-secondary-700/60 text-center">
                <p class="text-[11px] text-neutral-400 dark:text-neutral-500">
                    &copy; {{ date('Y') }} Rayakan Digital · Navigasi & Maps
                </p>
            </div>

        </div>
    </div>

    <script>
        document.getElementById('theme-toggle').addEventListener('click', function() {
            const isDark = document.documentElement.classList.toggle('dark');
            localStorage.setItem('dark-mode', isDark);
        });
    </script>
</body>
</html>
