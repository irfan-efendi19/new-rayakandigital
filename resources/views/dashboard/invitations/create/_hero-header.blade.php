{{-- Hero Header --}}
<div class="hero-mesh grain-overlay border-b border-neutral-200/60 dark:border-secondary-700/40">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-7 sm:py-8">
        <nav class="flex items-center gap-1.5 text-xs text-neutral-400 dark:text-neutral-500 mb-4">
            <a href="{{ route('dashboard') }}"
                class="hover:text-primary dark:hover:text-primary-400 transition-colors">Dashboard</a>
            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
            </svg>
            <span class="text-neutral-600 dark:text-neutral-400 font-medium">Buat Undangan</span>
        </nav>

        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
            <div>
                <h1
                    class="font-heading text-2xl sm:text-3xl font-bold text-secondary-800 dark:text-neutral-50 leading-tight">
                    Buat Undangan Baru
                </h1>
                <p class="text-sm text-neutral-500 dark:text-neutral-400 mt-1">Lengkapi data berikut untuk membuat
                    undangan digital Anda.</p>
            </div>
            <div class="flex items-center gap-2 self-start">
                <button type="button" id="btn-start-tour"
                    class="inline-flex items-center gap-2 px-3.5 py-2 text-xs font-semibold text-primary dark:text-primary-300 bg-white/70 dark:bg-secondary-800/50 border border-primary/30 dark:border-primary-800 rounded-xl hover:bg-primary-50 dark:hover:bg-primary-900/30 transition-all backdrop-blur-sm">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Panduan Tutorial
                </button>
                <a href="{{ route('dashboard') }}"
                    class="inline-flex items-center gap-2 px-3.5 py-2 text-xs font-semibold text-neutral-700 dark:text-neutral-300 bg-white/70 dark:bg-secondary-800/50 border border-neutral-300/80 dark:border-secondary-600 rounded-xl hover:bg-white dark:hover:bg-secondary-700 transition-all backdrop-blur-sm">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali
                </a>
            </div>
        </div>
    </div>
</div>
