<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div class="flex items-center gap-3">
                <div>
                    <h2 class="font-heading text-2xl font-bold text-secondary-800 dark:text-neutral-100">
                        {{ $invitation->title }}
                    </h2>
                    <p class="text-sm text-neutral-500 dark:text-neutral-400 mt-0.5">Kelola undangan digital Anda</p>
                </div>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('invitation.show', $invitation->slug) }}" target="_blank"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-primary-50 dark:bg-primary-900/50 text-primary-700 dark:text-primary-300 rounded-xl text-sm font-semibold hover:bg-primary-100 dark:hover:bg-primary-900/80 transition-all">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    <span class="hidden sm:inline">Lihat Website</span>
                </a>
                <a href="{{ route('dashboard.invitations.edit', $invitation) }}"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-white dark:bg-secondary-800 border border-neutral-300 dark:border-neutral-600 rounded-xl text-sm font-semibold text-neutral-700 dark:text-neutral-300 hover:bg-neutral-50 dark:hover:bg-secondary-700 hover:border-primary-300 dark:hover:border-primary-600 transition-all">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    <span class="hidden sm:inline">Edit Detail</span>
                </a>
                <a href="{{ route('dashboard.invitations.invoice-pdf', $invitation) }}"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-50 dark:bg-emerald-900/50 text-emerald-700 dark:text-emerald-300 rounded-xl text-sm font-semibold hover:bg-emerald-100 dark:hover:bg-emerald-900/70 transition-all">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <span class="hidden sm:inline">Invoice PDF</span>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- Slug Info --}}
            <div class="bg-white dark:bg-secondary-800 rounded-2xl shadow-soft border border-neutral-100 dark:border-secondary-700 overflow-hidden">
                <div class="p-5">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-primary-50 dark:bg-primary-900/50 flex items-center justify-center text-primary dark:text-primary-400">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-sm font-semibold text-secondary-800 dark:text-neutral-100">Tautan Undangan</h3>
                                <a href="{{ route('invitation.show', $invitation->slug) }}" target="_blank"
                                    class="text-primary-600 dark:text-primary-400 hover:text-primary-700 dark:hover:text-primary-300 font-mono text-sm break-all">
                                    {{ parse_url(config('app.url'), PHP_URL_HOST) }}/<strong>{{ $invitation->slug }}</strong>
                                </a>
                            </div>
                        </div>
                        <div>
                            @if($invitation->slug_change_count > 0)
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-100 dark:bg-amber-900/50 text-amber-700 dark:text-amber-300">
                                    Diubah {{ $invitation->slug_change_count }} kali
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-neutral-100 dark:bg-secondary-700 text-neutral-600 dark:text-neutral-400">
                                    Belum pernah diubah
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- Package Status --}}
            @php
$tierCode = $invitation->currentTier();
$tierBadgeColor = match ($tierCode) {
    'bronze' => 'bg-orange-100 dark:bg-orange-900/50 text-orange-700 dark:text-orange-300 border-orange-200 dark:border-orange-800',
    'silver' => 'bg-neutral-100 dark:bg-neutral-700 text-neutral-700 dark:text-neutral-300 border-neutral-200 dark:border-neutral-600',
    'gold' => 'bg-amber-100 dark:bg-amber-900/50 text-amber-700 dark:text-amber-300 border-amber-200 dark:border-amber-800',
    'platinum' => 'bg-primary-100 dark:bg-primary-900/50 text-primary-700 dark:text-primary-300 border-primary-200 dark:border-primary-800',
    default => 'bg-neutral-100 dark:bg-neutral-700 text-neutral-500 dark:text-neutral-400 border-neutral-200 dark:border-neutral-600'
};
$isExpired = $invitation->isTrialExpired();
$isTrial = $invitation->expires_at !== null && !$invitation->hasPremiumFeatures();
$daysLeft = $invitation->expires_at ? (int) max(0, now()->diffInDays($invitation->expires_at, false)) : null;
            @endphp
                <div
                    class="bg-white dark:bg-secondary-800 border rounded-2xl p-5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 {{ $isExpired ? 'border-red-200 dark:border-red-800 bg-red-50/50 dark:bg-red-900/10' : ($isTrial ? 'border-amber-200 dark:border-amber-800 bg-amber-50/50 dark:bg-amber-900/10' : 'border-neutral-200 dark:border-neutral-700') }}">
                    <div class="flex items-center gap-4">
                        <div
                            class="flex-shrink-0 w-10 h-10 rounded-xl flex items-center justify-center
                                                    {{ $isExpired ? 'bg-red-100 dark:bg-red-900/50 text-red-500' : ($isTrial ? 'bg-amber-100 dark:bg-amber-900/50 text-amber-500' : 'bg-primary-100 dark:bg-primary-900/50 text-primary') }}">
                            @if($isExpired)
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z" />
                                </svg>
                            @else
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            @endif
                        </div>
                        <div>
                            <div class="flex items-center gap-2">
                                <span class="font-heading text-base font-bold text-secondary-800 dark:text-neutral-100">Paket</span>
                                <span
                                    class="inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold uppercase tracking-wider {{ $tierBadgeColor }}">
                                    {{ $tierCode === 'free' ? 'Gratis' : $tierCode }}
                                </span>
                            </div>
                            <p class="text-sm text-neutral-500 dark:text-neutral-400 mt-0.5">
                                @if($isExpired)
                                    Undangan telah kedaluwarsa.
                                @elseif($invitation->expires_at)
                                    @if($isTrial)
                                        Masa percobaan tersisa <strong>{{ $daysLeft }} Hari</strong>.
                                    @else
                                        Aktif hingga <strong>{{ $invitation->expires_at->format('d F Y') }}</strong>
                                        @if($daysLeft !== null && $daysLeft > 0)
                                            ({{ $daysLeft }} Hari lagi)
                                        @endif
                                    @endif
                                @else
                                    Paket aktif tanpa batas waktu.
                                @endif
                            </p>
                        </div>
                    </div>
                    @if(!$isExpired && $tierCode === 'free')
                        <a href="{{ route('dashboard.checkout', ['invitation_id' => $invitation->id]) }}"
                            class="inline-flex items-center justify-center gap-2 w-full sm:w-auto px-4 py-2 text-sm font-semibold text-white bg-gradient-to-r from-primary to-primary-600 rounded-xl hover:shadow-md hover:scale-[1.02] active:scale-[0.98] transition-all flex-shrink-0">
                            Upgrade
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                            </svg>
                        </a>
                    @endif
                </div>
                
                {{-- Stats Cards --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div
                        class="bg-white dark:bg-secondary-800 rounded-2xl shadow-soft border overflow-hidden
                                                {{ $invitation->hasFeature('personal_link') ? 'border-neutral-100 dark:border-secondary-700' : 'border-amber-100 dark:border-amber-800 bg-amber-50/20 dark:bg-amber-900/10' }}">
                        <div class="p-5">
                            <div class="flex items-center justify-between mb-3">
                                <h3 class="text-sm font-semibold text-secondary-800 dark:text-neutral-100">Data Tamu</h3>
                                @if($invitation->hasFeature('personal_link'))
                                    <a href="{{ route('dashboard.invitations.guests.index', $invitation) }}"
                                        class="text-primary-600 dark:text-primary-400 hover:text-primary-700 dark:hover:text-primary-300 text-xs font-semibold">Kelola
                                        &rarr;</a>
                                @else
                                    <span
                                        class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold bg-amber-100 dark:bg-amber-900/50 text-amber-800 dark:text-amber-300">Gold</span>
                                @endif
                            </div>
                            <div class="text-3xl font-bold text-secondary-800 dark:text-neutral-100">{{ $invitation->guests->count() }}
                            </div>
                            <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-1">Total tamu yang diundang</p>
                            @if(!$invitation->hasFeature('personal_link'))
                                <div class="mt-3">
                                    <a href="{{ route('dashboard.checkout', ['invitation_id' => $invitation->id]) }}"
                                        class="inline-flex items-center justify-center gap-2 w-full px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white rounded-xl text-sm font-semibold shadow-sm transition-all">
                                        Upgrade ke Gold
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                
                    <div
                        class="bg-white dark:bg-secondary-800 rounded-2xl shadow-soft border border-neutral-100 dark:border-secondary-700 p-5">
                        <div class="flex items-center justify-between mb-3">
                            <h3 class="text-sm font-semibold text-secondary-800 dark:text-neutral-100">RSVP / Konfirmasi</h3>
                            <span class="text-xs text-neutral-400 dark:text-neutral-500">Total: {{ $invitation->rsvps->sum('pax') }}
                                pax</span>
                        </div>
                        <div class="text-3xl font-bold text-green-600 dark:text-green-400">
                            {{ $invitation->rsvps->where('attendance', 'attending')->count() }}
                        </div>
                        <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-1">Tamu yang hadir</p>
                        @if($invitation->isRsvpPaxLimited())
                            @php
    $paxUsed = $invitation->totalAcceptedPax();
    $paxMax = $invitation->max_global_pax_quota;
    $paxPercent = $paxMax > 0 ? round(($paxUsed / $paxMax) * 100) : 0;
                            @endphp
                            <div class="mt-3">
                                <div class="flex items-center justify-between text-xs text-neutral-500 dark:text-neutral-400 mb-1">
                                    <span>Kuota Pax: {{ $paxUsed }} / {{ $paxMax }}</span>
                                    <span>{{ $paxPercent }}%</span>
                                </div>
                                <div class="w-full bg-neutral-100 dark:bg-secondary-700 rounded-full h-1.5">
                                    <div class="bg-primary-500 dark:bg-primary-400 h-1.5 rounded-full transition-all duration-500"
                                        style="width: {{ $paxPercent }}%">
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                
                    <div
                        class="bg-white dark:bg-secondary-800 rounded-2xl shadow-soft border border-neutral-100 dark:border-secondary-700 p-5">
                        <div class="flex items-center justify-between mb-3">
                            <h3 class="text-sm font-semibold text-secondary-800 dark:text-neutral-100">Buku Tamu</h3>
                        </div>
                        <div class="text-3xl font-bold text-secondary-800 dark:text-neutral-100">{{ $invitation->wishes->count() }}
                        </div>
                        <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-1">Total ucapan dan doa</p>
                    </div>
                
                    <div
                        class="bg-white dark:bg-secondary-800 rounded-2xl shadow-soft border border-neutral-100 dark:border-secondary-700 p-5">
                        <div class="flex items-center justify-between mb-3">
                            <h3 class="text-sm font-semibold text-secondary-800 dark:text-neutral-100">Pengunjung</h3>
                        </div>
                        <div class="text-3xl font-bold text-primary dark:text-primary-400">{{ $totalUniques }}</div>
                        <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-1">Total pengunjung unik</p>
                    </div>
                </div>
                
                
                
                {{-- Visitor Chart --}}
                <div
                    class="bg-white dark:bg-secondary-800 rounded-2xl shadow-soft border border-neutral-100 dark:border-secondary-700 overflow-hidden">
                    <div class="p-5">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-sm font-semibold text-secondary-800 dark:text-neutral-100">Statistik Pengunjung (30 Hari
                                Terakhir)</h3>
                            <span class="text-xs text-neutral-500 dark:text-neutral-400">{{ $totalViews }} total kunjungan</span>
                        </div>
                        <div class="relative" style="height: 260px;">
                            <canvas id="visitorChart" data-labels='@json($chartLabels)' data-totals='@json($chartTotals)'
                                data-uniques='@json($chartUniques)'></canvas>
                        </div>
                    </div>
                </div>
                
                {{-- QR RSVP Universal --}}
                <div
                    class="bg-white dark:bg-secondary-800 rounded-2xl shadow-soft border overflow-hidden
                                            {{ $invitation->hasFeature('qr_rsvp_universal') ? 'border-neutral-100 dark:border-secondary-700' : 'border-amber-100 dark:border-amber-800 bg-amber-50/20 dark:bg-amber-900/10' }}">
                    <div class="p-5">
                        @if($invitation->hasFeature('qr_rsvp_universal'))
                            <div class="flex items-center gap-3 mb-3">
                                <div
                                    class="w-9 h-9 rounded-xl bg-primary-50 dark:bg-primary-900/50 flex items-center justify-center text-primary dark:text-primary-400">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-sm font-semibold text-secondary-800 dark:text-neutral-100">QR RSVP Universal</h3>
                                    <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-0.5">Satu QR Code untuk semua tamu. Cetak
                                        pada kartu undangan fisik.</p>
                                </div>
                                <div class="ml-auto flex gap-2">
                                    <a href="{{ route('dashboard.invitations.qr-rsvp', $invitation) }}"
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-primary-700 dark:text-primary-300 bg-primary-50 dark:bg-primary-900/50 rounded-lg hover:bg-primary-100 dark:hover:bg-primary-900/70 transition whitespace-nowrap">
                                        Detail Laporan &rarr;
                                    </a>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div
                                    class="bg-neutral-50 dark:bg-secondary-700 rounded-xl border border-neutral-200 dark:border-secondary-600 p-4 flex flex-col items-center">
                                    <div
                                        class="bg-white p-2 rounded-lg shadow-sm border border-neutral-200 dark:border-neutral-600 inline-block">
                                <div class="w-28 h-28 flex items-center justify-center">
                                        <img src="{{ $qrCodeData }}" alt="QR Code" class="w-full h-full">
                                    </div>
                                    </div>
                                    <div class="mt-3 flex gap-2 w-full">
                                        <a href="{{ $qrCodeData }}"
                                            download="qrcode-{{ $invitation->slug }}.png"
                                            class="flex-1 text-center px-2 py-1.5 text-xs font-semibold text-white bg-gradient-to-r from-primary to-primary-600 rounded-lg hover:shadow-md transition">
                                            Download
                                        </a>
                                        <a href="{{ route('dashboard.invitations.qr-rsvp', $invitation) }}"
                                            class="flex-1 text-center px-2 py-1.5 text-xs font-semibold text-primary-700 dark:text-primary-300 bg-primary-50 dark:bg-primary-900/50 rounded-lg hover:bg-primary-100 dark:hover:bg-primary-900/70 transition">
                                            QR + Laporan
                                        </a>
                                    </div>
                                </div>

                                <div class="md:col-span-2 grid grid-cols-2 gap-3">
                                    <div
                                        class="bg-neutral-50 dark:bg-secondary-700 rounded-xl border border-neutral-200 dark:border-secondary-600 p-4">
                                        <p class="text-xs text-neutral-500 dark:text-neutral-400">Total PAX Hadir</p>
                                        <p class="text-2xl font-bold text-emerald-600 dark:text-emerald-400">
                                            {{ $qrStats['total_pax_hadir'] }}
                                        </p>
                                    </div>
                                    <div
                                        class="bg-neutral-50 dark:bg-secondary-700 rounded-xl border border-neutral-200 dark:border-secondary-600 p-4">
                                        <p class="text-xs text-neutral-500 dark:text-neutral-400">Tamu Respon</p>
                                        <p class="text-2xl font-bold text-secondary-800 dark:text-neutral-100">
                                            {{ $qrStats['total_tamu_respon'] }}
                                        </p>
                                    </div>
                                    <div
                                        class="bg-neutral-50 dark:bg-secondary-700 rounded-xl border border-neutral-200 dark:border-secondary-600 p-4">
                                        <p class="text-xs text-neutral-500 dark:text-neutral-400">Hadir</p>
                                        <p class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $qrStats['tamu_hadir'] }}</p>
                                    </div>
                                    <div
                                        class="bg-neutral-50 dark:bg-secondary-700 rounded-xl border border-neutral-200 dark:border-secondary-600 p-4">
                                        <p class="text-xs text-neutral-500 dark:text-neutral-400">Tidak Hadir</p>
                                        <p class="text-2xl font-bold text-red-600 dark:text-red-400">{{ $qrStats['tamu_absen'] }}</p>
                                    </div>
                                    @if($qrStats['tamu_ragu'] > 0)
                                        <div
                                            class="bg-neutral-50 dark:bg-secondary-700 rounded-xl border border-neutral-200 dark:border-secondary-600 p-4">
                                            <p class="text-xs text-neutral-500 dark:text-neutral-400">Ragu</p>
                                            <p class="text-2xl font-bold text-amber-600 dark:text-amber-400">{{ $qrStats['tamu_ragu'] }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            {{-- RSVP Terbaru --}}
                            <div class="mt-6 border-t border-neutral-200 dark:border-secondary-600 pt-6">
                                <h3 class="text-sm font-semibold text-secondary-800 dark:text-neutral-100 mb-4">RSVP Terbaru</h3>
                                @if($invitation->rsvps->isEmpty())
                                    <p class="text-neutral-500 dark:text-neutral-400 text-center py-4 text-sm">Belum ada konfirmasi kehadiran
                                        dari tamu.</p>
                                @else
                                    <div x-data="{
                                                                                search: '',
                                                                                perPage: 10,
                                                                                rsvps: {{ Js::from($rsvpData) }},
                                                                                get filteredRsvps() {
                                                                                    if (! this.search) return this.rsvps;
                                                                                    const q = this.search.toLowerCase();
                                                                                    return this.rsvps.filter(r => r.guest_name.toLowerCase().includes(q));
                                                                                },
                                                                                get displayRsvps() {
                                                                                    const limit = parseInt(this.perPage);
                                                                                    return limit === 0 ? this.filteredRsvps : this.filteredRsvps.slice(0, limit);
                                                                                },
                                                                                get totalFiltered() {
                                                                                    return this.filteredRsvps.length;
                                                                                }
                                                                            }">
                                        <div class="flex flex-col sm:flex-row gap-3 mb-4">
                                            <div class="relative flex-1">
                                                <input type="text" x-model="search" placeholder="Cari nama tamu..."
                                                    class="w-full px-4 py-2.5 pl-10 text-sm border border-neutral-200 dark:border-secondary-600 rounded-xl bg-white dark:bg-secondary-800 text-secondary-800 dark:text-neutral-100 focus:ring-2 focus:ring-primary-500 focus:border-transparent placeholder-neutral-400 dark:placeholder-neutral-500">
                                                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-neutral-400" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                                </svg>
                                            </div>
                                            <select x-model="perPage"
                                                class="px-3 py-2.5 text-sm border border-neutral-200 dark:border-secondary-600 rounded-xl bg-white dark:bg-secondary-800 text-secondary-800 dark:text-neutral-100 focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                                                <option value="10">10 data</option>
                                                <option value="20">20 data</option>
                                                <option value="0">Semua</option>
                                            </select>
                                        </div>

                                        <div class="overflow-x-auto">
                                            <table class="min-w-full divide-y divide-neutral-200 dark:divide-secondary-700">
                                                <thead class="bg-neutral-50 dark:bg-secondary-700">
                                                    <tr>
                                                        <th scope="col"
                                                            class="px-6 py-3 text-left text-xs font-semibold text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                                                            Nama Tamu</th>
                                                        <th scope="col"
                                                            class="px-6 py-3 text-left text-xs font-semibold text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                                                            Kehadiran</th>
                                                        <th scope="col"
                                                            class="px-6 py-3 text-left text-xs font-semibold text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                                                            Jumlah (Pax)</th>
                                                        <th scope="col"
                                                            class="px-6 py-3 text-left text-xs font-semibold text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                                                            Waktu</th>
                                                        <th scope="col"
                                                            class="px-6 py-3 text-left text-xs font-semibold text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                                                            Terakhir Diupdate</th>
                                                    </tr>
                                                </thead>
                                                <tbody
                                                    class="bg-white dark:bg-secondary-800 divide-y divide-neutral-100 dark:divide-secondary-700">
                                                    <template x-for="rsvp in displayRsvps" :key="rsvp.id">
                                                        <tr class="hover:bg-neutral-50 dark:hover:bg-secondary-700 transition-colors">
                                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-secondary-800 dark:text-neutral-100"
                                                                x-text="rsvp.guest_name"></td>
                                                            <td class="px-6 py-4 whitespace-nowrap">
                                                                <span
                                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold"
                                                                    :class="{
                                                                                                                'bg-green-100 dark:bg-green-900/50 text-green-700 dark:text-green-300': rsvp.attendance === 'attending',
                                                                                                                'bg-red-100 dark:bg-red-900/50 text-red-700 dark:text-red-300': rsvp.attendance === 'not_attending',
                                                                                                                'bg-amber-100 dark:bg-amber-900/50 text-amber-700 dark:text-amber-300': rsvp.attendance === 'uncertain'
                                                                                                            }" x-text="rsvp.attendance_label">
                                                                </span>
                                                            </td>
                                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-600 dark:text-neutral-400"
                                                                x-text="rsvp.pax"></td>
                                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-500 dark:text-neutral-400"
                                                                x-text="rsvp.created_at"></td>
                                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-500 dark:text-neutral-400"
                                                                x-text="rsvp.updated_at"></td>
                                                        </tr>
                                                    </template>
                                                </tbody>
                                            </table>
                                            <div x-show="totalFiltered === 0"
                                                class="text-center py-6 text-sm text-neutral-500 dark:text-neutral-400">
                                                Tidak ada tamu yang cocok dengan pencarian "<span x-text="search"></span>".
                                            </div>
                                            <div x-show="totalFiltered > 0"
                                                class="flex items-center justify-between pt-3 text-xs text-neutral-500 dark:text-neutral-400">
                                                <span>Menampilkan <span x-text="displayRsvps.length"></span> dari <span
                                                        x-text="totalFiltered"></span> data</span>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @else
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="flex-shrink-0 inline-flex items-center justify-center w-10 h-10 rounded-xl bg-amber-100 dark:bg-amber-900/20 text-amber-500 dark:text-amber-400">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-sm font-semibold text-secondary-800 dark:text-neutral-100 flex items-center gap-2">
                                            QR RSVP Universal
                                            <span
                                                class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold bg-amber-100 dark:bg-amber-900/50 text-amber-800 dark:text-amber-300">Gold</span>
                                        </h3>
                                        <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-0.5">Satu QR Code untuk semua tamu.
                                            Cetak pada kartu undangan fisik.</p>
                                    </div>
                                </div>
                                <a href="{{ route('dashboard.checkout', ['invitation_id' => $invitation->id]) }}"
                                    class="inline-flex items-center justify-center gap-2 w-full sm:w-auto px-5 py-2.5 bg-amber-500 hover:bg-amber-600 text-white rounded-xl text-sm font-semibold shadow-sm transition-all flex-shrink-0">
                                    Upgrade ke Gold
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
                
                {{-- QR Check-In Scanner --}}
                <div
                    class="bg-white dark:bg-secondary-800 rounded-2xl shadow-soft border overflow-hidden
                                            {{ $invitation->hasFeature('qr_checkin') ? 'border-emerald-100 dark:border-emerald-800' : 'border-amber-100 dark:border-amber-800 bg-amber-50/20 dark:bg-amber-900/10' }}">
                    <div class="p-5">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                            <div class="flex items-center gap-3">
                                <div
                                    class="flex-shrink-0 inline-flex items-center justify-center w-10 h-10 rounded-xl
                                                            {{ $invitation->hasFeature('qr_checkin') ? 'bg-emerald-100 dark:bg-emerald-900/20 text-emerald-600 dark:text-emerald-400' : 'bg-amber-100 dark:bg-amber-900/20 text-amber-500 dark:text-amber-400' }}">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 3.5a.5.5 0 11-1 0 .5.5 0 011 0zm-7.5 0a.5.5 0 11-1 0 .5.5 0 011 0zm7.5-7.5a.5.5 0 11-1 0 .5.5 0 011 0zm-7.5 0a.5.5 0 11-1 0 .5.5 0 011 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-sm font-semibold text-secondary-800 dark:text-neutral-100 flex items-center gap-2">
                                        Scanner Kehadiran (QR Check-In)
                                        @if(!$invitation->hasFeature('qr_checkin'))
                                            <span
                                                class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold bg-amber-100 dark:bg-amber-900/50 text-amber-800 dark:text-amber-300">Platinum</span>
                                        @endif
                                    </h3>
                                    <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-0.5">
                                        @if($invitation->hasFeature('qr_checkin'))
                                            @php
    $checkedIn = $invitation->guests()->where('attendance_status', 'hadir')->count();
    $totalGuests = $invitation->guests()->count();
                                            @endphp
                                            <span class="font-semibold text-emerald-600 dark:text-emerald-400">{{ $checkedIn }}</span> /
                                            {{ $totalGuests }} tamu sudah check-in
                                        @else
                                            Scan QR Code tamu saat hari H dan cetak tiket kehadiran
                                        @endif
                                    </p>
                                </div>
                            </div>
                
                            @if($invitation->hasFeature('qr_checkin'))
                                <a href="{{ route('dashboard.invitations.guestbook', $invitation) }}"
                                    class="inline-flex items-center justify-center gap-2 w-full sm:w-auto px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-sm font-semibold shadow-sm transition-all">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    Buka Scanner
                                </a>
                            @else
                                <a href="{{ route('dashboard.checkout', ['invitation_id' => $invitation->id]) }}"
                                    class="inline-flex items-center justify-center gap-2 w-full sm:w-auto px-5 py-2.5 bg-amber-500 hover:bg-amber-600 text-white rounded-xl text-sm font-semibold shadow-sm transition-all">
                                    Upgrade ke Platinum
                                </a>
                            @endif
                        </div>
                
                        @if($invitation->hasFeature('qr_checkin') && $totalGuests > 0)
                            <div class="mt-4 w-full bg-neutral-100 dark:bg-secondary-700 rounded-full h-2">
                                <div class="bg-emerald-500 dark:bg-emerald-400 h-2 rounded-full transition-all duration-500"
                                    style="width: {{ $totalGuests > 0 ? round(($checkedIn / $totalGuests) * 100) : 0 }}%">
                                </div>
                            </div>
                            <p class="text-xs text-neutral-400 dark:text-neutral-500 mt-1 text-right">
                                {{ $totalGuests > 0 ? round(($checkedIn / $totalGuests) * 100) : 0 }}% kehadiran
                            </p>
                        @endif
                    </div>
                </div>
                
                {{-- Addons --}}
                <div class="bg-white dark:bg-secondary-800 rounded-2xl shadow-soft border border-neutral-100 dark:border-secondary-700 overflow-hidden">
                    <div class="p-5">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl bg-primary-50 dark:bg-primary-900/50 flex items-center justify-center text-primary dark:text-primary-400">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 00-1-1H4a2 2 0 110-4h1a1 1 0 001-1V7a1 1 0 011-1h3a1 1 0 001-1V4z" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-sm font-semibold text-secondary-800 dark:text-neutral-100">
                                        Add-On & Fitur Tambahan
                                    </h3>
                                    <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-0.5">
                                        {{ $invitation->addons->count() }} add-on terpasang
                                    </p>
                                </div>
                            </div>
                            <a href="{{ route('dashboard.invitations.addons.index', $invitation) }}"
                                class="inline-flex items-center justify-center gap-2 w-full sm:w-auto px-4 py-2 bg-primary-50 dark:bg-primary-900/50 text-primary-700 dark:text-primary-300 rounded-xl text-sm font-semibold hover:bg-primary-100 dark:hover:bg-primary-900/70 transition-all">
                                Kelola Add-On
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Wishes --}}
                <div
                    class="bg-white dark:bg-secondary-800 rounded-2xl shadow-soft border border-neutral-100 dark:border-secondary-700 overflow-hidden">
                    <div class="p-5">
                        <h3 class="text-sm font-semibold text-secondary-800 dark:text-neutral-100 mb-4">Pesan Para Tamu</h3>
                        @if($invitation->wishes->isEmpty())
                            <p class="text-neutral-500 dark:text-neutral-400 text-center py-4 text-sm">Belum ada ucapan dari tamu.</p>
                        @else
                            <div x-data="{
                                search: '',
                                perPage: 10,
                                wishes: {{ Js::from($wishesData) }},
                                get filteredWishes() {
                                    if (! this.search) return this.wishes;
                                    const q = this.search.toLowerCase();
                                    return this.wishes.filter(w => w.guest_name.toLowerCase().includes(q) || w.message.toLowerCase().includes(q));
                                },
                                get displayWishes() {
                                    const limit = parseInt(this.perPage);
                                    return limit === 0 ? this.filteredWishes : this.filteredWishes.slice(0, limit);
                                },
                                get totalFiltered() {
                                    return this.filteredWishes.length;
                                },
                                deleteWish(id) {
                                    Swal.fire({
                                        title: 'Hapus Ucapan?',
                                        text: 'Ucapan ini akan dihapus permanen.',
                                        icon: 'warning',
                                        showCancelButton: true,
                                        confirmButtonColor: '#d33',
                                        cancelButtonColor: '#3085d6',
                                        confirmButtonText: 'Ya, hapus!',
                                        cancelButtonText: 'Batal',
                                    }).then((result) => {
                                        if (! result.isConfirmed) return;
                                        const url = '{{ route('dashboard.invitations.wishes.destroy', ['invitation' => $invitation, 'wish' => '__ID__']) }}'.replace('__ID__', id);
                                        fetch(url, { method: 'DELETE', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } })
                                            .then(r => r.json())
                                            .then(data => {
                                                if (data.success) {
                                                    this.wishes = this.wishes.filter(w => w.id !== id);
                                                    Swal.fire({ icon: 'success', title: 'Berhasil!', text: data.message, timer: 1500, showConfirmButton: false });
                                                } else {
                                                    Swal.fire({ icon: 'error', title: 'Gagal!', text: 'Terjadi kesalahan. Silakan coba lagi.', timer: 2000, showConfirmButton: false });
                                                }
                                            });
                                    });
                                }
                            }">
                                <div class="flex flex-col sm:flex-row gap-3 mb-4">
                                    <div class="relative flex-1">
                                        <input type="text" x-model="search" placeholder="Cari nama atau pesan..."
                                            class="w-full px-4 py-2.5 pl-10 text-sm border border-neutral-200 dark:border-secondary-600 rounded-xl bg-white dark:bg-secondary-800 text-secondary-800 dark:text-neutral-100 focus:ring-2 focus:ring-primary-500 focus:border-transparent placeholder-neutral-400 dark:placeholder-neutral-500">
                                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-neutral-400" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                        </svg>
                                    </div>
                                    <select x-model="perPage"
                                        class="px-3 py-2.5 text-sm border border-neutral-200 dark:border-secondary-600 rounded-xl bg-white dark:bg-secondary-800 text-secondary-800 dark:text-neutral-100 focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                                        <option value="10">10 data</option>
                                        <option value="20">20 data</option>
                                        <option value="0">Semua</option>
                                    </select>
                                </div>

                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-neutral-200 dark:divide-secondary-700">
                                        <thead class="bg-neutral-50 dark:bg-secondary-700">
                                            <tr>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-semibold text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Nama Tamu</th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-semibold text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Pesan</th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-semibold text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Waktu</th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-right text-xs font-semibold text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody
                                            class="bg-white dark:bg-secondary-800 divide-y divide-neutral-100 dark:divide-secondary-700">
                                            <template x-for="wish in displayWishes" :key="wish.id">
                                                <tr class="hover:bg-neutral-50 dark:hover:bg-secondary-700 transition-colors">
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-secondary-800 dark:text-neutral-100"
                                                        x-text="wish.guest_name"></td>
                                                    <td class="px-6 py-4 text-sm text-neutral-600 dark:text-neutral-400 max-w-xs break-words"
                                                        x-text="wish.message"></td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-500 dark:text-neutral-400"
                                                        x-text="wish.created_at_diff"></td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                                        <button @click="deleteWish(wish.id)"
                                                            class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-semibold text-red-600 dark:text-red-400 bg-red-50 dark:bg-red-900/30 rounded-lg hover:bg-red-100 dark:hover:bg-red-900/50 transition">
                                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                            </svg>
                                                            Hapus
                                                        </button>
                                                    </td>
                                                </tr>
                                            </template>
                                        </tbody>
                                    </table>
                                    <div x-show="totalFiltered === 0"
                                        class="text-center py-6 text-sm text-neutral-500 dark:text-neutral-400">
                                        Tidak ada ucapan yang cocok dengan pencarian "<span x-text="search"></span>".
                                    </div>
                                    <div x-show="totalFiltered > 0"
                                        class="flex items-center justify-between pt-3 text-xs text-neutral-500 dark:text-neutral-400">
                                        <span>Menampilkan <span x-text="displayWishes.length"></span> dari <span
                                                x-text="totalFiltered"></span> data</span>
                                    </div>
                                </div>
                            </div>
                        @endif
                </div>
            </div>

            {{-- Gallery Upload Script --}}
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

                    dropzone.addEventListener('click', function () {
                        fileInput.click();
                    });

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
                        if (files.length > 0) {
                            selectedFiles = selectedFiles.concat(files);
                            updatePreview();
                        }
                    });

                    fileInput.addEventListener('change', function () {
                        const files = Array.from(this.files);
                        if (files.length > 0) {
                            selectedFiles = selectedFiles.concat(files);
                            updatePreview();
                        }
                        this.value = '';
                    });

                    if (changeFilesBtn) {
                        changeFilesBtn.addEventListener('click', function (e) {
                            e.stopPropagation();
                            fileInput.click();
                        });
                    }

                    document.getElementById('gallery-upload-form').addEventListener('submit', function (e) {
                        if (selectedFiles.length === 0) {
                            e.preventDefault();
                            return;
                        }

                        const dataTransfer = new DataTransfer();
                        selectedFiles.forEach(f => dataTransfer.items.add(f));
                        fileInput.files = dataTransfer.files;
                    });
                });
            </script>

            {{-- Danger Zone --}}
            <div class="bg-red-50 dark:bg-red-900/20 rounded-2xl shadow-soft border border-red-200 dark:border-red-800 overflow-hidden">
                <div class="p-5">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-9 h-9 rounded-xl bg-red-100 dark:bg-red-900/50 flex items-center justify-center text-red-600 dark:text-red-400">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-semibold text-red-800 dark:text-red-300">Danger Zone</h3>
                            <p class="text-xs text-red-600 dark:text-red-400">Menghapus undangan akan menghapus semua data terkait. Tindakan ini tidak dapat dibatalkan.</p>
                        </div>
                    </div>

                    <form action="{{ route('dashboard.invitations.destroy', $invitation) }}" method="POST" onsubmit="return confirmSwal(event, 'Apakah Anda yakin ingin menghapus undangan ini secara permanen?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="inline-flex items-center justify-center gap-2 w-full sm:w-auto px-4 py-2 bg-red-600 text-white rounded-xl text-sm font-semibold hover:bg-red-700 hover:shadow-md transition-all">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Hapus Undangan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
