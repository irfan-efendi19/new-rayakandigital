@props(['checkout' => false])

<div x-cloak x-show="featured" x-transition.opacity
    {{ $attributes->class(['sticky z-40 text-white shadow-lg shadow-primary-900/25', 'top-16' => ! $checkout, 'top-0' => $checkout]) }}>
    <div class="banner-gradient relative overflow-hidden">
        {{-- Animated shimmer overlay --}}
        <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/8 to-transparent banner-shimmer"></div>
        {{-- Edge vignette --}}
        <div class="absolute inset-0 bg-gradient-to-r from-black/10 via-transparent to-black/10"></div>
        {{-- Decorative dots --}}
        <div class="absolute -left-6 -top-6 h-24 w-24 rounded-full bg-white/5 blur-xl"></div>
        <div class="absolute -right-6 -bottom-6 h-20 w-20 rounded-full bg-white/5 blur-xl"></div>

        <div class="relative max-w-7xl mx-auto flex flex-wrap items-center justify-center gap-x-5 gap-y-2 px-4 py-2.5 text-sm">

            {{-- Promo title with icon --}}
            <span class="inline-flex items-center gap-2 font-bold tracking-wide">
                <span class="flex h-6 w-6 items-center justify-center rounded-full bg-white/15 backdrop-blur-sm">
                    <svg class="h-3.5 w-3.5 shrink-0" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M5 2a2 2 0 00-2 2v1a1 1 0 000 2v1a2 2 0 002 2h1.17a3 3 0 01-.17 1 3 3 0 01.17 1H5a2 2 0 00-2 2v1a1 1 0 000 2v1a2 2 0 002 2h10a2 2 0 002-2v-1a1 1 0 000-2v-1a2 2 0 00-2-2h-1.17a3 3 0 01.17-1 3 3 0 01-.17-1H15a2 2 0 002-2V7a1 1 0 000-2V4a2 2 0 00-2-2H5z" clip-rule="evenodd"/>
                    </svg>
                </span>
                <span x-text="featured?.promotion.title"></span>
            </span>

            {{-- Divider --}}
            <span class="h-4 w-px bg-white/25 hidden sm:block"></span>

            {{-- Countdown --}}
            <span class="flex items-center gap-2">
                <span class="text-white/80 text-xs font-medium uppercase tracking-wider">Berakhir</span>
                <span class="inline-flex items-center gap-1.5 rounded-full bg-black/20 px-3 py-1.5 font-mono text-xs font-bold tabular-nums backdrop-blur-sm ring-1 ring-white/10"
                    role="timer" aria-label="Sisa waktu promo"
                    x-data="{ prev: null, labels: ['jam','mnt','dtk'] }"
                    x-effect="prev = countdown(featured?.promotion)"
                >
                    <template x-for="(seg, i) in (countdown(featured?.promotion) || '00:00:00').split(':')" :key="i">
                        <span class="inline-flex items-center gap-1">
                            <span class="flex flex-col items-center gap-0.5">
                                <span class="inline-flex gap-0.5">
                                    <template x-for="(ch, j) in seg.split('')" :key="j">
                                        <span class="countdown-digit-wrapper" x-data="{ shown: ch, prev: ch }"
                                            x-effect="
                                                if (ch !== prev) {
                                                    $el.classList.remove('digit-flip');
                                                    void $el.offsetWidth;
                                                    $el.classList.add('digit-flip');
                                                    prev = ch;
                                                }
                                                shown = ch;
                                            ">
                                            <span class="countdown-digit rounded bg-white/10 shadow-inner shadow-black/10" x-text="shown"></span>
                                        </span>
                                    </template>
                                </span>
                                <span class="text-[8px] font-sans font-medium uppercase tracking-wider text-white/50 leading-none" x-text="labels[i]"></span>
                            </span>
                            <template x-if="i < 2">
                                <span class="text-white/30 font-bold countdown-colon self-start mt-0.5">:</span>
                            </template>
                        </span>
                    </template>
                </span>
            </span>

            {{-- CTA button --}}
            <a href="{{ $checkout ? '#pilih-paket' : route('dashboard.checkout') }}"
                class="group inline-flex items-center gap-1.5 rounded-full bg-white px-5 py-1.5 text-xs font-bold text-primary-700 shadow-md shadow-primary-900/20 transition-all duration-200 hover:shadow-lg hover:shadow-primary-900/30 hover:scale-105 active:scale-95">
                <svg class="h-3.5 w-3.5 text-primary-500" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-11.25a.75.75 0 00-1.5 0v2.5h-2.5a.75.75 0 000 1.5h2.5v2.5a.75.75 0 001.5 0v-2.5h2.5a.75.75 0 000-1.5h-2.5v-2.5z" clip-rule="evenodd"/>
                </svg>
                Klaim Diskon
                <svg class="h-3 w-3 transition-transform duration-200 group-hover:translate-x-0.5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M3 10a.75.75 0 01.75-.75h10.638L10.23 5.29a.75.75 0 111.04-1.08l5.5 5.25a.75.75 0 010 1.08l-5.5 5.25a.75.75 0 11-1.04-1.08l4.158-3.96H3.75A.75.75 0 013 10z" clip-rule="evenodd"/>
                </svg>
            </a>
        </div>
    </div>
</div>
