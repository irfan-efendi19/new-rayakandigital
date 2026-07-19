<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Konfirmasi Kehadiran - {{ $invitation->couple_name }}</title>

    <x-meta title="Konfirmasi Kehadiran {{ $invitation->couple_name }}"
        description="Konfirmasi kehadiran dan kirim ucapan untuk pernikahan {{ $invitation->couple_name }}." />

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link
        href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800|playfair-display:400,500,600,700&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />

    @vite(['resources/css/app.css'])

    <script>
        if (localStorage.getItem('dark-mode') === 'true' || (!('dark-mode' in localStorage) && window.matchMedia(
            '(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    <style>
        [x-cloak] {
            display: none !important;
        }

        body {
            background-image:
                radial-gradient(ellipse at 20% 10%, rgba(255, 122, 0, 0.12) 0%, transparent 50%),
                radial-gradient(ellipse at 80% 90%, rgba(255, 122, 0, 0.10) 0%, transparent 50%),
                radial-gradient(ellipse at 50% 50%, rgba(255, 122, 0, 0.04) 0%, transparent 70%);
            background-attachment: fixed;
        }

        .dark body {
            background-image:
                radial-gradient(ellipse at 20% 10%, rgba(255, 122, 0, 0.18) 0%, transparent 50%),
                radial-gradient(ellipse at 80% 90%, rgba(255, 122, 0, 0.14) 0%, transparent 50%),
                radial-gradient(ellipse at 50% 50%, rgba(255, 122, 0, 0.06) 0%, transparent 70%);
            background-attachment: fixed;
        }

        @keyframes float-in {
            from {
                opacity: 0;
                transform: translateY(20px) scale(0.96);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        @keyframes float-up {
            0% {
                opacity: 0;
                transform: translateY(24px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes success-pop {
            0% {
                transform: scale(0.3);
                opacity: 0;
            }

            50% {
                transform: scale(1.08);
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        @keyframes confetti-fall {
            0% {
                transform: translateY(-100%) rotate(0deg);
                opacity: 1;
            }

            100% {
                transform: translateY(300%) rotate(720deg);
                opacity: 0;
            }
        }

        @keyframes ring-rotate {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .animate-float-in {
            animation: float-in 0.5s cubic-bezier(0.22, 0.61, 0.36, 1) both;
        }

        .animate-float-up {
            animation: float-up 0.5s ease-out both;
        }

        .animate-success-pop {
            animation: success-pop 0.5s cubic-bezier(0.22, 0.61, 0.36, 1) both;
        }

        .card-ring {
            position: absolute;
            inset: -2px;
            border-radius: 26px;
            background: conic-gradient(from 0deg,
                    transparent 0%,
                    rgba(255, 122, 0, 0.2) 25%,
                    transparent 50%,
                    rgba(255, 122, 0, 0.2) 75%,
                    transparent 100%);
            animation: ring-rotate 8s linear infinite;
            pointer-events: none;
            opacity: 0;
            transition: opacity 0.5s;
        }

        .card-wrapper:hover .card-ring {
            opacity: 1;
        }

        .input-glow:focus {
            box-shadow: 0 0 0 3px rgba(255, 122, 0, 0.15), 0 1px 3px rgba(0, 0, 0, 0.06);
        }

        .dark .input-glow:focus {
            box-shadow: 0 0 0 3px rgba(255, 122, 0, 0.25), 0 1px 3px rgba(0, 0, 0, 0.2);
        }

        .radio-card {
            transition: all 0.25s cubic-bezier(0.22, 0.61, 0.36, 1);
        }

        .radio-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.06);
        }

        .dark .radio-card:hover {
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
        }

        .radio-card:has(input:checked) {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
        }

        .dark .radio-card:has(input:checked) {
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.35);
        }

        .confetti-piece {
            position: absolute;
            width: 8px;
            height: 8px;
            border-radius: 2px;
            animation: confetti-fall 1.5s ease-in forwards;
            pointer-events: none;
        }

        .char-counter {
            transition: color 0.3s;
        }

        .char-counter.near-limit {
            color: #ef4444;
        }

        #theme-toggle {
            transition: all 0.3s cubic-bezier(0.22, 0.61, 0.36, 1);
        }

        #theme-toggle:hover {
            transform: scale(1.1);
            box-shadow: 0 4px 15px rgba(255, 122, 0, 0.25);
        }

        #theme-toggle:active {
            transform: scale(0.92);
        }

        textarea::-webkit-scrollbar {
            width: 4px;
        }

        textarea::-webkit-scrollbar-track {
            background: transparent;
            border-radius: 8px;
        }

        textarea::-webkit-scrollbar-thumb {
            background: rgba(255, 122, 0, 0.3);
            border-radius: 8px;
        }

        textarea::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 122, 0, 0.5);
        }
    </style>
</head>

<body
    class="font-sans antialiased bg-tertiary dark:bg-secondary-900 text-secondary-800 dark:text-neutral-200 min-h-screen flex items-center justify-center p-4 sm:p-6">

    <button type="button" id="theme-toggle"
        class="fixed top-4 right-4 z-50 w-11 h-11 rounded-full bg-white/80 dark:bg-secondary-800/80 backdrop-blur-md shadow-lg border border-neutral-200/60 dark:border-secondary-700/60 flex items-center justify-center text-neutral-600 dark:text-neutral-300 hover:text-primary-500 dark:hover:text-primary-400 transition-all"
        aria-label="Ganti tema">
        <i class="fa-solid fa-sun dark:hidden text-base"></i>
        <i class="fa-solid fa-moon hidden dark:inline text-base"></i>
    </button>

    <div class="w-full max-w-md card-wrapper relative">
        <div class="card-ring hidden sm:block"></div>

        <div
            class="relative bg-white dark:bg-secondary-800 rounded-[28px] shadow-2xl shadow-neutral-200/50 dark:shadow-black/25 border border-neutral-100 dark:border-secondary-700 overflow-hidden animate-float-in">

            <div
                class="relative overflow-hidden bg-gradient-to-br from-primary-500 via-primary-600 to-primary-700 px-6 py-10 text-center">
                <div class="absolute inset-0 pointer-events-none opacity-25"
                    style="background-image: radial-gradient(circle, rgba(255,255,255,0.6) 1.5px, transparent 1.5px); background-size: 20px 20px;">
                </div>
                <div class="absolute -top-6 -right-6 w-24 h-24 bg-white/10 rounded-full blur-2xl pointer-events-none">
                </div>
                <div class="absolute -bottom-4 -left-4 w-20 h-20 bg-white/8 rounded-full blur-xl pointer-events-none">
                </div>
                <div
                    class="absolute top-1/2 left-1/4 w-3 h-3 bg-white/30 rounded-full blur-sm pointer-events-none animate-pulse">
                </div>
                <div class="absolute top-1/3 right-1/4 w-2 h-2 bg-white/25 rounded-full blur-sm pointer-events-none animate-pulse"
                    style="animation-delay: 0.8s;"></div>

                <div class="relative">
                    <div class="relative inline-block mb-4">
                        <div class="absolute inset-0 bg-white/15 rounded-2xl blur-md animate-pulse"></div>
                        <div
                            class="relative w-[68px] h-[68px] mx-auto bg-white/20 backdrop-blur-md rounded-[18px] flex items-center justify-center ring-1 ring-white/40 shadow-lg shadow-black/10">
                            <i class="fa-solid fa-envelope-open-text text-[28px] text-white drop-shadow-sm"></i>
                        </div>
                    </div>

                    <p class="text-primary-100/90 text-[10px] font-semibold uppercase tracking-[0.25em] mb-2">Konfirmasi
                        Kehadiran</p>
                    <h1 class="font-heading text-2xl font-bold text-white tracking-tight">{{ $invitation->couple_name }}
                    </h1>
                    @if ($invitation->event_date)
                        <div
                            class="inline-flex items-center gap-2 mt-2.5 px-4 py-1.5 bg-white/10 backdrop-blur-sm rounded-full">
                            <i class="fa-regular fa-calendar text-[11px] text-white/80"></i>
                            <span
                                class="text-primary-50/95 text-xs font-medium">{{ $invitation->event_date->translatedFormat('l, d F Y') }}</span>
                        </div>
                    @endif
                </div>
            </div>

            <div class="p-6 sm:p-7">
                <div id="rsvp-form-container">
                    <div class="text-center mb-7">
                        <div class="inline-flex items-center justify-center gap-2 mb-3">
                            <span class="w-8 h-[1px] bg-neutral-200 dark:bg-secondary-600"></span>
                            <span class="w-1.5 h-1.5 rounded-full bg-primary-400"></span>
                            <span class="w-8 h-[1px] bg-neutral-200 dark:bg-secondary-600"></span>
                        </div>
                        <p class="text-neutral-500 dark:text-neutral-400 text-sm leading-relaxed">
                            Silakan isi data diri Anda untuk konfirmasi kehadiran pada acara pernikahan
                            <strong
                                class="font-semibold text-secondary-800 dark:text-neutral-100">{{ $invitation->couple_name }}</strong>.
                        </p>
                    </div>

                    <form id="rsvp-form" class="space-y-5">
                        @csrf
                        <input type="hidden" name="invitation_id" value="{{ $invitation->id }}">

                        <div class="animate-float-up" style="animation-delay: 0.05s;">
                            <label for="guest_name"
                                class="flex items-center gap-2 text-sm font-semibold text-secondary-700 dark:text-neutral-300 mb-2">
                                <span
                                    class="w-7 h-7 rounded-lg bg-primary-50 dark:bg-primary-900/30 flex items-center justify-center">
                                    <i class="fa-regular fa-user text-primary-500 text-xs"></i>
                                </span>
                                Nama Lengkap <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="text" name="guest_name" id="guest_name" required
                                    placeholder="Masukkan nama Anda"
                                    class="input-glow block w-full rounded-2xl border-neutral-200 dark:border-secondary-600 bg-neutral-50 dark:bg-secondary-700/60 px-4 py-3 shadow-sm focus:border-primary-500 focus:ring-primary-500 focus:bg-white dark:focus:bg-secondary-700 text-sm text-secondary-800 dark:text-neutral-200 transition-all placeholder:text-neutral-400 dark:placeholder:text-neutral-500">
                                <div
                                    class="absolute right-4 top-1/2 -translate-y-1/2 text-neutral-300 dark:text-neutral-600 pointer-events-none">
                                    <i class="fa-solid fa-signature text-xs"></i>
                                </div>
                            </div>
                            <p class="text-xs text-neutral-400 dark:text-neutral-500 mt-1.5 ml-9">Tuliskan nama lengkap
                                Anda</p>
                        </div>

                        <div class="animate-float-up" style="animation-delay: 0.1s;">
                            <label
                                class="flex items-center gap-2 text-sm font-semibold text-secondary-700 dark:text-neutral-300 mb-3">
                                <span
                                    class="w-7 h-7 rounded-lg bg-primary-50 dark:bg-primary-900/30 flex items-center justify-center">
                                    <i class="fa-regular fa-circle-check text-primary-500 text-xs"></i>
                                </span>
                                Kehadiran <span class="text-red-500">*</span>
                            </label>
                            <div class="grid grid-cols-2 gap-3 ml-9">
                                <label
                                    class="radio-card group relative flex flex-col items-center justify-center gap-2 p-5 rounded-2xl border-2 border-neutral-200 dark:border-secondary-600 bg-neutral-50 dark:bg-secondary-700/40 cursor-pointer has-[:checked]:border-emerald-500 has-[:checked]:bg-emerald-50/80 dark:has-[:checked]:bg-emerald-900/25 has-[:checked]:shadow-md transition-all">
                                    <input type="radio" name="attendance" value="attending" required
                                        class="sr-only peer">
                                    <span
                                        class="w-10 h-10 rounded-xl bg-emerald-100 dark:bg-emerald-900/40 flex items-center justify-center group-has-[:checked]:scale-110 group-has-[:checked]:shadow-sm transition-all duration-300">
                                        <i class="fa-solid fa-check text-emerald-600 dark:text-emerald-400"></i>
                                    </span>
                                    <span
                                        class="block text-sm font-semibold text-secondary-700 dark:text-neutral-300 peer-checked:text-emerald-700 dark:peer-checked:text-emerald-400 transition-colors">Hadir</span>
                                    <span
                                        class="absolute top-2 right-2 w-5 h-5 rounded-full border-2 border-emerald-500 bg-emerald-500 hidden peer-checked:flex items-center justify-center">
                                        <i class="fa-solid fa-check text-white text-[8px]"></i>
                                    </span>
                                </label>
                                <label
                                    class="radio-card group relative flex flex-col items-center justify-center gap-2 p-5 rounded-2xl border-2 border-neutral-200 dark:border-secondary-600 bg-neutral-50 dark:bg-secondary-700/40 cursor-pointer has-[:checked]:border-red-400 has-[:checked]:bg-red-50/80 dark:has-[:checked]:bg-red-900/25 has-[:checked]:shadow-md transition-all">
                                    <input type="radio" name="attendance" value="not_attending" required
                                        class="sr-only peer">
                                    <span
                                        class="w-10 h-10 rounded-xl bg-red-100 dark:bg-red-900/40 flex items-center justify-center group-has-[:checked]:scale-110 group-has-[:checked]:shadow-sm transition-all duration-300">
                                        <i class="fa-solid fa-xmark text-red-500 dark:text-red-400"></i>
                                    </span>
                                    <span
                                        class="block text-sm font-semibold text-secondary-700 dark:text-neutral-300 peer-checked:text-red-600 dark:peer-checked:text-red-400 transition-colors">Tidak
                                        Hadir</span>
                                    <span
                                        class="absolute top-2 right-2 w-5 h-5 rounded-full border-2 border-red-400 bg-red-400 hidden peer-checked:flex items-center justify-center">
                                        <i class="fa-solid fa-check text-white text-[8px]"></i>
                                    </span>
                                </label>
                            </div>
                        </div>

                        <div id="pax-field" class="animate-float-up"
                            style="animation-delay: 0.15s; transition: max-height 0.3s ease, opacity 0.3s ease; overflow: hidden;">
                            <label for="pax"
                                class="flex items-center gap-2 text-sm font-semibold text-secondary-700 dark:text-neutral-300 mb-2">
                                <span
                                    class="w-7 h-7 rounded-lg bg-primary-50 dark:bg-primary-900/30 flex items-center justify-center">
                                    <i class="fa-solid fa-users text-primary-500 text-xs"></i>
                                </span>
                                Jumlah Rombongan <span class="text-red-500">*</span>
                            </label>
                            <div class="flex items-center gap-3 ml-9">
                                <button type="button" id="pax-minus"
                                    class="w-11 h-11 rounded-2xl border-2 border-neutral-200 dark:border-secondary-600 bg-white dark:bg-secondary-700/80 flex items-center justify-center text-secondary-600 dark:text-neutral-300 hover:bg-primary-50 hover:border-primary-400 hover:text-primary-600 dark:hover:bg-primary-900/40 dark:hover:text-primary-400 dark:hover:border-primary-600 transition-all duration-200 disabled:opacity-30 disabled:cursor-not-allowed disabled:hover:bg-white dark:disabled:hover:bg-secondary-700/80 disabled:hover:border-neutral-200 dark:disabled:hover:border-secondary-600 disabled:hover:text-secondary-600 dark:disabled:hover:text-neutral-300 shadow-sm">
                                    <i class="fa-solid fa-minus text-xs"></i>
                                </button>
                                <div class="relative">
                                    <input type="number" name="pax" id="pax" value="1" min="1" max="50" readonly
                                        class="w-[60px] text-center text-xl font-bold rounded-2xl border-2 border-neutral-200 dark:border-secondary-600 bg-neutral-50 dark:bg-secondary-700/60 shadow-sm text-secondary-800 dark:text-neutral-100 py-2.5 transition-all"
                                        style="transition: transform 0.15s cubic-bezier(0.22, 0.61, 0.36, 1);">
                                    <div class="absolute inset-x-0 bottom-0 h-1 bg-primary-500 rounded-full scale-x-0 transition-transform duration-200"
                                        id="pax-indicator"></div>
                                </div>
                                <button type="button" id="pax-plus"
                                    class="w-11 h-11 rounded-2xl border-2 border-neutral-200 dark:border-secondary-600 bg-white dark:bg-secondary-700/80 flex items-center justify-center text-secondary-600 dark:text-neutral-300 hover:bg-primary-50 hover:border-primary-400 hover:text-primary-600 dark:hover:bg-primary-900/40 dark:hover:text-primary-400 dark:hover:border-primary-600 transition-all duration-200 disabled:opacity-30 disabled:cursor-not-allowed disabled:hover:bg-white dark:disabled:hover:bg-secondary-700/80 disabled:hover:border-neutral-200 dark:disabled:hover:border-secondary-600 disabled:hover:text-secondary-600 dark:disabled:hover:text-neutral-300 shadow-sm">
                                    <i class="fa-solid fa-plus text-xs"></i>
                                </button>
                                <span class="text-sm font-medium text-neutral-500 dark:text-neutral-400">orang</span>
                            </div>
                            <p class="text-xs text-neutral-400 dark:text-neutral-500 mt-1.5 ml-9">Termasuk diri Anda
                                sendiri</p>
                        </div>

                        <div class="animate-float-up" style="animation-delay: 0.2s;">
                            <label for="message"
                                class="flex items-center gap-2 text-sm font-semibold text-secondary-700 dark:text-neutral-300 mb-2">
                                <span
                                    class="w-7 h-7 rounded-lg bg-primary-50 dark:bg-primary-900/30 flex items-center justify-center">
                                    <i class="fa-regular fa-heart text-primary-500 text-xs"></i>
                                </span>
                                Pesan untuk Pengantin
                            </label>
                            <div class="relative ml-9">
                                <textarea name="message" id="message" rows="3" maxlength="500"
                                    placeholder="Tuliskan ucapan atau doa untuk pengantin..."
                                    class="input-glow block w-full rounded-2xl border-neutral-200 dark:border-secondary-600 bg-neutral-50 dark:bg-secondary-700/60 px-4 py-3 shadow-sm focus:border-primary-500 focus:ring-primary-500 focus:bg-white dark:focus:bg-secondary-700 text-sm text-secondary-800 dark:text-neutral-200 resize-none transition-all placeholder:text-neutral-400 dark:placeholder:text-neutral-500"></textarea>
                                <div
                                    class="flex items-center justify-end gap-1 mt-1.5 text-xs text-neutral-400 dark:text-neutral-500">
                                    <span id="char-count" class="char-counter">0</span>
                                    <span>/ 500</span>
                                </div>
                            </div>
                            <p class="text-xs text-neutral-400 dark:text-neutral-500 mt-0.5 ml-9">Doa dan ucapan untuk
                                kedua mempelai (opsional)</p>
                        </div>

                        <div class="animate-float-up pt-2" style="animation-delay: 0.25s;">
                            <button type="submit" id="submit-btn"
                                class="group relative w-full py-4 px-6 bg-gradient-to-r from-primary-500 via-primary-600 to-primary-700 text-white rounded-2xl font-semibold text-sm shadow-lg shadow-primary-500/25 hover:shadow-xl hover:shadow-primary-500/35 focus:ring-4 focus:ring-primary-500/30 active:scale-[0.98] transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:shadow-lg disabled:hover:shadow-primary-500/25 flex items-center justify-center gap-2 overflow-hidden">
                                <div
                                    class="absolute inset-0 bg-gradient-to-r from-transparent via-white/15 to-transparent -translate-x-full group-hover:translate-x-full transition-transform duration-700 pointer-events-none">
                                </div>
                                <span id="btn-text" class="relative inline-flex items-center gap-2.5">
                                    <i
                                        class="fa-regular fa-paper-plane group-hover:translate-x-1 group-hover:-translate-y-0.5 transition-all duration-300"></i>
                                    Kirim Konfirmasi
                                </span>
                                <span id="btn-loading" class="hidden relative inline-flex items-center gap-2.5">
                                    <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                            stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                    </svg>
                                    Mengirim...
                                </span>
                            </button>
                        </div>
                    </form>
                </div>

                <div id="rsvp-success" class="hidden text-center py-8 animate-float-in">
                    <div class="relative w-24 h-24 mx-auto mb-6" id="success-icon-container">
                        <div class="confetti-piece bg-emerald-400" style="top:0;left:20%;animation-delay:0.1s;"></div>
                        <div class="confetti-piece bg-primary-400" style="top:5%;right:15%;animation-delay:0.2s;"></div>
                        <div class="confetti-piece bg-amber-400" style="top:10%;left:70%;animation-delay:0.3s;"></div>
                        <div class="confetti-piece bg-emerald-500" style="top:0;right:25%;animation-delay:0.15s;"></div>
                        <div class="confetti-piece bg-primary-500" style="top:8%;left:10%;animation-delay:0.35s;"></div>
                        <div class="confetti-piece bg-rose-400" style="top:3%;left:55%;animation-delay:0.25s;"></div>

                        <div
                            class="absolute inset-0 bg-emerald-100 dark:bg-emerald-900/30 rounded-full animate-ping opacity-50">
                        </div>
                        <div
                            class="relative w-24 h-24 bg-emerald-100 dark:bg-emerald-900/30 rounded-full flex items-center justify-center animate-success-pop shadow-lg shadow-emerald-200/50 dark:shadow-emerald-900/30">
                            <i class="fa-solid fa-check text-4xl text-emerald-600 dark:text-emerald-400"></i>
                        </div>
                    </div>
                    <h2 class="font-heading text-2xl font-bold text-secondary-800 dark:text-neutral-100 mb-2">Terima
                        Kasih!</h2>
                    <p class="text-neutral-500 dark:text-neutral-400 text-sm mb-7 leading-relaxed">
                        Konfirmasi kehadiran dan pesan Anda telah kami terima.<br>
                        <span class="text-primary-500 dark:text-primary-400 font-medium">Sampai jumpa di hari
                            bahagia.</span> 🤍
                    </p>
                    <button type="button" onclick="window.location.reload()"
                        class="inline-flex items-center gap-2 px-6 py-3 bg-primary-50 dark:bg-primary-900/40 text-primary-700 dark:text-primary-300 rounded-2xl text-sm font-semibold hover:bg-primary-100 dark:hover:bg-primary-900/60 transition-all hover:shadow-md hover:-translate-y-0.5 active:scale-95">
                        <i class="fa-solid fa-rotate-right text-xs"></i>
                        Konfirmasi Lagi
                    </button>
                </div>

                <div id="rsvp-error" class="hidden text-center py-4 animate-float-in">
                    <div
                        class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-2xl p-5 mb-4 flex items-start gap-3 text-left shadow-sm">
                        <div
                            class="w-9 h-9 rounded-xl bg-red-100 dark:bg-red-900/40 flex items-center justify-center flex-shrink-0">
                            <i class="fa-solid fa-circle-exclamation text-red-500 dark:text-red-400"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-red-800 dark:text-red-300 mb-0.5">Gagal Mengirim</p>
                            <p id="error-message" class="text-sm text-red-600 dark:text-red-400"></p>
                        </div>
                    </div>
                    <button type="button" onclick="location.reload()"
                        class="inline-flex items-center gap-2 px-5 py-2.5 text-sm text-primary-600 dark:text-primary-400 hover:text-primary-700 dark:hover:text-primary-300 font-semibold hover:bg-primary-50 dark:hover:bg-primary-900/40 rounded-xl transition-all">
                        <i class="fa-solid fa-arrow-rotate-right text-xs"></i>
                        Coba Lagi
                    </button>
                </div>
            </div>

            <div
                class="px-6 py-4 bg-neutral-50/80 dark:bg-secondary-900/60 backdrop-blur-sm border-t border-neutral-100 dark:border-secondary-700 text-center">
                <p class="text-xs text-neutral-400 dark:text-neutral-500 flex items-center justify-center gap-1.5">
                    <i class="fa-regular fa-copyright text-[10px]"></i>
                    {{ date('Y') }} {{ config('app.name') }} &mdash; Rayakan Cinta Dengan Sentuhan Digital.
                </p>
            </div>
        </div>
    </div>

    <script>
        const themeToggle = document.getElementById('theme-toggle');
        if (themeToggle) {
            themeToggle.addEventListener('click', function () {
                const isDark = document.documentElement.classList.toggle('dark');
                localStorage.setItem('dark-mode', isDark ? 'true' : 'false');
            });
        }

        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('rsvp-form');
            const formContainer = document.getElementById('rsvp-form-container');
            const successContainer = document.getElementById('rsvp-success');
            const errorContainer = document.getElementById('rsvp-error');
            const errorMessage = document.getElementById('error-message');
            const submitBtn = document.getElementById('submit-btn');
            const btnText = document.getElementById('btn-text');
            const btnLoading = document.getElementById('btn-loading');
            const paxField = document.getElementById('pax-field');
            const paxInput = document.getElementById('pax');
            const paxMinus = document.getElementById('pax-minus');
            const paxPlus = document.getElementById('pax-plus');
            const attendanceRadios = document.querySelectorAll('input[name="attendance"]');
            const messageTextarea = document.getElementById('message');
            const charCount = document.getElementById('char-count');
            const paxIndicator = document.getElementById('pax-indicator');

            function togglePaxField() {
                const selected = document.querySelector('input[name="attendance"]:checked');
                if (selected && selected.value === 'attending') {
                    paxField.style.maxHeight = paxField.scrollHeight + 'px';
                    paxField.style.opacity = '1';
                    paxField.classList.remove('hidden');
                    setTimeout(() => {
                        paxField.style.maxHeight = '';
                        paxField.style.opacity = '';
                    }, 300);
                } else {
                    paxField.style.maxHeight = paxField.scrollHeight + 'px';
                    requestAnimationFrame(() => {
                        paxField.style.maxHeight = '0px';
                        paxField.style.opacity = '0';
                    });
                    setTimeout(() => {
                        paxField.classList.add('hidden');
                        paxField.style.maxHeight = '';
                        paxField.style.opacity = '';
                    }, 300);
                }
            }

            attendanceRadios.forEach(radio => {
                radio.addEventListener('change', togglePaxField);
            });

            togglePaxField();

            function updatePaxButtons() {
                const val = parseInt(paxInput.value) || 1;
                paxMinus.disabled = val <= 1;
                paxPlus.disabled = val >= 50;

                if (paxIndicator) {
                    const percentage = ((val - 1) / 49) * 100;
                    paxIndicator.style.transform = `scaleX(${percentage / 100})`;
                }
            }

            paxMinus.addEventListener('click', function () {
                let val = parseInt(paxInput.value) || 1;
                if (val > 1) {
                    paxInput.value = val - 1;
                    paxInput.style.transform = 'scale(0.9)';
                    setTimeout(() => {
                        paxInput.style.transform = 'scale(1)';
                    }, 150);
                }
                updatePaxButtons();
            });

            paxPlus.addEventListener('click', function () {
                let val = parseInt(paxInput.value) || 1;
                if (val < 50) {
                    paxInput.value = val + 1;
                    paxInput.style.transform = 'scale(1.1)';
                    setTimeout(() => {
                        paxInput.style.transform = 'scale(1)';
                    }, 150);
                }
                updatePaxButtons();
            });

            updatePaxButtons();

            if (messageTextarea && charCount) {
                messageTextarea.addEventListener('input', function () {
                    const len = this.value.length;
                    charCount.textContent = len;
                    if (len >= 450) {
                        charCount.classList.add('near-limit');
                    } else {
                        charCount.classList.remove('near-limit');
                    }
                });
                charCount.textContent = messageTextarea.value.length;
            }

            form.addEventListener('submit', function (e) {
                e.preventDefault();

                const selectedAttendance = document.querySelector('input[name="attendance"]:checked');
                if (!selectedAttendance) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Pilih Kehadiran',
                        text: 'Silakan pilih status kehadiran Anda.',
                        confirmButtonColor: '#FF7A00',
                        confirmButtonText: 'OK',
                        customClass: {
                            popup: 'rounded-2xl',
                            confirmButton: 'rounded-xl px-6 py-2.5',
                        }
                    });
                    return;
                }

                submitBtn.disabled = true;
                btnText.classList.add('hidden');
                btnLoading.classList.remove('hidden');
                errorContainer.classList.add('hidden');

                const formData = new FormData();
                formData.append('guest_name', document.getElementById('guest_name').value);
                formData.append('attendance', selectedAttendance.value);
                formData.append('pax', selectedAttendance.value === 'attending' ? paxInput.value : 1);
                formData.append('message', document.getElementById('message').value);
                formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);

                fetch('{{ route('rsvp.store', $invitation) }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'Accept': 'application/json',
                    },
                })
                    .then(function (response) {
                        return response.json().then(function (data) {
                            return { status: response.status, data: data };
                        });
                    })
                    .then(function (result) {
                        if (result.status === 422) {
                            throw new Error(result.data.message || 'Terjadi kesalahan validasi.');
                        }
                        if (result.data.success) {
                            formContainer.classList.add('hidden');
                            errorContainer.classList.add('hidden');
                            successContainer.classList.remove('hidden');
                            successContainer.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        } else {
                            throw new Error(result.data.message || 'Terjadi kesalahan.');
                        }
                    })
                    .catch(function (error) {
                        submitBtn.disabled = false;
                        btnText.classList.remove('hidden');
                        btnLoading.classList.add('hidden');
                        errorMessage.textContent = error.message || 'Terjadi kesalahan. Silakan coba lagi.';
                        errorContainer.classList.remove('hidden');
                        errorContainer.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    });
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>