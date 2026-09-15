<x-app-layout>
    @php
        $invitationId = $invitation?->id ?? request('invitation_id');
        $currentPackage = $packages->firstWhere('package_code', $currentTier);
        $currentRank = $currentPackage ? $currentPackage->sort_order : -1;
    @endphp

    @if($activeMethod === 'midtrans')
    <script src="{{ config('midtrans.snap_url') }}" data-client-key="{{ $clientKey }}"></script>
    <style>
    [x-cloak] {
        display: none !important
    }
    </style>
    @endif

    <div class="min-h-screen" x-data="promotionCatalog" @promotion-refresh.window="refresh()"
        data-promotion-catalog="{{ json_encode($promotionCatalog) }}" data-promotion-url="{{ route('promotions.catalog') }}"
        data-promotion-code="{{ is_string(request('promotion_code')) ? request('promotion_code') : '' }}">
        <x-promotion-banner :checkout="true" />

        {{-- ─── HERO ─── --}}
        <div class="hero-mesh grain-overlay border-b border-neutral-200/60 dark:border-secondary-700/40">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-7 sm:py-8">

                {{-- Breadcrumb --}}
                <nav class="flex items-center gap-1.5 text-xs text-neutral-400 dark:text-neutral-500 mb-4">
                    <a href="{{ route('dashboard') }}" class="hover:text-primary dark:hover:text-primary-400 transition-colors">Dashboard</a>
                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                    @if($invitation)
                        <a href="{{ route('dashboard.invitations.show', $invitation) }}" class="hover:text-primary dark:hover:text-primary-400 transition-colors truncate max-w-[150px]">{{ $invitation->title }}</a>
                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                    @endif
                    <span class="text-neutral-600 dark:text-neutral-400 font-medium">Pilih Paket</span>
                </nav>

                <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
                    <div>
                        <h1 class="font-heading text-2xl sm:text-3xl font-bold text-secondary-800 dark:text-neutral-50 leading-tight">
                            Pilih Paket
                        </h1>
                        <p class="text-sm text-neutral-500 dark:text-neutral-400 mt-1">Upgrade undangan Anda untuk fitur yang lebih lengkap.</p>
                    </div>
                </div>

            </div>
        </div>

        {{-- ─── MAIN CONTENT ─── --}}
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-7 sm:py-8 space-y-6">

            {{-- Invitation Info --}}
            @if($invitation)
            <div class="bg-white dark:bg-secondary-800 rounded-2xl border border-neutral-200/80 dark:border-secondary-700/60 px-5 py-4 flex items-center gap-3">
                <svg class="w-5 h-5 text-neutral-400 dark:text-neutral-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                <span class="text-sm text-neutral-600 dark:text-neutral-400">
                    Memperbarui paket untuk undangan: <strong class="text-secondary-800 dark:text-neutral-100">{{ $invitation->title }}</strong>
                </span>
            </div>
            @endif

            {{-- Payment Method Info --}}
            @if($pendingOrders->isNotEmpty())
                <div id="pesanan-tersimpan" class="space-y-4 rounded-2xl border border-primary-200 bg-primary-50 p-5 dark:border-primary-800 dark:bg-primary-900/20">
                    <h2 class="font-semibold">Pesanan Menunggu Pembayaran</h2>
                    <p class="text-sm text-neutral-600 dark:text-neutral-300">Harga dan kuota promo pesanan ini sudah tersimpan. Lanjutkan pembayaran melalui tombol berikut.</p>
                    @foreach($pendingOrders as $pendingOrder)
                        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                            <div class="text-sm">
                                <p class="font-semibold">{{ ucfirst($pendingOrder->package_type) }} · Rp {{ number_format($pendingOrder->gross_amount, 0, ',', '.') }}</p>
                                <p class="text-xs text-neutral-500 dark:text-neutral-400">{{ $pendingOrder->order_id }} @if($pendingOrder->promotion_title)· {{ $pendingOrder->promotion_title }}@endif</p>
                            </div>
                            <form action="{{ route('dashboard.checkout.process') }}" method="POST" @if($activeMethod === 'midtrans') x-data="checkout" @submit.prevent="handleSubmit" @endif>
                                @csrf
                                <input type="hidden" name="tier" value="{{ $pendingOrder->package_type }}">
                                <input type="hidden" name="invitation_id" value="{{ $pendingOrder->invitation_id }}">
                                <input type="hidden" name="promotion_code" value="{{ $pendingOrder->promotion_code }}">
                                <input type="hidden" name="expected_amount" value="{{ (int) $pendingOrder->gross_amount }}">
                                <button type="submit" @if($activeMethod === 'midtrans') :disabled="processing" @endif class="rounded-xl bg-primary-600 px-4 py-3 text-sm font-semibold text-white disabled:opacity-50">Lanjutkan Pembayaran</button>
                            </form>
                        </div>
                    @endforeach
                </div>
            @endif
            @if($activeMethod === 'manual_bank')
            <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 text-blue-700 dark:text-blue-300 px-5 py-4 rounded-2xl text-sm flex items-center gap-3">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>Saat ini pembayaran menggunakan <strong>Transfer Bank Manual</strong>. Setelah memilih paket, Anda akan melihat instruksi transfer dan tombol kirim bukti via WhatsApp.</span>
            </div>
            @else
            <div class="bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 text-emerald-700 dark:text-emerald-300 px-5 py-4 rounded-2xl text-sm flex items-center gap-3">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>Setelah pilih paket, layar pembayaran akan langsung terbuka. Kamu bisa bayar dengan praktis pakai QRIS, Transfer Bank, atau Dompet Digital kesukaanmu.</span>
            </div>
            @endif

            {{-- Current Tier --}}
            <div class="bg-white dark:bg-secondary-800 rounded-2xl border border-neutral-200/80 dark:border-secondary-700/60 overflow-hidden">
                <div class="px-5 sm:px-6 py-4 border-b border-neutral-100 dark:border-secondary-700/60 flex items-center justify-between">
                    <div>
                        <h2 class="font-semibold text-sm text-secondary-800 dark:text-neutral-100">Paket Anda Saat Ini</h2>
                        <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-0.5">Upgrade untuk membuka fitur premium.</p>
                    </div>
                    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold
                        {{ $currentTier === 'free' ? 'bg-neutral-100 dark:bg-neutral-700 text-neutral-700 dark:text-neutral-300' : '' }}
                        {{ $currentTier === 'silver' ? 'bg-blue-100 dark:bg-blue-900/50 text-blue-700 dark:text-blue-300' : '' }}
                        {{ $currentTier === 'gold' ? 'bg-amber-100 dark:bg-amber-900/50 text-amber-700 dark:text-amber-300' : '' }}
                        {{ $currentTier === 'platinum' ? 'bg-primary-100 dark:bg-primary-900/50 text-primary-700 dark:text-primary-300' : '' }}
                    ">
                        {{ $currentPackage ? $currentPackage->package_name : ucfirst($currentTier) }}
                    </span>
                </div>
            </div>

            {{-- Voucher Card --}}
            <div class="relative overflow-hidden rounded-2xl border border-neutral-200/80 bg-white p-5 sm:p-6 shadow-sm dark:border-secondary-700/60 dark:bg-secondary-800">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-4">
                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-primary-500/10 text-primary-600 dark:bg-primary-500/20 dark:text-primary-400">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                            </svg>
                        </div>
                        <div>
                            <label for="promotion-code" class="block font-heading text-sm sm:text-base font-bold text-secondary-900 dark:text-neutral-100 cursor-pointer">
                                Kode voucher
                            </label>
                            <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-0.5">
                                Masukkan voucher promo untuk mendapatkan potongan harga spesial.
                            </p>
                        </div>
                    </div>

                    {{-- Active Voucher Tag --}}
                    <div x-cloak x-show="code && !message && Object.values(prices).some(p => p?.promotion)"
                        class="inline-flex items-center gap-1.5 self-start sm:self-center rounded-full border border-emerald-200/80 bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700 dark:border-emerald-800/60 dark:bg-emerald-950/50 dark:text-emerald-300">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                        </span>
                        <span>Voucher Aktif:</span>
                        <span class="font-mono font-bold uppercase tracking-wider" x-text="code"></span>
                    </div>
                </div>

                {{-- Input and Action Form --}}
                <form @submit.prevent="applyVoucher()">
                    <div class="flex flex-col sm:flex-row gap-3">
                        <div class="relative flex-1">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-neutral-400 dark:text-neutral-500">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                </svg>
                            </div>
                            <input id="promotion-code" type="text" maxlength="50" x-model="voucherInput"
                                @input="message = ''"
                                autocomplete="off"
                                placeholder="Masukkan kode voucher (contoh: HEMAT50)"
                                :class="message ? 'border-rose-300 dark:border-rose-700/60 focus:border-rose-500 focus:ring-rose-500/20' : (code && !message ? 'border-emerald-300 dark:border-emerald-700/60 focus:border-emerald-500 focus:ring-emerald-500/20' : 'border-neutral-300 dark:border-secondary-600 focus:border-primary-500 focus:ring-primary-500/20')"
                                class="w-full rounded-xl py-3 pl-10 pr-10 text-sm font-medium tracking-wider uppercase placeholder:normal-case placeholder:font-normal placeholder:tracking-normal placeholder:text-neutral-400 bg-neutral-50/50 dark:bg-secondary-900/80 dark:text-neutral-100 transition-all focus:bg-white dark:focus:bg-secondary-900 focus:outline-none focus:ring-2">
                            
                            {{-- Clear input button --}}
                            <button type="button" x-cloak x-show="voucherInput"
                                @click="voucherInput = ''; message = ''; if (code) { removeVoucher(); }"
                                class="absolute inset-y-0 right-0 flex items-center pr-3.5 text-neutral-400 hover:text-neutral-600 dark:hover:text-neutral-300 transition-colors"
                                title="Bersihkan input">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        <div class="flex gap-2 shrink-0">
                            <button type="submit" :disabled="refreshing || !voucherInput.trim()"
                                class="inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-primary-500 to-primary-600 px-6 py-3 text-sm font-bold text-white shadow-sm shadow-primary-500/20 transition-all duration-200 hover:from-primary-600 hover:to-primary-700 hover:shadow-md hover:shadow-primary-500/30 active:scale-[0.98] disabled:opacity-50 disabled:pointer-events-none disabled:shadow-none">
                                <svg x-cloak x-show="refreshing" class="h-4 w-4 animate-spin text-white" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <svg x-show="!refreshing" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                                <span x-show="!refreshing">Terapkan</span>
                                <span x-show="refreshing" x-cloak>Memeriksa...</span>
                            </button>

                            {{-- Remove applied voucher button --}}
                            <button type="button" x-cloak x-show="code && !message" @click="removeVoucher()"
                                class="inline-flex items-center justify-center gap-1.5 rounded-xl border border-neutral-200 bg-white px-4 py-3 text-xs font-semibold text-neutral-600 hover:border-rose-300 hover:bg-rose-50 hover:text-rose-600 dark:border-secondary-700 dark:bg-secondary-800 dark:text-neutral-300 dark:hover:border-rose-800 dark:hover:bg-rose-950/40 dark:hover:text-rose-400 transition-all"
                                title="Hapus voucher yang digunakan">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                <span class="hidden sm:inline">Hapus</span>
                            </button>
                        </div>
                    </div>
                </form>

                {{-- Modern Error Alert Message --}}
                <div x-cloak x-show="message" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-1" x-transition:enter-end="opacity-100 translate-y-0" role="alert"
                    class="mt-4 flex items-start gap-3 rounded-xl border border-rose-200/90 bg-rose-50/90 p-4 text-xs sm:text-sm text-rose-900 shadow-xs dark:border-rose-900/50 dark:bg-rose-950/40 dark:text-rose-200">
                    <div class="flex h-7 w-7 shrink-0 items-center justify-center rounded-lg bg-rose-100 dark:bg-rose-900/60 text-rose-600 dark:text-rose-400">
                        <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h4 class="font-bold text-rose-900 dark:text-rose-200 leading-snug">Voucher Tidak Berlaku</h4>
                        <p x-text="message" class="mt-0.5 text-xs text-rose-700 dark:text-rose-300/90 leading-relaxed"></p>
                    </div>
                    <button type="button" @click="message = ''"
                        class="shrink-0 p-1 text-rose-400 hover:text-rose-600 dark:text-rose-500 dark:hover:text-rose-300 transition-colors"
                        title="Tutup pesan">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                {{-- Modern Success Banner when Voucher is Applied --}}
                <div x-cloak x-show="code && !message && Object.values(prices).some(p => p?.promotion)" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-1" x-transition:enter-end="opacity-100 translate-y-0"
                    class="mt-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3 rounded-xl border border-emerald-200/90 bg-emerald-50/90 p-3.5 sm:p-4 text-xs sm:text-sm text-emerald-900 shadow-xs dark:border-emerald-900/50 dark:bg-emerald-950/40 dark:text-emerald-200">
                    <div class="flex items-center gap-3">
                        <div class="flex h-7 w-7 shrink-0 items-center justify-center rounded-lg bg-emerald-100 dark:bg-emerald-900/60 text-emerald-600 dark:text-emerald-400">
                            <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-emerald-900 dark:text-emerald-100 leading-snug">Voucher Berhasil Diterapkan!</h4>
                            <p class="mt-0.5 text-xs text-emerald-700 dark:text-emerald-300 leading-relaxed">
                                Potongan harga otomatis dihitung pada paket yang memenuhi syarat di bawah.
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 self-start sm:self-center shrink-0">
                        <span class="inline-flex items-center gap-1.5 font-mono font-bold tracking-wider px-3 py-1.5 bg-white dark:bg-secondary-800 border border-emerald-300/80 dark:border-emerald-700 text-emerald-800 dark:text-emerald-200 rounded-lg text-xs shadow-xs">
                            <svg class="h-3.5 w-3.5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                            </svg>
                            <span x-text="code"></span>
                        </span>
                    </div>
                </div>

                {{-- Server validation & flash errors --}}
                @if($errors->any())
                    <div class="mt-4 flex items-start gap-3 rounded-xl border border-rose-200/90 bg-rose-50/90 p-4 text-xs sm:text-sm text-rose-900 shadow-xs dark:border-rose-900/50 dark:bg-rose-950/40 dark:text-rose-200" role="alert">
                        <div class="flex h-7 w-7 shrink-0 items-center justify-center rounded-lg bg-rose-100 dark:bg-rose-900/60 text-rose-600 dark:text-rose-400">
                            <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h4 class="font-bold text-rose-900 dark:text-rose-200">Perhatian</h4>
                            <p class="mt-0.5 text-xs text-rose-700 dark:text-rose-300/90 leading-relaxed">{{ $errors->first() }}</p>
                        </div>
                    </div>
                @endif
                @if(session('error'))
                    <div class="mt-4 flex items-start gap-3 rounded-xl border border-rose-200/90 bg-rose-50/90 p-4 text-xs sm:text-sm text-rose-900 shadow-xs dark:border-rose-900/50 dark:bg-rose-950/40 dark:text-rose-200" role="alert">
                        <div class="flex h-7 w-7 shrink-0 items-center justify-center rounded-lg bg-rose-100 dark:bg-rose-900/60 text-rose-600 dark:text-rose-400">
                            <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h4 class="font-bold text-rose-900 dark:text-rose-200">Perhatian</h4>
                            <p class="mt-0.5 text-xs text-rose-700 dark:text-rose-300/90 leading-relaxed">{{ session('error') }}</p>
                        </div>
                    </div>
                @endif
            </div>
            <div id="pilih-paket" class="grid grid-cols-1 md:grid-cols-3 gap-6 scroll-mt-24">

                @forelse($packages as $pkg)
                    <div class="group relative bg-white dark:bg-secondary-800 rounded-2xl transition-all duration-300 hover:shadow-xl hover:-translate-y-1 flex flex-col
                        {{ $pkg->is_popular ? 'ring-2 ring-primary-500 shadow-lg' : 'border border-neutral-200/80 dark:border-secondary-700/60' }}
                        {{ $currentTier === $pkg->package_code ? 'ring-2 ring-primary-400' : '' }}
                    ">
                        {{-- Popular Badge --}}
                        @if($pkg->is_popular)
                            <div class="absolute -top-3 left-1/2 -translate-x-1/2 z-20">
                                <span class="inline-flex items-center gap-1.5 bg-gradient-to-r from-primary-500 to-primary-600 px-4 py-1.5 rounded-full text-xs font-bold text-white shadow-md whitespace-nowrap">
                                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    Best Seller
                                </span>
                            </div>
                        @endif

                        <div class="p-6 {{ $pkg->is_popular ? 'pt-10' : '' }} flex flex-col flex-1 overflow-hidden">
                            {{-- Package Name + Active badge --}}
                            <div class="flex items-center justify-between">
                                <h3 class="font-heading text-xl font-bold {{ $pkg->is_popular ? 'text-primary-600 dark:text-primary-400' : 'text-secondary-800 dark:text-neutral-100' }}">
                                    {{ $pkg->package_name }}
                                </h3>
                                @if($currentTier === $pkg->package_code)
                                    <span class="text-xs font-bold px-3 py-1 rounded-full text-primary-700 dark:text-primary-300 bg-primary-50 dark:bg-primary-900/50">AKTIF</span>
                                @endif
                            </div>

                            {{-- Description --}}
                            @if($pkg->description)
                                <p class="mt-2 text-sm text-neutral-500 dark:text-neutral-400">{{ $pkg->description }}</p>
                            @endif

                            {{-- Price --}}
                            <div class="mt-6">
                                <x-promotion-price :package="$pkg" :quote="$promotionCatalog['prices'][$pkg->package_code]" />
                            </div>
                            {{-- Features List --}}
                            <div class="border-t border-neutral-200/80 dark:border-secondary-700/60 -mx-6 mt-6 px-6 pt-5">
                                <div class="flex items-center gap-2 mb-4">
                                    <svg class="w-4 h-4 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    <h4 class="text-xs font-semibold text-neutral-400 uppercase tracking-wider">Fitur Termasuk</h4>
                                </div>
                                <ul class="space-y-2.5">
                                    @forelse($pkg->features as $feature)
                                        <li class="flex items-start gap-2.5 text-sm text-neutral-600 dark:text-neutral-300">
                                            <svg class="w-4 h-4 text-emerald-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                            <span>{{ $feature->feature_name }}</span>
                                        </li>
                                    @empty
                                        <li class="text-sm text-neutral-400 italic">Fitur dasar</li>
                                    @endforelse
                                </ul>
                            </div>

                            {{-- CTA --}}
                            <div class="mt-auto pt-5">
                                @if($currentTier === $pkg->package_code || $currentRank >= $pkg->sort_order)
                                    <div class="w-full bg-neutral-100 dark:bg-secondary-700 text-neutral-400 dark:text-neutral-500 rounded-xl py-3 text-sm font-semibold text-center cursor-default">
                                        {{ $currentTier === $pkg->package_code ? 'Paket Aktif' : 'Sudah Lebih Tinggi' }}
                                    </div>
                                @elseif($invitationId)
                                    <form action="{{ route('dashboard.checkout.process') }}" method="POST" @if($activeMethod === 'midtrans')
                                    x-data="checkout" @submit.prevent="handleSubmit" @endif>
                                        @csrf
                                        <input type="hidden" name="tier" value="{{ $pkg->package_code }}">
                                        <input type="hidden" name="invitation_id" value="{{ $invitationId }}">
                                        <input type="hidden" name="promotion_code" :value="code">
                                        <input type="hidden" name="expected_amount" :value="price(@js($pkg->package_code))?.amount" value="{{ $promotionCatalog['prices'][$pkg->package_code]['amount'] }}">
                                        
                                        <button type="submit" x-bind:disabled="!canCheckout(@js($pkg->package_code)){{ $activeMethod === 'midtrans' ? ' || processing' : '' }}"
                                            class="flex items-center justify-center gap-2 w-full rounded-xl py-3 text-sm font-semibold text-center transition-all duration-200
                                                @if($activeMethod === 'manual_bank')
                                                    bg-emerald-600 text-white hover:bg-emerald-700
                                                @else
                                                    {{ $pkg->is_popular ? 'bg-gradient-to-r from-primary-500 to-primary-600 text-white hover:shadow-lg shadow-md' : 'bg-secondary-800 dark:bg-primary-600 text-white hover:bg-secondary-700 dark:hover:bg-primary-700' }}
                                                @endif
                                            ">
                                            @if($activeMethod !== 'midtrans')
                                                Pilih {{ $pkg->package_name }}
                                            @else
                                                <span x-show="!processing">Pilih {{ $pkg->package_name }}</span>
                                                <span x-show="processing" x-cloak>Memproses...</span>
                                            @endif
                                        </button>
                                    </form>
                                    <div x-cloak x-show="code && !price(@js($pkg->package_code))?.promotion"
                                        class="mt-2.5 flex items-center gap-1.5 rounded-lg border border-amber-200/80 bg-amber-50/90 px-2.5 py-1.5 text-xs font-medium text-amber-800 dark:border-amber-900/50 dark:bg-amber-950/40 dark:text-amber-300">
                                        <svg class="h-3.5 w-3.5 shrink-0 text-amber-500" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                        </svg>
                                        <span>Voucher tidak berlaku untuk paket ini.</span>
                                    </div>
                                @else
                                    <a href="{{ route('invitation.create') }}" class="block rounded-xl bg-primary-600 py-3 text-center text-sm font-semibold text-white">Buat Undangan Dahulu</a>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-12 text-center text-neutral-500 dark:text-neutral-400">
                        <p class="text-lg">Belum ada paket tersedia. Silakan hubungi admin.</p>
                    </div>
                @endforelse

            </div>

            {{-- Footer Note --}}
            <div class="text-center">
                <div class="bg-white dark:bg-secondary-800 border border-neutral-200/80 dark:border-secondary-700/60 rounded-2xl p-6 inline-block max-w-2xl mx-auto">
                    <p class="text-sm text-neutral-500 dark:text-neutral-400">
                        Semua paket termasuk fitur RSVP, Buku Tamu, Link Personal per Tamu, dan Template Pesan WhatsApp.
                    </p>
                    <p class="text-sm text-neutral-500 dark:text-neutral-400 mt-1">
                        Pembayaran hanya satu kali, bukan langganan bulanan.
                    </p>
                </div>
            </div>

        </div>
    </div>

</x-app-layout>

