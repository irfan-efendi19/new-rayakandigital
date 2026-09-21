@php
    $commissionRate = '20';
    $discountRate = rtrim(rtrim(number_format((float) $settings['discount_rate'], 2, ',', '.'), '0'), ',');
    $minimumPayout = 'Rp '.number_format($settings['minimum_payout'], 0, ',', '.');
    $minimumPayoutRaw = (int) $settings['minimum_payout'];
    $whatsappUrl = 'https://wa.me/'.config('app.whatsapp_number', '62895349823366').'?text='.urlencode('Halo Rayakan Digital, saya ingin bertanya tentang program Reseller & Affiliate.');

    $simPackages = [
        ['name' => 'Silver', 'price' => 75000, 'popular' => false],
        ['name' => 'Gold', 'price' => 99000, 'popular' => true],
        ['name' => 'Platinum', 'price' => 299000, 'popular' => false],
    ];
    if (isset($packages) && $packages->count() > 0) {
        $simPackages = $packages->map(fn ($p) => [
            'name' => $p->package_name,
            'price' => (int) $p->price,
            'popular' => (bool) $p->is_popular,
        ])->toArray();
    }

    $tierList = [
        [
            'id' => 'starter',
            'name' => 'Starter',
            'badge' => 'Standar',
            'rate' => 20,
            'color' => 'neutral',
            'qualification' => 'Mitra Baru (1 – 10 klien/bln)',
            'description' => 'Cocok untuk creator, blogger, atau individu yang baru mulai merekomendasikan.',
            'popular' => false,
            'examples' => [
                ['qty' => 5, 'pkg' => 'Gold', 'income' => 'Rp 99.000'],
                ['qty' => 10, 'pkg' => 'Gold', 'income' => 'Rp 198.000'],
                ['qty' => 20, 'pkg' => 'Gold', 'income' => 'Rp 396.000'],
            ],
        ],
        [
            'id' => 'pro',
            'name' => 'Pro Partner',
            'badge' => 'Paling Populer',
            'rate' => 25,
            'color' => 'primary',
            'qualification' => '11 – 30 klien/bln atau Vendor Aktif',
            'description' => 'Direkomendasikan untuk vendor pernikahan (MUA, Fotografer, MC) dengan pesanan rutin.',
            'popular' => true,
            'examples' => [
                ['qty' => 15, 'pkg' => 'Gold', 'income' => 'Rp 371.250'],
                ['qty' => 25, 'pkg' => 'Gold', 'income' => 'Rp 618.750'],
                ['qty' => 30, 'pkg' => 'Gold', 'income' => 'Rp 742.500'],
            ],
        ],
        [
            'id' => 'master',
            'name' => 'Master VIP',
            'badge' => 'Wedding Organizer',
            'rate' => 30,
            'color' => 'amber',
            'qualification' => '> 30 klien/bln atau WO Resmi',
            'description' => 'Khusus Wedding Organizer, wedding planner, dan agensi dengan volume klien besar.',
            'popular' => false,
            'examples' => [
                ['qty' => 35, 'pkg' => 'Gold', 'income' => 'Rp 1.039.500'],
                ['qty' => 50, 'pkg' => 'Gold', 'income' => 'Rp 1.485.000'],
                ['qty' => 30, 'pkg' => 'Platinum', 'income' => 'Rp 2.691.000'],
            ],
        ],
    ];
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <x-meta title="Program Reseller & Affiliate Undangan Digital - Komisi Hingga 30%+ | Rayakan Digital"
        description="Dapatkan penghasilan pasif tanpa modal bersama Rayakan Digital. Komisi tinggi hingga 30%+, kupon diskon {{ $discountRate }}% untuk pelanggan, dan pencairan cepat langsung ke rekening."
        keywords="reseller undangan digital, affiliate undangan pernikahan, passive income tanpa modal, komisi affiliate terbaik, mitra rayakan digital" />
    <script>
        (() => {
            const root = document.documentElement;
            let savedTheme = null;

            try {
                savedTheme = localStorage.getItem('dark-mode');
            } catch (_) {
                // Private browsing or blocked storage should still respect the OS preference.
            }

            const dark = savedTheme === 'true'
                || (savedTheme === null && window.matchMedia('(prefers-color-scheme: dark)').matches);

            root.classList.toggle('dark', dark);
            root.style.colorScheme = dark ? 'dark' : 'light';
        })();
    </script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/landingpage.css') }}">
    <style>
        /* Hero entry animations (play on load, no scroll needed) */
        @media (prefers-reduced-motion: no-preference) {
            .hero-breadcrumb   { animation: heroFadeDown .5s ease both; animation-delay: .05s; }
            .hero-eyebrow      { animation: heroFadeUp .55s ease both;  animation-delay: .15s; }
            .hero-line-1       { animation: heroFadeUp .6s ease both;   animation-delay: .25s; }
            .hero-line-2       { animation: heroFadeUp .6s ease both;   animation-delay: .35s; }
            .hero-line-3       { animation: heroFadeUp .6s ease both;   animation-delay: .45s; }
            .hero-body         { animation: heroFadeUp .6s ease both;   animation-delay: .55s; }
            .hero-ctas         { animation: heroFadeUp .55s ease both;  animation-delay: .65s; }
            .hero-trust        { animation: heroFadeUp .5s ease both;   animation-delay: .75s; }
            .hero-card         { animation: heroSlideIn .7s cubic-bezier(.22,.68,0,1.2) both; animation-delay: .4s; }

            @keyframes heroFadeDown {
                from { opacity: 0; transform: translateY(-14px); }
                to   { opacity: 1; transform: translateY(0); }
            }
            @keyframes heroFadeUp {
                from { opacity: 0; transform: translateY(22px); }
                to   { opacity: 1; transform: translateY(0); }
            }
            @keyframes heroSlideIn {
                from { opacity: 0; transform: translateX(40px) scale(.97); }
                to   { opacity: 1; transform: translateX(0) scale(1); }
            }
        }
    </style>
</head>
<body class="bg-neutral-50 font-sans text-secondary-800 antialiased dark:bg-secondary-900 dark:text-neutral-200">
    <a href="#konten-mitra" class="sr-only focus:not-sr-only focus:fixed focus:left-4 focus:top-20 focus:z-50 focus:rounded-xl focus:bg-white focus:p-4 focus:text-secondary-900">Lewati ke konten</a>
    <x-public-navbar />
    <div class="h-16" aria-hidden="true"></div>

    <main id="konten-mitra" class="overflow-hidden">

        {{-- ═══════════════════════════ HERO ═══════════════════════════ --}}
        <section class="relative isolate border-b border-neutral-200 bg-[#FAF8F5] dark:border-secondary-700 dark:bg-secondary-900" aria-labelledby="mitra-title">

            {{-- Background decorations --}}
            <div class="pointer-events-none absolute -right-40 top-0 h-[40rem] w-[40rem] rounded-full bg-primary-200/25 blur-3xl dark:bg-primary-900/15" aria-hidden="true"></div>
            <div class="pointer-events-none absolute -left-32 bottom-0 h-[25rem] w-[25rem] rounded-full bg-primary-100/20 blur-3xl dark:bg-primary-950/10" aria-hidden="true"></div>

            {{-- Subtle grid overlay --}}
            <div class="pointer-events-none absolute inset-0 opacity-40 dark:opacity-20"
                style="background-image: linear-gradient(rgba(148,163,184,.07) 1px, transparent 1px), linear-gradient(90deg, rgba(148,163,184,.07) 1px, transparent 1px); background-size: 48px 48px;"
                aria-hidden="true"></div>

            <div class="relative mx-auto max-w-7xl px-6 py-10 sm:px-8 lg:px-12 lg:pb-24">
                {{-- Breadcrumb --}}
                <nav aria-label="Breadcrumb" class="hero-breadcrumb flex items-center gap-2 text-xs text-neutral-500 dark:text-neutral-400">
                    <a href="{{ route('home') }}" class="rounded hover:text-primary-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-primary-500">Beranda</a>
                    <span aria-hidden="true">/</span>
                    <span aria-current="page" class="text-secondary-800 dark:text-neutral-200">Reseller &amp; Affiliate</span>
                </nav>

                <div class="grid items-center gap-12 pb-6 pt-12 lg:grid-cols-[1.1fr_.9fr] lg:gap-20 lg:pt-20">
                    {{-- Left: headline --}}
                    <div class="flex flex-col items-start gap-7">
                        {{-- Eyebrow --}}
                        <div class="hero-eyebrow flex items-center gap-3">
                            <span class="relative flex h-2.5 w-2.5" aria-hidden="true">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-primary-500 opacity-75"></span>
                                <span class="relative inline-flex h-2.5 w-2.5 rounded-full bg-primary-600"></span>
                            </span>
                            <p class="text-[11px] font-bold uppercase tracking-[0.2em] text-primary-700 dark:text-primary-400">Peluang Passive Income Tanpa Modal</p>
                            <div class="h-px w-16 bg-gradient-to-r from-primary-300 to-transparent dark:from-primary-700" aria-hidden="true"></div>
                        </div>

                        <h1 id="mitra-title" class="font-heading text-4xl font-bold leading-[1.08] tracking-tight text-secondary-900 dark:text-white sm:text-5xl lg:text-6xl">
                            <span class="hero-line-1 block">Rekomendasikan Undangan,</span>
                            <span class="hero-line-2 block">Raih Komisi Menguntungkan.</span>
                            <span class="hero-line-3 block italic text-primary-600 dark:text-primary-400">Hingga 30%+ Per Penjualan.</span>
                        </h1>

                        <p class="hero-body max-w-lg text-base leading-8 text-neutral-600 dark:text-neutral-300">
                            Ubah relasi dan jaringan Anda menjadi sumber penghasilan tambahan yang nyata. Cukup bagikan link referral atau kupon diskon eksklusif ke calon pengantin, komisi otomatis langsung cair ke rekening bank Anda.
                        </p>

                        <div class="hero-ctas flex w-full flex-col gap-3 sm:w-auto sm:flex-row">
                            <a href="{{ route('dashboard.affiliate.index') }}" class="inline-flex min-h-12 items-center justify-center gap-3 rounded-full bg-primary-600 px-8 py-3.5 text-sm font-bold text-white shadow-lg shadow-primary-500/25 transition hover:bg-primary-700 hover:shadow-primary-500/30 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-primary-500">
                                {{ auth()->check() ? 'Buka Dashboard Mitra' : 'Daftar Jadi Mitra Sekarang (Gratis)' }}
                                <i class="fa-solid fa-arrow-right text-xs" aria-hidden="true"></i>
                            </a>
                            <a href="#perhitungan-tier" class="inline-flex min-h-12 items-center justify-center gap-2 rounded-full border border-neutral-300 px-7 py-3.5 text-sm font-semibold transition hover:border-primary-400 hover:bg-primary-50 hover:text-primary-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-primary-500 dark:border-secondary-600 dark:hover:border-primary-600 dark:hover:bg-primary-900/20 dark:hover:text-primary-400">
                                <i class="fa-solid fa-calculator text-xs text-primary-500" aria-hidden="true"></i>
                                <span>Hitung Potensi Cuan</span>
                            </a>
                        </div>

                        <div class="hero-trust flex flex-wrap items-center gap-x-5 gap-y-2 text-xs text-neutral-500 dark:text-neutral-400">
                            <span class="flex items-center gap-1.5">
                                <i class="fa-regular fa-circle-check text-emerald-500 dark:text-emerald-400" aria-hidden="true"></i>
                                100% Gratis Tanpa Modal
                            </span>
                            <span class="hidden h-3.5 w-px bg-neutral-300 dark:bg-secondary-600 sm:block" aria-hidden="true"></span>
                            <span class="flex items-center gap-1.5">
                                <i class="fa-regular fa-circle-check text-emerald-500 dark:text-emerald-400" aria-hidden="true"></i>
                                Komisi Tertinggi 20% – 30%+
                            </span>
                            <span class="hidden h-3.5 w-px bg-neutral-300 dark:bg-secondary-600 sm:block" aria-hidden="true"></span>
                            <span class="flex items-center gap-1.5">
                                <i class="fa-regular fa-circle-check text-emerald-500 dark:text-emerald-400" aria-hidden="true"></i>
                                Pencairan Cepat ke Bank
                            </span>
                        </div>
                    </div>

                    {{-- Right: stat card --}}
                    <aside aria-label="Ringkasan program kemitraan" class="hero-card relative mx-auto w-full max-w-lg">
                        <div class="absolute inset-0 rotate-2 rounded-[2rem] bg-gradient-to-br from-primary-300 to-primary-200 dark:from-primary-800/60 dark:to-primary-900/40" aria-hidden="true"></div>
                        <div class="relative overflow-hidden rounded-[2rem] border border-neutral-200/80 bg-white p-6 shadow-xl shadow-secondary-900/8 dark:border-secondary-700 dark:bg-secondary-800 sm:p-8">

                            {{-- Card header --}}
                            <div class="flex items-center justify-between gap-3 border-b border-neutral-100 pb-5 dark:border-secondary-700">
                                <div class="flex items-center gap-3">
                                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-primary-50 dark:bg-primary-900/30">
                                        <img src="{{ asset('img/logo.png') }}" alt="" class="h-7 w-7 object-contain">
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-secondary-900 dark:text-white">Rayakan Partners</p>
                                        <p class="text-xs text-neutral-500 dark:text-neutral-400">Peluang Cuan Tanpa Ribet</p>
                                    </div>
                                </div>
                                <span class="flex h-9 w-9 items-center justify-center rounded-full bg-primary-50 dark:bg-primary-900/30">
                                    <i class="fa-solid fa-arrow-trend-up text-base text-primary-600 dark:text-primary-400" aria-hidden="true"></i>
                                </span>
                            </div>

                            {{-- Commission highlight --}}
                            <div class="flex flex-col gap-2 py-7">
                                <p class="text-xs font-semibold uppercase tracking-widest text-neutral-500 dark:text-neutral-400">Komisi Mulai Dari</p>
                                <p class="font-heading text-7xl font-extrabold tracking-tight text-primary-600 dark:text-primary-400">
                                    {{ $commissionRate }}<span class="text-4xl">%</span>
                                </p>
                                <p class="max-w-xs text-sm leading-6 text-neutral-500 dark:text-neutral-400">Bisa meningkat hingga 30%+ per transaksi sukses sesuai pencapaian Anda.</p>
                            </div>

                            {{-- Mini stats --}}
                            <dl class="grid grid-cols-2 gap-3">
                                <div class="flex flex-col gap-1.5 rounded-2xl bg-neutral-50 p-4 ring-1 ring-neutral-100 dark:bg-secondary-900 dark:ring-secondary-700">
                                    <dt class="text-xs text-neutral-500 dark:text-neutral-400">Diskon kupon klien*</dt>
                                    <dd class="text-2xl font-bold text-secondary-900 dark:text-white">{{ $discountRate }}%</dd>
                                </div>
                                <div class="flex flex-col gap-1.5 rounded-2xl bg-neutral-50 p-4 ring-1 ring-neutral-100 dark:bg-secondary-900 dark:ring-secondary-700">
                                    <dt class="text-xs text-neutral-500 dark:text-neutral-400">Min. pencairan dana</dt>
                                    <dd class="text-lg font-bold text-secondary-900 dark:text-white sm:text-xl">{{ $minimumPayout }}</dd>
                                </div>
                            </dl>

                            {{-- Tag line --}}
                            <div class="mt-5 flex items-center gap-3 rounded-xl bg-primary-50 px-4 py-3 dark:bg-primary-900/20">
                                <i class="fa-solid fa-bolt text-primary-600 dark:text-primary-400" aria-hidden="true"></i>
                                <p class="text-xs font-semibold leading-5 text-primary-800 dark:text-primary-300">Bagikan Link &amp; Kupon · Komisi Otomatis Cair</p>
                            </div>

                            <p class="mt-4 text-[11px] leading-5 text-neutral-400 dark:text-neutral-500">Tarif komisi dapat meningkat sesuai tier volume Anda. *Kupon memberikan potongan langsung bagi pembeli.</p>
                        </div>
                    </aside>
                </div>
            </div>
        </section>

        {{-- ═══════════════════════════ TRUST STRIP ═══════════════════════════ --}}
        <div class="border-b border-neutral-200 bg-white dark:border-secondary-700 dark:bg-secondary-800/60" aria-label="Ringkasan program">
            <div class="mx-auto max-w-7xl px-6 py-5 sm:px-8 lg:px-12">
                <dl class="grid grid-cols-2 gap-6 sm:flex sm:items-center sm:justify-around">
                    @foreach([
                        ['icon' => 'fa-user-check', 'value' => '100% Gratis', 'label' => 'Pendaftaran tanpa modal'],
                        ['icon' => 'fa-percent', 'value' => $commissionRate.'% – 30%+', 'label' => 'Komisi per transaksi'],
                        ['icon' => 'fa-money-bill-transfer', 'value' => $minimumPayout, 'label' => 'Batas minimum pencairan'],
                        ['icon' => 'fa-bolt', 'value' => 'Cepat & Aman', 'label' => 'Transfer langsung ke rekening'],
                    ] as $i => $stat)
                        <div class="flex items-center gap-3"
                            data-aos="fade-up"
                            data-aos-delay="{{ $i * 80 }}">
                            <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-primary-50 text-primary-600 dark:bg-primary-900/30 dark:text-primary-400">
                                <i class="fa-solid {{ $stat['icon'] }} text-sm" aria-hidden="true"></i>
                            </span>
                            <div>
                                <dt class="text-[11px] text-neutral-500 dark:text-neutral-400">{{ $stat['label'] }}</dt>
                                <dd class="text-sm font-bold text-secondary-900 dark:text-white">{{ $stat['value'] }}</dd>
                            </div>
                        </div>
                    @endforeach
                </dl>
            </div>
        </div>

        {{-- ═══════════════════════════ UNTUK SIAPA ═══════════════════════════ --}}
        <section class="mx-auto max-w-7xl px-6 py-16 sm:px-8 lg:px-12 lg:py-24" aria-labelledby="untuk-siapa">
            <div class="grid gap-8 lg:grid-cols-[.8fr_1.2fr] lg:gap-16">
                <div class="flex flex-col items-start gap-5" data-aos="fade-right">
                    <p class="text-xs font-bold uppercase tracking-[0.18em] text-primary-700 dark:text-primary-400">Peluang Cuan Tanpa Batas</p>
                    <h2 id="untuk-siapa" class="font-heading text-3xl font-bold leading-tight text-secondary-900 dark:text-white sm:text-4xl">Siapa Saja yang Bisa<br>Cuan Bersama Kami?</h2>
                    <p class="max-w-md text-sm leading-7 text-neutral-600 dark:text-neutral-400">Punya klien pernikahan, audiens media sosial, atau teman yang sedang menyiapkan pernikahan? Anda sudah memiliki modal utama untuk mulai mencetak passive income hari ini.</p>
                    <a href="{{ route('undangan-web') }}" class="group inline-flex items-center gap-2 rounded text-sm font-bold text-primary-700 hover:text-primary-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-primary-500 dark:text-primary-400">
                        Lihat produk undangan yang mudah dijual
                        <i class="fa-solid fa-arrow-right text-xs transition-transform group-hover:translate-x-0.5" aria-hidden="true"></i>
                    </a>
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    {{-- Reseller card --}}
                    <article class="group flex flex-col gap-4 rounded-2xl border border-neutral-200 bg-white p-6 transition hover:border-primary-200 hover:shadow-md hover:shadow-primary-100/50 dark:border-secondary-700 dark:bg-secondary-800 dark:hover:border-primary-800 dark:hover:shadow-primary-900/20"
                        data-aos="fade-up" data-aos-delay="0">
                        <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-primary-50 text-primary-600 transition group-hover:bg-primary-100 dark:bg-primary-900/30 dark:text-primary-400 dark:group-hover:bg-primary-900/50">
                            <i class="fa-solid fa-handshake text-lg" aria-hidden="true"></i>
                        </span>
                        <div class="flex flex-col gap-2">
                            <h3 class="text-xl font-bold text-secondary-900 dark:text-white">Vendor Pernikahan &amp; WO</h3>
                            <p class="text-sm leading-7 text-neutral-600 dark:text-neutral-400">Tambah sumber profit baru tanpa beban operasional. Cukup bundle atau tawarkan undangan digital elegan kami ke klien Anda dan nikmati komisi hingga 30%+ per transaksi.</p>
                        </div>
                        <div class="mt-auto flex flex-wrap gap-1.5 border-t border-neutral-100 pt-4 dark:border-secondary-700">
                            @foreach(['Wedding Organizer', 'MUA & Stylist', 'Fotografer', 'Venue & Dekorasi', 'MC'] as $tag)
                                <span class="rounded-full bg-neutral-100 px-2.5 py-0.5 text-[11px] font-medium text-neutral-600 dark:bg-secondary-700 dark:text-neutral-300">{{ $tag }}</span>
                            @endforeach
                            <span class="rounded-full bg-neutral-100 px-2.5 py-0.5 text-[11px] font-medium text-neutral-500 dark:bg-secondary-700 dark:text-neutral-400">+ vendor lainnya</span>
                        </div>
                    </article>

                    {{-- Affiliate card --}}
                    <article class="group flex flex-col gap-4 rounded-2xl border border-neutral-200 bg-white p-6 transition hover:border-emerald-200 hover:shadow-md hover:shadow-emerald-100/50 dark:border-secondary-700 dark:bg-secondary-800 dark:hover:border-emerald-800 dark:hover:shadow-emerald-900/20"
                        data-aos="fade-up" data-aos-delay="120">
                        <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-50 text-emerald-700 transition group-hover:bg-emerald-100 dark:bg-emerald-900/20 dark:text-emerald-400 dark:group-hover:bg-emerald-900/40">
                            <i class="fa-solid fa-bullhorn text-lg" aria-hidden="true"></i>
                        </span>
                        <div class="flex flex-col gap-2">
                            <h3 class="text-xl font-bold text-secondary-900 dark:text-white">Affiliate, Creator &amp; Umum</h3>
                            <p class="text-sm leading-7 text-neutral-600 dark:text-neutral-400">Monetisasi audiens atau lingkaran pertemanan Anda. Bagikan link referral &amp; kupon diskon {{ $discountRate }}% — saat calon pengantin hemat, komisi Anda otomatis mengalir deras.</p>
                        </div>
                        <div class="mt-auto flex flex-wrap gap-1.5 border-t border-neutral-100 pt-4 dark:border-secondary-700">
                            @foreach(['Content Creator', 'Komunitas', 'Blogger', 'Teman Calon Pengantin'] as $tag)
                                <span class="rounded-full bg-neutral-100 px-2.5 py-0.5 text-[11px] font-medium text-neutral-600 dark:bg-secondary-700 dark:text-neutral-300">{{ $tag }}</span>
                            @endforeach
                            <span class="rounded-full bg-neutral-100 px-2.5 py-0.5 text-[11px] font-medium text-neutral-500 dark:bg-secondary-700 dark:text-neutral-400">+ siapa saja</span>
                        </div>
                    </article>
                </div>
            </div>
        </section>

        {{-- ═══════════════════════════ MANFAAT / BENEFITS ═══════════════════════════ --}}
        <section class="border-y border-neutral-200 bg-white dark:border-secondary-700 dark:bg-secondary-800/40" aria-labelledby="manfaat-mitra">
            <div class="mx-auto max-w-7xl px-6 py-16 sm:px-8 lg:px-12 lg:py-20">
                <div class="flex max-w-2xl flex-col gap-4" data-aos="fade-up">
                    <p class="text-xs font-bold uppercase tracking-[0.18em] text-primary-700 dark:text-primary-400">Fasilitas &amp; Amunisi Penjualan</p>
                    <h2 id="manfaat-mitra" class="font-heading text-3xl font-bold text-secondary-900 dark:text-white sm:text-4xl">Semua Amunisi Terbaik untuk Meledakkan Komisi Anda.</h2>
                </div>
                <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach([
                        ['icon' => 'fa-link', 'color' => 'primary', 'title' => 'Link Referral Akurat', 'text' => 'Dapatkan link unik dengan sistem pelacakan otomatis real-time. Setiap klik dan konversi tercatat presisi tanpa resiko tercecer.'],
                        ['icon' => 'fa-ticket', 'color' => 'amber', 'title' => 'Kupon Diskon '.$discountRate.'% Spesial', 'text' => 'Senjata ampuh penutup closing! Klien Anda senang dapat diskon instan '.$discountRate.'%, dan Anda langsung mengantongi komisi penjualan.'],
                        ['icon' => 'fa-chart-simple', 'color' => 'emerald', 'title' => 'Dashboard Transparan 24/7', 'text' => 'Pantau pertumbuhan saldo, riwayat transaksi, dan performa link referral Anda kapan pun dengan transparansi 100%.'],
                        ['icon' => 'fa-wallet', 'color' => 'blue', 'title' => 'Pencairan Kilat ke Rekening', 'text' => 'Tarik hasil keuntungan Anda mulai '.$minimumPayout.' langsung ke rekening bank lokal pilihan Anda dengan proses cepat & aman.'],
                    ] as $i => $benefit)
                        @php
                            $colorMap = [
                                'primary' => ['bg' => 'bg-primary-50 dark:bg-primary-900/30', 'text' => 'text-primary-600 dark:text-primary-400', 'border' => 'group-hover:border-primary-200 dark:group-hover:border-primary-800'],
                                'amber'   => ['bg' => 'bg-amber-50 dark:bg-amber-900/20', 'text' => 'text-amber-600 dark:text-amber-400', 'border' => 'group-hover:border-amber-200 dark:group-hover:border-amber-800'],
                                'emerald' => ['bg' => 'bg-emerald-50 dark:bg-emerald-900/20', 'text' => 'text-emerald-600 dark:text-emerald-400', 'border' => 'group-hover:border-emerald-200 dark:group-hover:border-emerald-800'],
                                'blue'    => ['bg' => 'bg-blue-50 dark:bg-blue-900/20', 'text' => 'text-blue-600 dark:text-blue-400', 'border' => 'group-hover:border-blue-200 dark:group-hover:border-blue-800'],
                            ];
                            $c = $colorMap[$benefit['color']];
                        @endphp
                        <article class="group flex flex-col gap-5 rounded-2xl border border-neutral-200 bg-neutral-50 p-6 transition hover:shadow-sm dark:border-secondary-700 dark:bg-secondary-900/40 {{ $c['border'] }}"
                            data-aos="fade-up"
                            data-aos-delay="{{ $i * 100 }}">
                            <span class="flex h-11 w-11 items-center justify-center rounded-xl {{ $c['bg'] }} {{ $c['text'] }}">
                                <i class="fa-solid {{ $benefit['icon'] }} text-lg" aria-hidden="true"></i>
                            </span>
                            <div class="flex flex-col gap-2">
                                <h3 class="text-base font-bold text-secondary-900 dark:text-white">{{ $benefit['title'] }}</h3>
                                <p class="text-sm leading-7 text-neutral-600 dark:text-neutral-400">{{ $benefit['text'] }}</p>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- ═══════════════════════════ CONTOH PERHITUNGAN TIAP TIER ═══════════════════════════ --}}
        <section id="perhitungan-tier" class="scroll-mt-24 border-b border-neutral-200 bg-[#FAF8F5] dark:border-secondary-700 dark:bg-secondary-900 py-16 sm:py-20 lg:py-24" aria-labelledby="perhitungan-tier-title">
            <div class="mx-auto max-w-7xl px-6 sm:px-8 lg:px-12">

                {{-- Header --}}
                <div class="flex flex-col items-center gap-4 text-center max-w-3xl mx-auto" data-aos="fade-up">
                    <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-[0.2em] text-primary-700 dark:text-primary-400">
                        <span class="flex h-2 w-2 rounded-full bg-primary-500" aria-hidden="true"></span>
                        Simulasi &amp; Transparansi Komisi
                    </div>
                    <h2 id="perhitungan-tier-title" class="font-heading text-3xl font-bold leading-tight text-secondary-900 dark:text-white sm:text-4xl lg:text-5xl">
                        Contoh Perhitungan Tiap Tier Reseller
                    </h2>
                    <p class="text-sm sm:text-base leading-7 text-neutral-600 dark:text-neutral-400">
                        Skema komisi berjenjang yang transparan dan menguntungkan. Semakin banyak rekomendasi yang berhasil, semakin besar persentase komisi hingga 30%+ yang langsung masuk ke rekening Anda.
                    </p>
                </div>

                {{-- Tier Cards Grid --}}
                <div class="mt-14 grid gap-8 lg:grid-cols-3 items-stretch">
                    @foreach($tierList as $tier)
                        @php
                            $isPopular = $tier['popular'];
                        @endphp
                        <div class="relative flex flex-col justify-between rounded-3xl border bg-white p-7 shadow-sm transition-all duration-300 hover:shadow-lg dark:bg-secondary-800 {{ $isPopular ? 'border-primary-500 ring-2 ring-primary-500/20 shadow-primary-500/10 lg:-translate-y-2' : 'border-neutral-200 dark:border-secondary-700' }}"
                            data-aos="fade-up"
                            data-aos-delay="{{ $loop->index * 120 }}">

                            @if($isPopular)
                                <div class="absolute -top-3.5 left-1/2 -translate-x-1/2 rounded-full bg-primary-600 px-4 py-1 text-[11px] font-bold uppercase tracking-wider text-white shadow-md">
                                    {{ $tier['badge'] }}
                                </div>
                            @endif

                            <div>
                                {{-- Card Top --}}
                                <div class="flex items-center justify-between gap-3 border-b border-neutral-100 pb-5 dark:border-secondary-700">
                                    <div>
                                        <div class="flex items-center gap-2">
                                            <h3 class="font-heading text-2xl font-bold text-secondary-900 dark:text-white">{{ $tier['name'] }}</h3>
                                            @if(!$isPopular)
                                                <span class="rounded-full bg-neutral-100 px-2.5 py-0.5 text-[10px] font-semibold text-neutral-600 dark:bg-secondary-700 dark:text-neutral-300">{{ $tier['badge'] }}</span>
                                            @endif
                                        </div>
                                        <p class="mt-1 text-xs text-neutral-500 dark:text-neutral-400">{{ $tier['qualification'] }}</p>
                                    </div>
                                    <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl {{ $isPopular ? 'bg-primary-100 text-primary-600 dark:bg-primary-900/40 dark:text-primary-400' : 'bg-neutral-100 text-neutral-600 dark:bg-secondary-700 dark:text-neutral-300' }}">
                                        <i class="fa-solid {{ $isPopular ? 'fa-crown' : ($tier['id'] === 'master' ? 'fa-gem' : 'fa-seedling') }} text-lg" aria-hidden="true"></i>
                                    </div>
                                </div>

                                {{-- Commission Rate Display --}}
                                <div class="py-6">
                                    <p class="text-xs font-semibold uppercase tracking-wider text-neutral-500 dark:text-neutral-400">Komisi per transaksi</p>
                                    <div class="mt-1 flex items-baseline gap-1">
                                        <span class="font-heading text-5xl font-extrabold text-secondary-900 dark:text-white">{{ $tier['rate'] }}%</span>
                                        <span class="text-xs font-medium text-neutral-500 dark:text-neutral-400">/ penjualan</span>
                                    </div>
                                    <p class="mt-2 text-xs leading-5 text-neutral-500 dark:text-neutral-400">{{ $tier['description'] }}</p>
                                </div>

                                {{-- Real Calculation Examples Box --}}
                                <div class="rounded-2xl bg-neutral-50 p-4 ring-1 ring-neutral-100 dark:bg-secondary-900/60 dark:ring-secondary-700/60">
                                    <p class="text-[11px] font-bold uppercase tracking-wider text-neutral-600 dark:text-neutral-300">
                                        <i class="fa-solid fa-calculator text-primary-600 mr-1.5 dark:text-primary-400" aria-hidden="true"></i>
                                        Contoh Perhitungan:
                                    </p>
                                    <ul class="mt-3 divide-y divide-neutral-200/70 text-xs dark:divide-secondary-700/70">
                                        @foreach($tier['examples'] as $example)
                                            <li class="flex items-center justify-between py-2 text-neutral-700 dark:text-neutral-300">
                                                <span>{{ $example['qty'] }} klien (Paket {{ $example['pkg'] }})</span>
                                                <span class="font-bold text-emerald-600 dark:text-emerald-400">{{ $example['income'] }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Interactive Calculator Box --}}
                <div class="mt-16 overflow-hidden rounded-3xl border border-neutral-200 bg-white shadow-xl dark:border-secondary-700 dark:bg-secondary-800"
                    data-aos="fade-up"
                    x-data="{
                        tierRate: 25,
                        tierName: 'Pro Partner',
                        packagePrice: 99000,
                        packageName: 'Gold',
                        volume: 15,
                        minimumPayout: {{ $minimumPayoutRaw }},
                        setTier(rate, name) {
                            this.tierRate = rate;
                            this.tierName = name;
                        },
                        setPackage(price, name) {
                            this.packagePrice = price;
                            this.packageName = name;
                        },
                        formatRp(val) {
                            return 'Rp ' + Number(Math.round(val)).toLocaleString('id-ID');
                        },
                        get commissionPerItem() {
                            return (this.packagePrice * this.tierRate) / 100;
                        },
                        get monthlyCommission() {
                            return this.commissionPerItem * this.volume;
                        },
                        get yearlyCommission() {
                            return this.monthlyCommission * 12;
                        },
                        get meetsMinimum() {
                            return this.monthlyCommission >= this.minimumPayout;
                        }
                    }">
                    <div class="grid lg:grid-cols-[1.2fr_.8fr]">
                        {{-- Calculator Controls --}}
                        <div class="p-6 sm:p-10 lg:p-12">
                            <div class="flex items-center gap-2.5">
                                <span class="flex h-8 w-8 items-center justify-center rounded-xl bg-primary-100 text-primary-600 dark:bg-primary-900/40 dark:text-primary-400">
                                    <i class="fa-solid fa-calculator text-sm" aria-hidden="true"></i>
                                </span>
                                <h3 class="font-heading text-xl sm:text-2xl font-bold text-secondary-900 dark:text-white">
                                    Kalkulator Simulasi Penghasilan &amp; Potensi Cuan
                                </h3>
                            </div>
                            <p class="mt-2 text-xs sm:text-sm text-neutral-500 dark:text-neutral-400">
                                Geser jumlah pesanan dan pilih paket di bawah untuk membuktikan seberapa cepat saldo rekening Anda bertambah hanya dari rekomendasi.
                            </p>

                            <div class="mt-8 space-y-7">
                                {{-- 1. Tier Selector --}}
                                <div>
                                    <label class="block text-xs font-bold uppercase tracking-wider text-neutral-600 dark:text-neutral-300">
                                        1. Pilih Tier Reseller Anda
                                    </label>
                                    <div class="mt-3 grid grid-cols-3 gap-2.5 sm:gap-3">
                                        @foreach($tierList as $t)
                                            <button type="button"
                                                @click="setTier({{ $t['rate'] }}, '{{ $t['name'] }}')"
                                                :class="tierRate === {{ $t['rate'] }} ? 'border-primary-500 bg-primary-50/70 text-primary-700 ring-2 ring-primary-500/20 dark:bg-primary-900/30 dark:text-primary-300' : 'border-neutral-200 bg-white text-secondary-700 hover:border-neutral-300 dark:border-secondary-700 dark:bg-secondary-900 dark:text-neutral-300'"
                                                class="flex flex-col items-center justify-center rounded-2xl border p-3 text-center transition">
                                                <span class="text-xs font-bold">{{ $t['name'] }}</span>
                                                <span class="mt-1 text-sm font-extrabold">{{ $t['rate'] }}%</span>
                                            </button>
                                        @endforeach
                                    </div>
                                </div>

                                {{-- 2. Package Selector --}}
                                <div>
                                    <label class="block text-xs font-bold uppercase tracking-wider text-neutral-600 dark:text-neutral-300">
                                        2. Pilih Paket Undangan yang Direkomendasikan
                                    </label>
                                    <div class="mt-3 grid grid-cols-3 gap-2.5 sm:gap-3">
                                        @foreach($simPackages as $pkg)
                                            <button type="button"
                                                @click="setPackage({{ $pkg['price'] }}, '{{ $pkg['name'] }}')"
                                                :class="packageName === '{{ $pkg['name'] }}' ? 'border-primary-500 bg-primary-50/70 text-primary-700 ring-2 ring-primary-500/20 dark:bg-primary-900/30 dark:text-primary-300' : 'border-neutral-200 bg-white text-secondary-700 hover:border-neutral-300 dark:border-secondary-700 dark:bg-secondary-900 dark:text-neutral-300'"
                                                class="flex flex-col items-center justify-center rounded-2xl border p-3 text-center transition">
                                                <div class="flex items-center gap-1">
                                                    <span class="text-xs font-bold">{{ $pkg['name'] }}</span>
                                                    @if($pkg['popular'])
                                                        <span class="h-1.5 w-1.5 rounded-full bg-primary-500"></span>
                                                    @endif
                                                </div>
                                                <span class="mt-1 text-xs sm:text-sm font-extrabold">Rp {{ number_format($pkg['price'], 0, ',', '.') }}</span>
                                            </button>
                                        @endforeach
                                    </div>
                                </div>

                                {{-- 3. Volume Slider --}}
                                <div>
                                    <div class="flex items-center justify-between">
                                        <label for="volume-range" class="text-xs font-bold uppercase tracking-wider text-neutral-600 dark:text-neutral-300">
                                            3. Perkiraan Undangan Terjual per Bulan
                                        </label>
                                        <span class="rounded-xl bg-primary-500/10 px-3 py-1 font-heading text-lg font-extrabold text-primary-600 dark:text-primary-400"
                                            x-text="volume + ' Undangan'">
                                            15 Undangan
                                        </span>
                                    </div>
                                    <div class="mt-4">
                                        <input id="volume-range" type="range" min="1" max="60" step="1" x-model.number="volume"
                                            class="h-2.5 w-full cursor-pointer appearance-none rounded-lg bg-neutral-200 accent-primary-600 dark:bg-secondary-700"
                                            aria-label="Jumlah undangan per bulan">
                                    </div>
                                    {{-- Quick Chips --}}
                                    <div class="mt-3 flex flex-wrap items-center gap-2">
                                        <span class="text-[11px] text-neutral-500 dark:text-neutral-400">Pilihan cepat:</span>
                                        <template x-for="chip in [5, 10, 15, 20, 30, 50]" :key="chip">
                                            <button type="button" @click="volume = chip"
                                                :class="volume === chip ? 'bg-primary-600 text-white font-bold' : 'bg-neutral-100 text-neutral-600 hover:bg-neutral-200 dark:bg-secondary-700 dark:text-neutral-300'"
                                                class="rounded-lg px-2.5 py-1 text-xs transition"
                                                x-text="chip + ' klien'">
                                            </button>
                                        </template>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Calculation Results Display --}}
                        <div class="flex flex-col justify-between border-t border-neutral-200 bg-secondary-900 p-6 text-white dark:border-secondary-700 lg:border-l lg:border-t-0 sm:p-10 lg:p-12">
                            <div>
                                <div class="flex items-center justify-between">
                                    <span class="text-[11px] font-bold uppercase tracking-widest text-primary-400">Hasil Simulasi Keuntungan</span>
                                    <span class="rounded-full bg-white/10 px-3 py-1 text-[11px] font-medium text-neutral-300">
                                        Tier <strong class="text-white" x-text="tierName">Pro Partner</strong> (<span x-text="tierRate + '%'">25%</span>)
                                    </span>
                                </div>

                                {{-- Main Highlight: Monthly Commission --}}
                                <div class="mt-6 rounded-2xl bg-white/5 p-6 ring-1 ring-white/10 backdrop-blur-sm">
                                    <p class="text-xs font-medium text-neutral-400">Estimasi Passive Income Bulanan</p>
                                    <p class="mt-2 font-heading text-4xl sm:text-5xl font-extrabold tracking-tight text-primary-400"
                                        x-text="formatRp(monthlyCommission)">
                                        Rp 371.250
                                    </p>
                                    <p class="mt-2 text-xs text-neutral-300">
                                        Dari <span class="font-bold text-white" x-text="volume">15</span> transaksi Paket <span class="font-bold text-white" x-text="packageName">Gold</span> per bulan
                                    </p>
                                </div>

                                {{-- Sub Details --}}
                                <dl class="mt-5 grid grid-cols-2 gap-3">
                                    <div class="rounded-xl bg-white/5 p-4 ring-1 ring-white/10">
                                        <dt class="text-[11px] text-neutral-400">Komisi Bersih per Undangan</dt>
                                        <dd class="mt-1 text-base font-bold text-white" x-text="formatRp(commissionPerItem)">
                                            Rp 24.750
                                        </dd>
                                    </div>
                                    <div class="rounded-xl bg-white/5 p-4 ring-1 ring-white/10">
                                        <dt class="text-[11px] text-neutral-400">Potensi Cuan 1 Tahun (Passive)</dt>
                                        <dd class="mt-1 text-base font-bold text-emerald-400" x-text="formatRp(yearlyCommission)">
                                            Rp 4.455.000
                                        </dd>
                                    </div>
                                </dl>

                                {{-- Minimum Payout Indicator --}}
                                <div class="mt-5 flex items-center gap-2.5 rounded-xl px-4 py-3 text-xs"
                                    :class="meetsMinimum ? 'bg-emerald-500/10 text-emerald-300 ring-1 ring-emerald-500/20' : 'bg-amber-500/10 text-amber-300 ring-1 ring-amber-500/20'">
                                    <i class="fa-solid shrink-0" :class="meetsMinimum ? 'fa-circle-check text-emerald-400' : 'fa-circle-info text-amber-400'" aria-hidden="true"></i>
                                    <span x-show="meetsMinimum">
                                        Saldo bulanan melebihi batas minimum pencairan ({{ $minimumPayout }}). Dapat langsung dicairkan ke rekening!
                                    </span>
                                    <span x-show="!meetsMinimum">
                                        Akumulasikan hingga {{ $minimumPayout }} untuk mengajukan pencairan dana ke rekening Anda.
                                    </span>
                                </div>
                            </div>

                            <div class="mt-8 pt-4">
                                <a href="{{ route('dashboard.affiliate.index') }}"
                                    class="flex w-full min-h-12 items-center justify-center gap-2 rounded-xl bg-primary-600 px-6 py-3.5 text-sm font-bold text-white shadow-lg shadow-primary-600/30 transition hover:bg-primary-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary-400">
                                    <span>Ambil Peluang &amp; Raih Komisi Ini</span>
                                    <i class="fa-solid fa-arrow-right text-xs" aria-hidden="true"></i>
                                </a>
                                <p class="mt-2.5 text-center text-[11px] text-neutral-400">
                                    100% Gratis Tanpa Modal · Transfer Langsung ke Rekening Anda
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Quick Reference Matrix Table --}}
                <div class="mt-16" data-aos="fade-up">
                    <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-2 mb-6">
                        <div>
                            <h3 class="font-heading text-xl font-bold text-secondary-900 dark:text-white">
                                Tabel Matriks Komisi per Transaksi
                            </h3>
                            <p class="text-xs text-neutral-500 dark:text-neutral-400">
                                Rincian uang tunai yang langsung masuk ke dompet Anda untuk setiap paket undangan yang lunas terjual.
                            </p>
                        </div>
                        <span class="text-[11px] font-medium text-neutral-400">
                            *Dihitung dari nilai transaksi berhasil
                        </span>
                    </div>

                    <div class="overflow-x-auto rounded-2xl border border-neutral-200 bg-white shadow-sm dark:border-secondary-700 dark:bg-secondary-800">
                        <table class="w-full text-left text-sm">
                            <thead class="border-b border-neutral-200 bg-neutral-50 text-xs font-bold uppercase tracking-wider text-secondary-700 dark:border-secondary-700 dark:bg-secondary-900/90 dark:text-neutral-300">
                                <tr>
                                    <th scope="col" class="px-6 py-4 dark:text-neutral-200">Paket Undangan</th>
                                    <th scope="col" class="px-6 py-4 dark:text-neutral-200">Harga Paket</th>
                                    @foreach($tierList as $tier)
                                        <th scope="col" class="px-6 py-4 text-center {{ $tier['popular'] ? 'bg-primary-50/70 dark:bg-primary-900/30 text-primary-700 dark:text-primary-300' : 'dark:text-neutral-200' }}">
                                            {{ $tier['name'] }}
                                            <span class="ml-1 rounded-full px-2 py-0.5 text-[10px] {{ $tier['popular'] ? 'bg-primary-600 text-white dark:bg-primary-500' : ($tier['id'] === 'master' ? 'bg-amber-100 text-amber-800 dark:bg-amber-900/40 dark:text-amber-300' : 'bg-neutral-200 text-neutral-700 dark:bg-secondary-700 dark:text-neutral-300') }}">
                                                {{ $tier['rate'] }}%
                                            </span>
                                        </th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-neutral-200 dark:divide-secondary-700 text-secondary-800 dark:text-neutral-200">
                                @foreach($simPackages as $pkg)
                                    <tr class="hover:bg-neutral-50/80 dark:hover:bg-secondary-700/50 transition">
                                        <th scope="row" class="px-6 py-4 font-bold text-secondary-900 dark:text-white">
                                            <div class="flex items-center gap-2">
                                                <span>{{ $pkg['name'] }}</span>
                                                @if($pkg['popular'])
                                                    <span class="rounded-full bg-primary-100 px-2 py-0.5 text-[10px] font-semibold text-primary-700 dark:bg-primary-900/50 dark:text-primary-300">Favorit</span>
                                                @endif
                                            </div>
                                        </th>
                                        <td class="px-6 py-4 text-neutral-600 dark:text-neutral-300 font-medium">
                                            Rp {{ number_format($pkg['price'], 0, ',', '.') }}
                                        </td>
                                        @foreach($tierList as $tier)
                                            <td class="px-6 py-4 text-center {{ $tier['popular'] ? 'font-bold text-primary-600 dark:text-primary-400 bg-primary-50/40 dark:bg-primary-900/20' : ($tier['id'] === 'master' ? 'font-bold text-emerald-600 dark:text-emerald-400' : 'font-semibold text-neutral-700 dark:text-neutral-300') }}">
                                                Rp {{ number_format(round($pkg['price'] * ($tier['rate'] / 100)), 0, ',', '.') }}
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </section>

        {{-- ═══════════════════════════ CARA BERGABUNG ═══════════════════════════ --}}
        <section id="cara-bergabung" class="mx-auto max-w-7xl scroll-mt-24 px-6 py-16 sm:px-8 lg:px-12 lg:py-24" aria-labelledby="cara-title">
            <div class="flex flex-col items-center gap-4 text-center" data-aos="fade-up">
                <p class="text-xs font-bold uppercase tracking-[0.18em] text-primary-700 dark:text-primary-400">Proses Cepat &amp; Praktis</p>
                <h2 id="cara-title" class="font-heading text-3xl font-bold text-secondary-900 dark:text-white sm:text-4xl">4 Langkah Praktis Mulai Menghasilkan Uang</h2>
                <p class="max-w-md text-sm leading-7 text-neutral-600 dark:text-neutral-400">Tanpa syarat ribet, tanpa modal awal. Anda bisa langsung action dan raih komisi pertama dalam sekejap.</p>
            </div>

            <ol class="relative mt-14 grid gap-8 sm:grid-cols-2 lg:grid-cols-4">
                {{-- Connector line (desktop only) --}}
                <div class="pointer-events-none absolute left-0 top-[1.875rem] hidden h-px w-full bg-gradient-to-r from-transparent via-neutral-200 to-transparent dark:via-secondary-700 lg:block" aria-hidden="true"></div>

                @foreach([
                    ['icon' => 'fa-user-plus', 'title' => 'Daftar Gratis (< 2 Menit)', 'text' => 'Buat akun mitra Rayakan Digital tanpa biaya sepeser pun. Isi profil singkat di menu Reseller & Affiliate.'],
                    ['icon' => 'fa-bolt', 'title' => 'Verifikasi Kilat', 'text' => 'Tim kami segera memvalidasi pengajuan Anda agar Anda bisa langsung mengakses seluruh amunisi dashboard mitra.'],
                    ['icon' => 'fa-share-nodes', 'title' => 'Sebar Link & Kupon Diskon', 'text' => 'Bagikan link referral unik atau kupon diskon '.$discountRate.'% ke calon pengantin lewat WhatsApp atau media sosial.'],
                    ['icon' => 'fa-money-bill-wave', 'title' => 'Cairkan Komisi ke Rekening', 'text' => 'Setiap transaksi berhasil otomatis jadi komisi. Tarik langsung saldo Anda ke rekening bank mulai dari '.$minimumPayout.'!'],
                ] as $step)
                    <li class="relative flex flex-col gap-4"
                        data-aos="fade-up"
                        data-aos-delay="{{ $loop->index * 120 }}">
                        {{-- Step circle --}}
                        <div class="relative z-10 flex items-center gap-4 lg:flex-col lg:items-start">
                            <div class="flex h-[3.75rem] w-[3.75rem] shrink-0 items-center justify-center rounded-full border-2 border-primary-200 bg-white shadow-sm dark:border-primary-800 dark:bg-secondary-800">
                                <i class="fa-solid {{ $step['icon'] }} text-xl text-primary-600 dark:text-primary-400" aria-hidden="true"></i>
                            </div>
                            <span class="font-heading text-4xl font-extrabold italic text-primary-200 dark:text-primary-900/60 lg:hidden" aria-hidden="true">0{{ $loop->iteration }}</span>
                        </div>
                        <div class="flex flex-col gap-2 lg:pt-2">
                            <span class="hidden font-heading text-5xl font-extrabold italic leading-none text-neutral-100 dark:text-secondary-700 lg:block" aria-hidden="true">0{{ $loop->iteration }}</span>
                            <h3 class="text-lg font-bold text-secondary-900 dark:text-white">{{ $step['title'] }}</h3>
                            <p class="text-sm leading-7 text-neutral-600 dark:text-neutral-400">{{ $step['text'] }}</p>
                        </div>
                    </li>
                @endforeach
            </ol>
        </section>

        {{-- ═══════════════════════════ FAQ ═══════════════════════════ --}}
        <section class="bg-[#FAF8F5] dark:bg-secondary-800/40" aria-labelledby="faq-title">
            <div class="mx-auto grid max-w-7xl gap-10 px-6 py-16 sm:px-8 lg:grid-cols-[.75fr_1.25fr] lg:gap-20 lg:px-12 lg:py-20">
                {{-- Left: header --}}
                <div class="flex flex-col items-start gap-6" data-aos="fade-right">
                    <p class="text-xs font-bold uppercase tracking-[0.18em] text-primary-700 dark:text-primary-400">Pusat Informasi &amp; Tanya Jawab</p>
                    <h2 id="faq-title" class="font-heading text-3xl font-bold leading-tight text-secondary-900 dark:text-white sm:text-4xl">Pertanyaan Populer<br>Seputar Program Mitra.</h2>
                    <p class="text-sm leading-7 text-neutral-600 dark:text-neutral-400">Masih ada yang ingin dipastikan? Tim kami siap berdiskusi dan membantu Anda memaksimalkan penghasilan.</p>
                    <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener noreferrer"
                        class="inline-flex min-h-11 items-center gap-2.5 rounded-full border border-emerald-300 bg-emerald-50 px-5 py-2.5 text-sm font-bold text-emerald-700 transition hover:bg-emerald-100 focus-visible:outline focus-visible:outline-2 focus-visible:outline-emerald-500 dark:border-emerald-800 dark:bg-emerald-900/20 dark:text-emerald-400 dark:hover:bg-emerald-900/30">
                        <i class="fa-brands fa-whatsapp text-lg" aria-hidden="true"></i>
                        Konsultasi via WhatsApp
                    </a>
                </div>

                {{-- Right: accordion --}}
                <div class="divide-y divide-neutral-200 dark:divide-secondary-700" x-data="{ open: null }" data-aos="fade-left">
                    @foreach([
                        ['question' => 'Apakah program kemitraan ini benar-benar gratis tanpa modal?', 'answer' => 'Ya, 100% GRATIS tanpa biaya pendaftaran! Anda tidak perlu modal sepeser pun, tidak perlu stok produk, dan tidak dibebani target kuota bulanan. Anda hanya fokus merekomendasikan dan menikmati hasilnya.'],
                        ['question' => 'Apakah harus punya bisnis di bidang pernikahan atau pengalaman tertentu?', 'answer' => 'Sama sekali tidak harus. Program ini dirancang untuk semua orang — vendor pernikahan, WO, fotografer, content creator, freelancer, hingga individu yang sekadar ingin passive income dari rekomendasi ke teman atau kerabat.'],
                        ['question' => 'Berapa persen komisi yang saya dapatkan dan bagaimana perhitungannya?', 'answer' => 'Komisi awal dimulai dari '.$commissionRate.'% per transaksi dan dapat meningkat hingga 30%+ seiring bertambahnya performa penjualan Anda. Komisi dihitung langsung dari nilai transaksi bersih yang lunas dibayar oleh pelanggan.'],
                        ['question' => 'Kapan saya mendapatkan link referral dan kupon diskon '.$discountRate.'%?', 'answer' => 'Segera setelah pengajuan Anda disetujui, Anda langsung mendapatkan link referral khusus dan kode kupon diskon '.$discountRate.'% di dashboard mitra. Calon pengantin hemat dengan kupon Anda, dan Anda langsung mengantongi komisi!'],
                        ['question' => 'Bagaimana cara mencairkan saldo komisi ke rekening bank?', 'answer' => 'Pencairan sangat praktis! Begitu saldo terkumpul mencapai '.$minimumPayout.', Anda cukup mengajukan pencairan melalui dashboard. Dana akan ditransfer langsung ke rekening bank lokal Anda tanpa potongan yang membingungkan.'],
                        ['question' => 'Apa yang terjadi jika ada transaksi yang dibatalkan?', 'answer' => 'Komisi hanya dihitung dari transaksi yang telah diverifikasi dan lunas dibayar. Pesanan yang dibatalkan, tidak dibayar, atau kedaluwarsa tidak akan menghasilkan komisi.'],
                    ] as $index => $faq)
                        <div x-data="{ open: false }" class="py-4">
                            <button
                                @click="open = !open"
                                :aria-expanded="open"
                                class="flex w-full cursor-pointer items-center justify-between gap-4 rounded py-1 text-left text-sm font-bold leading-6 text-secondary-900 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-primary-500 dark:text-neutral-100">
                                <span>{{ $faq['question'] }}</span>
                                <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-neutral-100 transition dark:bg-secondary-700" :class="open ? 'bg-primary-50 dark:bg-primary-900/30' : ''">
                                    <i class="fa-solid fa-plus text-[10px] text-neutral-500 transition-transform dark:text-neutral-400"
                                        :class="open ? 'rotate-45 text-primary-600 dark:text-primary-400' : ''"
                                        aria-hidden="true"></i>
                                </span>
                            </button>
                            <div x-show="open" x-collapse class="overflow-hidden">
                                <p class="pb-2 pr-8 pt-3 text-sm leading-7 text-neutral-600 dark:text-neutral-400">{{ $faq['answer'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- ═══════════════════════════ CTA ═══════════════════════════ --}}
        <section class="mx-auto max-w-7xl px-6 py-16 sm:px-8 lg:px-12 lg:py-20" aria-labelledby="gabung-title">
            <div class="relative overflow-hidden rounded-[2rem] bg-secondary-800 px-6 py-14 text-center dark:border dark:border-secondary-700 sm:px-12 sm:py-20"
                data-aos="zoom-in" data-aos-duration="600">

                {{-- Decorative rings --}}
                <div class="pointer-events-none absolute -right-20 -top-20 h-64 w-64 rounded-full border border-white/8" aria-hidden="true"></div>
                <div class="pointer-events-none absolute -left-10 -bottom-10 h-48 w-48 rounded-full border border-white/5" aria-hidden="true"></div>
                <div class="pointer-events-none absolute right-32 -top-8 h-32 w-32 rounded-full border border-white/5" aria-hidden="true"></div>

                {{-- Glowing orb --}}
                <div class="pointer-events-none absolute left-1/2 top-0 h-40 w-96 -translate-x-1/2 rounded-full bg-primary-500/10 blur-3xl" aria-hidden="true"></div>

                <div class="relative mx-auto flex max-w-2xl flex-col items-center gap-6">
                    <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-primary-600/20 ring-1 ring-primary-500/30"
                        data-aos="zoom-in" data-aos-delay="200">
                        <i class="fa-solid fa-handshake text-xl text-primary-400" aria-hidden="true"></i>
                    </div>
                    <p class="text-xs font-bold uppercase tracking-[0.18em] text-primary-400" data-aos="fade-up" data-aos-delay="250">Mulai Hasilkan Passive Income Hari Ini</p>
                    <h2 id="gabung-title" class="font-heading text-3xl font-bold leading-tight text-white sm:text-4xl lg:text-5xl" data-aos="fade-up" data-aos-delay="300">Siap Mengubah Setiap Rekomendasi<br>Menjadi Sumber Cuan Nyata?</h2>
                    <p class="max-w-lg text-sm leading-7 text-neutral-300" data-aos="fade-up" data-aos-delay="350">Bergabunglah bersama komunitas mitra kami. Nikmati komisi hingga 30%+, senjata kupon diskon {{ $discountRate }}% untuk pelanggan, dan penarikan saldo langsung ke rekening bank Anda.</p>
                    <div class="flex flex-col items-center gap-4 sm:flex-row" data-aos="fade-up" data-aos-delay="420">
                        <a href="{{ route('dashboard.affiliate.index') }}" class="inline-flex min-h-12 items-center justify-center gap-3 rounded-full bg-primary-600 px-8 py-3.5 text-sm font-bold text-white shadow-lg shadow-primary-500/20 transition hover:bg-primary-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-primary-400">
                            {{ auth()->check() ? 'Buka Dashboard Mitra Saya' : 'Daftar Jadi Mitra Sekarang — 100% Gratis' }}
                            <i class="fa-solid fa-arrow-right text-xs" aria-hidden="true"></i>
                        </a>
                        <a href="{{ route('syarat-ketentuan') }}" class="rounded text-xs text-neutral-400 underline underline-offset-4 transition hover:text-neutral-200 focus-visible:outline focus-visible:outline-2 focus-visible:outline-primary-400">Baca syarat &amp; ketentuan</a>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <x-public-footer />
</body>
</html>
