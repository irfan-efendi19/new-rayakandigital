<x-app-layout>
    <div class="min-h-screen">
        {{-- Hero Header --}}
        <div class="hero-mesh grain-overlay border-b border-neutral-200/60 dark:border-secondary-700/40">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-7 sm:py-8">
                <nav class="flex items-center gap-1.5 text-xs text-neutral-400 dark:text-neutral-500 mb-4">
                    <a href="{{ route('dashboard') }}" class="hover:text-primary dark:hover:text-primary-400 transition-colors">Dashboard</a>
                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                    <a href="{{ route('dashboard.invitations.show', $invitation) }}" class="hover:text-primary dark:hover:text-primary-400 transition-colors truncate max-w-[150px]">{{ $invitation->title }}</a>
                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                    <span class="text-neutral-600 dark:text-neutral-400 font-medium">Pesan Tamu</span>
                </nav>

                <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
                    <div>
                        <h1 class="font-heading text-2xl sm:text-3xl font-bold text-secondary-800 dark:text-neutral-50 leading-tight">
                            Pesan & Doa Para Tamu
                        </h1>
                        <p class="text-sm text-neutral-500 dark:text-neutral-400 mt-1">Kumpulan ucapan hangat dari kerabat untuk &ldquo;{{ $invitation->title }}&rdquo;</p>
                    </div>
                    <a href="{{ route('dashboard.invitations.show', $invitation) }}"
                        class="self-start inline-flex items-center gap-2 px-4 py-2 bg-white/70 dark:bg-secondary-800/50 border border-neutral-300/80 dark:border-secondary-600 rounded-xl text-xs font-semibold text-neutral-700 dark:text-neutral-300 hover:bg-white dark:hover:bg-secondary-700 transition-all backdrop-blur-sm">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Kembali ke Undangan
                    </a>
                </div>
            </div>
        </div>

        {{-- Main Container --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-7 sm:py-8">
            <div class="bg-white dark:bg-secondary-800 rounded-2xl border border-neutral-200/80 dark:border-secondary-700/60 overflow-hidden shadow-sm">
                <div class="p-5 sm:p-6">
                    @if($invitation->wishes->isEmpty())
                        <div class="text-center py-14">
                            <div class="w-14 h-14 rounded-full bg-primary-50 dark:bg-primary-900/30 text-primary dark:text-primary-400 flex items-center justify-center mx-auto mb-3">
                                <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                            </div>
                            <h3 class="font-heading text-lg font-bold text-secondary-800 dark:text-neutral-100">Belum Ada Ucapan</h3>
                            <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-1 max-w-xs mx-auto">Ucapan dan doa dari tamu undangan akan ditampilkan di sini.</p>
                        </div>
                    @else
                        <div x-data="{
                            search: '',
                            perPage: 12,
                            viewMode: 'grid',
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
                                    confirmButtonColor: '#ef4444',
                                    cancelButtonColor: '#6b7280',
                                    confirmButtonText: 'Ya, hapus!',
                                    cancelButtonText: 'Batal',
                                    customClass: { popup: 'rounded-2xl' }
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
                                                Swal.fire({ icon: 'error', title: 'Gagal!', text: 'Terjadi kesalahan.', timer: 2000, showConfirmButton: false });
                                            }
                                        });
                                });
                            }
                        }">
                            {{-- Search & Controls --}}
                            <div class="flex flex-col sm:flex-row items-center justify-between gap-3 mb-6">
                                <div class="relative w-full sm:w-80">
                                    <input type="text" x-model="search" placeholder="Cari pesan atau nama..."
                                        class="w-full px-4 py-2.5 pl-10 text-xs sm:text-sm border border-neutral-200/80 dark:border-secondary-600 rounded-xl bg-neutral-50/50 dark:bg-secondary-900/50 text-secondary-800 dark:text-neutral-100 focus:ring-2 focus:ring-primary-500/30 focus:border-primary-500 placeholder-neutral-400 transition-all">
                                    <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </div>
                                <div class="flex items-center gap-2 w-full sm:w-auto justify-end">
                                    <div class="flex items-center bg-neutral-100 dark:bg-secondary-700 p-1 rounded-xl">
                                        <button @click="viewMode = 'grid'" :class="viewMode === 'grid' ? 'bg-white dark:bg-secondary-800 text-primary shadow-xs' : 'text-neutral-400'" class="p-1.5 rounded-lg transition-all" title="Tampilan Kartu">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                                        </button>
                                        <button @click="viewMode = 'table'" :class="viewMode === 'table' ? 'bg-white dark:bg-secondary-800 text-primary shadow-xs' : 'text-neutral-400'" class="p-1.5 rounded-lg transition-all" title="Tampilan Tabel">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
                                        </button>
                                    </div>
                                    <select x-model="perPage"
                                        class="px-3.5 py-2 text-xs border border-neutral-200/80 dark:border-secondary-600 rounded-xl bg-neutral-50/50 dark:bg-secondary-900/50 text-secondary-800 dark:text-neutral-100 focus:ring-2 focus:ring-primary-500/30 transition-all">
                                        <option value="12">12 data</option>
                                        <option value="24">24 data</option>
                                        <option value="0">Semua</option>
                                    </select>
                                </div>
                            </div>

                            {{-- Grid View --}}
                            <div x-show="viewMode === 'grid'" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                <template x-for="wish in displayWishes" :key="wish.id">
                                    <div class="group relative bg-neutral-50/70 dark:bg-secondary-900/40 rounded-2xl p-4 sm:p-5 border border-neutral-200/70 dark:border-secondary-700/50 hover:border-primary-200/80 dark:hover:border-primary-800/50 transition-all duration-200 flex flex-col justify-between">
                                        <div>
                                            <div class="flex items-center justify-between mb-3">
                                                <div class="flex items-center gap-2.5">
                                                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-primary-400 to-primary-600 text-white font-bold text-xs flex items-center justify-center shadow-xs"
                                                        x-text="wish.guest_name ? wish.guest_name.substring(0,1).toUpperCase() : '?'"></div>
                                                    <div>
                                                        <h4 class="text-xs sm:text-sm font-semibold text-secondary-800 dark:text-neutral-100" x-text="wish.guest_name"></h4>
                                                        <p class="text-[10px] text-neutral-400 dark:text-neutral-500 font-mono" x-text="wish.created_at_diff"></p>
                                                    </div>
                                                </div>
                                                <button @click="deleteWish(wish.id)" class="text-neutral-300 dark:text-neutral-600 hover:text-red-500 dark:hover:text-red-400 transition-colors p-1" title="Hapus ucapan">
                                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                </button>
                                            </div>
                                            <p class="text-xs sm:text-sm text-neutral-600 dark:text-neutral-300 italic leading-relaxed bg-white/60 dark:bg-secondary-800/60 p-3 rounded-xl border border-neutral-100 dark:border-secondary-700/50"
                                                x-text="`&ldquo;${wish.message}&rdquo;`"></p>
                                        </div>
                                    </div>
                                </template>
                            </div>

                            {{-- Table View --}}
                            <div x-show="viewMode === 'table'" class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-neutral-100 dark:divide-secondary-700 table-stacked">
                                    <thead class="bg-neutral-50/80 dark:bg-secondary-700/60">
                                        <tr>
                                            <th scope="col" class="px-5 py-3.5 text-left text-[11px] font-bold text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Nama Tamu</th>
                                            <th scope="col" class="px-5 py-3.5 text-left text-[11px] font-bold text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Pesan</th>
                                            <th scope="col" class="px-5 py-3.5 text-left text-[11px] font-bold text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Waktu</th>
                                            <th scope="col" class="px-5 py-3.5 text-right text-[11px] font-bold text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white dark:bg-secondary-800 divide-y divide-neutral-100 dark:divide-secondary-700/60">
                                        <template x-for="wish in displayWishes" :key="wish.id">
                                            <tr class="hover:bg-neutral-50/70 dark:hover:bg-secondary-700/30 transition-colors">
                                                <td class="px-5 py-4 whitespace-nowrap text-xs sm:text-sm font-semibold text-secondary-800 dark:text-neutral-100" x-text="wish.guest_name" data-label="Nama"></td>
                                                <td class="px-5 py-4 text-xs sm:text-sm text-neutral-600 dark:text-neutral-300 max-w-xs break-words" x-text="wish.message" data-label="Pesan"></td>
                                                <td class="px-5 py-4 whitespace-nowrap text-xs text-neutral-400 dark:text-neutral-500 font-mono" x-text="wish.created_at_diff" data-label="Waktu"></td>
                                                <td class="px-5 py-4 whitespace-nowrap text-right full-width hide-label">
                                                    <button @click="deleteWish(wish.id)" class="inline-flex items-center gap-1 px-2.5 py-1 text-xs font-medium text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors">
                                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                        Hapus
                                                    </button>
                                                </td>
                                            </tr>
                                        </template>
                                    </tbody>
                                </table>
                            </div>

                            <div x-show="totalFiltered === 0" class="text-center py-8 text-xs text-neutral-500 dark:text-neutral-400">
                                Tidak ada ucapan yang cocok dengan pencarian "<span x-text="search"></span>".
                            </div>
                            <div x-show="totalFiltered > 0" class="flex items-center justify-between pt-4 text-xs text-neutral-400 dark:text-neutral-500">
                                <span>Menampilkan <span class="font-medium text-neutral-700 dark:text-neutral-300" x-text="displayWishes.length"></span> dari <span class="font-medium text-neutral-700 dark:text-neutral-300" x-text="totalFiltered"></span> ucapan</span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
