<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Tamu Undangan: {{ $invitation->title }}
            </h2>
            <div class="flex gap-2">
                @if($invitation->hasFeature('qr_checkin'))
                    <a href="{{ route('dashboard.invitations.guestbook', $invitation) }}" class="bg-indigo-100 text-indigo-700 px-4 py-2 rounded-md text-sm font-medium hover:bg-indigo-200">
                        📋 Buku Tamu (Scanner)
                    </a>
                @endif
                <a href="{{ route('dashboard.invitations.whatsapp.logs', $invitation) }}" class="bg-emerald-100 text-emerald-700 px-4 py-2 rounded-md text-sm font-medium hover:bg-emerald-200">
                    Log WA
                </a>
                <a href="{{ route('dashboard.invitations.show', $invitation) }}" class="bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-md text-sm font-medium hover:bg-gray-50">
                    &larr; Kembali
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('import_errors') && count(session('import_errors')) > 0)
                <div class="bg-amber-50 border border-amber-200 text-amber-900 px-4 py-4 rounded-xl relative shadow-sm space-y-2 mb-4">
                    <div class="flex items-center gap-2 font-bold text-amber-800">
                        <span>⚠️</span>
                        <span>Beberapa baris dilewati / bermasalah:</span>
                    </div>
                    <ul class="list-disc list-inside text-xs space-y-1 text-amber-700">
                        @foreach(session('import_errors') as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- WhatsApp Template Editor --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Template Pesan WhatsApp</h3>
                        <label class="inline-flex items-center gap-2 cursor-pointer">
                            <span class="text-sm text-gray-600">Aktifkan Template Custom</span>
                            <input type="checkbox" id="wa_template_toggle" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                                {{ $invitation->wa_template_enabled ? 'checked' : '' }}
                                onchange="document.getElementById('wa_template_form').submit()">
                        </label>
                    </div>
                    <form id="wa_template_form" action="{{ route('dashboard.invitations.whatsapp.template', $invitation) }}" method="POST">
                        @csrf
                        <input type="hidden" name="wa_template_enabled" value="{{ $invitation->wa_template_enabled ? '0' : '1' }}" id="wa_template_enabled_input">
                        <div class="mb-3">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Template Pesan</label>
                            <textarea name="wa_message_template" rows="5"
                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"
                                placeholder="Kosongkan untuk menggunakan template default">{{ $invitation->wa_message_template }}</textarea>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex flex-wrap gap-2">
                                <span class="text-xs text-gray-500">Variabel tersedia:</span>
                                <code class="text-xs bg-gray-100 px-1.5 py-0.5 rounded">{nama_tamu}</code>
                                <code class="text-xs bg-gray-100 px-1.5 py-0.5 rounded">{nama_mempelai_pria}</code>
                                <code class="text-xs bg-gray-100 px-1.5 py-0.5 rounded">{nama_mempelai_wanita}</code>
                                <code class="text-xs bg-gray-100 px-1.5 py-0.5 rounded">{tautan_undangan}</code>
                                <code class="text-xs bg-gray-100 px-1.5 py-0.5 rounded">{tanggal_acara}</code>
                                <code class="text-xs bg-gray-100 px-1.5 py-0.5 rounded">{waktu_acara}</code>
                                <code class="text-xs bg-gray-100 px-1.5 py-0.5 rounded">{tempat_acara}</code>
                                <code class="text-xs bg-gray-100 px-1.5 py-0.5 rounded">{qrcode_link}</code>
                            </div>
                            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-indigo-700">
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

            {{-- Import Card --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Import Tamu Massal (CSV)</h3>
                    <form action="{{ route('dashboard.invitations.guests.import', $invitation) }}" method="POST" enctype="multipart/form-data" class="flex flex-col md:flex-row items-end gap-4">
                        @csrf
                        <div class="flex-1 w-full">
                            <label for="file" class="block text-sm font-medium text-gray-700 mb-1">File CSV Tamu</label>
                            <input type="file" name="file" id="file" required accept=".csv,text/csv,text/plain" class="block w-full border border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                        </div>
                        <div class="flex-shrink-0 w-full md:w-auto">
                            <button type="submit" class="w-full bg-gradient-to-r from-indigo-600 to-indigo-700 text-white px-5 py-2.5 rounded-lg text-sm font-semibold hover:from-indigo-700 hover:to-indigo-800 shadow-sm transition-all duration-200">
                                📤 Import CSV
                            </button>
                        </div>
                    </form>
                    <p class="mt-2 text-xs text-gray-500">
                        Format file harus CSV. Baris pertama (header) wajib memiliki kolom: <strong class="text-indigo-600">nama</strong> atau <strong class="text-indigo-600">name</strong>. Kolom opsional: <strong class="text-indigo-600">phone</strong> atau <strong class="text-indigo-600">whatsapp</strong> untuk no HP.
                    </p>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
                        <h3 class="text-lg font-medium text-gray-900">Daftar Tamu ({{ $guests->total() }})</h3>
                        <div class="flex gap-2">
                            <button id="bulkSendBtn" disabled
                                class="bg-green-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-green-700 disabled:opacity-50 disabled:cursor-not-allowed"
                                onclick="bulkSend()">
                                Kirim WA Massal
                            </button>
                            <a href="{{ route('dashboard.invitations.guests.create', $invitation) }}" class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-indigo-700 w-full sm:w-auto text-center">
                                + Tambah Tamu
                            </a>
                        </div>
                    </div>

                    @if($guests->isEmpty())
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada tamu</h3>
                            <p class="mt-1 text-sm text-gray-500">Mulai tambahkan tamu untuk mengenerate link unik.</p>
                            <div class="mt-6">
                                <a href="{{ route('dashboard.invitations.guests.create', $invitation) }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                                    + Tambah Tamu Baru
                                </a>
                            </div>
                        </div>
                    @else
                        <form id="bulkSendForm" action="{{ route('dashboard.invitations.whatsapp.send', $invitation) }}" method="POST">
                            @csrf
                            <div class="overflow-x-auto border border-gray-200 rounded-md">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                <input type="checkbox" id="selectAll" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Tamu</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No HP</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status WA</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kehadiran</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Link Personal</th>
                                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($guests as $guest)
                                            @php $waStatus = $guest->wa_status; @endphp
                                            <tr>
                                                <td class="px-3 py-4 whitespace-nowrap">
                                                    @if($guest->phone)
                                                        <input type="checkbox" name="guest_ids[]" value="{{ $guest->id }}"
                                                            class="guest-checkbox rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                                    @endif
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                    {{ $guest->name }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ $guest->phone ?? '-' }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                    @if($waStatus === 'sent')
                                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Terkirim</span>
                                                    @elseif($waStatus === 'failed')
                                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Gagal</span>
                                                    @elseif($waStatus === 'queued' || $waStatus === 'pending')
                                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Diproses</span>
                                                    @else
                                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600">Belum</span>
                                                    @endif
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                    @if($guest->attendance_status === 'hadir')
                                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800" title="Check-in pada {{ $guest->checked_in_at?->format('H:i, d M Y') }}">
                                                            Hadir
                                                        </span>
                                                    @elseif($guest->attendance_status === 'absen')
                                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-rose-100 text-rose-800">
                                                            Absen
                                                        </span>
                                                    @else
                                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600">
                                                            Pending
                                                        </span>
                                                    @endif
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    <div class="flex items-center gap-2">
                                                        <input type="text" readonly value="{{ $guest->personalized_link }}" class="text-xs border-gray-300 rounded-md shadow-sm w-40 bg-gray-50" id="link-{{ $guest->id }}">
                                                        <button onclick="copyToClipboard('link-{{ $guest->id }}')" class="text-indigo-600 hover:text-indigo-900 text-xs" title="Copy Link">
                                                            Copy
                                                        </button>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                    <div class="flex items-center justify-end gap-2">
                                                        @if($guest->phone)
                                                            <form action="{{ route('dashboard.invitations.whatsapp.send-single', [$invitation, $guest]) }}" method="POST" class="inline-block">
                                                                @csrf
                                                                <button type="submit" class="text-green-600 hover:text-green-900 text-xs font-semibold" title="Kirim WhatsApp">
                                                                    Kirim WA
                                                                </button>
                                                            </form>
                                                        @endif
                                                        <a href="{{ route('dashboard.invitations.guests.edit', [$invitation, $guest]) }}" class="text-indigo-600 hover:text-indigo-900 text-xs font-semibold">Edit</a>
                                                        <form action="{{ route('dashboard.invitations.guests.destroy', [$invitation, $guest]) }}" method="POST" class="inline-block" onsubmit="return confirmSwal(event, 'Yakin ingin menghapus tamu ini?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="text-red-600 hover:text-red-900 text-xs font-semibold">Hapus</button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </form>

                        <div class="mt-4">
                            {{ $guests->links() }}
                        </div>

                        <script>
                            function copyToClipboard(id) {
                                var copyText = document.getElementById(id);
                                copyText.select();
                                copyText.setSelectionRange(0, 99999);
                                navigator.clipboard.writeText(copyText.value);
                                Swal.fire({ icon: 'success', title: 'Tersalin!', text: 'Link berhasil disalin!', timer: 1500, showConfirmButton: false });
                            }

                            // Select All toggle
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
                                btn.textContent = checked > 0 ? `Kirim WA Massal (${checked})` : 'Kirim WA Massal';
                            }

                            function bulkSend() {
                                Swal.fire({
                                    title: 'Konfirmasi',
                                    text: 'Kirim WhatsApp ke semua tamu yang dipilih? Pesan akan dikirim secara bertahap.',
                                    icon: 'question',
                                    showCancelButton: true,
                                    confirmButtonColor: '#3085d6',
                                    cancelButtonColor: '#d33',
                                    confirmButtonText: 'Ya, kirim!',
                                    cancelButtonText: 'Batal',
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        document.getElementById('bulkSendForm').submit();
                                    }
                                });
                            }
                        </script>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
