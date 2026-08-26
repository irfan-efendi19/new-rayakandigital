@php
    $preItems = $itemsByCategory['PRE_WEDDING'];
    $preTotalBudget = $preItems->sum('estimated_cost');
    $preTotalActual = $preItems->sum('actual_cost');
    $preTotalPaid = $preItems->sum('paid_amount');
    $preTotalRemaining = max(0, $preTotalBudget - $preTotalPaid);
    $prePaidPercent = $preTotalBudget > 0 ? min(100, max(0, round(($preTotalPaid / $preTotalBudget) * 100))) : 0;
@endphp
<div class="relative mb-5 overflow-hidden rounded-[28px] border border-violet-200/70 bg-gradient-to-br from-violet-600 via-purple-600 to-indigo-700 p-5 text-white shadow-[0_20px_50px_-24px_rgba(124,58,237,0.6)] dark:border-violet-800/50 sm:p-6">
    <div class="pointer-events-none absolute -right-12 -top-14 h-44 w-44 rounded-full bg-white/10 blur-2xl"></div>
    <div class="relative flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">
    <div class="flex items-center gap-4">
        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-white/15 ring-1 ring-white/20 backdrop-blur-sm">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 7h4l2-3h6l2 3h4v12H3V7zm9 3a3 3 0 100 6 3 3 0 000-6z" /></svg>
        </div>
        <div>
        <p class="text-[10px] font-bold uppercase tracking-[0.24em] text-violet-100">Item persiapan &amp; dokumentasi</p>
        <h3 class="mt-1 font-heading text-xl font-bold sm:text-2xl">Pre-Wedding</h3>
        <p class="mt-1 text-xs text-violet-100/85">
            {{ $preItems->count() }} item · total Rp {{ number_format($preTotalBudget, 0, ',', '.') }}
        </p>
        </div>
    </div>
    <button type="button" x-data @click="setActiveTab('PRE_WEDDING'); $dispatch('open-modal', 'add-item-PRE_WEDDING')"
        class="inline-flex items-center gap-1.5 self-start rounded-xl bg-white px-3.5 py-2 text-xs font-bold text-violet-700 shadow-sm transition-all hover:-translate-y-0.5 hover:bg-violet-50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-offset-2 focus-visible:ring-offset-violet-600 sm:self-auto">
        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        Tambah
    </button>
    </div>
</div>

@if($preItems->isEmpty())
    <div class="rounded-3xl border border-dashed border-violet-200 bg-violet-50/40 px-5 py-10 text-center dark:border-violet-800/50 dark:bg-violet-950/15">
        <span class="mx-auto flex h-12 w-12 items-center justify-center rounded-2xl bg-white text-violet-500 shadow-sm dark:bg-secondary-800 dark:text-violet-300">
            <i class="fa-solid fa-camera-retro" aria-hidden="true"></i>
        </span>
        <p class="mt-3 text-sm font-semibold text-secondary-800 dark:text-neutral-100">Belum ada item pre-wedding</p>
        <p class="mt-1 text-xs text-neutral-500 dark:text-neutral-400">Mulai dari fotografer, lokasi, busana, atau jadwal pemotretan.</p>
        <button type="button" x-data @click="$dispatch('open-modal', 'add-item-PRE_WEDDING')"
            class="mt-4 inline-flex items-center gap-2 rounded-xl bg-violet-600 px-3.5 py-2 text-xs font-bold text-white transition hover:bg-violet-500 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-violet-400 focus-visible:ring-offset-2 dark:focus-visible:ring-offset-secondary-800">
            <i class="fa-solid fa-plus text-[10px]" aria-hidden="true"></i> Tambah item pertama
        </button>
    </div>
@else
    {{-- Summary Cards --}}
    <div class="mb-5 grid grid-cols-2 gap-3 sm:grid-cols-3">
        <div
            class="col-span-2 rounded-2xl border border-neutral-200/70 bg-neutral-50/70 p-3.5 dark:border-secondary-700/50 dark:bg-secondary-700/40 sm:col-span-1 sm:p-4">
            <span class="text-[10px] text-neutral-400 dark:text-neutral-500 sm:text-[11px]">Total keseluruhan <span class="opacity-70">(estimasi)</span></span>
            <p class="mt-1 text-lg font-extrabold text-secondary-800 dark:text-neutral-100 tabular-nums sm:text-xl">
                Rp {{ number_format($preTotalBudget, 0, ',', '.') }}</p>
        </div>
        <div
            class="rounded-2xl border border-emerald-200/70 bg-emerald-50/70 p-3.5 dark:border-emerald-800/50 dark:bg-emerald-900/20 sm:p-4">
            <span class="text-[10px] text-emerald-500 dark:text-emerald-400 sm:text-[11px]">Sudah terbayar</span>
            <p class="mt-0.5 text-sm font-bold text-emerald-600 dark:text-emerald-400 tabular-nums sm:text-lg">
                Rp {{ number_format($preTotalPaid, 0, ',', '.') }}</p>
        </div>
        <div
            class="rounded-2xl border border-amber-200/70 bg-amber-50/70 p-3.5 dark:border-amber-800/50 dark:bg-amber-900/20 sm:p-4">
            <span class="text-[10px] text-amber-500 dark:text-amber-400 sm:text-[11px]">Belum terbayar</span>
            <p class="mt-0.5 text-sm font-bold text-amber-600 dark:text-amber-400 tabular-nums sm:text-lg">
                Rp
                {{ number_format($preTotalRemaining, 0, ',', '.') }}
            </p>
        </div>
    </div>

    <div class="mb-5 flex flex-col gap-2 rounded-2xl border border-violet-200/70 bg-violet-50/60 px-4 py-3 text-xs dark:border-violet-800/50 dark:bg-violet-900/15 sm:flex-row sm:items-center sm:justify-between">
        <span class="font-semibold text-violet-800 dark:text-violet-200">Budget Rp {{ number_format($preTotalBudget, 0, ',', '.') }} · Realisasi Rp {{ number_format($preTotalActual, 0, ',', '.') }}</span>
        <span class="text-violet-600/70 dark:text-violet-300/70">Rp {{ number_format($preTotalPaid, 0, ',', '.') }} total terbayar</span>
    </div>

    {{-- Progress Bar --}}
    <div
        class="mb-5 p-4 rounded-xl border border-neutral-200/70 dark:border-secondary-700/50 bg-neutral-50/60 dark:bg-secondary-700/30">
        <div class="flex items-center justify-between mb-2">
            <span class="text-xs font-semibold text-secondary-800 dark:text-neutral-100">Progres
                Pembayaran</span>
            <span class="text-xs font-bold text-violet-600 dark:text-violet-400 tabular-nums">{{ $prePaidPercent }}%</span>
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
    <div class="grid gap-3 lg:grid-cols-2">
        @foreach($preItems as $item)
            @php
                $itemPaidPercent = $item->estimated_cost > 0 ? min(100, max(0, round(($item->paid_amount / $item->estimated_cost) * 100))) : 0;
            @endphp
            <div
                class="group relative flex items-stretch rounded-2xl border border-neutral-200/80 bg-neutral-50/70 shadow-sm transition-all duration-200 hover:border-violet-300 hover:bg-violet-50/30 dark:border-secondary-600/50 dark:bg-secondary-700/30 dark:hover:border-violet-700/50 dark:hover:bg-violet-900/10">
                <div
                    class="flex w-12 shrink-0 items-center justify-center rounded-l-2xl border-r border-neutral-200 bg-violet-50/50 dark:border-secondary-600/50 dark:bg-violet-900/20">
                    <span
                        class="w-6 h-6 flex items-center justify-center rounded-lg text-[10px] font-bold text-white bg-violet-500">{{ $loop->iteration }}</span>
                </div>
                <div class="flex-1 px-4 py-3 min-w-0">
                    <div class="flex items-start justify-between gap-2">
                        <div class="min-w-0">
                            <div class="flex items-center gap-2 flex-wrap">
                                <p class="text-sm font-semibold text-secondary-800 dark:text-neutral-100 truncate">
                                    {{ $item->title }}
                                </p>
                                <span
                                    class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold {{ $statusStyles[$item->status] ?? $statusStyles['PENDING'] }}">
                                    {{ $statusLabels[$item->status] ?? $item->status }}
                                </span>
                            </div>
                            <div class="flex items-center gap-4 mt-2">
                                <div class="flex items-center gap-1.5">
                                    <span class="text-[10px] text-neutral-400 dark:text-neutral-500">Budget:</span>
                                    <span class="text-xs font-semibold text-secondary-700 dark:text-neutral-200 tabular-nums">Rp
                                        {{ number_format($item->estimated_cost, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <span class="text-[10px] text-neutral-400 dark:text-neutral-500">Bayar:</span>
                                    <span class="text-xs font-semibold text-emerald-600 dark:text-emerald-400 tabular-nums">Rp
                                        {{ number_format($item->paid_amount, 0, ',', '.') }}</span>
                                </div>
                            </div>
                            <div class="mt-2 flex items-center gap-2">
                                <div class="flex-1 h-1.5 bg-neutral-200 dark:bg-secondary-600 rounded-full overflow-hidden">
                                    <div class="h-full bg-violet-500 rounded-full" style="width: {{ $itemPaidPercent }}%"></div>
                                </div>
                                <span
                                    class="text-[10px] font-semibold text-violet-600 dark:text-violet-400 tabular-nums">{{ $itemPaidPercent }}%</span>
                            </div>
                        </div>
                        <div class="flex shrink-0 items-center gap-1">
                            <button type="button" x-data @click="$dispatch('open-modal', 'edit-item-{{ $item->id }}')"
                                aria-label="Edit {{ $item->title }}"
                                class="rounded-lg p-1.5 text-neutral-400 transition-colors hover:bg-primary-50 hover:text-primary focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-primary-400 dark:hover:bg-primary-900/20 dark:hover:text-primary-400">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </button>
                            <form action="{{ route('dashboard.planner.items.destroy', $item) }}" method="POST"
                                onsubmit="return confirm('Hapus item ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    aria-label="Hapus {{ $item->title }}"
                                    class="rounded-lg p-1.5 text-neutral-400 transition-colors hover:bg-red-50 hover:text-red-600 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-red-400 dark:hover:bg-red-900/20 dark:hover:text-red-400">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
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
