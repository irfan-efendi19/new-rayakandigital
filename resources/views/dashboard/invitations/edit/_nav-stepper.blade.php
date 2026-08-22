{{-- ─── STICKY SECTION NAV (8 STEPS) ─── --}}
        <div class="sticky top-[64px] z-30 bg-white/95 dark:bg-secondary-900/95 backdrop-blur-md border-b border-neutral-200/80 dark:border-secondary-700/60 py-2.5 sm:py-3 shadow-sm">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

                {{-- Mobile: modern custom step dropdown --}}
                <div class="sm:hidden relative" x-data="{ open: false }">
                    {{-- Trigger Button --}}
                    <button type="button" @click="open = !open"
                        class="w-full flex items-center gap-3 bg-white dark:bg-secondary-800 border border-neutral-200/90 dark:border-secondary-700/80 rounded-2xl p-2.5 shadow-sm transition-all duration-200 select-none"
                        :class="open ? 'ring-2 ring-primary/30 border-primary/50' : 'hover:border-neutral-300 dark:hover:border-secondary-600'">

                        {{-- Active step badge --}}
                        <span class="w-8 h-8 rounded-xl bg-primary text-white text-xs font-bold flex items-center justify-center shrink-0 shadow-sm"
                            x-text="sections.find(s => s.id === activeSection)?.num || 1"></span>

                        {{-- Active step name --}}
                        <span class="flex-1 text-left text-sm font-bold text-secondary-800 dark:text-neutral-100 truncate"
                            x-text="sections.find(s => s.id === activeSection)?.name || 'Mempelai'"></span>

                        {{-- Step counter --}}
                        <span class="text-[11px] font-semibold text-neutral-400 dark:text-neutral-500 shrink-0 px-1"
                            x-text="(sections.findIndex(s => s.id === activeSection) + 1) + ' / ' + sections.length"></span>

                        {{-- Animated chevron --}}
                        <svg class="w-4 h-4 text-neutral-400 dark:text-neutral-500 shrink-0 transition-transform duration-200"
                            :class="open ? 'rotate-180 text-primary' : ''"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    {{-- Progress bar --}}
                    <div class="mt-2 h-1 bg-neutral-100 dark:bg-secondary-700/60 rounded-full overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-primary-500 to-primary-700 rounded-full transition-all duration-500"
                            :style="'width:' + ((sections.findIndex(s => s.id === activeSection) + 1) / sections.length * 100) + '%'"></div>
                    </div>

                    {{-- Dropdown Panel --}}
                    <div x-show="open"
                        x-cloak
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 -translate-y-2 scale-95"
                        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                        x-transition:leave-end="opacity-0 -translate-y-2 scale-95"
                        @click.outside="open = false"
                        class="absolute left-0 right-0 top-full mt-2.5 z-50 rounded-2xl border border-neutral-200/90 dark:border-secondary-700/80 bg-white/95 dark:bg-secondary-800/95 backdrop-blur-md shadow-2xl overflow-hidden origin-top">

                        <div class="py-1.5 max-h-[60vh] overflow-y-auto divide-y divide-neutral-100 dark:divide-secondary-750">
                            <template x-for="(sec, i) in sections" :key="sec.id">
                                <button type="button"
                                    @click="scrollTo(sec.id); open = false"
                                    class="w-full flex items-center gap-3 px-3.5 py-2.5 text-left transition-all duration-150"
                                    :class="sec.id === activeSection
                                        ? 'bg-primary/8 dark:bg-primary/15'
                                        : 'hover:bg-neutral-50 dark:hover:bg-secondary-750/70'">

                                    {{-- Circle indicator --}}
                                    <span class="w-7 h-7 rounded-xl flex items-center justify-center text-xs font-bold shrink-0 border transition-all duration-150"
                                        :class="sec.id === activeSection
                                            ? 'bg-primary text-white border-primary shadow-sm ring-2 ring-primary/20'
                                            : (i < sections.findIndex(s => s.id === activeSection)
                                                ? 'bg-primary/10 dark:bg-primary/20 text-primary dark:text-primary-300 border-primary/30'
                                                : 'bg-neutral-100 dark:bg-secondary-700 text-neutral-400 dark:text-neutral-500 border-neutral-200 dark:border-secondary-600')"
                                        x-text="sec.num"></span>

                                    {{-- Step name --}}
                                    <span class="flex-1 text-xs sm:text-sm font-semibold truncate transition-colors duration-150"
                                        :class="sec.id === activeSection
                                            ? 'text-primary dark:text-primary-300'
                                            : 'text-secondary-800 dark:text-neutral-200'"
                                        x-text="sec.name"></span>

                                    {{-- Checkmark for completed steps --}}
                                    <svg x-show="i < sections.findIndex(s => s.id === activeSection)"
                                        class="w-4 h-4 text-primary/70 dark:text-primary-400/80 shrink-0"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                                    </svg>

                                    {{-- Active dot --}}
                                    <span x-show="sec.id === activeSection"
                                        class="w-2 h-2 rounded-full bg-primary shrink-0 shadow-sm ring-2 ring-primary/30"></span>
                                </button>
                            </template>
                        </div>
                    </div>
                </div>

                {{-- Desktop: segmented stepper --}}
                <div class="hidden sm:flex items-start justify-center" id="sticky-nav-container">
                    <template x-for="(sec, i) in sections" :key="sec.id">
                        <div class="relative flex flex-col items-center shrink-0">
                            <div class="flex items-center">
                                <div :class="i > 0 ? 'w-6 md:w-7 flex items-center' : 'w-6 md:w-7 flex items-center invisible'">
                                    <div class="w-full h-0.5 rounded-full transition-colors duration-300"
                                        :class="i <= sections.findIndex(s => s.id === activeSection) ? 'bg-primary' : 'bg-neutral-200 dark:bg-secondary-700'"></div>
                                </div>
                                <button type="button" :id="'nav-item-' + sec.id" @click.prevent="scrollTo(sec.id)"
                                    class="group flex flex-col items-center focus:outline-none cursor-pointer">
                                    <span
                                        class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold border transition-all duration-200"
                                        :class="sec.id === activeSection
                                            ? 'bg-primary text-white border-primary shadow-sm ring-4 ring-primary/15'
                                            : (i < sections.findIndex(s => s.id === activeSection)
                                                ? 'bg-primary-50 dark:bg-primary-900/30 text-primary dark:text-primary-300 border-primary/40'
                                                : 'bg-white dark:bg-secondary-800 text-neutral-400 dark:text-neutral-500 border-neutral-200 dark:border-secondary-700 group-hover:border-primary/50 group-hover:text-primary dark:group-hover:text-primary-300')"
                                        x-text="sec.num"></span>
                                </button>
                                <div :class="i < sections.length - 1 ? 'w-6 md:w-7 flex items-center' : 'w-6 md:w-7 flex items-center invisible'">
                                    <div class="w-full h-0.5 rounded-full transition-colors duration-300"
                                        :class="i < sections.findIndex(s => s.id === activeSection) ? 'bg-primary' : 'bg-neutral-200 dark:bg-secondary-700'"></div>
                                </div>
                            </div>
                            <span
                                class="mt-1.5 hidden lg:block text-[11px] font-medium leading-tight whitespace-nowrap transition-colors duration-200"
                                :class="sec.id === activeSection ? 'text-primary dark:text-primary-300 font-semibold' : 'text-neutral-400 dark:text-neutral-500'"
                                x-text="sec.name"></span>
                        </div>
                    </template>
                </div>
            </div>
        </div>
