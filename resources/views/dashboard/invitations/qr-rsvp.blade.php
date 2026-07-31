<x-app-layout>
    <div class="min-h-screen">

        {{-- ─── HERO ─── --}}
        <div class="hero-mesh grain-overlay border-b border-neutral-200/60 dark:border-secondary-700/40">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-7 sm:py-8">

                {{-- Breadcrumb --}}
                <nav class="flex items-center gap-1.5 text-xs text-neutral-400 dark:text-neutral-500 mb-4">
                    <a href="{{ route('dashboard') }}" class="hover:text-primary dark:hover:text-primary-400 transition-colors">Dashboard</a>
                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                    <a href="{{ route('dashboard.invitations.show', $invitation) }}" class="hover:text-primary dark:hover:text-primary-400 transition-colors truncate max-w-[150px]">{{ $invitation->title }}</a>
                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                    <span class="text-neutral-600 dark:text-neutral-400 font-medium">QR RSVP Universal</span>
                </nav>

                <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
                    <div class="flex items-start gap-3 min-w-0">
                        <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-primary to-primary-600 flex items-center justify-center text-white shadow-lg shadow-primary/20 shrink-0">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
                        </div>
                        <div class="min-w-0">
                            <h1 class="font-heading text-2xl sm:text-3xl font-bold text-secondary-800 dark:text-neutral-50 leading-tight truncate">
                                QR RSVP Universal
                            </h1>
                            <p class="text-sm text-neutral-500 dark:text-neutral-400 mt-1">
                                Satu QR Code untuk semua tamu undangan <strong class="text-secondary-700 dark:text-neutral-300">"{{ $invitation->title }}"</strong>
                            </p>
                        </div>
                    </div>
                    <a href="{{ route('dashboard.invitations.show', $invitation) }}"
                        class="inline-flex items-center gap-1.5 px-3.5 py-2 text-xs font-semibold text-secondary-700 dark:text-neutral-300 border border-neutral-300/80 dark:border-secondary-600 rounded-xl hover:bg-white dark:hover:bg-secondary-700 transition-all bg-white/70 dark:bg-secondary-800/50 backdrop-blur-sm shrink-0">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                        Kembali
                    </a>
                </div>

                {{-- Stat Strip --}}
                <div class="mt-6 grid grid-cols-2 md:grid-cols-4 gap-px bg-neutral-200/70 dark:bg-secondary-700/50 rounded-2xl overflow-hidden border border-neutral-200/80 dark:border-secondary-700/50">
                    <div class="bg-white/80 dark:bg-secondary-800/70 px-3 sm:px-5 py-4 flex flex-col items-center sm:items-start text-center sm:text-left backdrop-blur-sm">
                        <span class="stat-value text-xl sm:text-2xl font-bold text-emerald-600 dark:text-emerald-400 tabular-nums">{{ $report['total_pax_hadir'] }}</span>
                        <span class="text-[10px] sm:text-xs text-neutral-500 dark:text-neutral-400 font-medium mt-0.5">Total PAX Hadir</span>
                    </div>
                    <div class="bg-white/80 dark:bg-secondary-800/70 px-3 sm:px-5 py-4 flex flex-col items-center sm:items-start text-center sm:text-left backdrop-blur-sm">
                        <span class="stat-value text-xl sm:text-2xl font-bold text-emerald-600 dark:text-emerald-400 tabular-nums">{{ $report['tamu_hadir'] }}</span>
                        <span class="text-[10px] sm:text-xs text-neutral-500 dark:text-neutral-400 font-medium mt-0.5">Hadir</span>
                    </div>
                    <div class="bg-white/80 dark:bg-secondary-800/70 px-3 sm:px-5 py-4 flex flex-col items-center sm:items-start text-center sm:text-left backdrop-blur-sm">
                        <span class="stat-value text-xl sm:text-2xl font-bold text-rose-600 dark:text-rose-400 tabular-nums">{{ $report['tamu_absen'] }}</span>
                        <span class="text-[10px] sm:text-xs text-neutral-500 dark:text-neutral-400 font-medium mt-0.5">Absen</span>
                    </div>
                    <div class="bg-white/80 dark:bg-secondary-800/70 px-3 sm:px-5 py-4 flex flex-col items-center sm:items-start text-center sm:text-left backdrop-blur-sm">
                        <span class="stat-value text-xl sm:text-2xl font-bold text-primary dark:text-primary-400 tabular-nums">{{ $report['total_tamu_respon'] }}</span>
                        <span class="text-[10px] sm:text-xs text-neutral-500 dark:text-neutral-400 font-medium mt-0.5">Total Respon</span>
                    </div>
                </div>

            </div>
        </div>

        {{-- ─── MAIN CONTENT ─── --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-7 sm:py-8 space-y-5">

            <div class="grid grid-cols-1 lg:grid-cols-5 gap-5">

                {{-- QR Code Card --}}
                <div class="lg:col-span-2 bg-white dark:bg-secondary-800 rounded-2xl border border-neutral-200/80 dark:border-secondary-700/60 p-6 sm:p-7 self-start">
                    <div class="flex items-center gap-2.5 mb-1">
                        <div class="w-8 h-8 rounded-lg bg-primary-50 dark:bg-primary-900/30 flex items-center justify-center text-primary dark:text-primary-400 flex-shrink-0">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
                        </div>
                        <h2 class="font-semibold text-sm text-secondary-800 dark:text-neutral-100">QR Code Undangan</h2>
                    </div>
                    <p class="text-xs text-neutral-500 dark:text-neutral-400 mb-5 ml-10">QR unik untuk tautan undangan ini. Cetak pada kartu fisik, tamu scan sendiri untuk konfirmasi kehadiran.</p>

                    <div class="flex flex-col items-center">
                        <div class="bg-white p-4 rounded-2xl shadow-sm border border-neutral-200 dark:border-neutral-600 inline-block">
                            <div class="w-52 h-52 sm:w-56 sm:h-56 flex items-center justify-center">
                                <img src="{{ $qrCodeData }}" alt="QR Code" class="w-full h-full">
                            </div>
                        </div>

                        <div class="mt-5 w-full space-y-2.5">
                            <div class="bg-neutral-50 dark:bg-secondary-700/50 border border-neutral-200 dark:border-secondary-600 rounded-xl p-3">
                                <p class="text-xs text-neutral-500 dark:text-neutral-400 mb-1">Tautan RSVP Universal:</p>
                                <div class="flex items-center gap-2">
                                    <input type="text" id="rsvp-url-input" value="{{ $rsvpUrl }}" readonly
                                        class="flex-1 text-xs font-mono bg-white dark:bg-secondary-800 border border-neutral-200 dark:border-secondary-600 rounded-lg px-2 py-1.5 text-neutral-700 dark:text-neutral-300 focus:ring-0 focus:border-primary-400">
                                    <button type="button" onclick="copyRsvpUrl()"
                                        class="flex-shrink-0 px-3 py-1.5 bg-primary-50 dark:bg-primary-900/50 text-primary-700 dark:text-primary-300 rounded-lg text-xs font-semibold hover:bg-primary-100 dark:hover:bg-primary-900/70 transition">
                                        Salin
                                    </button>
                                </div>
                            </div>

                            <a href="{{ $qrCodeData }}" download="qrcode-{{ $invitation->slug }}.png"
                                class="inline-flex items-center justify-center gap-2 w-full px-4 py-2.5 bg-gradient-to-r from-primary to-primary-600 text-white rounded-xl text-sm font-semibold shadow-sm shadow-primary/20 hover:shadow-md hover:shadow-primary/30 hover:-translate-y-0.5 active:translate-y-0 transition-all">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                Download QR Code
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Laporan Card --}}
                <div class="lg:col-span-3 bg-white dark:bg-secondary-800 rounded-2xl border border-neutral-200/80 dark:border-secondary-700/60 overflow-hidden">
                    <div class="px-5 sm:px-6 py-4 border-b border-neutral-100 dark:border-secondary-700/60 flex items-center justify-between">
                        <div class="flex items-center gap-2.5">
                            <div class="w-8 h-8 rounded-lg bg-emerald-50 dark:bg-emerald-900/30 flex items-center justify-center text-emerald-600 dark:text-emerald-400 flex-shrink-0">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <div>
                                <h2 class="font-semibold text-sm text-secondary-800 dark:text-neutral-100">Laporan Kehadiran</h2>
                                <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-0.5">Rekap data konfirmasi kehadiran dari tamu</p>
                            </div>
                        </div>
                        <span class="text-xs font-medium text-neutral-500 dark:text-neutral-400 bg-neutral-100 dark:bg-secondary-700 px-2.5 py-1 rounded-lg whitespace-nowrap">{{ $invitation->rsvps->count() }} respon</span>
                    </div>

                    <div class="p-5 sm:p-6 space-y-4">
                        {{-- Statistik Grid --}}
                        <div class="grid grid-cols-3 gap-3">
                            <div class="bg-neutral-50 dark:bg-secondary-700/50 border border-neutral-200/70 dark:border-secondary-600/50 rounded-xl p-3.5 text-center">
                                <p class="text-[10px] sm:text-xs text-neutral-500 dark:text-neutral-400">Hadir</p>
                                <p class="text-xl sm:text-2xl font-bold text-emerald-600 dark:text-emerald-400 mt-0.5 tabular-nums">{{ $report['tamu_hadir'] }}</p>
                            </div>
                            <div class="bg-neutral-50 dark:bg-secondary-700/50 border border-neutral-200/70 dark:border-secondary-600/50 rounded-xl p-3.5 text-center">
                                <p class="text-[10px] sm:text-xs text-neutral-500 dark:text-neutral-400">Absen</p>
                                <p class="text-xl sm:text-2xl font-bold text-red-500 dark:text-red-400 mt-0.5 tabular-nums">{{ $report['tamu_absen'] }}</p>
                            </div>
                            <div class="bg-neutral-50 dark:bg-secondary-700/50 border border-neutral-200/70 dark:border-secondary-600/50 rounded-xl p-3.5 text-center">
                                <p class="text-[10px] sm:text-xs text-neutral-500 dark:text-neutral-400">Ragu-Ragu</p>
                                <p class="text-xl sm:text-2xl font-bold text-amber-600 dark:text-amber-400 mt-0.5 tabular-nums">{{ $report['tamu_ragu'] ?? 0 }}</p>
                            </div>
                        </div>

                        {{-- Progress Bar Pax --}}
                        @if($invitation->isRsvpPaxLimited())
                            @php
                                $paxPercentage = $invitation->max_global_pax_quota > 0 ? min(100, round(($report['total_pax_hadir'] / $invitation->max_global_pax_quota) * 100)) : 0;
                            @endphp
                            <div class="bg-neutral-50 dark:bg-secondary-700/40 rounded-xl border border-neutral-200/70 dark:border-secondary-600/50 p-4">
                                <div class="flex items-center justify-between mb-2">
                                    <p class="text-xs font-medium text-neutral-600 dark:text-neutral-400">Kuota Pax Terpakai</p>
                                    <p class="text-xs font-semibold text-neutral-700 dark:text-neutral-300">{{ $paxPercentage }}%</p>
                                </div>
                                <div class="w-full bg-neutral-200 dark:bg-secondary-600 rounded-full h-2.5 overflow-hidden">
                                    <div class="bg-gradient-to-r from-primary to-primary-600 h-2.5 rounded-full transition-all duration-700" style="width: {{ $paxPercentage }}%"></div>
                                </div>
                                <p class="text-xs text-neutral-400 dark:text-neutral-500 mt-1.5">
                                    {{ $report['total_pax_hadir'] }} dari {{ $invitation->max_global_pax_quota }} pax
                                    (sisa <span class="font-semibold text-emerald-600 dark:text-emerald-400">{{ $invitation->remainingGlobalQuota() }}</span>)
                                </p>
                            </div>
                        @endif

                        {{-- Tabel Daftar Tamu RSVP --}}
                        <div class="border border-neutral-200/70 dark:border-secondary-600/50 rounded-xl overflow-hidden">
                            <div class="px-4 py-3 border-b border-neutral-100 dark:border-neutral-600 bg-neutral-50/60 dark:bg-secondary-700/30 flex items-center justify-between">
                                <p class="text-xs font-semibold text-neutral-700 dark:text-neutral-300">Daftar Tamu RSVP</p>
                                <span class="text-xs text-neutral-400 dark:text-neutral-500">{{ $invitation->rsvps->count() }} respon</span>
                            </div>
                            <div class="overflow-x-auto max-h-[410px] overflow-y-auto">
                                <table class="w-full text-xs table-stacked">
                                    <thead class="bg-neutral-50 dark:bg-secondary-800 text-neutral-500 dark:text-neutral-400">
                                        <tr>
                                            <th class="text-left px-4 py-2 font-medium">Nama Tamu</th>
                                            <th class="text-center px-2 py-2 font-medium">Status</th>
                                            <th class="text-center px-2 py-2 font-medium">Pax</th>
                                            <th class="text-left px-4 py-2 font-medium">Pesan</th>
                                            <th class="text-right px-4 py-2 font-medium">Waktu</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-neutral-100 dark:divide-neutral-600">
                                        @forelse($invitation->rsvps->sortByDesc('created_at') as $rsvp)
                                        <tr class="hover:bg-neutral-50 dark:hover:bg-secondary-600/50 transition-colors">
                                            <td class="px-4 py-2.5 text-neutral-700 dark:text-neutral-300 font-medium" data-label="Nama Tamu">{{ $rsvp->guest_name }}</td>
                                            <td class="px-2 py-2.5 text-center" data-label="Status">
                                                @if($rsvp->attendance === 'attending')
                                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300 text-[10px] font-semibold">Hadir</span>
                                                @elseif($rsvp->attendance === 'not_attending')
                                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400 text-[10px] font-semibold">Absen</span>
                                                @else
                                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-amber-100 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400 text-[10px] font-semibold">Ragu</span>
                                                @endif
                                            </td>
                                            <td class="px-2 py-2.5 text-center text-neutral-600 dark:text-neutral-400 font-mono" data-label="Pax">{{ $rsvp->pax }}</td>
                                            <td class="px-4 py-2.5 text-left text-neutral-500 dark:text-neutral-400 max-w-[200px] truncate" data-label="Pesan">{{ $rsvp->message ?? '-' }}</td>
                                            <td class="px-4 py-2.5 text-right text-neutral-400 dark:text-neutral-500 whitespace-nowrap font-mono" data-label="Waktu">{{ $rsvp->created_at->format('d/m H:i') }}</td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="5" class="px-4 py-6 text-center text-neutral-400 dark:text-neutral-500">Belum ada respon RSVP</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            window.copyRsvpUrl = function() {
                const input = document.getElementById('rsvp-url-input');
                if (input) {
                    input.select();
                    document.execCommand('copy');
                    Swal.fire({
                        icon: 'success',
                        title: 'Tersalin!',
                        text: 'Tautan RSVP berhasil disalin.',
                        timer: 1500,
                        showConfirmButton: false,
                    });
                }
            };
        });
    </script>
</x-app-layout>
