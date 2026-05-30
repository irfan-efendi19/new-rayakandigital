<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Buat Undangan Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('dashboard.invitations.store') }}" method="POST">
                        @csrf
                        <div class="space-y-6">
                            <div>
                                <label for="title" class="block text-sm font-medium text-gray-700">Judul Undangan</label>
                                <input type="text" name="title" id="title" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required placeholder="Contoh: Pernikahan Budi & Ani">
                                @error('title') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="bride_name" class="block text-sm font-medium text-gray-700">Nama Lengkap Mempelai Wanita</label>
                                    <input type="text" name="bride_name" id="bride_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required placeholder="Ani Suryani">
                                    @error('bride_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label for="bride_nickname" class="block text-sm font-medium text-gray-700">Nama Panggilan Mempelai Wanita</label>
                                    <input type="text" name="bride_nickname" id="bride_nickname" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Ani">
                                    @error('bride_nickname') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div>
                                <label for="bride_parents" class="block text-sm font-medium text-gray-700">Nama Orang Tua Mempelai Wanita</label>
                                <input type="text" name="bride_parents" id="bride_parents" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Putri dari Bapak Surya & Ibu Dewi">
                                @error('bride_parents') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <hr class="border-gray-200" />

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="groom_name" class="block text-sm font-medium text-gray-700">Nama Lengkap Mempelai Pria</label>
                                    <input type="text" name="groom_name" id="groom_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required placeholder="Budi Santoso">
                                    @error('groom_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label for="groom_nickname" class="block text-sm font-medium text-gray-700">Nama Panggilan Mempelai Pria</label>
                                    <input type="text" name="groom_nickname" id="groom_nickname" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Budi">
                                    @error('groom_nickname') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div>
                                <label for="groom_parents" class="block text-sm font-medium text-gray-700">Nama Orang Tua Mempelai Pria</label>
                                <input type="text" name="groom_parents" id="groom_parents" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Putra dari Bapak Santo & Ibu Ratna">
                                @error('groom_parents') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <hr class="border-gray-200" />

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Tema</label>
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                    <label class="relative flex cursor-pointer rounded-lg border bg-white p-4 shadow-sm focus:outline-none hover:border-indigo-500 transition-colors">
                                        <input type="radio" name="theme" value="elegant" class="sr-only" {{ $selectedTheme === 'elegant' ? 'checked' : '' }}>
                                        <span class="flex flex-1">
                                            <span class="flex flex-col">
                                                <span class="block text-sm font-medium text-gray-900">Elegant Rose</span>
                                                <span class="mt-1 flex items-center text-sm text-gray-500">Klasik & Romantis</span>
                                            </span>
                                        </span>
                                        <svg class="h-5 w-5 text-indigo-600 {{ $selectedTheme === 'elegant' ? '' : 'hidden' }}" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" /></svg>
                                    </label>

                                    <label class="relative flex cursor-pointer rounded-lg border bg-white p-4 shadow-sm focus:outline-none hover:border-indigo-500 transition-colors">
                                        <input type="radio" name="theme" value="modern" class="sr-only" {{ $selectedTheme === 'modern' ? 'checked' : '' }}>
                                        <span class="flex flex-1">
                                            <span class="flex flex-col">
                                                <span class="block text-sm font-medium text-gray-900">Modern Dark</span>
                                                <span class="mt-1 flex items-center text-sm text-gray-500">Gelap & Elegan</span>
                                            </span>
                                        </span>
                                        <svg class="h-5 w-5 text-indigo-600 {{ $selectedTheme === 'modern' ? '' : 'hidden' }}" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" /></svg>
                                    </label>

                                    <label class="relative flex cursor-pointer rounded-lg border bg-white p-4 shadow-sm focus:outline-none hover:border-indigo-500 transition-colors">
                                        <input type="radio" name="theme" value="garden" class="sr-only" {{ $selectedTheme === 'garden' ? 'checked' : '' }}>
                                        <span class="flex flex-1">
                                            <span class="flex flex-col">
                                                <span class="block text-sm font-medium text-gray-900">Garden Green</span>
                                                <span class="mt-1 flex items-center text-sm text-gray-500">Segar & Natural</span>
                                            </span>
                                        </span>
                                        <svg class="h-5 w-5 text-indigo-600 {{ $selectedTheme === 'garden' ? '' : 'hidden' }}" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" /></svg>
                                    </label>
                                </div>
                                <style>
                                    input[type="radio"]:checked ~ span { color: #4f46e5; }
                                </style>
                                @error('theme') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div class="pt-4 flex justify-end">
                                <a href="{{ route('dashboard') }}" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 mr-3">
                                    Batal
                                </a>
                                <button type="submit" class="bg-indigo-600 border border-transparent rounded-md shadow-sm py-2 px-4 inline-flex justify-center text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Simpan & Lanjutkan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
