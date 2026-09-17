<section id="wedding-planner" aria-labelledby="wedding-planner-title"
    class="relative scroll-mt-20 overflow-hidden border-t border-primary-100/70 bg-[#FFF4EB] py-20 dark:border-secondary-800 dark:bg-secondary-800/40 sm:py-24">
    <div aria-hidden="true"
        class="pointer-events-none absolute -right-32 top-12 h-96 w-96 rounded-full bg-primary-200/30 blur-3xl dark:bg-primary-900/10"></div>

    <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 items-center gap-12 lg:grid-cols-2 lg:gap-16">
            <div class="flex flex-col items-start gap-7" data-aos="fade-up">
                <div class="flex flex-col gap-4">
                    <p class="flex items-center gap-2 text-xs font-bold uppercase tracking-[0.2em] text-primary-700 dark:text-primary-400">
                        <i class="fas fa-heart" aria-hidden="true"></i>
                        Wedding Planner Gratis
                    </p>
                    <h2 id="wedding-planner-title"
                        class="font-heading text-4xl font-bold leading-tight text-secondary-900 dark:text-neutral-100 sm:text-5xl">
                        Daftar undangan,<br>
                        Wedding Planner <span class="text-primary-600 dark:text-primary-400">GRATIS.</span>
                    </h2>
                    <p class="max-w-lg text-base leading-relaxed text-neutral-600 dark:text-neutral-300 sm:text-lg">
                        Cukup daftar undangan di Rayakan Digital untuk menikmati Wedding Planner gratis.
                        Kelola checklist, anggaran, vendor, dan jadwal dalam satu tempat, tanpa perlu membeli paket undangan berbayar.
                    </p>
                </div>

                <div class="flex w-full items-start gap-3 rounded-2xl border border-emerald-200 bg-emerald-50 p-4 dark:border-emerald-800 dark:bg-emerald-900/20">
                    <i class="fas fa-circle-check pt-0.5 text-emerald-700 dark:text-emerald-400" aria-hidden="true"></i>
                    <div class="flex flex-col gap-1.5">
                        <p class="text-sm font-bold text-emerald-800 dark:text-emerald-300">Undangan expired? Planner tetap bisa dipakai.</p>
                        <p class="text-sm leading-relaxed text-emerald-800 dark:text-emerald-200">Wedding Planner tetap bisa digunakan meski masa aktif undangan berakhir. Tidak perlu memperpanjang undangan untuk melanjutkan persiapan.</p>
                    </div>
                </div>

                <ul class="grid w-full grid-cols-1 gap-6 sm:grid-cols-2">
                    <li class="flex items-start gap-3">
                        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white text-primary-600 dark:bg-secondary-800 dark:text-primary-400">
                            <i class="fas fa-list-check" aria-hidden="true"></i>
                        </span>
                        <div class="flex flex-col gap-1.5">
                            <h3 class="text-sm font-bold text-secondary-900 dark:text-neutral-100">Tahu harus mulai dari mana</h3>
                            <p class="text-sm leading-relaxed text-neutral-600 dark:text-neutral-400">Checklist persiapan membantu Anda melangkah satu per satu dan melihat progresnya.</p>
                        </div>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white text-primary-600 dark:bg-secondary-800 dark:text-primary-400">
                            <i class="fas fa-wallet" aria-hidden="true"></i>
                        </span>
                        <div class="flex flex-col gap-1.5">
                            <h3 class="text-sm font-bold text-secondary-900 dark:text-neutral-100">Anggaran lebih terkendali</h3>
                            <p class="text-sm leading-relaxed text-neutral-600 dark:text-neutral-400">Catat estimasi biaya, pembayaran, dan sisa tagihan agar pengeluaran lebih terarah.</p>
                        </div>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white text-primary-600 dark:bg-secondary-800 dark:text-primary-400">
                            <i class="fas fa-address-book" aria-hidden="true"></i>
                        </span>
                        <div class="flex flex-col gap-1.5">
                            <h3 class="text-sm font-bold text-secondary-900 dark:text-neutral-100">Detail vendor mudah dicari</h3>
                            <p class="text-sm leading-relaxed text-neutral-600 dark:text-neutral-400">Simpan kontak, biaya, dan status vendor dengan rapi saat Anda membutuhkannya.</p>
                        </div>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white text-primary-600 dark:bg-secondary-800 dark:text-primary-400">
                            <i class="fas fa-calendar-check" aria-hidden="true"></i>
                        </span>
                        <div class="flex flex-col gap-1.5">
                            <h3 class="text-sm font-bold text-secondary-900 dark:text-neutral-100">Jadwal tertata hingga hari H</h3>
                            <p class="text-sm leading-relaxed text-neutral-600 dark:text-neutral-400">Atur agenda persiapan dan rundown acara, dari lamaran hingga momen akad.</p>
                        </div>
                    </li>
                </ul>

                <div class="flex w-full flex-col items-start gap-3">
                    @auth
                        <a href="{{ route('dashboard.planner.index') }}" id="wedding-planner-cta"
                            class="group inline-flex w-full items-center justify-center gap-3 rounded-2xl bg-primary-600 px-7 py-4 text-sm font-bold text-white shadow-lg shadow-primary-600/20 transition-colors hover:bg-primary-700 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-primary-600 focus-visible:ring-offset-4 focus-visible:ring-offset-[#FFF4EB] dark:focus-visible:ring-offset-secondary-900 sm:w-auto">
                            Buka Wedding Planner Gratis
                            <i class="fas fa-arrow-right text-xs transition-transform group-hover:translate-x-1 motion-reduce:transform-none" aria-hidden="true"></i>
                        </a>
                    @else
                        <a href="{{ route('register') }}" id="wedding-planner-cta"
                            class="group inline-flex w-full items-center justify-center gap-3 rounded-2xl bg-primary-600 px-7 py-4 text-sm font-bold text-white shadow-lg shadow-primary-600/20 transition-colors hover:bg-primary-700 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-primary-600 focus-visible:ring-offset-4 focus-visible:ring-offset-[#FFF4EB] dark:focus-visible:ring-offset-secondary-900 sm:w-auto">
                            Daftar &amp; Dapatkan Planner Gratis
                            <i class="fas fa-arrow-right text-xs transition-transform group-hover:translate-x-1 motion-reduce:transform-none" aria-hidden="true"></i>
                        </a>
                    @endauth
                    <p class="text-xs leading-relaxed text-neutral-600 dark:text-neutral-400">Cukup daftar undangan. Tanpa biaya tambahan untuk Wedding Planner.</p>
                </div>
            </div>

            <figure class="mx-auto flex w-full min-w-0 max-w-lg flex-col gap-4 lg:max-w-none" data-aos="fade-up" data-aos-delay="100">
                <div class="overflow-hidden rounded-3xl border border-primary-200/70 bg-white shadow-[0_24px_70px_-24px_rgba(140,64,0,0.2)] dark:border-secondary-700 dark:bg-secondary-800">
                    <div class="flex items-center justify-between gap-3 border-b border-neutral-100 px-5 py-4 dark:border-secondary-700 sm:px-7">
                        <div class="flex items-center gap-2.5">
                            <span class="flex h-8 w-8 items-center justify-center rounded-xl bg-primary-50 text-primary-600 dark:bg-primary-900/30 dark:text-primary-400">
                                <i class="fas fa-heart text-sm" aria-hidden="true"></i>
                            </span>
                            <span class="text-sm font-bold text-secondary-900 dark:text-neutral-100">Wedding Planner</span>
                        </div>
                        <span class="rounded-full bg-neutral-100 px-2.5 py-1 text-[10px] font-semibold text-neutral-500 dark:bg-secondary-700 dark:text-neutral-300">Ilustrasi</span>
                    </div>

                    <div class="flex flex-col gap-5 p-5 sm:p-7">
                        <div class="flex items-center justify-between gap-4">
                            <div class="flex flex-col gap-1">
                                <p class="text-xs text-neutral-500 dark:text-neutral-400">Selangkah lebih dekat menuju</p>
                                <p class="font-heading text-2xl font-bold text-secondary-900 dark:text-neutral-100">Hari bahagia Anda</p>
                            </div>
                            <div class="flex shrink-0 flex-col items-center gap-0.5 rounded-2xl bg-primary-50 px-3 py-2.5 text-primary-700 dark:bg-primary-900/30 dark:text-primary-300">
                                <span class="text-xl font-extrabold">H-90</span>
                                <span class="text-[10px] font-medium">menuju hari H</span>
                            </div>
                        </div>

                        <div class="flex flex-col gap-3 rounded-2xl bg-[#FDFCFA] p-4 dark:bg-secondary-900/60">
                            <div class="flex items-center justify-between gap-3">
                                <p class="text-xs font-semibold text-secondary-700 dark:text-neutral-300">Progres persiapan</p>
                                <span class="text-sm font-extrabold text-primary-600 dark:text-primary-400">75%</span>
                            </div>
                            <div class="h-2 overflow-hidden rounded-full bg-primary-100 dark:bg-secondary-700" aria-hidden="true">
                                <div class="h-full w-3/4 rounded-full bg-primary-500"></div>
                            </div>
                            <p class="text-xs text-neutral-500 dark:text-neutral-400">3 dari 4 langkah selesai. Sedikit lagi, makin siap!</p>
                        </div>

                        <div class="flex flex-col gap-3">
                            <p class="text-xs font-bold uppercase tracking-wider text-neutral-500 dark:text-neutral-400">Checklist Anda</p>
                            <ul class="flex flex-col gap-3 text-xs sm:text-sm">
                                <li class="flex items-center gap-3 text-neutral-500 dark:text-neutral-400">
                                    <i class="fas fa-circle-check text-base text-emerald-600 dark:text-emerald-400" aria-hidden="true"></i>
                                    <span class="sr-only">Selesai:</span>
                                    <span class="line-through">Tentukan tanggal &amp; venue</span>
                                </li>
                                <li class="flex items-center gap-3 text-neutral-500 dark:text-neutral-400">
                                    <i class="fas fa-circle-check text-base text-emerald-600 dark:text-emerald-400" aria-hidden="true"></i>
                                    <span class="sr-only">Selesai:</span>
                                    <span class="line-through">Pilih vendor dokumentasi</span>
                                </li>
                                <li class="flex items-center gap-3 text-neutral-500 dark:text-neutral-400">
                                    <i class="fas fa-circle-check text-base text-emerald-600 dark:text-emerald-400" aria-hidden="true"></i>
                                    <span class="sr-only">Selesai:</span>
                                    <span class="line-through">Susun anggaran pernikahan</span>
                                </li>
                                <li class="flex items-center gap-3 font-semibold text-secondary-800 dark:text-neutral-200">
                                    <i class="far fa-circle text-base text-primary-600 dark:text-primary-400" aria-hidden="true"></i>
                                    <span class="sr-only">Belum selesai:</span>
                                    <span>Jadwalkan fitting busana</span>
                                </li>
                            </ul>
                        </div>

                        <div class="grid grid-cols-2 gap-3 border-t border-neutral-100 pt-5 dark:border-secondary-700">
                            <div class="flex flex-col gap-1.5 rounded-2xl bg-neutral-50 p-3.5 dark:bg-secondary-900/60 sm:p-4">
                                <p class="text-xs text-neutral-500 dark:text-neutral-400">Estimasi biaya</p>
                                <p class="text-lg font-extrabold text-secondary-900 dark:text-neutral-100 sm:text-xl">Rp80 juta</p>
                            </div>
                            <div class="flex flex-col gap-1.5 rounded-2xl bg-emerald-50 p-3.5 dark:bg-emerald-900/20 sm:p-4">
                                <p class="text-xs text-emerald-700 dark:text-emerald-300">Sudah dibayar</p>
                                <p class="text-lg font-extrabold text-emerald-700 dark:text-emerald-300 sm:text-xl">Rp52 juta</p>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-start gap-3 bg-primary-50 px-5 py-4 dark:bg-primary-900/20 sm:px-7">
                        <i class="fas fa-file-pdf pt-0.5 text-primary-600 dark:text-primary-400" aria-hidden="true"></i>
                        <p class="text-xs leading-relaxed text-primary-800 dark:text-primary-200">Rencana sudah rapi? Unduh rangkumannya dalam PDF untuk dibagikan kepada pasangan atau keluarga.</p>
                    </div>
                </div>
                <figcaption class="text-center text-xs leading-relaxed text-neutral-500 dark:text-neutral-400">Ilustrasi planner dengan data contoh. Rencana Anda, sesuai kebutuhan Anda.</figcaption>
            </figure>
        </div>
    </div>
</section>
