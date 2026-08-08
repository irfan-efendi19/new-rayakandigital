<x-app-layout>
    <div class="min-h-screen">

        {{-- ─── HERO ─── --}}
        <div class="hero-mesh grain-overlay border-b border-neutral-200/60 dark:border-secondary-700/40">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-7 sm:py-8">

                {{-- Breadcrumb --}}
                <nav class="flex items-center gap-1.5 text-xs text-neutral-400 dark:text-neutral-500 mb-4">
                    <a href="{{ route('dashboard') }}" class="hover:text-primary dark:hover:text-primary-400 transition-colors">Dashboard</a>
                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                    <a href="{{ route('dashboard.invitations.show', $invitation) }}" class="hover:text-primary dark:hover:text-primary-400 transition-colors truncate max-w-[150px]">{{ $invitation->title }}</a>
                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                    <a href="{{ route('dashboard.invitations.qr-codes', $invitation) }}" class="hover:text-primary dark:hover:text-primary-400 transition-colors">Pusat QR Code</a>
                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                    <span class="text-neutral-600 dark:text-neutral-400 font-medium">QR Galeri Foto Bersama</span>
                </nav>

                <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
                    <div class="flex items-start gap-3 min-w-0">
                        <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-primary to-primary-600 flex items-center justify-center text-white shadow-lg shadow-primary/20 shrink-0">
                            <i class="fa-solid fa-camera-retro text-lg"></i>
                        </div>
                        <div class="min-w-0">
                            <h1 class="font-heading text-2xl sm:text-3xl font-bold text-secondary-800 dark:text-neutral-50 leading-tight">
                                QR Galeri Foto Bersama
                            </h1>
                            <p class="text-sm text-neutral-500 dark:text-neutral-400 mt-1">
                                Kelola galeri momen bersama foto yang diunggah tamu untuk undangan <strong class="text-secondary-700 dark:text-neutral-300">"{{ $invitation->title }}"</strong>
                            </p>
                        </div>
                    </div>
                    <a href="{{ route('dashboard.invitations.qr-codes', $invitation) }}"
                        class="inline-flex items-center gap-1.5 px-3.5 py-2 text-xs font-semibold text-secondary-700 dark:text-neutral-300 border border-neutral-300/80 dark:border-secondary-600 rounded-xl hover:bg-white dark:hover:bg-secondary-700 transition-all bg-white/70 dark:bg-secondary-800/50 backdrop-blur-sm shrink-0">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                        Kembali ke Pusat QR Code
                    </a>
                </div>

                {{-- Stat Strip --}}
                <div class="mt-6 bg-neutral-200/70 dark:bg-secondary-700/50 rounded-2xl overflow-hidden border border-neutral-200/80 dark:border-secondary-700/50">
                    <div class="bg-white/80 dark:bg-secondary-800/70 px-4 sm:px-6 py-4 flex flex-col items-center sm:items-start text-center sm:text-left backdrop-blur-sm">
                        <span class="text-xl sm:text-2xl font-bold text-primary dark:text-primary-400 tabular-nums">{{ $photos->count() }}</span>
                        <span class="text-[10px] sm:text-xs text-neutral-500 dark:text-neutral-400 font-medium mt-0.5">Total Foto Diunggah Tamu</span>
                    </div>
                </div>

            </div>
        </div>

        {{-- ─── MAIN CONTENT ─── --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-7 sm:py-8 space-y-5">

            @if(session('success'))
                <div class="bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200/70 dark:border-emerald-800/40 rounded-2xl px-5 py-3.5 flex items-center gap-3">
                    <div class="w-7 h-7 rounded-full bg-emerald-100 dark:bg-emerald-900/50 flex items-center justify-center text-emerald-600 dark:text-emerald-400 shrink-0">
                        <i class="fa-solid fa-check text-xs"></i>
                    </div>
                    <p class="text-xs font-semibold text-emerald-800 dark:text-emerald-300">{{ session('success') }}</p>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-5 gap-5">

                {{-- QR Code Card --}}
                <div class="lg:col-span-2 bg-white dark:bg-secondary-800 rounded-2xl border border-neutral-200/80 dark:border-secondary-700/60 p-6 sm:p-7 self-start">
                    <div class="flex items-center gap-2.5 mb-1">
                        <div class="w-8 h-8 rounded-lg bg-primary-50 dark:bg-primary-900/30 flex items-center justify-center text-primary dark:text-primary-400 flex-shrink-0">
                            <i class="fa-solid fa-qrcode text-sm"></i>
                        </div>
                        <h2 class="font-semibold text-sm text-secondary-800 dark:text-neutral-100">QR Code Galeri</h2>
                    </div>
                    <p class="text-xs text-neutral-500 dark:text-neutral-400 mb-5 ml-10">QR ini mengarahkan tamu ke halaman galeri foto bersama dan upload momen.</p>

                    <div class="flex flex-col items-center">
                        <div class="bg-white p-4 rounded-2xl shadow-sm border border-neutral-200 dark:border-neutral-600 inline-block">
                            <div class="w-52 h-52 sm:w-56 sm:h-56 flex items-center justify-center">
                                <img src="{{ $qrGalleryCodeData }}" alt="QR Code Galeri" class="w-full h-full">
                            </div>
                        </div>
                    </div>

                    <div class="mt-5 w-full space-y-2.5">
                        <div class="bg-neutral-50 dark:bg-secondary-700/50 border border-neutral-200 dark:border-secondary-600 rounded-xl p-3">
                            <p class="text-xs text-neutral-500 dark:text-neutral-400 mb-1">Tautan halaman Galeri:</p>
                            <div class="flex items-center gap-2">
                                <input type="text" id="gallery-url-input" value="{{ $qrGalleryUrl }}" readonly
                                    class="flex-1 text-xs font-mono bg-white dark:bg-secondary-800 border border-neutral-200 dark:border-secondary-600 rounded-lg px-2 py-1.5 text-neutral-700 dark:text-neutral-300 focus:ring-0 focus:border-primary-400">
                                <button type="button" onclick="copyGalleryUrl()" id="copy-gallery-btn"
                                    class="flex-shrink-0 px-3 py-1.5 bg-primary-50 dark:bg-primary-900/50 text-primary-700 dark:text-primary-300 rounded-lg text-xs font-semibold hover:bg-primary-100 dark:hover:bg-primary-900/70 transition">
                                    Salin
                                </button>
                            </div>
                        </div>

                        <a href="{{ $qrGalleryCodeData }}" download="qr-galeri-{{ $invitation->slug }}.png"
                            class="inline-flex items-center justify-center gap-2 w-full px-4 py-2.5 bg-gradient-to-r from-primary to-primary-600 text-white rounded-xl text-sm font-semibold shadow-sm shadow-primary/20 hover:shadow-md hover:-translate-y-0.5 active:translate-y-0 transition-all">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                            Download QR Code
                        </a>

                        <a href="{{ $qrGalleryUrl }}" target="_blank"
                            class="inline-flex items-center justify-center gap-2 w-full px-4 py-2 text-primary-700 dark:text-primary-300 bg-primary-50 dark:bg-primary-900/30 rounded-xl text-xs font-semibold hover:bg-primary-100 transition border border-primary-200/60 dark:border-primary-800/40">
                            Lihat Halaman Publik →
                        </a>
                    </div>
                </div>

                {{-- Right Column: Photographer Drive + Guest Photos --}}
                <div class="lg:col-span-3 space-y-5">

                    {{-- Photographer Drive Config Card --}}
                    <div class="bg-white dark:bg-secondary-800 rounded-2xl border border-neutral-200/80 dark:border-secondary-700/60 overflow-hidden">
                        <div class="px-5 sm:px-6 py-4 border-b border-neutral-100 dark:border-secondary-700/60 flex items-center gap-2.5">
                            <div class="w-8 h-8 rounded-lg bg-primary-50 dark:bg-primary-900/30 flex items-center justify-center text-primary dark:text-primary-400 flex-shrink-0">
                                <i class="fa-solid fa-camera font-bold text-sm"></i>
                            </div>
                            <div>
                                <h2 class="font-semibold text-sm text-secondary-800 dark:text-neutral-100">Cloud Drive Dokumentasi Fotografer</h2>
                                <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-0.5">Tautan album resmi hasil foto & video dari fotografer acara</p>
                            </div>
                        </div>

                        <form action="{{ route('dashboard.invitations.qr-gallery.update', $invitation) }}" method="POST" class="p-5 sm:p-6 space-y-4">
                            @csrf
                            @method('PATCH')

                            <div>
                                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Link Drive Foto Official (Google Drive / Photos / Dropbox)</label>
                                <input type="url" name="photographer_drive_url" value="{{ old('photographer_drive_url', $invitation->photographer_drive_url) }}"
                                    class="mt-1 block w-full rounded-xl border-neutral-300 dark:border-neutral-600 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm dark:bg-secondary-700 dark:text-neutral-200"
                                    placeholder="https://drive.google.com/drive/folders/...">
                                <p class="mt-1 text-xs text-neutral-400 dark:text-neutral-500">Tautan ini akan tampil di halaman galeri sebagai akses album dokumentasi resmi hasil jepretan fotografer acara.</p>
                            </div>

                            <button type="submit"
                                class="inline-flex items-center justify-center gap-2 w-full px-4 py-2.5 bg-gradient-to-r from-primary to-primary-600 text-white rounded-xl text-sm font-semibold shadow-sm shadow-primary/20 hover:shadow-md hover:-translate-y-0.5 active:translate-y-0 transition-all">
                                <i class="fa-solid fa-floppy-disk"></i> Simpan Link Drive Fotografer
                            </button>
                        </form>
                    </div>

                    {{-- Photos Management Card --}}
                    <div class="bg-white dark:bg-secondary-800 rounded-2xl border border-neutral-200/80 dark:border-secondary-700/60 overflow-hidden">
                        <div class="px-5 sm:px-6 py-4 border-b border-neutral-100 dark:border-secondary-700/60 flex items-center justify-between">
                            <div class="flex items-center gap-2.5">
                                <div class="w-8 h-8 rounded-lg bg-primary-50 dark:bg-primary-900/30 flex items-center justify-center text-primary dark:text-primary-400 flex-shrink-0">
                                    <i class="fa-solid fa-images text-sm"></i>
                                </div>
                                <div>
                                    <h2 class="font-semibold text-sm text-secondary-800 dark:text-neutral-100">Foto Diunggah Tamu</h2>
                                    <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-0.5">Kelola foto yang diunggah tamu dari venue</p>
                                </div>
                            </div>
                            <span class="text-xs font-medium text-neutral-500 dark:text-neutral-400 bg-neutral-100 dark:bg-secondary-700 px-2.5 py-1 rounded-lg whitespace-nowrap">{{ $photos->count() }} foto</span>
                        </div>

                        <div class="p-5 sm:p-6">
                            @if($photos->count() > 0)
                                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3">
                                    @foreach($photos as $photo)
                                        <div class="group relative rounded-xl overflow-hidden bg-neutral-100 dark:bg-secondary-700 border border-neutral-200 dark:border-secondary-600 aspect-square shadow-sm">
                                            <img src="{{ $photo->url }}" alt="{{ $photo->caption ?? 'Momen Acara' }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">

                                            {{-- Overlay --}}
                                            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity p-2.5 flex flex-col justify-end text-white">
                                                <p class="text-[11px] font-bold truncate">{{ $photo->guest_name ?: 'Tamu Undangan' }}</p>
                                                @if($photo->caption)
                                                    <p class="text-[10px] text-white/80 line-clamp-1">{{ $photo->caption }}</p>
                                                @endif
                                            </div>

                                            {{-- Delete Button --}}
                                            <form action="{{ route('dashboard.invitations.qr-gallery.photo.destroy', [$invitation, $photo]) }}" method="POST"
                                                class="absolute top-1.5 right-1.5 opacity-0 group-hover:opacity-100 transition-opacity"
                                                onsubmit="return confirm('Hapus foto ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="w-6 h-6 rounded-full bg-red-600/90 hover:bg-red-700 text-white flex items-center justify-center text-xs shadow-lg">
                                                    <i class="fa-solid fa-xmark"></i>
                                                </button>
                                            </form>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-10 px-4">
                                    <div class="w-12 h-12 mx-auto rounded-2xl bg-purple-100 dark:bg-purple-900/30 flex items-center justify-center text-purple-500 mb-3">
                                        <i class="fa-solid fa-camera text-xl"></i>
                                    </div>
                                    <p class="text-sm font-medium text-neutral-500 dark:text-neutral-400">Belum ada foto yang diunggah oleh tamu.</p>
                                    <p class="text-xs text-neutral-400 dark:text-neutral-500 mt-1">Foto yang diunggah tamu melalui QR Galeri akan muncul di sini.</p>
                                </div>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>

    <script>
        function copyGalleryUrl() {
            const input = document.getElementById('gallery-url-input');
            const btn = document.getElementById('copy-gallery-btn');
            navigator.clipboard.writeText(input.value).then(() => {
                btn.textContent = 'Tersalin!';
                btn.classList.add('bg-primary', 'text-white');
                setTimeout(() => {
                    btn.textContent = 'Salin';
                    btn.classList.remove('bg-primary', 'text-white');
                }, 2000);
            });
        }
    </script>
</x-app-layout>
