@props(['package', 'quote'])

<div class="space-y-2">
    <div x-cloak x-show="price(@js($package->package_code))?.promotion" x-transition.opacity class="flex flex-wrap items-center gap-2">
        <span class="text-xs text-neutral-500 line-through" x-text="'Rp ' + money(price(@js($package->package_code))?.original_amount)">Rp {{ number_format($quote['original_amount'], 0, ',', '.') }}</span>
        <span class="rounded-md bg-emerald-50 px-2 py-1 text-xs font-bold text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300"
            x-text="'Hemat ' + price(@js($package->package_code))?.savings_percent + '%'"></span>
    </div>
    <div class="flex items-baseline gap-1 text-secondary-900 dark:text-neutral-100">
        <span class="text-lg font-bold">Rp</span>
        <span class="text-4xl font-extrabold tracking-tight" x-text="money(price(@js($package->package_code))?.amount ?? {{ (int) $package->price }})">{{ number_format($quote['amount'], 0, ',', '.') }}</span>
    </div>
    @if($package->price > 0)
        <p class="text-xs text-neutral-500 dark:text-neutral-400">/ {{ $package->active_period_days === 0 ? 'Lifetime' : $package->active_period_days.' Hari' }}</p>
    @endif
    <div x-cloak x-show="price(@js($package->package_code))?.promotion" x-transition.opacity
        class="mt-1 flex items-center gap-2 rounded-lg bg-emerald-50 px-3 py-2 dark:bg-emerald-900/20"
        x-data="{ labels: ['jam','mnt','dtk'] }">
        <svg class="h-3.5 w-3.5 shrink-0 text-emerald-600 dark:text-emerald-400" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-13a.75.75 0 00-1.5 0v5c0 .414.336.75.75.75h4a.75.75 0 000-1.5h-3.25V5z" clip-rule="evenodd"/>
        </svg>
        <span class="text-xs font-semibold text-emerald-700 dark:text-emerald-300 truncate" x-text="price(@js($package->package_code))?.promotion?.title"></span>
        <span class="ml-auto inline-flex items-center gap-1 font-mono text-[11px] font-bold tabular-nums text-emerald-700 dark:text-emerald-300">
            <template x-for="(seg, i) in (countdown(price(@js($package->package_code))?.promotion) || '00:00:00').split(':')" :key="i">
                <span class="inline-flex items-center gap-0.5">
                    <span class="flex flex-col items-center">
                        <span class="rounded bg-emerald-100 px-1 py-0.5 text-emerald-800 dark:bg-emerald-800/40 dark:text-emerald-200" x-text="seg"></span>
                        <span class="mt-0.5 text-[7px] font-medium text-emerald-500 dark:text-emerald-400 uppercase leading-none" x-text="labels[i]"></span>
                    </span>
                    <template x-if="i < 2">
                        <span class="text-emerald-400 dark:text-emerald-500 font-bold text-[10px] -mx-0.5 self-start mt-1">:</span>
                    </template>
                </span>
            </template>
        </span>
    </div>
</div>
