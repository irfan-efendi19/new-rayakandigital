{{-- Step Header Indicator inside the Form Card --}}
                        <div class="mb-8 pb-5 border-b border-neutral-100 dark:border-secondary-700/50 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-2xl bg-primary/10 dark:bg-primary-900/30 flex items-center justify-center text-primary dark:text-primary-300 shadow-sm border border-primary/20 shrink-0">
                                    {{-- SVGs corresponding to activeSection --}}
                                    <template x-if="activeSection === 'sec-1'">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                                    </template>
                                    <template x-if="activeSection === 'sec-2'">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                    </template>
                                    <template x-if="activeSection === 'sec-3'">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" /></svg>
                                    </template>
                                    <template x-if="activeSection === 'sec-4'">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                                    </template>
                                    <template x-if="activeSection === 'sec-5'">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" /></svg>
                                    </template>
                                    <template x-if="activeSection === 'sec-6'">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
                                    </template>
                                    <template x-if="activeSection === 'sec-7'">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2zM9 16h6m-6-4h6m-6-4h6" /></svg>
                                    </template>
                                    <template x-if="activeSection === 'sec-8'">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                    </template>
                                </div>
                                <div>
                                    <span class="text-xs font-semibold text-primary uppercase tracking-wider block" x-text="'Langkah ' + (sections.findIndex(s => s.id === activeSection) + 1) + ' dari 8'"></span>
                                    <h2 class="text-xl font-bold text-secondary-900 dark:text-neutral-50 mt-0.5" x-text="sections.find(s => s.id === activeSection)?.name"></h2>
                                </div>
                            </div>
                            <div class="flex flex-col items-end gap-1.5 min-w-[120px]">
                                <span class="text-xs font-semibold text-neutral-400 dark:text-neutral-500" x-text="'Progress: ' + Math.round((sections.findIndex(s => s.id === activeSection) + 1) / sections.length * 100) + '%'"></span>
                                <div class="w-28 h-1.5 bg-neutral-100 dark:bg-secondary-700/60 rounded-full overflow-hidden">
                                    <div class="h-full bg-gradient-to-r from-primary-500 to-primary-700 rounded-full transition-all duration-300"
                                        :style="'width:' + ((sections.findIndex(s => s.id === activeSection) + 1) / sections.length * 100) + '%'"></div>
                                </div>
                            </div>
                        </div>
