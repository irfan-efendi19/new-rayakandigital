{{-- Sticky Step Progress Bar --}}
<div x-data="{ activeStep: 1 }" x-init="() => {
    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                activeStep = parseInt(entry.target.dataset.step);
            }
        });
    }, { rootMargin: '-120px 0px -60% 0px' });
    document.querySelectorAll('[data-step]').forEach(el => observer.observe(el));
}"
    class="sticky top-[64px] z-30 bg-white/90 dark:bg-secondary-900/90 backdrop-blur-md border-b border-neutral-200/80 dark:border-secondary-800/80 py-3 shadow-sm">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center gap-0 overflow-x-auto no-scrollbar">
            {{-- Step 1 --}}
            <a href="#step-1"
                @click.prevent="document.getElementById('step-1').scrollIntoView({ behavior: 'smooth' })"
                :class="activeStep === 1 ? 'text-primary dark:text-primary-300 font-bold' : 'text-neutral-500 dark:text-neutral-400 hover:text-neutral-800 dark:hover:text-neutral-200 font-medium'"
                class="flex items-center gap-2 px-3 py-1.5 rounded-xl transition-all duration-200 text-xs whitespace-nowrap">
                <span
                    :class="activeStep === 1 ? 'bg-primary-500 text-white shadow-sm ring-2 ring-primary-500/20' : (activeStep > 1 ? 'bg-primary-100 text-primary-700 dark:bg-primary-950/60 dark:text-primary-300' : 'bg-neutral-100 dark:bg-secondary-800 text-neutral-500 dark:text-neutral-400')"
                    class="w-6 h-6 rounded-full text-[11px] flex items-center justify-center font-bold transition-all duration-200 flex-shrink-0">
                    <template x-if="activeStep > 1"><svg class="w-3 h-3" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg></template>
                    <template x-if="activeStep <= 1"><span>1</span></template>
                </span>
                <span class="hidden sm:inline">Konsep & Tema</span>
                <span class="sm:hidden">Tema</span>
            </a>
            {{-- Connector 1→2 --}}
            <div class="flex-1 min-w-[20px] h-0.5 mx-1 rounded-full transition-all duration-500"
                :class="activeStep >= 2 ? 'bg-primary-500/40 dark:bg-primary-400/40' : 'bg-neutral-200 dark:bg-secondary-800'">
            </div>
            {{-- Step 2 --}}
            <a href="#step-2"
                @click.prevent="document.getElementById('step-2').scrollIntoView({ behavior: 'smooth' })"
                :class="activeStep === 2 ? 'text-primary dark:text-primary-300 font-bold' : 'text-neutral-500 dark:text-neutral-400 hover:text-neutral-800 dark:hover:text-neutral-200 font-medium'"
                class="flex items-center gap-2 px-3 py-1.5 rounded-xl transition-all duration-200 text-xs whitespace-nowrap">
                <span
                    :class="activeStep === 2 ? 'bg-primary-500 text-white shadow-sm ring-2 ring-primary-500/20' : (activeStep > 2 ? 'bg-primary-100 text-primary-700 dark:bg-primary-950/60 dark:text-primary-300' : 'bg-neutral-100 dark:bg-secondary-800 text-neutral-500 dark:text-neutral-400')"
                    class="w-6 h-6 rounded-full text-[11px] flex items-center justify-center font-bold transition-all duration-200 flex-shrink-0">
                    <template x-if="activeStep > 2"><svg class="w-3 h-3" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg></template>
                    <template x-if="activeStep <= 2"><span>2</span></template>
                </span>
                <span class="hidden sm:inline">Mempelai</span>
                <span class="sm:hidden">Mempelai</span>
            </a>
            {{-- Connector 2→3 --}}
            <div class="flex-1 min-w-[20px] h-0.5 mx-1 rounded-full transition-all duration-500"
                :class="activeStep >= 3 ? 'bg-primary-500/40 dark:bg-primary-400/40' : 'bg-neutral-200 dark:bg-secondary-800'">
            </div>
            {{-- Step 3 --}}
            <a href="#step-3"
                @click.prevent="document.getElementById('step-3').scrollIntoView({ behavior: 'smooth' })"
                :class="activeStep === 3 ? 'text-primary dark:text-primary-300 font-bold' : 'text-neutral-500 dark:text-neutral-400 hover:text-neutral-800 dark:hover:text-neutral-200 font-medium'"
                class="flex items-center gap-2 px-3 py-1.5 rounded-xl transition-all duration-200 text-xs whitespace-nowrap">
                <span
                    :class="activeStep === 3 ? 'bg-primary-500 text-white shadow-sm ring-2 ring-primary-500/20' : 'bg-neutral-100 dark:bg-secondary-800 text-neutral-500 dark:text-neutral-400'"
                    class="w-6 h-6 rounded-full text-[11px] flex items-center justify-center font-bold transition-all duration-200 flex-shrink-0">3</span>
                <span class="hidden sm:inline">Waktu & Tempat</span>
                <span class="sm:hidden">Waktu</span>
            </a>
        </div>

        <div class="mt-2.5 h-1 rounded-full bg-neutral-200/80 dark:bg-secondary-800 overflow-hidden">
            <div class="h-full bg-gradient-to-r from-primary-500 to-primary-400 rounded-full transition-all duration-500"
                :style="'width: ' + Math.min((activeStep / 3) * 100, 100) + '%'"></div>
        </div>
    </div>
</div>
