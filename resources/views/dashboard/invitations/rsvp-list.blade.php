<x-app-layout>
    @php
        $totalAttending = $invitation->rsvps->where('attendance', 'attending')->count();
        $totalNotAttending = $invitation->rsvps->where('attendance', 'not_attending')->count();
        $totalUncertain = $invitation->rsvps->where('attendance', 'uncertain')->count();
        $totalPax = $invitation->rsvps->sum('pax');
    @endphp

    <div class="min-h-screen">
        {{-- Hero Header --}}
        <div class="hero-mesh grain-overlay border-b border-neutral-200/60 dark:border-secondary-700/40">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-7 sm:py-8">
                <nav class="flex items-center gap-1.5 text-xs text-neutral-400 dark:text-neutral-500 mb-4">
                    <a href="{{ route('dashboard') }}" class="hover:text-primary dark:hover:text-primary-400 transition-colors">Dashboard</a>
                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                    <a href="{{ route('dashboard.invitations.show', $invitation) }}" class="hover:text-primary dark:hover:text-primary-400 transition-colors truncate max-w-[150px]">{{ $invitation->title }}</a>
                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                    <span class="text-neutral-600 dark:text-neutral-400 font-medium">RSVP</span>
                </nav>

                <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
                    <div>
                        <h1 class="font-heading text-2xl sm:text-3xl font-bold text-secondary-800 dark:text-neutral-50 leading-tight">
                            Konfirmasi Kehadiran (RSVP)
                        </h1>
                        <p class="text-sm text-neutral-500 dark:text-neutral-400 mt-1">Daftar respon RSVP untuk &ldquo;{{ $invitation->title }}&rdquo;</p>
                    </div>
                    <a href="{{ route('dashboard.invitations.show', $invitation) }}"
                        class="self-start inline-flex items-center gap-2 px-4 py-2 bg-white/70 dark:bg-secondary-800/50 border border-neutral-300/80 dark:border-secondary-600 rounded-xl text-xs font-semibold text-neutral-700 dark:text-neutral-300 hover:bg-white dark:hover:bg-secondary-700 transition-all backdrop-blur-sm">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Kembali ke Undangan
                    </a>
                </div>

                {{-- Quick Stat Summary Strip --}}
                <div class="mt-6 grid grid-cols-4 gap-px bg-neutral-200/70 dark:bg-secondary-700/50 rounded-2xl overflow-hidden border border-neutral-200/80 dark:border-secondary-700/50">
                    <div class="bg-white/80 dark:bg-secondary-800/70 px-3 sm:px-5 py-3.5 flex flex-col items-center sm:items-start text-center sm:text-left backdrop-blur-sm">
                        <span class="stat-value text-lg sm:text-xl font-bold text-emerald-600 dark:text-emerald-400 tabular-nums">{{ $totalAttending }}</span>
                        <span class="text-[10px] sm:text-xs text-neutral-500 dark:text-neutral-400 font-medium">Hadir</span>
                    </div>
                    <div class="bg-white/80 dark:bg-secondary-800/70 px-3 sm:px-5 py-3.5 flex flex-col items-center sm:items-start text-center sm:text-left backdrop-blur-sm">
                        <span class="stat-value text-lg sm:text-xl font-bold text-amber-600 dark:text-amber-400 tabular-nums">{{ $totalUncertain }}</span>
                        <span class="text-[10px] sm:text-xs text-neutral-500 dark:text-neutral-400 font-medium">Ragu-ragu</span>
                    </div>
                    <div class="bg-white/80 dark:bg-secondary-800/70 px-3 sm:px-5 py-3.5 flex flex-col items-center sm:items-start text-center sm:text-left backdrop-blur-sm">
                        <span class="stat-value text-lg sm:text-xl font-bold text-red-500 dark:text-red-400 tabular-nums">{{ $totalNotAttending }}</span>
                        <span class="text-[10px] sm:text-xs text-neutral-500 dark:text-neutral-400 font-medium">Tidak Hadir</span>
                    </div>
                    <div class="bg-white/80 dark:bg-secondary-800/70 px-3 sm:px-5 py-3.5 flex flex-col items-center sm:items-start text-center sm:text-left backdrop-blur-sm">
                        <span class="stat-value text-lg sm:text-xl font-bold text-primary dark:text-primary-400 tabular-nums">{{ $totalPax }}</span>
                        <span class="text-[10px] sm:text-xs text-neutral-500 dark:text-neutral-400 font-medium">Total Pax</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Table Container --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-7 sm:py-8">
            <div class="bg-white dark:bg-secondary-800 rounded-2xl border border-neutral-200/80 dark:border-secondary-700/60 overflow-hidden shadow-sm">
                <div class="p-5 sm:p-6">
                    @if($invitation->rsvps->isEmpty())
                        <div class="text-center py-12">
                            <div class="w-12 h-12 rounded-2xl bg-neutral-100 dark:bg-secondary-700 flex items-center justify-center mx-auto mb-3 text-neutral-400">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <p class="text-sm font-semibold text-secondary-800 dark:text-neutral-200">Belum ada konfirmasi RSVP</p>
                            <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-1">Respon dari tamu akan secara otomatis tercatat di sini.</p>
                        </div>
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
                            <div class="flex flex-col sm:flex-row gap-3 mb-5">
                                <div class="relative flex-1">
                                    <input type="text" x-model="search" placeholder="Cari nama tamu..."
                                        class="w-full px-4 py-2.5 pl-10 text-xs sm:text-sm border border-neutral-200/80 dark:border-secondary-600 rounded-xl bg-neutral-50/50 dark:bg-secondary-900/50 text-secondary-800 dark:text-neutral-100 focus:ring-2 focus:ring-primary-500/30 focus:border-primary-500 placeholder-neutral-400 transition-all">
                                    <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </div>
                                <select x-model="perPage"
                                    class="px-3.5 py-2.5 text-xs sm:text-sm border border-neutral-200/80 dark:border-secondary-600 rounded-xl bg-neutral-50/50 dark:bg-secondary-900/50 text-secondary-800 dark:text-neutral-100 focus:ring-2 focus:ring-primary-500/30 focus:border-primary-500 transition-all">
                                    <option value="10">10 per halaman</option>
                                    <option value="20">20 per halaman</option>
                                    <option value="50">50 per halaman</option>
                                    <option value="0">Tampilkan Semua</option>
                                </select>
                            </div>

                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-neutral-100 dark:divide-secondary-700 table-stacked">
                                    <thead class="bg-neutral-50/80 dark:bg-secondary-700/60">
                                        <tr>
                                            <th scope="col" class="px-5 py-3.5 text-left text-[11px] font-bold text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Nama Tamu</th>
                                            <th scope="col" class="px-5 py-3.5 text-left text-[11px] font-bold text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Kehadiran</th>
                                            <th scope="col" class="px-5 py-3.5 text-left text-[11px] font-bold text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Jumlah (Pax)</th>
                                            <th scope="col" class="px-5 py-3.5 text-left text-[11px] font-bold text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Pesan</th>
                                            <th scope="col" class="px-5 py-3.5 text-left text-[11px] font-bold text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Waktu WAP</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white dark:bg-secondary-800 divide-y divide-neutral-100 dark:divide-secondary-700/60">
                                        <template x-for="rsvp in displayRsvps" :key="rsvp.id">
                                            <tr class="hover:bg-neutral-50/70 dark:hover:bg-secondary-700/30 transition-colors">
                                                <td class="px-5 py-4 whitespace-nowrap text-xs sm:text-sm font-semibold text-secondary-800 dark:text-neutral-100"
                                                    x-text="rsvp.guest_name" data-label="Nama Tamu"></td>
                                                <td class="px-5 py-4 whitespace-nowrap" data-label="Kehadiran">
                                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-md text-[11px] font-semibold"
                                                        :class="{
                                                            'bg-emerald-100 dark:bg-emerald-900/40 text-emerald-700 dark:text-emerald-300': rsvp.attendance === 'attending',
                                                            'bg-red-100 dark:bg-red-900/40 text-red-700 dark:text-red-300': rsvp.attendance === 'not_attending',
                                                            'bg-amber-100 dark:bg-amber-900/40 text-amber-700 dark:text-amber-300': rsvp.attendance === 'uncertain'
                                                        }">
                                                        <span class="w-1.5 h-1.5 rounded-full"
                                                            :class="{
                                                                'bg-emerald-500': rsvp.attendance === 'attending',
                                                                'bg-red-500': rsvp.attendance === 'not_attending',
                                                                'bg-amber-500': rsvp.attendance === 'uncertain'
                                                            }"></span>
                                                        <span x-text="rsvp.attendance_label"></span>
                                                    </span>
                                                </td>
                                                <td class="px-5 py-4 whitespace-nowrap text-xs sm:text-sm text-neutral-600 dark:text-neutral-300 font-mono font-medium"
                                                    x-text="rsvp.pax" data-label="Pax"></td>
                                                <td class="px-5 py-4 text-xs sm:text-sm text-neutral-500 dark:text-neutral-400 max-w-xs truncate"
                                                    x-text="rsvp.message || '-'" data-label="Pesan"></td>
                                                <td class="px-5 py-4 whitespace-nowrap text-xs text-neutral-400 dark:text-neutral-500 font-mono"
                                                    x-text="rsvp.created_at" data-label="Waktu"></td>
                                            </tr>
                                        </template>
                                    </tbody>
                                </table>
                                <div x-show="totalFiltered === 0" class="text-center py-8 text-xs text-neutral-500 dark:text-neutral-400">
                                    Tidak ada data RSVP yang cocok dengan pencarian "<span x-text="search"></span>".
                                </div>
                                <div x-show="totalFiltered > 0" class="flex items-center justify-between pt-4 text-xs text-neutral-400 dark:text-neutral-500">
                                    <span>Menampilkan <span class="font-medium text-neutral-700 dark:text-neutral-300" x-text="displayRsvps.length"></span> dari <span class="font-medium text-neutral-700 dark:text-neutral-300" x-text="totalFiltered"></span> data</span>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
