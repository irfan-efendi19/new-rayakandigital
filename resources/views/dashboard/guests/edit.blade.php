<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-heading text-2xl font-bold text-secondary-800 dark:text-neutral-100">
                Edit Tamu
            </h2>
            <p class="text-sm text-neutral-500 dark:text-neutral-400 mt-0.5">{{ $guest->name }} — {{ $invitation->title }}</p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-secondary-800 rounded-2xl shadow-soft border border-neutral-100 dark:border-secondary-700">
                <div class="p-8">
                    <form action="{{ route('dashboard.invitations.guests.update', [$invitation, $guest]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="space-y-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1.5">Nama Tamu</label>
                                <input type="text" name="name" id="name" value="{{ old('name', $guest->name) }}"
                                    class="block w-full rounded-xl border-neutral-300 dark:border-secondary-600 dark:bg-secondary-700 dark:text-neutral-200 shadow-sm focus:border-primary-500 focus:ring-primary-500 text-sm" required>
                                @error('name') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="whatsapp_number" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1.5">No. WhatsApp <span class="text-neutral-400 dark:text-neutral-500 font-normal">(opsional)</span></label>
                                <input type="text" name="whatsapp_number" id="whatsapp_number" value="{{ old('whatsapp_number', $guest->whatsapp_number) }}"
                                    class="block w-full rounded-xl border-neutral-300 dark:border-secondary-600 dark:bg-secondary-700 dark:text-neutral-200 shadow-sm focus:border-primary-500 focus:ring-primary-500 text-sm">
                                @error('whatsapp_number') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="phone" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1.5">No. Telepon <span class="text-neutral-400 dark:text-neutral-500 font-normal">(opsional)</span></label>
                                <input type="text" name="phone" id="phone" value="{{ old('phone', $guest->phone) }}"
                                    class="block w-full rounded-xl border-neutral-300 dark:border-secondary-600 dark:bg-secondary-700 dark:text-neutral-200 shadow-sm focus:border-primary-500 focus:ring-primary-500 text-sm">
                                @error('phone') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="address" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1.5">Alamat <span class="text-neutral-400 dark:text-neutral-500 font-normal">(opsional)</span></label>
                                <textarea name="address" id="address" rows="2"
                                    class="block w-full rounded-xl border-neutral-300 dark:border-secondary-600 dark:bg-secondary-700 dark:text-neutral-200 shadow-sm focus:border-primary-500 focus:ring-primary-500 text-sm"
                                    placeholder="Contoh: Jl. Merdeka No. 123, Jakarta">{{ old('address', $guest->address) }}</textarea>
                                @error('address') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="guest_category_id" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1.5">Kategori Tamu <span class="text-neutral-400 dark:text-neutral-500 font-normal">(opsional)</span></label>
                                <select name="guest_category_id" id="guest_category_id"
                                    class="block w-full rounded-xl border-neutral-300 dark:border-secondary-600 dark:bg-secondary-700 dark:text-neutral-200 shadow-sm focus:border-primary-500 focus:ring-primary-500 text-sm">
                                    <option value="">— Pilih Kategori —</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('guest_category_id', $guest->guest_category_id) == $category->id ? 'selected' : '' }} style="color: {{ $category->color_code }};">
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('guest_category_id') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            @if($events->isNotEmpty())
                            <div>
                                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">Alokasi Acara (Kloter)</label>
                                <p class="text-xs text-neutral-500 dark:text-neutral-400 mb-3">Pilih acara yang akan dihadiri tamu ini. Biarkan kosong jika tamu diundang ke semua acara.</p>
                                <input type="hidden" name="event_ids" value="">
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                    @foreach($events as $event)
                                    @php $checked = in_array($event->id, old('event_ids', $guest->events->pluck('id')->toArray())); @endphp
                                    <label class="relative flex items-start p-3 rounded-xl border border-neutral-200 dark:border-secondary-600 cursor-pointer has-[:checked]:border-primary has-[:checked]:bg-primary-50 dark:has-[:checked]:bg-primary-900/20 transition-all hover:border-neutral-300 dark:hover:border-neutral-500">
                                        <input type="checkbox" name="event_ids[]" value="{{ $event->id }}"
                                            {{ $checked ? 'checked' : '' }}
                                            class="mt-0.5 rounded border-neutral-300 dark:border-secondary-600 dark:bg-secondary-900 text-primary focus:ring-primary-500 shadow-sm">
                                        <div class="ml-3">
                                            <span class="block text-sm font-semibold text-secondary-800 dark:text-neutral-200">{{ $event->event_title }}</span>
                                            <span class="block text-xs text-neutral-500 dark:text-neutral-400">
                                                {{ \Carbon\Carbon::parse($event->event_date)->translatedFormat('l, d F Y') }}
                                                {{ $event->start_time ? \Carbon\Carbon::parse($event->start_time)->format('H:i') : '' }}
                                            </span>
                                        </div>
                                    </label>
                                    @endforeach
                                </div>
                                @error('event_ids') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>
                            @endif

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
                                    Simpan Perubahan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
