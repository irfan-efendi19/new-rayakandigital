@if(session('success'))
    <div class="flex items-center gap-3 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800 shadow-sm dark:border-emerald-800/50 dark:bg-emerald-950/30 dark:text-emerald-300"
        role="status">
        <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-emerald-100 text-emerald-600 dark:bg-emerald-900/50 dark:text-emerald-300">
            <i class="fa-solid fa-check text-xs" aria-hidden="true"></i>
        </span>
        {{ session('success') }}
    </div>
@endif

@php
    $financialItemCount = $itemsByCategory['BUDGET']->count()
        + $itemsByCategory['VENDOR']->count()
        + $itemsByCategory['SESERAHAN']->count()
        + $itemsByCategory['ENGAGEMENT']->count()
        + $itemsByCategory['PRE_WEDDING']->count();
    $paidPercent = $totalEstimated > 0 ? min(100, round(($totalPaid / $totalEstimated) * 100)) : 0;
    $actualCostTotal = $plannerItems
        ->whereIn('category', ['BUDGET', 'VENDOR', 'SESERAHAN', 'ENGAGEMENT', 'PRE_WEDDING'])
        ->sum('actual_cost');
    $remainingBudget = max(0, $actualCostTotal - $totalPaid);
@endphp

<section aria-labelledby="financial-overview-title">
    <div class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-primary-600 dark:text-primary-400">Ringkasan keuangan</p>
            <h2 id="financial-overview-title" class="mt-1 font-heading text-xl font-bold text-secondary-900 dark:text-white sm:text-2xl">
                Kendalikan anggaran dengan tenang
            </h2>
        </div>
        <p class="max-w-md text-xs leading-5 text-neutral-500 dark:text-neutral-400">Pantau estimasi, pembayaran, dan sisa tagihan tanpa berpindah modul.</p>
    </div>

    <div class="mt-4 grid gap-4 lg:grid-cols-3">
        <article class="group relative overflow-hidden rounded-3xl border border-neutral-200 bg-white p-5 shadow-[0_18px_45px_-28px_rgba(15,23,42,0.35)] transition hover:-translate-y-0.5 hover:shadow-xl dark:border-secondary-700 dark:bg-secondary-800 sm:p-6">
            <div class="absolute -right-10 -top-10 h-28 w-28 rounded-full bg-primary-100/70 blur-2xl dark:bg-primary-900/20"></div>
            <div class="relative flex items-start justify-between gap-4">
                <div>
                    <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-neutral-400 dark:text-neutral-500">Estimasi anggaran</p>
                    <p class="mt-3 text-2xl font-extrabold tabular-nums text-secondary-900 dark:text-white sm:text-3xl">
                        <span class="text-sm font-bold text-neutral-400">Rp</span> {{ number_format($totalEstimated, 0, ',', '.') }}
                    </p>
                </div>
                <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-primary-50 text-primary-600 dark:bg-primary-900/30 dark:text-primary-300">
                    <i class="fa-solid fa-coins" aria-hidden="true"></i>
                </span>
            </div>
            <div class="relative mt-6 flex items-center justify-between gap-3 border-t border-neutral-100 pt-4 text-xs dark:border-secondary-700">
                <span class="text-neutral-500 dark:text-neutral-400">{{ $financialItemCount }} item tercatat</span>
                <span class="font-semibold text-primary-600 dark:text-primary-400">Rencana keseluruhan</span>
            </div>
        </article>

        <article class="group relative overflow-hidden rounded-3xl border border-neutral-200 bg-white p-5 shadow-[0_18px_45px_-28px_rgba(15,23,42,0.35)] transition hover:-translate-y-0.5 hover:shadow-xl dark:border-secondary-700 dark:bg-secondary-800 sm:p-6">
            <div class="absolute -right-10 -top-10 h-28 w-28 rounded-full bg-emerald-100/70 blur-2xl dark:bg-emerald-900/20"></div>
            <div class="relative flex items-start justify-between gap-4">
                <div>
                    <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-neutral-400 dark:text-neutral-500">Terbayar (DP/Lunas)</p>
                    <p class="mt-3 text-2xl font-extrabold tabular-nums text-secondary-900 dark:text-white sm:text-3xl">
                        <span class="text-sm font-bold text-neutral-400">Rp</span> {{ number_format($totalPaid, 0, ',', '.') }}
                    </p>
                </div>
                <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-600 dark:bg-emerald-900/30 dark:text-emerald-300">
                    <i class="fa-solid fa-circle-check" aria-hidden="true"></i>
                </span>
            </div>
            <div class="relative mt-6">
                <div class="flex items-center justify-between text-[11px]">
                    <span class="text-neutral-500 dark:text-neutral-400">Progress pembayaran</span>
                    <span class="font-bold text-emerald-600 dark:text-emerald-400">{{ $paidPercent }}%</span>
                </div>
                <div class="mt-2 h-1.5 overflow-hidden rounded-full bg-neutral-100 dark:bg-secondary-700">
                    <div class="h-full rounded-full bg-emerald-500" style="width: {{ $paidPercent }}%"></div>
                </div>
            </div>
        </article>

        <article class="group relative overflow-hidden rounded-3xl border border-neutral-200 bg-white p-5 shadow-[0_18px_45px_-28px_rgba(15,23,42,0.35)] transition hover:-translate-y-0.5 hover:shadow-xl dark:border-secondary-700 dark:bg-secondary-800 sm:p-6">
            <div class="absolute -right-10 -top-10 h-28 w-28 rounded-full bg-amber-100/70 blur-2xl dark:bg-amber-900/20"></div>
            <div class="relative flex items-start justify-between gap-4">
                <div>
                    <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-neutral-400 dark:text-neutral-500">Sisa biaya aktual</p>
                    <p class="mt-3 text-2xl font-extrabold tabular-nums text-secondary-900 dark:text-white sm:text-3xl">
                        <span class="text-sm font-bold text-neutral-400">Rp</span> {{ number_format($remainingBudget, 0, ',', '.') }}
                    </p>
                </div>
                <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-amber-50 text-amber-600 dark:bg-amber-900/30 dark:text-amber-300">
                    <i class="fa-solid fa-receipt" aria-hidden="true"></i>
                </span>
            </div>
            <div class="relative mt-6 flex items-center justify-between gap-3 border-t border-neutral-100 pt-4 text-xs dark:border-secondary-700">
                <span class="text-neutral-500 dark:text-neutral-400">Biaya aktual belum terbayar</span>
                <button type="button" x-data @click="$dispatch('open-modal', 'add-vendor')"
                    class="inline-flex items-center gap-1 font-semibold text-amber-600 transition hover:text-amber-700 dark:text-amber-400 dark:hover:text-amber-300">
                    Catat vendor <i class="fa-solid fa-arrow-right text-[9px]" aria-hidden="true"></i>
                </button>
            </div>
        </article>
    </div>
</section>
