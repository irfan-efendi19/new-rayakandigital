<x-public-layout>
    <div class="py-16 bg-neutral-50 dark:bg-secondary-900 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-base text-primary-600 font-semibold tracking-wide uppercase">Katalog Tema</h2>
                <p
                    class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-secondary-800 dark:text-neutral-200 sm:text-4xl">
                    Semua Desain Undangan
                </p>
                <p class="mt-4 max-w-2xl text-xl text-neutral-500 mx-auto">
                    Lihat pratinjau langsung dengan data contoh. Klik "Gunakan Tema Ini" untuk langsung mulai.
                </p>
            </div>

            @if($categories->isNotEmpty())
                <div class="flex flex-wrap justify-center gap-3 mb-10" id="categoryFilters">
                    <button type="button"
                        class="category-filter px-5 py-2.5 rounded-full text-sm font-semibold transition-all duration-200 border-2 active"
                        data-category="all" style="border-color: #FF7A00; background-color: #FF7A00; color: white;"
                        onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
                        Semua
                        <span
                            class="ml-1.5 inline-flex items-center justify-center min-w-[20px] h-5 px-1.5 rounded-full text-xs font-bold"
                            style="background-color: rgba(255,255,255,0.25); color: white;">
                            {{ $themes->count() }}
                        </span>
                    </button>

                    @foreach($categories as $category)
                        <button type="button"
                            class="category-filter px-5 py-2.5 rounded-full text-sm font-semibold transition-all duration-200 border-2"
                            data-category="{{ $category->id }}"
                            style="border-color: #D4D4D8; background-color: transparent; color: #525252;"
                            onmouseover="this.style.borderColor='#FF7A00'; this.style.color='#FF7A00'"
                            onmouseout="if(!this.classList.contains('active')){this.style.borderColor='#D4D4D8'; this.style.color='#525252';}">
                            {{ $category->name }}
                            <span
                                class="ml-1.5 inline-flex items-center justify-center min-w-[20px] h-5 px-1.5 rounded-full text-xs font-bold"
                                style="background-color: #E4E4E7; color: #525252;">
                                {{ $category->themes_count }}
                            </span>
                        </button>
                    @endforeach
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" id="themeGrid">
                @forelse($themes as $theme)
                    <div class="theme-card rounded-2xl transition-all duration-500 ease-out hover:shadow-2xl hover:-translate-y-1.5 shadow-soft"
                        data-category="{{ $theme->theme_category_id ?? '0' }}">
                        <div
                            class="rounded-2xl overflow-hidden border border-neutral-100 dark:border-secondary-700/50 group">
                            {{-- Full-card background image --}}
                            @if($theme->thumbnail_portrait)
                                <img src="{{ Storage::url($theme->thumbnail_portrait) }}" alt="{{ $theme->name }}"
                                    class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 ease-out group-hover:scale-105">
                            @endif

                            {{-- Content overlay --}}
                            <div class="relative z-10 flex flex-col">
                                <div class="relative aspect-[4/5]">
                                    @if(!$theme->thumbnail_portrait)
                                        <div
                                            class="absolute inset-0 bg-gradient-to-br from-secondary-50 to-tertiary flex items-center justify-center">
                                            <div class="flex flex-col items-center justify-center">
                                                <div
                                                    class="w-20 h-20 bg-gradient-to-br from-primary-100 to-primary-50 rounded-2xl flex items-center justify-center mb-3">
                                                    <i class="fas fa-images text-3xl text-primary-400"></i>
                                                </div>
                                                <span class="text-sm text-neutral-400">{{ $theme->name }}</span>
                                            </div>
                                        </div>
                                    @else
                                        <div class="absolute inset-0 bg-gradient-to-b from-black/20 to-transparent"></div>
                                    @endif

                                    <div class="absolute top-3 left-3 z-20">
                                        @if($theme->is_premium)
                                            <span
                                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-gradient-to-r from-amber-400 to-amber-500 text-white shadow-lg shadow-amber-200/50">
                                                <i class="fas fa-crown text-xs"></i>
                                                Premium
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-white/90 backdrop-blur-sm text-emerald-700 shadow-sm border border-emerald-200/50">
                                                <i class="fas fa-gem text-xs"></i>
                                                Gratis
                                            </span>
                                        @endif
                                    </div>

                                    @if($theme->rating)
                                        <div
                                            class="absolute top-3 right-3 z-20 inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-semibold bg-white/90 backdrop-blur-sm text-amber-700 shadow-sm border border-amber-200/50">
                                            <i class="fas fa-star text-amber-400 text-[10px]"></i>
                                            <span>{{ $theme->rating }}</span>
                                        </div>
                                    @endif

                                    <div class="absolute inset-0 z-10 opacity-0 group-hover:opacity-100 transition-all duration-300 flex items-center justify-center"
                                        style="background: linear-gradient(to top, rgba(0,0,0,0.7) 0%, rgba(0,0,0,0.15) 50%, transparent 100%);">
                                        <a href="{{ route('theme.preview', str_replace('themes.', '', $theme->view_path)) }}"
                                            target="_blank"
                                            class="flex items-center gap-2 px-5 py-2.5 rounded-xl text-white text-sm font-semibold transition-all duration-200 hover:scale-105"
                                            style="background: rgba(255,255,255,0.15); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.25);">
                                            <i class="fas fa-eye text-xs"></i> Lihat Pratinjau
                                        </a>
                                    </div>
                                </div>

                                <div
                                    class="h-0.5 bg-gradient-to-r from-primary-400 via-primary-500 to-primary-600 scale-x-0 group-hover:scale-x-100 transition-transform duration-500 ease-out origin-left">
                                </div>

                                <div class="p-5 bg-white/70 dark:bg-secondary-800/70 backdrop-blur-xl">
                                    <h3
                                        class="text-lg font-bold text-secondary-800 dark:text-neutral-200 group-hover:text-primary-600 transition-colors leading-snug mb-2">
                                        {{ $theme->name }}
                                    </h3>

                                    @if($theme->category)
                                        <span
                                            class="inline-flex items-center gap-1 px-2.5 py-1 bg-primary-50 dark:bg-primary-900/30 text-primary-600 dark:text-primary-300 rounded-lg text-xs font-medium">
                                            <i class="fas fa-tag text-[10px]"></i>{{ $theme->category->name }}
                                        </span>
                                    @endif

                                    <div class="flex items-center gap-2 mt-4">
                                        @auth
                                            <a href="{{ route('dashboard.invitations.create', ['theme' => str_replace('themes.', '', $theme->view_path)]) }}"
                                                class="flex-1 text-center px-4 py-2.5 bg-gradient-to-r from-primary-500 to-primary-600 text-white rounded-xl text-sm font-semibold hover:from-primary-600 hover:to-primary-700 transition-all duration-200 shadow-sm hover:shadow-md active:scale-95">
                                                <i class="fas fa-magic mr-1.5"></i> Gunakan
                                            </a>
                                        @else
                                            <a href="{{ route('register', ['theme' => str_replace('themes.', '', $theme->view_path)]) }}"
                                                class="flex-1 text-center px-4 py-2.5 bg-gradient-to-r from-primary-500 to-primary-600 text-white rounded-xl text-sm font-semibold hover:from-primary-600 hover:to-primary-700 transition-all duration-200 shadow-sm hover:shadow-md active:scale-95">
                                                <i class="fas fa-magic mr-1.5"></i> Gunakan
                                            </a>
                                        @endauth
                                        <a href="{{ route('theme.preview', str_replace('themes.', '', $theme->view_path)) }}"
                                            target="_blank"
                                            class="flex items-center justify-center w-11 h-11 rounded-xl border-2 border-neutral-200 dark:border-secondary-600 text-neutral-500 dark:text-neutral-400 hover:border-primary-200 hover:text-primary-600 dark:hover:border-primary-500 dark:hover:text-primary-400 transition-all duration-200 hover:bg-primary-50 dark:hover:bg-primary-900/20 active:scale-95"
                                            title="Pratinjau">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-16 text-center">
                        <div
                            class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-neutral-100 dark:bg-secondary-800 mb-4">
                            <i class="fas fa-palette text-3xl text-neutral-400"></i>
                        </div>
                        <p class="text-lg font-semibold text-secondary-800 dark:text-neutral-200">Belum ada tema tersedia
                        </p>
                        <p class="text-neutral-500 mt-2">Silakan hubungi admin untuk informasi lebih lanjut.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const filters = document.querySelectorAll('.category-filter');
            const cards = document.querySelectorAll('.theme-card');

            filters.forEach(btn => {
                btn.addEventListener('click', function () {
                    const category = this.dataset.category;

                    filters.forEach(f => {
                        f.classList.remove('active');
                        f.style.backgroundColor = 'transparent';
                        f.style.color = '#525252';
                        f.style.borderColor = '#D4D4D8';
                        const badge = f.querySelector('span');
                        if (badge) {
                            badge.style.backgroundColor = '#E4E4E7';
                            badge.style.color = '#525252';
                        }
                    });

                    this.classList.add('active');
                    this.style.backgroundColor = '#FF7A00';
                    this.style.color = 'white';
                    this.style.borderColor = '#FF7A00';
                    const activeBadge = this.querySelector('span');
                    if (activeBadge) {
                        activeBadge.style.backgroundColor = 'rgba(255,255,255,0.25)';
                        activeBadge.style.color = 'white';
                    }

                    cards.forEach(card => {
                        if (category === 'all' || card.dataset.category === category) {
                            card.style.display = '';
                            card.style.opacity = '0';
                            setTimeout(() => { card.style.opacity = '1'; }, 20);
                        } else {
                            card.style.display = 'none';
                        }
                    });
                });
            });
        });
    </script>
</x-public-layout>