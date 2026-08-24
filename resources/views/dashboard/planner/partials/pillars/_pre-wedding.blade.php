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
    <button type="button" x-data @click="setActiveTab('PRE_WEDDING'); $dispatch('open-modal', 'add-item-PRE_WEDDING')"
        class="inline-flex items-center gap-1.5 rounded-xl bg-primary px-2.5 py-1.5 text-[11px] font-semibold text-white transition-all hover:bg-primary-600 sm:px-3 sm:text-xs">
        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
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
            <span class="text-[10px] text-neutral-400 dark:text-neutral-500 sm:text-[11px]">Budget</span>
            <p class="mt-0.5 text-sm font-bold text-secondary-800 dark:text-neutral-100 tabular-nums sm:text-lg">
                Rp {{ number_format($preTotalBudget, 0, ',', '.') }}</p>
        </div>
        <div
            class="rounded-2xl border border-emerald-200/70 bg-emerald-50/70 p-2.5 text-center dark:border-emerald-800/50 dark:bg-emerald-900/20 sm:p-3.5">
            <span class="text-[10px] text-emerald-500 dark:text-emerald-400 sm:text-[11px]">Bayar</span>
            <p class="mt-0.5 text-sm font-bold text-emerald-600 dark:text-emerald-400 tabular-nums sm:text-lg">
                Rp {{ number_format($preTotalPaid, 0, ',', '.') }}</p>
        </div>
        <div
            class="rounded-2xl border border-amber-200/70 bg-amber-50/70 p-2.5 text-center dark:border-amber-800/50 dark:bg-amber-900/20 sm:p-3.5">
            <span class="text-[10px] text-amber-500 dark:text-amber-400 sm:text-[11px]">Sisa</span>
            <p class="mt-0.5 text-sm font-bold text-amber-600 dark:text-amber-400 tabular-nums sm:text-lg">
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
                        <div
                            class="flex items-center gap-1 shrink-0 sm:opacity-0 sm:group-hover:opacity-100 sm:focus-within:opacity-100 transition-opacity duration-150">
                            <button type="button" x-data @click="$dispatch('open-modal', 'edit-item-{{ $item->id }}')"
                                class="p-1.5 rounded-lg text-neutral-400 hover:text-primary dark:hover:text-primary-400 hover:bg-primary-50 dark:hover:bg-primary-900/20 transition-colors">
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
                                    class="p-1.5 rounded-lg text-neutral-400 hover:text-red-600 dark:hover:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
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