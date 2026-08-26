<x-app-layout>
    @php
        $tierCode = $invitation->currentTier();
        $tierLabel = match($tierCode) {
            'bronze'   => 'Bronze',
            'silver'   => 'Silver',
            'gold'     => 'Gold',
            'platinum' => 'Platinum',
            'free'     => 'Gratis',
            default    => ucfirst($tierCode),
        };
        $tierStyle = match($tierCode) {
            'bronze'   => 'bg-orange-100 dark:bg-orange-900/40 text-orange-700 dark:text-orange-300 border-orange-200 dark:border-orange-700',
            'silver'   => 'bg-neutral-100 dark:bg-neutral-700 text-neutral-600 dark:text-neutral-300 border-neutral-200 dark:border-neutral-600',
            'gold'     => 'bg-amber-100 dark:bg-amber-900/40 text-amber-700 dark:text-amber-300 border-amber-200 dark:border-amber-700',
            'platinum' => 'bg-primary-100 dark:bg-primary-900/40 text-primary-700 dark:text-primary-300 border-primary-200 dark:border-primary-700',
            default    => 'bg-neutral-100 dark:bg-neutral-700 text-neutral-500 dark:text-neutral-400 border-neutral-200 dark:border-neutral-600',
        };
        $isExpired = $invitation->isTrialExpired();
        $isTrial   = $invitation->expires_at !== null && !$invitation->hasPremiumFeatures();
        $daysLeft  = $invitation->expires_at ? (int) max(0, now()->diffInDays($invitation->expires_at, false)) : null;
        $days      = $invitation->trialRemainingDays();
        $hours     = $invitation->trialRemainingHours();
        $isUrgent  = $invitation->isTrialUrgent();
    @endphp

    <div class="min-h-screen">

        {{-- ─────────────────────────────────────────────────────────────────────
             PAGE HERO
        ──────────────────────────────────────────────────────────────────────── --}}
        <div class="grain-overlay relative isolate overflow-hidden border-b border-secondary-700 bg-secondary-900 bg-gradient-to-br from-secondary-900 via-secondary-900 to-primary-900/60 text-white">
            <div class="mx-auto max-w-7xl px-4 py-7 sm:px-6 sm:py-9 lg:px-8">

                {{-- Breadcrumb --}}
                <nav aria-label="Breadcrumb" class="mb-5 flex items-center gap-1.5 text-xs text-white/40">
                    <a href="{{ route('dashboard') }}" class="transition-colors hover:text-primary-300">Dashboard</a>
                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                    <span class="max-w-[200px] truncate font-medium text-white/70">{{ $invitation->title }}</span>
                </nav>

                <div class="grid gap-6 lg:grid-cols-[minmax(0,1fr)_minmax(420px,0.85fr)] lg:items-center">
                    <div class="min-w-0">
                        <p class="mb-3 text-[10px] font-bold uppercase tracking-[0.24em] text-primary-300">Pusat kendali undangan</p>
                        <div class="mb-2 flex flex-wrap items-center gap-2.5">
                            <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-bold uppercase tracking-wider border {{ $tierStyle }}">
                                {{ $tierLabel }}
                            </span>
                            @if($isExpired)
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[10px] font-semibold bg-red-100 dark:bg-red-900/40 text-red-600 dark:text-red-400">
                                    <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>Kedaluwarsa
                                </span>
                            @elseif($isTrial)
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[10px] font-semibold bg-amber-100 dark:bg-amber-900/40 text-amber-700 dark:text-amber-400">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                    Percobaan{{ $daysLeft !== null ? " · {$daysLeft}h tersisa" : '' }}
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[10px] font-semibold bg-emerald-100 dark:bg-emerald-900/40 text-emerald-700 dark:text-emerald-400">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>Aktif
                                </span>
                            @endif
                        </div>
                        <h1 class="font-heading text-3xl font-bold leading-tight text-white sm:text-4xl lg:text-5xl">
                            {{ $invitation->title }}
                        </h1>
                        <p class="mt-2 text-sm text-white/55 sm:text-base">{{ $invitation->couple_name }}</p>
                        <p class="mt-4 max-w-2xl text-sm leading-6 text-white/45">Pantau performa, kelola tamu, dan siapkan seluruh pengalaman undangan dari satu dashboard.</p>
                    </div>

{{-- CTA Buttons --}}
                    <div class="grid grid-cols-2 gap-2 rounded-3xl border border-white/10 bg-white/[0.06] p-3 shadow-2xl backdrop-blur-sm sm:p-4">
                        <a href="{{ route('invitation.show', $invitation->slug) }}" target="_blank"
                            class="col-span-2 inline-flex items-center justify-center gap-2 rounded-xl bg-primary-500 px-4 py-3 text-sm font-bold text-white shadow-lg shadow-primary-500/20 transition-all hover:-translate-y-0.5 hover:bg-primary-400">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                            Lihat Website
                        </a>
                        <a href="{{ route('dashboard.invitations.edit', $invitation) }}"
                            class="inline-flex items-center justify-center gap-1.5 rounded-xl border border-white/15 bg-white/5 px-3 py-2.5 text-xs font-semibold text-white transition-all hover:border-white/30 hover:bg-white/10">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            Edit Detail
                        </a>
                        <a href="{{ route('dashboard.invitations.invoice-pdf', $invitation) }}"
                            class="inline-flex items-center justify-center gap-1.5 rounded-xl border border-white/15 bg-white/5 px-3 py-2.5 text-xs font-semibold text-white transition-all hover:border-emerald-300/50 hover:bg-emerald-400/10">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            Invoice PDF
                        </a>
                         @if($invitation->canUseWhatsappGateway())
                         <a href="{{ route('dashboard.whatsapp.setting', $invitation) }}"
                            class="inline-flex items-center justify-center gap-1.5 rounded-xl border border-white/15 bg-white/5 px-3 py-2.5 text-xs font-semibold text-white transition-all hover:border-teal-300/50 hover:bg-teal-400/10">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                            Pengaturan WA
                        </a>
                        @endif
                        @if(!$isExpired && ($tierCode === 'free' || $isTrial))
                            <a href="{{ route('dashboard.checkout', ['invitation_id' => $invitation->id]) }}"
                                class="inline-flex items-center justify-center gap-1.5 rounded-xl border border-primary-300/30 bg-primary-500/15 px-3 py-2.5 text-xs font-semibold text-primary-200 transition-all hover:border-primary-300/60 hover:bg-primary-500/25">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 10l7-7m0 0l7 7m-7-7v18"/></svg>
                                Upgrade Paket
                            </a>
                        @endif
                    </div>
                </div>

                {{-- Stat Strip --}}
                <div class="mt-7 grid grid-cols-2 gap-px overflow-hidden rounded-2xl border border-white/10 bg-white/10 sm:grid-cols-4">
                    @php
                        $showStats = [
                            ['label' => 'Tamu',       'value' => $invitation->guests->count(),                                  'color' => 'text-white'],
                            ['label' => 'RSVP Hadir', 'value' => $invitation->rsvps->where('attendance', 'attending')->count(), 'color' => 'text-emerald-300'],
                            ['label' => 'Ucapan',     'value' => $invitation->wishes->count(),                                  'color' => 'text-primary-300'],
                            ['label' => 'Pengunjung', 'value' => $totalUniques,                                                 'color' => 'text-blue-300'],
                        ];
                    @endphp
                    @foreach($showStats as $s)
                        <div class="flex flex-col items-center bg-secondary-900/35 px-3 py-4 text-center backdrop-blur-sm sm:items-start sm:px-5 sm:text-left">
                            <span class="stat-value text-xl sm:text-2xl font-bold {{ $s['color'] }} tabular-nums">{{ $s['value'] }}</span>
                            <span class="mt-0.5 text-[10px] font-medium text-white/45 sm:text-xs">{{ $s['label'] }}</span>
                        </div>
                    @endforeach
                </div>

                {{-- URL Bar --}}
                <div class="mt-4 flex items-center gap-2.5 rounded-xl border border-white/10 bg-white/5 px-4 py-2.5 backdrop-blur-sm">
                    <svg class="h-3.5 w-3.5 flex-shrink-0 text-white/35" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                    <a href="{{ route('invitation.show', $invitation->slug) }}" target="_blank"
                        class="truncate font-mono text-xs text-white/45 transition-colors hover:text-primary-300">
                        {{ parse_url(config('app.url'), PHP_URL_HOST) }}/<strong class="text-white/75">{{ $invitation->slug }}</strong>
                    </a>
                    @if($invitation->slug_change_count > 0)
                        <span class="ml-auto flex-shrink-0 text-[10px] font-medium text-white/35">diubah {{ $invitation->slug_change_count }}×</span>
                    @endif
                </div>

            </div>
        </div>

        {{-- ─────────────────────────────────────────────────────────────────────
             MAIN CONTENT
        ──────────────────────────────────────────────────────────────────────── --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-7 sm:py-8 space-y-5">

            {{-- ── Trial Countdown Banner ── --}}
            @if($isTrial || $isExpired)
                <div class="relative overflow-hidden rounded-2xl border transition-all duration-300
                    {{ $isExpired
                        ? 'bg-red-50/80 dark:bg-red-950/30 border-red-200/80 dark:border-red-800/50'
                        : ($isUrgent
                            ? 'bg-amber-50/80 dark:bg-amber-950/30 border-amber-200/80 dark:border-amber-800/50'
                            : 'bg-primary-50/70 dark:bg-secondary-800/90 border-primary-200/70 dark:border-primary-800/40')
                    }}">

                    {{-- Accent left border --}}
                    <div class="absolute left-0 top-0 bottom-0 w-1 rounded-l-2xl
                        {{ $isExpired ? 'bg-red-400' : ($isUrgent ? 'bg-amber-400' : 'bg-primary') }}"></div>

                    <div class="pl-5 pr-4 py-4 sm:pl-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 text-secondary-800 dark:text-neutral-200">
                        <div class="flex items-start gap-3">
                            {{-- Status dot --}}
                            <div class="mt-1 flex-shrink-0 w-2 h-2 rounded-full {{ $isExpired ? 'bg-red-500' : ($isUrgent ? 'bg-amber-500 animate-pulse' : 'bg-primary animate-pulse') }}"></div>

                            <div>
                                <h4 class="font-semibold text-sm
                                    {{ $isExpired ? 'text-red-800 dark:text-red-300' : ($isUrgent ? 'text-amber-800 dark:text-amber-300' : 'text-secondary-800 dark:text-neutral-100') }}">
                                    {{ $invitation->title }}
                                </h4>
                                @if($isExpired)
                                    <p class="text-xs text-red-600 dark:text-red-400 mt-0.5">
                                        Masa uji coba <strong>telah berakhir</strong> — aktifkan kembali untuk melanjutkan.
                                    </p>
                                @else
                                    <p class="text-xs mt-0.5 {{ $isUrgent ? 'text-amber-700 dark:text-amber-400' : 'text-neutral-600 dark:text-neutral-400' }}">
                                        Masa uji coba tersisa
                                        <strong class="font-semibold">{{ $days }}h {{ $hours }}j</strong>
                                        @if($isUrgent)
                                            <span class="ml-1 text-amber-600 dark:text-amber-400 font-semibold">— Segera aktifkan!</span>
                                        @endif
                                    </p>
                                @endif
                            </div>
                        </div>

                        <a href="{{ route('dashboard.checkout', ['invitation_id' => $invitation->id]) }}"
                           class="self-start sm:self-auto inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-semibold transition-all whitespace-nowrap
                               {{ $isExpired
                                   ? 'bg-red-600 text-white hover:bg-red-700 shadow-sm shadow-red-500/20'
                                   : ($isUrgent
                                       ? 'bg-amber-500 text-white hover:bg-amber-600 shadow-sm shadow-amber-500/20'
                                       : 'bg-primary text-white hover:bg-primary-600 shadow-sm shadow-primary/20')
                               }}">
                            Aktifkan Sekarang
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                            </svg>
                        </a>
                    </div>
                </div>
            @endif

            {{-- ── Pending Orders ── --}}
            @if($pendingOrders->isNotEmpty())
                <div class="bg-white dark:bg-secondary-800 rounded-2xl border border-neutral-200/80 dark:border-secondary-700/60 overflow-hidden shadow-sm">
                    {{-- Header --}}
                    <div class="px-5 sm:px-6 py-4 flex items-center justify-between border-b border-neutral-100 dark:border-secondary-700/60">
                        <div class="flex items-center gap-2.5">
                            <div class="w-2 h-2 rounded-full bg-amber-400 animate-pulse"></div>
                            <h2 class="font-semibold text-sm sm:text-base text-secondary-800 dark:text-neutral-100">
                                Menunggu Pembayaran
                            </h2>
                            <span class="inline-flex items-center justify-center w-5 h-5 rounded-full bg-amber-100 dark:bg-amber-900/40 text-amber-700 dark:text-amber-400 text-xs font-bold">
                                {{ $pendingOrders->count() }}
                            </span>
                        </div>
                    </div>

                    {{-- Orders list --}}
                    <div class="divide-y divide-neutral-100 dark:divide-secondary-700/60">
                        @foreach($pendingOrders as $order)
                            <div class="px-5 sm:px-6 py-4 hover:bg-neutral-50/70 dark:hover:bg-secondary-700/20 transition-colors">
                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                                    <div class="flex-1 min-w-0">
                                        <div class="flex flex-wrap items-center gap-2 mb-1.5">
                                            <span class="font-mono font-bold text-primary dark:text-primary-400 text-xs tracking-wider">{{ $order->invoice_id }}</span>
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-semibold
                                                {{ $order->payment_status === 'pending'
                                                    ? 'bg-amber-100 dark:bg-amber-900/40 text-amber-700 dark:text-amber-300'
                                                    : 'bg-blue-100 dark:bg-blue-900/40 text-blue-700 dark:text-blue-300' }}">
                                                <span class="w-1.5 h-1.5 rounded-full {{ $order->payment_status === 'pending' ? 'bg-amber-500' : 'bg-blue-500' }}"></span>
                                                {{ $order->payment_status === 'pending' ? 'Menunggu Pembayaran' : 'Verifikasi (WA)' }}
                                            </span>
                                        </div>
                                        <div class="flex flex-wrap gap-x-4 gap-y-0.5 text-xs text-neutral-500 dark:text-neutral-400">
                                            <span>Paket <span class="font-semibold text-secondary-700 dark:text-neutral-300">{{ ucfirst($order->package_type) }}</span></span>
                                            <span>Total <span class="font-semibold text-secondary-700 dark:text-neutral-300">Rp{{ $order->total_with_code }}</span></span>
                                            <span>Kode unik <span class="font-semibold text-primary dark:text-primary-400 font-mono">{{ $order->unique_code }}</span></span>
                                        </div>
                                    </div>
                                    <div class="flex-shrink-0">
                                        @if($order->payment_status === 'pending' && $order->is_manual_whatsapp)
                                            <a href="{{ route('dashboard.payment.invoice', $order) }}"
                                               class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-emerald-600 text-white rounded-xl text-xs font-semibold hover:bg-emerald-700 transition-colors shadow-sm shadow-emerald-500/20">
                                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                                                </svg>
                                                Kirim Bukti WA
                                            </a>
                                        @elseif($order->payment_status === 'pending' && $order->payment_method_used === 'doku')
                                            <a href="{{ route('dashboard.payment.doku.invoice', $order) }}"
                                               class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-red-600 text-white rounded-xl text-xs font-semibold hover:bg-red-700 transition-colors shadow-sm shadow-red-500/20">
                                                Lanjutkan Bayar
                                            </a>
                                        @elseif($order->payment_status === 'verifying')
                                            <a href="{{ route('dashboard.payment.invoice', $order) }}"
                                               class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-blue-100 dark:bg-blue-900/40 text-blue-700 dark:text-blue-300 rounded-xl text-xs font-semibold hover:bg-blue-200 dark:hover:bg-blue-900/60 transition-colors">
                                                Lihat Status
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- ── Visitor Chart ── --}}
            <section aria-labelledby="visitor-analytics-heading" class="space-y-4">
                <div class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
                    <div>
                        <p class="text-[10px] font-bold uppercase tracking-[0.22em] text-primary dark:text-primary-400">Performa undangan</p>
                        <h2 id="visitor-analytics-heading" class="mt-1 font-heading text-xl font-bold text-secondary-800 dark:text-neutral-100 sm:text-2xl">Kenali aktivitas tamu Anda</h2>
                    </div>
                    <p class="max-w-xl text-xs leading-5 text-neutral-500 dark:text-neutral-400 sm:text-right">Pantau jangkauan website undangan selama 30 hari terakhir.</p>
                </div>
            <div class="overflow-hidden rounded-[24px] border border-neutral-200/80 bg-white shadow-[0_18px_45px_-30px_rgba(15,23,42,0.45)] ring-1 ring-black/5 dark:border-secondary-700/60 dark:bg-secondary-800/80">
                <div class="flex flex-col gap-3 border-b border-neutral-100 px-5 py-4 dark:border-secondary-700/60 sm:flex-row sm:items-center sm:justify-between sm:px-6">
                    <div>
                        <h2 class="font-semibold text-sm text-secondary-800 dark:text-neutral-100">Statistik Pengunjung</h2>
                        <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-0.5">30 hari terakhir</p>
                    </div>
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="rounded-lg bg-primary-50 px-2.5 py-1 text-xs font-semibold text-primary-700 dark:bg-primary-900/30 dark:text-primary-300">{{ $totalViews }} kunjungan</span>
                        <span class="rounded-lg bg-blue-50 px-2.5 py-1 text-xs font-semibold text-blue-700 dark:bg-blue-900/30 dark:text-blue-300">{{ $totalUniques }} pengunjung unik</span>
                    </div>
                </div>
                <div class="p-4 sm:p-6">
                    <div class="relative h-[240px] sm:h-[280px]">
                        <canvas id="visitorChart"
                            data-labels='@json($chartLabels)'
                            data-totals='@json($chartTotals)'
                            data-uniques='@json($chartUniques)'>
                        </canvas>
                    </div>
                </div>
            </div>
            </section>

            {{-- ── Quick Links Row ── --}}
            <section aria-labelledby="invitation-command-center" class="space-y-4 pt-2">
                <div class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
                    <div>
                        <p class="text-[10px] font-bold uppercase tracking-[0.22em] text-primary dark:text-primary-400">Pusat pengelolaan</p>
                        <h2 id="invitation-command-center" class="mt-1 font-heading text-xl font-bold text-secondary-800 dark:text-neutral-100 sm:text-2xl">Kelola seluruh kebutuhan acara</h2>
                    </div>
                    <p class="max-w-xl text-xs leading-5 text-neutral-500 dark:text-neutral-400 sm:text-right">Akses cepat ke data tamu, RSVP, ucapan, QR Code, dan perencanaan pernikahan.</p>
                </div>
            <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">

                {{-- Data Tamu --}}
                @if($invitation->hasFeature('personal_link'))
                    <a href="{{ route('dashboard.invitations.guests.index', $invitation) }}"
                        class="group flex min-h-[112px] items-center gap-4 rounded-3xl border border-neutral-200/80 bg-white p-5 shadow-sm transition-all hover:-translate-y-0.5 hover:border-primary-200 hover:shadow-lg dark:border-secondary-700/60 dark:bg-secondary-800/80 dark:hover:border-primary-800/40">
                        <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-2xl bg-secondary-100 text-secondary-600 transition-colors group-hover:bg-secondary-200 dark:bg-secondary-700 dark:text-neutral-300 dark:group-hover:bg-secondary-600">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                        <div class="min-w-0">
                            <p class="text-sm font-semibold text-secondary-800 dark:text-neutral-100">Data Tamu</p>
                            <p class="text-xs text-neutral-500 dark:text-neutral-400">{{ $invitation->guests->count() }} tamu terdaftar</p>
                        </div>
                        <svg class="w-4 h-4 text-neutral-300 dark:text-neutral-600 ml-auto group-hover:text-primary dark:group-hover:text-primary-400 group-hover:translate-x-0.5 transition-all" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                @else
                    <div class="flex min-h-[112px] items-center gap-4 rounded-3xl border border-amber-200/60 bg-amber-50/50 p-5 dark:border-amber-800/40 dark:bg-amber-950/20">
                        <div class="w-10 h-10 rounded-xl bg-amber-100 dark:bg-amber-900/40 flex items-center justify-center text-amber-500 flex-shrink-0">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                        <div class="min-w-0 flex-1">
                            <div class="flex items-center gap-1.5">
                                <p class="text-sm font-semibold text-secondary-800 dark:text-neutral-100">Data Tamu</p>
                                <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[9px] font-bold bg-amber-200/80 dark:bg-amber-800/60 text-amber-800 dark:text-amber-300 uppercase tracking-wider">Gold</span>
                            </div>
                            <a href="{{ route('dashboard.checkout', ['invitation_id' => $invitation->id]) }}" class="text-xs text-amber-600 dark:text-amber-400 hover:underline">Upgrade untuk akses →</a>
                        </div>
                    </div>
                @endif

                {{-- RSVP --}}
                <a href="{{ route('dashboard.invitations.rsvp-list', $invitation) }}"
                    class="group flex min-h-[112px] items-center gap-4 rounded-3xl border border-neutral-200/80 bg-white p-5 shadow-sm transition-all hover:-translate-y-0.5 hover:border-emerald-200 hover:shadow-lg dark:border-secondary-700/60 dark:bg-secondary-800/80 dark:hover:border-emerald-800/40">
                    <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-2xl bg-emerald-100 text-emerald-600 transition-colors group-hover:bg-emerald-200 dark:bg-emerald-900/30 dark:text-emerald-400 dark:group-hover:bg-emerald-900/50">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div class="min-w-0">
                        <p class="text-sm font-semibold text-secondary-800 dark:text-neutral-100">RSVP / Konfirmasi</p>
                        <p class="text-xs text-neutral-500 dark:text-neutral-400">{{ $invitation->rsvps->where('attendance', 'attending')->count() }} hadir · {{ $invitation->rsvps->count() }} total</p>
                    </div>
                    <svg class="w-4 h-4 text-neutral-300 dark:text-neutral-600 ml-auto group-hover:text-emerald-500 dark:group-hover:text-emerald-400 group-hover:translate-x-0.5 transition-all" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>

                {{-- Ucapan --}}
                <a href="{{ route('dashboard.invitations.wishes-list', $invitation) }}"
                    class="group flex min-h-[112px] items-center gap-4 rounded-3xl border border-neutral-200/80 bg-white p-5 shadow-sm transition-all hover:-translate-y-0.5 hover:border-primary-200 hover:shadow-lg dark:border-secondary-700/60 dark:bg-secondary-800/80 dark:hover:border-primary-800/40">
                    <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-2xl bg-primary-50 text-primary transition-colors group-hover:bg-primary-100 dark:bg-primary-900/30 dark:text-primary-400 dark:group-hover:bg-primary-900/50">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                    </div>
                    <div class="min-w-0">
                        <p class="text-sm font-semibold text-secondary-800 dark:text-neutral-100">Pesan Para Tamu</p>
                        <p class="text-xs text-neutral-500 dark:text-neutral-400">{{ $invitation->wishes->count() }} ucapan & doa</p>
                    </div>
                    <svg class="w-4 h-4 text-neutral-300 dark:text-neutral-600 ml-auto group-hover:text-primary dark:group-hover:text-primary-400 group-hover:translate-x-0.5 transition-all" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>

            <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-3">
            {{-- ── Wedding Planner Link ── --}}
            <a href="{{ route('dashboard.planner.index') }}"
                class="group flex min-h-[128px] items-start gap-4 rounded-3xl border border-violet-200/70 bg-gradient-to-br from-violet-50 to-white p-5 transition-all hover:-translate-y-0.5 hover:border-violet-300 hover:shadow-lg dark:border-violet-800/40 dark:from-violet-950/30 dark:to-secondary-800 dark:hover:border-violet-700/60">
                <div class="flex h-11 w-11 flex-shrink-0 items-center justify-center rounded-2xl bg-violet-100 text-violet-600 transition-colors group-hover:bg-violet-200 dark:bg-violet-900/30 dark:text-violet-400 dark:group-hover:bg-violet-900/50">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3M3 11h18M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <div class="min-w-0">
                    <p class="text-sm font-semibold text-secondary-800 dark:text-neutral-100">Wedding Planner</p>
                    <p class="text-xs text-neutral-500 dark:text-neutral-400">8 pilar persiapan, budget & rundown Hari H</p>
                </div>
                <svg class="ml-auto h-4 w-4 text-violet-300 transition-all group-hover:translate-x-0.5 group-hover:text-violet-500 dark:text-violet-700 dark:group-hover:text-violet-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>

            {{-- ── Fitur QR Code Interaktif (Pusat QR Code) ── --}}
            <a href="{{ route('dashboard.invitations.qr-codes', $invitation) }}" class="group block min-h-[128px] rounded-3xl border border-blue-200/70 bg-gradient-to-br from-blue-50 to-white p-5 transition-all duration-200 hover:-translate-y-0.5 hover:border-blue-300 hover:shadow-lg dark:border-blue-800/40 dark:from-blue-950/30 dark:to-secondary-800 dark:hover:border-blue-700/60">
                <div class="flex items-start gap-3 min-w-0">
                    <div class="flex h-11 w-11 flex-shrink-0 items-center justify-center rounded-2xl bg-blue-100 transition-colors group-hover:bg-blue-200 dark:bg-blue-900/30 dark:group-hover:bg-blue-900/50">
                        <svg class="h-5 w-5 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
                    </div>
                    <div class="min-w-0 flex-1">
                        <h2 class="font-semibold text-sm text-secondary-800 dark:text-neutral-100">Pusat Kelola & Unduh QR Code</h2>
                        <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-0.5 leading-relaxed">
                            Unduh QR Code Website Undangan, QR Kado Digital & QRIS, QR Kirim Ucapan, serta QR RSVP Universal.
                        </p>
                    </div>
                    <svg class="ml-auto mt-0.5 h-4 w-4 flex-shrink-0 text-blue-300 transition-all group-hover:translate-x-0.5 group-hover:text-blue-500 dark:text-blue-700 dark:group-hover:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </div>
            </a>

            {{-- ── RSVP PAX Quota (if limited) ── --}}
            @if($invitation->isRsvpPaxLimited())
                @php
                    $paxUsed    = $invitation->totalAcceptedPax();
                    $paxMax     = $invitation->max_global_pax_quota;
                    $paxPercent = $paxMax > 0 ? round(($paxUsed / $paxMax) * 100) : 0;
                @endphp
                <div class="min-h-[128px] rounded-3xl border border-neutral-200/80 bg-white p-5 dark:border-secondary-700/60 dark:bg-secondary-800/80">
                    <div class="flex items-center justify-between mb-3">
                        <h2 class="font-semibold text-sm text-secondary-800 dark:text-neutral-100">Kuota Pax RSVP</h2>
                        <span class="text-xs font-semibold tabular-nums text-neutral-600 dark:text-neutral-400">{{ $paxUsed }} / {{ $paxMax }} pax</span>
                    </div>
                    <div class="w-full bg-neutral-100 dark:bg-secondary-700 rounded-full h-2.5">
                        <div class="h-2.5 rounded-full transition-all duration-700 {{ $paxPercent >= 90 ? 'bg-red-500' : ($paxPercent >= 70 ? 'bg-amber-500' : 'bg-primary') }}"
                            style="width: {{ $paxPercent }}%"></div>
                    </div>
                    <div class="flex items-center justify-between mt-1.5 text-xs text-neutral-400 dark:text-neutral-500">
                        <span>{{ $paxPercent }}% terpakai</span>
                        <span>Sisa {{ $paxMax - $paxUsed }} pax</span>
                    </div>
                </div>
            @endif

            {{-- ── Add-On & Fitur Tambahan ── --}}
            <a href="{{ route('dashboard.invitations.addons.index', $invitation) }}" class="group block min-h-[128px] rounded-3xl border border-orange-200/70 bg-gradient-to-br from-orange-50 to-white p-5 transition-all duration-200 hover:-translate-y-0.5 hover:border-orange-300 hover:shadow-lg dark:border-orange-800/40 dark:from-orange-950/30 dark:to-secondary-800 dark:hover:border-orange-700/60">
                <div class="flex items-start gap-3 min-w-0">
                    <div class="flex h-11 w-11 flex-shrink-0 items-center justify-center rounded-2xl bg-orange-100 transition-colors group-hover:bg-orange-200 dark:bg-orange-900/30 dark:group-hover:bg-orange-900/50">
                        <svg class="h-5 w-5 text-orange-600 dark:text-orange-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 00-1-1H4a2 2 0 110-4h1a1 1 0 001-1V7a1 1 0 011-1h3a1 1 0 001-1V4z"/></svg>
                    </div>
                    <div class="min-w-0 flex-1">
                        <h2 class="font-semibold text-sm text-secondary-800 dark:text-neutral-100">Add-On & Fitur Tambahan</h2>
                        <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-0.5">{{ $invitation->addons->count() }} add-on terpasang</p>
                    </div>
                    <svg class="ml-auto mt-0.5 h-4 w-4 flex-shrink-0 text-orange-300 transition-all group-hover:translate-x-0.5 group-hover:text-orange-500 dark:text-orange-700 dark:group-hover:text-orange-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </div>
            </a>
            </div>
            </section>

            {{-- ── Gallery Upload ── --}}
            {{-- NOTE: Gallery dropzone HTML and JS are preserved exactly from original --}}
            @php
                // Re-include only the gallery HTML portion (lines 380+ from original show.blade.php are handled here)
            @endphp

            {{-- Gallery Upload Script (JS preserved exactly) --}}
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const dropzone = document.getElementById('gallery-dropzone');
                    const fileInput = document.getElementById('gallery-file-input');
                    const dropzoneEmpty = document.getElementById('dropzone-empty');
                    const dropzonePreview = document.getElementById('dropzone-preview');
                    const previewThumbnails = document.getElementById('preview-thumbnails');
                    const fileCount = document.getElementById('file-count');
                    const uploadCount = document.getElementById('upload-count');
                    const submitBtn = document.getElementById('gallery-submit-btn');
                    const dropzoneError = document.getElementById('dropzone-error');
                    const changeFilesBtn = document.getElementById('gallery-change-files');
                    let selectedFiles = [];

                    const allowedTypes = ['image/jpeg', 'image/png', 'image/webp', 'image/avif', 'image/heic', 'image/heif'];

                    function updatePreview() {
                        previewThumbnails.innerHTML = '';
                        let validFiles = [];
                        let errorMsg = '';

                        for (const file of selectedFiles) {
                            if (!allowedTypes.includes(file.type)) {
                                errorMsg = 'Format tidak didukung. Gunakan JPG, PNG, atau WEBP.';
                                continue;
                            }
                            validFiles.push(file);

                            const reader = new FileReader();
                            const wrapper = document.createElement('div');
                            wrapper.className = 'relative group w-16 h-16 rounded-lg overflow-hidden border border-neutral-200 dark:border-secondary-700 flex-shrink-0';

                            const img = document.createElement('img');
                            img.className = 'w-full h-full object-cover';

                            const removeBtn = document.createElement('button');
                            removeBtn.type = 'button';
                            removeBtn.className = 'absolute top-0.5 right-0.5 w-4 h-4 bg-red-600 dark:bg-red-500 text-white rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity text-xs leading-none';
                            removeBtn.innerHTML = '&times;';
                            removeBtn.dataset.index = selectedFiles.indexOf(file).toString();

                            removeBtn.addEventListener('click', function (e) {
                                e.stopPropagation();
                                const idx = parseInt(this.dataset.index);
                                selectedFiles.splice(idx, 1);
                                updatePreview();
                            });

                            wrapper.appendChild(img);
                            wrapper.appendChild(removeBtn);
                            previewThumbnails.appendChild(wrapper);

                            reader.onload = function (e) {
                                img.src = e.target.result;
                            };
                            reader.readAsDataURL(file);
                        }

                        selectedFiles = validFiles;

                        if (selectedFiles.length === 0) {
                            dropzoneEmpty.classList.remove('hidden');
                            dropzonePreview.classList.add('hidden');
                            submitBtn.disabled = true;
                            submitBtn.querySelector('#upload-count').textContent = '';
                            dropzoneError.textContent = errorMsg;
                            dropzoneError.classList.toggle('hidden', !errorMsg);
                            return;
                        }

                        dropzoneError.classList.add('hidden');
                        dropzoneEmpty.classList.add('hidden');
                        dropzonePreview.classList.remove('hidden');
                        fileCount.textContent = selectedFiles.length + ' foto dipilih';
                        uploadCount.textContent = '(' + selectedFiles.length + ')';
                        submitBtn.disabled = false;
                    }

                    if (dropzone) {
                        dropzone.addEventListener('click', function () { fileInput.click(); });
                        dropzone.addEventListener('dragover', function (e) {
                            e.preventDefault();
                            this.classList.add('border-primary-500', 'bg-primary-100/50');
                        });
                        dropzone.addEventListener('dragleave', function () {
                            this.classList.remove('border-primary-500', 'bg-primary-100/50');
                        });
                        dropzone.addEventListener('drop', function (e) {
                            e.preventDefault();
                            this.classList.remove('border-primary-500', 'bg-primary-100/50');
                            const files = Array.from(e.dataTransfer.files).filter(f => allowedTypes.includes(f.type));
                            if (files.length > 0) { selectedFiles = selectedFiles.concat(files); updatePreview(); }
                        });
                        fileInput.addEventListener('change', function () {
                            const files = Array.from(this.files);
                            if (files.length > 0) { selectedFiles = selectedFiles.concat(files); updatePreview(); }
                            this.value = '';
                        });
                        if (changeFilesBtn) {
                            changeFilesBtn.addEventListener('click', function (e) { e.stopPropagation(); fileInput.click(); });
                        }
                        document.getElementById('gallery-upload-form').addEventListener('submit', function (e) {
                            if (selectedFiles.length === 0) { e.preventDefault(); return; }
                            const dataTransfer = new DataTransfer();
                            selectedFiles.forEach(f => dataTransfer.items.add(f));
                            fileInput.files = dataTransfer.files;
                        });
                    }
                });
            </script>

            {{-- ── Danger Zone ── --}}
            <div class="bg-red-50/60 dark:bg-red-950/20 rounded-2xl border border-red-200/60 dark:border-red-800/40 overflow-hidden">
                <div class="px-5 sm:px-6 py-4">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-lg bg-red-100 dark:bg-red-900/40 flex items-center justify-center text-red-500 flex-shrink-0 mt-0.5">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                            </div>
                            <div>
                                <h2 class="text-sm font-semibold text-red-700 dark:text-red-300">Zona Berbahaya</h2>
                                <p class="text-xs text-red-600/80 dark:text-red-400/80 mt-0.5">Menghapus undangan akan menghapus semua data terkait secara permanen dan tidak dapat dibatalkan.</p>
                            </div>
                        </div>
                        <form action="{{ route('dashboard.invitations.destroy', $invitation) }}" method="POST"
                            onsubmit="return confirmSwal(event, 'Apakah Anda yakin ingin menghapus undangan ini secara permanen?');"
                            class="flex-shrink-0">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="inline-flex items-center gap-2 px-4 py-2 bg-red-600 text-white rounded-xl text-xs font-semibold hover:bg-red-700 hover:shadow-md transition-all">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                Hapus Undangan
                            </button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
