@props([
    'title',
    'eyebrow',
    'description',
    'qrData' => null,
    'downloadName' => null,
    'copyUrl' => null,
    'detailUrl' => null,
    'detailLabel' => 'Buka halaman',
    'newTab' => false,
    'available' => true,
    'requiredTier' => null,
    'upgradeUrl' => null,
])

<article
    {{ $attributes->merge(['class' => 'group relative flex h-full flex-col overflow-hidden rounded-3xl border border-neutral-200/80 bg-white shadow-sm transition-all duration-300 ease-out hover:-translate-y-1 hover:border-primary-200 hover:shadow-xl hover:shadow-primary-500/5 motion-reduce:transform-none motion-reduce:transition-none dark:border-secondary-700/70 dark:bg-secondary-800 dark:hover:border-primary-800/70']) }}
    @if($available && $copyUrl)
        x-data="qrCodeCard"
        data-copy-url="{{ $copyUrl }}"
    @endif
>
    <div class="h-1 w-full bg-gradient-to-r from-primary-300 via-primary to-primary-700"></div>

    <div class="flex flex-1 flex-col p-5 sm:p-6">
        <div class="flex items-start justify-between gap-4">
            <div class="flex min-w-0 items-start gap-3.5">
                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-primary-50 text-primary-600 ring-1 ring-primary-100 transition-all duration-300 ease-out group-hover:-translate-y-0.5 group-hover:bg-primary group-hover:text-white motion-reduce:transform-none motion-reduce:transition-none dark:bg-primary-900/30 dark:text-primary-300 dark:ring-primary-800/50">
                    {{ $icon }}
                </div>
                <div class="min-w-0">
                    <p class="text-[10px] font-bold uppercase tracking-[0.16em] text-primary-600 dark:text-primary-400">
                        {{ $eyebrow }}
                    </p>
                    <h3 class="mt-1 text-base font-bold leading-snug text-secondary-800 dark:text-neutral-100">
                        {{ $title }}
                    </h3>
                </div>
            </div>

            @if(!$available && $requiredTier)
                <span class="inline-flex shrink-0 items-center gap-1 rounded-full border border-amber-200 bg-amber-50 px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider text-amber-700 dark:border-amber-800/60 dark:bg-amber-900/30 dark:text-amber-300">
                    <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                    {{ $requiredTier }}
                </span>
            @endif
        </div>

        <p class="mt-4 text-sm leading-6 text-neutral-500 dark:text-neutral-400">
            {{ $description }}
        </p>

        @if($available && $qrData)
            <div class="mt-5 flex flex-1 flex-col gap-5 sm:flex-row sm:items-end">
                <figure class="mx-auto shrink-0 sm:mx-0">
                    <div class="rounded-2xl bg-white p-2.5 shadow-sm ring-1 ring-neutral-200 transition-all duration-300 ease-out group-hover:scale-[1.015] group-hover:ring-primary-200 motion-reduce:transform-none motion-reduce:transition-none dark:ring-neutral-600">
                        <img src="{{ $qrData }}" alt="{{ $title }}" class="h-32 w-32 object-contain sm:h-36 sm:w-36">
                    </div>
                    <figcaption class="mt-2 text-center text-[10px] font-medium text-neutral-400 dark:text-neutral-500">
                        Siap dipindai & dicetak
                    </figcaption>
                </figure>

                <div class="grid w-full grid-cols-2 gap-2 sm:ml-auto">
                    <a href="{{ $qrData }}" download="{{ $downloadName }}"
                        class="col-span-2 inline-flex min-h-[42px] items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-primary to-primary-600 px-4 py-2.5 text-xs font-bold text-white shadow-sm shadow-primary/20 transition-all duration-200 ease-out hover:-translate-y-0.5 hover:shadow-md active:translate-y-0 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 motion-reduce:transform-none motion-reduce:transition-none dark:focus:ring-offset-secondary-800">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        Unduh PNG
                    </a>

                    @if($detailUrl)
                        <a href="{{ $detailUrl }}" @if($newTab) target="_blank" rel="noopener noreferrer" @endif
                            class="inline-flex min-h-[40px] items-center justify-center gap-1.5 rounded-xl border border-neutral-200 bg-neutral-50 px-3 py-2 text-center text-[11px] font-bold text-secondary-700 transition-all duration-200 ease-out hover:border-primary-200 hover:bg-primary-50 hover:text-primary-700 active:scale-[0.98] focus:outline-none focus:ring-2 focus:ring-primary motion-reduce:transform-none motion-reduce:transition-none dark:border-secondary-600 dark:bg-secondary-700/60 dark:text-neutral-200 dark:hover:border-primary-800 dark:hover:bg-primary-900/20 dark:hover:text-primary-300">
                            {{ $detailLabel }}
                            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    @endif

                    @if($copyUrl)
                        <button type="button" x-on:click="copyLink()" x-bind:class="copied ? 'border-emerald-300 bg-emerald-50 text-emerald-700 dark:border-emerald-700 dark:bg-emerald-900/20 dark:text-emerald-300' : ''"
                            class="inline-flex min-h-[40px] items-center justify-center gap-1.5 rounded-xl border border-neutral-200 bg-white px-3 py-2 text-[11px] font-bold text-neutral-600 transition-all duration-200 ease-out hover:border-primary-200 hover:text-primary-700 active:scale-[0.98] focus:outline-none focus:ring-2 focus:ring-primary motion-reduce:transform-none motion-reduce:transition-none dark:border-secondary-600 dark:bg-secondary-800 dark:text-neutral-300 dark:hover:border-primary-800 dark:hover:text-primary-300">
                            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                            </svg>
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
                    @endif
                </div>
            </div>
        @else
            <div class="mt-5 flex flex-1 flex-col items-center justify-center rounded-2xl border border-dashed border-amber-200 bg-amber-50/60 p-6 text-center dark:border-amber-800/50 dark:bg-amber-900/10">
                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-white text-amber-500 shadow-sm ring-1 ring-amber-100 dark:bg-secondary-800 dark:text-amber-400 dark:ring-amber-800/50">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <p class="mt-3 text-sm font-bold text-secondary-800 dark:text-neutral-100">
                    Aktifkan dengan paket {{ $requiredTier }}
                </p>
                <p class="mt-1 text-xs leading-5 text-neutral-500 dark:text-neutral-400">
                    Upgrade paket untuk membuat, mengunduh, dan membagikan QR ini.
                </p>
                @if($upgradeUrl)
                    <a href="{{ $upgradeUrl }}"
                        class="mt-4 inline-flex min-h-[42px] items-center justify-center gap-2 rounded-xl bg-amber-500 px-4 py-2.5 text-xs font-bold text-white shadow-sm transition-all duration-200 ease-out hover:-translate-y-0.5 hover:bg-amber-600 hover:shadow-md active:translate-y-0 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 motion-reduce:transform-none motion-reduce:transition-none dark:focus:ring-offset-secondary-800">
                        Lihat opsi upgrade
                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                @endif
            </div>
        @endif
    </div>
</article>
