{{-- ─── Modals: Add Rundown ─── --}}
<x-modal name="add-rundown">
    <div class="p-6">
        <div class="flex items-start justify-between gap-4 mb-5">
            <div>
                <h3 class="text-lg font-bold text-secondary-800 dark:text-neutral-100">Tambah Rundown</h3>
                <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-1">Tambahkan jadwal kegiatan Hari H.</p>
            </div>
            <button type="button" x-on:click="show = false"
                class="shrink-0 p-2 -m-2 text-neutral-400 hover:text-secondary-600 dark:hover:text-neutral-300 rounded-xl hover:bg-neutral-100 dark:hover:bg-secondary-700 transition-colors">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <form action="{{ route('dashboard.planner.rundowns.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <x-input-label for="add-rundown-name" value="Nama Kegiatan" />
                <x-text-input id="add-rundown-name" name="activity_name" class="mt-1 block w-full"
                    placeholder="cth: Akad Nikah" required />
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <x-input-label for="add-rundown-start" value="Mulai (HH:MM)" />
                    <x-text-input id="add-rundown-start" name="time_start" type="time" class="mt-1 block w-full"
                        required />
                </div>
                <div>
                    <x-input-label for="add-rundown-end" value="Selesai (HH:MM)" />
                    <x-text-input id="add-rundown-end" name="time_end" type="time" class="mt-1 block w-full" />
                </div>
            </div>

            <div>
                <x-input-label for="add-rundown-pic" value="Person in Charge" />
                <x-text-input id="add-rundown-pic" name="person_in_charge" class="mt-1 block w-full"
                    placeholder="cth: MC / Panitia" />
            </div>

            <div>
                <x-input-label for="add-rundown-notes" value="Catatan" />
                <textarea id="add-rundown-notes" name="notes" rows="2"
                    class="mt-1 block w-full border-neutral-300 dark:border-neutral-600 dark:bg-secondary-700 dark:text-neutral-200 focus:border-primary-500 focus:ring-primary-500 rounded-xl shadow-sm"></textarea>
            </div>

            <div
                class="flex items-center justify-end gap-3 pt-4 mt-4 border-t border-neutral-100 dark:border-secondary-700">
                <x-secondary-button type="button" x-on:click="show = false">Batal</x-secondary-button>
                <x-primary-button type="submit">Simpan Rundown</x-primary-button>
            </div>
        </form>
    </div>
</x-modal>

{{-- ─── Modals: Edit Rundown ─── --}}
@foreach($rundowns as $rundown)
    <x-modal name="edit-rundown-{{ $rundown->id }}">
        <div class="p-6">
            <div class="flex items-start justify-between gap-4 mb-5">
                <div>
                    <h3 class="text-lg font-bold text-secondary-800 dark:text-neutral-100">Edit Rundown</h3>
                    <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-1">{{ $rundown->activity_name }}</p>
                </div>
                <button type="button" x-on:click="show = false"
                    class="shrink-0 p-2 -m-2 text-neutral-400 hover:text-secondary-600 dark:hover:text-neutral-300 rounded-xl hover:bg-neutral-100 dark:hover:bg-secondary-700 transition-colors">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form action="{{ route('dashboard.planner.rundowns.update', $rundown) }}" method="POST" class="space-y-4">
                @csrf
                @method('PATCH')
                <div>
                    <x-input-label for="edit-rundown-name-{{ $rundown->id }}" value="Nama Kegiatan" />
                    <x-text-input id="edit-rundown-name-{{ $rundown->id }}" name="activity_name" class="mt-1 block w-full"
                        value="{{ old('activity_name', $rundown->activity_name) }}" required />
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <x-input-label for="edit-rundown-start-{{ $rundown->id }}" value="Mulai (HH:MM)" />
                        <x-text-input id="edit-rundown-start-{{ $rundown->id }}" name="time_start" type="time"
                            class="mt-1 block w-full" value="{{ $rundown->time_start->format('H:i') }}" required />
                    </div>
                    <div>
                        <x-input-label for="edit-rundown-end-{{ $rundown->id }}" value="Selesai (HH:MM)" />
                        <x-text-input id="edit-rundown-end-{{ $rundown->id }}" name="time_end" type="time"
                            class="mt-1 block w-full" value="{{ $rundown->time_end?->format('H:i') }}" />
                    </div>
                </div>

                <div>
                    <x-input-label for="edit-rundown-pic-{{ $rundown->id }}" value="Person in Charge" />
                    <x-text-input id="edit-rundown-pic-{{ $rundown->id }}" name="person_in_charge" class="mt-1 block w-full"
                        value="{{ old('person_in_charge', $rundown->person_in_charge) }}" />
                </div>

                <div>
                    <x-input-label for="edit-rundown-notes-{{ $rundown->id }}" value="Catatan" />
                    <textarea id="edit-rundown-notes-{{ $rundown->id }}" name="notes" rows="2"
                        class="mt-1 block w-full border-neutral-300 dark:border-neutral-600 dark:bg-secondary-700 dark:text-neutral-200 focus:border-primary-500 focus:ring-primary-500 rounded-xl shadow-sm">{{ old('notes', $rundown->notes) }}</textarea>
                </div>

                <div
                    class="flex items-center justify-end gap-3 pt-4 mt-4 border-t border-neutral-100 dark:border-secondary-700">
                    <x-secondary-button type="button" x-on:click="show = false">Batal</x-secondary-button>
                    <x-primary-button type="submit">Perbarui Rundown</x-primary-button>
                </div>
            </form>
        </div>
    </x-modal>
@endforeach