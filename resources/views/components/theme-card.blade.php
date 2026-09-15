@props([
    'theme',
    'variant' => 'catalog',
])

@php
    $isCarousel = $variant === 'carousel';
    $previewUrl = route('theme.preview', $theme->slug);
    $useUrl = auth()->check()
        ? route('dashboard.invitations.create', ['theme' => $theme->slug])
        : route('register', ['theme' => $theme->slug]);
@endphp

<article
    {{ $attributes->merge([
        'class' => 'group relative isolate flex h-full flex-col overflow-hidden rounded-3xl border border-white/80 bg-white/95 shadow-[0_18px_45px_-28px_rgba(24,24,27,0.65)] ring-1 ring-neutral-200/80 backdrop-blur-xl transition-all duration-300 ease-out hover:-translate-y-1.5 hover:ring-primary-200 hover:shadow-[0_30px_64px_-28px_rgba(255,122,0,0.45)] focus-within:ring-2 focus-within:ring-primary-300 motion-reduce:transform-none motion-reduce:transition-none dark:border-white/[0.04] dark:bg-secondary-800/95 dark:ring-secondary-700 dark:hover:ring-primary-800 dark:focus-within:ring-primary-700',
    ]) }}
>
    <a href="{{ $previewUrl }}" target="_blank" rel="noopener noreferrer"
        aria-label="Lihat pratinjau tema {{ $theme->name }}"
        class="relative block aspect-[3/4] overflow-hidden bg-neutral-100 focus:outline-none dark:bg-secondary-700">
        @if($theme->thumbnail_url)
            <img src="{{ $theme->thumbnail_url }}" alt="Pratinjau tema {{ $theme->name }}" width="360" height="480"
                loading="lazy" decoding="async"
                class="absolute inset-0 h-full w-full object-cover object-top transition-transform duration-700 ease-out group-hover:scale-[1.04] motion-reduce:transform-none motion-reduce:transition-none">
        @else
            <div class="absolute inset-0 flex items-center justify-center bg-gradient-to-br from-primary-50 via-white to-amber-50 dark:from-secondary-700 dark:via-secondary-800 dark:to-primary-900/20">
                <div class="px-5 text-center">
                    <span class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-white/80 text-primary-400 shadow-sm ring-1 ring-primary-100 dark:bg-secondary-700 dark:text-primary-500 dark:ring-primary-900/60">
                        <i class="fas fa-images text-xl" aria-hidden="true"></i>
                    </span>
                    <span class="mt-3 block text-xs font-semibold leading-relaxed text-neutral-500 dark:text-neutral-400">
                        {{ $theme->name }}
                    </span>
                </div>
            </div>
        @endif

        <div class="pointer-events-none absolute inset-0 bg-gradient-to-b from-black/35 via-transparent to-black/70"></div>

        <div class="absolute inset-x-0 top-0 flex items-start p-3 sm:p-4">
            @if($theme->is_premium)
                <span class="inline-flex items-center gap-1.5 rounded-full border border-white/20 bg-secondary-900/70 px-2.5 py-1 text-[10px] font-bold uppercase tracking-[0.1em] text-white shadow-sm backdrop-blur-md">
                    <i class="fas fa-crown text-[9px] text-amber-300" aria-hidden="true"></i>
                    Premium
                </span>
            @else
                <span class="inline-flex items-center gap-1.5 rounded-full border border-white/60 bg-white/90 px-2.5 py-1 text-[10px] font-bold uppercase tracking-[0.1em] text-emerald-700 shadow-sm backdrop-blur-md">
                    <i class="fas fa-gem text-[9px]" aria-hidden="true"></i>
                    Gratis
                </span>
            @endif

        </div>

        <div class="absolute inset-x-0 bottom-0 flex items-end justify-between gap-3 p-3 sm:p-4">
            <div class="min-w-0 text-white">
                <span class="block text-[9px] font-bold uppercase tracking-[0.18em] text-white/65">Pratinjau langsung</span>
                <span class="mt-0.5 block truncate text-xs font-semibold">Buka desain</span>
            </div>
            <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full border border-white/30 bg-white/15 text-white shadow-sm backdrop-blur-md transition-all duration-300 group-hover:scale-110 group-hover:bg-white group-hover:text-primary-600 motion-reduce:transform-none motion-reduce:transition-none">
                <i class="fas fa-arrow-up-right-from-square text-[10px]" aria-hidden="true"></i>
            </span>
        </div>
    </a>

    <div class="relative h-1 overflow-hidden bg-primary-100 dark:bg-primary-950/50">
        <div class="absolute inset-y-0 left-0 w-1/3 bg-gradient-to-r from-primary-400 via-primary-500 to-amber-400 transition-all duration-500 ease-out group-hover:w-full motion-reduce:transition-none"></div>
    </div>

    <div class="relative flex flex-1 flex-col bg-gradient-to-b from-white to-neutral-50/70 p-4 sm:p-5 dark:from-secondary-800 dark:to-secondary-900/50">
        <div class="pointer-events-none absolute -right-10 -top-10 h-24 w-24 rounded-full bg-primary-100/60 blur-2xl transition-colors duration-300 group-hover:bg-primary-200/80 dark:bg-primary-900/10 dark:group-hover:bg-primary-900/20"></div>

        <div class="relative min-w-0">
            @if($theme->themeCategory)
                <span class="inline-flex max-w-full items-center gap-2 text-[9px] font-bold uppercase tracking-[0.16em] text-primary-600 dark:text-primary-400">
                    <span class="h-px w-5 shrink-0 bg-primary-400" aria-hidden="true"></span>
                    <span class="truncate">{{ $theme->themeCategory->name }}</span>
                </span>
            @else
                <span class="inline-flex items-center gap-2 text-[9px] font-bold uppercase tracking-[0.16em] text-neutral-400 dark:text-neutral-500">
                    <span class="h-px w-5 shrink-0 bg-primary-300 dark:bg-primary-800" aria-hidden="true"></span>
                    Koleksi pilihan
                </span>
            @endif

            <h3 class="mt-2 truncate font-heading font-bold leading-snug text-secondary-900 transition-colors duration-200 group-hover:text-primary-600 dark:text-neutral-100 dark:group-hover:text-primary-400 {{ $isCarousel ? 'text-lg' : 'text-base' }}"
                title="{{ $theme->name }}">
                {{ $theme->name }}
            </h3>
        </div>

        <div class="relative mt-5 grid grid-cols-[minmax(0,1fr)_2.75rem] gap-2">
            <a href="{{ $useUrl }}"
                class="inline-flex min-h-11 items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-primary-500 to-primary-600 px-3 py-2.5 text-xs font-bold text-white shadow-md shadow-primary-500/20 transition-all duration-200 hover:from-primary-600 hover:to-primary-700 hover:shadow-lg hover:shadow-primary-500/25 active:scale-[0.98] focus:outline-none focus-visible:ring-2 focus-visible:ring-primary-500 focus-visible:ring-offset-2 motion-reduce:transform-none motion-reduce:transition-none dark:focus-visible:ring-offset-secondary-800">
                <i class="fas fa-wand-magic-sparkles text-[10px]" aria-hidden="true"></i>
                @if($isCarousel)
                    Pilih tema
                @else
                    <span class="sm:hidden">Pilih</span>
                    <span class="hidden sm:inline">Pilih tema</span>
                @endif
            </a>
            <a href="{{ $previewUrl }}" target="_blank" rel="noopener noreferrer"
                aria-label="Pratinjau {{ $theme->name }}" title="Lihat pratinjau"
                class="inline-flex h-11 w-11 items-center justify-center rounded-xl border border-neutral-200 bg-white text-neutral-500 shadow-sm transition-all duration-200 hover:-translate-y-0.5 hover:border-primary-300 hover:bg-primary-50 hover:text-primary-600 hover:shadow-md active:translate-y-0 active:scale-95 focus:outline-none focus-visible:ring-2 focus-visible:ring-primary-500 motion-reduce:transform-none motion-reduce:transition-none dark:border-secondary-600 dark:bg-secondary-700/70 dark:text-neutral-300 dark:hover:border-primary-800 dark:hover:bg-primary-900/20 dark:hover:text-primary-300">
                <i class="fas fa-eye text-xs" aria-hidden="true"></i>
            </a>
        </div>
    </div>
</article>
