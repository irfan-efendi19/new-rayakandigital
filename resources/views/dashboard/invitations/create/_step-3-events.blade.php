{{-- ======================================== --}}
{{-- STEP 3: Waktu & Tempat (Detail Acara) --}}
{{-- ======================================== --}}
<div id="step-3" data-step="3"
    class="border-b border-neutral-200/80 dark:border-secondary-700/70 pb-8 scroll-mt-28"
    data-tour="event-schedule">
    <div class="flex items-center gap-3 mb-2">
        <div
            class="w-8 h-8 rounded-xl bg-primary-500 text-white font-bold text-sm flex items-center justify-center flex-shrink-0">
            3
        </div>
        <div>
            <h3
                class="font-heading text-lg font-bold text-secondary-900 dark:text-neutral-100">
                Waktu & Tempat <span
                    class="text-sm font-normal text-neutral-400 dark:text-neutral-500">(Detail
                    Acara)</span>
            </h3>
        </div>
    </div>
    <p class="text-sm text-neutral-500 dark:text-neutral-400 mb-6">Informasi krusial
        mengenai kapan dan di mana acara berlangsung.</p>

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
                <h4 class="font-bold text-base text-secondary-900 dark:text-neutral-100">
                    Daftar Acara</h4>
                <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-0.5">Tambah
                    beberapa acara sekaligus — Akad Nikah, Resepsi, Unduh Mantu, dll.</p>
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
                    <div
                        class="event-card form-section-card relative border-t-2 border-t-primary-500 overflow-hidden space-y-4">
                        <input type="hidden" name="events[{{ $ei }}][id]" value="">
                        <div
                            class="flex items-center justify-between pb-2 border-b border-neutral-200/60 dark:border-secondary-700/60">
                            <div class="flex items-center gap-2">
                                <div
                                    class="w-7 h-7 rounded-lg bg-primary-100 dark:bg-primary-500/15 flex items-center justify-center text-primary-600 dark:text-primary-400 border border-primary-200/50 dark:border-primary-500/30">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <h4
                                    class="event-card-title font-bold text-sm text-primary-700 dark:text-primary-300">
                                    Acara #{{ $loop->iteration }}</h4>
                            </div>
                            <div class="flex items-center gap-1">
                                <button type="button"
                                    class="move-up p-1.5 text-neutral-400 dark:text-neutral-500 hover:text-neutral-700 dark:hover:text-neutral-300 hover:bg-neutral-200/60 dark:hover:bg-secondary-700 rounded-lg transition"
                                    title="Pindah ke atas">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="M5 15l7-7 7 7" />
                                    </svg>
                                </button>
                                <button type="button"
                                    class="move-down p-1.5 text-neutral-400 dark:text-neutral-500 hover:text-neutral-700 dark:hover:text-neutral-300 hover:bg-neutral-200/60 dark:hover:bg-secondary-700 rounded-lg transition"
                                    title="Pindah ke bawah">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>
                                <button type="button"
                                    class="remove-event ml-1 p-1.5 text-red-400 hover:text-red-600 dark:hover:text-red-300 hover:bg-red-50 dark:hover:bg-red-950/40 rounded-lg transition"
                                    title="Hapus acara">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 gap-y-4 gap-x-4 sm:grid-cols-6">
                            <div class="sm:col-span-6">
                                <label class="form-label-crafted">Nama Acara <span
                                        class="text-red-500">*</span></label>
                                <input type="text" name="events[{{ $ei }}][event_title]"
                                    value="{{ $ev['event_title'] ?? '' }}"
                                    list="event-titles-{{ $ei }}" class="form-input-crafted"
                                    placeholder="Pilih atau ketik nama acara" required>
                                <datalist id="event-titles-{{ $ei }}">
                                    <option value="Akad Nikah">
                                    <option value="Resepsi">
                                    <option value="Pengajian">
                                    <option value="Unduh Mantu">
                                </datalist>
                            </div>
                            <div class="sm:col-span-2">
                                <label class="form-label-crafted">Tanggal Acara <span
                                        class="text-red-500">*</span></label>
                                <input type="date" name="events[{{ $ei }}][event_date]"
                                    value="{{ $ev['event_date'] ?? '' }}" class="form-input-crafted"
                                    required>
                            </div>
                            <div class="sm:col-span-2">
                                <label class="form-label-crafted">Jam Mulai <span
                                        class="text-red-500">*</span></label>
                                <input type="time" name="events[{{ $ei }}][start_time]"
                                    value="{{ $ev['start_time'] ?? '' }}" class="form-input-crafted"
                                    required>
                            </div>
                            <div class="sm:col-span-2">
                                <label class="form-label-crafted">Jam Selesai</label>
                                <input type="time" name="events[{{ $ei }}][end_time]"
                                    value="{{ $ev['end_time'] ?? '' }}" class="form-input-crafted">
                                <div class="mt-2 flex items-center">
                                    <input type="hidden" name="events[{{ $ei }}][is_until_finished]"
                                        value="0">
                                    <input type="checkbox"
                                        name="events[{{ $ei }}][is_until_finished]" value="1" {{ !empty($ev['is_until_finished']) ? 'checked' : '' }}
                                        class="h-4 w-4 rounded border-neutral-300 dark:border-secondary-600 text-primary-600 dark:text-primary-400 focus:ring-primary-500/20">
                                    <label
                                        class="ml-2 text-xs font-medium text-neutral-600 dark:text-neutral-400">Sampai
                                        Selesai</label>
                                </div>
                            </div>
                            <div class="sm:col-span-6">
                                <label class="form-label-crafted">Nama Tempat / Lokasi <span
                                        class="text-red-500">*</span></label>
                                <input type="text" name="events[{{ $ei }}][place_name]"
                                    value="{{ $ev['place_name'] ?? '' }}" class="form-input-crafted"
                                    placeholder="Nama gedung atau lokasi" required>
                            </div>
                            <div class="sm:col-span-6">
                                <label class="form-label-crafted">Alamat Lengkap <span
                                        class="text-red-500">*</span></label>
                                <textarea name="events[{{ $ei }}][place_address]" rows="2"
                                    class="form-input-crafted" placeholder="Alamat lengkap lokasi"
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
                <div
                    class="event-card form-section-card relative border-t-2 border-t-primary-500 overflow-hidden space-y-4">
                    <input type="hidden" name="events[0][id]" value="">
                    <div
                        class="flex items-center justify-between pb-2 border-b border-neutral-200/60 dark:border-secondary-700/60">
                        <div class="flex items-center gap-2">
                            <div
                                class="w-7 h-7 rounded-lg bg-primary-100 dark:bg-primary-500/15 flex items-center justify-center text-primary-600 dark:text-primary-400 border border-primary-200/50 dark:border-primary-500/30">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <h4
                                class="event-card-title font-bold text-sm text-primary-700 dark:text-primary-300">
                                Acara #1</h4>
                        </div>
                        <div class="flex items-center gap-1">
                            <button type="button"
                                class="move-up p-1.5 text-neutral-400 dark:text-neutral-500 hover:text-neutral-700 dark:hover:text-neutral-300 hover:bg-neutral-200/60 dark:hover:bg-secondary-700 rounded-lg transition"
                                title="Pindah ke atas">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M5 15l7-7 7 7" />
                                </svg>
                            </button>
                            <button type="button"
                                class="move-down p-1.5 text-neutral-400 dark:text-neutral-500 hover:text-neutral-700 dark:hover:text-neutral-300 hover:bg-neutral-200/60 dark:hover:bg-secondary-700 rounded-lg transition"
                                title="Pindah ke bawah">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <button type="button"
                                class="remove-event ml-1 p-1.5 text-red-400 hover:text-red-600 dark:hover:text-red-300 hover:bg-red-50 dark:hover:bg-red-950/40 rounded-lg transition"
                                title="Hapus acara">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 gap-y-4 gap-x-4 sm:grid-cols-6">
                        <div class="sm:col-span-6">
                            <label class="form-label-crafted">Nama Acara <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="events[0][event_title]" value=""
                                list="event-titles-0" class="form-input-crafted"
                                placeholder="Pilih atau ketik nama acara" required>
                            <datalist id="event-titles-0">
                                <option value="Akad Nikah">
                                <option value="Resepsi">
                                <option value="Pengajian">
                                <option value="Unduh Mantu">
                            </datalist>
                        </div>
                        <div class="sm:col-span-2">
                            <label class="form-label-crafted">Tanggal Acara <span
                                    class="text-red-500">*</span></label>
                            <input type="date" name="events[0][event_date]" value=""
                                class="form-input-crafted" required>
                        </div>
                        <div class="sm:col-span-2">
                            <label class="form-label-crafted">Jam Mulai <span
                                    class="text-red-500">*</span></label>
                            <input type="time" name="events[0][start_time]" value=""
                                class="form-input-crafted" required>
                        </div>
                        <div class="sm:col-span-2">
                            <label class="form-label-crafted">Jam Selesai</label>
                            <input type="time" name="events[0][end_time]" value=""
                                class="form-input-crafted">
                            <div class="mt-2 flex items-center">
                                <input type="hidden" name="events[0][is_until_finished]"
                                    value="0">
                                <input type="checkbox" name="events[0][is_until_finished]"
                                    value="1"
                                    class="h-4 w-4 rounded border-neutral-300 dark:border-secondary-600 text-primary-600 dark:text-primary-400 focus:ring-primary-500/20">
                                <label
                                    class="ml-2 text-xs font-medium text-neutral-600 dark:text-neutral-400">Sampai
                                    Selesai</label>
                            </div>
                        </div>
                        <div class="sm:col-span-6">
                            <label class="form-label-crafted">Nama Tempat / Lokasi <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="events[0][place_name]" value=""
                                class="form-input-crafted" placeholder="Nama gedung atau lokasi"
                                required>
                        </div>
                        <div class="sm:col-span-6">
                            <label class="form-label-crafted">Alamat Lengkap <span
                                    class="text-red-500">*</span></label>
                            <textarea name="events[0][place_address]" rows="2"
                                class="form-input-crafted" placeholder="Alamat lengkap lokasi"
                                required></textarea>
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
            <div
                class="event-card form-section-card relative border-t-2 border-t-primary-500 overflow-hidden space-y-4">
                <input type="hidden" name="events[__INDEX__][id]" value="">
                <div
                    class="flex items-center justify-between pb-2 border-b border-neutral-200/60 dark:border-secondary-700/60">
                    <div class="flex items-center gap-2">
                        <div
                            class="w-7 h-7 rounded-lg bg-primary-100 dark:bg-primary-500/15 flex items-center justify-center text-primary-600 dark:text-primary-400 border border-primary-200/50 dark:border-primary-500/30">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <h4
                            class="event-card-title font-bold text-sm text-primary-700 dark:text-primary-300">
                            Acara #__INDEX__</h4>
                    </div>
                    <div class="flex items-center gap-1">
                        <button type="button"
                            class="move-up p-1.5 text-neutral-400 dark:text-neutral-500 hover:text-neutral-700 dark:hover:text-neutral-300 hover:bg-neutral-200/60 dark:hover:bg-secondary-700 rounded-lg transition"
                            title="Pindah ke atas">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="M5 15l7-7 7 7" />
                            </svg>
                        </button>
                        <button type="button"
                            class="move-down p-1.5 text-neutral-400 dark:text-neutral-500 hover:text-neutral-700 dark:hover:text-neutral-300 hover:bg-neutral-200/60 dark:hover:bg-secondary-700 rounded-lg transition"
                            title="Pindah ke bawah">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <button type="button"
                            class="remove-event ml-1 p-1.5 text-red-400 hover:text-red-600 dark:hover:text-red-300 hover:bg-red-50 dark:hover:bg-red-950/40 rounded-lg transition"
                            title="Hapus acara">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="grid grid-cols-1 gap-y-4 gap-x-4 sm:grid-cols-6">
                    <div class="sm:col-span-6">
                        <label class="form-label-crafted">Nama Acara <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="events[__INDEX__][event_title]" value=""
                            list="event-titles-__INDEX__" class="form-input-crafted"
                            placeholder="Pilih atau ketik nama acara" required>
                        <datalist id="event-titles-__INDEX__">
                            <option value="Akad Nikah">
                            <option value="Resepsi">
                            <option value="Pengajian">
                            <option value="Unduh Mantu">
                        </datalist>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="form-label-crafted">Tanggal Acara <span
                                class="text-red-500">*</span></label>
                        <input type="date" name="events[__INDEX__][event_date]" value=""
                            class="form-input-crafted" required>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="form-label-crafted">Jam Mulai <span
                                class="text-red-500">*</span></label>
                        <input type="time" name="events[__INDEX__][start_time]" value=""
                            class="form-input-crafted" required>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="form-label-crafted">Jam Selesai</label>
                        <input type="time" name="events[__INDEX__][end_time]" value=""
                            class="form-input-crafted">
                        <div class="mt-2 flex items-center">
                            <input type="hidden" name="events[__INDEX__][is_until_finished]"
                                value="0">
                            <input type="checkbox"
                                name="events[__INDEX__][is_until_finished]" value="1"
                                class="h-4 w-4 rounded border-neutral-300 dark:border-secondary-600 text-primary-600 dark:text-primary-400 focus:ring-primary-500/20">
                            <label
                                class="ml-2 text-xs font-medium text-neutral-600 dark:text-neutral-400">Sampai
                                Selesai</label>
                        </div>
                    </div>
                    <div class="sm:col-span-6">
                        <label class="form-label-crafted">Nama Tempat / Lokasi <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="events[__INDEX__][place_name]" value=""
                            class="form-input-crafted" placeholder="Nama gedung atau lokasi"
                            required>
                    </div>
                    <div class="sm:col-span-6">
                        <label class="form-label-crafted">Alamat Lengkap <span
                                class="text-red-500">*</span></label>
                        <textarea name="events[__INDEX__][place_address]" rows="2"
                            class="form-input-crafted" placeholder="Alamat lengkap lokasi"
                            required></textarea>
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
