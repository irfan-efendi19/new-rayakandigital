<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
            <div>
                <h2 class="font-heading text-2xl font-bold text-secondary-800 dark:text-neutral-100">
                    Tamu Undangan: {{ $invitation->title }}
                </h2>
                <p class="text-sm text-neutral-500 mt-0.5">Kelola daftar tamu dan kirim undangan WhatsApp.</p>
            </div>
            <div class="flex flex-wrap gap-2">
                @if($invitation->hasFeature('qr_checkin'))
                    <a href="{{ route('dashboard.invitations.guestbook', $invitation) }}"
                       class="inline-flex items-center gap-1.5 bg-primary-50 dark:bg-primary-900/50 text-primary-700 dark:text-primary-300 px-4 py-2 rounded-xl text-sm font-medium hover:bg-primary-100 dark:hover:bg-primary-900/70 transition-colors">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                        </svg>
                        Buku Tamu (Scanner)
                    </a>
                @endif
                <a href="{{ route('dashboard.invitations.whatsapp.logs', $invitation) }}"
                   class="inline-flex items-center gap-1.5 bg-emerald-50 dark:bg-emerald-900/50 text-emerald-700 dark:text-emerald-300 px-4 py-2 rounded-xl text-sm font-medium hover:bg-emerald-100 dark:hover:bg-emerald-900/70 transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                    Log WA
                </a>
                <a href="{{ route('dashboard.invitations.show', $invitation) }}"
                   class="inline-flex items-center gap-1.5 bg-white dark:bg-secondary-800 border border-neutral-200 dark:border-secondary-700 text-neutral-700 dark:text-neutral-300 px-4 py-2 rounded-xl text-sm font-medium hover:bg-neutral-50 dark:hover:bg-secondary-700 transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            @if(session('import_errors') && count(session('import_errors')) > 0)
                <div class="bg-amber-50 dark:bg-amber-900/30 border border-amber-200 dark:border-amber-800 text-amber-900 dark:text-amber-100 px-5 py-4 rounded-2xl shadow-soft space-y-2">
                    <div class="flex items-center gap-2 font-bold text-amber-800 dark:text-amber-200">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z" />
                        </svg>
                        <span>Beberapa baris dilewati / bermasalah:</span>
                    </div>
                    <ul class="list-disc list-inside text-xs space-y-1 text-amber-700 dark:text-amber-300 ml-2">
                        @foreach(session('import_errors') as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- WhatsApp Template Editor --}}
            <div class="bg-white dark:bg-secondary-800 rounded-2xl shadow-soft border border-neutral-100 dark:border-secondary-700">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="font-heading text-lg font-bold text-secondary-800 dark:text-neutral-100">Template Pesan WhatsApp</h3>
                        <label class="inline-flex items-center gap-2 cursor-pointer select-none">
                            <span class="text-sm text-neutral-600 dark:text-neutral-400">Custom Template</span>
                            <input type="checkbox" id="wa_template_toggle" class="rounded-lg border-neutral-300 dark:border-secondary-600 dark:bg-secondary-900 text-primary focus:ring-primary-500 shadow-sm"
                                {{ $invitation->wa_template_enabled ? 'checked' : '' }}
                                onchange="document.getElementById('wa_template_form').submit()">
                        </label>
                    </div>
                    <form id="wa_template_form" action="{{ route('dashboard.invitations.whatsapp.template', $invitation) }}" method="POST">
                        @csrf
                        <input type="hidden" name="wa_template_enabled" value="{{ $invitation->wa_template_enabled ? '0' : '1' }}" id="wa_template_enabled_input">
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1.5">Template Pesan</label>
                            <textarea name="wa_message_template" rows="4"
                                class="block w-full rounded-xl border-neutral-300 dark:border-secondary-600 dark:bg-secondary-900 dark:text-neutral-200 shadow-sm focus:border-primary-500 focus:ring-primary-500 text-sm"
                                placeholder="Kosongkan untuk menggunakan template default">{{ $invitation->wa_message_template }}</textarea>
                        </div>
                        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
                            <div class="flex flex-wrap items-center gap-1.5">
                                <span class="text-xs text-neutral-500 dark:text-neutral-400 font-medium">Variabel:</span>
                                @foreach(['{nama_tamu}','{nama_mempelai_pria}','{nama_mempelai_wanita}','{tautan_undangan}','{tanggal_acara}','{waktu_acara}','{tempat_acara}','{qrcode_link}'] as $var)
                                    <code class="text-xs bg-neutral-100 dark:bg-secondary-900 text-neutral-600 dark:text-neutral-400 px-1.5 py-0.5 rounded-lg">{{ $var }}</code>
                                @endforeach
                            </div>
                            <button type="submit" class="bg-gradient-to-r from-primary to-primary-600 text-white px-5 py-2 rounded-xl text-sm font-semibold hover:shadow-lg transition-all">
                                Simpan Template
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <script>
                document.getElementById('wa_template_toggle')?.addEventListener('change', function() {
                    document.getElementById('wa_template_enabled_input').value = this.checked ? '1' : '0';
                });
            </script>

            @if($invitation->hasFeature('guest_import'))
            {{-- Import Card --}}
            <div class="bg-white dark:bg-secondary-800 rounded-2xl shadow-soft border border-neutral-100 dark:border-secondary-700">
                <div class="p-6">
                    <h3 class="font-heading text-lg font-bold text-secondary-800 dark:text-neutral-100 mb-4">Import Tamu Massal (CSV)</h3>
                    <form action="{{ route('dashboard.invitations.guests.import', $invitation) }}" method="POST" enctype="multipart/form-data" class="flex flex-col md:flex-row items-end gap-4">
                        @csrf
                        <div class="flex-1 w-full">
                            <label for="file" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1.5">File CSV Tamu</label>
                            <input type="file" name="file" id="file" required accept=".csv,text/csv,text/plain"
                                class="block w-full border border-neutral-300 dark:border-secondary-600 dark:bg-secondary-900 dark:text-neutral-200 rounded-xl shadow-sm focus:border-primary-500 focus:ring-primary-500 text-sm file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-primary-50 dark:file:bg-primary-900/50 file:text-primary-700 dark:file:text-primary-300 hover:file:bg-primary-100 dark:hover:file:bg-primary-900/70">
                        </div>
                        <div class="flex-shrink-0 w-full md:w-auto">
                            <button type="submit" class="w-full bg-gradient-to-r from-primary to-primary-600 text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:shadow-lg transition-all">
                                <span class="flex items-center gap-2 justify-center">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                    </svg>
                                    Import CSV
                                </span>
                            </button>
                        </div>
                    </form>
                    <p class="mt-2.5 text-xs text-neutral-500 dark:text-neutral-400">
                        Format file harus CSV. Baris pertama (header) wajib memiliki kolom: <strong class="text-primary">nama</strong> atau <strong class="text-primary">name</strong>. Kolom opsional: <strong class="text-primary">phone</strong> atau <strong class="text-primary">whatsapp</strong> untuk no HP.
                    </p>
                </div>
            </div>
            @endif

            {{-- Guest List --}}
            <div class="bg-white dark:bg-secondary-800 rounded-2xl shadow-soft border border-neutral-100 dark:border-secondary-700">
                <div class="p-6">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
                        <div class="flex items-center gap-2">
                            <h3 class="font-heading text-lg font-bold text-secondary-800 dark:text-neutral-100">Daftar Tamu</h3>
                            <span class="inline-flex items-center justify-center min-w-[1.5rem] h-6 px-2 rounded-full bg-primary-50 dark:bg-primary-900/50 text-primary-700 dark:text-primary-300 text-xs font-bold">{{ $guests->total() }}</span>
                        </div>
                        <div class="flex gap-2">
                            <button id="bulkSendBtn" disabled
                                class="inline-flex items-center gap-1.5 bg-emerald-600 text-white px-4 py-2 rounded-xl text-sm font-medium hover:bg-emerald-700 disabled:opacity-50 disabled:cursor-not-allowed transition-colors"
                                onclick="bulkSend()">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                </svg>
                                Kirim WA Massal
                            </button>
                            <a href="{{ route('dashboard.invitations.guests.create', $invitation) }}"
                               class="inline-flex items-center gap-1.5 bg-gradient-to-r from-primary to-primary-600 text-white px-4 py-2 rounded-xl text-sm font-medium hover:shadow-lg transition-all">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                Tambah Tamu
                            </a>
                        </div>
                    </div>

                    @if($guests->isEmpty())
                        <div class="text-center py-16">
                            <div class="w-16 h-16 mx-auto bg-neutral-100 dark:bg-secondary-700 rounded-full flex items-center justify-center mb-4">
                                <svg class="w-8 h-8 text-neutral-400 dark:text-neutral-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                            </div>
                            <h3 class="text-base font-bold text-secondary-800 dark:text-neutral-100">Belum ada tamu</h3>
                            <p class="mt-1 text-sm text-neutral-500 dark:text-neutral-400">Mulai tambahkan tamu untuk mengenerate link unik.</p>
                            <div class="mt-6">
                                <a href="{{ route('dashboard.invitations.guests.create', $invitation) }}"
                                   class="inline-flex items-center gap-2 bg-gradient-to-r from-primary to-primary-600 text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:shadow-lg transition-all">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                    Tambah Tamu Baru
                                </a>
                            </div>
                        </div>
                    @else
                        <form id="bulkSendForm" action="{{ route('dashboard.invitations.whatsapp.send', $invitation) }}" method="POST">
                            @csrf
                            <div class="overflow-x-auto border border-neutral-200 dark:border-secondary-700 rounded-2xl">
                                <table class="min-w-full divide-y divide-neutral-200 dark:divide-secondary-700">
                                    <thead class="bg-neutral-50 dark:bg-secondary-900">
                                        <tr>
                                            <th scope="col" class="px-3 py-3.5 text-left">
                                                <input type="checkbox" id="selectAll"
                                                    class="rounded-lg border-neutral-300 dark:border-secondary-600 dark:bg-secondary-900 text-primary focus:ring-primary-500 shadow-sm">
                                            </th>
                                            <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Nama Tamu</th>
                                            <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">No HP</th>
                                            <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Status WA</th>
                                            <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Kehadiran</th>
                                            <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Link Personal</th>
                                            <th scope="col" class="px-6 py-3.5 text-right text-xs font-semibold text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white dark:bg-secondary-800 divide-y divide-neutral-100 dark:divide-secondary-700">
                                        @foreach($guests as $guest)
                                            @php $waStatus = $guest->wa_status; @endphp
                                            <tr class="hover:bg-neutral-50 dark:hover:bg-secondary-700/50 transition-colors">
                                                <td class="px-3 py-4 whitespace-nowrap">
                                                    @if($guest->phone)
                                                        <input type="checkbox" name="guest_ids[]" value="{{ $guest->id }}"
                                                            class="guest-checkbox rounded-lg border-neutral-300 dark:border-secondary-600 dark:bg-secondary-900 text-primary focus:ring-primary-500 shadow-sm">
                                                    @endif
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <span class="text-sm font-semibold text-secondary-800 dark:text-neutral-200">{{ $guest->name }}</span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-500 dark:text-neutral-400">
                                                    {{ $guest->phone ?? '—' }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    @php
                                                        $waBadge = match($waStatus) {
                                                            'sent' => ['bg-emerald-100 dark:bg-emerald-900/50 text-emerald-800 dark:text-emerald-200', 'Terkirim'],
                                                            'failed' => ['bg-red-100 dark:bg-red-900/50 text-red-800 dark:text-red-200', 'Gagal'],
                                                            'queued', 'pending' => ['bg-amber-100 dark:bg-amber-900/50 text-amber-800 dark:text-amber-200', 'Diproses'],
                                                            default => ['bg-neutral-100 dark:bg-secondary-700 text-neutral-600 dark:text-neutral-400', 'Belum'],
                                                        };
                                                    @endphp
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $waBadge[0] }}">
                                                        {{ $waBadge[1] }}
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    @php
                                                        $attBadge = match($guest->attendance_status) {
                                                            'hadir' => ['bg-emerald-100 dark:bg-emerald-900/50 text-emerald-800 dark:text-emerald-200', 'Hadir'],
                                                            'absen' => ['bg-rose-100 dark:bg-rose-900/50 text-rose-800 dark:text-rose-200', 'Absen'],
                                                            default => ['bg-neutral-100 dark:bg-secondary-700 text-neutral-600 dark:text-neutral-400', 'Pending'],
                                                        };
                                                    @endphp
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $attBadge[0] }}"
                                                        @if($guest->attendance_status === 'hadir' && $guest->checked_in_at)
                                                            title="Check-in {{ $guest->checked_in_at->format('H:i, d M Y') }}"
                                                        @endif>
                                                        {{ $attBadge[1] }}
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-500 dark:text-neutral-400">
                                                    <div class="flex items-center gap-1.5">
                                                        <input type="text" readonly value="{{ $guest->personalized_link }}"
                                                            class="text-xs border-neutral-200 dark:border-secondary-600 rounded-lg shadow-sm w-36 bg-neutral-50 dark:bg-secondary-900 dark:text-neutral-300 focus:ring-0 cursor-default"
                                                            id="link-{{ $guest->id }}">
                                                        <button onclick="copyToClipboard('link-{{ $guest->id }}')"
                                                            class="text-primary hover:text-primary-600 dark:hover:text-primary-400 text-xs font-semibold">
                                                            Copy
                                                        </button>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                    <div class="flex items-center justify-end gap-2">
                                                        @if($guest->phone)
                                                            <form action="{{ route('dashboard.invitations.whatsapp.send-single', [$invitation, $guest]) }}" method="POST" class="inline-block">
                                                                @csrf
                                                                <button type="submit" class="text-emerald-600 hover:text-emerald-700 text-xs font-semibold">
                                                                    <span class="flex items-center gap-1">
                                                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                                                        </svg>
                                                                        Kirim WA
                                                                    </span>
                                                                </button>
                                                            </form>
                                                        @endif
                                                        <a href="{{ route('dashboard.invitations.guests.edit', [$invitation, $guest]) }}"
                                                           class="text-primary hover:text-primary-600 text-xs font-semibold">Edit</a>
                                                        <form action="{{ route('dashboard.invitations.guests.destroy', [$invitation, $guest]) }}" method="POST" class="inline-block" onsubmit="return confirmSwal(event, 'Yakin ingin menghapus tamu ini?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="text-red-500 hover:text-red-700 text-xs font-semibold">Hapus</button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </form>

                        <div class="mt-6">
                            {{ $guests->links() }}
                        </div>

                        <script>
                            function copyToClipboard(id) {
                                var copyText = document.getElementById(id);
                                copyText.select();
                                copyText.setSelectionRange(0, 99999);
                                navigator.clipboard.writeText(copyText.value);
                                if (typeof Swal !== 'undefined') {
                                    Swal.fire({ icon: 'success', title: 'Tersalin!', text: 'Link berhasil disalin!', timer: 1500, showConfirmButton: false });
                                }
                            }

                            document.getElementById('selectAll').addEventListener('change', function() {
                                document.querySelectorAll('.guest-checkbox').forEach(cb => cb.checked = this.checked);
                                updateBulkButton();
                            });

                            document.querySelectorAll('.guest-checkbox').forEach(cb => {
                                cb.addEventListener('change', updateBulkButton);
                            });

                            function updateBulkButton() {
                                const checked = document.querySelectorAll('.guest-checkbox:checked').length;
                                const btn = document.getElementById('bulkSendBtn');
                                btn.disabled = checked === 0;
                                btn.innerHTML = checked > 0
                                    ? `<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg> Kirim WA Massal (${checked})`
                                    : `<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg> Kirim WA Massal`;
                            }

                            function bulkSend() {
                                if (typeof Swal !== 'undefined') {
                                    Swal.fire({
                                        title: 'Konfirmasi',
                                        text: 'Kirim WhatsApp ke semua tamu yang dipilih? Pesan akan dikirim secara bertahap.',
                                        icon: 'question',
                                        showCancelButton: true,
                                        confirmButtonColor: '#FF7A00',
                                        cancelButtonColor: '#EF4444',
                                        confirmButtonText: 'Ya, kirim!',
                                        cancelButtonText: 'Batal',
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            document.getElementById('bulkSendForm').submit();
                                        }
                                    });
                                } else if (confirm('Kirim WhatsApp ke semua tamu yang dipilih? Pesan akan dikirim secara bertahap.')) {
                                    document.getElementById('bulkSendForm').submit();
                                }
                            }
                        </script>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
