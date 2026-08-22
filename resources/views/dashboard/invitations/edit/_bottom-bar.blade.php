{{-- Fixed bottom bar --}}
        <div
            class="fixed bottom-0 left-0 right-0 bg-white/95 dark:bg-secondary-800/95 backdrop-blur-sm border-t border-neutral-200 dark:border-secondary-700 shadow-soft z-40">
            <div class="max-w-4xl mx-auto px-4 py-3 flex items-center justify-between gap-2">
                {{-- Left: Prev / Batal --}}
                <div class="flex items-center gap-2">
                    <button type="button" @click="prevStep()" x-show="activeSection !== 'sec-1'" x-cloak
                        class="inline-flex items-center justify-center gap-1.5 px-3 sm:px-5 py-2.5 bg-white dark:bg-secondary-800 border border-neutral-300 dark:border-neutral-600 rounded-xl shadow-sm text-sm font-semibold text-neutral-700 dark:text-neutral-300 hover:bg-neutral-50 dark:hover:bg-secondary-700 hover:border-primary-300 transition-all">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                        <span class="hidden sm:inline">Sebelumnya</span>
                    </button>
                    <a href="{{ route('dashboard.invitations.show', $invitation) }}" x-show="activeSection === 'sec-1'" x-cloak
                        class="inline-flex items-center justify-center gap-1.5 px-3 sm:px-5 py-2.5 bg-white dark:bg-secondary-800 border border-neutral-300 dark:border-neutral-600 rounded-xl shadow-sm text-sm font-semibold text-neutral-700 dark:text-neutral-300 hover:bg-neutral-50 dark:hover:bg-secondary-700 hover:border-primary-300 transition-all">
                        <span class="hidden sm:inline">Batal</span>
                        <span class="sm:hidden">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </span>
                    </a>
                </div>

                {{-- Right: Navigation & Save --}}
                <div class="flex items-center gap-2">
                    <a href="{{ route('dashboard.invitations.show', $invitation) }}" x-show="activeSection !== 'sec-1'" x-cloak
                        class="hidden sm:inline-flex items-center justify-center px-4 py-2.5 bg-white dark:bg-secondary-800 border border-neutral-300 dark:border-neutral-600 rounded-xl shadow-sm text-sm font-semibold text-neutral-700 dark:text-neutral-300 hover:bg-neutral-50 dark:hover:bg-secondary-700 hover:border-primary-300 transition-all">
                        Batal
                    </a>

                    <button type="button" @click="nextStep()" x-show="activeSection !== 'sec-8'" x-cloak
                        class="inline-flex items-center justify-center gap-1.5 px-3 sm:px-5 py-2.5 bg-primary/10 dark:bg-primary-900/30 text-primary dark:text-primary-300 border border-primary/20 dark:border-primary-800/85 rounded-xl shadow-sm text-sm font-semibold hover:bg-primary/20 transition-all">
                        <span>Selanjutnya</span>
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>

                    <button type="button" id="save-invitation-btn" data-tour="publish-btn"
                        class="inline-flex items-center justify-center gap-1.5 px-4 sm:px-6 py-2.5 bg-primary rounded-xl shadow-sm text-sm font-semibold text-white hover:bg-primary-600 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 transition-all">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span>Simpan</span>
                    </button>
                </div>
            </div>
        </div>
