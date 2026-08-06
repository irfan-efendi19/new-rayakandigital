<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $invitation->couple_name }} — QR Interaktif</title>

    <x-meta title="{{ $invitation->couple_name }} — Undangan Digital"
        description="Akses undangan, kirim kado digital, dan sampaikan ucapan untuk {{ $invitation->couple_name }}." />

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
                transform: translateY(16px);
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
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        @keyframes shimmer {
            0% { background-position: -200% center; }
            100% { background-position: 200% center; }
        }

        .animate-float-in {
            animation: float-in 0.5s cubic-bezier(0.22, 0.61, 0.36, 1) both;
        }

        .animate-float-up {
            animation: float-up 0.45s ease-out both;
        }

        .animate-success-pop {
            animation: success-pop 0.5s cubic-bezier(0.22, 0.61, 0.36, 1) both;
        }

        .card-ring {
            position: absolute;
            inset: -2px;
            border-radius: 30px;
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

        .hub-action-btn {
            transition: all 0.25s cubic-bezier(0.22, 0.61, 0.36, 1);
        }

        .hub-action-btn:hover {
            transform: translateY(-2px);
        }

        .hub-action-btn:active {
            transform: translateY(0) scale(0.98);
        }

        .accordion-content {
            overflow: hidden;
            transition: max-height 0.4s cubic-bezier(0.22, 0.61, 0.36, 1), opacity 0.3s ease;
        }

        .bank-card {
            transition: all 0.2s ease;
        }

        .bank-card:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.06);
        }

        .copy-btn {
            transition: all 0.2s ease;
        }

        .copy-btn.copied {
            background-color: #10b981;
            color: white;
        }

        .input-glow:focus {
            box-shadow: 0 0 0 3px rgba(255, 122, 0, 0.15), 0 1px 3px rgba(0, 0, 0, 0.06);
        }

        .dark .input-glow:focus {
            box-shadow: 0 0 0 3px rgba(255, 122, 0, 0.25), 0 1px 3px rgba(0, 0, 0, 0.2);
        }

        .confetti-piece {
            position: absolute;
            width: 8px;
            height: 8px;
            border-radius: 2px;
            animation: confetti-fall 1.5s ease-in forwards;
            pointer-events: none;
        }

        #theme-toggle {
            transition: all 0.3s cubic-bezier(0.22, 0.61, 0.36, 1);
        }

        #theme-toggle:hover {
            transform: scale(1.1);
            box-shadow: 0 4px 15px rgba(255, 122, 0, 0.25);
        }

        textarea::-webkit-scrollbar { width: 4px; }
        textarea::-webkit-scrollbar-track { background: transparent; border-radius: 8px; }
        textarea::-webkit-scrollbar-thumb { background: rgba(255, 122, 0, 0.3); border-radius: 8px; }
        textarea::-webkit-scrollbar-thumb:hover { background: rgba(255, 122, 0, 0.5); }

        .tab-active {
            background: linear-gradient(135deg, #FF7A00, #FF9500);
            color: white;
            box-shadow: 0 4px 12px rgba(255, 122, 0, 0.3);
        }

        .qris-zoom {
            transition: transform 0.3s ease;
            cursor: zoom-in;
        }

        .qris-zoom.zoomed {
            transform: scale(2);
            cursor: zoom-out;
        }
    </style>
</head>

<body
    class="font-sans antialiased bg-tertiary dark:bg-secondary-900 text-secondary-800 dark:text-neutral-200 min-h-screen flex items-center justify-center p-4 sm:p-6">

    {{-- Dark mode toggle --}}
    <button type="button" id="theme-toggle"
        class="fixed top-4 right-4 z-50 w-11 h-11 rounded-full bg-white/80 dark:bg-secondary-800/80 backdrop-blur-md shadow-lg border border-neutral-200/60 dark:border-secondary-700/60 flex items-center justify-center text-neutral-600 dark:text-neutral-300 hover:text-primary-500 dark:hover:text-primary-400 transition-all"
        aria-label="Ganti tema">
        <i class="fa-solid fa-sun dark:hidden text-base"></i>
        <i class="fa-solid fa-moon hidden dark:inline text-base"></i>
    </button>

    <div class="w-full max-w-md card-wrapper relative">
        <div class="card-ring hidden sm:block"></div>

        <div
            class="relative bg-white dark:bg-secondary-800 rounded-[30px] shadow-2xl shadow-neutral-200/50 dark:shadow-black/30 border border-neutral-100 dark:border-secondary-700 overflow-hidden animate-float-in">

            {{-- ── HEADER ── --}}
            <div
                class="relative overflow-hidden bg-gradient-to-br from-primary-500 via-primary-600 to-primary-700 px-6 py-10 text-center">
                <div class="absolute inset-0 pointer-events-none opacity-20"
                    style="background-image: radial-gradient(circle, rgba(255,255,255,0.7) 1.5px, transparent 1.5px); background-size: 20px 20px;">
                </div>
                <div class="absolute -top-6 -right-6 w-32 h-32 bg-white/10 rounded-full blur-2xl pointer-events-none">
                </div>
                <div
                    class="absolute -bottom-4 -left-4 w-24 h-24 bg-white/8 rounded-full blur-xl pointer-events-none">
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
                            <i class="fa-solid fa-qrcode text-[28px] text-white drop-shadow-sm"></i>
                        </div>
                    </div>

                    <p class="text-primary-100/90 text-[10px] font-semibold uppercase tracking-[0.25em] mb-1.5">QR
                        Interaktif</p>
                    <h1 class="font-heading text-2xl font-bold text-white tracking-tight">
                        {{ $invitation->couple_name }}</h1>
                    @if ($invitation->event_date)
                        <div
                            class="inline-flex items-center gap-2 mt-2.5 px-4 py-1.5 bg-white/10 backdrop-blur-sm rounded-full">
                            <i class="fa-regular fa-calendar text-[11px] text-white/80"></i>
                            <span
                                class="text-primary-50/95 text-xs font-medium">{{ $invitation->event_date->translatedFormat('l, d F Y') }}</span>
                        </div>
                    @endif

                    {{-- Venue --}}
                    @if ($invitation->venue_name)
                        <p class="text-white/70 text-[11px] mt-2">
                            <i class="fa-solid fa-location-dot mr-1 text-white/60"></i>
                            {{ $invitation->venue_name }}
                        </p>
                    @endif
                </div>
            </div>

            {{-- ── DIVIDER ── --}}
            <div class="px-6 pt-5 pb-1">
                <div class="flex items-center gap-3">
                    <span class="flex-1 h-px bg-neutral-200 dark:bg-secondary-600"></span>
                    <span class="text-[10px] font-semibold uppercase tracking-widest text-neutral-400 dark:text-neutral-500">Pilih
                        Aksi</span>
                    <span class="flex-1 h-px bg-neutral-200 dark:bg-secondary-600"></span>
                </div>
            </div>

            {{-- ── ACTION BUTTONS ── --}}
            <div class="px-5 pt-3 pb-5 space-y-3">

                {{-- 1. BUKA UNDANGAN --}}
                <a id="btn-undangan"
                    href="{{ route('invitation.show', $invitation->slug) }}"
                    class="hub-action-btn animate-float-up group flex items-center gap-4 w-full p-4 rounded-2xl bg-gradient-to-r from-primary-50 to-orange-50 dark:from-primary-900/20 dark:to-orange-900/10 border-2 border-primary-200/70 dark:border-primary-800/40 hover:border-primary-400 dark:hover:border-primary-600 hover:shadow-lg hover:shadow-primary-100/50 dark:hover:shadow-primary-900/20"
                    style="animation-delay: 0.05s;">
                    <div
                        class="w-12 h-12 rounded-xl bg-gradient-to-br from-primary-500 to-primary-600 flex items-center justify-center shadow-md shadow-primary-500/30 flex-shrink-0 group-hover:shadow-lg group-hover:shadow-primary-500/40 transition-shadow">
                        <i class="fa-solid fa-envelope-open-text text-white text-lg"></i>
                    </div>
                    <div class="min-w-0 flex-1 text-left">
                        <p class="font-bold text-sm text-secondary-800 dark:text-neutral-100">Buka Undangan</p>
                        <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-0.5">Lihat website undangan
                            digital</p>
                    </div>
                    <i
                        class="fa-solid fa-arrow-right text-sm text-primary-400 group-hover:translate-x-1 transition-transform"></i>
                </a>

                {{-- 2. KADO DIGITAL --}}
                <div class="animate-float-up" style="animation-delay: 0.1s;">
                    @php
                        $hasGiftBanks = !empty($invitation->gift_banks);
                        $hasGiftEwallets = !empty($invitation->gift_ewallets);
                        $hasQris = !empty($invitation->gift_qris_image);
                        $hasAnyGift = $hasGiftBanks || $hasGiftEwallets || $hasQris;
                    @endphp

                    <button id="toggle-kado" type="button"
                        class="hub-action-btn group flex items-center gap-4 w-full p-4 rounded-2xl bg-gradient-to-r from-rose-50 to-pink-50 dark:from-rose-900/15 dark:to-pink-900/10 border-2 border-rose-200/70 dark:border-rose-800/40 hover:border-rose-400 dark:hover:border-rose-600 hover:shadow-lg hover:shadow-rose-100/50 dark:hover:shadow-rose-900/20 transition-all"
                        aria-expanded="false">
                        <div
                            class="w-12 h-12 rounded-xl bg-gradient-to-br from-rose-500 to-pink-500 flex items-center justify-center shadow-md shadow-rose-500/30 flex-shrink-0 group-hover:shadow-lg transition-shadow">
                            <i class="fa-solid fa-gift text-white text-lg"></i>
                        </div>
                        <div class="min-w-0 flex-1 text-left">
                            <p class="font-bold text-sm text-secondary-800 dark:text-neutral-100">Kado Digital</p>
                            <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-0.5">
                                @if ($hasAnyGift)
                                    {{ collect([$hasGiftBanks ? count($invitation->gift_banks).' rekening' : null, $hasGiftEwallets ? count($invitation->gift_ewallets).' e-wallet' : null, $hasQris ? 'QRIS' : null])->filter()->implode(', ') }}
                                @else
                                    Informasi rekening & transfer
                                @endif
                            </p>
                        </div>
                        <i id="kado-chevron"
                            class="fa-solid fa-chevron-down text-sm text-rose-400 transition-transform duration-300"></i>
                    </button>

                    {{-- Accordion Kado --}}
                    <div id="kado-panel" class="accordion-content" style="max-height: 0; opacity: 0;">
                        <div class="pt-2 space-y-2">
                            @if ($hasAnyGift)

                                {{-- Rekening Bank --}}
                                @if ($hasGiftBanks)
                                    @foreach ($invitation->gift_banks as $bank)
                                        <div
                                            class="bank-card bg-white dark:bg-secondary-700/60 rounded-2xl border border-neutral-200/80 dark:border-secondary-600/60 p-4 shadow-sm">
                                            <div class="flex items-center justify-between mb-2.5">
                                                <div class="flex items-center gap-2.5">
                                                    <div
                                                        class="w-8 h-8 rounded-lg bg-blue-50 dark:bg-blue-900/30 flex items-center justify-center">
                                                        <i
                                                            class="fa-solid fa-building-columns text-blue-500 dark:text-blue-400 text-sm"></i>
                                                    </div>
                                                    <div>
                                                        <p
                                                            class="text-xs font-bold text-secondary-800 dark:text-neutral-100">
                                                            {{ $bank['bank_name'] }}</p>
                                                        @if (!empty($bank['account_holder']))
                                                            <p
                                                                class="text-[10px] text-neutral-500 dark:text-neutral-400">
                                                                a.n {{ $bank['account_holder'] }}</p>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div
                                                class="flex items-center gap-2 bg-neutral-50 dark:bg-secondary-700 rounded-xl px-3.5 py-2.5 border border-neutral-200/70 dark:border-secondary-600/50">
                                                <span
                                                    class="font-mono text-sm font-bold text-secondary-800 dark:text-neutral-100 flex-1 tracking-wider">{{ $bank['account_number'] }}</span>
                                                <button type="button"
                                                    onclick="copyText(this, '{{ $bank['account_number'] }}')"
                                                    class="copy-btn inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-[10px] font-semibold bg-primary-50 dark:bg-primary-900/40 text-primary-600 dark:text-primary-400 hover:bg-primary-100 dark:hover:bg-primary-900/60 transition-all border border-primary-200/60 dark:border-primary-800/40">
                                                    <i class="fa-regular fa-copy text-xs"></i>
                                                    Salin
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif

                                {{-- E-Wallet --}}
                                @if ($hasGiftEwallets)
                                    @foreach ($invitation->gift_ewallets as $ewallet)
                                        <div
                                            class="bank-card bg-white dark:bg-secondary-700/60 rounded-2xl border border-neutral-200/80 dark:border-secondary-600/60 p-4 shadow-sm">
                                            <div class="flex items-center justify-between mb-2.5">
                                                <div class="flex items-center gap-2.5">
                                                    <div
                                                        class="w-8 h-8 rounded-lg bg-emerald-50 dark:bg-emerald-900/30 flex items-center justify-center">
                                                        <i
                                                            class="fa-solid fa-wallet text-emerald-500 dark:text-emerald-400 text-sm"></i>
                                                    </div>
                                                    <div>
                                                        <p
                                                            class="text-xs font-bold text-secondary-800 dark:text-neutral-100">
                                                            {{ $ewallet['wallet_name'] }}</p>
                                                        <p class="text-[10px] text-neutral-500 dark:text-neutral-400">
                                                            E-Wallet</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div
                                                class="flex items-center gap-2 bg-neutral-50 dark:bg-secondary-700 rounded-xl px-3.5 py-2.5 border border-neutral-200/70 dark:border-secondary-600/50">
                                                <span
                                                    class="font-mono text-sm font-bold text-secondary-800 dark:text-neutral-100 flex-1 tracking-wider">{{ $ewallet['wallet_number'] }}</span>
                                                <button type="button"
                                                    onclick="copyText(this, '{{ $ewallet['wallet_number'] }}')"
                                                    class="copy-btn inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-[10px] font-semibold bg-emerald-50 dark:bg-emerald-900/40 text-emerald-600 dark:text-emerald-400 hover:bg-emerald-100 dark:hover:bg-emerald-900/60 transition-all border border-emerald-200/60 dark:border-emerald-800/40">
                                                    <i class="fa-regular fa-copy text-xs"></i>
                                                    Salin
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif

                                {{-- QRIS --}}
                                @if ($hasQris)
                                    <div
                                        class="bank-card bg-white dark:bg-secondary-700/60 rounded-2xl border border-neutral-200/80 dark:border-secondary-600/60 p-4 shadow-sm text-center">
                                        <div class="flex items-center gap-2.5 mb-3">
                                            <div
                                                class="w-8 h-8 rounded-lg bg-violet-50 dark:bg-violet-900/30 flex items-center justify-center flex-shrink-0">
                                                <i
                                                    class="fa-solid fa-qrcode text-violet-500 dark:text-violet-400 text-sm"></i>
                                            </div>
                                            <div class="text-left">
                                                <p
                                                    class="text-xs font-bold text-secondary-800 dark:text-neutral-100">
                                                    QRIS</p>
                                                <p class="text-[10px] text-neutral-500 dark:text-neutral-400">Scan
                                                    untuk transfer</p>
                                            </div>
                                        </div>
                                        <div
                                            class="overflow-hidden rounded-xl border border-neutral-200 dark:border-secondary-600 bg-white p-2 inline-block">
                                            <img src="{{ Storage::url($invitation->gift_qris_image) }}"
                                                alt="QRIS {{ $invitation->couple_name }}"
                                                class="qris-zoom w-48 h-48 object-contain rounded-lg"
                                                id="qris-img"
                                                onclick="toggleQrisZoom(this)">
                                        </div>
                                        <p class="text-[10px] text-neutral-400 dark:text-neutral-500 mt-2">Ketuk
                                            gambar untuk zoom</p>
                                    </div>
                                @endif

                            @else
                                {{-- Belum dikonfigurasi --}}
                                <div
                                    class="text-center py-6 px-4 bg-neutral-50 dark:bg-secondary-700/40 rounded-2xl border border-neutral-200/60 dark:border-secondary-600/40">
                                    <div
                                        class="w-12 h-12 rounded-xl bg-neutral-100 dark:bg-secondary-600/60 flex items-center justify-center mx-auto mb-3">
                                        <i class="fa-regular fa-gift text-neutral-400 text-xl"></i>
                                    </div>
                                    <p class="text-sm font-semibold text-neutral-600 dark:text-neutral-300 mb-1">
                                        Belum Dikonfigurasi</p>
                                    <p class="text-xs text-neutral-400 dark:text-neutral-500">Informasi kado digital
                                        belum diatur oleh penyelenggara.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- 3. KIRIM UCAPAN --}}
                <div class="animate-float-up" style="animation-delay: 0.15s;">
                    <button id="toggle-ucapan" type="button"
                        class="hub-action-btn group flex items-center gap-4 w-full p-4 rounded-2xl bg-gradient-to-r from-violet-50 to-purple-50 dark:from-violet-900/15 dark:to-purple-900/10 border-2 border-violet-200/70 dark:border-violet-800/40 hover:border-violet-400 dark:hover:border-violet-600 hover:shadow-lg hover:shadow-violet-100/50 dark:hover:shadow-violet-900/20 transition-all"
                        aria-expanded="false">
                        <div
                            class="w-12 h-12 rounded-xl bg-gradient-to-br from-violet-500 to-purple-500 flex items-center justify-center shadow-md shadow-violet-500/30 flex-shrink-0 group-hover:shadow-lg transition-shadow">
                            <i class="fa-regular fa-comment-dots text-white text-lg"></i>
                        </div>
                        <div class="min-w-0 flex-1 text-left">
                            <p class="font-bold text-sm text-secondary-800 dark:text-neutral-100">Kirim Ucapan</p>
                            <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-0.5">Doa & ucapan untuk
                                kedua mempelai</p>
                        </div>
                        <i id="ucapan-chevron"
                            class="fa-solid fa-chevron-down text-sm text-violet-400 transition-transform duration-300"></i>
                    </button>

                    {{-- Accordion Ucapan --}}
                    <div id="ucapan-panel" class="accordion-content" style="max-height: 0; opacity: 0;">
                        <div class="pt-2">

                            {{-- Ucapan terbaru --}}
                            @if ($invitation->wishes->isNotEmpty())
                                <div class="mb-3 space-y-2">
                                    @foreach ($invitation->wishes as $wish)
                                        <div
                                            class="bg-violet-50/60 dark:bg-violet-900/10 rounded-xl border border-violet-100 dark:border-violet-800/30 p-3">
                                            <div class="flex items-start gap-2.5">
                                                <div
                                                    class="w-7 h-7 rounded-full bg-gradient-to-br from-violet-400 to-purple-500 flex items-center justify-center flex-shrink-0 text-white text-[10px] font-bold mt-0.5">
                                                    {{ mb_strtoupper(mb_substr($wish->guest_name ?? 'T', 0, 1)) }}
                                                </div>
                                                <div class="min-w-0 flex-1">
                                                    <p
                                                        class="text-[11px] font-bold text-secondary-700 dark:text-neutral-200">
                                                        {{ $wish->guest_name ?? 'Tamu' }}</p>
                                                    <p
                                                        class="text-xs text-neutral-600 dark:text-neutral-400 mt-0.5 leading-relaxed">
                                                        {{ Str::limit($wish->message, 120) }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            {{-- Form ucapan --}}
                            <div id="wish-form-wrap">
                                <form id="wish-form" class="space-y-3">
                                    @csrf
                                    <input type="hidden" name="invitation_id" value="{{ $invitation->id }}">
                                    <div>
                                        <input type="text" name="sender_name" id="wish-name"
                                            placeholder="Nama Anda"
                                            class="input-glow w-full rounded-xl border border-neutral-200 dark:border-secondary-600 bg-neutral-50 dark:bg-secondary-700/60 px-4 py-2.5 text-sm text-secondary-800 dark:text-neutral-200 focus:border-violet-500 focus:ring-violet-500 placeholder:text-neutral-400 dark:placeholder:text-neutral-500 transition-all">
                                    </div>
                                    <div>
                                        <textarea name="content" id="wish-content" rows="3"
                                            maxlength="500"
                                            placeholder="Tulis ucapan dan doa untuk pengantin..."
                                            class="input-glow w-full rounded-xl border border-neutral-200 dark:border-secondary-600 bg-neutral-50 dark:bg-secondary-700/60 px-4 py-2.5 text-sm text-secondary-800 dark:text-neutral-200 focus:border-violet-500 focus:ring-violet-500 resize-none placeholder:text-neutral-400 dark:placeholder:text-neutral-500 transition-all"></textarea>
                                        <div class="text-right text-[10px] text-neutral-400 mt-0.5">
                                            <span id="wish-char">0</span>/500
                                        </div>
                                    </div>
                                    <button type="submit" id="wish-submit-btn"
                                        class="w-full py-3 px-5 bg-gradient-to-r from-violet-500 to-purple-600 text-white rounded-xl text-sm font-semibold shadow-md shadow-violet-500/20 hover:shadow-lg hover:shadow-violet-500/30 hover:-translate-y-0.5 active:scale-[0.98] transition-all flex items-center justify-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed">
                                        <span id="wish-btn-text" class="inline-flex items-center gap-2">
                                            <i class="fa-regular fa-paper-plane"></i>
                                            Kirim Ucapan
                                        </span>
                                        <span id="wish-btn-loading" class="hidden inline-flex items-center gap-2">
                                            <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10"
                                                    stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor"
                                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                            </svg>
                                            Mengirim...
                                        </span>
                                    </button>
                                </form>
                            </div>

                            {{-- Wish success state --}}
                            <div id="wish-success" class="hidden text-center py-5 animate-float-in">
                                <div class="relative w-16 h-16 mx-auto mb-3">
                                    <div class="confetti-piece bg-violet-400" style="top:0;left:20%;animation-delay:0.1s;"></div>
                                    <div class="confetti-piece bg-primary-400" style="top:5%;right:15%;animation-delay:0.2s;"></div>
                                    <div class="confetti-piece bg-amber-400" style="top:10%;left:70%;animation-delay:0.3s;"></div>
                                    <div class="relative w-16 h-16 bg-violet-100 dark:bg-violet-900/30 rounded-full flex items-center justify-center animate-success-pop shadow-lg shadow-violet-200/50 dark:shadow-violet-900/30">
                                        <i class="fa-solid fa-check text-2xl text-violet-600 dark:text-violet-400"></i>
                                    </div>
                                </div>
                                <p class="text-sm font-bold text-secondary-800 dark:text-neutral-100 mb-1">Ucapan Terkirim! 🤍</p>
                                <p class="text-xs text-neutral-500 dark:text-neutral-400">Terima kasih atas doa dan ucapannya.</p>
                                <button type="button" onclick="resetWishForm()"
                                    class="mt-3 text-xs font-semibold text-violet-600 dark:text-violet-400 hover:text-violet-700 dark:hover:text-violet-300 transition-colors">
                                    Kirim ucapan lagi →
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ── FOOTER ── --}}
            <div
                class="px-6 py-3.5 bg-neutral-50/80 dark:bg-secondary-900/60 backdrop-blur-sm border-t border-neutral-100 dark:border-secondary-700 text-center">
                <p class="text-[11px] text-neutral-400 dark:text-neutral-500 flex items-center justify-center gap-1.5">
                    <i class="fa-regular fa-copyright text-[10px]"></i>
                    {{ date('Y') }} {{ config('app.name') }} &mdash; Rayakan Cinta Dengan Sentuhan Digital.
                </p>
            </div>
        </div>
    </div>

    <script>
        // Dark mode toggle
        const themeToggle = document.getElementById('theme-toggle');
        if (themeToggle) {
            themeToggle.addEventListener('click', function() {
                const isDark = document.documentElement.classList.toggle('dark');
                localStorage.setItem('dark-mode', isDark ? 'true' : 'false');
            });
        }

        // ── Accordion ──
        function openAccordion(panelId, chevronId) {
            const panel = document.getElementById(panelId);
            const chevron = document.getElementById(chevronId);
            panel.style.opacity = '1';
            panel.style.maxHeight = panel.scrollHeight + 300 + 'px';
            if (chevron) chevron.style.transform = 'rotate(180deg)';
        }

        function closeAccordion(panelId, chevronId) {
            const panel = document.getElementById(panelId);
            const chevron = document.getElementById(chevronId);
            panel.style.maxHeight = panel.scrollHeight + 'px';
            requestAnimationFrame(() => {
                panel.style.opacity = '0';
                panel.style.maxHeight = '0px';
            });
            if (chevron) chevron.style.transform = 'rotate(0deg)';
        }

        function toggleAccordion(panelId, chevronId, btnId) {
            const panel = document.getElementById(panelId);
            const btn = document.getElementById(btnId);
            const isOpen = panel.style.maxHeight && panel.style.maxHeight !== '0px';
            if (isOpen) {
                closeAccordion(panelId, chevronId);
                btn.setAttribute('aria-expanded', 'false');
            } else {
                openAccordion(panelId, chevronId);
                btn.setAttribute('aria-expanded', 'true');
            }
        }

        document.getElementById('toggle-kado').addEventListener('click', function() {
            toggleAccordion('kado-panel', 'kado-chevron', 'toggle-kado');
        });

        document.getElementById('toggle-ucapan').addEventListener('click', function() {
            toggleAccordion('ucapan-panel', 'ucapan-chevron', 'toggle-ucapan');
        });

        // ── Copy to clipboard ──
        function copyText(btn, text) {
            navigator.clipboard.writeText(text).then(function() {
                const original = btn.innerHTML;
                btn.classList.add('copied');
                btn.innerHTML = '<i class="fa-solid fa-check text-xs"></i> Tersalin!';
                setTimeout(function() {
                    btn.classList.remove('copied');
                    btn.innerHTML = original;
                }, 2000);
            }).catch(function() {
                // Fallback
                const ta = document.createElement('textarea');
                ta.value = text;
                ta.style.position = 'fixed';
                ta.style.opacity = '0';
                document.body.appendChild(ta);
                ta.focus();
                ta.select();
                document.execCommand('copy');
                document.body.removeChild(ta);
                const original = btn.innerHTML;
                btn.classList.add('copied');
                btn.innerHTML = '<i class="fa-solid fa-check text-xs"></i> Tersalin!';
                setTimeout(function() {
                    btn.classList.remove('copied');
                    btn.innerHTML = original;
                }, 2000);
            });
        }

        // ── QRIS Zoom ──
        function toggleQrisZoom(img) {
            img.classList.toggle('zoomed');
        }

        // ── Wish form ──
        const wishContent = document.getElementById('wish-content');
        const wishChar = document.getElementById('wish-char');
        if (wishContent && wishChar) {
            wishContent.addEventListener('input', function() {
                wishChar.textContent = this.value.length;
            });
        }

        function resetWishForm() {
            document.getElementById('wish-success').classList.add('hidden');
            document.getElementById('wish-form-wrap').classList.remove('hidden');
            document.getElementById('wish-form').reset();
            if (wishChar) wishChar.textContent = '0';
        }

        document.getElementById('wish-form').addEventListener('submit', function(e) {
            e.preventDefault();

            const name = document.getElementById('wish-name').value.trim();
            const content = document.getElementById('wish-content').value.trim();

            if (!name) {
                document.getElementById('wish-name').focus();
                return;
            }
            if (!content) {
                document.getElementById('wish-content').focus();
                return;
            }

            const submitBtn = document.getElementById('wish-submit-btn');
            const btnText = document.getElementById('wish-btn-text');
            const btnLoading = document.getElementById('wish-btn-loading');

            submitBtn.disabled = true;
            btnText.classList.add('hidden');
            btnLoading.classList.remove('hidden');

            const formData = new FormData(this);
            formData.set('guest_name', name);
            formData.set('message', content);
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
            if (csrfToken) {
                formData.set('_token', csrfToken);
            }

            fetch('{{ route('wish.store', $invitation) }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                })
                .then(function(res) {
                    return res.json().then(function(data) {
                        return { status: res.status, data: data };
                    });
                })
                .then(function(result) {
                    if (result.status === 422) {
                        let errorMsg = result.data.message;
                        if (result.data.errors) {
                            errorMsg = Object.values(result.data.errors).flat().join(', ');
                        }
                        throw new Error(errorMsg || 'Terjadi kesalahan validasi.');
                    }

                    if (result.data && (result.data.success || result.data.wish || result.data.message)) {
                        document.getElementById('wish-form-wrap').classList.add('hidden');
                        document.getElementById('wish-success').classList.remove('hidden');
                        const panel = document.getElementById('ucapan-panel');
                        if (panel) panel.style.maxHeight = 'none';
                    } else {
                        throw new Error(result.data.message || 'Terjadi kesalahan.');
                    }
                })
                .catch(function(err) {
                    submitBtn.disabled = false;
                    btnText.classList.remove('hidden');
                    btnLoading.classList.add('hidden');
                    alert(err.message || 'Gagal mengirim ucapan. Coba lagi.');
                });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>
