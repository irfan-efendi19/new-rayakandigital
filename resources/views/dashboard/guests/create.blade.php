<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-heading text-2xl font-bold text-secondary-800 dark:text-neutral-100">
                Tambah Tamu
            </h2>
            <p class="text-sm text-neutral-500 dark:text-neutral-400 mt-0.5">{{ $invitation->title }}</p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-secondary-800 rounded-2xl shadow-soft border border-neutral-100 dark:border-secondary-700">
                <div class="p-8">
                    <form action="{{ route('dashboard.invitations.guests.store', $invitation) }}" method="POST">
                        @csrf
                        <div class="space-y-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1.5">Nama Tamu</label>
                                <input type="text" name="name" id="name"
                                    class="block w-full rounded-xl border-neutral-300 dark:border-secondary-600 dark:bg-secondary-700 dark:text-neutral-200 shadow-sm focus:border-primary-500 focus:ring-primary-500 text-sm"
                                    required placeholder="Contoh: Bapak Budi Santoso">
                                <p class="mt-1.5 text-xs text-neutral-500 dark:text-neutral-400">Gunakan sapaan yang sesuai (Bapak/Ibu/Sdr/i) karena akan muncul di undangan.</p>
                                @error('name') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="phone" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1.5">No. WhatsApp <span class="text-neutral-400 dark:text-neutral-500 font-normal">(opsional)</span></label>
                                <input type="text" name="phone" id="phone"
                                    class="block w-full rounded-xl border-neutral-300 dark:border-secondary-600 dark:bg-secondary-700 dark:text-neutral-200 shadow-sm focus:border-primary-500 focus:ring-primary-500 text-sm"
                                    placeholder="Contoh: 08123456789">
                                <p class="mt-1.5 text-xs text-neutral-500 dark:text-neutral-400">Digunakan untuk mengirim link undangan via WhatsApp otomatis.</p>
                                @error('phone') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="address" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1.5">Alamat <span class="text-neutral-400 dark:text-neutral-500 font-normal">(opsional)</span></label>
                                <textarea name="address" id="address" rows="2"
                                    class="block w-full rounded-xl border-neutral-300 dark:border-secondary-600 dark:bg-secondary-700 dark:text-neutral-200 shadow-sm focus:border-primary-500 focus:ring-primary-500 text-sm"
                                    placeholder="Contoh: Jl. Merdeka No. 123, Jakarta"></textarea>
                                @error('address') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="guest_category_id" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1.5">Kategori Tamu <span class="text-neutral-400 dark:text-neutral-500 font-normal">(opsional)</span></label>
                                <select name="guest_category_id" id="guest_category_id"
                                    class="block w-full rounded-xl border-neutral-300 dark:border-secondary-600 dark:bg-secondary-700 dark:text-neutral-200 shadow-sm focus:border-primary-500 focus:ring-primary-500 text-sm">
                                    <option value="">— Pilih Kategori —</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" style="color: {{ $category->color_code }};">
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('guest_category_id') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div class="pt-6 border-t border-neutral-100 dark:border-secondary-700 flex justify-end gap-3">
                                <a href="{{ route('dashboard.invitations.guests.index', $invitation) }}"
                                   class="inline-flex items-center px-5 py-2.5 border border-neutral-200 dark:border-secondary-600 rounded-xl text-sm font-medium text-neutral-700 dark:text-neutral-300 hover:bg-neutral-50 dark:hover:bg-secondary-700 transition-colors">
                                    Batal
                                </a>
                                <button type="submit"
                                    class="inline-flex items-center gap-2 bg-gradient-to-r from-primary to-primary-600 text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:shadow-lg transition-all">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    Simpan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
