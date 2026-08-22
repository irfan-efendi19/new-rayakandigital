{{-- ======================================== --}}
                            {{-- Section 4: Konten Tambahan & Personalisasi --}}
                            {{-- ======================================== --}}
                            <div id="sec-4"
                                x-show="activeSection === 'sec-4'"
                                x-transition:enter="transition ease-out duration-300"
                                x-transition:enter-start="opacity-0 translate-x-4"
                                x-transition:enter-end="opacity-100 translate-x-0"
                                class="scroll-mt-32"
                                x-cloak>
                                <div class="mb-3">
                                    <h3 class="font-heading text-lg font-bold text-secondary-800 dark:text-neutral-100">
                                        Konten Tambahan <span class="text-sm font-normal text-neutral-400 dark:text-neutral-500">(Cerita Cinta & Kutipan)</span>
                                    </h3>
                                </div>
                                <p class="text-sm text-neutral-500 dark:text-neutral-400 mb-6">
                                    Personalisasi undangan
                                    dengan cerita cinta dan kutipan
                                    bermakna.</p>

                                <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                                    {{-- Love Story --}}
                                    <div data-tour="love-story" class="sm:col-span-6">
                                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 mb-3">
                                            <label
                                                class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Cerita
                                                Cinta (Love
                                                Story)</label>
                                            <button type="button" id="add-story-btn"
                                                class="text-xs text-primary-600 dark:text-primary-400 hover:text-primary-700 dark:hover:text-primary-300 font-semibold">+
                                                Tambah Momen</button>
                                        </div>
                                        <div id="stories-container" class="space-y-3">
                                            @php $storyCollection = old(
                                                    'stories',
                                                    $invitation->stories->toArray()
                                                );
                                            @endphp
                                            @foreach($storyCollection as $storyIdx => $story)
                                                @php $story = (object) 
                                                $story; @endphp
                                                <div
                                                    class="story-card bg-neutral-50 dark:bg-secondary-700 p-4 rounded-xl border border-neutral-200 dark:border-secondary-700 space-y-3">
                                                    <div class="flex items-center justify-between flex-wrap gap-1">
                                                        <div class="flex items-center gap-1">
                                                            <span
                                                                class="text-xs font-semibold text-neutral-500 dark:text-neutral-400">Momen
                                                                #{{ $loop->iteration }}</span>
                                                            <button type="button"
                                                                class="story-move-up p-1 text-neutral-400 dark:text-neutral-500 hover:text-neutral-600 dark:hover:text-neutral-400 hover:bg-neutral-200 dark:hover:bg-secondary-600 rounded-lg transition"
                                                                title="Pindah ke atas">
                                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"
                                                                    stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2" d="M5 15l7-7 7 7" />
                                                                </svg>
                                                            </button>
                                                            <button type="button"
                                                                class="story-move-down p-1 text-neutral-400 dark:text-neutral-500 hover:text-neutral-600 dark:hover:text-neutral-400 hover:bg-neutral-200 dark:hover:bg-secondary-600 rounded-lg transition"
                                                                title="Pindah ke bawah">
                                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"
                                                                    stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2" d="M19 9l-7 7-7-7" />
                                                                </svg>
                                                            </button>
                                                        </div>
                                                        <button type="button"
                                                            class="remove-story text-red-400 dark:text-red-400 hover:text-red-600 dark:hover:text-red-300 text-xs font-semibold">Hapus</button>
                                                    </div>
                                                    @if(!empty($story->id))<input type="hidden"
                                                    name="stories[{{ $storyIdx }}][id]" value="{{ $story->id }}">@endif
                                                    <div>
                                                        <input type="text" name="stories[{{ $storyIdx }}][story_date]"
                                                            value="{{ old('stories.' . $storyIdx . '.story_date', $story->story_date ?? '') }}"
                                                            class="block w-full rounded-xl border-neutral-300 dark:border-neutral-600 shadow-sm focus:border-primary-500 focus:ring-primary-500 text-xs dark:bg-secondary-700 dark:text-neutral-200"
                                                            placeholder="Waktu (contoh: Tahun 2022, Maret 2024, 12 Desember 2025)">
                                                        @error('stories.' .
                                                                $storyIdx .
                                                            '.story_date') <span
                                                                class="text-red-500 dark:text-red-400 text-xs">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                    <div>
                                                        <input type="text" name="stories[{{ $storyIdx }}][story_title]"
                                                            value="{{ old('stories.' . $storyIdx . '.story_title', $story->story_title ?? '') }}"
                                                            class="block w-full rounded-xl border-neutral-300 dark:border-neutral-600 shadow-sm focus:border-primary-500 focus:ring-primary-500 text-xs dark:bg-secondary-700 dark:text-neutral-200"
                                                            placeholder="Judul momen (opsional)">
                                                        @error('stories.' .
                                                                $storyIdx .
                                                            '.story_title')
                                                            <span
                                                                class="text-red-500 dark:text-red-400 text-xs">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                    <div>
                                                        <textarea name="stories[{{ $storyIdx }}][story_description]"
                                                            rows="2"
                                                            class="block w-full rounded-xl border-neutral-300 dark:border-neutral-600 shadow-sm focus:border-primary-500 focus:ring-primary-500 text-xs dark:bg-secondary-700 dark:text-neutral-200"
                                                            placeholder="Ceritakan momen indah Anda...">{{ old('stories.' . $storyIdx . '.story_description', $story->story_description ?? '') }}</textarea>
                                                        @error('stories.' .
                                                                $storyIdx .
                                                            '.story_description')
                                                            <span
                                                                class="text-red-500 dark:text-red-400 text-xs">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <template id="story-card-template">
                                            <div
                                                class="story-card bg-neutral-50 dark:bg-secondary-700 p-4 rounded-xl border border-neutral-200 dark:border-secondary-700 space-y-3">
                                                <div class="flex items-center justify-between flex-wrap gap-1">
                                                    <div class="flex items-center gap-1">
                                                        <span
                                                            class="text-xs font-semibold text-neutral-500 dark:text-neutral-400">Momen
                                                            Baru</span>
                                                        <button type="button"
                                                            class="story-move-up p-1 text-neutral-400 dark:text-neutral-500 hover:text-neutral-600 dark:hover:text-neutral-400 hover:bg-neutral-200 dark:hover:bg-secondary-600 rounded-lg transition"
                                                            title="Pindah ke atas">
                                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"
                                                                stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2" d="M5 15l7-7 7 7" />
                                                            </svg>
                                                        </button>
                                                        <button type="button"
                                                            class="story-move-down p-1 text-neutral-400 dark:text-neutral-500 hover:text-neutral-600 dark:hover:text-neutral-400 hover:bg-neutral-200 dark:hover:bg-secondary-600 rounded-lg transition"
                                                            title="Pindah ke bawah">
                                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"
                                                                stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2" d="M19 9l-7 7-7-7" />
                                                            </svg>
                                                        </button>
                                                    </div>
                                                    <button type="button"
                                                        class="remove-story text-red-400 dark:text-red-400 hover:text-red-600 dark:hover:text-red-300 text-xs font-semibold">Hapus</button>
                                                </div>
                                                <div>
                                                    <input type="text" name="stories[__INDEX__][story_date]"
                                                        class="block w-full rounded-xl border-neutral-300 dark:border-neutral-600 shadow-sm focus:border-primary-500 focus:ring-primary-500 text-xs dark:bg-secondary-700 dark:text-neutral-200"
                                                        placeholder="Waktu (contoh: Tahun 2022, Maret 2024, 12 Desember 2025)">
                                                </div>
                                                <div>
                                                    <input type="text" name="stories[__INDEX__][story_title]"
                                                        class="block w-full rounded-xl border-neutral-300 dark:border-neutral-600 shadow-sm focus:border-primary-500 focus:ring-primary-500 text-xs dark:bg-secondary-700 dark:text-neutral-200"
                                                        placeholder="Judul momen (opsional)">
                                                </div>
                                                <div>
                                                    <textarea name="stories[__INDEX__][story_description]" rows="2"
                                                        class="block w-full rounded-xl border-neutral-300 dark:border-neutral-600 shadow-sm focus:border-primary-500 focus:ring-primary-500 text-xs dark:bg-secondary-700 dark:text-neutral-200"
                                                        placeholder="Ceritakan momen indah Anda..."></textarea>
                                                </div>
                                            </div>
                                        </template>
                                        <p class="text-xs text-neutral-400 dark:text-neutral-500 mt-2">
                                            Bagikan
                                            momen-momen berharga
                                            perjalanan cinta Anda kepada
                                            para tamu.</p>
                                    </div>

                                    {{-- Quote --}}
                                    @php
                                        $quoteTemplates = \App\Models\QuoteTemplate::active()->ordered()->get();
                                    @endphp

                                    <div class="sm:col-span-6">
                                        <div class="form-section-card space-y-5">
                                            {{-- Card Header --}}
                                            <div class="flex items-center gap-3">
                                                <div class="w-8 h-8 shrink-0 rounded-xl bg-primary-100 dark:bg-primary-900/50 flex items-center justify-center text-primary-600 dark:text-primary-300">
                                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                                                    </svg>
                                                </div>
                                                <h4 class="text-sm font-semibold text-neutral-800 dark:text-neutral-100">Kutipan / Ayat Suci</h4>
                                            </div>

                                            {{-- Quick-pick Templates --}}
                                            @if($quoteTemplates->isNotEmpty())
                                                <div>
                                                    <p class="form-label-crafted">Pilih Template Cepat</p>
                                                    <div class="flex flex-wrap gap-1.5">
                                                        @foreach($quoteTemplates as $qt)
                                                            <button type="button"
                                                                data-quote-content="{{ e($qt->content) }}"
                                                                data-quote-source="{{ e($qt->source) }}"
                                                                class="quote-template-btn px-2.5 py-1 rounded-lg border border-neutral-200 dark:border-neutral-600 text-xs font-medium text-neutral-600 dark:text-neutral-400 bg-white dark:bg-secondary-800 hover:bg-primary-50 dark:hover:bg-primary-900/30 hover:border-primary-300 dark:hover:border-primary-600 hover:text-primary-700 dark:hover:text-primary-300 transition-all duration-150 active:scale-95">
                                                                {{ $qt->label }}
                                                            </button>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif

                                            {{-- Quote Content --}}
                                            <div>
                                                <textarea name="quote_content" id="quote_content" rows="4"
                                                    class="block w-full rounded-xl border-neutral-300 dark:border-neutral-600 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm dark:bg-secondary-700 dark:text-neutral-200"
                                                    placeholder="Tulis kutipan ayat suci atau kutipan romantis...">{{ old('quote_content', $invitation->quote_content) }}</textarea>
                                                <p class="text-xs text-neutral-400 dark:text-neutral-500 mt-1">Isi kutipan, ayat suci, atau pesan romantis yang ingin ditampilkan.</p>
                                                @error('quote_content')
                                                    <span class="text-red-500 dark:text-red-400 text-xs mt-1 block">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            {{-- Quote Source --}}
                                            <div>
                                                <label for="quote_source" class="form-label-crafted">Sumber Kutipan</label>
                                                <input type="text" name="quote_source" id="quote_source"
                                                    value="{{ old('quote_source', $invitation->quote_source) }}"
                                                    class="block w-full rounded-xl border-neutral-300 dark:border-neutral-600 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm dark:bg-secondary-700 dark:text-neutral-200"
                                                    placeholder="Contoh: Ar-Rum: 21, Kahlil Gibran, QS. Al-Baqarah: 45">
                                                <p class="text-xs text-neutral-400 dark:text-neutral-500 mt-1">Nama tokoh, buku, atau pasal ayat sebagai sumber kutipan.</p>
                                                @error('quote_source')
                                                    <span class="text-red-500 dark:text-red-400 text-xs mt-1 block">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
