@php
    $engItems = $itemsByCategory['ENGAGEMENT'];
    $engTotalPria = (float) $engItems->sum('cost_pria');
    $engTotalWanita = (float) $engItems->sum('cost_wanita');
    $engTotal = $engTotalPria + $engTotalWanita;
@endphp
<div class="mb-5 flex items-center justify-between gap-3">
    <div>
        <h3 class="text-sm font-semibold text-secondary-800 dark:text-neutral-100 sm:text-base">
            Rencana Pertunangan</h3>
        <p class="mt-0.5 text-[11px] text-neutral-500 dark:text-neutral-400 sm:text-xs">
            {{ $engItems->count() }} item
        </p>
    </div>
    <button type="button" x-data @click="setActiveTab('ENGAGEMENT'); $dispatch('open-modal', 'add-item-ENGAGEMENT')"
        class="inline-flex items-center gap-1.5 rounded-xl bg-primary px-2.5 py-1.5 text-[11px] font-semibold text-white transition-all hover:bg-primary-600 sm:px-3 sm:text-xs">
        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        Tambah
    </button>
</div>

{{-- Summary --}}
<div class="mb-5 grid grid-cols-3 gap-2 sm:gap-3">
    <div
        class="rounded-2xl border border-neutral-200/70 bg-neutral-50/70 p-2.5 text-center dark:border-secondary-700/50 dark:bg-secondary-700/40 sm:p-3.5">
        <p class="text-[10px] text-neutral-500 dark:text-neutral-400 sm:text-[11px]">Total</p>
        <p class="mt-1 text-sm font-bold text-secondary-800 dark:text-neutral-100 tabular-nums sm:text-lg">
            Rp {{ number_format($engTotal, 0, ',', '.') }}
        </p>
    </div>
    <div
        class="rounded-2xl border border-blue-200/70 bg-blue-50/70 p-2.5 text-center dark:border-blue-800/50 dark:bg-blue-900/20 sm:p-3.5">
        <p class="text-[10px] text-blue-500 dark:text-blue-400 sm:text-[11px]">Pria</p>
        <p class="mt-1 text-sm font-bold text-blue-600 dark:text-blue-400 tabular-nums sm:text-lg">
            Rp {{ number_format($engTotalPria, 0, ',', '.') }}
        </p>
    </div>
    <div
        class="rounded-2xl border border-pink-200/70 bg-pink-50/70 p-2.5 text-center dark:border-pink-800/50 dark:bg-pink-900/20 sm:p-3.5">
        <p class="text-[10px] text-pink-500 dark:text-pink-400 sm:text-[11px]">Wanita</p>
        <p class="mt-1 text-sm font-bold text-pink-600 dark:text-pink-400 tabular-nums sm:text-lg">
            Rp {{ number_format($engTotalWanita, 0, ',', '.') }}
        </p>
    </div>
</div>

@if($engItems->isEmpty())
    <div
        class="rounded-2xl border border-dashed border-pink-200/70 bg-pink-50/50 px-5 py-10 text-center text-sm text-pink-700/80 dark:border-pink-800/40 dark:bg-pink-950/20 dark:text-pink-300">
        <div
            class="mx-auto flex h-12 w-12 items-center justify-center rounded-2xl bg-white/80 shadow-sm dark:bg-secondary-800/70">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
            </svg>
        </div>
        <p class="mt-3 font-semibold">Belum ada data pertunangan.</p>
        <p class="mt-1 text-xs text-pink-700/70 dark:text-pink-300/70">Tambahkan item untuk mulai
            merencanakan acara pertunangan.</p>
    </div>
@else
    <div class="space-y-2.5">
        @foreach($engItems as $item)
            @php
                $itemTotal = $item->cost_pria + $item->cost_wanita;
            @endphp
            <div
                class="group relative rounded-2xl border border-neutral-200/80 bg-white shadow-sm transition-all duration-200 hover:border-pink-300 hover:shadow-md dark:border-secondary-600/50 dark:bg-secondary-800/80 dark:hover:border-pink-700/50">
                <div class="p-4">
                    <div class="flex items-start justify-between gap-3">
                        <div class="flex items-center gap-2 min-w-0">
                            <span class="w-1.5 h-1.5 rounded-full bg-pink-500 shrink-0"></span>
                            <p class="text-sm font-semibold text-secondary-800 dark:text-neutral-100 truncate">
                                {{ $item->title }}
                            </p>
                            <span
                                class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold {{ $statusStyles[$item->status] ?? $statusStyles['PENDING'] }} shrink-0">
                                {{ $statusLabels[$item->status] ?? $item->status }}
                            </span>
                        </div>
                        <div
                            class="flex items-center gap-0.5 shrink-0 sm:opacity-0 sm:group-hover:opacity-100 sm:focus-within:opacity-100 transition-opacity duration-150">
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
                                    class="p-1.5 rounded-lg text-neutral-400 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                    <div
                        class="mt-3 grid grid-cols-3 divide-x divide-neutral-200/80 overflow-hidden rounded-xl border border-neutral-100 bg-neutral-50/80 dark:divide-secondary-600/60 dark:border-secondary-600/50 dark:bg-secondary-700/40">
                        <div class="min-w-0 px-3 py-2.5">
                            <p class="text-[10px] font-medium text-blue-500 dark:text-blue-400">
                                Pria</p>
                            <p
                                class="mt-0.5 truncate text-xs font-bold text-blue-600 tabular-nums dark:text-blue-400 sm:text-sm">
                                Rp {{ number_format($item->cost_pria, 0, ',', '.') }}
                            </p>
                        </div>
                        <div class="min-w-0 px-3 py-2.5">
                            <p class="text-[10px] font-medium text-pink-500 dark:text-pink-400">
                                Wanita</p>
                            <p
                                class="mt-0.5 truncate text-xs font-bold text-pink-600 tabular-nums dark:text-pink-400 sm:text-sm">
                                Rp {{ number_format($item->cost_wanita, 0, ',', '.') }}
                            </p>
                        </div>
                        <div class="min-w-0 px-3 py-2.5">
                            <p class="text-[10px] font-medium text-neutral-400 dark:text-neutral-500">
                                Total</p>
                            <p
                                class="mt-0.5 truncate text-xs font-bold text-secondary-800 tabular-nums dark:text-neutral-100 sm:text-sm">
                                Rp {{ number_format($itemTotal, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif