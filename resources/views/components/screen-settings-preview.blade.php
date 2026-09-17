@props(['invitation', 'presets', 'currentTheme', 'screenGalleries'])

<aside class="min-w-0 lg:sticky lg:top-24" aria-label="Pratinjau dan panduan layar sapa">
    <div class="overflow-hidden rounded-2xl border border-neutral-200 bg-white shadow-sm dark:border-secondary-700 dark:bg-secondary-800">
        <div class="flex items-center justify-between gap-3 px-5 py-4">
            <h2 class="text-sm font-bold">Pratinjau konten</h2>
            <span class="inline-flex items-center gap-1.5 text-[10px] font-semibold text-neutral-500 dark:text-neutral-400"><span class="h-1.5 w-1.5 rounded-full bg-emerald-500" aria-hidden="true"></span>Sesuai isian</span>
        </div>
        <div class="px-4 pb-4">
            <div class="rounded-xl bg-secondary-900 p-2 shadow-inner">
                <div class="relative flex aspect-video items-center justify-center overflow-hidden rounded-lg bg-gradient-to-br from-[#392d29] via-[#1c1917] to-[#422b1e] text-center text-white">
                    <template x-if="previewBackground"><img :src="previewBackground" alt="" class="absolute inset-0 h-full w-full object-cover"></template>
                    <div class="absolute inset-0 bg-black/45"></div>
                    <div class="relative z-10 flex w-full flex-col items-center gap-2 px-6 pb-5">
                        <span class="text-[8px] font-semibold uppercase tracking-[0.25em] text-orange-200">The wedding of</span>
                        <p class="line-clamp-2 w-full break-words font-heading text-xl font-semibold leading-tight sm:text-2xl" x-text="names.trim() || defaultNames">{{ $invitation->couple_nickname }}</p>
                        <span class="h-px w-8 bg-orange-200/50" aria-hidden="true"></span>
                        <p class="line-clamp-2 w-full break-words text-[10px] text-white/90" x-text="title.trim() || 'Selamat Datang'">Selamat Datang</p>
                        <p class="text-xs font-semibold">Tamu Undangan</p>
                    </div>
                    <div x-show="wishes" class="absolute inset-x-0 bottom-0 border-t border-white/10 bg-black/30 px-3 py-2 text-[8px] text-white/70"><i class="fa-regular fa-heart mr-1" aria-hidden="true"></i>Semoga bahagia selalu dalam setiap langkah bersama.</div>
                </div>
                <div class="flex justify-center py-1.5"><span class="h-1 w-1 rounded-full bg-neutral-500"></span></div>
            </div>
            <p class="mt-3 text-[11px] leading-5 text-neutral-500 dark:text-neutral-400">Ilustrasi teks dan latar. Tata letak akhir mengikuti tema yang dipilih.</p>
        </div>
        <dl class="grid gap-4 border-t border-neutral-100 p-5 text-xs dark:border-secondary-700">
            <div class="flex items-start justify-between gap-4"><dt class="shrink-0 text-neutral-500 dark:text-neutral-400">Tema pilihan</dt><dd class="text-right font-semibold" x-text="selectedPreset?.name || 'Belum dipilih'">{{ $presets->firstWhere('slug', $currentTheme)?->name ?? 'Belum dipilih' }}</dd></div>
            <div class="flex items-center justify-between gap-4"><dt class="text-neutral-500 dark:text-neutral-400">Dinding ucapan</dt><dd class="font-semibold" x-text="wishes ? 'Ditampilkan' : 'Disembunyikan'"></dd></div>
            <div class="flex items-center justify-between gap-4"><dt class="text-neutral-500 dark:text-neutral-400">Slideshow</dt><dd class="font-semibold"><span x-text="galleryCount">{{ $screenGalleries->count() }}</span> foto</dd></div>
        </dl>
    </div>
    <div class="mt-4 rounded-2xl border border-primary-200/70 bg-primary-50/60 p-5 dark:border-primary-800/40 dark:bg-primary-900/10">
        <h3 class="flex items-center gap-2 text-xs font-bold text-primary-800 dark:text-primary-300"><i class="fa-regular fa-lightbulb" aria-hidden="true"></i>Siap ditampilkan di lokasi acara</h3>
        <ol class="mt-3 grid list-inside list-decimal gap-2 text-xs leading-6 text-neutral-600 dark:text-neutral-400"><li>Simpan pengaturan yang sudah Anda sesuaikan.</li><li>Buka layar sapa di perangkat yang terhubung ke proyektor.</li><li>Gunakan mode layar penuh pada browser.</li></ol>
        <a href="{{ route('dashboard.welcome-screen.index', $invitation) }}" target="_blank" rel="noopener noreferrer" class="mt-4 inline-flex min-h-10 items-center gap-2 text-xs font-bold text-primary-700 hover:underline dark:text-primary-300">Lihat tampilan tersimpan<i class="fa-solid fa-arrow-up-right-from-square text-[10px]" aria-hidden="true"></i></a>
    </div>
</aside>
