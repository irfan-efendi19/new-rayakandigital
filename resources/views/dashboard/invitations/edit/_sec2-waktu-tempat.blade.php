{{-- ======================================== --}}
                            {{-- Section 2: Waktu Tempat & Akses Undangan --}}
                            {{-- ======================================== --}}
                            <div id="sec-2"
                                x-show="activeSection === 'sec-2'"
                                x-transition:enter="transition ease-out duration-300"
                                x-transition:enter-start="opacity-0 translate-x-4"
                                x-transition:enter-end="opacity-100 translate-x-0"
                                class="scroll-mt-32"
                                data-tour="event-schedule"
                                x-cloak>
                                <div class="mb-3">
                                    <h3 class="font-heading text-lg font-bold text-secondary-800 dark:text-neutral-100">
                                        Waktu, Tempat & Akses Undangan <span class="text-sm font-normal text-neutral-400 dark:text-neutral-500">(Detail Acara)</span>
                                    </h3>
                                </div>
                                <p class="text-sm text-neutral-500 dark:text-neutral-400 mb-6">Atur jadwal acara dan lokasi tempat pelaksanaan acara.</p>

                                {{-- Event Details --}}
                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 mb-4">
                                    <h4
                                        class="font-heading text-base font-bold text-secondary-800 dark:text-neutral-100">
                                        Waktu & Tempat</h4>
                                </div>

                                @error('events') <span
                                    class="text-red-500 dark:text-red-400 text-xs block mb-3">{{ $message }}</span>
                                @enderror

                                <input type="hidden" name="events_enabled" value="1">

                                <div id="events-container" class="space-y-4">
                                    @php
                                        $eventCollection = old('events') ?
                                            array_values(old('events')) :
                                            $invitation->events;
                                    @endphp
                                    @foreach($eventCollection as $eventIdx => $event)
                                        @php
                                            if (is_array($event)) {
                                                $event = (object) $event;
                                            }
                                        @endphp
                                        <div
                                            class="event-card overflow-hidden bg-neutral-50 dark:bg-secondary-700/50 p-5 rounded-2xl border border-neutral-200 dark:border-secondary-700 shadow-sm">
                                            <input type="hidden" name="events[{{ $eventIdx }}][id]"
                                                value="{{ $event->id ?? '' }}">
                                            <div class="flex items-center justify-between flex-wrap gap-2 mb-4">
                                                <div class="flex items-center gap-2">
                                                    <div
                                                        class="w-7 h-7 rounded-lg bg-primary-100 dark:bg-primary-900/50 flex items-center justify-center text-primary">
                                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"
                                                            stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                        </svg>
                                                    </div>
                                                    <h4
                                                        class="event-card-title font-semibold text-sm text-primary-700 dark:text-primary-300">
                                                        Acara
                                                        #{{ $loop->iteration }}
                                                    </h4>
                                                </div>
                                                <div class="flex items-center gap-1">
                                                    <button type="button"
                                                        class="move-up p-1.5 text-neutral-400 dark:text-neutral-500 hover:text-neutral-600 dark:hover:text-neutral-400 hover:bg-neutral-200 dark:hover:bg-secondary-600 rounded-lg transition"
                                                        title="Pindah ke atas">
                                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                                            stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M5 15l7-7 7 7" />
                                                        </svg>
                                                    </button>
                                                    <button type="button"
                                                        class="move-down p-1.5 text-neutral-400 dark:text-neutral-500 hover:text-neutral-600 dark:hover:text-neutral-400 hover:bg-neutral-200 dark:hover:bg-secondary-600 rounded-lg transition"
                                                        title="Pindah ke bawah">
                                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                                            stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M19 9l-7 7-7-7" />
                                                        </svg>
                                                    </button>
                                                    <button type="button"
                                                        class="remove-event ml-1 p-1.5 text-red-400 dark:text-red-400 hover:text-red-600 dark:hover:text-red-300 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition"
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
                                                    <label
                                                        class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Nama
                                                        Acara</label>
                                                    <input type="text" name="events[{{ $eventIdx }}][event_title]"
                                                        value="{{ old('events.' . $eventIdx . '.event_title', $event->event_title ?? '') }}"
                                                        list="event-titles-{{ $eventIdx }}"
                                                        class="mt-1 block w-full rounded-xl border-neutral-300 dark:border-neutral-600 shadow-sm focus:border-primary focus:ring-primary sm:text-sm dark:bg-secondary-700 dark:text-neutral-200"
                                                        placeholder="Pilih atau ketik nama acara" required>
                                                    <datalist id="event-titles-{{ $eventIdx }}">
                                                        <option value="Akad Nikah">
                                                        <option value="Resepsi">
                                                        <option value="Pengajian">
                                                        <option value="Unduh Mantu">
                                                    </datalist>
                                                </div>
                                                <div class="sm:col-span-2">
                                                    <label
                                                        class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Tanggal
                                                        Acara</label>
                                                    <input type="date" name="events[{{ $eventIdx }}][event_date]"
                                                        value="{{ old('events.' . $eventIdx . '.event_date', $event->event_date instanceof \Carbon\Carbon ? $event->event_date->format('Y-m-d') : ($event->event_date ?? '')) }}"
                                                        class="mt-1 block w-full rounded-xl border-neutral-300 dark:border-neutral-600 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm dark:bg-secondary-700 dark:text-neutral-200"
                                                        required>
                                                </div>
                                                <div class="sm:col-span-2">
                                                    <label
                                                        class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Jam
                                                        Mulai</label>
                                                    <input type="time" name="events[{{ $eventIdx }}][start_time]"
                                                        value="{{ old('events.' . $eventIdx . '.start_time', $event->start_time ?? '') }}"
                                                        class="mt-1 block w-full rounded-xl border-neutral-300 dark:border-neutral-600 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm dark:bg-secondary-700 dark:text-neutral-200"
                                                        required>
                                                </div>
                                                <div class="sm:col-span-2">
                                                    <label
                                                        class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Jam
                                                        Selesai</label>
                                                    <input type="time" name="events[{{ $eventIdx }}][end_time]"
                                                        value="{{ old('events.' . $eventIdx . '.end_time', $event->end_time ?? '') }}"
                                                        class="mt-1 block w-full rounded-xl border-neutral-300 dark:border-neutral-600 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm dark:bg-secondary-700 dark:text-neutral-200">
                                                    <div class="mt-1.5 flex items-center">
                                                        <input type="hidden"
                                                            name="events[{{ $eventIdx }}][is_until_finished]" value="0">
                                                        <input type="checkbox"
                                                            name="events[{{ $eventIdx }}][is_until_finished]" value="1"
                                                            {{ old('events.' . $eventIdx . '.is_until_finished', $event->is_until_finished ?? false) ? 'checked' : '' }}
                                                            class="h-4 w-4 rounded border-neutral-300 dark:border-neutral-600 text-primary-600 dark:text-primary-400 focus:ring-primary-500">
                                                        <label
                                                            class="ml-2 text-xs text-neutral-500 dark:text-neutral-400">Sampai
                                                            Selesai</label>
                                                    </div>
                                                </div>
                                                <div class="sm:col-span-6">
                                                    <label
                                                        class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Nama
                                                        Tempat /
                                                        Lokasi</label>
                                                    <input type="text" name="events[{{ $eventIdx }}][place_name]"
                                                        value="{{ old('events.' . $eventIdx . '.place_name', $event->place_name ?? '') }}"
                                                        class="mt-1 block w-full rounded-xl border-neutral-300 dark:border-neutral-600 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm dark:bg-secondary-700 dark:text-neutral-200"
                                                        placeholder="Nama gedung atau lokasi" required>
                                                </div>
                                                <div class="sm:col-span-6">
                                                    <label
                                                        class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Alamat
                                                        Lengkap</label>
                                                    <textarea name="events[{{ $eventIdx }}][place_address]" rows="2"
                                                        class="mt-1 block w-full rounded-xl border-neutral-300 dark:border-neutral-600 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm dark:bg-secondary-700 dark:text-neutral-200"
                                                        placeholder="Alamat lengkap lokasi"
                                                        required>{{ old('events.' . $eventIdx . '.place_address', $event->place_address ?? '') }}</textarea>
                                                </div>
                                                <div class="sm:col-span-6">
                                                    <label
                                                        class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Link
                                                        Google Maps</label>
                                                    <input type="url" name="events[{{ $eventIdx }}][google_maps_url]"
                                                        value="{{ old('events.' . $eventIdx . '.google_maps_url', $event->google_maps_url ?? '') }}"
                                                        class="mt-1 block w-full rounded-xl border-neutral-300 dark:border-neutral-600 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm dark:bg-secondary-700 dark:text-neutral-200"
                                                        placeholder="https://goo.gl/maps/...">
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                 </div>

                                <button type="button" id="add-event-btn"
                                    class="inline-flex items-center justify-center gap-1.5 w-full sm:w-auto px-4 py-2 mt-5 text-sm font-semibold rounded-xl text-primary-700 dark:text-primary-300 bg-primary-50 dark:bg-primary-900/50 hover:bg-primary-100 dark:hover:bg-primary-900/70 transition">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4v16m8-8H4" />
                                    </svg>
                                    Tambah Acara
                                </button>

                                {{-- Template for new event card (hidden, cloned by JS) --}}
                                <template id="event-card-template">
                                    <div
                                        class="event-card bg-neutral-50 dark:bg-secondary-700 p-5 rounded-2xl border border-neutral-200 dark:border-secondary-700">
                                        <input type="hidden" name="events[__INDEX__][id]" value="">
                                        <div class="flex items-center justify-between flex-wrap gap-2 mb-4">
                                            <div class="flex items-center gap-2">
                                                <div
                                                    class="w-7 h-7 rounded-lg bg-primary-100 dark:bg-primary-900/50 flex items-center justify-center text-primary">
                                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"
                                                        stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                </div>
                                                <h4
                                                    class="event-card-title font-semibold text-sm text-primary-700 dark:text-primary-300">
                                                    Acara #__INDEX__</h4>
                                            </div>
                                            <div class="flex items-center gap-1">
                                                <button type="button"
                                                    class="move-up p-1.5 text-neutral-400 dark:text-neutral-500 hover:text-neutral-600 dark:hover:text-neutral-400 hover:bg-neutral-200 dark:hover:bg-secondary-600 rounded-lg transition"
                                                    title="Pindah ke atas">
                                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                                        stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M5 15l7-7 7 7" />
                                                    </svg>
                                                </button>
                                                <button type="button"
                                                    class="move-down p-1.5 text-neutral-400 dark:text-neutral-500 hover:text-neutral-600 dark:hover:text-neutral-400 hover:bg-neutral-200 dark:hover:bg-secondary-600 rounded-lg transition"
                                                    title="Pindah ke bawah">
                                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                                        stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M19 9l-7 7-7-7" />
                                                    </svg>
                                                </button>
                                                <button type="button"
                                                    class="remove-event ml-1 p-1.5 text-red-400 dark:text-red-400 hover:text-red-600 dark:hover:text-red-300 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition"
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
                                                <label
                                                    class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Nama
                                                    Acara</label>
                                                <input type="text" name="events[__INDEX__][event_title]" value=""
                                                    list="event-titles-__INDEX__"
                                                    class="mt-1 block w-full rounded-xl border-neutral-300 dark:border-neutral-600 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm dark:bg-secondary-700 dark:text-neutral-200"
                                                    placeholder="Pilih atau ketik nama acara" required>
                                                <datalist id="event-titles-__INDEX__">
                                                    <option value="Akad Nikah">
                                                    <option value="Resepsi">
                                                    <option value="Pengajian">
                                                    <option value="Unduh Mantu">
                                                </datalist>
                                            </div>
                                            <div class="sm:col-span-2">
                                                <label
                                                    class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Tanggal
                                                    Acara</label>
                                                <input type="date" name="events[__INDEX__][event_date]" value=""
                                                    class="mt-1 block w-full rounded-xl border-neutral-300 dark:border-neutral-600 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm dark:bg-secondary-700 dark:text-neutral-200"
                                                    required>
                                            </div>
                                            <div class="sm:col-span-2">
                                                <label
                                                    class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Jam
                                                    Mulai</label>
                                                <input type="time" name="events[__INDEX__][start_time]" value=""
                                                    class="mt-1 block w-full rounded-xl border-neutral-300 dark:border-neutral-600 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm dark:bg-secondary-700 dark:text-neutral-200"
                                                    required>
                                            </div>
                                            <div class="sm:col-span-2">
                                                <label
                                                    class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Jam
                                                    Selesai</label>
                                                <input type="time" name="events[__INDEX__][end_time]" value=""
                                                    class="mt-1 block w-full rounded-xl border-neutral-300 dark:border-neutral-600 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm dark:bg-secondary-700 dark:text-neutral-200">
                                                <div class="mt-1.5 flex items-center">
                                                    <input type="hidden" name="events[__INDEX__][is_until_finished]"
                                                        value="0">
                                                    <input type="checkbox" name="events[__INDEX__][is_until_finished]"
                                                        value="1"
                                                        class="h-4 w-4 rounded border-neutral-300 dark:border-neutral-600 text-primary-600 dark:text-primary-400 focus:ring-primary-500">
                                                    <label
                                                        class="ml-2 text-xs text-neutral-500 dark:text-neutral-400">Sampai
                                                        Selesai</label>
                                                </div>
                                            </div>
                                            <div class="sm:col-span-6">
                                                <label
                                                    class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Nama
                                                    Tempat /
                                                    Lokasi</label>
                                                <input type="text" name="events[__INDEX__][place_name]" value=""
                                                    class="mt-1 block w-full rounded-xl border-neutral-300 dark:border-neutral-600 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm dark:bg-secondary-700 dark:text-neutral-200"
                                                    placeholder="Nama gedung atau lokasi" required>
                                            </div>
                                            <div class="sm:col-span-6">
                                                <label
                                                    class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Alamat
                                                    Lengkap</label>
                                                <textarea name="events[__INDEX__][place_address]" rows="2"
                                                    class="mt-1 block w-full rounded-xl border-neutral-300 dark:border-neutral-600 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm dark:bg-secondary-700 dark:text-neutral-200"
                                                    placeholder="Alamat lengkap lokasi" required></textarea>
                                            </div>
                                            <div class="sm:col-span-6">
                                                <label
                                                    class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Link
                                                    Google Maps</label>
                                                <input type="url" name="events[__INDEX__][google_maps_url]" value=""
                                                    class="mt-1 block w-full rounded-xl border-neutral-300 dark:border-neutral-600 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm dark:bg-secondary-700 dark:text-neutral-200"
                                                    placeholder="https://goo.gl/maps/...">
                                            </div>
                                        </div>
                                    </div>
                                </template>

                                <div class="mt-6">
                                    <label for="timezone"
                                        class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Zona
                                        Waktu</label>
                                    <select name="timezone" id="timezone"
                                        class="mt-1 block w-full rounded-xl border-neutral-300 dark:border-neutral-600 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm dark:bg-secondary-700 dark:text-neutral-200">
                                        <option value="Asia/Jakarta"
                                            {{ old('timezone', $invitation->timezone) == 'Asia/Jakarta' ? 'selected' : '' }}>
                                            WIB (Waktu Indonesia Barat)
                                        </option>
                                        <option value="Asia/Makassar"
                                            {{ old('timezone', $invitation->timezone) == 'Asia/Makassar' ? 'selected' : '' }}>
                                            WITA (Waktu Indonesia
                                            Tengah)
                                        </option>
                                        <option value="Asia/Jayapura"
                                            {{ old('timezone', $invitation->timezone) == 'Asia/Jayapura' ? 'selected' : '' }}>
                                            WIT (Waktu Indonesia Timur)
                                        </option>
                                    </select>
                                 </div>
                             </div>
