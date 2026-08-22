{{-- ======================================== --}}
{{-- STEP 2: Informasi Mempelai (Profil) --}}
{{-- ======================================== --}}
<div id="step-2" data-step="2"
    class="border-b border-neutral-200/80 dark:border-secondary-700/70 pb-8 scroll-mt-28"
    data-tour="mempelai-info">
    <div class="flex items-center gap-3 mb-2">
        <div
            class="w-8 h-8 rounded-xl bg-primary-500 text-white font-bold text-sm flex items-center justify-center flex-shrink-0">
            2
        </div>
        <div>
            <h3
                class="font-heading text-lg font-bold text-secondary-900 dark:text-neutral-100">
                Informasi Mempelai <span
                    class="text-sm font-normal text-neutral-400 dark:text-neutral-500">(Profil)</span>
            </h3>
        </div>
    </div>
    <p class="text-sm text-neutral-500 dark:text-neutral-400 mb-6">Data lengkap kedua
        mempelai yang akan tampil di halaman utama.</p>

    <div x-data="{
        order: '{{ old('bride_groom_order', 'male_first') }}',
        toggleOrder() { this.order = this.order === 'male_first' ? 'female_first' : 'male_first'; }
    }" class="flex flex-col gap-6">

        <input type="hidden" name="bride_groom_order" :value="order">

        {{-- Swap Button --}}
        <div class="flex justify-center -mb-2">
            <button @click="toggleOrder" type="button"
                class="inline-flex items-center gap-2 px-4 py-2 text-xs font-semibold rounded-xl text-primary-600 dark:text-primary-400 bg-primary-50 dark:bg-primary-500/10 border border-primary-200 dark:border-primary-500/30 hover:bg-primary-100 dark:hover:bg-primary-500/20 dark:hover:border-primary-500/50 transition-all duration-150 active:scale-95 shadow-sm">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                </svg>
                Tukar Urutan Posisi
            </button>
        </div>

        @include('dashboard.invitations.create._step-2-bride')
        @include('dashboard.invitations.create._step-2-groom')
    </div>
</div>
