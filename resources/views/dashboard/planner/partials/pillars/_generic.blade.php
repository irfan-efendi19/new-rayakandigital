<div class="mb-4 flex items-center justify-between gap-3">
    <div>
        <h3 class="font-semibold text-secondary-800 dark:text-neutral-100">
            {{ $pillar['label'] }}
        </h3>
        <p class="mt-0.5 text-xs text-neutral-500 dark:text-neutral-400">
            {{ count(\App\Models\WeddingPlannerItem::STATUSES) === 4 ? 'Kelola item persiapan ' . strtolower($pillar['label']) . '.' : '' }}
        </p>
    </div>
    <button type="button" x-data
        @click="setActiveTab('{{ $pillar['key'] }}'); $dispatch('open-modal', 'add-item-{{ $pillar['key'] }}')"
        class="inline-flex items-center gap-1.5 rounded-xl bg-primary px-3 py-1.5 text-xs font-semibold text-white transition-all hover:bg-primary-600">
        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        Tambah Item
    </button>
</div>

@if($itemsByCategory[$pillar['key']]->isEmpty())
    <div
        class="rounded-2xl border border-dashed border-neutral-200 px-5 py-10 text-center text-sm text-neutral-400 dark:border-secondary-600 dark:text-neutral-500">
        Belum ada item pada pilar {{ $pillar['label'] }}.
    </div>
@else
    <div class="space-y-2.5">
        @foreach($itemsByCategory[$pillar['key']] as $item)
            <div
                class="flex items-start gap-3 rounded-2xl border border-neutral-200/80 bg-neutral-50/70 p-3.5 shadow-sm dark:border-secondary-700/50 dark:bg-secondary-700/30">
                <div class="min-w-0 flex-1">
                    <div class="flex items-center gap-2 flex-wrap">
                        <p class="text-sm font-semibold text-secondary-800 dark:text-neutral-100">
                            {{ $item->title }}
                        </p>
                        <span
                            class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold {{ $statusStyles[$item->status] ?? $statusStyles['PENDING'] }}">
                            {{ $statusLabels[$item->status] ?? $item->status }}
                        </span>
                    </div>
                    @if($item->description)
                        <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-1 line-clamp-2">
                            {{ $item->description }}
                        </p>
                    @endif
                    @if($item->event_date)
                        <p class="text-xs text-neutral-400 dark:text-neutral-500 mt-1 flex items-center gap-1">
                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            {{ $item->event_date->translatedFormat('d M Y') }}
                        </p>
                    @endif

                    @if(in_array($pillar['key'], ['BUDGET', 'VENDOR']))
                        <div class="mt-2 grid grid-cols-3 gap-2 text-[11px]">
                            <div
                                class="px-2 py-1.5 rounded-lg bg-white dark:bg-secondary-700/50 border border-neutral-200/60 dark:border-secondary-600/40">
                                <span class="text-neutral-400 dark:text-neutral-500">Budget</span>
                                <p class="font-semibold text-secondary-700 dark:text-neutral-200 tabular-nums">
                                    Rp {{ number_format($item->estimated_cost, 0, ',', '.') }}</p>
                            </div>
                            <div
                                class="px-2 py-1.5 rounded-lg bg-white dark:bg-secondary-700/50 border border-neutral-200/60 dark:border-secondary-600/40">
                                <span class="text-neutral-400 dark:text-neutral-500">Bayar</span>
                                <p class="font-semibold text-emerald-600 dark:text-emerald-400 tabular-nums">
                                    Rp {{ number_format($item->paid_amount, 0, ',', '.') }}</p>
                            </div>
                            <div
                                class="px-2 py-1.5 rounded-lg bg-white dark:bg-secondary-700/50 border border-neutral-200/60 dark:border-secondary-600/40">
                                <span class="text-neutral-400 dark:text-neutral-500">Sisa</span>
                                <p class="font-semibold text-amber-600 dark:text-amber-400 tabular-nums">Rp
                                    {{ number_format(max(0, $item->remaining_balance), 0, ',', '.') }}
                                </p>
                            </div>
                        </div>
                    @endif

                    @if($item->vendor_contact)
                        <p class="text-xs text-neutral-400 dark:text-neutral-500 mt-1.5">
                            {{ $item->vendor_contact }}
                        </p>
                    @endif
                </div>
                <div class="flex-shrink-0 flex items-center gap-1">
                    <button type="button" x-data @click="$dispatch('open-modal', 'edit-item-{{ $item->id }}')"
                        class="inline-flex items-center px-2.5 py-1.5 rounded-lg text-[11px] font-semibold text-primary dark:text-primary-400 hover:bg-primary-50 dark:hover:bg-primary-900/20 transition-colors">
                        Edit
                    </button>
                    <form action="{{ route('dashboard.planner.items.destroy', $item) }}" method="POST"
                        onsubmit="return confirm('Hapus item ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="inline-flex items-center px-2.5 py-1.5 rounded-lg text-[11px] font-semibold text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
@endif