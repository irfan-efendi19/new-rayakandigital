@props(['themes', 'categories', 'totalThemes', 'search', 'category'])

<section id="tema" aria-labelledby="tema-heading" class="scroll-mt-20 border-b border-neutral-200 bg-[#F8F5F2] py-14 dark:border-secondary-800 dark:bg-secondary-900 sm:py-20">
    <div class="mx-auto max-w-7xl px-5 sm:px-8 lg:px-12">
        <div class="flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
            <div class="max-w-xl">
                <span class="inline-flex items-center gap-2 text-xs font-bold uppercase tracking-[0.18em] text-primary-700 dark:text-primary-400">
                    <span class="h-px w-7 bg-primary-500" aria-hidden="true"></span>
                    Satu tema, sejuta cerita
                </span>
                <h2 id="tema-heading" class="mt-3 font-heading text-3xl font-bold leading-tight tracking-tight text-secondary-900 dark:text-white sm:text-4xl">Temukan yang paling <span class="font-normal italic text-primary-600 dark:text-primary-400">Anda.</span></h2>
                <p class="mt-4 text-sm leading-7 text-neutral-600 dark:text-neutral-300">Dari sentuhan tradisional hingga modern minimalis. Buka pratinjau dan temukan desain untuk cerita Anda berdua.</p>
            </div>
            <a href="{{ route('themes.index') }}" class="inline-flex min-h-11 shrink-0 items-center gap-2 self-start text-sm font-semibold text-primary-700 underline-offset-4 hover:underline focus-visible:rounded focus-visible:outline focus-visible:outline-2 focus-visible:outline-primary-500 dark:text-primary-400 lg:self-auto">
                Buka katalog lengkap
                <i class="fa-solid fa-arrow-up-right-from-square text-xs" aria-hidden="true"></i>
            </a>
        </div>

        <div class="mt-8 rounded-2xl border border-neutral-200 bg-white p-4 dark:border-secondary-700 dark:bg-secondary-800 sm:p-5">
            <form method="GET" action="{{ route('undangan-web') }}#tema" role="search" aria-label="Cari tema undangan" class="flex flex-col gap-3 sm:flex-row sm:items-center">
                @if($category)
                    <input type="hidden" name="category" value="{{ $category }}">
                @endif
                <label for="theme-search" class="shrink-0 text-sm font-semibold text-secondary-900 dark:text-white">Cari tema favorit</label>
                <div class="flex min-w-0 flex-1 gap-2">
                    <div class="relative min-w-0 flex-1">
                        <i class="fa-solid fa-magnifying-glass pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-sm text-neutral-400" aria-hidden="true"></i>
                        <input id="theme-search" type="search" name="search" value="{{ $search }}" maxlength="100" placeholder="Cari nama tema…"
                            class="h-12 w-full rounded-xl border-neutral-200 bg-neutral-50 pl-11 pr-3 text-sm text-secondary-900 placeholder:text-neutral-400 focus:border-primary-500 focus:ring-primary-500 dark:border-secondary-600 dark:bg-secondary-900 dark:text-white">
                    </div>
                    <button type="submit" class="inline-flex h-12 shrink-0 items-center justify-center rounded-xl bg-secondary-900 px-5 text-sm font-bold text-white transition hover:bg-primary-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary-500 dark:bg-primary-600 dark:hover:bg-primary-700">Cari</button>
                </div>
            </form>

            <nav aria-label="Kategori tema" class="mt-4 flex flex-wrap gap-2 border-t border-neutral-100 pt-4 dark:border-secondary-700">
                <a href="{{ route('undangan-web', $search !== '' ? ['search' => $search] : []) }}#tema"
                    @if(!$category) aria-current="true" @endif
                    class="inline-flex min-h-10 items-center gap-2 rounded-full border px-4 py-2 text-xs font-semibold transition focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary-500 {{ !$category ? 'border-primary-600 bg-primary-600 text-white dark:border-primary-500 dark:bg-primary-500' : 'border-neutral-200 text-neutral-600 hover:border-primary-300 hover:bg-primary-50 dark:border-secondary-600 dark:text-neutral-300 dark:hover:border-primary-700 dark:hover:bg-secondary-700' }}">
                    Semua tema <span class="text-[10px] opacity-80">{{ $totalThemes }}</span>
                </a>
                @foreach($categories as $themeCategory)
                    <a href="{{ route('undangan-web', array_filter(['search' => $search, 'category' => $themeCategory->id], fn ($value) => $value !== '')) }}#tema"
                        @if($category === $themeCategory->id) aria-current="true" @endif
                        class="inline-flex min-h-10 items-center gap-2 rounded-full border px-4 py-2 text-xs font-semibold transition focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary-500 {{ $category === $themeCategory->id ? 'border-primary-600 bg-primary-600 text-white dark:border-primary-500 dark:bg-primary-500' : 'border-neutral-200 text-neutral-600 hover:border-primary-300 hover:bg-primary-50 dark:border-secondary-600 dark:text-neutral-300 dark:hover:border-primary-700 dark:hover:bg-secondary-700' }}">
                        {{ $themeCategory->name }} <span class="text-[10px] opacity-80">{{ $themeCategory->themes_count }}</span>
                    </a>
                @endforeach
            </nav>
        </div>

        <div class="flex flex-wrap items-center justify-between gap-3 py-6">
            <p class="text-xs leading-6 text-neutral-500 dark:text-neutral-400" role="status">
                @if($themes->count())
                    Menampilkan <span class="font-semibold text-secondary-800 dark:text-neutral-200">{{ $themes->firstItem() }}–{{ $themes->lastItem() }}</span> dari <span class="font-semibold text-secondary-800 dark:text-neutral-200">{{ $themes->total() }} tema</span>
                @else
                    {{ $themes->total() }} tema ditemukan
                @endif
                @if($search !== '')
                    untuk <span class="break-all font-semibold text-secondary-800 dark:text-neutral-200">“{{ $search }}”</span>
                @endif
            </p>
            @if($search !== '' || $category)
                <a href="{{ route('undangan-web') }}#tema" class="inline-flex min-h-11 items-center gap-2 text-xs font-semibold text-primary-700 hover:underline focus-visible:outline focus-visible:outline-2 focus-visible:outline-primary-500 dark:text-primary-400">
                    <i class="fa-solid fa-xmark" aria-hidden="true"></i> Hapus filter
                </a>
            @else
                <span class="hidden items-center gap-2 text-xs text-neutral-500 dark:text-neutral-400 sm:inline-flex"><i class="fa-regular fa-eye" aria-hidden="true"></i> Pratinjau tema sebelum memilih</span>
            @endif
        </div>

        <div class="grid grid-cols-1 gap-4 min-[380px]:grid-cols-2 sm:gap-6 lg:grid-cols-4">
            @forelse($themes as $theme)
                <x-theme-card :theme="$theme" variant="showcase" />
            @empty
                <div class="col-span-full flex flex-col items-center rounded-3xl border border-dashed border-neutral-300 bg-white/60 px-6 py-14 text-center dark:border-secondary-700 dark:bg-secondary-800/50">
                    <span class="flex h-16 w-16 items-center justify-center rounded-2xl bg-primary-50 text-2xl text-primary-600 dark:bg-primary-900/30 dark:text-primary-400"><i class="fa-regular fa-images" aria-hidden="true"></i></span>
                    <h3 class="mt-5 font-heading text-2xl font-bold text-secondary-900 dark:text-white">{{ $themes->currentPage() > 1 ? 'Halaman ini tidak memiliki tema' : ($search !== '' || $category ? 'Belum menemukan yang cocok?' : 'Koleksi baru sedang disiapkan') }}</h3>
                    <p class="mt-3 max-w-md text-sm leading-7 text-neutral-500 dark:text-neutral-400">{{ $themes->currentPage() > 1 ? 'Kembali ke halaman pertama untuk menjelajahi tema yang tersedia.' : ($search !== '' || $category ? 'Coba nama tema lain atau jelajahi kembali semua kategori.' : 'Tema undangan akan tampil di sini setelah tersedia. Sementara itu, kenali fitur untuk hari istimewa Anda.') }}</p>
                    <a href="{{ $themes->currentPage() > 1 ? $themes->url(1) : ($search !== '' || $category ? route('undangan-web') . '#tema' : '#fitur') }}" class="mt-6 inline-flex min-h-11 items-center gap-2 rounded-full bg-primary-600 px-6 py-3 text-sm font-bold text-white hover:bg-primary-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary-500">
                        {{ $themes->currentPage() > 1 ? 'Kembali ke halaman pertama' : ($search !== '' || $category ? 'Lihat semua tema' : 'Jelajahi fitur') }} <i class="fa-solid fa-arrow-right text-xs" aria-hidden="true"></i>
                    </a>
                </div>
            @endforelse
        </div>

        @if($themes->hasPages())
            <div class="mt-8 border-t border-neutral-200 pt-6 dark:border-secondary-700">
                {{ $themes->onEachSide(1)->links('vendor.pagination.undangan') }}
            </div>
        @endif

        <div class="mt-8 flex flex-col items-start justify-between gap-4 rounded-2xl border border-primary-200/70 bg-primary-50/80 px-5 py-5 dark:border-primary-800/50 dark:bg-primary-900/10 sm:flex-row sm:items-center sm:px-6">
            <div class="flex items-center gap-3">
                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-white text-primary-600 dark:bg-secondary-800 dark:text-primary-400"><i class="fa-solid fa-wand-magic-sparkles" aria-hidden="true"></i></span>
                <div>
                    <p class="text-sm font-bold text-secondary-900 dark:text-white">Desain pilihan, sentuhan personal.</p>
                    <p class="mt-1 text-xs leading-6 text-neutral-600 dark:text-neutral-400">Sesuaikan foto, cerita, dan detail acara setelah memilih tema.</p>
                </div>
            </div>
            <a href="#cara-kerja" class="inline-flex min-h-11 shrink-0 items-center gap-2 text-xs font-bold text-primary-700 hover:underline focus-visible:outline focus-visible:outline-2 focus-visible:outline-primary-500 dark:text-primary-400">Lihat cara membuat <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></a>
        </div>
    </div>
</section>
