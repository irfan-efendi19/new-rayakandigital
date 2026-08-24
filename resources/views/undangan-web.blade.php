<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <x-meta title="Undangan Web - Rayakan Digital"
        description="Buat undangan pernikahan online dalam 5 menit. Praktis, elegan, lengkap dengan fitur kirim otomatis via WhatsApp, galeri foto, musik latar, dan Check-in QR Code."
        keywords="undangan web, undangan online, undangan pernikahan digital, buat undangan online, undangan interaktif" />

    @stack('meta')

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    <link rel="stylesheet" href="{{ asset('css/landingpage.css') }}">
    <script>
        if (localStorage.getItem('dark-mode') === 'true' || (!('dark-mode' in localStorage) && window.matchMedia(
            '(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>

<body class="bg-neutral-50 font-sans text-secondary-800 antialiased dark:bg-secondary-900 dark:text-neutral-200">
    <x-public-navbar />
    <div class="h-16" aria-hidden="true"></div>

    <main class="overflow-hidden">
        <section class="grain-bg relative isolate overflow-hidden bg-white dark:bg-secondary-900" id="layanan">
            <div class="orb-orange pointer-events-none absolute -left-40 top-0 h-[34rem] w-[34rem]" aria-hidden="true"></div>
            <div class="orb-warm pointer-events-none absolute -right-48 bottom-0 h-[38rem] w-[38rem]" aria-hidden="true"></div>

            <div class="relative mx-auto grid min-h-[42rem] max-w-7xl items-center gap-14 px-6 py-16 sm:px-8 lg:grid-cols-[1.05fr_.95fr] lg:gap-8 lg:px-12 lg:py-24">
                <div class="max-w-2xl">
                    <div class="mb-6 inline-flex items-center gap-2 rounded-full border border-primary-200 bg-primary-50 px-3.5 py-2 text-xs font-bold uppercase tracking-wider text-primary-700 dark:border-primary-800 dark:bg-primary-900/30 dark:text-primary-300">
                        <span class="relative flex h-2 w-2" aria-hidden="true">
                            <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-primary-400 opacity-75"></span>
                            <span class="relative inline-flex h-2 w-2 rounded-full bg-primary-500"></span>
                        </span>
                        Undangan siap dibagikan dalam 5 menit
                    </div>

                    <h1 class="font-heading text-4xl font-bold leading-[1.08] tracking-tight text-secondary-900 dark:text-white sm:text-5xl lg:text-6xl">
                        Undangan digital yang terasa
                        <span class="text-primary-500">personal</span>, sejak pandangan pertama.
                    </h1>

                    <p class="mt-6 max-w-xl text-base leading-8 text-neutral-600 dark:text-neutral-300 sm:text-lg">
                        Buat undangan pernikahan dengan tampilan elegan, RSVP real-time, dan link personal untuk setiap
                        tamu—dari akad hingga resepsi.
                    </p>

                    <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                        <a href="{{ route('register') }}"
                            class="inline-flex min-h-12 items-center justify-center gap-2 rounded-full bg-primary-500 px-7 py-3.5 text-sm font-bold text-white shadow-lg shadow-primary-500/25 transition duration-200 hover:-translate-y-0.5 hover:bg-primary-600 hover:shadow-xl focus:outline-none focus-visible:ring-4 focus-visible:ring-primary-500/30 motion-reduce:transform-none">
                            Buat undangan gratis
                            <i class="fa-solid fa-arrow-right text-xs" aria-hidden="true"></i>
                        </a>
                        <a href="{{ route('themes.index') }}"
                            class="inline-flex min-h-12 items-center justify-center gap-2 rounded-full border border-neutral-300 bg-white/80 px-7 py-3.5 text-sm font-bold text-secondary-800 transition duration-200 hover:-translate-y-0.5 hover:border-primary-300 hover:text-primary-600 focus:outline-none focus-visible:ring-4 focus-visible:ring-primary-500/20 dark:border-secondary-700 dark:bg-secondary-800/80 dark:text-neutral-100 dark:hover:border-primary-700 dark:hover:text-primary-400 motion-reduce:transform-none">
                            <i class="fa-regular fa-images" aria-hidden="true"></i>
                            Lihat koleksi tema
                        </a>
                    </div>

                    <dl class="mt-10 grid max-w-xl grid-cols-3 gap-3 border-t border-neutral-200 pt-6 dark:border-secondary-700">
                        <div>
                            <dt class="text-xs leading-5 text-neutral-500 dark:text-neutral-400">Waktu pembuatan</dt>
                            <dd class="mt-1 text-sm font-bold text-secondary-900 dark:text-white sm:text-base">± 5 menit</dd>
                        </div>
                        <div>
                            <dt class="text-xs leading-5 text-neutral-500 dark:text-neutral-400">Link tamu</dt>
                            <dd class="mt-1 text-sm font-bold text-secondary-900 dark:text-white sm:text-base">Personal</dd>
                        </div>
                        <div>
                            <dt class="text-xs leading-5 text-neutral-500 dark:text-neutral-400">Konfirmasi hadir</dt>
                            <dd class="mt-1 text-sm font-bold text-secondary-900 dark:text-white sm:text-base">Real-time</dd>
                        </div>
                    </dl>
                </div>

                <div class="relative mx-auto flex w-full max-w-xl items-center justify-center lg:justify-end">
                    <div class="absolute inset-x-10 top-1/2 h-64 -translate-y-1/2 rounded-full bg-primary-500/20 blur-3xl dark:bg-primary-600/15" aria-hidden="true"></div>
                    <img src="{{ asset('img/mockup.png') }}" alt="Tampilan undangan digital Rayakan Digital di perangkat seluler"
                        width="493" height="347" fetchpriority="high"
                        class="relative z-10 w-full max-w-[31rem] drop-shadow-2xl">

                    <div class="absolute -left-2 top-7 z-20 flex items-center gap-3 rounded-2xl border border-white/70 bg-white/90 px-4 py-3 shadow-xl backdrop-blur dark:border-secondary-700 dark:bg-secondary-800/90 sm:left-3 lg:-left-4">
                        <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-emerald-100 text-emerald-600 dark:bg-emerald-950 dark:text-emerald-400">
                            <i class="fa-solid fa-check" aria-hidden="true"></i>
                        </span>
                        <span>
                            <span class="block text-[10px] font-semibold uppercase tracking-wider text-neutral-400">RSVP masuk</span>
                            <span class="block text-xs font-bold text-secondary-900 dark:text-white">Rina & Keluarga · 3 tamu</span>
                        </span>
                    </div>

                    <div class="absolute -bottom-5 right-0 z-20 flex items-center gap-3 rounded-2xl border border-white/70 bg-white/90 px-4 py-3 shadow-xl backdrop-blur dark:border-secondary-700 dark:bg-secondary-800/90 sm:right-5 lg:-right-2">
                        <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-primary-100 text-primary-600 dark:bg-primary-900/40 dark:text-primary-400">
                            <i class="fa-brands fa-whatsapp" aria-hidden="true"></i>
                        </span>
                        <span>
                            <span class="block text-[10px] font-semibold uppercase tracking-wider text-neutral-400">Siap dibagikan</span>
                            <span class="block text-xs font-bold text-secondary-900 dark:text-white">Pesan tamu otomatis</span>
                        </span>
                    </div>
                </div>
            </div>
        </section>

        <section class="border-y border-neutral-200 bg-neutral-50 dark:border-secondary-700 dark:bg-secondary-800/50" aria-label="Rangkaian acara pernikahan">
            <div class="mx-auto flex max-w-7xl flex-col items-center justify-between gap-5 px-6 py-6 sm:px-8 lg:flex-row lg:px-12">
                <p class="text-center text-xs font-bold uppercase tracking-[0.2em] text-neutral-400 lg:text-left">Khusus untuk rangkaian hari pernikahan</p>
                <div class="flex flex-wrap justify-center gap-2.5">
                    @foreach ([['book-open', 'Akad Nikah'], ['rings-wedding', 'Resepsi'], ['people-roof', 'Ngunduh Mantu'], ['champagne-glasses', 'Wedding Ceremony']] as [$icon, $label])
                        <span class="inline-flex items-center gap-2 rounded-full border border-neutral-200 bg-white px-4 py-2 text-xs font-semibold text-neutral-600 shadow-sm dark:border-secondary-700 dark:bg-secondary-800 dark:text-neutral-300">
                            <i class="fa-solid fa-{{ $icon }} text-primary-500" aria-hidden="true"></i>
                            {{ $label }}
                        </span>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="bg-white py-20 dark:bg-secondary-900 sm:py-24" id="fitur">
            <div class="mx-auto max-w-7xl px-6 sm:px-8 lg:px-12">
                <div class="mx-auto max-w-2xl text-center">
                    <span class="text-xs font-bold uppercase tracking-[0.2em] text-primary-500">Semua serba praktis</span>
                    <h2 class="mt-3 font-heading text-3xl font-bold tracking-tight text-secondary-900 dark:text-white sm:text-4xl">
                        Semua yang Anda butuhkan dalam satu undangan
                    </h2>
                    <p class="mt-4 text-sm leading-7 text-neutral-600 dark:text-neutral-300 sm:text-base">
                        Dari membagikan kabar bahagia sampai mencatat kehadiran, setiap detail terhubung tanpa alat tambahan.
                    </p>
                </div>

                <div class="mt-12 grid gap-5 lg:grid-cols-12">
                    <article class="group relative overflow-hidden rounded-3xl border border-neutral-200 bg-neutral-50 p-6 dark:border-secondary-700 dark:bg-secondary-800 sm:p-8 lg:col-span-7">
                        <div class="relative z-10 max-w-md">
                            <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-primary-100 text-primary-600 dark:bg-primary-900/40 dark:text-primary-400">
                                <i class="fa-regular fa-images" aria-hidden="true"></i>
                            </span>
                            <h3 class="mt-5 text-xl font-bold text-secondary-900 dark:text-white">Galeri yang menampilkan cerita Anda</h3>
                            <p class="mt-2 text-sm leading-7 text-neutral-600 dark:text-neutral-300">Susun foto dan video terbaik dalam pengalaman visual yang nyaman di setiap ukuran layar.</p>
                        </div>
                        <div class="mt-7 grid h-52 grid-cols-3 items-end gap-3 overflow-hidden rounded-2xl bg-gradient-to-br from-primary-100 to-primary-50 p-4 dark:from-primary-950 dark:to-secondary-900">
                            <div class="h-28 -rotate-3 rounded-2xl border-4 border-white bg-primary-200 shadow-lg dark:border-secondary-700 dark:bg-primary-900"></div>
                            <div class="h-44 overflow-hidden rounded-2xl border-4 border-white shadow-xl transition duration-500 group-hover:-translate-y-2 dark:border-secondary-700">
                                <img src="{{ asset('img/undangan.webp') }}" alt="" loading="lazy"
                                    class="h-full w-full object-cover object-top">
                            </div>
                            <div class="h-32 rotate-3 rounded-2xl border-4 border-white bg-primary-300 shadow-lg dark:border-secondary-700 dark:bg-primary-800"></div>
                        </div>
                    </article>

                    <article class="rounded-3xl bg-primary-500 p-6 text-white shadow-lg shadow-primary-500/15 sm:p-8 lg:col-span-5">
                        <div class="flex items-start justify-between gap-4">
                            <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-white/15">
                                <i class="fa-solid fa-envelope-open-text" aria-hidden="true"></i>
                            </span>
                            <span class="rounded-full bg-white/15 px-3 py-1.5 text-[10px] font-bold uppercase tracking-wider">Live update</span>
                        </div>
                        <h3 class="mt-5 text-xl font-bold">RSVP & ucapan real-time</h3>
                        <p class="mt-2 text-sm leading-7 text-white/80">Ketahui siapa yang hadir dan baca ucapan hangat tamu langsung dari dashboard.</p>

                        <div class="mt-7 grid gap-2.5">
                            <div class="flex items-center gap-3 rounded-2xl bg-white/15 p-3.5 backdrop-blur">
                                <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-white text-sm font-bold text-primary-600">R</span>
                                <span class="min-w-0 flex-1">
                                    <span class="block truncate text-xs font-bold">Rina & Keluarga</span>
                                    <span class="block text-[10px] text-white/70">Hadir · 3 orang</span>
                                </span>
                                <i class="fa-solid fa-circle-check text-white" aria-hidden="true"></i>
                            </div>
                            <div class="flex items-center gap-3 rounded-2xl bg-white/10 p-3.5 backdrop-blur">
                                <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-white/20 text-sm font-bold">B</span>
                                <span class="min-w-0 flex-1">
                                    <span class="block truncate text-xs font-bold">Budi Santoso</span>
                                    <span class="block text-[10px] text-white/70">Menunggu konfirmasi</span>
                                </span>
                                <i class="fa-regular fa-clock text-white/70" aria-hidden="true"></i>
                            </div>
                        </div>
                    </article>

                    <article class="rounded-3xl border border-neutral-200 bg-neutral-50 p-6 dark:border-secondary-700 dark:bg-secondary-800 sm:p-8 lg:col-span-4">
                        <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-sky-100 text-sky-600 dark:bg-sky-950 dark:text-sky-400">
                            <i class="fa-solid fa-location-dot" aria-hidden="true"></i>
                        </span>
                        <h3 class="mt-5 text-lg font-bold text-secondary-900 dark:text-white">Navigasi sekali sentuh</h3>
                        <p class="mt-2 text-sm leading-7 text-neutral-600 dark:text-neutral-300">Arahkan tamu ke lokasi pernikahan melalui Google Maps atau Waze.</p>
                        <div class="relative mt-6 h-24 overflow-hidden rounded-2xl bg-sky-100 dark:bg-sky-950">
                            <div class="absolute -left-3 top-7 h-0.5 w-32 rotate-12 bg-white/80 dark:bg-sky-800"></div>
                            <div class="absolute right-2 top-12 h-0.5 w-36 -rotate-6 bg-white/80 dark:bg-sky-800"></div>
                            <span class="absolute left-1/2 top-1/2 flex h-10 w-10 -translate-x-1/2 -translate-y-1/2 items-center justify-center rounded-full bg-primary-500 text-white shadow-lg">
                                <i class="fa-solid fa-location-dot" aria-hidden="true"></i>
                            </span>
                        </div>
                    </article>

                    <article class="rounded-3xl border border-neutral-200 bg-neutral-50 p-6 dark:border-secondary-700 dark:bg-secondary-800 sm:p-8 lg:col-span-4">
                        <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-violet-100 text-violet-600 dark:bg-violet-950 dark:text-violet-400">
                            <i class="fa-solid fa-music" aria-hidden="true"></i>
                        </span>
                        <h3 class="mt-5 text-lg font-bold text-secondary-900 dark:text-white">Musik latar pilihan</h3>
                        <p class="mt-2 text-sm leading-7 text-neutral-600 dark:text-neutral-300">Bangun suasana yang tepat dengan lagu spesial Anda.</p>
                        <div class="mt-7 flex h-14 items-center gap-1.5 rounded-2xl bg-white px-4 dark:bg-secondary-900">
                            @foreach (['h-2', 'h-3.5', 'h-5', 'h-3', 'h-6', 'h-4', 'h-2.5', 'h-[18px]', 'h-3', 'h-[22px]', 'h-3.5', 'h-2'] as $heightClass)
                                <span class="w-1.5 rounded-full bg-primary-400 {{ $heightClass }}" aria-hidden="true"></span>
                            @endforeach
                            <span class="ml-auto flex h-9 w-9 items-center justify-center rounded-full bg-primary-500 text-xs text-white">
                                <i class="fa-solid fa-pause" aria-hidden="true"></i>
                            </span>
                        </div>
                    </article>

                    <article class="rounded-3xl border border-neutral-200 bg-neutral-50 p-6 dark:border-secondary-700 dark:bg-secondary-800 sm:p-8 lg:col-span-4">
                        <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-emerald-100 text-emerald-600 dark:bg-emerald-950 dark:text-emerald-400">
                            <i class="fa-brands fa-whatsapp" aria-hidden="true"></i>
                        </span>
                        <h3 class="mt-5 text-lg font-bold text-secondary-900 dark:text-white">Pesan tamu personal</h3>
                        <p class="mt-2 text-sm leading-7 text-neutral-600 dark:text-neutral-300">Bagikan link bernama langsung ke WhatsApp dengan template siap pakai.</p>
                        <div class="mt-6 rounded-2xl border border-emerald-100 bg-white p-4 dark:border-emerald-900 dark:bg-secondary-900">
                            <p class="text-[11px] leading-5 text-neutral-500 dark:text-neutral-400">Kepada Yth. <strong class="text-secondary-900 dark:text-white">Bapak Andi</strong>, kami mengundang Anda...</p>
                        </div>
                    </article>
                </div>
            </div>
        </section>

        <section class="border-y border-neutral-200 bg-neutral-50 py-20 dark:border-secondary-700 dark:bg-secondary-800/40 sm:py-24" id="cara-kerja">
            <div class="mx-auto max-w-7xl px-6 sm:px-8 lg:px-12">
                <div class="grid items-end gap-6 lg:grid-cols-2">
                    <div>
                        <span class="text-xs font-bold uppercase tracking-[0.2em] text-primary-500">Mulai tanpa ribet</span>
                        <h2 class="mt-3 font-heading text-3xl font-bold text-secondary-900 dark:text-white sm:text-4xl">Tiga langkah menuju hari bahagia</h2>
                    </div>
                    <p class="max-w-xl text-sm leading-7 text-neutral-600 dark:text-neutral-300 lg:justify-self-end">Tidak perlu coding atau menunggu desainer. Pilih tampilan, masukkan cerita Anda, lalu bagikan.</p>
                </div>

                <ol class="mt-12 grid gap-5 md:grid-cols-3">
                    @foreach ([
                        ['01', 'Pilih tema', 'Temukan desain yang paling sesuai dengan karakter dan nuansa pernikahan Anda.', 'wand-magic-sparkles'],
                        ['02', 'Isi detail pernikahan', 'Lengkapi profil pasangan, jadwal, lokasi, galeri, musik, dan daftar tamu.', 'pen-to-square'],
                        ['03', 'Bagikan ke tamu', 'Kirim link personal melalui WhatsApp dan pantau RSVP secara real-time.', 'paper-plane'],
                    ] as [$number, $title, $description, $icon])
                        <li class="relative rounded-3xl border border-neutral-200 bg-white p-7 shadow-sm dark:border-secondary-700 dark:bg-secondary-800">
                            <div class="flex items-center justify-between gap-4">
                                <span class="font-heading text-4xl font-bold text-primary-200 dark:text-primary-900">{{ $number }}</span>
                                <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-primary-50 text-primary-600 dark:bg-primary-900/30 dark:text-primary-400">
                                    <i class="fa-solid fa-{{ $icon }}" aria-hidden="true"></i>
                                </span>
                            </div>
                            <h3 class="mt-6 text-lg font-bold text-secondary-900 dark:text-white">{{ $title }}</h3>
                            <p class="mt-2 text-sm leading-7 text-neutral-600 dark:text-neutral-300">{{ $description }}</p>
                        </li>
                    @endforeach
                </ol>
            </div>
        </section>

        <section class="bg-white py-20 dark:bg-secondary-900 sm:py-24" id="harga">
            <div class="mx-auto max-w-7xl px-6 sm:px-8 lg:px-12">
                <div class="mx-auto max-w-2xl text-center">
                    <span class="text-xs font-bold uppercase tracking-[0.2em] text-primary-500">Harga transparan</span>
                    <h2 class="mt-3 font-heading text-3xl font-bold text-secondary-900 dark:text-white sm:text-4xl">Pilih paket sesuai kebutuhan</h2>
                    <p class="mt-4 text-sm leading-7 text-neutral-600 dark:text-neutral-300 sm:text-base">Mulai gratis, lalu tingkatkan paket saat Anda membutuhkan fitur yang lebih lengkap.</p>
                </div>

                <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-4 lg:items-start">
                    @forelse($packages as $index => $package)
                        @php
                            $packageDescription = match ($package->package_code) {
                                'free' => 'Cocok untuk mencoba undangan pernikahan digital dengan fitur dasar.',
                                'silver' => 'Untuk pasangan yang menginginkan undangan pernikahan sederhana dan elegan.',
                                'gold' => 'Paket favorit calon pengantin dengan fitur lengkap untuk hari istimewa.',
                                'platinum' => 'Untuk rangkaian pernikahan dengan kebutuhan tamu dan fitur paling lengkap.',
                                default => 'Pilihan fitur untuk melengkapi undangan pernikahan Anda.',
                            };
                        @endphp
                        <article class="relative flex h-full flex-col rounded-3xl bg-white transition duration-300 hover:-translate-y-1 hover:shadow-xl dark:bg-secondary-800 motion-reduce:transform-none {{ $package->is_popular ? 'border-2 border-primary-500 shadow-xl shadow-primary-500/10' : 'border border-neutral-200 shadow-sm dark:border-secondary-700' }}">
                            @if($package->is_popular)
                                <div class="absolute -top-3 left-1/2 -translate-x-1/2">
                                    <span class="inline-flex items-center gap-1.5 whitespace-nowrap rounded-full bg-primary-500 px-4 py-1.5 text-[10px] font-bold uppercase tracking-wider text-white shadow-lg">
                                        <i class="fa-solid fa-star" aria-hidden="true"></i>
                                        Paling populer
                                    </span>
                                </div>
                            @endif

                            <div class="flex flex-1 flex-col p-6 {{ $package->is_popular ? 'pt-8' : '' }}">
                                <div>
                                    <h3 class="font-heading text-xl font-bold {{ $package->is_popular ? 'text-primary-600 dark:text-primary-400' : 'text-secondary-900 dark:text-white' }}">{{ $package->package_name }}</h3>
                                    <p class="mt-2 min-h-[4.5rem] text-xs leading-6 text-neutral-500 dark:text-neutral-400">{{ $packageDescription }}</p>
                                </div>

                                <div class="mt-5 border-y border-neutral-100 py-5 dark:border-secondary-700">
                                    @if($package->slashed_price && $package->slashed_price > $package->price)
                                        <span class="block text-xs text-neutral-400 line-through">Rp {{ number_format($package->slashed_price, 0, ',', '.') }}</span>
                                    @endif
                                    <div class="mt-1 flex flex-wrap items-end gap-1">
                                        <span class="pb-1 text-sm font-bold text-secondary-900 dark:text-white">Rp</span>
                                        <span class="text-3xl font-extrabold tracking-tight text-secondary-900 dark:text-white">{{ number_format($package->price, 0, ',', '.') }}</span>
                                    </div>
                                    @if($package->price > 0)
                                        <span class="mt-1 block text-[11px] text-neutral-400">{{ $package->active_period_days === 0 ? 'Aktif selamanya' : 'Aktif ' . $package->active_period_days . ' hari' }}</span>
                                    @else
                                        <span class="mt-1 block text-[11px] text-neutral-400">Coba tanpa biaya</span>
                                    @endif
                                </div>

                                <div class="mt-5 flex flex-1 flex-col">
                                    <h4 class="text-[10px] font-bold uppercase tracking-[0.16em] text-neutral-400">Fitur termasuk</h4>
                                    <ul class="mt-4 grid gap-3">
                                        @forelse($package->features as $feature)
                                            <li class="flex items-start gap-2.5 text-xs leading-5 text-neutral-600 dark:text-neutral-300">
                                                <span class="mt-0.5 flex h-4 w-4 shrink-0 items-center justify-center rounded-full bg-emerald-100 text-[8px] text-emerald-600 dark:bg-emerald-950 dark:text-emerald-400">
                                                    <i class="fa-solid fa-check" aria-hidden="true"></i>
                                                </span>
                                                <span>{{ $feature->feature_name }}</span>
                                            </li>
                                        @empty
                                            <li class="text-xs italic text-neutral-400">Fitur dasar</li>
                                        @endforelse
                                    </ul>
                                </div>

                                @auth
                                    @if($package->package_code === 'free')
                                        <div class="mt-7 flex min-h-11 items-center justify-center gap-2 rounded-xl bg-neutral-100 px-4 py-3 text-xs font-bold text-neutral-500 dark:bg-secondary-700 dark:text-neutral-300">
                                            <i class="fa-solid fa-circle-check text-emerald-500" aria-hidden="true"></i>
                                            Paket aktif
                                        </div>
                                    @else
                                        <a href="{{ route('dashboard.checkout') }}"
                                            class="mt-7 inline-flex min-h-11 items-center justify-center gap-2 rounded-xl px-4 py-3 text-xs font-bold transition focus:outline-none focus-visible:ring-4 focus-visible:ring-primary-500/20 {{ $package->is_popular ? 'bg-primary-500 text-white hover:bg-primary-600' : 'border border-primary-200 bg-primary-50 text-primary-700 hover:bg-primary-100 dark:border-primary-800 dark:bg-primary-900/20 dark:text-primary-300 dark:hover:bg-primary-900/40' }}">
                                            Pilih {{ $package->package_name }}
                                            <i class="fa-solid fa-arrow-right text-[10px]" aria-hidden="true"></i>
                                        </a>
                                    @endif
                                @else
                                    <a href="{{ route('register') }}"
                                        class="mt-7 inline-flex min-h-11 items-center justify-center gap-2 rounded-xl px-4 py-3 text-xs font-bold transition focus:outline-none focus-visible:ring-4 focus-visible:ring-primary-500/20 {{ $package->is_popular ? 'bg-primary-500 text-white hover:bg-primary-600' : 'border border-primary-200 bg-primary-50 text-primary-700 hover:bg-primary-100 dark:border-primary-800 dark:bg-primary-900/20 dark:text-primary-300 dark:hover:bg-primary-900/40' }}">
                                        {{ $package->package_code === 'free' ? 'Mulai gratis' : 'Pilih ' . $package->package_name }}
                                        <i class="fa-solid fa-arrow-right text-[10px]" aria-hidden="true"></i>
                                    </a>
                                @endauth
                            </div>
                        </article>
                    @empty
                        <div class="col-span-full rounded-3xl border border-dashed border-neutral-300 py-16 text-center dark:border-secondary-700">
                            <span class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-neutral-100 text-neutral-400 dark:bg-secondary-800">
                                <i class="fa-solid fa-box-open text-xl" aria-hidden="true"></i>
                            </span>
                            <p class="mt-4 font-bold text-secondary-900 dark:text-white">Belum ada paket tersedia</p>
                            <p class="mt-1 text-sm text-neutral-500">Silakan hubungi admin untuk informasi lebih lanjut.</p>
                        </div>
                    @endforelse
                </div>

                <p class="mt-8 flex items-center justify-center gap-2 text-center text-xs text-neutral-500 dark:text-neutral-400">
                    <i class="fa-solid fa-shield-halved text-emerald-500" aria-hidden="true"></i>
                    Pembayaran aman · Harga transparan · Dukungan tim Rayakan Digital
                </p>
            </div>
        </section>

        <section class="bg-neutral-50 px-6 py-16 dark:bg-secondary-900 sm:px-8 sm:py-20">
            <div class="grain-bg relative mx-auto max-w-5xl overflow-hidden rounded-[2rem] bg-secondary-900 px-6 py-12 text-center text-white shadow-2xl dark:border dark:border-secondary-700 sm:px-12 sm:py-16">
                <div class="orb-orange pointer-events-none absolute -left-32 -top-32 h-96 w-96" aria-hidden="true"></div>
                <div class="absolute -bottom-32 -right-20 h-72 w-72 rounded-full bg-primary-500/10 blur-3xl" aria-hidden="true"></div>
                <div class="relative z-10">
                    <span class="inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/5 px-3.5 py-2 text-[10px] font-bold uppercase tracking-[0.18em] text-primary-300">
                        <i class="fa-solid fa-heart" aria-hidden="true"></i>
                        Mulai momen Anda
                    </span>
                    <h2 class="mx-auto mt-5 max-w-2xl font-heading text-3xl font-bold sm:text-4xl">Satu undangan, begitu banyak kenangan.</h2>
                    <p class="mx-auto mt-4 max-w-xl text-sm leading-7 text-neutral-300 sm:text-base">Buat undangan pertama Anda hari ini. Gratis untuk mencoba, mudah untuk dibagikan.</p>
                    <div class="mt-8 flex flex-col justify-center gap-3 sm:flex-row">
                        <a href="{{ route('register') }}"
                            class="inline-flex min-h-12 items-center justify-center gap-2 rounded-full bg-primary-500 px-7 py-3.5 text-sm font-bold text-white shadow-lg shadow-primary-500/25 transition hover:-translate-y-0.5 hover:bg-primary-600 focus:outline-none focus-visible:ring-4 focus-visible:ring-primary-400/30 motion-reduce:transform-none">
                            Buat undangan sekarang
                            <i class="fa-solid fa-arrow-right text-xs" aria-hidden="true"></i>
                        </a>
                        <a href="https://wa.me/62895349823366?text=Halo%20Rayakan%20Digital%2C%20saya%20ingin%20konsultasi%20mengenai%20undangan%20digital."
                            target="_blank" rel="noopener noreferrer"
                            class="inline-flex min-h-12 items-center justify-center gap-2 rounded-full border border-white/20 bg-white/5 px-7 py-3.5 text-sm font-bold text-white transition hover:-translate-y-0.5 hover:bg-white/10 focus:outline-none focus-visible:ring-4 focus-visible:ring-white/20 motion-reduce:transform-none">
                            <i class="fa-brands fa-whatsapp text-base" aria-hidden="true"></i>
                            Konsultasi WhatsApp
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <x-public-footer />
</body>

</html>
