<x-public-layout>
    <div class="py-16 bg-neutral-50 dark:bg-secondary-900 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-base text-primary-600 font-semibold tracking-wide uppercase">Katalog Tema</h2>
                <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-secondary-800 dark:text-neutral-200 sm:text-4xl">
                    Semua Desain Undangan
                </p>
                <p class="mt-4 max-w-2xl text-xl text-neutral-500 mx-auto">
                    Lihat pratinjau langsung dengan data contoh. Klik "Gunakan Tema Ini" untuk langsung mulai.
                </p>
            </div>

            @if($categories->isNotEmpty())
            <div class="flex flex-wrap justify-center gap-3 mb-10" id="categoryFilters">
                <button
                    type="button"
                    class="category-filter px-5 py-2.5 rounded-full text-sm font-semibold transition-all duration-200 border-2 active"
                    data-category="all"
                    style="border-color: #FF7A00; background-color: #FF7A00; color: white;"
                    onmouseover="this.style.opacity='0.9'"
                    onmouseout="this.style.opacity='1'"
                >
                    Semua
                    <span class="ml-1.5 inline-flex items-center justify-center min-w-[20px] h-5 px-1.5 rounded-full text-xs font-bold"
                        style="background-color: rgba(255,255,255,0.25); color: white;">
                        {{ $themes->count() }}
                    </span>
                </button>

                @foreach($categories as $category)
                <button
                    type="button"
                    class="category-filter px-5 py-2.5 rounded-full text-sm font-semibold transition-all duration-200 border-2"
                    data-category="{{ $category->id }}"
                    style="border-color: #D4D4D8; background-color: transparent; color: #525252;"
                    onmouseover="this.style.borderColor='#FF7A00'; this.style.color='#FF7A00'"
                    onmouseout="if(!this.classList.contains('active')){this.style.borderColor='#D4D4D8'; this.style.color='#525252';}"
                >
                    {{ $category->name }}
                    <span class="ml-1.5 inline-flex items-center justify-center min-w-[20px] h-5 px-1.5 rounded-full text-xs font-bold"
                        style="background-color: #E4E4E7; color: #525252;">
                        {{ $category->themes_count }}
                    </span>
                </button>
                @endforeach
            </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" id="themeGrid">
                @forelse($themes as $theme)
                    <div class="theme-card bg-white dark:bg-secondary-800 rounded-2xl border border-neutral-100 dark:border-secondary-700/50 shadow-sm hover:shadow-2xl hover:-translate-y-1.5 transition-all duration-500 ease-out overflow-hidden group"
                        data-category="{{ $theme->theme_category_id ?? '0' }}">
                        <div class="relative aspect-[9/16] bg-gradient-to-br from-secondary-50 to-tertiary overflow-hidden">
                            @if($theme->thumbnail_portrait)
                                <img src="{{ Storage::url($theme->thumbnail_portrait) }}" alt="{{ $theme->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 ease-out">
                            @else
                                <div class="flex items-center justify-center h-full">
                                    <div class="text-center">
                                        <div class="w-20 h-20 mx-auto bg-gradient-to-br from-primary-100 to-primary-50 rounded-2xl flex items-center justify-center mb-3">
                                            <i class="fas fa-images text-3xl text-primary-400"></i>
                                        </div>
                                        <span class="text-sm text-neutral-400">{{ $theme->name }}</span>
                                    </div>
                                </div>
                            @endif

                            @if($theme->is_premium)
                                <span class="absolute top-3 right-3 inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-gradient-to-r from-amber-400 to-amber-500 text-white shadow-md">
                                    <i class="fas fa-crown text-xs"></i>
                                    Premium
                                </span>
                            @else
                                <span class="absolute top-3 right-3 inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700 shadow-sm">
                                    <i class="fas fa-gem text-xs"></i>
                                    Gratis
                                </span>
                            @endif
                        </div>

                        <div class="p-5">
                            <div class="flex items-start justify-between mb-2">
                                <h3 class="text-lg font-bold text-secondary-800 dark:text-neutral-200 group-hover:text-primary-600 transition-colors">
                                    {{ $theme->name }}
                                </h3>
                                @if($theme->rating)
                                    <div class="flex items-center gap-0.5">
                                        <i class="fas fa-star text-amber-400 text-xs"></i>
                                        <span class="text-xs font-semibold text-secondary-600">{{ $theme->rating }}</span>
                                    </div>
                                @endif
                            </div>

                            @if($theme->category)
                                <div class="mb-4">
                                    <span class="inline-block px-2 py-0.5 bg-primary-50 text-primary-600 rounded-lg text-xs">
                                        <i class="fas fa-tag text-xs mr-1"></i>{{ $theme->category->name }}
                                    </span>
                                </div>
                            @endif

                            <div class="flex gap-3 mt-3">
                                <a
                                    href="{{ route('theme.preview', str_replace('themes.', '', $theme->view_path)) }}"
                                    target="_blank"
                                    class="flex-1 text-center px-3 py-2.5 border-2 border-primary-200 text-primary-600 rounded-xl text-sm font-semibold hover:bg-primary-50 hover:border-primary-300 transition-all duration-200"
                                >
                                    <i class="fas fa-eye mr-1"></i> Pratinjau
                                </a>

                                @auth
                                    <a href="{{ route('dashboard.invitations.create', ['theme' => str_replace('themes.', '', $theme->view_path)]) }}"
                                       class="flex-1 text-center px-3 py-2.5 bg-gradient-to-r from-primary-500 to-primary-600 text-white rounded-xl text-sm font-semibold hover:from-primary-600 hover:to-primary-700 transition-all duration-200 shadow-sm hover:shadow-md"
                                    >
                                        <i class="fas fa-magic mr-1"></i> Gunakan
                                    </a>
                                @else
                                    <a href="{{ route('register', ['theme' => str_replace('themes.', '', $theme->view_path)]) }}"
                                       class="flex-1 text-center px-3 py-2.5 bg-gradient-to-r from-primary-500 to-primary-600 text-white rounded-xl text-sm font-semibold hover:from-primary-600 hover:to-primary-700 transition-all duration-200 shadow-sm hover:shadow-md"
                                    >
                                        <i class="fas fa-magic mr-1"></i> Gunakan
                                    </a>
                                @endauth
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-16 text-center">
                        <div class="w-20 h-20 mx-auto bg-neutral-100 dark:bg-secondary-700 rounded-2xl flex items-center justify-center mb-4">
                            <i class="fas fa-paintbrush text-3xl text-neutral-400"></i>
                        </div>
                        <p class="text-lg font-semibold text-secondary-800 dark:text-neutral-200">Belum ada tema tersedia</p>
                        <p class="text-sm text-neutral-500 mt-1">Silakan hubungi admin untuk menambahkan tema.</p>
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
