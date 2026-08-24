{{-- ─── Modals: Add Item ─── --}}
@foreach($pillars as $pillar)
    @if(in_array($pillar['key'], ['CALENDAR', 'CHECKLIST', 'VENDOR']))
        @continue
    @endif
    <x-modal name="add-item-{{ $pillar['key'] }}">
        <div class="p-6">
            <div class="flex items-start justify-between gap-4 mb-5">
                <div>
                    <h3 class="text-lg font-bold text-secondary-800 dark:text-neutral-100">Tambah Item
                        {{ $pillar['label'] }}
                    </h3>
                    <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-1">Simpan item baru ke pilar
                        {{ $pillar['label'] }}.
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
                <input type="hidden" name="category" value="{{ $pillar['key'] }}">

                <div>
                    <x-input-label for="add-title-{{ $pillar['key'] }}" value="Judul" />
                    <x-text-input id="add-title-{{ $pillar['key'] }}" name="title" class="mt-1 block w-full"
                        placeholder="cth: Booking venue" required />
                    <x-input-error :messages="$errors->get('title')" class="mt-2" />
                </div>

                @if(!in_array($pillar['key'], ['PRE_WEDDING', 'SESERAHAN', 'ENGAGEMENT', 'BUDGET']))
                    <div>
                        <x-input-label for="add-desc-{{ $pillar['key'] }}" value="Deskripsi" />
                        <textarea id="add-desc-{{ $pillar['key'] }}" name="description" rows="2"
                            class="mt-1 block w-full border-neutral-300 dark:border-neutral-600 dark:bg-secondary-700 dark:text-neutral-200 focus:border-primary-500 focus:ring-primary-500 rounded-xl shadow-sm"
                            placeholder="Catatan opsional"></textarea>
                    </div>
                @endif

                <div class="grid grid-cols-2 gap-4">
                    @if(!in_array($pillar['key'], ['PRE_WEDDING', 'SESERAHAN', 'ENGAGEMENT', 'BUDGET']))
                        <div>
                            <x-input-label for="add-date-{{ $pillar['key'] }}" value="Tanggal" />
                            <x-text-input id="add-date-{{ $pillar['key'] }}" name="event_date" type="date"
                                class="mt-1 block w-full" />
                        </div>
                    @endif
                    <div
                        class="{{ in_array($pillar['key'], ['PRE_WEDDING', 'SESERAHAN', 'ENGAGEMENT', 'BUDGET']) ? 'col-span-2' : '' }}">
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
                                <input type="radio" name="status" value="IN_PROGRESS" x-model="selected"
                                    class="peer sr-only">
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
                </div>

                @if($pillar['key'] === 'BUDGET')
                    <div>
                        <x-input-label for="add-budget-group" value="Kategori Anggaran" />
                        <select id="add-budget-group" name="subcategory"
                            class="mt-1 block w-full border-neutral-300 dark:border-neutral-600 dark:bg-secondary-700 dark:text-neutral-200 focus:border-primary-500 focus:ring-primary-500 rounded-xl shadow-sm"
                            required>
                            @foreach(\App\Models\WeddingPlannerItem::BUDGET_CATEGORIES as $code => $config)
                                <option value="{{ $code }}">{{ $config['label'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="add-est-{{ $pillar['key'] }}" value="Budget (Rp)" />
                            <x-text-input id="add-est-{{ $pillar['key'] }}" name="estimated_cost" type="text"
                                inputmode="numeric" data-rupiah value="0" class="mt-1 block w-full" />
                        </div>
                        <div>
                            <x-input-label for="add-paid-{{ $pillar['key'] }}" value="Bayar (Rp)" />
                            <x-text-input id="add-paid-{{ $pillar['key'] }}" name="paid_amount" type="text" inputmode="numeric"
                                data-rupiah value="0" class="mt-1 block w-full" />
                        </div>
                    </div>
                @elseif($pillar['key'] === 'VENDOR')
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="add-est-{{ $pillar['key'] }}" value="Estimasi (Rp)" />
                            <x-text-input id="add-est-{{ $pillar['key'] }}" name="estimated_cost" type="text"
                                inputmode="numeric" data-rupiah value="0" class="mt-1 block w-full" />
                        </div>
                        <div>
                            <x-input-label for="add-paid-{{ $pillar['key'] }}" value="Bayar (Rp)" />
                            <x-text-input id="add-paid-{{ $pillar['key'] }}" name="paid_amount" type="text" inputmode="numeric"
                                data-rupiah value="0" class="mt-1 block w-full" />
                        </div>
                    </div>
                    <div>
                        <x-input-label for="add-contact-{{ $pillar['key'] }}" value="Kontak Vendor" />
                        <x-text-input id="add-contact-{{ $pillar['key'] }}" name="vendor_contact" class="mt-1 block w-full"
                            placeholder="cth: 0812-3456-7890" />
                    </div>
                @elseif($pillar['key'] === 'PRE_WEDDING')
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="add-est-{{ $pillar['key'] }}" value="Budget (Rp)" />
                            <x-text-input id="add-est-{{ $pillar['key'] }}" name="estimated_cost" type="text"
                                inputmode="numeric" data-rupiah value="0" class="mt-1 block w-full" />
                        </div>
                        <div>
                            <x-input-label for="add-paid-{{ $pillar['key'] }}" value="Bayar (Rp)" />
                            <x-text-input id="add-paid-{{ $pillar['key'] }}" name="paid_amount" type="text" inputmode="numeric"
                                data-rupiah value="0" class="mt-1 block w-full" />
                        </div>
                    </div>
                @endif

                @if($pillar['key'] === 'ENGAGEMENT')
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="add-pria-{{ $pillar['key'] }}" value="Biaya Pria (Rp)" />
                            <x-text-input id="add-pria-{{ $pillar['key'] }}" name="cost_pria" type="text" inputmode="numeric"
                                data-rupiah value="0" class="mt-1 block w-full" />
                        </div>
                        <div>
                            <x-input-label for="add-wanita-{{ $pillar['key'] }}" value="Biaya Wanita (Rp)" />
                            <x-text-input id="add-wanita-{{ $pillar['key'] }}" name="cost_wanita" type="text"
                                inputmode="numeric" data-rupiah value="0" class="mt-1 block w-full" />
                        </div>
                    </div>
                @endif

                @if($pillar['key'] === 'SESERAHAN')
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="add-party-{{ $pillar['key'] }}" value="Pihak" />
                            <select id="add-party-{{ $pillar['key'] }}" name="subcategory"
                                class="mt-1 block w-full border-neutral-300 dark:border-neutral-600 dark:bg-secondary-700 dark:text-neutral-200 focus:border-primary-500 focus:ring-primary-500 rounded-xl shadow-sm"
                                required>
                                <option value="PRIA">Pria</option>
                                <option value="WANITA">Wanita</option>
                            </select>
                        </div>
                        <div>
                            <x-input-label for="add-est-{{ $pillar['key'] }}" value="Biaya (Rp)" />
                            <x-text-input id="add-est-{{ $pillar['key'] }}" name="estimated_cost" type="text"
                                inputmode="numeric" data-rupiah value="0" class="mt-1 block w-full" />
                        </div>
                    </div>
                @endif

                <div
                    class="flex items-center justify-end gap-3 pt-4 mt-4 border-t border-neutral-100 dark:border-secondary-700">
                    <x-secondary-button type="button" x-on:click="show = false">Batal</x-secondary-button>
                    <x-primary-button type="submit">Simpan Item</x-primary-button>
                </div>
            </form>
        </div>
    </x-modal>
@endforeach

{{-- ─── Modals: Edit Item ─── --}}
@foreach($plannerItems as $item)
    <x-modal name="edit-item-{{ $item->id }}">
        <div class="p-6">
            <div class="flex items-start justify-between gap-4 mb-5">
                <div>
                    <h3 class="text-lg font-bold text-secondary-800 dark:text-neutral-100">Edit Item</h3>
                    <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-1">{{ $item->title }}</p>
                </div>
                <button type="button" x-on:click="show = false"
                    class="shrink-0 p-2 -m-2 text-neutral-400 hover:text-secondary-600 dark:hover:text-neutral-300 rounded-xl hover:bg-neutral-100 dark:hover:bg-secondary-700 transition-colors">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form action="{{ route('dashboard.planner.items.update', $item) }}" method="POST" class="space-y-4">
                @csrf
                @method('PATCH')
                <input type="hidden" name="category" value="{{ $item->category }}">

                <div>
                    <x-input-label for="edit-title-{{ $item->id }}" value="Judul" />
                    <x-text-input id="edit-title-{{ $item->id }}" name="title" class="mt-1 block w-full"
                        value="{{ old('title', $item->title) }}" required />
                </div>

                @if($item->category === 'VENDOR')
                    <div>
                        <x-input-label for="edit-vendor-type-{{ $item->id }}" value="Kategori Vendor" />
                        <select id="edit-vendor-type-{{ $item->id }}" name="vendor_type"
                            class="mt-1 block w-full border-neutral-300 dark:border-neutral-600 dark:bg-secondary-700 dark:text-neutral-200 focus:border-primary-500 focus:ring-primary-500 rounded-xl shadow-sm"
                            required>
                            @foreach(\App\Models\WeddingPlannerItem::VENDOR_TYPES as $code => $label)
                                <option value="{{ $code }}" @selected($item->vendor_type === $code)>{{ $label }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('vendor_type')" class="mt-2" />
                    </div>
                @endif

                @if($item->category === 'ENGAGEMENT')
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="edit-pria-{{ $item->id }}" value="Biaya Pria (Rp)" />
                            <x-text-input id="edit-pria-{{ $item->id }}" name="cost_pria" type="text" inputmode="numeric"
                                data-rupiah value="{{ old('cost_pria', (float) $item->cost_pria) }}"
                                class="mt-1 block w-full" />
                        </div>
                        <div>
                            <x-input-label for="edit-wanita-{{ $item->id }}" value="Biaya Wanita (Rp)" />
                            <x-text-input id="edit-wanita-{{ $item->id }}" name="cost_wanita" type="text" inputmode="numeric"
                                data-rupiah value="{{ old('cost_wanita', (float) $item->cost_wanita) }}"
                                class="mt-1 block w-full" />
                        </div>
                    </div>
                @endif

                @if($item->category === 'SESERAHAN')
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="edit-party-{{ $item->id }}" value="Pihak" />
                            <select id="edit-party-{{ $item->id }}" name="subcategory"
                                class="mt-1 block w-full border-neutral-300 dark:border-neutral-600 dark:bg-secondary-700 dark:text-neutral-200 focus:border-primary-500 focus:ring-primary-500 rounded-xl shadow-sm"
                                required>
                                <option value="PRIA" @selected($item->subcategory === 'PRIA')>Pria</option>
                                <option value="WANITA" @selected($item->subcategory === 'WANITA')>Wanita</option>
                            </select>
                        </div>
                        <div>
                            <x-input-label for="edit-est-{{ $item->id }}" value="Biaya (Rp)" />
                            <x-text-input id="edit-est-{{ $item->id }}" name="estimated_cost" type="text" inputmode="numeric"
                                data-rupiah class="mt-1 block w-full"
                                value="{{ old('estimated_cost', $item->estimated_cost) }}" />
                        </div>
                    </div>
                @endif

                @if($item->category === 'CALENDAR')
                    <div>
                        <x-input-label for="edit-event-date-{{ $item->id }}" value="Tanggal" />
                        <x-text-input id="edit-event-date-{{ $item->id }}" name="event_date" type="date"
                            class="mt-1 block w-full" value="{{ old('event_date', $item->event_date?->format('Y-m-d')) }}" />
                    </div>
                    <div>
                        <x-input-label for="edit-notes-{{ $item->id }}" value="Catatan" />
                        <textarea id="edit-notes-{{ $item->id }}" name="description" rows="2"
                            class="mt-1 block w-full border-neutral-300 dark:border-neutral-600 dark:bg-secondary-700 dark:text-neutral-200 focus:border-primary-500 focus:ring-primary-500 rounded-xl shadow-sm"
                            placeholder="Catatan event">{{ old('description', $item->description) }}</textarea>
                    </div>
                @endif

                <div>
                    <x-input-label value="Status" />
                    <div class="mt-2 grid grid-cols-2 sm:grid-cols-4 gap-2" x-data="{ selected: '{{ $item->status }}' }">
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

                @if($item->isFinancialCategory())
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="edit-est-{{ $item->id }}"
                                value="{{ $item->category === 'PRE_WEDDING' ? 'Budget' : 'Estimasi' }} (Rp)" />
                            <x-text-input id="edit-est-{{ $item->id }}" name="estimated_cost" type="text" inputmode="numeric"
                                data-rupiah class="mt-1 block w-full"
                                value="{{ old('estimated_cost', $item->estimated_cost) }}" />
                        </div>
                        <div>
                            <x-input-label for="edit-paid-{{ $item->id }}"
                                value="{{ $item->category === 'PRE_WEDDING' ? 'Bayar' : 'Terbayar' }} (Rp)" />
                            <x-text-input id="edit-paid-{{ $item->id }}" name="paid_amount" type="text" inputmode="numeric"
                                data-rupiah class="mt-1 block w-full" value="{{ old('paid_amount', $item->paid_amount) }}" />
                        </div>
                    </div>
                    @if($item->category !== 'PRE_WEDDING')
                        <div>
                            <x-input-label for="edit-contact-{{ $item->id }}" value="Kontak Vendor" />
                            <x-text-input id="edit-contact-{{ $item->id }}" name="vendor_contact" class="mt-1 block w-full"
                                value="{{ old('vendor_contact', $item->vendor_contact) }}" />
                        </div>
                    @endif
                @endif

                <div
                    class="flex items-center justify-end gap-3 pt-4 mt-4 border-t border-neutral-100 dark:border-secondary-700">
                    <x-secondary-button type="button" x-on:click="show = false">Batal</x-secondary-button>
                    <x-primary-button type="submit">Perbarui Item</x-primary-button>
                </div>
            </form>
        </div>
    </x-modal>
@endforeach