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
                    <span class="text-neutral-600 dark:text-neutral-400 font-medium">QR Maps & Petunjuk Arah</span>
                </nav>

                <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
                    <div class="flex items-start gap-3 min-w-0">
                        <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-primary to-primary-600 flex items-center justify-center text-white shadow-lg shadow-primary/20 shrink-0">
                            <i class="fa-solid fa-map-location-dot text-lg"></i>
                        </div>
                        <div class="min-w-0">
                            <h1 class="font-heading text-2xl sm:text-3xl font-bold text-secondary-800 dark:text-neutral-50 leading-tight">
                                QR Maps & Petunjuk Arah
                            </h1>
                            <p class="text-sm text-neutral-500 dark:text-neutral-400 mt-1">
                                Konfigurasi petunjuk lokasi dan navigasi untuk undangan <strong class="text-secondary-700 dark:text-neutral-300">"{{ $invitation->title }}"</strong>
                            </p>
                        </div>
                    </div>
                    <a href="{{ route('dashboard.invitations.qr-codes', $invitation) }}"
                        class="inline-flex items-center gap-1.5 px-3.5 py-2 text-xs font-semibold text-secondary-700 dark:text-neutral-300 border border-neutral-300/80 dark:border-secondary-600 rounded-xl hover:bg-white dark:hover:bg-secondary-700 transition-all bg-white/70 dark:bg-secondary-800/50 backdrop-blur-sm shrink-0">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                        Kembali ke Pusat QR Code
                    </a>
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
                        <h2 class="font-semibold text-sm text-secondary-800 dark:text-neutral-100">QR Code Maps</h2>
                    </div>
                    <p class="text-xs text-neutral-500 dark:text-neutral-400 mb-5 ml-10">QR ini mengarahkan tamu ke halaman navigasi lokasi acara.</p>

                    <div class="flex flex-col items-center">
                        <div class="bg-white p-4 rounded-2xl shadow-sm border border-neutral-200 dark:border-neutral-600 inline-block">
                            <div class="w-52 h-52 sm:w-56 sm:h-56 flex items-center justify-center">
                                <img src="{{ $qrMapsCodeData }}" alt="QR Code Maps" class="w-full h-full">
                            </div>
                        </div>
                    </div>

                    <div class="mt-5 w-full space-y-2.5">
                        <div class="bg-neutral-50 dark:bg-secondary-700/50 border border-neutral-200 dark:border-secondary-600 rounded-xl p-3">
                            <p class="text-xs text-neutral-500 dark:text-neutral-400 mb-1">Tautan halaman Maps:</p>
                            <div class="flex items-center gap-2">
                                <input type="text" id="maps-url-input" value="{{ $qrMapsUrl }}" readonly
                                    class="flex-1 text-xs font-mono bg-white dark:bg-secondary-800 border border-neutral-200 dark:border-secondary-600 rounded-lg px-2 py-1.5 text-neutral-700 dark:text-neutral-300 focus:ring-0 focus:border-primary-400">
                                <button type="button" onclick="copyMapsUrl()" id="copy-maps-btn"
                                    class="flex-shrink-0 px-3 py-1.5 bg-primary-50 dark:bg-primary-900/50 text-primary-700 dark:text-primary-300 rounded-lg text-xs font-semibold hover:bg-primary-100 dark:hover:bg-primary-900/70 transition">
                                    Salin
                                </button>
                            </div>
                        </div>

                        <a href="{{ $qrMapsCodeData }}" download="qr-maps-{{ $invitation->slug }}.png"
                            class="inline-flex items-center justify-center gap-2 w-full px-4 py-2.5 bg-gradient-to-r from-primary to-primary-600 text-white rounded-xl text-sm font-semibold shadow-sm shadow-primary/20 hover:shadow-md hover:-translate-y-0.5 active:translate-y-0 transition-all">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                            Download QR Code
                        </a>

                        <a href="{{ $qrMapsUrl }}" target="_blank"
                            class="inline-flex items-center justify-center gap-2 w-full px-4 py-2 text-primary-700 dark:text-primary-300 bg-primary-50 dark:bg-primary-900/30 rounded-xl text-xs font-semibold hover:bg-primary-100 transition border border-primary-200/60 dark:border-primary-800/40">
                            Lihat Halaman Publik →
                        </a>
                    </div>
                </div>

                {{-- Configuration Form Card --}}
                <div class="lg:col-span-3 bg-white dark:bg-secondary-800 rounded-2xl border border-neutral-200/80 dark:border-secondary-700/60 overflow-hidden">
                    <div class="px-5 sm:px-6 py-4 border-b border-neutral-100 dark:border-secondary-700/60 flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-lg bg-primary-50 dark:bg-primary-900/30 flex items-center justify-center text-primary dark:text-primary-400 flex-shrink-0">
                            <i class="fa-solid fa-gear text-sm"></i>
                        </div>
                        <div>
                            <h2 class="font-semibold text-sm text-secondary-800 dark:text-neutral-100">Konfigurasi Data Lokasi</h2>
                            <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-0.5">Data ini ditampilkan saat tamu men-scan QR Maps</p>
                        </div>
                    </div>

                    <form action="{{ route('dashboard.invitations.qr-maps.update', $invitation) }}" method="POST" class="p-5 sm:p-6 space-y-5">
                        @csrf
                        @method('PATCH')

                        @php
                            $firstEvent = $invitation->events->first();
                        @endphp

                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Nama Tempat / Lokasi Venue</label>
                                <input type="text" name="venue_name" value="{{ old('venue_name', $invitation->venue_name ?? $firstEvent?->place_name) }}"
                                    class="mt-1 block w-full rounded-xl border-neutral-300 dark:border-neutral-600 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm dark:bg-secondary-700 dark:text-neutral-200"
                                    placeholder="Nama gedung atau lokasi">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Alamat Lengkap</label>
                                <textarea name="venue_address" rows="2"
                                    class="mt-1 block w-full rounded-xl border-neutral-300 dark:border-neutral-600 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm dark:bg-secondary-700 dark:text-neutral-200"
                                    placeholder="Alamat lengkap lokasi">{{ old('venue_address', $invitation->venue_address ?? $firstEvent?->place_address) }}</textarea>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Link Google Maps</label>
                                <input type="url" name="venue_maps_url" value="{{ old('venue_maps_url', $invitation->venue_maps_url ?? $firstEvent?->google_maps_url) }}"
                                    class="mt-1 block w-full rounded-xl border-neutral-300 dark:border-neutral-600 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm dark:bg-secondary-700 dark:text-neutral-200"
                                    placeholder="https://goo.gl/maps/...">
                                <p class="mt-1 text-xs text-neutral-400 dark:text-neutral-500">Tautan Google Maps yang akan dibuka saat tamu menekan tombol navigasi.</p>
                            </div>

                            <div class="p-4 bg-primary-50/60 dark:bg-primary-900/15 rounded-xl border border-primary-100 dark:border-primary-800/40 space-y-2">
                                <label class="block text-sm font-semibold text-primary-800 dark:text-primary-300">
                                    <i class="fa-solid fa-square-parking text-primary me-1"></i> Petunjuk Titik Parkir & Akses Masuk
                                </label>
                                <p class="text-xs text-neutral-500 dark:text-neutral-400">
                                    Instruksi khusus yang ditampilkan saat tamu men-scan QR Maps.
                                </p>
                                <textarea name="venue_parking_info" rows="3"
                                    class="mt-1 block w-full rounded-xl border-neutral-300 dark:border-neutral-600 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm dark:bg-secondary-800 dark:text-neutral-200"
                                    placeholder="Misal: Parkir mobil VIP di Area Basement 1. Pintu masuk utama melalui Lobby Selatan.">{{ old('venue_parking_info', $invitation->venue_parking_info) }}</textarea>
                            </div>
                        </div>

                        <button type="submit"
                            class="inline-flex items-center justify-center gap-2 w-full px-4 py-2.5 bg-gradient-to-r from-primary to-primary-600 text-white rounded-xl text-sm font-semibold shadow-sm shadow-primary/20 hover:shadow-md hover:-translate-y-0.5 active:translate-y-0 transition-all">
                            <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan
                        </button>
                    </form>
                </div>

            </div>
        </div>

    </div>

    <script>
        function copyMapsUrl() {
            const input = document.getElementById('maps-url-input');
            const btn = document.getElementById('copy-maps-btn');
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
