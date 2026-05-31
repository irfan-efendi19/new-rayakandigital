<x-public-layout>
    <div class="py-16 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-base text-indigo-600 font-semibold tracking-wide uppercase">Katalog Tema</h2>
                <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                    Semua Desain Undangan
                </p>
                <p class="mt-4 max-w-2xl text-xl text-gray-500 mx-auto">
                    Lihat pratinjau langsung dengan data contoh. Klik "Gunakan Tema Ini" untuk langsung mulai.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($themes as $theme)
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl transition-all duration-300 group">
                        <div class="relative h-56 bg-gradient-to-br from-gray-100 to-gray-50 overflow-hidden">
                            @if($theme->thumbnail)
                                <img src="{{ $theme->thumbnail }}" alt="{{ $theme->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="flex items-center justify-center h-full">
                                    <div class="text-center">
                                        <svg class="w-16 h-16 mx-auto text-gray-300 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <span class="text-sm text-gray-400">{{ $theme->name }}</span>
                                    </div>
                                </div>
                            @endif

                            @if($theme->is_premium)
                                <span class="absolute top-3 right-3 inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-gradient-to-r from-amber-400 to-amber-500 text-white shadow-sm">
                                    ✨ Premium
                                </span>
                            @else
                                <span class="absolute top-3 right-3 inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700">
                                    Gratis
                                </span>
                            @endif
                        </div>

                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-900 mb-3">{{ $theme->name }}</h3>

                            <div class="flex gap-3">
                                <a
                                    href="{{ route('theme.preview', str_replace('themes.', '', $theme->view_path)) }}"
                                    target="_blank"
                                    class="flex-1 text-center px-4 py-2.5 border-2 border-indigo-200 text-indigo-600 rounded-xl text-sm font-semibold hover:bg-indigo-50 hover:border-indigo-300 transition-all duration-200"
                                >
                                    👁 Pratinjau
                                </a>

                                @auth
                                    <a href="{{ route('dashboard.invitations.create', ['theme' => str_replace('themes.', '', $theme->view_path)]) }}"
                                       class="flex-1 text-center px-4 py-2.5 bg-gradient-to-r from-indigo-600 to-indigo-700 text-white rounded-xl text-sm font-semibold hover:from-indigo-700 hover:to-indigo-800 transition-all duration-200 shadow-sm"
                                    >
                                        Gunakan Tema Ini
                                    </a>
                                @else
                                    <a href="{{ route('register', ['theme' => str_replace('themes.', '', $theme->view_path)]) }}"
                                       class="flex-1 text-center px-4 py-2.5 bg-gradient-to-r from-indigo-600 to-indigo-700 text-white rounded-xl text-sm font-semibold hover:from-indigo-700 hover:to-indigo-800 transition-all duration-200 shadow-sm"
                                    >
                                        Gunakan Tema Ini
                                    </a>
                                @endauth
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-12 text-center text-gray-500">
                        <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.53 16.122a3 3 0 00-5.78 1.128 2.25 2.25 0 01-2.4 2.245 4.5 4.5 0 008.4-2.245c0-.399-.078-.78-.22-1.128zm0 0a15.998 15.998 0 003.388-1.62m-5.043-.025a15.994 15.994 0 011.622-3.395m3.42 3.42a15.995 15.995 0 004.764-4.648l3.876-5.814a1.151 1.151 0 00-1.597-1.597L14.146 6.32a15.996 15.996 0 00-4.649 4.763m3.42 3.42a6.776 6.776 0 00-3.42-3.42" />
                        </svg>
                        <p class="text-lg">Belum ada tema tersedia. Silakan hubungi admin.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-public-layout>
