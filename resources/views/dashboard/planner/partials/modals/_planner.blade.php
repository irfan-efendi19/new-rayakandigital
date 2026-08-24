{{-- ─── Modals: Add Checklist ─── --}}
<x-modal name="add-checklist">
    <div class="p-6">
        <div class="flex items-start justify-between gap-4 mb-5">
            <div>
                <h3 class="text-lg font-bold text-secondary-800 dark:text-neutral-100">Tambah Checklist</h3>
                <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-1">Tambahkan checklist custom sesuai
                    kebutuhan.</p>
            </div>
            <button type="button" x-on:click="show = false"
                class="shrink-0 p-2 -m-2 text-neutral-400 hover:text-secondary-600 dark:hover:text-neutral-300 rounded-xl hover:bg-neutral-100 dark:hover:bg-secondary-700 transition-colors">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <form action="{{ route('dashboard.planner.checklists.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <x-input-label for="add-checklist-category" value="Kategori" />
                <select id="add-checklist-category" name="category_code"
                    class="mt-1 block w-full border-neutral-300 dark:border-neutral-600 dark:bg-secondary-700 dark:text-neutral-200 focus:border-primary-500 focus:ring-primary-500 rounded-xl shadow-sm"
                    required>
                    @foreach(\App\Models\WeddingChecklist::CATEGORIES as $code => $label)
                        <option value="{{ $code }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <x-input-label for="add-checklist-title" value="Nama Tugas" />
                <x-text-input id="add-checklist-title" name="title" class="mt-1 block w-full"
                    placeholder="cth: Sewa mobil pengantin" required />
                <x-input-error :messages="$errors->get('title')" class="mt-2" />
            </div>
            <div
                class="flex items-center justify-end gap-3 pt-4 mt-4 border-t border-neutral-100 dark:border-secondary-700">
                <x-secondary-button type="button" x-on:click="show = false">Batal</x-secondary-button>
                <x-primary-button type="submit">Simpan Checklist</x-primary-button>
            </div>
        </form>
    </div>
</x-modal>

{{-- ─── Modals: Add Vendor ─── --}}
<x-modal name="add-vendor">
    <div class="p-6" x-data="{ vendorType: 'VENUE' }" x-on:set-vendor-type.window="vendorType = $event.detail.type">
        <div class="flex items-start justify-between gap-4 mb-5">
            <div>
                <h3 class="text-lg font-bold text-secondary-800 dark:text-neutral-100">Tambah Vendor</h3>
                <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-1">Simpan vendor baru ke kategori persiapan.
                </p>
            </div>
            <button type="button" x-on:click="show = false"
                class="shrink-0 p-2 -m-2 text-neutral-400 hover:text-secondary-600 dark:hover:text-neutral-300 rounded-xl hover:bg-neutral-100 dark:hover:bg-secondary-700 transition-colors">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <form action="{{ route('dashboard.planner.items.store') }}" method="POST" class="space-y-4">
            @csrf
            <input type="hidden" name="category" value="VENDOR">

            <div>
                <x-input-label for="add-vendor-type" value="Kategori Vendor" />
                <select id="add-vendor-type" name="vendor_type" x-model="vendorType"
                    class="mt-1 block w-full border-neutral-300 dark:border-neutral-600 dark:bg-secondary-700 dark:text-neutral-200 focus:border-primary-500 focus:ring-primary-500 rounded-xl shadow-sm"
                    required>
                    @foreach(\App\Models\WeddingPlannerItem::VENDOR_TYPES as $code => $label)
                        <option value="{{ $code }}">{{ $label }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('vendor_type')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="add-vendor-title" value="Nama Vendor" />
                <x-text-input id="add-vendor-title" name="title" class="mt-1 block w-full"
                    placeholder="cth: Venue Ballroom Grand" required />
                <x-input-error :messages="$errors->get('title')" class="mt-2" />
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <x-input-label for="add-vendor-est" value="Estimasi (Rp)" />
                    <x-text-input id="add-vendor-est" name="estimated_cost" type="text" inputmode="numeric" data-rupiah
                        value="0" class="mt-1 block w-full" />
                </div>
                <div>
                    <x-input-label for="add-vendor-paid" value="Bayar (Rp)" />
                    <x-text-input id="add-vendor-paid" name="paid_amount" type="text" inputmode="numeric" data-rupiah
                        value="0" class="mt-1 block w-full" />
                </div>
            </div>

            <div>
                <x-input-label for="add-vendor-contact" value="Kontak Vendor" />
                <x-text-input id="add-vendor-contact" name="vendor_contact" class="mt-1 block w-full"
                    placeholder="cth: 0812-3456-7890" />
            </div>

            <div>
                <x-input-label value="Status" />
                <div class="mt-2 grid grid-cols-2 sm:grid-cols-4 gap-2" x-data="{ selected: '' }">
                    <label
                        class="relative flex items-center gap-2.5 cursor-pointer rounded-xl border-2 px-3 py-2.5 transition-all duration-200"
                        :class="selected === 'PENDING' ? 'border-neutral-500 dark:border-neutral-400 bg-neutral-100 dark:bg-secondary-600 shadow-md' : 'border-neutral-200 dark:border-secondary-600 hover:border-neutral-300 dark:hover:border-secondary-500'">
                        <input type="radio" name="status" value="PENDING" x-model="selected" class="peer sr-only">
                        <span class="flex-shrink-0 transition-colors duration-200"
                            :class="selected === 'PENDING' ? 'text-neutral-800 dark:text-neutral-100' : 'text-neutral-400 dark:text-neutral-500'">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <circle cx="12" cy="12" r="4" fill="currentColor" />
                            </svg>
                        </span>
                        <span class="text-sm font-medium transition-colors duration-200"
                            :class="selected === 'PENDING' ? 'text-neutral-800 dark:text-neutral-100' : 'text-neutral-500 dark:text-neutral-400'">{{ $statusLabels['PENDING'] }}</span>
                    </label>
                    <label
                        class="relative flex items-center gap-2.5 cursor-pointer rounded-xl border-2 px-3 py-2.5 transition-all duration-200"
                        :class="selected === 'IN_PROGRESS' ? 'border-blue-500 dark:border-blue-400 bg-blue-100 dark:bg-blue-900/50 shadow-md' : 'border-neutral-200 dark:border-secondary-600 hover:border-neutral-300 dark:hover:border-secondary-500'">
                        <input type="radio" name="status" value="IN_PROGRESS" x-model="selected" class="peer sr-only">
                        <span class="flex-shrink-0 transition-colors duration-200"
                            :class="selected === 'IN_PROGRESS' ? 'text-blue-600 dark:text-blue-400' : 'text-neutral-400 dark:text-neutral-500'">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </span>
                        <span class="text-sm font-medium transition-colors duration-200"
                            :class="selected === 'IN_PROGRESS' ? 'text-blue-700 dark:text-blue-200' : 'text-neutral-500 dark:text-neutral-400'">{{ $statusLabels['IN_PROGRESS'] }}</span>
                    </label>
                    <label
                        class="relative flex items-center gap-2.5 cursor-pointer rounded-xl border-2 px-3 py-2.5 transition-all duration-200"
                        :class="selected === 'COMPLETED' ? 'border-emerald-500 dark:border-emerald-400 bg-emerald-100 dark:bg-emerald-900/50 shadow-md' : 'border-neutral-200 dark:border-secondary-600 hover:border-neutral-300 dark:hover:border-secondary-500'">
                        <input type="radio" name="status" value="COMPLETED" x-model="selected" class="peer sr-only">
                        <span class="flex-shrink-0 transition-colors duration-200"
                            :class="selected === 'COMPLETED' ? 'text-emerald-600 dark:text-emerald-400' : 'text-neutral-400 dark:text-neutral-500'">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                        </span>
                        <span class="text-sm font-medium transition-colors duration-200"
                            :class="selected === 'COMPLETED' ? 'text-emerald-700 dark:text-emerald-200' : 'text-neutral-500 dark:text-neutral-400'">{{ $statusLabels['COMPLETED'] }}</span>
                    </label>
                    <label
                        class="relative flex items-center gap-2.5 cursor-pointer rounded-xl border-2 px-3 py-2.5 transition-all duration-200"
                        :class="selected === 'CANCELLED' ? 'border-red-500 dark:border-red-400 bg-red-100 dark:bg-red-900/50 shadow-md' : 'border-neutral-200 dark:border-secondary-600 hover:border-neutral-300 dark:hover:border-secondary-500'">
                        <input type="radio" name="status" value="CANCELLED" x-model="selected" class="peer sr-only">
                        <span class="flex-shrink-0 transition-colors duration-200"
                            :class="selected === 'CANCELLED' ? 'text-red-600 dark:text-red-400' : 'text-neutral-400 dark:text-neutral-500'">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </span>
                        <span class="text-sm font-medium transition-colors duration-200"
                            :class="selected === 'CANCELLED' ? 'text-red-700 dark:text-red-200' : 'text-neutral-500 dark:text-neutral-400'">{{ $statusLabels['CANCELLED'] }}</span>
                    </label>
                </div>
            </div>

            <div
                class="flex items-center justify-end gap-3 pt-4 mt-4 border-t border-neutral-100 dark:border-secondary-700">
                <x-secondary-button type="button" x-on:click="show = false">Batal</x-secondary-button>
                <x-primary-button type="submit">Simpan Vendor</x-primary-button>
            </div>
        </form>
    </div>
</x-modal>

{{-- ─── Modals: Edit Checklist (custom only) ─── --}}
@foreach($checklists as $item)
    @if($item->is_preset)
        @continue
    @endif
    <x-modal name="edit-checklist-{{ $item->id }}">
        <div class="p-6">
            <div class="flex items-start justify-between gap-4 mb-5">
                <div>
                    <h3 class="text-lg font-bold text-secondary-800 dark:text-neutral-100">Edit Checklist</h3>
                    <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-1">{{ $item->title }}</p>
                </div>
                <button type="button" x-on:click="show = false"
                    class="shrink-0 p-2 -m-2 text-neutral-400 hover:text-secondary-600 dark:hover:text-neutral-300 rounded-xl hover:bg-neutral-100 dark:hover:bg-secondary-700 transition-colors">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form action="{{ route('dashboard.planner.checklists.update', $item) }}" method="POST" class="space-y-4">
                @csrf
                @method('PATCH')
                <div>
                    <x-input-label for="edit-checklist-category-{{ $item->id }}" value="Kategori" />
                    <select id="edit-checklist-category-{{ $item->id }}" name="category_code"
                        class="mt-1 block w-full border-neutral-300 dark:border-neutral-600 dark:bg-secondary-700 dark:text-neutral-200 focus:border-primary-500 focus:ring-primary-500 rounded-xl shadow-sm"
                        required>
                        @foreach(\App\Models\WeddingChecklist::CATEGORIES as $code => $label)
                            <option value="{{ $code }}" @selected($item->category_code === $code)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <x-input-label for="edit-checklist-title-{{ $item->id }}" value="Nama Tugas" />
                    <x-text-input id="edit-checklist-title-{{ $item->id }}" name="title" class="mt-1 block w-full"
                        value="{{ old('title', $item->title) }}" required />
                </div>
                <div>
                    <x-input-label for="edit-checklist-desc-{{ $item->id }}" value="Deskripsi" />
                    <textarea id="edit-checklist-desc-{{ $item->id }}" name="description" rows="2"
                        class="mt-1 block w-full border-neutral-300 dark:border-neutral-600 dark:bg-secondary-700 dark:text-neutral-200 focus:border-primary-500 focus:ring-primary-500 rounded-xl shadow-sm">{{ old('description', $item->description) }}</textarea>
                </div>
                <div
                    class="flex items-center justify-end gap-3 pt-4 mt-4 border-t border-neutral-100 dark:border-secondary-700">
                    <x-secondary-button type="button" x-on:click="show = false">Batal</x-secondary-button>
                    <x-primary-button type="submit">Perbarui Checklist</x-primary-button>
                </div>
            </form>
        </div>
    </x-modal>
@endforeach

{{-- ─── Modals: Add Calendar Event ─── --}}
<div x-data="{ show: false, selectedDate: '' }"
    x-init="$watch('show', val => { if(val && window.__selectedCalendarDate) { selectedDate = window.__selectedCalendarDate; window.__selectedCalendarDate = null; } })"
    @open-calendar-modal.window="show = true" x-cloak>
    <div x-show="show" @click.away="show = false" @keydown.escape.window="show = false"
        class="fixed inset-0 z-50 overflow-y-auto px-4 py-6 sm:px-0">
        <div x-show="show" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="fixed inset-0 transform transition-all" @click="show = false">
            <div class="absolute inset-0 bg-secondary-900/60 backdrop-blur-sm dark:bg-secondary-950/80"></div>
        </div>
        <div x-show="show" x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            class="mb-6 bg-white dark:bg-secondary-800 rounded-2xl overflow-hidden shadow-2xl ring-1 ring-black/5 dark:ring-white/10 transform transition-all sm:w-full sm:max-w-2xl sm:mx-auto">
            <div class="p-6">
                <div class="flex items-start justify-between gap-4 mb-5">
                    <div>
                        <h3 class="text-lg font-bold text-secondary-800 dark:text-neutral-100">Tambah Event</h3>
                        <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-1">Tambahkan jadwal atau catatan ke
                            kalender.</p>
                    </div>
                    <button type="button" @click="show = false"
                        class="shrink-0 p-2 -m-2 text-neutral-400 hover:text-secondary-600 dark:hover:text-neutral-300 rounded-xl hover:bg-neutral-100 dark:hover:bg-secondary-700 transition-colors">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <form action="{{ route('dashboard.planner.items.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <input type="hidden" name="category" value="CALENDAR">
                    <input type="hidden" name="event_date" :value="selectedDate">
                    <input type="hidden" name="status" value="PENDING">
                    <div>
                        <x-input-label for="add-calendar-title" value="Judul Event" />
                        <x-text-input id="add-calendar-title" name="title" class="mt-1 block w-full"
                            placeholder="cth: Fitting Baju Pengantin" required />
                    </div>

                    <div>
                        <x-input-label for="add-calendar-notes" value="Catatan (Opsional)" />
                        <textarea id="add-calendar-notes" name="description" rows="2"
                            class="mt-1 block w-full border-neutral-300 dark:border-neutral-600 dark:bg-secondary-700 dark:text-neutral-200 focus:border-primary-500 focus:ring-primary-500 rounded-xl shadow-sm"
                            placeholder="cth: Konfirmasi vendor terlebih dahulu"></textarea>
                    </div>

                    <div
                        class="flex items-center justify-end gap-3 pt-4 mt-4 border-t border-neutral-100 dark:border-secondary-700">
                        <x-secondary-button type="button" @click="show = false">Batal</x-secondary-button>
                        <x-primary-button type="submit">Simpan Event</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>