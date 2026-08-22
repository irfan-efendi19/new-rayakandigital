{{-- Bride Card --}}
<div :style="order === 'female_first' ? { order: 1 } : { order: 2 }"
    class="form-section-card">
    {{-- Card Header --}}
    <div
        class="flex items-center gap-3 mb-5 pb-4 border-b border-neutral-100 dark:border-secondary-700/50">
        <div
            class="w-8 h-8 rounded-xl bg-pink-50 dark:bg-pink-950/40 border border-pink-100 dark:border-pink-900/50 flex items-center justify-center text-pink-500 dark:text-pink-400 flex-shrink-0">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                    stroke-width="2"
                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
        </div>
        <div>
            <h4 class="font-bold text-sm text-secondary-900 dark:text-neutral-100">
                Mempelai Wanita</h4>
            <p class="text-xs text-neutral-400 dark:text-neutral-500 mt-0.5">Data
                diri mempelai wanita</p>
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
                    <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="1.5"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
            </div>
            <div class="flex-1 min-w-0">
                <p
                    class="text-sm font-semibold text-neutral-700 dark:text-neutral-200 group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors">
                    Unggah Foto Mempelai Wanita</p>
                <p class="text-xs text-neutral-400 dark:text-neutral-500 mt-0.5">
                    Klik untuk pilih foto (rasio 1:1)</p>
                <input type="file" name="bride_photo" id="bride_photo_input"
                    class="crop-file-input hidden" accept="image/*"
                    data-preview="bride-preview" data-title="Foto Mempelai Wanita"
                    data-aspect-ratio="1" data-width="400" data-height="400">
                <button type="button" data-crop-target="bride_photo_input"
                    onclick="event.stopPropagation()"
                    class="mt-2.5 inline-flex items-center gap-1.5 px-3 py-1.5 bg-white dark:bg-secondary-700 border border-neutral-200 dark:border-secondary-600 text-neutral-600 dark:text-neutral-300 rounded-lg text-xs font-semibold hover:bg-primary-500 hover:border-primary-500 hover:text-white dark:hover:bg-primary-500 dark:hover:border-primary-500 transition-all duration-150">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                    </svg>
                    Pilih &amp; Crop Foto
                </button>
            </div>
        </div>
        @error('bride_photo') <span
        class="text-red-500 dark:text-red-400 text-xs mt-1 block font-medium">{{ $message }}</span>@enderror
    </div>

    {{-- Name Grid --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
        <div>
            <label for="bride_name" class="form-label-crafted">Nama Lengkap <span
                    class="text-red-500">*</span></label>
            <input type="text" name="bride_name" id="bride_name"
                value="{{ old('bride_name') }}" class="form-input-crafted" required
                placeholder="Ani Suryani">
            @error('bride_name') <span
            class="text-red-500 dark:text-red-400 text-xs mt-1 block font-medium">{{ $message }}</span>@enderror
        </div>
        <div>
            <label for="bride_nickname" class="form-label-crafted">Nama
                Panggilan</label>
            <input type="text" name="bride_nickname" id="bride_nickname"
                value="{{ old('bride_nickname') }}" class="form-input-crafted"
                placeholder="Ani">
            @error('bride_nickname') <span
            class="text-red-500 dark:text-red-400 text-xs mt-1 block font-medium">{{ $message }}</span>@enderror
        </div>
        <div>
            <label for="bride_father_name" class="form-label-crafted">Nama Ayah
                <span class="text-red-500">*</span></label>
            <input type="text" name="bride_father_name" id="bride_father_name"
                value="{{ old('bride_father_name') }}" class="form-input-crafted"
                placeholder="Nama Ayah Mempelai Wanita" required>
            @error('bride_father_name') <span
            class="text-red-500 dark:text-red-400 text-xs mt-1 block font-medium">{{ $message }}</span>@enderror
        </div>
        <div>
            <label for="bride_mother_name" class="form-label-crafted">Nama Ibu <span
                    class="text-red-500">*</span></label>
            <input type="text" name="bride_mother_name" id="bride_mother_name"
                value="{{ old('bride_mother_name') }}" class="form-input-crafted"
                placeholder="Nama Ibu Mempelai Wanita" required>
            @error('bride_mother_name') <span
            class="text-red-500 dark:text-red-400 text-xs mt-1 block font-medium">{{ $message }}</span>@enderror
        </div>
    </div>
</div>
