<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <x-meta
        :title="$invitation->bride_name . ' & ' . $invitation->groom_name . ' - Wedding Invitation'"
        :description="'Undangan Pernikahan ' . $invitation->bride_name . ' & ' . $invitation->groom_name"
        :image="$invitation->cover_photo ? asset('storage/' . $invitation->cover_photo) : null"
        :url="url()->current()"
        type="website"
        robots="index, follow"
    />

    @stack('meta')

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    @yield('fonts')

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        .cover-overlay {
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: @yield('cover-bg-color', '#fff');
            z-index: 9999;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            transition: transform 1s ease-in-out, opacity 1s ease-in-out;
        }
        .cover-overlay.opened {
            transform: translateY(-100%);
            opacity: 0;
            pointer-events: none;
        }
        
        body.locked {
            overflow: hidden;
            height: 100vh;
        }
    </style>
    @stack('styles')
</head>
<body class="antialiased locked text-gray-800 bg-gray-50 @yield('body-class')">

    <!-- Cover (Tap to Open) -->
    <div id="welcome-cover" class="cover-overlay text-center px-4">
        @yield('cover-content')
        
        <div class="mt-8">
            <button id="btn-open-invitation" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-full shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 animate-bounce">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                </svg>
                Buka Undangan
            </button>
        </div>
    </div>

    <!-- Floating Audio Player -->
    <div class="fixed bottom-6 right-6 z-50">
        <button id="btn-audio" class="bg-indigo-600 text-white p-3 rounded-full shadow-lg hover:bg-indigo-700 transition animate-spin-slow">
            <svg id="icon-music-on" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
            </svg>
            <svg id="icon-music-off" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.907L5.586 15z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2" />
            </svg>
        </button>
        <!-- Custom or default audio based on tier & upload -->
        <audio id="bg-audio" loop preload="auto">
            <source src="{{ ($invitation->canUseCustomMusic() && $invitation->music_url) ? asset('storage/' . $invitation->music_url) : 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-1.mp3' }}" type="audio/mpeg">
        </audio>
    </div>

    <!-- Main Content -->
    <main class="max-w-md mx-auto bg-white min-h-screen shadow-xl relative overflow-x-hidden">
        @yield('content')
        
        <div class="py-8 text-center bg-gray-100 text-xs text-gray-400">
            Created with <a href="{{ route('home') }}" class="font-semibold text-indigo-500">RayakanDigital</a>
        </div>
    </main>

    <x-sweet-alert />

    <!-- Scripts -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            AOS.init({
                duration: 1000,
                once: true,
                offset: 50
            });

            // Handle Cover & Audio
            const btnOpen = document.getElementById('btn-open-invitation');
            const cover = document.getElementById('welcome-cover');
            const audio = document.getElementById('bg-audio');
            const btnAudio = document.getElementById('btn-audio');
            const iconOn = document.getElementById('icon-music-on');
            const iconOff = document.getElementById('icon-music-off');
            let isPlaying = false;

            btnOpen.addEventListener('click', function() {
                cover.classList.add('opened');
                document.body.classList.remove('locked');
                
                // Play audio
                audio.play().then(() => {
                    isPlaying = true;
                }).catch(e => console.log("Audio play failed:", e));
            });

            btnAudio.addEventListener('click', function() {
                if (isPlaying) {
                    audio.pause();
                    btnAudio.classList.remove('animate-spin-slow');
                    iconOn.classList.add('hidden');
                    iconOff.classList.remove('hidden');
                } else {
                    audio.play();
                    btnAudio.classList.add('animate-spin-slow');
                    iconOn.classList.remove('hidden');
                    iconOff.classList.add('hidden');
                }
                isPlaying = !isPlaying;
            });
            
            // Handle RSVP Form
            const rsvpForm = document.getElementById('rsvp-form');
            if(rsvpForm) {
                rsvpForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const formData = new FormData(this);
                    
                    fetch(this.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if(data.success) {
                            Swal.fire({ icon: 'success', title: 'Berhasil!', text: data.message, timer: 3000, showConfirmButton: false });
                            this.reset();
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire({ icon: 'error', title: 'Gagal!', text: 'Terjadi kesalahan. Silakan coba lagi.', timer: 3000, showConfirmButton: false });
                    });
                });
            }
            
            // Handle Wish Form
            const wishForm = document.getElementById('wish-form');
            if(wishForm) {
                wishForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const formData = new FormData(this);
                    
                    fetch(this.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if(data.success) {
                            Swal.fire({ icon: 'success', title: 'Berhasil!', text: data.message, timer: 2000, showConfirmButton: false });
                            this.reset();
                            setTimeout(() => location.reload(), 1000);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire({ icon: 'error', title: 'Gagal!', text: 'Terjadi kesalahan. Silakan coba lagi.', timer: 3000, showConfirmButton: false });
                    });
                });
            }
        });
    </script>
    <style>
        .animate-spin-slow {
            animation: spin 3s linear infinite;
        }
    </style>

    @if(isset($firstEvent) && $firstEvent)
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var timer = document.getElementById('countdown-timer');
            if (!timer) return;

            var targetDate = new Date(
                parseInt(timer.dataset.year),
                parseInt(timer.dataset.month) - 1,
                parseInt(timer.dataset.day)
            );

            function updateCountdown() {
                var now = new Date();
                var diff = targetDate - now;

                if (diff <= 0) {
                    document.getElementById('countdown-days').textContent = '00';
                    document.getElementById('countdown-hours').textContent = '00';
                    document.getElementById('countdown-minutes').textContent = '00';
                    document.getElementById('countdown-seconds').textContent = '00';
                    return;
                }

                var days = Math.floor(diff / (1000 * 60 * 60 * 24));
                var hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((diff % (1000 * 60)) / 1000);

                document.getElementById('countdown-days').textContent = String(days).padStart(2, '0');
                document.getElementById('countdown-hours').textContent = String(hours).padStart(2, '0');
                document.getElementById('countdown-minutes').textContent = String(minutes).padStart(2, '0');
                document.getElementById('countdown-seconds').textContent = String(seconds).padStart(2, '0');
            }

            updateCountdown();
            setInterval(updateCountdown, 1000);
        });
    </script>
    @endif
</body>
</html>
