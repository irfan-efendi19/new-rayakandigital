{{-- ======================================== --}}
                        {{-- Section 7: Kategori Tamu (Guest Categories) --}}
                        {{-- ======================================== --}}
                        <div id="sec-7"
                            x-show="activeSection === 'sec-7'"
                            x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 translate-x-4"
                            x-transition:enter-end="opacity-100 translate-x-0"
                            class="scroll-mt-32"
                            data-tour="guest-management"
                            x-cloak>
                            <div class="mb-3">
                                <h3 class="font-heading text-lg font-bold text-secondary-800 dark:text-neutral-100">
                                    Kategori Tamu <span class="text-sm font-normal text-neutral-400 dark:text-neutral-500">(VIP, Keluarga, dll)</span>
                                </h3>
                            </div>
                            <p class="text-sm text-neutral-500 dark:text-neutral-400 mb-6">
                                Kelola label kategori untuk mengelompokkan tamu (misal: VIP, Keluarga, Teman Kantor).
                            </p>

                            <div x-data="guestCategories()" x-init="init()" class="space-y-4">
                                <div class="flex flex-wrap gap-2 mb-4">
                                    <template x-for="category in categories" :key="category.id">
                                        <span
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-medium"
                                            :style="'background-color: ' + category.color_code + '20; color: ' + category.color_code + '; border: 1px solid ' + category.color_code + '40'">
                                            <span x-text="category.name"></span>
                                            <button type="button" @click="editCategory(category)"
                                                class="hover:opacity-70 transition-opacity" title="Edit">
                                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </button>
                                            <button type="button" @click="deleteCategory(category)"
                                                class="hover:opacity-70 transition-opacity" title="Hapus">
                                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </span>
                                    </template>
                                </div>

                                <div
                                    class="bg-neutral-50 dark:bg-secondary-700 rounded-2xl border border-neutral-200 dark:border-secondary-700 p-5">
                                    <h4 class="text-sm font-semibold text-secondary-800 dark:text-neutral-100 mb-3"
                                        x-text="editing ? 'Edit Kategori' : 'Tambah Kategori Baru'"></h4>
                                    <div class="flex flex-col sm:flex-row gap-3">
                                        <div class="flex-1">
                                            <input type="text" x-model="form.name"
                                                placeholder="Nama kategori (misal: VIP, Keluarga)"
                                                class="block w-full rounded-xl border-neutral-300 dark:border-secondary-600 dark:bg-secondary-800 dark:text-neutral-200 shadow-sm focus:border-primary-500 focus:ring-primary-500 text-sm">
                                        </div>
                                        <div class="w-full sm:w-32">
                                            <div class="flex items-center gap-2">
                                                <input type="color" x-model="form.color_code"
                                                    class="h-10 w-10 rounded-lg border border-neutral-300 dark:border-secondary-600 cursor-pointer p-0.5">
                                                <input type="text" x-model="form.color_code" placeholder="#6b7280"
                                                    class="block w-full rounded-xl border-neutral-300 dark:border-secondary-600 dark:bg-secondary-800 dark:text-neutral-200 shadow-sm focus:border-primary-500 focus:ring-primary-500 text-sm">
                                            </div>
                                        </div>
                                        <div class="flex gap-2">
                                            <button type="button" @click="saveCategory"
                                                class="inline-flex items-center gap-1.5 bg-primary text-white px-4 py-2 rounded-xl text-sm font-semibold hover:shadow-lg transition-all whitespace-nowrap">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                                <span x-text="editing ? 'Update' : 'Tambah'"></span>
                                            </button>
                                            <button type="button" @click="cancelEdit" x-show="editing"
                                                class="inline-flex items-center gap-1.5 bg-neutral-200 dark:bg-secondary-600 text-neutral-700 dark:text-neutral-300 px-4 py-2 rounded-xl text-sm font-semibold hover:bg-neutral-300 dark:hover:bg-secondary-500 transition-all">
                                                Batal
                                            </button>
                                        </div>
                                    </div>
                                    <p class="text-xs text-neutral-400 dark:text-neutral-500 mt-2">
                                        Warna akan tampil sebagai badge di daftar tamu dan menjadi filter pada fitur
                                        WhatsApp blast.
                                    </p>
                                </div>
                            </div>
                        </div>
