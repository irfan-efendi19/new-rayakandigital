<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div class="flex items-center gap-3">
                <div>
                    <h2 class="font-heading text-2xl font-bold text-secondary-800">
                        {{ $invitation->title }}
                    </h2>
                    <p class="text-sm text-neutral-500 mt-0.5">Kelola undangan digital Anda</p>
                </div>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('invitation.show', $invitation->slug) }}" target="_blank"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-primary-50 text-primary-700 rounded-xl text-sm font-semibold hover:bg-primary-100 transition-all">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    Lihat Website
                </a>
                <a href="{{ route('dashboard.invitations.edit', $invitation) }}"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-neutral-300 rounded-xl text-sm font-semibold text-neutral-700 hover:bg-neutral-50 hover:border-primary-300 transition-all">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit Detail
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- Slug Info --}}
            <div class="bg-white rounded-2xl shadow-soft border border-neutral-100 overflow-hidden">
                <div class="p-5">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-primary-50 flex items-center justify-center text-primary">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-sm font-semibold text-secondary-800">Tautan Undangan</h3>
                                <a href="{{ route('invitation.show', $invitation->slug) }}" target="_blank"
                                    class="text-primary-600 hover:text-primary-700 font-mono text-sm">
                                    {{ parse_url(config('app.url'), PHP_URL_HOST) }}/<strong>{{ $invitation->slug }}</strong>
                                </a>
                            </div>
                        </div>
                        <div>
                            @if($invitation->slug_change_count > 0)
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-700">
                                    Diubah {{ $invitation->slug_change_count }} kali
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-neutral-100 text-neutral-600">
                                    Belum pernah diubah
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- Stats Cards --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-white rounded-2xl shadow-soft border overflow-hidden
                    {{ $invitation->hasFeature('personal_link') ? 'border-neutral-100' : 'border-amber-100 bg-amber-50/20' }}">
                    <div class="p-5">
                        <div class="flex items-center justify-between mb-3">
                            <h3 class="text-sm font-semibold text-secondary-800">Data Tamu</h3>
                            @if($invitation->hasFeature('personal_link'))
                                <a href="{{ route('dashboard.invitations.guests.index', $invitation) }}"
                                    class="text-primary-600 hover:text-primary-700 text-xs font-semibold">Kelola &rarr;</a>
                            @else
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold bg-amber-100 text-amber-800">Premium</span>
                            @endif
                        </div>
                        <div class="text-3xl font-bold text-secondary-800">{{ $invitation->guests->count() }}</div>
                        <p class="text-xs text-neutral-500 mt-1">Total tamu yang diundang</p>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-soft border border-neutral-100 p-5">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-sm font-semibold text-secondary-800">RSVP / Konfirmasi</h3>
                        <span class="text-xs text-neutral-400">Total: {{ $invitation->rsvps->sum('pax') }} pax</span>
                    </div>
                    <div class="text-3xl font-bold text-green-600">{{ $invitation->rsvps->where('attendance', 'attending')->count() }}</div>
                    <p class="text-xs text-neutral-500 mt-1">Tamu yang hadir</p>
                </div>

                <div class="bg-white rounded-2xl shadow-soft border border-neutral-100 p-5">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-sm font-semibold text-secondary-800">Buku Tamu</h3>
                    </div>
                    <div class="text-3xl font-bold text-secondary-800">{{ $invitation->wishes->count() }}</div>
                    <p class="text-xs text-neutral-500 mt-1">Total ucapan dan doa</p>
                </div>

                <div class="bg-white rounded-2xl shadow-soft border border-neutral-100 p-5">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-sm font-semibold text-secondary-800">Pengunjung</h3>
                    </div>
                    <div class="text-3xl font-bold text-primary">{{ $totalUniques }}</div>
                    <p class="text-xs text-neutral-500 mt-1">Total pengunjung unik</p>
                </div>
            </div>

            {{-- QR Check-In Scanner --}}
            <div class="bg-white rounded-2xl shadow-soft border overflow-hidden
                {{ $invitation->hasFeature('qr_checkin') ? 'border-emerald-100' : 'border-amber-100 bg-amber-50/20' }}">
                <div class="p-5">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="flex-shrink-0 inline-flex items-center justify-center w-10 h-10 rounded-xl
                                {{ $invitation->hasFeature('qr_checkin') ? 'bg-emerald-100 text-emerald-600' : 'bg-amber-100 text-amber-500' }}">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 3.5a.5.5 0 11-1 0 .5.5 0 011 0zm-7.5 0a.5.5 0 11-1 0 .5.5 0 011 0zm7.5-7.5a.5.5 0 11-1 0 .5.5 0 011 0zm-7.5 0a.5.5 0 11-1 0 .5.5 0 011 0z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-sm font-semibold text-secondary-800 flex items-center gap-2">
                                    Scanner Kehadiran (QR Check-In)
                                    @if(!$invitation->hasFeature('qr_checkin'))
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold bg-amber-100 text-amber-800">Platinum</span>
                                    @endif
                                </h3>
                                <p class="text-xs text-neutral-500 mt-0.5">
                                    @if($invitation->hasFeature('qr_checkin'))
                                        @php
                                            $checkedIn = $invitation->guests()->where('attendance_status', 'hadir')->count();
                                            $totalGuests = $invitation->guests()->count();
                                        @endphp
                                        <span class="font-semibold text-emerald-600">{{ $checkedIn }}</span> / {{ $totalGuests }} tamu sudah check-in
                                    @else
                                        Scan QR Code tamu saat hari H dan cetak tiket kehadiran
                                    @endif
                                </p>
                            </div>
                        </div>

                        @if($invitation->hasFeature('qr_checkin'))
                            <a href="{{ route('dashboard.invitations.guestbook', $invitation) }}"
                               class="inline-flex items-center gap-2 px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-sm font-semibold shadow-sm transition-all">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                Buka Scanner
                            </a>
                        @else
                            <a href="{{ route('dashboard.checkout') }}"
                               class="inline-flex items-center gap-2 px-5 py-2.5 bg-amber-500 hover:bg-amber-600 text-white rounded-xl text-sm font-semibold shadow-sm transition-all">
                                Upgrade ke Platinum
                            </a>
                        @endif
                    </div>

                    @if($invitation->hasFeature('qr_checkin') && $totalGuests > 0)
                        <div class="mt-4 w-full bg-neutral-100 rounded-full h-2">
                            <div class="bg-emerald-500 h-2 rounded-full transition-all duration-500"
                                 style="width: {{ $totalGuests > 0 ? round(($checkedIn / $totalGuests) * 100) : 0 }}%">
                            </div>
                        </div>
                        <p class="text-xs text-neutral-400 mt-1 text-right">
                            {{ $totalGuests > 0 ? round(($checkedIn / $totalGuests) * 100) : 0 }}% kehadiran
                        </p>
                    @endif
                </div>
            </div>

            {{-- Visitor Chart --}}
            <div class="bg-white rounded-2xl shadow-soft border border-neutral-100 overflow-hidden">
                <div class="p-5">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-sm font-semibold text-secondary-800">Statistik Pengunjung (30 Hari Terakhir)</h3>
                        <span class="text-xs text-neutral-500">{{ $totalViews }} total kunjungan</span>
                    </div>
                    <div class="relative" style="height: 260px;">
                        <canvas id="visitorChart"
                            data-labels='@json($chartLabels)'
                            data-totals='@json($chartTotals)'
                            data-uniques='@json($chartUniques)'
                        ></canvas>
                    </div>
                </div>
            </div>

            {{-- Video YouTube & Live Streaming --}}
            @php $videoLocked = !$invitation->hasFeature('youtube_video'); @endphp
            <div class="bg-white rounded-2xl shadow-soft border overflow-hidden
                {{ $videoLocked ? 'border-amber-100 bg-amber-50/20' : 'border-neutral-100' }}">
                <div class="p-5">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-sm font-semibold text-secondary-800 flex items-center gap-2">
                            <svg class="w-4 h-4 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                            </svg>
                            Video YouTube & Live Streaming
                            @if($videoLocked)
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold bg-amber-100 text-amber-800">Gold</span>
                            @endif
                        </h3>
                        @if(!$videoLocked && $invitation->youtube_video_id)
                            <span class="text-xs text-green-600 font-semibold flex items-center gap-1">
                                <span class="w-1.5 h-1.5 rounded-full bg-green-500 inline-block"></span>
                                Terhubung
                            </span>
                        @endif
                    </div>

                    @if(!$videoLocked)
                        <div class="space-y-4">
                            <form action="{{ route('dashboard.invitations.update', $invitation) }}" method="POST" class="space-y-3">
                                @csrf
                                @method('PUT')
                                <div>
                                    <label for="youtube_url" class="block text-xs font-semibold text-neutral-700 mb-1">Tautan Video YouTube / Live Streaming</label>
                                    <div class="flex gap-2">
                                        <input type="url" name="youtube_url" id="youtube_url"
                                            value="{{ old('youtube_url', $invitation->youtube_url) }}"
                                            class="block w-full rounded-xl border-neutral-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 text-xs"
                                            placeholder="https://youtube.com/watch?v=... atau https://youtu.be/...">
                                        <button type="submit"
                                            class="inline-flex items-center gap-1.5 px-4 py-2 bg-gradient-to-r from-primary to-primary-600 text-white rounded-xl text-xs font-semibold shadow-sm hover:shadow-md transition-all flex-shrink-0">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                            </svg>
                                            Simpan
                                        </button>
                                    </div>
                                    <p class="text-xs text-neutral-400 mt-1.5">Mendukung format <span class="font-mono">youtube.com/watch?v=</span>, <span class="font-mono">youtu.be/</span>, <span class="font-mono">youtube.com/live/</span>, atau ID video langsung.</p>
                                    @error('youtube_url') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                </div>
                            </form>

                            <div class="flex items-center justify-between bg-neutral-50 rounded-xl px-4 py-2.5 border border-neutral-200">
                                <div class="flex items-center gap-2">
                                    <div class="w-2 h-2 rounded-full {{ $invitation->show_video ? 'bg-green-500' : 'bg-neutral-300' }}"></div>
                                    <span class="text-xs font-medium text-neutral-700">Video {{ $invitation->show_video ? 'ditampilkan' : 'disembunyikan' }} di halaman undangan</span>
                                </div>
                                <a href="{{ route('dashboard.invitations.edit', $invitation) }}#video-section"
                                    class="text-xs text-primary-600 hover:text-primary-700 font-semibold">Ubah di Edit &rarr;</a>
                            </div>

                            @if($invitation->youtube_video_id)
                                <div class="relative" style="padding-bottom: 56.25%; height: 0; overflow: hidden; border-radius: 12px; border: 1px solid #e5e7eb;">
                                    <iframe src="https://www.youtube.com/embed/{{ $invitation->youtube_video_id }}?autoplay=0&rel=0" allowfullscreen loading="lazy"
                                        style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: none; border-radius: 12px;"></iframe>
                                </div>
                                <div class="flex items-center justify-between">
                                    <a href="https://youtube.com/watch?v={{ $invitation->youtube_video_id }}" target="_blank"
                                        class="inline-flex items-center gap-1.5 text-xs text-primary-600 hover:text-primary-700 font-semibold">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                        </svg>
                                        Buka di YouTube
                                    </a>
                                    <span class="text-xs text-neutral-400">ID: {{ $invitation->youtube_video_id }}</span>
                                </div>
                            @else
                                <div class="bg-neutral-50 border border-dashed border-neutral-200 rounded-xl p-6 text-center">
                                    <div class="w-10 h-10 mx-auto rounded-xl bg-neutral-100 flex items-center justify-center text-neutral-400">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <p class="mt-2 text-xs font-medium text-neutral-500">Belum ada video ditambahkan</p>
                                    <p class="mt-0.5 text-xs text-neutral-400">Masukkan tautan YouTube di atas untuk menampilkan video atau siaran langsung di undangan Anda.</p>
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="text-center py-8">
                            <div class="w-14 h-14 mx-auto rounded-2xl bg-amber-100 flex items-center justify-center">
                                <svg class="w-7 h-7 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <h4 class="mt-3 font-semibold text-secondary-800">Fitur Video & Live Streaming Terkunci</h4>
                            <p class="mt-1 text-xs text-neutral-500 max-w-sm mx-auto">Upgrade ke paket Gold atau Platinum untuk menyematkan video YouTube dan siaran langsung di halaman undangan Anda.</p>
                            <a href="{{ route('dashboard.checkout') }}"
                                class="mt-4 inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-primary to-primary-600 text-white rounded-xl text-xs font-semibold shadow-sm hover:shadow-md transition-all">
                                Upgrade Sekarang
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Gallery & Gift --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Gallery --}}
                @php $galleryLocked = !$invitation->hasFeature('gallery_photos'); @endphp
                <div class="bg-white rounded-2xl shadow-soft border overflow-hidden
                    {{ $galleryLocked ? 'border-amber-100 bg-amber-50/20' : 'border-neutral-100' }}">
                    <div class="p-5">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-sm font-semibold text-secondary-800 flex items-center gap-2">
                                <svg class="w-4 h-4 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                Galeri Foto
                                @if($galleryLocked)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold bg-amber-100 text-amber-800">Premium</span>
                                @endif
                            </h3>
                            @if(!$galleryLocked)
                                <span class="text-xs text-neutral-500 font-semibold">{{ count($invitation->gallery_photos ?? []) }} / {{ $invitation->maxGalleryPhotos() }} Foto</span>
                            @endif
                        </div>

                        @if(!$galleryLocked)
                            <div class="space-y-6">
                                <form id="gallery-upload-form" action="{{ route('dashboard.invitations.gallery.update', $invitation) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                                    @csrf
                                    <div id="gallery-dropzone" class="relative border-2 border-dashed border-primary-300 rounded-2xl p-6 text-center cursor-pointer hover:border-primary-400 hover:bg-primary-50/50 transition-all duration-200">
                                        <input type="file" name="photos[]" id="gallery-file-input" multiple accept="image/*" class="hidden">
                                        <div id="dropzone-empty" class="space-y-2">
                                            <div class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-primary-100 text-primary-600">
                                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                                </svg>
                                            </div>
                                            <p class="text-sm font-medium text-neutral-700">Seret foto ke sini atau <span class="text-primary-600 underline">klik untuk memilih</span></p>
                                            <p class="text-xs text-neutral-400">Format gambar apa pun. Akan dikonversi ke WebP otomatis.</p>
                                        </div>
                                        <div id="dropzone-preview" class="hidden space-y-3">
                                            <div id="preview-thumbnails" class="flex flex-wrap gap-2 justify-center max-h-48 overflow-y-auto"></div>
                                            <div class="flex items-center justify-center gap-2 text-sm text-neutral-500">
                                                <span id="file-count"></span>
                                                <button type="button" id="gallery-change-files" class="text-primary-600 hover:text-primary-700 underline text-xs">Ganti pilihan</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex items-center justify-end gap-3">
                                        <span id="dropzone-error" class="text-xs text-red-500 hidden"></span>
                                        <button type="submit" id="gallery-submit-btn"
                                            class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-primary to-primary-600 text-white rounded-xl text-sm font-semibold shadow-sm hover:shadow-md transition-all disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                                            Unggah <span id="upload-count"></span>
                                        </button>
                                    </div>
                                </form>

                                @if(empty($invitation->gallery_photos))
                                    <p class="text-neutral-500 text-center py-4 text-sm">Belum ada foto galeri.</p>
                                @else
                                    <div class="grid grid-cols-3 sm:grid-cols-4 gap-3">
                                        @foreach($invitation->gallery_photos as $index => $photo)
                                            <div class="relative group aspect-square rounded-xl overflow-hidden border border-neutral-100 bg-neutral-50">
                                                <img src="{{ asset('storage/' . $photo) }}" alt="Gallery photo" class="w-full h-full object-cover">
                                                <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                                    <form action="{{ route('dashboard.invitations.gallery.destroy', $invitation) }}" method="POST" onsubmit="return confirmSwal(event, 'Hapus foto ini?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <input type="hidden" name="photo_index" value="{{ $index }}">
                                                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white rounded-full p-1.5 shadow-md transition-all">
                                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                            </svg>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @else
                            <div class="text-center py-8">
                                <div class="w-14 h-14 mx-auto rounded-2xl bg-amber-100 flex items-center justify-center">
                                    <svg class="w-7 h-7 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                </div>
                                <h4 class="mt-3 font-semibold text-secondary-800">Fitur Galeri Foto Terkunci</h4>
                                <p class="mt-1 text-xs text-neutral-500 max-w-sm mx-auto">Upgrade paket Anda untuk menampilkan galeri foto.</p>
                                <a href="{{ route('dashboard.checkout') }}"
                                    class="mt-4 inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-primary to-primary-600 text-white rounded-xl text-xs font-semibold shadow-sm hover:shadow-md transition-all">
                                    Upgrade Sekarang
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Gift --}}
                <div class="bg-white rounded-2xl shadow-soft border overflow-hidden
                    {{ $invitation->canUseGift() ? 'border-neutral-100' : 'border-amber-100 bg-amber-50/20' }}">
                    <div class="p-5">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-sm font-semibold text-secondary-800 flex items-center gap-2">
                                <svg class="w-4 h-4 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                                Kado Digital
                                @if(!$invitation->canUseGift())
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold bg-amber-100 text-amber-800">Premium</span>
                                @endif
                            </h3>
                        </div>

                        @if($invitation->canUseGift())
                            @php
                                $maxGift = $invitation->maxGiftAccounts();
                                $oldBanks = old('gift_banks', $invitation->gift_banks ?? []);
                                $oldEwallets = old('gift_ewallets', $invitation->gift_ewallets ?? []);

                                if (empty($oldBanks) && ($invitation->gift_bank_name || $invitation->gift_bank_account)) {
                                    $oldBanks = [['bank_name' => $invitation->gift_bank_name, 'account_number' => $invitation->gift_bank_account, 'account_holder' => $invitation->gift_bank_holder]];
                                }
                                if (empty($oldEwallets) && ($invitation->gift_ewallet_name || $invitation->gift_ewallet_number)) {
                                    $oldEwallets = [['wallet_name' => $invitation->gift_ewallet_name, 'wallet_number' => $invitation->gift_ewallet_number]];
                                }
                            @endphp
                            <form id="gift-form" action="{{ route('dashboard.invitations.gift.update', $invitation) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                                @csrf
                                <div class="flex items-center justify-between">
                                    <span class="text-xs text-neutral-500 font-semibold">Maksimal {{ $maxGift }} akun</span>
                                    <span id="gift-account-count" class="text-xs text-neutral-400">0 / {{ $maxGift }}</span>
                                </div>

                                <div id="gift-banks-container" class="space-y-3">
                                    <div class="flex items-center justify-between">
                                        <label class="text-xs font-semibold text-neutral-700">Transfer Bank</label>
                                        <button type="button" id="add-bank-btn" class="text-xs text-primary-600 hover:text-primary-700 font-semibold">+ Tambah Bank</button>
                                    </div>
                                    @foreach($oldBanks as $bankIdx => $bank)
                                        @php $bank = (object) $bank; @endphp
                                        <div class="gift-bank-card bg-neutral-50 p-3 rounded-xl border border-neutral-200 space-y-2">
                                            <div class="flex items-center justify-between">
                                                <span class="text-xs font-semibold text-neutral-500">Bank #{{ $loop->iteration }}</span>
                                                <button type="button" class="remove-bank text-red-400 hover:text-red-600 text-xs font-semibold">Hapus</button>
                                            </div>
                                            <div class="grid grid-cols-2 gap-2">
                                                <div>
                                                    <input type="text" name="gift_banks[{{ $bankIdx }}][bank_name]" value="{{ old('gift_banks.' . $bankIdx . '.bank_name', $bank->bank_name ?? '') }}" class="block w-full rounded-xl border-neutral-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 text-xs" placeholder="Nama Bank">
                                                    @error('gift_banks.' . $bankIdx . '.bank_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                                </div>
                                                <div>
                                                    <input type="text" name="gift_banks[{{ $bankIdx }}][account_number]" value="{{ old('gift_banks.' . $bankIdx . '.account_number', $bank->account_number ?? '') }}" class="block w-full rounded-xl border-neutral-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 text-xs" placeholder="No. Rekening">
                                                    @error('gift_banks.' . $bankIdx . '.account_number') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                                </div>
                                                <div class="col-span-2">
                                                    <input type="text" name="gift_banks[{{ $bankIdx }}][account_holder]" value="{{ old('gift_banks.' . $bankIdx . '.account_holder', $bank->account_holder ?? '') }}" class="block w-full rounded-xl border-neutral-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 text-xs" placeholder="Atas Nama">
                                                    @error('gift_banks.' . $bankIdx . '.account_holder') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <div id="gift-ewallets-container" class="space-y-3">
                                    <div class="flex items-center justify-between">
                                        <label class="text-xs font-semibold text-neutral-700">Dompet Digital</label>
                                        <button type="button" id="add-ewallet-btn" class="text-xs text-primary-600 hover:text-primary-700 font-semibold">+ Tambah E-Wallet</button>
                                    </div>
                                    @foreach($oldEwallets as $ewalletIdx => $ewallet)
                                        @php $ewallet = (object) $ewallet; @endphp
                                        <div class="gift-ewallet-card bg-neutral-50 p-3 rounded-xl border border-neutral-200 space-y-2">
                                            <div class="flex items-center justify-between">
                                                <span class="text-xs font-semibold text-neutral-500">E-Wallet #{{ $loop->iteration }}</span>
                                                <button type="button" class="remove-ewallet text-red-400 hover:text-red-600 text-xs font-semibold">Hapus</button>
                                            </div>
                                            <div class="grid grid-cols-2 gap-2">
                                                <div>
                                                    <input type="text" name="gift_ewallets[{{ $ewalletIdx }}][wallet_name]" value="{{ old('gift_ewallets.' . $ewalletIdx . '.wallet_name', $ewallet->wallet_name ?? '') }}" class="block w-full rounded-xl border-neutral-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 text-xs" placeholder="Nama E-Wallet">
                                                    @error('gift_ewallets.' . $ewalletIdx . '.wallet_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                                </div>
                                                <div>
                                                    <input type="text" name="gift_ewallets[{{ $ewalletIdx }}][wallet_number]" value="{{ old('gift_ewallets.' . $ewalletIdx . '.wallet_number', $ewallet->wallet_number ?? '') }}" class="block w-full rounded-xl border-neutral-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 text-xs" placeholder="Nomor E-Wallet">
                                                    @error('gift_ewallets.' . $ewalletIdx . '.wallet_number') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <hr class="border-neutral-100">

                                <div>
                                    <label class="block text-xs font-semibold text-neutral-700">Barcode QRIS</label>
                                    <div class="mt-1 flex items-center gap-4">
                                        @if($invitation->gift_qris_image)
                                            <img src="{{ asset('storage/' . $invitation->gift_qris_image) }}" alt="QRIS" class="w-16 h-16 object-contain border border-neutral-200 rounded-xl">
                                        @endif
                                        <input type="file" name="gift_qris_image" id="gift_qris_image"
                                            class="text-xs text-neutral-500 file:mr-4 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100">
                                    </div>
                                    @error('gift_qris_image') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>

                                <div class="pt-2 flex justify-end">
                                    <button type="submit"
                                        class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-primary to-primary-600 text-white rounded-xl text-xs font-semibold shadow-sm hover:shadow-md transition-all">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        Simpan Kado Digital
                                    </button>
                                </div>
                            </form>

                            <script>
                                document.addEventListener('DOMContentLoaded', function () {
                                    const maxAccounts = {{ $maxGift }};
                                    const banksContainer = document.getElementById('gift-banks-container');
                                    const ewalletsContainer = document.getElementById('gift-ewallets-container');
                                    const bankTemplate = document.getElementById('gift-bank-template');
                                    const ewalletTemplate = document.getElementById('gift-ewallet-template');
                                    const accountCountEl = document.getElementById('gift-account-count');

                                    function updateAccountCount() {
                                        const total = banksContainer.querySelectorAll('.gift-bank-card').length + ewalletsContainer.querySelectorAll('.gift-ewallet-card').length;
                                        accountCountEl.textContent = total + ' / ' + maxAccounts;
                                        document.getElementById('add-bank-btn').style.display = total >= maxAccounts ? 'none' : '';
                                        document.getElementById('add-ewallet-btn').style.display = total >= maxAccounts ? 'none' : '';
                                    }

                                    function reindexItems(container, prefix) {
                                        const cards = container.querySelectorAll('[class*="gift-' + prefix + '-card"]');
                                        cards.forEach(function (card, idx) {
                                            const inputs = card.querySelectorAll('[name]');
                                            inputs.forEach(function (input) {
                                                const name = input.getAttribute('name');
                                                if (name) {
                                                    input.setAttribute('name', name.replace(new RegExp(prefix + 's\\[\\d+\\]'), prefix + 's[' + idx + ']'));
                                                }
                                            });
                                            const label = card.querySelector('span.text-xs.font-semibold.text-neutral-500');
                                            if (label) {
                                                const prefixLabel = prefix === 'bank' ? 'Bank' : 'E-Wallet';
                                                label.textContent = prefixLabel + ' #' + (idx + 1);
                                            }
                                        });
                                    }

                                    function addItem(container, templateId, prefix) {
                                        const total = banksContainer.querySelectorAll('.gift-bank-card').length + ewalletsContainer.querySelectorAll('.gift-ewallet-card').length;
                                        if (total >= maxAccounts) return;

                                        const template = document.getElementById(templateId);
                                        const clone = template.content.cloneNode(true);
                                        const card = clone.querySelector('[class*="gift-' + prefix + '-card"]');
                                        container.appendChild(card);
                                        reindexItems(container, prefix);
                                        updateAccountCount();
                                    }

                                    banksContainer.addEventListener('click', function (e) {
                                        if (e.target.closest('.remove-bank')) {
                                            e.target.closest('.gift-bank-card').remove();
                                            reindexItems(banksContainer, 'bank');
                                            updateAccountCount();
                                        }
                                    });

                                    ewalletsContainer.addEventListener('click', function (e) {
                                        if (e.target.closest('.remove-ewallet')) {
                                            e.target.closest('.gift-ewallet-card').remove();
                                            reindexItems(ewalletsContainer, 'ewallet');
                                            updateAccountCount();
                                        }
                                    });

                                    document.getElementById('add-bank-btn').addEventListener('click', function () {
                                        addItem(banksContainer, 'gift-bank-template', 'bank');
                                    });

                                    document.getElementById('add-ewallet-btn').addEventListener('click', function () {
                                        addItem(ewalletsContainer, 'gift-ewallet-template', 'ewallet');
                                    });

                                    updateAccountCount();
                                });
                            </script>

                            <template id="gift-bank-template">
                                <div class="gift-bank-card bg-neutral-50 p-3 rounded-xl border border-neutral-200 space-y-2">
                                    <div class="flex items-center justify-between">
                                        <span class="text-xs font-semibold text-neutral-500">Bank Baru</span>
                                        <button type="button" class="remove-bank text-red-400 hover:text-red-600 text-xs font-semibold">Hapus</button>
                                    </div>
                                    <div class="grid grid-cols-2 gap-2">
                                        <div>
                                            <input type="text" name="gift_banks[999][bank_name]" class="block w-full rounded-xl border-neutral-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 text-xs" placeholder="Nama Bank">
                                        </div>
                                        <div>
                                            <input type="text" name="gift_banks[999][account_number]" class="block w-full rounded-xl border-neutral-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 text-xs" placeholder="No. Rekening">
                                        </div>
                                        <div class="col-span-2">
                                            <input type="text" name="gift_banks[999][account_holder]" class="block w-full rounded-xl border-neutral-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 text-xs" placeholder="Atas Nama">
                                        </div>
                                    </div>
                                </div>
                            </template>

                            <template id="gift-ewallet-template">
                                <div class="gift-ewallet-card bg-neutral-50 p-3 rounded-xl border border-neutral-200 space-y-2">
                                    <div class="flex items-center justify-between">
                                        <span class="text-xs font-semibold text-neutral-500">E-Wallet Baru</span>
                                        <button type="button" class="remove-ewallet text-red-400 hover:text-red-600 text-xs font-semibold">Hapus</button>
                                    </div>
                                    <div class="grid grid-cols-2 gap-2">
                                        <div>
                                            <input type="text" name="gift_ewallets[999][wallet_name]" class="block w-full rounded-xl border-neutral-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 text-xs" placeholder="Nama E-Wallet">
                                        </div>
                                        <div>
                                            <input type="text" name="gift_ewallets[999][wallet_number]" class="block w-full rounded-xl border-neutral-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 text-xs" placeholder="Nomor E-Wallet">
                                        </div>
                                    </div>
                                </div>
                            </template>
                        @else
                            <div class="text-center py-8">
                                <div class="w-14 h-14 mx-auto rounded-2xl bg-amber-100 flex items-center justify-center">
                                    <svg class="w-7 h-7 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                </div>
                                <h4 class="mt-3 font-semibold text-secondary-800">Fitur Kado Digital Terkunci</h4>
                                <p class="mt-1 text-xs text-neutral-500 max-w-sm mx-auto">Upgrade paket Anda untuk menerima kado digital.</p>
                                <a href="{{ route('dashboard.checkout') }}"
                                    class="mt-4 inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-primary to-primary-600 text-white rounded-xl text-xs font-semibold shadow-sm hover:shadow-md transition-all">
                                    Upgrade Sekarang
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Wishes --}}
            <div class="bg-white rounded-2xl shadow-soft border border-neutral-100 overflow-hidden">
                <div class="p-5">
                    <h3 class="text-sm font-semibold text-secondary-800 mb-4">Buku Tamu Terbaru</h3>

                    @if($invitation->wishes->isEmpty())
                        <p class="text-neutral-500 text-center py-4 text-sm">Belum ada ucapan dari tamu.</p>
                    @else
                        <div class="space-y-4">
                            @foreach($invitation->wishes->take(5) as $wish)
                                <div class="border-b border-neutral-100 pb-4 last:border-0 last:pb-0">
                                    <div class="flex items-center gap-2 mb-1">
                                        <div class="w-7 h-7 rounded-full bg-primary-100 flex items-center justify-center text-primary-700 text-xs font-semibold">
                                            {{ substr($wish->guest_name, 0, 1) }}
                                        </div>
                                        <h4 class="font-semibold text-sm text-secondary-800">{{ $wish->guest_name }}</h4>
                                    </div>
                                    <p class="text-sm text-neutral-600 ml-9">{{ $wish->message }}</p>
                                    <p class="text-xs text-neutral-400 mt-1 ml-9">{{ $wish->created_at->diffForHumans() }}</p>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            {{-- RSVP --}}
            <div class="bg-white rounded-2xl shadow-soft border border-neutral-100 overflow-hidden">
                <div class="p-5">
                    <h3 class="text-sm font-semibold text-secondary-800 mb-4">RSVP Terbaru</h3>

                    @if($invitation->rsvps->isEmpty())
                        <p class="text-neutral-500 text-center py-4 text-sm">Belum ada konfirmasi kehadiran dari tamu.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-neutral-200">
                                <thead class="bg-neutral-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-neutral-500 uppercase tracking-wider">Nama Tamu</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-neutral-500 uppercase tracking-wider">Kehadiran</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-neutral-500 uppercase tracking-wider">Jumlah (Pax)</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-neutral-500 uppercase tracking-wider">Waktu</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-neutral-100">
                                    @foreach($invitation->rsvps->take(10) as $rsvp)
                                        <tr class="hover:bg-neutral-50 transition-colors">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-secondary-800">{{ $rsvp->guest_name }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold
                                                    {{ $rsvp->attendance === 'attending' ? 'bg-green-100 text-green-700' :
                                                      ($rsvp->attendance === 'not_attending' ? 'bg-red-100 text-red-700' : 'bg-amber-100 text-amber-700') }}">
                                                    {{ $rsvp->attendanceLabel() }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-600">{{ $rsvp->pax }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-500">{{ $rsvp->created_at->format('d/m/Y H:i') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Gallery Upload Script --}}
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const dropzone = document.getElementById('gallery-dropzone');
                    const fileInput = document.getElementById('gallery-file-input');
                    const dropzoneEmpty = document.getElementById('dropzone-empty');
                    const dropzonePreview = document.getElementById('dropzone-preview');
                    const previewThumbnails = document.getElementById('preview-thumbnails');
                    const fileCount = document.getElementById('file-count');
                    const uploadCount = document.getElementById('upload-count');
                    const submitBtn = document.getElementById('gallery-submit-btn');
                    const dropzoneError = document.getElementById('dropzone-error');
                    const changeFilesBtn = document.getElementById('gallery-change-files');
                    let selectedFiles = [];

                    const allowedTypes = ['image/jpeg', 'image/png', 'image/webp', 'image/avif', 'image/heic', 'image/heif'];

                    function updatePreview() {
                        previewThumbnails.innerHTML = '';
                        let validFiles = [];
                        let errorMsg = '';

                        for (const file of selectedFiles) {
                            if (!allowedTypes.includes(file.type)) {
                                errorMsg = 'Format tidak didukung. Gunakan JPG, PNG, atau WEBP.';
                                continue;
                            }
                            validFiles.push(file);

                            const reader = new FileReader();
                            const wrapper = document.createElement('div');
                            wrapper.className = 'relative group w-16 h-16 rounded-lg overflow-hidden border border-neutral-200 flex-shrink-0';

                            const img = document.createElement('img');
                            img.className = 'w-full h-full object-cover';

                            const removeBtn = document.createElement('button');
                            removeBtn.type = 'button';
                            removeBtn.className = 'absolute top-0.5 right-0.5 w-4 h-4 bg-red-500 text-white rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity text-xs leading-none';
                            removeBtn.innerHTML = '&times;';
                            removeBtn.dataset.index = selectedFiles.indexOf(file).toString();

                            removeBtn.addEventListener('click', function (e) {
                                e.stopPropagation();
                                const idx = parseInt(this.dataset.index);
                                selectedFiles.splice(idx, 1);
                                updatePreview();
                            });

                            wrapper.appendChild(img);
                            wrapper.appendChild(removeBtn);
                            previewThumbnails.appendChild(wrapper);

                            reader.onload = function (e) {
                                img.src = e.target.result;
                            };
                            reader.readAsDataURL(file);
                        }

                        selectedFiles = validFiles;

                        if (selectedFiles.length === 0) {
                            dropzoneEmpty.classList.remove('hidden');
                            dropzonePreview.classList.add('hidden');
                            submitBtn.disabled = true;
                            submitBtn.querySelector('#upload-count').textContent = '';
                            dropzoneError.textContent = errorMsg;
                            dropzoneError.classList.toggle('hidden', !errorMsg);
                            return;
                        }

                        dropzoneError.classList.add('hidden');
                        dropzoneEmpty.classList.add('hidden');
                        dropzonePreview.classList.remove('hidden');
                        fileCount.textContent = selectedFiles.length + ' foto dipilih';
                        uploadCount.textContent = '(' + selectedFiles.length + ')';
                        submitBtn.disabled = false;
                    }

                    dropzone.addEventListener('click', function () {
                        fileInput.click();
                    });

                    dropzone.addEventListener('dragover', function (e) {
                        e.preventDefault();
                        this.classList.add('border-primary-500', 'bg-primary-100/50');
                    });

                    dropzone.addEventListener('dragleave', function () {
                        this.classList.remove('border-primary-500', 'bg-primary-100/50');
                    });

                    dropzone.addEventListener('drop', function (e) {
                        e.preventDefault();
                        this.classList.remove('border-primary-500', 'bg-primary-100/50');
                        const files = Array.from(e.dataTransfer.files).filter(f => allowedTypes.includes(f.type));
                        if (files.length > 0) {
                            selectedFiles = selectedFiles.concat(files);
                            updatePreview();
                        }
                    });

                    fileInput.addEventListener('change', function () {
                        const files = Array.from(this.files);
                        if (files.length > 0) {
                            selectedFiles = selectedFiles.concat(files);
                            updatePreview();
                        }
                        this.value = '';
                    });

                    if (changeFilesBtn) {
                        changeFilesBtn.addEventListener('click', function (e) {
                            e.stopPropagation();
                            fileInput.click();
                        });
                    }

                    document.getElementById('gallery-upload-form').addEventListener('submit', function (e) {
                        if (selectedFiles.length === 0) {
                            e.preventDefault();
                            return;
                        }

                        const dataTransfer = new DataTransfer();
                        selectedFiles.forEach(f => dataTransfer.items.add(f));
                        fileInput.files = dataTransfer.files;
                    });
                });
            </script>

            {{-- Danger Zone --}}
            <div class="bg-red-50 rounded-2xl shadow-soft border border-red-200 overflow-hidden">
                <div class="p-5">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-9 h-9 rounded-xl bg-red-100 flex items-center justify-center text-red-600">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-semibold text-red-800">Danger Zone</h3>
                            <p class="text-xs text-red-600">Menghapus undangan akan menghapus semua data terkait. Tindakan ini tidak dapat dibatalkan.</p>
                        </div>
                    </div>

                    <form action="{{ route('dashboard.invitations.destroy', $invitation) }}" method="POST" onsubmit="return confirmSwal(event, 'Apakah Anda yakin ingin menghapus undangan ini secara permanen?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="inline-flex items-center gap-2 px-4 py-2 bg-red-600 text-white rounded-xl text-sm font-semibold hover:bg-red-700 hover:shadow-md transition-all">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Hapus Undangan
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
