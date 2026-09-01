<div id="crop-modal"
    class="fixed inset-0 z-50 hidden items-end justify-center overflow-hidden overscroll-contain bg-black/70 sm:items-center sm:p-4"
    role="dialog" aria-modal="true" aria-labelledby="crop-modal-title" tabindex="-1">
    <div id="crop-modal-inner"
        class="relative flex h-[100dvh] max-h-[100dvh] w-full flex-col overflow-hidden bg-[#0f0f12] shadow-2xl sm:h-auto sm:max-h-[90vh] sm:max-w-2xl sm:rounded-2xl">
        <div
            class="flex shrink-0 items-center justify-between gap-3 border-b border-white/[0.07] px-4 pb-3 pt-[max(0.75rem,env(safe-area-inset-top))] sm:px-5 sm:py-4">
            <div class="flex min-w-0 items-center gap-3">
                <div
                    class="flex h-8 w-8 shrink-0 items-center justify-center rounded-xl border border-primary-500/25 bg-primary-500/15 sm:h-9 sm:w-9">
                    <svg class="h-4 w-4 text-primary-400 sm:h-5 sm:w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M7.5 3.75H6A2.25 2.25 0 0 0 3.75 6v1.5M16.5 3.75H18A2.25 2.25 0 0 1 20.25 6v1.5M20.25 16.5V18A2.25 2.25 0 0 1 18 20.25h-1.5M7.5 20.25H6A2.25 2.25 0 0 1 3.75 18v-1.5" />
                    </svg>
                </div>
                <div class="min-w-0">
                    <h3 id="crop-modal-title" class="truncate text-sm font-semibold leading-tight text-white sm:text-base">
                        Sesuaikan Foto
                    </h3>
                    <p id="crop-modal-subtitle" class="mt-0.5 truncate text-[11px] text-white/40 sm:text-xs">
                        Geser & perbesar untuk memilih area
                    </p>
                </div>
            </div>
            <button type="button" aria-label="Tutup penyesuaian foto"
                class="crop-close flex h-10 w-10 shrink-0 items-center justify-center rounded-lg border border-white/[0.08] bg-white/[0.06] text-white/50 transition-all hover:bg-white/[0.12] hover:text-white sm:h-8 sm:w-8">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <div class="flex min-h-0 flex-1 flex-col overflow-hidden sm:flex-row">
            <div class="relative min-h-0 flex-1 overflow-hidden bg-black sm:min-h-[380px]">
                <div id="crop-loading"
                    class="absolute inset-0 z-20 hidden flex flex-col items-center justify-center gap-3 bg-black/80">
                    <svg class="h-7 w-7 animate-spin text-primary-400" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 3v3m6.366-.366l-2.12 2.12M21 12h-3m.366 6.366l-2.12-2.12M12 21v-3m-6.366.366l2.12-2.12M3 12h3m-.366-6.366l2.12 2.12" />
                    </svg>
                    <span id="crop-loading-text" class="text-xs font-medium text-white/50">Memuat foto...</span>
                </div>
                <div id="crop-container" class="h-full min-h-0 w-full overflow-hidden"></div>

                <div class="pointer-events-none absolute right-3 top-3 z-10 sm:hidden">
                    <div class="crop-preview-ring h-11 w-11"></div>
                </div>
            </div>

            <div
                class="hidden w-48 shrink-0 flex-col items-center justify-center gap-5 border-l border-white/[0.07] bg-white/[0.02] px-4 py-6 sm:flex">
                <div>
                    <p class="mb-3 text-center text-[10px] font-semibold uppercase tracking-widest text-white/30">
                        Pratinjau
                    </p>
                    <div class="crop-preview-ring mx-auto h-24 w-24"></div>
                    <p id="crop-ratio-hint" class="mt-2 text-center text-[10px] text-white/30">Rasio 1:1</p>
                </div>
                <p class="px-1 text-center text-[10px] leading-relaxed text-white/25">
                    Geser foto untuk mengatur posisi. Gunakan tombol zoom atau scroll mouse untuk memperbesar.
                </p>
            </div>
        </div>

        <div class="shrink-0 border-t border-white/[0.07] bg-white/[0.02]">
            <div class="grid grid-cols-3 gap-2 px-3 py-2.5 sm:flex sm:items-center sm:px-5 sm:py-3">
                <span
                    class="hidden shrink-0 text-[10px] font-semibold uppercase tracking-widest text-white/25 sm:inline-flex">
                    Alat
                </span>
                <button type="button" id="crop-zoom-out" title="Perkecil" class="crop-tool-btn w-full sm:w-auto">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607zM13.5 10.5h-6" />
                    </svg>
                    <span>Perkecil</span>
                </button>
                <button type="button" id="crop-zoom-in" title="Perbesar" class="crop-tool-btn w-full sm:w-auto">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607zM10.5 7.5v6m3-3h-6" />
                    </svg>
                    <span>Perbesar</span>
                </button>
                <button type="button" id="crop-rotate" title="Putar 90°" class="crop-tool-btn w-full sm:w-auto">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                    </svg>
                    <span>Putar</span>
                </button>
            </div>

            <div
                class="grid grid-cols-[minmax(0,1fr)_minmax(0,2fr)] gap-2 px-3 pb-[max(0.75rem,env(safe-area-inset-bottom))] sm:flex sm:gap-3 sm:px-5 sm:pb-5 sm:pt-1">
                <button type="button"
                    class="crop-close min-w-0 rounded-xl border border-white/10 px-3 py-2.5 text-sm font-semibold text-white/50 transition-all hover:border-white/20 hover:bg-white/[0.05] hover:text-white sm:flex-1 sm:px-4">
                    Batal
                </button>
                <button type="button" id="crop-save"
                    class="flex min-w-0 items-center justify-center gap-2 whitespace-nowrap rounded-xl bg-gradient-to-r from-primary-500 to-primary-600 px-3 py-2.5 text-sm font-semibold text-white shadow-lg shadow-primary-500/25 transition-all duration-200 hover:from-primary-400 hover:to-primary-500 hover:shadow-primary-500/40 sm:flex-[2] sm:px-6">
                    <svg class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0z" />
                    </svg>
                    <span class="truncate">Gunakan Foto Ini</span>
                </button>
            </div>
        </div>
    </div>
</div>
