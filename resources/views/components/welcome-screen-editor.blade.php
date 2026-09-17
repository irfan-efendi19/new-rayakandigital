@props(['invitation', 'screen', 'presets', 'screenGalleries'])

@php
    $currentTheme = old('selected_theme', $screen->selected_theme ?? ($presets->first()?->slug ?? 'minimal-clean'));
    $screenSettings = [
        'theme' => $currentTheme,
        'title' => old('custom_title', $screen->custom_title) ?? '',
        'names' => old('screen_bride_names', $invitation->screen_bride_names) ?? '',
        'defaultNames' => $invitation->couple_nickname,
        'wishes' => (bool) old('show_wishes_wall', session()->hasOldInput() ? false : ($screen->show_wishes_wall ?? true)),
        'savedBackground' => $invitation->screen_background_image ? asset('storage/' . $invitation->screen_background_image) : '',
        'removeBackground' => (bool) old('remove_background', false),
        'savedGalleryCount' => $screenGalleries->count(),
        'dirty' => $errors->any(),
        'presets' => $presets->map(fn ($preset) => ['slug' => $preset->slug, 'name' => $preset->name])->values(),
    ];
@endphp

<div class="screen-settings min-h-screen bg-[#F7F7F5] dark:bg-secondary-900" x-data="welcomeScreenSettings" data-screen-settings="{{ json_encode($screenSettings) }}">
    <header class="border-b border-neutral-200 bg-white dark:border-secondary-700 dark:bg-secondary-800">
        <div class="mx-auto max-w-7xl px-4 py-7 sm:px-6 lg:px-8">
            <nav aria-label="Breadcrumb" class="flex flex-wrap items-center gap-2 text-xs text-neutral-500 dark:text-neutral-400">
                <a href="{{ route('dashboard') }}" class="hover:text-primary-600">Dashboard</a><span aria-hidden="true">/</span>
                <a href="{{ route('dashboard.invitations.guestbook', $invitation) }}" class="hover:text-primary-600">Buku tamu</a><span aria-hidden="true">/</span>
                <span aria-current="page" class="font-semibold text-secondary-800 dark:text-neutral-200">Pengaturan layar sapa</span>
            </nav>
            <div class="mt-6 flex flex-col justify-between gap-5 lg:flex-row lg:items-center">
                <div class="min-w-0">
                    <span class="mb-3 inline-flex max-w-full items-center gap-2 rounded-full bg-primary-50 px-3 py-1.5 text-xs font-semibold text-primary-700 dark:bg-primary-900/30 dark:text-primary-300"><i class="fa-solid fa-display shrink-0" aria-hidden="true"></i><span class="truncate">{{ $invitation->title }}</span></span>
                    <h1 class="text-2xl font-bold tracking-tight text-secondary-900 dark:text-white sm:text-3xl">Sambutan hangat, sejak tamu tiba.</h1>
                    <p class="mt-2 text-sm leading-7 text-neutral-500 dark:text-neutral-400">Atur tema, pesan, dan foto untuk layar sapa di hari istimewa Anda.</p>
                </div>
                <a href="{{ route('dashboard.welcome-screen.index', $invitation) }}" target="_blank" rel="noopener noreferrer" class="screen-settings-button self-start"><i class="fa-solid fa-arrow-up-right-from-square" aria-hidden="true"></i>Buka layar sapa</a>
            </div>
        </div>
    </header>

    <div class="mx-auto max-w-7xl px-4 pb-28 pt-6 sm:px-6 lg:px-8">
        @if(session('success'))
            <div role="status" class="mb-5 flex items-center gap-3 rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-800 dark:border-emerald-800 dark:bg-emerald-900/20 dark:text-emerald-300"><i class="fa-solid fa-circle-check" aria-hidden="true"></i>{{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div role="alert" class="mb-5 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-800 dark:border-red-800 dark:bg-red-900/20 dark:text-red-300">
                <p class="font-bold">Pengaturan belum disimpan. Periksa kembali isian berikut.</p>
                <ul class="mt-2 list-inside list-disc space-y-1">@foreach($errors->all() as $message)<li>{{ $message }}</li>@endforeach</ul>
                <p class="mt-2 text-xs">Pilih kembali berkas gambar jika sebelumnya Anda menambahkan foto.</p>
            </div>
        @endif
        <nav aria-label="Bagian pengaturan" class="mb-6 flex flex-wrap gap-2">
            @foreach(['tema-layar' => 'Tema layar', 'teks-sambutan' => 'Teks sambutan', 'latar-layar' => 'Latar belakang', 'galeri-layar' => 'Slideshow'] as $anchor => $label)
                <a href="#{{ $anchor }}" class="inline-flex min-h-10 items-center gap-2 rounded-full border border-neutral-200 bg-white px-4 py-2 text-xs font-semibold text-neutral-600 transition hover:border-primary-300 hover:text-primary-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-primary-500 dark:border-secondary-700 dark:bg-secondary-800 dark:text-neutral-300"><span class="text-primary-600 dark:text-primary-400">0{{ $loop->iteration }}</span>{{ $label }}</a>
            @endforeach
        </nav>

        <form id="screen-settings-form" action="{{ route('dashboard.welcome-screen.settings.update', $invitation) }}" method="POST" enctype="multipart/form-data" @input="dirty = true" @change="dirty = true" @submit="submitting = true">
            @csrf
            <div class="grid items-start gap-6 lg:grid-cols-[minmax(0,1fr)_360px] xl:grid-cols-[minmax(0,1fr)_400px]">
                <div class="flex min-w-0 flex-col gap-6">
                    <x-screen-settings-section id="tema-layar" number="01" title="Pilih suasana layar" description="Pilih desain yang selaras dengan nuansa acara Anda.">
                        <fieldset>
                            <legend class="sr-only">Tema layar sapa</legend>
                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                @forelse($presets as $preset)
                                    <label class="group relative min-w-0 cursor-pointer">
                                        <input type="radio" name="selected_theme" value="{{ $preset->slug }}" x-model="theme" @checked($currentTheme === $preset->slug) class="peer sr-only">
                                        <span class="flex h-full flex-col overflow-hidden rounded-xl border-2 border-neutral-200 bg-white transition group-hover:border-primary-300 peer-checked:border-primary-500 peer-checked:bg-primary-50/30 peer-focus-visible:ring-2 peer-focus-visible:ring-primary-500 peer-focus-visible:ring-offset-2 dark:border-secondary-600 dark:bg-secondary-900 dark:peer-checked:border-primary-500 dark:peer-checked:bg-primary-900/10 dark:peer-focus-visible:ring-offset-secondary-800">
                                            <span class="relative block aspect-video overflow-hidden border-b border-neutral-100 bg-neutral-50 dark:border-secondary-700 dark:bg-secondary-700">
                                                @if($preset->thumbnail_image)
                                                    <img src="{{ asset('storage/' . $preset->thumbnail_image) }}" alt="" loading="lazy" class="h-full w-full object-cover transition duration-300 group-hover:scale-105 motion-reduce:transform-none">
                                                @else
                                                    <span class="flex h-full flex-col items-center justify-center gap-2 bg-gradient-to-br from-primary-50 via-white to-neutral-100 p-4 text-center dark:from-secondary-700 dark:via-secondary-800 dark:to-secondary-900"><i class="fa-solid fa-display text-lg text-primary-500" aria-hidden="true"></i><span class="font-heading text-lg font-semibold text-secondary-800 dark:text-neutral-100">{{ $preset->name }}</span><span class="text-[9px] uppercase tracking-[0.18em] text-neutral-500 dark:text-neutral-400">Layar penyambutan</span></span>
                                                @endif
                                            </span>
                                            <span class="flex flex-1 items-start justify-between gap-3 p-4">
                                                <span class="min-w-0"><span class="block text-sm font-bold text-secondary-900 dark:text-white">{{ $preset->name }}</span>@if($preset->description)<span class="mt-1 block text-xs leading-6 text-neutral-500 dark:text-neutral-400">{{ $preset->description }}</span>@endif</span>
                                                <span class="mt-0.5 flex h-5 w-5 shrink-0 items-center justify-center rounded-full border border-neutral-300 text-[10px] dark:border-secondary-500" :class="theme === $el.closest('label').querySelector('input').value ? 'bg-primary-500 border-primary-500 text-white' : 'text-transparent'"><i class="fa-solid fa-check" aria-hidden="true"></i></span>
                                            </span>
                                        </span>
                                    </label>
                                @empty
                                    <div class="col-span-full rounded-xl border border-dashed border-neutral-300 px-5 py-10 text-center dark:border-secondary-600"><i class="fa-solid fa-palette text-2xl text-neutral-400" aria-hidden="true"></i><p class="mt-3 text-sm font-semibold">Belum ada tema tersedia</p><p class="screen-settings-help">Hubungi administrator untuk menambahkan tema layar sapa.</p></div>
                                @endforelse
                            </div>
                            @error('selected_theme')<p class="screen-settings-error">{{ $message }}</p>@enderror
                        </fieldset>
                    </x-screen-settings-section>

                    <x-screen-settings-section id="teks-sambutan" number="02" title="Buat sambutan lebih personal" description="Teks ini menyambut tamu saat mereka melakukan check-in.">
                        <div class="grid gap-5">
                            <div>
                                <div class="flex items-center justify-between gap-3"><label for="custom_title" class="text-sm font-semibold">Judul sambutan</label><span class="text-[10px] font-medium text-neutral-400">OPSIONAL</span></div>
                                <input id="custom_title" name="custom_title" type="text" maxlength="255" x-model="title" value="{{ $screenSettings['title'] }}" placeholder="Selamat Datang" aria-describedby="title-help" class="screen-settings-input">
                                <p id="title-help" class="screen-settings-help">Kosongkan untuk menggunakan judul bawaan tema.</p>
                                @error('custom_title')<p class="screen-settings-error">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <div class="flex items-center justify-between gap-3"><label for="screen_bride_names" class="text-sm font-semibold">Nama pengantin di layar</label><span class="text-[10px] font-medium text-neutral-400">OPSIONAL</span></div>
                                <input id="screen_bride_names" name="screen_bride_names" type="text" maxlength="255" x-model="names" value="{{ $screenSettings['names'] }}" placeholder="{{ $invitation->couple_nickname }}" aria-describedby="names-help" class="screen-settings-input">
                                <p id="names-help" class="screen-settings-help">Nama bawaan: {{ $invitation->couple_nickname }}.</p>
                                @error('screen_bride_names')<p class="screen-settings-error">{{ $message }}</p>@enderror
                            </div>
                            <label for="show_wishes_wall" class="flex cursor-pointer items-start justify-between gap-4 rounded-xl border border-neutral-200 bg-neutral-50 p-4 dark:border-secondary-600 dark:bg-secondary-900">
                                <span><span class="flex items-center gap-2 text-sm font-semibold"><i class="fa-regular fa-comment-dots text-primary-600 dark:text-primary-400" aria-hidden="true"></i>Dinding ucapan</span><span class="screen-settings-help block">Tampilkan doa dan ucapan tamu secara real-time di layar.</span></span>
                                <span class="relative mt-1 inline-flex shrink-0"><input id="show_wishes_wall" name="show_wishes_wall" type="checkbox" value="1" x-model="wishes" @checked($screenSettings['wishes']) class="peer sr-only"><span class="h-6 w-11 rounded-full bg-neutral-300 transition peer-checked:bg-primary-500 peer-focus-visible:ring-2 peer-focus-visible:ring-primary-500 peer-focus-visible:ring-offset-2 dark:bg-secondary-600 dark:peer-focus-visible:ring-offset-secondary-900"></span><span class="pointer-events-none absolute left-1 top-1 h-4 w-4 rounded-full bg-white shadow-sm transition peer-checked:translate-x-5 motion-reduce:transition-none"></span></span>
                            </label>
                        </div>
                    </x-screen-settings-section>

                    <x-screen-settings-section id="latar-layar" number="03" title="Latar yang melengkapi suasana" description="Gunakan foto atau desain Anda sebagai latar layar sapa.">
                        <div x-cloak x-show="previewBackground" class="relative mb-4 overflow-hidden rounded-xl border border-neutral-200 bg-neutral-100 dark:border-secondary-600 dark:bg-secondary-900">
                            <template x-if="previewBackground"><img :src="previewBackground" alt="Pratinjau latar belakang layar sapa" class="aspect-[21/9] w-full object-cover"></template>
                            <span class="absolute bottom-3 left-3 rounded-full bg-black/65 px-3 py-1.5 text-[10px] font-semibold text-white" x-text="backgroundPreview ? 'Foto baru · belum disimpan' : 'Latar tersimpan'"></span>
                        </div>
                        <div class="rounded-xl border-2 border-dashed border-neutral-200 bg-neutral-50 px-5 py-6 text-center transition hover:border-primary-400 dark:border-secondary-600 dark:bg-secondary-900">
                            <label for="screen_background_image" class="flex cursor-pointer flex-col items-center gap-2"><span class="flex h-10 w-10 items-center justify-center rounded-xl bg-white text-primary-600 shadow-sm dark:bg-secondary-800 dark:text-primary-400"><i class="fa-solid fa-arrow-up-from-bracket" aria-hidden="true"></i></span><span class="max-w-full break-all text-sm font-semibold" x-text="backgroundName || 'Pilih gambar latar'">Pilih gambar latar</span><span class="text-xs text-neutral-500 dark:text-neutral-400">JPG, PNG, atau WebP · maksimal 10 MB</span></label>
                            <input id="screen_background_image" name="screen_background_image" type="file" accept="image/jpeg,image/png,image/webp" x-ref="backgroundInput" @change="selectBackground($event)" class="screen-settings-file">
                        </div>
                        <p x-cloak x-show="backgroundError" x-text="backgroundError" role="alert" class="screen-settings-error"></p>
                        @error('screen_background_image')<p class="screen-settings-error">{{ $message }}</p>@enderror
                        <button type="button" x-cloak x-show="backgroundPreview" @click="clearBackground(); dirty = true" class="mt-3 inline-flex min-h-10 items-center gap-2 text-xs font-semibold text-neutral-600 hover:text-red-600 dark:text-neutral-300"><i class="fa-solid fa-xmark" aria-hidden="true"></i>Batalkan pilihan gambar</button>
                        @if($invitation->screen_background_image)
                            <label class="mt-4 flex cursor-pointer items-start gap-3 text-xs leading-6"><input type="checkbox" name="remove_background" id="remove_background" value="1" x-model="removeBackground" :disabled="!!backgroundPreview" @checked($screenSettings['removeBackground']) class="mt-1 rounded border-neutral-300 text-red-600 focus:ring-red-500 disabled:opacity-40 dark:border-secondary-600 dark:bg-secondary-900"><span><span class="font-semibold">Hapus latar tersimpan</span><span class="block text-neutral-500 dark:text-neutral-400">Latar dihapus setelah Anda menyimpan pengaturan.</span></span></label>
                        @endif
                        <p class="screen-settings-help mt-4"><i class="fa-regular fa-lightbulb mr-1 text-primary-600" aria-hidden="true"></i>Gunakan gambar lanskap agar pas di proyektor. Gambar akan dikompresi otomatis.</p>
                    </x-screen-settings-section>

                    <x-screen-settings-section id="galeri-layar" number="04" title="Cerita Anda dalam slideshow" description="Foto bergantian tampil setelah 30 detik tanpa tamu check-in.">
                        <div class="mb-4 flex items-center justify-between gap-3"><p class="text-sm font-semibold">Galeri layar</p><span class="rounded-full bg-neutral-100 px-3 py-1 text-xs font-semibold text-neutral-500 dark:bg-secondary-700 dark:text-neutral-300"><span x-text="galleryCount">{{ $screenGalleries->count() }}</span> foto</span></div>
                        <div class="grid grid-cols-2 gap-3 sm:grid-cols-3" x-show="savedGalleryCount > removedGalleryIds.length">
                            @foreach($screenGalleries as $gallery)
                                <div class="relative overflow-hidden rounded-xl border border-neutral-200 dark:border-secondary-600" x-show="!removedGalleryIds.includes({{ $gallery->id }})">
                                    <img src="{{ asset('storage/' . $gallery->image_path) }}" alt="Foto slideshow {{ $loop->iteration }}" loading="lazy" class="aspect-[4/3] w-full object-cover">
                                    <div class="flex items-center justify-between gap-2 bg-white px-3 py-2 dark:bg-secondary-900"><span class="text-[11px] font-medium text-neutral-500 dark:text-neutral-400">Foto {{ $loop->iteration }}</span><button type="button" data-gallery-id="{{ $gallery->id }}" data-delete-url="{{ route('dashboard.welcome-screen.gallery.destroy', [$invitation, $gallery]) }}" @click="deleteGallery($el)" :disabled="deletingId !== null" aria-label="Hapus foto slideshow {{ $loop->iteration }}" class="flex h-9 w-9 items-center justify-center rounded-lg text-neutral-400 hover:bg-red-50 hover:text-red-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-red-500 disabled:opacity-40 dark:hover:bg-red-900/20"><i class="fa-regular fa-trash-can" aria-hidden="true"></i></button></div>
                                </div>
                            @endforeach
                        </div>
                        <div x-show="galleryCount === 0" class="rounded-xl border border-dashed border-neutral-200 bg-neutral-50 p-7 text-center dark:border-secondary-600 dark:bg-secondary-900"><i class="fa-regular fa-images text-2xl text-neutral-400" aria-hidden="true"></i><p class="mt-3 text-sm font-semibold">Tambahkan momen terbaik Anda</p><p class="screen-settings-help">Foto prewedding dan kenangan bersama akan menemani tamu selama acara.</p></div>
                        <p x-cloak x-show="galleryActionError" x-text="galleryActionError" role="alert" class="screen-settings-error"></p>
                        <div x-cloak x-show="pendingPhotos.length" class="mt-5 rounded-xl border border-primary-200 bg-primary-50/40 p-3 dark:border-primary-800 dark:bg-primary-900/10">
                            <div class="mb-3 flex items-center justify-between gap-3"><p class="text-xs font-semibold text-primary-700 dark:text-primary-300"><span x-text="pendingPhotos.length"></span> foto baru · belum disimpan</p><button type="button" @click="clearGallery()" class="min-h-9 text-xs font-semibold text-neutral-500 hover:text-red-600 dark:text-neutral-400">Batalkan</button></div>
                            <div class="grid grid-cols-2 gap-3 sm:grid-cols-3"><template x-for="photo in pendingPhotos" :key="photo.url"><div class="min-w-0"><img :src="photo.url" :alt="photo.name" class="aspect-[4/3] w-full rounded-lg object-cover"><p class="mt-1 truncate text-[10px] text-neutral-500 dark:text-neutral-400" x-text="photo.name"></p></div></template></div>
                        </div>
                        <div class="mt-5 border-t border-neutral-100 pt-5 dark:border-secondary-700"><label for="screen_gallery_photos" class="block text-sm font-semibold">Tambah foto slideshow</label><input id="screen_gallery_photos" name="screen_gallery_photos[]" type="file" multiple accept="image/jpeg,image/png,image/webp" x-ref="galleryInput" @change="selectGallery($event)" class="screen-settings-file"><p class="screen-settings-help">Pilih beberapa foto sekaligus. Maksimal 10 MB per foto.</p></div>
                        <p x-cloak x-show="galleryError" x-text="galleryError" role="alert" class="screen-settings-error"></p>
                        @error('screen_gallery_photos')<p class="screen-settings-error">{{ $message }}</p>@enderror
                        @error('screen_gallery_photos.*')<p class="screen-settings-error">{{ $message }}</p>@enderror
                    </x-screen-settings-section>
                </div>
                <x-screen-settings-preview :invitation="$invitation" :presets="$presets" :current-theme="$currentTheme" :screen-galleries="$screenGalleries" />
            </div>
            <div class="sticky bottom-20 z-30 mt-6 flex flex-col justify-between gap-3 rounded-2xl border border-neutral-200 bg-white/95 p-4 shadow-lg backdrop-blur sm:bottom-3 sm:flex-row sm:items-center sm:px-5 dark:border-secondary-600 dark:bg-secondary-800/95">
                <p class="flex items-center gap-2 text-xs text-neutral-500 dark:text-neutral-400" role="status"><span class="h-2 w-2 shrink-0 rounded-full" :class="dirty ? 'bg-amber-500' : 'bg-neutral-300'" aria-hidden="true"></span><span x-text="submitting ? 'Menyimpan pengaturan…' : (dirty ? 'Perubahan belum disimpan' : 'Perubahan diterapkan setelah disimpan')">Perubahan diterapkan setelah disimpan</span></p>
                <div class="flex items-center gap-3 sm:pr-14"><a href="{{ route('dashboard.invitations.guestbook', $invitation) }}" class="screen-settings-button flex-1 sm:flex-none">Kembali</a><button type="submit" :disabled="submitting" class="screen-settings-save"><i class="fa-solid fa-check" aria-hidden="true"></i><span x-text="submitting ? 'Menyimpan…' : 'Simpan pengaturan'">Simpan pengaturan</span></button></div>
            </div>
        </form>
    </div>
</div>
