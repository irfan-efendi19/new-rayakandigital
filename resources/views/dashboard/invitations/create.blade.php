<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h2 class="font-heading text-2xl font-bold text-secondary-800 dark:text-neutral-100">
                    Buat Undangan Baru
                </h2>
                <p class="text-sm text-neutral-500 dark:text-neutral-400 mt-0.5">Lengkapi data berikut untuk membuat undangan digital Anda.</p>
            </div>
            <a href="{{ route('dashboard') }}"
                class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-neutral-600 dark:text-neutral-400 bg-white dark:bg-secondary-800 border border-neutral-300 dark:border-neutral-600 rounded-xl hover:bg-neutral-50 dark:hover:bg-secondary-700 hover:border-primary-300 transition-all">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali
            </a>
        </div>
    </x-slot>

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

    [x-cloak] { display: none !important; }

    .scrollbar-thin::-webkit-scrollbar {
        height: 6px;
    }
    .scrollbar-thin::-webkit-scrollbar-track {
        background: transparent;
    }
    .scrollbar-thin::-webkit-scrollbar-thumb {
        background-color: rgb(226, 232, 240);
        border-radius: 10px;
    }
    .dark .scrollbar-thin::-webkit-scrollbar-thumb {
        background-color: rgb(51, 65, 85);
    }
    </style>

    <div class="py-8">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-secondary-800 rounded-2xl shadow-soft border border-neutral-100 dark:border-secondary-700 overflow-hidden">
                <div class="p-6 md:p-8">
                    <form action="{{ route('dashboard.invitations.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="space-y-8">

                            {{-- ======================================== --}}
                            {{-- STEP 1: Konsep & Tema (Inisiasi) --}}
                            {{-- ======================================== --}}
                            <div class="border-b border-neutral-200 dark:border-secondary-700 pb-8">
                                <div class="flex items-center gap-3 mb-1">
                                    <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-primary-100 dark:bg-primary-900/50 text-primary-700 dark:text-primary-300 text-sm font-bold">1</span>
                                    <h3 class="font-heading text-lg font-bold text-secondary-800 dark:text-neutral-100">Konsep & Tema <span class="text-sm font-normal text-neutral-400 dark:text-neutral-500">(Inisiasi)</span></h3>
                                </div>
                                <p class="text-sm text-neutral-500 dark:text-neutral-400 mb-6">Bagian awal untuk menentukan identitas proyek dan visual dasar.</p>

                                {{-- Title --}}
                                <div>
                                    <label for="title" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Judul Undangan</label>
                                    <input type="text" name="title" id="title"
                                        class="mt-1 block w-full rounded-xl border-neutral-300 dark:border-neutral-600 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm dark:bg-secondary-700 dark:text-neutral-200"
                                        required placeholder="Contoh: The Wedding of Andi & Rara">
                                    @error('title') <span class="text-red-500 dark:text-red-400 text-xs mt-1">{{ $message }}</span> @enderror
                                </div>

                                {{-- Slug --}}
                                <div class="mt-6">
                                    <label for="slug-input" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Tautan Undangan (URL Kustom)</label>
                                    <div class="mt-1.5 flex items-stretch gap-0">
                                        <span class="inline-flex items-center px-3 rounded-l-xl border border-r-0 border-neutral-300 dark:border-neutral-600 bg-neutral-100 dark:bg-secondary-700 text-sm text-neutral-500 dark:text-neutral-400 whitespace-nowrap">{{ parse_url(config('app.url'), PHP_URL_HOST) }}/</span>
                                        <input type="text" name="slug" id="slug-input"
                                            value="{{ old('slug') }}"
                                            class="block w-full rounded-r-xl border-neutral-300 dark:border-neutral-600 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm font-mono dark:bg-secondary-700 dark:text-neutral-200"
                                            placeholder="nama-undangan-anda" maxlength="100" pattern="^[a-z0-9\-]+$">
                                    </div>
                                    <div id="slug-indicator" class="mt-1.5 text-xs flex items-center gap-1.5 text-neutral-400 dark:text-neutral-500">
                                        <span class="slug-icon">🔗</span>
                                        <span class="slug-text">Masukkan tautan kustom</span>
                                    </div>
                                    @error('slug') <span class="text-red-500 dark:text-red-400 text-xs mt-1">{{ $message }}</span> @enderror
                                    <p class="mt-1.5 text-xs text-neutral-400 dark:text-neutral-500">Huruf kecil, angka, dan tanda hubung (-). Kosongkan untuk generate otomatis.</p>
                                </div>

                                {{-- Theme Selection --}}
                                @php $currentTheme = old('theme', $selectedTheme); @endphp
                                <input type="hidden" name="theme" :value="selectedTheme" required>

                                @if(!$hasPredefinedTheme)
                                <div x-data="{ selectedTheme: '{{ $currentTheme }}' }" class="space-y-3">

                                    <div class="bg-neutral-50 dark:bg-secondary-700 p-5 rounded-2xl border border-neutral-200 dark:border-secondary-700 space-y-4">
                                        <div class="flex flex-col">
                                            <label class="text-xs font-bold text-neutral-700 dark:text-neutral-300 uppercase tracking-wider">
                                                Pilih Tema Undangan
                                            </label>
                                            <span class="text-[11px] text-neutral-400 mt-0.5">
                                                Geser horizontal untuk melihat koleksi desain premium. Klik pada kartu gambar untuk memilih tema.
                                            </span>
                                        </div>

                                        <div class="flex gap-4 overflow-x-auto py-3 px-1 scrollbar-thin scrollbar-thumb-neutral-200 dark:scrollbar-thumb-neutral-700 snap-x items-stretch">

                                        @foreach($themes as $tema)
                                            @php $themeKey = str_replace('themes.', '', $tema->view_path); @endphp
                                            <div
                                                @click="selectedTheme = '{{ $themeKey }}'"
                                                :class="{
                                                    'border-primary ring-2 ring-primary/20 shadow-md bg-primary-50 dark:bg-primary-900/20': selectedTheme === '{{ $themeKey }}',
                                                    'border-neutral-200 dark:border-neutral-600 hover:border-neutral-300 dark:hover:border-neutral-500 bg-white dark:bg-secondary-800': selectedTheme !== '{{ $themeKey }}'
                                                }"
                                                class="w-40 sm:w-48 flex-shrink-0 border rounded-2xl p-2.5 transition-all duration-200 cursor-pointer snap-start relative flex flex-col justify-between select-none"
                                            >
                                                <div x-show="selectedTheme === '{{ $themeKey }}'" class="absolute top-4 right-4 bg-primary text-white rounded-full p-1 z-10 shadow-sm" x-cloak>
                                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                                    </svg>
                                                </div>

                                                <div class="w-full aspect-[9/16] rounded-xl overflow-hidden bg-neutral-100 dark:bg-secondary-900 relative">
                                                    @if($tema->thumbnail_portrait)
                                                        <img src="{{ asset('storage/' . $tema->thumbnail_portrait) }}" class="w-full h-full object-cover" alt="Pratinjau {{ $tema->name }}">
                                                    @else
                                                        <div class="w-full h-full flex items-center justify-center text-neutral-400 text-xs">No Preview</div>
                                                    @endif
                                                </div>

                                                <div class="mt-3 space-y-1">
                                                    <span class="inline-block text-[9px] font-bold uppercase tracking-wider bg-neutral-100 dark:bg-neutral-700 text-neutral-500 dark:text-neutral-400 px-1.5 py-0.5 rounded-md">
                                                        {{ $tema->themeCategory?->name ?? 'Umum' }}
                                                    </span>

                                                    <h4 class="text-xs font-bold text-neutral-800 dark:text-neutral-100 truncate block">
                                                        {{ $tema->name }}
                                                    </h4>
                                                </div>
                                            </div>
                                        @endforeach

                                    </div>

                                    @error('theme') <span
                                        class="text-red-500 dark:text-red-400 text-xs mt-1">{{ $message }}</span>
                                    @enderror
                                </div>
                                </div>
                                @endif
                            </div>

                            {{-- ======================================== --}}
                            {{-- STEP 2: Informasi Mempelai (Profil) --}}
                            {{-- ======================================== --}}
                            <div class="border-b border-neutral-200 dark:border-secondary-700 pb-8">
                                <div class="flex items-center gap-3 mb-1">
                                    <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-primary-100 dark:bg-primary-900/50 text-primary-700 dark:text-primary-300 text-sm font-bold">2</span>
                                    <h3 class="font-heading text-lg font-bold text-secondary-800 dark:text-neutral-100">Informasi Mempelai <span class="text-sm font-normal text-neutral-400 dark:text-neutral-500">(Profil)</span></h3>
                                </div>
                                <p class="text-sm text-neutral-500 dark:text-neutral-400 mb-6">Data lengkap kedua mempelai yang akan dipasang di halaman utama.</p>

                                <div class="space-y-6">
                                    {{-- Bride --}}
                                    <div class="bg-neutral-50 dark:bg-secondary-700 p-5 rounded-2xl border border-neutral-200 dark:border-secondary-700 space-y-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-lg bg-primary-100 dark:bg-primary-900/50 flex items-center justify-center text-primary dark:text-primary-400">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                            </div>
                                            <h4 class="font-semibold text-sm text-primary-700 dark:text-primary-300">Mempelai Wanita</h4>
                                        </div>
                                        <div class="grid grid-cols-1 gap-y-5 gap-x-4 sm:grid-cols-6">
                                            <div class="sm:col-span-3">
                                                <label for="bride_name" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Nama Lengkap Mempelai Wanita</label>
                                                <input type="text" name="bride_name" id="bride_name"
                                                    value="{{ old('bride_name') }}"
                                                    class="mt-1 block w-full rounded-xl border-neutral-300 dark:border-neutral-600 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm dark:bg-secondary-700 dark:text-neutral-200"
                                                    required placeholder="Ani Suryani">
                                                @error('bride_name') <span class="text-red-500 dark:text-red-400 text-xs mt-1">{{ $message }}</span> @enderror
                                            </div>
                                            <div class="sm:col-span-3">
                                                <label for="bride_nickname" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Nama Panggilan</label>
                                                <input type="text" name="bride_nickname" id="bride_nickname"
                                                    value="{{ old('bride_nickname') }}"
                                                    class="mt-1 block w-full rounded-xl border-neutral-300 dark:border-neutral-600 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm dark:bg-secondary-700 dark:text-neutral-200"
                                                    placeholder="Ani">
                                                @error('bride_nickname') <span class="text-red-500 dark:text-red-400 text-xs mt-1">{{ $message }}</span> @enderror
                                            </div>
                                            <div class="sm:col-span-3">
                                                <label for="bride_father_name" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Nama Ayah</label>
                                                <input type="text" name="bride_father_name" id="bride_father_name"
                                                    value="{{ old('bride_father_name') }}"
                                                    class="mt-1 block w-full rounded-xl border-neutral-300 dark:border-neutral-600 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm dark:bg-secondary-700 dark:text-neutral-200"
                                                    placeholder="Nama Ayah Mempelai Wanita">
                                                @error('bride_father_name') <span class="text-red-500 dark:text-red-400 text-xs mt-1">{{ $message }}</span> @enderror
                                            </div>
                                            <div class="sm:col-span-3">
                                                <label for="bride_mother_name" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Nama Ibu</label>
                                                <input type="text" name="bride_mother_name" id="bride_mother_name"
                                                    value="{{ old('bride_mother_name') }}"
                                                    class="mt-1 block w-full rounded-xl border-neutral-300 dark:border-neutral-600 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm dark:bg-secondary-700 dark:text-neutral-200"
                                                    placeholder="Nama Ibu Mempelai Wanita">
                                                @error('bride_mother_name') <span class="text-red-500 dark:text-red-400 text-xs mt-1">{{ $message }}</span> @enderror
                                            </div>
                                            <div class="sm:col-span-6">
                                                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Foto Mempelai Wanita</label>
                                                <div class="mt-2 flex items-center gap-4">
                                                    <div class="relative flex-shrink-0">
                                                        <img id="bride-preview" src="" alt="Bride photo"
                                                            class="w-16 h-16 object-cover rounded-full border-2 border-neutral-200 dark:border-neutral-600 hidden">
                                                        <div id="bride-preview-placeholder"
                                                            class="w-16 h-16 bg-neutral-200 dark:bg-secondary-700 rounded-full flex items-center justify-center text-neutral-500 dark:text-neutral-400 text-xs font-semibold">
                                                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                            </svg>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <input type="file" name="bride_photo" id="bride_photo_input"
                                                            class="crop-file-input hidden" accept="image/*" data-preview="bride-preview">
                                                        <button type="button" data-crop-target="bride_photo_input"
                                                            class="px-4 py-2 bg-primary-50 dark:bg-primary-900/50 text-primary-700 dark:text-primary-300 rounded-xl text-sm font-semibold hover:bg-primary-100 dark:hover:bg-primary-900/70 transition">
                                                            Pilih & Crop Foto
                                                        </button>
                                                        <p class="text-xs text-neutral-400 dark:text-neutral-500 mt-1">Format gambar apa pun. Hasil potongan berbentuk persegi (1:1).</p>
                                                    </div>
                                                </div>
                                                @error('bride_photo') <span class="text-red-500 dark:text-red-400 text-xs mt-1">{{ $message }}</span> @enderror
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Groom --}}
                                    <div class="bg-neutral-50 dark:bg-secondary-700 p-5 rounded-2xl border border-neutral-200 dark:border-secondary-700 space-y-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-lg bg-primary-100 dark:bg-primary-900/50 flex items-center justify-center text-primary dark:text-primary-400">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                            </div>
                                            <h4 class="font-semibold text-sm text-primary-700 dark:text-primary-300">Mempelai Pria</h4>
                                        </div>
                                        <div class="grid grid-cols-1 gap-y-5 gap-x-4 sm:grid-cols-6">
                                            <div class="sm:col-span-3">
                                                <label for="groom_name" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Nama Lengkap Mempelai Pria</label>
                                                <input type="text" name="groom_name" id="groom_name"
                                                    value="{{ old('groom_name') }}"
                                                    class="mt-1 block w-full rounded-xl border-neutral-300 dark:border-neutral-600 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm dark:bg-secondary-700 dark:text-neutral-200"
                                                    required placeholder="Budi Santoso">
                                                @error('groom_name') <span class="text-red-500 dark:text-red-400 text-xs mt-1">{{ $message }}</span> @enderror
                                            </div>
                                            <div class="sm:col-span-3">
                                                <label for="groom_nickname" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Nama Panggilan</label>
                                                <input type="text" name="groom_nickname" id="groom_nickname"
                                                    value="{{ old('groom_nickname') }}"
                                                    class="mt-1 block w-full rounded-xl border-neutral-300 dark:border-neutral-600 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm dark:bg-secondary-700 dark:text-neutral-200"
                                                    placeholder="Budi">
                                                @error('groom_nickname') <span class="text-red-500 dark:text-red-400 text-xs mt-1">{{ $message }}</span> @enderror
                                            </div>
                                            <div class="sm:col-span-3">
                                                <label for="groom_father_name" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Nama Ayah</label>
                                                <input type="text" name="groom_father_name" id="groom_father_name"
                                                    value="{{ old('groom_father_name') }}"
                                                    class="mt-1 block w-full rounded-xl border-neutral-300 dark:border-neutral-600 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm dark:bg-secondary-700 dark:text-neutral-200"
                                                    placeholder="Nama Ayah Mempelai Pria">
                                                @error('groom_father_name') <span class="text-red-500 dark:text-red-400 text-xs mt-1">{{ $message }}</span> @enderror
                                            </div>
                                            <div class="sm:col-span-3">
                                                <label for="groom_mother_name" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Nama Ibu</label>
                                                <input type="text" name="groom_mother_name" id="groom_mother_name"
                                                    value="{{ old('groom_mother_name') }}"
                                                    class="mt-1 block w-full rounded-xl border-neutral-300 dark:border-neutral-600 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm dark:bg-secondary-700 dark:text-neutral-200"
                                                    placeholder="Nama Ibu Mempelai Pria">
                                                @error('groom_mother_name') <span class="text-red-500 dark:text-red-400 text-xs mt-1">{{ $message }}</span> @enderror
                                            </div>
                                            <div class="sm:col-span-6">
                                                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Foto Mempelai Pria</label>
                                                <div class="mt-2 flex items-center gap-4">
                                                    <div class="relative flex-shrink-0">
                                                        <img id="groom-preview" src="" alt="Groom photo"
                                                            class="w-16 h-16 object-cover rounded-full border-2 border-neutral-200 dark:border-neutral-600 hidden">
                                                        <div id="groom-preview-placeholder"
                                                            class="w-16 h-16 bg-neutral-200 dark:bg-secondary-700 rounded-full flex items-center justify-center text-neutral-500 dark:text-neutral-400 text-xs font-semibold">
                                                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                            </svg>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <input type="file" name="groom_photo" id="groom_photo_input"
                                                            class="crop-file-input hidden" accept="image/*" data-preview="groom-preview">
                                                        <button type="button" data-crop-target="groom_photo_input"
                                                            class="px-4 py-2 bg-primary-50 dark:bg-primary-900/50 text-primary-700 dark:text-primary-300 rounded-xl text-sm font-semibold hover:bg-primary-100 dark:hover:bg-primary-900/70 transition">
                                                            Pilih & Crop Foto
                                                        </button>
                                                        <p class="text-xs text-neutral-400 dark:text-neutral-500 mt-1">Format gambar apa pun. Hasil potongan berbentuk persegi (1:1).</p>
                                                    </div>
                                                </div>
                                                @error('groom_photo') <span class="text-red-500 dark:text-red-400 text-xs mt-1">{{ $message }}</span> @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- ======================================== --}}
                            {{-- STEP 3: Waktu & Tempat (Detail Acara) --}}
                            {{-- ======================================== --}}
                            <div class="border-b border-neutral-200 dark:border-secondary-700 pb-8">
                                <div class="flex items-center gap-3 mb-1">
                                    <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-primary-100 dark:bg-primary-900/50 text-primary-700 dark:text-primary-300 text-sm font-bold">3</span>
                                    <h3 class="font-heading text-lg font-bold text-secondary-800 dark:text-neutral-100">Waktu & Tempat <span class="text-sm font-normal text-neutral-400 dark:text-neutral-500">(Detail Acara)</span></h3>
                                </div>
                                <p class="text-sm text-neutral-500 dark:text-neutral-400 mb-6">Informasi krusial mengenai kapan dan di mana acara berlangsung.</p>

                                {{-- Timezone --}}
                                <div>
                                    <label for="timezone" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Zona Waktu</label>
                                    <select name="timezone" id="timezone"
                                        class="mt-1 block w-full rounded-xl border-neutral-300 dark:border-neutral-600 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm dark:bg-secondary-700 dark:text-neutral-200">
                                        <option value="Asia/Jakarta" {{ old('timezone', 'Asia/Jakarta') == 'Asia/Jakarta' ? 'selected' : '' }}>WIB (Waktu Indonesia Barat)</option>
                                        <option value="Asia/Makassar" {{ old('timezone') == 'Asia/Makassar' ? 'selected' : '' }}>WITA (Waktu Indonesia Tengah)</option>
                                        <option value="Asia/Jayapura" {{ old('timezone') == 'Asia/Jayapura' ? 'selected' : '' }}>WIT (Waktu Indonesia Timur)</option>
                                    </select>
                                    @error('timezone') <span class="text-red-500 dark:text-red-400 text-xs mt-1">{{ $message }}</span> @enderror
                                </div>

                                {{-- Events management --}}
                                <div class="mt-6">
                                    <div class="flex items-center justify-between mb-4">
                                        <h4 class="font-heading text-base font-bold text-secondary-800 dark:text-neutral-100">Manajemen Acara</h4>
                                        <button type="button" id="add-event-btn"
                                            class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-semibold rounded-xl text-primary-700 dark:text-primary-300 bg-primary-50 dark:bg-primary-900/50 hover:bg-primary-100 dark:hover:bg-primary-900/70 transition">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                            </svg>
                                            Tambah Acara
                                        </button>
                                    </div>
                                    <p class="text-sm text-neutral-500 dark:text-neutral-400 mb-4">Pengguna bisa menambah beberapa acara sekaligus (misal: Akad Nikah, Resepsi, Unduh Mantu).</p>

                                    @error('events') <span class="text-red-500 dark:text-red-400 text-xs block mb-3">{{ $message }}</span> @enderror

                                    <input type="hidden" name="events_enabled" value="1">

                                    <div id="events-container" class="space-y-4">
                                        {{-- First event card rendered by default --}}
                                        @php $eventIdx = 0; @endphp
                                        @if(old('events'))
                                            @foreach(old('events') as $ei => $ev)
                                                <div class="event-card bg-neutral-50 dark:bg-secondary-700 p-5 rounded-2xl border border-neutral-200 dark:border-secondary-700">
                                                    <input type="hidden" name="events[{{ $ei }}][id]" value="">
                                                    <div class="flex items-center justify-between mb-4">
                                                        <div class="flex items-center gap-2">
                                                            <div class="w-7 h-7 rounded-lg bg-primary-100 dark:bg-primary-900/50 flex items-center justify-center text-primary">
                                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                                </svg>
                                                            </div>
                                                            <h4 class="font-semibold text-sm text-primary-700 dark:text-primary-300">Acara #{{ $loop->iteration }}</h4>
                                                        </div>
                                                        <div class="flex items-center gap-1">
                                                            <button type="button" class="move-up p-1.5 text-neutral-400 dark:text-neutral-500 hover:text-neutral-600 dark:hover:text-neutral-400 hover:bg-neutral-200 dark:hover:bg-secondary-600 rounded-lg transition" title="Pindah ke atas">
                                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                                                                </svg>
                                                            </button>
                                                            <button type="button" class="move-down p-1.5 text-neutral-400 dark:text-neutral-500 hover:text-neutral-600 dark:hover:text-neutral-400 hover:bg-neutral-200 dark:hover:bg-secondary-600 rounded-lg transition" title="Pindah ke bawah">
                                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                                                </svg>
                                                            </button>
                                                            <button type="button" class="remove-event ml-1 p-1.5 text-red-400 dark:text-red-400 hover:text-red-600 dark:hover:text-red-300 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition" title="Hapus acara">
                                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                                </svg>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="grid grid-cols-1 gap-y-4 gap-x-4 sm:grid-cols-6">
                                                        <div class="sm:col-span-6">
                                                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Nama Acara</label>
                                                            <input type="text" name="events[{{ $ei }}][event_title]" value="{{ $ev['event_title'] ?? '' }}" list="event-titles-{{ $ei }}"
                                                                class="mt-1 block w-full rounded-xl border-neutral-300 dark:border-neutral-600 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm dark:bg-secondary-700 dark:text-neutral-200"
                                                                placeholder="Pilih atau ketik nama acara" required>
                                                            <datalist id="event-titles-{{ $ei }}">
                                                                <option value="Akad Nikah"><option value="Resepsi"><option value="Pengajian"><option value="Unduh Mantu">
                                                            </datalist>
                                                        </div>
                                                        <div class="sm:col-span-2">
                                                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Tanggal Acara</label>
                                                            <input type="date" name="events[{{ $ei }}][event_date]" value="{{ $ev['event_date'] ?? '' }}"
                                                                class="mt-1 block w-full rounded-xl border-neutral-300 dark:border-neutral-600 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm dark:bg-secondary-700 dark:text-neutral-200" required>
                                                        </div>
                                                        <div class="sm:col-span-2">
                                                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Jam Mulai</label>
                                                            <input type="time" name="events[{{ $ei }}][start_time]" value="{{ $ev['start_time'] ?? '' }}"
                                                                class="mt-1 block w-full rounded-xl border-neutral-300 dark:border-neutral-600 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm dark:bg-secondary-700 dark:text-neutral-200" required>
                                                        </div>
                                                        <div class="sm:col-span-2">
                                                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Jam Selesai</label>
                                                            <input type="time" name="events[{{ $ei }}][end_time]" value="{{ $ev['end_time'] ?? '' }}"
                                                                class="mt-1 block w-full rounded-xl border-neutral-300 dark:border-neutral-600 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm dark:bg-secondary-700 dark:text-neutral-200">
                                                            <div class="mt-1.5 flex items-center">
                                                                <input type="hidden" name="events[{{ $ei }}][is_until_finished]" value="0">
                                                                <input type="checkbox" name="events[{{ $ei }}][is_until_finished]" value="1"
                                                                    {{ !empty($ev['is_until_finished']) ? 'checked' : '' }}
                                                                    class="h-4 w-4 rounded border-neutral-300 dark:border-neutral-600 text-primary-600 dark:text-primary-400 focus:ring-primary-500">
                                                                <label class="ml-2 text-xs text-neutral-500 dark:text-neutral-400">Sampai Selesai</label>
                                                            </div>
                                                        </div>
                                                        <div class="sm:col-span-6">
                                                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Nama Tempat / Lokasi</label>
                                                            <input type="text" name="events[{{ $ei }}][place_name]" value="{{ $ev['place_name'] ?? '' }}"
                                                                class="mt-1 block w-full rounded-xl border-neutral-300 dark:border-neutral-600 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm dark:bg-secondary-700 dark:text-neutral-200"
                                                                placeholder="Nama gedung atau lokasi" required>
                                                        </div>
                                                        <div class="sm:col-span-6">
                                                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Alamat Lengkap</label>
                                                            <textarea name="events[{{ $ei }}][place_address]" rows="2"
                                                                class="mt-1 block w-full rounded-xl border-neutral-300 dark:border-neutral-600 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm dark:bg-secondary-700 dark:text-neutral-200"
                                                                placeholder="Alamat lengkap lokasi" required>{{ $ev['place_address'] ?? '' }}</textarea>
                                                        </div>
                                                        <div class="sm:col-span-6">
                                                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Link Google Maps</label>
                                                            <input type="url" name="events[{{ $ei }}][google_maps_url]" value="{{ $ev['google_maps_url'] ?? '' }}"
                                                                class="mt-1 block w-full rounded-xl border-neutral-300 dark:border-neutral-600 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm dark:bg-secondary-700 dark:text-neutral-200"
                                                                placeholder="https://goo.gl/maps/...">
                                                        </div>
                                                    </div>
                                                </div>
                                                @php $eventIdx = $ei + 1; @endphp
                                            @endforeach
                                        @else
                                            <div class="event-card bg-neutral-50 dark:bg-secondary-700 p-5 rounded-2xl border border-neutral-200 dark:border-secondary-700">
                                                <input type="hidden" name="events[0][id]" value="">
                                                <div class="flex items-center justify-between mb-4">
                                                    <div class="flex items-center gap-2">
                                                        <div class="w-7 h-7 rounded-lg bg-primary-100 dark:bg-primary-900/50 flex items-center justify-center text-primary">
                                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                            </svg>
                                                        </div>
                                                        <h4 class="font-semibold text-sm text-primary-700 dark:text-primary-300">Acara #1</h4>
                                                    </div>
                                                    <div class="flex items-center gap-1">
                                                        <button type="button" class="move-up p-1.5 text-neutral-400 dark:text-neutral-500 hover:text-neutral-600 dark:hover:text-neutral-400 hover:bg-neutral-200 dark:hover:bg-secondary-600 rounded-lg transition" title="Pindah ke atas">
                                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                                                            </svg>
                                                        </button>
                                                        <button type="button" class="move-down p-1.5 text-neutral-400 dark:text-neutral-500 hover:text-neutral-600 dark:hover:text-neutral-400 hover:bg-neutral-200 dark:hover:bg-secondary-600 rounded-lg transition" title="Pindah ke bawah">
                                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                                            </svg>
                                                        </button>
                                                        <button type="button" class="remove-event ml-1 p-1.5 text-red-400 dark:text-red-400 hover:text-red-600 dark:hover:text-red-300 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition" title="Hapus acara">
                                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="grid grid-cols-1 gap-y-4 gap-x-4 sm:grid-cols-6">
                                                    <div class="sm:col-span-6">
                                                        <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Nama Acara</label>
                                                        <input type="text" name="events[0][event_title]" value="" list="event-titles-0"
                                                            class="mt-1 block w-full rounded-xl border-neutral-300 dark:border-neutral-600 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm dark:bg-secondary-700 dark:text-neutral-200"
                                                            placeholder="Pilih atau ketik nama acara" required>
                                                        <datalist id="event-titles-0">
                                                            <option value="Akad Nikah"><option value="Resepsi"><option value="Pengajian"><option value="Unduh Mantu">
                                                        </datalist>
                                                    </div>
                                                    <div class="sm:col-span-2">
                                                        <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Tanggal Acara</label>
                                                        <input type="date" name="events[0][event_date]" value=""
                                                            class="mt-1 block w-full rounded-xl border-neutral-300 dark:border-neutral-600 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm dark:bg-secondary-700 dark:text-neutral-200" required>
                                                    </div>
                                                    <div class="sm:col-span-2">
                                                        <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Jam Mulai</label>
                                                        <input type="time" name="events[0][start_time]" value=""
                                                            class="mt-1 block w-full rounded-xl border-neutral-300 dark:border-neutral-600 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm dark:bg-secondary-700 dark:text-neutral-200" required>
                                                    </div>
                                                    <div class="sm:col-span-2">
                                                        <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Jam Selesai</label>
                                                        <input type="time" name="events[0][end_time]" value=""
                                                            class="mt-1 block w-full rounded-xl border-neutral-300 dark:border-neutral-600 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm dark:bg-secondary-700 dark:text-neutral-200">
                                                        <div class="mt-1.5 flex items-center">
                                                            <input type="hidden" name="events[0][is_until_finished]" value="0">
                                                            <input type="checkbox" name="events[0][is_until_finished]" value="1"
                                                                class="h-4 w-4 rounded border-neutral-300 dark:border-neutral-600 text-primary-600 dark:text-primary-400 focus:ring-primary-500">
                                                            <label class="ml-2 text-xs text-neutral-500 dark:text-neutral-400">Sampai Selesai</label>
                                                        </div>
                                                    </div>
                                                    <div class="sm:col-span-6">
                                                        <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Nama Tempat / Lokasi</label>
                                                        <input type="text" name="events[0][place_name]" value=""
                                                            class="mt-1 block w-full rounded-xl border-neutral-300 dark:border-neutral-600 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm dark:bg-secondary-700 dark:text-neutral-200"
                                                            placeholder="Nama gedung atau lokasi" required>
                                                    </div>
                                                    <div class="sm:col-span-6">
                                                        <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Alamat Lengkap</label>
                                                        <textarea name="events[0][place_address]" rows="2"
                                                            class="mt-1 block w-full rounded-xl border-neutral-300 dark:border-neutral-600 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm dark:bg-secondary-700 dark:text-neutral-200"
                                                            placeholder="Alamat lengkap lokasi" required></textarea>
                                                    </div>
                                                    <div class="sm:col-span-6">
                                                        <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Link Google Maps</label>
                                                        <input type="url" name="events[0][google_maps_url]" value=""
                                                            class="mt-1 block w-full rounded-xl border-neutral-300 dark:border-neutral-600 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm dark:bg-secondary-700 dark:text-neutral-200"
                                                            placeholder="https://goo.gl/maps/...">
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>

                                    {{-- Template for new event card --}}
                                    <template id="event-card-template">
                                        <div class="event-card bg-neutral-50 dark:bg-secondary-700 p-5 rounded-2xl border border-neutral-200 dark:border-secondary-700">
                                            <input type="hidden" name="events[__INDEX__][id]" value="">
                                            <div class="flex items-center justify-between mb-4">
                                                <div class="flex items-center gap-2">
                                                    <div class="w-7 h-7 rounded-lg bg-primary-100 dark:bg-primary-900/50 flex items-center justify-center text-primary">
                                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                        </svg>
                                                    </div>
                                                    <h4 class="font-semibold text-sm text-primary-700 dark:text-primary-300">Acara Baru</h4>
                                                </div>
                                                <div class="flex items-center gap-1">
                                                    <button type="button" class="move-up p-1.5 text-neutral-400 dark:text-neutral-500 hover:text-neutral-600 dark:hover:text-neutral-400 hover:bg-neutral-200 dark:hover:bg-secondary-600 rounded-lg transition" title="Pindah ke atas">
                                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                                                        </svg>
                                                    </button>
                                                    <button type="button" class="move-down p-1.5 text-neutral-400 dark:text-neutral-500 hover:text-neutral-600 dark:hover:text-neutral-400 hover:bg-neutral-200 dark:hover:bg-secondary-600 rounded-lg transition" title="Pindah ke bawah">
                                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                                        </svg>
                                                    </button>
                                                    <button type="button" class="remove-event ml-1 p-1.5 text-red-400 dark:text-red-400 hover:text-red-600 dark:hover:text-red-300 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition" title="Hapus acara">
                                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="grid grid-cols-1 gap-y-4 gap-x-4 sm:grid-cols-6">
                                                <div class="sm:col-span-6">
                                                    <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Nama Acara</label>
                                                    <input type="text" name="events[__INDEX__][event_title]" value="" list="event-titles-__INDEX__"
                                                        class="mt-1 block w-full rounded-xl border-neutral-300 dark:border-neutral-600 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm dark:bg-secondary-700 dark:text-neutral-200"
                                                        placeholder="Pilih atau ketik nama acara" required>
                                                    <datalist id="event-titles-__INDEX__">
                                                        <option value="Akad Nikah"><option value="Resepsi"><option value="Pengajian"><option value="Unduh Mantu">
                                                    </datalist>
                                                </div>
                                                <div class="sm:col-span-2">
                                                    <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Tanggal Acara</label>
                                                    <input type="date" name="events[__INDEX__][event_date]" value=""
                                                        class="mt-1 block w-full rounded-xl border-neutral-300 dark:border-neutral-600 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm dark:bg-secondary-700 dark:text-neutral-200" required>
                                                </div>
                                                <div class="sm:col-span-2">
                                                    <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Jam Mulai</label>
                                                    <input type="time" name="events[__INDEX__][start_time]" value=""
                                                        class="mt-1 block w-full rounded-xl border-neutral-300 dark:border-neutral-600 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm dark:bg-secondary-700 dark:text-neutral-200" required>
                                                </div>
                                                <div class="sm:col-span-2">
                                                    <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Jam Selesai</label>
                                                    <input type="time" name="events[__INDEX__][end_time]" value=""
                                                        class="mt-1 block w-full rounded-xl border-neutral-300 dark:border-neutral-600 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm dark:bg-secondary-700 dark:text-neutral-200">
                                                    <div class="mt-1.5 flex items-center">
                                                        <input type="hidden" name="events[__INDEX__][is_until_finished]" value="0">
                                                        <input type="checkbox" name="events[__INDEX__][is_until_finished]" value="1"
                                                            class="h-4 w-4 rounded border-neutral-300 dark:border-neutral-600 text-primary-600 dark:text-primary-400 focus:ring-primary-500">
                                                        <label class="ml-2 text-xs text-neutral-500 dark:text-neutral-400">Sampai Selesai</label>
                                                    </div>
                                                </div>
                                                <div class="sm:col-span-6">
                                                    <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Nama Tempat / Lokasi</label>
                                                    <input type="text" name="events[__INDEX__][place_name]" value=""
                                                        class="mt-1 block w-full rounded-xl border-neutral-300 dark:border-neutral-600 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm dark:bg-secondary-700 dark:text-neutral-200"
                                                        placeholder="Nama gedung atau lokasi" required>
                                                </div>
                                                <div class="sm:col-span-6">
                                                    <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Alamat Lengkap</label>
                                                    <textarea name="events[__INDEX__][place_address]" rows="2"
                                                        class="mt-1 block w-full rounded-xl border-neutral-300 dark:border-neutral-600 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm dark:bg-secondary-700 dark:text-neutral-200"
                                                        placeholder="Alamat lengkap lokasi" required></textarea>
                                                </div>
                                                <div class="sm:col-span-6">
                                                    <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Link Google Maps</label>
                                                    <input type="url" name="events[__INDEX__][google_maps_url]" value=""
                                                        class="mt-1 block w-full rounded-xl border-neutral-300 dark:border-neutral-600 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm dark:bg-secondary-700 dark:text-neutral-200"
                                                        placeholder="https://goo.gl/maps/...">
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                </div>

                                {{-- Countdown Timer --}}
                                <div class="mt-6 bg-neutral-50 dark:bg-secondary-700 p-5 rounded-2xl border border-neutral-200 dark:border-secondary-700">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-lg bg-primary-100 dark:bg-primary-900/50 flex items-center justify-center text-primary">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <h4 class="font-semibold text-sm text-primary-700 dark:text-primary-300">Hitung Mundur (Countdown Timer)</h4>
                                            <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-0.5">Aktif secara otomatis berdasarkan tanggal acara pertama yang Anda pilih di atas.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Actions --}}
                            <div class="flex items-center justify-between pt-2">
                                <a href="{{ route('dashboard') }}"
                                    class="inline-flex items-center px-5 py-2.5 bg-white dark:bg-secondary-800 border border-neutral-300 dark:border-secondary-600 rounded-xl shadow-sm text-sm font-semibold text-neutral-700 dark:text-neutral-300 hover:bg-neutral-50 dark:hover:bg-secondary-700 hover:border-primary-300 transition-all">
                                    <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                    </svg>
                                    Batal
                                </a>
                                <button type="button" id="submit-btn"
                                    class="inline-flex items-center gap-2 px-6 py-2.5 bg-gradient-to-r from-primary to-primary-600 rounded-xl shadow-sm text-sm font-semibold text-white hover:shadow-md hover:scale-[1.02] active:scale-[0.98] focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition-all">
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
    <div id="crop-modal" class="hidden fixed inset-0 z-50 bg-black/60 items-center justify-center p-4 overflow-y-auto">
        <div class="bg-white dark:bg-secondary-800 rounded-2xl shadow-2xl w-full max-w-lg overflow-hidden my-8">
            <div class="p-4 border-b border-neutral-100 dark:border-secondary-700 flex items-center justify-between">
                <h3 class="text-lg font-semibold text-secondary-800 dark:text-neutral-100">Crop Foto</h3>
                <button type="button"
                    class="crop-close text-neutral-400 dark:text-neutral-500 hover:text-neutral-600 dark:hover:text-neutral-400 transition">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="p-4 bg-secondary-900" style="height:400px">
                <div id="crop-container" class="w-full mx-auto" style="max-width:500px;overflow:hidden">
                </div>
            </div>
            <div class="p-4 border-t border-neutral-100 dark:border-secondary-700">
                <div class="flex items-center justify-center gap-3 mb-4">
                    <button type="button" id="crop-zoom-out"
                        class="p-2 rounded-xl bg-neutral-100 dark:bg-secondary-700 hover:bg-neutral-200 dark:hover:bg-secondary-600 text-neutral-700 dark:text-neutral-300 transition"
                        title="Perkecil">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                        </svg>
                    </button>
                    <button type="button" id="crop-zoom-in"
                        class="p-2 rounded-xl bg-neutral-100 dark:bg-secondary-700 hover:bg-neutral-200 dark:hover:bg-secondary-600 text-neutral-700 dark:text-neutral-300 transition"
                        title="Perbesar">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                    </button>
                    <button type="button" id="crop-rotate"
                        class="p-2 rounded-xl bg-neutral-100 dark:bg-secondary-700 hover:bg-neutral-200 dark:hover:bg-secondary-600 text-neutral-700 dark:text-neutral-300 transition"
                        title="Rotate">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                    </button>
                </div>
                <div class="flex gap-3">
                    <button type="button"
                        class="crop-close flex-1 px-4 py-2.5 border border-neutral-300 dark:border-neutral-600 rounded-xl text-sm font-semibold text-neutral-700 dark:text-neutral-300 hover:bg-neutral-50 dark:hover:bg-secondary-700 transition">
                        Batal
                    </button>
                    <button type="button" id="crop-save"
                        class="flex-1 px-4 py-2.5 bg-gradient-to-r from-primary to-primary-600 text-white rounded-xl text-sm font-semibold hover:shadow-md transition-all">
                        Simpan
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const container = document.getElementById('events-container');
        const template = document.getElementById('event-card-template');
        const addBtn = document.getElementById('add-event-btn');
        let eventIndex = container ? container.children.length : 0;

        function reindexEvents() {
            const cards = container.querySelectorAll('.event-card');
            cards.forEach(function(card, idx) {
                const inputs = card.querySelectorAll('[name]');
                inputs.forEach(function(input) {
                    const name = input.getAttribute('name');
                    if (name) {
                        input.setAttribute('name', name.replace(/events\[\d+\]/, 'events[' + idx + ']'));
                    }
                });
                const datalists = card.querySelectorAll('[id^="event-titles-"]');
                datalists.forEach(function(dl) {
                    dl.id = 'event-titles-' + idx;
                });
                const inputsWithList = card.querySelectorAll('[list^="event-titles-"]');
                inputsWithList.forEach(function(inp) {
                    inp.setAttribute('list', 'event-titles-' + idx);
                });
                const title = card.querySelector('h4.font-semibold');
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
            card.querySelector('.remove-event')?.addEventListener('click', function() {
                removeEventCard(this);
            });
            card.querySelector('.move-up')?.addEventListener('click', function() {
                moveUp(this);
            });
            card.querySelector('.move-down')?.addEventListener('click', function() {
                moveDown(this);
            });
        }

        container.querySelectorAll('.event-card').forEach(function(card) {
            bindCardEvents(card);
        });

        if (addBtn) {
            addBtn.addEventListener('click', addEventCard);
        }

        const submitBtn = document.getElementById('submit-btn');
        const form = submitBtn?.closest('form');
        if (submitBtn && form) {
            submitBtn.addEventListener('click', function(e) {
                e.preventDefault();
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
                        form.requestSubmit();
                    }
                });
            });
        }
    });
    </script>
</x-app-layout>
