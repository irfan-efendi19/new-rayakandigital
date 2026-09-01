@php
    $sesItems = $itemsByCategory['SESERAHAN'];
    $sesPriaItems = $sesItems->where('subcategory', 'PRIA')->values();
    $sesWanitaItems = $sesItems->where('subcategory', 'WANITA')->values();
    $sesTotalPria = (float) $sesPriaItems->sum('estimated_cost');
    $sesTotalWanita = (float) $sesWanitaItems->sum('estimated_cost');
    $sesTotal = $sesTotalPria + $sesTotalWanita;
@endphp
<div x-data="{ sesFilter: 'ALL' }">
    <div class="relative mb-5 overflow-hidden rounded-[28px] border border-amber-200/70 bg-gradient-to-br from-amber-500 via-orange-500 to-rose-600 p-5 text-white shadow-[0_20px_50px_-24px_rgba(245,158,11,0.62)] dark:border-amber-800/50 sm:p-6">
        <div class="pointer-events-none absolute -right-12 -top-14 h-44 w-44 rounded-full bg-white/10 blur-2xl"></div>
        <div class="relative flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">
        <div class="flex items-center gap-4">
            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-white/15 ring-1 ring-white/20 backdrop-blur-sm">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M20 12v8H4v-8m8 8V8m-8 4h16M7.5 8A2.5 2.5 0 1112 6c0-1.38-1.12-2.5-2.5-2.5S7 4.62 7 6c0 .82.2 1.48.5 2zm9 0A2.5 2.5 0 1012 6c0-1.38 1.12-2.5 2.5-2.5S17 4.62 17 6c0 .82-.2 1.48-.5 2z" /></svg>
            </div>
            <div>
            <p class="text-[10px] font-bold uppercase tracking-[0.24em] text-amber-100">Hadiah Penuh Makna</p>
            <h3 class="mt-1 font-heading text-xl font-bold sm:text-2xl">Seserahan</h3>
            <p class="mt-1 text-xs text-amber-50/90">
                {{ $sesItems->count() }} item · dibagi per pihak
            </p>
            </div>
        </div>
        <button type="button" x-data @click="setActiveTab('SESERAHAN'); $dispatch('open-modal', 'add-item-SESERAHAN')"
            class="inline-flex items-center gap-1.5 self-start rounded-xl bg-white px-3.5 py-2 text-xs font-bold text-orange-700 shadow-sm transition-all hover:-translate-y-0.5 hover:bg-amber-50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-offset-2 focus-visible:ring-offset-orange-500 sm:self-auto">
            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Tambah
        </button>
        </div>
    </div>

    {{-- Toggle Filter --}}
    <div class="mb-5 grid grid-cols-3 gap-1 rounded-2xl bg-neutral-100 p-1 dark:bg-secondary-700/50">
        <button type="button" @click="sesFilter = 'ALL'"
            :aria-pressed="(sesFilter === 'ALL').toString()"
            :class="sesFilter === 'ALL' ? 'bg-white dark:bg-secondary-800 text-secondary-800 dark:text-neutral-100 shadow-sm' : 'text-neutral-500 dark:text-neutral-400 hover:text-secondary-700 dark:hover:text-neutral-300'"
            class="flex items-center justify-center gap-1 px-1.5 sm:gap-1.5 sm:px-3 py-2 min-w-0 rounded-lg text-xs font-semibold transition-all duration-200">
            <svg class="w-3.5 h-3.5 hidden sm:block flex-shrink-0" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 6h16M4 10h16M4 14h16M4 18h16" />
            </svg>
            <span class="truncate">Semua</span>
            <span
                class="flex-shrink-0 text-[10px] px-1.5 py-0.5 rounded-full bg-neutral-200 dark:bg-secondary-600 text-neutral-600 dark:text-neutral-300">{{ $sesItems->count() }}</span>
        </button>
        <button type="button" @click="sesFilter = 'PRIA'"
            :aria-pressed="(sesFilter === 'PRIA').toString()"
            :class="sesFilter === 'PRIA' ? 'bg-blue-500 text-white shadow-sm' : 'text-neutral-500 dark:text-neutral-400 hover:text-blue-600 dark:hover:text-blue-400'"
            class="flex items-center justify-center gap-1 px-1.5 sm:gap-1.5 sm:px-3 py-2 min-w-0 rounded-lg text-xs font-semibold transition-all duration-200">
            <svg class="hidden h-3.5 w-3.5 flex-shrink-0 sm:block" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" aria-hidden="true">
                <circle cx="10" cy="14" r="5" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 10.5 19 5m-4 0h4v4" />
            </svg>
            <span class="truncate">Pria</span>
            <span class="flex-shrink-0 text-[10px] px-1.5 py-0.5 rounded-full min-w-[18px] text-center"
                :class="sesFilter === 'PRIA' ? 'bg-blue-400 text-white' : 'bg-blue-100 dark:bg-blue-900/40 text-blue-600 dark:text-blue-400'">{{ $sesPriaItems->count() }}</span>
        </button>
        <button type="button" @click="sesFilter = 'WANITA'"
            :aria-pressed="(sesFilter === 'WANITA').toString()"
            :class="sesFilter === 'WANITA' ? 'bg-pink-500 text-white shadow-sm' : 'text-neutral-500 dark:text-neutral-400 hover:text-pink-600 dark:hover:text-pink-400'"
            class="flex items-center justify-center gap-1 px-1.5 sm:gap-1.5 sm:px-3 py-2 min-w-0 rounded-lg text-xs font-semibold transition-all duration-200">
            <svg class="hidden h-3.5 w-3.5 flex-shrink-0 sm:block" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" aria-hidden="true">
                <circle cx="12" cy="9" r="5" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 14v7m-3-3h6" />
            </svg>
            <span class="truncate">Wanita</span>
            <span class="flex-shrink-0 text-[10px] px-1.5 py-0.5 rounded-full min-w-[18px] text-center"
                :class="sesFilter === 'WANITA' ? 'bg-pink-400 text-white' : 'bg-pink-100 dark:bg-pink-900/40 text-pink-600 dark:text-pink-400'">{{ $sesWanitaItems->count() }}</span>
        </button>
    </div>

    {{-- Summary Cards --}}
    <div class="mb-5 grid grid-cols-2 gap-3 sm:grid-cols-3">
        <div
            class="col-span-2 rounded-2xl border border-neutral-200/70 bg-neutral-50/70 p-3.5 dark:border-secondary-700/50 dark:bg-secondary-700/40 sm:col-span-1 sm:p-4">
            <span class="text-[10px] text-neutral-400 dark:text-neutral-500 sm:text-[11px]">Total seserahan</span>
            <p class="mt-1 text-lg font-extrabold text-secondary-800 dark:text-neutral-100 tabular-nums sm:text-xl">
                Rp {{ number_format($sesTotal, 0, ',', '.') }}</p>
            <p class="mt-1 text-[10px] text-neutral-500 dark:text-neutral-400">Pria Rp {{ number_format($sesTotalPria, 0, ',', '.') }} · Wanita Rp {{ number_format($sesTotalWanita, 0, ',', '.') }}</p>
        </div>
        <div
            class="rounded-2xl border border-blue-200/70 bg-blue-50/70 p-3.5 dark:border-blue-800/50 dark:bg-blue-900/20 sm:p-4">
            <span class="text-[10px] text-blue-500 dark:text-blue-400 sm:text-[11px]">Untuk pihak pria</span>
            <p class="mt-0.5 text-sm font-bold text-blue-600 dark:text-blue-400 tabular-nums sm:text-lg">
                Rp
                {{ number_format($sesTotalPria, 0, ',', '.') }}
            </p>
        </div>
        <div
            class="rounded-2xl border border-pink-200/70 bg-pink-50/70 p-3.5 dark:border-pink-800/50 dark:bg-pink-900/20 sm:p-4">
            <span class="text-[10px] text-pink-500 dark:text-pink-400 sm:text-[11px]">Untuk pihak wanita</span>
            <p class="mt-0.5 text-sm font-bold text-pink-600 dark:text-pink-400 tabular-nums sm:text-lg">
                Rp
                {{ number_format($sesTotalWanita, 0, ',', '.') }}
            </p>
        </div>
    </div>

    @if($sesItems->isEmpty())
        <div class="rounded-3xl border border-dashed border-amber-200 bg-amber-50/40 px-5 py-10 text-center dark:border-amber-800/50 dark:bg-amber-950/15">
            <span class="mx-auto flex h-12 w-12 items-center justify-center rounded-2xl bg-white text-amber-500 shadow-sm dark:bg-secondary-800 dark:text-amber-300">
                <i class="fa-solid fa-gift" aria-hidden="true"></i>
            </span>
            <p class="mt-3 text-sm font-semibold text-secondary-800 dark:text-neutral-100">Belum ada item seserahan.</p>
            <p class="mt-1 text-xs text-neutral-500 dark:text-neutral-400">Tambahkan barang lalu pilih pihak agar daftar otomatis terkelompok.</p>
            <button type="button" x-data @click="$dispatch('open-modal', 'add-item-SESERAHAN')"
                class="mt-4 inline-flex items-center gap-2 rounded-xl bg-amber-500 px-3.5 py-2 text-xs font-bold text-white transition hover:bg-amber-400 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-amber-400 focus-visible:ring-offset-2 dark:focus-visible:ring-offset-secondary-800">
                <i class="fa-solid fa-plus text-[10px]" aria-hidden="true"></i> Tambah item pertama
            </button>
        </div>
    @else
        @php
            $sesPartyStyles = [
                'PRIA' => [
                    'border' => 'border-blue-200 dark:border-blue-800/60',
                    'headerBg' => 'bg-blue-50 dark:bg-blue-900/30',
                    'badge' => 'bg-blue-500',
                    'cost' => 'text-blue-600 dark:text-blue-400',
                    'subtotal' => 'text-blue-700 dark:text-blue-300',
                    'dot' => 'bg-blue-500',
                    'iconColor' => 'text-blue-500 dark:text-blue-400',
                ],
                'WANITA' => [
                    'border' => 'border-pink-200 dark:border-pink-800/60',
                    'headerBg' => 'bg-pink-50 dark:bg-pink-900/30',
                    'badge' => 'bg-pink-500',
                    'cost' => 'text-pink-600 dark:text-pink-400',
                    'subtotal' => 'text-pink-700 dark:text-pink-300',
                    'dot' => 'bg-pink-500',
                    'iconColor' => 'text-pink-500 dark:text-pink-400',
                ],
            ];
        @endphp

        {{-- Filtered Items --}}
        <div class="flex flex-col gap-4">
            @foreach(\App\Models\WeddingPlannerItem::SESERAHAN_PARTIES as $partyCode => $partyLabel)
                <div x-show="sesFilter === 'ALL' || sesFilter === '{{ $partyCode }}'"
                    x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100">
                    @php
                        $partyItems = $partyCode === 'PRIA' ? $sesPriaItems : $sesWanitaItems;
                        $partyTotal = $partyCode === 'PRIA' ? $sesTotalPria : $sesTotalWanita;
                        $partyStyle = $sesPartyStyles[$partyCode];
                    @endphp
                    <div
                        class="overflow-hidden rounded-2xl border {{ $partyStyle['border'] }} bg-white shadow-sm dark:bg-secondary-800">
                        <div class="px-4 py-3 {{ $partyStyle['headerBg'] }} flex items-center justify-between gap-3">
                            <div class="flex items-center gap-2.5">
                                <span class="w-2 h-2 rounded-full {{ $partyStyle['dot'] }}"></span>
                                <h4 class="text-sm font-semibold text-secondary-800 dark:text-neutral-100">
                                    Subtotal {{ $partyLabel }}
                                </h4>
                            </div>
                            <div class="flex items-center gap-2">
                                <span
                                    class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-white/80 dark:bg-secondary-800/80 text-secondary-700 dark:text-neutral-300">
                                    {{ $partyItems->count() }} item
                                </span>
                                <span class="text-xs font-bold tabular-nums {{ $partyStyle['cost'] }}">Rp
                                    {{ number_format($partyTotal, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        @if($partyItems->isEmpty())
                            <div class="px-4 py-8 text-center text-sm text-neutral-400 dark:text-neutral-500">
                                Belum ada item untuk {{ strtolower($partyLabel) }}.
                            </div>
                        @else
                            <div class="flex flex-col gap-2 p-3">
                                @foreach($partyItems as $item)
                                    @php
                                        $hoverBorder = $partyCode === 'PRIA' ? 'hover:border-blue-300' : 'hover:border-pink-300';
                                        $hoverBg = $partyCode === 'PRIA' ? 'hover:bg-blue-50/30' : 'hover:bg-pink-50/30';
                                        $darkHoverBorder = $partyCode === 'PRIA' ? 'dark:hover:border-blue-700/50' : 'dark:hover:border-pink-700/50';
                                        $darkHoverBg = $partyCode === 'PRIA' ? 'dark:hover:bg-blue-900/10' : 'dark:hover:bg-pink-900/10';
                                        $bgLeft = $partyCode === 'PRIA' ? 'bg-blue-50/50 dark:bg-blue-900/20' : 'bg-pink-50/50 dark:bg-pink-900/20';
                                    @endphp
                                    <div
                                        class="group relative flex items-stretch rounded-2xl border border-neutral-200/80 bg-neutral-50/70 shadow-sm transition-all duration-200 {{ $hoverBorder }} {{ $hoverBg }} dark:border-secondary-600/50 dark:bg-secondary-700/30 {{ $darkHoverBorder }} {{ $darkHoverBg }}">
                                        <div
                                            class="flex w-12 shrink-0 items-center justify-center rounded-l-2xl border-r border-neutral-200 dark:border-secondary-600/50 {{ $bgLeft }}">
                                            <span
                                                class="w-6 h-6 flex items-center justify-center rounded-lg text-[10px] font-bold text-white {{ $partyStyle['badge'] }}">{{ $loop->iteration }}</span>
                                        </div>
                                        <div class="flex-1 px-3 py-2.5 min-w-0">
                                            <div class="flex items-center justify-between gap-2">
                                                <div class="min-w-0">
                                                    <div class="flex items-center gap-2 flex-wrap">
                                                        <p
                                                            class="text-sm font-medium text-secondary-800 dark:text-neutral-100 truncate">
                                                            {{ $item->title }}
                                                        </p>
                                                        <span
                                                            class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold {{ $statusStyles[$item->status] ?? $statusStyles['PENDING'] }}">
                                                            {{ $statusLabels[$item->status] ?? $item->status }}
                                                        </span>
                                                    </div>
                                                    <p class="text-xs font-semibold mt-0.5 tabular-nums {{ $partyStyle['cost'] }}">
                                                        Rp
                                                        {{ number_format($item->estimated_cost, 0, ',', '.') }}
                                                    </p>
                                                </div>
                                                <div class="flex shrink-0 items-center gap-1">
                                                    <button type="button" x-data
                                                        @click="$dispatch('open-modal', 'edit-item-{{ $item->id }}')"
                                                        aria-label="Edit {{ $item->title }}"
                                                        class="rounded-lg p-1.5 text-neutral-400 transition-colors hover:bg-primary-50 hover:text-primary focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-primary-400 dark:hover:bg-primary-900/20 dark:hover:text-primary-400">
                                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                        </svg>
                                                    </button>
                                                    <form action="{{ route('dashboard.planner.items.destroy', $item) }}" method="POST"
                                                        onsubmit="return confirmSwal(event, 'Hapus item seserahan ini?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            aria-label="Hapus {{ $item->title }}"
                                                            class="rounded-lg p-1.5 text-neutral-400 transition-colors hover:bg-red-50 hover:text-red-600 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-red-400 dark:hover:bg-red-900/20 dark:hover:text-red-400">
                                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"
                                                                stroke="currentColor">
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
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Total Summary --}}
        <div
            class="mt-5 p-4 rounded-xl bg-amber-50 dark:bg-amber-900/20 border border-amber-200/60 dark:border-amber-700/40">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <p class="text-sm font-bold text-secondary-800 dark:text-neutral-100">Total
                        Pengeluaran</p>
                    <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-0.5">Pria Rp
                        {{ number_format($sesTotalPria, 0, ',', '.') }} · Wanita Rp
                        {{ number_format($sesTotalWanita, 0, ',', '.') }}
                    </p>
                </div>
                <p class="text-xl font-bold text-amber-700 dark:text-amber-300 tabular-nums">Rp
                    {{ number_format($sesTotal, 0, ',', '.') }}
                </p>
            </div>
        </div>
    @endif
</div>
