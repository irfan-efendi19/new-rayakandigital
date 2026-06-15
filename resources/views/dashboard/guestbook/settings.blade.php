<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h2 class="font-heading text-2xl font-bold text-secondary-800 dark:text-neutral-100">
                    Pengaturan Layar Sapa
                </h2>
                <p class="text-sm text-neutral-500 mt-0.5">{{ $invitation->title }}</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('dashboard.welcome-screen.index', $invitation) }}" target="_blank"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-primary to-primary-600 text-white rounded-xl text-sm font-semibold shadow-soft hover:shadow-md transition-all">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    Buka Layar Sapa
                </a>
                <a href="{{ route('dashboard.invitations.guestbook', $invitation) }}"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-neutral-300 rounded-xl text-sm font-semibold text-neutral-700 hover:bg-neutral-50 hover:border-primary-300 transition-all">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali ke Buku Tamu
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white dark:bg-secondary-800 rounded-2xl shadow-soft border border-neutral-100 dark:border-secondary-700 overflow-hidden">
                <div class="p-6 sm:p-8">
                    <div class="flex items-center gap-3 mb-1">
                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-xl bg-primary-100 dark:bg-primary-900/50 text-primary-700 dark:text-primary-300">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </span>
                        <h3 class="font-heading text-lg font-bold text-secondary-800 dark:text-neutral-100">Pengaturan Layar Sapa</h3>
                    </div>
                    <p class="text-sm text-neutral-500 dark:text-neutral-400 ml-11 mb-6">Kustomisasi tampilan layar sapa proyektor di venue pernikahan Anda.</p>

                    <form action="{{ route('dashboard.welcome-screen.settings.update', $invitation) }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="space-y-6">
                            {{-- Custom Bride Names --}}
                            <div class="bg-neutral-50 dark:bg-secondary-700 p-5 rounded-2xl border border-neutral-200 dark:border-secondary-700 space-y-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-primary-100 dark:bg-primary-900/50 flex items-center justify-center text-primary dark:text-primary-400">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                        </svg>
                                    </div>
                                    <h4 class="font-semibold text-sm text-primary-700 dark:text-primary-300">Nama Pengantin di Layar</h4>
                                </div>
                                <div>
                                    <label for="screen_bride_names" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Nama Pajangan Pengantin</label>
                                    <p class="text-xs text-neutral-500 dark:text-neutral-400 mb-2">Tulis nama panggilan khusus untuk layar proyektor. Kosongkan untuk menggunakan nama default.</p>
                                    <input type="text" name="screen_bride_names" id="screen_bride_names"
                                        value="{{ old('screen_bride_names', $invitation->screen_bride_names) }}"
                                        placeholder="{{ ($invitation->bride_nickname ?? $invitation->bride_name) . ' & ' . ($invitation->groom_nickname ?? $invitation->groom_name) }}"
                                        class="mt-1 block w-full rounded-xl border-neutral-300 dark:border-neutral-600 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm dark:bg-secondary-700 dark:text-neutral-200">
                                    @error('screen_bride_names') <span class="text-red-500 dark:text-red-400 text-xs mt-1">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            {{-- Background Image & Overlay --}}
                            <div class="bg-neutral-50 dark:bg-secondary-700 p-5 rounded-2xl border border-neutral-200 dark:border-secondary-700 space-y-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-primary-100 dark:bg-primary-900/50 flex items-center justify-center text-primary dark:text-primary-400">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <h4 class="font-semibold text-sm text-primary-700 dark:text-primary-300">Latar Belakang & Overlay</h4>
                                </div>

                                {{-- Background upload --}}
                                <div>
                                    <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">Foto Latar Belakang</label>
                                    @if($invitation->screen_background_image)
                                        <div class="mb-3 flex items-start gap-3">
                                            <div class="relative inline-block">
                                                <img src="{{ asset('storage/' . $invitation->screen_background_image) }}" alt="Background saat ini" class="w-48 h-28 object-cover rounded-lg border border-neutral-200 dark:border-secondary-600">
                                                <span class="absolute top-1 right-1 bg-green-500 text-white text-[10px] px-1.5 py-0.5 rounded font-semibold">Aktif</span>
                                            </div>
                                            <label class="inline-flex items-center gap-2 cursor-pointer text-xs text-red-600 hover:text-red-700 mt-1">
                                                <input type="checkbox" name="remove_background" value="1" class="rounded border-neutral-300 text-red-500 focus:ring-red-400">
                                                Hapus background
                                            </label>
                                        </div>
                                    @endif
                                    <input type="file" name="screen_background_image" id="screen_background_image"
                                        accept="image/*"
                                        class="block w-full text-sm text-neutral-500 dark:text-neutral-400
                                            file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0
                                            file:text-sm file:font-semibold file:bg-primary-50 dark:file:bg-primary-900/30
                                            file:text-primary-700 dark:file:text-primary-300
                                            hover:file:bg-primary-100 dark:hover:file:bg-primary-900/50
                                            transition">
                                    <p class="text-xs text-neutral-400 dark:text-neutral-500 mt-1">Otomatis dikompresi ke format .webp. Maksimal 10 MB.</p>
                                    @error('screen_background_image') <span class="text-red-500 dark:text-red-400 text-xs mt-1">{{ $message }}</span> @enderror
                                </div>

                                {{-- Overlay opacity slider --}}
                                <div x-data="{ opacity: {{ old('screen_overlay_opacity', $invitation->screen_overlay_opacity ?? 50) }} }">
                                    <label for="screen_overlay_opacity" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Tingkat Gelap Overlay</label>
                                    <p class="text-xs text-neutral-500 dark:text-neutral-400 mb-3">Atur kecerahan lapisan hitam di atas background agar teks tetap terbaca.</p>
                                    <div class="flex items-center gap-4">
                                        <input type="range" name="screen_overlay_opacity" id="screen_overlay_opacity"
                                            min="0" max="100" x-model="opacity"
                                            class="flex-1 h-2 bg-neutral-200 dark:bg-secondary-600 rounded-lg appearance-none cursor-pointer accent-primary-500">
                                        <span class="text-sm font-semibold text-neutral-700 dark:text-neutral-300 w-12 text-right" x-text="opacity + '%'"></span>
                                    </div>
                                    {{-- Live preview --}}
                                    <div class="mt-3 relative h-20 rounded-lg overflow-hidden border border-neutral-200 dark:border-secondary-600">
                                        <div class="absolute inset-0 bg-gradient-to-r from-blue-400 to-purple-500"></div>
                                        <div class="absolute inset-0 bg-black transition-opacity" :style="'opacity: ' + (opacity / 100)"></div>
                                        <div class="absolute inset-0 flex items-center justify-center">
                                            <span class="text-white text-sm font-semibold">Preview Overlay</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Screen Gallery --}}
                            <div class="bg-neutral-50 dark:bg-secondary-700 p-5 rounded-2xl border border-neutral-200 dark:border-secondary-700 space-y-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-primary-100 dark:bg-primary-900/50 flex items-center justify-center text-primary dark:text-primary-400">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                        </svg>
                                    </div>
                                    <h4 class="font-semibold text-sm text-primary-700 dark:text-primary-300">Galeri Slideshow (Idle Mode)</h4>
                                </div>
                                <p class="text-xs text-neutral-500 dark:text-neutral-400">Foto-foto ini akan berputar otomatis saat tidak ada tamu yang check-in (setelah 30 detik idle).</p>

                                {{-- Existing gallery photos --}}
                                @if($screenGalleries->count() > 0)
                                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3">
                                        @foreach($screenGalleries as $gallery)
                                            <div class="relative group">
                                                <img src="{{ asset('storage/' . $gallery->image_path) }}" alt="Gallery {{ $gallery->sort_order + 1 }}"
                                                    class="w-full h-24 object-cover rounded-lg border border-neutral-200 dark:border-secondary-600">
                                                <form action="{{ route('dashboard.welcome-screen.gallery.destroy', [$invitation, $gallery]) }}" method="POST" class="absolute top-1 right-1"
                                                    onsubmit="return confirm('Hapus foto ini dari galeri slideshow?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="w-6 h-6 bg-red-500/90 hover:bg-red-600 text-white rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity shadow-sm" title="Hapus foto">
                                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                        </svg>
                                                    </button>
                                                </form>
                                                <span class="absolute bottom-1 left-1 bg-black/60 text-white text-[10px] px-1.5 py-0.5 rounded font-medium">#{{ $gallery->sort_order + 1 }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="text-center py-6 text-neutral-400 dark:text-neutral-500">
                                        <svg class="w-10 h-10 mx-auto mb-2 opacity-40" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <p class="text-sm">Belum ada foto galeri slideshow</p>
                                    </div>
                                @endif

                                {{-- Gallery Upload --}}
                                <div class="pt-4 border-t border-neutral-200 dark:border-secondary-600">
                                    <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">Upload Foto Galeri Baru</label>
                                    <input type="file" name="screen_gallery_photos[]" multiple accept="image/*"
                                        class="block w-full text-sm text-neutral-500 dark:text-neutral-400
                                            file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0
                                            file:text-sm file:font-semibold file:bg-primary-50 dark:file:bg-primary-900/30
                                            file:text-primary-700 dark:file:text-primary-300
                                            hover:file:bg-primary-100 dark:hover:file:bg-primary-900/50
                                            transition">
                                    <p class="text-xs text-neutral-400 dark:text-neutral-500 mt-1">Pilih beberapa foto sekaligus. Otomatis dikompresi ke .webp.</p>
                                    @error('screen_gallery_photos.*') <span class="text-red-500 dark:text-red-400 text-xs mt-1">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Submit --}}
                        <div class="mt-8 flex items-center justify-end gap-3">
                            <a href="{{ route('dashboard.invitations.guestbook', $invitation) }}"
                                class="inline-flex items-center px-5 py-2.5 bg-white dark:bg-secondary-800 border border-neutral-300 dark:border-neutral-600 rounded-xl shadow-sm text-sm font-semibold text-neutral-700 dark:text-neutral-300 hover:bg-neutral-50 dark:hover:bg-secondary-700 hover:border-primary-300 transition-all">
                                Batal
                            </a>
                            <button type="submit"
                                class="inline-flex items-center gap-2 px-6 py-2.5 bg-gradient-to-r from-primary to-primary-600 rounded-xl shadow-sm text-sm font-semibold text-white hover:shadow-md hover:scale-[1.02] active:scale-[0.98] focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition-all">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Simpan Pengaturan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>