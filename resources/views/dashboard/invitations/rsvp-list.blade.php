<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div class="flex items-center gap-3">
                <div>
                    <h2 class="font-heading text-2xl font-bold text-secondary-800 dark:text-neutral-100">
                        RSVP Terbaru
                    </h2>
                    <p class="text-sm text-neutral-500 dark:text-neutral-400 mt-0.5">
                        Daftar konfirmasi kehadiran &mdash; {{ $invitation->title }}
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
                    @if($invitation->rsvps->isEmpty())
                        <p class="text-neutral-500 dark:text-neutral-400 text-center py-8 text-sm">Belum ada konfirmasi kehadiran dari tamu.</p>
                    @else
                        <div x-data="{
                            search: '',
                            perPage: 10,
                            rsvps: {{ Js::from($rsvpData) }},
                            get filteredRsvps() {
                                if (! this.search) return this.rsvps;
                                const q = this.search.toLowerCase();
                                return this.rsvps.filter(r => r.guest_name.toLowerCase().includes(q));
                            },
                            get displayRsvps() {
                                const limit = parseInt(this.perPage);
                                return limit === 0 ? this.filteredRsvps : this.filteredRsvps.slice(0, limit);
                            },
                            get totalFiltered() {
                                return this.filteredRsvps.length;
                            }
                        }">
                            <div class="flex flex-col sm:flex-row gap-3 mb-4">
                                <div class="relative flex-1">
                                    <input type="text" x-model="search" placeholder="Cari nama tamu..."
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
                                                class="px-6 py-3 text-left text-xs font-semibold text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Kehadiran</th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-semibold text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Jumlah (Pax)</th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-semibold text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Pesan</th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-semibold text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Waktu</th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-semibold text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Terakhir Diupdate</th>
                                        </tr>
                                    </thead>
                                    <tbody
                                        class="bg-white dark:bg-secondary-800 divide-y divide-neutral-100 dark:divide-secondary-700">
                                        <template x-for="rsvp in displayRsvps" :key="rsvp.id">
                                            <tr class="hover:bg-neutral-50 dark:hover:bg-secondary-700 transition-colors">
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-secondary-800 dark:text-neutral-100"
                                                    x-text="rsvp.guest_name" data-label="Nama Tamu"></td>
                                                <td class="px-6 py-4 whitespace-nowrap" data-label="Kehadiran">
                                                    <span
                                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold"
                                                        :class="{
                                                            'bg-green-100 dark:bg-green-900/50 text-green-700 dark:text-green-300': rsvp.attendance === 'attending',
                                                            'bg-red-100 dark:bg-red-900/50 text-red-700 dark:text-red-300': rsvp.attendance === 'not_attending',
                                                            'bg-amber-100 dark:bg-amber-900/50 text-amber-700 dark:text-amber-300': rsvp.attendance === 'uncertain'
                                                        }" x-text="rsvp.attendance_label">
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-600 dark:text-neutral-400 font-mono"
                                                    x-text="rsvp.pax" data-label="Jumlah (Pax)"></td>
                                                <td class="px-6 py-4 text-sm text-neutral-500 dark:text-neutral-400 max-w-[200px] truncate"
                                                    x-text="rsvp.message || '-'" data-label="Pesan"></td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-500 dark:text-neutral-400 font-mono"
                                                    x-text="rsvp.created_at" data-label="Waktu"></td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-500 dark:text-neutral-400 font-mono"
                                                    x-text="rsvp.updated_at" data-label="Terakhir Diupdate"></td>
                                            </tr>
                                        </template>
                                    </tbody>
                                </table>
                                <div x-show="totalFiltered === 0"
                                    class="text-center py-6 text-sm text-neutral-500 dark:text-neutral-400">
                                    Tidak ada tamu yang cocok dengan pencarian "<span x-text="search"></span>".
                                </div>
                                <div x-show="totalFiltered > 0"
                                    class="flex items-center justify-between pt-3 text-xs text-neutral-500 dark:text-neutral-400">
                                    <span>Menampilkan <span x-text="displayRsvps.length"></span> dari <span
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
