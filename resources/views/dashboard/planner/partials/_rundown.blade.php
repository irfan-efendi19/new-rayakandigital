{{-- ── Rundown Hari H ── --}}
<div
    class="overflow-hidden rounded-3xl border border-neutral-200/80 bg-white shadow-[0_16px_40px_-24px_rgba(15,23,42,0.25)] dark:border-secondary-700/70 dark:bg-secondary-800">
    <div
        class="flex items-center justify-between gap-3 border-b border-neutral-200/80 px-4 py-3 sm:px-5 sm:py-4 dark:border-secondary-700/60">
        <div class="flex items-center gap-3">
            <div class="rounded-2xl bg-primary/10 p-2 text-primary dark:bg-primary-500/10 dark:text-primary-300">
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
                            <p class="text-sm font-bold text-secondary-800 dark:text-neutral-100 tabular-nums leading-tight">
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
                                            <svg class="w-3 h-3 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                            {{ $rundown->person_in_charge }}
                                        </span>
                                    @endif
                                    @if($rundown->notes)
                                        <span
                                            class="inline-flex items-center gap-1 text-[11px] text-neutral-400 dark:text-neutral-500 truncate max-w-[180px]">
                                            <svg class="w-3 h-3 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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
                                <button type="button" x-data @click="$dispatch('open-modal', 'edit-rundown-{{ $rundown->id }}')"
                                    class="rounded-lg p-1.5 text-neutral-400 transition-colors hover:bg-primary-50 hover:text-primary dark:hover:bg-primary-900/20 dark:hover:text-primary-400">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </button>
                                <form action="{{ route('dashboard.planner.rundowns.destroy', $rundown) }}" method="POST"
                                    onsubmit="return confirm('Hapus rundown ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="rounded-lg p-1.5 text-neutral-400 transition-colors hover:bg-red-50 hover:text-red-600 dark:hover:bg-red-900/20 dark:hover:text-red-400">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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