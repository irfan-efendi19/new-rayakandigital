{{-- ─── KALENDER BULANAN ─── --}}
@php
    $calendarItems = $itemsByCategory['CALENDAR']->sortBy('event_date');
@endphp
<div class="relative mb-5 overflow-hidden rounded-[28px] border border-blue-200/70 bg-gradient-to-br from-blue-600 via-blue-600 to-indigo-700 p-5 text-white shadow-[0_20px_50px_-24px_rgba(37,99,235,0.65)] dark:border-blue-800/50 sm:p-6">
    <div class="pointer-events-none absolute -right-10 -top-12 h-40 w-40 rounded-full bg-white/10 blur-2xl"></div>
    <div class="relative flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">
        <div class="flex items-center gap-4">
            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-white/15 ring-1 ring-white/20 backdrop-blur-sm">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 7V3m8 4V3M5 11h14M5 5h14a2 2 0 012 2v12a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2z" />
                </svg>
            </div>
            <div>
                <p class="text-[10px] font-bold uppercase tracking-[0.24em] text-blue-100">Jadwal Pernikahan</p>
                <h3 class="mt-1 font-heading text-xl font-bold sm:text-2xl">Kalender Bulanan</h3>
                <p class="mt-1 text-xs text-blue-100/85">Susun agenda penting menuju Hari H dalam satu tempat.</p>
            </div>
        </div>
        <div class="flex items-center gap-2 self-start rounded-2xl bg-white/10 px-3 py-2 ring-1 ring-white/15 backdrop-blur-sm sm:self-auto">
            <span class="flex h-8 w-8 items-center justify-center rounded-xl bg-white text-sm font-bold text-blue-600">{{ $calendarItems->count() }}</span>
            <span class="pr-1 text-xs font-semibold text-blue-50">agenda tercatat</span>
        </div>
    </div>
</div>

<div x-data="plannerCalendar()"
    class="overflow-hidden rounded-[24px] border border-neutral-200/80 bg-white shadow-[0_18px_45px_-28px_rgba(15,23,42,0.45)] ring-1 ring-black/5 dark:border-secondary-700/60 dark:bg-secondary-800/80">
    {{-- Header --}}
    <div
        class="flex items-center justify-between gap-3 bg-gradient-to-r from-blue-600 to-indigo-600 px-5 py-4 dark:from-blue-700 dark:to-indigo-800">
        <button type="button" @click="prevMonth()"
            aria-label="Bulan sebelumnya"
            class="inline-flex items-center justify-center w-9 h-9 rounded-xl text-white/80 hover:bg-white/20 hover:text-white transition-all">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7" />
            </svg>
        </button>
        <div class="text-center flex-1">
            <p class="text-base font-bold text-white" x-text="monthLabel"></p>
            <p class="text-[11px] text-white/70 font-medium mt-0.5" x-text="weddingLabel">
            </p>
        </div>
        <button type="button" @click="nextMonth()"
            aria-label="Bulan berikutnya"
            class="inline-flex items-center justify-center w-9 h-9 rounded-xl text-white/80 hover:bg-white/20 hover:text-white transition-all">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
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
                        <svg class="w-2.5 h-2.5 sm:w-3 sm:h-3 text-amber-500" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
                        </svg>
                    </template>
                    <template x-if="cell.hasEvent && !cell.isWedding">
                        <span class="w-1 h-1 sm:w-1.5 sm:h-1.5 rounded-full bg-emerald-500"></span>
                    </template>
                </div>
            </button>
        </template>
    </div>
</div>

@if($weddingDate)
    <div class="mt-4 flex items-center gap-4 text-[11px] text-neutral-500 dark:text-neutral-400 flex-wrap">
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
@if($calendarItems->isNotEmpty())
    <div class="mt-5">
        <h4 class="text-xs font-bold uppercase tracking-wider text-neutral-400 dark:text-neutral-500 mb-3">
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
                        <p class="text-sm font-medium text-secondary-800 dark:text-neutral-100 truncate">
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
                        <button type="button" x-data @click="$dispatch('open-modal', 'edit-item-{{ $event->id }}')"
                            class="p-1.5 rounded-lg text-neutral-400 hover:text-primary hover:bg-primary-50 dark:hover:bg-primary-900/20 transition-colors">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </button>
                        <form action="{{ route('dashboard.planner.items.destroy', $event) }}" method="POST" class="inline"
                            onsubmit="event.stopPropagation(); return confirmSwal(event, 'Hapus agenda ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="p-1.5 rounded-lg text-neutral-400 hover:text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
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
