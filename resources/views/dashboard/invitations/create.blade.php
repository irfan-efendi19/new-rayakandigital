<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-heading text-2xl font-bold text-secondary-800">
                Buat Undangan Baru
            </h2>
            <p class="text-sm text-neutral-500 mt-0.5">Lengkapi data berikut untuk membuat undangan digital Anda.</p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-soft border border-neutral-100 overflow-hidden">
                <div class="p-6 md:p-8">
                    <form action="{{ route('dashboard.invitations.store') }}" method="POST">
                        @csrf
                        <div class="space-y-8">
                            {{-- Title --}}
                            <div>
                                <label for="title" class="block text-sm font-medium text-neutral-700">Judul Undangan</label>
                                <input type="text" name="title" id="title"
                                    class="mt-1 block w-full rounded-xl border-neutral-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm"
                                    required placeholder="Contoh: Pernikahan Budi & Ani">
                                @error('title') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>

                            {{-- Bride & Groom --}}
                            <div class="border-b border-neutral-200 pb-8">
                                <h3 class="font-heading text-lg font-bold text-secondary-800 mb-1">Informasi Mempelai</h3>
                                <p class="text-sm text-neutral-500 mb-6">Data lengkap kedua mempelai untuk ditampilkan di undangan.</p>

                                <div class="space-y-6">
                                    {{-- Bride --}}
                                    <div class="bg-neutral-50 p-5 rounded-2xl border border-neutral-200 space-y-5">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-lg bg-primary-100 flex items-center justify-center text-primary">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                            </div>
                                            <h4 class="font-semibold text-sm text-primary-700">Mempelai Wanita</h4>
                                        </div>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                            <div class="md:col-span-2">
                                                <label for="bride_name" class="block text-sm font-medium text-neutral-700">Nama Lengkap Mempelai Wanita</label>
                                                <input type="text" name="bride_name" id="bride_name"
                                                    class="mt-1 block w-full rounded-xl border-neutral-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm"
                                                    required placeholder="Ani Suryani">
                                                @error('bride_name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                            </div>
                                            <div>
                                                <label for="bride_nickname" class="block text-sm font-medium text-neutral-700">Nama Panggilan</label>
                                                <input type="text" name="bride_nickname" id="bride_nickname"
                                                    class="mt-1 block w-full rounded-xl border-neutral-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm"
                                                    placeholder="Ani">
                                                @error('bride_nickname') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                            </div>
                                            <div>
                                                <label for="bride_parents" class="block text-sm font-medium text-neutral-700">Nama Orang Tua</label>
                                                <input type="text" name="bride_parents" id="bride_parents"
                                                    class="mt-1 block w-full rounded-xl border-neutral-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm"
                                                    placeholder="Putri dari Bapak Surya & Ibu Dewi">
                                                @error('bride_parents') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Groom --}}
                                    <div class="bg-neutral-50 p-5 rounded-2xl border border-neutral-200 space-y-5">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-lg bg-primary-100 flex items-center justify-center text-primary">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                            </div>
                                            <h4 class="font-semibold text-sm text-primary-700">Mempelai Pria</h4>
                                        </div>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                            <div class="md:col-span-2">
                                                <label for="groom_name" class="block text-sm font-medium text-neutral-700">Nama Lengkap Mempelai Pria</label>
                                                <input type="text" name="groom_name" id="groom_name"
                                                    class="mt-1 block w-full rounded-xl border-neutral-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm"
                                                    required placeholder="Budi Santoso">
                                                @error('groom_name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                            </div>
                                            <div>
                                                <label for="groom_nickname" class="block text-sm font-medium text-neutral-700">Nama Panggilan</label>
                                                <input type="text" name="groom_nickname" id="groom_nickname"
                                                    class="mt-1 block w-full rounded-xl border-neutral-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm"
                                                    placeholder="Budi">
                                                @error('groom_nickname') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                            </div>
                                            <div>
                                                <label for="groom_parents" class="block text-sm font-medium text-neutral-700">Nama Orang Tua</label>
                                                <input type="text" name="groom_parents" id="groom_parents"
                                                    class="mt-1 block w-full rounded-xl border-neutral-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm"
                                                    placeholder="Putra dari Bapak Santo & Ibu Ratna">
                                                @error('groom_parents') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Theme Selection --}}
                            <div class="border-b border-neutral-200 pb-8">
                                <h3 class="font-heading text-lg font-bold text-secondary-800 mb-1">Pilih Tema</h3>
                                <p class="text-sm text-neutral-500 mb-6">Pilih tema undangan yang sesuai dengan acara Anda.</p>

                                <div x-data="{ selected: '{{ $selectedTheme }}' }">
                                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                        @foreach($themes as $tema)
                                            @php $themeKey = str_replace('themes.', '', $tema->view_path); @endphp
                                            <label @click="selected = '{{ $themeKey }}'"
                                                :class="selected === '{{ $themeKey }}' ? 'border-primary-500 ring-2 ring-primary-500 ring-offset-2' : 'border-neutral-200 hover:border-primary-300 hover:shadow-sm'"
                                                class="relative flex cursor-pointer rounded-2xl border-2 bg-white p-5 shadow-sm transition-all duration-200">
                                                <input type="radio" name="theme" value="{{ $themeKey }}" class="sr-only"
                                                    :checked="selected === '{{ $themeKey }}'">
                                                <span class="flex flex-1">
                                                    <span class="flex flex-col">
                                                        <span class="block text-sm font-semibold text-secondary-800">{{ $tema->name }}</span>
                                                        <span class="mt-1 flex items-center text-sm text-neutral-500">
                                                            {{ $tema->is_premium ? 'Premium' : 'Gratis' }}
                                                        </span>
                                                    </span>
                                                </span>
                                                <svg x-show="selected === '{{ $themeKey }}'" class="h-5 w-5 text-primary" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                                                </svg>
                                            </label>
                                        @endforeach
                                    </div>
                                    @error('theme') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            {{-- Actions --}}
                            <div class="flex items-center justify-between pt-2">
                                <a href="{{ route('dashboard') }}"
                                    class="inline-flex items-center px-5 py-2.5 bg-white border border-neutral-300 rounded-xl shadow-sm text-sm font-semibold text-neutral-700 hover:bg-neutral-50 hover:border-primary-300 transition-all">
                                    <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                    </svg>
                                    Batal
                                </a>
                                <button type="submit"
                                    class="inline-flex items-center gap-2 px-6 py-2.5 bg-gradient-to-r from-primary to-primary-600 rounded-xl shadow-sm text-sm font-semibold text-white hover:shadow-md hover:scale-[1.02] active:scale-[0.98] focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition-all">
                                    Simpan & Lanjutkan
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
