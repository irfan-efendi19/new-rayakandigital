{{-- ======================================== --}}
                        {{-- Section 8: Kontrol Visibilitas & Finalisasi --}}
                        {{-- ======================================== --}}
                        <div id="sec-8"
                            x-show="activeSection === 'sec-8'"
                            x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 translate-x-4"
                            x-transition:enter-end="opacity-100 translate-x-0"
                            class="scroll-mt-32"
                            x-cloak>
                            <div class="mb-3">
                                <h3 class="font-heading text-lg font-bold text-secondary-800 dark:text-neutral-100">
                                    Kontrol Visibilitas & Finalisasi <span class="text-sm font-normal text-neutral-400 dark:text-neutral-500">(Fitur Publik)</span>
                                </h3>
                            </div>
                            <p class="text-sm text-neutral-500 dark:text-neutral-400 mb-6">
                                Atur visibilitas dan
                                tampilan fitur di halaman undangan
                                publik.</p>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                {{-- Card 1: Fitur Interaktif --}}
                                <div class="bg-neutral-50 dark:bg-secondary-700/60 rounded-2xl border border-neutral-200 dark:border-secondary-600 p-5 flex flex-col justify-between">
                                    <div>
                                        <div class="flex items-center gap-2 mb-4 pb-3 border-b border-neutral-200/80 dark:border-secondary-600">
                                            <svg class="w-4 h-4 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"></path>
                                            </svg>
                                            <h4 class="text-sm font-bold text-secondary-800 dark:text-neutral-100">
                                                Fitur Interaktif
                                            </h4>
                                        </div>
                                        <div class="space-y-4">
                                            @php
                                                $interactiveToggles = [
                                                    [
                                                        'id' => 'show_rsvp',
                                                        'label' => 'RSVP',
                                                        'desc' => 'Tampilkan form konfirmasi kehadiran'
                                                    ],
                                                    [
                                                        'id' => 'show_gallery',
                                                        'label' => 'Galeri Foto',
                                                        'desc' => 'Tampilkan galeri foto momen indah'
                                                    ],
                                                    [
                                                        'id' => 'show_gift',
                                                        'label' => 'Kado Digital',
                                                        'desc' => 'Tampilkan informasi transfer bank & e-wallet'
                                                    ],
                                                    [
                                                        'id' => 'show_comments',
                                                        'label' => 'Buku Tamu / Komentar',
                                                        'desc' => 'Tampilkan kolom ucapan dan doa'
                                                    ],
                                                    [
                                                        'id' => 'show_qr_checkin',
                                                        'label' => 'QR Check-In',
                                                        'desc' => 'Tampilkan kode QR unik tamu'
                                                    ],
                                                ];
                                            @endphp
                                            @foreach($interactiveToggles as $toggle)
                                                <div class="flex items-start gap-3 py-1">
                                                    <div class="text-sm flex-1">
                                                        <label for="{{ $toggle['id'] }}"
                                                            class="font-medium text-neutral-700 dark:text-neutral-300 cursor-pointer">{{ $toggle['label'] }}</label>
                                                        <p class="text-neutral-500 dark:text-neutral-400 text-xs">
                                                            {{ $toggle['desc'] }}
                                                        </p>
                                                    </div>
                                                    <label class="relative inline-flex items-center cursor-pointer flex-shrink-0 mt-0.5">
                                                        <input type="hidden" name="{{ $toggle['id'] }}" value="0">
                                                        <input type="checkbox" name="{{ $toggle['id'] }}" id="{{ $toggle['id'] }}"
                                                            value="1"
                                                            {{ old($toggle['id'], $invitation->{$toggle['id']}) ? 'checked' : '' }}
                                                            class="sr-only peer">
                                                        <div
                                                            class="w-9 h-5 bg-neutral-200 dark:bg-secondary-800 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-neutral-300 dark:after:border-neutral-600 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-primary-500">
                                                        </div>
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                {{-- Card 2: Visibilitas Fitur --}}
                                <div class="bg-neutral-50 dark:bg-secondary-700/60 rounded-2xl border border-neutral-200 dark:border-secondary-600 p-5 flex flex-col justify-between">
                                    <div>
                                        <div class="flex items-center gap-2 mb-4 pb-3 border-b border-neutral-200/80 dark:border-secondary-600">
                                            <svg class="w-4 h-4 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                            <h4 class="text-sm font-bold text-secondary-800 dark:text-neutral-100">
                                                Visibilitas Fitur
                                            </h4>
                                        </div>
                                        <div class="space-y-4">
                                            @php
                                                $visibilityToggles = [
                                                    [
                                                        'id' => 'show_stories',
                                                        'label' => 'Cerita Cinta',
                                                        'desc' => 'Tampilkan timeline perjalanan cinta'
                                                    ],
                                                    [
                                                        'id' => 'show_countdown',
                                                        'label' => 'Hitung Mundur',
                                                        'desc' => 'Tampilkan timer hitung mundur ke acara'
                                                    ],
                                                    [
                                                        'id' => 'show_event_detail',
                                                        'label' => 'Detail Acara',
                                                        'desc' => 'Tampilkan informasi waktu & tempat'
                                                    ],
                                                    [
                                                        'id' => 'show_quote',
                                                        'label' => 'Kutipan',
                                                        'desc' => 'Tampilkan kutipan atau ayat suci'
                                                    ],
                                                    [
                                                        'id' => 'show_video',
                                                        'label' => 'Video YouTube',
                                                        'desc' => 'Tampilkan video YouTube & live streaming'
                                                    ],
                                                ];
                                            @endphp
                                            @foreach($visibilityToggles as $toggle)
                                                <div class="flex items-start gap-3 py-1">
                                                    <div class="text-sm flex-1">
                                                        <label for="{{ $toggle['id'] }}"
                                                            class="font-medium text-neutral-700 dark:text-neutral-300 cursor-pointer">{{ $toggle['label'] }}</label>
                                                        <p class="text-neutral-500 dark:text-neutral-400 text-xs">
                                                            {{ $toggle['desc'] }}
                                                        </p>
                                                    </div>
                                                    <label class="relative inline-flex items-center cursor-pointer flex-shrink-0 mt-0.5">
                                                        <input type="hidden" name="{{ $toggle['id'] }}" value="0">
                                                        <input type="checkbox" name="{{ $toggle['id'] }}" id="{{ $toggle['id'] }}"
                                                            value="1"
                                                            {{ old($toggle['id'], $invitation->{$toggle['id']}) ? 'checked' : '' }}
                                                            class="sr-only peer">
                                                        <div
                                                            class="w-9 h-5 bg-neutral-200 dark:bg-secondary-800 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-neutral-300 dark:after:border-neutral-600 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-primary-500">
                                                        </div>
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Active toggle --}}
                            @php $isActive = old('is_active', $invitation->is_active); @endphp
                            <div class="mt-6">
                                <input type="hidden" name="is_active" value="{{ $isActive ? '1' : '0' }}">
                                <div class="flex flex-col sm:flex-row sm:items-center gap-3 p-4 bg-neutral-50 dark:bg-secondary-700 rounded-xl border border-neutral-200 dark:border-secondary-700">
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-neutral-700 dark:text-neutral-300">Status Undangan</p>
                                        <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-0.5">Undangan yang tidak aktif tidak dapat diakses oleh tamu.</p>
                                    </div>
                                    <div class="flex gap-2">
                                        <button type="button" id="activate-btn"
                                            class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold transition-all {{ $isActive ? 'bg-emerald-100 dark:bg-emerald-900/50 text-emerald-700 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800' : 'bg-white dark:bg-secondary-800 border border-neutral-300 dark:border-neutral-600 text-neutral-600 dark:text-neutral-400 hover:border-emerald-300 hover:text-emerald-600' }}">
                                            <span class="w-2 h-2 rounded-full {{ $isActive ? 'bg-emerald-500' : 'bg-neutral-300 dark:bg-neutral-500' }}"></span>
                                            Aktif
                                        </button>
                                        <button type="button" id="deactivate-btn"
                                            class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold transition-all {{ !$isActive ? 'bg-red-100 dark:bg-red-900/50 text-red-700 dark:text-red-300 border border-red-200 dark:border-red-800' : 'bg-white dark:bg-secondary-800 border border-neutral-300 dark:border-neutral-600 text-neutral-600 dark:text-neutral-400 hover:border-red-300 hover:text-red-600' }}">
                                            <span class="w-2 h-2 rounded-full {{ !$isActive ? 'bg-red-500' : 'bg-neutral-300 dark:bg-neutral-500' }}"></span>
                                            Nonaktif
                                        </button>
                                    </div>
                                </div>
