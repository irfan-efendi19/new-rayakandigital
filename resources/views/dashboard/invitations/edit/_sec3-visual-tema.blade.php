{{-- ======================================== --}}
                            {{-- Section 3: Visual & Estetika --}}
                            {{-- ======================================== --}}
                            <div id="sec-3"
                                x-show="activeSection === 'sec-3'"
                                x-transition:enter="transition ease-out duration-300"
                                x-transition:enter-start="opacity-0 translate-x-4"
                                x-transition:enter-end="opacity-100 translate-x-0"
                                class="scroll-mt-32"
                                data-tour="layar-sapa-config"
                                x-cloak>
                                <div class="mb-3">
                                    <h3 class="font-heading text-lg font-bold text-secondary-800 dark:text-neutral-100">
                                        Visual & Estetika <span class="text-sm font-normal text-neutral-400 dark:text-neutral-500">(Foto & Tema)</span>
                                    </h3>
                                </div>
                                <p class="text-sm text-neutral-500 dark:text-neutral-400 mb-6">
                                    Atur tampilan visual
                                    undangan, foto sampul, tema, dan
                                    musik latar.</p>

                                {{-- Cover Photo --}}
                                <div data-tour="cover-photo">
                                    <h4
                                        class="font-heading text-base font-bold text-secondary-800 dark:text-neutral-100 mb-1">
                                        Foto Sampul</h4>
                                    <p class="text-sm text-neutral-500 dark:text-neutral-400 mb-4">
                                        Foto sampul akan
                                        ditampilkan di kartu undangan
                                        dashboard. Rasio 9:16
                                        (portrait).</p>

                                    <div
                                        class="bg-neutral-50 dark:bg-secondary-700 p-5 rounded-2xl border border-neutral-200 dark:border-secondary-700 space-y-4">
                                        <div>
                                            <label
                                                class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Foto
                                                Sampul</label>
                                            <div class="mt-2 flex flex-col sm:flex-row items-start gap-4">
                                                <div class="relative flex-shrink-0 w-full sm:w-48 max-w-[180px] sm:max-w-none">
                                                    <div class="rounded-xl overflow-hidden border-2 border-neutral-200 dark:border-neutral-600"
                                                        style="aspect-ratio:9/16">
                                                        <img id="cover-preview"
                                                            src="{{ $invitation->cover_photo ? asset('storage/' . $invitation->cover_photo) : '' }}"
                                                            alt="Cover photo"
                                                            class="w-full h-full object-cover {{ $invitation->cover_photo ? '' : 'hidden' }}">
                                                        <div id="cover-preview-placeholder"
                                                            class="w-full h-full bg-neutral-200 dark:bg-secondary-700 flex flex-col items-center justify-center text-neutral-500 dark:text-neutral-400 text-xs font-semibold {{ $invitation->cover_photo ? 'hidden' : '' }}">
                                                            <svg class="w-8 h-8 mb-1" fill="none" viewBox="0 0 24 24"
                                                                stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="1.5"
                                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                            </svg>
                                                            <span>Belum
                                                                ada</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div>
                                                    <input type="file" name="cover_photo" id="cover_photo_input"
                                                        class="crop-file-input hidden" accept="image/*"
                                                        data-preview="cover-preview" data-aspect-ratio="9/16"
                                                        data-width="360" data-height="640"
                                                        data-title="Foto Sampul (Cover)">
                                                    <button type="button" data-crop-target="cover_photo_input"
                                                        class="px-4 py-2 bg-primary-50 dark:bg-primary-900/50 text-primary-700 dark:text-primary-300 rounded-xl text-sm font-semibold hover:bg-primary-100 dark:hover:bg-primary-900/70 transition">
                                                        Pilih & Crop Foto
                                                    </button>
                                                    <p class="text-xs text-neutral-400 dark:text-neutral-500 mt-1">
                                                        Format
                                                        gambar apa pun.
                                                        Hasil potongan rasio
                                                        9:16
                                                        portrait.</p>
                                                    @error('cover_photo')
                                                        <span
                                                            class="text-red-500 dark:text-red-400 text-xs mt-1">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @if($invitation->hasFeature('youtube_video'))
                                    <div data-tour="youtube-video"
                                        class="mt-4 bg-neutral-50 dark:bg-secondary-700 p-5 rounded-2xl border border-neutral-200 dark:border-secondary-700 space-y-4">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-8 h-8 rounded-lg bg-primary-100 dark:bg-primary-900/50 flex items-center justify-center text-primary">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                            <h4 class="font-semibold text-sm text-primary-700 dark:text-primary-300">
                                                Video
                                                YouTube & Live Streaming
                                            </h4>
                                        </div>
                                        <div>
                                            <label for="youtube_url"
                                                class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Tautan
                                                Video YouTube</label>
                                            <input type="url" name="youtube_url" id="youtube_url"
                                                value="{{ old('youtube_url', $invitation->youtube_url) }}"
                                                class="mt-1 block w-full rounded-xl border-neutral-300 dark:border-neutral-600 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm dark:bg-secondary-700 dark:text-neutral-200"
                                                placeholder="https://youtube.com/watch?v=... atau https://youtu.be/...">
                                            <p class="text-xs text-neutral-400 dark:text-neutral-500 mt-1.5">
                                                Masukkan URL
                                                video YouTube atau siaran
                                                langsung (live streaming).
                                                Mendukung format <span class="font-mono">youtube.com/watch?v=</span>,
                                                <span class="font-mono">youtu.be/</span>,
                                                <span class="font-mono">youtube.com/live/</span>.
                                            </p>
                                            @error('youtube_url') <span
                                                class="text-red-500 dark:text-red-400 text-xs mt-1">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        @if($invitation->youtube_video_id)
                                            <div
                                                class="bg-primary-50 dark:bg-primary-900/50 border border-primary-100 dark:border-primary-800/50 rounded-xl p-3 flex items-center gap-3">
                                                <span class="text-primary flex-shrink-0">
                                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                                                </span>
                                                <div>
                                                    <p class="text-xs font-semibold text-primary-700 dark:text-primary-300">
                                                        Video Terdeteksi</p>
                                                    <p class="text-xs text-primary-600 dark:text-primary-400">
                                                        ID:
                                                        {{ $invitation->youtube_video_id }}
                                                    </p>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                @else
                                     <div
                                         class="mt-4 bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-2xl p-5 flex flex-col sm:flex-row sm:items-center gap-3">
                                         <span class="text-amber-500 flex-shrink-0">
                                             <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                         </span>
                                         <div>
                                             <p class="text-sm font-semibold text-amber-800 dark:text-amber-300">
                                                 Fitur Video
                                                 YouTube & Live Streaming
                                                 Terkunci</p>
                                             <p class="text-xs text-amber-700 dark:text-amber-400">
                                                 Silakan upgrade ke paket
                                                 Gold atau Platinum untuk
                                                 menyematkan video YouTube
                                                 dan siaran langsung di
                                                 halaman undangan Anda.</p>
                                         </div>
                                     </div>
                                 @endif

                                 {{-- Galeri Foto --}}
                                @php $galleryLocked =
                                    !$invitation->hasFeature('gallery_photos');
                                @endphp
                                <div data-tour="gallery-photos"
                                    class="mt-4 bg-neutral-50 dark:bg-secondary-700 p-5 rounded-2xl border border-neutral-200 dark:border-secondary-700 space-y-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-8 h-8 rounded-lg bg-primary-100 dark:bg-primary-900/50 flex items-center justify-center text-primary">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        <h4 class="font-semibold text-sm text-primary-700 dark:text-primary-300">
                                            Galeri
                                            Foto</h4>
                                        @if(!$galleryLocked)
                                            <span
                                                class="ml-auto text-xs text-neutral-500 dark:text-neutral-400 font-semibold">{{ count($invitation->gallery_photos ?? []) }}
                                                /
                                                {{ $invitation->maxGalleryPhotos() }}
                                                Foto</span>
                                        @endif
                                    </div>

                                    @if(!$galleryLocked)
                                        <div class="space-y-6">
                                            <div id="gallery-upload-form" class="space-y-4">
                                                <div id="gallery-dropzone"
                                                    class="relative border-2 border-dashed border-primary-300 dark:border-primary-700 rounded-2xl p-6 text-center cursor-pointer hover:border-primary-400 dark:hover:border-primary-500 hover:bg-primary-50/50 dark:hover:bg-primary-900/20 transition-all duration-200">
                                                    <input type="file" name="photos[]" id="gallery-file-input" multiple
                                                        accept="image/*" class="hidden">
                                                    <div id="dropzone-empty" class="space-y-2">
                                                        <div
                                                            class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-primary-100 dark:bg-primary-900/50 text-primary-600 dark:text-primary-400">
                                                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                                                                stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                                            </svg>
                                                        </div>
                                                        <p
                                                            class="text-sm font-medium text-neutral-700 dark:text-neutral-300">
                                                            Seret foto ke
                                                            sini atau <span
                                                                class="text-primary-600 dark:text-primary-400 underline">klik
                                                                untuk
                                                                memilih</span>
                                                        </p>
                                                        <p class="text-xs text-neutral-400 dark:text-neutral-500">
                                                            Format
                                                            gambar apa pun.
                                                            Akan dikonversi
                                                            ke WebP
                                                            otomatis.</p>
                                                        <p
                                                            class="inline-flex items-center gap-1.5 text-xs font-medium text-primary-600 dark:text-primary-400">
                                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"
                                                                stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M13 5l7 7-7 7M5 5l7 7-7 7" />
                                                            </svg>
                                                            Foto terunggah
                                                            otomatis
                                                            setelah
                                                            dipilih.</p>
                                                    </div>
                                                    <div id="dropzone-preview" class="hidden space-y-3">
                                                        <div id="preview-thumbnails"
                                                            class="flex flex-wrap gap-2 justify-center max-h-48 overflow-y-auto">
                                                        </div>
                                                        <div
                                                            class="flex items-center justify-center gap-2 text-sm text-neutral-500 dark:text-neutral-400">
                                                            <span id="file-count"></span>
                                                        </div>
                                                        <div id="upload-status"
                                                            class="hidden items-center justify-center gap-2 text-sm font-medium text-primary-600 dark:text-primary-400">
                                                            <svg class="w-4 h-4 animate-spin" fill="none"
                                                                viewBox="0 0 24 24">
                                                                <circle class="opacity-25" cx="12" cy="12" r="10"
                                                                    stroke="currentColor" stroke-width="4"></circle>
                                                                <path class="opacity-75" fill="currentColor"
                                                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                                            </svg>
                                                            <span>Mengunggah foto...</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="flex items-center justify-end gap-3">
                                                    <span id="dropzone-error"
                                                        class="text-xs text-red-500 dark:text-red-400 hidden"></span>
                                                </div>
                                            </div>

                                            @if(empty($invitation->gallery_photos))
                                                <p class="text-neutral-500 dark:text-neutral-400 text-center py-4 text-sm">
                                                    Belum
                                                    ada foto galeri.</p>
                                            @else
                                                <div class="grid grid-cols-3 sm:grid-cols-4 gap-3">
                                                    @foreach($invitation->gallery_photos as $index => $photo)
                                                        <div
                                                            class="relative group aspect-square rounded-xl overflow-hidden border border-neutral-100 dark:border-secondary-700 bg-neutral-50 dark:bg-secondary-700">
                                                            <img src="{{ asset('storage/' . $photo) }}" alt="Gallery photo"
                                                                class="w-full h-full object-cover">
                                                            <div
                                                                class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                                                <button type="button"
                                                                    class="delete-photo-btn bg-red-600 hover:bg-red-700 text-white rounded-full p-1.5 shadow-md transition-all"
                                                                    data-index="{{ $index }}">
                                                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                                                        stroke="currentColor">
                                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                                            stroke-width="2"
                                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                                    </svg>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    @else
                                        <div class="text-center py-6">
                                            <div
                                                class="w-12 h-12 mx-auto rounded-2xl bg-amber-100 dark:bg-amber-900/20 flex items-center justify-center">
                                                <svg class="w-6 h-6 text-amber-500 dark:text-amber-400" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                                </svg>
                                            </div>
                                            <p class="mt-2 text-sm font-semibold text-amber-800 dark:text-amber-300">
                                                Fitur
                                                Galeri Foto Terkunci</p>
                                            <p class="mt-1 text-xs text-amber-700 dark:text-amber-400">
                                                Upgrade paket Anda
                                                untuk menampilkan galeri
                                                 foto.</p>
                                        </div>
                                    @endif

                                 </div>

                                {{-- Music --}}
                                <div data-tour="music-background" class="mt-6">
                                    <label
                                        class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Musik
                                        Latar Belakang</label>

                                    @if($invitation->canUseCustomMusic())
                                        <div class="mt-3 space-y-3">
                                            <div
                                                class="bg-white dark:bg-secondary-800 rounded-xl border border-neutral-200 dark:border-neutral-700 divide-y divide-neutral-100 dark:divide-neutral-700">
                                                <label
                                                    class="flex items-center gap-3 p-4 cursor-pointer hover:bg-neutral-50 dark:hover:bg-secondary-700/50 transition-all rounded-t-xl {{ !$invitation->use_custom_music ? 'bg-primary-50 dark:bg-primary-900/20 border-l-2 border-l-primary' : '' }}">
                                                    <input type="radio" name="use_custom_music" value="0"
                                                        class="h-4 w-4 text-primary focus:ring-primary-500"
                                                        {{ !$invitation->use_custom_music ? 'checked' : '' }}>
                                                    <div>
                                                        <span class="text-sm font-semibold text-secondary-800 dark:text-neutral-200">Gunakan Musik Bawaan Tema</span>
                                                        <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-0.5">Putar musik default dari tema yang dipilih</p>
                                                    </div>
                                                </label>
                                                <label
                                                    class="flex items-center gap-3 p-4 cursor-pointer hover:bg-neutral-50 dark:hover:bg-secondary-700/50 transition-all rounded-b-xl {{ $invitation->use_custom_music ? 'bg-primary-50 dark:bg-primary-900/20 border-l-2 border-l-primary' : '' }}">
                                                    <input type="radio" name="use_custom_music" value="1"
                                                        class="h-4 w-4 text-primary focus:ring-primary-500"
                                                        {{ $invitation->use_custom_music ? 'checked' : '' }}>
                                                    <div>
                                                        <span class="text-sm font-semibold text-secondary-800 dark:text-neutral-200">Gunakan Lagu Sendiri</span>
                                                        <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-0.5">Unggah file MP3/audio dari perangkat Anda</p>
                                                    </div>
                                                </label>
                                            </div>

                                            <div class="ml-7 pl-4 border-l-2 border-primary/30 dark:border-primary-700/50 space-y-3">
                                                @if($invitation->custom_music)
                                                    <div
                                                        class="flex items-center gap-3 bg-neutral-50 dark:bg-secondary-700 p-3 rounded-xl border border-neutral-200 dark:border-secondary-600">
                                                        <span class="text-xs font-semibold text-neutral-700 dark:text-neutral-300">Musik Aktif:</span>
                                                        <audio src="{{ asset('storage/' . $invitation->custom_music) }}" controls
                                                            class="h-8 max-w-xs"></audio>
                                                    </div>
                                                @endif
                                                <input type="file" name="music_file" id="music_file" accept=".mp3,.wav,.ogg"
                                                    class="text-sm text-neutral-500 dark:text-neutral-400 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-primary-50 dark:file:bg-primary-900/50 file:text-primary-700 dark:file:text-primary-300 hover:file:bg-primary-100 dark:hover:file:bg-primary-900/70">
                                                <p class="text-xs text-neutral-500 dark:text-neutral-400">
                                                    Format: MP3, WAV, OGG. Maks 10MB.</p>
                                            </div>
                                        </div>
                                    @else
                                        <div
                                            class="mt-2 bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-xl p-4 flex flex-col sm:flex-row sm:items-center gap-3">
                                            <span class="text-amber-500 flex-shrink-0">
                                             <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                         </span>
                                            <div>
                                                <p class="text-sm font-semibold text-amber-800 dark:text-amber-300">
                                                    Fitur Kustom Musik Terkunci</p>
                                                <p class="text-xs text-amber-700 dark:text-amber-400">
                                                    Upgrade ke Gold atau Platinum untuk upload musik sendiri.</p>
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                {{-- Theme Selection --}}
                                @php $currentTheme = old(
                                    'theme',
                                    $invitation->theme
                                ); @endphp
                                <div x-data="{ selectedTheme: '{{ $currentTheme }}' }" class="mt-6 space-y-3" data-tour="select-theme">

                                    <input type="hidden" name="theme" :value="selectedTheme" required>

                                    <div class="flex flex-col">
                                        <label
                                            class="text-xs font-bold text-neutral-700 dark:text-neutral-300 uppercase tracking-wider">
                                            Pilihan Tema Visual Undangan
                                        </label>
                                        <span class="text-[11px] text-neutral-400 mt-0.5">
                                            Geser horizontal untuk
                                            melihat koleksi desain
                                            premium. Klik pada kartu
                                            gambar untuk memilih tema
                                            aktif.
                                        </span>
                                    </div>

                                    <div
                                        class="flex gap-4 overflow-x-auto py-3 px-1 scrollbar-thin scrollbar-thumb-neutral-200 dark:scrollbar-thumb-neutral-700 snap-x items-stretch">

                                        @foreach($themes as $tema)
                                            @php $themeKey = str_replace(
                                                'themes.',
                                                '',
                                                $tema->view_path
                                            ); @endphp
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
                                        class="text-red-500 dark:text-red-400 text-xs mt-1">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
