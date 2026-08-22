{{-- ======================================== --}}
                        {{-- Section 6: Kontrol RSVP --}}
                        {{-- ======================================== --}}
                        <div id="sec-6"
                            x-show="activeSection === 'sec-6'"
                            x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 translate-x-4"
                            x-transition:enter-end="opacity-100 translate-x-0"
                            class="scroll-mt-32"
                            x-cloak>
                            <div class="mb-3">
                                <h3 class="font-heading text-lg font-bold text-secondary-800 dark:text-neutral-100">
                                    Kontrol RSVP <span class="text-sm font-normal text-neutral-400 dark:text-neutral-500">(Batasan Kuota)</span>
                                </h3>
                            </div>
                            <p class="text-sm text-neutral-500 dark:text-neutral-400 mb-6">
                                Atur batasan kuota kehadiran tamu undangan.</p>

                            <div
                                class="bg-primary-50/50 dark:bg-primary-900/10 border border-primary-100 dark:border-primary-800/30 rounded-xl p-5 space-y-4">
                                <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-3">
                                    <div>
                                        <h4 class="text-sm font-semibold text-secondary-800 dark:text-neutral-100">
                                            Batasi Pax RSVP</h4>
                                        <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-0.5">
                                            Batasi jumlah maksimal pax/rombongan per tamu dan total kuota global.
                                        </p>
                                    </div>
                                    <label class="relative inline-flex items-center cursor-pointer flex-shrink-0">
                                        <input type="hidden" name="is_rsvp_pax_limited" value="0">
                                        <input type="checkbox" name="is_rsvp_pax_limited" id="is_rsvp_pax_limited"
                                            value="1"
                                            {{ old('is_rsvp_pax_limited', $invitation->is_rsvp_pax_limited) ? 'checked' : '' }}
                                            class="sr-only peer">
                                        <div
                                            class="w-9 h-5 bg-neutral-200 dark:bg-secondary-700 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-neutral-300 dark:after:border-neutral-600 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-primary-500">
                                        </div>
                                    </label>
                                </div>

                                <div id="rsvp-pax-settings"
                                    class="space-y-4 {{ old('is_rsvp_pax_limited', $invitation->is_rsvp_pax_limited) ? '' : 'hidden' }}">
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        <div>
                                            <label for="max_global_pax_quota"
                                                class="block text-xs font-medium text-neutral-700 dark:text-neutral-300">
                                                Total Kuota Global (Maksimal Pax)
                                            </label>
                                            <input type="number" name="max_global_pax_quota" id="max_global_pax_quota"
                                                value="{{ old('max_global_pax_quota', $invitation->max_global_pax_quota) }}"
                                                min="1"
                                                class="mt-1 block w-full rounded-xl border-neutral-300 dark:border-neutral-600 shadow-sm focus:border-primary-500 focus:ring-primary-500 text-sm dark:bg-secondary-700 dark:text-neutral-200"
                                                placeholder="Contoh: 500">
                                            <p class="text-xs text-neutral-400 dark:text-neutral-500 mt-1">
                                                Total maksimal seluruh pax yang hadir (misal: kapasitas gedung).
                                            </p>
                                            @error('max_global_pax_quota')
                                                <span
                                                    class="text-red-500 dark:text-red-400 text-xs mt-1">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div>
                                            <label for="max_pax_per_guest"
                                                class="block text-xs font-medium text-neutral-700 dark:text-neutral-300">
                                                Maksimal Pax per Tamu
                                            </label>
                                            <input type="number" name="max_pax_per_guest" id="max_pax_per_guest"
                                                value="{{ old('max_pax_per_guest', $invitation->max_pax_per_guest ?? 2) }}"
                                                min="1" max="50"
                                                class="mt-1 block w-full rounded-xl border-neutral-300 dark:border-neutral-600 shadow-sm focus:border-primary-500 focus:ring-primary-500 text-sm dark:bg-secondary-700 dark:text-neutral-200"
                                                placeholder="2">
                                            <p class="text-xs text-neutral-400 dark:text-neutral-500 mt-1">
                                                Jumlah rombongan maksimal yang bisa dibawa setiap tamu.
                                            </p>
                                            @error('max_pax_per_guest')
                                                <span
                                                    class="text-red-500 dark:text-red-400 text-xs mt-1">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    @if($invitation->isRsvpPaxLimited())
                                        <div
                                            class="bg-white dark:bg-secondary-700 border border-neutral-200 dark:border-neutral-600 rounded-xl p-3">
                                            <p class="text-xs text-neutral-600 dark:text-neutral-400">
                                                Saat ini:
                                                <span
                                                    class="font-semibold text-primary-600 dark:text-primary-400">{{ $invitation->totalAcceptedPax() }}</span>
                                                dari
                                                <span class="font-semibold">{{ $invitation->max_global_pax_quota }}</span>
                                                pax terpakai
                                                (sisa <span
                                                    class="font-semibold text-emerald-600 dark:text-emerald-400">{{ $invitation->remainingGlobalQuota() }}</span>).
                                            </p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
