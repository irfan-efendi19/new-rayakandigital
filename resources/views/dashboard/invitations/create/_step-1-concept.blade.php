{{-- ======================================== --}}
{{-- STEP 1: Konsep & Tema (Inisiasi) --}}
{{-- ======================================== --}}
<div id="step-1" data-step="1"
    class="border-b border-neutral-200/80 dark:border-secondary-700/70 pb-8 scroll-mt-28">
    <div class="flex items-center gap-3 mb-2">
        <div
            class="w-8 h-8 rounded-xl bg-primary-500 text-white font-bold text-sm flex items-center justify-center flex-shrink-0">
            1
        </div>
        <div>
            <h3
                class="font-heading text-lg font-bold text-secondary-900 dark:text-neutral-100">
                Konsep & Tema <span
                    class="text-sm font-normal text-neutral-400 dark:text-neutral-500">(Inisiasi)</span>
            </h3>
        </div>
    </div>
    <p class="text-sm text-neutral-500 dark:text-neutral-400 mb-6">Tentukan identitas proyek
        dan tampilan visual dasar undangan Anda.</p>

    {{-- Title (auto-generated from bride & groom names) --}}
    <input type="hidden" name="title" id="title" value="{{ old('title') }}" required>

    {{-- Slug / Tautan Kustom --}}
    <div data-tour="invitation-link" class="mt-6">
        <div class="mb-4">
            <label for="slug-input"
                class="block text-sm font-bold text-secondary-900 dark:text-neutral-100 mb-0.5">Tautan
                Undangan</label>
            <p class="text-xs text-neutral-500 dark:text-neutral-400">Buat alamat web unik
                agar tamu dapat membuka undangan Anda secara online.</p>
        </div>

        <div class="form-section-card space-y-4">

            {{-- Input Field --}}
            <div>
                <label for="slug-input" class="form-label-crafted">Tautan Kustom</label>
                <div
                    class="flex flex-col sm:flex-row rounded-xl overflow-hidden border border-neutral-200 dark:border-secondary-700 focus-within:border-primary-500 dark:focus-within:border-primary-400 focus-within:ring-2 focus-within:ring-primary-500/20 dark:focus-within:ring-primary-400/20 transition-all duration-150 shadow-sm">
                    <span
                        class="inline-flex items-center px-3.5 py-2 sm:py-2.5 bg-neutral-100/80 dark:bg-secondary-700/80 text-xs sm:text-sm text-neutral-500 dark:text-neutral-400 whitespace-nowrap font-mono border-b sm:border-b-0 sm:border-r border-neutral-200 dark:border-secondary-700 flex-shrink-0 select-none justify-start">{{ parse_url(config('app.url'), PHP_URL_HOST) }}/</span>
                    <input type="text" name="slug" id="slug-input" value="{{ old('slug') }}"
                        class="block flex-1 w-full min-w-0 border-0 bg-white dark:bg-secondary-800 text-neutral-900 dark:text-neutral-100 placeholder:text-neutral-400 dark:placeholder:text-neutral-500 text-sm px-3.5 py-2.5 focus:ring-0 outline-none font-mono"
                        placeholder="contoh: andi-dan-sari" maxlength="100"
                        pattern="^[a-z0-9\-]+$">
                </div>
                <div id="slug-indicator"
                    class="mt-2 text-xs flex items-center gap-1.5 text-neutral-400 dark:text-neutral-500">
                    <span id="slug-icon"
                        class="slug-icon flex items-center text-[13px] leading-none">🔗</span>
                    <span id="slug-text" class="slug-text">Masukkan tautan kustom</span>
                </div>
                @error('slug')
                    <span
                        class="text-red-500 dark:text-red-400 text-xs mt-1 block font-medium">{{ $message }}</span>
                @enderror
            </div>

            {{-- Live URL Preview --}}
            <div id="slug-preview-box"
                class="bg-neutral-50 dark:bg-secondary-900/50 rounded-xl border border-neutral-200 dark:border-secondary-700 p-3.5 transition-all duration-300"
                style="display: none;">
                <p
                    class="text-[10px] uppercase tracking-widest font-semibold text-neutral-400 dark:text-neutral-500 mb-1.5">
                    Pratinjau Tautan</p>
                <div class="flex items-center gap-2">
                    <div
                        class="w-5 h-5 rounded-md bg-green-100 dark:bg-green-900/30 flex items-center justify-center flex-shrink-0">
                        <svg class="w-3 h-3 text-green-600 dark:text-green-400" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2.5" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <p class="font-mono text-sm text-primary-600 dark:text-primary-400 break-all"
                        id="slug-preview-url">
                        {{ parse_url(config('app.url'), PHP_URL_HOST) }}/<span
                            id="slug-preview-text"
                            class="font-semibold">nama-undangan</span>
                    </p>
                </div>
            </div>

            {{-- Format Rules --}}
            <div class="flex flex-wrap items-center gap-x-4 gap-y-2">
                <p
                    class="text-[10px] uppercase tracking-widest font-semibold text-neutral-400 dark:text-neutral-500">
                    Format:</p>
                <div class="flex flex-wrap gap-1.5">
                    <span
                        class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-neutral-100 dark:bg-secondary-700 text-[11px] text-neutral-600 dark:text-neutral-300 font-medium">
                        <span
                            class="font-mono font-bold text-primary-600 dark:text-primary-400">a-z</span>
                        huruf kecil
                    </span>
                    <span
                        class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-neutral-100 dark:bg-secondary-700 text-[11px] text-neutral-600 dark:text-neutral-300 font-medium">
                        <span
                            class="font-mono font-bold text-primary-600 dark:text-primary-400">0-9</span>
                        angka
                    </span>
                    <span
                        class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-neutral-100 dark:bg-secondary-700 text-[11px] text-neutral-600 dark:text-neutral-300 font-medium">
                        <span
                            class="font-mono font-bold text-primary-600 dark:text-primary-400">-</span>
                        tanda hubung
                    </span>
                </div>
            </div>

            {{-- Tip: Auto-generate --}}
            <div
                class="flex items-start gap-2.5 bg-amber-50 dark:bg-amber-950/20 border border-amber-200/80 dark:border-amber-800/30 rounded-xl p-3.5">
                <svg class="w-4 h-4 text-amber-500 dark:text-amber-400 flex-shrink-0 mt-0.5"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                </svg>
                <p class="text-xs text-amber-700 dark:text-amber-300 leading-relaxed">
                    <strong class="font-semibold">Tips:</strong> Kosongkan kolom ini jika
                    ingin tautan di-generate
                    otomatis dari nama pengantin. Anda juga bisa mengubahnya nanti di
                    halaman edit undangan.
                </p>
            </div>
        </div>
    </div>

    {{-- Theme Selection --}}
    @php $currentTheme = old('theme', $selectedTheme); @endphp

    @if(!$hasPredefinedTheme)
        <div x-data="{ selectedTheme: '{{ $currentTheme }}' }" class="space-y-3 mt-6"
            data-tour="select-theme">
            <input type="hidden" name="theme" x-model="selectedTheme" required>

            <div class="form-section-card space-y-4">
                <div class="flex flex-col">
                    <label class="form-label-crafted">
                        Pilih Tema Undangan <span class="text-red-500">*</span>
                    </label>
                    <span class="text-xs text-neutral-500 dark:text-neutral-400 mt-0.5">
                        Geser horizontal untuk melihat koleksi desain premium. Klik pada kartu
                        gambar untuk memilih tema.
                    </span>
                </div>

                <div
                    class="flex gap-4 overflow-x-auto py-3 px-1 scrollbar-thin scrollbar-thumb-neutral-200 dark:scrollbar-thumb-neutral-700 snap-x items-stretch">

                    @foreach($themes as $tema)
                        @php $themeKey = str_replace('themes.', '', $tema->view_path); @endphp
                        <div @click="selectedTheme = '{{ $themeKey }}'" :class="{
                                                        'border-primary-500 ring-2 ring-primary-500/20 shadow-md bg-primary-50/40 dark:bg-primary-950/30': selectedTheme === '{{ $themeKey }}',
                                                        'border-neutral-200/90 dark:border-secondary-700 hover:border-primary-300 dark:hover:border-primary-700 bg-white dark:bg-secondary-800/90': selectedTheme !== '{{ $themeKey }}'
                                                    }"
                            class="theme-card w-36 sm:w-44 flex-shrink-0 border rounded-2xl p-3 cursor-pointer snap-start relative flex flex-col justify-between select-none group transition-all duration-200">
                            <div x-show="selectedTheme === '{{ $themeKey }}'"
                                class="absolute top-4 right-4 bg-primary-500 text-white rounded-full p-1 z-10 shadow-sm ring-2 ring-white dark:ring-secondary-800"
                                x-cloak>
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="3">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                            </div>

                            <div
                                class="w-full aspect-[9/16] rounded-xl overflow-hidden bg-neutral-100 dark:bg-secondary-900 relative border border-neutral-100 dark:border-secondary-700/50">
                                @if($tema->thumbnail_portrait)
                                    <img src="{{ asset('storage/' . $tema->thumbnail_portrait) }}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                                        alt="Pratinjau {{ $tema->name }}">
                                @else
                                    <div
                                        class="w-full h-full flex items-center justify-center text-neutral-400 text-xs font-medium">
                                        No Preview</div>
                                @endif
                            </div>

                            <div class="mt-3 space-y-1">
                                <span
                                    class="inline-block text-[9px] font-bold uppercase tracking-wider bg-neutral-100 dark:bg-secondary-700 text-neutral-600 dark:text-neutral-300 px-2 py-0.5 rounded-md">
                                    {{ $tema->themeCategory?->name ?? 'Umum' }}
                                </span>

                                <h4
                                    class="text-xs font-bold text-neutral-800 dark:text-neutral-100 truncate block">
                                    {{ $tema->name }}
                                </h4>
                            </div>
                        </div>
                    @endforeach

                </div>

                @error('theme') <span
                    class="text-red-500 dark:text-red-400 text-xs mt-1 block font-medium">{{ $message }}</span>
                @enderror
            </div>
        </div>
    @else
        <input type="hidden" name="theme" value="{{ $currentTheme }}" required>
    @endif
</div>
