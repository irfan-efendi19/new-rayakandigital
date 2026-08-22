{{-- ======================================== --}}
                            {{-- Section 1: Informasi Dasar & Identitas --}}
                            {{-- ======================================== --}}
                            <div id="sec-1"
                                x-show="activeSection === 'sec-1'"
                                x-transition:enter="transition ease-out duration-300"
                                x-transition:enter-start="opacity-0 translate-x-4"
                                x-transition:enter-end="opacity-100 translate-x-0"
                                class="scroll-mt-32"
                                data-tour="mempelai-info"
                                x-cloak>
                                <div class="mb-3">
                                    <h3 class="font-heading text-lg font-bold text-secondary-800 dark:text-neutral-100">
                                        Informasi Dasar & Identitas <span class="text-sm font-normal text-neutral-400 dark:text-neutral-500">(Profil)</span>
                                    </h3>
                                </div>
                                <p class="text-sm text-neutral-500 dark:text-neutral-400 mb-6">Data lengkap kedua mempelai untuk ditampilkan di undangan.</p>

                                <div x-data="{
                                    order: '{{ $invitation->bride_groom_order ?? 'male_first' }}',
                                    toggleOrder() { this.order = this.order === 'male_first' ? 'female_first' : 'male_first'; }
                                }" class="flex flex-col gap-6">

                                    <input type="hidden" name="bride_groom_order" :value="order">

                                    {{-- Swap Button --}}
                                    <div class="flex justify-center -mb-2">
                                        <button @click="toggleOrder" type="button"
                                            class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold rounded-xl text-primary dark:text-primary-300 bg-primary-50 dark:bg-primary-900/40 border border-primary-200/60 dark:border-primary-800/40 hover:bg-primary-100 dark:hover:bg-primary-900/70 transition">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                                            </svg>
                                            Tukar Urutan Posisi
                                        </button>
                                    </div>

                                    {{-- Bride --}}
                                    <div :style="order === 'female_first' ? { order: 1 } : { order: 2 }"
                                        class="bg-neutral-50 dark:bg-secondary-700/50 p-5 rounded-2xl border border-neutral-200 dark:border-secondary-700 space-y-4">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-8 h-8 rounded-lg bg-primary-100 dark:bg-primary-900/50 flex items-center justify-center text-primary dark:text-primary-400 font-semibold text-sm">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                            </div>
                                            <div>
                                                <h4 class="font-bold text-sm text-secondary-800 dark:text-neutral-100">Mempelai Wanita</h4>
                                            </div>
                                        </div>
                                        <div class="grid grid-cols-1 gap-y-5 gap-x-4 sm:grid-cols-6">
                                            <div class="sm:col-span-3">
                                                <label for="bride_name"
                                                    class="block text-xs font-semibold text-neutral-700 dark:text-neutral-300 uppercase tracking-wide mb-1.5">Nama Lengkap <span class="text-red-500">*</span></label>
                                                <input type="text" name="bride_name" id="bride_name"
                                                    value="{{ old('bride_name', $invitation->bride_name) }}"
                                                    class="block w-full rounded-xl border-neutral-300 dark:border-neutral-600 shadow-sm focus:border-primary focus:ring-primary sm:text-sm dark:bg-secondary-700 dark:text-neutral-200"
                                                    required>
                                                @error('bride_name')
                                                    <span
                                                        class="text-red-500 dark:text-red-400 text-xs mt-1">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="sm:col-span-3">
                                                <label for="bride_nickname"
                                                    class="block text-xs font-semibold text-neutral-700 dark:text-neutral-300 uppercase tracking-wide mb-1.5">Nama Panggilan</label>
                                                <input type="text" name="bride_nickname" id="bride_nickname"
                                                    value="{{ old('bride_nickname', $invitation->bride_nickname) }}"
                                                    class="block w-full rounded-xl border-neutral-300 dark:border-neutral-600 shadow-sm focus:border-primary focus:ring-primary sm:text-sm dark:bg-secondary-700 dark:text-neutral-200">
                                                @error('bride_nickname')
                                                    <span
                                                        class="text-red-500 dark:text-red-400 text-xs mt-1">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="sm:col-span-3">
                                                <label for="bride_father_name"
                                                    class="block text-xs font-semibold text-neutral-700 dark:text-neutral-300 uppercase tracking-wide mb-1.5">Nama Ayah</label>
                                                <input type="text" name="bride_father_name" id="bride_father_name"
                                                    value="{{ old('bride_father_name', $invitation->bride_father_name) }}"
                                                    class="block w-full rounded-xl border-neutral-300 dark:border-neutral-600 shadow-sm focus:border-primary focus:ring-primary sm:text-sm dark:bg-secondary-700 dark:text-neutral-200"
                                                    placeholder="Nama Ayah Mempelai Wanita">
                                                @error('bride_father_name')
                                                    <span
                                                        class="text-red-500 dark:text-red-400 text-xs mt-1">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="sm:col-span-3">
                                                <label for="bride_mother_name"
                                                    class="block text-xs font-semibold text-neutral-700 dark:text-neutral-300 uppercase tracking-wide mb-1.5">Nama Ibu</label>
                                                <input type="text" name="bride_mother_name" id="bride_mother_name"
                                                    value="{{ old('bride_mother_name', $invitation->bride_mother_name) }}"
                                                    class="block w-full rounded-xl border-neutral-300 dark:border-neutral-600 shadow-sm focus:border-primary focus:ring-primary sm:text-sm dark:bg-secondary-700 dark:text-neutral-200"
                                                    placeholder="Nama Ibu Mempelai Wanita">
                                                @error('bride_mother_name')
                                                    <span
                                                        class="text-red-500 dark:text-red-400 text-xs mt-1">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="sm:col-span-6">
                                                <label class="block text-xs font-semibold text-neutral-700 dark:text-neutral-300 uppercase tracking-wide mb-2">Foto Mempelai Wanita</label>
                                                <div class="photo-upload-zone relative border-2 border-dashed border-neutral-200 dark:border-secondary-600 rounded-2xl p-4 bg-white dark:bg-secondary-800 hover:border-primary cursor-pointer group"
                                                    onclick="document.querySelector('[data-crop-target=bride_photo_input]').click()">
                                                    <div class="flex items-center gap-4">
                                                        <div class="relative flex-shrink-0">
                                                            <img id="bride-preview"
                                                                src="{{ $invitation->bride_photo ? asset('storage/' . $invitation->bride_photo) : '' }}"
                                                                alt="Bride photo"
                                                                class="w-16 h-16 object-cover rounded-xl border border-neutral-200 dark:border-secondary-600 {{ $invitation->bride_photo ? '' : 'hidden' }}">
                                                            <div id="bride-preview-placeholder"
                                                                class="w-16 h-16 bg-neutral-100 dark:bg-secondary-700 rounded-xl flex items-center justify-center text-neutral-400 dark:text-neutral-500 {{ $invitation->bride_photo ? 'hidden' : '' }}">
                                                                <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                                </svg>
                                                            </div>
                                                        </div>
                                                        <div class="flex-1 min-w-0">
                                                            <p class="text-sm font-semibold text-neutral-700 dark:text-neutral-200 group-hover:text-primary transition-colors">Unggah Foto</p>
                                                            <p class="text-xs text-neutral-400 dark:text-neutral-500 mt-0.5">Klik untuk memilih foto (Format 1:1)</p>
                                                            <input type="file" name="bride_photo" id="bride_photo_input"
                                                                class="crop-file-input hidden" accept="image/*"
                                                                data-preview="bride-preview"
                                                                data-title="Foto Mempelai Wanita"
                                                                data-aspect-ratio="1" data-width="400" data-height="400">
                                                            <button type="button" data-crop-target="bride_photo_input"
                                                                onclick="event.stopPropagation()"
                                                                class="mt-2 inline-flex items-center gap-1.5 px-3 py-1.5 bg-neutral-100 dark:bg-secondary-700 text-neutral-700 dark:text-neutral-300 rounded-lg text-xs font-semibold hover:bg-primary-50 hover:text-primary dark:hover:bg-primary-900/40 transition">
                                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                                                                Pilih & Crop Foto
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                @error('bride_photo')
                                                    <span
                                                        class="text-red-500 dark:text-red-400 text-xs mt-1">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Groom --}}
                                    <div :style="order === 'male_first' ? { order: 1 } : { order: 2 }"
                                        class="bg-neutral-50 dark:bg-secondary-700/50 p-5 rounded-2xl border border-neutral-200 dark:border-secondary-700 space-y-4">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-8 h-8 rounded-lg bg-primary-100 dark:bg-primary-900/50 flex items-center justify-center text-primary dark:text-primary-400 font-semibold text-sm">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                            </div>
                                            <div>
                                                <h4 class="font-bold text-sm text-secondary-800 dark:text-neutral-100">Mempelai Pria</h4>
                                            </div>
                                        </div>
                                        <div class="grid grid-cols-1 gap-y-5 gap-x-4 sm:grid-cols-6">
                                            <div class="sm:col-span-3">
                                                <label for="groom_name"
                                                    class="block text-xs font-semibold text-neutral-700 dark:text-neutral-300 uppercase tracking-wide mb-1.5">Nama Lengkap <span class="text-red-500">*</span></label>
                                                <input type="text" name="groom_name" id="groom_name"
                                                    value="{{ old('groom_name', $invitation->groom_name) }}"
                                                    class="block w-full rounded-xl border-neutral-300 dark:border-neutral-600 shadow-sm focus:border-primary focus:ring-primary sm:text-sm dark:bg-secondary-700 dark:text-neutral-200"
                                                    required>
                                                @error('groom_name')
                                                    <span
                                                        class="text-red-500 dark:text-red-400 text-xs mt-1">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="sm:col-span-3">
                                                <label for="groom_nickname"
                                                    class="block text-xs font-semibold text-neutral-700 dark:text-neutral-300 uppercase tracking-wide mb-1.5">Nama Panggilan</label>
                                                <input type="text" name="groom_nickname" id="groom_nickname"
                                                    value="{{ old('groom_nickname', $invitation->groom_nickname) }}"
                                                    class="block w-full rounded-xl border-neutral-300 dark:border-neutral-600 shadow-sm focus:border-primary focus:ring-primary sm:text-sm dark:bg-secondary-700 dark:text-neutral-200">
                                                @error('groom_nickname')
                                                    <span
                                                        class="text-red-500 dark:text-red-400 text-xs mt-1">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="sm:col-span-3">
                                                <label for="groom_father_name"
                                                    class="block text-xs font-semibold text-neutral-700 dark:text-neutral-300 uppercase tracking-wide mb-1.5">Nama Ayah</label>
                                                <input type="text" name="groom_father_name" id="groom_father_name"
                                                    value="{{ old('groom_father_name', $invitation->groom_father_name) }}"
                                                    class="block w-full rounded-xl border-neutral-300 dark:border-neutral-600 shadow-sm focus:border-primary focus:ring-primary sm:text-sm dark:bg-secondary-700 dark:text-neutral-200"
                                                    placeholder="Nama Ayah Mempelai Pria">
                                                @error('groom_father_name')
                                                    <span
                                                        class="text-red-500 dark:text-red-400 text-xs mt-1">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="sm:col-span-3">
                                                <label for="groom_mother_name"
                                                    class="block text-xs font-semibold text-neutral-700 dark:text-neutral-300 uppercase tracking-wide mb-1.5">Nama Ibu</label>
                                                <input type="text" name="groom_mother_name" id="groom_mother_name"
                                                    value="{{ old('groom_mother_name', $invitation->groom_mother_name) }}"
                                                    class="block w-full rounded-xl border-neutral-300 dark:border-neutral-600 shadow-sm focus:border-primary focus:ring-primary sm:text-sm dark:bg-secondary-700 dark:text-neutral-200"
                                                    placeholder="Nama Ibu Mempelai Pria">
                                                @error('groom_mother_name')
                                                    <span
                                                        class="text-red-500 dark:text-red-400 text-xs mt-1">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="sm:col-span-6">
                                                <label class="block text-xs font-semibold text-neutral-700 dark:text-neutral-300 uppercase tracking-wide mb-2">Foto Mempelai Pria</label>
                                                <div class="photo-upload-zone relative border-2 border-dashed border-neutral-200 dark:border-secondary-600 rounded-2xl p-4 bg-white dark:bg-secondary-800 hover:border-primary cursor-pointer group"
                                                    onclick="document.querySelector('[data-crop-target=groom_photo_input]').click()">
                                                    <div class="flex items-center gap-4">
                                                        <div class="relative flex-shrink-0">
                                                            <img id="groom-preview"
                                                                src="{{ $invitation->groom_photo ? asset('storage/' . $invitation->groom_photo) : '' }}"
                                                                alt="Groom photo"
                                                                class="w-16 h-16 object-cover rounded-xl border border-neutral-200 dark:border-secondary-600 {{ $invitation->groom_photo ? '' : 'hidden' }}">
                                                            <div id="groom-preview-placeholder"
                                                                class="w-16 h-16 bg-neutral-100 dark:bg-secondary-700 rounded-xl flex items-center justify-center text-neutral-400 dark:text-neutral-500 {{ $invitation->groom_photo ? 'hidden' : '' }}">
                                                                <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                                </svg>
                                                            </div>
                                                        </div>
                                                        <div class="flex-1 min-w-0">
                                                            <p class="text-sm font-semibold text-neutral-700 dark:text-neutral-200 group-hover:text-primary transition-colors">Unggah Foto</p>
                                                            <p class="text-xs text-neutral-400 dark:text-neutral-500 mt-0.5">Klik untuk memilih foto (Format 1:1)</p>
                                                            <input type="file" name="groom_photo" id="groom_photo_input"
                                                                class="crop-file-input hidden" accept="image/*"
                                                                data-preview="groom-preview"
                                                                data-title="Foto Mempelai Pria"
                                                                data-aspect-ratio="1" data-width="400" data-height="400">
                                                            <button type="button" data-crop-target="groom_photo_input"
                                                                onclick="event.stopPropagation()"
                                                                class="mt-2 inline-flex items-center gap-1.5 px-3 py-1.5 bg-neutral-100 dark:bg-secondary-700 text-neutral-700 dark:text-neutral-300 rounded-lg text-xs font-semibold hover:bg-primary-50 hover:text-primary dark:hover:bg-primary-900/40 transition">
                                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                                                                Pilih & Crop Foto
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                @error('groom_photo')
                                                    <span
                                                        class="text-red-500 dark:text-red-400 text-xs mt-1">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Custom URL / Slug --}}
                                <div data-tour="invitation-link" class="mt-6">
                                    <h4
                                        class="font-heading text-base font-bold text-secondary-800 dark:text-neutral-100 mb-1">
                                        Tautan Undangan</h4>
                                    <p class="text-sm text-neutral-500 dark:text-neutral-400 mb-4">
                                        Sesuaikan tautan
                                        undangan Anda.</p>

                                    <div
                                        class="bg-neutral-50 dark:bg-secondary-700 p-5 rounded-2xl border border-neutral-200 dark:border-secondary-700 space-y-4">
                                        <div>
                                            <label for="slug-input"
                                                class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Tautan
                                                Kustom</label>
                                            <div class="mt-1.5 flex flex-col sm:flex-row items-stretch gap-2 sm:gap-0">
                                                <span
                                                    class="inline-flex items-center px-3 py-2 sm:py-0 rounded-xl sm:rounded-r-none border border-neutral-300 dark:border-neutral-600 bg-neutral-100 dark:bg-secondary-800 text-xs sm:text-sm text-neutral-500 dark:text-neutral-400 whitespace-nowrap font-mono w-full sm:w-auto justify-center sm:justify-start sm:border-r-0">{{ parse_url(config('app.url'), PHP_URL_HOST) }}/</span>
                                                <input type="text" name="slug" id="slug-input"
                                                    value="{{ old('slug', $invitation->slug) }}"
                                                    data-original="{{ $invitation->slug }}"
                                                    data-id="{{ $invitation->id }}"
                                                    class="block w-full flex-1 rounded-xl sm:rounded-l-none border border-neutral-300 dark:border-neutral-600 shadow-sm focus:border-primary-500 focus:ring-primary-500 text-sm font-mono dark:bg-secondary-700 dark:text-neutral-200 py-2.5 px-3"
                                                    placeholder="nama-undangan-anda" maxlength="100"
                                                    pattern="^[a-z0-9\-]+$">
                                            </div>
                                            <div id="slug-indicator"
                                                class="mt-1.5 text-xs flex items-center gap-1.5 text-neutral-400 dark:text-neutral-500">
                                                <span class="slug-icon flex items-center">
                                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                                                </span>
                                                <span class="slug-text">Masukkan
                                                    tautan
                                                    kustom</span>
                                            </div>
                                            @error('slug') <span
                                                class="text-red-500 dark:text-red-400 text-xs mt-1">{{ $message }}</span>
                                            @enderror
                                            <p class="mt-1.5 text-xs text-neutral-400 dark:text-neutral-500">
                                                Huruf
                                                kecil,
                                                angka, dan tanda hubung
                                                (-)</p>
                                        </div>

                                        <div
                                            class="bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-xl p-4">
                                            <div class="flex items-start gap-3">
                                                <span class="text-amber-600 dark:text-amber-400 flex-shrink-0 mt-0.5">
                                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                                                </span>
                                                <div>
                                                    <p class="text-xs font-semibold text-amber-800 dark:text-amber-300">
                                                        Perhatian</p>
                                                    <p class="text-xs text-amber-700 dark:text-amber-400 mt-0.5">
                                                        Mengubah
                                                        tautan akan
                                                        membuat tautan
                                                        lama tidak
                                                        bisa diakses.
                                                        Pastikan
                                                        Anda
                                                        belum
                                                        menyebarkan
                                                        tautan lama ke
                                                        tamu
                                                        undangan.</p>
                                                    @if(
                                                            $invitation->slug_change_count
                                                            > 0
                                                        )
                                                        <p class="text-xs text-amber-700 dark:text-amber-400 mt-1">
                                                            Tautan
                                                            telah
                                                            diubah
                                                            {{ $invitation->slug_change_count }}
                                                            kali.
                                                        </p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
