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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    Buka Layar Sapa
                </a>
                <a href="{{ route('dashboard.invitations.guestbook', $invitation) }}"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-neutral-300 rounded-xl text-sm font-semibold text-neutral-700 hover:bg-neutral-50 hover:border-primary-300 transition-all">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali ke Buku Tamu
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            <div
                class="bg-white dark:bg-secondary-800 rounded-2xl shadow-soft border border-neutral-100 dark:border-secondary-700 overflow-hidden">
                <div class="p-6 sm:p-8">
                    <div class="flex items-center gap-3 mb-1">
                        <span
                            class="inline-flex items-center justify-center w-8 h-8 rounded-xl bg-primary-100 dark:bg-primary-900/50 text-primary-700 dark:text-primary-300">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </span>
                        <h3 class="font-heading text-lg font-bold text-secondary-800 dark:text-neutral-100">Pengaturan
                            Layar Sapa</h3>
                    </div>
                    <p class="text-sm text-neutral-500 dark:text-neutral-400 ml-11 mb-6">Kustomisasi tampilan layar sapa
                        proyektor di venue pernikahan Anda.</p>

                    <form action="{{ route('dashboard.welcome-screen.settings.update', $invitation) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf

                        <div class="space-y-6">
                            {{-- Theme Selection --}}
                            <div
                                class="bg-neutral-50 dark:bg-secondary-700 p-5 rounded-2xl border border-neutral-200 dark:border-secondary-700 space-y-4">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-8 h-8 rounded-lg bg-primary-100 dark:bg-primary-900/50 flex items-center justify-center text-primary dark:text-primary-400">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z" />
                                        </svg>
                                    </div>
                                    <h4 class="font-semibold text-sm text-primary-700 dark:text-primary-300">Pilih
                                        Preset Tema Layar Sapa</h4>
                                </div>
                                @php
                                    $currentTheme = old('selected_theme', $screen->selected_theme ?? ($presets->first()?->slug ?? 'minimal-clean'));
                                @endphp
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4"
                                    x-data="{ theme: '{{ $currentTheme }}' }">
                                    @forelse($presets as $preset)
                                    <label
                                        class="relative flex flex-col p-4 bg-white dark:bg-secondary-800 rounded-xl border-2 cursor-pointer transition-all hover:shadow-sm focus:outline-none"
                                        :class="theme === '{{ $preset->slug }}' ? 'border-primary-500 ring-2 ring-primary-500' : 'border-neutral-200 dark:border-secondary-600'">
                                        <input type="radio" name="selected_theme" value="{{ $preset->slug }}" class="sr-only"
                                            {{ $currentTheme === $preset->slug ? 'checked' : '' }}
                                            @change="theme = '{{ $preset->slug }}'">
                                        @if($preset->thumbnail_image)
                                            <img src="{{ asset('storage/' . $preset->thumbnail_image) }}"
                                                alt="{{ $preset->name }}"
                                                class="w-full h-24 object-cover rounded-lg mb-3">
                                        @else
                                            <div class="w-full h-16 rounded-lg mb-3 bg-gradient-to-br from-primary-100 to-primary-200 dark:from-primary-900/30 dark:to-primary-800/30 flex items-center justify-center">
                                                <svg class="w-6 h-6 text-primary-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                        @endif
                                        <div class="flex flex-col h-full justify-between">
                                            <div>
                                                <span class="block text-sm font-bold text-neutral-800 dark:text-neutral-100">{{ $preset->name }}</span>
                                                @if($preset->description)
                                                    <span class="block text-xs text-neutral-500 dark:text-neutral-400 mt-1">{{ $preset->description }}</span>
                                                @endif
                                            </div>
                                            <div class="mt-3 flex items-center justify-between">
                                                <span class="text-[10px] uppercase tracking-wider font-semibold px-2 py-0.5 rounded bg-primary-50 dark:bg-primary-950/30 text-primary-600 dark:text-primary-300">{{ $preset->slug }}</span>
                                                <span :class="theme === '{{ $preset->slug }}' ? 'text-primary-500' : 'text-transparent'">
                                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                                </span>
                                            </div>
                                        </div>
                                    </label>
                                    @empty
                                        <div class="col-span-3 text-center py-8 text-neutral-400 dark:text-neutral-500">
                                            <p class="text-sm">Belum ada preset tema tersedia. Hubungi administrator.</p>
                                        </div>
                                    @endforelse
                                </div>

                                @error('selected_theme') <span
                                class="text-red-500 dark:text-red-400 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>

                            {{-- Custom Title & Wishes Wall --}}
                            <div
                                class="bg-neutral-50 dark:bg-secondary-700 p-5 rounded-2xl border border-neutral-200 dark:border-secondary-700 space-y-4">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-8 h-8 rounded-lg bg-primary-100 dark:bg-primary-900/50 flex items-center justify-center text-primary dark:text-primary-400">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </div>
                                    <h4 class="font-semibold text-sm text-primary-700 dark:text-primary-300">Judul &
                                        Dinding Ucapan</h4>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="custom_title"
                                            class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Judul
                                            Kustom Layar Sapa</label>
                                        <p class="text-xs text-neutral-500 dark:text-neutral-400 mb-2">Ubah teks
                                            sambutan utama di layar (contoh: "Selamat Datang di Pernikahan Kami").
                                            Kosongkan untuk menggunakan judul default.</p>
                                        <input type="text" name="custom_title" id="custom_title"
                                            value="{{ old('custom_title', $screen->custom_title) }}"
                                            placeholder="Selamat Datang"
                                            class="mt-1 block w-full rounded-xl border-neutral-300 dark:border-neutral-600 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm dark:bg-secondary-700 dark:text-neutral-200">
                                        @error('custom_title') <span
                                            class="text-red-500 dark:text-red-400 text-xs mt-1">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="flex flex-col justify-center">
                                        <div class="flex items-start">
                                            <div class="flex items-center h-5">
                                                <input id="show_wishes_wall" name="show_wishes_wall" type="checkbox"
                                                    value="1" {{ old('show_wishes_wall', $screen->show_wishes_wall ?? true) ? 'checked' : '' }}
                                                    class="focus:ring-primary-500 h-5 w-5 text-primary border-neutral-300 dark:border-neutral-600 rounded-lg">
                                            </div>
                                            <div class="ml-3 text-sm">
                                                <label for="show_wishes_wall"
                                                    class="font-medium text-neutral-700 dark:text-neutral-300">Tampilkan
                                                    Dinding Ucapan (Live Wish Wall)</label>
                                                <p class="text-xs text-neutral-500 dark:text-neutral-400">Aktifkan untuk
                                                    menampilkan running text / gulungan doa dari tamu secara real-time
                                                    di layar.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- Custom Bride Names --}}
                            <div
                                class="bg-neutral-50 dark:bg-secondary-700 p-5 rounded-2xl border border-neutral-200 dark:border-secondary-700 space-y-4">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-8 h-8 rounded-lg bg-primary-100 dark:bg-primary-900/50 flex items-center justify-center text-primary dark:text-primary-400">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                        </svg>
                                    </div>
                                    <h4 class="font-semibold text-sm text-primary-700 dark:text-primary-300">Nama
                                        Pengantin di Layar</h4>
                                </div>
                                <div>
                                    <label for="screen_bride_names"
                                        class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Nama
                                        Pajangan Pengantin</label>
                                    <p class="text-xs text-neutral-500 dark:text-neutral-400 mb-2">Tulis nama panggilan
                                        khusus untuk layar proyektor. Kosongkan untuk menggunakan nama default.</p>
                                    <input type="text" name="screen_bride_names" id="screen_bride_names"
                                        value="{{ old('screen_bride_names', $invitation->screen_bride_names) }}"
                                        placeholder="{{ $invitation->couple_nickname }}"
                                        class="mt-1 block w-full rounded-xl border-neutral-300 dark:border-neutral-600 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm dark:bg-secondary-700 dark:text-neutral-200">
                                    @error('screen_bride_names') <span
                                        class="text-red-500 dark:text-red-400 text-xs mt-1">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            {{-- Background Image --}}
                            <div
                                class="bg-neutral-50 dark:bg-secondary-700 p-5 rounded-2xl border border-neutral-200 dark:border-secondary-700 space-y-4">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-8 h-8 rounded-lg bg-primary-100 dark:bg-primary-900/50 flex items-center justify-center text-primary dark:text-primary-400">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <h4 class="font-semibold text-sm text-primary-700 dark:text-primary-300">Latar
                                        Belakang</h4>
                                </div>

                                @if($invitation->screen_background_image)
                                    <div class="relative group">
                                        <img src="{{ asset('storage/' . $invitation->screen_background_image) }}"
                                            alt="Background saat ini"
                                            class="w-full h-32 object-cover rounded-lg border border-neutral-200 dark:border-secondary-600">
                                        <button type="button" id="btn-remove-bg"
                                            onclick="Swal.fire({title:'Hapus background?',text:'Background akan dihapus saat pengaturan disimpan.',icon:'warning',showCancelButton:true,confirmButtonColor:'#dc2626',cancelButtonColor:'#6b7280',confirmButtonText:'Ya, hapus!',cancelButtonText:'Batal'}).then((result)=>{const cb=document.getElementById('remove_background');const b=document.getElementById('btn-remove-bg');const badge=document.getElementById('badge-active');if(result.isConfirmed){cb.checked=true;b.classList.add('!bg-red-600');badge.classList.add('hidden');Swal.fire({icon:'success',title:'Ditandai untuk dihapus',text:'Klik Simpan Pengaturan untuk menghapus background.',timer:2000,showConfirmButton:false});}else{cb.checked=false;b.classList.remove('!bg-red-600');badge.classList.remove('hidden');}})"
                                            class="absolute top-1 right-1 w-6 h-6 bg-red-500/90 hover:bg-red-600 text-white rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity shadow-sm"
                                            title="Hapus background">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                        <input type="checkbox" name="remove_background" id="remove_background" value="1" class="sr-only">
                                        <span id="badge-active"
                                            class="absolute bottom-1 left-1 bg-black/60 text-white text-[10px] px-1.5 py-0.5 rounded font-medium">Aktif</span>
                                    </div>
                                @endif

                                <div>
                                    <input type="file" name="screen_background_image" id="screen_background_image"
                                        accept="image/*" class="block w-full text-sm text-neutral-500 dark:text-neutral-400
                                            file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0
                                            file:text-sm file:font-semibold file:bg-primary-50 dark:file:bg-primary-900/30
                                            file:text-primary-700 dark:file:text-primary-300
                                            hover:file:bg-primary-100 dark:hover:file:bg-primary-900/50
                                            transition">
                                    <p class="text-xs text-neutral-400 dark:text-neutral-500 mt-1">Otomatis dikompresi
                                        ke format .webp. Maksimal 10 MB.</p>
                                    @error('screen_background_image') <span
                                        class="text-red-500 dark:text-red-400 text-xs mt-1">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            {{-- Screen Gallery --}}
                            <div
                                class="bg-neutral-50 dark:bg-secondary-700 p-5 rounded-2xl border border-neutral-200 dark:border-secondary-700 space-y-4">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-8 h-8 rounded-lg bg-primary-100 dark:bg-primary-900/50 flex items-center justify-center text-primary dark:text-primary-400">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                        </svg>
                                    </div>
                                    <h4 class="font-semibold text-sm text-primary-700 dark:text-primary-300">Galeri
                                        Slideshow (Idle Mode)</h4>
                                </div>
                                <p class="text-xs text-neutral-500 dark:text-neutral-400">Foto-foto ini akan berputar
                                    otomatis saat tidak ada tamu yang check-in (setelah 30 detik idle).</p>

                                {{-- Existing gallery photos --}}
                                @if($screenGalleries->count() > 0)
                                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3">
                                        @foreach($screenGalleries as $gallery)
                                            <div class="relative group">
                                                <img src="{{ asset('storage/' . $gallery->image_path) }}"
                                                    alt="Gallery {{ $gallery->sort_order + 1 }}"
                                                    class="w-full h-24 object-cover rounded-lg border border-neutral-200 dark:border-secondary-600">
                                                <button type="button"
                                                    onclick="Swal.fire({title:'Hapus foto ini?',text:'Foto akan dihapus dari galeri slideshow.',icon:'warning',showCancelButton:true,confirmButtonColor:'#dc2626',cancelButtonColor:'#6b7280',confirmButtonText:'Ya, hapus!',cancelButtonText:'Batal'}).then((result)=>{if(result.isConfirmed){fetch('{{ route('dashboard.welcome-screen.gallery.destroy', [$invitation, $gallery]) }}',{method:'DELETE',headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}','Accept':'application/json'}}).then(()=>Swal.fire({icon:'success',title:'Berhasil!',text:'Foto galeri berhasil dihapus.',timer:1500,showConfirmButton:false}).then(()=>location.reload()))}})"
                                                    class="absolute top-1 right-1 w-6 h-6 bg-red-500/90 hover:bg-red-600 text-white rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity shadow-sm"
                                                    title="Hapus foto">
                                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"
                                                        stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                </button>
                                                <span
                                                    class="absolute bottom-1 left-1 bg-black/60 text-white text-[10px] px-1.5 py-0.5 rounded font-medium">#{{ $gallery->sort_order + 1 }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="text-center py-6 text-neutral-400 dark:text-neutral-500">
                                        <svg class="w-10 h-10 mx-auto mb-2 opacity-40" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <p class="text-sm">Belum ada foto galeri slideshow</p>
                                    </div>
                                @endif

                                {{-- Gallery Upload --}}
                                <div class="pt-4 border-t border-neutral-200 dark:border-secondary-600">
                                    <label
                                        class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">Upload
                                        Foto Galeri Baru</label>
                                    <input type="file" name="screen_gallery_photos[]" multiple accept="image/*" class="block w-full text-sm text-neutral-500 dark:text-neutral-400
                                            file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0
                                            file:text-sm file:font-semibold file:bg-primary-50 dark:file:bg-primary-900/30
                                            file:text-primary-700 dark:file:text-primary-300
                                            hover:file:bg-primary-100 dark:hover:file:bg-primary-900/50
                                            transition">
                                    <p class="text-xs text-neutral-400 dark:text-neutral-500 mt-1">Pilih beberapa foto
                                        sekaligus. Otomatis dikompresi ke .webp.</p>
                                    @error('screen_gallery_photos.*') <span
                                        class="text-red-500 dark:text-red-400 text-xs mt-1">{{ $message }}</span>
                                    @enderror
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
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
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