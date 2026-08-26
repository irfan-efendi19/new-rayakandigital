{{-- ─── CHECKLIST INTERAKTIF (Interactive Wedding Checklist Planner) ─── --}}
@php
    $checklistCategories = collect(\App\Models\WeddingChecklist::CATEGORIES)
        ->reject(fn($label, $code) => $code === 'ADMINISTRATION')
        ->all();
@endphp

<div
    class="relative mb-6 overflow-hidden rounded-[28px] border border-emerald-200/70 bg-gradient-to-br from-emerald-600 via-emerald-600 to-teal-700 p-5 text-white shadow-[0_20px_50px_-24px_rgba(5,150,105,0.6)] dark:border-emerald-800/50 sm:p-6">
    <div class="pointer-events-none absolute -right-12 -top-14 h-44 w-44 rounded-full bg-white/10 blur-2xl"></div>
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div class="relative flex min-w-0 items-start gap-4">
            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-white/15 ring-1 ring-white/20 backdrop-blur-sm">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" /></svg>
            </div>
            <div>
            <p class="text-[10px] font-bold uppercase tracking-[0.24em] text-emerald-100">
                Checklist Wedding Plan</p>
            <h3 class="mt-1 font-heading text-xl font-bold text-white sm:text-2xl"
                x-text="progressPercent === 100 ? '🎉 Semua Ceklis Selesai!' : (completedItems > 0 ? 'Yuk lanjutkan ceklis!' : 'Yuk mulai ceklis!')">
            </h3>
            <p class="mt-1 text-xs text-emerald-100/85">
                <span x-text="completedItems"></span>/<span x-text="totalItems"></span> selesai
                ·
                {{ count($checklistCategories) }} kategori
            </p>
            </div>
        </div>
        <div class="relative flex-shrink-0">
            <button type="button" x-data @click="$dispatch('open-modal', 'add-checklist')"
                class="inline-flex items-center gap-1.5 rounded-xl bg-white px-3.5 py-2 text-xs font-bold text-emerald-700 shadow-sm transition-all hover:-translate-y-0.5 hover:bg-emerald-50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-offset-2 focus-visible:ring-offset-emerald-600">
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Data
            </button>
        </div>
    </div>
    <div class="relative mt-5">
        <div class="h-2.5 overflow-hidden rounded-full bg-black/15 ring-1 ring-white/10">
            <div class="h-full rounded-full bg-white transition-all duration-500"
                :style="'width:' + progressPercent + '%'"></div>
        </div>
        <p class="mt-1.5 text-right text-xs font-bold text-white tabular-nums"
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
    <div class="flex flex-col gap-4">
        @foreach($checklistCategories as $code => $label)
            @php
                $items = $checklists->where('category_code', $code);
                $normalItems = $items->where('is_document', false);
            @endphp
            <div x-data="{ open: {{ $loop->first ? 'true' : 'false' }} }"
                class="overflow-hidden rounded-2xl border border-neutral-200/80 bg-white shadow-sm transition hover:border-emerald-200 dark:border-secondary-700/60 dark:bg-secondary-800/80 dark:hover:border-emerald-800/60">
                <button type="button" @click="open = !open" :aria-expanded="open.toString()"
                    class="flex w-full items-center gap-3 bg-neutral-50/90 px-4 py-3.5 text-left transition hover:bg-emerald-50/60 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-inset focus-visible:ring-emerald-500 dark:bg-secondary-700/40 dark:hover:bg-emerald-950/20">
                    <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300">
                        <i class="fa-solid fa-list-check text-xs" aria-hidden="true"></i>
                    </span>
                    <span class="min-w-0 flex-1">
                        <span class="block truncate text-sm font-semibold text-secondary-800 dark:text-neutral-100">{{ $label }}</span>
                        <span class="mt-0.5 block text-[11px] text-neutral-500 dark:text-neutral-400">
                            <span x-text="categoryCompleted('{{ $code }}')"></span> dari
                            <span x-text="categoryTotal('{{ $code }}')"></span> tugas selesai
                        </span>
                    </span>
                    <span class="hidden items-center gap-2 sm:flex">
                        <span class="text-[11px] font-bold tabular-nums text-emerald-700 dark:text-emerald-300"
                            x-text="categoryProgress('{{ $code }}') + '%'">
                        </span>
                        <span class="h-1.5 w-20 overflow-hidden rounded-full bg-neutral-200 dark:bg-secondary-600">
                            <span class="block h-full rounded-full bg-emerald-500 transition-all duration-500"
                                :style="'width:' + categoryProgress('{{ $code }}') + '%'"></span>
                        </span>
                    </span>
                    <i class="fa-solid fa-chevron-down text-[10px] text-neutral-400 transition-transform duration-200"
                        :class="open ? 'rotate-180' : ''" aria-hidden="true"></i>
                </button>

                <div x-show="open" x-collapse class="border-t border-neutral-100 dark:border-secondary-700/60">

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
                                            aria-label="Tandai {{ $item->title }} selesai"
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
            </div>
        @endforeach
    </div>
@endif
