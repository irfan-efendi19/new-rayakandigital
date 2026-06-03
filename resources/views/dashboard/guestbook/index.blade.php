<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h2 class="font-heading text-2xl font-bold text-secondary-800">
                    Buku Tamu
                </h2>
                <p class="text-sm text-neutral-500 mt-0.5">{{ $invitation->title }}</p>
            </div>
            <div class="flex gap-2">
                @if($invitation->hasFeature('personal_link'))
                <a href="{{ route('dashboard.invitations.guests.index', $invitation) }}"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-neutral-300 rounded-xl text-sm font-semibold text-neutral-700 hover:bg-neutral-50 hover:border-primary-300 transition-all">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    Daftar Tamu
                </a>
                @endif
                <a href="{{ route('dashboard.welcome-screen.index', $invitation) }}" target="_blank"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-primary to-primary-600 text-white rounded-xl text-sm font-semibold shadow-soft hover:shadow-md transition-all">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    Layar Sapa
                </a>
                <a href="{{ route('dashboard.invitations.show', $invitation) }}"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-neutral-300 rounded-xl text-sm font-semibold text-neutral-700 hover:bg-neutral-50 hover:border-primary-300 transition-all">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- Stats --}}
            <div class="grid grid-cols-3 gap-4">
                <div class="bg-white rounded-2xl shadow-soft p-5 border border-neutral-100 text-center">
                    <p class="text-3xl font-bold text-secondary-800" id="stat-total">{{ $stats['total'] }}</p>
                    <div class="flex items-center justify-center gap-1.5 mt-1">
                        <div class="w-2 h-2 rounded-full bg-primary"></div>
                        <p class="text-xs text-neutral-500 uppercase tracking-wide font-semibold">Total Tamu</p>
                    </div>
                </div>
                <div class="bg-white rounded-2xl shadow-soft p-5 border-2 border-emerald-200 text-center">
                    <p class="text-3xl font-bold text-emerald-600" id="stat-hadir">{{ $stats['hadir'] }}</p>
                    <div class="flex items-center justify-center gap-1.5 mt-1">
                        <div class="w-2 h-2 rounded-full bg-emerald-500"></div>
                        <p class="text-xs text-neutral-500 uppercase tracking-wide font-semibold">Sudah Hadir</p>
                    </div>
                </div>
                <div class="bg-white rounded-2xl shadow-soft p-5 border-2 border-amber-200 text-center">
                    <p class="text-3xl font-bold text-amber-600" id="stat-pending">{{ $stats['pending'] }}</p>
                    <div class="flex items-center justify-center gap-1.5 mt-1">
                        <div class="w-2 h-2 rounded-full bg-amber-500"></div>
                        <p class="text-xs text-neutral-500 uppercase tracking-wide font-semibold">Belum Hadir</p>
                    </div>
                </div>
            </div>

            {{-- Scanner --}}
            <div class="bg-white rounded-2xl shadow-soft border border-neutral-100 overflow-hidden">
                <div class="p-6">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-9 h-9 rounded-xl bg-primary-100 flex items-center justify-center text-primary">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                            </svg>
                        </div>
                        <h3 class="font-heading text-lg font-bold text-secondary-800">Scan QR Code Tamu</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <div id="qr-reader" class="rounded-2xl overflow-hidden border-2 border-dashed border-neutral-300 bg-neutral-50" style="width: 100%;"></div>
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

                            <div class="mt-4 pt-4 border-t border-neutral-200">
                                <label class="block text-sm font-medium text-neutral-700 mb-1.5">Input Token Manual</label>
                                <div class="flex gap-2">
                                    <input type="text" id="manual-token" placeholder="Masukkan QR code token..."
                                        class="flex-1 rounded-xl border-neutral-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 text-sm">
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
                            <div id="result-panel" class="rounded-2xl p-6 bg-neutral-50 border-2 border-dashed border-neutral-200 min-h-[280px] flex items-center justify-center">
                                <div class="text-center text-neutral-400">
                                    <svg class="mx-auto h-14 w-14 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                                    </svg>
                                    <p class="text-sm font-medium text-neutral-500">Menunggu Scan...</p>
                                    <p class="text-xs text-neutral-400 mt-1">Arahkan kamera ke QR Code tamu</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Checked-in Table --}}
            <div class="bg-white rounded-2xl shadow-soft border border-neutral-100 overflow-hidden">
                <div class="p-6">
                    <h3 class="font-heading text-lg font-bold text-secondary-800 mb-4">Tamu Yang Sudah Hadir</h3>
                    <div class="overflow-x-auto border border-neutral-200 rounded-2xl">
                        <table class="min-w-full divide-y divide-neutral-200">
                            <thead class="bg-neutral-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-neutral-500 uppercase tracking-wider">#</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-neutral-500 uppercase tracking-wider">Nama Tamu</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-neutral-500 uppercase tracking-wider">No HP</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-neutral-500 uppercase tracking-wider">Waktu Check-In</th>
                                    <th class="px-4 py-3 text-right text-xs font-semibold text-neutral-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-neutral-100" id="checkin-tbody">
                                @forelse($recentCheckins as $index => $checkedGuest)
                                    <tr class="hover:bg-neutral-50 transition-colors">
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-neutral-500">{{ $index + 1 }}</td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-secondary-800">{{ $checkedGuest->name }}</td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-neutral-500">{{ $checkedGuest->phone ?? '-' }}</td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-neutral-500">{{ $checkedGuest->checked_in_at->format('H:i, d M Y') }}</td>
                                        <td class="px-4 py-3 whitespace-nowrap text-right text-sm">
                                            <a href="{{ route('dashboard.invitations.guestbook.ticket', [$invitation, $checkedGuest]) }}" target="_blank"
                                                class="inline-flex items-center gap-1.5 text-primary-600 hover:text-primary-700 text-xs font-semibold">
                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                                </svg>
                                                Cetak Tiket
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr id="empty-row">
                                        <td colspan="5" class="px-4 py-8 text-center text-sm text-neutral-500 italic">
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
                loading: { bg: 'bg-blue-50', border: 'border-blue-300', text: 'text-blue-800', icon: 'loader' },
                success: { bg: 'bg-emerald-50', border: 'border-emerald-400', text: 'text-emerald-800', icon: 'check' },
                warning: { bg: 'bg-amber-50', border: 'border-amber-400', text: 'text-amber-800', icon: 'warn' },
                error:   { bg: 'bg-red-50', border: 'border-red-400', text: 'text-red-800', icon: 'x' },
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
            hadirEl.textContent = parseInt(hadirEl.textContent) + increment;
            pendingEl.textContent = Math.max(0, parseInt(pendingEl.textContent) - increment);
        }

        function addToCheckinTable(guest, ticketUrl) {
            const tbody = document.getElementById('checkin-tbody');
            const emptyRow = document.getElementById('empty-row');
            if (emptyRow) emptyRow.remove();

            const currentRows = tbody.querySelectorAll('tr').length;
            const row = document.createElement('tr');
            row.className = 'animate-pulse bg-emerald-50';
            row.innerHTML = `
                <td class="px-4 py-3 whitespace-nowrap text-sm text-neutral-500">${guest.checkin_order}</td>
                <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-secondary-800">${guest.name}</td>
                <td class="px-4 py-3 whitespace-nowrap text-sm text-neutral-500">${guest.phone || '-'}</td>
                <td class="px-4 py-3 whitespace-nowrap text-sm text-neutral-500">${guest.checked_in_at}</td>
                <td class="px-4 py-3 whitespace-nowrap text-right text-sm">
                    <a href="${ticketUrl}" target="_blank" class="inline-flex items-center gap-1.5 text-primary-600 hover:text-primary-700 text-xs font-semibold">
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
