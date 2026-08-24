{{-- ─── CHECKLIST INTERAKTIF (Interactive Wedding Checklist Planner) ─── --}}
@php
    $checklistCategories = collect(\App\Models\WeddingChecklist::CATEGORIES)
        ->reject(fn($label, $code) => $code === 'ADMINISTRATION')
        ->all();
@endphp

<div
    class="rounded-2xl border border-neutral-200/80 dark:border-secondary-700/60 bg-neutral-50/60 dark:bg-secondary-700/30 p-5 mb-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div class="min-w-0">
            <p class="text-xs font-semibold uppercase tracking-[0.24em] text-primary dark:text-primary-400">
                Checklist Wedding Plan</p>
            <p class="mt-1 text-xs text-neutral-500 dark:text-neutral-400">Item persiapan per
                kategori.</p>
            <h3 class="mt-1 font-heading text-lg font-bold text-secondary-800 dark:text-neutral-100"
                x-text="progressPercent === 100 ? '🎉 Semua Ceklis Selesai!' : (completedItems > 0 ? 'Yuk lanjutkan ceklis!' : 'Yuk mulai ceklis!')">
            </h3>
            <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-1">
                <span x-text="completedItems"></span>/<span x-text="totalItems"></span> selesai
                ·
                {{ count($checklistCategories) }} kategori
            </p>
        </div>
        <div class="flex-shrink-0">
            <button type="button" x-data @click="$dispatch('open-modal', 'add-checklist')"
                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-primary hover:bg-primary-600 text-white text-xs font-semibold transition-all">
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Data
            </button>
        </div>
    </div>
    <div class="mt-4">
        <div class="h-2.5 bg-neutral-200/80 dark:bg-secondary-700/60 rounded-full overflow-hidden">
            <div class="h-full bg-primary rounded-full transition-all duration-500"
                :style="'width:' + progressPercent + '%'"></div>
        </div>
        <p class="text-right text-xs font-bold text-primary dark:text-primary-400 mt-1 tabular-nums"
            x-text="progressPercent + '%'"></p>
    </div>
</div>

{{-- Empty State (PRD section 22) --}}
@if($checklistTotalItems === 0)
    <div
        class="rounded-3xl border border-dashed border-neutral-200 bg-neutral-50/70 px-5 py-10 text-center shadow-sm dark:border-secondary-600 dark:bg-secondary-800/50">
        <svg class="mx-auto h-10 w-10 text-neutral-300 dark:text-neutral-600" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
        </svg>
        <p class="mt-3 text-sm font-semibold text-secondary-800 dark:text-neutral-100">Belum ada
            checklist.</p>
        <p class="mt-1 text-xs text-neutral-500 dark:text-neutral-400">Checklist persiapan
            pernikahan akan tersedia setelah invitation dibuat.</p>
    </div>
@else
    {{-- Category Groups --}}
    <div class="space-y-5">
        @foreach($checklistCategories as $code => $label)
            @php
                $items = $checklists->where('category_code', $code);
                $normalItems = $items->where('is_document', false);
            @endphp
            <div
                class="overflow-hidden rounded-2xl border border-neutral-200/80 bg-white shadow-sm dark:border-secondary-700/60 dark:bg-secondary-800/80">
                <div
                    class="flex items-center justify-between gap-3 border-b border-neutral-200/80 bg-neutral-50/90 px-4 py-3 dark:border-secondary-700/60 dark:bg-secondary-700/40">
                    <h4 class="text-sm font-semibold text-secondary-800 dark:text-neutral-100">
                        {{ $label }}
                    </h4>
                    <span class="text-[11px] font-semibold text-neutral-500 dark:text-neutral-400 tabular-nums">
                        <span x-text="categoryCompleted('{{ $code }}')"></span> / <span
                            x-text="categoryTotal('{{ $code }}')"></span> selesai
                    </span>
                </div>
                <div class="h-1.5 bg-neutral-100 dark:bg-secondary-700/50">
                    <div class="h-full bg-emerald-500 dark:bg-emerald-400 transition-all duration-500"
                        :style="'width:' + categoryProgress('{{ $code }}') + '%'"></div>
                </div>

                @if($items->isEmpty())
                    <div class="px-4 py-8 text-center text-sm text-neutral-400 dark:text-neutral-500">
                        Belum ada checklist pada kategori ini.
                    </div>
                @else
                    @if($normalItems->isNotEmpty())
                        <ul class="divide-y divide-neutral-100 dark:divide-secondary-700/50">
                            @foreach($normalItems as $item)
                                <li
                                    class="flex items-center gap-3 px-4 py-3 transition-colors hover:bg-neutral-50/80 dark:hover:bg-secondary-700/30">
                                    <div
                                        class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-primary/10 text-primary dark:bg-primary-900/30 dark:text-primary-400">
                                        <input type="checkbox" :checked="items[{{ $item->id }}].completed"
                                            data-toggle-url="{{ route('dashboard.planner.checklists.toggle', $item) }}"
                                            @change="toggleItem({{ $item->id }}, $event)"
                                            class="h-4 w-4 cursor-pointer rounded border-neutral-300 text-primary focus:ring-primary-500 dark:border-neutral-600">
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <p class="text-sm font-medium text-secondary-800 dark:text-neutral-100"
                                            :class="items[{{ $item->id }}].completed ? 'line-through text-neutral-400 dark:text-neutral-500' : ''">
                                            {{ $item->title }}
                                        </p>
                                        @if($item->description)
                                            <p class="mt-0.5 line-clamp-2 text-xs text-neutral-400 dark:text-neutral-500">
                                                {{ $item->description }}
                                            </p>
                                        @endif
                                    </div>
                                    @if(!$item->is_preset)
                                        <div class="flex flex-shrink-0 items-center gap-1">
                                            <button type="button" x-data @click="$dispatch('open-modal', 'edit-checklist-{{ $item->id }}')"
                                                class="inline-flex items-center rounded-lg px-2.5 py-1.5 text-[11px] font-semibold text-primary transition-colors hover:bg-primary-50 dark:text-primary-400 dark:hover:bg-primary-900/20">
                                                Edit
                                            </button>
                                            <form action="{{ route('dashboard.planner.checklists.destroy', $item) }}" method="POST"
                                                class="inline" onsubmit="return confirm('Hapus checklist custom ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="inline-flex items-center rounded-lg px-2.5 py-1.5 text-[11px] font-semibold text-red-600 transition-colors hover:bg-red-50 dark:text-red-400 dark:hover:bg-red-900/20">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    @endif
                @endif
            </div>
        @endforeach
    </div>
@endif