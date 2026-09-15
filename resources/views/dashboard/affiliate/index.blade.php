<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <p class="text-xs font-bold uppercase tracking-widest text-primary-600 dark:text-primary-400">Program Kemitraan</p>
                <h1 class="text-xl sm:text-2xl font-bold text-secondary-900 dark:text-white">Reseller & Affiliate</h1>
            </div>
            @if($affiliate)
                @php
                    $statusColors = [
                        'approved'  => 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200 dark:bg-emerald-950/70 dark:text-emerald-300 dark:ring-emerald-800/80',
                        'pending'   => 'bg-amber-50 text-amber-700 ring-1 ring-amber-200 dark:bg-amber-950/70 dark:text-amber-300 dark:ring-amber-800/80',
                        'rejected'  => 'bg-red-50 text-red-700 ring-1 ring-red-200 dark:bg-red-950/70 dark:text-red-300 dark:ring-red-800/80',
                        'suspended' => 'bg-neutral-100 text-neutral-600 ring-1 ring-neutral-300 dark:bg-neutral-800 dark:text-neutral-300 dark:ring-neutral-700',
                    ];
                    $statusIcons = [
                        'approved'  => 'fa-check-circle',
                        'pending'   => 'fa-clock',
                        'rejected'  => 'fa-times-circle',
                        'suspended' => 'fa-pause-circle',
                    ];
                @endphp
                <span class="inline-flex items-center gap-1.5 rounded-full px-3 py-1 text-xs sm:text-sm font-semibold {{ $statusColors[$affiliate->status] ?? '' }}">
                    <i class="fa-solid {{ $statusIcons[$affiliate->status] ?? 'fa-circle' }} text-xs"></i>
                    {{ \App\Models\Affiliate::STATUSES[$affiliate->status] }}
                </span>
            @endif
        </div>
    </x-slot>

    <div class="mx-auto flex max-w-7xl flex-col gap-5 sm:gap-6 px-3 sm:px-6 lg:px-8 py-5 sm:py-8">

        {{-- Error Alert --}}
        @if($errors->any())
            <div role="alert" class="flex gap-3 rounded-2xl border border-red-200 bg-red-50 p-4 text-sm text-red-800 dark:border-red-900/60 dark:bg-red-950/40 dark:text-red-300">
                <i class="fa-solid fa-circle-exclamation mt-0.5 flex-shrink-0 text-base text-red-500 dark:text-red-400"></i>
                <div class="min-w-0 flex-1">
                    <p class="font-semibold text-red-900 dark:text-red-200">Periksa kembali data Anda.</p>
                    <ul class="mt-1 list-inside list-disc space-y-0.5 text-xs sm:text-sm text-red-800 dark:text-red-300">
                        @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                    </ul>
                </div>
            </div>
        @endif

        {{-- ============================
             STATE: BELUM DAFTAR (ONBOARDING)
        ============================= --}}
        {{-- ============================
             STATE: BELUM DAFTAR (ONBOARDING)
        ============================= --}}
        @if(!$affiliate)
            <div class="space-y-6">
                {{-- Hero Banner: Modern SaaS Partner Portal --}}
                <div class="relative overflow-hidden rounded-2xl sm:rounded-3xl border border-neutral-200/80 bg-white p-6 sm:p-8 md:p-10 dark:border-secondary-700 dark:bg-secondary-800 shadow-sm">
                    {{-- Ambient backdrop tint --}}
                    <div class="absolute -right-20 -top-20 h-64 w-64 rounded-full bg-primary-500/10 blur-3xl pointer-events-none"></div>
                    <div class="absolute -left-20 -bottom-20 h-64 w-64 rounded-full bg-emerald-500/5 blur-3xl pointer-events-none"></div>

                    <div class="relative z-10 max-w-3xl space-y-3">
                        <div class="inline-flex items-center gap-2 rounded-full bg-primary-50 px-3 py-1 text-xs font-semibold text-primary-700 dark:bg-primary-900/40 dark:text-primary-300 dark:ring-1 dark:ring-primary-800/50">
                            <i class="fa-solid fa-coins text-xs text-primary-600 dark:text-primary-400"></i>
                            Program Kemitraan &amp; Reseller Resmi
                        </div>
                        <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold tracking-tight text-secondary-900 dark:text-white">
                            Ubah Relasi Jadi Penghasilan Pasif.<br>
                            Komisi Awal <span class="text-primary-600 dark:text-primary-400">20%</span> &amp; <span class="text-emerald-600 dark:text-emerald-400">Terus Naik</span> Sesuai Performa.
                        </h2>
                        <p class="text-sm sm:text-base text-neutral-600 dark:text-neutral-300 leading-relaxed">
                            Setiap minggu Anda bertemu puluhan calon pengantin yang membutuhkan undangan digital. Cukup rekomendasikan <strong>Rayakan Digital</strong> melalui link atau kode kupon eksklusif brand Anda. Tanpa modal, tanpa pusing urusan server—tim kami yang melayani teknisnya, komisi otomatis mengalir ke rekening Anda!
                        </p>
                    </div>

                    {{-- 4 Metric Value Pillars --}}
                    <div class="relative z-10 mt-8 grid grid-cols-2 gap-3 sm:grid-cols-4 border-t border-neutral-100 pt-6 dark:border-secondary-700">
                        <div class="flex flex-col">
                            <span class="text-xs text-neutral-400 dark:text-neutral-500 font-medium">Bagi Hasil Awal</span>
                            <span class="mt-0.5 text-xl sm:text-2xl font-bold text-primary-600 dark:text-primary-400">20%</span>
                            <span class="text-[11px] text-neutral-500 dark:text-neutral-400">Langsung aktif saat daftar</span>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-xs text-neutral-400 dark:text-neutral-500 font-medium">Bonus Performa</span>
                            <span class="mt-0.5 text-xl sm:text-2xl font-bold text-emerald-600 dark:text-emerald-400">s/d 30%+</span>
                            <span class="text-[11px] text-neutral-500 dark:text-neutral-400">Naik tier otomatis</span>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-xs text-neutral-400 dark:text-neutral-500 font-medium">Minimal Pencairan</span>
                            <span class="mt-0.5 text-xl sm:text-2xl font-bold text-secondary-900 dark:text-white">Rp 50.000</span>
                            <span class="text-[11px] text-neutral-500 dark:text-neutral-400">Langsung ke rekening bank</span>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-xs text-neutral-400 dark:text-neutral-500 font-medium">Pelacakan Referral</span>
                            <span class="mt-0.5 text-xl sm:text-2xl font-bold text-secondary-900 dark:text-white">30 Hari</span>
                            <span class="text-[11px] text-neutral-500 dark:text-neutral-400">Masa aktif cookie referral</span>
                        </div>
                    </div>
                </div>

                {{-- Skema Hasil & Jenjang Komisi (Matched with Landing Page) --}}
                <div class="rounded-2xl border border-neutral-200/80 bg-white p-5 sm:p-7 dark:border-secondary-700 dark:bg-secondary-800 shadow-sm">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-neutral-100 pb-4 dark:border-secondary-700">
                        <div>
                            <span class="text-xs font-bold uppercase tracking-wider text-primary-600 dark:text-primary-400">
                                <i class="fa-solid fa-calculator mr-1"></i> Skema Hasil &amp; Simulasi Cuan
                            </span>
                            <h3 class="text-base sm:text-lg font-bold text-secondary-900 dark:text-white mt-0.5">
                                Jenjang Bagi Hasil &amp; Estimasi Pendapatan Riil
                            </h3>
                        </div>
                        <span class="inline-flex items-center gap-1 text-[11px] font-semibold text-emerald-600 dark:text-emerald-400 self-start sm:self-auto bg-emerald-50 dark:bg-emerald-950/60 px-2.5 py-1 rounded-full border border-emerald-200 dark:border-emerald-800/60">
                            <i class="fa-solid fa-shield-halved text-[10px]"></i> Transparan &amp; Tanpa Target Kuota
                        </span>
                    </div>

                    <div class="mt-5 grid grid-cols-1 md:grid-cols-3 gap-4">
                        {{-- Tier 1: Starter --}}
                        <div class="flex flex-col justify-between rounded-xl border border-neutral-200 bg-neutral-50/50 p-4 dark:border-secondary-700 dark:bg-secondary-900/40">
                            <div>
                                <div class="flex items-center justify-between">
                                    <span class="rounded-md bg-neutral-200 px-2 py-0.5 text-[11px] font-bold text-neutral-700 dark:bg-secondary-700 dark:text-neutral-300">
                                        Tier 1 · Starter
                                    </span>
                                    <span class="text-base font-extrabold text-primary-600 dark:text-primary-400">20% Komisi</span>
                                </div>
                                <p class="mt-2 text-xs font-semibold text-secondary-900 dark:text-white">Skala 5 – 10 Klien / bulan</p>
                                <p class="text-[11px] text-neutral-500 dark:text-neutral-400">Cocok untuk vendor yang baru mulai merekomendasikan.</p>

                                <div class="mt-3 space-y-1.5 border-t border-neutral-200/70 pt-2.5 text-xs dark:border-secondary-700">
                                    <div class="flex justify-between text-neutral-600 dark:text-neutral-300">
                                        <span>Paket Silver (Rp 75rb):</span>
                                        <span class="font-bold text-secondary-900 dark:text-white">Rp 15.000 / order</span>
                                    </div>
                                    <div class="flex justify-between text-neutral-600 dark:text-neutral-300">
                                        <span>Paket Gold (Rp 99rb):</span>
                                        <span class="font-bold text-secondary-900 dark:text-white">Rp 19.800 / order</span>
                                    </div>
                                    <div class="flex justify-between text-neutral-600 dark:text-neutral-300">
                                        <span>Paket Platinum (Rp 299rb):</span>
                                        <span class="font-bold text-secondary-900 dark:text-white">Rp 59.800 / order</span>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4 rounded-lg bg-white p-2.5 text-center border border-neutral-200/60 dark:bg-secondary-800 dark:border-secondary-700">
                                <p class="text-[10px] uppercase font-semibold text-neutral-400 dark:text-neutral-500">Estimasi Cuan Bulanan</p>
                                <p class="text-base font-bold text-secondary-900 dark:text-white">Rp 200rb – Rp 600rb+</p>
                            </div>
                        </div>

                        {{-- Tier 2: Silver --}}
                        <div class="relative flex flex-col justify-between rounded-xl border border-primary-300 bg-primary-50/30 p-4 dark:border-primary-800/60 dark:bg-primary-950/20 shadow-sm">
                            <span class="absolute -top-2.5 right-3 rounded-full bg-primary-600 px-2 py-0.5 text-[10px] font-bold text-white shadow-xs">
                                Paling Populer
                            </span>
                            <div>
                                <div class="flex items-center justify-between">
                                    <span class="rounded-md bg-primary-100 px-2 py-0.5 text-[11px] font-bold text-primary-800 dark:bg-primary-900/60 dark:text-primary-300">
                                        Tier 2 · Silver
                                    </span>
                                    <span class="text-base font-extrabold text-primary-600 dark:text-primary-400">25% Komisi</span>
                                </div>
                                <p class="mt-2 text-xs font-semibold text-secondary-900 dark:text-white">Skala 11 – 25 Klien / bulan</p>
                                <p class="text-[11px] text-neutral-500 dark:text-neutral-400">Untuk WO, MUA &amp; fotografer yang aktif tiap pekan.</p>

                                <div class="mt-3 space-y-1.5 border-t border-primary-200/60 pt-2.5 text-xs dark:border-primary-900/40">
                                    <div class="flex justify-between text-neutral-700 dark:text-neutral-200">
                                        <span>Paket Silver (Rp 75rb):</span>
                                        <span class="font-bold text-secondary-900 dark:text-white">Rp 18.750 / order</span>
                                    </div>
                                    <div class="flex justify-between text-neutral-700 dark:text-neutral-200">
                                        <span>Paket Gold (Rp 99rb):</span>
                                        <span class="font-bold text-secondary-900 dark:text-white">Rp 24.750 / order</span>
                                    </div>
                                    <div class="flex justify-between text-neutral-700 dark:text-neutral-200">
                                        <span>Paket Platinum (Rp 299rb):</span>
                                        <span class="font-bold text-secondary-900 dark:text-white">Rp 74.750 / order</span>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4 rounded-lg bg-white p-2.5 text-center border border-primary-200 dark:bg-secondary-800 dark:border-primary-900/50">
                                <p class="text-[10px] uppercase font-bold text-primary-700 dark:text-primary-300">Estimasi Cuan Bulanan</p>
                                <p class="text-base font-bold text-primary-700 dark:text-primary-400">Rp 1.000.000 – Rp 2.000.000+</p>
                            </div>
                        </div>

                        {{-- Tier 3: Gold VIP --}}
                        <div class="flex flex-col justify-between rounded-xl border border-amber-300/80 bg-amber-50/30 p-4 dark:border-amber-800/60 dark:bg-amber-950/20">
                            <div>
                                <div class="flex items-center justify-between">
                                    <span class="rounded-md bg-amber-100 px-2 py-0.5 text-[11px] font-bold text-amber-800 dark:bg-amber-900/60 dark:text-amber-300 flex items-center gap-1">
                                        <i class="fa-solid fa-crown text-[9px]"></i> Tier 3 · Gold VIP
                                    </span>
                                    <span class="text-base font-extrabold text-amber-600 dark:text-amber-400">30%+ Komisi</span>
                                </div>
                                <p class="mt-2 text-xs font-semibold text-secondary-900 dark:text-white">Skala 26+ Klien / bulan</p>
                                <p class="text-[11px] text-neutral-500 dark:text-neutral-400">Untuk vendor volume tinggi, agensi &amp; creator.</p>

                                <div class="mt-3 space-y-1.5 border-t border-amber-200/60 pt-2.5 text-xs dark:border-amber-900/40">
                                    <div class="flex justify-between text-neutral-700 dark:text-neutral-200">
                                        <span>Paket Silver (Rp 75rb):</span>
                                        <span class="font-bold text-secondary-900 dark:text-white">Rp 22.500+ / order</span>
                                    </div>
                                    <div class="flex justify-between text-neutral-700 dark:text-neutral-200">
                                        <span>Paket Gold (Rp 99rb):</span>
                                        <span class="font-bold text-secondary-900 dark:text-white">Rp 29.700+ / order</span>
                                    </div>
                                    <div class="flex justify-between text-neutral-700 dark:text-neutral-200">
                                        <span>Paket Platinum (Rp 299rb):</span>
                                        <span class="font-bold text-secondary-900 dark:text-white">Rp 89.700+ / order</span>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4 rounded-lg bg-white p-2.5 text-center border border-amber-200 dark:bg-secondary-800 dark:border-amber-900/50">
                                <p class="text-[10px] uppercase font-bold text-amber-700 dark:text-amber-400">Estimasi Cuan Bulanan</p>
                                <p class="text-base font-bold text-amber-700 dark:text-amber-400">Rp 2.500.000 – Rp 5.000.000++</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Split Workspace: How it Works & Focused Registration Form --}}
                <div class="grid grid-cols-1 gap-6 lg:grid-cols-12 items-start">
                    {{-- Left column: Benefits & Steps --}}
                    <div class="lg:col-span-5 space-y-4">
                        {{-- 3 Simple Steps --}}
                        <div class="rounded-2xl border border-neutral-200/80 bg-white p-5 sm:p-6 dark:border-secondary-700 dark:bg-secondary-800 shadow-sm">
                            <h3 class="text-xs font-bold uppercase tracking-wider text-neutral-400 dark:text-neutral-500">
                                3 Langkah Mudah Menjadi Mitra
                            </h3>
                            <div class="mt-4 space-y-4">
                                <div class="flex gap-3.5 items-start">
                                    <div class="flex h-7 w-7 flex-shrink-0 items-center justify-center rounded-full bg-primary-100 dark:bg-primary-900/50 text-xs font-bold text-primary-700 dark:text-primary-300">
                                        1
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-semibold text-secondary-900 dark:text-white">Lengkapi Profil Mitra</h4>
                                        <p class="mt-0.5 text-xs text-neutral-500 dark:text-neutral-400 leading-relaxed">
                                            Isi identitas brand Anda dan rekening bank pencairan pada formulir di sebelah.
                                        </p>
                                    </div>
                                </div>

                                <div class="flex gap-3.5 items-start">
                                    <div class="flex h-7 w-7 flex-shrink-0 items-center justify-center rounded-full bg-primary-100 dark:bg-primary-900/50 text-xs font-bold text-primary-700 dark:text-primary-300">
                                        2
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-semibold text-secondary-900 dark:text-white">Verifikasi Kilat oleh Admin</h4>
                                        <p class="mt-0.5 text-xs text-neutral-500 dark:text-neutral-400 leading-relaxed">
                                            Tim kami meninjau dan mengaktifkan akun kemitraan Anda dalam 1x24 jam kerja.
                                        </p>
                                    </div>
                                </div>

                                <div class="flex gap-3.5 items-start">
                                    <div class="flex h-7 w-7 flex-shrink-0 items-center justify-center rounded-full bg-primary-100 dark:bg-primary-900/50 text-xs font-bold text-primary-700 dark:text-primary-300">
                                        3
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-semibold text-secondary-900 dark:text-white">Bagikan Kupon &amp; Cairkan Cuan</h4>
                                        <p class="mt-0.5 text-xs text-neutral-500 dark:text-neutral-400 leading-relaxed">
                                            Dapatkan kupon promo atas nama brand Anda, bagikan ke calon pengantin, dan nikmati pencairan langsung ke rekening.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Why Partner with Us --}}
                        <div class="rounded-2xl border border-neutral-200/80 bg-white p-5 sm:p-6 dark:border-secondary-700 dark:bg-secondary-800 shadow-sm space-y-3">
                            <h3 class="text-xs font-bold uppercase tracking-wider text-neutral-400 dark:text-neutral-500">
                                Keunggulan Kemitraan
                            </h3>
                            <div class="space-y-2.5 text-xs">
                                <div class="flex items-start gap-2.5 text-neutral-600 dark:text-neutral-300">
                                    <i class="fa-solid fa-circle-check text-emerald-500 mt-0.5 flex-shrink-0 text-sm"></i>
                                    <span><strong>Kupon Diskon Klien:</strong> Calon pengantin lebih tertarik checkout karena mendapatkan diskon eksklusif.</span>
                                </div>
                                <div class="flex items-start gap-2.5 text-neutral-600 dark:text-neutral-300">
                                    <i class="fa-solid fa-circle-check text-emerald-500 mt-0.5 flex-shrink-0 text-sm"></i>
                                    <span><strong>Materi Promosi Gratis:</strong> Akses katalog banner dan template story Instagram yang siap pakai.</span>
                                </div>
                                <div class="flex items-start gap-2.5 text-neutral-600 dark:text-neutral-300">
                                    <i class="fa-solid fa-circle-check text-emerald-500 mt-0.5 flex-shrink-0 text-sm"></i>
                                    <span><strong>100% Pasif:</strong> Seluruh proses aktivasi, server, dan bantuan teknis ditangani oleh tim Rayakan Digital.</span>
                                </div>
                            </div>
                        </div>

                        {{-- Partner Support Card --}}
                        <div class="rounded-2xl border border-neutral-200/80 bg-neutral-50/70 p-5 dark:border-secondary-700 dark:bg-secondary-800/60 flex items-start gap-3.5">
                            <div class="flex h-9 w-9 flex-shrink-0 items-center justify-center rounded-xl bg-emerald-500/10 text-emerald-600 dark:text-emerald-400">
                                <i class="fa-brands fa-whatsapp text-lg"></i>
                            </div>
                            <div class="min-w-0 flex-1">
                                <h4 class="text-xs font-bold uppercase tracking-wider text-secondary-900 dark:text-white">Punya Pertanyaan Khusus?</h4>
                                <p class="mt-1 text-xs text-neutral-500 dark:text-neutral-400 leading-relaxed">
                                    Ingin konsultasi mengenai komisi khusus vendor besar atau integrasi paket wedding? Tim kami siap berdiskusi.
                                </p>
                                <a href="https://wa.me/62895349823366?text={{ urlencode('Halo Admin, saya ingin berdiskusi seputar peluang Kemitraan & Reseller Rayakan Digital.') }}"
                                    target="_blank"
                                    class="mt-2 inline-flex items-center gap-1.5 text-xs font-semibold text-emerald-600 hover:text-emerald-700 dark:text-emerald-400 dark:hover:underline">
                                    Diskusi via WhatsApp <i class="fa-solid fa-arrow-right text-[10px]"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- Right column: Clean Registration Form Card --}}
                    <div class="lg:col-span-7">
                        <div class="rounded-2xl border border-neutral-200/80 bg-white p-5 sm:p-7 dark:border-secondary-700 dark:bg-secondary-800 shadow-sm">
                            <div class="border-b border-neutral-100 pb-4 dark:border-secondary-700">
                                <div class="inline-flex items-center gap-1.5 rounded-full bg-primary-50 px-2.5 py-0.5 text-[11px] font-semibold text-primary-700 dark:bg-primary-900/40 dark:text-primary-300 mb-2">
                                    <i class="fa-solid fa-sparkles text-[10px]"></i> 100% Gratis &amp; Tanpa Modal
                                </div>
                                <h3 class="text-lg font-bold text-secondary-900 dark:text-white">
                                    Daftar menjadi mitra
                                </h3>
                                <p class="mt-1 text-xs text-neutral-500 dark:text-neutral-400 leading-relaxed">
                                    Lengkapi data profil usaha dan rekening tujuan. Setelah disetujui, link kustom dan kupon diskon Anda akan langsung aktif.
                                </p>
                            </div>

                            <form method="POST" action="{{ route('dashboard.affiliate.store') }}" class="mt-5 space-y-5">
                                @csrf

                                {{-- Section: Identitas Brand --}}
                                <div class="space-y-3.5">
                                    <p class="text-xs font-bold uppercase tracking-wider text-neutral-500 dark:text-neutral-400">
                                        1. Informasi Profil &amp; Brand
                                    </p>

                                    <div>
                                        <x-input-label for="business_name" value="Nama Usaha / Brand" />
                                        <x-text-input id="business_name" name="business_name" class="mt-1 w-full text-sm"
                                            :value="old('business_name')" placeholder="Contoh: Royal Wedding Organizer / MUA Bella"
                                            maxlength="150" required />
                                        <p class="mt-1 text-[11px] text-neutral-400 dark:text-neutral-500">Nama brand akan digunakan sebagai judul kode kupon promo Anda.</p>
                                    </div>

                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                                        <div>
                                            <x-input-label for="partner_type" value="Jenis Kemitraan" />
                                            <select id="partner_type" name="partner_type" required
                                                class="mt-1 w-full rounded-xl border-neutral-300 text-sm shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:border-secondary-600 dark:bg-secondary-900 dark:text-neutral-200">
                                                @foreach(\App\Models\Affiliate::TYPES as $value => $label)
                                                    <option value="{{ $value }}" class="dark:bg-secondary-900 dark:text-neutral-200" @selected(old('partner_type') === $value)>{{ $label }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div>
                                            <x-input-label for="phone" value="Nomor WhatsApp" />
                                            <x-text-input id="phone" name="phone" type="tel" class="mt-1 w-full text-sm"
                                                :value="old('phone')" placeholder="628123456789" required />
                                        </div>
                                    </div>
                                </div>

                                {{-- Section: Rekening Bank --}}
                                <div class="border-t border-neutral-100 pt-4 dark:border-secondary-700 space-y-3.5">
                                    <div class="flex items-center justify-between">
                                        <p class="text-xs font-bold uppercase tracking-wider text-neutral-500 dark:text-neutral-400">
                                            2. Rekening Pencairan Komisi
                                        </p>
                                        <span class="text-[11px] text-neutral-400 dark:text-neutral-500 flex items-center gap-1">
                                            <i class="fa-solid fa-lock text-[10px]"></i> Terenkripsi aman
                                        </span>
                                    </div>

                                    <div class="flex flex-col gap-3">
                                        @include('dashboard.affiliate.bank-fields', ['bank' => null])
                                    </div>
                                </div>

                                {{-- Notice & Submit Button --}}
                                <div class="border-t border-neutral-100 pt-4 dark:border-secondary-700">
                                    <p class="text-[11px] text-neutral-400 dark:text-neutral-500 leading-relaxed mb-4">
                                        Dengan mendaftar, Anda menjadi mitra resmi Rayakan Digital dan menyetujui ketentuan komisi serta kebijakan anti self-referral.
                                    </p>

                                    <x-primary-button class="w-full justify-center py-3 text-sm font-bold shadow-sm">
                                        <i class="fa-solid fa-paper-plane mr-2 text-xs"></i>
                                        Kirim Pendaftaran Kemitraan
                                    </x-primary-button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- FAQ Section for New Partners --}}
                <div class="rounded-2xl border border-neutral-200/80 bg-white p-5 sm:p-8 dark:border-secondary-700 dark:bg-secondary-800 shadow-sm" x-data="{ activeFaq: null }">
                    <div class="max-w-2xl">
                        <div class="inline-flex items-center gap-2 rounded-full bg-neutral-100 px-3 py-1 text-xs font-semibold text-neutral-600 dark:bg-secondary-700 dark:text-neutral-300 mb-2.5">
                            <i class="fa-solid fa-circle-question text-xs text-primary-600 dark:text-primary-400"></i>
                            Pusat Informasi Mitra
                        </div>
                        <h3 class="text-xl sm:text-2xl font-bold tracking-tight text-secondary-900 dark:text-white">
                            Pertanyaan yang Sering Diajukan
                        </h3>
                        <p class="mt-1 text-xs sm:text-sm text-neutral-500 dark:text-neutral-400 leading-relaxed">
                            Ketahui lebih dalam mengenai mekanisme komisi, pelacakan referral, dan ketentuan pencairan dana.
                        </p>
                    </div>

                    <div class="mt-6 space-y-3">
                        @php
                            $faqs = [
                                [
                                    'q' => 'Bagaimana cara kerja komisi awal 20% dan kenaikan tier?',
                                    'a' => 'Saat mendaftar, Anda langsung menikmati bagi hasil 20% (Tier Starter) untuk setiap pesanan paket undangan aktif. Seiring bertambahnya volume penjualan (10+ order untuk Silver 25%, dan 25+ order untuk Gold VIP 30%+), rate komisi Anda otomatis dinaikkan oleh admin sebagai apresiasi atas performa Anda.',
                                ],
                                [
                                    'q' => 'Kapan dan bagaimana komisi bisa dicairkan?',
                                    'a' => 'Saldo yang berstatus "Siap Cair" dapat diajukan penarikannya kapan saja melalui dashboard ini dengan batas minimum Rp 50.000. Dana akan diverifikasi dan ditransfer langsung oleh admin ke rekening bank terdaftar Anda tanpa potongan tersembunyi.',
                                ],
                                [
                                    'q' => 'Berapa lama masa berlaku cookie link referral?',
                                    'a' => 'Link referral menggunakan cookie terenkripsi yang aktif selama 30 hari sejak klik terakhir. Jika calon pengantin melakukan checkout dalam rentang waktu tersebut, transaksi tetap teratribusi secara otomatis ke akun Anda.',
                                ],
                                [
                                    'q' => 'Apakah mitra mendapatkan kode kupon promo unik?',
                                    'a' => 'Ya! Begitu pendaftaran disetujui oleh admin, sistem secara otomatis menerbitkan kode promo eksklusif sesuai nama brand Anda. Calon pengantin yang menggunakan kupon Anda saat checkout akan mendapatkan potongan harga dan komisi tetap masuk ke saldo Anda.',
                                ],
                                [
                                    'q' => 'Apakah ada biaya pendaftaran atau target penjualan bulanan?',
                                    'a' => 'Program kemitraan ini 100% gratis tanpa biaya pendaftaran, tanpa biaya bulanan, dan tanpa target kuota penjualan minimum. Anda bebas merekomendasikan layanan sesuai jadwal dan aktivitas usaha Anda.',
                                ],
                                [
                                    'q' => 'Apakah pembelian undangan untuk akun sendiri mendapatkan komisi?',
                                    'a' => 'Tidak. Kebijakan kemitraan melarang self-referral. Pembelian paket undangan yang dibuat menggunakan akun Anda sendiri tidak akan menghasilkan komisi.',
                                ],
                            ];
                        @endphp

                        @foreach($faqs as $index => $faq)
                            <div class="rounded-xl border border-neutral-100 dark:border-secondary-700 overflow-hidden bg-neutral-50/50 dark:bg-secondary-900/40 transition-colors">
                                <button type="button"
                                    @click="activeFaq = (activeFaq === {{ $index }} ? null : {{ $index }})"
                                    class="flex w-full items-center justify-between gap-4 p-4 text-left sm:px-5 sm:py-4 cursor-pointer focus:outline-none">
                                    <span class="text-xs sm:text-sm font-semibold text-secondary-900 dark:text-white leading-snug">
                                        {{ $faq['q'] }}
                                    </span>
                                    <span class="flex h-6 w-6 flex-shrink-0 items-center justify-center rounded-full bg-white dark:bg-secondary-800 border border-neutral-200 dark:border-secondary-600 text-neutral-400 text-xs transition-transform duration-200"
                                        :class="activeFaq === {{ $index }} ? 'rotate-180 text-primary-600 dark:text-primary-400' : ''">
                                        <i class="fa-solid fa-chevron-down text-[10px]"></i>
                                    </span>
                                </button>
                                <div x-show="activeFaq === {{ $index }}"
                                     x-transition:enter="transition ease-out duration-150"
                                     x-transition:enter-start="opacity-0 -translate-y-1"
                                     x-transition:enter-end="opacity-100 translate-y-0"
                                     class="border-t border-neutral-100 px-4 pb-4 pt-3 sm:px-5 sm:pb-5 text-xs sm:text-sm text-neutral-600 dark:text-neutral-300 leading-relaxed dark:border-secondary-700 bg-white/60 dark:bg-secondary-800/40">
                                    {{ $faq['a'] }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        {{-- ============================
             STATE: SUDAH DAFTAR
        ============================= --}}
        @else

            {{-- Review note from admin --}}
            @if($affiliate->review_note)
                <div class="flex gap-3 rounded-2xl border border-blue-200 bg-blue-50 p-4 dark:border-blue-900/50 dark:bg-blue-950/40">
                    <i class="fa-solid fa-info-circle mt-0.5 flex-shrink-0 text-blue-600 dark:text-blue-400"></i>
                    <div class="min-w-0 flex-1">
                        <p class="text-xs sm:text-sm font-semibold text-blue-950 dark:text-blue-200">Catatan admin</p>
                        <p class="mt-0.5 text-xs sm:text-sm text-blue-900 dark:text-blue-300">{{ $affiliate->review_note }}</p>
                    </div>
                </div>
            @endif

            {{-- Pending / Suspended notice --}}
            @if($affiliate->status !== 'approved')
                @php
                    $noticeStyle = $affiliate->status === 'pending'
                        ? 'border-amber-200 bg-amber-50 text-amber-900 dark:border-amber-800/60 dark:bg-amber-950/40 dark:text-amber-200'
                        : 'border-red-200 bg-red-50 text-red-900 dark:border-red-800/60 dark:bg-red-950/40 dark:text-red-200';
                    $noticeIcon = $affiliate->status === 'pending' ? 'fa-hourglass-half text-amber-600 dark:text-amber-400' : 'fa-ban text-red-600 dark:text-red-400';
                    $noticeMsg = $affiliate->status === 'pending'
                        ? 'Pendaftaran Anda sedang ditinjau. Link referral, kupon, marketing kit, dan pencairan tersedia setelah disetujui admin.'
                        : 'Akses promosi dan pencairan dinonaktifkan. Hubungi admin untuk meninjau status kemitraan Anda.';
                @endphp
                <div class="flex gap-3.5 sm:gap-4 rounded-2xl border {{ $noticeStyle }} p-4 sm:p-5">
                    <i class="fa-solid {{ $noticeIcon }} mt-0.5 flex-shrink-0 text-base sm:text-lg"></i>
                    <div class="min-w-0 flex-1">
                        <h2 class="font-bold text-sm sm:text-base">{{ \App\Models\Affiliate::STATUSES[$affiliate->status] }}</h2>
                        <p class="mt-1 text-xs sm:text-sm leading-relaxed">{{ $noticeMsg }}</p>
                    </div>
                </div>
            @endif

            {{-- ── STATS ── --}}
            <section aria-label="Ringkasan performa" class="grid grid-cols-2 gap-2.5 sm:gap-4 lg:grid-cols-4">
                @php
                    $statCards = [
                        ['label' => 'Total klik link', 'value' => number_format($stats['clicks'], 0, ',', '.'), 'help' => 'Kunjungan unik per 30 menit.', 'icon' => 'fa-mouse-pointer', 'color' => 'text-blue-600 bg-blue-50 dark:bg-blue-950/70 dark:text-blue-400 dark:ring-1 dark:ring-blue-800/50'],
                        ['label' => 'Total penjualan', 'value' => number_format($stats['sales'], 0, ',', '.'), 'help' => 'Pesanan berhasil dibayar.', 'icon' => 'fa-bag-shopping', 'color' => 'text-violet-600 bg-violet-50 dark:bg-violet-950/70 dark:text-violet-400 dark:ring-1 dark:ring-violet-800/50'],
                        ['label' => 'Total komisi', 'value' => 'Rp ' . number_format($balance['earned'], 0, ',', '.'), 'help' => 'Komisi dari penjualan.', 'icon' => 'fa-coins', 'color' => 'text-amber-600 bg-amber-50 dark:bg-amber-950/70 dark:text-amber-400 dark:ring-1 dark:ring-amber-800/50'],
                        ['label' => 'Saldo siap cair', 'value' => 'Rp ' . number_format(max(0, $balance['available']), 0, ',', '.'), 'help' => 'Setelah dikurangi pencairan.', 'icon' => 'fa-wallet', 'color' => 'text-emerald-600 bg-emerald-50 dark:bg-emerald-950/70 dark:text-emerald-400 dark:ring-1 dark:ring-emerald-800/50'],
                    ];
                @endphp
                @foreach($statCards as $card)
                    <div class="flex flex-col justify-between gap-2 sm:gap-3 rounded-2xl border border-neutral-200 bg-white p-3.5 sm:p-5 dark:border-secondary-700 dark:bg-secondary-800 shadow-sm">
                        <div class="flex items-start justify-between gap-1.5">
                            <p class="text-[11px] sm:text-xs font-medium text-neutral-500 dark:text-neutral-400 leading-tight">{{ $card['label'] }}</p>
                            <span class="flex h-7 w-7 sm:h-8 sm:w-8 flex-shrink-0 items-center justify-center rounded-lg {{ $card['color'] }}">
                                <i class="fa-solid {{ $card['icon'] }} text-[11px] sm:text-xs"></i>
                            </span>
                        </div>
                        <div>
                            <p class="truncate text-base sm:text-xl lg:text-2xl font-bold text-secondary-900 dark:text-white" title="{{ $card['value'] }}">{{ $card['value'] }}</p>
                            <p class="mt-0.5 text-[10px] sm:text-xs leading-tight text-neutral-400 dark:text-neutral-500">{{ $card['help'] }}</p>
                        </div>
                    </div>
                @endforeach
            </section>

            {{-- ── APPROVED CONTENT ── --}}
            @if($affiliate->status === 'approved')

                {{-- Tier & rate badge --}}
                <div class="flex flex-wrap items-center gap-2">
                    <span class="inline-flex items-center gap-1.5 rounded-full bg-primary-50 px-3 py-1 text-xs font-semibold text-primary-700 dark:bg-primary-900/40 dark:text-primary-300 dark:ring-1 dark:ring-primary-800/50">
                        <i class="fa-solid fa-star text-[10px]"></i>
                        Tier {{ $affiliate->tier?->name ?? 'Global' }}
                    </span>
                    <span class="inline-flex items-center gap-1.5 rounded-full bg-neutral-100 px-3 py-1 text-xs font-semibold text-neutral-600 dark:bg-secondary-700 dark:text-neutral-300">
                        <i class="fa-solid fa-percent text-[10px]"></i>
                        Komisi {{ $stats['rate'] }}%
                    </span>
                </div>

                {{-- ── TABS (Alpine.js) ── --}}
                <div x-data="{ tab: 'links' }">

                    {{-- Tab nav with responsive horizontal scrolling --}}
                    <div class="flex gap-1 overflow-x-auto rounded-2xl border border-neutral-200 bg-neutral-100 p-1 dark:border-secondary-700 dark:bg-secondary-900 scrollbar-none">
                        @foreach([
                            ['links',      'fa-link',            'Link & Kupon'],
                            ['payout',     'fa-money-bill-wave', 'Pencairan'],
                            ['sales',      'fa-chart-bar',       'Penjualan'],
                            ['marketing',  'fa-images',          'Marketing Kit'],
                        ] as [$id, $icon, $label])
                            <button
                                type="button"
                                @click="tab = '{{ $id }}'"
                                :class="tab === '{{ $id }}'
                                    ? 'bg-white text-secondary-900 shadow-sm dark:bg-secondary-700 dark:text-white'
                                    : 'text-neutral-500 hover:text-secondary-700 dark:text-neutral-400 dark:hover:text-neutral-200'"
                                class="flex flex-1 min-w-fit items-center justify-center gap-1.5 whitespace-nowrap rounded-xl px-3 py-2 text-xs sm:text-sm font-semibold transition-all duration-150 shrink-0 sm:shrink">
                                <i class="fa-solid {{ $icon }} text-xs"></i>
                                <span>{{ $label }}</span>
                            </button>
                        @endforeach
                    </div>

                    {{-- ── TAB: Links & Kupon ── --}}
                    <div x-show="tab === 'links'" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0">
                        <div class="mt-4 grid gap-4 lg:grid-cols-2">

                            {{-- Coupon card --}}
                            @if($affiliate->promotion)
                                <div class="rounded-2xl border border-neutral-200 bg-white p-4 sm:p-6 dark:border-secondary-700 dark:bg-secondary-800 shadow-sm" x-data="affiliateCopy()">
                                    <div class="mb-3 sm:mb-4 flex items-start sm:items-center justify-between gap-2">
                                        <div class="min-w-0 flex-1">
                                            <h3 class="font-bold text-sm sm:text-base text-secondary-900 dark:text-white">Kode Promo Unik</h3>
                                            <p class="text-xs text-neutral-500 dark:text-neutral-400">
                                                Diskon {{ $affiliate->promotion->discount_value }}{{ $affiliate->promotion->discount_type === 'PERCENTAGE' ? '%' : ' rupiah' }} untuk pelanggan Anda
                                            </p>
                                        </div>
                                        <span class="rounded-full flex-shrink-0 {{ $affiliate->promotion->is_active ? 'bg-emerald-50 text-emerald-700 dark:bg-emerald-950/70 dark:text-emerald-300' : 'bg-neutral-100 text-neutral-500 dark:bg-secondary-700 dark:text-neutral-400' }} px-2.5 py-1 text-xs font-semibold">
                                            {{ $affiliate->promotion->is_active ? 'Aktif' : 'Nonaktif' }}
                                        </span>
                                    </div>
                                    <div class="flex gap-2">
                                        <input id="coupon-field" type="text" readonly value="{{ $affiliate->promotion->code }}"
                                            class="min-w-0 flex-1 rounded-xl border border-neutral-200 bg-neutral-50 px-3 py-2 font-mono text-xs sm:text-sm font-bold tracking-widest text-secondary-900 focus:border-primary-500 focus:ring-primary-500 dark:border-secondary-600 dark:bg-secondary-900 dark:text-white" />
                                        <button type="button" @click="copyText('coupon-field')"
                                            class="inline-flex shrink-0 items-center gap-1.5 rounded-xl border border-neutral-300 bg-white px-3 sm:px-4 py-2 text-xs sm:text-sm font-semibold text-neutral-700 transition hover:bg-neutral-50 dark:border-secondary-600 dark:bg-secondary-700 dark:text-neutral-200 dark:hover:bg-secondary-600">
                                            <i class="fa-solid fa-copy text-xs"></i>
                                            <span x-text="copied === 'coupon-field' ? 'Tersalin!' : 'Salin'"></span>
                                        </button>
                                    </div>
                                    @if($affiliate->promotion->end_time)
                                        <p class="mt-2 text-xs text-neutral-400 dark:text-neutral-500">
                                            <i class="fa-regular fa-calendar-xmark mr-1"></i>
                                            Berlaku hingga {{ $affiliate->promotion->end_time->format('d M Y') }}
                                        </p>
                                    @endif
                                </div>
                            @endif

                            {{-- Create link form --}}
                            <div class="rounded-2xl border border-neutral-200 bg-white p-4 sm:p-6 dark:border-secondary-700 dark:bg-secondary-800 shadow-sm">
                                <h3 class="mb-3 sm:mb-4 font-bold text-sm sm:text-base text-secondary-900 dark:text-white">
                                    <i class="fa-solid fa-plus mr-1.5 text-primary-600 dark:text-primary-400 text-xs sm:text-sm"></i>
                                    Buat Link Kustom
                                </h3>
                                <form method="POST" action="{{ route('dashboard.affiliate.links.store') }}" class="flex flex-col gap-3">
                                    @csrf
                                    <div>
                                        <x-input-label for="label" value="Nama kampanye" />
                                        <x-text-input id="label" name="label" :value="old('label')" class="mt-1 w-full text-sm" placeholder="Promo Instagram" maxlength="100" required />
                                    </div>
                                    <div>
                                        <x-input-label for="slug" value="Alamat link" />
                                        <div class="mt-1 flex overflow-hidden rounded-xl border border-neutral-300 bg-neutral-50 focus-within:border-primary-500 focus-within:ring-2 focus-within:ring-primary-500 dark:border-secondary-600 dark:bg-secondary-900">
                                            <span class="flex items-center whitespace-nowrap border-r border-neutral-300 bg-neutral-100 px-3 text-xs text-neutral-500 dark:border-secondary-600 dark:bg-secondary-800 dark:text-neutral-400">/r/</span>
                                            <input id="slug" name="slug" type="text" :value="old('slug')"
                                                placeholder="nama-brand-anda" minlength="3" maxlength="60" pattern="[a-z0-9]+(-[a-z0-9]+)*" required
                                                class="min-w-0 flex-1 border-none bg-transparent px-3 py-2 text-sm text-secondary-900 placeholder-neutral-400 focus:ring-0 dark:text-white dark:placeholder-neutral-500" />
                                        </div>
                                        <p class="mt-1 text-[11px] sm:text-xs text-neutral-400 dark:text-neutral-500">Huruf kecil, angka, tanda hubung.</p>
                                    </div>
                                    <div>
                                        <x-input-label for="destination" value="Halaman tujuan" />
                                        <select name="destination" id="destination"
                                            class="mt-1 w-full rounded-xl border-neutral-300 text-sm shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:border-secondary-600 dark:bg-secondary-900 dark:text-neutral-200">
                                            @foreach(\App\Models\AffiliateLink::DESTINATIONS as $value => $label)
                                                <option value="{{ $value }}" class="dark:bg-secondary-900 dark:text-neutral-200" @selected(old('destination') === $value)>{{ $label }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <x-primary-button class="justify-center py-2.5 text-xs sm:text-sm">
                                        <i class="fa-solid fa-plus mr-1.5 text-xs"></i>
                                        Buat link referral
                                    </x-primary-button>
                                </form>
                            </div>
                        </div>

                        {{-- Links list --}}
                        @if($links && $links->count())
                            <div class="mt-4 rounded-2xl border border-neutral-200 bg-white p-4 sm:p-6 dark:border-secondary-700 dark:bg-secondary-800 shadow-sm" x-data="affiliateCopy()">
                                <div class="mb-3 sm:mb-4 flex flex-wrap items-center justify-between gap-1">
                                    <h3 class="font-bold text-sm sm:text-base text-secondary-900 dark:text-white">Link Referral Aktif</h3>
                                    <p class="text-[11px] sm:text-xs text-neutral-400 dark:text-neutral-500">Referral berlaku 30 hari dari kunjungan terakhir.</p>
                                </div>
                                <div class="space-y-3">
                                    @foreach($links as $link)
                                        <div class="rounded-xl border border-neutral-200 dark:border-secondary-700 bg-white dark:bg-secondary-800"
                                             x-data="{ editing: false, confirmDelete: false }">
                                            {{-- Link header row --}}
                                            <div class="flex flex-col gap-2.5 p-3 sm:p-4">
                                                <div class="flex flex-wrap sm:flex-nowrap items-center justify-between gap-2">
                                                    <div class="flex items-center gap-2 min-w-0 max-w-full">
                                                        <span class="flex h-7 w-7 flex-shrink-0 items-center justify-center rounded-lg bg-primary-50 dark:bg-primary-900/40">
                                                            <i class="fa-solid fa-link text-xs text-primary-600 dark:text-primary-400"></i>
                                                        </span>
                                                        <p class="truncate text-xs sm:text-sm font-semibold text-secondary-800 dark:text-white max-w-[150px] xs:max-w-[220px] sm:max-w-md">{{ $link->label }}</p>
                                                    </div>
                                                    <div class="flex items-center gap-1.5 ml-auto sm:ml-0 flex-shrink-0">
                                                        <span class="rounded-full bg-neutral-100 px-2 sm:px-2.5 py-1 text-[11px] sm:text-xs font-medium text-neutral-600 dark:bg-secondary-700 dark:text-neutral-300">
                                                            <i class="fa-solid fa-mouse-pointer text-[9px] sm:text-[10px]"></i>
                                                            {{ number_format($link->clicks, 0, ',', '.') }} klik
                                                        </span>
                                                        {{-- Edit toggle --}}
                                                        <button type="button" @click="editing = !editing; confirmDelete = false"
                                                            :class="editing ? 'bg-primary-50 text-primary-700 border-primary-300 dark:bg-primary-900/50 dark:text-primary-300 dark:border-primary-700' : 'bg-white text-neutral-600 border-neutral-300 dark:bg-secondary-700 dark:text-neutral-300 dark:border-secondary-600'"
                                                            class="inline-flex items-center gap-1 rounded-lg border px-2 sm:px-2.5 py-1 text-xs font-semibold transition hover:bg-primary-50 hover:text-primary-700 dark:hover:bg-primary-900/40 dark:hover:text-primary-300"
                                                            title="Edit link">
                                                            <i class="fa-solid fa-pen text-[10px]"></i>
                                                            <span x-text="editing ? 'Batal' : 'Edit'"></span>
                                                        </button>
                                                        {{-- Delete toggle --}}
                                                        @if($links->total() > 1)
                                                            <button type="button" @click="confirmDelete = !confirmDelete; editing = false"
                                                                :class="confirmDelete ? 'bg-red-50 text-red-700 border-red-300 dark:bg-red-950/70 dark:text-red-300 dark:border-red-800' : 'bg-white text-neutral-400 border-neutral-300 dark:bg-secondary-700 dark:text-neutral-400 dark:border-secondary-600'"
                                                                class="inline-flex items-center justify-center rounded-lg border p-1.5 text-xs transition hover:bg-red-50 hover:text-red-600 dark:hover:bg-red-950/50 dark:hover:text-red-300"
                                                                title="Hapus link">
                                                                <i class="fa-solid fa-trash-can text-[10px]"></i>
                                                            </button>
                                                        @else
                                                            <span class="inline-flex items-center justify-center rounded-lg border border-neutral-200 p-1.5 text-xs text-neutral-300 dark:border-secondary-700 dark:text-neutral-600 cursor-not-allowed" title="Minimal 1 link harus ada">
                                                                <i class="fa-solid fa-trash-can text-[10px]"></i>
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="flex gap-2">
                                                    <input id="link-{{ $link->id }}" type="text" readonly value="{{ $link->url }}"
                                                        class="min-w-0 flex-1 rounded-xl border border-neutral-200 bg-neutral-50 px-3 py-1.5 text-xs text-secondary-800 dark:border-secondary-600 dark:bg-secondary-900 dark:text-neutral-200" />
                                                    <button type="button" @click="copyText('link-{{ $link->id }}')"
                                                        class="inline-flex flex-shrink-0 items-center gap-1.5 rounded-xl border border-neutral-300 bg-white px-2.5 sm:px-3 py-1.5 text-xs font-semibold text-neutral-700 transition hover:bg-neutral-50 dark:border-secondary-600 dark:bg-secondary-700 dark:text-neutral-200 dark:hover:bg-secondary-600">
                                                        <i class="fa-solid fa-copy text-[10px]"></i>
                                                        <span x-text="copied === 'link-{{ $link->id }}' ? 'Tersalin!' : 'Salin'"></span>
                                                    </button>
                                                </div>
                                            </div>

                                            {{-- Edit form (slide-down) --}}
                                            <div x-show="editing"
                                                 x-transition:enter="transition ease-out duration-150"
                                                 x-transition:enter-start="opacity-0 -translate-y-1"
                                                 x-transition:enter-end="opacity-100 translate-y-0"
                                                 class="border-t border-neutral-100 bg-neutral-50 px-3.5 sm:px-4 pb-4 pt-4 dark:border-secondary-700 dark:bg-secondary-900/60">
                                                <p class="mb-3 text-xs font-semibold text-neutral-600 dark:text-neutral-300">
                                                    <i class="fa-solid fa-pen mr-1 text-primary-600 dark:text-primary-400"></i> Edit link referral
                                                </p>
                                                <form method="POST" action="{{ route('dashboard.affiliate.links.update', $link) }}" class="flex flex-col gap-3">
                                                    @csrf @method('PUT')
                                                    <div>
                                                        <x-input-label for="edit-label-{{ $link->id }}" value="Nama kampanye" />
                                                        <x-text-input id="edit-label-{{ $link->id }}" name="label"
                                                            value="{{ old('label', $link->label) }}"
                                                            class="mt-1 w-full text-sm" maxlength="100" required />
                                                    </div>
                                                    <div>
                                                        <x-input-label for="edit-slug-{{ $link->id }}" value="Alamat link" />
                                                        <div class="mt-1 flex overflow-hidden rounded-xl border border-neutral-300 bg-white focus-within:border-primary-500 focus-within:ring-2 focus-within:ring-primary-500 dark:border-secondary-600 dark:bg-secondary-900">
                                                            <span class="flex items-center whitespace-nowrap border-r border-neutral-300 bg-neutral-100 px-3 text-xs text-neutral-500 dark:border-secondary-600 dark:bg-secondary-800 dark:text-neutral-400">/r/</span>
                                                            <input id="edit-slug-{{ $link->id }}" name="slug" type="text"
                                                                value="{{ old('slug', $link->slug) }}"
                                                                minlength="3" maxlength="60" pattern="[a-z0-9]+(-[a-z0-9]+)*" required
                                                                class="min-w-0 flex-1 border-none bg-transparent px-3 py-2 text-sm text-secondary-900 focus:ring-0 dark:text-white" />
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <x-input-label for="edit-destination-{{ $link->id }}" value="Halaman tujuan" />
                                                        <select id="edit-destination-{{ $link->id }}" name="destination"
                                                            class="mt-1 w-full rounded-xl border-neutral-300 text-sm shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:border-secondary-600 dark:bg-secondary-900 dark:text-neutral-200">
                                                            @foreach(\App\Models\AffiliateLink::DESTINATIONS as $destValue => $destLabel)
                                                                <option value="{{ $destValue }}" class="dark:bg-secondary-900 dark:text-neutral-200" @selected(old('destination', $link->destination) === $destValue)>{{ $destLabel }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="flex flex-col-reverse sm:flex-row gap-2 pt-1">
                                                        <button type="button" @click="editing = false"
                                                            class="rounded-xl border border-neutral-300 bg-white px-3 py-2 text-xs font-semibold text-neutral-600 transition hover:bg-neutral-50 dark:border-secondary-600 dark:bg-secondary-700 dark:text-neutral-300 dark:hover:bg-secondary-600">
                                                            Batal
                                                        </button>
                                                        <x-primary-button class="flex-1 justify-center py-2 text-xs">
                                                            <i class="fa-solid fa-floppy-disk mr-1.5 text-[10px]"></i>
                                                            Simpan perubahan
                                                        </x-primary-button>
                                                    </div>
                                                </form>
                                            </div>

                                            {{-- Delete confirmation (slide-down) --}}
                                            <div x-show="confirmDelete"
                                                 x-transition:enter="transition ease-out duration-150"
                                                 x-transition:enter-start="opacity-0 -translate-y-1"
                                                 x-transition:enter-end="opacity-100 translate-y-0"
                                                 class="border-t border-red-100 bg-red-50 px-3.5 sm:px-4 pb-4 pt-4 dark:border-red-900/60 dark:bg-red-950/40">
                                                <div class="flex items-start gap-3">
                                                    <i class="fa-solid fa-triangle-exclamation mt-0.5 flex-shrink-0 text-sm text-red-600 dark:text-red-400"></i>
                                                    <div class="min-w-0 flex-1">
                                                        <p class="text-xs sm:text-sm font-semibold text-red-800 dark:text-red-200">Hapus link ini?</p>
                                                        <p class="mt-0.5 text-xs text-red-700 dark:text-red-300">Link <strong>{{ $link->label }}</strong> akan dihapus permanen. Statistik klik akan hilang.</p>
                                                        <div class="mt-3 flex gap-2">
                                                            <form method="POST" action="{{ route('dashboard.affiliate.links.destroy', $link) }}">
                                                                @csrf @method('DELETE')
                                                                <button type="submit"
                                                                    class="inline-flex items-center gap-1.5 rounded-xl bg-red-600 px-3 py-1.5 text-xs font-bold text-white transition hover:bg-red-700 dark:bg-red-700 dark:hover:bg-red-600">
                                                                    <i class="fa-solid fa-trash-can text-[10px]"></i>
                                                                    Ya, hapus
                                                                </button>
                                                            </form>
                                                            <button type="button" @click="confirmDelete = false"
                                                                class="rounded-xl border border-red-300 bg-white px-3 py-1.5 text-xs font-semibold text-red-700 transition hover:bg-red-50 dark:border-red-800 dark:bg-secondary-800 dark:text-red-300 dark:hover:bg-secondary-700">
                                                                Batal
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="mt-4">{{ $links->withQueryString()->links() }}</div>
                                <p class="mt-2 text-[11px] sm:text-xs text-neutral-400 dark:text-neutral-500">Kupon mitra yang digunakan saat checkout menentukan penerima komisi. Pembelian sendiri tidak dihitung.</p>
                            </div>
                        @else
                            <div class="mt-4 flex flex-col items-center gap-3 rounded-2xl border border-dashed border-neutral-300 bg-neutral-50 py-10 text-center dark:border-secondary-700 dark:bg-secondary-800/50">
                                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-neutral-200 dark:bg-secondary-700">
                                    <i class="fa-solid fa-link text-neutral-400 dark:text-neutral-500"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-neutral-600 dark:text-neutral-300">Belum ada link referral</p>
                                    <p class="text-xs text-neutral-400 dark:text-neutral-500">Buat link pertama Anda menggunakan formulir di atas.</p>
                                </div>
                            </div>
                        @endif
                    </div>

                    {{-- ── TAB: Pencairan ── --}}
                    <div x-show="tab === 'payout'" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0">
                        <div class="mt-4 grid gap-4 lg:grid-cols-2">

                            {{-- Balance breakdown --}}
                            <div class="flex flex-col gap-4 rounded-2xl border border-neutral-200 bg-white p-4 sm:p-6 dark:border-secondary-700 dark:bg-secondary-800 shadow-sm">
                                <h3 class="font-bold text-sm sm:text-base text-secondary-900 dark:text-white">Rincian Saldo</h3>
                                <div class="space-y-2.5 sm:space-y-3">
                                    @foreach([
                                        ['Total komisi diperoleh', $balance['earned'],   'text-secondary-900 dark:text-white'],
                                        ['Dana dicadangkan',       $balance['reserved'],  'text-amber-600 dark:text-amber-400'],
                                        ['Sudah ditransfer',       $balance['paid'],      'text-neutral-500 dark:text-neutral-400'],
                                    ] as [$label, $amount, $textColor])
                                        <div class="flex items-center justify-between gap-2 rounded-xl bg-neutral-50 px-3.5 sm:px-4 py-2.5 sm:py-3 dark:bg-secondary-900">
                                            <p class="text-xs sm:text-sm text-neutral-600 dark:text-neutral-300">{{ $label }}</p>
                                            <p class="text-xs sm:text-sm font-bold {{ $textColor }}">Rp {{ number_format($amount, 0, ',', '.') }}</p>
                                        </div>
                                    @endforeach
                                    <div class="flex items-center justify-between gap-2 rounded-xl border border-primary-200 bg-primary-50 px-3.5 sm:px-4 py-2.5 sm:py-3 dark:border-primary-800/50 dark:bg-primary-900/30">
                                        <p class="text-xs sm:text-sm font-semibold text-primary-800 dark:text-primary-300">Saldo siap cair</p>
                                        <p class="text-base sm:text-lg font-bold text-primary-700 dark:text-primary-300">Rp {{ number_format(max(0, $balance['available']), 0, ',', '.') }}</p>
                                    </div>
                                    @if($balance['available'] < 0)
                                        <div class="flex gap-2 rounded-xl border border-red-200 bg-red-50 px-3.5 sm:px-4 py-2.5 sm:py-3 text-xs sm:text-sm text-red-700 dark:border-red-900/60 dark:bg-red-950/40 dark:text-red-300">
                                            <i class="fa-solid fa-triangle-exclamation flex-shrink-0 mt-0.5"></i>
                                            <span>Saldo sedang disesuaikan karena pembatalan transaksi. Hubungi admin.</span>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            {{-- Withdrawal form --}}
                            <div class="flex flex-col gap-4 sm:gap-5 rounded-2xl border border-neutral-200 bg-white p-4 sm:p-6 dark:border-secondary-700 dark:bg-secondary-800 shadow-sm">
                                <div>
                                    <h3 class="font-bold text-sm sm:text-base text-secondary-900 dark:text-white">Ajukan Pencairan</h3>
                                    <div class="mt-2 flex items-center gap-2.5 rounded-xl bg-neutral-50 px-3.5 sm:px-4 py-2.5 sm:py-3 dark:bg-secondary-900">
                                        <i class="fa-solid fa-building-columns text-sm text-neutral-500 dark:text-neutral-400"></i>
                                        <div class="text-xs sm:text-sm min-w-0">
                                            <p class="font-semibold text-secondary-800 dark:text-white">{{ $affiliate->bank_name }}</p>
                                            <p class="text-neutral-500 dark:text-neutral-400 truncate">{{ $affiliate->bank_account_number }} · a.n. {{ $affiliate->bank_account_holder }}</p>
                                        </div>
                                    </div>
                                </div>
                                <form method="POST" action="{{ route('dashboard.affiliate.payouts.store') }}" class="flex flex-col gap-3">
                                    @csrf
                                    <div>
                                        <x-input-label for="amount" value="Nominal penarikan (Rp)" />
                                        <x-text-input id="amount" name="amount" type="number" :value="old('amount')" :min="$settings['minimum_payout']" :max="max(0, $balance['available'])" step="1" class="mt-1 w-full text-sm" required />
                                        <p class="mt-1 text-[11px] sm:text-xs text-neutral-400 dark:text-neutral-500">
                                            Minimum Rp {{ number_format($settings['minimum_payout'], 0, ',', '.') }}. Diproses manual setelah persetujuan admin.
                                        </p>
                                    </div>
                                    <x-primary-button class="justify-center py-2.5 sm:py-3 text-xs sm:text-sm" :disabled="$balance['available'] < $settings['minimum_payout']">
                                        <i class="fa-solid fa-money-bill-transfer mr-1.5 text-xs"></i>
                                        Ajukan pencairan
                                    </x-primary-button>
                                </form>

                                {{-- Change bank details --}}
                                <details class="border-t border-neutral-100 pt-3 sm:pt-4 dark:border-secondary-700">
                                    <summary class="cursor-pointer select-none text-xs sm:text-sm font-semibold text-neutral-600 hover:text-secondary-800 dark:text-neutral-300 dark:hover:text-white">
                                        <i class="fa-solid fa-pen-to-square mr-1.5 text-xs"></i>
                                        Ubah rekening tujuan
                                    </summary>
                                    <form method="POST" action="{{ route('dashboard.affiliate.bank') }}" class="mt-3 flex flex-col gap-3">
                                        @csrf @method('PUT')
                                        <div class="flex flex-col gap-3">
                                            @include('dashboard.affiliate.bank-fields', ['bank' => $affiliate])
                                        </div>
                                        <p class="text-[11px] sm:text-xs text-neutral-400 dark:text-neutral-500">Perubahan berlaku untuk pengajuan baru.</p>
                                        <x-secondary-button type="submit" class="justify-center py-2 text-xs sm:text-sm">
                                            <i class="fa-solid fa-floppy-disk mr-1.5 text-xs"></i>
                                            Simpan rekening
                                        </x-secondary-button>
                                    </form>
                                </details>
                            </div>
                        </div>

                        {{-- Payout history --}}
                        <div class="mt-4 rounded-2xl border border-neutral-200 bg-white dark:border-secondary-700 dark:bg-secondary-800 shadow-sm overflow-hidden">
                            <div class="border-b border-neutral-100 px-4 sm:px-6 py-3.5 sm:py-4 dark:border-secondary-700 flex items-center justify-between">
                                <h3 class="font-bold text-sm sm:text-base text-secondary-900 dark:text-white">Riwayat Pencairan</h3>
                                <span class="text-[11px] sm:text-xs text-neutral-400 dark:text-neutral-500 sm:hidden">Geser tabel &rarr;</span>
                            </div>
                            <div class="overflow-x-auto">
                                <table class="w-full whitespace-nowrap text-left text-xs sm:text-sm">
                                    <thead class="bg-neutral-50 text-[10px] sm:text-xs font-semibold uppercase tracking-wide text-neutral-500 dark:bg-secondary-900 dark:text-neutral-400 border-b border-neutral-100 dark:border-secondary-700">
                                        <tr>
                                            <th class="px-4 sm:px-5 py-3">Tanggal</th>
                                            <th class="px-4 sm:px-5 py-3">Nominal</th>
                                            <th class="px-4 sm:px-5 py-3">Rekening tujuan</th>
                                            <th class="px-4 sm:px-5 py-3">Status</th>
                                            <th class="px-4 sm:px-5 py-3">Referensi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-neutral-100 dark:divide-secondary-700">
                                        @forelse($payouts as $payout)
                                            @php
                                                $payoutStatusBadge = [
                                                    'pending'  => 'bg-amber-50 text-amber-700 dark:bg-amber-950/70 dark:text-amber-300 dark:ring-1 dark:ring-amber-800/50',
                                                    'approved' => 'bg-blue-50 text-blue-700 dark:bg-blue-950/70 dark:text-blue-300 dark:ring-1 dark:ring-blue-800/50',
                                                    'paid'     => 'bg-emerald-50 text-emerald-700 dark:bg-emerald-950/70 dark:text-emerald-300 dark:ring-1 dark:ring-emerald-800/50',
                                                    'rejected' => 'bg-red-50 text-red-700 dark:bg-red-950/70 dark:text-red-300 dark:ring-1 dark:ring-red-800/50',
                                                ][$payout->status] ?? 'bg-neutral-100 text-neutral-600';
                                            @endphp
                                            <tr class="hover:bg-neutral-50/80 dark:hover:bg-secondary-700/40 transition-colors">
                                                <td class="px-4 sm:px-5 py-3 sm:py-3.5 text-neutral-500 dark:text-neutral-400">{{ $payout->created_at->format('d M Y') }}</td>
                                                <td class="px-4 sm:px-5 py-3 sm:py-3.5 font-bold text-secondary-900 dark:text-white">Rp {{ number_format($payout->amount, 0, ',', '.') }}</td>
                                                <td class="px-4 sm:px-5 py-3 sm:py-3.5 text-neutral-600 dark:text-neutral-300">{{ $payout->bank_name }} · {{ $payout->bank_account_number }}</td>
                                                <td class="px-4 sm:px-5 py-3 sm:py-3.5">
                                                    <span class="rounded-full px-2 sm:px-2.5 py-0.5 sm:py-1 text-[11px] sm:text-xs font-semibold {{ $payoutStatusBadge }}">
                                                        {{ \App\Models\AffiliatePayout::STATUSES[$payout->status] }}
                                                    </span>
                                                </td>
                                                <td class="max-w-xs whitespace-normal px-4 sm:px-5 py-3 sm:py-3.5 text-neutral-500 dark:text-neutral-400">{{ $payout->transfer_reference ?? $payout->review_note ?? '—' }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="px-4 sm:px-5 py-8 sm:py-10 text-center">
                                                    <div class="flex flex-col items-center gap-2">
                                                        <i class="fa-solid fa-inbox text-xl sm:text-2xl text-neutral-300 dark:text-neutral-600"></i>
                                                        <p class="text-xs sm:text-sm text-neutral-500 dark:text-neutral-400">Belum ada pengajuan pencairan.</p>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            @if($payouts && $payouts->hasPages())
                                <div class="border-t border-neutral-100 px-4 sm:px-5 py-3 sm:py-4 dark:border-secondary-700">{{ $payouts->withQueryString()->links() }}</div>
                            @endif
                        </div>
                    </div>

                    {{-- ── TAB: Penjualan & Komisi ── --}}
                    <div x-show="tab === 'sales'" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0">
                        <div class="mt-4 rounded-2xl border border-neutral-200 bg-white dark:border-secondary-700 dark:bg-secondary-800 shadow-sm overflow-hidden">
                            <div class="border-b border-neutral-100 px-4 sm:px-6 py-3.5 sm:py-4 dark:border-secondary-700 flex items-center justify-between">
                                <h3 class="font-bold text-sm sm:text-base text-secondary-900 dark:text-white">Penjualan & Komisi</h3>
                                <span class="text-[11px] sm:text-xs text-neutral-400 dark:text-neutral-500 sm:hidden">Geser tabel &rarr;</span>
                            </div>
                            <div class="overflow-x-auto">
                                <table class="w-full whitespace-nowrap text-left text-xs sm:text-sm">
                                    <thead class="bg-neutral-50 text-[10px] sm:text-xs font-semibold uppercase tracking-wide text-neutral-500 dark:bg-secondary-900 dark:text-neutral-400 border-b border-neutral-100 dark:border-secondary-700">
                                        <tr>
                                            <th class="px-4 sm:px-5 py-3">Tanggal</th>
                                            <th class="px-4 sm:px-5 py-3">No. Pesanan</th>
                                            <th class="px-4 sm:px-5 py-3">Paket</th>
                                            <th class="px-4 sm:px-5 py-3">Nilai penjualan</th>
                                            <th class="px-4 sm:px-5 py-3">Komisi</th>
                                            <th class="px-4 sm:px-5 py-3">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-neutral-100 dark:divide-secondary-700">
                                        @forelse($commissions as $commission)
                                            <tr class="hover:bg-neutral-50/80 dark:hover:bg-secondary-700/40 transition-colors">
                                                <td class="px-4 sm:px-5 py-3 sm:py-3.5 text-neutral-500 dark:text-neutral-400">{{ $commission->created_at->format('d M Y') }}</td>
                                                <td class="px-4 sm:px-5 py-3 sm:py-3.5 font-mono text-xs font-semibold text-secondary-800 dark:text-neutral-200">{{ $commission->order->order_id }}</td>
                                                <td class="px-4 sm:px-5 py-3 sm:py-3.5 text-neutral-600 dark:text-neutral-300">{{ ucfirst($commission->order->package_type) }}</td>
                                                <td class="px-4 sm:px-5 py-3 sm:py-3.5 text-neutral-600 dark:text-neutral-300">Rp {{ number_format($commission->sale_amount, 0, ',', '.') }}</td>
                                                <td class="px-4 sm:px-5 py-3 sm:py-3.5">
                                                    <p class="font-bold text-secondary-900 dark:text-white">Rp {{ number_format($commission->amount, 0, ',', '.') }}</p>
                                                    <p class="text-[10px] sm:text-xs text-neutral-400 dark:text-neutral-500">{{ $commission->rate }}%</p>
                                                </td>
                                                <td class="px-4 sm:px-5 py-3 sm:py-3.5">
                                                    @if($commission->status === 'earned')
                                                        <span class="rounded-full bg-emerald-50 px-2 sm:px-2.5 py-0.5 sm:py-1 text-[11px] sm:text-xs font-semibold text-emerald-700 dark:bg-emerald-950/70 dark:text-emerald-300 dark:ring-1 dark:ring-emerald-800/50">Tercatat</span>
                                                    @else
                                                        <span class="rounded-full bg-red-50 px-2 sm:px-2.5 py-0.5 sm:py-1 text-[11px] sm:text-xs font-semibold text-red-700 dark:bg-red-950/70 dark:text-red-300 dark:ring-1 dark:ring-red-800/50">Dibatalkan</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="px-4 sm:px-5 py-8 sm:py-10 text-center">
                                                    <div class="flex flex-col items-center gap-2">
                                                        <i class="fa-solid fa-chart-bar text-xl sm:text-2xl text-neutral-300 dark:text-neutral-600"></i>
                                                        <p class="text-xs sm:text-sm text-neutral-500 dark:text-neutral-400">Belum ada penjualan yang berhasil dibayar.</p>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            @if($commissions && $commissions->hasPages())
                                <div class="border-t border-neutral-100 px-4 sm:px-5 py-3 sm:py-4 dark:border-secondary-700">{{ $commissions->withQueryString()->links() }}</div>
                            @endif
                        </div>
                    </div>

                    {{-- ── TAB: Marketing Kit ── --}}
                    <div x-show="tab === 'marketing'" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0">
                        <div class="mt-4">
                            <div class="mb-3 sm:mb-4">
                                <h3 class="font-bold text-sm sm:text-base text-secondary-900 dark:text-white">Marketing Kit</h3>
                                <p class="text-xs sm:text-sm text-neutral-500 dark:text-neutral-400">Banner promo, templat Story Instagram, dan brosur untuk kampanye Anda.</p>
                            </div>
                            @if($assets->count())
                                <div class="grid gap-3 sm:gap-4 sm:grid-cols-2 lg:grid-cols-3">
                                    @foreach($assets as $asset)
                                        <div class="flex flex-col gap-3 rounded-2xl border border-neutral-200 bg-white p-4 sm:p-5 transition hover:shadow-soft dark:border-secondary-700 dark:bg-secondary-800 shadow-sm">
                                            <div class="flex items-start justify-between gap-2">
                                                <span class="rounded-lg bg-primary-50 px-2.5 py-1 text-[11px] sm:text-xs font-semibold uppercase tracking-wide text-primary-700 dark:bg-primary-900/40 dark:text-primary-300">
                                                    {{ \App\Models\MarketingAsset::CATEGORIES[$asset->category] }}
                                                </span>
                                            </div>
                                            <div class="flex-1">
                                                <h4 class="font-semibold text-sm sm:text-base text-secondary-900 dark:text-white">{{ $asset->title }}</h4>
                                                <p class="mt-1 text-xs sm:text-sm text-neutral-500 dark:text-neutral-400 leading-relaxed">{{ $asset->description }}</p>
                                            </div>
                                            <a href="{{ route('dashboard.affiliate.assets.download', $asset) }}"
                                                class="inline-flex items-center gap-1.5 text-xs sm:text-sm font-bold text-primary-700 hover:text-primary-600 hover:underline dark:text-primary-400 dark:hover:text-primary-300">
                                                <i class="fa-solid fa-download text-xs"></i>
                                                Unduh aset
                                                <span class="sr-only">{{ $asset->title }}</span>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="flex flex-col items-center gap-3 rounded-2xl border border-dashed border-neutral-300 bg-neutral-50 py-10 sm:py-14 text-center dark:border-secondary-700 dark:bg-secondary-800/50">
                                    <div class="flex h-12 w-12 sm:h-14 sm:w-14 items-center justify-center rounded-2xl bg-neutral-200 dark:bg-secondary-700">
                                        <i class="fa-solid fa-images text-lg sm:text-xl text-neutral-400 dark:text-neutral-500"></i>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-xs sm:text-sm text-neutral-600 dark:text-neutral-300">Belum ada materi promosi</p>
                                        <p class="mt-1 text-xs text-neutral-400 dark:text-neutral-500">Materi yang diterbitkan admin akan muncul di sini.</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                </div>{{-- end x-data tabs --}}
            @endif

        @endif
    </div>

    @push('scripts')
    <script>
        function affiliateCopy() {
            return {
                copied: null,
                copyText(id) {
                    const el = document.getElementById(id);
                    if (!el) { return; }
                    navigator.clipboard.writeText(el.value).then(() => {
                        this.copied = id;
                        setTimeout(() => { this.copied = null; }, 2000);
                    });
                }
            };
        }
    </script>
    @endpush
</x-app-layout>
