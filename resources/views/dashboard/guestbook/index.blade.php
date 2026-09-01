<x-app-layout>
    <div class="min-h-screen bg-neutral-50 dark:bg-secondary-900">

        {{-- ─── HERO ─── --}}
        <div class="hero-mesh grain-overlay border-b border-neutral-200/60 dark:border-secondary-700/40">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-7 sm:py-8">

                {{-- Breadcrumb --}}
                <nav aria-label="Breadcrumb"
                    class="mb-5 flex items-center gap-1.5 overflow-hidden text-xs text-neutral-400 dark:text-neutral-500">
                    <a href="{{ route('dashboard') }}"
                        class="shrink-0 transition-colors hover:text-primary dark:hover:text-primary-400">Dashboard</a>
                    <svg class="h-3 w-3 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M9 5l7 7-7 7" /></svg>
                    <a href="{{ route('dashboard.invitations.show', $invitation) }}"
                        class="max-w-[150px] truncate transition-colors hover:text-primary dark:hover:text-primary-400">{{ $invitation->title }}</a>
                    <svg class="h-3 w-3 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M9 5l7 7-7 7" /></svg>
                    <span class="shrink-0 font-medium text-neutral-600 dark:text-neutral-400">Buku Tamu</span>
                </nav>

                <div class="flex flex-col gap-5 lg:flex-row lg:items-start lg:justify-between">
                    <div class="flex min-w-0 items-start gap-3.5">
                        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-gradient-to-br from-primary to-primary-600 text-white shadow-lg shadow-primary/20">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" /></svg>
                        </div>
                        <div class="min-w-0">
                            <div class="flex flex-wrap items-center gap-2">
                                <h1 class="truncate font-heading text-2xl font-bold leading-tight text-secondary-800 dark:text-neutral-50 sm:text-3xl">
                                Buku Tamu
                                </h1>
                                <span class="inline-flex items-center gap-1.5 rounded-full border border-emerald-200 bg-emerald-50 px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider text-emerald-700 dark:border-emerald-800/60 dark:bg-emerald-950/40 dark:text-emerald-300">
                                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                    Siap check-in
                                </span>
                            </div>
                            <p class="mt-1.5 max-w-xl text-sm leading-6 text-neutral-500 dark:text-neutral-400">
                                Pusat check-in untuk undangan <strong class="text-secondary-700 dark:text-neutral-300">{{ $invitation->title }}</strong>. Scan kode, verifikasi tamu, lalu cetak tiket.
                            </p>
                        </div>
                    </div>

                    <div class="flex flex-wrap items-center gap-2 lg:max-w-xl lg:justify-end">
                        @if($invitation->hasFeature('personal_link'))
                            <a href="{{ route('dashboard.invitations.guests.index', $invitation) }}"
                                class="inline-flex items-center gap-1.5 rounded-xl border border-neutral-300/80 bg-white/70 px-3.5 py-2 text-xs font-semibold text-secondary-700 backdrop-blur-sm transition-all hover:-translate-y-0.5 hover:bg-white hover:shadow-sm dark:border-secondary-600 dark:bg-secondary-800/50 dark:text-neutral-300 dark:hover:bg-secondary-700">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                Daftar Tamu
                            </a>
                        @endif
                        <a href="{{ route('dashboard.welcome-screen.index', $invitation) }}" target="_blank"
                            rel="noopener noreferrer"
                            class="inline-flex items-center gap-1.5 rounded-xl border border-primary/30 bg-white/70 px-3.5 py-2 text-xs font-semibold text-primary backdrop-blur-sm transition-all hover:-translate-y-0.5 hover:bg-primary-50 hover:shadow-sm dark:border-primary-700/50 dark:bg-secondary-800/50 dark:text-primary-400 dark:hover:bg-primary-900/20">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            Layar Sapa
                        </a>
                        <a href="{{ route('dashboard.invitations.guestbook.settings', $invitation) }}"
                            class="inline-flex items-center gap-1.5 rounded-xl border border-emerald-300/80 bg-white/70 px-3.5 py-2 text-xs font-semibold text-emerald-700 backdrop-blur-sm transition-all hover:-translate-y-0.5 hover:bg-emerald-50 hover:shadow-sm dark:border-emerald-700/50 dark:bg-secondary-800/50 dark:text-emerald-300 dark:hover:bg-emerald-900/20">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065zM15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            Pengaturan
                        </a>
                        <a href="{{ route('dashboard.invitations.qr-codes', $invitation) }}"
                            class="inline-flex items-center gap-1.5 rounded-xl border border-neutral-300/80 bg-white/70 px-3.5 py-2 text-xs font-semibold text-secondary-700 backdrop-blur-sm transition-all hover:-translate-y-0.5 hover:bg-white hover:shadow-sm dark:border-secondary-600 dark:bg-secondary-800/50 dark:text-neutral-300 dark:hover:bg-secondary-700">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                            Kembali ke Pusat QR Code
                        </a>
                    </div>
                </div>

                {{-- Stat Cards --}}
                <div class="mt-6 grid grid-cols-2 gap-3 lg:grid-cols-4">
                    <article class="rounded-2xl border border-neutral-200/80 bg-white/80 p-4 shadow-sm backdrop-blur-sm dark:border-secondary-700/60 dark:bg-secondary-800/70">
                        <div class="flex items-start justify-between gap-3">
                            <div><p class="text-[10px] font-bold uppercase tracking-wider text-neutral-400">Total tamu</p>
                                <p class="mt-1 text-2xl font-extrabold tabular-nums text-secondary-800 dark:text-neutral-100" id="stat-total">{{ $stats['total'] }}</p></div>
                            <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-primary-50 text-primary dark:bg-primary-900/30 dark:text-primary-400"><i class="fa-solid fa-users text-sm" aria-hidden="true"></i></span>
                        </div>
                    </article>
                    <article class="rounded-2xl border border-emerald-200/70 bg-emerald-50/70 p-4 shadow-sm dark:border-emerald-800/50 dark:bg-emerald-950/25">
                        <div class="flex items-start justify-between gap-3">
                            <div><p class="text-[10px] font-bold uppercase tracking-wider text-emerald-600/80 dark:text-emerald-400">Sudah hadir</p>
                                <p class="mt-1 text-2xl font-extrabold tabular-nums text-emerald-700 dark:text-emerald-300" id="stat-hadir">{{ $stats['hadir'] }}</p></div>
                            <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-emerald-100 text-emerald-600 dark:bg-emerald-900/40 dark:text-emerald-300"><i class="fa-solid fa-circle-check text-sm" aria-hidden="true"></i></span>
                        </div>
                    </article>
                    <article class="rounded-2xl border border-amber-200/70 bg-amber-50/70 p-4 shadow-sm dark:border-amber-800/50 dark:bg-amber-950/25">
                        <div class="flex items-start justify-between gap-3">
                            <div><p class="text-[10px] font-bold uppercase tracking-wider text-amber-600/80 dark:text-amber-400">Menunggu</p>
                                <p class="mt-1 text-2xl font-extrabold tabular-nums text-amber-700 dark:text-amber-300" id="stat-pending">{{ $stats['pending'] }}</p></div>
                            <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-amber-100 text-amber-600 dark:bg-amber-900/40 dark:text-amber-300"><i class="fa-solid fa-clock text-sm" aria-hidden="true"></i></span>
                        </div>
                    </article>
                    <article class="col-span-2 rounded-2xl border border-violet-200/70 bg-violet-50/70 p-4 shadow-sm dark:border-violet-800/50 dark:bg-violet-950/25 lg:col-span-1">
                        <div class="flex items-center justify-between gap-3">
                            <p class="text-[10px] font-bold uppercase tracking-wider text-violet-600/80 dark:text-violet-400">Kehadiran</p>
                            <span class="text-lg font-extrabold tabular-nums text-violet-700 dark:text-violet-300" id="stat-percentage">{{ $stats['percentage'] }}%</span>
                        </div>
                        <div class="mt-3 h-2 overflow-hidden rounded-full bg-violet-100 dark:bg-violet-900/40">
                            <div id="attendance-progress" class="h-full rounded-full bg-gradient-to-r from-violet-500 to-primary transition-[width] duration-500"
                                style="width: {{ $stats['percentage'] }}%"></div>
                        </div>
                    </article>
                </div>

            </div>
        </div>

        {{-- ─── MAIN CONTENT ─── --}}
        <div class="mx-auto flex max-w-7xl flex-col gap-6 px-4 py-7 sm:px-6 sm:py-8 lg:px-8">

            {{-- Scanner --}}
            <section aria-labelledby="scanner-title"
                class="overflow-hidden rounded-[28px] border border-neutral-200/80 bg-white shadow-[0_20px_50px_-32px_rgba(15,23,42,0.4)] dark:border-secondary-700/60 dark:bg-secondary-800">
                <div class="flex flex-col gap-3 border-b border-neutral-100 px-5 py-4 dark:border-secondary-700/60 sm:flex-row sm:items-center sm:justify-between sm:px-6">
                    <div class="flex items-center gap-2.5">
                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-primary-50 text-primary dark:bg-primary-900/30 dark:text-primary-400">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
                    </div>
                    <div>
                        <h2 id="scanner-title" class="text-sm font-bold text-secondary-800 dark:text-neutral-100">Scan QR Code Tamu</h2>
                        <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-0.5">Arahkan kamera ke QR Code tamu saat hari H</p>
                    </div>
                    </div>
                    <div class="flex items-center gap-1.5 text-[10px] font-semibold text-neutral-400 dark:text-neutral-500">
                        <span class="rounded-full bg-primary px-2.5 py-1 text-white">1 · Scan</span>
                        <span aria-hidden="true">→</span>
                        <span class="rounded-full bg-neutral-100 px-2.5 py-1 dark:bg-secondary-700">2 · Verifikasi</span>
                        <span aria-hidden="true">→</span>
                        <span class="rounded-full bg-neutral-100 px-2.5 py-1 dark:bg-secondary-700">3 · Cetak</span>
                    </div>
                </div>

                <div class="p-5 sm:p-6">
                    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                        <div class="min-w-0">
                            <div id="qr-reader"
                                class="min-h-[280px] overflow-hidden rounded-2xl border-2 border-dashed border-neutral-300 bg-neutral-50 dark:border-secondary-600 dark:bg-secondary-900"></div>
                            <div class="mt-3 flex gap-2">
                                <button type="button" onclick="startScanner()" id="btn-start"
                                    class="inline-flex flex-1 items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-primary to-primary-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition-all hover:-translate-y-0.5 hover:shadow-md focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-primary-500 focus-visible:ring-offset-2 disabled:cursor-wait disabled:opacity-60 dark:focus-visible:ring-offset-secondary-800">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                    </svg>
                                    Mulai Scan
                                </button>
                                <button type="button" onclick="stopScanner()" id="btn-stop"
                                    class="hidden inline-flex flex-1 items-center justify-center gap-2 rounded-xl bg-neutral-600 px-4 py-2.5 text-sm font-semibold text-white transition-all hover:bg-neutral-700 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-neutral-500 focus-visible:ring-offset-2 dark:focus-visible:ring-offset-secondary-800">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0zM9 10a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4z" />
                                    </svg>
                                    Stop Scan
                                </button>
                            </div>

                            <div class="mt-4 border-t border-neutral-200 pt-4 dark:border-secondary-700">
                                <div class="flex items-end justify-between gap-3">
                                    <label for="manual-token" class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300">Input token manual</label>
                                    <span class="text-[10px] text-neutral-400">Alternatif jika kamera bermasalah</span>
                                </div>
                                <div class="mt-2 flex flex-col gap-2 sm:flex-row">
                                    <input type="text" id="manual-token" placeholder="Tempel token QR tamu"
                                        autocomplete="off" spellcheck="false" aria-describedby="manual-token-help"
                                        class="min-w-0 flex-1 rounded-xl border-neutral-300 text-sm shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:border-secondary-600 dark:bg-secondary-900 dark:text-neutral-200">
                                    <button type="button" onclick="manualCheckin()" id="btn-manual"
                                        class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-xl bg-emerald-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition-all hover:-translate-y-0.5 hover:bg-emerald-700 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-emerald-500 focus-visible:ring-offset-2 disabled:cursor-wait disabled:opacity-60 dark:focus-visible:ring-offset-secondary-800">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        Check-In
                                    </button>
                                </div>
                                <p id="manual-token-help" class="mt-2 text-[11px] leading-5 text-neutral-400">Tekan Enter atau tombol Check-In untuk memproses token.</p>
                            </div>
                        </div>

                        <div class="min-w-0">
                            <div id="result-panel" role="status" aria-live="polite" aria-atomic="true" tabindex="-1"
                                class="flex min-h-[280px] items-center justify-center rounded-2xl border-2 border-dashed border-neutral-200 bg-neutral-50 p-4 outline-none transition-all focus-visible:ring-2 focus-visible:ring-primary-500 dark:border-secondary-600 dark:bg-secondary-900 sm:p-6">
                                <div class="text-center text-neutral-400 dark:text-neutral-500">
                                    <span class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-white shadow-sm ring-1 ring-neutral-200/70 dark:bg-secondary-800 dark:ring-secondary-700">
                                    <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                                    </svg>
                                    </span>
                                    <p class="mt-4 text-sm font-semibold text-neutral-600 dark:text-neutral-300">Hasil check-in muncul di sini</p>
                                    <p class="mt-1 text-xs leading-5 text-neutral-400 dark:text-neutral-500">Nama tamu, urutan kedatangan, dan tombol cetak tiket akan tampil setelah scan berhasil.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            {{-- Checked-in Table --}}
            <section aria-labelledby="recent-checkins-title"
                class="overflow-hidden rounded-[28px] border border-neutral-200/80 bg-white shadow-[0_20px_50px_-32px_rgba(15,23,42,0.35)] dark:border-secondary-700/60 dark:bg-secondary-800">
                <div class="flex flex-col gap-3 border-b border-neutral-100 px-5 py-4 dark:border-secondary-700/60 sm:flex-row sm:items-center sm:justify-between sm:px-6">
                    <div class="flex items-center gap-2.5">
                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 dark:bg-emerald-900/30 dark:text-emerald-400">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <h2 id="recent-checkins-title" class="text-sm font-bold text-secondary-800 dark:text-neutral-100">Kedatangan terbaru</h2>
                            <p class="mt-0.5 text-xs text-neutral-500 dark:text-neutral-400"><span id="recent-count">{{ $recentCheckins->count() }}</span> dari maksimal 50 check-in terbaru</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <label for="checkin-search" class="sr-only">Cari tamu yang sudah hadir</label>
                        <div class="relative min-w-0 flex-1 sm:w-56">
                            <svg class="pointer-events-none absolute left-3 top-1/2 h-3.5 w-3.5 -translate-y-1/2 text-neutral-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m21 21-4.35-4.35m2.35-5.65a8 8 0 1 1-16 0 8 8 0 0 1 16 0Z" /></svg>
                            <input id="checkin-search" type="search" placeholder="Cari nama atau nomor..."
                                class="w-full rounded-xl border-neutral-200 py-2 pl-9 pr-3 text-xs shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:border-secondary-600 dark:bg-secondary-900 dark:text-neutral-200">
                        </div>
                        <a href="{{ route('dashboard.invitations.guests.index', $invitation) }}"
                            class="inline-flex shrink-0 items-center gap-1 rounded-xl px-2.5 py-2 text-xs font-semibold text-primary transition-colors hover:bg-primary-50 dark:text-primary-400 dark:hover:bg-primary-900/20">
                            Semua <span aria-hidden="true">→</span>
                        </a>
                    </div>
                </div>

                <div class="p-5 sm:p-6">
                    <div class="overflow-x-auto border border-neutral-200/70 dark:border-secondary-600/50 rounded-xl">
                        <table class="min-w-full divide-y divide-neutral-200 dark:divide-secondary-700">
                            <thead class="bg-neutral-50 dark:bg-secondary-900">
                                <tr>
                                    <th scope="col" class="hidden px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-neutral-500 dark:text-neutral-400 sm:table-cell">#</th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-neutral-500 dark:text-neutral-400">Nama Tamu</th>
                                    <th scope="col" class="hidden px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-neutral-500 dark:text-neutral-400 sm:table-cell">No HP</th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-neutral-500 dark:text-neutral-400">Waktu</th>
                                    <th scope="col" class="hidden px-4 py-3 text-right text-xs font-semibold uppercase tracking-wider text-neutral-500 dark:text-neutral-400 sm:table-cell">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-secondary-800 divide-y divide-neutral-100 dark:divide-secondary-700" id="checkin-tbody">
                                @forelse($recentCheckins as $index => $checkedGuest)
                                    <tr data-checkin-row data-search="{{ Str::lower($checkedGuest->name.' '.($checkedGuest->phone ?? '')) }}"
                                        class="transition-colors hover:bg-neutral-50 dark:hover:bg-secondary-700/50">
                                        <td class="hidden sm:table-cell px-4 py-3 whitespace-nowrap text-sm text-neutral-500 dark:text-neutral-400">{{ $index + 1 }}</td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-secondary-800 dark:text-neutral-200">
                                            <div class="flex items-center gap-2">
                                                <span class="truncate max-w-[140px] sm:max-w-none">{{ $checkedGuest->name }}</span>
                                                <a href="{{ route('dashboard.invitations.guestbook.ticket', [$invitation, $checkedGuest]) }}" target="_blank"
                                                    rel="noopener noreferrer" aria-label="Cetak tiket {{ $checkedGuest->name }}"
                                                    class="inline-flex h-7 w-7 shrink-0 items-center justify-center rounded-lg bg-primary-50 text-primary-600 transition-colors hover:bg-primary-100 dark:bg-primary-900/30 dark:text-primary-400 dark:hover:bg-primary-900/50 sm:hidden">
                                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                                    </svg>
                                                </a>
                                            </div>
                                        </td>
                                        <td class="hidden sm:table-cell px-4 py-3 whitespace-nowrap text-sm text-neutral-500 dark:text-neutral-400">{{ $checkedGuest->phone ?? '-' }}</td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-neutral-500 dark:text-neutral-400">{{ $checkedGuest->checked_in_at->format('H:i, d M Y') }}</td>
                                        <td class="hidden sm:table-cell px-4 py-3 whitespace-nowrap text-right text-sm">
                                            <a href="{{ route('dashboard.invitations.guestbook.ticket', [$invitation, $checkedGuest]) }}" target="_blank" rel="noopener noreferrer"
                                                class="inline-flex items-center gap-1.5 text-primary-600 dark:text-primary-400 hover:text-primary-700 text-xs font-semibold">
                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                                </svg>
                                                Cetak Tiket
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr id="empty-row">
                                        <td colspan="5" class="px-4 py-12 text-center text-sm text-neutral-500 dark:text-neutral-400">
                                            <span class="mx-auto flex h-11 w-11 items-center justify-center rounded-2xl bg-neutral-100 text-neutral-400 dark:bg-secondary-700 dark:text-neutral-500"><i class="fa-solid fa-user-clock" aria-hidden="true"></i></span>
                                            <span class="mt-3 block font-semibold text-secondary-700 dark:text-neutral-300">Belum ada tamu yang check-in</span>
                                            <span class="mt-1 block text-xs">Kedatangan pertama akan otomatis tampil di sini.</span>
                                        </td>
                                    </tr>
                                @endforelse
                                <tr id="no-search-results" class="hidden">
                                    <td colspan="5" class="px-4 py-10 text-center text-sm text-neutral-500 dark:text-neutral-400">
                                        Tidak ada tamu yang cocok dengan pencarian.
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>

    <script>
        const checkinUrl = @json(route('dashboard.invitations.guestbook.checkin', $invitation));
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const startButton = document.getElementById('btn-start');
        const stopButton = document.getElementById('btn-stop');
        const manualButton = document.getElementById('btn-manual');
        const manualInput = document.getElementById('manual-token');
        let html5QrCode = null;
        let isScanning = false;
        let isProcessing = false;
        let lastScannedToken = '';
        let scanCooldown = false;

        function startScanner() {
            if (isScanning) return;

            if (typeof window.Html5Qrcode === 'undefined') {
                showResult('error', 'Scanner belum siap', 'Muat ulang halaman atau gunakan input token manual.');
                return;
            }

            startButton.disabled = true;
            html5QrCode = new window.Html5Qrcode('qr-reader');
            html5QrCode.start(
                { facingMode: 'environment' },
                { fps: 10, qrbox: { width: 250, height: 250 } },
                onScanSuccess,
                onScanError
            ).then(() => {
                isScanning = true;
                startButton.classList.add('hidden');
                stopButton.classList.remove('hidden');
                showResult('loading', 'Kamera aktif', 'Arahkan QR Code tamu ke area pemindai.');
            }).catch(() => {
                showResult('error', 'Kamera tidak dapat diakses', 'Periksa izin kamera, lalu coba lagi atau gunakan input token manual.');
            }).finally(() => {
                startButton.disabled = false;
            });
        }

        function stopScanner() {
            if (!isScanning || !html5QrCode) return;

            stopButton.disabled = true;
            html5QrCode.stop().then(() => {
                isScanning = false;
                startButton.classList.remove('hidden');
                stopButton.classList.add('hidden');
                showResult('warning', 'Scanner dihentikan', 'Aktifkan kembali kamera saat siap menerima tamu.');
            }).catch(() => {
                showResult('error', 'Scanner gagal dihentikan', 'Muat ulang halaman jika kamera masih aktif.');
            }).finally(() => {
                stopButton.disabled = false;
            });
        }

        function onScanSuccess(decodedText) {
            if (scanCooldown || decodedText === lastScannedToken) return;
            lastScannedToken = decodedText;
            scanCooldown = true;
            setTimeout(() => { scanCooldown = false; lastScannedToken = ''; }, 3000);
            processCheckin(decodedText);
        }

        function onScanError() {}

        function manualCheckin() {
            const token = manualInput.value.trim();
            if (!token) {
                showResult('warning', 'Token belum diisi', 'Masukkan token QR tamu sebelum melakukan check-in.');
                manualInput.focus();
                return;
            }

            processCheckin(token);
            manualInput.value = '';
        }

        async function processCheckin(token) {
            if (isProcessing) return;

            isProcessing = true;
            manualButton.disabled = true;
            manualInput.disabled = true;
            showResult('loading', 'Memproses...', 'Mencari data tamu...');

            try {
                const response = await fetch(checkinUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ qr_code_token: token }),
                });

                const data = await response.json().catch(() => ({}));

                if (response.ok && data.success) {
                    showResult('success', data.guest.name, `Check-in #${data.guest.checkin_order} — ${data.guest.checked_in_at}`, data.ticket_url);
                    updateStats(1);
                    addToCheckinTable(data.guest, data.ticket_url);
                    playBeep(true);
                } else if (response.status === 409) {
                    showResult('warning', data.guest.name, `${data.message} (${data.guest.checked_in_at})`);
                    playBeep(false);
                } else {
                    showResult('error', 'Check-in gagal', data.message || 'Token tidak dapat diproses. Silakan coba lagi.');
                    playBeep(false);
                }
            } catch {
                showResult('error', 'Koneksi bermasalah', 'Tidak dapat terhubung ke server. Periksa koneksi lalu coba lagi.');
            } finally {
                isProcessing = false;
                manualButton.disabled = false;
                manualInput.disabled = false;
            }
        }

        function showResult(type, title, subtitle, ticketUrl = null) {
            const panel = document.getElementById('result-panel');
            const configs = {
                loading: { classes: 'bg-blue-50 dark:bg-blue-900/30 border-blue-300 dark:border-blue-700 text-blue-800 dark:text-blue-200', icon: 'loader' },
                success: { classes: 'bg-emerald-50 dark:bg-emerald-900/30 border-emerald-400 dark:border-emerald-700 text-emerald-800 dark:text-emerald-200', icon: 'check' },
                warning: { classes: 'bg-amber-50 dark:bg-amber-900/30 border-amber-400 dark:border-amber-700 text-amber-800 dark:text-amber-200', icon: 'warn' },
                error: { classes: 'bg-red-50 dark:bg-red-900/30 border-red-400 dark:border-red-700 text-red-800 dark:text-red-200', icon: 'x' },
            };
            const config = configs[type] || configs.error;

            const icons = {
                loader: '<svg class="animate-spin h-10 w-10 mx-auto mb-4 text-blue-500" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>',
                check: '<svg class="h-10 w-10 mx-auto mb-4 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
                warn: '<svg class="h-10 w-10 mx-auto mb-4 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>',
                x: '<svg class="h-10 w-10 mx-auto mb-4 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>',
            };

            const content = document.createElement('div');
            content.className = `${config.classes} flex min-h-[280px] w-full flex-col items-center justify-center rounded-2xl border-2 p-6 text-center transition-all`;
            content.innerHTML = icons[config.icon];

            const heading = document.createElement('h3');
            heading.className = 'text-xl font-bold';
            heading.textContent = String(title || 'Informasi check-in');
            content.appendChild(heading);

            const message = document.createElement('p');
            message.className = 'mt-2 text-sm opacity-80';
            message.textContent = String(subtitle || '');
            content.appendChild(message);

            if (ticketUrl) {
                const ticketLink = document.createElement('a');
                ticketLink.href = ticketUrl;
                ticketLink.target = '_blank';
                ticketLink.rel = 'noopener noreferrer';
                ticketLink.className = 'mt-4 inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-primary to-primary-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition-all hover:-translate-y-0.5 hover:shadow-md';
                ticketLink.innerHTML = '<svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" /></svg><span>Cetak Tiket</span>';
                content.appendChild(ticketLink);
            }

            panel.replaceChildren(content);
            if (type !== 'loading') panel.focus({ preventScroll: true });
        }

        function updateStats(increment) {
            const hadirEl = document.getElementById('stat-hadir');
            const pendingEl = document.getElementById('stat-pending');
            const totalEl = document.getElementById('stat-total');
            const percentageEl = document.getElementById('stat-percentage');
            const progressEl = document.getElementById('attendance-progress');
            const total = Number.parseInt(totalEl.textContent, 10) || 0;
            const hadir = (Number.parseInt(hadirEl.textContent, 10) || 0) + increment;

            hadirEl.textContent = hadir;
            pendingEl.textContent = Math.max(0, (Number.parseInt(pendingEl.textContent, 10) || 0) - increment);

            const percentage = total > 0 ? Math.round((hadir / total) * 100) : 0;
            percentageEl.textContent = `${percentage}%`;
            progressEl.style.width = `${percentage}%`;
        }

        function addToCheckinTable(guest, ticketUrl) {
            const tbody = document.getElementById('checkin-tbody');
            const emptyRow = document.getElementById('empty-row');
            if (emptyRow) emptyRow.remove();

            const row = document.createElement('tr');
            row.className = 'animate-pulse bg-emerald-50 dark:bg-emerald-900/30';
            row.dataset.checkinRow = '';
            row.dataset.search = `${guest.name || ''} ${guest.phone || ''}`.toLocaleLowerCase('id-ID');

            const orderCell = document.createElement('td');
            orderCell.className = 'hidden whitespace-nowrap px-4 py-3 text-sm text-neutral-500 dark:text-neutral-400 sm:table-cell';
            orderCell.textContent = String(guest.checkin_order);

            const nameCell = document.createElement('td');
            nameCell.className = 'whitespace-nowrap px-4 py-3 text-sm font-medium text-secondary-800 dark:text-neutral-200';
            const nameWrap = document.createElement('div');
            nameWrap.className = 'flex items-center gap-2';
            const name = document.createElement('span');
            name.className = 'max-w-[140px] truncate sm:max-w-none';
            name.textContent = String(guest.name || '-');
            nameWrap.appendChild(name);
            nameWrap.appendChild(createTicketLink(ticketUrl, guest.name, true));
            nameCell.appendChild(nameWrap);

            const phoneCell = document.createElement('td');
            phoneCell.className = 'hidden whitespace-nowrap px-4 py-3 text-sm text-neutral-500 dark:text-neutral-400 sm:table-cell';
            phoneCell.textContent = String(guest.phone || '-');

            const timeCell = document.createElement('td');
            timeCell.className = 'whitespace-nowrap px-4 py-3 text-sm text-neutral-500 dark:text-neutral-400';
            timeCell.textContent = String(guest.checked_in_at || '-');

            const actionCell = document.createElement('td');
            actionCell.className = 'hidden whitespace-nowrap px-4 py-3 text-right text-sm sm:table-cell';
            actionCell.appendChild(createTicketLink(ticketUrl, guest.name, false));

            row.append(orderCell, nameCell, phoneCell, timeCell, actionCell);
            tbody.insertBefore(row, tbody.firstChild);

            const rows = tbody.querySelectorAll('[data-checkin-row]');
            if (rows.length > 50) rows[rows.length - 1].remove();
            document.getElementById('recent-count').textContent = String(Math.min(rows.length, 50));
            filterCheckins();

            setTimeout(() => {
                row.classList.remove('animate-pulse', 'bg-emerald-50', 'dark:bg-emerald-900/30');
            }, 2000);
        }

        function createTicketLink(ticketUrl, guestName, compact) {
            const link = document.createElement('a');
            link.href = ticketUrl;
            link.target = '_blank';
            link.rel = 'noopener noreferrer';
            link.setAttribute('aria-label', `Cetak tiket ${guestName || 'tamu'}`);
            link.className = compact
                ? 'inline-flex h-7 w-7 shrink-0 items-center justify-center rounded-lg bg-primary-50 text-primary-600 transition-colors hover:bg-primary-100 dark:bg-primary-900/30 dark:text-primary-400 dark:hover:bg-primary-900/50 sm:hidden'
                : 'inline-flex items-center gap-1.5 text-xs font-semibold text-primary-600 transition-colors hover:text-primary-700 dark:text-primary-400';
            link.innerHTML = `<svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" /></svg>${compact ? '' : '<span>Cetak Tiket</span>'}`;

            return link;
        }

        function filterCheckins() {
            const query = document.getElementById('checkin-search').value.trim().toLocaleLowerCase('id-ID');
            const rows = [...document.querySelectorAll('[data-checkin-row]')];
            const emptyRow = document.getElementById('empty-row');
            let visibleRows = 0;

            rows.forEach((row) => {
                const visible = !query || row.dataset.search.includes(query);
                row.classList.toggle('hidden', !visible);
                if (visible) visibleRows++;
            });

            if (emptyRow) emptyRow.classList.toggle('hidden', Boolean(query));
            document.getElementById('no-search-results').classList.toggle('hidden', !query || visibleRows > 0);
        }

        function playBeep(success) {
            try {
                const ctx = new (window.AudioContext || window.webkitAudioContext)();
                const osc = ctx.createOscillator();
                const gain = ctx.createGain();
                osc.connect(gain);
                gain.connect(ctx.destination);
                osc.frequency.value = success ? 800 : 300;
                gain.gain.value = 0.3;
                osc.start();
                osc.stop(ctx.currentTime + (success ? 0.15 : 0.3));
                osc.addEventListener('ended', () => ctx.close());
            } catch {}
        }

        manualInput.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') manualCheckin();
        });
        document.getElementById('checkin-search').addEventListener('input', filterCheckins);
        window.addEventListener('pagehide', () => {
            if (isScanning && html5QrCode) html5QrCode.stop().catch(() => {});
        });
    </script>
</x-app-layout>
