{{-- Required fields note --}}
<div
    class="flex items-center gap-1.5 text-xs text-neutral-400 dark:text-neutral-500 pt-2 border-t border-neutral-200/80 dark:border-secondary-700/70">
    <span
        class="inline-flex items-center justify-center w-4 h-4 rounded-full bg-red-50 dark:bg-red-950/40 text-red-500 font-bold text-[10px]">*</span>
    Kolom bertanda bintang wajib diisi sebelum menyimpan
</div>

{{-- Actions --}}
<div class="flex items-center justify-between pt-4">
    <a href="{{ route('dashboard') }}"
        class="inline-flex items-center gap-2 px-5 py-2.5 bg-white dark:bg-secondary-800 border border-neutral-200 dark:border-secondary-700 rounded-xl text-sm font-semibold text-neutral-600 dark:text-neutral-300 hover:bg-neutral-50 dark:hover:bg-secondary-700/80 hover:border-neutral-300 hover:text-neutral-800 dark:hover:text-neutral-100 transition-all duration-150 shadow-sm">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Batal
    </a>
    <button type="button" id="submit-btn" data-tour="publish-btn"
        class="inline-flex items-center gap-2 px-6 py-2.5 bg-gradient-to-r from-primary-500 to-primary-600 text-white rounded-xl shadow-md shadow-primary-500/20 text-sm font-bold hover:shadow-lg hover:shadow-primary-500/30 hover:from-primary-600 hover:to-primary-700 focus:outline-none focus:ring-4 focus:ring-primary-500/20 active:scale-[0.99] transition-all duration-200">
        Simpan & Lanjutkan
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M13 7l5 5m0 0l-5 5m5-5H6" />
        </svg>
    </button>
</div>
