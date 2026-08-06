<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kado Digital — {{ $invitation->couple_name }}</title>

    <x-meta title="Kado Digital {{ $invitation->couple_name }}"
        description="Kirim kado digital, transfer bank, e-wallet, atau scan QRIS untuk {{ $invitation->couple_name }}." />

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
                radial-gradient(ellipse at 20% 10%, rgba(244, 63, 94, 0.12) 0%, transparent 50%),
                radial-gradient(ellipse at 80% 90%, rgba(244, 63, 94, 0.10) 0%, transparent 50%),
                radial-gradient(ellipse at 50% 50%, rgba(244, 63, 94, 0.04) 0%, transparent 70%);
            background-attachment: fixed;
        }

        @keyframes float-in {
            from { opacity: 0; transform: translateY(20px) scale(0.96); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }

        .animate-float-in { animation: float-in 0.5s cubic-bezier(0.22, 0.61, 0.36, 1) both; }

        .bank-card { transition: all 0.2s ease; }
        .bank-card:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(0, 0, 0, 0.06); }

        .copy-btn { transition: all 0.2s ease; }
        .copy-btn.copied { background-color: #10b981; color: white; }

        .qris-zoom { transition: transform 0.3s ease; cursor: zoom-in; }
        .qris-zoom.zoomed { transform: scale(2); cursor: zoom-out; }
    </style>
</head>

<body class="font-sans antialiased bg-tertiary dark:bg-secondary-900 text-secondary-800 dark:text-neutral-200 min-h-screen flex items-center justify-center p-4 sm:p-6">

    <button type="button" id="theme-toggle"
        class="fixed top-4 right-4 z-50 w-11 h-11 rounded-full bg-white/80 dark:bg-secondary-800/80 backdrop-blur-md shadow-lg border border-neutral-200/60 dark:border-secondary-700/60 flex items-center justify-center text-neutral-600 dark:text-neutral-300 hover:text-rose-500 transition-all">
        <i class="fa-solid fa-sun dark:hidden text-base"></i>
        <i class="fa-solid fa-moon hidden dark:inline text-base"></i>
    </button>

    <div class="w-full max-w-md relative">
        <div class="relative bg-white dark:bg-secondary-800 rounded-[30px] shadow-2xl border border-neutral-100 dark:border-secondary-700 overflow-hidden animate-float-in">

            {{-- Header --}}
            <div class="relative overflow-hidden bg-gradient-to-br from-rose-500 via-rose-600 to-pink-600 px-6 py-9 text-center text-white">
                <div class="w-16 h-16 mx-auto mb-3 bg-white/20 backdrop-blur-md rounded-2xl flex items-center justify-center shadow-lg ring-1 ring-white/40">
                    <i class="fa-solid fa-gift text-3xl text-white"></i>
                </div>
                <p class="text-rose-100 text-[10px] font-semibold uppercase tracking-[0.25em] mb-1">Kado Digital & Angpao</p>
                <h1 class="font-heading text-2xl font-bold tracking-tight">{{ $invitation->couple_name }}</h1>
                <p class="text-white/80 text-xs mt-2 leading-relaxed">Doa restu Anda merupakan karunia terindah. Namun jika ingin memberi kado, Anda dapat menyalurkannya melalui rekening/QRIS berikut.</p>
            </div>

            {{-- Content --}}
            <div class="p-6 space-y-4">
                @php
                    $hasGiftBanks = !empty($invitation->gift_banks);
                    $hasGiftEwallets = !empty($invitation->gift_ewallets);
                    $hasQris = !empty($invitation->gift_qris_image);
                    $hasAnyGift = $hasGiftBanks || $hasGiftEwallets || $hasQris;
                @endphp

                @if ($hasAnyGift)
                    {{-- Rekening Bank --}}
                    @if ($hasGiftBanks)
                        @foreach ($invitation->gift_banks as $bank)
                            <div class="bank-card bg-white dark:bg-secondary-700/60 rounded-2xl border border-neutral-200/80 dark:border-secondary-600/60 p-4 shadow-sm">
                                <div class="flex items-center gap-3 mb-3">
                                    <div class="w-9 h-9 rounded-xl bg-blue-50 dark:bg-blue-900/30 flex items-center justify-center">
                                        <i class="fa-solid fa-building-columns text-blue-500 dark:text-blue-400 text-base"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-secondary-800 dark:text-neutral-100">{{ $bank['bank_name'] }}</p>
                                        @if (!empty($bank['account_holder']))
                                            <p class="text-xs text-neutral-500 dark:text-neutral-400">a.n {{ $bank['account_holder'] }}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="flex items-center gap-2 bg-neutral-50 dark:bg-secondary-700 rounded-xl px-3.5 py-2.5 border border-neutral-200/70 dark:border-secondary-600/50">
                                    <span class="font-mono text-sm font-bold text-secondary-800 dark:text-neutral-100 flex-1 tracking-wider">{{ $bank['account_number'] }}</span>
                                    <button type="button" onclick="copyText(this, '{{ $bank['account_number'] }}')"
                                        class="copy-btn inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold bg-rose-50 dark:bg-rose-900/40 text-rose-600 dark:text-rose-400 hover:bg-rose-100 dark:hover:bg-rose-900/60 transition-all border border-rose-200/60 dark:border-rose-800/40">
                                        <i class="fa-regular fa-copy text-xs"></i> Salin
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    @endif

                    {{-- E-Wallet --}}
                    @if ($hasGiftEwallets)
                        @foreach ($invitation->gift_ewallets as $ewallet)
                            <div class="bank-card bg-white dark:bg-secondary-700/60 rounded-2xl border border-neutral-200/80 dark:border-secondary-600/60 p-4 shadow-sm">
                                <div class="flex items-center gap-3 mb-3">
                                    <div class="w-9 h-9 rounded-xl bg-emerald-50 dark:bg-emerald-900/30 flex items-center justify-center">
                                        <i class="fa-solid fa-wallet text-emerald-500 dark:text-emerald-400 text-base"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-secondary-800 dark:text-neutral-100">{{ $ewallet['wallet_name'] }}</p>
                                        <p class="text-xs text-neutral-500 dark:text-neutral-400">E-Wallet</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2 bg-neutral-50 dark:bg-secondary-700 rounded-xl px-3.5 py-2.5 border border-neutral-200/70 dark:border-secondary-600/50">
                                    <span class="font-mono text-sm font-bold text-secondary-800 dark:text-neutral-100 flex-1 tracking-wider">{{ $ewallet['wallet_number'] }}</span>
                                    <button type="button" onclick="copyText(this, '{{ $ewallet['wallet_number'] }}')"
                                        class="copy-btn inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold bg-emerald-50 dark:bg-emerald-900/40 text-emerald-600 dark:text-emerald-400 hover:bg-emerald-100 dark:hover:bg-emerald-900/60 transition-all border border-emerald-200/60 dark:border-emerald-800/40">
                                        <i class="fa-regular fa-copy text-xs"></i> Salin
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    @endif

                    {{-- QRIS --}}
                    @if ($hasQris)
                        <div class="bank-card bg-white dark:bg-secondary-700/60 rounded-2xl border border-neutral-200/80 dark:border-secondary-600/60 p-5 shadow-sm text-center">
                            <div class="flex items-center justify-center gap-2.5 mb-3">
                                <i class="fa-solid fa-qrcode text-rose-500 text-lg"></i>
                                <p class="text-sm font-bold text-secondary-800 dark:text-neutral-100">Scan QRIS</p>
                            </div>
                            <div class="overflow-hidden rounded-xl border border-neutral-200 dark:border-secondary-600 bg-white p-3 inline-block shadow-inner">
                                <img src="{{ Storage::url($invitation->gift_qris_image) }}" alt="QRIS" class="qris-zoom w-52 h-52 object-contain rounded-lg" onclick="this.classList.toggle('zoomed')">
                            </div>
                            <p class="text-[11px] text-neutral-400 dark:text-neutral-500 mt-2">Ketuk gambar untuk memperbesar</p>
                        </div>
                    @endif
                @else
                    <div class="text-center py-8 px-4 bg-neutral-50 dark:bg-secondary-700/40 rounded-2xl border border-neutral-200/60 dark:border-secondary-600/40">
                        <i class="fa-regular fa-gift text-neutral-400 text-3xl mb-3"></i>
                        <p class="text-sm font-semibold text-neutral-600 dark:text-neutral-300">Belum Dikonfigurasi</p>
                        <p class="text-xs text-neutral-400 dark:text-neutral-500 mt-1">Informasi kado digital belum diatur oleh penyelenggara.</p>
                    </div>
                @endif

                {{-- Link ke website undangan --}}
                <div class="pt-2">
                    <a href="{{ route('invitation.show', $invitation->slug) }}"
                        class="w-full py-3.5 px-5 bg-gradient-to-r from-rose-500 to-pink-600 text-white rounded-2xl text-sm font-semibold shadow-lg shadow-rose-500/20 hover:shadow-xl hover:shadow-rose-500/30 transition-all flex items-center justify-center gap-2">
                        <i class="fa-solid fa-envelope-open-text"></i> Buka Website Undangan
                    </a>
                </div>
            </div>

            {{-- Footer --}}
            <div class="px-6 py-3.5 bg-neutral-50/80 dark:bg-secondary-900/60 border-t border-neutral-100 dark:border-secondary-700 text-center">
                <p class="text-[11px] text-neutral-400 dark:text-neutral-500">
                    &copy; {{ date('Y') }} {{ config('app.name') }} &mdash; Digital Gift
                </p>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('theme-toggle')?.addEventListener('click', function() {
            const isDark = document.documentElement.classList.toggle('dark');
            localStorage.setItem('dark-mode', isDark ? 'true' : 'false');
        });

        function copyText(btn, text) {
            navigator.clipboard.writeText(text).then(function() {
                const original = btn.innerHTML;
                btn.classList.add('copied');
                btn.innerHTML = '<i class="fa-solid fa-check text-xs"></i> Tersalin!';
                setTimeout(() => { btn.classList.remove('copied'); btn.innerHTML = original; }, 2000);
            });
        }
    </script>
</body>
</html>
