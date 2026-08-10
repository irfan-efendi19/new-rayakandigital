<x-app-layout>
    <div class="min-h-screen">

        {{-- ─── HERO ─── --}}
        <div class="hero-mesh grain-overlay border-b border-neutral-200/60 dark:border-secondary-700/40">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-7 sm:py-8">

                {{-- Breadcrumb --}}
                <nav class="flex items-center gap-1.5 text-xs text-neutral-400 dark:text-neutral-500 mb-4">
                    <a href="{{ route('dashboard') }}" class="hover:text-primary dark:hover:text-primary-400 transition-colors">Dashboard</a>
                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                    <span class="text-neutral-600 dark:text-neutral-400 font-medium">Wedding Planner</span>
                </nav>

                <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
                    <div>
                        <h1 class="font-heading text-2xl sm:text-3xl font-bold text-secondary-800 dark:text-neutral-50 leading-tight">
                            Wedding Planner & Organizer
                        </h1>
                        <p class="text-sm text-neutral-500 dark:text-neutral-400 mt-1">
                            Kelola 8 pilar persiapan pernikahan dari H-12 bulan hingga Hari H.
                        </p>
                    </div>
                    <div class="flex flex-wrap items-center gap-2 flex-shrink-0">
                        <a href="{{ route('dashboard.planner.export-pdf') }}"
                           class="inline-flex items-center gap-1.5 px-3.5 py-2 text-xs font-semibold text-white bg-red-600 hover:bg-red-700 rounded-xl shadow-sm shadow-red-500/20 transition-all">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
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
                    <div class="mt-6 rounded-2xl bg-gradient-to-r from-primary-600 via-primary-700 to-secondary-900 p-5 sm:p-6 text-white relative overflow-hidden">
                        <div class="absolute -right-8 -bottom-10 opacity-10 pointer-events-none">
                            <svg class="w-56 h-56" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3M3 11h18M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                        <div class="relative z-10 flex flex-col sm:flex-row sm:items-center gap-4 sm:gap-6">
                            <div class="min-w-0">
                                <p class="text-xs uppercase tracking-widest text-white/70 font-semibold">Countdown Menuju Hari H</p>
                                <h4 class="font-heading text-lg sm:text-xl font-bold mt-1">
                                    {{ $weddingDate->translatedFormat('l, d F Y') }}
                                    @if($weddingTime)
                                        <span class="text-white/80 text-sm font-medium">• {{ \Carbon\Carbon::parse($weddingTime)->format('H:i') }}</span>
                                    @endif
                                </h4>
                                @if($invitation)
                                    <p class="text-xs text-white/60 mt-0.5 truncate">Undangan: {{ $invitation->title }}</p>
                                @endif
                            </div>
                            <div class="flex-shrink-0">
                                @if($isPast)
                                    <div class="flex items-center gap-2 rounded-xl bg-white/10 backdrop-blur-sm border border-white/15 px-4 py-3">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                        <span class="text-sm font-semibold">Acara telah dilaksanakan</span>
                                    </div>
                                @else
                                    <div class="grid grid-cols-4 gap-2 sm:gap-3" x-data="plannerCountdown('{{ $weddingDate->format('Y-m-d') }}')">
                                        <template x-if="initialized">
                                            <template x-for="unit in [
                                                { label: 'Hari', value: days },
                                                { label: 'Jam', value: hours },
                                                { label: 'Menit', value: minutes },
                                                { label: 'Detik', value: seconds },
                                            ]" :key="unit.label">
                                                <div class="bg-white/10 backdrop-blur-sm rounded-xl py-2.5 px-2 text-center border border-white/15 min-w-[64px]">
                                                    <p class="text-xl sm:text-2xl font-extrabold tabular-nums leading-none" x-text="String(unit.value).padStart(2, '0')"></p>
                                                    <p class="text-[10px] uppercase tracking-wider text-white/70 mt-1" x-text="unit.label"></p>
                                                </div>
                                            </template>
                                        </template>
                                        <template x-if="!initialized">
                                            <div class="col-span-4 flex items-center gap-2 rounded-xl bg-white/10 backdrop-blur-sm border border-white/15 px-4 py-3 text-sm font-semibold">
                                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
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
                <div class="rounded-2xl border border-emerald-200 bg-emerald-50 dark:bg-emerald-950/30 dark:border-emerald-800/50 px-4 py-3 text-sm text-emerald-800 dark:text-emerald-300 flex items-center gap-2">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    {{ session('success') }}
                </div>
            @endif

            {{-- ── Financial Overview Cards ── --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="p-5 bg-blue-50 border border-blue-200 rounded-2xl dark:bg-blue-950/30 dark:border-blue-800/50">
                    <p class="text-xs text-blue-600 dark:text-blue-400 font-semibold uppercase tracking-wide">Total Estimasi Anggaran</p>
                    <p class="text-2xl font-bold text-blue-900 dark:text-blue-100 mt-1 tabular-nums">Rp {{ number_format($totalEstimated, 0, ',', '.') }}</p>
                    <p class="text-xs text-blue-500 dark:text-blue-400 mt-1">{{ $itemsByCategory['BUDGET']->count() + $itemsByCategory['VENDOR']->count() }} item budget & vendor</p>
                </div>
                <div class="p-5 bg-emerald-50 border border-emerald-200 rounded-2xl dark:bg-emerald-950/30 dark:border-emerald-800/50">
                    <p class="text-xs text-emerald-600 dark:text-emerald-400 font-semibold uppercase tracking-wide">Total Terbayar (DP/Lunas)</p>
                    <p class="text-2xl font-bold text-emerald-900 dark:text-emerald-100 mt-1 tabular-nums">Rp {{ number_format($totalPaid, 0, ',', '.') }}</p>
                </div>
                <div class="p-5 bg-amber-50 border border-amber-200 rounded-2xl dark:bg-amber-950/30 dark:border-amber-800/50">
                    <p class="text-xs text-amber-600 dark:text-amber-400 font-semibold uppercase tracking-wide">Sisa Tagihan Vendor</p>
                    <p class="text-2xl font-bold text-amber-900 dark:text-amber-100 mt-1 tabular-nums">Rp {{ number_format(max(0, $totalActual - $totalPaid), 0, ',', '.') }}</p>
                </div>
            </div>

            {{-- ── Rundown Hari H ── --}}
            <div class="bg-white dark:bg-secondary-800 rounded-2xl border border-neutral-200/80 dark:border-secondary-700/60 overflow-hidden">
                <div class="px-5 py-4 border-b border-neutral-200/80 dark:border-secondary-700/60 flex items-center justify-between gap-3">
                    <div>
                        <h3 class="font-semibold text-secondary-800 dark:text-neutral-100">Rundown Acara Hari H</h3>
                        <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-0.5">Time schedule kegiatan ditampilkan secara kronologis.</p>
                    </div>
                    <button type="button" x-data @click="$dispatch('open-modal', 'add-rundown')"
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-primary hover:bg-primary-600 text-white text-xs font-semibold transition-all">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Tambah Rundown
                    </button>
                </div>

                @if($rundowns->isEmpty())
                    <div class="px-5 py-10 text-center text-sm text-neutral-400 dark:text-neutral-500">
                        Belum ada rundown. Tambahkan jadwal kegiatan Hari H.
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-neutral-100 dark:divide-secondary-700/60">
                            <thead>
                                <tr class="bg-neutral-50 dark:bg-secondary-700/40">
                                    <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wide text-neutral-500 dark:text-neutral-400">Waktu</th>
                                    <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wide text-neutral-500 dark:text-neutral-400">Kegiatan</th>
                                    <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wide text-neutral-500 dark:text-neutral-400">PIC</th>
                                    <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wide text-neutral-500 dark:text-neutral-400">Catatan</th>
                                    <th class="px-5 py-3 text-right text-[11px] font-semibold uppercase tracking-wide text-neutral-500 dark:text-neutral-400">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-neutral-100 dark:divide-secondary-700/60">
                                @foreach($rundowns as $index => $rundown)
                                    <tr class="hover:bg-neutral-50 dark:hover:bg-secondary-700/30 transition-colors">
                                        <td class="px-5 py-3 whitespace-nowrap">
                                            <div class="flex items-center gap-2.5">
                                                <div class="flex flex-col items-center">
                                                    <span class="w-px h-3 bg-neutral-200 dark:bg-secondary-600"></span>
                                                    <span class="w-2 h-2 rounded-full bg-primary"></span>
                                                    <span class="w-px h-3 bg-neutral-200 dark:bg-secondary-600"></span>
                                                </div>
                                                <div>
                                                    <p class="text-sm font-semibold text-secondary-800 dark:text-neutral-100 tabular-nums">
                                                        {{ $rundown->time_start->format('H:i') }}
                                                        @if($rundown->time_end)
                                                            – {{ $rundown->time_end->format('H:i') }}
                                                        @endif
                                                    </p>
                                                    <p class="text-[10px] text-neutral-400 dark:text-neutral-500">Urutan #{{ $index + 1 }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-5 py-3">
                                            <p class="text-sm font-medium text-secondary-800 dark:text-neutral-100">{{ $rundown->activity_name }}</p>
                                        </td>
                                        <td class="px-5 py-3">
                                            <span class="text-xs text-neutral-600 dark:text-neutral-400">{{ $rundown->person_in_charge ?: '—' }}</span>
                                        </td>
                                        <td class="px-5 py-3">
                                            <span class="text-xs text-neutral-500 dark:text-neutral-400 line-clamp-2">{{ $rundown->notes ?: '—' }}</span>
                                        </td>
                                        <td class="px-5 py-3 whitespace-nowrap text-right">
                                            <button type="button" x-data @click="$dispatch('open-modal', 'edit-rundown-{{ $rundown->id }}')"
                                                class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg text-[11px] font-semibold text-primary dark:text-primary-400 hover:bg-primary-50 dark:hover:bg-primary-900/20 transition-colors">
                                                Edit
                                            </button>
                                            <form action="{{ route('dashboard.planner.rundowns.destroy', $rundown) }}" method="POST" class="inline"
                                                onsubmit="return confirm('Hapus rundown ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg text-[11px] font-semibold text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
                                                    Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

            {{-- ── 8 Pilar Modul Tabs ── --}}
            @php
                $pillars = [
                    ['key' => 'CALENDAR',      'label' => 'Calendar',      'color' => 'text-blue-600 dark:text-blue-400',   'bg' => 'bg-blue-100 dark:bg-blue-900/40'],
                    ['key' => 'CHECKLIST',     'label' => 'Checklist',     'color' => 'text-emerald-600 dark:text-emerald-400','bg' => 'bg-emerald-100 dark:bg-emerald-900/40'],
                    ['key' => 'ENGAGEMENT',    'label' => 'Engagement',    'color' => 'text-pink-600 dark:text-pink-400',     'bg' => 'bg-pink-100 dark:bg-pink-900/40'],
                    ['key' => 'PRE_WEDDING',   'label' => 'Pre-Wedding',   'color' => 'text-violet-600 dark:text-violet-400', 'bg' => 'bg-violet-100 dark:bg-violet-900/40'],
                    ['key' => 'SESERAHAN',     'label' => 'Seserahan',     'color' => 'text-amber-600 dark:text-amber-400',  'bg' => 'bg-amber-100 dark:bg-amber-900/40'],
                    ['key' => 'ADMINISTRATION','label' => 'Administrasi',  'color' => 'text-cyan-600 dark:text-cyan-400',    'bg' => 'bg-cyan-100 dark:bg-cyan-900/40'],
                    ['key' => 'BUDGET',        'label' => 'Budget',        'color' => 'text-green-600 dark:text-green-400',  'bg' => 'bg-green-100 dark:bg-green-900/40'],
                    ['key' => 'VENDOR',        'label' => 'Vendor',        'color' => 'text-orange-600 dark:text-orange-400', 'bg' => 'bg-orange-100 dark:bg-orange-900/40'],
                ];

                $statusStyles = [
                    'PENDING'     => 'bg-neutral-100 text-neutral-600 dark:bg-neutral-700 dark:text-neutral-300',
                    'IN_PROGRESS' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/50 dark:text-blue-300',
                    'COMPLETED'   => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/50 dark:text-emerald-300',
                    'CANCELLED'   => 'bg-red-100 text-red-700 dark:bg-red-900/50 dark:text-red-300',
                ];

                $statusLabels = [
                    'PENDING'     => 'Pending',
                    'IN_PROGRESS' => 'Proses',
                    'COMPLETED'   => 'Selesai',
                    'CANCELLED'   => 'Batal',
                ];

                $statusOptions = [
                    'PENDING', 'IN_PROGRESS', 'COMPLETED', 'CANCELLED',
                ];

                $adminChecklists = $checklists->where('category_code', 'ADMINISTRATION');
                $adminTotalItems = $adminChecklists->sum(fn ($item) => $item->checkboxCount());
                $adminCompletedItems = $adminChecklists->sum(fn ($item) => $item->completedCheckboxCount());
            @endphp

            <div x-data="{ activeTab: '{{ $pillars[0]['key'] }}' }" class="bg-white dark:bg-secondary-800 rounded-2xl border border-neutral-200/80 dark:border-secondary-700/60 overflow-hidden">
                {{-- Tabs --}}
                <div class="flex overflow-x-auto border-b border-neutral-200/80 dark:border-secondary-700/60">
                    @foreach($pillars as $pillar)
                        <button type="button"
                            @click="activeTab = '{{ $pillar['key'] }}'"
                            class="flex-shrink-0 px-4 py-3.5 text-sm font-medium border-b-2 transition-colors whitespace-nowrap"
                            :class="activeTab === '{{ $pillar['key'] }}'
                                ? 'border-primary text-primary dark:text-primary-400'
                                : 'border-transparent text-neutral-500 dark:text-neutral-400 hover:text-secondary-800 dark:hover:text-neutral-200 hover:bg-neutral-50 dark:hover:bg-secondary-700/40'">
                            {{ $pillar['label'] }}
                            <span class="ml-1.5 inline-flex items-center px-1.5 py-0.5 rounded-full text-[10px] font-bold {{ $pillar['bg'] }} {{ $pillar['color'] }}">
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
                                <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-0.5">Kalender referensi bulanan menuju Hari H.</p>
                            </div>

                            <div x-data="plannerCalendar()" class="border border-neutral-200/80 dark:border-secondary-700/60 rounded-xl overflow-hidden">
                                {{-- Header --}}
                                <div class="flex items-center justify-between gap-3 px-4 py-3 bg-neutral-50 dark:bg-secondary-700/40 border-b border-neutral-200/80 dark:border-secondary-700/60">
                                    <button type="button" @click="prevMonth()"
                                        class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-neutral-500 dark:text-neutral-400 hover:bg-neutral-200 dark:hover:bg-secondary-600 hover:text-secondary-800 dark:hover:text-neutral-100 transition-colors">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
                                    </button>
                                    <div class="text-center">
                                        <p class="text-sm font-bold text-secondary-800 dark:text-neutral-100" x-text="monthLabel"></p>
                                        <p class="text-[10px] text-neutral-400 dark:text-neutral-500" x-text="weddingLabel"></p>
                                    </div>
                                    <button type="button" @click="nextMonth()"
                                        class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-neutral-500 dark:text-neutral-400 hover:bg-neutral-200 dark:hover:bg-secondary-600 hover:text-secondary-800 dark:hover:text-neutral-100 transition-colors">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                                    </button>
                                </div>

                                {{-- Weekday header --}}
                                <div class="grid grid-cols-7 text-center text-[10px] font-bold uppercase tracking-wide text-neutral-400 dark:text-neutral-500 py-2 border-b border-neutral-100 dark:border-secondary-700/50">
                                    <span>Min</span><span>Sen</span><span>Sel</span><span>Rab</span><span>Kam</span><span>Jum</span><span>Sab</span>
                                </div>

                                {{-- Days grid --}}
                                <div class="grid grid-cols-7 gap-px bg-neutral-100 dark:bg-secondary-700/50">
                                    <template x-for="cell in cells" :key="cell.key">
                                        <div class="min-h-[72px] bg-white dark:bg-secondary-800 p-1.5 flex flex-col"
                                            :class="cell.isOutside ? 'opacity-40' : ''">
                                            <div class="flex items-center justify-between">
                                                <span class="text-[11px] font-semibold tabular-nums"
                                                    :class="cell.isToday ? 'w-5 h-5 flex items-center justify-center rounded-full bg-primary text-white text-[10px]' : (cell.isWedding ? 'w-5 h-5 flex items-center justify-center rounded-full bg-amber-500 text-white text-[10px]' : 'text-secondary-700 dark:text-neutral-300')"
                                                    x-text="cell.day"></span>
                                                <svg x-show="cell.isWedding" class="w-3 h-3 text-amber-500" fill="currentColor" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </div>

                            @if($weddingDate)
                                <div class="mt-4 flex items-center gap-4 text-[11px] text-neutral-500 dark:text-neutral-400 flex-wrap">
                                    <span class="inline-flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-amber-500"></span> Hari H</span>
                                    <span class="inline-flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-primary"></span> Hari ini</span>
                                </div>
                            @endif

                        @elseif($pillar['key'] === 'CHECKLIST')

                            {{-- ─── CHECKLIST INTERAKTIF (Interactive Wedding Checklist Planner) ─── --}}
                            @php
                                $checklistCategories = collect(\App\Models\WeddingChecklist::CATEGORIES)
                                    ->reject(fn ($label, $code) => $code === 'ADMINISTRATION')
                                    ->all();
                            @endphp

                            <div class="rounded-2xl border border-neutral-200/80 dark:border-secondary-700/60 bg-neutral-50/60 dark:bg-secondary-700/30 p-5 mb-6">
                                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                                        <div class="min-w-0">
                                            <p class="text-xs uppercase tracking-widest text-primary dark:text-primary-400 font-semibold">Checklist Wedding Plan</p>
                                            <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-1">Item persiapan per kategori.</p>
                                            <h3 class="font-heading text-lg font-bold text-secondary-800 dark:text-neutral-100 mt-1"
                                                x-text="progressPercent === 100 ? '🎉 Semua Ceklis Selesai!' : (completedItems > 0 ? 'Yuk lanjutkan ceklis!' : 'Yuk mulai ceklis!')"></h3>
                                            <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-1">
                                                <span x-text="completedItems"></span>/<span x-text="totalItems"></span> selesai ·
                                                {{ count($checklistCategories) }} kategori
                                            </p>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <button type="button" x-data @click="$dispatch('open-modal', 'add-checklist')"
                                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-primary hover:bg-primary-600 text-white text-xs font-semibold transition-all">
                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                                Tambah Data
                                            </button>
                                        </div>
                                    </div>
                                    <div class="mt-4">
                                        <div class="h-2.5 bg-neutral-200/80 dark:bg-secondary-700/60 rounded-full overflow-hidden">
                                            <div class="h-full bg-primary rounded-full transition-all duration-500" :style="'width:' + progressPercent + '%'"></div>
                                        </div>
                                        <p class="text-right text-xs font-bold text-primary dark:text-primary-400 mt-1 tabular-nums" x-text="progressPercent + '%'"></p>
                                    </div>
                                </div>

                                {{-- Empty State (PRD section 22) --}}
                                @if($checklistTotalItems === 0)
                                    <div class="rounded-xl border border-dashed border-neutral-200 dark:border-secondary-600 px-5 py-10 text-center">
                                        <svg class="w-10 h-10 mx-auto text-neutral-300 dark:text-neutral-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                                        <p class="text-sm font-semibold text-secondary-800 dark:text-neutral-100 mt-3">Belum ada checklist.</p>
                                        <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-1">Checklist persiapan pernikahan akan tersedia setelah invitation dibuat.</p>
                                    </div>
                                @else
                                {{-- Category Groups --}}
                                <div class="space-y-5">
                                    @foreach($checklistCategories as $code => $label)
                                        @php
                                            $items = $checklists->where('category_code', $code);
                                            $normalItems = $items->where('is_document', false);
                                        @endphp
                                        <div class="rounded-xl border border-neutral-200/80 dark:border-secondary-700/60 overflow-hidden">
                                            <div class="px-4 py-3 bg-neutral-50 dark:bg-secondary-700/40 border-b border-neutral-200/80 dark:border-secondary-700/60 flex items-center justify-between gap-3">
                                                <h4 class="text-sm font-semibold text-secondary-800 dark:text-neutral-100">{{ $label }}</h4>
                                                <span class="text-[11px] font-semibold text-neutral-500 dark:text-neutral-400 tabular-nums">
                                                    <span x-text="categoryCompleted('{{ $code }}')"></span> / <span x-text="categoryTotal('{{ $code }}')"></span> selesai
                                                </span>
                                            </div>
                                            <div class="h-1.5 bg-neutral-100 dark:bg-secondary-700/50">
                                                <div class="h-full bg-emerald-500 dark:bg-emerald-400 transition-all duration-500" :style="'width:' + categoryProgress('{{ $code }}') + '%'"></div>
                                            </div>

                                            @if($items->isEmpty())
                                                <div class="px-4 py-8 text-center text-sm text-neutral-400 dark:text-neutral-500">
                                                    Belum ada checklist pada kategori ini.
                                                </div>
                                            @else
                                                @if($normalItems->isNotEmpty())
                                                    <ul class="divide-y divide-neutral-100 dark:divide-secondary-700/50">
                                                        @foreach($normalItems as $item)
                                                            <li class="px-4 py-2.5 flex items-center gap-3 hover:bg-neutral-50 dark:hover:bg-secondary-700/30 transition-colors">
                                                                <input type="checkbox"
                                                                    :checked="items[{{ $item->id }}].completed"
                                                                    data-toggle-url="{{ route('dashboard.planner.checklists.toggle', $item) }}"
                                                                    @change="toggleItem({{ $item->id }}, $event)"
                                                                    class="w-4 h-4 rounded border-neutral-300 dark:border-neutral-600 text-primary focus:ring-primary-500 cursor-pointer">
                                                                <div class="min-w-0 flex-1">
                                                                    <p class="text-sm font-medium text-secondary-800 dark:text-neutral-100"
                                                                        :class="items[{{ $item->id }}].completed ? 'line-through text-neutral-400 dark:text-neutral-500' : ''">
                                                                        {{ $item->title }}
                                                                    </p>
                                                                    @if($item->description)
                                                                        <p class="text-xs text-neutral-400 dark:text-neutral-500 mt-0.5 line-clamp-2">{{ $item->description }}</p>
                                                                    @endif
                                                                </div>
                                                                @if($item->is_preset)
                                                                    <span class="flex-shrink-0 inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-neutral-100 text-neutral-500 dark:bg-secondary-600 dark:text-neutral-400">Preset</span>
                                                                @else
                                                                    <div class="flex-shrink-0 flex items-center gap-1">
                                                                        <button type="button" x-data @click="$dispatch('open-modal', 'edit-checklist-{{ $item->id }}')"
                                                                            class="inline-flex items-center px-2.5 py-1.5 rounded-lg text-[11px] font-semibold text-primary dark:text-primary-400 hover:bg-primary-50 dark:hover:bg-primary-900/20 transition-colors">
                                                                            Edit
                                                                        </button>
                                                                        <form action="{{ route('dashboard.planner.checklists.destroy', $item) }}" method="POST" class="inline"
                                                                            onsubmit="return confirm('Hapus checklist custom ini?')">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="submit" class="inline-flex items-center px-2.5 py-1.5 rounded-lg text-[11px] font-semibold text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
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
                            <div class="rounded-2xl border border-neutral-200/80 dark:border-secondary-700/60 bg-neutral-50/60 dark:bg-secondary-700/30 p-5 mb-6">
                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                                    <div class="min-w-0">
                                        <p class="text-xs uppercase tracking-widest text-cyan-600 dark:text-cyan-400 font-semibold">Administrasi & Legal</p>
                                        <h3 class="font-heading text-lg font-bold text-secondary-800 dark:text-neutral-100 mt-1">Dokumen Persyaratan KUA</h3>
                                        <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-1">
                                            <span x-text="categoryCompleted('ADMINISTRATION')"></span>/<span x-text="categoryTotal('ADMINISTRATION')"></span> checkbox selesai
                                        </p>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <button type="button" x-data @click="$dispatch('open-modal', 'add-checklist')"
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-primary hover:bg-primary-600 text-white text-xs font-semibold transition-all">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                            Tambah Data
                                        </button>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <div class="h-2.5 bg-neutral-200/80 dark:bg-secondary-700/60 rounded-full overflow-hidden">
                                        <div class="h-full bg-cyan-500 dark:bg-cyan-400 rounded-full transition-all duration-500" :style="'width:' + categoryProgress('ADMINISTRATION') + '%'"></div>
                                    </div>
                                    <p class="text-right text-xs font-bold text-cyan-600 dark:text-cyan-400 mt-1 tabular-nums" x-text="categoryProgress('ADMINISTRATION') + '%'"></p>
                                </div>
                            </div>

                            <div class="space-y-5">
                                @php
                                    $adminItems = $checklists->where('category_code', 'ADMINISTRATION');
                                    $adminNormalItems = $adminItems->where('is_document', false);
                                    $adminDocumentItems = $adminItems->where('is_document', true);
                                @endphp

                                @if($adminItems->isEmpty())
                                    <div class="px-5 py-10 text-center text-sm text-neutral-400 dark:text-neutral-500 border border-dashed border-neutral-200 dark:border-secondary-600 rounded-xl">
                                        Belum ada checklist pada kategori Administrasi.
                                    </div>
                                @else
                                    @if($adminNormalItems->isNotEmpty())
                                        <div class="rounded-xl border border-neutral-200/80 dark:border-secondary-700/60 overflow-hidden">
                                            <div class="px-4 py-3 bg-neutral-50 dark:bg-secondary-700/40 border-b border-neutral-200/80 dark:border-secondary-700/60">
                                                <h4 class="text-sm font-semibold text-secondary-800 dark:text-neutral-100">Administrasi Umum</h4>
                                            </div>
                                            <ul class="divide-y divide-neutral-100 dark:divide-secondary-700/50">
                                                @foreach($adminNormalItems as $item)
                                                    <li class="px-4 py-2.5 flex items-center gap-3 hover:bg-neutral-50 dark:hover:bg-secondary-700/30 transition-colors">
                                                        <input type="checkbox"
                                                            :checked="items[{{ $item->id }}].completed"
                                                            data-toggle-url="{{ route('dashboard.planner.checklists.toggle', $item) }}"
                                                            @change="toggleItem({{ $item->id }}, $event)"
                                                            class="w-4 h-4 rounded border-neutral-300 dark:border-neutral-600 text-primary focus:ring-primary-500 cursor-pointer">
                                                        <div class="min-w-0 flex-1">
                                                            <p class="text-sm font-medium text-secondary-800 dark:text-neutral-100"
                                                                :class="items[{{ $item->id }}].completed ? 'line-through text-neutral-400 dark:text-neutral-500' : ''">
                                                                {{ $item->title }}
                                                            </p>
                                                        </div>
                                                        <span class="flex-shrink-0 inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-neutral-100 text-neutral-500 dark:bg-secondary-600 dark:text-neutral-400">Preset</span>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                    @if($adminDocumentItems->isNotEmpty())
                                        <div class="rounded-xl border border-neutral-200/80 dark:border-secondary-700/60 overflow-hidden">
                                            <div class="px-4 py-3 bg-neutral-50 dark:bg-secondary-700/40 border-b border-neutral-200/80 dark:border-secondary-700/60">
                                                <h4 class="text-sm font-semibold text-secondary-800 dark:text-neutral-100">Dokumen Persyaratan</h4>
                                                <p class="text-[11px] text-neutral-400 dark:text-neutral-500 mt-0.5">{{ $adminDocumentItems->count() }} item · klik checkbox buat tandai selesai</p>
                                            </div>
                                            <ul class="divide-y divide-neutral-100 dark:divide-secondary-700/50">
                                                @foreach($adminDocumentItems as $item)
                                                    <li class="px-4 py-2.5 flex items-center gap-3 hover:bg-neutral-50 dark:hover:bg-secondary-700/30 transition-colors">
                                                        <div class="min-w-0 flex-1">
                                                            <p class="text-sm font-medium text-secondary-800 dark:text-neutral-100"
                                                                :class="items[{{ $item->id }}].pria && items[{{ $item->id }}].wanita ? 'line-through text-neutral-400 dark:text-neutral-500' : ''">
                                                                {{ $item->title }}
                                                            </p>
                                                        </div>
                                                        <div class="flex-shrink-0 flex items-center gap-4">
                                                            <label class="inline-flex items-center gap-1.5 cursor-pointer select-none">
                                                                <input type="checkbox"
                                                                    :checked="items[{{ $item->id }}].pria"
                                                                    data-toggle-url="{{ route('dashboard.planner.checklists.toggle', $item) }}"
                                                                    data-party="pria"
                                                                    @change="toggleItem({{ $item->id }}, $event)"
                                                                    class="w-4 h-4 rounded border-neutral-300 dark:border-neutral-600 text-primary focus:ring-primary-500 cursor-pointer">
                                                                <span class="text-xs font-semibold text-neutral-500 dark:text-neutral-400">Pria</span>
                                                            </label>
                                                            <label class="inline-flex items-center gap-1.5 cursor-pointer select-none">
                                                                <input type="checkbox"
                                                                    :checked="items[{{ $item->id }}].wanita"
                                                                    data-toggle-url="{{ route('dashboard.planner.checklists.toggle', $item) }}"
                                                                    data-party="wanita"
                                                                    @change="toggleItem({{ $item->id }}, $event)"
                                                                    class="w-4 h-4 rounded border-neutral-300 dark:border-neutral-600 text-primary focus:ring-primary-500 cursor-pointer">
                                                                <span class="text-xs font-semibold text-neutral-500 dark:text-neutral-400">Wanita</span>
                                                            </label>
                                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-neutral-100 text-neutral-500 dark:bg-secondary-600 dark:text-neutral-400">Preset</span>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                @endif
                            </div>

                        @elseif($pillar['key'] === 'VENDOR')

                            {{-- ─── VENDOR: kartu vendor per tipe ─── --}}
                            <div class="flex items-center justify-between gap-3 mb-4">
                                <div>
                                    <h3 class="font-semibold text-secondary-800 dark:text-neutral-100">Vendor Pernikahan</h3>
                                    <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-0.5">Kelola vendor per kategori persiapan.</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                @foreach(\App\Models\WeddingPlannerItem::VENDOR_TYPES as $type => $vendorLabel)
                                    @php
                                        $vendors = $vendorsByType[$type] ?? collect();
                                    @endphp
                                    <div class="rounded-2xl border border-neutral-200/80 dark:border-secondary-700/60 overflow-hidden bg-white dark:bg-secondary-800">
                                        <div class="px-4 py-3 bg-neutral-50 dark:bg-secondary-700/40 border-b border-neutral-200/80 dark:border-secondary-700/60 flex items-center justify-between gap-3">
                                            <h4 class="text-sm font-semibold text-secondary-800 dark:text-neutral-100">{{ $vendorLabel }}</h4>
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-orange-100 text-orange-700 dark:bg-orange-900/40 dark:text-orange-300">
                                                {{ $vendors->count() }}
                                            </span>
                                        </div>

                                        @if($vendors->isEmpty())
                                            <div class="px-4 py-8 text-center text-sm text-neutral-400 dark:text-neutral-500">
                                                Belum ada vendor
                                            </div>
                                        @else
                                            <div class="divide-y divide-neutral-100 dark:divide-secondary-700/50">
                                                @foreach($vendors as $vendor)
                                                    <div class="px-4 py-3">
                                                        <div class="flex items-center justify-between gap-2">
                                                            <p class="text-sm font-semibold text-secondary-800 dark:text-neutral-100">{{ $vendor->title }}</p>
                                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold {{ $statusStyles[$vendor->status] ?? $statusStyles['PENDING'] }}">
                                                                {{ $statusLabels[$vendor->status] ?? $vendor->status }}
                                                            </span>
                                                        </div>
                                                        @if($vendor->description)
                                                            <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-1 line-clamp-2">{{ $vendor->description }}</p>
                                                        @endif
                                                        @if($vendor->vendor_contact)
                                                            <p class="text-xs text-neutral-400 dark:text-neutral-500 mt-1 flex items-center gap-1">
                                                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                                                {{ $vendor->vendor_contact }}
                                                            </p>
                                                        @endif
                                                        <div class="mt-2 flex items-center justify-between gap-2">
                                                            <p class="text-[11px] text-neutral-400 dark:text-neutral-500 tabular-nums">
                                                                Estimasi Rp {{ number_format($vendor->estimated_cost, 0, ',', '.') }}
                                                            </p>
                                                            <div class="flex items-center gap-1">
                                                                <button type="button" x-data @click="$dispatch('open-modal', 'edit-item-{{ $vendor->id }}')"
                                                                    class="inline-flex items-center px-2.5 py-1.5 rounded-lg text-[11px] font-semibold text-primary dark:text-primary-400 hover:bg-primary-50 dark:hover:bg-primary-900/20 transition-colors">
                                                                    Edit
                                                                </button>
                                                                <form action="{{ route('dashboard.planner.items.destroy', $vendor) }}" method="POST" class="inline"
                                                                    onsubmit="return confirm('Hapus vendor ini?')">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="inline-flex items-center px-2.5 py-1.5 rounded-lg text-[11px] font-semibold text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
                                                                        Hapus
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif

                                        <div class="px-4 py-3 border-t border-neutral-100 dark:border-secondary-700/50">
                                            <button type="button" x-data
                                                @click="$dispatch('open-modal', 'add-vendor'); $dispatch('set-vendor-type', { type: '{{ $type }}' })"
                                                class="w-full inline-flex items-center justify-center gap-1.5 px-3 py-2 rounded-xl bg-primary hover:bg-primary-600 text-white text-xs font-semibold transition-all">
                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                                Tambah vendor
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
                            <div class="flex items-center justify-between gap-3 mb-4">
                                <div>
                                    <h3 class="font-semibold text-secondary-800 dark:text-neutral-100">Rencana Pertunangan</h3>
                                    <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-0.5">
                                        {{ $engItems->count() }} item di {{ count(\App\Models\WeddingPlannerItem::ENGAGEMENT_ITEMS) }} kategori
                                    </p>
                                </div>
                                <button type="button" x-data
                                    @click="activeTab = 'ENGAGEMENT'; $dispatch('open-modal', 'add-item-ENGAGEMENT')"
                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-primary hover:bg-primary-600 text-white text-xs font-semibold transition-all">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                    Tambah Data
                                </button>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 mb-5">
                                <div class="p-3.5 rounded-xl border border-neutral-200/70 dark:border-secondary-700/50 bg-neutral-50/60 dark:bg-secondary-700/30">
                                    <span class="text-[11px] text-neutral-400 dark:text-neutral-500">Total Pengeluaran</span>
                                    <p class="text-lg font-bold text-secondary-800 dark:text-neutral-100 tabular-nums mt-0.5">Rp {{ number_format($engTotal, 0, ',', '.') }}</p>
                                </div>
                                <div class="p-3.5 rounded-xl border border-neutral-200/70 dark:border-secondary-700/50 bg-neutral-50/60 dark:bg-secondary-700/30">
                                    <span class="text-[11px] text-neutral-400 dark:text-neutral-500">Pria (CPP)</span>
                                    <p class="text-lg font-bold text-blue-600 dark:text-blue-400 tabular-nums mt-0.5">Rp {{ number_format($engTotalPria, 0, ',', '.') }}</p>
                                </div>
                                <div class="p-3.5 rounded-xl border border-neutral-200/70 dark:border-secondary-700/50 bg-neutral-50/60 dark:bg-secondary-700/30">
                                    <span class="text-[11px] text-neutral-400 dark:text-neutral-500">Wanita (CPW)</span>
                                    <p class="text-lg font-bold text-pink-600 dark:text-pink-400 tabular-nums mt-0.5">Rp {{ number_format($engTotalWanita, 0, ',', '.') }}</p>
                                </div>
                            </div>

                            @if($engItems->isEmpty())
                                <div class="px-5 py-10 text-center text-sm text-neutral-400 dark:text-neutral-500 border border-dashed border-neutral-200 dark:border-secondary-600 rounded-xl">
                                    Belum ada rencana pertunangan. Tambahkan data untuk mulai merencanakan.
                                </div>
                            @else
                                @foreach(\App\Models\WeddingPlannerItem::ENGAGEMENT_ITEMS as $groupCode => $groupTitles)
                                    @php
                                        $groupItems = $engItems->where('subcategory', $groupCode)->values();
                                        $groupPria = (float) $groupItems->sum('cost_pria');
                                        $groupWanita = (float) $groupItems->sum('cost_wanita');
                                        $groupTotal = $groupPria + $groupWanita;
                                    @endphp
                                    @if($groupItems->isNotEmpty())
                                        <div class="space-y-2.5">
                                            @foreach($groupItems as $item)
                                                <div class="flex items-start gap-3 p-3.5 rounded-xl border border-neutral-200/70 dark:border-secondary-700/50 bg-neutral-50/60 dark:bg-secondary-700/30">
                                                    <span class="flex-shrink-0 w-7 h-7 flex items-center justify-center rounded-lg text-xs font-bold text-white bg-pink-500">{{ $loop->iteration }}</span>
                                                    <div class="min-w-0 flex-1">
                                                        <div class="flex items-center gap-2 flex-wrap">
                                                            <p class="text-sm font-semibold text-secondary-800 dark:text-neutral-100">{{ $item->title }}</p>
                                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold {{ $statusStyles[$item->status] ?? $statusStyles['PENDING'] }}">
                                                                {{ $statusLabels[$item->status] ?? $item->status }}
                                                            </span>
                                                        </div>
                                                        <div class="mt-2 grid grid-cols-2 gap-2 text-[11px]">
                                                            <div class="px-2 py-1.5 rounded-lg bg-white dark:bg-secondary-700/50 border border-neutral-200/60 dark:border-secondary-600/40">
                                                                <span class="text-neutral-400 dark:text-neutral-500">Pria</span>
                                                                <p class="font-semibold text-blue-600 dark:text-blue-400 tabular-nums">Rp {{ number_format($item->cost_pria, 0, ',', '.') }}</p>
                                                            </div>
                                                            <div class="px-2 py-1.5 rounded-lg bg-white dark:bg-secondary-700/50 border border-neutral-200/60 dark:border-secondary-600/40">
                                                                <span class="text-neutral-400 dark:text-neutral-500">Wanita</span>
                                                                <p class="font-semibold text-pink-600 dark:text-pink-400 tabular-nums">Rp {{ number_format($item->cost_wanita, 0, ',', '.') }}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="flex-shrink-0 flex items-center gap-1">
                                                        <button type="button" x-data @click="$dispatch('open-modal', 'edit-item-{{ $item->id }}')"
                                                            class="inline-flex items-center px-2.5 py-1.5 rounded-lg text-[11px] font-semibold text-primary dark:text-primary-400 hover:bg-primary-50 dark:hover:bg-primary-900/20 transition-colors">
                                                            Edit
                                                        </button>
                                                        <form action="{{ route('dashboard.planner.items.destroy', $item) }}" method="POST"
                                                            onsubmit="return confirm('Hapus item ini?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="inline-flex items-center px-2.5 py-1.5 rounded-lg text-[11px] font-semibold text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
                                                                Hapus
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            @endforeach

                                            <div class="flex items-center justify-between gap-3 p-3.5 rounded-xl bg-pink-50 dark:bg-pink-900/20 border border-pink-200/60 dark:border-pink-700/40">
                                                <div>
                                                    <p class="text-xs font-bold text-secondary-800 dark:text-neutral-100">Subtotal {{ \App\Models\WeddingPlannerItem::ENGAGEMENT_GROUP_LABELS[$groupCode] }}</p>
                                                    <p class="text-[11px] text-neutral-500 dark:text-neutral-400 mt-0.5">Pria Rp {{ number_format($groupPria, 0, ',', '.') }} · Wanita Rp {{ number_format($groupWanita, 0, ',', '.') }}</p>
                                                </div>
                                                <p class="text-base font-bold text-pink-700 dark:text-pink-300 tabular-nums">Rp {{ number_format($groupTotal, 0, ',', '.') }}</p>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach

                                <div class="mt-4 p-4 rounded-xl bg-pink-50 dark:bg-pink-900/20 border border-pink-200/60 dark:border-pink-700/40">
                                    <p class="text-sm font-bold text-secondary-800 dark:text-neutral-100">Total Pengeluaran</p>
                                    <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-1">Pria Rp {{ number_format($engTotalPria, 0, ',', '.') }} · Wanita Rp {{ number_format($engTotalWanita, 0, ',', '.') }}</p>
                                    <div class="mt-1.5 flex items-baseline gap-2">
                                        <p class="text-xl font-bold text-pink-700 dark:text-pink-300 tabular-nums">Rp {{ number_format($engTotal, 0, ',', '.') }}</p>
                                        <span class="text-[10px] text-neutral-400 dark:text-neutral-500">total pengeluaran</span>
                                    </div>
                                </div>
                            @endif

                        @elseif($pillar['key'] === 'PRE_WEDDING')
                            @php
                                $preItems = $itemsByCategory['PRE_WEDDING'];
                                $preTotalBudget = $preItems->sum('estimated_cost');
                                $preTotalRealisasi = $preItems->sum('actual_cost');
                                $preTotalPaid = $preItems->sum('paid_amount');
                            @endphp
                            <div class="flex items-center justify-between gap-3 mb-4">
                                <div>
                                    <h3 class="font-semibold text-secondary-800 dark:text-neutral-100">Item persiapan</h3>
                                    <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-0.5">
                                        {{ $preItems->count() }} item · total Rp {{ number_format($preTotalBudget, 0, ',', '.') }}
                                    </p>
                                </div>
                                <button type="button" x-data
                                    @click="activeTab = 'PRE_WEDDING'; $dispatch('open-modal', 'add-item-PRE_WEDDING')"
                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-primary hover:bg-primary-600 text-white text-xs font-semibold transition-all">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                    Tambah Item
                                </button>
                            </div>

                            @if($preItems->isEmpty())
                                <div class="px-5 py-10 text-center text-sm text-neutral-400 dark:text-neutral-500 border border-dashed border-neutral-200 dark:border-secondary-600 rounded-xl">
                                    Belum ada item persiapan. Tambahkan item untuk mulai merencanakan pre-wedding.
                                </div>
                            @else
                                <div class="space-y-2.5">
                                    @foreach($preItems as $item)
                                        <div class="flex items-start gap-3 p-3.5 rounded-xl border border-neutral-200/70 dark:border-secondary-700/50 bg-neutral-50/60 dark:bg-secondary-700/30">
                                            <span class="flex-shrink-0 w-7 h-7 flex items-center justify-center rounded-lg text-xs font-bold text-white bg-violet-500">{{ $loop->iteration }}</span>
                                            <div class="min-w-0 flex-1">
                                                <div class="flex items-center gap-2 flex-wrap">
                                                    <p class="text-sm font-semibold text-secondary-800 dark:text-neutral-100">{{ $item->title }}</p>
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold {{ $statusStyles[$item->status] ?? $statusStyles['PENDING'] }}">
                                                        {{ $statusLabels[$item->status] ?? $item->status }}
                                                    </span>
                                                </div>
                                                <div class="mt-2 grid grid-cols-2 gap-2 text-[11px]">
                                                    <div class="px-2 py-1.5 rounded-lg bg-white dark:bg-secondary-700/50 border border-neutral-200/60 dark:border-secondary-600/40">
                                                        <span class="text-neutral-400 dark:text-neutral-500">Budget</span>
                                                        <p class="font-semibold text-secondary-700 dark:text-neutral-200 tabular-nums">Rp {{ number_format($item->estimated_cost, 0, ',', '.') }}</p>
                                                    </div>
                                                    <div class="px-2 py-1.5 rounded-lg bg-white dark:bg-secondary-700/50 border border-neutral-200/60 dark:border-secondary-600/40">
                                                        <span class="text-neutral-400 dark:text-neutral-500">Realisasi</span>
                                                        <p class="font-semibold text-secondary-700 dark:text-neutral-200 tabular-nums">Rp {{ number_format($item->actual_cost, 0, ',', '.') }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="flex-shrink-0 flex items-center gap-1">
                                                <button type="button" x-data @click="$dispatch('open-modal', 'edit-item-{{ $item->id }}')"
                                                    class="inline-flex items-center px-2.5 py-1.5 rounded-lg text-[11px] font-semibold text-primary dark:text-primary-400 hover:bg-primary-50 dark:hover:bg-primary-900/20 transition-colors">
                                                    Edit
                                                </button>
                                                <form action="{{ route('dashboard.planner.items.destroy', $item) }}" method="POST"
                                                    onsubmit="return confirm('Hapus item ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="inline-flex items-center px-2.5 py-1.5 rounded-lg text-[11px] font-semibold text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="mt-4 p-4 rounded-xl bg-violet-50 dark:bg-violet-900/20 border border-violet-200/60 dark:border-violet-700/40">
                                    <p class="text-sm font-bold text-secondary-800 dark:text-neutral-100">Total keseluruhan</p>
                                    <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-1">Budget Rp {{ number_format($preTotalBudget, 0, ',', '.') }} · Realisasi Rp {{ number_format($preTotalRealisasi, 0, ',', '.') }}</p>
                                    <div class="mt-1.5 flex items-baseline gap-2">
                                        <p class="text-xl font-bold text-violet-700 dark:text-violet-300 tabular-nums">Rp {{ number_format($preTotalPaid, 0, ',', '.') }}</p>
                                        <span class="text-[10px] text-neutral-400 dark:text-neutral-500">total terbayar</span>
                                    </div>
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
                            <div class="flex items-center justify-between gap-3 mb-4">
                                <div>
                                    <h3 class="font-semibold text-secondary-800 dark:text-neutral-100">Seserahan</h3>
                                    <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-0.5">
                                        {{ $sesItems->count() }} item · dibagi per pihak (pria & wanita)
                                    </p>
                                </div>
                                <button type="button" x-data
                                    @click="activeTab = 'SESERAHAN'; $dispatch('open-modal', 'add-item-SESERAHAN')"
                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-primary hover:bg-primary-600 text-white text-xs font-semibold transition-all">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                    Tambah Data
                                </button>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 mb-5">
                                <div class="p-3.5 rounded-xl border border-neutral-200/70 dark:border-secondary-700/50 bg-neutral-50/60 dark:bg-secondary-700/30">
                                    <span class="text-[11px] text-neutral-400 dark:text-neutral-500">Total Pengeluaran</span>
                                    <p class="text-lg font-bold text-secondary-800 dark:text-neutral-100 tabular-nums mt-0.5">Rp {{ number_format($sesTotal, 0, ',', '.') }}</p>
                                </div>
                                <div class="p-3.5 rounded-xl border border-neutral-200/70 dark:border-secondary-700/50 bg-neutral-50/60 dark:bg-secondary-700/30">
                                    <span class="text-[11px] text-neutral-400 dark:text-neutral-500">Pria (CPP)</span>
                                    <p class="text-lg font-bold text-blue-600 dark:text-blue-400 tabular-nums mt-0.5">Rp {{ number_format($sesTotalPria, 0, ',', '.') }}</p>
                                </div>
                                <div class="p-3.5 rounded-xl border border-neutral-200/70 dark:border-secondary-700/50 bg-neutral-50/60 dark:bg-secondary-700/30">
                                    <span class="text-[11px] text-neutral-400 dark:text-neutral-500">Wanita (CPW)</span>
                                    <p class="text-lg font-bold text-pink-600 dark:text-pink-400 tabular-nums mt-0.5">Rp {{ number_format($sesTotalWanita, 0, ',', '.') }}</p>
                                </div>
                            </div>

                            @if($sesItems->isEmpty())
                                <div class="px-5 py-10 text-center text-sm text-neutral-400 dark:text-neutral-500 border border-dashed border-neutral-200 dark:border-secondary-600 rounded-xl">
                                    Belum ada item seserahan. Tambahkan data untuk mulai merencanakan.
                                </div>
                            @else
                                @php
                                    $sesPartyStyles = [
                                        'PRIA' => [
                                            'badge' => 'bg-blue-500',
                                            'cost' => 'text-blue-600 dark:text-blue-400',
                                            'subtotal' => 'text-blue-700 dark:text-blue-300',
                                        ],
                                        'WANITA' => [
                                            'badge' => 'bg-pink-500',
                                            'cost' => 'text-pink-600 dark:text-pink-400',
                                            'subtotal' => 'text-pink-700 dark:text-pink-300',
                                        ],
                                    ];
                                @endphp
                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                                    @foreach(\App\Models\WeddingPlannerItem::SESERAHAN_PARTIES as $partyCode => $partyLabel)
                                        @php
                                            $partyItems = $partyCode === 'PRIA' ? $sesPriaItems : $sesWanitaItems;
                                            $partyTotal = $partyCode === 'PRIA' ? $sesTotalPria : $sesTotalWanita;
                                            $partyStyle = $sesPartyStyles[$partyCode];
                                        @endphp
                                        <div class="rounded-2xl border border-neutral-200/80 dark:border-secondary-700/60 overflow-hidden bg-white dark:bg-secondary-800">
                                            <div class="px-4 py-3 bg-neutral-50 dark:bg-secondary-700/40 border-b border-neutral-200/80 dark:border-secondary-700/60 flex items-center justify-between gap-3">
                                                <h4 class="text-sm font-semibold text-secondary-800 dark:text-neutral-100">{{ $partyLabel }}</h4>
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-700 dark:bg-amber-900/40 dark:text-amber-300">
                                                    {{ $partyItems->count() }} item
                                                </span>
                                            </div>

                                            @if($partyItems->isEmpty())
                                                <div class="px-4 py-8 text-center text-sm text-neutral-400 dark:text-neutral-500">
                                                    Belum ada item untuk {{ strtolower($partyLabel) }}.
                                                </div>
                                            @else
                                                <ul class="divide-y divide-neutral-100 dark:divide-secondary-700/50">
                                                    @foreach($partyItems as $item)
                                                        <li class="px-4 py-2.5 flex items-center gap-3 hover:bg-neutral-50 dark:hover:bg-secondary-700/30 transition-colors">
                                                            <span class="flex-shrink-0 w-6 h-6 flex items-center justify-center rounded-lg text-[10px] font-bold text-white {{ $partyStyle['badge'] }}">{{ $loop->iteration }}</span>
                                                            <div class="min-w-0 flex-1">
                                                                <div class="flex items-center gap-2 flex-wrap">
                                                                    <p class="text-sm font-medium text-secondary-800 dark:text-neutral-100">{{ $item->title }}</p>
                                                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold {{ $statusStyles[$item->status] ?? $statusStyles['PENDING'] }}">
                                                                        {{ $statusLabels[$item->status] ?? $item->status }}
                                                                    </span>
                                                                </div>
                                                                <p class="text-xs font-semibold mt-0.5 tabular-nums {{ $partyStyle['cost'] }}">Rp {{ number_format($item->estimated_cost, 0, ',', '.') }}</p>
                                                            </div>
                                                            <div class="flex-shrink-0 flex items-center gap-1">
                                                                <button type="button" x-data @click="$dispatch('open-modal', 'edit-item-{{ $item->id }}')"
                                                                    class="inline-flex items-center px-2.5 py-1.5 rounded-lg text-[11px] font-semibold text-primary dark:text-primary-400 hover:bg-primary-50 dark:hover:bg-primary-900/20 transition-colors">
                                                                    Edit
                                                                </button>
                                                                <form action="{{ route('dashboard.planner.items.destroy', $item) }}" method="POST" class="inline"
                                                                    onsubmit="return confirm('Hapus item ini?')">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="inline-flex items-center px-2.5 py-1.5 rounded-lg text-[11px] font-semibold text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
                                                                        Hapus
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @endif

                                            <div class="px-4 py-3 border-t border-neutral-100 dark:border-secondary-700/50 flex items-center justify-between gap-3">
                                                <span class="text-[11px] text-neutral-400 dark:text-neutral-500">Subtotal {{ $partyLabel }}</span>
                                                <p class="text-sm font-bold tabular-nums {{ $partyStyle['subtotal'] }}">Rp {{ number_format($partyTotal, 0, ',', '.') }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="mt-4 p-4 rounded-xl bg-amber-50 dark:bg-amber-900/20 border border-amber-200/60 dark:border-amber-700/40">
                                    <p class="text-sm font-bold text-secondary-800 dark:text-neutral-100">Total Pengeluaran</p>
                                    <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-1">Pria Rp {{ number_format($sesTotalPria, 0, ',', '.') }} · Wanita Rp {{ number_format($sesTotalWanita, 0, ',', '.') }}</p>
                                    <div class="mt-1.5 flex items-baseline gap-2">
                                        <p class="text-xl font-bold text-amber-700 dark:text-amber-300 tabular-nums">Rp {{ number_format($sesTotal, 0, ',', '.') }}</p>
                                        <span class="text-[10px] text-neutral-400 dark:text-neutral-500">total pengeluaran</span>
                                    </div>
                                </div>
                            @endif

                        @else
                        <div class="flex items-center justify-between gap-3 mb-4">
                            <div>
                                <h3 class="font-semibold text-secondary-800 dark:text-neutral-100">{{ $pillar['label'] }}</h3>
                                <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-0.5">
                                    {{ count(\App\Models\WeddingPlannerItem::STATUSES) === 4 ? 'Kelola item persiapan '.strtolower($pillar['label']).'.' : '' }}
                                </p>
                            </div>
                            <button type="button" x-data
                                @click="activeTab = '{{ $pillar['key'] }}'; $dispatch('open-modal', 'add-item-{{ $pillar['key'] }}')"
                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-primary hover:bg-primary-600 text-white text-xs font-semibold transition-all">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                Tambah Item
                            </button>
                        </div>

                        @if($itemsByCategory[$pillar['key']]->isEmpty())
                            <div class="px-5 py-10 text-center text-sm text-neutral-400 dark:text-neutral-500 border border-dashed border-neutral-200 dark:border-secondary-600 rounded-xl">
                                Belum ada item pada pilar {{ $pillar['label'] }}.
                            </div>
                        @else
                            <div class="space-y-2.5">
                                @foreach($itemsByCategory[$pillar['key']] as $item)
                                    <div class="flex items-start gap-3 p-3.5 rounded-xl border border-neutral-200/70 dark:border-secondary-700/50 bg-neutral-50/60 dark:bg-secondary-700/30">
                                        <div class="min-w-0 flex-1">
                                            <div class="flex items-center gap-2 flex-wrap">
                                                <p class="text-sm font-semibold text-secondary-800 dark:text-neutral-100">{{ $item->title }}</p>
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold {{ $statusStyles[$item->status] ?? $statusStyles['PENDING'] }}">
                                                    {{ $statusLabels[$item->status] ?? $item->status }}
                                                </span>
                                            </div>
                                            @if($item->description)
                                                <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-1 line-clamp-2">{{ $item->description }}</p>
                                            @endif
                                            @if($item->event_date)
                                                <p class="text-xs text-neutral-400 dark:text-neutral-500 mt-1 flex items-center gap-1">
                                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                                    {{ $item->event_date->translatedFormat('d M Y') }}
                                                </p>
                                            @endif

                                            @if(in_array($pillar['key'], ['BUDGET', 'VENDOR']))
                                                <div class="mt-2 grid grid-cols-2 sm:grid-cols-4 gap-2 text-[11px]">
                                                    <div class="px-2 py-1.5 rounded-lg bg-white dark:bg-secondary-700/50 border border-neutral-200/60 dark:border-secondary-600/40">
                                                        <span class="text-neutral-400 dark:text-neutral-500">Estimasi</span>
                                                        <p class="font-semibold text-secondary-700 dark:text-neutral-200 tabular-nums">Rp {{ number_format($item->estimated_cost, 0, ',', '.') }}</p>
                                                    </div>
                                                    <div class="px-2 py-1.5 rounded-lg bg-white dark:bg-secondary-700/50 border border-neutral-200/60 dark:border-secondary-600/40">
                                                        <span class="text-neutral-400 dark:text-neutral-500">Realisasi</span>
                                                        <p class="font-semibold text-secondary-700 dark:text-neutral-200 tabular-nums">Rp {{ number_format($item->actual_cost, 0, ',', '.') }}</p>
                                                    </div>
                                                    <div class="px-2 py-1.5 rounded-lg bg-white dark:bg-secondary-700/50 border border-neutral-200/60 dark:border-secondary-600/40">
                                                        <span class="text-neutral-400 dark:text-neutral-500">Terbayar</span>
                                                        <p class="font-semibold text-emerald-600 dark:text-emerald-400 tabular-nums">Rp {{ number_format($item->paid_amount, 0, ',', '.') }}</p>
                                                    </div>
                                                    <div class="px-2 py-1.5 rounded-lg bg-white dark:bg-secondary-700/50 border border-neutral-200/60 dark:border-secondary-600/40">
                                                        <span class="text-neutral-400 dark:text-neutral-500">Sisa</span>
                                                        <p class="font-semibold text-amber-600 dark:text-amber-400 tabular-nums">Rp {{ number_format(max(0, $item->remaining_balance), 0, ',', '.') }}</p>
                                                    </div>
                                                </div>
                                            @endif

                                            @if($item->vendor_contact)
                                                <p class="text-xs text-neutral-400 dark:text-neutral-500 mt-1.5">{{ $item->vendor_contact }}</p>
                                            @endif
                                        </div>
                                        <div class="flex-shrink-0 flex items-center gap-1">
                                            <button type="button" x-data @click="$dispatch('open-modal', 'edit-item-{{ $item->id }}')"
                                                class="inline-flex items-center px-2.5 py-1.5 rounded-lg text-[11px] font-semibold text-primary dark:text-primary-400 hover:bg-primary-50 dark:hover:bg-primary-900/20 transition-colors">
                                                Edit
                                            </button>
                                            <form action="{{ route('dashboard.planner.items.destroy', $item) }}" method="POST"
                                                onsubmit="return confirm('Hapus item ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-flex items-center px-2.5 py-1.5 rounded-lg text-[11px] font-semibold text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
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
                <h3 class="text-lg font-bold text-secondary-800 dark:text-neutral-100 mb-1">Tambah Item {{ $pillar['label'] }}</h3>
                <p class="text-xs text-neutral-500 dark:text-neutral-400 mb-5">Simpan item baru ke pilar {{ $pillar['label'] }}.</p>

                <form action="{{ route('dashboard.planner.items.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <input type="hidden" name="category" value="{{ $pillar['key'] }}">

                    <div>
                        <x-input-label for="add-title-{{ $pillar['key'] }}" value="Judul" />
                        <x-text-input id="add-title-{{ $pillar['key'] }}" name="title" class="mt-1 block w-full" placeholder="cth: Booking venue" required />
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="add-desc-{{ $pillar['key'] }}" value="Deskripsi" />
                        <textarea id="add-desc-{{ $pillar['key'] }}" name="description" rows="2" class="mt-1 block w-full border-neutral-300 dark:border-neutral-600 dark:bg-secondary-700 dark:text-neutral-200 focus:border-primary-500 focus:ring-primary-500 rounded-xl shadow-sm" placeholder="Catatan opsional"></textarea>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="add-date-{{ $pillar['key'] }}" value="Tanggal" />
                            <x-text-input id="add-date-{{ $pillar['key'] }}" name="event_date" type="date" class="mt-1 block w-full" />
                        </div>
                        <div>
                            <x-input-label for="add-status-{{ $pillar['key'] }}" value="Status" />
                            <select id="add-status-{{ $pillar['key'] }}" name="status" class="mt-1 block w-full border-neutral-300 dark:border-neutral-600 dark:bg-secondary-700 dark:text-neutral-200 focus:border-primary-500 focus:ring-primary-500 rounded-xl shadow-sm">
                                @foreach($statusOptions as $status)
                                    <option value="{{ $status }}">{{ $statusLabels[$status] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    @if(in_array($pillar['key'], ['BUDGET', 'VENDOR']))
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div>
                                <x-input-label for="add-est-{{ $pillar['key'] }}" value="Estimasi (Rp)" />
                                <x-text-input id="add-est-{{ $pillar['key'] }}" name="estimated_cost" type="number" min="0" step="0.01" value="0" class="mt-1 block w-full" />
                            </div>
                            <div>
                                <x-input-label for="add-act-{{ $pillar['key'] }}" value="Realisasi (Rp)" />
                                <x-text-input id="add-act-{{ $pillar['key'] }}" name="actual_cost" type="number" min="0" step="0.01" value="0" class="mt-1 block w-full" />
                            </div>
                            <div>
                                <x-input-label for="add-paid-{{ $pillar['key'] }}" value="Terbayar (Rp)" />
                                <x-text-input id="add-paid-{{ $pillar['key'] }}" name="paid_amount" type="number" min="0" step="0.01" value="0" class="mt-1 block w-full" />
                            </div>
                        </div>
                            <div>
                                <x-input-label for="add-contact-{{ $pillar['key'] }}" value="Kontak Vendor" />
                                <x-text-input id="add-contact-{{ $pillar['key'] }}" name="vendor_contact" class="mt-1 block w-full" placeholder="cth: 0812-3456-7890" />
                            </div>
                        @endif

                        @if($pillar['key'] === 'ENGAGEMENT')
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <x-input-label for="add-pria-{{ $pillar['key'] }}" value="Biaya Pria (CPP) (Rp)" />
                                    <x-text-input id="add-pria-{{ $pillar['key'] }}" name="cost_pria" type="number" min="0" step="0.01" value="0" class="mt-1 block w-full" />
                                </div>
                                <div>
                                    <x-input-label for="add-wanita-{{ $pillar['key'] }}" value="Biaya Wanita (CPW) (Rp)" />
                                    <x-text-input id="add-wanita-{{ $pillar['key'] }}" name="cost_wanita" type="number" min="0" step="0.01" value="0" class="mt-1 block w-full" />
                                </div>
                            </div>
                        @endif

                        @if($pillar['key'] === 'SESERAHAN')
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <x-input-label for="add-party-{{ $pillar['key'] }}" value="Pihak" />
                                    <select id="add-party-{{ $pillar['key'] }}" name="subcategory" class="mt-1 block w-full border-neutral-300 dark:border-neutral-600 dark:bg-secondary-700 dark:text-neutral-200 focus:border-primary-500 focus:ring-primary-500 rounded-xl shadow-sm" required>
                                        <option value="PRIA">Pria (CPP)</option>
                                        <option value="WANITA">Wanita (CPW)</option>
                                    </select>
                                </div>
                                <div>
                                    <x-input-label for="add-est-{{ $pillar['key'] }}" value="Biaya (Rp)" />
                                    <x-text-input id="add-est-{{ $pillar['key'] }}" name="estimated_cost" type="number" min="0" step="0.01" value="0" class="mt-1 block w-full" />
                                </div>
                            </div>
                        @endif

                        <div class="flex justify-end gap-2 pt-2">
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
                <h3 class="text-lg font-bold text-secondary-800 dark:text-neutral-100 mb-1">Edit Item</h3>
                <p class="text-xs text-neutral-500 dark:text-neutral-400 mb-5">{{ $item->title }}</p>

                <form action="{{ route('dashboard.planner.items.update', $item) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="category" value="{{ $item->category }}">

                    <div>
                        <x-input-label for="edit-title-{{ $item->id }}" value="Judul" />
                        <x-text-input id="edit-title-{{ $item->id }}" name="title" class="mt-1 block w-full" value="{{ old('title', $item->title) }}" required />
                    </div>

                    <div>
                        <x-input-label for="edit-desc-{{ $item->id }}" value="Deskripsi" />
                        <textarea id="edit-desc-{{ $item->id }}" name="description" rows="2" class="mt-1 block w-full border-neutral-300 dark:border-neutral-600 dark:bg-secondary-700 dark:text-neutral-200 focus:border-primary-500 focus:ring-primary-500 rounded-xl shadow-sm">{{ old('description', $item->description) }}</textarea>
                    </div>

                    @if($item->category === 'VENDOR')
                        <div>
                            <x-input-label for="edit-vendor-type-{{ $item->id }}" value="Kategori Vendor" />
                            <select id="edit-vendor-type-{{ $item->id }}" name="vendor_type" class="mt-1 block w-full border-neutral-300 dark:border-neutral-600 dark:bg-secondary-700 dark:text-neutral-200 focus:border-primary-500 focus:ring-primary-500 rounded-xl shadow-sm" required>
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
                                <x-input-label for="edit-pria-{{ $item->id }}" value="Biaya Pria (CPP) (Rp)" />
                                <x-text-input id="edit-pria-{{ $item->id }}" name="cost_pria" type="number" min="0" step="0.01" value="{{ old('cost_pria', (float) $item->cost_pria) }}" class="mt-1 block w-full" />
                            </div>
                            <div>
                                <x-input-label for="edit-wanita-{{ $item->id }}" value="Biaya Wanita (CPW) (Rp)" />
                                <x-text-input id="edit-wanita-{{ $item->id }}" name="cost_wanita" type="number" min="0" step="0.01" value="{{ old('cost_wanita', (float) $item->cost_wanita) }}" class="mt-1 block w-full" />
                            </div>
                        </div>
                    @endif

                    @if($item->category === 'SESERAHAN')
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="edit-party-{{ $item->id }}" value="Pihak" />
                                <select id="edit-party-{{ $item->id }}" name="subcategory" class="mt-1 block w-full border-neutral-300 dark:border-neutral-600 dark:bg-secondary-700 dark:text-neutral-200 focus:border-primary-500 focus:ring-primary-500 rounded-xl shadow-sm" required>
                                    <option value="PRIA" @selected($item->subcategory === 'PRIA')>Pria (CPP)</option>
                                    <option value="WANITA" @selected($item->subcategory === 'WANITA')>Wanita (CPW)</option>
                                </select>
                            </div>
                            <div>
                                <x-input-label for="edit-est-{{ $item->id }}" value="Biaya (Rp)" />
                                <x-text-input id="edit-est-{{ $item->id }}" name="estimated_cost" type="number" min="0" step="0.01" class="mt-1 block w-full" value="{{ old('estimated_cost', $item->estimated_cost) }}" />
                            </div>
                        </div>
                    @endif

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="edit-date-{{ $item->id }}" value="Tanggal" />
                            <x-text-input id="edit-date-{{ $item->id }}" name="event_date" type="date" class="mt-1 block w-full" value="{{ $item->event_date?->format('Y-m-d') }}" />
                        </div>
                        <div>
                            <x-input-label for="edit-status-{{ $item->id }}" value="Status" />
                            <select id="edit-status-{{ $item->id }}" name="status" class="mt-1 block w-full border-neutral-300 dark:border-neutral-600 dark:bg-secondary-700 dark:text-neutral-200 focus:border-primary-500 focus:ring-primary-500 rounded-xl shadow-sm">
                                @foreach($statusOptions as $status)
                                    <option value="{{ $status }}" @selected($item->status === $status)>{{ $statusLabels[$status] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    @if($item->isFinancialCategory())
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div>
                                <x-input-label for="edit-est-{{ $item->id }}" value="Estimasi (Rp)" />
                                <x-text-input id="edit-est-{{ $item->id }}" name="estimated_cost" type="number" min="0" step="0.01" class="mt-1 block w-full" value="{{ old('estimated_cost', $item->estimated_cost) }}" />
                            </div>
                            <div>
                                <x-input-label for="edit-act-{{ $item->id }}" value="Realisasi (Rp)" />
                                <x-text-input id="edit-act-{{ $item->id }}" name="actual_cost" type="number" min="0" step="0.01" class="mt-1 block w-full" value="{{ old('actual_cost', $item->actual_cost) }}" />
                            </div>
                            <div>
                                <x-input-label for="edit-paid-{{ $item->id }}" value="Terbayar (Rp)" />
                                <x-text-input id="edit-paid-{{ $item->id }}" name="paid_amount" type="number" min="0" step="0.01" class="mt-1 block w-full" value="{{ old('paid_amount', $item->paid_amount) }}" />
                            </div>
                        </div>
                        <div>
                            <x-input-label for="edit-contact-{{ $item->id }}" value="Kontak Vendor" />
                            <x-text-input id="edit-contact-{{ $item->id }}" name="vendor_contact" class="mt-1 block w-full" value="{{ old('vendor_contact', $item->vendor_contact) }}" />
                        </div>
                    @endif

                    <div class="flex justify-end gap-2 pt-2">
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
            <h3 class="text-lg font-bold text-secondary-800 dark:text-neutral-100 mb-1">Tambah Checklist</h3>
            <p class="text-xs text-neutral-500 dark:text-neutral-400 mb-5">Tambahkan checklist custom sesuai kebutuhan.</p>

            <form action="{{ route('dashboard.planner.checklists.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <x-input-label for="add-checklist-category" value="Kategori" />
                    <select id="add-checklist-category" name="category_code" class="mt-1 block w-full border-neutral-300 dark:border-neutral-600 dark:bg-secondary-700 dark:text-neutral-200 focus:border-primary-500 focus:ring-primary-500 rounded-xl shadow-sm" required>
                        @foreach(\App\Models\WeddingChecklist::CATEGORIES as $code => $label)
                            <option value="{{ $code }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <x-input-label for="add-checklist-title" value="Nama Tugas" />
                    <x-text-input id="add-checklist-title" name="title" class="mt-1 block w-full" placeholder="cth: Sewa mobil pengantin" required />
                    <x-input-error :messages="$errors->get('title')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="add-checklist-desc" value="Deskripsi" />
                    <textarea id="add-checklist-desc" name="description" rows="2" class="mt-1 block w-full border-neutral-300 dark:border-neutral-600 dark:bg-secondary-700 dark:text-neutral-200 focus:border-primary-500 focus:ring-primary-500 rounded-xl shadow-sm" placeholder="Catatan opsional"></textarea>
                </div>
                <div class="flex justify-end gap-2 pt-2">
                    <x-secondary-button type="button" x-on:click="show = false">Batal</x-secondary-button>
                    <x-primary-button type="submit">Simpan Checklist</x-primary-button>
                </div>
            </form>
        </div>
    </x-modal>

    {{-- ─── Modals: Add Vendor ─── --}}
    <x-modal name="add-vendor">
        <div class="p-6" x-data="{ vendorType: 'VENUE' }" x-on:set-vendor-type.window="vendorType = $event.detail.type">
            <h3 class="text-lg font-bold text-secondary-800 dark:text-neutral-100 mb-1">Tambah Vendor</h3>
            <p class="text-xs text-neutral-500 dark:text-neutral-400 mb-5">Simpan vendor baru ke kategori persiapan.</p>

            <form action="{{ route('dashboard.planner.items.store') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="category" value="VENDOR">

                <div>
                    <x-input-label for="add-vendor-type" value="Kategori Vendor" />
                    <select id="add-vendor-type" name="vendor_type" x-model="vendorType"
                        class="mt-1 block w-full border-neutral-300 dark:border-neutral-600 dark:bg-secondary-700 dark:text-neutral-200 focus:border-primary-500 focus:ring-primary-500 rounded-xl shadow-sm" required>
                        @foreach(\App\Models\WeddingPlannerItem::VENDOR_TYPES as $code => $label)
                            <option value="{{ $code }}">{{ $label }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('vendor_type')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="add-vendor-title" value="Nama Vendor" />
                    <x-text-input id="add-vendor-title" name="title" class="mt-1 block w-full" placeholder="cth: Venue Ballroom Grand" required />
                    <x-input-error :messages="$errors->get('title')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="add-vendor-desc" value="Deskripsi" />
                    <textarea id="add-vendor-desc" name="description" rows="2" class="mt-1 block w-full border-neutral-300 dark:border-neutral-600 dark:bg-secondary-700 dark:text-neutral-200 focus:border-primary-500 focus:ring-primary-500 rounded-xl shadow-sm" placeholder="Catatan opsional"></textarea>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <x-input-label for="add-vendor-est" value="Estimasi (Rp)" />
                        <x-text-input id="add-vendor-est" name="estimated_cost" type="number" min="0" step="0.01" value="0" class="mt-1 block w-full" />
                    </div>
                    <div>
                        <x-input-label for="add-vendor-act" value="Realisasi (Rp)" />
                        <x-text-input id="add-vendor-act" name="actual_cost" type="number" min="0" step="0.01" value="0" class="mt-1 block w-full" />
                    </div>
                    <div>
                        <x-input-label for="add-vendor-paid" value="Terbayar (Rp)" />
                        <x-text-input id="add-vendor-paid" name="paid_amount" type="number" min="0" step="0.01" value="0" class="mt-1 block w-full" />
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <x-input-label for="add-vendor-contact" value="Kontak Vendor" />
                        <x-text-input id="add-vendor-contact" name="vendor_contact" class="mt-1 block w-full" placeholder="cth: 0812-3456-7890" />
                    </div>
                    <div>
                        <x-input-label for="add-vendor-status" value="Status" />
                        <select id="add-vendor-status" name="status" class="mt-1 block w-full border-neutral-300 dark:border-neutral-600 dark:bg-secondary-700 dark:text-neutral-200 focus:border-primary-500 focus:ring-primary-500 rounded-xl shadow-sm">
                            @foreach($statusOptions as $status)
                                <option value="{{ $status }}">{{ $statusLabels[$status] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="flex justify-end gap-2 pt-2">
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
                <h3 class="text-lg font-bold text-secondary-800 dark:text-neutral-100 mb-1">Edit Checklist</h3>
                <p class="text-xs text-neutral-500 dark:text-neutral-400 mb-5">{{ $item->title }}</p>

                <form action="{{ route('dashboard.planner.checklists.update', $item) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PATCH')
                    <div>
                        <x-input-label for="edit-checklist-category-{{ $item->id }}" value="Kategori" />
                        <select id="edit-checklist-category-{{ $item->id }}" name="category_code" class="mt-1 block w-full border-neutral-300 dark:border-neutral-600 dark:bg-secondary-700 dark:text-neutral-200 focus:border-primary-500 focus:ring-primary-500 rounded-xl shadow-sm" required>
                            @foreach(\App\Models\WeddingChecklist::CATEGORIES as $code => $label)
                                <option value="{{ $code }}" @selected($item->category_code === $code)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <x-input-label for="edit-checklist-title-{{ $item->id }}" value="Nama Tugas" />
                        <x-text-input id="edit-checklist-title-{{ $item->id }}" name="title" class="mt-1 block w-full" value="{{ old('title', $item->title) }}" required />
                    </div>
                    <div>
                        <x-input-label for="edit-checklist-desc-{{ $item->id }}" value="Deskripsi" />
                        <textarea id="edit-checklist-desc-{{ $item->id }}" name="description" rows="2" class="mt-1 block w-full border-neutral-300 dark:border-neutral-600 dark:bg-secondary-700 dark:text-neutral-200 focus:border-primary-500 focus:ring-primary-500 rounded-xl shadow-sm">{{ old('description', $item->description) }}</textarea>
                    </div>
                    <div class="flex justify-end gap-2 pt-2">
                        <x-secondary-button type="button" x-on:click="show = false">Batal</x-secondary-button>
                        <x-primary-button type="submit">Perbarui Checklist</x-primary-button>
                    </div>
                </form>
            </div>
        </x-modal>
    @endforeach

    {{-- ─── Modals: Add Rundown ─── --}}
    <x-modal name="add-rundown">
        <div class="p-6">
            <h3 class="text-lg font-bold text-secondary-800 dark:text-neutral-100 mb-1">Tambah Rundown</h3>
            <p class="text-xs text-neutral-500 dark:text-neutral-400 mb-5">Tambahkan jadwal kegiatan Hari H.</p>

            <form action="{{ route('dashboard.planner.rundowns.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <x-input-label for="add-rundown-name" value="Nama Kegiatan" />
                    <x-text-input id="add-rundown-name" name="activity_name" class="mt-1 block w-full" placeholder="cth: Akad Nikah" required />
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <x-input-label for="add-rundown-start" value="Mulai (HH:MM)" />
                        <x-text-input id="add-rundown-start" name="time_start" type="time" class="mt-1 block w-full" required />
                    </div>
                    <div>
                        <x-input-label for="add-rundown-end" value="Selesai (HH:MM)" />
                        <x-text-input id="add-rundown-end" name="time_end" type="time" class="mt-1 block w-full" />
                    </div>
                </div>

                <div>
                    <x-input-label for="add-rundown-pic" value="Person in Charge" />
                    <x-text-input id="add-rundown-pic" name="person_in_charge" class="mt-1 block w-full" placeholder="cth: MC / Panitia" />
                </div>

                <div>
                    <x-input-label for="add-rundown-notes" value="Catatan" />
                    <textarea id="add-rundown-notes" name="notes" rows="2" class="mt-1 block w-full border-neutral-300 dark:border-neutral-600 dark:bg-secondary-700 dark:text-neutral-200 focus:border-primary-500 focus:ring-primary-500 rounded-xl shadow-sm"></textarea>
                </div>

                <div class="flex justify-end gap-2 pt-2">
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
                <h3 class="text-lg font-bold text-secondary-800 dark:text-neutral-100 mb-1">Edit Rundown</h3>
                <p class="text-xs text-neutral-500 dark:text-neutral-400 mb-5">{{ $rundown->activity_name }}</p>

                <form action="{{ route('dashboard.planner.rundowns.update', $rundown) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PATCH')
                    <div>
                        <x-input-label for="edit-rundown-name-{{ $rundown->id }}" value="Nama Kegiatan" />
                        <x-text-input id="edit-rundown-name-{{ $rundown->id }}" name="activity_name" class="mt-1 block w-full" value="{{ old('activity_name', $rundown->activity_name) }}" required />
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="edit-rundown-start-{{ $rundown->id }}" value="Mulai (HH:MM)" />
                            <x-text-input id="edit-rundown-start-{{ $rundown->id }}" name="time_start" type="time" class="mt-1 block w-full" value="{{ $rundown->time_start->format('H:i') }}" required />
                        </div>
                        <div>
                            <x-input-label for="edit-rundown-end-{{ $rundown->id }}" value="Selesai (HH:MM)" />
                            <x-text-input id="edit-rundown-end-{{ $rundown->id }}" name="time_end" type="time" class="mt-1 block w-full" value="{{ $rundown->time_end?->format('H:i') }}" />
                        </div>
                    </div>

                    <div>
                        <x-input-label for="edit-rundown-pic-{{ $rundown->id }}" value="Person in Charge" />
                        <x-text-input id="edit-rundown-pic-{{ $rundown->id }}" name="person_in_charge" class="mt-1 block w-full" value="{{ old('person_in_charge', $rundown->person_in_charge) }}" />
                    </div>

                    <div>
                        <x-input-label for="edit-rundown-notes-{{ $rundown->id }}" value="Catatan" />
                        <textarea id="edit-rundown-notes-{{ $rundown->id }}" name="notes" rows="2" class="mt-1 block w-full border-neutral-300 dark:border-neutral-600 dark:bg-secondary-700 dark:text-neutral-200 focus:border-primary-500 focus:ring-primary-500 rounded-xl shadow-sm">{{ old('notes', $rundown->notes) }}</textarea>
                    </div>

                    <div class="flex justify-end gap-2 pt-2">
                        <x-secondary-button type="button" x-on:click="show = false">Batal</x-secondary-button>
                        <x-primary-button type="submit">Perbarui Rundown</x-primary-button>
                    </div>
                </form>
            </div>
        </x-modal>
    @endforeach

    @push('scripts')
    @php
        $checklistItemsForJs = $checklists->mapWithKeys(fn ($item) => [
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
        function plannerCalendar() {
            return {
                year: new Date().getFullYear(),
                month: new Date().getMonth(),
                today: new Date().toISOString().slice(0, 10),
                weddingDate: @json($weddingDate?->format('Y-m-d')),

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
                        cells.push({ key: 'blank-' + i, isOutside: true, day: '', isToday: false, isWedding: false });
                    }

                    for (let d = 1; d <= daysInMonth; d++) {
                        const date = this.year + '-' + String(this.month + 1).padStart(2, '0') + '-' + String(d).padStart(2, '0');
                        cells.push({
                            key: date,
                            day: d,
                            isOutside: false,
                            isToday: date === this.today,
                            isWedding: this.weddingDate !== null && date === this.weddingDate,
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

        function plannerCountdown(targetDate) {
            return {
                target: new Date(targetDate + 'T23:59:59').getTime(),
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
