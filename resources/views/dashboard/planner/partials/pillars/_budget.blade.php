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
            <h3 class="font-semibold text-secondary-800 dark:text-neutral-100 text-sm sm:text-base">
                Anggaran
                Pernikahan</h3>
            <p class="text-[11px] sm:text-xs text-neutral-500 dark:text-neutral-400 mt-0.5">
                Kelola anggaran per
                kategori.</p>
        </div>
        <button type="button" x-data @click="setActiveTab('BUDGET'); $dispatch('open-modal', 'add-item-BUDGET')"
            class="inline-flex items-center gap-1.5 px-2.5 sm:px-3 py-1.5 rounded-xl bg-primary hover:bg-primary-600 text-white text-[11px] sm:text-xs font-semibold transition-all">
            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Tambah
        </button>
    </div>

    {{-- Summary Cards --}}
    <div class="grid grid-cols-3 gap-2 sm:gap-3 mb-5">
        <div
            class="rounded-2xl border border-neutral-200/70 bg-neutral-50/70 p-2.5 dark:border-secondary-700/50 dark:bg-secondary-700/40 sm:p-3.5">
            <span class="text-[10px] text-neutral-400 dark:text-neutral-500 sm:text-[11px]">Estimasi</span>
            <p class="mt-0.5 text-sm font-bold text-secondary-800 dark:text-neutral-100 tabular-nums sm:text-lg">
                Rp {{ number_format($budgetTotalEstimated, 0, ',', '.') }}</p>
        </div>
        <div
            class="rounded-2xl border border-emerald-200/70 bg-emerald-50/70 p-2.5 dark:border-emerald-800/50 dark:bg-emerald-900/20 sm:p-3.5">
            <span class="text-[10px] sm:text-[11px] text-emerald-500 dark:text-emerald-400">Terbayar</span>
            <p class="text-sm sm:text-lg font-bold text-emerald-600 dark:text-emerald-400 tabular-nums mt-0.5">
                Rp {{ number_format($budgetTotalPaid, 0, ',', '.') }}</p>
        </div>
        <div
            class="rounded-2xl border border-amber-200/70 bg-amber-50/70 p-2.5 dark:border-amber-800/50 dark:bg-amber-900/20 sm:p-3.5">
            <span class="text-[10px] text-amber-500 dark:text-amber-400 sm:text-[11px]">Sisa
                Vendor</span>
            <p class="mt-0.5 text-sm font-bold text-amber-600 dark:text-amber-400 tabular-nums sm:text-lg">
                Rp {{ number_format($vendorTotalRemaining, 0, ',', '.') }}</p>
        </div>
    </div>

    {{-- Progress Bar --}}
    <div
        class="mb-5 p-3 sm:p-4 rounded-xl border border-neutral-200/70 dark:border-secondary-700/50 bg-neutral-50/60 dark:bg-secondary-700/30">
        <div class="flex items-center justify-between mb-2">
            <span class="text-[11px] sm:text-xs font-semibold text-secondary-800 dark:text-neutral-100">Progres
                Pembayaran</span>
            <span
                class="text-[11px] sm:text-xs font-bold text-emerald-600 dark:text-emerald-400 tabular-nums">{{ $budgetPaidPercent }}%</span>
        </div>
        <div class="w-full h-2 sm:h-2.5 bg-neutral-200 dark:bg-secondary-600 rounded-full overflow-hidden">
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
    <div class="mb-5 flex items-center gap-1 overflow-x-auto rounded-2xl bg-neutral-100 p-1 dark:bg-secondary-700/50">
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
                    x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95"
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
                                <span class="text-[11px] font-semibold text-neutral-500 dark:text-neutral-400 tabular-nums">
                                    {{ $group['items']->count() }} item
                                </span>
                            </div>
                        </div>
                        <div class="flex items-center gap-4 text-[11px]">
                            <span class="text-neutral-400 dark:text-neutral-500">Budget: <span
                                    class="font-semibold text-secondary-700 dark:text-neutral-300">Rp
                                    {{ number_format($groupEstimated, 0, ',', '.') }}</span></span>
                            <span class="text-emerald-500 dark:text-emerald-400">Bayar: <span class="font-semibold">Rp
                                    {{ number_format($groupPaid, 0, ',', '.') }}</span></span>
                        </div>
                        <div class="mt-2 h-1.5 bg-neutral-200 dark:bg-secondary-600 rounded-full overflow-hidden">
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
                                            <p class="text-sm font-semibold text-secondary-800 dark:text-neutral-100 truncate">
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
                                    <div class="mt-3 flex items-center gap-3 flex-wrap">
                                        <div class="flex items-center gap-1.5">
                                            <span class="text-[10px] text-neutral-400 dark:text-neutral-500">Budget:</span>
                                            <span
                                                class="text-xs font-semibold text-secondary-700 dark:text-neutral-200 tabular-nums">Rp
                                                {{ number_format($item->estimated_cost, 0, ',', '.') }}</span>
                                        </div>
                                        <span class="hidden sm:block w-px h-3.5 bg-neutral-200 dark:bg-secondary-600"></span>
                                        <div class="flex items-center gap-1.5">
                                            <span class="text-[10px] text-emerald-400 dark:text-emerald-500">Bayar:</span>
                                            <span
                                                class="text-xs font-semibold text-emerald-600 dark:text-emerald-400 tabular-nums">Rp
                                                {{ number_format($item->paid_amount, 0, ',', '.') }}</span>
                                        </div>
                                        <span
                                            class="ml-auto text-[10px] font-semibold text-emerald-600 dark:text-emerald-400 tabular-nums">{{ $itemPaidPercent }}%</span>
                                    </div>
                                    <div class="mt-2 h-1.5 bg-neutral-200 dark:bg-secondary-600 rounded-full overflow-hidden">
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