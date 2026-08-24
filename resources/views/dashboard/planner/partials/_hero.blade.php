{{-- ─── HERO ─── --}}
<div class="hero-mesh grain-overlay border-b border-neutral-200/60 dark:border-secondary-700/40">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-7 sm:py-8">

        {{-- Breadcrumb --}}
        <nav class="flex items-center gap-1.5 text-xs text-neutral-400 dark:text-neutral-500 mb-4">
            <a href="{{ route('dashboard') }}"
                class="hover:text-primary dark:hover:text-primary-400 transition-colors">Dashboard</a>
            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
            </svg>
            <span class="text-neutral-600 dark:text-neutral-400 font-medium">Wedding Planner</span>
        </nav>

        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
            <div>
                <h1
                    class="font-heading text-2xl sm:text-3xl font-bold text-secondary-800 dark:text-neutral-50 leading-tight">
                    Bikin Rencana Nikah Jadi Asyik & Tanpa Ribet
                </h1>
                <p class="text-sm text-neutral-500 dark:text-neutral-400 mt-1">
                    Kelola 8 pilar persiapan pernikahan dari H-12 bulan hingga Hari H.
                </p>
            </div>
            <div class="flex flex-wrap items-center gap-2 flex-shrink-0">
                <a href="{{ route('dashboard.planner.export-pdf') }}"
                    class="inline-flex items-center gap-1.5 px-3.5 py-2 text-xs font-semibold text-white bg-red-600 hover:bg-red-700 rounded-xl shadow-sm shadow-red-500/20 transition-all">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Export PDF Rundown & Budget
                </a>
            </div>
        </div>

        {{-- ─── COUNTDOWN MENUJU HARI H (dari tanggal undangan) ─── --}}
        @if($weddingDate)
            @php
                $daysLeft = (int) now()->startOfDay()->diffInDays($weddingDate->copy()->startOfDay(), false);
                $isPast = $daysLeft < 0;
                $weddingTime = $firstEvent?->start_time ?? $invitation?->event_time;
            @endphp
            <div
                class="mt-6 rounded-3xl border border-neutral-200/80 bg-white/90 p-5 sm:p-6 text-secondary-800 shadow-[0_18px_45px_-24px_rgba(15,23,42,0.35)] backdrop-blur dark:border-secondary-700/70 dark:bg-secondary-800/90 dark:text-neutral-100 relative overflow-hidden">
                <div
                    class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(15,23,42,0.04),transparent_60%)] dark:bg-[radial-gradient(circle_at_top_right,rgba(255,255,255,0.05),transparent_60%)]">
                </div>
                <div class="relative z-10 flex flex-col sm:flex-row sm:items-center gap-4 sm:gap-6">
                    <div class="min-w-0">
                        <p class="text-xs uppercase tracking-[0.28em] text-primary/80 dark:text-primary-300 font-semibold">
                            Countdown Menuju
                            Hari H</p>
                        <h4 class="font-heading text-lg sm:text-xl font-bold mt-1 text-secondary-900 dark:text-white">
                            {{ $weddingDate->translatedFormat('l, d F Y') }}
                            @if($weddingTime)
                                <span class="text-secondary-600 dark:text-neutral-300 text-sm font-medium">•
                                    {{ \Carbon\Carbon::parse($weddingTime)->format('H:i') }}</span>
                            @endif
                        </h4>
                        @if($invitation)
                            <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-0.5 truncate">Undangan:
                                {{ $invitation->title }}
                            </p>
                        @endif
                    </div>
                    <div class="flex-shrink-0">
                        @if($isPast)
                            <div
                                class="flex items-center gap-2 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-700 dark:border-emerald-800/50 dark:bg-emerald-950/30 dark:text-emerald-300">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <span class="text-sm font-semibold">Acara telah dilaksanakan</span>
                            </div>
                        @else
                            <div class="grid grid-cols-4 gap-2 sm:gap-3"
                                x-data="plannerCountdown('{{ $weddingDate->format('Y-m-d') }}', '{{ $weddingTime ?? '' }}')">
                                <template x-if="initialized">
                                    <template
                                        x-for="unit in [
                                                                                                                                                                                                { label: 'Hari', value: days },
                                                                                                                                                                                                { label: 'Jam', value: hours },
                                                                                                                                                                                                { label: 'Menit', value: minutes },
                                                                                                                                                                                                { label: 'Detik', value: seconds },
                                                                                                                                                                                            ]"
                                        :key="unit.label">
                                        <div
                                            class="rounded-2xl border border-neutral-200 bg-white/80 px-2 py-2.5 text-center shadow-sm dark:border-secondary-700 dark:bg-secondary-900/70 min-w-[64px]">
                                            <p class="text-xl sm:text-2xl font-extrabold tabular-nums leading-none text-secondary-900 dark:text-white"
                                                x-text="String(unit.value).padStart(2, '0')"></p>
                                            <p class="text-[10px] uppercase tracking-wider text-neutral-500 dark:text-neutral-400 mt-1"
                                                x-text="unit.label"></p>
                                        </div>
                                    </template>
                                </template>
                                <template x-if="!initialized">
                                    <div
                                        class="col-span-4 flex items-center gap-2 rounded-2xl border border-neutral-200 bg-white/80 px-4 py-3 text-sm font-semibold text-secondary-700 shadow-sm dark:border-secondary-700 dark:bg-secondary-900/70 dark:text-neutral-200">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7" />
                                        </svg>
                                        Hari H telah tiba
                                    </div>
                                </template>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>