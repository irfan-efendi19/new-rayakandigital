<x-app-layout>
    {{-- Hero Header --}}
    <div class="hero-mesh grain-overlay border-b border-neutral-200/60 dark:border-secondary-700/40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-7 sm:py-8">
            <nav class="flex items-center gap-1.5 text-xs text-neutral-400 dark:text-neutral-500 mb-4">
                <a href="{{ route('dashboard') }}" class="hover:text-primary dark:hover:text-primary-400 transition-colors">Dashboard</a>
                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                <span class="text-neutral-600 dark:text-neutral-400 font-medium">Buat Undangan</span>
            </nav>

            <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
                <div>
                    <h1 class="font-heading text-2xl sm:text-3xl font-bold text-secondary-800 dark:text-neutral-50 leading-tight">
                        Buat Undangan Baru
                    </h1>
                    <p class="text-sm text-neutral-500 dark:text-neutral-400 mt-1">Lengkapi data berikut untuk membuat undangan digital Anda.</p>
                </div>
                <div class="flex items-center gap-2 self-start">
                    <button type="button" id="btn-start-tour"
                        class="inline-flex items-center gap-2 px-3.5 py-2 text-xs font-semibold text-primary dark:text-primary-300 bg-white/70 dark:bg-secondary-800/50 border border-primary/30 dark:border-primary-800 rounded-xl hover:bg-primary-50 dark:hover:bg-primary-900/30 transition-all backdrop-blur-sm">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Panduan Tutorial
                    </button>
                    <a href="{{ route('dashboard') }}"
                        class="inline-flex items-center gap-2 px-3.5 py-2 text-xs font-semibold text-neutral-700 dark:text-neutral-300 bg-white/70 dark:bg-secondary-800/50 border border-neutral-300/80 dark:border-secondary-600 rounded-xl hover:bg-white dark:hover:bg-secondary-700 transition-all backdrop-blur-sm">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Sticky Step Progress Bar --}}
    <div x-data="{ activeStep: 1 }" x-init="() => {
        const observer = new IntersectionObserver(entries => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    activeStep = parseInt(entry.target.dataset.step);
                }
            });
        }, { rootMargin: '-120px 0px -60% 0px' });
        document.querySelectorAll('[data-step]').forEach(el => observer.observe(el));
    }" class="sticky top-[64px] z-30 bg-white/90 dark:bg-secondary-900/90 backdrop-blur-md border-b border-neutral-200/80 dark:border-secondary-800/80 py-3 shadow-sm">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center gap-0 overflow-x-auto no-scrollbar">
                {{-- Step 1 --}}
                <a href="#step-1" @click.prevent="document.getElementById('step-1').scrollIntoView({ behavior: 'smooth' })"
                    :class="activeStep === 1 ? 'text-primary dark:text-primary-300 font-bold' : 'text-neutral-500 dark:text-neutral-400 hover:text-neutral-800 dark:hover:text-neutral-200 font-medium'"
                    class="flex items-center gap-2 px-3 py-1.5 rounded-xl transition-all duration-200 text-xs whitespace-nowrap">
                    <span :class="activeStep === 1 ? 'bg-primary-500 text-white shadow-sm ring-2 ring-primary-500/20' : (activeStep > 1 ? 'bg-primary-100 text-primary-700 dark:bg-primary-950/60 dark:text-primary-300' : 'bg-neutral-100 dark:bg-secondary-800 text-neutral-500 dark:text-neutral-400')"
                        class="w-6 h-6 rounded-full text-[11px] flex items-center justify-center font-bold transition-all duration-200 flex-shrink-0">
                        <template x-if="activeStep > 1"><svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg></template>
                        <template x-if="activeStep <= 1"><span>1</span></template>
                    </span>
                    <span class="hidden sm:inline">Konsep & Tema</span>
                    <span class="sm:hidden">Tema</span>
                </a>
                {{-- Connector 1→2 --}}
                <div class="flex-1 min-w-[20px] h-0.5 mx-1 rounded-full transition-all duration-500"
                    :class="activeStep >= 2 ? 'bg-primary-500/40 dark:bg-primary-400/40' : 'bg-neutral-200 dark:bg-secondary-800'"></div>
                {{-- Step 2 --}}
                <a href="#step-2" @click.prevent="document.getElementById('step-2').scrollIntoView({ behavior: 'smooth' })"
                    :class="activeStep === 2 ? 'text-primary dark:text-primary-300 font-bold' : 'text-neutral-500 dark:text-neutral-400 hover:text-neutral-800 dark:hover:text-neutral-200 font-medium'"
                    class="flex items-center gap-2 px-3 py-1.5 rounded-xl transition-all duration-200 text-xs whitespace-nowrap">
                    <span :class="activeStep === 2 ? 'bg-primary-500 text-white shadow-sm ring-2 ring-primary-500/20' : (activeStep > 2 ? 'bg-primary-100 text-primary-700 dark:bg-primary-950/60 dark:text-primary-300' : 'bg-neutral-100 dark:bg-secondary-800 text-neutral-500 dark:text-neutral-400')"
                        class="w-6 h-6 rounded-full text-[11px] flex items-center justify-center font-bold transition-all duration-200 flex-shrink-0">
                        <template x-if="activeStep > 2"><svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg></template>
                        <template x-if="activeStep <= 2"><span>2</span></template>
                    </span>
                    <span class="hidden sm:inline">Mempelai</span>
                    <span class="sm:hidden">Mempelai</span>
                </a>
                {{-- Connector 2→3 --}}
                <div class="flex-1 min-w-[20px] h-0.5 mx-1 rounded-full transition-all duration-500"
                    :class="activeStep >= 3 ? 'bg-primary-500/40 dark:bg-primary-400/40' : 'bg-neutral-200 dark:bg-secondary-800'"></div>
                {{-- Step 3 --}}
                <a href="#step-3" @click.prevent="document.getElementById('step-3').scrollIntoView({ behavior: 'smooth' })"
                    :class="activeStep === 3 ? 'text-primary dark:text-primary-300 font-bold' : 'text-neutral-500 dark:text-neutral-400 hover:text-neutral-800 dark:hover:text-neutral-200 font-medium'"
                    class="flex items-center gap-2 px-3 py-1.5 rounded-xl transition-all duration-200 text-xs whitespace-nowrap">
                    <span :class="activeStep === 3 ? 'bg-primary-500 text-white shadow-sm ring-2 ring-primary-500/20' : 'bg-neutral-100 dark:bg-secondary-800 text-neutral-500 dark:text-neutral-400'"
                        class="w-6 h-6 rounded-full text-[11px] flex items-center justify-center font-bold transition-all duration-200 flex-shrink-0">3</span>
                    <span class="hidden sm:inline">Waktu & Tempat</span>
                    <span class="sm:hidden">Waktu</span>
                </a>
            </div>

            <div class="mt-2.5 h-1 rounded-full bg-neutral-200/80 dark:bg-secondary-800 overflow-hidden">
                <div class="h-full bg-gradient-to-r from-primary-500 to-primary-400 rounded-full transition-all duration-500"
                    :style="'width: ' + Math.min((activeStep / 3) * 100, 100) + '%'"></div>
            </div>
        </div>
    </div>

    <style>
        #crop-container {
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        #crop-container cropper-canvas {
            flex: 1;
            min-height: 0;
        }

        /* Crop Modal modern styles */
        #crop-modal {
            backdrop-filter: blur(4px);
            -webkit-backdrop-filter: blur(4px);
        }

        #crop-modal-inner {
            animation: cropModalIn 0.22s cubic-bezier(0.34,1.56,0.64,1);
        }

        @keyframes cropModalIn {
            from { opacity: 0; transform: translateY(24px) scale(0.97); }
            to   { opacity: 1; transform: translateY(0)  scale(1);    }
        }

        #crop-preview-ring {
            overflow: hidden;
            border-radius: 9999px;
            border: 3px solid rgba(var(--color-primary-400), 1);
            box-shadow: 0 0 0 4px rgba(var(--color-primary-400), 0.18);
            background: #111;
        }

        .crop-tool-btn {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 4px;
            padding: 10px 14px;
            border-radius: 12px;
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.1);
            color: #d4d4d8;
            transition: background 0.15s, border-color 0.15s, color 0.15s;
            cursor: pointer;
            flex-shrink: 0;
            white-space: nowrap;
        }

        @media (max-width: 480px) {
            .crop-tool-btn {
                padding: 8px 10px;
            }
        }

        .crop-tool-btn:hover {
            background: rgba(255,255,255,0.13);
            border-color: rgba(255,255,255,0.2);
            color: #fff;
        }

        .crop-tool-btn span {
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 0.02em;
            line-height: 1;
        }

        [x-cloak] {
            display: none !important;
        }

        .scrollbar-thin::-webkit-scrollbar {
            height: 6px;
        }

        .scrollbar-thin::-webkit-scrollbar-track {
            background: transparent;
        }

        .scrollbar-thin::-webkit-scrollbar-thumb {
            background-color: #E4E4E7;
            border-radius: 10px;
        }

        .dark .scrollbar-thin::-webkit-scrollbar-thumb {
            background-color: #27272A;
        }

        .photo-upload-zone {
            transition: border-color 0.2s, background-color 0.2s;
        }

        .theme-card {
            transition: all 0.2s ease-in-out;
        }
    </style>

    <div class="py-8">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div
                class="bg-white dark:bg-secondary-800/90 rounded-2xl sm:rounded-3xl border border-neutral-200/80 dark:border-secondary-700/80 shadow-[0_8px_30px_rgb(0,0,0,0.04)] dark:shadow-[0_8px_30px_rgba(0,0,0,0.25)] overflow-hidden">
                <div class="p-6 md:p-8">
                    <form action="{{ route('dashboard.invitations.store') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="space-y-8">

                            {{-- ======================================== --}}
                            {{-- STEP 1: Konsep & Tema (Inisiasi) --}}
                            {{-- ======================================== --}}
                            <div id="step-1" data-step="1" class="border-b border-neutral-200/80 dark:border-secondary-700/70 pb-8 scroll-mt-28">
                                <div class="flex items-center gap-3 mb-2">
                                    <div class="w-8 h-8 rounded-xl bg-primary-500 text-white font-bold text-sm flex items-center justify-center flex-shrink-0">
                                        1
                                    </div>
                                    <div>
                                        <h3 class="font-heading text-lg font-bold text-secondary-900 dark:text-neutral-100">
                                            Konsep & Tema <span class="text-sm font-normal text-neutral-400 dark:text-neutral-500">(Inisiasi)</span>
                                        </h3>
                                    </div>
                                </div>
                                <p class="text-sm text-neutral-500 dark:text-neutral-400 mb-6">Tentukan identitas proyek dan tampilan visual dasar undangan Anda.</p>

                                {{-- Title (auto-generated from bride & groom names) --}}
                                <input type="hidden" name="title" id="title" value="{{ old('title') }}" required>

                                {{-- Slug / Tautan Kustom --}}
                                <div data-tour="invitation-link" class="mt-6">
                                    <div class="mb-4">
                                        <label for="slug-input" class="block text-sm font-bold text-secondary-900 dark:text-neutral-100 mb-0.5">Tautan Undangan</label>
                                        <p class="text-xs text-neutral-500 dark:text-neutral-400">Buat alamat web unik agar tamu dapat membuka undangan Anda secara online.</p>
                                    </div>

                                    <div class="form-section-card space-y-4">

                                        {{-- Input Field --}}
                                        <div>
                                            <label for="slug-input" class="form-label-crafted">Tautan Kustom</label>
                                            <div class="flex flex-col sm:flex-row rounded-xl overflow-hidden border border-neutral-200 dark:border-secondary-700 focus-within:border-primary-500 dark:focus-within:border-primary-400 focus-within:ring-2 focus-within:ring-primary-500/20 dark:focus-within:ring-primary-400/20 transition-all duration-150 shadow-sm">
                                                <span class="inline-flex items-center px-3.5 py-2 sm:py-2.5 bg-neutral-100/80 dark:bg-secondary-700/80 text-xs sm:text-sm text-neutral-500 dark:text-neutral-400 whitespace-nowrap font-mono border-b sm:border-b-0 sm:border-r border-neutral-200 dark:border-secondary-700 flex-shrink-0 select-none justify-start">{{ parse_url(config('app.url'), PHP_URL_HOST) }}/</span>
                                                <input type="text" name="slug" id="slug-input"
                                                    value="{{ old('slug') }}"
                                                    class="block flex-1 w-full min-w-0 border-0 bg-white dark:bg-secondary-800 text-neutral-900 dark:text-neutral-100 placeholder:text-neutral-400 dark:placeholder:text-neutral-500 text-sm px-3.5 py-2.5 focus:ring-0 outline-none font-mono"
                                                    placeholder="contoh: andi-dan-sari" maxlength="100"
                                                    pattern="^[a-z0-9\-]+$">
                                            </div>
                                            <div id="slug-indicator"
                                                class="mt-2 text-xs flex items-center gap-1.5 text-neutral-400 dark:text-neutral-500">
                                                <span id="slug-icon" class="slug-icon flex items-center text-[13px] leading-none">🔗</span>
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
                                                    <svg class="w-3 h-3 text-green-600 dark:text-green-400"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2.5"
                                                            d="M5 13l4 4L19 7" />
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
                                            <p class="text-[10px] uppercase tracking-widest font-semibold text-neutral-400 dark:text-neutral-500">
                                            Format:</p>
                                            <div class="flex flex-wrap gap-1.5">
                                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-neutral-100 dark:bg-secondary-700 text-[11px] text-neutral-600 dark:text-neutral-300 font-medium">
                                                    <span class="font-mono font-bold text-primary-600 dark:text-primary-400">a-z</span> huruf kecil
                                                </span>
                                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-neutral-100 dark:bg-secondary-700 text-[11px] text-neutral-600 dark:text-neutral-300 font-medium">
                                                    <span class="font-mono font-bold text-primary-600 dark:text-primary-400">0-9</span> angka
                                                </span>
                                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-neutral-100 dark:bg-secondary-700 text-[11px] text-neutral-600 dark:text-neutral-300 font-medium">
                                                    <span class="font-mono font-bold text-primary-600 dark:text-primary-400">-</span> tanda hubung
                                                </span>
                                            </div>
                                        </div>

                                        {{-- Tip: Auto-generate --}}
                                        <div
                                            class="flex items-start gap-2.5 bg-amber-50 dark:bg-amber-950/20 border border-amber-200/80 dark:border-amber-800/30 rounded-xl p-3.5">
                                            <svg class="w-4 h-4 text-amber-500 dark:text-amber-400 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                                            </svg>
                                            <p class="text-xs text-amber-700 dark:text-amber-300 leading-relaxed">
                                                <strong class="font-semibold">Tips:</strong> Kosongkan kolom ini jika ingin tautan di-generate
                                                otomatis dari nama pengantin. Anda juga bisa mengubahnya nanti di
                                                halaman edit undangan.
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                {{-- Theme Selection --}}
                                @php $currentTheme = old('theme', $selectedTheme); @endphp

                                @if(!$hasPredefinedTheme)
                                    <div x-data="{ selectedTheme: '{{ $currentTheme }}' }" class="space-y-3 mt-6" data-tour="select-theme">
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

                            {{-- ======================================== --}}
                            {{-- STEP 2: Informasi Mempelai (Profil) --}}
                            {{-- ======================================== --}}
                            <div id="step-2" data-step="2" class="border-b border-neutral-200/80 dark:border-secondary-700/70 pb-8 scroll-mt-28" data-tour="mempelai-info">
                                <div class="flex items-center gap-3 mb-2">
                                    <div class="w-8 h-8 rounded-xl bg-primary-500 text-white font-bold text-sm flex items-center justify-center flex-shrink-0">
                                        2
                                    </div>
                                    <div>
                                        <h3 class="font-heading text-lg font-bold text-secondary-900 dark:text-neutral-100">
                                            Informasi Mempelai <span class="text-sm font-normal text-neutral-400 dark:text-neutral-500">(Profil)</span>
                                        </h3>
                                    </div>
                                </div>
                                <p class="text-sm text-neutral-500 dark:text-neutral-400 mb-6">Data lengkap kedua mempelai yang akan tampil di halaman utama.</p>

                                <div x-data="{
                                    order: '{{ old('bride_groom_order', 'male_first') }}',
                                    toggleOrder() { this.order = this.order === 'male_first' ? 'female_first' : 'male_first'; }
                                }"
                                    class="flex flex-col gap-6">

                                    <input type="hidden" name="bride_groom_order" :value="order">

                                    {{-- Swap Button --}}
                                    <div class="flex justify-center -mb-2">
                                        <button @click="toggleOrder" type="button"
                                            class="inline-flex items-center gap-2 px-4 py-2 text-xs font-semibold rounded-xl text-primary-600 dark:text-primary-400 bg-primary-50 dark:bg-primary-500/10 border border-primary-200 dark:border-primary-500/30 hover:bg-primary-100 dark:hover:bg-primary-500/20 dark:hover:border-primary-500/50 transition-all duration-150 active:scale-95 shadow-sm">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                                            </svg>
                                            Tukar Urutan Posisi
                                        </button>
                                    </div>

                                    {{-- Bride --}}
                                    <div :style="order === 'female_first' ? { order: 1 } : { order: 2 }"
                                        class="form-section-card">
                                        {{-- Card Header --}}
                                        <div class="flex items-center gap-3 mb-5 pb-4 border-b border-neutral-100 dark:border-secondary-700/50">
                                            <div class="w-8 h-8 rounded-xl bg-pink-50 dark:bg-pink-950/40 border border-pink-100 dark:border-pink-900/50 flex items-center justify-center text-pink-500 dark:text-pink-400 flex-shrink-0">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                            </div>
                                            <div>
                                                <h4 class="font-bold text-sm text-secondary-900 dark:text-neutral-100">Mempelai Wanita</h4>
                                                <p class="text-xs text-neutral-400 dark:text-neutral-500 mt-0.5">Data diri mempelai wanita</p>
                                            </div>
                                        </div>

                                        {{-- Photo Upload (top, prominent) --}}
                                        <div class="mb-5">
                                            <label class="form-label-crafted">Foto Profil</label>
                                            <div class="photo-upload-zone flex items-center gap-4 border-2 border-dashed border-neutral-200 dark:border-secondary-700 rounded-2xl p-4 bg-white dark:bg-secondary-800/60 hover:border-primary-400 dark:hover:border-primary-600 hover:bg-primary-50/20 dark:hover:bg-primary-950/10 transition-all cursor-pointer group"
                                                onclick="document.querySelector('[data-crop-target=bride_photo_input]').click()">
                                                <div class="relative flex-shrink-0">
                                                    <img id="bride-preview" src="" alt="Bride photo"
                                                        class="w-16 h-16 object-cover rounded-xl border border-neutral-200 dark:border-secondary-600 hidden">
                                                    <div id="bride-preview-placeholder"
                                                        class="w-16 h-16 bg-neutral-100 dark:bg-secondary-700 rounded-xl flex items-center justify-center text-neutral-300 dark:text-neutral-500 border border-dashed border-neutral-300 dark:border-secondary-600">
                                                        <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                        </svg>
                                                    </div>
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <p class="text-sm font-semibold text-neutral-700 dark:text-neutral-200 group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors">Unggah Foto Mempelai Wanita</p>
                                                    <p class="text-xs text-neutral-400 dark:text-neutral-500 mt-0.5">Klik untuk pilih foto (rasio 1:1)</p>
                                                            <input type="file" name="bride_photo" id="bride_photo_input"
                                                                class="crop-file-input hidden" accept="image/*"
                                                                data-preview="bride-preview"
                                                                data-title="Foto Mempelai Wanita"
                                                                data-aspect-ratio="1" data-width="400" data-height="400">
                                                    <button type="button" data-crop-target="bride_photo_input"
                                                        onclick="event.stopPropagation()"
                                                        class="mt-2.5 inline-flex items-center gap-1.5 px-3 py-1.5 bg-white dark:bg-secondary-700 border border-neutral-200 dark:border-secondary-600 text-neutral-600 dark:text-neutral-300 rounded-lg text-xs font-semibold hover:bg-primary-500 hover:border-primary-500 hover:text-white dark:hover:bg-primary-500 dark:hover:border-primary-500 transition-all duration-150">
                                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                                                        Pilih &amp; Crop Foto
                                                    </button>
                                                </div>
                                            </div>
                                            @error('bride_photo') <span class="text-red-500 dark:text-red-400 text-xs mt-1 block font-medium">{{ $message }}</span>@enderror
                                        </div>

                                        {{-- Name Grid --}}
                                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                            <div>
                                                <label for="bride_name" class="form-label-crafted">Nama Lengkap <span class="text-red-500">*</span></label>
                                                <input type="text" name="bride_name" id="bride_name"
                                                    value="{{ old('bride_name') }}"
                                                    class="form-input-crafted"
                                                    required placeholder="Ani Suryani">
                                                @error('bride_name') <span class="text-red-500 dark:text-red-400 text-xs mt-1 block font-medium">{{ $message }}</span>@enderror
                                            </div>
                                            <div>
                                                <label for="bride_nickname" class="form-label-crafted">Nama Panggilan</label>
                                                <input type="text" name="bride_nickname" id="bride_nickname"
                                                    value="{{ old('bride_nickname') }}"
                                                    class="form-input-crafted"
                                                    placeholder="Ani">
                                                @error('bride_nickname') <span class="text-red-500 dark:text-red-400 text-xs mt-1 block font-medium">{{ $message }}</span>@enderror
                                            </div>
                                            <div>
                                                <label for="bride_father_name" class="form-label-crafted">Nama Ayah <span class="text-red-500">*</span></label>
                                                <input type="text" name="bride_father_name" id="bride_father_name"
                                                    value="{{ old('bride_father_name') }}"
                                                    class="form-input-crafted"
                                                    placeholder="Nama Ayah Mempelai Wanita" required>
                                                @error('bride_father_name') <span class="text-red-500 dark:text-red-400 text-xs mt-1 block font-medium">{{ $message }}</span>@enderror
                                            </div>
                                            <div>
                                                <label for="bride_mother_name" class="form-label-crafted">Nama Ibu <span class="text-red-500">*</span></label>
                                                <input type="text" name="bride_mother_name" id="bride_mother_name"
                                                    value="{{ old('bride_mother_name') }}"
                                                    class="form-input-crafted"
                                                    placeholder="Nama Ibu Mempelai Wanita" required>
                                                @error('bride_mother_name') <span class="text-red-500 dark:text-red-400 text-xs mt-1 block font-medium">{{ $message }}</span>@enderror
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Groom --}}
                                    <div :style="order === 'male_first' ? { order: 1 } : { order: 2 }"
                                        class="form-section-card">
                                        {{-- Card Header --}}
                                        <div class="flex items-center gap-3 mb-5 pb-4 border-b border-neutral-100 dark:border-secondary-700/50">
                                            <div class="w-8 h-8 rounded-xl bg-blue-50 dark:bg-blue-950/40 border border-blue-100 dark:border-blue-900/50 flex items-center justify-center text-blue-500 dark:text-blue-400 flex-shrink-0">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                            </div>
                                            <div>
                                                <h4 class="font-bold text-sm text-secondary-900 dark:text-neutral-100">Mempelai Pria</h4>
                                                <p class="text-xs text-neutral-400 dark:text-neutral-500 mt-0.5">Data diri mempelai pria</p>
                                            </div>
                                        </div>

                                        {{-- Photo Upload (top, prominent) --}}
                                        <div class="mb-5">
                                            <label class="form-label-crafted">Foto Profil</label>
                                            <div class="photo-upload-zone flex items-center gap-4 border-2 border-dashed border-neutral-200 dark:border-secondary-700 rounded-2xl p-4 bg-white dark:bg-secondary-800/60 hover:border-primary-400 dark:hover:border-primary-600 hover:bg-primary-50/20 dark:hover:bg-primary-950/10 transition-all cursor-pointer group"
                                                onclick="document.querySelector('[data-crop-target=groom_photo_input]').click()">
                                                <div class="relative flex-shrink-0">
                                                    <img id="groom-preview" src="" alt="Groom photo"
                                                        class="w-16 h-16 object-cover rounded-xl border border-neutral-200 dark:border-secondary-600 hidden">
                                                    <div id="groom-preview-placeholder"
                                                        class="w-16 h-16 bg-neutral-100 dark:bg-secondary-700 rounded-xl flex items-center justify-center text-neutral-300 dark:text-neutral-500 border border-dashed border-neutral-300 dark:border-secondary-600">
                                                        <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                        </svg>
                                                    </div>
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <p class="text-sm font-semibold text-neutral-700 dark:text-neutral-200 group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors">Unggah Foto Mempelai Pria</p>
                                                    <p class="text-xs text-neutral-400 dark:text-neutral-500 mt-0.5">Klik untuk pilih foto (rasio 1:1)</p>
                                                            <input type="file" name="groom_photo" id="groom_photo_input"
                                                                class="crop-file-input hidden" accept="image/*"
                                                                data-preview="groom-preview"
                                                                data-title="Foto Mempelai Pria"
                                                                data-aspect-ratio="1" data-width="400" data-height="400">
                                                    <button type="button" data-crop-target="groom_photo_input"
                                                        onclick="event.stopPropagation()"
                                                        class="mt-2.5 inline-flex items-center gap-1.5 px-3 py-1.5 bg-white dark:bg-secondary-700 border border-neutral-200 dark:border-secondary-600 text-neutral-600 dark:text-neutral-300 rounded-lg text-xs font-semibold hover:bg-primary-500 hover:border-primary-500 hover:text-white dark:hover:bg-primary-500 dark:hover:border-primary-500 transition-all duration-150">
                                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                                                        Pilih &amp; Crop Foto
                                                    </button>
                                                </div>
                                            </div>
                                            @error('groom_photo') <span class="text-red-500 dark:text-red-400 text-xs mt-1 block font-medium">{{ $message }}</span>@enderror
                                        </div>

                                        {{-- Name Grid --}}
                                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                            <div>
                                                <label for="groom_name" class="form-label-crafted">Nama Lengkap <span class="text-red-500">*</span></label>
                                                <input type="text" name="groom_name" id="groom_name"
                                                    value="{{ old('groom_name') }}"
                                                    class="form-input-crafted"
                                                    required placeholder="Budi Santoso">
                                                @error('groom_name') <span class="text-red-500 dark:text-red-400 text-xs mt-1 block font-medium">{{ $message }}</span>@enderror
                                            </div>
                                            <div>
                                                <label for="groom_nickname" class="form-label-crafted">Nama Panggilan</label>
                                                <input type="text" name="groom_nickname" id="groom_nickname"
                                                    value="{{ old('groom_nickname') }}"
                                                    class="form-input-crafted"
                                                    placeholder="Budi">
                                                @error('groom_nickname') <span class="text-red-500 dark:text-red-400 text-xs mt-1 block font-medium">{{ $message }}</span>@enderror
                                            </div>
                                            <div>
                                                <label for="groom_father_name" class="form-label-crafted">Nama Ayah <span class="text-red-500">*</span></label>
                                                <input type="text" name="groom_father_name" id="groom_father_name"
                                                    value="{{ old('groom_father_name') }}"
                                                    class="form-input-crafted"
                                                    placeholder="Nama Ayah Mempelai Pria" required>
                                                @error('groom_father_name') <span class="text-red-500 dark:text-red-400 text-xs mt-1 block font-medium">{{ $message }}</span>@enderror
                                            </div>
                                            <div>
                                                <label for="groom_mother_name" class="form-label-crafted">Nama Ibu <span class="text-red-500">*</span></label>
                                                <input type="text" name="groom_mother_name" id="groom_mother_name"
                                                    value="{{ old('groom_mother_name') }}"
                                                    class="form-input-crafted"
                                                    placeholder="Nama Ibu Mempelai Pria" required>
                                                @error('groom_mother_name') <span class="text-red-500 dark:text-red-400 text-xs mt-1 block font-medium">{{ $message }}</span>@enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- ======================================== --}}
                            {{-- STEP 3: Waktu & Tempat (Detail Acara) --}}
                            {{-- ======================================== --}}
                            <div id="step-3" data-step="3" class="border-b border-neutral-200/80 dark:border-secondary-700/70 pb-8 scroll-mt-28" data-tour="event-schedule">
                                <div class="flex items-center gap-3 mb-2">
                                    <div class="w-8 h-8 rounded-xl bg-primary-500 text-white font-bold text-sm flex items-center justify-center flex-shrink-0">
                                        3
                                    </div>
                                    <div>
                                        <h3 class="font-heading text-lg font-bold text-secondary-900 dark:text-neutral-100">
                                            Waktu & Tempat <span class="text-sm font-normal text-neutral-400 dark:text-neutral-500">(Detail Acara)</span>
                                        </h3>
                                    </div>
                                </div>
                                <p class="text-sm text-neutral-500 dark:text-neutral-400 mb-6">Informasi krusial mengenai kapan dan di mana acara berlangsung.</p>

                                {{-- Timezone --}}
                                <div class="mt-6">
                                    <label for="timezone" class="form-label-crafted">Zona Waktu</label>
                                    <select name="timezone" id="timezone" class="form-input-crafted">
                                        <option value="Asia/Jakarta" {{ old('timezone', 'Asia/Jakarta') == 'Asia/Jakarta' ? 'selected' : '' }}>WIB (Waktu Indonesia Barat)</option>
                                        <option value="Asia/Makassar" {{ old('timezone') == 'Asia/Makassar' ? 'selected' : '' }}>WITA (Waktu Indonesia Tengah)</option>
                                        <option value="Asia/Jayapura" {{ old('timezone') == 'Asia/Jayapura' ? 'selected' : '' }}>WIT (Waktu Indonesia Timur)</option>
                                    </select>
                                    @error('timezone') <span
                                        class="text-red-500 dark:text-red-400 text-xs mt-1 block font-medium">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Events management --}}
                                <div class="mt-6">
                                    <div class="flex items-center justify-between mb-3">
                                        <div>
                                            <h4 class="font-bold text-base text-secondary-900 dark:text-neutral-100">Daftar Acara</h4>
                                            <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-0.5">Tambah beberapa acara sekaligus — Akad Nikah, Resepsi, Unduh Mantu, dll.</p>
                                        </div>
                                    </div>

                                    @error('events') <span
                                        class="text-red-500 dark:text-red-400 text-xs block mb-3 font-medium">{{ $message }}</span>
                                    @enderror

                                    <input type="hidden" name="events_enabled" value="1">

                                    <div id="events-container" class="space-y-5">
                                        {{-- First event card rendered by default --}}
                                        @php $eventIdx = 0; @endphp
                                        @if(old('events'))
                                            @foreach(old('events') as $ei => $ev)
                                                <div class="event-card form-section-card relative border-t-2 border-t-primary-500 overflow-hidden space-y-4">
                                                    <input type="hidden" name="events[{{ $ei }}][id]" value="">
                                                    <div class="flex items-center justify-between pb-2 border-b border-neutral-200/60 dark:border-secondary-700/60">
                                                        <div class="flex items-center gap-2">
                                                            <div class="w-7 h-7 rounded-lg bg-primary-100 dark:bg-primary-500/15 flex items-center justify-center text-primary-600 dark:text-primary-400 border border-primary-200/50 dark:border-primary-500/30">
                                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                                </svg>
                                                            </div>
                                                            <h4 class="event-card-title font-bold text-sm text-primary-700 dark:text-primary-300">
                                                                Acara #{{ $loop->iteration }}</h4>
                                                        </div>
                                                        <div class="flex items-center gap-1">
                                                            <button type="button"
                                                                class="move-up p-1.5 text-neutral-400 dark:text-neutral-500 hover:text-neutral-700 dark:hover:text-neutral-300 hover:bg-neutral-200/60 dark:hover:bg-secondary-700 rounded-lg transition"
                                                                title="Pindah ke atas">
                                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                                                                </svg>
                                                            </button>
                                                            <button type="button"
                                                                class="move-down p-1.5 text-neutral-400 dark:text-neutral-500 hover:text-neutral-700 dark:hover:text-neutral-300 hover:bg-neutral-200/60 dark:hover:bg-secondary-700 rounded-lg transition"
                                                                title="Pindah ke bawah">
                                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                                                </svg>
                                                            </button>
                                                            <button type="button"
                                                                class="remove-event ml-1 p-1.5 text-red-400 hover:text-red-600 dark:hover:text-red-300 hover:bg-red-50 dark:hover:bg-red-950/40 rounded-lg transition"
                                                                title="Hapus acara">
                                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                                </svg>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="grid grid-cols-1 gap-y-4 gap-x-4 sm:grid-cols-6">
                                                        <div class="sm:col-span-6">
                                                            <label class="form-label-crafted">Nama Acara <span class="text-red-500">*</span></label>
                                                            <input type="text" name="events[{{ $ei }}][event_title]"
                                                                value="{{ $ev['event_title'] ?? '' }}"
                                                                list="event-titles-{{ $ei }}"
                                                                class="form-input-crafted"
                                                                placeholder="Pilih atau ketik nama acara" required>
                                                            <datalist id="event-titles-{{ $ei }}">
                                                                <option value="Akad Nikah">
                                                                <option value="Resepsi">
                                                                <option value="Pengajian">
                                                                <option value="Unduh Mantu">
                                                            </datalist>
                                                        </div>
                                                        <div class="sm:col-span-2">
                                                            <label class="form-label-crafted">Tanggal Acara <span class="text-red-500">*</span></label>
                                                            <input type="date" name="events[{{ $ei }}][event_date]"
                                                                value="{{ $ev['event_date'] ?? '' }}"
                                                                class="form-input-crafted"
                                                                required>
                                                        </div>
                                                        <div class="sm:col-span-2">
                                                            <label class="form-label-crafted">Jam Mulai <span class="text-red-500">*</span></label>
                                                            <input type="time" name="events[{{ $ei }}][start_time]"
                                                                value="{{ $ev['start_time'] ?? '' }}"
                                                                class="form-input-crafted"
                                                                required>
                                                        </div>
                                                        <div class="sm:col-span-2">
                                                            <label class="form-label-crafted">Jam Selesai</label>
                                                            <input type="time" name="events[{{ $ei }}][end_time]"
                                                                value="{{ $ev['end_time'] ?? '' }}"
                                                                class="form-input-crafted">
                                                            <div class="mt-2 flex items-center">
                                                                <input type="hidden" name="events[{{ $ei }}][is_until_finished]" value="0">
                                                                <input type="checkbox"
                                                                    name="events[{{ $ei }}][is_until_finished]" value="1" {{ !empty($ev['is_until_finished']) ? 'checked' : '' }}
                                                                    class="h-4 w-4 rounded border-neutral-300 dark:border-secondary-600 text-primary-600 dark:text-primary-400 focus:ring-primary-500/20">
                                                                <label class="ml-2 text-xs font-medium text-neutral-600 dark:text-neutral-400">Sampai Selesai</label>
                                                            </div>
                                                        </div>
                                                        <div class="sm:col-span-6">
                                                            <label class="form-label-crafted">Nama Tempat / Lokasi <span class="text-red-500">*</span></label>
                                                            <input type="text" name="events[{{ $ei }}][place_name]"
                                                                value="{{ $ev['place_name'] ?? '' }}"
                                                                class="form-input-crafted"
                                                                placeholder="Nama gedung atau lokasi" required>
                                                        </div>
                                                        <div class="sm:col-span-6">
                                                            <label class="form-label-crafted">Alamat Lengkap <span class="text-red-500">*</span></label>
                                                            <textarea name="events[{{ $ei }}][place_address]" rows="2"
                                                                class="form-input-crafted"
                                                                placeholder="Alamat lengkap lokasi"
                                                                required>{{ $ev['place_address'] ?? '' }}</textarea>
                                                        </div>
                                                        <div class="sm:col-span-6">
                                                            <label class="form-label-crafted">Link Google Maps</label>
                                                            <input type="url" name="events[{{ $ei }}][google_maps_url]"
                                                                value="{{ $ev['google_maps_url'] ?? '' }}"
                                                                class="form-input-crafted"
                                                                placeholder="https://goo.gl/maps/...">
                                                        </div>
                                                    </div>
                                                </div>
                                                @php $eventIdx = $ei + 1; @endphp
                                            @endforeach
                                        @else
                                            <div class="event-card form-section-card relative border-t-2 border-t-primary-500 overflow-hidden space-y-4">
                                                <input type="hidden" name="events[0][id]" value="">
                                                <div class="flex items-center justify-between pb-2 border-b border-neutral-200/60 dark:border-secondary-700/60">
                                                    <div class="flex items-center gap-2">
                                                        <div class="w-7 h-7 rounded-lg bg-primary-100 dark:bg-primary-500/15 flex items-center justify-center text-primary-600 dark:text-primary-400 border border-primary-200/50 dark:border-primary-500/30">
                                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                            </svg>
                                                        </div>
                                                        <h4 class="event-card-title font-bold text-sm text-primary-700 dark:text-primary-300">
                                                            Acara #1</h4>
                                                    </div>
                                                    <div class="flex items-center gap-1">
                                                        <button type="button"
                                                            class="move-up p-1.5 text-neutral-400 dark:text-neutral-500 hover:text-neutral-700 dark:hover:text-neutral-300 hover:bg-neutral-200/60 dark:hover:bg-secondary-700 rounded-lg transition"
                                                            title="Pindah ke atas">
                                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                                                            </svg>
                                                        </button>
                                                        <button type="button"
                                                            class="move-down p-1.5 text-neutral-400 dark:text-neutral-500 hover:text-neutral-700 dark:hover:text-neutral-300 hover:bg-neutral-200/60 dark:hover:bg-secondary-700 rounded-lg transition"
                                                            title="Pindah ke bawah">
                                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                                            </svg>
                                                        </button>
                                                        <button type="button"
                                                            class="remove-event ml-1 p-1.5 text-red-400 hover:text-red-600 dark:hover:text-red-300 hover:bg-red-50 dark:hover:bg-red-950/40 rounded-lg transition"
                                                            title="Hapus acara">
                                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="grid grid-cols-1 gap-y-4 gap-x-4 sm:grid-cols-6">
                                                    <div class="sm:col-span-6">
                                                        <label class="form-label-crafted">Nama Acara <span class="text-red-500">*</span></label>
                                                        <input type="text" name="events[0][event_title]" value=""
                                                            list="event-titles-0"
                                                            class="form-input-crafted"
                                                            placeholder="Pilih atau ketik nama acara" required>
                                                        <datalist id="event-titles-0">
                                                            <option value="Akad Nikah">
                                                            <option value="Resepsi">
                                                            <option value="Pengajian">
                                                            <option value="Unduh Mantu">
                                                        </datalist>
                                                    </div>
                                                    <div class="sm:col-span-2">
                                                        <label class="form-label-crafted">Tanggal Acara <span class="text-red-500">*</span></label>
                                                        <input type="date" name="events[0][event_date]" value=""
                                                            class="form-input-crafted"
                                                            required>
                                                    </div>
                                                    <div class="sm:col-span-2">
                                                        <label class="form-label-crafted">Jam Mulai <span class="text-red-500">*</span></label>
                                                        <input type="time" name="events[0][start_time]" value=""
                                                            class="form-input-crafted"
                                                            required>
                                                    </div>
                                                    <div class="sm:col-span-2">
                                                        <label class="form-label-crafted">Jam Selesai</label>
                                                        <input type="time" name="events[0][end_time]" value=""
                                                            class="form-input-crafted">
                                                        <div class="mt-2 flex items-center">
                                                            <input type="hidden" name="events[0][is_until_finished]" value="0">
                                                            <input type="checkbox" name="events[0][is_until_finished]" value="1"
                                                                class="h-4 w-4 rounded border-neutral-300 dark:border-secondary-600 text-primary-600 dark:text-primary-400 focus:ring-primary-500/20">
                                                            <label class="ml-2 text-xs font-medium text-neutral-600 dark:text-neutral-400">Sampai Selesai</label>
                                                        </div>
                                                    </div>
                                                    <div class="sm:col-span-6">
                                                        <label class="form-label-crafted">Nama Tempat / Lokasi <span class="text-red-500">*</span></label>
                                                        <input type="text" name="events[0][place_name]" value=""
                                                            class="form-input-crafted"
                                                            placeholder="Nama gedung atau lokasi" required>
                                                    </div>
                                                    <div class="sm:col-span-6">
                                                        <label class="form-label-crafted">Alamat Lengkap <span class="text-red-500">*</span></label>
                                                        <textarea name="events[0][place_address]" rows="2"
                                                            class="form-input-crafted"
                                                            placeholder="Alamat lengkap lokasi" required></textarea>
                                                    </div>
                                                    <div class="sm:col-span-6">
                                                        <label class="form-label-crafted">Link Google Maps</label>
                                                        <input type="url" name="events[0][google_maps_url]" value=""
                                                            class="form-input-crafted"
                                                            placeholder="https://goo.gl/maps/...">
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>

                                    <button type="button" id="add-event-btn"
                                        class="inline-flex items-center gap-2 px-5 py-2.5 mt-5 text-sm font-semibold rounded-xl text-primary-600 dark:text-primary-400 bg-primary-50 dark:bg-primary-500/10 border border-primary-200 dark:border-primary-500/30 hover:bg-primary-100 dark:hover:bg-primary-500/20 dark:hover:border-primary-500/50 transition-all duration-150 shadow-sm">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 4v16m8-8H4" />
                                        </svg>
                                        Tambah Acara Lain
                                    </button>

                                    {{-- Template for new event card --}}
                                    <template id="event-card-template">
                                        <div class="event-card form-section-card relative border-t-2 border-t-primary-500 overflow-hidden space-y-4">
                                            <input type="hidden" name="events[__INDEX__][id]" value="">
                                            <div class="flex items-center justify-between pb-2 border-b border-neutral-200/60 dark:border-secondary-700/60">
                                                <div class="flex items-center gap-2">
                                                    <div class="w-7 h-7 rounded-lg bg-primary-100 dark:bg-primary-500/15 flex items-center justify-center text-primary-600 dark:text-primary-400 border border-primary-200/50 dark:border-primary-500/30">
                                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                        </svg>
                                                    </div>
                                                    <h4 class="event-card-title font-bold text-sm text-primary-700 dark:text-primary-300">
                                                        Acara #__INDEX__</h4>
                                                </div>
                                                <div class="flex items-center gap-1">
                                                    <button type="button"
                                                        class="move-up p-1.5 text-neutral-400 dark:text-neutral-500 hover:text-neutral-700 dark:hover:text-neutral-300 hover:bg-neutral-200/60 dark:hover:bg-secondary-700 rounded-lg transition"
                                                        title="Pindah ke atas">
                                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                                                        </svg>
                                                    </button>
                                                    <button type="button"
                                                        class="move-down p-1.5 text-neutral-400 dark:text-neutral-500 hover:text-neutral-700 dark:hover:text-neutral-300 hover:bg-neutral-200/60 dark:hover:bg-secondary-700 rounded-lg transition"
                                                        title="Pindah ke bawah">
                                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                                        </svg>
                                                    </button>
                                                    <button type="button"
                                                        class="remove-event ml-1 p-1.5 text-red-400 hover:text-red-600 dark:hover:text-red-300 hover:bg-red-50 dark:hover:bg-red-950/40 rounded-lg transition"
                                                        title="Hapus acara">
                                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="grid grid-cols-1 gap-y-4 gap-x-4 sm:grid-cols-6">
                                                <div class="sm:col-span-6">
                                                    <label class="form-label-crafted">Nama Acara <span class="text-red-500">*</span></label>
                                                    <input type="text" name="events[__INDEX__][event_title]" value=""
                                                        list="event-titles-__INDEX__"
                                                        class="form-input-crafted"
                                                        placeholder="Pilih atau ketik nama acara" required>
                                                    <datalist id="event-titles-__INDEX__">
                                                        <option value="Akad Nikah">
                                                        <option value="Resepsi">
                                                        <option value="Pengajian">
                                                        <option value="Unduh Mantu">
                                                    </datalist>
                                                </div>
                                                <div class="sm:col-span-2">
                                                    <label class="form-label-crafted">Tanggal Acara <span class="text-red-500">*</span></label>
                                                    <input type="date" name="events[__INDEX__][event_date]" value=""
                                                        class="form-input-crafted"
                                                        required>
                                                </div>
                                                <div class="sm:col-span-2">
                                                    <label class="form-label-crafted">Jam Mulai <span class="text-red-500">*</span></label>
                                                    <input type="time" name="events[__INDEX__][start_time]" value=""
                                                        class="form-input-crafted"
                                                        required>
                                                </div>
                                                <div class="sm:col-span-2">
                                                    <label class="form-label-crafted">Jam Selesai</label>
                                                    <input type="time" name="events[__INDEX__][end_time]" value=""
                                                        class="form-input-crafted">
                                                    <div class="mt-2 flex items-center">
                                                        <input type="hidden" name="events[__INDEX__][is_until_finished]" value="0">
                                                        <input type="checkbox"
                                                            name="events[__INDEX__][is_until_finished]" value="1"
                                                            class="h-4 w-4 rounded border-neutral-300 dark:border-secondary-600 text-primary-600 dark:text-primary-400 focus:ring-primary-500/20">
                                                        <label class="ml-2 text-xs font-medium text-neutral-600 dark:text-neutral-400">Sampai Selesai</label>
                                                    </div>
                                                </div>
                                                <div class="sm:col-span-6">
                                                    <label class="form-label-crafted">Nama Tempat / Lokasi <span class="text-red-500">*</span></label>
                                                    <input type="text" name="events[__INDEX__][place_name]" value=""
                                                        class="form-input-crafted"
                                                        placeholder="Nama gedung atau lokasi" required>
                                                </div>
                                                <div class="sm:col-span-6">
                                                    <label class="form-label-crafted">Alamat Lengkap <span class="text-red-500">*</span></label>
                                                    <textarea name="events[__INDEX__][place_address]" rows="2"
                                                        class="form-input-crafted"
                                                        placeholder="Alamat lengkap lokasi" required></textarea>
                                                </div>
                                                <div class="sm:col-span-6">
                                                    <label class="form-label-crafted">Link Google Maps</label>
                                                    <input type="url" name="events[__INDEX__][google_maps_url]" value=""
                                                        class="form-input-crafted"
                                                        placeholder="https://goo.gl/maps/...">
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                </div>

                                {{-- Countdown Timer --}}
                                <div class="mt-6 form-section-card border-l-4 border-l-primary-500">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-8 h-8 rounded-xl bg-primary-100 dark:bg-primary-950/60 border border-primary-200/50 dark:border-primary-900/50 flex items-center justify-center text-primary-600 dark:text-primary-400">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <h4 class="font-bold text-sm text-secondary-900 dark:text-neutral-100">
                                                Hitung Mundur (Countdown Timer)</h4>
                                            <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-0.5">Aktif
                                                secara otomatis berdasarkan tanggal acara pertama yang Anda pilih di
                                                atas.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Required fields note --}}
                            <div class="flex items-center gap-1.5 text-xs text-neutral-400 dark:text-neutral-500 pt-2 border-t border-neutral-200/80 dark:border-secondary-700/70">
                                <span class="inline-flex items-center justify-center w-4 h-4 rounded-full bg-red-50 dark:bg-red-950/40 text-red-500 font-bold text-[10px]">*</span>
                                Kolom bertanda bintang wajib diisi sebelum menyimpan
                            </div>

                            {{-- Actions --}}
                            <div class="flex items-center justify-between pt-4">
                                <a href="{{ route('dashboard') }}"
                                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-white dark:bg-secondary-800 border border-neutral-200 dark:border-secondary-700 rounded-xl text-sm font-semibold text-neutral-600 dark:text-neutral-300 hover:bg-neutral-50 dark:hover:bg-secondary-700/80 hover:border-neutral-300 hover:text-neutral-800 dark:hover:text-neutral-100 transition-all duration-150 shadow-sm">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                    </svg>
                                    Batal
                                </a>
                                <button type="button" id="submit-btn" data-tour="publish-btn"
                                    class="inline-flex items-center gap-2 px-6 py-2.5 bg-gradient-to-r from-primary-500 to-primary-600 text-white rounded-xl shadow-md shadow-primary-500/20 text-sm font-bold hover:shadow-lg hover:shadow-primary-500/30 hover:from-primary-600 hover:to-primary-700 focus:outline-none focus:ring-4 focus:ring-primary-500/20 active:scale-[0.99] transition-all duration-200">
                                    Simpan & Lanjutkan
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Spacer for fixed bottom bar (if needed) --}}
    <div class="h-16"></div>

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

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const container = document.getElementById('events-container');

            // Timezone conversion
            var tzSelect = document.getElementById('timezone');
            if (tzSelect) {
                var tzOffsets = {
                    'Asia/Jakarta': 7,
                    'Asia/Makassar': 8,
                    'Asia/Jayapura': 9
                };
                var oldTz = tzSelect.value;

                tzSelect.addEventListener('change', function () {
                    var newTz = this.value;
                    var oldOffset = tzOffsets[oldTz] || 7;
                    var newOffset = tzOffsets[newTz] || 7;
                    var diff = newOffset - oldOffset;

                    if (diff === 0) return;

                    container.querySelectorAll('.event-card').forEach(function (card) {
                        var dateInput = card.querySelector('input[name$="[event_date]"]');
                        var startInput = card.querySelector('input[name$="[start_time]"]');
                        var endInput = card.querySelector('input[name$="[end_time]"]');

                        function convertTime(input, dateInput) {
                            if (!input || !input.value) return;
                            var parts = input.value.split(':');
                            var hours = parseInt(parts[0]);
                            var minutes = parseInt(parts[1]);
                            hours += diff;
                            if (hours >= 24) {
                                hours -= 24;
                                if (dateInput && dateInput.value) {
                                    var d = new Date(dateInput.value + 'T00:00:00');
                                    d.setDate(d.getDate() + 1);
                                    dateInput.value = d.toISOString().slice(0, 10);
                                }
                            } else if (hours < 0) {
                                hours += 24;
                                if (dateInput && dateInput.value) {
                                    var d = new Date(dateInput.value + 'T00:00:00');
                                    d.setDate(d.getDate() - 1);
                                    dateInput.value = d.toISOString().slice(0, 10);
                                }
                            }
                            input.value = String(hours).padStart(2, '0') + ':' + String(minutes).padStart(2, '0');
                        }

                        convertTime(startInput, dateInput);
                        convertTime(endInput, dateInput);
                    });

                    oldTz = newTz;
                });
            }
            const template = document.getElementById('event-card-template');
            const addBtn = document.getElementById('add-event-btn');
            let eventIndex = container ? container.children.length : 0;

            function reindexEvents() {
                const cards = container.querySelectorAll('.event-card');
                cards.forEach(function (card, idx) {
                    const inputs = card.querySelectorAll('[name]');
                    inputs.forEach(function (input) {
                        const name = input.getAttribute('name');
                        if (name) {
                            input.setAttribute('name', name.replace(/events\[\d+\]/, 'events[' + idx + ']'));
                        }
                    });
                    const datalists = card.querySelectorAll('[id^="event-titles-"]');
                    datalists.forEach(function (dl) {
                        dl.id = 'event-titles-' + idx;
                    });
                    const inputsWithList = card.querySelectorAll('[list^="event-titles-"]');
                    inputsWithList.forEach(function (inp) {
                        inp.setAttribute('list', 'event-titles-' + idx);
                    });
                    const title = card.querySelector('h4.event-card-title');
                    if (title) {
                        title.textContent = 'Acara #' + (idx + 1);
                    }
                });
            }

            function addEventCard() {
                const clone = template.content.cloneNode(true);
                const html = clone.querySelector('.event-card').outerHTML.replace(/__INDEX__/g, eventIndex);
                const wrapper = document.createElement('div');
                wrapper.innerHTML = html;
                const card = wrapper.firstElementChild;
                container.appendChild(card);
                eventIndex++;
                bindCardEvents(card);
                reindexEvents();
                if (window.initFlatpickr) window.initFlatpickr(card);
                card.scrollIntoView({ behavior: 'smooth', block: 'center' });
                const firstField = card.querySelector('input');
                if (firstField) firstField.focus({ preventScroll: true });
            }

            function removeEventCard(btn) {
                const card = btn.closest('.event-card');
                if (!card) return;
                Swal.fire({
                    title: 'Hapus Acara?',
                    text: 'Acara ini akan dihapus dari undangan.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal',
                }).then((result) => {
                    if (result.isConfirmed) {
                        card.remove();
                        reindexEvents();
                    }
                });
            }

            function moveUp(btn) {
                const card = btn.closest('.event-card');
                const prev = card ? card.previousElementSibling : null;
                if (prev) {
                    card.parentNode.insertBefore(card, prev);
                    reindexEvents();
                }
            }

            function moveDown(btn) {
                const card = btn.closest('.event-card');
                const next = card ? card.nextElementSibling : null;
                if (next) {
                    card.parentNode.insertBefore(next, card);
                    reindexEvents();
                }
            }

            function bindCardEvents(card) {
                card.querySelector('.remove-event')?.addEventListener('click', function () {
                    removeEventCard(this);
                });
                card.querySelector('.move-up')?.addEventListener('click', function () {
                    moveUp(this);
                });
                card.querySelector('.move-down')?.addEventListener('click', function () {
                    moveDown(this);
                });
            }

            container.querySelectorAll('.event-card').forEach(function (card) {
                bindCardEvents(card);
            });

            if (addBtn) {
                addBtn.addEventListener('click', addEventCard);
            }

            function getFieldLabel(field) {
                if (field.id) {
                    const label = document.querySelector('label[for="' + field.id + '"]');
                    if (label) return label.textContent.trim();
                }
                const parent = field.closest('[class*="col-span"]') || field.parentElement;
                const label = parent?.querySelector('label');
                if (label) return label.textContent.trim();
                return field.getAttribute('name') || 'Field';
            }

            function markInvalid(field) {
                if (!field) return;
                field.classList.add('field-invalid');
                ['input', 'change'].forEach(function (evt) {
                    field.addEventListener(evt, function clear() {
                        field.classList.remove('field-invalid');
                        field.removeEventListener('input', clear);
                        field.removeEventListener('change', clear);
                    });
                });
            }

            function validateForm() {
                form.querySelectorAll('.field-invalid').forEach(function (f) { f.classList.remove('field-invalid'); });

                const invalidFields = [];
                const checkedNames = new Set();

                form.querySelectorAll('input[required], select[required], textarea[required]').forEach(function (field) {
                    if (field.type === 'hidden') return;
                    if (field.disabled) return;
                    if (field.closest('.event-card') && !field.closest('.event-card').offsetParent) return;

                    const name = field.getAttribute('name') || '';
                    if (checkedNames.has(name)) return;
                    checkedNames.add(name);

                    const value = field.value.trim();
                    if (!value) {
                        invalidFields.push(field);
                        markInvalid(field);
                    }
                });

                const themeInput = form.querySelector('input[name="theme"]');
                if (themeInput && !themeInput.value.trim()) {
                    invalidFields.push(themeInput);
                }

                return invalidFields;
            }

            const submitBtn = document.getElementById('submit-btn');
            const form = submitBtn?.closest('form');

            function resetSubmitButton() {
                if (!submitBtn) return;
                submitBtn.disabled = false;
                submitBtn.classList.remove('opacity-70', 'cursor-not-allowed', 'pointer-events-none');
                submitBtn.innerHTML = 'Simpan & Lanjutkan <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" /></svg>';
            }

            function requestSubmitForm() {
                let submitted = false;
                const onFormSubmit = function (e) {
                    submitted = true;
                    form.removeEventListener('submit', onFormSubmit);
                    if (e.defaultPrevented) {
                        resetSubmitButton();
                    }
                };
                form.addEventListener('submit', onFormSubmit);
                form.requestSubmit();
                if (!submitted) {
                    resetSubmitButton();
                }
            }

            if (submitBtn && form) {
                submitBtn.addEventListener('click', function (e) {
                    e.preventDefault();
                    const invalidFields = validateForm();
                    if (invalidFields.length > 0) {
                        const list = invalidFields.map(function (f) {
                            return '<li>' + (f.getAttribute('name') === 'theme' ? 'Pilih Tema Undangan' : getFieldLabel(f)) + '</li>';
                        }).join('');
                        const firstVisible = invalidFields.find(function (f) {
                            return !(f.closest('.event-card') && !f.closest('.event-card').offsetParent);
                        }) || invalidFields[0];
                        if (firstVisible && firstVisible.type !== 'hidden') {
                            firstVisible.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        }
                        Swal.fire({
                            title: '<span class="text-lg">Form Belum Lengkap!</span>',
                            html: '<div class="text-left">' +
                                '<p class="text-sm text-neutral-600 dark:text-neutral-400 mb-3">Harap lengkapi bagian berikut sebelum menyimpan:</p>' +
                                '<ul class="list-none space-y-1.5 text-sm text-red-600 dark:text-red-400 font-medium">' + list + '</ul>' +
                                '</div>',
                            icon: 'warning',
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'Oke, lengkapi',
                            allowOutsideClick: false,
                        });
                        return;
                    }

                    const slugVal = slugInput?.value.trim();
                    if (slugVal && slugAvailable === false) {
                        Swal.fire({
                            title: 'Tautan Kustom Tidak Tersedia',
                            html: '<p class="text-sm text-neutral-600 dark:text-neutral-400">Tautan <strong class="font-mono text-red-500 dark:text-red-400">' + slugVal + '</strong> sudah digunakan oleh undangan lain. Silakan ganti dengan tautan kustom lain.</p>',
                            icon: 'warning',
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'Oke',
                        });
                        return;
                    }

                    Swal.fire({
                        title: 'Buat Undangan?',
                        text: 'Pastikan semua data sudah benar. Undangan akan dibuat dalam mode trial.',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#6b7280',
                        confirmButtonText: 'Ya, buat!',
                        cancelButtonText: 'Cek Lagi',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            submitBtn.disabled = true;
                            submitBtn.classList.add('opacity-70', 'cursor-not-allowed', 'pointer-events-none');
                            submitBtn.innerHTML = '<svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v3m6.366-.366l-2.12 2.12M21 12h-3m.366 6.366l-2.12-2.12M12 21v-3m-6.366.366l2.12-2.12M3 12h3m-.366-6.366l2.12 2.12"/></svg> Menyimpan Undangan...';
                            requestSubmitForm();
                        }
                    });
                });
            }

            const titleInput = document.getElementById('title');
            const brideNameInput = document.getElementById('bride_name');
            const groomNameInput = document.getElementById('groom_name');
            function autoGenerateTitle() {
                const bride = brideNameInput?.value.trim();
                const groom = groomNameInput?.value.trim();
                if (bride && groom) {
                    titleInput.value = 'Pernikahan ' + groom + ' & ' + bride;
                } else if (bride) {
                    titleInput.value = 'Pernikahan ' + bride;
                } else if (groom) {
                    titleInput.value = 'Pernikahan ' + groom;
                } else {
                    titleInput.value = '';
                }
            }

            // ---- Live slug check & auto-suggestion ----
            const slugInput = document.getElementById('slug-input');
            const slugIconEl = document.getElementById('slug-icon');
            const slugTextEl = document.getElementById('slug-text');
            const slugPreviewText = document.getElementById('slug-preview-text');
            const slugPreviewBox = document.getElementById('slug-preview-box');
            let slugTouched = {{ old('slug') ? 'true' : 'false' }};
            let slugCheckTimer = null;
            let slugAvailable = null;
            const slugCheckUrl = @json(route('dashboard.invitations.check-slug'));

            const SLUG_ICONS = {
                neutral: '🔗',
                loading: '<svg class="w-3.5 h-3.5 animate-spin" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 3v3m6.366-.366l-2.12 2.12M21 12h-3m.366 6.366l-2.12-2.12M12 21v-3m-6.366.366l2.12-2.12M3 12h3m-.366-6.366l2.12 2.12"/></svg>',
                success: '<svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>',
                error: '<svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>',
            };

            function setSlugStatus(kind, text) {
                const indicator = document.getElementById('slug-indicator');
                if (!indicator) return;
                slugIconEl.innerHTML = SLUG_ICONS[kind] || SLUG_ICONS.neutral;
                slugTextEl.textContent = text;
                indicator.classList.remove(
                    'text-neutral-400', 'dark:text-neutral-500',
                    'text-green-600', 'dark:text-green-400',
                    'text-red-500', 'dark:text-red-400',
                    'text-amber-500', 'dark:text-amber-400'
                );
                const colorMap = {
                    neutral: ['text-neutral-400', 'dark:text-neutral-500'],
                    success: ['text-green-600', 'dark:text-green-400'],
                    error: ['text-red-500', 'dark:text-red-400'],
                    loading: ['text-amber-500', 'dark:text-amber-400'],
                };
                indicator.classList.add(...(colorMap[kind] || colorMap.neutral));
            }

            function slugify(value) {
                return String(value || '')
                    .toLowerCase()
                    .replace(/['"]/g, '')
                    .replace(/[^a-z0-9]+/g, '-')
                    .replace(/^-+|-+$/g, '')
                    .replace(/-{2,}/g, '-');
            }

            function firstNameOf(name) {
                const parts = String(name || '').trim().split(/\s+/);
                return parts[0] || '';
            }

            function updateSlugPreview() {
                const value = slugInput.value.trim();
                if (value) {
                    slugPreviewText.textContent = value;
                    slugPreviewBox.style.display = 'block';
                } else {
                    slugPreviewBox.style.display = 'none';
                }
            }

            function suggestSlug() {
                if (slugTouched) return;
                const groom = slugify(firstNameOf(groomNameInput?.value));
                const bride = slugify(firstNameOf(brideNameInput?.value));
                const parts = [groom, bride].filter(Boolean);
                if (parts.length >= 2 && !slugInput.value.trim()) {
                    slugInput.value = parts.join('-');
                    updateSlugPreview();
                    checkSlugAvailability();
                }
            }

            function checkSlugAvailability() {
                const value = slugInput.value.trim();
                if (!value) {
                    slugAvailable = null;
                    setSlugStatus('neutral', 'Masukkan tautan kustom');
                    return;
                }
                if (!/^[a-z0-9\-]+$/.test(value)) {
                    slugAvailable = false;
                    setSlugStatus('error', 'Hanya huruf kecil (a-z), angka, dan tanda hubung (-)');
                    return;
                }
                slugAvailable = null;
                setSlugStatus('loading', 'Memeriksa ketersediaan...');
                fetch(slugCheckUrl + '?slug=' + encodeURIComponent(value), {
                    headers: { 'Accept': 'application/json' },
                    credentials: 'same-origin',
                })
                    .then(function (res) { return res.json(); })
                    .then(function (data) {
                        if (data.available) {
                            slugAvailable = true;
                            setSlugStatus('success', 'Tautan tersedia!');
                        } else {
                            slugAvailable = false;
                            setSlugStatus('error', data.message || 'Tautan sudah digunakan oleh undangan lain.');
                        }
                    })
                    .catch(function () {
                        slugAvailable = null;
                        setSlugStatus('neutral', 'Masukkan tautan kustom');
                    });
            }

            function scheduleSlugCheck() {
                clearTimeout(slugCheckTimer);
                slugCheckTimer = setTimeout(checkSlugAvailability, 350);
            }

            if (slugInput) {
                slugInput.addEventListener('input', function () {
                    slugTouched = true;
                    const sanitized = slugInput.value.toLowerCase().replace(/\s+/g, '-').replace(/[^a-z0-9-]/g, '');
                    if (sanitized !== slugInput.value) {
                        slugInput.value = sanitized;
                    }
                    updateSlugPreview();
                    scheduleSlugCheck();
                });
                slugInput.addEventListener('blur', checkSlugAvailability);
                updateSlugPreview();
            }

            brideNameInput?.addEventListener('input', function () { autoGenerateTitle(); suggestSlug(); });
            groomNameInput?.addEventListener('input', function () { autoGenerateTitle(); suggestSlug(); });
            autoGenerateTitle();

            // Mark server-side validation errors (without auto-scrolling)
            form.querySelectorAll('input, select, textarea').forEach(function (field) {
                const parent = field.parentElement;
                if (parent && parent.querySelector('span.text-red-500')) {
                    markInvalid(field);
                }
            });
        });
    </script>
</x-app-layout>