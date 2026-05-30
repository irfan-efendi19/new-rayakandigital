<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Undangan: ') }} {{ $invitation->title }}
        </h2>
    </x-slot>

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
                                                    @if($invitation->bride_photo)
                                                        <img src="{{ asset('storage/' . $invitation->bride_photo) }}" alt="Bride photo" class="w-16 h-16 object-cover rounded-full border">
                                                    @else
                                                        <div class="w-16 h-16 bg-gray-200 rounded-full flex items-center justify-center text-gray-400 text-xs font-semibold">No Photo</div>
                                                    @endif
                                                    <input type="file" name="bride_photo" id="bride_photo" class="text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
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
                                                    @if($invitation->groom_photo)
                                                        <img src="{{ asset('storage/' . $invitation->groom_photo) }}" alt="Groom photo" class="w-16 h-16 object-cover rounded-full border">
                                                    @else
                                                        <div class="w-16 h-16 bg-gray-200 rounded-full flex items-center justify-center text-gray-400 text-xs font-semibold">No Photo</div>
                                                    @endif
                                                    <input type="file" name="groom_photo" id="groom_photo" class="text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
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
</x-app-layout>
