<x-app-layout>
    <div class="min-h-screen">

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
                                <p
                                    class="text-xs uppercase tracking-[0.28em] text-primary/80 dark:text-primary-300 font-semibold">
                                    Countdown Menuju
                                    Hari H</p>
                                <h4
                                    class="font-heading text-lg sm:text-xl font-bold mt-1 text-secondary-900 dark:text-white">
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
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7" />
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

        {{-- ─── MAIN CONTENT ─── --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-7 sm:py-8 space-y-6">

            @if(session('success'))
                <div
                    class="rounded-2xl border border-emerald-200 bg-emerald-50 dark:bg-emerald-950/30 dark:border-emerald-800/50 px-4 py-3 text-sm text-emerald-800 dark:text-emerald-300 flex items-center gap-2">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            {{-- ── Financial Overview Cards ── --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 sm:gap-4">
                <div
                    class="rounded-3xl border border-neutral-200/80 bg-white p-4 shadow-[0_16px_40px_-24px_rgba(15,23,42,0.25)] dark:border-secondary-700/70 dark:bg-secondary-800/80 sm:p-5">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <p
                                class="text-[11px] sm:text-xs font-semibold uppercase tracking-[0.2em] text-primary/80 dark:text-primary-300">
                                Total Estimasi Anggaran</p>
                            <p
                                class="mt-2 text-xl font-bold text-secondary-900 tabular-nums dark:text-white sm:text-2xl">
                                Rp
                                {{ number_format($totalEstimated, 0, ',', '.') }}
                            </p>
                        </div>
                        <div
                            class="rounded-2xl bg-primary/10 p-2.5 text-primary dark:bg-primary-500/10 dark:text-primary-300">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                    d="M12 8c-1.657 0-3 1.343-3 3v1h6v-1c0-1.657-1.343-3-3-3zm-4 4h8m-8 0v4m8-4v4M6 20h12a2 2 0 002-2V8a2 2 0 00-2-2H6a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                    </div>
                    <p class="mt-3 text-[11px] sm:text-xs text-neutral-500 dark:text-neutral-400">
                        {{ $itemsByCategory['BUDGET']->count() + $itemsByCategory['VENDOR']->count() + $itemsByCategory['SESERAHAN']->count() + $itemsByCategory['ENGAGEMENT']->count() + $itemsByCategory['PRE_WEDDING']->count() }}
                        item tercatat
                    </p>
                </div>
                <div
                    class="rounded-3xl border border-neutral-200/80 bg-white p-4 shadow-[0_16px_40px_-24px_rgba(15,23,42,0.25)] dark:border-secondary-700/70 dark:bg-secondary-800/80 sm:p-5">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <p
                                class="text-[11px] sm:text-xs font-semibold uppercase tracking-[0.2em] text-emerald-600 dark:text-emerald-400">
                                Total Terbayar (DP/Lunas)</p>
                            <p
                                class="mt-2 text-xl font-bold text-secondary-900 tabular-nums dark:text-white sm:text-2xl">
                                Rp
                                {{ number_format($totalPaid, 0, ',', '.') }}
                            </p>
                        </div>
                        <div
                            class="rounded-2xl bg-emerald-50 p-2.5 text-emerald-600 dark:bg-emerald-900/30 dark:text-emerald-400">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                    </div>
                    <p class="mt-3 text-[11px] sm:text-xs text-neutral-500 dark:text-neutral-400">
                        Pembayaran yang sudah masuk ke sistem
                    </p>
                </div>
                <div
                    class="rounded-3xl border border-neutral-200/80 bg-white p-4 shadow-[0_16px_40px_-24px_rgba(15,23,42,0.25)] dark:border-secondary-700/70 dark:bg-secondary-800/80 sm:p-5">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <p
                                class="text-[11px] sm:text-xs font-semibold uppercase tracking-[0.2em] text-amber-600 dark:text-amber-400">
                                Sisa Tagihan Vendor</p>
                            <p
                                class="mt-2 text-xl font-bold text-secondary-900 tabular-nums dark:text-white sm:text-2xl">
                                Rp
                                {{ number_format($vendorTotalRemaining, 0, ',', '.') }}
                            </p>
                        </div>
                        <div
                            class="rounded-2xl bg-amber-50 p-2.5 text-amber-600 dark:bg-amber-900/30 dark:text-amber-400">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                    d="M12 8v8m0 0l-3-3m3 3l3-3M4 12a8 8 0 1116 0 8 8 0 01-16 0z" />
                            </svg>
                        </div>
                    </div>
                    <p class="mt-3 text-[11px] sm:text-xs text-neutral-500 dark:text-neutral-400">
                        Nilai tagihan yang belum terbayarkan
                    </p>
                </div>
            </div>

            {{-- ── Rundown Hari H ── --}}
            <div
                class="overflow-hidden rounded-3xl border border-neutral-200/80 bg-white shadow-[0_16px_40px_-24px_rgba(15,23,42,0.25)] dark:border-secondary-700/70 dark:bg-secondary-800">
                <div
                    class="flex items-center justify-between gap-3 border-b border-neutral-200/80 px-4 py-3 sm:px-5 sm:py-4 dark:border-secondary-700/60">
                    <div class="flex items-center gap-3">
                        <div
                            class="rounded-2xl bg-primary/10 p-2 text-primary dark:bg-primary-500/10 dark:text-primary-300">
                            <svg class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                    d="M12 6v6l4 2m-4-8a9 9 0 100 18 9 9 0 000-18z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-semibold text-secondary-800 dark:text-neutral-100 sm:text-base">
                                Rundown
                                Acara Hari H</h3>
                            <p class="mt-0.5 text-[11px] text-neutral-500 dark:text-neutral-400 sm:text-xs">Time
                                schedule
                                kegiatan ditampilkan secara kronologis.</p>
                        </div>
                    </div>
                    <button type="button" x-data @click="$dispatch('open-modal', 'add-rundown')"
                        class="inline-flex items-center gap-1.5 rounded-xl border border-neutral-200 bg-white px-2.5 py-1.5 text-[11px] font-semibold text-secondary-700 transition-all hover:border-primary/20 hover:text-primary dark:border-secondary-600 dark:bg-secondary-700 dark:text-neutral-100 dark:hover:border-primary/30 dark:hover:text-primary-300 sm:px-3">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        <span class="hidden sm:inline">Tambah </span>Rundown
                    </button>
                </div>

                @if($rundowns->isEmpty())
                    <div class="px-5 py-10 text-center">
                        <div
                            class="mx-auto flex h-12 w-12 items-center justify-center rounded-2xl bg-neutral-100 text-neutral-400 dark:bg-secondary-700/60 dark:text-neutral-500">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                    d="M12 6v6l4 2m-4-8a9 9 0 100 18 9 9 0 000-18z" />
                            </svg>
                        </div>
                        <p class="mt-3 text-sm font-semibold text-secondary-800 dark:text-neutral-100">Belum ada rundown</p>
                        <p class="mt-1 text-sm text-neutral-400 dark:text-neutral-500">Tambahkan jadwal kegiatan Hari H
                            untuk memudahkan koordinasi.</p>
                    </div>
                @else
                    <div class="p-4 space-y-3">
                        @foreach($rundowns as $index => $rundown)
                            <div
                                class="group relative flex items-stretch rounded-2xl border border-neutral-200/80 bg-neutral-50/70 shadow-sm transition-all duration-200 hover:border-primary/40 hover:bg-primary-50/30 dark:border-secondary-600/50 dark:bg-secondary-700/30 dark:hover:border-primary/40 dark:hover:bg-primary-900/10">
                                <div
                                    class="flex min-w-[72px] items-center justify-center rounded-l-2xl border-r border-neutral-200/80 bg-white/80 px-2.5 py-3 text-center dark:border-secondary-600/50 dark:bg-secondary-800/70 sm:min-w-[96px] sm:px-3">
                                    <div>
                                        <p
                                            class="text-sm font-bold text-secondary-800 dark:text-neutral-100 tabular-nums leading-tight">
                                            {{ $rundown->time_start->format('H:i') }}
                                        </p>
                                        @if($rundown->time_end)
                                            <p class="mt-0.5 text-[10px] text-neutral-400 dark:text-neutral-500 tabular-nums">s.d.
                                                {{ $rundown->time_end->format('H:i') }}
                                            </p>
                                        @endif
                                    </div>
                                </div>

                                <div class="flex-1 px-4 py-3 min-w-0">
                                    <div class="flex items-start justify-between gap-2">
                                        <div class="min-w-0">
                                            <p class="text-sm font-semibold text-secondary-800 dark:text-neutral-100">
                                                {{ $rundown->activity_name }}
                                            </p>
                                            <div class="mt-1 flex flex-wrap items-center gap-2">
                                                @if($rundown->person_in_charge)
                                                    <span
                                                        class="inline-flex items-center gap-1 text-[11px] text-neutral-500 dark:text-neutral-400">
                                                        <svg class="w-3 h-3 shrink-0" fill="none" viewBox="0 0 24 24"
                                                            stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                        </svg>
                                                        {{ $rundown->person_in_charge }}
                                                    </span>
                                                @endif
                                                @if($rundown->notes)
                                                    <span
                                                        class="inline-flex items-center gap-1 text-[11px] text-neutral-400 dark:text-neutral-500 truncate max-w-[180px]">
                                                        <svg class="w-3 h-3 shrink-0" fill="none" viewBox="0 0 24 24"
                                                            stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                                                        </svg>
                                                        {{ $rundown->notes }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div
                                            class="flex items-center gap-1 shrink-0 sm:opacity-0 sm:group-hover:opacity-100 sm:focus-within:opacity-100 transition-opacity duration-150">
                                            <button type="button" x-data
                                                @click="$dispatch('open-modal', 'edit-rundown-{{ $rundown->id }}')"
                                                class="rounded-lg p-1.5 text-neutral-400 transition-colors hover:bg-primary-50 hover:text-primary dark:hover:bg-primary-900/20 dark:hover:text-primary-400">
                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </button>
                                            <form action="{{ route('dashboard.planner.rundowns.destroy', $rundown) }}"
                                                method="POST" onsubmit="return confirm('Hapus rundown ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="rounded-lg p-1.5 text-neutral-400 transition-colors hover:bg-red-50 hover:text-red-600 dark:hover:bg-red-900/20 dark:hover:text-red-400">
                                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"
                                                        stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <div
                                    class="absolute left-[68px] sm:left-24 top-1/2 -translate-y-1/2 -translate-x-1/2 h-2.5 w-2.5 rounded-full border-2 border-white bg-primary opacity-0 transition-opacity duration-200 group-hover:opacity-100 dark:border-secondary-800">
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- ── 8 Pilar Modul Tabs ── --}}
            @php
                $pillars = [
                    ['key' => 'CALENDAR', 'label' => 'Jadwal', 'color' => 'text-blue-600 dark:text-blue-400', 'bg' => 'bg-blue-100 dark:bg-blue-900/40'],
                    ['key' => 'CHECKLIST', 'label' => 'Checklist', 'color' => 'text-emerald-600 dark:text-emerald-400', 'bg' => 'bg-emerald-100 dark:bg-emerald-900/40'],
                    ['key' => 'ENGAGEMENT', 'label' => 'Lamaran', 'color' => 'text-pink-600 dark:text-pink-400', 'bg' => 'bg-pink-100 dark:bg-pink-900/40'],
                    ['key' => 'PRE_WEDDING', 'label' => 'Pre-Wedding', 'color' => 'text-violet-600 dark:text-violet-400', 'bg' => 'bg-violet-100 dark:bg-violet-900/40'],
                    ['key' => 'SESERAHAN', 'label' => 'Seserahan', 'color' => 'text-amber-600 dark:text-amber-400', 'bg' => 'bg-amber-100 dark:bg-amber-900/40'],
                    ['key' => 'ADMINISTRATION', 'label' => 'Administrasi', 'color' => 'text-cyan-600 dark:text-cyan-400', 'bg' => 'bg-cyan-100 dark:bg-cyan-900/40'],
                    ['key' => 'BUDGET', 'label' => 'Budget', 'color' => 'text-green-600 dark:text-green-400', 'bg' => 'bg-green-100 dark:bg-green-900/40'],
                    ['key' => 'VENDOR', 'label' => 'Vendor', 'color' => 'text-orange-600 dark:text-orange-400', 'bg' => 'bg-orange-100 dark:bg-orange-900/40'],
                ];

                $statusStyles = [
                    'PENDING' => 'bg-neutral-100 text-neutral-600 dark:bg-neutral-700 dark:text-neutral-300',
                    'IN_PROGRESS' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/50 dark:text-blue-300',
                    'COMPLETED' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/50 dark:text-emerald-300',
                    'CANCELLED' => 'bg-red-100 text-red-700 dark:bg-red-900/50 dark:text-red-300',
                ];

                $statusLabels = [
                    'PENDING' => 'Pending',
                    'IN_PROGRESS' => 'Proses',
                    'COMPLETED' => 'Selesai',
                    'CANCELLED' => 'Batal',
                ];

                $statusOptions = [
                    'PENDING',
                    'IN_PROGRESS',
                    'COMPLETED',
                    'CANCELLED',
                ];

                $adminChecklists = $checklists->where('category_code', 'ADMINISTRATION');
                $adminTotalItems = $adminChecklists->sum(fn($item) => $item->checkboxCount());
                $adminCompletedItems = $adminChecklists->sum(fn($item) => $item->completedCheckboxCount());
            @endphp

            <div x-data="{
                activeTab: localStorage.getItem('plannerActiveTab') || '{{ $pillars[0]['key'] }}',
                init() {
                    this.$nextTick(() => this.scrollTabIntoView(this.activeTab, false));
                },
                setActiveTab(key) {
                    this.activeTab = key;
                    localStorage.setItem('plannerActiveTab', key);
                    this.$nextTick(() => this.scrollTabIntoView(key, true));
                },
                scrollTabIntoView(key, smooth) {
                    const container = this.$refs.tabs;
                    if (!container || container.scrollWidth <= container.clientWidth) return;
                    const btn = Array.from(container.children).find((el) => el.dataset.tab === key);
                    if (btn) {
                        container.scrollTo({
                            left: Math.max(0, btn.offsetLeft - (container.clientWidth / 2) + (btn.offsetWidth / 2)),
                            behavior: smooth ? 'smooth' : 'auto',
                        });
                    }
                }
            }"
                class="overflow-hidden rounded-3xl border border-neutral-200/80 bg-white shadow-[0_16px_40px_-24px_rgba(15,23,42,0.25)] dark:border-secondary-700/70 dark:bg-secondary-800">
                {{-- Tabs --}}
                <div x-ref="tabs"
                    class="flex overflow-x-auto gap-1.5 border-b border-neutral-200/80 bg-neutral-50/70 px-2 py-2 scrollbar-hide dark:border-secondary-700/60 dark:bg-secondary-700/40">
                    @foreach($pillars as $pillar)
                        <button type="button" @click="setActiveTab('{{ $pillar['key'] }}')"
                            data-tab="{{ $pillar['key'] }}"
                            class="flex-shrink-0 whitespace-nowrap rounded-xl border px-3 py-2.5 text-xs font-medium transition-all sm:px-4 sm:text-sm"
                            :class="activeTab === '{{ $pillar['key'] }}'
                                                                                                ? 'border-primary/20 bg-white text-primary shadow-sm dark:border-primary-400/30 dark:bg-secondary-800 dark:text-primary-300'
                                                                                                : 'border-transparent text-neutral-500 hover:bg-white/80 hover:text-secondary-800 dark:text-neutral-400 dark:hover:bg-secondary-700/70 dark:hover:text-neutral-100'">
                            {{ $pillar['label'] }}
                            <span
                                class="ml-1 sm:ml-1.5 inline-flex items-center rounded-full px-1 py-0.5 text-[9px] font-bold sm:px-1.5 sm:text-[10px] {{ $pillar['bg'] }} {{ $pillar['color'] }}">
                                @if($pillar['key'] === 'CHECKLIST')
                                    {{ $checklistCompletedItems }}/{{ $checklistTotalItems }}
                                @elseif($pillar['key'] === 'ADMINISTRATION')
                                    {{ $adminCompletedItems }}/{{ $adminTotalItems }}
                                @else
                                    {{ $itemsByCategory[$pillar['key']]->count() }}
                                @endif
                            </span>
                        </button>
                    @endforeach
                </div>

                {{-- Tab Panels --}}
                <div x-data="plannerChecklist()">
                    @foreach($pillars as $pillar)
                        <div x-show="activeTab === '{{ $pillar['key'] }}'" x-cloak class="p-5">
                            @if($pillar['key'] === 'CALENDAR')

                                {{-- ─── KALENDER BULANAN ─── --}}
                                <div class="mb-4">
                                    <h3 class="font-semibold text-secondary-800 dark:text-neutral-100">Kalender Bulanan</h3>
                                    <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-0.5">Kalender referensi bulanan
                                        menuju Hari H.</p>
                                </div>

                                <div x-data="plannerCalendar()"
                                    class="rounded-2xl border border-neutral-200/80 dark:border-secondary-700/60 overflow-hidden shadow-sm">
                                    {{-- Header --}}
                                    <div
                                        class="flex items-center justify-between gap-3 px-5 py-4 bg-gradient-to-r from-primary-600 to-primary-700 dark:from-primary-700 dark:to-primary-800">
                                        <button type="button" @click="prevMonth()"
                                            class="inline-flex items-center justify-center w-9 h-9 rounded-xl text-white/80 hover:bg-white/20 hover:text-white transition-all">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                    d="M15 19l-7-7 7-7" />
                                            </svg>
                                        </button>
                                        <div class="text-center flex-1">
                                            <p class="text-base font-bold text-white" x-text="monthLabel"></p>
                                            <p class="text-[11px] text-white/70 font-medium mt-0.5" x-text="weddingLabel">
                                            </p>
                                        </div>
                                        <button type="button" @click="nextMonth()"
                                            class="inline-flex items-center justify-center w-9 h-9 rounded-xl text-white/80 hover:bg-white/20 hover:text-white transition-all">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                    d="M9 5l7 7-7 7" />
                                            </svg>
                                        </button>
                                    </div>

                                    {{-- Weekday header --}}
                                    <div
                                        class="grid grid-cols-7 text-center text-[10px] font-bold uppercase tracking-wider text-neutral-400 dark:text-neutral-500 py-2.5 bg-neutral-50 dark:bg-secondary-700/40 border-b border-neutral-100 dark:border-secondary-700/50">
                                        <span>Min</span><span>Sen</span><span>Sel</span><span>Rab</span><span>Kam</span><span>Jum</span><span>Sab</span>
                                    </div>

                                    {{-- Days grid --}}
                                    <div class="grid grid-cols-7 gap-px bg-neutral-100 dark:bg-secondary-700/30">
                                        <template x-for="cell in cells" :key="cell.key">
                                            <button type="button"
                                                class="min-h-[52px] sm:min-h-[72px] bg-white dark:bg-secondary-800 p-1 sm:p-1.5 flex flex-col transition-all hover:bg-primary-50 dark:hover:bg-primary-900/20 cursor-pointer text-left"
                                                :class="cell.isOutside ? 'opacity-30 pointer-events-none' : ''"
                                                @click="!cell.isOutside && addEventToDate(cell.key)">
                                                <div class="flex items-center justify-between">
                                                    <span class="text-[10px] sm:text-[11px] font-semibold tabular-nums"
                                                        :class="cell.isToday ? 'w-5 h-5 sm:w-6 sm:h-6 flex items-center justify-center rounded-full bg-primary text-white text-[9px] sm:text-[10px] shadow-sm shadow-primary/30' : (cell.isWedding ? 'w-5 h-5 sm:w-6 sm:h-6 flex items-center justify-center rounded-full bg-amber-500 text-white text-[9px] sm:text-[10px] shadow-sm shadow-amber-500/30' : 'text-secondary-700 dark:text-neutral-300')"
                                                        x-text="cell.day"></span>
                                                    <template x-if="cell.isWedding">
                                                        <svg class="w-2.5 h-2.5 sm:w-3 sm:h-3 text-amber-500"
                                                            fill="currentColor" viewBox="0 0 20 20">
                                                            <path
                                                                d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
                                                        </svg>
                                                    </template>
                                                    <template x-if="cell.hasEvent && !cell.isWedding">
                                                        <span
                                                            class="w-1 h-1 sm:w-1.5 sm:h-1.5 rounded-full bg-emerald-500"></span>
                                                    </template>
                                                </div>
                                            </button>
                                        </template>
                                    </div>
                                </div>

                                @if($weddingDate)
                                    <div
                                        class="mt-4 flex items-center gap-4 text-[11px] text-neutral-500 dark:text-neutral-400 flex-wrap">
                                        <span class="inline-flex items-center gap-1.5"><span
                                                class="w-2.5 h-2.5 rounded-full bg-amber-500 shadow-sm shadow-amber-500/30"></span>
                                            Hari H</span>
                                        <span class="inline-flex items-center gap-1.5"><span
                                                class="w-2.5 h-2.5 rounded-full bg-primary shadow-sm shadow-primary/30"></span> Hari
                                            ini</span>
                                        <span class="inline-flex items-center gap-1.5"><span
                                                class="w-2.5 h-2.5 rounded-full bg-emerald-500 shadow-sm shadow-emerald-500/30"></span>
                                            Ada event</span>
                                    </div>
                                @endif

                                {{-- Event List --}}
                                @php
                                    $calendarItems = $itemsByCategory['CALENDAR']->sortBy('event_date');
                                @endphp
                                @if($calendarItems->isNotEmpty())
                                    <div class="mt-5">
                                        <h4
                                            class="text-xs font-bold uppercase tracking-wider text-neutral-400 dark:text-neutral-500 mb-3">
                                            Jadwal Event</h4>
                                        <div class="space-y-2">
                                            @foreach($calendarItems as $event)
                                                <div
                                                    class="group flex items-center gap-3 p-3 rounded-xl border border-neutral-200/70 dark:border-secondary-700/50 bg-white dark:bg-secondary-800 hover:border-primary/30 dark:hover:border-primary/30 transition-all">
                                                    <div
                                                        class="flex-shrink-0 w-10 h-10 rounded-lg bg-primary-50 dark:bg-primary-900/30 flex flex-col items-center justify-center">
                                                        <span
                                                            class="text-[10px] font-bold text-primary-600 dark:text-primary-400 leading-none">{{ $event->event_date?->format('d') }}</span>
                                                        <span
                                                            class="text-[8px] font-semibold text-primary-400 dark:text-primary-500 uppercase">{{ $event->event_date?->format('M') }}</span>
                                                    </div>
                                                    <div class="flex-1 min-w-0">
                                                        <p
                                                            class="text-sm font-medium text-secondary-800 dark:text-neutral-100 truncate">
                                                            {{ $event->title }}
                                                        </p>
                                                        @if($event->description)
                                                            <p class="text-[11px] text-neutral-400 dark:text-neutral-500 truncate">
                                                                {{ $event->description }}
                                                            </p>
                                                        @endif
                                                    </div>
                                                    <span
                                                        class="inline-flex items-center px-1.5 py-0.5 rounded text-[9px] font-bold
                                                                                                                                                                                                                                                                                @if($event->status === 'COMPLETED') bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-400
                                                                                                                                                                                                                                                                                @elseif($event->status === 'IN_PROGRESS') bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-400
                                                                                                                                                                                                                                                                                @elseif($event->status === 'CANCELLED') bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-400
                                                                                                                                                                                                                                                                                @else bg-neutral-100 text-neutral-600 dark:bg-secondary-700 dark:text-neutral-400 @endif shrink-0">
                                                        {{ $statusLabels[$event->status] ?? $event->status }}
                                                    </span>
                                                    <div
                                                        class="flex items-center gap-0.5 shrink-0 sm:opacity-0 sm:group-hover:opacity-100 sm:focus-within:opacity-100 transition-opacity duration-150">
                                                        <button type="button" x-data
                                                            @click="$dispatch('open-modal', 'edit-item-{{ $event->id }}')"
                                                            class="p-1.5 rounded-lg text-neutral-400 hover:text-primary hover:bg-primary-50 dark:hover:bg-primary-900/20 transition-colors">
                                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"
                                                                stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                            </svg>
                                                        </button>
                                                        <form action="{{ route('dashboard.planner.items.destroy', $event) }}"
                                                            method="POST" class="inline"
                                                            onsubmit="event.stopPropagation(); return confirm('Hapus event ini?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="p-1.5 rounded-lg text-neutral-400 hover:text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
                                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"
                                                                    stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2"
                                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                                </svg>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                            @elseif($pillar['key'] === 'CHECKLIST')

                                {{-- ─── CHECKLIST INTERAKTIF (Interactive Wedding Checklist Planner) ─── --}}
                                @php
                                    $checklistCategories = collect(\App\Models\WeddingChecklist::CATEGORIES)
                                        ->reject(fn($label, $code) => $code === 'ADMINISTRATION')
                                        ->all();
                                @endphp

                                <div
                                    class="rounded-2xl border border-neutral-200/80 dark:border-secondary-700/60 bg-neutral-50/60 dark:bg-secondary-700/30 p-5 mb-6">
                                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                                        <div class="min-w-0">
                                            <p
                                                class="text-xs font-semibold uppercase tracking-[0.24em] text-primary dark:text-primary-400">
                                                Checklist Wedding Plan</p>
                                            <p class="mt-1 text-xs text-neutral-500 dark:text-neutral-400">Item persiapan per
                                                kategori.</p>
                                            <h3 class="mt-1 font-heading text-lg font-bold text-secondary-800 dark:text-neutral-100"
                                                x-text="progressPercent === 100 ? '🎉 Semua Ceklis Selesai!' : (completedItems > 0 ? 'Yuk lanjutkan ceklis!' : 'Yuk mulai ceklis!')">
                                            </h3>
                                            <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-1">
                                                <span x-text="completedItems"></span>/<span x-text="totalItems"></span> selesai
                                                ·
                                                {{ count($checklistCategories) }} kategori
                                            </p>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <button type="button" x-data @click="$dispatch('open-modal', 'add-checklist')"
                                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-primary hover:bg-primary-600 text-white text-xs font-semibold transition-all">
                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 4v16m8-8H4" />
                                                </svg>
                                                Tambah Data
                                            </button>
                                        </div>
                                    </div>
                                    <div class="mt-4">
                                        <div
                                            class="h-2.5 bg-neutral-200/80 dark:bg-secondary-700/60 rounded-full overflow-hidden">
                                            <div class="h-full bg-primary rounded-full transition-all duration-500"
                                                :style="'width:' + progressPercent + '%'"></div>
                                        </div>
                                        <p class="text-right text-xs font-bold text-primary dark:text-primary-400 mt-1 tabular-nums"
                                            x-text="progressPercent + '%'"></p>
                                    </div>
                                </div>

                                {{-- Empty State (PRD section 22) --}}
                                @if($checklistTotalItems === 0)
                                    <div
                                        class="rounded-3xl border border-dashed border-neutral-200 bg-neutral-50/70 px-5 py-10 text-center shadow-sm dark:border-secondary-600 dark:bg-secondary-800/50">
                                        <svg class="mx-auto h-10 w-10 text-neutral-300 dark:text-neutral-600" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                                        </svg>
                                        <p class="mt-3 text-sm font-semibold text-secondary-800 dark:text-neutral-100">Belum ada
                                            checklist.</p>
                                        <p class="mt-1 text-xs text-neutral-500 dark:text-neutral-400">Checklist persiapan
                                            pernikahan akan tersedia setelah invitation dibuat.</p>
                                    </div>
                                @else
                                    {{-- Category Groups --}}
                                    <div class="space-y-5">
                                        @foreach($checklistCategories as $code => $label)
                                            @php
                                                $items = $checklists->where('category_code', $code);
                                                $normalItems = $items->where('is_document', false);
                                            @endphp
                                            <div
                                                class="overflow-hidden rounded-2xl border border-neutral-200/80 bg-white shadow-sm dark:border-secondary-700/60 dark:bg-secondary-800/80">
                                                <div
                                                    class="flex items-center justify-between gap-3 border-b border-neutral-200/80 bg-neutral-50/90 px-4 py-3 dark:border-secondary-700/60 dark:bg-secondary-700/40">
                                                    <h4 class="text-sm font-semibold text-secondary-800 dark:text-neutral-100">
                                                        {{ $label }}
                                                    </h4>
                                                    <span
                                                        class="text-[11px] font-semibold text-neutral-500 dark:text-neutral-400 tabular-nums">
                                                        <span x-text="categoryCompleted('{{ $code }}')"></span> / <span
                                                            x-text="categoryTotal('{{ $code }}')"></span> selesai
                                                    </span>
                                                </div>
                                                <div class="h-1.5 bg-neutral-100 dark:bg-secondary-700/50">
                                                    <div class="h-full bg-emerald-500 dark:bg-emerald-400 transition-all duration-500"
                                                        :style="'width:' + categoryProgress('{{ $code }}') + '%'"></div>
                                                </div>

                                                @if($items->isEmpty())
                                                    <div class="px-4 py-8 text-center text-sm text-neutral-400 dark:text-neutral-500">
                                                        Belum ada checklist pada kategori ini.
                                                    </div>
                                                @else
                                                    @if($normalItems->isNotEmpty())
                                                        <ul class="divide-y divide-neutral-100 dark:divide-secondary-700/50">
                                                            @foreach($normalItems as $item)
                                                                <li
                                                                    class="flex items-center gap-3 px-4 py-3 transition-colors hover:bg-neutral-50/80 dark:hover:bg-secondary-700/30">
                                                                    <div
                                                                        class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-primary/10 text-primary dark:bg-primary-900/30 dark:text-primary-400">
                                                                        <input type="checkbox" :checked="items[{{ $item->id }}].completed"
                                                                            data-toggle-url="{{ route('dashboard.planner.checklists.toggle', $item) }}"
                                                                            @change="toggleItem({{ $item->id }}, $event)"
                                                                            class="h-4 w-4 cursor-pointer rounded border-neutral-300 text-primary focus:ring-primary-500 dark:border-neutral-600">
                                                                    </div>
                                                                    <div class="min-w-0 flex-1">
                                                                        <p class="text-sm font-medium text-secondary-800 dark:text-neutral-100"
                                                                            :class="items[{{ $item->id }}].completed ? 'line-through text-neutral-400 dark:text-neutral-500' : ''">
                                                                            {{ $item->title }}
                                                                        </p>
                                                                        @if($item->description)
                                                                            <p
                                                                                class="mt-0.5 line-clamp-2 text-xs text-neutral-400 dark:text-neutral-500">
                                                                                {{ $item->description }}
                                                                            </p>
                                                                        @endif
                                                                    </div>
                                                                    @if(!$item->is_preset)
                                                                        <div class="flex flex-shrink-0 items-center gap-1">
                                                                            <button type="button" x-data
                                                                                @click="$dispatch('open-modal', 'edit-checklist-{{ $item->id }}')"
                                                                                class="inline-flex items-center rounded-lg px-2.5 py-1.5 text-[11px] font-semibold text-primary transition-colors hover:bg-primary-50 dark:text-primary-400 dark:hover:bg-primary-900/20">
                                                                                Edit
                                                                            </button>
                                                                            <form action="{{ route('dashboard.planner.checklists.destroy', $item) }}"
                                                                                method="POST" class="inline"
                                                                                onsubmit="return confirm('Hapus checklist custom ini?')">
                                                                                @csrf
                                                                                @method('DELETE')
                                                                                <button type="submit"
                                                                                    class="inline-flex items-center rounded-lg px-2.5 py-1.5 text-[11px] font-semibold text-red-600 transition-colors hover:bg-red-50 dark:text-red-400 dark:hover:bg-red-900/20">
                                                                                    Hapus
                                                                                </button>
                                                                            </form>
                                                                        </div>
                                                                    @endif
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    @endif
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                @endif

                            @elseif($pillar['key'] === 'ADMINISTRATION')

                                {{-- ─── ADMINISTRASI: Dokumen Persyaratan KUA (Pria/Wanita) ─── --}}
                                <div
                                    class="mb-6 rounded-2xl border border-neutral-200/80 bg-white p-5 shadow-sm dark:border-secondary-700/60 dark:bg-secondary-800/80">
                                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                                        <div class="min-w-0">
                                            <h3 class="font-heading text-lg font-bold text-secondary-800 dark:text-neutral-100">
                                                Dokumen Persyaratan KUA</h3>
                                            <p class="mt-1 text-xs text-neutral-500 dark:text-neutral-400">
                                                <span x-text="categoryCompleted('ADMINISTRATION')"></span>/<span
                                                    x-text="categoryTotal('ADMINISTRATION')"></span> checkbox selesai
                                            </p>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <button type="button" x-data @click="$dispatch('open-modal', 'add-checklist')"
                                                class="inline-flex items-center gap-1.5 rounded-xl bg-primary px-3 py-1.5 text-xs font-semibold text-white transition-all hover:bg-primary-600">
                                                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 4v16m8-8H4" />
                                                </svg>
                                                Tambah Data
                                            </button>
                                        </div>
                                    </div>
                                    <div class="mt-4">
                                        <div
                                            class="h-2.5 overflow-hidden rounded-full bg-neutral-200/80 dark:bg-secondary-700/60">
                                            <div class="h-full rounded-full bg-cyan-500 transition-all duration-500 dark:bg-cyan-400"
                                                :style="'width:' + categoryProgress('ADMINISTRATION') + '%'"></div>
                                        </div>
                                        <p class="mt-1 text-right text-xs font-bold tabular-nums text-cyan-600 dark:text-cyan-400"
                                            x-text="categoryProgress('ADMINISTRATION') + '%'"></p>
                                    </div>
                                </div>

                                <div class="space-y-5">
                                    @php
                                        $adminItems = $checklists->where('category_code', 'ADMINISTRATION');
                                        $adminNormalItems = $adminItems->where('is_document', false);
                                        $adminDocumentItems = $adminItems->where('is_document', true);
                                    @endphp

                                    @if($adminItems->isEmpty())
                                        <div
                                            class="rounded-3xl border border-dashed border-cyan-200/70 bg-cyan-50/50 px-6 py-10 text-center text-sm text-cyan-700/80 dark:border-cyan-800/40 dark:bg-cyan-950/20 dark:text-cyan-300">
                                            <div
                                                class="mx-auto flex h-12 w-12 items-center justify-center rounded-2xl bg-white/80 shadow-sm dark:bg-secondary-800/70">
                                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                                        d="M9 12h6m-6 4h6m2 4H7a2 2 0 01-2-2V4a2 2 0 012-2h6.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V20a2 2 0 01-2 2z" />
                                                </svg>
                                            </div>
                                            <p class="mt-3 font-semibold">Belum ada checklist pada kategori Administrasi.</p>
                                            <p class="mt-1 text-xs text-cyan-700/70 dark:text-cyan-300/70">Tambahkan item untuk
                                                melengkapi dokumen persyaratan.</p>
                                        </div>
                                    @else
                                        @if($adminNormalItems->isNotEmpty())
                                            <div
                                                class="overflow-hidden rounded-[24px] border border-neutral-200/80 bg-white shadow-[0_16px_40px_-24px_rgba(15,23,42,0.35)] ring-1 ring-black/5 dark:border-secondary-700/60 dark:bg-secondary-800/80">
                                                <div
                                                    class="border-b border-neutral-200/80 bg-gradient-to-r from-neutral-50/90 to-white px-4 py-3 dark:border-secondary-700/60 dark:from-secondary-700/40 dark:to-secondary-800/50">
                                                    <h4 class="text-sm font-semibold text-secondary-800 dark:text-neutral-100">
                                                        Administrasi Umum</h4>
                                                </div>
                                                <ul class="divide-y divide-neutral-100 dark:divide-secondary-700/50">
                                                    @foreach($adminNormalItems as $item)
                                                        <li
                                                            class="flex items-center gap-3 px-4 py-3.5 transition-all duration-200 hover:bg-cyan-50/60 dark:hover:bg-secondary-700/30">
                                                            <div
                                                                class="flex h-9 w-9 shrink-0 items-center justify-center rounded-2xl bg-cyan-50 text-cyan-600 ring-1 ring-cyan-100 dark:bg-cyan-900/30 dark:text-cyan-400 dark:ring-cyan-900/40">
                                                                <input type="checkbox" :checked="items[{{ $item->id }}].completed"
                                                                    data-toggle-url="{{ route('dashboard.planner.checklists.toggle', $item) }}"
                                                                    @change="toggleItem({{ $item->id }}, $event)"
                                                                    class="h-4 w-4 cursor-pointer rounded border-neutral-300 text-primary focus:ring-primary-500 dark:border-neutral-600">
                                                            </div>
                                                            <div class="min-w-0 flex-1">
                                                                <p class="text-sm font-medium text-secondary-800 dark:text-neutral-100"
                                                                    :class="items[{{ $item->id }}].completed ? 'line-through text-neutral-400 dark:text-neutral-500' : ''">
                                                                    {{ $item->title }}
                                                                </p>
                                                            </div>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif

                                        @if($adminDocumentItems->isNotEmpty())
                                            <div
                                                class="overflow-hidden rounded-[24px] border border-neutral-200/80 bg-white shadow-[0_16px_40px_-24px_rgba(15,23,42,0.35)] ring-1 ring-black/5 dark:border-secondary-700/60 dark:bg-secondary-800/80">
                                                <div
                                                    class="border-b border-neutral-200/80 bg-gradient-to-r from-neutral-50/90 to-white px-4 py-3 dark:border-secondary-700/60 dark:from-secondary-700/40 dark:to-secondary-800/50">
                                                    <h4 class="text-sm font-semibold text-secondary-800 dark:text-neutral-100">Dokumen
                                                        Persyaratan</h4>
                                                    <p class="mt-0.5 text-[11px] text-neutral-400 dark:text-neutral-500">
                                                        {{ $adminDocumentItems->count() }} item · klik checkbox buat tandai selesai
                                                    </p>
                                                </div>
                                                <ul class="divide-y divide-neutral-100 dark:divide-secondary-700/50">
                                                    @foreach($adminDocumentItems as $item)
                                                        <li
                                                            class="px-4 py-3.5 transition-all duration-200 hover:bg-cyan-50/60 dark:hover:bg-secondary-700/30">
                                                            <p class="text-sm font-medium text-secondary-800 dark:text-neutral-100"
                                                                :class="items[{{ $item->id }}].pria && items[{{ $item->id }}].wanita ? 'line-through text-neutral-400 dark:text-neutral-500' : ''">
                                                                {{ $item->title }}
                                                            </p>
                                                            <div class="mt-2 flex items-center gap-2">
                                                                <label
                                                                    class="inline-flex items-center gap-1.5 cursor-pointer select-none rounded-full border border-neutral-200 bg-white/80 px-3 py-1.5 text-neutral-600 transition-all dark:border-secondary-600/60 dark:bg-secondary-700/40 dark:text-neutral-300"
                                                                    :class="items[{{ $item->id }}].pria ? 'border-blue-300 bg-blue-50 text-blue-700 dark:border-blue-600/50 dark:bg-blue-900/20 dark:text-blue-300' : ''">
                                                                    <input type="checkbox" :checked="items[{{ $item->id }}].pria"
                                                                        data-toggle-url="{{ route('dashboard.planner.checklists.toggle', $item) }}"
                                                                        data-party="pria" @change="toggleItem({{ $item->id }}, $event)"
                                                                        class="h-3.5 w-3.5 cursor-pointer rounded border-neutral-300 text-primary focus:ring-primary-500 dark:border-neutral-600">
                                                                    <span class="flex items-center gap-1 text-xs font-semibold">
                                                                        <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none"
                                                                            stroke="currentColor" stroke-width="1.8">
                                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                                d="M10 5a3 3 0 100 6 3 3 0 000-6zm-4 12v-1a2 2 0 012-2h4a2 2 0 012 2v1" />
                                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                                d="M10 15v4" />
                                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                                d="M8 17h4" />
                                                                        </svg>
                                                                        Pria
                                                                    </span>
                                                                </label>
                                                                <label
                                                                    class="inline-flex items-center gap-1.5 cursor-pointer select-none rounded-full border border-neutral-200 bg-white/80 px-3 py-1.5 text-neutral-600 transition-all dark:border-secondary-600/60 dark:bg-secondary-700/40 dark:text-neutral-300"
                                                                    :class="items[{{ $item->id }}].wanita ? 'border-pink-300 bg-pink-50 text-pink-700 dark:border-pink-600/50 dark:bg-pink-900/20 dark:text-pink-300' : ''">
                                                                    <input type="checkbox" :checked="items[{{ $item->id }}].wanita"
                                                                        data-toggle-url="{{ route('dashboard.planner.checklists.toggle', $item) }}"
                                                                        data-party="wanita" @change="toggleItem({{ $item->id }}, $event)"
                                                                        class="h-3.5 w-3.5 cursor-pointer rounded border-neutral-300 text-primary focus:ring-primary-500 dark:border-neutral-600">
                                                                    <span class="flex items-center gap-1 text-xs font-semibold">
                                                                        <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none"
                                                                            stroke="currentColor" stroke-width="1.8">
                                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                                d="M12 4a3 3 0 100 6 3 3 0 000-6zm-4 12v-1a2 2 0 012-2h4a2 2 0 012 2v1" />
                                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                                d="M9 7h6" />
                                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                                d="M12 4v6" />
                                                                        </svg>
                                                                        Wanita
                                                                    </span>
                                                                </label>
                                                            </div>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                    @endif
                                </div>

                            @elseif($pillar['key'] === 'VENDOR')
                                @php
                                    $allVendors = $vendorsByType->flatten(1);
                                    $totalVendors = $allVendors->count();
                                    $bookedVendors = $allVendors->where('status', 'COMPLETED')->count();
                                    $pendingVendors = $totalVendors - $bookedVendors;
                                    $totalEstimate = (float) $allVendors->sum('estimated_cost');
                                @endphp
                                <div class="mb-4 flex items-center justify-between gap-3">
                                    <div>
                                        <h3 class="font-semibold text-secondary-800 dark:text-neutral-100">Vendor Pernikahan
                                        </h3>
                                        <p class="mt-0.5 text-xs text-neutral-500 dark:text-neutral-400">{{ $totalVendors }}
                                            vendor terdaftar</p>
                                    </div>
                                </div>

                                {{-- Summary --}}
                                <div class="mb-4 grid grid-cols-2 gap-2 sm:grid-cols-4">
                                    <div
                                        class="rounded-2xl border border-neutral-200/70 bg-neutral-50/70 p-3 text-center dark:border-secondary-700/50 dark:bg-secondary-700/40">
                                        <p class="text-[10px] text-neutral-500 dark:text-neutral-400">Total</p>
                                        <p class="mt-1 text-sm font-bold text-secondary-800 dark:text-neutral-100 tabular-nums">
                                            {{ $totalVendors }}
                                        </p>
                                    </div>
                                    <div
                                        class="rounded-2xl border border-emerald-200/70 bg-emerald-50/70 p-3 text-center dark:border-emerald-800/50 dark:bg-emerald-900/20">
                                        <p class="text-[10px] text-emerald-500 dark:text-emerald-400">Booked</p>
                                        <p class="mt-1 text-sm font-bold text-emerald-600 dark:text-emerald-400 tabular-nums">
                                            {{ $bookedVendors }}
                                        </p>
                                    </div>
                                    <div
                                        class="rounded-2xl border border-amber-200/70 bg-amber-50/70 p-3 text-center dark:border-amber-800/50 dark:bg-amber-900/20">
                                        <p class="text-[10px] text-amber-500 dark:text-amber-400">Pending</p>
                                        <p class="mt-1 text-sm font-bold text-amber-600 dark:text-amber-400 tabular-nums">
                                            {{ $pendingVendors }}
                                        </p>
                                    </div>
                                    <div
                                        class="rounded-2xl border border-orange-200/70 bg-orange-50/70 p-3 text-center dark:border-orange-800/50 dark:bg-orange-900/20">
                                        <p class="text-[10px] text-orange-500 dark:text-orange-400">Estimasi</p>
                                        <p class="mt-1 text-sm font-bold text-orange-600 dark:text-orange-400 tabular-nums">Rp
                                            {{ number_format($totalEstimate, 0, ',', '.') }}
                                        </p>
                                    </div>
                                </div>

                                {{-- Vendor Grid --}}
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    @foreach(\App\Models\WeddingPlannerItem::VENDOR_TYPES as $type => $vendorLabel)
                                        @php
                                            $vendors = $vendorsByType[$type] ?? collect();
                                            $typeEstimate = (float) $vendors->sum('estimated_cost');
                                            $typeBooked = $vendors->where('status', 'COMPLETED')->count();
                                        @endphp
                                        <div
                                            class="overflow-hidden rounded-2xl border border-neutral-200/80 bg-white shadow-sm dark:border-secondary-700/60 dark:bg-secondary-800/80">
                                            {{-- Type Header --}}
                                            <div
                                                class="border-b border-neutral-100 bg-neutral-50/80 px-4 py-3 dark:border-secondary-700/50 dark:bg-secondary-700/40">
                                                <div class="flex items-center justify-between">
                                                    <div class="flex items-center gap-2">
                                                        <span class="h-2 w-2 rounded-full bg-orange-500"></span>
                                                        <h4 class="text-sm font-semibold text-secondary-800 dark:text-neutral-100">
                                                            {{ $vendorLabel }}
                                                        </h4>
                                                    </div>
                                                    <div class="flex items-center gap-2">
                                                        <span
                                                            class="text-[10px] font-semibold text-neutral-400 dark:text-neutral-500">{{ $vendors->count() }}
                                                            vendor</span>
                                                        @if($vendors->isNotEmpty())
                                                            <span
                                                                class="text-[10px] font-bold text-orange-600 dark:text-orange-400 tabular-nums">Rp
                                                                {{ number_format($typeEstimate, 0, ',', '.') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- Vendor List --}}
                                            @if($vendors->isEmpty())
                                                <div class="px-4 py-6 text-center">
                                                    <svg class="mx-auto mb-2 h-8 w-8 text-neutral-300 dark:text-secondary-600"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                                    </svg>
                                                    <p class="text-xs text-neutral-400 dark:text-neutral-500">Belum ada vendor</p>
                                                </div>
                                            @else
                                                <div class="space-y-1.5 p-2">
                                                    @foreach($vendors as $vendor)
                                                        <div
                                                            class="group relative flex items-center gap-3 rounded-xl p-2.5 transition-colors hover:bg-neutral-50 dark:hover:bg-secondary-700/30">
                                                            <div class="min-w-0 flex-1">
                                                                <div class="flex items-center gap-2">
                                                                    <p
                                                                        class="truncate text-sm font-medium text-secondary-800 dark:text-neutral-100">
                                                                        {{ $vendor->title }}
                                                                    </p>
                                                                    <span
                                                                        class="inline-flex shrink-0 items-center rounded px-1.5 py-0.5 text-[9px] font-bold {{ $statusStyles[$vendor->status] ?? $statusStyles['PENDING'] }}">
                                                                        {{ $statusLabels[$vendor->status] ?? $vendor->status }}
                                                                    </span>
                                                                </div>
                                                                @if($vendor->vendor_contact)
                                                                    <p
                                                                        class="mt-0.5 flex items-center gap-1 truncate text-[11px] text-neutral-400 dark:text-neutral-500">
                                                                        <svg class="h-3 w-3 shrink-0" fill="none" viewBox="0 0 24 24"
                                                                            stroke="currentColor">
                                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                                stroke-width="2"
                                                                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                                                        </svg>
                                                                        {{ $vendor->vendor_contact }}
                                                                    </p>
                                                                @endif
                                                            </div>
                                                            <div class="flex shrink-0 items-center gap-2">
                                                                <span
                                                                    class="text-[11px] font-semibold text-neutral-500 dark:text-neutral-400 tabular-nums">Rp
                                                                    {{ number_format($vendor->estimated_cost, 0, ',', '.') }}</span>
                                                                <div
                                                                    class="flex items-center gap-0.5 opacity-0 transition-opacity group-hover:opacity-100">
                                                                    <button type="button" x-data
                                                                        @click="$dispatch('open-modal', 'edit-item-{{ $vendor->id }}')"
                                                                        class="rounded-lg p-1.5 text-neutral-400 transition-colors hover:bg-primary-50 hover:text-primary dark:hover:bg-primary-900/20">
                                                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"
                                                                            stroke="currentColor">
                                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                                stroke-width="2"
                                                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                                        </svg>
                                                                    </button>
                                                                    <form action="{{ route('dashboard.planner.items.destroy', $vendor) }}"
                                                                        method="POST" onsubmit="return confirm('Hapus vendor ini?')">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit"
                                                                            class="rounded-lg p-1.5 text-neutral-400 transition-colors hover:bg-red-50 hover:text-red-600 dark:hover:bg-red-900/20">
                                                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"
                                                                                stroke="currentColor">
                                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                                    stroke-width="2"
                                                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                                            </svg>
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif

                                            {{-- Add Button --}}
                                            <div class="px-3 pb-3">
                                                <button type="button" x-data
                                                    @click="$dispatch('open-modal', 'add-vendor'); $dispatch('set-vendor-type', { type: '{{ $type }}' })"
                                                    class="w-full flex items-center justify-center gap-1.5 px-3 py-2 rounded-lg border border-dashed border-neutral-300 dark:border-secondary-600 text-neutral-500 dark:text-neutral-400 hover:border-orange-400 hover:text-orange-500 dark:hover:border-orange-600 dark:hover:text-orange-400 text-xs font-medium transition-colors">
                                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M12 4v16m8-8H4" />
                                                    </svg>
                                                    Tambah
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                            @elseif($pillar['key'] === 'ENGAGEMENT')
                                @php
                                    $engItems = $itemsByCategory['ENGAGEMENT'];
                                    $engTotalPria = (float) $engItems->sum('cost_pria');
                                    $engTotalWanita = (float) $engItems->sum('cost_wanita');
                                    $engTotal = $engTotalPria + $engTotalWanita;
                                @endphp
                                <div class="mb-5 flex items-center justify-between gap-3">
                                    <div>
                                        <h3 class="text-sm font-semibold text-secondary-800 dark:text-neutral-100 sm:text-base">
                                            Rencana Pertunangan</h3>
                                        <p class="mt-0.5 text-[11px] text-neutral-500 dark:text-neutral-400 sm:text-xs">
                                            {{ $engItems->count() }} item
                                        </p>
                                    </div>
                                    <button type="button" x-data
                                        @click="setActiveTab('ENGAGEMENT'); $dispatch('open-modal', 'add-item-ENGAGEMENT')"
                                        class="inline-flex items-center gap-1.5 rounded-xl bg-primary px-2.5 py-1.5 text-[11px] font-semibold text-white transition-all hover:bg-primary-600 sm:px-3 sm:text-xs">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 4v16m8-8H4" />
                                        </svg>
                                        Tambah
                                    </button>
                                </div>

                                {{-- Summary --}}
                                <div class="mb-5 grid grid-cols-3 gap-2 sm:gap-3">
                                    <div
                                        class="rounded-2xl border border-neutral-200/70 bg-neutral-50/70 p-2.5 text-center dark:border-secondary-700/50 dark:bg-secondary-700/40 sm:p-3.5">
                                        <p class="text-[10px] text-neutral-500 dark:text-neutral-400 sm:text-[11px]">Total</p>
                                        <p class="mt-1 text-sm font-bold text-secondary-800 dark:text-neutral-100 tabular-nums sm:text-lg">
                                            Rp {{ number_format($engTotal, 0, ',', '.') }}
                                        </p>
                                    </div>
                                    <div
                                        class="rounded-2xl border border-blue-200/70 bg-blue-50/70 p-2.5 text-center dark:border-blue-800/50 dark:bg-blue-900/20 sm:p-3.5">
                                        <p class="text-[10px] text-blue-500 dark:text-blue-400 sm:text-[11px]">Pria</p>
                                        <p class="mt-1 text-sm font-bold text-blue-600 dark:text-blue-400 tabular-nums sm:text-lg">
                                            Rp {{ number_format($engTotalPria, 0, ',', '.') }}
                                        </p>
                                    </div>
                                    <div
                                        class="rounded-2xl border border-pink-200/70 bg-pink-50/70 p-2.5 text-center dark:border-pink-800/50 dark:bg-pink-900/20 sm:p-3.5">
                                        <p class="text-[10px] text-pink-500 dark:text-pink-400 sm:text-[11px]">Wanita</p>
                                        <p class="mt-1 text-sm font-bold text-pink-600 dark:text-pink-400 tabular-nums sm:text-lg">
                                            Rp {{ number_format($engTotalWanita, 0, ',', '.') }}
                                        </p>
                                    </div>
                                </div>

                                @if($engItems->isEmpty())
                                    <div
                                        class="rounded-2xl border border-dashed border-pink-200/70 bg-pink-50/50 px-5 py-10 text-center text-sm text-pink-700/80 dark:border-pink-800/40 dark:bg-pink-950/20 dark:text-pink-300">
                                        <div
                                            class="mx-auto flex h-12 w-12 items-center justify-center rounded-2xl bg-white/80 shadow-sm dark:bg-secondary-800/70">
                                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                            </svg>
                                        </div>
                                        <p class="mt-3 font-semibold">Belum ada data pertunangan.</p>
                                        <p class="mt-1 text-xs text-pink-700/70 dark:text-pink-300/70">Tambahkan item untuk mulai
                                            merencanakan acara pertunangan.</p>
                                    </div>
                                @else
                                    <div class="space-y-2.5">
                                        @foreach($engItems as $item)
                                            @php
                                                $itemTotal = $item->cost_pria + $item->cost_wanita;
                                            @endphp
                                            <div
                                                class="group relative rounded-2xl border border-neutral-200/80 bg-white shadow-sm transition-all duration-200 hover:border-pink-300 hover:shadow-md dark:border-secondary-600/50 dark:bg-secondary-800/80 dark:hover:border-pink-700/50">
                                                <div class="p-4">
                                                    <div class="flex items-start justify-between gap-3">
                                                        <div class="flex items-center gap-2 min-w-0">
                                                            <span class="w-1.5 h-1.5 rounded-full bg-pink-500 shrink-0"></span>
                                                            <p
                                                                class="text-sm font-semibold text-secondary-800 dark:text-neutral-100 truncate">
                                                                {{ $item->title }}
                                                            </p>
                                                            <span
                                                                class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold {{ $statusStyles[$item->status] ?? $statusStyles['PENDING'] }} shrink-0">
                                                                {{ $statusLabels[$item->status] ?? $item->status }}
                                                            </span>
                                                        </div>
                                                        <div
                                                            class="flex items-center gap-0.5 shrink-0 sm:opacity-0 sm:group-hover:opacity-100 sm:focus-within:opacity-100 transition-opacity duration-150">
                                                            <button type="button" x-data
                                                                @click="$dispatch('open-modal', 'edit-item-{{ $item->id }}')"
                                                                class="p-1.5 rounded-lg text-neutral-400 hover:text-primary dark:hover:text-primary-400 hover:bg-primary-50 dark:hover:bg-primary-900/20 transition-colors">
                                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"
                                                                    stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2"
                                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                                </svg>
                                                            </button>
                                                            <form action="{{ route('dashboard.planner.items.destroy', $item) }}"
                                                                method="POST" onsubmit="return confirm('Hapus item ini?')">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                    class="p-1.5 rounded-lg text-neutral-400 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
                                                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"
                                                                        stroke="currentColor">
                                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                                            stroke-width="2"
                                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                                    </svg>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                    <div
                                                        class="mt-3 grid grid-cols-3 divide-x divide-neutral-200/80 overflow-hidden rounded-xl border border-neutral-100 bg-neutral-50/80 dark:divide-secondary-600/60 dark:border-secondary-600/50 dark:bg-secondary-700/40">
                                                        <div class="min-w-0 px-3 py-2.5">
                                                            <p class="text-[10px] font-medium text-blue-500 dark:text-blue-400">
                                                                Pria</p>
                                                            <p
                                                                class="mt-0.5 truncate text-xs font-bold text-blue-600 tabular-nums dark:text-blue-400 sm:text-sm">
                                                                Rp {{ number_format($item->cost_pria, 0, ',', '.') }}
                                                            </p>
                                                        </div>
                                                        <div class="min-w-0 px-3 py-2.5">
                                                            <p class="text-[10px] font-medium text-pink-500 dark:text-pink-400">
                                                                Wanita</p>
                                                            <p
                                                                class="mt-0.5 truncate text-xs font-bold text-pink-600 tabular-nums dark:text-pink-400 sm:text-sm">
                                                                Rp {{ number_format($item->cost_wanita, 0, ',', '.') }}
                                                            </p>
                                                        </div>
                                                        <div class="min-w-0 px-3 py-2.5">
                                                            <p
                                                                class="text-[10px] font-medium text-neutral-400 dark:text-neutral-500">
                                                                Total</p>
                                                            <p
                                                                class="mt-0.5 truncate text-xs font-bold text-secondary-800 tabular-nums dark:text-neutral-100 sm:text-sm">
                                                                Rp {{ number_format($itemTotal, 0, ',', '.') }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif

                            @elseif($pillar['key'] === 'PRE_WEDDING')
                                @php
                                    $preItems = $itemsByCategory['PRE_WEDDING'];
                                    $preTotalBudget = $preItems->sum('estimated_cost');
                                    $preTotalPaid = $preItems->sum('paid_amount');
                                    $preTotalRemaining = max(0, $preTotalBudget - $preTotalPaid);
                                    $prePaidPercent = $preTotalBudget > 0 ? round(($preTotalPaid / $preTotalBudget) * 100) : 0;
                                @endphp
                                <div class="mb-4 flex items-center justify-between gap-3">
                                    <div>
                                        <h3 class="text-sm font-semibold text-secondary-800 dark:text-neutral-100 sm:text-base">
                                            Pre-Wedding</h3>
                                        <p class="mt-0.5 text-[11px] text-neutral-500 dark:text-neutral-400 sm:text-xs">
                                            {{ $preItems->count() }} item persiapan
                                        </p>
                                    </div>
                                    <button type="button" x-data
                                        @click="setActiveTab('PRE_WEDDING'); $dispatch('open-modal', 'add-item-PRE_WEDDING')"
                                        class="inline-flex items-center gap-1.5 rounded-xl bg-primary px-2.5 py-1.5 text-[11px] font-semibold text-white transition-all hover:bg-primary-600 sm:px-3 sm:text-xs">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 4v16m8-8H4" />
                                        </svg>
                                        Tambah
                                    </button>
                                </div>

                                @if($preItems->isEmpty())
                                    <div
                                        class="rounded-2xl border border-dashed border-neutral-200 px-5 py-10 text-center text-sm text-neutral-400 dark:border-secondary-600 dark:text-neutral-500">
                                        Belum ada item persiapan. Tambahkan item untuk mulai merencanakan pre-wedding.
                                    </div>
                                @else
                                    {{-- Summary Cards --}}
                                    <div class="mb-5 grid grid-cols-3 gap-2 sm:gap-3">
                                        <div
                                            class="rounded-2xl border border-neutral-200/70 bg-neutral-50/70 p-2.5 text-center dark:border-secondary-700/50 dark:bg-secondary-700/40 sm:p-3.5">
                                            <span
                                                class="text-[10px] text-neutral-400 dark:text-neutral-500 sm:text-[11px]">Budget</span>
                                            <p
                                                class="mt-0.5 text-sm font-bold text-secondary-800 dark:text-neutral-100 tabular-nums sm:text-lg">
                                                Rp {{ number_format($preTotalBudget, 0, ',', '.') }}</p>
                                        </div>
                                        <div
                                            class="rounded-2xl border border-emerald-200/70 bg-emerald-50/70 p-2.5 text-center dark:border-emerald-800/50 dark:bg-emerald-900/20 sm:p-3.5">
                                            <span
                                                class="text-[10px] text-emerald-500 dark:text-emerald-400 sm:text-[11px]">Bayar</span>
                                            <p
                                                class="mt-0.5 text-sm font-bold text-emerald-600 dark:text-emerald-400 tabular-nums sm:text-lg">
                                                Rp {{ number_format($preTotalPaid, 0, ',', '.') }}</p>
                                        </div>
                                        <div
                                            class="rounded-2xl border border-amber-200/70 bg-amber-50/70 p-2.5 text-center dark:border-amber-800/50 dark:bg-amber-900/20 sm:p-3.5">
                                            <span class="text-[10px] text-amber-500 dark:text-amber-400 sm:text-[11px]">Sisa</span>
                                            <p
                                                class="mt-0.5 text-sm font-bold text-amber-600 dark:text-amber-400 tabular-nums sm:text-lg">
                                                Rp
                                                {{ number_format($preTotalRemaining, 0, ',', '.') }}
                                            </p>
                                        </div>
                                    </div>

                                    {{-- Progress Bar --}}
                                    <div
                                        class="mb-5 p-4 rounded-xl border border-neutral-200/70 dark:border-secondary-700/50 bg-neutral-50/60 dark:bg-secondary-700/30">
                                        <div class="flex items-center justify-between mb-2">
                                            <span class="text-xs font-semibold text-secondary-800 dark:text-neutral-100">Progres
                                                Pembayaran</span>
                                            <span
                                                class="text-xs font-bold text-violet-600 dark:text-violet-400 tabular-nums">{{ $prePaidPercent }}%</span>
                                        </div>
                                        <div class="w-full h-2 bg-neutral-200 dark:bg-secondary-600 rounded-full overflow-hidden">
                                            <div class="h-full bg-violet-500 rounded-full transition-all duration-500"
                                                style="width: {{ $prePaidPercent }}%"></div>
                                        </div>
                                        <div class="flex items-center justify-between mt-1.5">
                                            <span class="text-[10px] text-neutral-400 dark:text-neutral-500">Rp
                                                {{ number_format($preTotalPaid, 0, ',', '.') }} terbayar</span>
                                            <span class="text-[10px] text-neutral-400 dark:text-neutral-500">Rp
                                                {{ number_format($preTotalBudget, 0, ',', '.') }} total</span>
                                        </div>
                                    </div>

                                    {{-- Items List --}}
                                    <div class="space-y-2.5">
                                        @foreach($preItems as $item)
                                            @php
                                                $itemPaidPercent = $item->estimated_cost > 0 ? round(($item->paid_amount / $item->estimated_cost) * 100) : 0;
                                            @endphp
                                            <div
                                                class="group relative flex items-stretch rounded-2xl border border-neutral-200/80 bg-neutral-50/70 shadow-sm transition-all duration-200 hover:border-violet-300 hover:bg-violet-50/30 dark:border-secondary-600/50 dark:bg-secondary-700/30 dark:hover:border-violet-700/50 dark:hover:bg-violet-900/10">
                                                <div
                                                    class="flex items-center justify-center w-12 shrink-0 border-r border-neutral-150 dark:border-secondary-600/50 bg-violet-50/50 dark:bg-violet-900/20 rounded-l-xl">
                                                    <span
                                                        class="w-6 h-6 flex items-center justify-center rounded-lg text-[10px] font-bold text-white bg-violet-500">{{ $loop->iteration }}</span>
                                                </div>
                                                <div class="flex-1 px-4 py-3 min-w-0">
                                                    <div class="flex items-start justify-between gap-2">
                                                        <div class="min-w-0">
                                                            <div class="flex items-center gap-2 flex-wrap">
                                                                <p
                                                                    class="text-sm font-semibold text-secondary-800 dark:text-neutral-100 truncate">
                                                                    {{ $item->title }}
                                                                </p>
                                                                <span
                                                                    class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold {{ $statusStyles[$item->status] ?? $statusStyles['PENDING'] }}">
                                                                    {{ $statusLabels[$item->status] ?? $item->status }}
                                                                </span>
                                                            </div>
                                                            <div class="flex items-center gap-4 mt-2">
                                                                <div class="flex items-center gap-1.5">
                                                                    <span
                                                                        class="text-[10px] text-neutral-400 dark:text-neutral-500">Budget:</span>
                                                                    <span
                                                                        class="text-xs font-semibold text-secondary-700 dark:text-neutral-200 tabular-nums">Rp
                                                                        {{ number_format($item->estimated_cost, 0, ',', '.') }}</span>
                                                                </div>
                                                                <div class="flex items-center gap-1.5">
                                                                    <span
                                                                        class="text-[10px] text-neutral-400 dark:text-neutral-500">Bayar:</span>
                                                                    <span
                                                                        class="text-xs font-semibold text-emerald-600 dark:text-emerald-400 tabular-nums">Rp
                                                                        {{ number_format($item->paid_amount, 0, ',', '.') }}</span>
                                                                </div>
                                                            </div>
                                                            <div class="mt-2 flex items-center gap-2">
                                                                <div
                                                                    class="flex-1 h-1.5 bg-neutral-200 dark:bg-secondary-600 rounded-full overflow-hidden">
                                                                    <div class="h-full bg-violet-500 rounded-full"
                                                                        style="width: {{ $itemPaidPercent }}%"></div>
                                                                </div>
                                                                <span
                                                                    class="text-[10px] font-semibold text-violet-600 dark:text-violet-400 tabular-nums">{{ $itemPaidPercent }}%</span>
                                                            </div>
                                                        </div>
                                                        <div
                                                            class="flex items-center gap-1 shrink-0 sm:opacity-0 sm:group-hover:opacity-100 sm:focus-within:opacity-100 transition-opacity duration-150">
                                                            <button type="button" x-data
                                                                @click="$dispatch('open-modal', 'edit-item-{{ $item->id }}')"
                                                                class="p-1.5 rounded-lg text-neutral-400 hover:text-primary dark:hover:text-primary-400 hover:bg-primary-50 dark:hover:bg-primary-900/20 transition-colors">
                                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"
                                                                    stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2"
                                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                                </svg>
                                                            </button>
                                                            <form action="{{ route('dashboard.planner.items.destroy', $item) }}"
                                                                method="POST" onsubmit="return confirm('Hapus item ini?')">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                    class="p-1.5 rounded-lg text-neutral-400 hover:text-red-600 dark:hover:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
                                                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"
                                                                        stroke="currentColor">
                                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                                            stroke-width="2"
                                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                                    </svg>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif

                            @elseif($pillar['key'] === 'SESERAHAN')
                                @php
                                    $sesItems = $itemsByCategory['SESERAHAN'];
                                    $sesPriaItems = $sesItems->where('subcategory', 'PRIA')->values();
                                    $sesWanitaItems = $sesItems->where('subcategory', 'WANITA')->values();
                                    $sesTotalPria = (float) $sesPriaItems->sum('estimated_cost');
                                    $sesTotalWanita = (float) $sesWanitaItems->sum('estimated_cost');
                                    $sesTotal = $sesTotalPria + $sesTotalWanita;
                                @endphp
                                <div x-data="{ sesFilter: 'ALL' }">
                                    <div class="flex items-center justify-between gap-3 mb-4">
                                        <div>
                                            <h3
                                                class="font-semibold text-secondary-800 dark:text-neutral-100 text-sm sm:text-base">
                                                Seserahan</h3>
                                            <p class="text-[11px] sm:text-xs text-neutral-500 dark:text-neutral-400 mt-0.5">
                                                {{ $sesItems->count() }} item · dibagi per pihak
                                            </p>
                                        </div>
                                        <button type="button" x-data
                                            @click="setActiveTab('SESERAHAN'); $dispatch('open-modal', 'add-item-SESERAHAN')"
                                            class="inline-flex items-center gap-1.5 px-2.5 sm:px-3 py-1.5 rounded-xl bg-primary hover:bg-primary-600 text-white text-[11px] sm:text-xs font-semibold transition-all">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 4v16m8-8H4" />
                                            </svg>
                                            Tambah
                                        </button>
                                    </div>

                                    {{-- Toggle Filter --}}
                                    <div
                                        class="mb-5 grid grid-cols-3 gap-1 rounded-2xl bg-neutral-100 p-1 dark:bg-secondary-700/50">
                                        <button type="button" @click="sesFilter = 'ALL'"
                                            :class="sesFilter === 'ALL' ? 'bg-white dark:bg-secondary-800 text-secondary-800 dark:text-neutral-100 shadow-sm' : 'text-neutral-500 dark:text-neutral-400 hover:text-secondary-700 dark:hover:text-neutral-300'"
                                            class="flex items-center justify-center gap-1 px-1.5 sm:gap-1.5 sm:px-3 py-2 min-w-0 rounded-lg text-xs font-semibold transition-all duration-200">
                                            <svg class="w-3.5 h-3.5 hidden sm:block flex-shrink-0" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                                            </svg>
                                            <span class="truncate">Semua</span>
                                            <span
                                                class="flex-shrink-0 text-[10px] px-1.5 py-0.5 rounded-full bg-neutral-200 dark:bg-secondary-600 text-neutral-600 dark:text-neutral-300">{{ $sesItems->count() }}</span>
                                        </button>
                                        <button type="button" @click="sesFilter = 'PRIA'"
                                            :class="sesFilter === 'PRIA' ? 'bg-blue-500 text-white shadow-sm' : 'text-neutral-500 dark:text-neutral-400 hover:text-blue-600 dark:hover:text-blue-400'"
                                            class="flex items-center justify-center gap-1 px-1.5 sm:gap-1.5 sm:px-3 py-2 min-w-0 rounded-lg text-xs font-semibold transition-all duration-200">
                                            <svg class="w-3.5 h-3.5 hidden sm:block flex-shrink-0" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                            <span class="truncate">Pria</span>
                                            <span
                                                class="flex-shrink-0 text-[10px] px-1.5 py-0.5 rounded-full min-w-[18px] text-center"
                                                :class="sesFilter === 'PRIA' ? 'bg-blue-400 text-white' : 'bg-blue-100 dark:bg-blue-900/40 text-blue-600 dark:text-blue-400'">{{ $sesPriaItems->count() }}</span>
                                        </button>
                                        <button type="button" @click="sesFilter = 'WANITA'"
                                            :class="sesFilter === 'WANITA' ? 'bg-pink-500 text-white shadow-sm' : 'text-neutral-500 dark:text-neutral-400 hover:text-pink-600 dark:hover:text-pink-400'"
                                            class="flex items-center justify-center gap-1 px-1.5 sm:gap-1.5 sm:px-3 py-2 min-w-0 rounded-lg text-xs font-semibold transition-all duration-200">
                                            <svg class="w-3.5 h-3.5 hidden sm:block flex-shrink-0" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                            <span class="truncate">Wanita</span>
                                            <span
                                                class="flex-shrink-0 text-[10px] px-1.5 py-0.5 rounded-full min-w-[18px] text-center"
                                                :class="sesFilter === 'WANITA' ? 'bg-pink-400 text-white' : 'bg-pink-100 dark:bg-pink-900/40 text-pink-600 dark:text-pink-400'">{{ $sesWanitaItems->count() }}</span>
                                        </button>
                                    </div>

                                    {{-- Summary Cards --}}
                                    <div class="mb-5 grid grid-cols-3 gap-2 sm:gap-3">
                                        <div
                                            class="rounded-2xl border border-neutral-200/70 bg-neutral-50/70 p-2.5 dark:border-secondary-700/50 dark:bg-secondary-700/40 sm:p-3.5">
                                            <span
                                                class="text-[10px] text-neutral-400 dark:text-neutral-500 sm:text-[11px]">Total</span>
                                            <p
                                                class="mt-0.5 text-sm font-bold text-secondary-800 dark:text-neutral-100 tabular-nums sm:text-lg">
                                                Rp {{ number_format($sesTotal, 0, ',', '.') }}</p>
                                        </div>
                                        <div
                                            class="rounded-2xl border border-blue-200/70 bg-blue-50/70 p-2.5 dark:border-blue-800/50 dark:bg-blue-900/20 sm:p-3.5">
                                            <span
                                                class="text-[10px] text-blue-500 dark:text-blue-400 sm:text-[11px]">Pria</span>
                                            <p
                                                class="mt-0.5 text-sm font-bold text-blue-600 dark:text-blue-400 tabular-nums sm:text-lg">
                                                Rp
                                                {{ number_format($sesTotalPria, 0, ',', '.') }}
                                            </p>
                                        </div>
                                        <div
                                            class="rounded-2xl border border-pink-200/70 bg-pink-50/70 p-2.5 dark:border-pink-800/50 dark:bg-pink-900/20 sm:p-3.5">
                                            <span
                                                class="text-[10px] text-pink-500 dark:text-pink-400 sm:text-[11px]">Wanita</span>
                                            <p
                                                class="mt-0.5 text-sm font-bold text-pink-600 dark:text-pink-400 tabular-nums sm:text-lg">
                                                Rp
                                                {{ number_format($sesTotalWanita, 0, ',', '.') }}
                                            </p>
                                        </div>
                                    </div>

                                    @if($sesItems->isEmpty())
                                        <div
                                            class="px-5 py-10 text-center text-sm text-neutral-400 dark:text-neutral-500 border border-dashed border-neutral-200 dark:border-secondary-600 rounded-xl">
                                            Belum ada item seserahan. Tambahkan data untuk mulai merencanakan.
                                        </div>
                                    @else
                                        @php
                                            $sesPartyStyles = [
                                                'PRIA' => [
                                                    'border' => 'border-blue-200 dark:border-blue-800/60',
                                                    'headerBg' => 'bg-blue-50 dark:bg-blue-900/30',
                                                    'badge' => 'bg-blue-500',
                                                    'cost' => 'text-blue-600 dark:text-blue-400',
                                                    'subtotal' => 'text-blue-700 dark:text-blue-300',
                                                    'dot' => 'bg-blue-500',
                                                    'iconColor' => 'text-blue-500 dark:text-blue-400',
                                                ],
                                                'WANITA' => [
                                                    'border' => 'border-pink-200 dark:border-pink-800/60',
                                                    'headerBg' => 'bg-pink-50 dark:bg-pink-900/30',
                                                    'badge' => 'bg-pink-500',
                                                    'cost' => 'text-pink-600 dark:text-pink-400',
                                                    'subtotal' => 'text-pink-700 dark:text-pink-300',
                                                    'dot' => 'bg-pink-500',
                                                    'iconColor' => 'text-pink-500 dark:text-pink-400',
                                                ],
                                            ];
                                        @endphp

                                        {{-- Filtered Items --}}
                                        <div class="space-y-4">
                                            @foreach(\App\Models\WeddingPlannerItem::SESERAHAN_PARTIES as $partyCode => $partyLabel)
                                                <div x-show="sesFilter === 'ALL' || sesFilter === '{{ $partyCode }}'"
                                                    x-transition:enter="transition ease-out duration-200"
                                                    x-transition:enter-start="opacity-0 scale-95"
                                                    x-transition:enter-end="opacity-100 scale-100">
                                                    @php
                                                        $partyItems = $partyCode === 'PRIA' ? $sesPriaItems : $sesWanitaItems;
                                                        $partyTotal = $partyCode === 'PRIA' ? $sesTotalPria : $sesTotalWanita;
                                                        $partyStyle = $sesPartyStyles[$partyCode];
                                                    @endphp
                                                    <div
                                                        class="overflow-hidden rounded-2xl border {{ $partyStyle['border'] }} bg-white shadow-sm dark:bg-secondary-800">
                                                        <div
                                                            class="px-4 py-3 {{ $partyStyle['headerBg'] }} flex items-center justify-between gap-3">
                                                            <div class="flex items-center gap-2.5">
                                                                <span class="w-2 h-2 rounded-full {{ $partyStyle['dot'] }}"></span>
                                                                <h4
                                                                    class="text-sm font-semibold text-secondary-800 dark:text-neutral-100">
                                                                    {{ $partyLabel }}
                                                                </h4>
                                                            </div>
                                                            <div class="flex items-center gap-2">
                                                                <span
                                                                    class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-white/80 dark:bg-secondary-800/80 text-secondary-700 dark:text-neutral-300">
                                                                    {{ $partyItems->count() }} item
                                                                </span>
                                                                <span
                                                                    class="text-xs font-bold tabular-nums {{ $partyStyle['cost'] }}">Rp
                                                                    {{ number_format($partyTotal, 0, ',', '.') }}</span>
                                                            </div>
                                                        </div>

                                                        @if($partyItems->isEmpty())
                                                            <div
                                                                class="px-4 py-8 text-center text-sm text-neutral-400 dark:text-neutral-500">
                                                                Belum ada item untuk {{ strtolower($partyLabel) }}.
                                                            </div>
                                                        @else
                                                            <div class="p-3 space-y-2">
                                                                @foreach($partyItems as $item)
                                                                    @php
                                                                        $hoverBorder = $partyCode === 'PRIA' ? 'hover:border-blue-300' : 'hover:border-pink-300';
                                                                        $hoverBg = $partyCode === 'PRIA' ? 'hover:bg-blue-50/30' : 'hover:bg-pink-50/30';
                                                                        $darkHoverBorder = $partyCode === 'PRIA' ? 'dark:hover:border-blue-700/50' : 'dark:hover:border-pink-700/50';
                                                                        $darkHoverBg = $partyCode === 'PRIA' ? 'dark:hover:bg-blue-900/10' : 'dark:hover:bg-pink-900/10';
                                                                        $bgLeft = $partyCode === 'PRIA' ? 'bg-blue-50/50 dark:bg-blue-900/20' : 'bg-pink-50/50 dark:bg-pink-900/20';
                                                                    @endphp
                                                                    <div
                                                                        class="group relative flex items-stretch rounded-2xl border border-neutral-200/80 bg-neutral-50/70 shadow-sm transition-all duration-200 {{ $hoverBorder }} {{ $hoverBg }} dark:border-secondary-600/50 dark:bg-secondary-700/30 {{ $darkHoverBorder }} {{ $darkHoverBg }}">
                                                                        <div
                                                                            class="flex items-center justify-center w-12 shrink-0 border-r border-neutral-150 dark:border-secondary-600/50 {{ $bgLeft }} rounded-l-xl">
                                                                            <span
                                                                                class="w-6 h-6 flex items-center justify-center rounded-lg text-[10px] font-bold text-white {{ $partyStyle['badge'] }}">{{ $loop->iteration }}</span>
                                                                        </div>
                                                                        <div class="flex-1 px-3 py-2.5 min-w-0">
                                                                            <div class="flex items-center justify-between gap-2">
                                                                                <div class="min-w-0">
                                                                                    <div class="flex items-center gap-2 flex-wrap">
                                                                                        <p
                                                                                            class="text-sm font-medium text-secondary-800 dark:text-neutral-100 truncate">
                                                                                            {{ $item->title }}
                                                                                        </p>
                                                                                        <span
                                                                                            class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold {{ $statusStyles[$item->status] ?? $statusStyles['PENDING'] }}">
                                                                                            {{ $statusLabels[$item->status] ?? $item->status }}
                                                                                        </span>
                                                                                    </div>
                                                                                    <p
                                                                                        class="text-xs font-semibold mt-0.5 tabular-nums {{ $partyStyle['cost'] }}">
                                                                                        Rp
                                                                                        {{ number_format($item->estimated_cost, 0, ',', '.') }}
                                                                                    </p>
                                                                                </div>
                                                                                <div
                                                                                    class="flex items-center gap-1 shrink-0 sm:opacity-0 sm:group-hover:opacity-100 sm:focus-within:opacity-100 transition-opacity duration-150">
                                                                                    <button type="button" x-data
                                                                                        @click="$dispatch('open-modal', 'edit-item-{{ $item->id }}')"
                                                                                        class="p-1.5 rounded-lg text-neutral-400 hover:text-primary dark:hover:text-primary-400 hover:bg-primary-50 dark:hover:bg-primary-900/20 transition-colors">
                                                                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"
                                                                                            stroke="currentColor">
                                                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                                                stroke-width="2"
                                                                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                                                        </svg>
                                                                                    </button>
                                                                                    <form
                                                                                        action="{{ route('dashboard.planner.items.destroy', $item) }}"
                                                                                        method="POST"
                                                                                        onsubmit="return confirm('Hapus item ini?')">
                                                                                        @csrf
                                                                                        @method('DELETE')
                                                                                        <button type="submit"
                                                                                            class="p-1.5 rounded-lg text-neutral-400 hover:text-red-600 dark:hover:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
                                                                                            <svg class="w-3.5 h-3.5" fill="none"
                                                                                                viewBox="0 0 24 24" stroke="currentColor">
                                                                                                <path stroke-linecap="round"
                                                                                                    stroke-linejoin="round" stroke-width="2"
                                                                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                                                            </svg>
                                                                                        </button>
                                                                                    </form>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>

                                        {{-- Total Summary --}}
                                        <div
                                            class="mt-5 p-4 rounded-xl bg-amber-50 dark:bg-amber-900/20 border border-amber-200/60 dark:border-amber-700/40">
                                            <div class="flex items-center justify-between">
                                                <div>
                                                    <p class="text-sm font-bold text-secondary-800 dark:text-neutral-100">Total
                                                        Pengeluaran</p>
                                                    <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-0.5">Pria Rp
                                                        {{ number_format($sesTotalPria, 0, ',', '.') }} · Wanita Rp
                                                        {{ number_format($sesTotalWanita, 0, ',', '.') }}
                                                    </p>
                                                </div>
                                                <p class="text-xl font-bold text-amber-700 dark:text-amber-300 tabular-nums">Rp
                                                    {{ number_format($sesTotal, 0, ',', '.') }}
                                                </p>
                                            </div>
                                        </div>
                                    @endif
                                </div>

                            @elseif($pillar['key'] === 'BUDGET')
                                @php
                                    $budgetItems = $itemsByCategory['BUDGET'];
                                    $vendorItems = $vendorsByType->flatten(1);
                                    $engItems = $itemsByCategory['ENGAGEMENT'];
                                    $sesItems = $itemsByCategory['SESERAHAN'];
                                    $preItems = $itemsByCategory['PRE_WEDDING'];

                                    $budgetTotalEstimated = (float) $budgetItems->sum('estimated_cost');
                                    $budgetTotalPaid = (float) $budgetItems->sum('paid_amount');
                                    $budgetTotalRemaining = max(0, $budgetTotalEstimated - $budgetTotalPaid);
                                    $budgetPaidPercent = $budgetTotalEstimated > 0 ? round(($budgetTotalPaid / $budgetTotalEstimated) * 100) : 0;

                                    $vendorTotalEstimated = (float) $vendorItems->sum('estimated_cost');
                                    $vendorTotalPaid = (float) $vendorItems->sum('paid_amount');
                                    $vendorTotalRemaining = max(0, $vendorTotalEstimated - $vendorTotalPaid);

                                    $engTotalEstimated = (float) $engItems->sum('cost_pria') + $engItems->sum('cost_wanita');
                                    $engTotalPaid = 0;

                                    $sesTotalEstimated = (float) $sesItems->sum('estimated_cost');
                                    $sesTotalPaid = 0;

                                    $preTotalEstimated = (float) $preItems->sum('estimated_cost');
                                    $preTotalPaid = (float) $preItems->sum('paid_amount');

                                    $grandTotalEstimated = $budgetTotalEstimated + $vendorTotalEstimated + $engTotalEstimated + $sesTotalEstimated + $preTotalEstimated;
                                    $grandTotalPaid = $budgetTotalPaid + $vendorTotalPaid + $engTotalPaid + $sesTotalPaid + $preTotalPaid;
                                    $grandTotalRemaining = max(0, $grandTotalEstimated - $grandTotalPaid);
                                    $grandPaidPercent = $grandTotalEstimated > 0 ? round(($grandTotalPaid / $grandTotalEstimated) * 100) : 0;

                                    $budgetGroups = collect(\App\Models\WeddingPlannerItem::BUDGET_CATEGORIES)
                                        ->map(fn($config, $code) => [
                                            'label' => $config['label'],
                                            'items' => $budgetItems->where('subcategory', $code)->values(),
                                        ])
                                        ->reject(fn($group) => $group['items']->isEmpty());
                                @endphp
                                <div x-data="{ budgetFilter: 'ALL' }">
                                    <div class="flex items-center justify-between gap-3 mb-4">
                                        <div>
                                            <h3
                                                class="font-semibold text-secondary-800 dark:text-neutral-100 text-sm sm:text-base">
                                                Anggaran
                                                Pernikahan</h3>
                                            <p class="text-[11px] sm:text-xs text-neutral-500 dark:text-neutral-400 mt-0.5">
                                                Kelola anggaran per
                                                kategori.</p>
                                        </div>
                                        <button type="button" x-data
                                            @click="setActiveTab('BUDGET'); $dispatch('open-modal', 'add-item-BUDGET')"
                                            class="inline-flex items-center gap-1.5 px-2.5 sm:px-3 py-1.5 rounded-xl bg-primary hover:bg-primary-600 text-white text-[11px] sm:text-xs font-semibold transition-all">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 4v16m8-8H4" />
                                            </svg>
                                            Tambah
                                        </button>
                                    </div>

                                    {{-- Summary Cards --}}
                                    <div class="grid grid-cols-3 gap-2 sm:gap-3 mb-5">
                                        <div
                                            class="rounded-2xl border border-neutral-200/70 bg-neutral-50/70 p-2.5 dark:border-secondary-700/50 dark:bg-secondary-700/40 sm:p-3.5">
                                            <span
                                                class="text-[10px] text-neutral-400 dark:text-neutral-500 sm:text-[11px]">Estimasi</span>
                                            <p
                                                class="mt-0.5 text-sm font-bold text-secondary-800 dark:text-neutral-100 tabular-nums sm:text-lg">
                                                Rp {{ number_format($budgetTotalEstimated, 0, ',', '.') }}</p>
                                        </div>
                                        <div
                                            class="rounded-2xl border border-emerald-200/70 bg-emerald-50/70 p-2.5 dark:border-emerald-800/50 dark:bg-emerald-900/20 sm:p-3.5">
                                            <span
                                                class="text-[10px] sm:text-[11px] text-emerald-500 dark:text-emerald-400">Terbayar</span>
                                            <p
                                                class="text-sm sm:text-lg font-bold text-emerald-600 dark:text-emerald-400 tabular-nums mt-0.5">
                                                Rp {{ number_format($budgetTotalPaid, 0, ',', '.') }}</p>
                                        </div>
                                        <div
                                            class="rounded-2xl border border-amber-200/70 bg-amber-50/70 p-2.5 dark:border-amber-800/50 dark:bg-amber-900/20 sm:p-3.5">
                                            <span class="text-[10px] text-amber-500 dark:text-amber-400 sm:text-[11px]">Sisa
                                                Vendor</span>
                                            <p
                                                class="mt-0.5 text-sm font-bold text-amber-600 dark:text-amber-400 tabular-nums sm:text-lg">
                                                Rp {{ number_format($vendorTotalRemaining, 0, ',', '.') }}</p>
                                        </div>
                                    </div>

                                    {{-- Progress Bar --}}
                                    <div
                                        class="mb-5 p-3 sm:p-4 rounded-xl border border-neutral-200/70 dark:border-secondary-700/50 bg-neutral-50/60 dark:bg-secondary-700/30">
                                        <div class="flex items-center justify-between mb-2">
                                            <span
                                                class="text-[11px] sm:text-xs font-semibold text-secondary-800 dark:text-neutral-100">Progres
                                                Pembayaran</span>
                                            <span
                                                class="text-[11px] sm:text-xs font-bold text-emerald-600 dark:text-emerald-400 tabular-nums">{{ $budgetPaidPercent }}%</span>
                                        </div>
                                        <div
                                            class="w-full h-2 sm:h-2.5 bg-neutral-200 dark:bg-secondary-600 rounded-full overflow-hidden">
                                            <div class="h-full bg-emerald-500 rounded-full transition-all duration-500"
                                                style="width: {{ $budgetPaidPercent }}%"></div>
                                        </div>
                                        <div class="flex items-center justify-between mt-1.5">
                                            <span class="text-[10px] text-neutral-400 dark:text-neutral-500">Rp
                                                {{ number_format($budgetTotalPaid, 0, ',', '.') }} terbayar</span>
                                            <span class="text-[10px] text-neutral-400 dark:text-neutral-500">Rp
                                                {{ number_format($budgetTotalEstimated, 0, ',', '.') }} total</span>
                                        </div>
                                    </div>

                                    {{-- Toggle Filter --}}
                                    <div
                                        class="mb-5 flex items-center gap-1 overflow-x-auto rounded-2xl bg-neutral-100 p-1 dark:bg-secondary-700/50">
                                        <button type="button" @click="budgetFilter = 'ALL'"
                                            :class="budgetFilter === 'ALL' ? 'bg-white dark:bg-secondary-800 text-secondary-800 dark:text-neutral-100 shadow-sm' : 'text-neutral-500 dark:text-neutral-400 hover:text-secondary-700 dark:hover:text-neutral-300'"
                                            class="flex items-center justify-center gap-1.5 px-3 py-2 rounded-lg text-xs font-semibold transition-all duration-200 whitespace-nowrap">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                                            </svg>
                                            Semua
                                        </button>
                                        @foreach($budgetGroups as $groupCode => $group)
                                            <button type="button" @click="budgetFilter = '{{ $groupCode }}'"
                                                :class="budgetFilter === '{{ $groupCode }}' ? 'bg-white dark:bg-secondary-800 text-secondary-800 dark:text-neutral-100 shadow-sm' : 'text-neutral-500 dark:text-neutral-400 hover:text-secondary-700 dark:hover:text-neutral-300'"
                                                class="flex items-center justify-center gap-1.5 px-3 py-2 rounded-lg text-xs font-semibold transition-all duration-200 whitespace-nowrap">
                                                {{ $group['label'] }}
                                                <span class="text-[10px] px-1.5 py-0.5 rounded-full"
                                                    :class="budgetFilter === '{{ $groupCode }}' ? 'bg-emerald-100 dark:bg-emerald-900/40 text-emerald-600 dark:text-emerald-400' : 'bg-neutral-200 dark:bg-secondary-600 text-neutral-600 dark:text-neutral-300'">{{ $group['items']->count() }}</span>
                                            </button>
                                        @endforeach
                                    </div>

                                    @if($budgetItems->isEmpty())
                                        <div
                                            class="px-5 py-10 text-center text-sm text-neutral-400 dark:text-neutral-500 border border-dashed border-neutral-200 dark:border-secondary-600 rounded-xl">
                                            Belum ada anggaran. Tambahkan item untuk mulai mengelola budget.
                                        </div>
                                    @else
                                        <div class="space-y-4">
                                            @foreach($budgetGroups as $groupCode => $group)
                                                @php
                                                    $groupEstimated = (float) $group['items']->sum('estimated_cost');
                                                    $groupPaid = (float) $group['items']->sum('paid_amount');
                                                    $groupRemaining = max(0, $groupEstimated - $groupPaid);
                                                    $groupPaidPercent = $groupEstimated > 0 ? round(($groupPaid / $groupEstimated) * 100) : 0;
                                                @endphp
                                                <div x-show="budgetFilter === 'ALL' || budgetFilter === '{{ $groupCode }}'"
                                                    x-transition:enter="transition ease-out duration-200"
                                                    x-transition:enter-start="opacity-0 scale-95"
                                                    x-transition:enter-end="opacity-100 scale-100"
                                                    class="rounded-2xl border border-neutral-200/80 dark:border-secondary-700/60 overflow-hidden bg-white dark:bg-secondary-800">
                                                    <div
                                                        class="px-4 py-3 bg-neutral-50 dark:bg-secondary-700/40 border-b border-neutral-200/80 dark:border-secondary-700/60">
                                                        <div class="flex items-center justify-between gap-3 mb-2">
                                                            <h4 class="text-sm font-semibold text-secondary-800 dark:text-neutral-100">
                                                                {{ $group['label'] }}
                                                            </h4>
                                                            <div class="flex items-center gap-2">
                                                                <span
                                                                    class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 dark:bg-emerald-900/40 text-emerald-700 dark:text-emerald-300">
                                                                    {{ $groupPaidPercent }}% terbayar
                                                                </span>
                                                                <span
                                                                    class="text-[11px] font-semibold text-neutral-500 dark:text-neutral-400 tabular-nums">
                                                                    {{ $group['items']->count() }} item
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="flex items-center gap-4 text-[11px]">
                                                            <span class="text-neutral-400 dark:text-neutral-500">Budget: <span
                                                                    class="font-semibold text-secondary-700 dark:text-neutral-300">Rp
                                                                    {{ number_format($groupEstimated, 0, ',', '.') }}</span></span>
                                                            <span class="text-emerald-500 dark:text-emerald-400">Bayar: <span
                                                                    class="font-semibold">Rp
                                                                    {{ number_format($groupPaid, 0, ',', '.') }}</span></span>
                                                        </div>
                                                        <div
                                                            class="mt-2 h-1.5 bg-neutral-200 dark:bg-secondary-600 rounded-full overflow-hidden">
                                                            <div class="h-full bg-emerald-500 rounded-full transition-all duration-500"
                                                                style="width: {{ $groupPaidPercent }}%"></div>
                                                        </div>
                                                    </div>

                                                    <div class="p-3 space-y-2">
                                                        @foreach($group['items'] as $item)
                                                            @php
                                                                $itemPaidPercent = $item->estimated_cost > 0 ? round(($item->paid_amount / $item->estimated_cost) * 100) : 0;
                                                            @endphp
                                                            <div
                                                                class="group relative rounded-xl border border-neutral-150 dark:border-secondary-600/50 bg-neutral-50/50 dark:bg-secondary-700/30 hover:border-emerald-300 dark:hover:border-emerald-700/50 hover:bg-emerald-50/30 dark:hover:bg-emerald-900/10 transition-all duration-200">
                                                                <div class="p-3 sm:p-4">
                                                                    <div class="flex items-start justify-between gap-3">
                                                                        <div class="flex items-center gap-2 min-w-0">
                                                                            <span
                                                                                class="w-6 h-6 flex items-center justify-center rounded-lg text-[10px] font-bold text-white bg-emerald-500 shrink-0">{{ $loop->iteration }}</span>
                                                                            <p
                                                                                class="text-sm font-semibold text-secondary-800 dark:text-neutral-100 truncate">
                                                                                {{ $item->title }}
                                                                            </p>
                                                                            <span
                                                                                class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold {{ $statusStyles[$item->status] ?? $statusStyles['PENDING'] }} shrink-0">
                                                                                {{ $statusLabels[$item->status] ?? $item->status }}
                                                                            </span>
                                                                        </div>
                                                                        <div
                                                                            class="flex items-center gap-1 shrink-0 sm:opacity-0 sm:group-hover:opacity-100 sm:focus-within:opacity-100 transition-opacity duration-150">
                                                                            <button type="button" x-data
                                                                                @click="$dispatch('open-modal', 'edit-item-{{ $item->id }}')"
                                                                                class="p-1.5 rounded-lg text-neutral-400 hover:text-primary dark:hover:text-primary-400 hover:bg-primary-50 dark:hover:bg-primary-900/20 transition-colors">
                                                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"
                                                                                    stroke="currentColor">
                                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                                        stroke-width="2"
                                                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                                                </svg>
                                                                            </button>
                                                                            <form
                                                                                action="{{ route('dashboard.planner.items.destroy', $item) }}"
                                                                                method="POST" onsubmit="return confirm('Hapus item ini?')">
                                                                                @csrf
                                                                                @method('DELETE')
                                                                                <button type="submit"
                                                                                    class="p-1.5 rounded-lg text-neutral-400 hover:text-red-600 dark:hover:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
                                                                                    <svg class="w-3.5 h-3.5" fill="none"
                                                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                                                        <path stroke-linecap="round"
                                                                                            stroke-linejoin="round" stroke-width="2"
                                                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                                                    </svg>
                                                                                </button>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                    <div class="mt-3 flex items-center gap-3 flex-wrap">
                                                                        <div class="flex items-center gap-1.5">
                                                                            <span
                                                                                class="text-[10px] text-neutral-400 dark:text-neutral-500">Budget:</span>
                                                                            <span
                                                                                class="text-xs font-semibold text-secondary-700 dark:text-neutral-200 tabular-nums">Rp
                                                                                {{ number_format($item->estimated_cost, 0, ',', '.') }}</span>
                                                                        </div>
                                                                        <span
                                                                            class="hidden sm:block w-px h-3.5 bg-neutral-200 dark:bg-secondary-600"></span>
                                                                        <div class="flex items-center gap-1.5">
                                                                            <span
                                                                                class="text-[10px] text-emerald-400 dark:text-emerald-500">Bayar:</span>
                                                                            <span
                                                                                class="text-xs font-semibold text-emerald-600 dark:text-emerald-400 tabular-nums">Rp
                                                                                {{ number_format($item->paid_amount, 0, ',', '.') }}</span>
                                                                        </div>
                                                                        <span
                                                                            class="ml-auto text-[10px] font-semibold text-emerald-600 dark:text-emerald-400 tabular-nums">{{ $itemPaidPercent }}%</span>
                                                                    </div>
                                                                    <div
                                                                        class="mt-2 h-1.5 bg-neutral-200 dark:bg-secondary-600 rounded-full overflow-hidden">
                                                                        <div class="h-full bg-emerald-500 rounded-full transition-all duration-500"
                                                                            style="width: {{ $itemPaidPercent }}%"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>

                                        {{-- Total Summary --}}
                                        <div
                                            class="mt-5 p-4 rounded-xl bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200/60 dark:border-emerald-700/40">
                                            <div class="flex items-center justify-between">
                                                <div>
                                                    <p class="text-sm font-bold text-secondary-800 dark:text-neutral-100">Total
                                                        Anggaran</p>
                                                    <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-0.5">Budget Rp
                                                        {{ number_format($grandTotalEstimated, 0, ',', '.') }} · Bayar Rp
                                                        {{ number_format($grandTotalPaid, 0, ',', '.') }}
                                                    </p>
                                                </div>
                                                <p class="text-xl font-bold text-emerald-700 dark:text-emerald-300 tabular-nums">Rp
                                                    {{ number_format($grandTotalRemaining, 0, ',', '.') }}
                                                </p>
                                            </div>
                                        </div>
                                    @endif
                                </div>

                            @else
                                <div class="mb-4 flex items-center justify-between gap-3">
                                    <div>
                                        <h3 class="font-semibold text-secondary-800 dark:text-neutral-100">
                                            {{ $pillar['label'] }}
                                        </h3>
                                        <p class="mt-0.5 text-xs text-neutral-500 dark:text-neutral-400">
                                            {{ count(\App\Models\WeddingPlannerItem::STATUSES) === 4 ? 'Kelola item persiapan ' . strtolower($pillar['label']) . '.' : '' }}
                                        </p>
                                    </div>
                                    <button type="button" x-data
                                        @click="setActiveTab('{{ $pillar['key'] }}'); $dispatch('open-modal', 'add-item-{{ $pillar['key'] }}')"
                                        class="inline-flex items-center gap-1.5 rounded-xl bg-primary px-3 py-1.5 text-xs font-semibold text-white transition-all hover:bg-primary-600">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 4v16m8-8H4" />
                                        </svg>
                                        Tambah Item
                                    </button>
                                </div>

                                @if($itemsByCategory[$pillar['key']]->isEmpty())
                                    <div
                                        class="rounded-2xl border border-dashed border-neutral-200 px-5 py-10 text-center text-sm text-neutral-400 dark:border-secondary-600 dark:text-neutral-500">
                                        Belum ada item pada pilar {{ $pillar['label'] }}.
                                    </div>
                                @else
                                    <div class="space-y-2.5">
                                        @foreach($itemsByCategory[$pillar['key']] as $item)
                                            <div
                                                class="flex items-start gap-3 rounded-2xl border border-neutral-200/80 bg-neutral-50/70 p-3.5 shadow-sm dark:border-secondary-700/50 dark:bg-secondary-700/30">
                                                <div class="min-w-0 flex-1">
                                                    <div class="flex items-center gap-2 flex-wrap">
                                                        <p class="text-sm font-semibold text-secondary-800 dark:text-neutral-100">
                                                            {{ $item->title }}
                                                        </p>
                                                        <span
                                                            class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold {{ $statusStyles[$item->status] ?? $statusStyles['PENDING'] }}">
                                                            {{ $statusLabels[$item->status] ?? $item->status }}
                                                        </span>
                                                    </div>
                                                    @if($item->description)
                                                        <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-1 line-clamp-2">
                                                            {{ $item->description }}
                                                        </p>
                                                    @endif
                                                    @if($item->event_date)
                                                        <p
                                                            class="text-xs text-neutral-400 dark:text-neutral-500 mt-1 flex items-center gap-1">
                                                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                            </svg>
                                                            {{ $item->event_date->translatedFormat('d M Y') }}
                                                        </p>
                                                    @endif

                                                    @if(in_array($pillar['key'], ['BUDGET', 'VENDOR']))
                                                        <div class="mt-2 grid grid-cols-3 gap-2 text-[11px]">
                                                            <div
                                                                class="px-2 py-1.5 rounded-lg bg-white dark:bg-secondary-700/50 border border-neutral-200/60 dark:border-secondary-600/40">
                                                                <span class="text-neutral-400 dark:text-neutral-500">Budget</span>
                                                                <p
                                                                    class="font-semibold text-secondary-700 dark:text-neutral-200 tabular-nums">
                                                                    Rp {{ number_format($item->estimated_cost, 0, ',', '.') }}</p>
                                                            </div>
                                                            <div
                                                                class="px-2 py-1.5 rounded-lg bg-white dark:bg-secondary-700/50 border border-neutral-200/60 dark:border-secondary-600/40">
                                                                <span class="text-neutral-400 dark:text-neutral-500">Bayar</span>
                                                                <p
                                                                    class="font-semibold text-emerald-600 dark:text-emerald-400 tabular-nums">
                                                                    Rp {{ number_format($item->paid_amount, 0, ',', '.') }}</p>
                                                            </div>
                                                            <div
                                                                class="px-2 py-1.5 rounded-lg bg-white dark:bg-secondary-700/50 border border-neutral-200/60 dark:border-secondary-600/40">
                                                                <span class="text-neutral-400 dark:text-neutral-500">Sisa</span>
                                                                <p class="font-semibold text-amber-600 dark:text-amber-400 tabular-nums">Rp
                                                                    {{ number_format(max(0, $item->remaining_balance), 0, ',', '.') }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    @endif

                                                    @if($item->vendor_contact)
                                                        <p class="text-xs text-neutral-400 dark:text-neutral-500 mt-1.5">
                                                            {{ $item->vendor_contact }}
                                                        </p>
                                                    @endif
                                                </div>
                                                <div class="flex-shrink-0 flex items-center gap-1">
                                                    <button type="button" x-data
                                                        @click="$dispatch('open-modal', 'edit-item-{{ $item->id }}')"
                                                        class="inline-flex items-center px-2.5 py-1.5 rounded-lg text-[11px] font-semibold text-primary dark:text-primary-400 hover:bg-primary-50 dark:hover:bg-primary-900/20 transition-colors">
                                                        Edit
                                                    </button>
                                                    <form action="{{ route('dashboard.planner.items.destroy', $item) }}" method="POST"
                                                        onsubmit="return confirm('Hapus item ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="inline-flex items-center px-2.5 py-1.5 rounded-lg text-[11px] font-semibold text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
                                                            Hapus
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>

    {{-- ─── Modals: Add Item ─── --}}
    @foreach($pillars as $pillar)
        @if(in_array($pillar['key'], ['CALENDAR', 'CHECKLIST', 'VENDOR']))
            @continue
        @endif
        <x-modal name="add-item-{{ $pillar['key'] }}">
            <div class="p-6">
                <div class="flex items-start justify-between gap-4 mb-5">
                    <div>
                        <h3 class="text-lg font-bold text-secondary-800 dark:text-neutral-100">Tambah Item
                            {{ $pillar['label'] }}
                        </h3>
                        <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-1">Simpan item baru ke pilar
                            {{ $pillar['label'] }}.
                        </p>
                    </div>
                    <button type="button" x-on:click="show = false" class="shrink-0 p-2 -m-2 text-neutral-400 hover:text-secondary-600 dark:hover:text-neutral-300 rounded-xl hover:bg-neutral-100 dark:hover:bg-secondary-700 transition-colors">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <form action="{{ route('dashboard.planner.items.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <input type="hidden" name="category" value="{{ $pillar['key'] }}">

                    <div>
                        <x-input-label for="add-title-{{ $pillar['key'] }}" value="Judul" />
                        <x-text-input id="add-title-{{ $pillar['key'] }}" name="title" class="mt-1 block w-full"
                            placeholder="cth: Booking venue" required />
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>

                    @if(!in_array($pillar['key'], ['PRE_WEDDING', 'SESERAHAN', 'ENGAGEMENT', 'BUDGET']))
                        <div>
                            <x-input-label for="add-desc-{{ $pillar['key'] }}" value="Deskripsi" />
                            <textarea id="add-desc-{{ $pillar['key'] }}" name="description" rows="2"
                                class="mt-1 block w-full border-neutral-300 dark:border-neutral-600 dark:bg-secondary-700 dark:text-neutral-200 focus:border-primary-500 focus:ring-primary-500 rounded-xl shadow-sm"
                                placeholder="Catatan opsional"></textarea>
                        </div>
                    @endif

                    <div class="grid grid-cols-2 gap-4">
                        @if(!in_array($pillar['key'], ['PRE_WEDDING', 'SESERAHAN', 'ENGAGEMENT', 'BUDGET']))
                            <div>
                                <x-input-label for="add-date-{{ $pillar['key'] }}" value="Tanggal" />
                                <x-text-input id="add-date-{{ $pillar['key'] }}" name="event_date" type="date"
                                    class="mt-1 block w-full" />
                            </div>
                        @endif
                        <div
                            class="{{ in_array($pillar['key'], ['PRE_WEDDING', 'SESERAHAN', 'ENGAGEMENT', 'BUDGET']) ? 'col-span-2' : '' }}">
                            <x-input-label value="Status" />
                            <div class="mt-2 grid grid-cols-2 sm:grid-cols-4 gap-2" x-data="{ selected: '' }">
                                <label class="relative flex items-center gap-2.5 cursor-pointer rounded-xl border-2 px-3 py-2.5 transition-all duration-200" :class="selected === 'PENDING' ? 'border-neutral-500 dark:border-neutral-400 bg-neutral-100 dark:bg-secondary-600 shadow-md' : 'border-neutral-200 dark:border-secondary-600 hover:border-neutral-300 dark:hover:border-secondary-500'">
                                    <input type="radio" name="status" value="PENDING" x-model="selected" class="peer sr-only">
                                    <span class="flex-shrink-0 transition-colors duration-200" :class="selected === 'PENDING' ? 'text-neutral-800 dark:text-neutral-100' : 'text-neutral-400 dark:text-neutral-500'">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><circle cx="12" cy="12" r="4" fill="currentColor"/></svg>
                                    </span>
                                    <span class="text-sm font-medium transition-colors duration-200" :class="selected === 'PENDING' ? 'text-neutral-800 dark:text-neutral-100' : 'text-neutral-500 dark:text-neutral-400'">{{ $statusLabels['PENDING'] }}</span>
                                </label>
                                <label class="relative flex items-center gap-2.5 cursor-pointer rounded-xl border-2 px-3 py-2.5 transition-all duration-200" :class="selected === 'IN_PROGRESS' ? 'border-blue-500 dark:border-blue-400 bg-blue-100 dark:bg-blue-900/50 shadow-md' : 'border-neutral-200 dark:border-secondary-600 hover:border-neutral-300 dark:hover:border-secondary-500'">
                                    <input type="radio" name="status" value="IN_PROGRESS" x-model="selected" class="peer sr-only">
                                    <span class="flex-shrink-0 transition-colors duration-200" :class="selected === 'IN_PROGRESS' ? 'text-blue-600 dark:text-blue-400' : 'text-neutral-400 dark:text-neutral-500'">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    </span>
                                    <span class="text-sm font-medium transition-colors duration-200" :class="selected === 'IN_PROGRESS' ? 'text-blue-700 dark:text-blue-200' : 'text-neutral-500 dark:text-neutral-400'">{{ $statusLabels['IN_PROGRESS'] }}</span>
                                </label>
                                <label class="relative flex items-center gap-2.5 cursor-pointer rounded-xl border-2 px-3 py-2.5 transition-all duration-200" :class="selected === 'COMPLETED' ? 'border-emerald-500 dark:border-emerald-400 bg-emerald-100 dark:bg-emerald-900/50 shadow-md' : 'border-neutral-200 dark:border-secondary-600 hover:border-neutral-300 dark:hover:border-secondary-500'">
                                    <input type="radio" name="status" value="COMPLETED" x-model="selected" class="peer sr-only">
                                    <span class="flex-shrink-0 transition-colors duration-200" :class="selected === 'COMPLETED' ? 'text-emerald-600 dark:text-emerald-400' : 'text-neutral-400 dark:text-neutral-500'">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    </span>
                                    <span class="text-sm font-medium transition-colors duration-200" :class="selected === 'COMPLETED' ? 'text-emerald-700 dark:text-emerald-200' : 'text-neutral-500 dark:text-neutral-400'">{{ $statusLabels['COMPLETED'] }}</span>
                                </label>
                                <label class="relative flex items-center gap-2.5 cursor-pointer rounded-xl border-2 px-3 py-2.5 transition-all duration-200" :class="selected === 'CANCELLED' ? 'border-red-500 dark:border-red-400 bg-red-100 dark:bg-red-900/50 shadow-md' : 'border-neutral-200 dark:border-secondary-600 hover:border-neutral-300 dark:hover:border-secondary-500'">
                                    <input type="radio" name="status" value="CANCELLED" x-model="selected" class="peer sr-only">
                                    <span class="flex-shrink-0 transition-colors duration-200" :class="selected === 'CANCELLED' ? 'text-red-600 dark:text-red-400' : 'text-neutral-400 dark:text-neutral-500'">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                    </span>
                                    <span class="text-sm font-medium transition-colors duration-200" :class="selected === 'CANCELLED' ? 'text-red-700 dark:text-red-200' : 'text-neutral-500 dark:text-neutral-400'">{{ $statusLabels['CANCELLED'] }}</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    @if($pillar['key'] === 'BUDGET')
                        <div>
                            <x-input-label for="add-budget-group" value="Kategori Anggaran" />
                            <select id="add-budget-group" name="subcategory"
                                class="mt-1 block w-full border-neutral-300 dark:border-neutral-600 dark:bg-secondary-700 dark:text-neutral-200 focus:border-primary-500 focus:ring-primary-500 rounded-xl shadow-sm"
                                required>
                                @foreach(\App\Models\WeddingPlannerItem::BUDGET_CATEGORIES as $code => $config)
                                    <option value="{{ $code }}">{{ $config['label'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="add-est-{{ $pillar['key'] }}" value="Budget (Rp)" />
                                <x-text-input id="add-est-{{ $pillar['key'] }}" name="estimated_cost" type="text" inputmode="numeric"
                                    data-rupiah value="0" class="mt-1 block w-full" />
                            </div>
                            <div>
                                <x-input-label for="add-paid-{{ $pillar['key'] }}" value="Bayar (Rp)" />
                                <x-text-input id="add-paid-{{ $pillar['key'] }}" name="paid_amount" type="text" inputmode="numeric"
                                    data-rupiah value="0" class="mt-1 block w-full" />
                            </div>
                        </div>
                    @elseif($pillar['key'] === 'VENDOR')
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="add-est-{{ $pillar['key'] }}" value="Estimasi (Rp)" />
                                <x-text-input id="add-est-{{ $pillar['key'] }}" name="estimated_cost" type="text" inputmode="numeric"
                                    data-rupiah value="0" class="mt-1 block w-full" />
                            </div>
                            <div>
                                <x-input-label for="add-paid-{{ $pillar['key'] }}" value="Bayar (Rp)" />
                                <x-text-input id="add-paid-{{ $pillar['key'] }}" name="paid_amount" type="text" inputmode="numeric"
                                    data-rupiah value="0" class="mt-1 block w-full" />
                            </div>
                        </div>
                        <div>
                            <x-input-label for="add-contact-{{ $pillar['key'] }}" value="Kontak Vendor" />
                            <x-text-input id="add-contact-{{ $pillar['key'] }}" name="vendor_contact" class="mt-1 block w-full"
                                placeholder="cth: 0812-3456-7890" />
                        </div>
                    @elseif($pillar['key'] === 'PRE_WEDDING')
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="add-est-{{ $pillar['key'] }}" value="Budget (Rp)" />
                                <x-text-input id="add-est-{{ $pillar['key'] }}" name="estimated_cost" type="text" inputmode="numeric"
                                    data-rupiah value="0" class="mt-1 block w-full" />
                            </div>
                            <div>
                                <x-input-label for="add-paid-{{ $pillar['key'] }}" value="Bayar (Rp)" />
                                <x-text-input id="add-paid-{{ $pillar['key'] }}" name="paid_amount" type="text" inputmode="numeric"
                                    data-rupiah value="0" class="mt-1 block w-full" />
                            </div>
                        </div>
                    @endif

                    @if($pillar['key'] === 'ENGAGEMENT')
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="add-pria-{{ $pillar['key'] }}" value="Biaya Pria (Rp)" />
<x-text-input id="add-pria-{{ $pillar['key'] }}" name="cost_pria" type="text" inputmode="numeric"
                                        data-rupiah value="0" class="mt-1 block w-full" />
                            </div>
                            <div>
                                <x-input-label for="add-wanita-{{ $pillar['key'] }}" value="Biaya Wanita (Rp)" />
<x-text-input id="add-wanita-{{ $pillar['key'] }}" name="cost_wanita" type="text" inputmode="numeric"
                                        data-rupiah value="0" class="mt-1 block w-full" />
                            </div>
                        </div>
                    @endif

                    @if($pillar['key'] === 'SESERAHAN')
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="add-party-{{ $pillar['key'] }}" value="Pihak" />
                                <select id="add-party-{{ $pillar['key'] }}" name="subcategory"
                                    class="mt-1 block w-full border-neutral-300 dark:border-neutral-600 dark:bg-secondary-700 dark:text-neutral-200 focus:border-primary-500 focus:ring-primary-500 rounded-xl shadow-sm"
                                    required>
                                    <option value="PRIA">Pria</option>
                                    <option value="WANITA">Wanita</option>
                                </select>
                            </div>
                            <div>
                                <x-input-label for="add-est-{{ $pillar['key'] }}" value="Biaya (Rp)" />
                                <x-text-input id="add-est-{{ $pillar['key'] }}" name="estimated_cost" type="text" inputmode="numeric"
                                    data-rupiah value="0" class="mt-1 block w-full" />
                            </div>
                        </div>
                    @endif

                    <div class="flex items-center justify-end gap-3 pt-4 mt-4 border-t border-neutral-100 dark:border-secondary-700">
                        <x-secondary-button type="button" x-on:click="show = false">Batal</x-secondary-button>
                        <x-primary-button type="submit">Simpan Item</x-primary-button>
                    </div>
                </form>
            </div>
        </x-modal>
    @endforeach

    {{-- ─── Modals: Edit Item ─── --}}
    @foreach($plannerItems as $item)
        <x-modal name="edit-item-{{ $item->id }}">
            <div class="p-6">
                <div class="flex items-start justify-between gap-4 mb-5">
                    <div>
                        <h3 class="text-lg font-bold text-secondary-800 dark:text-neutral-100">Edit Item</h3>
                        <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-1">{{ $item->title }}</p>
                    </div>
                    <button type="button" x-on:click="show = false" class="shrink-0 p-2 -m-2 text-neutral-400 hover:text-secondary-600 dark:hover:text-neutral-300 rounded-xl hover:bg-neutral-100 dark:hover:bg-secondary-700 transition-colors">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <form action="{{ route('dashboard.planner.items.update', $item) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="category" value="{{ $item->category }}">

                    <div>
                        <x-input-label for="edit-title-{{ $item->id }}" value="Judul" />
                        <x-text-input id="edit-title-{{ $item->id }}" name="title" class="mt-1 block w-full"
                            value="{{ old('title', $item->title) }}" required />
                    </div>

                    @if($item->category === 'VENDOR')
                        <div>
                            <x-input-label for="edit-vendor-type-{{ $item->id }}" value="Kategori Vendor" />
                            <select id="edit-vendor-type-{{ $item->id }}" name="vendor_type"
                                class="mt-1 block w-full border-neutral-300 dark:border-neutral-600 dark:bg-secondary-700 dark:text-neutral-200 focus:border-primary-500 focus:ring-primary-500 rounded-xl shadow-sm"
                                required>
                                @foreach(\App\Models\WeddingPlannerItem::VENDOR_TYPES as $code => $label)
                                    <option value="{{ $code }}" @selected($item->vendor_type === $code)>{{ $label }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('vendor_type')" class="mt-2" />
                        </div>
                    @endif

                    @if($item->category === 'ENGAGEMENT')
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="edit-pria-{{ $item->id }}" value="Biaya Pria (Rp)" />
<x-text-input id="edit-pria-{{ $item->id }}" name="cost_pria" type="text" inputmode="numeric"
                                        data-rupiah
                                        value="{{ old('cost_pria', (float) $item->cost_pria) }}" class="mt-1 block w-full" />
                            </div>
                            <div>
                                <x-input-label for="edit-wanita-{{ $item->id }}" value="Biaya Wanita (Rp)" />
<x-text-input id="edit-wanita-{{ $item->id }}" name="cost_wanita" type="text" inputmode="numeric"
                                        data-rupiah
                                        value="{{ old('cost_wanita', (float) $item->cost_wanita) }}"
                                        class="mt-1 block w-full" />
                            </div>
                        </div>
                    @endif

                    @if($item->category === 'SESERAHAN')
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="edit-party-{{ $item->id }}" value="Pihak" />
                                <select id="edit-party-{{ $item->id }}" name="subcategory"
                                    class="mt-1 block w-full border-neutral-300 dark:border-neutral-600 dark:bg-secondary-700 dark:text-neutral-200 focus:border-primary-500 focus:ring-primary-500 rounded-xl shadow-sm"
                                    required>
                                    <option value="PRIA" @selected($item->subcategory === 'PRIA')>Pria</option>
                                    <option value="WANITA" @selected($item->subcategory === 'WANITA')>Wanita</option>
                                </select>
                            </div>
                            <div>
                                <x-input-label for="edit-est-{{ $item->id }}" value="Biaya (Rp)" />
                                <x-text-input id="edit-est-{{ $item->id }}" name="estimated_cost" type="text" inputmode="numeric"
                                    data-rupiah class="mt-1 block w-full"
                                    value="{{ old('estimated_cost', $item->estimated_cost) }}" />
                            </div>
                        </div>
                    @endif

                    @if($item->category === 'CALENDAR')
                        <div>
                            <x-input-label for="edit-event-date-{{ $item->id }}" value="Tanggal" />
                            <x-text-input id="edit-event-date-{{ $item->id }}" name="event_date" type="date"
                                class="mt-1 block w-full"
                                value="{{ old('event_date', $item->event_date?->format('Y-m-d')) }}" />
                        </div>
                        <div>
                            <x-input-label for="edit-notes-{{ $item->id }}" value="Catatan" />
                            <textarea id="edit-notes-{{ $item->id }}" name="description" rows="2"
                                class="mt-1 block w-full border-neutral-300 dark:border-neutral-600 dark:bg-secondary-700 dark:text-neutral-200 focus:border-primary-500 focus:ring-primary-500 rounded-xl shadow-sm"
                                placeholder="Catatan event">{{ old('description', $item->description) }}</textarea>
                        </div>
                    @endif

                    <div>
                        <x-input-label value="Status" />
                        <div class="mt-2 grid grid-cols-2 sm:grid-cols-4 gap-2" x-data="{ selected: '{{ $item->status }}' }">
                            <label class="relative flex items-center gap-2.5 cursor-pointer rounded-xl border-2 px-3 py-2.5 transition-all duration-200" :class="selected === 'PENDING' ? 'border-neutral-500 dark:border-neutral-400 bg-neutral-100 dark:bg-secondary-600 shadow-md' : 'border-neutral-200 dark:border-secondary-600 hover:border-neutral-300 dark:hover:border-secondary-500'">
                                <input type="radio" name="status" value="PENDING" x-model="selected" class="peer sr-only">
                                <span class="flex-shrink-0 transition-colors duration-200" :class="selected === 'PENDING' ? 'text-neutral-800 dark:text-neutral-100' : 'text-neutral-400 dark:text-neutral-500'">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><circle cx="12" cy="12" r="4" fill="currentColor"/></svg>
                                </span>
                                <span class="text-sm font-medium transition-colors duration-200" :class="selected === 'PENDING' ? 'text-neutral-800 dark:text-neutral-100' : 'text-neutral-500 dark:text-neutral-400'">{{ $statusLabels['PENDING'] }}</span>
                            </label>
                            <label class="relative flex items-center gap-2.5 cursor-pointer rounded-xl border-2 px-3 py-2.5 transition-all duration-200" :class="selected === 'IN_PROGRESS' ? 'border-blue-500 dark:border-blue-400 bg-blue-100 dark:bg-blue-900/50 shadow-md' : 'border-neutral-200 dark:border-secondary-600 hover:border-neutral-300 dark:hover:border-secondary-500'">
                                <input type="radio" name="status" value="IN_PROGRESS" x-model="selected" class="peer sr-only">
                                <span class="flex-shrink-0 transition-colors duration-200" :class="selected === 'IN_PROGRESS' ? 'text-blue-600 dark:text-blue-400' : 'text-neutral-400 dark:text-neutral-500'">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </span>
                                <span class="text-sm font-medium transition-colors duration-200" :class="selected === 'IN_PROGRESS' ? 'text-blue-700 dark:text-blue-200' : 'text-neutral-500 dark:text-neutral-400'">{{ $statusLabels['IN_PROGRESS'] }}</span>
                            </label>
                            <label class="relative flex items-center gap-2.5 cursor-pointer rounded-xl border-2 px-3 py-2.5 transition-all duration-200" :class="selected === 'COMPLETED' ? 'border-emerald-500 dark:border-emerald-400 bg-emerald-100 dark:bg-emerald-900/50 shadow-md' : 'border-neutral-200 dark:border-secondary-600 hover:border-neutral-300 dark:hover:border-secondary-500'">
                                <input type="radio" name="status" value="COMPLETED" x-model="selected" class="peer sr-only">
                                <span class="flex-shrink-0 transition-colors duration-200" :class="selected === 'COMPLETED' ? 'text-emerald-600 dark:text-emerald-400' : 'text-neutral-400 dark:text-neutral-500'">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                </span>
                                <span class="text-sm font-medium transition-colors duration-200" :class="selected === 'COMPLETED' ? 'text-emerald-700 dark:text-emerald-200' : 'text-neutral-500 dark:text-neutral-400'">{{ $statusLabels['COMPLETED'] }}</span>
                            </label>
                            <label class="relative flex items-center gap-2.5 cursor-pointer rounded-xl border-2 px-3 py-2.5 transition-all duration-200" :class="selected === 'CANCELLED' ? 'border-red-500 dark:border-red-400 bg-red-100 dark:bg-red-900/50 shadow-md' : 'border-neutral-200 dark:border-secondary-600 hover:border-neutral-300 dark:hover:border-secondary-500'">
                                <input type="radio" name="status" value="CANCELLED" x-model="selected" class="peer sr-only">
                                <span class="flex-shrink-0 transition-colors duration-200" :class="selected === 'CANCELLED' ? 'text-red-600 dark:text-red-400' : 'text-neutral-400 dark:text-neutral-500'">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                </span>
                                <span class="text-sm font-medium transition-colors duration-200" :class="selected === 'CANCELLED' ? 'text-red-700 dark:text-red-200' : 'text-neutral-500 dark:text-neutral-400'">{{ $statusLabels['CANCELLED'] }}</span>
                            </label>
                        </div>
                    </div>

                    @if($item->isFinancialCategory())
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="edit-est-{{ $item->id }}"
                                    value="{{ $item->category === 'PRE_WEDDING' ? 'Budget' : 'Estimasi' }} (Rp)" />
                                <x-text-input id="edit-est-{{ $item->id }}" name="estimated_cost" type="text" inputmode="numeric"
                                    data-rupiah class="mt-1 block w-full"
                                    value="{{ old('estimated_cost', $item->estimated_cost) }}" />
                            </div>
                            <div>
                                <x-input-label for="edit-paid-{{ $item->id }}"
                                    value="{{ $item->category === 'PRE_WEDDING' ? 'Bayar' : 'Terbayar' }} (Rp)" />
                                <x-text-input id="edit-paid-{{ $item->id }}" name="paid_amount" type="text" inputmode="numeric"
                                    data-rupiah class="mt-1 block w-full"
                                    value="{{ old('paid_amount', $item->paid_amount) }}" />
                            </div>
                        </div>
                        @if($item->category !== 'PRE_WEDDING')
                            <div>
                                <x-input-label for="edit-contact-{{ $item->id }}" value="Kontak Vendor" />
                                <x-text-input id="edit-contact-{{ $item->id }}" name="vendor_contact" class="mt-1 block w-full"
                                    value="{{ old('vendor_contact', $item->vendor_contact) }}" />
                            </div>
                        @endif
                    @endif

                    <div class="flex items-center justify-end gap-3 pt-4 mt-4 border-t border-neutral-100 dark:border-secondary-700">
                        <x-secondary-button type="button" x-on:click="show = false">Batal</x-secondary-button>
                        <x-primary-button type="submit">Perbarui Item</x-primary-button>
                    </div>
                </form>
            </div>
        </x-modal>
    @endforeach

    {{-- ─── Modals: Add Checklist ─── --}}
    <x-modal name="add-checklist">
        <div class="p-6">
            <div class="flex items-start justify-between gap-4 mb-5">
                <div>
                    <h3 class="text-lg font-bold text-secondary-800 dark:text-neutral-100">Tambah Checklist</h3>
                    <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-1">Tambahkan checklist custom sesuai kebutuhan.</p>
                </div>
                <button type="button" x-on:click="show = false" class="shrink-0 p-2 -m-2 text-neutral-400 hover:text-secondary-600 dark:hover:text-neutral-300 rounded-xl hover:bg-neutral-100 dark:hover:bg-secondary-700 transition-colors">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <form action="{{ route('dashboard.planner.checklists.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <x-input-label for="add-checklist-category" value="Kategori" />
                    <select id="add-checklist-category" name="category_code"
                        class="mt-1 block w-full border-neutral-300 dark:border-neutral-600 dark:bg-secondary-700 dark:text-neutral-200 focus:border-primary-500 focus:ring-primary-500 rounded-xl shadow-sm"
                        required>
                        @foreach(\App\Models\WeddingChecklist::CATEGORIES as $code => $label)
                            <option value="{{ $code }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <x-input-label for="add-checklist-title" value="Nama Tugas" />
                    <x-text-input id="add-checklist-title" name="title" class="mt-1 block w-full"
                        placeholder="cth: Sewa mobil pengantin" required />
                    <x-input-error :messages="$errors->get('title')" class="mt-2" />
                </div>
                <div class="flex items-center justify-end gap-3 pt-4 mt-4 border-t border-neutral-100 dark:border-secondary-700">
                    <x-secondary-button type="button" x-on:click="show = false">Batal</x-secondary-button>
                    <x-primary-button type="submit">Simpan Checklist</x-primary-button>
                </div>
            </form>
        </div>
    </x-modal>

    {{-- ─── Modals: Add Vendor ─── --}}
    <x-modal name="add-vendor">
        <div class="p-6" x-data="{ vendorType: 'VENUE' }" x-on:set-vendor-type.window="vendorType = $event.detail.type">
            <div class="flex items-start justify-between gap-4 mb-5">
                <div>
                    <h3 class="text-lg font-bold text-secondary-800 dark:text-neutral-100">Tambah Vendor</h3>
                    <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-1">Simpan vendor baru ke kategori persiapan.</p>
                </div>
                <button type="button" x-on:click="show = false" class="shrink-0 p-2 -m-2 text-neutral-400 hover:text-secondary-600 dark:hover:text-neutral-300 rounded-xl hover:bg-neutral-100 dark:hover:bg-secondary-700 transition-colors">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <form action="{{ route('dashboard.planner.items.store') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="category" value="VENDOR">

                <div>
                    <x-input-label for="add-vendor-type" value="Kategori Vendor" />
                    <select id="add-vendor-type" name="vendor_type" x-model="vendorType"
                        class="mt-1 block w-full border-neutral-300 dark:border-neutral-600 dark:bg-secondary-700 dark:text-neutral-200 focus:border-primary-500 focus:ring-primary-500 rounded-xl shadow-sm"
                        required>
                        @foreach(\App\Models\WeddingPlannerItem::VENDOR_TYPES as $code => $label)
                            <option value="{{ $code }}">{{ $label }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('vendor_type')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="add-vendor-title" value="Nama Vendor" />
                    <x-text-input id="add-vendor-title" name="title" class="mt-1 block w-full"
                        placeholder="cth: Venue Ballroom Grand" required />
                    <x-input-error :messages="$errors->get('title')" class="mt-2" />
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <x-input-label for="add-vendor-est" value="Estimasi (Rp)" />
                        <x-text-input id="add-vendor-est" name="estimated_cost" type="text" inputmode="numeric"
                            data-rupiah value="0" class="mt-1 block w-full" />
                    </div>
                    <div>
                        <x-input-label for="add-vendor-paid" value="Bayar (Rp)" />
                        <x-text-input id="add-vendor-paid" name="paid_amount" type="text" inputmode="numeric"
                            data-rupiah value="0" class="mt-1 block w-full" />
                    </div>
                </div>

                <div>
                    <x-input-label for="add-vendor-contact" value="Kontak Vendor" />
                    <x-text-input id="add-vendor-contact" name="vendor_contact" class="mt-1 block w-full"
                        placeholder="cth: 0812-3456-7890" />
                </div>

                <div>
                    <x-input-label value="Status" />
                    <div class="mt-2 grid grid-cols-2 sm:grid-cols-4 gap-2" x-data="{ selected: '' }">
                        <label class="relative flex items-center gap-2.5 cursor-pointer rounded-xl border-2 px-3 py-2.5 transition-all duration-200" :class="selected === 'PENDING' ? 'border-neutral-500 dark:border-neutral-400 bg-neutral-100 dark:bg-secondary-600 shadow-md' : 'border-neutral-200 dark:border-secondary-600 hover:border-neutral-300 dark:hover:border-secondary-500'">
                            <input type="radio" name="status" value="PENDING" x-model="selected" class="peer sr-only">
                            <span class="flex-shrink-0 transition-colors duration-200" :class="selected === 'PENDING' ? 'text-neutral-800 dark:text-neutral-100' : 'text-neutral-400 dark:text-neutral-500'">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><circle cx="12" cy="12" r="4" fill="currentColor"/></svg>
                            </span>
                            <span class="text-sm font-medium transition-colors duration-200" :class="selected === 'PENDING' ? 'text-neutral-800 dark:text-neutral-100' : 'text-neutral-500 dark:text-neutral-400'">{{ $statusLabels['PENDING'] }}</span>
                        </label>
                        <label class="relative flex items-center gap-2.5 cursor-pointer rounded-xl border-2 px-3 py-2.5 transition-all duration-200" :class="selected === 'IN_PROGRESS' ? 'border-blue-500 dark:border-blue-400 bg-blue-100 dark:bg-blue-900/50 shadow-md' : 'border-neutral-200 dark:border-secondary-600 hover:border-neutral-300 dark:hover:border-secondary-500'">
                            <input type="radio" name="status" value="IN_PROGRESS" x-model="selected" class="peer sr-only">
                            <span class="flex-shrink-0 transition-colors duration-200" :class="selected === 'IN_PROGRESS' ? 'text-blue-600 dark:text-blue-400' : 'text-neutral-400 dark:text-neutral-500'">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </span>
                            <span class="text-sm font-medium transition-colors duration-200" :class="selected === 'IN_PROGRESS' ? 'text-blue-700 dark:text-blue-200' : 'text-neutral-500 dark:text-neutral-400'">{{ $statusLabels['IN_PROGRESS'] }}</span>
                        </label>
                        <label class="relative flex items-center gap-2.5 cursor-pointer rounded-xl border-2 px-3 py-2.5 transition-all duration-200" :class="selected === 'COMPLETED' ? 'border-emerald-500 dark:border-emerald-400 bg-emerald-100 dark:bg-emerald-900/50 shadow-md' : 'border-neutral-200 dark:border-secondary-600 hover:border-neutral-300 dark:hover:border-secondary-500'">
                            <input type="radio" name="status" value="COMPLETED" x-model="selected" class="peer sr-only">
                            <span class="flex-shrink-0 transition-colors duration-200" :class="selected === 'COMPLETED' ? 'text-emerald-600 dark:text-emerald-400' : 'text-neutral-400 dark:text-neutral-500'">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            </span>
                            <span class="text-sm font-medium transition-colors duration-200" :class="selected === 'COMPLETED' ? 'text-emerald-700 dark:text-emerald-200' : 'text-neutral-500 dark:text-neutral-400'">{{ $statusLabels['COMPLETED'] }}</span>
                        </label>
                        <label class="relative flex items-center gap-2.5 cursor-pointer rounded-xl border-2 px-3 py-2.5 transition-all duration-200" :class="selected === 'CANCELLED' ? 'border-red-500 dark:border-red-400 bg-red-100 dark:bg-red-900/50 shadow-md' : 'border-neutral-200 dark:border-secondary-600 hover:border-neutral-300 dark:hover:border-secondary-500'">
                            <input type="radio" name="status" value="CANCELLED" x-model="selected" class="peer sr-only">
                            <span class="flex-shrink-0 transition-colors duration-200" :class="selected === 'CANCELLED' ? 'text-red-600 dark:text-red-400' : 'text-neutral-400 dark:text-neutral-500'">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            </span>
                            <span class="text-sm font-medium transition-colors duration-200" :class="selected === 'CANCELLED' ? 'text-red-700 dark:text-red-200' : 'text-neutral-500 dark:text-neutral-400'">{{ $statusLabels['CANCELLED'] }}</span>
                        </label>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 mt-4 border-t border-neutral-100 dark:border-secondary-700">
                    <x-secondary-button type="button" x-on:click="show = false">Batal</x-secondary-button>
                    <x-primary-button type="submit">Simpan Vendor</x-primary-button>
                </div>
            </form>
        </div>
    </x-modal>

    {{-- ─── Modals: Edit Checklist (custom only) ─── --}}
    @foreach($checklists as $item)
        @if($item->is_preset)
            @continue
        @endif
        <x-modal name="edit-checklist-{{ $item->id }}">
            <div class="p-6">
                <div class="flex items-start justify-between gap-4 mb-5">
                    <div>
                        <h3 class="text-lg font-bold text-secondary-800 dark:text-neutral-100">Edit Checklist</h3>
                        <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-1">{{ $item->title }}</p>
                    </div>
                    <button type="button" x-on:click="show = false" class="shrink-0 p-2 -m-2 text-neutral-400 hover:text-secondary-600 dark:hover:text-neutral-300 rounded-xl hover:bg-neutral-100 dark:hover:bg-secondary-700 transition-colors">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <form action="{{ route('dashboard.planner.checklists.update', $item) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PATCH')
                    <div>
                        <x-input-label for="edit-checklist-category-{{ $item->id }}" value="Kategori" />
                        <select id="edit-checklist-category-{{ $item->id }}" name="category_code"
                            class="mt-1 block w-full border-neutral-300 dark:border-neutral-600 dark:bg-secondary-700 dark:text-neutral-200 focus:border-primary-500 focus:ring-primary-500 rounded-xl shadow-sm"
                            required>
                            @foreach(\App\Models\WeddingChecklist::CATEGORIES as $code => $label)
                                <option value="{{ $code }}" @selected($item->category_code === $code)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <x-input-label for="edit-checklist-title-{{ $item->id }}" value="Nama Tugas" />
                        <x-text-input id="edit-checklist-title-{{ $item->id }}" name="title" class="mt-1 block w-full"
                            value="{{ old('title', $item->title) }}" required />
                    </div>
                    <div>
                        <x-input-label for="edit-checklist-desc-{{ $item->id }}" value="Deskripsi" />
                        <textarea id="edit-checklist-desc-{{ $item->id }}" name="description" rows="2"
                            class="mt-1 block w-full border-neutral-300 dark:border-neutral-600 dark:bg-secondary-700 dark:text-neutral-200 focus:border-primary-500 focus:ring-primary-500 rounded-xl shadow-sm">{{ old('description', $item->description) }}</textarea>
                    </div>
                    <div class="flex items-center justify-end gap-3 pt-4 mt-4 border-t border-neutral-100 dark:border-secondary-700">
                        <x-secondary-button type="button" x-on:click="show = false">Batal</x-secondary-button>
                        <x-primary-button type="submit">Perbarui Checklist</x-primary-button>
                    </div>
                </form>
            </div>
        </x-modal>
    @endforeach

    {{-- ─── Modals: Add Calendar Event ─── --}}
    <div x-data="{ show: false, selectedDate: '' }"
        x-init="$watch('show', val => { if(val && window.__selectedCalendarDate) { selectedDate = window.__selectedCalendarDate; window.__selectedCalendarDate = null; } })"
        @open-calendar-modal.window="show = true"
        x-cloak>
        <div x-show="show" @click.away="show = false" @keydown.escape.window="show = false"
            class="fixed inset-0 z-50 overflow-y-auto px-4 py-6 sm:px-0">
            <div x-show="show" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                class="fixed inset-0 transform transition-all" @click="show = false">
                <div class="absolute inset-0 bg-secondary-900/60 backdrop-blur-sm dark:bg-secondary-950/80"></div>
            </div>
            <div x-show="show" x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                class="mb-6 bg-white dark:bg-secondary-800 rounded-2xl overflow-hidden shadow-2xl ring-1 ring-black/5 dark:ring-white/10 transform transition-all sm:w-full sm:max-w-2xl sm:mx-auto">
                <div class="p-6">
                    <div class="flex items-start justify-between gap-4 mb-5">
                        <div>
                            <h3 class="text-lg font-bold text-secondary-800 dark:text-neutral-100">Tambah Event</h3>
                            <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-1">Tambahkan jadwal atau catatan ke
                                kalender.</p>
                        </div>
                        <button type="button" @click="show = false" class="shrink-0 p-2 -m-2 text-neutral-400 hover:text-secondary-600 dark:hover:text-neutral-300 rounded-xl hover:bg-neutral-100 dark:hover:bg-secondary-700 transition-colors">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>

                    <form action="{{ route('dashboard.planner.items.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <input type="hidden" name="category" value="CALENDAR">
                        <input type="hidden" name="event_date" :value="selectedDate">
                        <input type="hidden" name="status" value="PENDING">
                        <div>
                            <x-input-label for="add-calendar-title" value="Judul Event" />
                            <x-text-input id="add-calendar-title" name="title" class="mt-1 block w-full"
                                placeholder="cth: Fitting Baju Pengantin" required />
                        </div>

                        <div>
                            <x-input-label for="add-calendar-notes" value="Catatan (Opsional)" />
                            <textarea id="add-calendar-notes" name="description" rows="2"
                                class="mt-1 block w-full border-neutral-300 dark:border-neutral-600 dark:bg-secondary-700 dark:text-neutral-200 focus:border-primary-500 focus:ring-primary-500 rounded-xl shadow-sm"
                                placeholder="cth: Konfirmasi vendor terlebih dahulu"></textarea>
                        </div>

                        <div class="flex items-center justify-end gap-3 pt-4 mt-4 border-t border-neutral-100 dark:border-secondary-700">
                            <x-secondary-button type="button" @click="show = false">Batal</x-secondary-button>
                            <x-primary-button type="submit">Simpan Event</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- ─── Modals: Add Rundown ─── --}}
    <x-modal name="add-rundown">
        <div class="p-6">
            <div class="flex items-start justify-between gap-4 mb-5">
                <div>
                    <h3 class="text-lg font-bold text-secondary-800 dark:text-neutral-100">Tambah Rundown</h3>
                    <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-1">Tambahkan jadwal kegiatan Hari H.</p>
                </div>
                <button type="button" x-on:click="show = false" class="shrink-0 p-2 -m-2 text-neutral-400 hover:text-secondary-600 dark:hover:text-neutral-300 rounded-xl hover:bg-neutral-100 dark:hover:bg-secondary-700 transition-colors">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <form action="{{ route('dashboard.planner.rundowns.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <x-input-label for="add-rundown-name" value="Nama Kegiatan" />
                    <x-text-input id="add-rundown-name" name="activity_name" class="mt-1 block w-full"
                        placeholder="cth: Akad Nikah" required />
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <x-input-label for="add-rundown-start" value="Mulai (HH:MM)" />
                        <x-text-input id="add-rundown-start" name="time_start" type="time" class="mt-1 block w-full"
                            required />
                    </div>
                    <div>
                        <x-input-label for="add-rundown-end" value="Selesai (HH:MM)" />
                        <x-text-input id="add-rundown-end" name="time_end" type="time" class="mt-1 block w-full" />
                    </div>
                </div>

                <div>
                    <x-input-label for="add-rundown-pic" value="Person in Charge" />
                    <x-text-input id="add-rundown-pic" name="person_in_charge" class="mt-1 block w-full"
                        placeholder="cth: MC / Panitia" />
                </div>

                <div>
                    <x-input-label for="add-rundown-notes" value="Catatan" />
                    <textarea id="add-rundown-notes" name="notes" rows="2"
                        class="mt-1 block w-full border-neutral-300 dark:border-neutral-600 dark:bg-secondary-700 dark:text-neutral-200 focus:border-primary-500 focus:ring-primary-500 rounded-xl shadow-sm"></textarea>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 mt-4 border-t border-neutral-100 dark:border-secondary-700">
                    <x-secondary-button type="button" x-on:click="show = false">Batal</x-secondary-button>
                    <x-primary-button type="submit">Simpan Rundown</x-primary-button>
                </div>
            </form>
        </div>
    </x-modal>

    {{-- ─── Modals: Edit Rundown ─── --}}
    @foreach($rundowns as $rundown)
        <x-modal name="edit-rundown-{{ $rundown->id }}">
            <div class="p-6">
                <div class="flex items-start justify-between gap-4 mb-5">
                    <div>
                        <h3 class="text-lg font-bold text-secondary-800 dark:text-neutral-100">Edit Rundown</h3>
                        <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-1">{{ $rundown->activity_name }}</p>
                    </div>
                    <button type="button" x-on:click="show = false" class="shrink-0 p-2 -m-2 text-neutral-400 hover:text-secondary-600 dark:hover:text-neutral-300 rounded-xl hover:bg-neutral-100 dark:hover:bg-secondary-700 transition-colors">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <form action="{{ route('dashboard.planner.rundowns.update', $rundown) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PATCH')
                    <div>
                        <x-input-label for="edit-rundown-name-{{ $rundown->id }}" value="Nama Kegiatan" />
                        <x-text-input id="edit-rundown-name-{{ $rundown->id }}" name="activity_name"
                            class="mt-1 block w-full" value="{{ old('activity_name', $rundown->activity_name) }}"
                            required />
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="edit-rundown-start-{{ $rundown->id }}" value="Mulai (HH:MM)" />
                            <x-text-input id="edit-rundown-start-{{ $rundown->id }}" name="time_start" type="time"
                                class="mt-1 block w-full" value="{{ $rundown->time_start->format('H:i') }}" required />
                        </div>
                        <div>
                            <x-input-label for="edit-rundown-end-{{ $rundown->id }}" value="Selesai (HH:MM)" />
                            <x-text-input id="edit-rundown-end-{{ $rundown->id }}" name="time_end" type="time"
                                class="mt-1 block w-full" value="{{ $rundown->time_end?->format('H:i') }}" />
                        </div>
                    </div>

                    <div>
                        <x-input-label for="edit-rundown-pic-{{ $rundown->id }}" value="Person in Charge" />
                        <x-text-input id="edit-rundown-pic-{{ $rundown->id }}" name="person_in_charge"
                            class="mt-1 block w-full" value="{{ old('person_in_charge', $rundown->person_in_charge) }}" />
                    </div>

                    <div>
                        <x-input-label for="edit-rundown-notes-{{ $rundown->id }}" value="Catatan" />
                        <textarea id="edit-rundown-notes-{{ $rundown->id }}" name="notes" rows="2"
                            class="mt-1 block w-full border-neutral-300 dark:border-neutral-600 dark:bg-secondary-700 dark:text-neutral-200 focus:border-primary-500 focus:ring-primary-500 rounded-xl shadow-sm">{{ old('notes', $rundown->notes) }}</textarea>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-4 mt-4 border-t border-neutral-100 dark:border-secondary-700">
                        <x-secondary-button type="button" x-on:click="show = false">Batal</x-secondary-button>
                        <x-primary-button type="submit">Perbarui Rundown</x-primary-button>
                    </div>
                </form>
            </div>
        </x-modal>
    @endforeach

    @push('scripts')
        @php
            $checklistItemsForJs = $checklists->mapWithKeys(fn($item) => [
                $item->id => [
                    'code' => $item->category_code,
                    'is_document' => (bool) $item->is_document,
                    'completed' => (bool) $item->is_completed,
                    'pria' => (bool) $item->is_completed_pria,
                    'wanita' => (bool) $item->is_completed_wanita,
                ],
            ])->all();
        @endphp
        <script>
            function formatRupiahValue(value) {
                const digits = value.replace(/[^\d]/g, '');
                return digits ? Number(digits).toLocaleString('id-ID') : '';
            }

            function initRupiahInputs() {
                document.querySelectorAll('[data-rupiah]').forEach(function (input) {
                    input.value = formatRupiahValue(input.value);
                });
            }

            document.addEventListener('input', function (e) {
                if (e.target.matches && e.target.matches('[data-rupiah]')) {
                    e.target.value = formatRupiahValue(e.target.value);
                }
            });

            document.addEventListener('submit', function (e) {
                (e.target.querySelectorAll ? e.target.querySelectorAll('[data-rupiah]') : []).forEach(function (input) {
                    input.value = formatRupiahValue(input.value).replace(/\./g, '');
                });
            }, true);

            document.addEventListener('DOMContentLoaded', initRupiahInputs);
            window.addEventListener('pageshow', initRupiahInputs);

            function plannerCalendar() {
                return {
                    year: new Date().getFullYear(),
                    month: new Date().getMonth(),
                    today: new Date().toISOString().slice(0, 10),
                    weddingDate: @json($weddingDate?->format('Y-m-d')),
                    eventDates: @json($itemsByCategory['CALENDAR']->pluck('event_date')->filter()->map->format('Y-m-d')->values()->all()),

                    get monthLabel() {
                        return new Date(this.year, this.month, 1).toLocaleDateString('id-ID', {
                            month: 'long',
                            year: 'numeric',
                        });
                    },

                    get weddingLabel() {
                        if (this.weddingDate) {
                            return 'Hari H: ' + new Date(this.weddingDate).toLocaleDateString('id-ID', {
                                day: 'numeric',
                                month: 'short',
                                year: 'numeric',
                            });
                        }

                        return 'Tanggal Hari H belum ditentukan';
                    },

                    get firstDayIndex() {
                        return (new Date(this.year, this.month, 1).getDay() + 6) % 7;
                    },

                    get daysInMonth() {
                        return new Date(this.year, this.month + 1, 0).getDate();
                    },

                    get cells() {
                        const cells = [];
                        const firstDayIndex = this.firstDayIndex;
                        const daysInMonth = this.daysInMonth;

                        for (let i = 0; i < firstDayIndex; i++) {
                            cells.push({ key: 'blank-' + i, isOutside: true, day: '', isToday: false, isWedding: false, hasEvent: false });
                        }

                        for (let d = 1; d <= daysInMonth; d++) {
                            const date = this.year + '-' + String(this.month + 1).padStart(2, '0') + '-' + String(d).padStart(2, '0');
                            cells.push({
                                key: date,
                                day: d,
                                isOutside: false,
                                isToday: date === this.today,
                                isWedding: this.weddingDate !== null && date === this.weddingDate,
                                hasEvent: this.eventDates.includes(date),
                            });
                        }

                        return cells;
                    },

                    prevMonth() {
                        this.month--;
                        if (this.month < 0) {
                            this.month = 11;
                            this.year--;
                        }
                    },

                    nextMonth() {
                        this.month++;
                        if (this.month > 11) {
                            this.month = 0;
                            this.year++;
                        }
                    },

                    addEventToDate(date) {
                        window.__selectedCalendarDate = date;
                        this.$dispatch('open-calendar-modal');
                    },
                };
            }

            function plannerChecklist() {
                return {
                    items: @json($checklistItemsForJs),

                    checkboxCount(item) {
                        return item.is_document ? 2 : 1;
                    },

                    completedCheckboxCount(item) {
                        return item.is_document
                            ? (item.pria ? 1 : 0) + (item.wanita ? 1 : 0)
                            : (item.completed ? 1 : 0);
                    },

                    get totalItems() {
                        return Object.values(this.items)
                            .filter((item) => item.code !== 'ADMINISTRATION')
                            .reduce((sum, item) => sum + this.checkboxCount(item), 0);
                    },

                    get completedItems() {
                        return Object.values(this.items)
                            .filter((item) => item.code !== 'ADMINISTRATION')
                            .reduce((sum, item) => sum + this.completedCheckboxCount(item), 0);
                    },

                    get progressPercent() {
                        return this.totalItems > 0 ? Math.round((this.completedItems / this.totalItems) * 100) : 0;
                    },

                    categoryItems(code) {
                        return Object.values(this.items).filter((item) => item.code === code);
                    },

                    categoryTotal(code) {
                        return this.categoryItems(code)
                            .reduce((sum, item) => sum + this.checkboxCount(item), 0);
                    },

                    categoryCompleted(code) {
                        return this.categoryItems(code)
                            .reduce((sum, item) => sum + this.completedCheckboxCount(item), 0);
                    },

                    categoryProgress(code) {
                        const total = this.categoryTotal(code);
                        return total > 0 ? Math.round((this.categoryCompleted(code) / total) * 100) : 0;
                    },

                    async toggleItem(id, event) {
                        const checkbox = event.target;
                        const url = checkbox.dataset.toggleUrl;
                        const party = checkbox.dataset.party || null;
                        const key = party === 'pria' ? 'pria' : party === 'wanita' ? 'wanita' : 'completed';
                        const previous = this.items[id][key];
                        this.items[id][key] = checkbox.checked;

                        try {
                            const response = await fetch(url, {
                                method: 'PATCH',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                    'Content-Type': 'application/json',
                                    'Accept': 'application/json',
                                },
                                body: JSON.stringify({ party: party }),
                            });

                            if (!response.ok) {
                                throw new Error('Toggle gagal');
                            }

                            const data = await response.json();
                            this.items[id].completed = data.is_completed;
                            this.items[id].pria = data.is_completed_pria;
                            this.items[id].wanita = data.is_completed_wanita;
                        } catch (error) {
                            this.items[id][key] = previous;
                            checkbox.checked = previous;
                        }
                    },
                };
            }

            function plannerCountdown(targetDate, weddingTime) {
                let targetDateTime = targetDate;
                if (weddingTime) {
                    targetDateTime += 'T' + weddingTime;
                } else {
                    targetDateTime += 'T23:59:59';
                }

                return {
                    target: new Date(targetDateTime).getTime(),
                    days: 0,
                    hours: 0,
                    minutes: 0,
                    seconds: 0,
                    initialized: false,
                    timer: null,

                    init() {
                        this.update();
                        this.timer = setInterval(() => this.update(), 1000);
                    },

                    update() {
                        const diff = this.target - Date.now();
                        if (diff <= 0) {
                            this.initialized = false;
                            if (this.timer) {
                                clearInterval(this.timer);
                            }
                            return;
                        }

                        this.initialized = true;
                        this.days = Math.floor(diff / (1000 * 60 * 60 * 24));
                        this.hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                        this.minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                        this.seconds = Math.floor((diff % (1000 * 60)) / 1000);
                    },

                    destroy() {
                        if (this.timer) {
                            clearInterval(this.timer);
                        }
                    },
                };
            }
        </script>
    @endpush
</x-app-layout>