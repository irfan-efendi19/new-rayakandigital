@php
    $sesItems = $itemsByCategory['SESERAHAN'];
    $sesPriaItems = $sesItems->where('subcategory', 'PRIA')->values();
    $sesWanitaItems = $sesItems->where('subcategory', 'WANITA')->values();
    $sesTotalPria = (float) $sesPriaItems->sum('estimated_cost');
    $sesTotalWanita = (float) $sesWanitaItems->sum('estimated_cost');
    $sesTotal = $sesTotalPria + $sesTotalWanita;
@endphp
<div x-data="{ sesFilter: 'ALL' }">
    <div class="flex items-center justify-between gap-3 mb-4">
        <div>
            <h3 class="font-semibold text-secondary-800 dark:text-neutral-100 text-sm sm:text-base">
                Seserahan</h3>
            <p class="text-[11px] sm:text-xs text-neutral-500 dark:text-neutral-400 mt-0.5">
                {{ $sesItems->count() }} item · dibagi per pihak
            </p>
        </div>
        <button type="button" x-data @click="setActiveTab('SESERAHAN'); $dispatch('open-modal', 'add-item-SESERAHAN')"
            class="inline-flex items-center gap-1.5 px-2.5 sm:px-3 py-1.5 rounded-xl bg-primary hover:bg-primary-600 text-white text-[11px] sm:text-xs font-semibold transition-all">
            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Tambah
        </button>
    </div>

    {{-- Toggle Filter --}}
    <div class="mb-5 grid grid-cols-3 gap-1 rounded-2xl bg-neutral-100 p-1 dark:bg-secondary-700/50">
        <button type="button" @click="sesFilter = 'ALL'"
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
            :class="sesFilter === 'PRIA' ? 'bg-blue-500 text-white shadow-sm' : 'text-neutral-500 dark:text-neutral-400 hover:text-blue-600 dark:hover:text-blue-400'"
            class="flex items-center justify-center gap-1 px-1.5 sm:gap-1.5 sm:px-3 py-2 min-w-0 rounded-lg text-xs font-semibold transition-all duration-200">
            <svg class="w-3.5 h-3.5 hidden sm:block flex-shrink-0" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
            <span class="truncate">Pria</span>
            <span class="flex-shrink-0 text-[10px] px-1.5 py-0.5 rounded-full min-w-[18px] text-center"
                :class="sesFilter === 'PRIA' ? 'bg-blue-400 text-white' : 'bg-blue-100 dark:bg-blue-900/40 text-blue-600 dark:text-blue-400'">{{ $sesPriaItems->count() }}</span>
        </button>
        <button type="button" @click="sesFilter = 'WANITA'"
            :class="sesFilter === 'WANITA' ? 'bg-pink-500 text-white shadow-sm' : 'text-neutral-500 dark:text-neutral-400 hover:text-pink-600 dark:hover:text-pink-400'"
            class="flex items-center justify-center gap-1 px-1.5 sm:gap-1.5 sm:px-3 py-2 min-w-0 rounded-lg text-xs font-semibold transition-all duration-200">
            <svg class="w-3.5 h-3.5 hidden sm:block flex-shrink-0" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
            <span class="truncate">Wanita</span>
            <span class="flex-shrink-0 text-[10px] px-1.5 py-0.5 rounded-full min-w-[18px] text-center"
                :class="sesFilter === 'WANITA' ? 'bg-pink-400 text-white' : 'bg-pink-100 dark:bg-pink-900/40 text-pink-600 dark:text-pink-400'">{{ $sesWanitaItems->count() }}</span>
        </button>
    </div>

    {{-- Summary Cards --}}
    <div class="mb-5 grid grid-cols-3 gap-2 sm:gap-3">
        <div
            class="rounded-2xl border border-neutral-200/70 bg-neutral-50/70 p-2.5 dark:border-secondary-700/50 dark:bg-secondary-700/40 sm:p-3.5">
            <span class="text-[10px] text-neutral-400 dark:text-neutral-500 sm:text-[11px]">Total</span>
            <p class="mt-0.5 text-sm font-bold text-secondary-800 dark:text-neutral-100 tabular-nums sm:text-lg">
                Rp {{ number_format($sesTotal, 0, ',', '.') }}</p>
        </div>
        <div
            class="rounded-2xl border border-blue-200/70 bg-blue-50/70 p-2.5 dark:border-blue-800/50 dark:bg-blue-900/20 sm:p-3.5">
            <span class="text-[10px] text-blue-500 dark:text-blue-400 sm:text-[11px]">Pria</span>
            <p class="mt-0.5 text-sm font-bold text-blue-600 dark:text-blue-400 tabular-nums sm:text-lg">
                Rp
                {{ number_format($sesTotalPria, 0, ',', '.') }}
            </p>
        </div>
        <div
            class="rounded-2xl border border-pink-200/70 bg-pink-50/70 p-2.5 dark:border-pink-800/50 dark:bg-pink-900/20 sm:p-3.5">
            <span class="text-[10px] text-pink-500 dark:text-pink-400 sm:text-[11px]">Wanita</span>
            <p class="mt-0.5 text-sm font-bold text-pink-600 dark:text-pink-400 tabular-nums sm:text-lg">
                Rp
                {{ number_format($sesTotalWanita, 0, ',', '.') }}
            </p>
        </div>
    </div>

    @if($sesItems->isEmpty())
        <div
            class="px-5 py-10 text-center text-sm text-neutral-400 dark:text-neutral-500 border border-dashed border-neutral-200 dark:border-secondary-600 rounded-xl">
            Belum ada item seserahan. Tambahkan data untuk mulai merencanakan.
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
        <div class="space-y-4">
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
                                    {{ $partyLabel }}
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
                            <div class="p-3 space-y-2">
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
                                            class="flex items-center justify-center w-12 shrink-0 border-r border-neutral-150 dark:border-secondary-600/50 {{ $bgLeft }} rounded-l-xl">
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
            <div class="flex items-center justify-between">
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