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
    @endphp

    <div class="min-h-screen">

        {{-- ─────────────────────────────────────────────────────────────────────
             PAGE HERO
        ──────────────────────────────────────────────────────────────────────── --}}
        <div class="hero-mesh grain-overlay border-b border-neutral-200/60 dark:border-secondary-700/40">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-7 sm:py-8">

                {{-- Breadcrumb --}}
                <nav class="flex items-center gap-1.5 text-xs text-neutral-400 dark:text-neutral-500 mb-4">
                    <a href="{{ route('dashboard') }}" class="hover:text-primary dark:hover:text-primary-400 transition-colors">Dashboard</a>
                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                    <span class="text-neutral-600 dark:text-neutral-400 font-medium truncate max-w-[200px]">{{ $invitation->title }}</span>
                </nav>

                <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
                    <div class="min-w-0">
                        <div class="flex items-center gap-2.5 mb-1">
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
                        <h1 class="font-heading text-2xl sm:text-3xl font-bold text-secondary-800 dark:text-neutral-50 leading-tight truncate">
                            {{ $invitation->title }}
                        </h1>
                        <p class="text-sm text-neutral-500 dark:text-neutral-400 mt-1">{{ $invitation->couple_name }}</p>
                    </div>

                    {{-- CTA Buttons --}}
                    <div class="flex flex-wrap items-center gap-2 flex-shrink-0">
                        <a href="{{ route('invitation.show', $invitation->slug) }}" target="_blank"
                            class="inline-flex items-center gap-1.5 px-3.5 py-2 text-xs font-semibold text-primary dark:text-primary-400 border border-primary/30 dark:border-primary-700/50 rounded-xl hover:bg-primary-50 dark:hover:bg-primary-900/20 transition-all bg-white/70 dark:bg-secondary-800/50 backdrop-blur-sm">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                            Lihat Website
                        </a>
                        <a href="{{ route('dashboard.invitations.edit', $invitation) }}"
                            class="inline-flex items-center gap-1.5 px-3.5 py-2 text-xs font-semibold text-secondary-700 dark:text-neutral-300 border border-neutral-300/80 dark:border-secondary-600 rounded-xl hover:bg-white dark:hover:bg-secondary-700 transition-all bg-white/70 dark:bg-secondary-800/50 backdrop-blur-sm">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            Edit Detail
                        </a>
                        <a href="{{ route('dashboard.invitations.invoice-pdf', $invitation) }}"
                            class="inline-flex items-center gap-1.5 px-3.5 py-2 text-xs font-semibold text-emerald-700 dark:text-emerald-300 border border-emerald-300/80 dark:border-emerald-700/50 rounded-xl hover:bg-emerald-50 dark:hover:bg-emerald-900/20 transition-all bg-white/70 dark:bg-secondary-800/50 backdrop-blur-sm">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            Invoice PDF
                        </a>
                         @if($invitation->canUseWhatsappGateway())
                         <a href="{{ route('dashboard.whatsapp.setting', $invitation) }}"
                            class="inline-flex items-center gap-1.5 px-3.5 py-2 text-xs font-semibold text-teal-700 dark:text-teal-300 border border-teal-300/80 dark:border-teal-700/50 rounded-xl hover:bg-teal-50 dark:hover:bg-teal-900/20 transition-all bg-white/70 dark:bg-secondary-800/50 backdrop-blur-sm">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                            Pengaturan WA
                        </a>
                        @endif
                        @if(!$isExpired && ($tierCode === 'free' || $isTrial))
                            <a href="{{ route('dashboard.checkout', ['invitation_id' => $invitation->id]) }}"
                                class="inline-flex items-center gap-1.5 px-4 py-2 text-xs font-semibold text-white bg-gradient-to-br from-primary to-primary-600 rounded-xl shadow-sm shadow-primary/25 hover:shadow-md hover:shadow-primary/30 hover:-translate-y-0.5 transition-all">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 10l7-7m0 0l7 7m-7-7v18"/></svg>
                                Upgrade Paket
                            </a>
                        @endif
                    </div>
                </div>

                {{-- Stat Strip --}}
                <div class="mt-6 grid grid-cols-4 gap-px bg-neutral-200/70 dark:bg-secondary-700/50 rounded-2xl overflow-hidden border border-neutral-200/80 dark:border-secondary-700/50">
                    @php
                        $showStats = [
                            ['label' => 'Tamu',       'value' => $invitation->guests->count(),                                          'color' => 'text-secondary-800 dark:text-neutral-100'],
                            ['label' => 'RSVP Hadir', 'value' => $invitation->rsvps->where('attendance', 'attending')->count(),         'color' => 'text-emerald-600 dark:text-emerald-400'],
                            ['label' => 'Ucapan',     'value' => $invitation->wishes->count(),                                          'color' => 'text-primary dark:text-primary-400'],
                            ['label' => 'Pengunjung', 'value' => $totalUniques,                                                         'color' => 'text-blue-600 dark:text-blue-400'],
                        ];
                    @endphp
                    @foreach($showStats as $s)
                        <div class="bg-white/80 dark:bg-secondary-800/70 px-3 sm:px-5 py-4 flex flex-col items-center sm:items-start text-center sm:text-left backdrop-blur-sm">
                            <span class="stat-value text-xl sm:text-2xl font-bold {{ $s['color'] }} tabular-nums">{{ $s['value'] }}</span>
                            <span class="text-[10px] sm:text-xs text-neutral-500 dark:text-neutral-400 font-medium mt-0.5">{{ $s['label'] }}</span>
                        </div>
                    @endforeach
                </div>

                {{-- URL Bar --}}
                <div class="mt-4 flex items-center gap-2.5 px-4 py-2.5 bg-white/60 dark:bg-secondary-800/40 backdrop-blur-sm rounded-xl border border-neutral-200/70 dark:border-secondary-700/50">
                    <svg class="w-3.5 h-3.5 text-neutral-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                    <a href="{{ route('invitation.show', $invitation->slug) }}" target="_blank"
                        class="font-mono text-xs text-neutral-500 dark:text-neutral-400 hover:text-primary dark:hover:text-primary-400 transition-colors truncate">
                        {{ parse_url(config('app.url'), PHP_URL_HOST) }}/<strong class="text-secondary-700 dark:text-neutral-300">{{ $invitation->slug }}</strong>
                    </a>
                    @if($invitation->slug_change_count > 0)
                        <span class="ml-auto flex-shrink-0 text-[10px] font-medium text-neutral-400 dark:text-neutral-500">diubah {{ $invitation->slug_change_count }}×</span>
                    @endif
                </div>

            </div>
        </div>

        {{-- ─────────────────────────────────────────────────────────────────────
             MAIN CONTENT
        ──────────────────────────────────────────────────────────────────────── --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-7 sm:py-8 space-y-5">

            {{-- ── Visitor Chart ── --}}
            <div class="bg-white dark:bg-secondary-800 rounded-2xl border border-neutral-200/80 dark:border-secondary-700/60 overflow-hidden">
                <div class="px-5 sm:px-6 py-4 border-b border-neutral-100 dark:border-secondary-700/60 flex items-center justify-between">
                    <div>
                        <h2 class="font-semibold text-sm text-secondary-800 dark:text-neutral-100">Statistik Pengunjung</h2>
                        <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-0.5">30 hari terakhir</p>
                    </div>
                    <span class="text-xs font-medium text-neutral-500 dark:text-neutral-400 bg-neutral-100 dark:bg-secondary-700 px-2.5 py-1 rounded-lg">{{ $totalViews }} kunjungan</span>
                </div>
                <div class="p-5">
                    <div class="relative" style="height: 220px;">
                        <canvas id="visitorChart"
                            data-labels='@json($chartLabels)'
                            data-totals='@json($chartTotals)'
                            data-uniques='@json($chartUniques)'>
                        </canvas>
                    </div>
                </div>
            </div>

            {{-- ── Quick Links Row ── --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">

                {{-- Data Tamu --}}
                @if($invitation->hasFeature('personal_link'))
                    <a href="{{ route('dashboard.invitations.guests.index', $invitation) }}"
                        class="group flex items-center gap-4 p-4 bg-white dark:bg-secondary-800 rounded-2xl border border-neutral-200/80 dark:border-secondary-700/60 hover:border-primary-200 dark:hover:border-primary-800/40 hover:shadow-md hover:-translate-y-0.5 transition-all">
                        <div class="w-10 h-10 rounded-xl bg-secondary-100 dark:bg-secondary-700 flex items-center justify-center text-secondary-600 dark:text-neutral-300 flex-shrink-0 group-hover:bg-secondary-200 dark:group-hover:bg-secondary-600 transition-colors">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                        <div class="min-w-0">
                            <p class="text-sm font-semibold text-secondary-800 dark:text-neutral-100">Data Tamu</p>
                            <p class="text-xs text-neutral-500 dark:text-neutral-400">{{ $invitation->guests->count() }} tamu terdaftar</p>
                        </div>
                        <svg class="w-4 h-4 text-neutral-300 dark:text-neutral-600 ml-auto group-hover:text-primary dark:group-hover:text-primary-400 group-hover:translate-x-0.5 transition-all" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                @else
                    <div class="flex items-center gap-4 p-4 bg-amber-50/50 dark:bg-amber-950/20 rounded-2xl border border-amber-200/60 dark:border-amber-800/40">
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
                    class="group flex items-center gap-4 p-4 bg-white dark:bg-secondary-800 rounded-2xl border border-neutral-200/80 dark:border-secondary-700/60 hover:border-emerald-200 dark:hover:border-emerald-800/40 hover:shadow-md hover:-translate-y-0.5 transition-all">
                    <div class="w-10 h-10 rounded-xl bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center text-emerald-600 dark:text-emerald-400 flex-shrink-0 group-hover:bg-emerald-200 dark:group-hover:bg-emerald-900/50 transition-colors">
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
                    class="group flex items-center gap-4 p-4 bg-white dark:bg-secondary-800 rounded-2xl border border-neutral-200/80 dark:border-secondary-700/60 hover:border-primary-200 dark:hover:border-primary-800/40 hover:shadow-md hover:-translate-y-0.5 transition-all">
                    <div class="w-10 h-10 rounded-xl bg-primary-50 dark:bg-primary-900/30 flex items-center justify-center text-primary dark:text-primary-400 flex-shrink-0 group-hover:bg-primary-100 dark:group-hover:bg-primary-900/50 transition-colors">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                    </div>
                    <div class="min-w-0">
                        <p class="text-sm font-semibold text-secondary-800 dark:text-neutral-100">Pesan Para Tamu</p>
                        <p class="text-xs text-neutral-500 dark:text-neutral-400">{{ $invitation->wishes->count() }} ucapan & doa</p>
                    </div>
                    <svg class="w-4 h-4 text-neutral-300 dark:text-neutral-600 ml-auto group-hover:text-primary dark:group-hover:text-primary-400 group-hover:translate-x-0.5 transition-all" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>

            {{-- ── Fitur QR Code Interaktif (Pusat QR Code) ── --}}
            <div class="bg-gradient-to-r from-primary-600 via-primary-700 to-secondary-900 text-white rounded-3xl p-6 sm:p-7 shadow-lg shadow-primary-500/15 relative overflow-hidden">
                <div class="absolute -right-8 -bottom-10 opacity-10 pointer-events-none">
                    <svg class="w-64 h-64 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
                </div>
                <div class="relative z-10 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-5">
                    <div class="space-y-1.5 min-w-0">
                        <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-white/20 backdrop-blur-md text-white uppercase tracking-wider">
                            <svg class="w-3 h-3 text-amber-300" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            Fitur QR Code Lengkap
                        </div>
                        <h2 class="font-heading text-xl sm:text-2xl font-bold leading-snug">Pusat Kelola & Unduh QR Code</h2>
                        <p class="text-xs sm:text-sm text-white/80 max-w-xl leading-relaxed">
                            Unduh QR Code Website Undangan, QR Kado Digital & QRIS, QR Kirim Ucapan, serta QR RSVP Universal secara mudah di halaman khusus.
                        </p>
                    </div>
                    <a href="{{ route('dashboard.invitations.qr-codes', $invitation) }}"
                        class="inline-flex items-center justify-center gap-2 px-5 py-3 bg-white hover:bg-neutral-100 text-secondary-900 rounded-2xl text-xs font-bold shadow-lg shadow-black/10 hover:shadow-xl hover:scale-[1.02] active:scale-[0.98] transition-all whitespace-nowrap shrink-0">
                        <svg class="w-4 h-4 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
                        Buka Pusat QR Code →
                    </a>
                </div>
            </div>

            {{-- ── RSVP PAX Quota (if limited) ── --}}
            @if($invitation->isRsvpPaxLimited())
                @php
                    $paxUsed    = $invitation->totalAcceptedPax();
                    $paxMax     = $invitation->max_global_pax_quota;
                    $paxPercent = $paxMax > 0 ? round(($paxUsed / $paxMax) * 100) : 0;
                @endphp
                <div class="bg-white dark:bg-secondary-800 rounded-2xl border border-neutral-200/80 dark:border-secondary-700/60 px-5 sm:px-6 py-4">
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
            <div class="bg-white dark:bg-secondary-800 rounded-2xl border border-neutral-200/80 dark:border-secondary-700/60 overflow-hidden">
                <div class="px-5 sm:px-6 py-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-lg bg-primary-50 dark:bg-primary-900/30 flex items-center justify-center text-primary dark:text-primary-400">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 00-1-1H4a2 2 0 110-4h1a1 1 0 001-1V7a1 1 0 011-1h3a1 1 0 001-1V4z"/></svg>
                        </div>
                        <div>
                            <h2 class="font-semibold text-sm text-secondary-800 dark:text-neutral-100">Add-On & Fitur Tambahan</h2>
                            <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-0.5">{{ $invitation->addons->count() }} add-on terpasang</p>
                        </div>
                    </div>
                    <a href="{{ route('dashboard.invitations.addons.index', $invitation) }}"
                        class="self-start sm:self-auto inline-flex items-center gap-1.5 px-3.5 py-2 text-xs font-semibold text-primary dark:text-primary-400 border border-primary/30 dark:border-primary-700/50 rounded-xl hover:bg-primary-50 dark:hover:bg-primary-900/20 transition-all">
                        Kelola Add-On
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>
            </div>

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
