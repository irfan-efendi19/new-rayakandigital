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
                <p class="mt-2 text-xl font-bold text-secondary-900 tabular-nums dark:text-white sm:text-2xl">
                    Rp
                    {{ number_format($totalEstimated, 0, ',', '.') }}
                </p>
            </div>
            <div class="rounded-2xl bg-primary/10 p-2.5 text-primary dark:bg-primary-500/10 dark:text-primary-300">
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
                <p class="mt-2 text-xl font-bold text-secondary-900 tabular-nums dark:text-white sm:text-2xl">
                    Rp
                    {{ number_format($totalPaid, 0, ',', '.') }}
                </p>
            </div>
            <div class="rounded-2xl bg-emerald-50 p-2.5 text-emerald-600 dark:bg-emerald-900/30 dark:text-emerald-400">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M5 13l4 4L19 7" />
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
                <p class="mt-2 text-xl font-bold text-secondary-900 tabular-nums dark:text-white sm:text-2xl">
                    Rp
                    {{ number_format($vendorTotalRemaining, 0, ',', '.') }}
                </p>
            </div>
            <div class="rounded-2xl bg-amber-50 p-2.5 text-amber-600 dark:bg-amber-900/30 dark:text-amber-400">
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