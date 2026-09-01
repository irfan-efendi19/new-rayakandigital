<section aria-labelledby="rundown-title"
    class="overflow-hidden rounded-3xl border border-neutral-200 bg-white shadow-[0_18px_45px_-28px_rgba(15,23,42,0.35)] dark:border-secondary-700 dark:bg-secondary-800">
    <div class="flex flex-col gap-4 border-b border-neutral-200 px-5 py-5 dark:border-secondary-700 sm:flex-row sm:items-center sm:justify-between sm:px-6">
        <div class="flex items-center gap-3">
            <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-secondary-900 text-primary-400 dark:bg-secondary-700">
                <i class="fa-regular fa-clock" aria-hidden="true"></i>
            </span>
            <div>
                <div class="flex items-center gap-2">
                    <h2 id="rundown-title" class="font-heading text-lg font-bold text-secondary-900 dark:text-white sm:text-xl">Rundown Hari H</h2>
                    <span class="rounded-full bg-neutral-100 px-2 py-0.5 text-[10px] font-bold text-neutral-500 dark:bg-secondary-700 dark:text-neutral-300">{{ $rundowns->count() }} agenda</span>
                </div>
                <p class="mt-1 text-xs leading-5 text-neutral-500 dark:text-neutral-400">Susun alur acara secara kronologis agar setiap tim bergerak tepat waktu.</p>
            </div>
        </div>
        <button type="button" x-data @click="$dispatch('open-modal', 'add-rundown')"
            class="inline-flex items-center justify-center gap-2 rounded-xl bg-secondary-900 px-4 py-2.5 text-xs font-bold text-white transition hover:-translate-y-0.5 hover:bg-primary-600 dark:bg-primary-500 dark:hover:bg-primary-400">
            <i class="fa-solid fa-plus text-[10px]" aria-hidden="true"></i>
            Tambah rundown
        </button>
    </div>

    @if($rundowns->isEmpty())
        <div class="relative overflow-hidden px-5 py-12 text-center sm:py-14">
            <div class="absolute left-1/2 top-0 h-40 w-40 -translate-x-1/2 rounded-full bg-primary-50 blur-3xl dark:bg-primary-900/20"></div>
            <div class="relative">
                <span class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl border border-neutral-200 bg-neutral-50 text-neutral-400 shadow-sm dark:border-secondary-700 dark:bg-secondary-900 dark:text-neutral-500">
                    <i class="fa-solid fa-timeline text-xl" aria-hidden="true"></i>
                </span>
                <h3 class="mt-4 text-sm font-bold text-secondary-900 dark:text-white">Hari H belum punya alur acara</h3>
                <p class="mx-auto mt-2 max-w-md text-xs leading-6 text-neutral-500 dark:text-neutral-400">Mulai dari waktu akad atau pemberkatan, lalu tambahkan resepsi dan agenda penting lainnya.</p>
                <button type="button" x-data @click="$dispatch('open-modal', 'add-rundown')"
                    class="mt-5 inline-flex items-center justify-center gap-2 rounded-xl border border-primary-200 bg-primary-50 px-4 py-2.5 text-xs font-bold text-primary-700 transition hover:border-primary-300 hover:bg-primary-100 dark:border-primary-800 dark:bg-primary-900/20 dark:text-primary-300 dark:hover:bg-primary-900/30">
                    <i class="fa-solid fa-plus text-[10px]" aria-hidden="true"></i>
                    Tambah agenda pertama
                </button>
            </div>
        </div>
    @else
        <div class="px-4 py-5 sm:px-6 sm:py-6">
            <div class="relative flex flex-col gap-3 before:absolute before:bottom-6 before:left-[47px] before:top-6 before:w-px before:bg-gradient-to-b before:from-primary-400 before:via-neutral-200 before:to-transparent dark:before:via-secondary-600 sm:before:left-[63px]">
                @foreach($rundowns as $index => $rundown)
                    <article class="group relative grid grid-cols-[96px_1fr] gap-3 sm:grid-cols-[128px_1fr] sm:gap-4">
                        <div class="relative z-10 flex items-start justify-center pt-4">
                            <div class="rounded-xl border border-neutral-200 bg-white px-2.5 py-2 text-center shadow-sm dark:border-secondary-600 dark:bg-secondary-900 sm:min-w-[76px]">
                                <p class="text-sm font-extrabold tabular-nums text-secondary-900 dark:text-white">{{ $rundown->time_start->format('H:i') }}</p>
                                @if($rundown->time_end)
                                    <p class="mt-0.5 text-[9px] tabular-nums text-neutral-400">hingga {{ $rundown->time_end->format('H:i') }}</p>
                                @else
                                    <p class="mt-0.5 text-[9px] text-neutral-400">mulai</p>
                                @endif
                            </div>
                        </div>

                        <div class="rounded-2xl border border-neutral-200 bg-neutral-50/70 p-4 transition duration-200 hover:border-primary-200 hover:bg-primary-50/30 dark:border-secondary-700 dark:bg-secondary-900/50 dark:hover:border-primary-800 dark:hover:bg-primary-900/10">
                            <div class="flex items-start justify-between gap-3">
                                <div class="min-w-0">
                                    <div class="flex items-center gap-2">
                                        <span class="text-[9px] font-bold uppercase tracking-[0.16em] text-primary-600 dark:text-primary-400">Agenda {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                                    </div>
                                    <h3 class="mt-1 text-sm font-bold text-secondary-900 dark:text-white sm:text-base">{{ $rundown->activity_name }}</h3>
                                    <div class="mt-2 flex flex-wrap items-center gap-x-4 gap-y-2">
                                        @if($rundown->person_in_charge)
                                            <span class="inline-flex items-center gap-1.5 text-[11px] text-neutral-500 dark:text-neutral-400">
                                                <i class="fa-regular fa-user text-[10px]" aria-hidden="true"></i>
                                                {{ $rundown->person_in_charge }}
                                            </span>
                                        @endif
                                        @if($rundown->notes)
                                            <span class="inline-flex min-w-0 items-center gap-1.5 text-[11px] text-neutral-400 dark:text-neutral-500">
                                                <i class="fa-regular fa-note-sticky shrink-0 text-[10px]" aria-hidden="true"></i>
                                                <span class="truncate">{{ $rundown->notes }}</span>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="flex shrink-0 items-center gap-1 sm:opacity-0 sm:transition-opacity sm:group-hover:opacity-100 sm:focus-within:opacity-100">
                                    <button type="button" x-data @click="$dispatch('open-modal', 'edit-rundown-{{ $rundown->id }}')"
                                        class="flex h-8 w-8 items-center justify-center rounded-lg text-neutral-400 transition hover:bg-primary-50 hover:text-primary-600 dark:hover:bg-primary-900/20 dark:hover:text-primary-300"
                                        aria-label="Edit rundown {{ $rundown->activity_name }}">
                                        <i class="fa-solid fa-pen text-[10px]" aria-hidden="true"></i>
                                    </button>
                                    <form action="{{ route('dashboard.planner.rundowns.destroy', $rundown) }}" method="POST"
                                        onsubmit="return confirmSwal(event, 'Hapus rundown ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="flex h-8 w-8 items-center justify-center rounded-lg text-neutral-400 transition hover:bg-red-50 hover:text-red-600 dark:hover:bg-red-900/20 dark:hover:text-red-400"
                                            aria-label="Hapus rundown {{ $rundown->activity_name }}">
                                            <i class="fa-solid fa-trash text-[10px]" aria-hidden="true"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    @endif
</section>
