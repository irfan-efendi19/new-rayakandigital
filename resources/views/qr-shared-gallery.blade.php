<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Galeri Foto Bersama — {{ $invitation->couple_name }}</title>

    <x-meta title="Galeri Foto Bersama {{ $invitation->couple_name }}"
        description="Unggah dan bagikan foto/video momen keseruan acara {{ $invitation->couple_name }} di galeri bersama." />

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link
        href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800|playfair-display:400,500,600,700&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />

    @vite(['resources/css/app.css'])

    <script>
        if (localStorage.getItem('dark-mode') === 'true' || (!('dark-mode' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    <style>
        body {
            background-image:
                radial-gradient(ellipse at 20% 10%, rgba(255, 122, 0, 0.10) 0%, transparent 50%),
                radial-gradient(ellipse at 80% 90%, rgba(214, 101, 0, 0.08) 0%, transparent 50%),
                radial-gradient(ellipse at 50% 50%, rgba(255, 122, 0, 0.05) 0%, transparent 70%);
            background-attachment: fixed;
        }

        @keyframes float-in {
            from { opacity: 0; transform: translateY(20px) scale(0.96); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }

        .animate-float-in { animation: float-in 0.5s cubic-bezier(0.22, 0.61, 0.36, 1) both; }

        .soft-hero-gradient {
            background-image: linear-gradient(
                135deg,
                #fff4eb 0%,
                #ffe4cc 30%,
                #ffd0a3 55%,
                #ffb56b 100%
            );
        }
    </style>
</head>

<body class="font-sans antialiased bg-neutral-50 dark:bg-secondary-900 text-secondary-800 dark:text-neutral-200 min-h-screen p-4 sm:p-6">

    <!-- Dark Mode Toggle -->
    <button type="button" id="theme-toggle"
        class="fixed top-4 right-4 z-50 w-11 h-11 rounded-full bg-white/80 dark:bg-secondary-800/80 backdrop-blur-md shadow-lg border border-neutral-200/60 dark:border-secondary-700/60 flex items-center justify-center text-neutral-600 dark:text-neutral-300 hover:text-primary transition-all">
        <i class="fa-solid fa-sun dark:hidden text-base"></i>
        <i class="fa-solid fa-moon hidden dark:block text-base"></i>
    </button>

    <div class="w-full max-w-2xl mx-auto animate-float-in space-y-6">
        
        <!-- Main Card Container -->
        <div class="bg-white/90 dark:bg-secondary-800/90 backdrop-blur-xl rounded-3xl border border-neutral-200/80 dark:border-secondary-700/80 shadow-2xl shadow-primary/10 overflow-hidden">
            
            <!-- Header Soft Gradient Banner -->
            <div class="soft-hero-gradient text-secondary-800 p-6 sm:p-8 text-center relative overflow-hidden">
                <div class="absolute -right-6 -top-6 w-32 h-32 bg-primary-500/10 rounded-full blur-2xl pointer-events-none"></div>
                <div class="absolute -left-6 -bottom-6 w-32 h-32 bg-primary-500/10 rounded-full blur-2xl pointer-events-none"></div>

                <div class="relative z-10">
                    <div class="w-14 h-14 mx-auto rounded-2xl bg-white/70 backdrop-blur-md border border-primary-200 flex items-center justify-center text-primary-600 mb-3 shadow-lg">
                        <i class="fa-solid fa-camera-retro text-2xl"></i>
                    </div>

                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold bg-primary-100/80 text-primary-700 uppercase tracking-wider mb-2">
                        <i class="fa-solid fa-images text-xs"></i> Galeri Momen Acara
                    </span>

                    <h1 class="font-heading text-2xl sm:text-3xl font-bold tracking-tight text-secondary-800">
                        {{ $invitation->couple_name }}
                    </h1>
                    <p class="text-xs sm:text-sm text-secondary-700/70 mt-1">
                        Album Foto & Momen Bersama Tamu Undangan
                    </p>
                </div>
            </div>

            <!-- Content Area -->
            <div class="p-6 sm:p-8 space-y-6">

                <!-- Official Photographer Cloud Drive Album Card -->
                <div class="bg-white/70 dark:bg-secondary-800/80 backdrop-blur-xl rounded-3xl p-6 shadow-xl shadow-primary/10 border border-primary-200/70 dark:border-primary-700/40 relative overflow-hidden space-y-4">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div class="flex items-center gap-3.5">
                            <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-primary-400 to-primary-600 text-white flex items-center justify-center shrink-0 shadow-lg shadow-primary-500/20">
                                <i class="fa-solid fa-camera-retro text-xl"></i>
                            </div>
                            <div>
                                <span class="inline-flex items-center gap-1 text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded bg-primary-50 dark:bg-primary-500/10 text-primary-700 dark:text-primary-300 border border-primary-200 dark:border-primary-600/40">
                                    <i class="fa-solid fa-gem text-amber-400"></i> Dokumentasi Official
                                </span>
                                <h3 class="font-bold text-base text-secondary-800 dark:text-white mt-0.5">Drive Foto Official Fotografer</h3>
                                <p class="text-xs text-neutral-500 dark:text-primary-200/70">Album foto & video kualitas HD hasil dokumentasi tim fotografer acara</p>
                            </div>
                        </div>

                        @if($invitation->photographer_drive_url)
                            <a href="{{ $invitation->photographer_drive_url }}" target="_blank" rel="noopener noreferrer"
                                class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-5 py-3 bg-gradient-to-r from-primary-500 to-primary-600 hover:from-primary-600 hover:to-primary-700 active:scale-[0.98] text-white rounded-2xl text-xs font-bold shadow-lg shadow-primary-500/20 transition-all shrink-0">
                                <i class="fa-brands fa-google-drive text-base"></i> Buka Drive Fotografer →
                            </a>
                        @endif
                    </div>

                    @if($invitation->photographer_drive_url)
                        <div class="bg-white/70 dark:bg-black/25 backdrop-blur-md rounded-2xl p-3.5 border border-neutral-200 dark:border-white/10 flex flex-col sm:flex-row items-center justify-between gap-2">
                            <div class="flex items-center gap-2 min-w-0 w-full sm:w-auto">
                                <i class="fa-solid fa-link text-xs text-primary-500 dark:text-primary-300 shrink-0"></i>
                                <span class="text-xs text-primary-700 dark:text-primary-100 font-mono truncate select-all">{{ $invitation->photographer_drive_url }}</span>
                            </div>
                            <button type="button" onclick="navigator.clipboard.writeText('{{ $invitation->photographer_drive_url }}'); alert('Link Drive Fotografer berhasil disalin!');"
                                class="w-full sm:w-auto px-3 py-1.5 bg-primary-500/10 hover:bg-primary-500/20 text-primary-700 dark:text-primary-200 rounded-xl text-xs font-semibold transition shrink-0 whitespace-nowrap">
                                <i class="fa-regular fa-copy me-1"></i> Salin Link
                            </button>
                        </div>
                    @else
                        <div class="bg-neutral-50 dark:bg-white/5 rounded-2xl p-4 border border-dashed border-neutral-200 dark:border-white/10 text-center">
                            <p class="text-xs text-neutral-500 dark:text-primary-200/70">
                                <i class="fa-solid fa-clock text-amber-400 me-1"></i> Link album dokumentasi fotografer akan diunggah oleh pengantin setelah acara selesai.
                            </p>
                        </div>
                    @endif
                </div>
                <!-- Upload Form Box -->
                <div class="bg-neutral-50 dark:bg-secondary-700/50 rounded-2xl p-5 border border-neutral-200/70 dark:border-secondary-600/50 space-y-4">
                    <div class="flex items-center gap-2 text-primary-700 dark:text-primary-400 font-bold text-sm">
                        <i class="fa-solid fa-cloud-arrow-up text-base"></i> Unggah Foto / Video Keseruan Acara
                    </div>

                    <form id="shared-upload-form" action="{{ route('qr-shared-gallery.upload', $invitation->slug) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf

                        <!-- Dropzone Area -->
                        <div id="dropzone" class="border-2 border-dashed border-primary-300 dark:border-primary-700/60 rounded-xl p-6 text-center bg-white dark:bg-secondary-800/80 hover:bg-primary-50/50 dark:hover:bg-primary-900/10 cursor-pointer transition-all">
                            <input type="file" id="photo-input" name="photo" accept="image/*" class="hidden">

                            <div id="dropzone-empty" class="space-y-2">
                                <div class="w-12 h-12 mx-auto rounded-full bg-primary-100 dark:bg-primary-900/40 text-primary-600 dark:text-primary-400 flex items-center justify-center text-xl">
                                    <i class="fa-solid fa-file-image"></i>
                                </div>
                                <p class="text-xs font-bold text-secondary-800 dark:text-neutral-100">Ketuk di sini untuk memilih foto</p>
                                <p class="text-[11px] text-neutral-400">Format: JPG, PNG, WEBP (Maks 10MB)</p>
                            </div>

                            <div id="dropzone-preview" class="hidden space-y-2">
                                <img id="preview-img" src="" class="max-h-44 mx-auto rounded-lg shadow border border-neutral-200 dark:border-secondary-700 object-cover">
                                <p id="file-name" class="text-xs text-primary-600 dark:text-primary-400 font-medium truncate"></p>
                            </div>
                        </div>

                        <!-- Form Inputs -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-semibold text-neutral-600 dark:text-neutral-300 mb-1">Nama Tamu (Opsional)</label>
                                <input type="text" name="guest_name" placeholder="Misal: Andi & Keluarga"
                                    class="w-full text-xs rounded-xl border-neutral-300 dark:border-secondary-600 bg-white dark:bg-secondary-800 text-secondary-800 dark:text-neutral-100 focus:border-primary focus:ring-primary">
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-neutral-600 dark:text-neutral-300 mb-1">Pesan / Caption (Opsional)</label>
                                <input type="text" name="caption" placeholder="Misal: Selamat ya! SAMAWA"
                                    class="w-full text-xs rounded-xl border-neutral-300 dark:border-secondary-600 bg-white dark:bg-secondary-800 text-secondary-800 dark:text-neutral-100 focus:border-primary focus:ring-primary">
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" id="submit-btn" disabled
                            class="w-full py-3 px-4 bg-gradient-to-r from-primary-500 to-primary-600 hover:from-primary-600 hover:to-primary-700 disabled:opacity-50 disabled:cursor-not-allowed text-white font-bold text-xs rounded-xl shadow-lg shadow-primary-500/20 transition-all flex items-center justify-center gap-2">
                            <i class="fa-solid fa-paper-plane"></i> Unggah Foto Sekarang
                        </button>
                    </form>
                </div>

                <!-- Live Photos Feed Grid -->
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <p class="text-xs font-bold uppercase tracking-wider text-neutral-400 dark:text-neutral-500">
                            <i class="fa-solid fa-photo-film me-1"></i> Galeri Momen Yang Diunggah ({{ $photos->count() }})
                        </p>
                    </div>

                    @if($photos->count() > 0)
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                            @foreach($photos as $photo)
                                <div class="group relative rounded-xl overflow-hidden bg-neutral-100 dark:bg-secondary-700 border border-neutral-200 dark:border-secondary-600 aspect-square shadow-sm">
                                    <img src="{{ $photo->url }}" alt="{{ $photo->caption ?? 'Momen Acara' }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity p-2.5 flex flex-col justify-end text-white">
                                        <p class="text-[11px] font-bold truncate">{{ $photo->guest_name ?: 'Tamu Undangan' }}</p>
                                        @if($photo->caption)
                                            <p class="text-[10px] text-white/80 line-clamp-1">{{ $photo->caption }}</p>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8 px-4 bg-neutral-50 dark:bg-secondary-700/30 rounded-2xl border border-dashed border-neutral-200 dark:border-secondary-700">
                            <div class="w-10 h-10 mx-auto rounded-full bg-primary-100 dark:bg-primary-900/30 text-primary-500 flex items-center justify-center text-base mb-2">
                                <i class="fa-solid fa-camera"></i>
                            </div>
                            <p class="text-xs font-medium text-neutral-500 dark:text-neutral-400">Belum ada foto yang diunggah.</p>
                            <p class="text-[11px] text-neutral-400 mt-0.5">Jadilah yang pertama membagikan momen keseruan acara!</p>
                        </div>
                    @endif
                </div>

                <!-- Back Link -->
                <div class="pt-2 text-center">
                    <a href="{{ route('invitation.show', $invitation->slug) }}"
                        class="inline-flex items-center gap-2 text-xs font-semibold text-neutral-500 dark:text-neutral-400 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">
                        <i class="fa-solid fa-arrow-left"></i> Buka Website Undangan Utama
                    </a>
                </div>

            </div>

            <!-- Footer -->
            <div class="px-6 py-4 bg-neutral-100/60 dark:bg-secondary-900/60 border-t border-neutral-200/60 dark:border-secondary-700/60 text-center">
                <p class="text-[11px] text-neutral-400 dark:text-neutral-500">
                    &copy; {{ date('Y') }} Rayakan Digital · Galeri Foto Bersama
                </p>
            </div>

        </div>
    </div>

    <!-- Toast Notification -->
    <div id="toast" class="fixed bottom-5 right-5 z-50 transform translate-y-20 opacity-0 transition-all duration-300 pointer-events-none">
        <div class="bg-emerald-600 text-white px-4 py-3 rounded-2xl shadow-xl flex items-center gap-3 text-xs font-semibold">
            <i class="fa-solid fa-circle-check text-lg"></i>
            <span id="toast-msg">Foto berhasil diunggah!</span>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const dropzone = document.getElementById('dropzone');
            const photoInput = document.getElementById('photo-input');
            const dropzoneEmpty = document.getElementById('dropzone-empty');
            const dropzonePreview = document.getElementById('dropzone-preview');
            const previewImg = document.getElementById('preview-img');
            const fileName = document.getElementById('file-name');
            const submitBtn = document.getElementById('submit-btn');

            dropzone.addEventListener('click', () => photoInput.click());

            photoInput.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    const file = this.files[0];
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        previewImg.src = e.target.result;
                        fileName.textContent = file.name;
                        dropzoneEmpty.classList.add('hidden');
                        dropzonePreview.classList.remove('hidden');
                        submitBtn.disabled = false;
                    };

                    reader.readAsDataURL(file);
                }
            });

            // Theme toggle
            document.getElementById('theme-toggle').addEventListener('click', function() {
                const isDark = document.documentElement.classList.toggle('dark');
                localStorage.setItem('dark-mode', isDark);
            });
        });
    </script>
</body>
</html>
