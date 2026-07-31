<x-app-layout>
    @php
        $ownedCount   = $invitation->addons->count();
        $activeCount  = $invitation->addons->filter(fn ($a) => $a->pivot->status_active)->count();
        $pendingCount = $pendingTransactions->count();

        $addonIcons = [
            'heroicon-o-puzzle-piece' => 'M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 00-1-1H4a2 2 0 110-4h1a1 1 0 001-1V7a1 1 0 011-1h3a1 1 0 001-1V4z',
            'heroicon-o-musical-note' => 'M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2z',
            'heroicon-o-gift' => 'M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7',
            'heroicon-o-camera' => 'M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9zM15 13a3 3 0 11-6 0 3 3 0 016 0z',
            'heroicon-o-video-camera' => 'M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z',
            'heroicon-o-chart-bar' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z',
            'heroicon-o-star' => 'M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.196-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z',
            'heroicon-o-heart' => 'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z',
            'heroicon-o-sparkles' => 'M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3zM19 15v3m-1.5-1.5h3M6 6v2M5 7h2',
            'heroicon-o-globe-alt' => 'M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
            'heroicon-o-rocket-launch' => 'M15.59 14.37a6 6 0 01-5.84 7.38v-4.8m5.84-2.58a14.98 14.98 0 006.16-12.12A14.98 14.98 0 009.631 8.41m5.96 5.96a14.926 14.926 0 01-5.841 2.58m-.119-8.54a6 6 0 00-7.381 5.84h4.8m2.581-5.84a14.927 14.927 0 00-2.58 5.84m2.699 2.7c-.103.021-.207.041-.311.06a15.09 15.09 0 01-2.448-2.448 14.9 14.9 0 01.06-.312m-2.24 2.39a4.493 4.493 0 00-1.757 4.306 4.493 4.493 0 004.306-1.758M16.5 9a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z',
            'heroicon-o-phone' => 'M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z',
            'heroicon-o-envelope' => 'M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z',
            'heroicon-o-map-pin' => 'M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0zM15 11a3 3 0 11-6 0 3 3 0 016 0z',
            'heroicon-o-calendar' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z',
            'heroicon-o-user-group' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z',
        ];

        $addonIcon = fn ($identifier) => $addonIcons[$identifier] ?? $addonIcons['heroicon-o-puzzle-piece'];
    @endphp

    <div class="min-h-screen">

        {{-- ─── HERO ─── --}}
        <div class="hero-mesh grain-overlay border-b border-neutral-200/60 dark:border-secondary-700/40">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-7 sm:py-8">

                {{-- Breadcrumb --}}
                <nav class="flex items-center gap-1.5 text-xs text-neutral-400 dark:text-neutral-500 mb-4">
                    <a href="{{ route('dashboard') }}" class="hover:text-primary dark:hover:text-primary-400 transition-colors">Dashboard</a>
                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                    <a href="{{ route('dashboard.invitations.show', $invitation) }}" class="hover:text-primary dark:hover:text-primary-400 transition-colors truncate max-w-[150px]">{{ $invitation->title }}</a>
                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                    <span class="text-neutral-600 dark:text-neutral-400 font-medium">Add-On & Fitur</span>
                </nav>

                <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
                    <div class="flex items-start gap-3 min-w-0">
                        <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-primary to-primary-600 flex items-center justify-center text-white shadow-lg shadow-primary/20 shrink-0">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $addonIcons['heroicon-o-puzzle-piece'] }}"/></svg>
                        </div>
                        <div class="min-w-0">
                            <h1 class="font-heading text-2xl sm:text-3xl font-bold text-secondary-800 dark:text-neutral-50 leading-tight truncate">
                                Add-On & Fitur Tambahan
                            </h1>
                            <p class="text-sm text-neutral-500 dark:text-neutral-400 mt-1">
                                Tingkatkan undangan <strong class="text-secondary-700 dark:text-neutral-300">"{{ $invitation->title }}"</strong> dengan fitur tambahan
                            </p>
                        </div>
                    </div>
                    <a href="{{ route('dashboard.invitations.show', $invitation) }}"
                        class="inline-flex items-center gap-1.5 px-3.5 py-2 text-xs font-semibold text-secondary-700 dark:text-neutral-300 border border-neutral-300/80 dark:border-secondary-600 rounded-xl hover:bg-white dark:hover:bg-secondary-700 transition-all bg-white/70 dark:bg-secondary-800/50 backdrop-blur-sm shrink-0">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                        Kembali ke Undangan
                    </a>
                </div>

                {{-- Stat Strip --}}
                <div class="mt-6 grid grid-cols-2 md:grid-cols-4 gap-px bg-neutral-200/70 dark:bg-secondary-700/50 rounded-2xl overflow-hidden border border-neutral-200/80 dark:border-secondary-700/50">
                    <div class="bg-white/80 dark:bg-secondary-800/70 px-3 sm:px-5 py-4 flex flex-col items-center sm:items-start text-center sm:text-left backdrop-blur-sm">
                        <span class="stat-value text-xl sm:text-2xl font-bold text-secondary-800 dark:text-neutral-100 tabular-nums">{{ $availableAddons->count() }}</span>
                        <span class="text-[10px] sm:text-xs text-neutral-500 dark:text-neutral-400 font-medium mt-0.5">Add-On Tersedia</span>
                    </div>
                    <div class="bg-white/80 dark:bg-secondary-800/70 px-3 sm:px-5 py-4 flex flex-col items-center sm:items-start text-center sm:text-left backdrop-blur-sm">
                        <span class="stat-value text-xl sm:text-2xl font-bold text-primary dark:text-primary-400 tabular-nums">{{ $ownedCount }}</span>
                        <span class="text-[10px] sm:text-xs text-neutral-500 dark:text-neutral-400 font-medium mt-0.5">Terpasang</span>
                    </div>
                    <div class="bg-white/80 dark:bg-secondary-800/70 px-3 sm:px-5 py-4 flex flex-col items-center sm:items-start text-center sm:text-left backdrop-blur-sm">
                        <span class="stat-value text-xl sm:text-2xl font-bold text-emerald-600 dark:text-emerald-400 tabular-nums">{{ $activeCount }}</span>
                        <span class="text-[10px] sm:text-xs text-neutral-500 dark:text-neutral-400 font-medium mt-0.5">Aktif</span>
                    </div>
                    <div class="bg-white/80 dark:bg-secondary-800/70 px-3 sm:px-5 py-4 flex flex-col items-center sm:items-start text-center sm:text-left backdrop-blur-sm">
                        <span class="stat-value text-xl sm:text-2xl font-bold text-amber-600 dark:text-amber-400 tabular-nums">{{ $pendingCount }}</span>
                        <span class="text-[10px] sm:text-xs text-neutral-500 dark:text-neutral-400 font-medium mt-0.5">Menunggu Pembayaran</span>
                    </div>
                </div>

            </div>
        </div>

        @if($paymentMethod === 'midtrans')
        <script src="{{ config('midtrans.snap_url') }}" data-client-key="{{ $clientKey }}"></script>
        <style>[x-cloak] { display: none !important }</style>
        @endif

        @if($paymentMethod === 'doku')
        <style>[x-cloak] { display: none !important }</style>
        @endif

        {{-- ─── MAIN CONTENT ─── --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-7 sm:py-8 space-y-5">

            {{-- Flash Messages --}}
            @if(session('success'))
                <div class="p-4 rounded-2xl bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-700/60 flex items-center gap-3 shadow-sm">
                    <div class="w-8 h-8 rounded-xl bg-emerald-100 dark:bg-emerald-900/40 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <span class="text-sm font-medium text-emerald-800 dark:text-emerald-300">{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="p-4 rounded-2xl bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-700/60 flex items-center gap-3 shadow-sm">
                    <div class="w-8 h-8 rounded-xl bg-red-100 dark:bg-red-900/40 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4 text-red-600 dark:text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                    </div>
                    <span class="text-sm font-medium text-red-800 dark:text-red-300">{{ session('error') }}</span>
                </div>
            @endif

            @if(session('info'))
                <div class="p-4 rounded-2xl bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-700/60 flex items-center gap-3 shadow-sm">
                    <div class="w-8 h-8 rounded-xl bg-blue-100 dark:bg-blue-900/40 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <span class="text-sm font-medium text-blue-800 dark:text-blue-300">{{ session('info') }}</span>
                </div>
            @endif

            {{-- PIC WhatsApp Banner --}}
            <div class="bg-white dark:bg-secondary-800 rounded-2xl border border-neutral-200/80 dark:border-secondary-700/60 overflow-hidden">
                <div class="p-5 sm:p-6">
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                        <div class="flex items-start gap-3">
                            <div class="flex-shrink-0 w-11 h-11 rounded-xl bg-emerald-100 dark:bg-emerald-900/40 flex items-center justify-center text-emerald-600 dark:text-emerald-400">
                                <i class="fa-solid fa-headset text-lg"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-secondary-800 dark:text-neutral-100">PIC WhatsApp Konfirmasi & Bantuan</p>
                                <p class="text-sm text-neutral-600 dark:text-neutral-400 mt-1">
                                    Sudah melakukan order add-on atau butuh bantuan terkait pesanan? Hubungi tim kami langsung melalui WhatsApp agar bisa kami bantu cek dan konfirmasi.
                                </p>
                            </div>
                        </div>
                        <a href="https://wa.me/{{ config('app.whatsapp_number', '62895349823366') }}?text={{ urlencode('Halo, saya sudah order add-on undangan dan ingin konfirmasi / butuh bantuan.') }}"
                           target="_blank"
                           rel="noopener noreferrer"
                           class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold transition-all shadow-sm shrink-0">
                            <i class="fa-brands fa-whatsapp"></i>
                            Hubungi PIC WhatsApp
                        </a>
                    </div>
                </div>
            </div>

            {{-- Payment Method Info --}}
            @if($paymentMethod === 'manual_bank')
                <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 text-blue-700 dark:text-blue-300 px-5 py-4 rounded-2xl text-sm flex items-center gap-3">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>Saat ini pembayaran menggunakan <strong>Transfer Bank Manual</strong>. Setelah membeli add-on, Anda akan melihat instruksi transfer dan tombol kirim bukti via WhatsApp.</span>
                </div>
            @else
                <div class="bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 text-emerald-700 dark:text-emerald-300 px-5 py-4 rounded-2xl text-sm flex items-center gap-3">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>Setelah pilih add-on, layar pembayaran akan langsung terbuka. Kamu bisa bayar dengan QRIS, Transfer Bank, atau Dompet Digital.</span>
                </div>
            @endif

            {{-- Add-On Cards --}}
            <div class="space-y-4">
                @forelse($availableAddons as $addon)
                    @php
                        $pivot = $invitation->addons->firstWhere('id', $addon->id);
                        $isOwned = $pivot !== null;
                        $isActive = $pivot?->pivot->status_active ?? false;
                        $pendingTx = $pendingTransactions->get($addon->id);
                    @endphp
                    <div class="bg-white dark:bg-secondary-800 rounded-2xl border overflow-hidden transition-all
                        {{ $isActive ? 'border-emerald-200 dark:border-emerald-800' : ($pendingTx ? 'border-amber-200 dark:border-amber-800' : 'border-neutral-200/80 dark:border-secondary-700/60') }}">
                        <div class="p-5 sm:p-6">
                            <div class="flex flex-col sm:flex-row sm:items-start gap-4">
                                <div class="flex items-start gap-4 flex-1 min-w-0">
                                    <div class="flex-shrink-0 w-12 h-12 rounded-xl bg-primary-50 dark:bg-primary-900/50 flex items-center justify-center text-primary dark:text-primary-400">
                                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $addonIcon($addon->icon_identifier) }}"/></svg>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center gap-2 flex-wrap">
                                            <h3 class="text-base font-bold text-secondary-800 dark:text-neutral-100">
                                                {{ $addon->name }}
                                            </h3>
                                            @if($isActive)
                                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 dark:bg-emerald-900/50 text-emerald-700 dark:text-emerald-300">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                                    Aktif
                                                </span>
                                            @elseif($pendingTx && $pendingTx->payment_status === 'verifying')
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-blue-100 dark:bg-blue-900/50 text-blue-700 dark:text-blue-300">
                                                    Verifikasi (WA)
                                                </span>
                                            @elseif($pendingTx)
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-amber-100 dark:bg-amber-900/50 text-amber-700 dark:text-amber-300">
                                                    Menunggu Pembayaran
                                                </span>
                                            @elseif($isOwned)
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-neutral-100 dark:bg-secondary-700 text-neutral-600 dark:text-neutral-400">
                                                    Belum Aktif
                                                </span>
                                            @endif
                                        </div>
                                        @if($addon->description)
                                            <p class="text-sm text-neutral-500 dark:text-neutral-400 mt-1">
                                                {{ $addon->description }}
                                            </p>
                                        @endif
                                        <div class="flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-3 mt-2">
                                            <span class="text-sm font-semibold text-primary-600 dark:text-primary-400">
                                                Rp {{ number_format($addon->price, 0, ',', '.') }}
                                            </span>
                                            @if($isOwned && $pivot->pivot->purchased_price)
                                                <span class="text-xs text-neutral-400 dark:text-neutral-500">
                                                    (Dibeli seharga Rp {{ number_format($pivot->pivot->purchased_price, 0, ',', '.') }})
                                                </span>
                                            @endif
                                            @if($isActive && $pivot->pivot->activated_at)
                                                <span class="text-xs text-neutral-400 dark:text-neutral-500">
                                                    Diaktifkan {{ \Carbon\Carbon::parse($pivot->pivot->activated_at)->diffForHumans() }}
                                                </span>
                                            @endif
                                            @if($pendingTx && $pendingTx->payment_status === 'pending')
                                                <span class="text-xs text-amber-500 dark:text-amber-400">
                                                    {{ $pendingTx->created_at->diffForHumans() }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="flex-shrink-0 w-full sm:w-auto">
                                    @if($pendingTx && $pendingTx->payment_status === 'pending')
                                        @if($paymentMethod === 'midtrans' || $paymentMethod === 'doku')
                                            <form action="{{ route('dashboard.invitations.addons.purchase', [$invitation, $addon]) }}" method="POST"
                                                x-data="addonCheckout" @submit.prevent="handleSubmit">
                                                @csrf
                                                <button type="submit"
                                                    x-bind:disabled="processing"
                                                    class="inline-flex items-center justify-center gap-2 w-full sm:w-auto px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-xl text-sm font-semibold transition-all">
                                                    <span x-show="!processing">Bayar Sekarang</span>
                                                    <span x-show="processing" x-cloak>Memproses...</span>
                                                </button>
                                            </form>
                                        @else
                                            <a href="{{ route('dashboard.invitations.addons.invoice', [$invitation, $pendingTx]) }}"
                                                class="inline-flex items-center justify-center gap-2 w-full sm:w-auto px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-xl text-sm font-semibold transition-all">
                                                Lihat Invoice
                                            </a>
                                        @endif
                                    @elseif($pendingTx && $pendingTx->payment_status === 'verifying')
                                        <a href="{{ route('dashboard.invitations.addons.invoice', [$invitation, $pendingTx]) }}"
                                            class="inline-flex items-center justify-center gap-2 w-full sm:w-auto px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-semibold transition-all">
                                            Cek Status
                                        </a>
                                    @elseif(!$isOwned)
                                        @if($paymentMethod === 'midtrans' || $paymentMethod === 'doku')
                                            <form action="{{ route('dashboard.invitations.addons.purchase', [$invitation, $addon]) }}" method="POST"
                                                x-data="addonCheckout" @submit.prevent="handleSubmit">
                                                @csrf
                                                <button type="submit"
                                                    x-bind:disabled="processing"
                                                    class="inline-flex items-center justify-center gap-2 w-full sm:w-auto px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-xl text-sm font-semibold transition-all">
                                                    <span x-show="!processing">Beli Rp {{ number_format($addon->price, 0, ',', '.') }}</span>
                                                    <span x-show="processing" x-cloak>Memproses...</span>
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ route('dashboard.invitations.addons.purchase', [$invitation, $addon]) }}" method="POST">
                                                @csrf
                                                <button type="submit"
                                                    class="inline-flex items-center justify-center gap-2 w-full sm:w-auto px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-xl text-sm font-semibold transition-all">
                                                    Beli Rp {{ number_format($addon->price, 0, ',', '.') }}
                                                </button>
                                            </form>
                                        @endif
                                    @elseif($isOwned && !$isActive)
                                        <form action="{{ route('dashboard.invitations.addons.activate', [$invitation, $addon]) }}" method="POST">
                                            @csrf
                                            <button type="submit"
                                                class="inline-flex items-center justify-center gap-2 w-full sm:w-auto px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-xl text-sm font-semibold transition-all">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                                Aktifkan
                                            </button>
                                        </form>
                                    @elseif($isOwned && $isActive)
                                        <form action="{{ route('dashboard.invitations.addons.deactivate', [$invitation, $addon]) }}" method="POST">
                                            @csrf
                                            <button type="submit"
                                                class="inline-flex items-center justify-center gap-2 w-full sm:w-auto px-4 py-2 bg-white dark:bg-secondary-800 border border-neutral-300 dark:border-neutral-600 rounded-xl text-sm font-semibold text-neutral-700 dark:text-neutral-300 hover:bg-neutral-50 dark:hover:bg-secondary-700 transition-all">
                                                Nonaktifkan
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="bg-white dark:bg-secondary-800 rounded-2xl border border-neutral-200/80 dark:border-secondary-700/60 p-10 text-center">
                        <div class="w-16 h-16 mx-auto rounded-full bg-neutral-100 dark:bg-secondary-700 flex items-center justify-center">
                            <svg class="w-8 h-8 text-neutral-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                        </div>
                        <h3 class="mt-4 text-base font-semibold text-secondary-800 dark:text-neutral-100">Belum Ada Add-On</h3>
                        <p class="mt-1 text-sm text-neutral-500 dark:text-neutral-400">Saat ini belum ada add-on yang tersedia.</p>
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>
