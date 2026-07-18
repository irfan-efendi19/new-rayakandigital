<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h2 class="font-heading text-2xl font-bold text-secondary-800 dark:text-neutral-100">
                    QR RSVP Universal
                </h2>
                <p class="text-sm text-neutral-500 dark:text-neutral-400 mt-0.5">
                    {{ $invitation->title }}
                </p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('dashboard.invitations.show', $invitation) }}"
                    class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-neutral-600 dark:text-neutral-400 bg-white dark:bg-secondary-800 border border-neutral-300 dark:border-neutral-600 rounded-xl hover:bg-neutral-50 dark:hover:bg-secondary-700 hover:border-primary-300 transition-all">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-secondary-800 rounded-2xl shadow-soft border border-neutral-100 dark:border-secondary-700 overflow-hidden">
                <div class="p-6 md:p-8">
                    <div class="flex items-center gap-3 mb-1">
                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-primary-100 dark:bg-primary-900/50 text-primary-700 dark:text-primary-300">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                            </svg>
                        </span>
                        <h3 class="font-heading text-lg font-bold text-secondary-800 dark:text-neutral-100">
                            QR RSVP Universal & Laporan</h3>
                    </div>
                    <p class="text-sm text-neutral-500 dark:text-neutral-400 mb-6 ml-11">
                        Satu QR Code untuk semua tamu. Cetak pada kartu undangan fisik. Tamu scan sendiri untuk konfirmasi kehadiran.
                    </p>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        {{-- QR Code --}}
                        <div class="bg-neutral-50 dark:bg-secondary-700 p-5 rounded-2xl border border-neutral-200 dark:border-secondary-700">
                            <h4 class="font-heading text-base font-bold text-secondary-800 dark:text-neutral-100 mb-1">QR Code Undangan</h4>
                            <p class="text-xs text-neutral-500 dark:text-neutral-400 mb-4">QR Code unik untuk tautan undangan ini. Cetak pada kartu fisik.</p>

                            <div class="flex flex-col items-center">
                                <div class="bg-white p-4 rounded-2xl shadow-sm border border-neutral-200 dark:border-neutral-600 inline-block">
                                    <div class="w-56 h-56 flex items-center justify-center">
                                        <img src="{{ $qrCodeData }}" alt="QR Code" class="w-full h-full">
                                    </div>
                                </div>

                                <div class="mt-4 w-full space-y-2">
                                    <div class="bg-white dark:bg-secondary-800 border border-neutral-200 dark:border-neutral-600 rounded-xl p-3">
                                        <p class="text-xs text-neutral-500 dark:text-neutral-400 mb-1">Tautan RSVP Universal:</p>
                                        <div class="flex items-center gap-2">
                                            <input type="text" id="rsvp-url-input" value="{{ $rsvpUrl }}" readonly
                                                class="flex-1 text-xs font-mono bg-neutral-50 dark:bg-secondary-700 border border-neutral-200 dark:border-neutral-600 rounded-lg px-2 py-1.5 text-neutral-700 dark:text-neutral-300">
                                            <button type="button" onclick="copyRsvpUrl()"
                                                class="flex-shrink-0 px-3 py-1.5 bg-primary-50 dark:bg-primary-900/50 text-primary-700 dark:text-primary-300 rounded-lg text-xs font-semibold hover:bg-primary-100 dark:hover:bg-primary-900/70 transition">
                                                Salin
                                            </button>
                                        </div>
                                    </div>

                                    <a href="{{ $qrCodeData }}" download="qrcode-{{ $invitation->slug }}.png"
                                        class="inline-flex items-center justify-center gap-2 w-full px-4 py-2.5 bg-gradient-to-r from-primary to-primary-600 text-white rounded-xl text-sm font-semibold shadow-sm hover:shadow-md hover:scale-[1.01] active:scale-[0.99] transition-all">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                        </svg>
                                        Download QR Code
                                    </a>
                                </div>
                            </div>
                        </div>

                        {{-- Laporan --}}
                        <div class="space-y-4">
                            <h4 class="font-heading text-base font-bold text-secondary-800 dark:text-neutral-100">Laporan Kehadiran</h4>
                            <p class="text-xs text-neutral-500 dark:text-neutral-400 -mt-3">Rekap data konfirmasi kehadiran dari tamu.</p>

                            <div id="rsvp-report" class="space-y-3">
                                {{-- Total Pax Hadir --}}
                                <div class="bg-emerald-50 dark:bg-emerald-900/10 border border-emerald-200 dark:border-emerald-800/50 rounded-xl p-4">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-xl bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center text-emerald-600 dark:text-emerald-400">
                                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="text-xs font-medium text-emerald-700 dark:text-emerald-300">Total Pax Hadir</p>
                                                <p class="text-2xl font-bold text-emerald-800 dark:text-emerald-200">{{ $report['total_pax_hadir'] }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Statistik Grid --}}
                                <div class="grid grid-cols-3 gap-3">
                                    <div class="bg-white dark:bg-secondary-700 border border-neutral-200 dark:border-neutral-600 rounded-xl p-3 text-center">
                                        <p class="text-xs text-neutral-500 dark:text-neutral-400">Hadir</p>
                                        <p class="text-xl font-bold text-emerald-600 dark:text-emerald-400">{{ $report['tamu_hadir'] }}</p>
                                    </div>
                                    <div class="bg-white dark:bg-secondary-700 border border-neutral-200 dark:border-neutral-600 rounded-xl p-3 text-center">
                                        <p class="text-xs text-neutral-500 dark:text-neutral-400">Absen</p>
                                        <p class="text-xl font-bold text-red-500 dark:text-red-400">{{ $report['tamu_absen'] }}</p>
                                    </div>
                                    <div class="bg-white dark:bg-secondary-700 border border-neutral-200 dark:border-neutral-600 rounded-xl p-3 text-center">
                                        <p class="text-xs text-neutral-500 dark:text-neutral-400">Total Respon</p>
                                        <p class="text-xl font-bold text-primary-600 dark:text-primary-400">{{ $report['total_tamu_respon'] }}</p>
                                    </div>
                                </div>

                                {{-- Progress Bar Pax --}}
                                @if($invitation->isRsvpPaxLimited())
                                @php $paxPercentage = $invitation->max_global_pax_quota > 0 ? min(100, round(($report['total_pax_hadir'] / $invitation->max_global_pax_quota) * 100)) : 0; @endphp
                                <div class="bg-white dark:bg-secondary-700 border border-neutral-200 dark:border-neutral-600 rounded-xl p-4">
                                    <div class="flex items-center justify-between mb-2">
                                        <p class="text-xs font-medium text-neutral-600 dark:text-neutral-400">Kuota Pax Terpakai</p>
                                        <p class="text-xs font-semibold text-neutral-700 dark:text-neutral-300">{{ $paxPercentage }}%</p>
                                    </div>
                                    <div class="w-full bg-neutral-200 dark:bg-secondary-600 rounded-full h-2.5 overflow-hidden">
                                        <div class="bg-gradient-to-r from-primary to-primary-600 h-2.5 rounded-full" style="width: {{ $paxPercentage }}%"></div>
                                    </div>
                                    <p class="text-xs text-neutral-400 dark:text-neutral-500 mt-1">
                                        {{ $report['total_pax_hadir'] }} dari {{ $invitation->max_global_pax_quota }} pax
                                        (sisa <span class="font-semibold text-emerald-600 dark:text-emerald-400">{{ $invitation->remainingGlobalQuota() }}</span>)
                                    </p>
                                </div>
                                @endif

                                {{-- Tabel Daftar Tamu RSVP --}}
                                <div class="bg-white dark:bg-secondary-700 border border-neutral-200 dark:border-neutral-600 rounded-xl overflow-hidden">
                                    <div class="px-4 py-3 border-b border-neutral-100 dark:border-neutral-600 flex items-center justify-between">
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
