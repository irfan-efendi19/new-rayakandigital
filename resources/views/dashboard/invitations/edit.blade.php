<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Undangan: ') }} {{ $invitation->title }}
        </h2>
    </x-slot>

    <style>
        #crop-container cropper-canvas,
        #crop-container cropper-image {
            width: 100% !important;
            height: 100% !important;
        }
    </style>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('dashboard.invitations.update', $invitation) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="space-y-6">
                            <!-- Basic Info -->
                            <div class="border-b border-gray-200 pb-6">
                                <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Informasi Mempelai</h3>
                                
                                <div class="space-y-6">
                                    <!-- Mempelai Wanita -->
                                    <div class="bg-gray-50 p-4 rounded-xl space-y-4">
                                        <h4 class="font-semibold text-sm text-indigo-700">Mempelai Wanita</h4>
                                        <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                                            <div class="sm:col-span-3">
                                                <label for="bride_name" class="block text-sm font-medium text-gray-700">Nama Lengkap Mempelai Wanita</label>
                                                <input type="text" name="bride_name" id="bride_name" value="{{ old('bride_name', $invitation->bride_name) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                                                @error('bride_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                            </div>

                                            <div class="sm:col-span-3">
                                                <label for="bride_nickname" class="block text-sm font-medium text-gray-700">Nama Panggilan</label>
                                                <input type="text" name="bride_nickname" id="bride_nickname" value="{{ old('bride_nickname', $invitation->bride_nickname) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                                @error('bride_nickname') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                            </div>

                                            <div class="sm:col-span-6">
                                                <label for="bride_parents" class="block text-sm font-medium text-gray-700">Nama Orang Tua</label>
                                                <input type="text" name="bride_parents" id="bride_parents" value="{{ old('bride_parents', $invitation->bride_parents) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Putri dari Bapak ... & Ibu ...">
                                                @error('bride_parents') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                            </div>

                                            <div class="sm:col-span-6">
                                                <label class="block text-sm font-medium text-gray-700">Foto Mempelai Wanita</label>
                                                <div class="mt-1 flex items-center gap-4">
                                                    <div class="relative flex-shrink-0">
                                                        <img id="bride-preview" src="{{ $invitation->bride_photo ? asset('storage/' . $invitation->bride_photo) : '' }}" alt="Bride photo" class="w-16 h-16 object-cover rounded-full border {{ $invitation->bride_photo ? '' : 'hidden' }}">
                                                        <div id="bride-preview-placeholder" class="w-16 h-16 bg-gray-200 rounded-full flex items-center justify-center text-gray-400 text-xs font-semibold {{ $invitation->bride_photo ? 'hidden' : '' }}">No Photo</div>
                                                    </div>
                                                    <div>
                                                        <input type="file" name="bride_photo" id="bride_photo_input" class="crop-file-input hidden" accept="image/*" data-preview="bride-preview">
                                                        <button type="button" data-crop-target="bride_photo_input" class="px-4 py-2 bg-indigo-50 text-indigo-700 rounded-md text-sm font-semibold hover:bg-indigo-100 transition">
                                                            Pilih & Crop Foto
                                                        </button>
                                                        <p class="text-xs text-gray-400 mt-1">Format JPG/PNG. Foto akan dipotong persegi secara otomatis.</p>
                                                    </div>
                                                </div>
                                                @error('bride_photo') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Mempelai Pria -->
                                    <div class="bg-gray-50 p-4 rounded-xl space-y-4">
                                        <h4 class="font-semibold text-sm text-indigo-700">Mempelai Pria</h4>
                                        <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                                            <div class="sm:col-span-3">
                                                <label for="groom_name" class="block text-sm font-medium text-gray-700">Nama Lengkap Mempelai Pria</label>
                                                <input type="text" name="groom_name" id="groom_name" value="{{ old('groom_name', $invitation->groom_name) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                                                @error('groom_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                            </div>

                                            <div class="sm:col-span-3">
                                                <label for="groom_nickname" class="block text-sm font-medium text-gray-700">Nama Panggilan</label>
                                                <input type="text" name="groom_nickname" id="groom_nickname" value="{{ old('groom_nickname', $invitation->groom_nickname) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                                @error('groom_nickname') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                            </div>

                                            <div class="sm:col-span-6">
                                                <label for="groom_parents" class="block text-sm font-medium text-gray-700">Nama Orang Tua</label>
                                                <input type="text" name="groom_parents" id="groom_parents" value="{{ old('groom_parents', $invitation->groom_parents) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Putra dari Bapak ... & Ibu ...">
                                                @error('groom_parents') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                            </div>

                                            <div class="sm:col-span-6">
                                                <label class="block text-sm font-medium text-gray-700">Foto Mempelai Pria</label>
                                                <div class="mt-1 flex items-center gap-4">
                                                    <div class="relative flex-shrink-0">
                                                        <img id="groom-preview" src="{{ $invitation->groom_photo ? asset('storage/' . $invitation->groom_photo) : '' }}" alt="Groom photo" class="w-16 h-16 object-cover rounded-full border {{ $invitation->groom_photo ? '' : 'hidden' }}">
                                                        <div id="groom-preview-placeholder" class="w-16 h-16 bg-gray-200 rounded-full flex items-center justify-center text-gray-400 text-xs font-semibold {{ $invitation->groom_photo ? 'hidden' : '' }}">No Photo</div>
                                                    </div>
                                                    <div>
                                                        <input type="file" name="groom_photo" id="groom_photo_input" class="crop-file-input hidden" accept="image/*" data-preview="groom-preview">
                                                        <button type="button" data-crop-target="groom_photo_input" class="px-4 py-2 bg-indigo-50 text-indigo-700 rounded-md text-sm font-semibold hover:bg-indigo-100 transition">
                                                            Pilih & Crop Foto
                                                        </button>
                                                        <p class="text-xs text-gray-400 mt-1">Format JPG/PNG. Foto akan dipotong persegi secara otomatis.</p>
                                                    </div>
                                                </div>
                                                @error('groom_photo') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Event Details -->
                            <div class="border-b border-gray-200 pb-6">
                                <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Waktu & Tempat</h3>
                                
                                <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                                    <div class="sm:col-span-2">
                                        <label for="event_date" class="block text-sm font-medium text-gray-700">Tanggal Acara</label>
                                        <input type="date" name="event_date" id="event_date" value="{{ old('event_date', $invitation->event_date?->format('Y-m-d')) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        @error('event_date') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="sm:col-span-2">
                                        <label for="event_time" class="block text-sm font-medium text-gray-700">Waktu Mulai</label>
                                        <input type="time" name="event_time" id="event_time" value="{{ old('event_time', $invitation->event_time) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        @error('event_time') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="sm:col-span-2">
                                        <label for="event_time_end" class="block text-sm font-medium text-gray-700">Waktu Selesai</label>
                                        <input type="time" name="event_time_end" id="event_time_end" value="{{ old('event_time_end', $invitation->event_time_end) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        @error('event_time_end') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="sm:col-span-6">
                                        <label for="timezone" class="block text-sm font-medium text-gray-700">Zona Waktu</label>
                                        <select name="timezone" id="timezone" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                            <option value="Asia/Jakarta" {{ old('timezone', $invitation->timezone) == 'Asia/Jakarta' ? 'selected' : '' }}>WIB (Waktu Indonesia Barat)</option>
                                            <option value="Asia/Makassar" {{ old('timezone', $invitation->timezone) == 'Asia/Makassar' ? 'selected' : '' }}>WITA (Waktu Indonesia Tengah)</option>
                                            <option value="Asia/Jayapura" {{ old('timezone', $invitation->timezone) == 'Asia/Jayapura' ? 'selected' : '' }}>WIT (Waktu Indonesia Timur)</option>
                                        </select>
                                        @error('timezone') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="sm:col-span-6">
                                        <label for="venue_name" class="block text-sm font-medium text-gray-700">Nama Gedung / Lokasi</label>
                                        <input type="text" name="venue_name" id="venue_name" value="{{ old('venue_name', $invitation->venue_name) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        @error('venue_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="sm:col-span-6">
                                        <label for="venue_address" class="block text-sm font-medium text-gray-700">Alamat Lengkap</label>
                                        <textarea name="venue_address" id="venue_address" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('venue_address', $invitation->venue_address) }}</textarea>
                                        @error('venue_address') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="sm:col-span-6">
                                        <label for="venue_maps_url" class="block text-sm font-medium text-gray-700">Link Google Maps</label>
                                        <input type="url" name="venue_maps_url" id="venue_maps_url" value="{{ old('venue_maps_url', $invitation->venue_maps_url) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="https://goo.gl/maps/...">
                                        @error('venue_maps_url') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Custom URL / Slug Editor -->
                            <div class="border-b border-gray-200 pb-6">
                                <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Tautan Undangan</h3>

                                <div class="bg-gray-50 p-4 rounded-xl space-y-4">
                                    <div>
                                        <label for="slug-input" class="block text-sm font-medium text-gray-700">Tautan Kustom</label>
                                        <div class="mt-1 flex items-center gap-2">
                                            <span class="text-sm text-gray-500 whitespace-nowrap">{{ parse_url(config('app.url'), PHP_URL_HOST) }}/</span>
                                            <input type="text" name="slug" id="slug-input"
                                                value="{{ old('slug', $invitation->slug) }}"
                                                data-original="{{ $invitation->slug }}"
                                                data-id="{{ $invitation->id }}"
                                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm font-mono"
                                                placeholder="nama-undangan-anda"
                                                maxlength="100"
                                                pattern="^[a-z0-9\-]+$">
                                        </div>
                                        <div id="slug-indicator" class="mt-1 text-xs flex items-center gap-1 text-gray-400">
                                            <span class="slug-icon">🔗</span>
                                            <span class="slug-text">Masukkan tautan kustom</span>
                                        </div>
                                        @error('slug') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                        <div class="mt-2 flex gap-2 text-xs text-gray-500">
                                            <span>Huruf kecil, angka, dan tanda hubung (-)</span>
                                        </div>
                                    </div>

                                    <div class="bg-amber-50 border border-amber-100 rounded-lg p-3">
                                        <div class="flex items-start gap-2">
                                            <span class="text-amber-600 text-sm">⚠</span>
                                            <div>
                                                <p class="text-xs font-semibold text-amber-800">Perhatian</p>
                                                <p class="text-xs text-amber-700">Mengubah tautan akan membuat tautan lama tidak bisa diakses. Pastikan Anda belum menyebarkan tautan lama ke tamu undangan.</p>
                                                @if($invitation->slug_change_count > 0)
                                                    <p class="text-xs text-amber-700 mt-1">Tautan telah diubah {{ $invitation->slug_change_count }} kali.</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Additional Info & Premium -->
                            <div class="border-b border-gray-200 pb-6">
                                <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Pengaturan & Fitur</h3>
                                
                                <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                                    <div class="sm:col-span-6">
                                        <label for="love_story" class="block text-sm font-medium text-gray-700">Cerita Cinta (Love Story)</label>
                                        <textarea name="love_story" id="love_story" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('love_story', $invitation->love_story) }}</textarea>
                                        @error('love_story') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="sm:col-span-6">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Tema Undangan</label>
                                        <select name="theme" id="theme" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                            <option value="elegant" {{ old('theme', $invitation->theme) == 'elegant' ? 'selected' : '' }}>Elegant Rose</option>
                                            <option value="modern" {{ old('theme', $invitation->theme) == 'modern' ? 'selected' : '' }}>Modern Dark</option>
                                            <option value="garden" {{ old('theme', $invitation->theme) == 'garden' ? 'selected' : '' }}>Garden Green</option>
                                        </select>
                                        @error('theme') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>

                                    <!-- Music Upload Section (Gold & Platinum Only) -->
                                    <div class="sm:col-span-6">
                                        <label class="block text-sm font-medium text-gray-700">Musik Latar Belakang (Background Music)</label>
                                        @if($invitation->canUseCustomMusic())
                                            <div class="mt-1 space-y-2">
                                                @if($invitation->music_url)
                                                    <div class="flex items-center gap-3 bg-indigo-50 p-3 rounded-lg border border-indigo-100">
                                                        <span class="text-xs font-semibold text-indigo-700">🎵 Musik Aktif:</span>
                                                        <audio src="{{ asset('storage/' . $invitation->music_url) }}" controls class="h-8 max-w-xs"></audio>
                                                    </div>
                                                @endif
                                                <input type="file" name="music_file" id="music_file" class="text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                                                <p class="text-xs text-gray-500">Mendukung format MP3, WAV, OGG (Maks. 10MB).</p>
                                            </div>
                                        @else
                                            <div class="mt-1 bg-amber-50 border border-amber-100 rounded-lg p-4 flex items-center gap-3">
                                                <span class="text-xl">✨</span>
                                                <div>
                                                    <p class="text-sm font-semibold text-amber-800">Fitur Kustom Musik Terkunci</p>
                                                    <p class="text-xs text-amber-700">Silakan upgrade ke paket Gold atau Platinum untuk mengunggah musik latar belakang favorit Anda.</p>
                                                </div>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="sm:col-span-6">
                                        <div class="flex items-start">
                                            <div class="flex h-5 items-center">
                                                <input type="hidden" name="is_active" value="0">
                                                <input id="is_active" name="is_active" type="checkbox" value="1" {{ old('is_active', $invitation->is_active) ? 'checked' : '' }} class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                            </div>
                                            <div class="ml-3 text-sm">
                                                <label for="is_active" class="font-medium text-gray-700">Aktifkan Undangan</label>
                                                <p class="text-gray-500">Undangan yang tidak aktif tidak dapat diakses oleh tamu.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="pt-4 flex justify-end">
                                <a href="{{ route('dashboard.invitations.show', $invitation) }}" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 mr-3">
                                    Batal
                                </a>
                                <button type="submit" class="bg-indigo-600 border border-transparent rounded-md shadow-sm py-2 px-4 inline-flex justify-center text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Simpan Perubahan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Crop Modal -->
    <div id="crop-modal" class="hidden fixed inset-0 z-50 bg-black/60 items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg overflow-hidden">
            <div class="p-4 border-b border-gray-100 flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900">Crop Foto</h3>
                <button type="button" class="crop-close text-gray-400 hover:text-gray-600 transition">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="p-4 bg-gray-900 flex items-center justify-center" style="min-height:300px">
                <div id="crop-container" class="w-full mx-auto" style="max-width:500px;aspect-ratio:1/1;overflow:hidden"></div>
            </div>
            <div class="p-4 border-t border-gray-100">
                <div class="flex items-center justify-center gap-3 mb-4">
                    <button type="button" id="crop-zoom-out" class="p-2 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-700 transition" title="Perkecil">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                        </svg>
                    </button>
                    <button type="button" id="crop-zoom-in" class="p-2 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-700 transition" title="Perbesar">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                    </button>
                    <button type="button" id="crop-rotate" class="p-2 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-700 transition" title="Rotate">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                    </button>
                </div>
                <div class="flex gap-3">
                    <button type="button" class="crop-close flex-1 px-4 py-2.5 border border-gray-300 rounded-xl text-sm font-semibold text-gray-700 hover:bg-gray-50 transition">
                        Batal
                    </button>
                    <button type="button" id="crop-save" class="flex-1 px-4 py-2.5 bg-gradient-to-r from-indigo-600 to-indigo-700 text-white rounded-xl text-sm font-semibold hover:from-indigo-700 hover:to-indigo-800 transition shadow-sm">
                        Simpan
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
