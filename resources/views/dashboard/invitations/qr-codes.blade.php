<x-app-layout>
    <div class="min-h-screen">

        {{-- ─── HERO ─── --}}
        <div class="hero-mesh grain-overlay border-b border-neutral-200/60 dark:border-secondary-700/40">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-7 sm:py-8">

                {{-- Breadcrumb --}}
                <nav class="flex items-center gap-1.5 text-xs text-neutral-400 dark:text-neutral-500 mb-4">
                    <a href="{{ route('dashboard') }}"
                        class="hover:text-primary dark:hover:text-primary-400 transition-colors">Dashboard</a>
                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                    </svg>
                    <a href="{{ route('dashboard.invitations.show', $invitation) }}"
                        class="hover:text-primary dark:hover:text-primary-400 transition-colors truncate max-w-[150px]">{{ $invitation->title }}</a>
                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                    </svg>
                    <span class="text-neutral-600 dark:text-neutral-400 font-medium">Pusat QR Code</span>
                </nav>

                <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
                    <div class="flex items-start gap-3 min-w-0">
                        <div
                            class="w-11 h-11 rounded-2xl bg-gradient-to-br from-primary to-primary-600 flex items-center justify-center text-white shadow-lg shadow-primary/20 shrink-0">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <h1
                                class="font-heading text-2xl sm:text-3xl font-bold text-secondary-800 dark:text-neutral-50 leading-tight truncate">
                                Pusat QR Code
                            </h1>
                            <p class="text-sm text-neutral-500 dark:text-neutral-400 mt-1">
                                Unduh & kelola seluruh QR code untuk undangan <strong
                                    class="text-secondary-700 dark:text-neutral-300">"{{ $invitation->title }}"</strong>
                            </p>
                        </div>
                    </div>
                    <a href="{{ route('dashboard.invitations.show', $invitation) }}"
                        class="inline-flex items-center gap-1.5 px-3.5 py-2 text-xs font-semibold text-secondary-700 dark:text-neutral-300 border border-neutral-300/80 dark:border-secondary-600 rounded-xl hover:bg-white dark:hover:bg-secondary-700 transition-all bg-white/70 dark:bg-secondary-800/50 backdrop-blur-sm shrink-0">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Kembali ke Detail Undangan
                    </a>
                </div>
            </div>
        </div>

        {{-- ─── MAIN CONTENT ─── --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-7 sm:py-8 space-y-8">

            {{-- ── BANNER PETUNJUK ── --}}
            <div
                class="bg-primary-50/70 dark:bg-primary-900/20 border border-primary-200/70 dark:border-primary-800/40 rounded-2xl p-4 sm:p-5">
                <div class="flex flex-col sm:flex-row sm:items-center gap-3 sm:gap-4">
                    <div
                        class="w-10 h-10 rounded-xl bg-white dark:bg-secondary-800 shadow-sm border border-primary-200 dark:border-primary-800 flex items-center justify-center text-primary shrink-0">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="text-sm font-semibold text-primary-700 dark:text-primary-300">Cara pakai: unduh QR
                            code lalu taruh di tempat yang tepat</p>
                        <p class="text-xs text-primary-600/80 dark:text-primary-400/80 mt-0.5 leading-relaxed">
                            <strong class="font-semibold">QR Untuk Tamu</strong> (Undangan, Kado, Ucapan) → cetak /
                            bagikan agar tamu bisa scan sendiri.
                            <strong class="font-semibold">QR Untuk Panitia</strong> (RSVP Kartu, Scanner) → digunakan
                            kamu & tim saat acara berlangsung.
                        </p>
                    </div>
                </div>
            </div>

            {{-- ── SECTION 1: QR CODE UNTUK TAMU ── --}}
            <div class="space-y-4">
                <div class="flex items-center gap-2">
                    <span
                        class="w-7 h-7 rounded-lg bg-primary-100 dark:bg-primary-900/50 text-primary-700 dark:text-primary-300 flex items-center justify-center font-bold text-sm shrink-0">1</span>
                    <div>
                        <h2
                            class="font-heading text-lg font-bold text-secondary-800 dark:text-neutral-100 flex items-center gap-2">
                            QR Code Untuk Tamu
                        </h2>
                        <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-0.5">Masing-masing QR disiapkan
                            khusus untuk satu fungsi agar tidak membingungkan tamu saat di-scan.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                    {{-- Card 1: QR Website Undangan --}}
                    <div
                        class="bg-white dark:bg-secondary-800 rounded-2xl border border-neutral-200/80 dark:border-secondary-700/60 p-6 flex flex-col items-center text-center shadow-sm hover:shadow-md transition-all">
                        <div
                            class="w-12 h-12 rounded-2xl bg-primary-100 dark:bg-primary-900/40 text-primary-700 dark:text-primary-300 flex items-center justify-center mb-3">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 002-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <h3 class="font-bold text-base text-secondary-800 dark:text-neutral-100">QR Website Undangan
                        </h3>
                        <span
                            class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-primary-50 dark:bg-primary-900/30 text-primary-700 dark:text-primary-300 text-[10px] font-semibold mt-1.5 mb-2 border border-primary-100 dark:border-primary-800/50">Untuk
                            tamu · fitur undangan</span>
                        <p class="text-xs text-neutral-500 dark:text-neutral-400 mb-3 min-h-[36px]">Tamu scan → langsung
                            membuka website / landing page undangan. Cocok dicetak di kartu & dibagikan lewat WhatsApp.
                        </p>

                        <div
                            class="bg-white p-3 rounded-2xl shadow-sm border border-neutral-200 dark:border-neutral-600 mb-5">
                            <img src="{{ $qrWebsiteCodeData }}" alt="QR Website Undangan"
                                class="w-36 h-36 object-contain">
                        </div>

                        <div class="flex flex-col gap-2 w-full mt-auto">
                            <a href="{{ $qrWebsiteCodeData }}" download="qr-undangan-{{ $invitation->slug }}.png"
                                class="flex-1 text-center px-3 py-2 text-xs font-semibold text-white bg-gradient-to-r from-primary to-primary-600 rounded-xl hover:shadow transition">
                                <svg class="w-3.5 h-3.5 inline-block mr-1.5 -mt-0.5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                                Unduh QR Code
                            </a>
                            <a href="{{ $qrWebsiteUrl }}" target="_blank"
                                class="flex-1 text-center px-3 py-2 text-xs font-semibold text-primary-700 dark:text-primary-300 bg-primary-50 dark:bg-primary-900/30 rounded-xl hover:bg-primary-100 transition border border-primary-200/60 dark:border-primary-800/40">
                                Cek halaman tujuan ↗
                            </a>
                        </div>
                    </div>

                    {{-- Card 2: QR Kado Digital & QRIS --}}
                    <div
                        class="bg-white dark:bg-secondary-800 rounded-2xl border border-neutral-200/80 dark:border-secondary-700/60 p-6 flex flex-col items-center text-center shadow-sm hover:shadow-md transition-all">
                        <div
                            class="w-12 h-12 rounded-2xl bg-primary-100 dark:bg-primary-900/40 text-primary-700 dark:text-primary-300 flex items-center justify-center mb-3">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5a2 2 0 10-2 2h2zm0 13C10.832 21 2 20 2 12c0-4.5 3.5-8 10-8s10 3.5 10 8c0 8-8.832 9-10 9z" />
                            </svg>
                        </div>
                        <h3 class="font-bold text-base text-secondary-800 dark:text-neutral-100">QR Kado Digital & QRIS
                        </h3>
                        <span
                            class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-primary-50 dark:bg-primary-900/30 text-primary-700 dark:text-primary-300 text-[10px] font-semibold mt-1.5 mb-2 border border-primary-100 dark:border-primary-800/50">Untuk
                            tamu · fitur kado</span>
                        <p class="text-xs text-neutral-500 dark:text-neutral-400 mb-3 min-h-[36px]">Tamu scan → melihat
                            nomor rekening bank, e-wallet, & QRIS. Letakkan di bagian kado. Tersedia jika fitur kado
                            diaktifkan.</p>

                        <div
                            class="bg-white p-3 rounded-2xl shadow-sm border border-neutral-200 dark:border-neutral-600 mb-5">
                            <img src="{{ $qrKadoCodeData }}" alt="QR Kado Digital" class="w-36 h-36 object-contain">
                        </div>

                        <div class="flex flex-col gap-2 w-full mt-auto">
                            <a href="{{ $qrKadoCodeData }}" download="qr-kado-{{ $invitation->slug }}.png"
                                class="flex-1 text-center px-3 py-2 text-xs font-semibold text-white bg-gradient-to-r from-primary to-primary-600 rounded-xl hover:shadow transition">
                                <svg class="w-3.5 h-3.5 inline-block mr-1.5 -mt-0.5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                                Unduh QR Code
                            </a>
                            <a href="{{ $qrKadoUrl }}" target="_blank"
                                class="flex-1 text-center px-3 py-2 text-xs font-semibold text-primary-700 dark:text-primary-300 bg-primary-50 dark:bg-primary-900/30 rounded-xl hover:bg-primary-100 transition border border-primary-200/60 dark:border-primary-800/40">
                                Cek halaman tujuan ↗
                            </a>
                        </div>
                    </div>

                    {{-- Card 3: QR Kirim Ucapan & Doa --}}
                    <div
                        class="bg-white dark:bg-secondary-800 rounded-2xl border border-neutral-200/80 dark:border-secondary-700/60 p-6 flex flex-col items-center text-center shadow-sm hover:shadow-md transition-all">
                        <div
                            class="w-12 h-12 rounded-2xl bg-primary-100 dark:bg-primary-900/40 text-primary-700 dark:text-primary-300 flex items-center justify-center mb-3">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                            </svg>
                        </div>
                        <h3 class="font-bold text-base text-secondary-800 dark:text-neutral-100">QR Kirim Ucapan & Doa
                        </h3>
                        <span
                            class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-primary-50 dark:bg-primary-900/30 text-primary-700 dark:text-primary-300 text-[10px] font-semibold mt-1.5 mb-2 border border-primary-100 dark:border-primary-800/50">Untuk
                            tamu · fitur ucapan</span>
                        <p class="text-xs text-neutral-500 dark:text-neutral-400 mb-3 min-h-[36px]">Tamu scan → mengirim
                            pesan ucapan & doa restu secara real-time ke buku tamu kamu.</p>

                        <div
                            class="bg-white p-3 rounded-2xl shadow-sm border border-neutral-200 dark:border-neutral-600 mb-5">
                            <img src="{{ $qrUcapanCodeData }}" alt="QR Ucapan & Doa" class="w-36 h-36 object-contain">
                        </div>

                        <div class="flex flex-col gap-2 w-full mt-auto">
                            <a href="{{ $qrUcapanCodeData }}" download="qr-ucapan-{{ $invitation->slug }}.png"
                                class="flex-1 text-center px-3 py-2 text-xs font-semibold text-white bg-gradient-to-r from-primary to-primary-600 rounded-xl hover:shadow transition">
                                <svg class="w-3.5 h-3.5 inline-block mr-1.5 -mt-0.5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                                Unduh QR Code
                            </a>
                            <a href="{{ $qrUcapanUrl }}" target="_blank"
                                class="flex-1 text-center px-3 py-2 text-xs font-semibold text-primary-700 dark:text-primary-300 bg-primary-50 dark:bg-primary-900/30 rounded-xl hover:bg-primary-100 transition border border-primary-200/60 dark:border-primary-800/40">
                                Cek halaman tujuan ↗
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ── SECTION 2: QR CODE UNTUK PANITIA (KARTU CETAK & PRESENSI) ── --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4">
                <div class="md:col-span-2 -mb-2">
                    <div class="flex items-center gap-2">
                        <span
                            class="w-7 h-7 rounded-lg bg-emerald-100 dark:bg-emerald-900/40 text-emerald-600 dark:text-emerald-400 flex items-center justify-center font-bold text-sm shrink-0">2</span>
                        <div>
                            <h2 class="font-heading text-lg font-bold text-secondary-800 dark:text-neutral-100">QR Code
                                Untuk Panitia & Alat Acara</h2>
                            <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-0.5">Digunakan oleh kamu & tim
                                saat hari-H: kartu fisik RSVP dan pemindai tiket tamu.</p>
                        </div>
                    </div>
                </div>

                {{-- QR RSVP Universal (Kartu Cetak Fisik) --}}
                <div
                    class="bg-white dark:bg-secondary-800 rounded-2xl border border-neutral-200/80 dark:border-secondary-700/60 p-6 flex flex-col sm:flex-row items-center gap-5">
                    @if($qrRsvpCodeData)
                        <div
                            class="bg-white p-2.5 rounded-2xl shadow-sm border border-neutral-200 dark:border-neutral-600 shrink-0">
                            <img src="{{ $qrRsvpCodeData }}" alt="QR RSVP Universal" class="w-32 h-32 object-contain">
                        </div>
                    @endif
                    <div class="min-w-0 flex-1 text-center sm:text-left">
                        <div class="flex flex-wrap items-center justify-center sm:justify-start gap-2 mb-1">
                            <h3 class="font-bold text-base text-secondary-800 dark:text-neutral-100">QR RSVP</h3>
                            @if(!$invitation->hasFeature('qr_rsvp_universal'))
                                <span
                                    class="inline-flex items-center px-1.5 py-0.5 rounded text-[9px] font-bold bg-amber-100 dark:bg-amber-900/50 text-amber-700 dark:text-amber-300 uppercase">Gold</span>
                            @endif
                        </div>
                        <p class="text-xs text-neutral-500 dark:text-neutral-400 mb-4">QR khusus untuk dicetak pada
                            kartu fisik / souvenir. Tamu scan → konfirmasi kehadiran (RSVP). Hasilnya bisa dilihat lewat
                            link Laporan RSVP.</p>

                        @if($invitation->hasFeature('qr_rsvp_universal'))
                            <div class="flex flex-wrap gap-2 justify-center sm:justify-start">
                                <a href="{{ $qrRsvpCodeData }}" download="qrcode-{{ $invitation->slug }}.png"
                                    class="px-3 py-1.5 text-xs font-semibold text-white bg-gradient-to-r from-primary to-primary-600 rounded-xl hover:shadow transition">
                                    Unduh QR
                                </a>
                                <a href="{{ route('dashboard.invitations.qr-rsvp', $invitation) }}"
                                    class="px-3 py-1.5 text-xs font-semibold text-primary dark:text-primary-300 bg-primary-50 dark:bg-primary-900/40 rounded-xl hover:bg-primary-100 transition">
                                    Lihat Laporan RSVP →
                                </a>
                            </div>
                        @else
                            <a href="{{ route('dashboard.checkout', ['invitation_id' => $invitation->id]) }}"
                                class="inline-flex items-center gap-1.5 text-xs font-semibold text-amber-600 dark:text-amber-400 hover:underline">
                                Upgrade Paket Gold →
                            </a>
                        @endif
                    </div>
                </div>

                {{-- QR Check-In Scanner (Penerima Tamu) --}}
                <div
                    class="bg-white dark:bg-secondary-800 rounded-2xl border p-6 flex flex-col sm:flex-row items-center gap-5
                    {{ $invitation->hasFeature('qr_checkin') ? 'border-emerald-200/60 dark:border-emerald-800/40' : 'border-amber-200/60 dark:border-amber-800/40' }}">
                    <div class="w-24 h-24 rounded-2xl
                        {{ $invitation->hasFeature('qr_checkin') ? 'bg-emerald-100 dark:bg-emerald-900/40 text-emerald-600 dark:text-emerald-400' : 'bg-amber-100 dark:bg-amber-900/40 text-amber-500 dark:text-amber-400' }}
                        flex items-center justify-center shrink-0">
                        <svg class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                        </svg>
                    </div>
                    <div class="min-w-0 flex-1 text-center sm:text-left">
                        <div class="flex flex-wrap items-center justify-center sm:justify-start gap-2 mb-1">
                            <h3 class="font-bold text-base text-secondary-800 dark:text-neutral-100">QR Scan Check-In
                            </h3>
                            @if(!$invitation->hasFeature('qr_checkin'))
                                <span
                                    class="inline-flex items-center px-1.5 py-0.5 rounded text-[9px] font-bold bg-amber-100 dark:bg-amber-900/50 text-amber-700 dark:text-amber-300 uppercase tracking-wider">Platinum</span>
                            @endif
                        </div>
                        <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-1 mb-4">Gunakan kamera HP penerima
                            tamu di lokasi acara untuk memindai tiket QR Code tamu dan mencatat kehadiran.</p>

                        @if($invitation->hasFeature('qr_checkin'))
                            <a href="{{ route('dashboard.invitations.guestbook', $invitation) }}"
                                class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-semibold shadow-sm transition">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                                </svg>
                                Buka Scanner Penerima Tamu →
                            </a>
                        @else
                            <a href="{{ route('dashboard.checkout', ['invitation_id' => $invitation->id]) }}"
                                class="inline-flex items-center gap-1.5 px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white rounded-xl text-xs font-semibold shadow-sm transition">
                                Upgrade ke Platinum →
                            </a>
                        @endif
                    </div>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>