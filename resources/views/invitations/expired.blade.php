<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <x-meta
        title="Undangan Telah Kedaluwarsa - {{ config('app.name') }}"
        description="Maaf, undangan ini telah kedaluwarsa. Silakan hubungi penyelenggara acara untuk informasi lebih lanjut."
        robots="noindex, nofollow"
    />

    @stack('meta')

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Playfair+Display:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <!-- Tailwind CSS -->
    @vite(['resources/css/app.css'])
</head>
<body
    class="bg-gradient-to-br from-secondary-900 via-secondary-800 to-secondary-900 min-h-screen flex items-center justify-center px-4 font-sans text-white">
    <div class="max-w-md w-full text-center">
        <!-- Icon -->
        <div
            class="mb-6 inline-flex items-center justify-center w-20 h-20 rounded-full bg-primary-500/10 text-primary-500 border border-primary-500/20 shadow-lg shadow-primary-500/5 animate-pulse">
            <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>

        <!-- Card -->
        <div class="bg-white/5 backdrop-blur-xl border border-white/10 rounded-3xl p-8 shadow-2xl relative overflow-hidden">
            <!-- Decorative gradient -->
            <div class="absolute -top-24 -left-24 w-48 h-48 bg-primary-500/20 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-24 -right-24 w-48 h-48 bg-primary-400/20 rounded-full blur-3xl"></div>

            <h1
                class="text-2xl font-extrabold tracking-tight bg-gradient-to-r from-primary-200 via-white to-primary-200 bg-clip-text text-transparent mb-3 font-heading">
                Masa Aktif Undangan Habis
            </h1>

            <p class="text-slate-300 text-sm leading-relaxed mb-6">
                Undangan pernikahan <span class="font-semibold text-white">"{{ $invitation->title }}"</span> ini telah
                melewati batas waktu masa aktif demo / gratis.
            </p>

            <div class="bg-white/5 border border-white/5 rounded-2xl p-4 mb-8 text-xs text-slate-400 text-left">
                <p class="mb-2">⚠️ <strong class="text-slate-200">Bagi Pemilik Undangan:</strong></p>
                <p>Data undangan Anda tetap aman disimpan sementara dalam masa tenggang. Segera lakukan aktivasi paket
                    untuk mengaktifkan kembali undangan ini.</p>
            </div>

            <!-- Action buttons -->
            <div class="space-y-3">
                @if(auth()->check() && auth()->id() === $invitation->user_id)
                    <a href="{{ route('dashboard.checkout') }}"
                        class="block w-full py-3 px-4 bg-gradient-to-r from-primary-500 to-primary-600 hover:from-primary-600 hover:to-primary-700 text-white rounded-xl font-bold transition-all duration-300 transform hover:scale-[1.02] shadow-lg shadow-primary-500/25">
                        Aktivasi Paket Sekarang
                    </a>
                    <a href="{{ route('dashboard') }}"
                        class="block w-full py-3 px-4 bg-white/5 hover:bg-white/10 border border-white/10 text-white rounded-xl font-semibold transition-all duration-300">
                        Kembali ke Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}"
                        class="block w-full py-3 px-4 bg-gradient-to-r from-primary-500 to-primary-600 hover:from-primary-600 hover:to-primary-700 text-white rounded-xl font-bold transition-all duration-300 transform hover:scale-[1.02] shadow-lg shadow-primary-500/25">
                        Login Pemilik Undangan
                    </a>
                    <a href="{{ route('home') }}"
                        class="block w-full py-3 px-4 bg-white/5 hover:bg-white/10 border border-white/10 text-slate-300 hover:text-white rounded-xl font-semibold transition-all duration-300">
                        Kembali ke Beranda
                    </a>
                @endif
            </div>
        </div>

        <p class="text-xs text-slate-500 mt-8">
            &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        </p>
    </div>
</body>

</html>