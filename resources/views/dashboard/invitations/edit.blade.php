<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h2 class="font-heading text-2xl font-bold text-secondary-800">
                    Edit Undangan
                </h2>
                <p class="text-sm text-neutral-500 mt-0.5">{{ $invitation->title }}</p>
            </div>
            <a href="{{ route('dashboard.invitations.show', $invitation) }}"
                class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-neutral-600 bg-white border border-neutral-300 rounded-xl hover:bg-neutral-50 hover:border-primary-300 transition-all">
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
        min-height: 400px;
        position: relative;
    }

    #crop-container .cropper-container,
    #crop-container .cropper-wrap-box,
    #crop-container .cropper-canvas,
    #crop-container .cropper-view-box,
    #crop-container .cropper-crop-box,
    #crop-container .cropper-face,
    #crop-container .cropper-canvas img {
        width: 100% !important;
        height: 100% !important;
        min-width: 100% !important;
        min-height: 100% !important;
    }

    #crop-container .cropper-canvas,
    #crop-container .cropper-wrap-box {
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
    }

    #crop-container .cropper-canvas img {
        object-fit: cover !important;
        display: block !important;
    }
    </style>

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-soft border border-neutral-100 overflow-hidden">
                <div class="p-6 md:p-8">
                    <form id="invitation-form" action="{{ route('dashboard.invitations.update', $invitation) }}"
                        method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="title" value="{{ old('title', $invitation->title) }}">

                        <div class="space-y-8">
                            {{-- Bride & Groom Info --}}
                            <div class="border-b border-neutral-200 pb-8">
                                <h3 class="font-heading text-lg font-bold text-secondary-800 mb-1">Informasi Mempelai</h3>
                                <p class="text-sm text-neutral-500 mb-6">Data lengkap kedua mempelai untuk ditampilkan di undangan.</p>

                                <div class="space-y-6">
                                    {{-- Bride --}}
                                    <div class="bg-neutral-50 p-5 rounded-2xl border border-neutral-200 space-y-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-lg bg-primary-100 flex items-center justify-center text-primary">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                            </div>
                                            <h4 class="font-semibold text-sm text-primary-700">Mempelai Wanita</h4>
                                        </div>
                                        <div class="grid grid-cols-1 gap-y-5 gap-x-4 sm:grid-cols-6">
                                            <div class="sm:col-span-3">
                                                <label for="bride_name" class="block text-sm font-medium text-neutral-700">Nama Lengkap Mempelai Wanita</label>
                                                <input type="text" name="bride_name" id="bride_name"
                                                    value="{{ old('bride_name', $invitation->bride_name) }}"
                                                    class="mt-1 block w-full rounded-xl border-neutral-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm"
                                                    required>
                                                @error('bride_name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                            </div>

                                            <div class="sm:col-span-3">
                                                <label for="bride_nickname" class="block text-sm font-medium text-neutral-700">Nama Panggilan</label>
                                                <input type="text" name="bride_nickname" id="bride_nickname"
                                                    value="{{ old('bride_nickname', $invitation->bride_nickname) }}"
                                                    class="mt-1 block w-full rounded-xl border-neutral-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
                                                @error('bride_nickname') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                            </div>

                                            <div class="sm:col-span-6">
                                                <label for="bride_parents" class="block text-sm font-medium text-neutral-700">Nama Orang Tua</label>
                                                <input type="text" name="bride_parents" id="bride_parents"
                                                    value="{{ old('bride_parents', $invitation->bride_parents) }}"
                                                    class="mt-1 block w-full rounded-xl border-neutral-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm"
                                                    placeholder="Putri dari Bapak ... & Ibu ...">
                                                @error('bride_parents') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                            </div>

                                            <div class="sm:col-span-6">
                                                <label class="block text-sm font-medium text-neutral-700">Foto Mempelai Wanita</label>
                                                <div class="mt-2 flex items-center gap-4">
                                                    <div class="relative flex-shrink-0">
                                                        <img id="bride-preview"
                                                            src="{{ $invitation->bride_photo ? asset('storage/' . $invitation->bride_photo) : '' }}"
                                                            alt="Bride photo"
                                                            class="w-16 h-16 object-cover rounded-full border-2 border-neutral-200 {{ $invitation->bride_photo ? '' : 'hidden' }}">
                                                        <div id="bride-preview-placeholder"
                                                            class="w-16 h-16 bg-neutral-200 rounded-full flex items-center justify-center text-neutral-500 text-xs font-semibold {{ $invitation->bride_photo ? 'hidden' : '' }}">
                                                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                            </svg>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <input type="file" name="bride_photo" id="bride_photo_input"
                                                            class="crop-file-input hidden" accept="image/*"
                                                            data-preview="bride-preview">
                                                        <button type="button" data-crop-target="bride_photo_input"
                                                            class="px-4 py-2 bg-primary-50 text-primary-700 rounded-xl text-sm font-semibold hover:bg-primary-100 transition">
                                                            Pilih & Crop Foto
                                                        </button>
                                                        <p class="text-xs text-neutral-400 mt-1">Format JPG/PNG. Hasil potongan berbentuk persegi (400×400).</p>
                                                    </div>
                                                </div>
                                                @error('bride_photo') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Groom --}}
                                    <div class="bg-neutral-50 p-5 rounded-2xl border border-neutral-200 space-y-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-lg bg-primary-100 flex items-center justify-center text-primary">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                            </div>
                                            <h4 class="font-semibold text-sm text-primary-700">Mempelai Pria</h4>
                                        </div>
                                        <div class="grid grid-cols-1 gap-y-5 gap-x-4 sm:grid-cols-6">
                                            <div class="sm:col-span-3">
                                                <label for="groom_name" class="block text-sm font-medium text-neutral-700">Nama Lengkap Mempelai Pria</label>
                                                <input type="text" name="groom_name" id="groom_name"
                                                    value="{{ old('groom_name', $invitation->groom_name) }}"
                                                    class="mt-1 block w-full rounded-xl border-neutral-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm"
                                                    required>
                                                @error('groom_name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                            </div>

                                            <div class="sm:col-span-3">
                                                <label for="groom_nickname" class="block text-sm font-medium text-neutral-700">Nama Panggilan</label>
                                                <input type="text" name="groom_nickname" id="groom_nickname"
                                                    value="{{ old('groom_nickname', $invitation->groom_nickname) }}"
                                                    class="mt-1 block w-full rounded-xl border-neutral-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
                                                @error('groom_nickname') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                            </div>

                                            <div class="sm:col-span-6">
                                                <label for="groom_parents" class="block text-sm font-medium text-neutral-700">Nama Orang Tua</label>
                                                <input type="text" name="groom_parents" id="groom_parents"
                                                    value="{{ old('groom_parents', $invitation->groom_parents) }}"
                                                    class="mt-1 block w-full rounded-xl border-neutral-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm"
                                                    placeholder="Putra dari Bapak ... & Ibu ...">
                                                @error('groom_parents') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                            </div>

                                            <div class="sm:col-span-6">
                                                <label class="block text-sm font-medium text-neutral-700">Foto Mempelai Pria</label>
                                                <div class="mt-2 flex items-center gap-4">
                                                    <div class="relative flex-shrink-0">
                                                        <img id="groom-preview"
                                                            src="{{ $invitation->groom_photo ? asset('storage/' . $invitation->groom_photo) : '' }}"
                                                            alt="Groom photo"
                                                            class="w-16 h-16 object-cover rounded-full border-2 border-neutral-200 {{ $invitation->groom_photo ? '' : 'hidden' }}">
                                                        <div id="groom-preview-placeholder"
                                                            class="w-16 h-16 bg-neutral-200 rounded-full flex items-center justify-center text-neutral-500 text-xs font-semibold {{ $invitation->groom_photo ? 'hidden' : '' }}">
                                                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                            </svg>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <input type="file" name="groom_photo" id="groom_photo_input"
                                                            class="crop-file-input hidden" accept="image/*"
                                                            data-preview="groom-preview">
                                                        <button type="button" data-crop-target="groom_photo_input"
                                                            class="px-4 py-2 bg-primary-50 text-primary-700 rounded-xl text-sm font-semibold hover:bg-primary-100 transition">
                                                            Pilih & Crop Foto
                                                        </button>
                                                        <p class="text-xs text-neutral-400 mt-1">Format JPG/PNG. Hasil potongan berbentuk persegi (400×400).</p>
                                                    </div>
                                                </div>
                                                @error('groom_photo') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Event Details --}}
                            <div class="border-b border-neutral-200 pb-8">
                                <div class="flex items-center justify-between mb-1">
                                    <h3 class="font-heading text-lg font-bold text-secondary-800">Waktu & Tempat</h3>
                                    <button type="button" id="add-event-btn"
                                        class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-semibold rounded-xl text-primary-700 bg-primary-50 hover:bg-primary-100 transition">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                        </svg>
                                        Tambah Acara
                                    </button>
                                </div>
                                <p class="text-sm text-neutral-500 mb-6">Atur jadwal dan lokasi setiap acara.</p>

                                @error('events') <span class="text-red-500 text-xs block mb-3">{{ $message }}</span> @enderror

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
                                        <div class="event-card bg-neutral-50 p-5 rounded-2xl border border-neutral-200">
                                            <input type="hidden" name="events[{{ $eventIdx }}][id]"
                                                value="{{ $event->id ?? '' }}">
                                            <div class="flex items-center justify-between mb-4">
                                                <div class="flex items-center gap-2">
                                                    <div class="w-7 h-7 rounded-lg bg-primary-100 flex items-center justify-center text-primary">
                                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                        </svg>
                                                    </div>
                                                    <h4 class="font-semibold text-sm text-primary-700">Acara #{{ $loop->iteration }}</h4>
                                                </div>
                                                <div class="flex items-center gap-1">
                                                    <button type="button" class="move-up p-1.5 text-neutral-400 hover:text-neutral-600 hover:bg-neutral-200 rounded-lg transition" title="Pindah ke atas">
                                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                                                        </svg>
                                                    </button>
                                                    <button type="button" class="move-down p-1.5 text-neutral-400 hover:text-neutral-600 hover:bg-neutral-200 rounded-lg transition" title="Pindah ke bawah">
                                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                                        </svg>
                                                    </button>
                                                    <button type="button" class="remove-event ml-1 p-1.5 text-red-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition" title="Hapus acara">
                                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="grid grid-cols-1 gap-y-4 gap-x-4 sm:grid-cols-6">
                                                <div class="sm:col-span-6">
                                                    <label class="block text-sm font-medium text-neutral-700">Nama Acara</label>
                                                    <input type="text" name="events[{{ $eventIdx }}][event_title]"
                                                        value="{{ old('events.' . $eventIdx . '.event_title', $event->event_title ?? '') }}"
                                                        list="event-titles-{{ $eventIdx }}"
                                                        class="mt-1 block w-full rounded-xl border-neutral-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm"
                                                        placeholder="Pilih atau ketik nama acara" required>
                                                    <datalist id="event-titles-{{ $eventIdx }}">
                                                        <option value="Akad Nikah">
                                                        <option value="Resepsi">
                                                        <option value="Pengajian">
                                                        <option value="Unduh Mantu">
                                                    </datalist>
                                                </div>
                                                <div class="sm:col-span-2">
                                                    <label class="block text-sm font-medium text-neutral-700">Tanggal Acara</label>
                                                    <input type="date" name="events[{{ $eventIdx }}][event_date]"
                                                        value="{{ old('events.' . $eventIdx . '.event_date', $event->event_date instanceof \Carbon\Carbon ? $event->event_date->format('Y-m-d') : ($event->event_date ?? '')) }}"
                                                        class="mt-1 block w-full rounded-xl border-neutral-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm"
                                                        required>
                                                </div>
                                                <div class="sm:col-span-2">
                                                    <label class="block text-sm font-medium text-neutral-700">Jam Mulai</label>
                                                    <input type="time" name="events[{{ $eventIdx }}][start_time]"
                                                        value="{{ old('events.' . $eventIdx . '.start_time', $event->start_time ?? '') }}"
                                                        class="mt-1 block w-full rounded-xl border-neutral-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm"
                                                        required>
                                                </div>
                                                <div class="sm:col-span-2">
                                                    <label class="block text-sm font-medium text-neutral-700">Jam Selesai</label>
                                                    <input type="time" name="events[{{ $eventIdx }}][end_time]"
                                                        value="{{ old('events.' . $eventIdx . '.end_time', $event->end_time ?? '') }}"
                                                        class="mt-1 block w-full rounded-xl border-neutral-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
                                                    <div class="mt-1.5 flex items-center">
                                                        <input type="hidden" name="events[{{ $eventIdx }}][is_until_finished]" value="0">
                                                        <input type="checkbox" name="events[{{ $eventIdx }}][is_until_finished]" value="1"
                                                            {{ old('events.' . $eventIdx . '.is_until_finished', $event->is_until_finished ?? false) ? 'checked' : '' }}
                                                            class="h-4 w-4 rounded border-neutral-300 text-primary-600 focus:ring-primary-500">
                                                        <label class="ml-2 text-xs text-neutral-500">Sampai Selesai</label>
                                                    </div>
                                                </div>
                                                <div class="sm:col-span-6">
                                                    <label class="block text-sm font-medium text-neutral-700">Nama Tempat / Lokasi</label>
                                                    <input type="text" name="events[{{ $eventIdx }}][place_name]"
                                                        value="{{ old('events.' . $eventIdx . '.place_name', $event->place_name ?? '') }}"
                                                        class="mt-1 block w-full rounded-xl border-neutral-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm"
                                                        placeholder="Nama gedung atau lokasi" required>
                                                </div>
                                                <div class="sm:col-span-6">
                                                    <label class="block text-sm font-medium text-neutral-700">Alamat Lengkap</label>
                                                    <textarea name="events[{{ $eventIdx }}][place_address]" rows="2"
                                                        class="mt-1 block w-full rounded-xl border-neutral-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm"
                                                        placeholder="Alamat lengkap lokasi"
                                                        required>{{ old('events.' . $eventIdx . '.place_address', $event->place_address ?? '') }}</textarea>
                                                </div>
                                                <div class="sm:col-span-6">
                                                    <label class="block text-sm font-medium text-neutral-700">Link Google Maps</label>
                                                    <input type="url" name="events[{{ $eventIdx }}][google_maps_url]"
                                                        value="{{ old('events.' . $eventIdx . '.google_maps_url', $event->google_maps_url ?? '') }}"
                                                        class="mt-1 block w-full rounded-xl border-neutral-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm"
                                                        placeholder="https://goo.gl/maps/...">
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="mt-6">
                                    <label for="timezone" class="block text-sm font-medium text-neutral-700">Zona Waktu</label>
                                    <select name="timezone" id="timezone"
                                        class="mt-1 block w-full rounded-xl border-neutral-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
                                        <option value="Asia/Jakarta"
                                            {{ old('timezone', $invitation->timezone) == 'Asia/Jakarta' ? 'selected' : '' }}>
                                            WIB (Waktu Indonesia Barat)
                                        </option>
                                        <option value="Asia/Makassar"
                                            {{ old('timezone', $invitation->timezone) == 'Asia/Makassar' ? 'selected' : '' }}>
                                            WITA (Waktu Indonesia Tengah)
                                        </option>
                                        <option value="Asia/Jayapura"
                                            {{ old('timezone', $invitation->timezone) == 'Asia/Jayapura' ? 'selected' : '' }}>
                                            WIT (Waktu Indonesia Timur)
                                        </option>
                                    </select>
                                    @error('timezone') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            {{-- Custom URL / Slug --}}
                            <div class="border-b border-neutral-200 pb-8">
                                <h3 class="font-heading text-lg font-bold text-secondary-800 mb-1">Tautan Undangan</h3>
                                <p class="text-sm text-neutral-500 mb-6">Sesuaikan tautan undangan Anda.</p>

                                <div class="bg-neutral-50 p-5 rounded-2xl border border-neutral-200 space-y-4">
                                    <div>
                                        <label for="slug-input" class="block text-sm font-medium text-neutral-700">Tautan Kustom</label>
                                        <div class="mt-1.5 flex items-stretch gap-0">
                                            <span class="inline-flex items-center px-3 rounded-l-xl border border-r-0 border-neutral-300 bg-neutral-100 text-sm text-neutral-500 whitespace-nowrap">{{ parse_url(config('app.url'), PHP_URL_HOST) }}/</span>
                                            <input type="text" name="slug" id="slug-input"
                                                value="{{ old('slug', $invitation->slug) }}"
                                                data-original="{{ $invitation->slug }}" data-id="{{ $invitation->id }}"
                                                class="block w-full rounded-r-xl border-neutral-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm font-mono"
                                                placeholder="nama-undangan-anda" maxlength="100"
                                                pattern="^[a-z0-9\-]+$">
                                        </div>
                                        <div id="slug-indicator" class="mt-1.5 text-xs flex items-center gap-1.5 text-neutral-400">
                                            <span class="slug-icon text-base">🔗</span>
                                            <span class="slug-text">Masukkan tautan kustom</span>
                                        </div>
                                        @error('slug') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                        <p class="mt-1.5 text-xs text-neutral-400">Huruf kecil, angka, dan tanda hubung (-)</p>
                                    </div>

                                    <div class="bg-amber-50 border border-amber-200 rounded-xl p-4">
                                        <div class="flex items-start gap-3">
                                            <span class="text-amber-600 flex-shrink-0 mt-0.5">⚠</span>
                                            <div>
                                                <p class="text-xs font-semibold text-amber-800">Perhatian</p>
                                                <p class="text-xs text-amber-700 mt-0.5">Mengubah tautan akan membuat tautan lama tidak bisa diakses. Pastikan Anda belum menyebarkan tautan lama ke tamu undangan.</p>
                                                @if($invitation->slug_change_count > 0)
                                                    <p class="text-xs text-amber-700 mt-1">Tautan telah diubah {{ $invitation->slug_change_count }} kali.</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Additional Info & Features --}}
                            <div class="border-b border-neutral-200 pb-8">
                                <h3 class="font-heading text-lg font-bold text-secondary-800 mb-1">Pengaturan & Fitur</h3>
                                <p class="text-sm text-neutral-500 mb-6">Personalisasi undangan dengan fitur tambahan.</p>

                                <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                                    {{-- Love Story --}}
                                    <div class="sm:col-span-6">
                                        <div class="flex items-center justify-between mb-3">
                                            <label class="block text-sm font-medium text-neutral-700">Cerita Cinta (Love Story)</label>
                                            <button type="button" id="add-story-btn" class="text-xs text-primary-600 hover:text-primary-700 font-semibold">+ Tambah Momen</button>
                                        </div>
                                        <div id="stories-container" class="space-y-3">
                                            @php $storyCollection = old('stories', $invitation->stories->toArray()); @endphp
                                            @foreach($storyCollection as $storyIdx => $story)
                                                @php $story = (object) $story; @endphp
                                                <div class="story-card bg-neutral-50 p-4 rounded-xl border border-neutral-200 space-y-3">
                                                    <div class="flex items-center justify-between">
                                                        <span class="text-xs font-semibold text-neutral-500">Momen #{{ $loop->iteration }}</span>
                                                        <button type="button" class="remove-story text-red-400 hover:text-red-600 text-xs font-semibold">Hapus</button>
                                                    </div>
                                                    @if(!empty($story->id))<input type="hidden" name="stories[{{ $storyIdx }}][id]" value="{{ $story->id }}">@endif
                                                    <div>
                                                        <input type="text" name="stories[{{ $storyIdx }}][story_date]" value="{{ old('stories.' . $storyIdx . '.story_date', $story->story_date ?? '') }}" class="block w-full rounded-xl border-neutral-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 text-xs" placeholder="Waktu (contoh: Tahun 2022, Maret 2024, 12 Desember 2025)">
                                                        @error('stories.' . $storyIdx . '.story_date') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                                    </div>
                                                    <div>
                                                        <textarea name="stories[{{ $storyIdx }}][story_description]" rows="2" class="block w-full rounded-xl border-neutral-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 text-xs" placeholder="Ceritakan momen indah Anda...">{{ old('stories.' . $storyIdx . '.story_description', $story->story_description ?? '') }}</textarea>
                                                        @error('stories.' . $storyIdx . '.story_description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <template id="story-card-template">
                                            <div class="story-card bg-neutral-50 p-4 rounded-xl border border-neutral-200 space-y-3">
                                                <div class="flex items-center justify-between">
                                                    <span class="text-xs font-semibold text-neutral-500">Momen Baru</span>
                                                    <button type="button" class="remove-story text-red-400 hover:text-red-600 text-xs font-semibold">Hapus</button>
                                                </div>
                                                <div>
                                                    <input type="text" name="stories[__INDEX__][story_date]" class="block w-full rounded-xl border-neutral-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 text-xs" placeholder="Waktu (contoh: Tahun 2022, Maret 2024, 12 Desember 2025)">
                                                </div>
                                                <div>
                                                    <textarea name="stories[__INDEX__][story_description]" rows="2" class="block w-full rounded-xl border-neutral-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 text-xs" placeholder="Ceritakan momen indah Anda..."></textarea>
                                                </div>
                                            </div>
                                        </template>
                                        <p class="text-xs text-neutral-400 mt-2">Bagikan momen-momen berharga perjalanan cinta Anda kepada para tamu.</p>
                                    </div>

                                    {{-- Quote --}}
                                    <div class="sm:col-span-6">
                                        <label for="quote_content" class="block text-sm font-medium text-neutral-700">Kutipan / Ayat Suci</label>
                                        <textarea name="quote_content" id="quote_content" rows="4"
                                            class="mt-1 block w-full rounded-xl border-neutral-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm"
                                            placeholder="Tulis kutipan ayat suci atau kutipan romantis...">{{ old('quote_content', $invitation->quote_content) }}</textarea>
                                        <p class="text-xs text-neutral-400 mt-1">Isi kutipan, ayat suci, atau pesan romantis.</p>
                                        @error('quote_content') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="sm:col-span-6">
                                        <label for="quote_source" class="block text-sm font-medium text-neutral-700">Sumber Kutipan</label>
                                        <input type="text" name="quote_source" id="quote_source"
                                            value="{{ old('quote_source', $invitation->quote_source) }}"
                                            class="mt-1 block w-full rounded-xl border-neutral-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm"
                                            placeholder="Contoh: Ar-Rum: 21, Kahlil Gibran, QS. Al-Baqarah: 45">
                                        <p class="text-xs text-neutral-400 mt-1">Nama tokoh, buku, atau pasal ayat sebagai sumber kutipan.</p>
                                        @error('quote_source') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                    </div>

                                    {{-- Theme --}}
                                    <div class="sm:col-span-6">
                                        <label for="theme" class="block text-sm font-medium text-neutral-700">Tema Undangan</label>
                                        <select name="theme" id="theme"
                                            class="mt-1 block w-full rounded-xl border-neutral-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
                                            @foreach($themes as $tema)
                                                @php $themeKey = str_replace('themes.', '', $tema->view_path); @endphp
                                                <option value="{{ $themeKey }}"
                                                    {{ old('theme', $invitation->theme) == $themeKey ? 'selected' : '' }}>
                                                    {{ $tema->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('theme') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                    </div>

                                    {{-- Music --}}
                                    <div class="sm:col-span-6">
                                        <label class="block text-sm font-medium text-neutral-700">Musik Latar Belakang</label>
                                        @if($invitation->canUseCustomMusic())
                                            <div class="mt-2 space-y-2">
                                                @if($invitation->music_url)
                                                    <div class="flex items-center gap-3 bg-primary-50 p-3 rounded-xl border border-primary-100">
                                                        <span class="text-xs font-semibold text-primary-700">🎵 Musik Aktif:</span>
                                                        <audio src="{{ asset('storage/' . $invitation->music_url) }}" controls
                                                            class="h-8 max-w-xs"></audio>
                                                    </div>
                                                @endif
                                                <input type="file" name="music_file" id="music_file"
                                                    class="text-sm text-neutral-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100">
                                                <p class="text-xs text-neutral-500">Mendukung format MP3, WAV, OGG (Maks 10MB).</p>
                                            </div>
                                        @else
                                            <div class="mt-2 bg-amber-50 border border-amber-200 rounded-xl p-4 flex items-center gap-3">
                                                <span class="text-xl">✨</span>
                                                <div>
                                                    <p class="text-sm font-semibold text-amber-800">Fitur Kustom Musik Terkunci</p>
                                                    <p class="text-xs text-amber-700">Silakan upgrade ke paket Gold atau Platinum untuk mengunggah musik latar belakang favorit Anda.</p>
                                                </div>
                                            </div>
                                        @endif
                                    </div>

                                    {{-- Active toggle --}}
                                    <div class="sm:col-span-6">
                                        <div class="flex items-start gap-3 p-4 bg-neutral-50 rounded-xl border border-neutral-200">
                                            <div class="flex h-5 items-center">
                                                <input type="hidden" name="is_active" value="0">
                                                <input id="is_active" name="is_active" type="checkbox" value="1"
                                                    {{ old('is_active', $invitation->is_active) ? 'checked' : '' }}
                                                    class="h-4 w-4 rounded border-neutral-300 text-primary-600 focus:ring-primary-500">
                                            </div>
                                            <div class="text-sm">
                                                <label for="is_active" class="font-medium text-neutral-700">Aktifkan Undangan</label>
                                                <p class="text-neutral-500 text-xs mt-0.5">Undangan yang tidak aktif tidak dapat diakses oleh tamu.</p>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Template for new event card (hidden, cloned by JS) --}}
                            <template id="event-card-template">
                                <div class="event-card bg-neutral-50 p-5 rounded-2xl border border-neutral-200">
                                    <input type="hidden" name="events[__INDEX__][id]" value="">
                                    <div class="flex items-center justify-between mb-4">
                                        <div class="flex items-center gap-2">
                                            <div class="w-7 h-7 rounded-lg bg-primary-100 flex items-center justify-center text-primary">
                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                            <h4 class="font-semibold text-sm text-primary-700">Acara Baru</h4>
                                        </div>
                                        <div class="flex items-center gap-1">
                                            <button type="button" class="move-up p-1.5 text-neutral-400 hover:text-neutral-600 hover:bg-neutral-200 rounded-lg transition" title="Pindah ke atas">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                                                </svg>
                                            </button>
                                            <button type="button" class="move-down p-1.5 text-neutral-400 hover:text-neutral-600 hover:bg-neutral-200 rounded-lg transition" title="Pindah ke bawah">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                                </svg>
                                            </button>
                                            <button type="button" class="remove-event ml-1 p-1.5 text-red-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition" title="Hapus acara">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-1 gap-y-4 gap-x-4 sm:grid-cols-6">
                                        <div class="sm:col-span-6">
                                            <label class="block text-sm font-medium text-neutral-700">Nama Acara</label>
                                            <input type="text" name="events[__INDEX__][event_title]" value=""
                                                list="event-titles-__INDEX__"
                                                class="mt-1 block w-full rounded-xl border-neutral-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm"
                                                placeholder="Pilih atau ketik nama acara" required>
                                            <datalist id="event-titles-__INDEX__">
                                                <option value="Akad Nikah">
                                                <option value="Resepsi">
                                                <option value="Pengajian">
                                                <option value="Unduh Mantu">
                                            </datalist>
                                        </div>
                                        <div class="sm:col-span-2">
                                            <label class="block text-sm font-medium text-neutral-700">Tanggal Acara</label>
                                            <input type="date" name="events[__INDEX__][event_date]" value=""
                                                class="mt-1 block w-full rounded-xl border-neutral-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm" required>
                                        </div>
                                        <div class="sm:col-span-2">
                                            <label class="block text-sm font-medium text-neutral-700">Jam Mulai</label>
                                            <input type="time" name="events[__INDEX__][start_time]" value=""
                                                class="mt-1 block w-full rounded-xl border-neutral-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm" required>
                                        </div>
                                        <div class="sm:col-span-2">
                                            <label class="block text-sm font-medium text-neutral-700">Jam Selesai</label>
                                            <input type="time" name="events[__INDEX__][end_time]" value=""
                                                class="mt-1 block w-full rounded-xl border-neutral-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
                                            <div class="mt-1.5 flex items-center">
                                                <input type="hidden" name="events[__INDEX__][is_until_finished]" value="0">
                                                <input type="checkbox" name="events[__INDEX__][is_until_finished]" value="1"
                                                    class="h-4 w-4 rounded border-neutral-300 text-primary-600 focus:ring-primary-500">
                                                <label class="ml-2 text-xs text-neutral-500">Sampai Selesai</label>
                                            </div>
                                        </div>
                                        <div class="sm:col-span-6">
                                            <label class="block text-sm font-medium text-neutral-700">Nama Tempat / Lokasi</label>
                                            <input type="text" name="events[__INDEX__][place_name]" value=""
                                                class="mt-1 block w-full rounded-xl border-neutral-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm"
                                                placeholder="Nama gedung atau lokasi" required>
                                        </div>
                                        <div class="sm:col-span-6">
                                            <label class="block text-sm font-medium text-neutral-700">Alamat Lengkap</label>
                                            <textarea name="events[__INDEX__][place_address]" rows="2"
                                                class="mt-1 block w-full rounded-xl border-neutral-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm"
                                                placeholder="Alamat lengkap lokasi" required></textarea>
                                        </div>
                                        <div class="sm:col-span-6">
                                            <label class="block text-sm font-medium text-neutral-700">Link Google Maps</label>
                                            <input type="url" name="events[__INDEX__][google_maps_url]" value=""
                                                class="mt-1 block w-full rounded-xl border-neutral-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm"
                                                placeholder="https://goo.gl/maps/...">
                                        </div>
                                    </div>
                                </div>
                            </template>

                            {{-- Feature visibility --}}
                                    </div>
                                    <div class="sm:col-span-6">
                                        <div class="bg-neutral-50 rounded-2xl border border-neutral-200 p-5">
                                            <h4 class="text-sm font-semibold text-secondary-800 mb-1">Visibilitas Fitur</h4>
                                            <p class="text-xs text-neutral-500 mb-4">Atur tampilan setiap fitur di halaman undangan publik.</p>
                                            <div class="space-y-4">
                                                @php
                                                    $toggles = [
                                                        ['id' => 'show_rsvp', 'label' => 'RSVP', 'desc' => 'Tampilkan form konfirmasi kehadiran'],
                                                        ['id' => 'show_gallery', 'label' => 'Galeri Foto', 'desc' => 'Tampilkan galeri foto momen indah'],
                                                        ['id' => 'show_gift', 'label' => 'Kado Digital', 'desc' => 'Tampilkan informasi transfer bank & e-wallet'],
                                                        ['id' => 'show_stories', 'label' => 'Cerita Cinta', 'desc' => 'Tampilkan timeline perjalanan cinta'],
                                                        ['id' => 'show_countdown', 'label' => 'Hitung Mundur', 'desc' => 'Tampilkan timer hitung mundur ke acara'],
                                                        ['id' => 'show_event_detail', 'label' => 'Detail Acara', 'desc' => 'Tampilkan informasi waktu & tempat'],
                                                        ['id' => 'show_quote', 'label' => 'Kutipan', 'desc' => 'Tampilkan kutipan atau ayat suci'],
                                                        ['id' => 'show_qr_checkin', 'label' => 'QR Check-In', 'desc' => 'Tampilkan kode QR unik tamu'],
                                                        ['id' => 'show_comments', 'label' => 'Buku Tamu / Komentar', 'desc' => 'Tampilkan kolom ucapan dan doa'],
                                                    ];
                                                @endphp
                                                @foreach($toggles as $toggle)
                                                <div class="flex items-center justify-between py-1">
                                                    <div class="text-sm flex-1 pr-4">
                                                        <label for="{{ $toggle['id'] }}" class="font-medium text-neutral-700">{{ $toggle['label'] }}</label>
                                                        <p class="text-neutral-500 text-xs">{{ $toggle['desc'] }}</p>
                                                    </div>
                                                    <label class="relative inline-flex items-center cursor-pointer flex-shrink-0">
                                                        <input type="hidden" name="{{ $toggle['id'] }}" value="0">
                                                        <input type="checkbox" name="{{ $toggle['id'] }}" id="{{ $toggle['id'] }}"
                                                            value="1"
                                                            {{ old($toggle['id'], $invitation->{$toggle['id']}) ? 'checked' : '' }}
                                                            class="sr-only peer">
                                                        <div class="w-9 h-5 bg-neutral-200 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-neutral-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-primary-500"></div>
                                                    </label>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Fixed bottom bar --}}
            <div class="fixed bottom-0 left-0 right-0 bg-white/95 backdrop-blur-sm border-t border-neutral-200 shadow-soft z-40">
                <div class="max-w-4xl mx-auto px-6 py-3.5 flex justify-end items-center">
                    <a href="{{ route('dashboard.invitations.show', $invitation) }}"
                        class="inline-flex items-center px-5 py-2.5 bg-white border border-neutral-300 rounded-xl shadow-sm text-sm font-semibold text-neutral-700 hover:bg-neutral-50 hover:border-primary-300 transition-all mr-3">
                        Batal
                    </a>
                    <button type="submit" form="invitation-form"
                        class="inline-flex items-center gap-2 px-6 py-2.5 bg-gradient-to-r from-primary to-primary-600 rounded-xl shadow-sm text-sm font-semibold text-white hover:shadow-md hover:scale-[1.02] active:scale-[0.98] focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition-all">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Simpan Perubahan
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Spacer for fixed bottom bar --}}
    <div class="h-16"></div>

    {{-- Crop Modal --}}
    <div id="crop-modal" class="hidden fixed inset-0 z-50 bg-black/60 items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg overflow-hidden">
            <div class="p-4 border-b border-neutral-100 flex items-center justify-between">
                <h3 class="text-lg font-semibold text-secondary-800">Crop Foto</h3>
                <button type="button" class="crop-close text-neutral-400 hover:text-neutral-600 transition">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="p-4 bg-secondary-900 flex items-center justify-center" style="min-height:300px">
                <div id="crop-container" class="w-full mx-auto flex items-center justify-center"
                    style="max-width:500px;min-height:350px;overflow:hidden">
                </div>
            </div>
            <div class="p-4 border-t border-neutral-100">
                <div class="flex items-center justify-center gap-3 mb-4">
                    <button type="button" id="crop-zoom-out"
                        class="p-2 rounded-xl bg-neutral-100 hover:bg-neutral-200 text-neutral-700 transition" title="Perkecil">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                        </svg>
                    </button>
                    <button type="button" id="crop-zoom-in"
                        class="p-2 rounded-xl bg-neutral-100 hover:bg-neutral-200 text-neutral-700 transition" title="Perbesar">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                    </button>
                    <button type="button" id="crop-rotate"
                        class="p-2 rounded-xl bg-neutral-100 hover:bg-neutral-200 text-neutral-700 transition" title="Rotate">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                    </button>
                </div>
                <div class="flex gap-3">
                    <button type="button"
                        class="crop-close flex-1 px-4 py-2.5 border border-neutral-300 rounded-xl text-sm font-semibold text-neutral-700 hover:bg-neutral-50 transition">
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
            if (card && confirm('Hapus acara ini?')) {
                card.remove();
                reindexEvents();
            }
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

        addBtn.addEventListener('click', addEventCard);

        const storiesContainer = document.getElementById('stories-container');
        const storyTemplate = document.getElementById('story-card-template');
        const addStoryBtn = document.getElementById('add-story-btn');

        function reindexStories() {
            const cards = storiesContainer.querySelectorAll('.story-card');
            cards.forEach(function(card, idx) {
                const inputs = card.querySelectorAll('[name]');
                inputs.forEach(function(input) {
                    const name = input.getAttribute('name');
                    if (name) {
                        input.setAttribute('name', name.replace(/stories\[\d+\]/, 'stories[' + idx + ']'));
                    }
                });
                const label = card.querySelector('span.text-xs.font-semibold');
                if (label) {
                    label.textContent = 'Momen #' + (idx + 1);
                }
            });
        }

        function addStoryCard() {
            const clone = storyTemplate.content.cloneNode(true);
            const html = clone.querySelector('.story-card').outerHTML.replace(/__INDEX__/g, storiesContainer.children.length);
            const wrapper = document.createElement('div');
            wrapper.innerHTML = html;
            const card = wrapper.firstElementChild;
            storiesContainer.appendChild(card);
            reindexStories();
        }

        storiesContainer.addEventListener('click', function(e) {
            if (e.target.closest('.remove-story')) {
                e.target.closest('.story-card').remove();
                reindexStories();
            }
        });

        if (addStoryBtn) {
            addStoryBtn.addEventListener('click', addStoryCard);
        }
    });
    </script>
</x-app-layout>
