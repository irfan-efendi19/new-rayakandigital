<x-app-layout>
    <div x-data="qrCodePage" class="min-h-screen bg-neutral-50 dark:bg-secondary-900">
        <section class="hero-mesh grain-overlay border-b border-neutral-200/70 dark:border-secondary-700/50">
            <div class="mx-auto max-w-7xl px-4 py-7 sm:px-6 sm:py-10 lg:px-8">
                <nav class="mb-5 flex min-w-0 items-center gap-1.5 text-xs text-neutral-400 dark:text-neutral-500" aria-label="Breadcrumb">
                    <a href="{{ route('dashboard') }}" class="transition-colors hover:text-primary dark:hover:text-primary-400">Dashboard</a>
                    <svg class="h-3 w-3 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                    </svg>
                    <a href="{{ route('dashboard.invitations.show', $invitation) }}" class="max-w-[130px] truncate transition-colors hover:text-primary dark:hover:text-primary-400 sm:max-w-xs">
                        {{ $invitation->title }}
                    </a>
                    <svg class="h-3 w-3 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                    </svg>
                    <span class="truncate font-semibold text-neutral-600 dark:text-neutral-300">Pusat QR Code</span>
                </nav>

                <div class="flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
                    <div class="max-w-2xl">
                        <div class="mb-3 flex flex-wrap items-center gap-2">
                            <span class="inline-flex items-center gap-1.5 rounded-full border border-primary-200 bg-white/75 px-2.5 py-1 text-[10px] font-bold uppercase tracking-[0.14em] text-primary-700 backdrop-blur dark:border-primary-800/60 dark:bg-secondary-800/70 dark:text-primary-300">
                                <span class="h-1.5 w-1.5 rounded-full bg-primary"></span>
                                Paket {{ \Illuminate\Support\Str::headline($currentTier) }}
                            </span>
                            <span class="text-xs font-medium text-neutral-500 dark:text-neutral-400">7 pilihan QR dalam satu tempat</span>
                        </div>
                        <h1 class="font-heading text-3xl font-bold leading-tight text-secondary-800 dark:text-neutral-50 sm:text-4xl">
                            Pusat QR Code
                        </h1>
                        <p class="mt-3 max-w-xl text-sm leading-6 text-neutral-600 dark:text-neutral-400 sm:text-base">
                            Siapkan semua akses digital untuk <strong class="font-semibold text-secondary-800 dark:text-neutral-200">{{ $invitation->title }}</strong>—mulai dari undangan hingga check-in hari acara.
                        </p>
                    </div>

                    <div class="flex flex-col gap-2 sm:flex-row">
                        <a href="#qr-tamu" x-on:click.prevent="scrollToSection('qr-tamu')" class="inline-flex min-h-[42px] items-center justify-center gap-2 rounded-xl bg-secondary-800 px-4 py-2.5 text-xs font-bold text-white shadow-sm transition-all duration-200 ease-out hover:-translate-y-0.5 hover:bg-secondary-700 hover:shadow-md active:translate-y-0 focus:outline-none focus:ring-2 focus:ring-secondary-700 focus:ring-offset-2 motion-reduce:transform-none motion-reduce:transition-none dark:bg-white dark:text-secondary-800 dark:hover:bg-neutral-100 dark:focus:ring-white dark:focus:ring-offset-secondary-900">
                            Jelajahi QR tamu
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </a>
                        <a href="{{ route('dashboard.invitations.show', $invitation) }}" class="inline-flex min-h-[42px] items-center justify-center gap-2 rounded-xl border border-neutral-300 bg-white/75 px-4 py-2.5 text-xs font-bold text-secondary-700 backdrop-blur transition-all duration-200 ease-out hover:-translate-y-0.5 hover:border-primary-200 hover:text-primary-700 active:translate-y-0 focus:outline-none focus:ring-2 focus:ring-primary motion-reduce:transform-none motion-reduce:transition-none dark:border-secondary-600 dark:bg-secondary-800/70 dark:text-neutral-200 dark:hover:border-primary-800 dark:hover:text-primary-300">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Detail undangan
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <main class="mx-auto max-w-7xl space-y-10 px-4 py-8 sm:px-6 sm:py-10 lg:px-8">
            <section aria-labelledby="qr-serbaguna-title">
                <div class="relative overflow-hidden rounded-3xl bg-secondary-900 shadow-xl dark:ring-1 dark:ring-secondary-700">
                    <div class="absolute -right-20 -top-24 h-64 w-64 rounded-full bg-primary/20 blur-3xl"></div>
                    <div class="absolute -bottom-24 left-1/3 h-56 w-56 rounded-full bg-amber-300/10 blur-3xl"></div>

                    <div class="relative grid gap-6 p-6 sm:p-8 lg:grid-cols-[1fr_auto] lg:items-center lg:gap-10">
                        <div class="max-w-2xl">
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="inline-flex items-center gap-1.5 rounded-full bg-primary px-2.5 py-1 text-[10px] font-extrabold uppercase tracking-[0.14em] text-white">
                                    <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4m11-2v4m-2-2h4M5 17v4m-2-2h4m9-2l2 2 4-4" />
                                    </svg>
                                    Pilihan paling praktis
                                </span>
                                <span class="text-xs font-semibold text-neutral-400">1 QR · beberapa kebutuhan</span>
                            </div>
                            <h2 id="qr-serbaguna-title" class="mt-4 font-heading text-2xl font-bold text-white sm:text-3xl">QR Serbaguna Acara</h2>
                            <p class="mt-3 text-sm leading-6 text-neutral-300 sm:text-base">
                                Cukup cetak satu QR agar tamu bisa membuka undangan, mengirim kado digital, dan menulis ucapan dari satu halaman yang rapi.
                            </p>

                            <div class="mt-5 grid gap-2 text-xs font-medium text-neutral-300 sm:grid-cols-3">
                                <div class="flex items-center gap-2 rounded-xl bg-white/5 px-3 py-2.5 ring-1 ring-white/10">
                                    <svg class="h-4 w-4 shrink-0 text-primary-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                    Buka undangan
                                </div>
                                <div class="flex items-center gap-2 rounded-xl bg-white/5 px-3 py-2.5 ring-1 ring-white/10">
                                    <svg class="h-4 w-4 shrink-0 text-primary-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                    Kirim kado
                                </div>
                                <div class="flex items-center gap-2 rounded-xl bg-white/5 px-3 py-2.5 ring-1 ring-white/10">
                                    <svg class="h-4 w-4 shrink-0 text-primary-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                    Tulis ucapan
                                </div>
                            </div>
                        </div>

                        <div x-data="qrCodeCard" data-copy-url="{{ $qrHubUrl }}" class="flex flex-col gap-3 rounded-2xl bg-white p-3.5 shadow-2xl sm:flex-row sm:items-center lg:w-[420px]">
                            <img src="{{ $qrHubCodeData }}" alt="QR Serbaguna Acara" class="mx-auto h-36 w-36 shrink-0 rounded-xl object-contain sm:mx-0">
                            <div class="grid flex-1 grid-cols-2 gap-2">
                                <a href="{{ $qrHubCodeData }}" download="qr-serbaguna-{{ $invitation->slug }}.png" class="col-span-2 inline-flex min-h-[42px] items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-primary to-primary-600 px-3 py-2.5 text-xs font-bold text-white shadow-sm transition-all duration-200 ease-out hover:-translate-y-0.5 hover:shadow-md active:translate-y-0 focus:outline-none focus:ring-2 focus:ring-primary motion-reduce:transform-none motion-reduce:transition-none">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg>
                                    Unduh PNG
                                </a>
                                <a href="{{ $qrHubUrl }}" target="_blank" rel="noopener noreferrer" class="inline-flex min-h-[40px] items-center justify-center rounded-xl bg-neutral-100 px-3 py-2 text-[11px] font-bold text-secondary-700 transition-all duration-200 ease-out hover:bg-primary-50 hover:text-primary-700 active:scale-[0.98] focus:outline-none focus:ring-2 focus:ring-primary motion-reduce:transform-none motion-reduce:transition-none">Buka halaman</a>
                                <button type="button" x-on:click="copyLink()" x-bind:class="copied ? 'border-emerald-300 bg-emerald-50 text-emerald-700' : ''" class="inline-flex min-h-[40px] items-center justify-center gap-1.5 rounded-xl border border-neutral-200 px-3 py-2 text-[11px] font-bold text-neutral-600 transition-all duration-200 ease-out hover:border-primary-200 hover:text-primary-700 active:scale-[0.98] focus:outline-none focus:ring-2 focus:ring-primary motion-reduce:transform-none motion-reduce:transition-none">
                                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" /></svg>
                                    <span class="grid min-w-[4.25rem] place-items-center" aria-hidden="true">
                                        <span class="[grid-area:1/1]" x-show="!copied"
                                            x-transition:enter="transition-opacity duration-150 ease-out motion-reduce:duration-0"
                                            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                            x-transition:leave="transition-opacity duration-100 ease-in motion-reduce:duration-0"
                                            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">Salin link</span>
                                        <span x-cloak class="[grid-area:1/1]" x-show="copied"
                                            x-transition:enter="transition-opacity duration-150 ease-out motion-reduce:duration-0"
                                            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                            x-transition:leave="transition-opacity duration-100 ease-in motion-reduce:duration-0"
                                            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">Tersalin</span>
                                    </span>
                                    <span class="sr-only" aria-live="polite" x-text="copied ? 'Link tersalin' : ''"></span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <div class="flex gap-2 overflow-x-auto pb-1 scrollbar-hide" aria-label="Navigasi bagian QR">
                <a href="#qr-tamu" x-on:click.prevent="scrollToSection('qr-tamu')" class="inline-flex shrink-0 items-center gap-2 rounded-full bg-primary-50 px-4 py-2 text-xs font-bold text-primary-700 ring-1 ring-primary-100 transition-all duration-200 ease-out hover:-translate-y-0.5 hover:bg-primary-100 active:translate-y-0 motion-reduce:transform-none motion-reduce:transition-none dark:bg-primary-900/20 dark:text-primary-300 dark:ring-primary-800/50">
                    <span class="flex h-5 w-5 items-center justify-center rounded-full bg-primary text-[10px] text-white">1</span>
                    QR untuk tamu
                </a>
                <a href="#qr-panitia" x-on:click.prevent="scrollToSection('qr-panitia')" class="inline-flex shrink-0 items-center gap-2 rounded-full bg-emerald-50 px-4 py-2 text-xs font-bold text-emerald-700 ring-1 ring-emerald-100 transition-all duration-200 ease-out hover:-translate-y-0.5 hover:bg-emerald-100 active:translate-y-0 motion-reduce:transform-none motion-reduce:transition-none dark:bg-emerald-900/20 dark:text-emerald-300 dark:ring-emerald-800/50">
                    <span class="flex h-5 w-5 items-center justify-center rounded-full bg-emerald-600 text-[10px] text-white">2</span>
                    QR untuk panitia
                </a>
            </div>

            <section id="qr-tamu" class="scroll-mt-24" aria-labelledby="qr-tamu-title">
                <div class="mb-5 flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
                    <div>
                        <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-primary-600 dark:text-primary-400">Kebutuhan tamu</p>
                        <h2 id="qr-tamu-title" class="mt-1 font-heading text-2xl font-bold text-secondary-800 dark:text-neutral-100">QR Code Untuk Tamu</h2>
                        <p class="mt-1 text-sm text-neutral-500 dark:text-neutral-400">Pilih QR sesuai titik interaksi, lalu unduh untuk dicetak atau dibagikan.</p>
                    </div>
                    <div class="flex items-center gap-2 text-xs font-medium text-neutral-500 dark:text-neutral-400">
                        <svg class="h-4 w-4 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        Uji pindai sebelum dicetak
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-5 lg:grid-cols-2">
                    <x-dashboard.qr-card title="QR Website Undangan" eyebrow="Undangan digital"
                        description="Arahkan tamu langsung ke landing page undangan. Ideal untuk kartu fisik dan pesan WhatsApp."
                        :qr-data="$qrWebsiteCodeData" download-name="qr-undangan-{{ $invitation->slug }}.png"
                        :copy-url="$qrWebsiteUrl" :detail-url="$qrWebsiteUrl" detail-label="Lihat tujuan" :new-tab="true">
                        <x-slot:icon><svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg></x-slot:icon>
                    </x-dashboard.qr-card>

                    <x-dashboard.qr-card title="QR Maps & Petunjuk Arah" eyebrow="Lokasi acara"
                        description="Bantu tamu membuka navigasi venue serta melihat informasi parkir dan akses masuk."
                        :qr-data="$qrMapsCodeData" download-name="qr-maps-{{ $invitation->slug }}.png"
                        :copy-url="$qrMapsUrl" :detail-url="route('dashboard.invitations.qr-maps', $invitation)" detail-label="Kelola lokasi">
                        <x-slot:icon><svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg></x-slot:icon>
                    </x-dashboard.qr-card>

                    <x-dashboard.qr-card title="QR Kado Digital & QRIS" eyebrow="Kado digital"
                        description="Tampilkan rekening bank, e-wallet, dan QRIS pada satu halaman kado yang mudah diakses."
                        :qr-data="$hasGoldAccess ? $qrKadoCodeData : null" download-name="qr-kado-{{ $invitation->slug }}.png"
                        :copy-url="$hasGoldAccess ? $qrKadoUrl : null" :detail-url="$hasGoldAccess ? $qrKadoUrl : null" detail-label="Lihat tujuan"
                        :available="$hasGoldAccess" required-tier="Gold" :upgrade-url="route('dashboard.checkout', ['invitation_id' => $invitation->id])" :new-tab="true">
                        <x-slot:icon><svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5a2 2 0 10-2 2h2zm0 13C10.832 21 2 20 2 12c0-4.5 3.5-8 10-8s10 3.5 10 8c0 8-8.832 9-10 9z" /></svg></x-slot:icon>
                    </x-dashboard.qr-card>

                    <x-dashboard.qr-card title="QR Kirim Ucapan & Doa" eyebrow="Buku ucapan"
                        description="Ajak tamu meninggalkan pesan dan doa secara real-time untuk tersimpan di undangan."
                        :qr-data="$hasGoldAccess ? $qrUcapanCodeData : null" download-name="qr-ucapan-{{ $invitation->slug }}.png"
                        :copy-url="$hasGoldAccess ? $qrUcapanUrl : null" :detail-url="$hasGoldAccess ? $qrUcapanUrl : null" detail-label="Lihat tujuan"
                        :available="$hasGoldAccess" required-tier="Gold" :upgrade-url="route('dashboard.checkout', ['invitation_id' => $invitation->id])" :new-tab="true">
                        <x-slot:icon><svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" /></svg></x-slot:icon>
                    </x-dashboard.qr-card>

                    <x-dashboard.qr-card title="QR Galeri Foto Bersama" eyebrow="Momen acara"
                        description="Undang tamu mengunggah foto dan video mereka langsung dari lokasi acara."
                        :qr-data="$hasGoldAccess ? $qrGalleryCodeData : null" download-name="qr-galeri-{{ $invitation->slug }}.png"
                        :copy-url="$hasGoldAccess ? $qrGalleryUrl : null" :detail-url="$hasGoldAccess ? route('dashboard.invitations.qr-gallery', $invitation) : null" detail-label="Kelola galeri"
                        :available="$hasGoldAccess" required-tier="Gold" :upgrade-url="route('dashboard.checkout', ['invitation_id' => $invitation->id])">
                        <x-slot:icon><svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" /></svg></x-slot:icon>
                    </x-dashboard.qr-card>

                    <x-dashboard.qr-card title="QR RSVP" eyebrow="Konfirmasi kehadiran"
                        description="Kumpulkan jawaban kehadiran dari kartu fisik atau souvenir, lalu pantau hasilnya."
                        :qr-data="$hasQrRsvp ? $qrRsvpCodeData : null" download-name="qrcode-{{ $invitation->slug }}.png"
                        :copy-url="$hasQrRsvp ? $rsvpUrl : null" :detail-url="$hasQrRsvp ? route('dashboard.invitations.qr-rsvp', $invitation) : null" detail-label="Lihat laporan"
                        :available="$hasQrRsvp" required-tier="Gold" :upgrade-url="route('dashboard.checkout', ['invitation_id' => $invitation->id])">
                        <x-slot:icon><svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg></x-slot:icon>
                    </x-dashboard.qr-card>
                </div>
            </section>

            <section id="qr-panitia" class="scroll-mt-24" aria-labelledby="qr-panitia-title">
                <div class="mb-5">
                    <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-emerald-600 dark:text-emerald-400">Operasional hari-H</p>
                    <h2 id="qr-panitia-title" class="mt-1 font-heading text-2xl font-bold text-secondary-800 dark:text-neutral-100">QR Code Untuk Panitia</h2>
                    <p class="mt-1 text-sm text-neutral-500 dark:text-neutral-400">Alat kerja tim penerima tamu untuk proses check-in yang lebih cepat.</p>
                </div>

                <div class="overflow-hidden rounded-3xl border {{ $hasQrCheckin ? 'border-emerald-200/80 bg-emerald-50/60 dark:border-emerald-800/50 dark:bg-emerald-900/10' : 'border-amber-200/80 bg-amber-50/60 dark:border-amber-800/50 dark:bg-amber-900/10' }}">
                    <div class="grid gap-6 p-6 sm:p-8 lg:grid-cols-[auto_1fr_auto] lg:items-center">
                        <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-3xl {{ $hasQrCheckin ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-600/20' : 'bg-white text-amber-500 shadow-sm ring-1 ring-amber-100 dark:bg-secondary-800 dark:text-amber-400 dark:ring-amber-800/50' }} lg:mx-0">
                            <svg class="h-9 w-9" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" /></svg>
                        </div>

                        <div class="text-center lg:text-left">
                            <div class="flex flex-wrap items-center justify-center gap-2 lg:justify-start">
                                <h3 class="text-lg font-bold text-secondary-800 dark:text-neutral-100">QR Scan Check-In</h3>
                                @if(!$hasQrCheckin)
                                    <span class="rounded-full border border-amber-200 bg-white px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider text-amber-700 dark:border-amber-800/60 dark:bg-secondary-800 dark:text-amber-300">Platinum</span>
                                @else
                                    <span class="inline-flex items-center gap-1 rounded-full bg-emerald-100 px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300">
                                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                        Aktif
                                    </span>
                                @endif
                            </div>
                            <p class="mt-2 max-w-2xl text-sm leading-6 text-neutral-600 dark:text-neutral-400">Gunakan kamera ponsel penerima tamu untuk memindai tiket, memvalidasi data, dan mencatat kehadiran secara langsung.</p>
                        </div>

                        @if($hasQrCheckin)
                            <a href="{{ route('dashboard.invitations.guestbook', $invitation) }}" class="inline-flex min-h-[46px] items-center justify-center gap-2 rounded-xl bg-emerald-600 px-5 py-3 text-xs font-bold text-white shadow-sm transition hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:ring-offset-2 dark:focus:ring-offset-secondary-900">
                                Buka scanner
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                            </a>
                        @else
                            <a href="{{ route('dashboard.checkout', ['invitation_id' => $invitation->id]) }}" class="inline-flex min-h-[46px] items-center justify-center gap-2 rounded-xl bg-amber-500 px-5 py-3 text-xs font-bold text-white shadow-sm transition hover:bg-amber-600 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 dark:focus:ring-offset-secondary-900">
                                Upgrade ke Platinum
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                            </a>
                        @endif
                    </div>
                </div>
            </section>

            <aside class="flex flex-col gap-4 rounded-2xl border border-neutral-200 bg-white p-5 dark:border-secondary-700 dark:bg-secondary-800 sm:flex-row sm:items-center">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-primary-50 text-primary-600 dark:bg-primary-900/30 dark:text-primary-300">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-bold text-secondary-800 dark:text-neutral-100">Tip cetak QR Code</p>
                    <p class="mt-1 text-xs leading-5 text-neutral-500 dark:text-neutral-400">Gunakan ukuran minimal 3 × 3 cm, sisakan ruang putih di sekeliling QR, dan selalu lakukan tes pindai dari hasil cetak sebelum acara.</p>
                </div>
            </aside>
        </main>
    </div>
</x-app-layout>
