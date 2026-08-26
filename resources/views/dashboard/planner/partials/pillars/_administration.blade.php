{{-- ─── ADMINISTRASI: Dokumen Persyaratan KUA (Pria/Wanita) ─── --}}
@php
    $adminItems = $checklists->where('category_code', 'ADMINISTRATION');
    $adminNormalItems = $adminItems->where('is_document', false);
    $adminDocumentItems = $adminItems->where('is_document', true);
    $adminDocumentCount = $adminDocumentItems->count();
    $adminPriaCompleted = $adminDocumentItems->where('is_completed_pria', true)->count();
    $adminWanitaCompleted = $adminDocumentItems->where('is_completed_wanita', true)->count();
@endphp
<div
    class="relative mb-6 overflow-hidden rounded-[28px] border border-cyan-200/70 bg-gradient-to-br from-cyan-600 via-cyan-600 to-sky-700 p-5 text-white shadow-[0_20px_50px_-24px_rgba(8,145,178,0.6)] dark:border-cyan-800/50 sm:p-6">
    <div class="pointer-events-none absolute -right-12 -top-14 h-44 w-44 rounded-full bg-white/10 blur-2xl"></div>
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div class="relative flex min-w-0 items-center gap-4">
            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-white/15 ring-1 ring-white/20 backdrop-blur-sm">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12h6m-6 4h6m2 4H7a2 2 0 01-2-2V4a2 2 0 012-2h6.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V20a2 2 0 01-2 2z" /></svg>
            </div>
            <div>
            <p class="text-[10px] font-bold uppercase tracking-[0.24em] text-cyan-100">Administrasi Pernikahan</p>
            <h3 class="mt-1 font-heading text-xl font-bold text-white sm:text-2xl">Dokumen Persyaratan KUA</h3>
            <p class="mt-1 text-xs text-cyan-100/85">
                <span x-text="categoryCompleted('ADMINISTRATION')"></span>/<span
                    x-text="categoryTotal('ADMINISTRATION')"></span> checkbox selesai
            </p>
            </div>
        </div>
        <div class="relative flex-shrink-0">
            <button type="button" x-data @click="$dispatch('open-modal', 'add-checklist')"
                class="inline-flex items-center gap-1.5 rounded-xl bg-white px-3.5 py-2 text-xs font-bold text-cyan-700 shadow-sm transition-all hover:-translate-y-0.5 hover:bg-cyan-50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-offset-2 focus-visible:ring-offset-cyan-600">
                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Data
            </button>
        </div>
    </div>
    <div class="relative mt-5">
        <div class="h-2.5 overflow-hidden rounded-full bg-black/15 ring-1 ring-white/10">
            <div class="h-full rounded-full bg-white transition-all duration-500"
                :style="'width:' + categoryProgress('ADMINISTRATION') + '%'"></div>
        </div>
        <p class="mt-1.5 text-right text-xs font-bold tabular-nums text-white"
            x-text="categoryProgress('ADMINISTRATION') + '%'"></p>
    </div>
</div>

@if($adminDocumentItems->isNotEmpty())
    <div class="mb-5 grid grid-cols-2 gap-3">
        <article class="rounded-2xl border border-blue-200/70 bg-blue-50/70 p-3.5 dark:border-blue-800/50 dark:bg-blue-950/20 sm:p-4">
            <div class="flex items-center justify-between gap-3">
                <span class="text-[10px] font-bold uppercase tracking-wider text-blue-600 dark:text-blue-300">Dokumen pihak pria</span>
                <i class="fa-solid fa-mars text-blue-400" aria-hidden="true"></i>
            </div>
            <p class="mt-2 text-lg font-extrabold tabular-nums text-blue-700 dark:text-blue-200 sm:text-xl">
                {{ $adminPriaCompleted }}<span class="text-xs font-semibold text-blue-500/70">/{{ $adminDocumentCount }}</span>
            </p>
            <p class="mt-0.5 text-[10px] text-blue-700/70 dark:text-blue-300/70">berkas sudah siap</p>
        </article>
        <article class="rounded-2xl border border-pink-200/70 bg-pink-50/70 p-3.5 dark:border-pink-800/50 dark:bg-pink-950/20 sm:p-4">
            <div class="flex items-center justify-between gap-3">
                <span class="text-[10px] font-bold uppercase tracking-wider text-pink-600 dark:text-pink-300">Dokumen pihak wanita</span>
                <i class="fa-solid fa-venus text-pink-400" aria-hidden="true"></i>
            </div>
            <p class="mt-2 text-lg font-extrabold tabular-nums text-pink-700 dark:text-pink-200 sm:text-xl">
                {{ $adminWanitaCompleted }}<span class="text-xs font-semibold text-pink-500/70">/{{ $adminDocumentCount }}</span>
            </p>
            <p class="mt-0.5 text-[10px] text-pink-700/70 dark:text-pink-300/70">berkas sudah siap</p>
        </article>
    </div>
@endif

<div class="flex flex-col gap-5">

    @if($adminItems->isEmpty())
        <div
            class="rounded-3xl border border-dashed border-cyan-200/70 bg-cyan-50/50 px-6 py-10 text-center text-sm text-cyan-700/80 dark:border-cyan-800/40 dark:bg-cyan-950/20 dark:text-cyan-300">
            <div
                class="mx-auto flex h-12 w-12 items-center justify-center rounded-2xl bg-white/80 shadow-sm dark:bg-secondary-800/70">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                        d="M9 12h6m-6 4h6m2 4H7a2 2 0 01-2-2V4a2 2 0 012-2h6.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V20a2 2 0 01-2 2z" />
                </svg>
            </div>
            <p class="mt-3 font-semibold">Belum ada checklist pada kategori Administrasi.</p>
            <p class="mt-1 text-xs text-cyan-700/70 dark:text-cyan-300/70">Tambahkan item untuk
                melengkapi dokumen persyaratan.</p>
        </div>
    @else
        @if($adminNormalItems->isNotEmpty())
            <div
                class="overflow-hidden rounded-[24px] border border-neutral-200/80 bg-white shadow-[0_16px_40px_-24px_rgba(15,23,42,0.35)] ring-1 ring-black/5 dark:border-secondary-700/60 dark:bg-secondary-800/80">
                <div
                    class="border-b border-neutral-200/80 bg-gradient-to-r from-neutral-50/90 to-white px-4 py-3 dark:border-secondary-700/60 dark:from-secondary-700/40 dark:to-secondary-800/50">
                    <h4 class="text-sm font-semibold text-secondary-800 dark:text-neutral-100">
                        Administrasi Umum</h4>
                </div>
                <ul class="divide-y divide-neutral-100 dark:divide-secondary-700/50">
                    @foreach($adminNormalItems as $item)
                        <li
                            class="flex items-center gap-3 px-4 py-3.5 transition-all duration-200 hover:bg-cyan-50/60 dark:hover:bg-secondary-700/30">
                            <div
                                class="flex h-9 w-9 shrink-0 items-center justify-center rounded-2xl bg-cyan-50 text-cyan-600 ring-1 ring-cyan-100 dark:bg-cyan-900/30 dark:text-cyan-400 dark:ring-cyan-900/40">
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
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if($adminDocumentItems->isNotEmpty())
            <div
                class="overflow-hidden rounded-[24px] border border-neutral-200/80 bg-white shadow-[0_16px_40px_-24px_rgba(15,23,42,0.35)] ring-1 ring-black/5 dark:border-secondary-700/60 dark:bg-secondary-800/80">
                <div
                    class="border-b border-neutral-200/80 bg-gradient-to-r from-neutral-50/90 to-white px-4 py-3 dark:border-secondary-700/60 dark:from-secondary-700/40 dark:to-secondary-800/50">
                    <h4 class="text-sm font-semibold text-secondary-800 dark:text-neutral-100">Dokumen
                        Persyaratan</h4>
                    <p class="mt-0.5 text-[11px] text-neutral-400 dark:text-neutral-500">
                        {{ $adminDocumentItems->count() }} item · tandai kesiapan masing-masing pihak
                    </p>
                </div>
                <ul class="grid gap-2 p-3 md:grid-cols-2">
                    @foreach($adminDocumentItems as $item)
                        <li class="rounded-2xl border border-neutral-100 bg-neutral-50/60 p-3.5 transition-all duration-200 hover:border-cyan-200 hover:bg-cyan-50/60 dark:border-secondary-700/60 dark:bg-secondary-700/25 dark:hover:border-cyan-800/60 dark:hover:bg-cyan-950/15">
                            <p class="text-sm font-medium text-secondary-800 dark:text-neutral-100"
                                :class="items[{{ $item->id }}].pria && items[{{ $item->id }}].wanita ? 'line-through text-neutral-400 dark:text-neutral-500' : ''">
                                {{ $item->title }}
                            </p>
                            <div class="mt-3 flex flex-wrap items-center gap-2">
                                <label
                                    class="inline-flex items-center gap-1.5 cursor-pointer select-none rounded-full border border-neutral-200 bg-white/80 px-3 py-1.5 text-neutral-600 transition-all dark:border-secondary-600/60 dark:bg-secondary-700/40 dark:text-neutral-300"
                                    :class="items[{{ $item->id }}].pria ? 'border-blue-300 bg-blue-50 text-blue-700 dark:border-blue-600/50 dark:bg-blue-900/20 dark:text-blue-300' : ''">
                                    <input type="checkbox" :checked="items[{{ $item->id }}].pria"
                                        data-toggle-url="{{ route('dashboard.planner.checklists.toggle', $item) }}"
                                        data-party="pria" @change="toggleItem({{ $item->id }}, $event)"
                                        aria-label="Tandai dokumen {{ $item->title }} untuk pihak pria siap"
                                        class="h-3.5 w-3.5 cursor-pointer rounded border-neutral-300 text-primary focus:ring-primary-500 dark:border-neutral-600">
                                    <span class="flex items-center gap-1 text-xs font-semibold">
                                        <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="1.8">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M10 5a3 3 0 100 6 3 3 0 000-6zm-4 12v-1a2 2 0 012-2h4a2 2 0 012 2v1" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 15v4" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 17h4" />
                                        </svg>
                                        Pria
                                    </span>
                                </label>
                                <label
                                    class="inline-flex items-center gap-1.5 cursor-pointer select-none rounded-full border border-neutral-200 bg-white/80 px-3 py-1.5 text-neutral-600 transition-all dark:border-secondary-600/60 dark:bg-secondary-700/40 dark:text-neutral-300"
                                    :class="items[{{ $item->id }}].wanita ? 'border-pink-300 bg-pink-50 text-pink-700 dark:border-pink-600/50 dark:bg-pink-900/20 dark:text-pink-300' : ''">
                                    <input type="checkbox" :checked="items[{{ $item->id }}].wanita"
                                        data-toggle-url="{{ route('dashboard.planner.checklists.toggle', $item) }}"
                                        data-party="wanita" @change="toggleItem({{ $item->id }}, $event)"
                                        aria-label="Tandai dokumen {{ $item->title }} untuk pihak wanita siap"
                                        class="h-3.5 w-3.5 cursor-pointer rounded border-neutral-300 text-primary focus:ring-primary-500 dark:border-neutral-600">
                                    <span class="flex items-center gap-1 text-xs font-semibold">
                                        <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="1.8">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M12 4a3 3 0 100 6 3 3 0 000-6zm-4 12v-1a2 2 0 012-2h4a2 2 0 012 2v1" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 7h6" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v6" />
                                        </svg>
                                        Wanita
                                    </span>
                                </label>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif
    @endif
</div>
