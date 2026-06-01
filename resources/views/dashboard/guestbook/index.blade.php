<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                📋 Buku Tamu: {{ $invitation->title }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('dashboard.invitations.guests.index', $invitation) }}" class="bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-md text-sm font-medium hover:bg-gray-50">
                    Daftar Tamu
                </a>
                <a href="{{ route('dashboard.invitations.show', $invitation) }}" class="bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-md text-sm font-medium hover:bg-gray-50">
                    &larr; Kembali
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Statistik Kehadiran --}}
            <div class="grid grid-cols-3 gap-4">
                <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-100 text-center">
                    <p class="text-3xl font-bold text-gray-800" id="stat-total">{{ $stats['total'] }}</p>
                    <p class="text-xs text-gray-500 mt-1 uppercase tracking-wide">Total Tamu</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm p-5 border border-emerald-200 text-center">
                    <p class="text-3xl font-bold text-emerald-600" id="stat-hadir">{{ $stats['hadir'] }}</p>
                    <p class="text-xs text-gray-500 mt-1 uppercase tracking-wide">Sudah Hadir</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm p-5 border border-amber-200 text-center">
                    <p class="text-3xl font-bold text-amber-600" id="stat-pending">{{ $stats['pending'] }}</p>
                    <p class="text-xs text-gray-500 mt-1 uppercase tracking-wide">Belum Hadir</p>
                </div>
            </div>

            {{-- Scanner Area --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">📷 Scan QR Code Tamu</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Camera Scanner --}}
                        <div>
                            <div id="qr-reader" class="rounded-xl overflow-hidden border-2 border-dashed border-gray-300 bg-gray-50" style="width: 100%;"></div>
                            <div class="mt-3 flex gap-2">
                                <button onclick="startScanner()" id="btn-start" class="flex-1 bg-indigo-600 text-white px-4 py-2.5 rounded-lg text-sm font-semibold hover:bg-indigo-700 transition-colors">
                                    📷 Mulai Scan
                                </button>
                                <button onclick="stopScanner()" id="btn-stop" class="flex-1 bg-gray-500 text-white px-4 py-2.5 rounded-lg text-sm font-semibold hover:bg-gray-600 transition-colors hidden">
                                    ⏹ Stop Scan
                                </button>
                            </div>

                            {{-- Manual Input --}}
                            <div class="mt-4 pt-4 border-t border-gray-200">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Input Token Manual</label>
                                <div class="flex gap-2">
                                    <input type="text" id="manual-token" placeholder="Masukkan QR code token..." class="flex-1 border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                    <button onclick="manualCheckin()" class="bg-emerald-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-emerald-700 transition-colors whitespace-nowrap">
                                        ✓ Check-In
                                    </button>
                                </div>
                            </div>
                        </div>

                        {{-- Result Panel --}}
                        <div>
                            <div id="result-panel" class="rounded-xl p-6 bg-gray-50 border-2 border-dashed border-gray-200 min-h-[280px] flex items-center justify-center">
                                <div class="text-center text-gray-400">
                                    <svg class="mx-auto h-12 w-12 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                                    </svg>
                                    <p class="text-sm font-medium">Menunggu Scan...</p>
                                    <p class="text-xs mt-1">Arahkan kamera ke QR Code tamu</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Daftar Tamu Yang Sudah Hadir --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">✅ Tamu Yang Sudah Hadir</h3>
                    <div class="overflow-x-auto border border-gray-200 rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Tamu</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No HP</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Waktu Check-In</th>
                                    <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200" id="checkin-tbody">
                                @forelse($recentCheckins as $index => $checkedGuest)
                                    <tr>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">{{ $index + 1 }}</td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">{{ $checkedGuest->name }}</td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">{{ $checkedGuest->phone ?? '-' }}</td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">{{ $checkedGuest->checked_in_at->format('H:i, d M Y') }}</td>
                                        <td class="px-4 py-3 whitespace-nowrap text-right text-sm">
                                            <a href="{{ route('dashboard.invitations.guestbook.ticket', [$invitation, $checkedGuest]) }}" target="_blank" class="text-indigo-600 hover:text-indigo-900 text-xs font-semibold">
                                                🖨 Cetak Tiket
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr id="empty-row">
                                        <td colspan="5" class="px-4 py-8 text-center text-sm text-gray-500 italic">
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

    {{-- html5-qrcode CDN --}}
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

        function onScanError(errorMessage) {
            // Ignore continuous scan errors
        }

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
                    // Play success sound
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
                loading: { bg: 'bg-blue-50', border: 'border-blue-300', text: 'text-blue-800', icon: '⏳' },
                success: { bg: 'bg-emerald-50', border: 'border-emerald-400', text: 'text-emerald-800', icon: '✅' },
                warning: { bg: 'bg-amber-50', border: 'border-amber-400', text: 'text-amber-800', icon: '⚠️' },
                error:   { bg: 'bg-red-50', border: 'border-red-400', text: 'text-red-800', icon: '❌' },
            };
            const c = configs[type];

            let html = `
                <div class="${c.bg} ${c.text} rounded-xl p-6 border-2 ${c.border} min-h-[280px] flex flex-col items-center justify-center text-center transition-all">
                    <span class="text-5xl mb-4">${c.icon}</span>
                    <h3 class="text-xl font-bold">${title}</h3>
                    <p class="text-sm mt-2 opacity-80">${subtitle}</p>
            `;

            if (ticketUrl) {
                html += `
                    <a href="${ticketUrl}" target="_blank" onclick="setTimeout(() => { let w = window.open('${ticketUrl}', '_blank'); }, 100);"
                       class="mt-4 inline-flex items-center gap-2 bg-indigo-600 text-white px-6 py-2.5 rounded-lg text-sm font-semibold hover:bg-indigo-700 transition-colors shadow-md">
                        🖨 Cetak Tiket
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
                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">${guest.checkin_order}</td>
                <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">${guest.name}</td>
                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">${guest.phone || '-'}</td>
                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">${guest.checked_in_at}</td>
                <td class="px-4 py-3 whitespace-nowrap text-right text-sm">
                    <a href="${ticketUrl}" target="_blank" class="text-indigo-600 hover:text-indigo-900 text-xs font-semibold">🖨 Cetak Tiket</a>
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

        // Allow Enter key on manual input
        document.getElementById('manual-token')?.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') manualCheckin();
        });
    </script>
</x-app-layout>
