@php
    $engItems = $itemsByCategory['ENGAGEMENT'];
    $engTotalPria = (float) $engItems->sum('cost_pria');
    $engTotalWanita = (float) $engItems->sum('cost_wanita');
    $engTotal = $engTotalPria + $engTotalWanita;
    $engGroupCount = $engItems->pluck('subcategory')->filter()->unique()->count();
@endphp
<div x-data="{ engagementFilter: 'ALL' }">
<div class="relative mb-5 overflow-hidden rounded-[28px] border border-pink-200/70 bg-gradient-to-br from-rose-600 via-pink-600 to-fuchsia-700 p-5 text-white shadow-[0_20px_50px_-24px_rgba(219,39,119,0.58)] dark:border-pink-800/50 sm:p-6">
    <div class="pointer-events-none absolute -right-12 -top-14 h-44 w-44 rounded-full bg-white/10 blur-2xl"></div>
    <div class="relative flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">
    <div class="flex items-center gap-4">
        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-white/15 ring-1 ring-white/20 backdrop-blur-sm">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" /></svg>
        </div>
        <div>
        <p class="text-[10px] font-bold uppercase tracking-[0.24em] text-pink-100">Momen Pertama</p>
        <h3 class="mt-1 font-heading text-xl font-bold sm:text-2xl">Rencana Pertunangan</h3>
        <p class="mt-1 text-xs text-pink-100/85">
            {{ $engItems->count() }} item di {{ $engGroupCount }} kategori
        </p>
        </div>
    </div>
    <button type="button" x-data @click="setActiveTab('ENGAGEMENT'); $dispatch('open-modal', 'add-item-ENGAGEMENT')"
        class="inline-flex items-center gap-1.5 self-start rounded-xl bg-white px-3.5 py-2 text-xs font-bold text-pink-700 shadow-sm transition-all hover:-translate-y-0.5 hover:bg-pink-50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-offset-2 focus-visible:ring-offset-pink-600 sm:self-auto">
        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        Tambah
    </button>
    </div>
</div>

{{-- Summary --}}
<div class="mb-5 grid grid-cols-2 gap-3 sm:grid-cols-3">
    <div
        class="col-span-2 rounded-2xl border border-neutral-200/70 bg-neutral-50/70 p-3.5 dark:border-secondary-700/50 dark:bg-secondary-700/40 sm:col-span-1 sm:p-4">
        <p class="text-[10px] text-neutral-500 dark:text-neutral-400 sm:text-[11px]">Total Pengeluaran</p>
        <p class="mt-1 text-lg font-extrabold text-secondary-800 dark:text-neutral-100 tabular-nums sm:text-xl">
            Rp {{ number_format($engTotal, 0, ',', '.') }}
        </p>
        <p class="mt-1 text-[10px] text-neutral-500 dark:text-neutral-400">Pria Rp {{ number_format($engTotalPria, 0, ',', '.') }} · Wanita Rp {{ number_format($engTotalWanita, 0, ',', '.') }}</p>
    </div>
    <div
        class="rounded-2xl border border-blue-200/70 bg-blue-50/70 p-3.5 dark:border-blue-800/50 dark:bg-blue-900/20 sm:p-4">
        <p class="text-[10px] text-blue-500 dark:text-blue-400 sm:text-[11px]">Pria (CPP)</p>
        <p class="mt-1 text-sm font-bold text-blue-600 dark:text-blue-400 tabular-nums sm:text-lg">
            Rp {{ number_format($engTotalPria, 0, ',', '.') }}
        </p>
    </div>
    <div
        class="rounded-2xl border border-pink-200/70 bg-pink-50/70 p-3.5 dark:border-pink-800/50 dark:bg-pink-900/20 sm:p-4">
        <p class="text-[10px] text-pink-500 dark:text-pink-400 sm:text-[11px]">Wanita (CPW)</p>
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
    <div class="scrollbar-hide mb-5 flex gap-2 overflow-x-auto rounded-2xl bg-neutral-100 p-1.5 dark:bg-secondary-700/50" aria-label="Filter kategori lamaran">
        <button type="button" @click="engagementFilter = 'ALL'"
            :class="engagementFilter === 'ALL' ? 'bg-white text-pink-700 shadow-sm dark:bg-secondary-800 dark:text-pink-300' : 'text-neutral-500 hover:text-secondary-800 dark:text-neutral-400 dark:hover:text-white'"
            class="shrink-0 rounded-xl px-3 py-2 text-xs font-semibold transition focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-pink-400">
            Semua <span class="ml-1 text-[10px] opacity-70">{{ $engItems->count() }}</span>
        </button>
        @foreach(\App\Models\WeddingPlannerItem::ENGAGEMENT_GROUP_LABELS as $groupCode => $groupLabel)
            @php
                $groupItems = $engItems->where('subcategory', $groupCode);
                $groupPria = (float) $groupItems->sum('cost_pria');
                $groupWanita = (float) $groupItems->sum('cost_wanita');
            @endphp
            <button type="button" @click="engagementFilter = '{{ $groupCode }}'"
                :class="engagementFilter === '{{ $groupCode }}' ? 'bg-white text-pink-700 shadow-sm dark:bg-secondary-800 dark:text-pink-300' : 'text-neutral-500 hover:text-secondary-800 dark:text-neutral-400 dark:hover:text-white'"
                class="shrink-0 rounded-xl px-3 py-2 text-left transition focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-pink-400">
                <span class="block text-[10px] font-bold uppercase tracking-wider">Subtotal {{ $groupLabel }}</span>
                <span class="mt-0.5 block text-[9px] font-medium opacity-70">Pria Rp {{ number_format($groupPria, 0, ',', '.') }} · Wanita Rp {{ number_format($groupWanita, 0, ',', '.') }}</span>
            </button>
        @endforeach
    </div>
    <div class="flex flex-col gap-2.5">
        @foreach($engItems as $item)
            @php
                $itemTotal = $item->cost_pria + $item->cost_wanita;
            @endphp
            <div x-show="engagementFilter === 'ALL' || engagementFilter === '{{ $item->subcategory }}'" x-transition.opacity
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
                        <div class="flex shrink-0 items-center gap-0.5">
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
                                    class="rounded-lg p-1.5 text-neutral-400 transition-colors hover:bg-red-50 hover:text-red-600 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-red-400 dark:hover:bg-red-900/20">
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
</div>
