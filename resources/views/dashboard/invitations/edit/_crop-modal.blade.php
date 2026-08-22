{{-- Crop Modal --}}
    <div id="crop-modal" class="hidden fixed inset-0 z-50 bg-black/70 flex items-end sm:items-center justify-center sm:p-4"
        role="dialog" aria-modal="true" aria-labelledby="crop-modal-title">

        <div id="crop-modal-inner" class="relative w-full sm:max-w-2xl h-[92dvh] max-h-[92dvh] sm:h-auto sm:max-h-[90vh] bg-[#0f0f12] rounded-t-2xl sm:rounded-2xl shadow-2xl overflow-hidden flex flex-col">

            {{-- Header --}}
            <div class="flex items-center justify-between px-5 py-4 border-b border-white/[0.07] flex-shrink-0">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-primary-500/15 border border-primary-500/25 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-primary-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 3.75H6A2.25 2.25 0 0 0 3.75 6v1.5M16.5 3.75H18A2.25 2.25 0 0 1 20.25 6v1.5M20.25 16.5V18A2.25 2.25 0 0 1 18 20.25h-1.5M7.5 20.25H6A2.25 2.25 0 0 1 3.75 18v-1.5" />
                        </svg>
                    </div>
                    <div>
                        <h3 id="crop-modal-title" class="text-base font-semibold text-white leading-tight">Sesuaikan Foto</h3>
                        <p id="crop-modal-subtitle" class="text-xs text-white/40 mt-0.5">Geser & perbesar untuk memilih area</p>
                    </div>
                </div>
                <button type="button" class="crop-close w-8 h-8 rounded-lg bg-white/[0.06] hover:bg-white/[0.12] border border-white/[0.08] flex items-center justify-center text-white/50 hover:text-white transition-all">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            {{-- Body: cropper + preview --}}
            <div class="flex flex-col sm:flex-row flex-1 overflow-hidden min-h-0">

                {{-- Cropper area --}}
                <div class="relative bg-black flex-1 min-h-[240px] sm:min-h-[380px]">
                    <div id="crop-loading" class="hidden absolute inset-0 z-10 flex flex-col items-center justify-center gap-3 bg-black/80">
                        <svg class="w-7 h-7 animate-spin text-primary-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v3m6.366-.366l-2.12 2.12M21 12h-3m.366 6.366l-2.12-2.12M12 21v-3m-6.366.366l2.12-2.12M3 12h3m-.366-6.366l2.12 2.12" />
                        </svg>
                        <span id="crop-loading-text" class="text-xs text-white/50 font-medium">Memuat foto...</span>
                    </div>
                    <div id="crop-container" class="w-full h-full">
                    </div>
                </div>

                {{-- Right panel: preview + hint (desktop) --}}
                <div class="hidden sm:flex flex-col items-center justify-center gap-5 w-48 px-4 py-6 border-l border-white/[0.07] bg-white/[0.02] flex-shrink-0">
                    <div>
                        <p class="text-[10px] font-semibold uppercase tracking-widest text-white/30 text-center mb-3">Pratinjau</p>
                        <div class="crop-preview-ring w-24 h-24 mx-auto">
                            {{-- preview image injected by JS --}}
                        </div>
                        <p class="text-[10px] text-white/30 text-center mt-2" id="crop-ratio-hint">Rasio 1:1</p>
                    </div>
                    <div class="text-[10px] text-white/25 text-center leading-relaxed px-1">
                        Geser foto untuk mengatur posisi. Gunakan tombol zoom atau scroll mouse untuk memperbesar.
                    </div>
                </div>
            </div>

            {{-- Toolbar --}}
            <div class="flex-shrink-0 border-t border-white/[0.07] bg-white/[0.02]">
                <div class="flex items-center gap-2 px-4 sm:px-5 py-3 overflow-x-auto no-scrollbar">
                    <span class="text-[10px] font-semibold uppercase tracking-widest text-white/25 mr-1 flex-shrink-0">Alat</span>
                    <button type="button" id="crop-zoom-out" title="Perkecil" class="crop-tool-btn">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607zM13.5 10.5h-6" />
                        </svg>
                        <span>Perkecil</span>
                    </button>
                    <button type="button" id="crop-zoom-in" title="Perbesar" class="crop-tool-btn">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607zM10.5 7.5v6m3-3h-6" />
                        </svg>
                        <span>Perbesar</span>
                    </button>
                    <button type="button" id="crop-rotate" title="Putar 90°" class="crop-tool-btn">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                        </svg>
                        <span>Putar</span>
                    </button>

                    {{-- Mobile preview badge --}}
                    <div class="sm:hidden ml-auto flex items-center gap-2 flex-shrink-0">
                        <div class="crop-preview-ring w-10 h-10">
                        </div>
                    </div>
                </div>

                {{-- Action buttons --}}
                <div class="flex gap-3 px-4 sm:px-5 pb-[max(1.25rem,env(safe-area-inset-bottom))] pt-1">
                    <button type="button"
                        class="crop-close flex-1 px-4 py-2.5 border border-white/10 rounded-xl text-sm font-semibold text-white/50 hover:text-white hover:border-white/20 hover:bg-white/[0.05] transition-all">
                        Batal
                    </button>
                    <button type="button" id="crop-save"
                        class="flex-2 px-6 py-2.5 bg-gradient-to-r from-primary-500 to-primary-600 hover:from-primary-400 hover:to-primary-500 text-white rounded-xl text-sm font-semibold shadow-lg shadow-primary-500/25 hover:shadow-primary-500/40 transition-all duration-200 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0z" />
                        </svg>
                        Gunakan Foto Ini
                    </button>
                </div>
            </div>
        </div>
    </div>
