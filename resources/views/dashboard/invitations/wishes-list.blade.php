<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div class="flex items-center gap-3">
                <div>
                    <h2 class="font-heading text-2xl font-bold text-secondary-800 dark:text-neutral-100">
                        Pesan Para Tamu
                    </h2>
                    <p class="text-sm text-neutral-500 dark:text-neutral-400 mt-0.5">
                        Semua ucapan dan doa &mdash; {{ $invitation->title }}
                    </p>
                </div>
            </div>
            <a href="{{ route('dashboard.invitations.show', $invitation) }}"
                class="inline-flex items-center gap-2 px-4 py-2 bg-white dark:bg-secondary-800 border border-neutral-300 dark:border-neutral-600 rounded-xl text-sm font-semibold text-neutral-700 dark:text-neutral-300 hover:bg-neutral-50 dark:hover:bg-secondary-700 transition-all">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-secondary-800 rounded-2xl shadow-soft border border-neutral-100 dark:border-secondary-700 overflow-hidden">
                <div class="p-5">
                    @if($invitation->wishes->isEmpty())
                        <p class="text-neutral-500 dark:text-neutral-400 text-center py-8 text-sm">Belum ada ucapan dari tamu.</p>
                    @else
                        <div x-data="{
                            search: '',
                            perPage: 10,
                            wishes: {{ Js::from($wishesData) }},
                            get filteredWishes() {
                                if (! this.search) return this.wishes;
                                const q = this.search.toLowerCase();
                                return this.wishes.filter(w => w.guest_name.toLowerCase().includes(q) || w.message.toLowerCase().includes(q));
                            },
                            get displayWishes() {
                                const limit = parseInt(this.perPage);
                                return limit === 0 ? this.filteredWishes : this.filteredWishes.slice(0, limit);
                            },
                            get totalFiltered() {
                                return this.filteredWishes.length;
                            },
                            deleteWish(id) {
                                Swal.fire({
                                    title: 'Hapus Ucapan?',
                                    text: 'Ucapan ini akan dihapus permanen.',
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonColor: '#d33',
                                    cancelButtonColor: '#3085d6',
                                    confirmButtonText: 'Ya, hapus!',
                                    cancelButtonText: 'Batal',
                                }).then((result) => {
                                    if (! result.isConfirmed) return;
                                    const url = '{{ route('dashboard.invitations.wishes.destroy', ['invitation' => $invitation, 'wish' => '__ID__']) }}'.replace('__ID__', id);
                                    fetch(url, { method: 'DELETE', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } })
                                        .then(r => r.json())
                                        .then(data => {
                                            if (data.success) {
                                                this.wishes = this.wishes.filter(w => w.id !== id);
                                                Swal.fire({ icon: 'success', title: 'Berhasil!', text: data.message, timer: 1500, showConfirmButton: false });
                                            } else {
                                                Swal.fire({ icon: 'error', title: 'Gagal!', text: 'Terjadi kesalahan. Silakan coba lagi.', timer: 2000, showConfirmButton: false });
                                            }
                                        });
                                });
                            }
                        }">
                            <div class="flex flex-col sm:flex-row gap-3 mb-4">
                                <div class="relative flex-1">
                                    <input type="text" x-model="search" placeholder="Cari nama atau pesan..."
                                        class="w-full px-4 py-2.5 pl-10 text-sm border border-neutral-200 dark:border-secondary-600 rounded-xl bg-white dark:bg-secondary-800 text-secondary-800 dark:text-neutral-100 focus:ring-2 focus:ring-primary-500 focus:border-transparent placeholder-neutral-400 dark:placeholder-neutral-500">
                                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-neutral-400" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </div>
                                <select x-model="perPage"
                                    class="px-3 py-2.5 text-sm border border-neutral-200 dark:border-secondary-600 rounded-xl bg-white dark:bg-secondary-800 text-secondary-800 dark:text-neutral-100 focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                                    <option value="10">10 data</option>
                                    <option value="20">20 data</option>
                                    <option value="50">50 data</option>
                                    <option value="0">Semua</option>
                                </select>
                            </div>

                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-neutral-200 dark:divide-secondary-700 table-stacked">
                                    <thead class="bg-neutral-50 dark:bg-secondary-700">
                                        <tr>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-semibold text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Nama Tamu</th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-semibold text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Pesan</th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-semibold text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Waktu</th>
                                            <th scope="col"
                                                class="px-6 py-3 text-right text-xs font-semibold text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody
                                        class="bg-white dark:bg-secondary-800 divide-y divide-neutral-100 dark:divide-secondary-700">
                                        <template x-for="wish in displayWishes" :key="wish.id">
                                            <tr class="hover:bg-neutral-50 dark:hover:bg-secondary-700 transition-colors">
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-secondary-800 dark:text-neutral-100"
                                                    x-text="wish.guest_name" data-label="Nama Tamu"></td>
                                                <td class="px-6 py-4 text-sm text-neutral-600 dark:text-neutral-400 max-w-xs break-words"
                                                    x-text="wish.message" data-label="Pesan"></td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-500 dark:text-neutral-400 font-mono"
                                                    x-text="wish.created_at_diff" data-label="Waktu"></td>
                                                <td class="px-6 py-4 whitespace-nowrap text-right full-width hide-label">
                                                    <button @click="deleteWish(wish.id)"
                                                        class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-semibold text-red-600 dark:text-red-400 bg-red-50 dark:bg-red-900/30 rounded-lg hover:bg-red-100 dark:hover:bg-red-900/50 transition">
                                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                        Hapus
                                                    </button>
                                                </td>
                                            </tr>
                                        </template>
                                    </tbody>
                                </table>
                                <div x-show="totalFiltered === 0"
                                    class="text-center py-6 text-sm text-neutral-500 dark:text-neutral-400">
                                    Tidak ada ucapan yang cocok dengan pencarian "<span x-text="search"></span>".
                                </div>
                                <div x-show="totalFiltered > 0"
                                    class="flex items-center justify-between pt-3 text-xs text-neutral-500 dark:text-neutral-400">
                                    <span>Menampilkan <span x-text="displayWishes.length"></span> dari <span
                                            x-text="totalFiltered"></span> data</span>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
