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
                    <span class="text-neutral-600 dark:text-neutral-400 font-medium">Buku Tamu</span>
                </nav>

                <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-4">
                    <div class="flex items-start gap-3 min-w-0">
                        <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-primary to-primary-600 flex items-center justify-center text-white shadow-lg shadow-primary/20 shrink-0">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9zM15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                        <div class="min-w-0">
                            <h1 class="font-heading text-2xl sm:text-3xl font-bold text-secondary-800 dark:text-neutral-50 leading-tight truncate">
                                Buku Tamu
                            </h1>
                            <p class="text-sm text-neutral-500 dark:text-neutral-400 mt-1">
                                Scan QR Code tamu untuk check-in undangan <strong class="text-secondary-700 dark:text-neutral-300">"{{ $invitation->title }}"</strong>
                            </p>
                        </div>
                    </div>

                    <div class="flex flex-wrap items-center gap-2 flex-shrink-0">
                        @if($invitation->hasFeature('personal_link'))
                            <a href="{{ route('dashboard.invitations.guests.index', $invitation) }}"
                                class="inline-flex items-center gap-1.5 px-3.5 py-2 text-xs font-semibold text-secondary-700 dark:text-neutral-300 border border-neutral-300/80 dark:border-secondary-600 rounded-xl hover:bg-white dark:hover:bg-secondary-700 transition-all bg-white/70 dark:bg-secondary-800/50 backdrop-blur-sm">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                Daftar Tamu
                            </a>
                        @endif
                        <a href="{{ route('dashboard.welcome-screen.index', $invitation) }}" target="_blank"
                            class="inline-flex items-center gap-1.5 px-3.5 py-2 text-xs font-semibold text-primary dark:text-primary-400 border border-primary/30 dark:border-primary-700/50 rounded-xl hover:bg-primary-50 dark:hover:bg-primary-900/20 transition-all bg-white/70 dark:bg-secondary-800/50 backdrop-blur-sm">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            Layar Sapa
                        </a>
                        <a href="{{ route('dashboard.invitations.guestbook.settings', $invitation) }}"
                            class="inline-flex items-center gap-1.5 px-3.5 py-2 text-xs font-semibold text-emerald-700 dark:text-emerald-300 border border-emerald-300/80 dark:border-emerald-700/50 rounded-xl hover:bg-emerald-50 dark:hover:bg-emerald-900/20 transition-all bg-white/70 dark:bg-secondary-800/50 backdrop-blur-sm">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065zM15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            Pengaturan
                        </a>
                        <a href="{{ route('dashboard.invitations.show', $invitation) }}"
                            class="inline-flex items-center gap-1.5 px-3.5 py-2 text-xs font-semibold text-secondary-700 dark:text-neutral-300 border border-neutral-300/80 dark:border-secondary-600 rounded-xl hover:bg-white dark:hover:bg-secondary-700 transition-all bg-white/70 dark:bg-secondary-800/50 backdrop-blur-sm">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                            Kembali
                        </a>
                    </div>
                </div>

                {{-- Stat Strip --}}
                <div class="mt-6 grid grid-cols-3 gap-px bg-neutral-200/70 dark:bg-secondary-700/50 rounded-2xl overflow-hidden border border-neutral-200/80 dark:border-secondary-700/50">
                    <div class="bg-white/80 dark:bg-secondary-800/70 px-3 sm:px-5 py-4 flex flex-col items-center sm:items-start text-center sm:text-left backdrop-blur-sm">
                        <span class="stat-value text-xl sm:text-2xl font-bold text-secondary-800 dark:text-neutral-100 tabular-nums" id="stat-total">{{ $stats['total'] }}</span>
                        <span class="text-[10px] sm:text-xs text-neutral-500 dark:text-neutral-400 font-medium mt-0.5">Total Tamu</span>
                    </div>
                    <div class="bg-white/80 dark:bg-secondary-800/70 px-3 sm:px-5 py-4 flex flex-col items-center sm:items-start text-center sm:text-left backdrop-blur-sm">
                        <span class="stat-value text-xl sm:text-2xl font-bold text-emerald-600 dark:text-emerald-400 tabular-nums" id="stat-hadir">{{ $stats['hadir'] }}</span>
                        <span class="text-[10px] sm:text-xs text-neutral-500 dark:text-neutral-400 font-medium mt-0.5">Hadir</span>
                    </div>
                    <div class="bg-white/80 dark:bg-secondary-800/70 px-3 sm:px-5 py-4 flex flex-col items-center sm:items-start text-center sm:text-left backdrop-blur-sm">
                        <span class="stat-value text-xl sm:text-2xl font-bold text-amber-600 dark:text-amber-400 tabular-nums" id="stat-pending">{{ $stats['pending'] }}</span>
                        <span class="text-[10px] sm:text-xs text-neutral-500 dark:text-neutral-400 font-medium mt-0.5">Pending</span>
                    </div>
                </div>

            </div>
        </div>

        {{-- ─── MAIN CONTENT ─── --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-7 sm:py-8 space-y-5">

            {{-- Scanner --}}
            <div class="bg-white dark:bg-secondary-800 rounded-2xl border border-neutral-200/80 dark:border-secondary-700/60 overflow-hidden">
                <div class="px-5 sm:px-6 py-4 border-b border-neutral-100 dark:border-secondary-700/60 flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-lg bg-primary-50 dark:bg-primary-900/30 flex items-center justify-center text-primary dark:text-primary-400 flex-shrink-0">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
                    </div>
                    <div>
                        <h2 class="font-semibold text-sm text-secondary-800 dark:text-neutral-100">Scan QR Code Tamu</h2>
                        <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-0.5">Arahkan kamera ke QR Code tamu saat hari H</p>
                    </div>
                </div>

                <div class="p-5 sm:p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <div id="qr-reader" class="rounded-2xl overflow-hidden border-2 border-dashed border-neutral-300 dark:border-secondary-600 bg-neutral-50 dark:bg-secondary-900" style="width: 100%;"></div>
                            <div class="mt-3 flex gap-2">
                                <button onclick="startScanner()" id="btn-start"
                                    class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-gradient-to-r from-primary to-primary-600 text-white rounded-xl text-sm font-semibold shadow-sm hover:shadow-md transition-all">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                    </svg>
                                    Mulai Scan
                                </button>
                                <button onclick="stopScanner()" id="btn-stop"
                                    class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-neutral-500 text-white rounded-xl text-sm font-semibold hover:bg-neutral-600 transition-all hidden">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0zM9 10a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4z" />
                                    </svg>
                                    Stop Scan
                                </button>
                            </div>

                            <div class="mt-4 pt-4 border-t border-neutral-200 dark:border-secondary-700">
                                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1.5">Input Token Manual</label>
                                <div class="flex gap-2">
                                    <input type="text" id="manual-token" placeholder="Masukkan QR code token..."
                                        class="flex-1 rounded-xl border-neutral-300 dark:border-secondary-600 dark:bg-secondary-900 dark:text-neutral-200 shadow-sm focus:border-primary-500 focus:ring-primary-500 text-sm">
                                    <button onclick="manualCheckin()"
                                        class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 text-white rounded-xl text-sm font-semibold hover:bg-emerald-700 transition-all whitespace-nowrap shadow-sm">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        Check-In
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div>
                            <div id="result-panel" class="rounded-2xl p-4 sm:p-6 bg-neutral-50 dark:bg-secondary-900 border-2 border-dashed border-neutral-200 dark:border-secondary-600 min-h-[200px] sm:min-h-[280px] flex items-center justify-center">
                                <div class="text-center text-neutral-400 dark:text-neutral-500">
                                    <svg class="mx-auto h-14 w-14 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                                    </svg>
                                    <p class="text-sm font-medium text-neutral-500 dark:text-neutral-400">Menunggu Scan...</p>
                                    <p class="text-xs text-neutral-400 dark:text-neutral-500 mt-1">Arahkan kamera ke QR Code tamu</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Checked-in Table --}}
            <div class="bg-white dark:bg-secondary-800 rounded-2xl border border-neutral-200/80 dark:border-secondary-700/60 overflow-hidden">
                <div class="px-5 sm:px-6 py-4 border-b border-neutral-100 dark:border-secondary-700/60 flex items-center justify-between">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-lg bg-emerald-50 dark:bg-emerald-900/30 flex items-center justify-center text-emerald-600 dark:text-emerald-400 flex-shrink-0">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <h2 class="font-semibold text-sm text-secondary-800 dark:text-neutral-100">Tamu Yang Sudah Hadir</h2>
                            <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-0.5">{{ $recentCheckins->count() }} check-in terbaru</p>
                        </div>
                    </div>
                    <a href="{{ route('dashboard.invitations.guests.index', $invitation) }}"
                        class="text-xs font-semibold text-primary dark:text-primary-400 hover:text-primary-600 dark:hover:text-primary-300 transition-colors whitespace-nowrap">
                        Lihat semua →
                    </a>
                </div>

                <div class="p-5 sm:p-6">
                    <div class="overflow-x-auto border border-neutral-200/70 dark:border-secondary-600/50 rounded-xl">
                        <table class="min-w-full divide-y divide-neutral-200 dark:divide-secondary-700">
                            <thead class="bg-neutral-50 dark:bg-secondary-900">
                                <tr>
                                    <th class="hidden sm:table-cell px-4 py-3 text-left text-xs font-semibold text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">#</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Nama Tamu</th>
                                    <th class="hidden sm:table-cell px-4 py-3 text-left text-xs font-semibold text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">No HP</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Waktu</th>
                                    <th class="hidden sm:table-cell px-4 py-3 text-right text-xs font-semibold text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-secondary-800 divide-y divide-neutral-100 dark:divide-secondary-700" id="checkin-tbody">
                                @forelse($recentCheckins as $index => $checkedGuest)
                                    <tr class="hover:bg-neutral-50 dark:hover:bg-secondary-700/50 transition-colors">
                                        <td class="hidden sm:table-cell px-4 py-3 whitespace-nowrap text-sm text-neutral-500 dark:text-neutral-400">{{ $index + 1 }}</td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-secondary-800 dark:text-neutral-200">
                                            <div class="flex items-center gap-2">
                                                <span class="truncate max-w-[140px] sm:max-w-none">{{ $checkedGuest->name }}</span>
                                                <a href="{{ route('dashboard.invitations.guestbook.ticket', [$invitation, $checkedGuest]) }}" target="_blank"
                                                    class="sm:hidden inline-flex items-center justify-center w-7 h-7 rounded-lg bg-primary-50 dark:bg-primary-900/30 text-primary-600 dark:text-primary-400 hover:bg-primary-100 dark:hover:bg-primary-900/50 transition-colors flex-shrink-0" title="Cetak Tiket">
                                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                                    </svg>
                                                </a>
                                            </div>
                                        </td>
                                        <td class="hidden sm:table-cell px-4 py-3 whitespace-nowrap text-sm text-neutral-500 dark:text-neutral-400">{{ $checkedGuest->phone ?? '-' }}</td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-neutral-500 dark:text-neutral-400">{{ $checkedGuest->checked_in_at->format('H:i, d M Y') }}</td>
                                        <td class="hidden sm:table-cell px-4 py-3 whitespace-nowrap text-right text-sm">
                                            <a href="{{ route('dashboard.invitations.guestbook.ticket', [$invitation, $checkedGuest]) }}" target="_blank"
                                                class="inline-flex items-center gap-1.5 text-primary-600 dark:text-primary-400 hover:text-primary-700 text-xs font-semibold">
                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                                </svg>
                                                Cetak Tiket
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr id="empty-row">
                                        <td colspan="5" class="px-4 py-8 text-center text-sm text-neutral-500 dark:text-neutral-400 italic">
                                            Belum ada tamu yang check-in.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>

    <script>
        const checkinUrl = @json(route('dashboard.invitations.guestbook.checkin', $invitation));
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        let html5QrCode = null;
        let isScanning = false;
        let lastScannedToken = '';
        let scanCooldown = false;

        function startScanner() {
            if (isScanning) return;

            html5QrCode = new Html5Qrcode("qr-reader");
            html5QrCode.start(
                { facingMode: "environment" },
                { fps: 10, qrbox: { width: 250, height: 250 } },
                onScanSuccess,
                onScanError
            ).then(() => {
                isScanning = true;
                document.getElementById('btn-start').classList.add('hidden');
                document.getElementById('btn-stop').classList.remove('hidden');
            }).catch(err => {
                showResult('error', 'Gagal mengakses kamera', err.toString());
            });
        }

        function stopScanner() {
            if (!isScanning || !html5QrCode) return;
            html5QrCode.stop().then(() => {
                isScanning = false;
                document.getElementById('btn-start').classList.remove('hidden');
                document.getElementById('btn-stop').classList.add('hidden');
            });
        }

        function onScanSuccess(decodedText) {
            if (scanCooldown || decodedText === lastScannedToken) return;
            lastScannedToken = decodedText;
            scanCooldown = true;
            setTimeout(() => { scanCooldown = false; lastScannedToken = ''; }, 3000);
            processCheckin(decodedText);
        }

        function onScanError(errorMessage) {}

        function manualCheckin() {
            const token = document.getElementById('manual-token').value.trim();
            if (!token) return;
            processCheckin(token);
            document.getElementById('manual-token').value = '';
        }

        async function processCheckin(token) {
            showResult('loading', 'Memproses...', 'Mencari data tamu...');

            try {
                const response = await fetch(checkinUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ qr_code_token: token }),
                });

                const data = await response.json();

                if (response.ok && data.success) {
                    showResult('success', data.guest.name, `Check-in #${data.guest.checkin_order} — ${data.guest.checked_in_at}`, data.ticket_url);
                    updateStats(1);
                    addToCheckinTable(data.guest, data.ticket_url);
                    playBeep(true);
                } else if (response.status === 409) {
                    showResult('warning', data.guest.name, `${data.message} (${data.guest.checked_in_at})`);
                    playBeep(false);
                } else {
                    showResult('error', 'Tidak Ditemukan', data.message);
                    playBeep(false);
                }
            } catch (error) {
                showResult('error', 'Error', 'Gagal terhubung ke server: ' + error.message);
            }
        }

        function showResult(type, title, subtitle, ticketUrl = null) {
            const panel = document.getElementById('result-panel');
            const configs = {
                loading: { bg: 'bg-blue-50 dark:bg-blue-900/30', border: 'border-blue-300 dark:border-blue-700', text: 'text-blue-800 dark:text-blue-200', icon: 'loader' },
                success: { bg: 'bg-emerald-50 dark:bg-emerald-900/30', border: 'border-emerald-400 dark:border-emerald-700', text: 'text-emerald-800 dark:text-emerald-200', icon: 'check' },
                warning: { bg: 'bg-amber-50 dark:bg-amber-900/30', border: 'border-amber-400 dark:border-amber-700', text: 'text-amber-800 dark:text-amber-200', icon: 'warn' },
                error:   { bg: 'bg-red-50 dark:bg-red-900/30', border: 'border-red-400 dark:border-red-700', text: 'text-red-800 dark:text-red-200', icon: 'x' },
            };
            const c = configs[type];

            const icons = {
                loader: '<svg class="animate-spin h-10 w-10 mx-auto mb-4 text-blue-500" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>',
                check: '<svg class="h-10 w-10 mx-auto mb-4 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
                warn: '<svg class="h-10 w-10 mx-auto mb-4 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>',
                x: '<svg class="h-10 w-10 mx-auto mb-4 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>',
            };

            let html = `
                <div class="${c.bg} ${c.text} rounded-2xl p-6 border-2 ${c.border} min-h-[280px] flex flex-col items-center justify-center text-center transition-all">
                    ${icons[type === 'loading' ? 'loader' : type === 'success' ? 'check' : type === 'warning' ? 'warn' : 'x']}
                    <h3 class="text-xl font-bold">${title}</h3>
                    <p class="text-sm mt-2 opacity-80">${subtitle}</p>
            `;

            if (ticketUrl) {
                html += `
                    <a href="${ticketUrl}" target="_blank"
                       class="mt-4 inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-primary to-primary-600 text-white rounded-xl text-sm font-semibold shadow-sm hover:shadow-md transition-all">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                        </svg>
                        Cetak Tiket
                    </a>
                `;
            }

            html += '</div>';
            panel.innerHTML = html;
        }

        function updateStats(increment) {
            const hadirEl = document.getElementById('stat-hadir');
            const pendingEl = document.getElementById('stat-pending');
            const totalEl = document.getElementById('stat-total');
            hadirEl.textContent = parseInt(hadirEl.textContent) + increment;
            pendingEl.textContent = Math.max(0, parseInt(pendingEl.textContent) - increment);
            totalEl.textContent = parseInt(totalEl.textContent) + increment;
        }

        function addToCheckinTable(guest, ticketUrl) {
            const tbody = document.getElementById('checkin-tbody');
            const emptyRow = document.getElementById('empty-row');
            if (emptyRow) emptyRow.remove();

            const row = document.createElement('tr');
            row.className = 'animate-pulse bg-emerald-50 dark:bg-emerald-900/30';
            row.innerHTML = `
                <td class="hidden sm:table-cell px-4 py-3 whitespace-nowrap text-sm text-neutral-500 dark:text-neutral-400">${guest.checkin_order}</td>
                <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-secondary-800 dark:text-neutral-200">${guest.name}</td>
                <td class="hidden sm:table-cell px-4 py-3 whitespace-nowrap text-sm text-neutral-500 dark:text-neutral-400">${guest.phone || '-'}</td>
                <td class="px-4 py-3 whitespace-nowrap text-sm text-neutral-500 dark:text-neutral-400">${guest.checked_in_at}</td>
                <td class="hidden sm:table-cell px-4 py-3 whitespace-nowrap text-right text-sm">
                    <a href="${ticketUrl}" target="_blank" class="inline-flex items-center gap-1.5 text-primary-600 dark:text-primary-400 hover:text-primary-700 text-xs font-semibold">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" /></svg>
                        Cetak Tiket
                    </a>
                </td>
            `;
            tbody.insertBefore(row, tbody.firstChild);
            setTimeout(() => { row.classList.remove('animate-pulse', 'bg-emerald-50'); }, 2000);
        }

        function playBeep(success) {
            try {
                const ctx = new (window.AudioContext || window.webkitAudioContext)();
                const osc = ctx.createOscillator();
                const gain = ctx.createGain();
                osc.connect(gain);
                gain.connect(ctx.destination);
                osc.frequency.value = success ? 800 : 300;
                gain.gain.value = 0.3;
                osc.start();
                osc.stop(ctx.currentTime + (success ? 0.15 : 0.3));
            } catch (e) {}
        }

        document.getElementById('manual-token')?.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') manualCheckin();
        });
    </script>
</x-app-layout>
