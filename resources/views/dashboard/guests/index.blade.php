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
            @php
                $waTemplateEnabled = $invitation->wa_template_enabled ? 'true' : 'false';
                $waMessageTemplate = $invitation->wa_message_template ?? '';
            @endphp
            <script>
                window.__WA_TEMPLATE_DATA = {
                    presets: @json($presets ?? []),
                    templateText: @js($waMessageTemplate),
                };
            </script>
            <div
                x-data="{
                    templateText: window.__WA_TEMPLATE_DATA.templateText || '',
                    templateEnabled: {{ $waTemplateEnabled }},
                    openPresetModal: false,
                    presets: window.__WA_TEMPLATE_DATA.presets || [],
                    insertVariable(varText) {
                        const el = this.$refs.messageField;
                        const start = el.selectionStart;
                        const end = el.selectionEnd;
                        this.templateText = this.templateText.substring(0, start) + varText + this.templateText.substring(end);
                        this.$nextTick(() => {
                            el.focus();
                            el.setSelectionRange(start + varText.length, start + varText.length);
                        });
                    },
                    selectPreset(presetText) {
                        if (this.templateText.trim().length > 0) {
                            Swal.fire({
                                title: 'Ganti Template?',
                                text: 'Memilih template ini akan menghapus teks draf yang sudah Anda tulis. Apakah Anda yakin?',
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#d33',
                                cancelButtonColor: '#3085d6',
                                confirmButtonText: 'Ya, ganti!',
                                cancelButtonText: 'Batal',
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    this.templateText = presetText;
                                    this.openPresetModal = false;
                                }
                            });
                        } else {
                            this.templateText = presetText;
                            this.openPresetModal = false;
                        }
                    }
                }"
                class="bg-white dark:bg-secondary-800 rounded-2xl shadow-soft border border-neutral-100 dark:border-secondary-700"
            >
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="font-heading text-lg font-bold text-secondary-800 dark:text-neutral-100">Template Pesan WhatsApp</h3>
                        <label class="inline-flex items-center gap-2 cursor-pointer select-none">
                            <span class="text-sm text-neutral-600 dark:text-neutral-400">Custom Template</span>
                            <input type="checkbox" x-model="templateEnabled"
                                class="rounded-lg border-neutral-300 dark:border-secondary-600 dark:bg-secondary-900 text-primary focus:ring-primary-500 shadow-sm">
                        </label>
                    </div>
                    <form id="wa_template_form" action="{{ route('dashboard.invitations.whatsapp.template', $invitation) }}" method="POST">
                        @csrf
                        <input type="hidden" name="wa_template_enabled" :value="templateEnabled ? '1' : '0'">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 mb-4">
                            <div class="flex flex-col">
                                <label for="whatsapp_template" class="text-xs font-bold text-secondary-700 dark:text-neutral-300 uppercase tracking-wider">
                                    Template Teks Pesan WhatsApp Undangan
                                </label>
                                <span class="text-[11px] text-neutral-400 mt-0.5">
                                    Tuliskan format pesan pembuka atau gunakan koleksi template bawaan siap pakai di bawah ini.
                                </span>
                            </div>
                            <button
                                type="button"
                                @click="openPresetModal = true"
                                class="inline-flex items-center justify-center px-3 py-1.5 bg-primary/10 hover:bg-primary/20 text-primary text-xs font-bold rounded-xl border border-primary/20 transition-all cursor-pointer shadow-sm whitespace-nowrap"
                            >
                                Pilih dari Template Contoh
                            </button>
                        </div>
                        <div class="relative mb-4">
                            <textarea
                                id="whatsapp_template"
                                name="wa_message_template"
                                rows="8"
                                x-ref="messageField"
                                x-model="templateText"
                                class="w-full text-sm p-4 rounded-2xl border border-neutral-200 dark:border-gray-700 bg-white dark:bg-secondary-900 text-secondary-800 dark:text-neutral-100 focus:outline-none focus:ring-2 focus:ring-primary font-sans leading-relaxed shadow-sm resize-y"
                                placeholder="Tulis draf pesan WhatsApp Anda di sini..."
                            ></textarea>
                        </div>
                        <div class="flex flex-wrap gap-2 items-center bg-neutral-50 dark:bg-secondary-900/50 p-3 rounded-xl border border-neutral-100 dark:border-secondary-700">
                            <span class="text-[10px] font-bold text-neutral-400 dark:text-neutral-500 uppercase tracking-wider block mr-1">
                                Klik untuk Menyisipkan:
                            </span>
                            <button type="button" @click="insertVariable('@{{nama_tamu}}')"
                                class="text-[11px] font-semibold bg-white dark:bg-secondary-800 border border-neutral-200 dark:border-secondary-600 hover:border-primary text-neutral-700 dark:text-neutral-300 px-2.5 py-1 rounded-lg shadow-sm transition-all cursor-pointer hover:text-primary">
                                Nama Tamu
                            </button>
                            <button type="button" @click="insertVariable('@{{nama_pengantin}}')"
                                class="text-[11px] font-semibold bg-white dark:bg-secondary-800 border border-neutral-200 dark:border-secondary-600 hover:border-primary text-neutral-700 dark:text-neutral-300 px-2.5 py-1 rounded-lg shadow-sm transition-all cursor-pointer hover:text-primary">
                                Nama Pengantin
                            </button>
                            <button type="button" @click="insertVariable('@{{link_undangan}}')"
                                class="text-[11px] font-semibold bg-white dark:bg-secondary-800 border border-neutral-200 dark:border-secondary-600 hover:border-primary text-neutral-700 dark:text-neutral-300 px-2.5 py-1 rounded-lg shadow-sm transition-all cursor-pointer hover:text-primary">
                                Link Undangan
                            </button>
                            <button type="button" @click="insertVariable('@{{tanggal_acara}}')"
                                class="text-[11px] font-semibold bg-white dark:bg-secondary-800 border border-neutral-200 dark:border-secondary-600 hover:border-primary text-neutral-700 dark:text-neutral-300 px-2.5 py-1 rounded-lg shadow-sm transition-all cursor-pointer hover:text-primary">
                                Tanggal Acara
                            </button>
                            <button type="button" @click="insertVariable('@{{waktu_acara}}')"
                                class="text-[11px] font-semibold bg-white dark:bg-secondary-800 border border-neutral-200 dark:border-secondary-600 hover:border-primary text-neutral-700 dark:text-neutral-300 px-2.5 py-1 rounded-lg shadow-sm transition-all cursor-pointer hover:text-primary">
                                Waktu Acara
                            </button>
                            <button type="button" @click="insertVariable('@{{tempat_acara}}')"
                                class="text-[11px] font-semibold bg-white dark:bg-secondary-800 border border-neutral-200 dark:border-secondary-600 hover:border-primary text-neutral-700 dark:text-neutral-300 px-2.5 py-1 rounded-lg shadow-sm transition-all cursor-pointer hover:text-primary">
                                Tempat Acara
                            </button>
                            <button type="button" @click="insertVariable('@{{daftar_acara}}')"
                                class="text-[11px] font-semibold bg-white dark:bg-secondary-800 border border-neutral-200 dark:border-secondary-600 hover:border-primary text-neutral-700 dark:text-neutral-300 px-2.5 py-1 rounded-lg shadow-sm transition-all cursor-pointer hover:text-primary">
                                Daftar Acara
                            </button>
                            <button type="button" @click="insertVariable('@{{qrcode_link}}')"
                                class="text-[11px] font-semibold bg-white dark:bg-secondary-800 border border-neutral-200 dark:border-secondary-600 hover:border-primary text-neutral-700 dark:text-neutral-300 px-2.5 py-1 rounded-lg shadow-sm transition-all cursor-pointer hover:text-primary">
                                QR Code Link
                            </button>
                        </div>
                        {{-- Preset Template Gallery Modal --}}
                        <div x-show="openPresetModal" class="fixed inset-0 bg-black/60 z-50 flex items-center justify-center p-4" x-transition x-cloak>
                            <div class="bg-white dark:bg-secondary-800 rounded-3xl p-6 max-w-2xl w-full max-h-[80vh] flex flex-col justify-between shadow-2xl space-y-4" @click.away="openPresetModal = false">

                                <div>
                                    <h3 class="text-sm font-bold text-secondary-900 dark:text-white uppercase tracking-wider">Koleksi Template Contoh Pesan WA</h3>
                                    <p class="text-[11px] text-neutral-400 mt-0.5">Pilih salah satu template siap pakai di bawah ini. Kode penanda variabel otomatis menyesuaikan data undangan.</p>
                                </div>

                                <div class="flex-1 overflow-y-auto pr-1 space-y-3 max-h-[50vh]">
                                    <template x-for="preset in presets" :key="preset.name">
                                        <div class="border border-neutral-100 dark:border-secondary-700 bg-neutral-50 dark:bg-secondary-900 p-4 rounded-2xl flex flex-col justify-between hover:border-primary/50 transition-all">
                                            <div class="flex items-center justify-between">
                                                <span class="text-xs font-extrabold text-secondary-700 dark:text-neutral-300" x-text="preset.name"></span>
                                                <button
                                                    type="button"
                                                    @click="selectPreset(preset.text)"
                                                    class="text-[10px] font-bold bg-primary text-white px-3 py-1 rounded-lg hover:bg-primary-600 transition-all cursor-pointer shadow-sm"
                                                >
                                                    Use Template
                                                </button>
                                            </div>
                                            <pre class="mt-2 text-[11px] text-neutral-500 dark:text-neutral-400 font-sans leading-relaxed whitespace-pre-line bg-white dark:bg-secondary-800 p-3 rounded-xl border border-neutral-100 dark:border-secondary-700 select-all" x-text="preset.text"></pre>
                                        </div>
                                    </template>
                                </div>

                                <div class="pt-2 border-t border-neutral-100 dark:border-secondary-700 flex justify-end">
                                    <button
                                        type="button"
                                        @click="openPresetModal = false"
                                        class="px-4 py-2 bg-neutral-100 dark:bg-secondary-700 text-neutral-600 dark:text-neutral-300 text-xs font-bold rounded-xl hover:bg-neutral-200 transition-all cursor-pointer"
                                    >
                                        Tutup Pustaka
                                    </button>
                                </div>

                            </div>
                        </div>

                        <div class="mt-4 flex justify-end">
                            <button type="submit" class="bg-gradient-to-r from-primary to-primary-600 text-white px-5 py-2 rounded-xl text-sm font-semibold hover:shadow-lg transition-all">
                                Simpan Template
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            @if($invitation->hasFeature('guest_import'))
            {{-- Import Card --}}
            <div class="bg-white dark:bg-secondary-800 rounded-2xl shadow-soft border border-neutral-100 dark:border-secondary-700">
                <div class="p-6">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-4">
                        <h3 class="font-heading text-lg font-bold text-secondary-800 dark:text-neutral-100">Import Tamu Massal (Excel)</h3>
                        <a href="{{ route('dashboard.invitations.guests.template', $invitation) }}"
                           class="inline-flex items-center gap-1.5 bg-emerald-50 dark:bg-emerald-900/50 text-emerald-700 dark:text-emerald-300 px-4 py-2 rounded-xl text-sm font-medium hover:bg-emerald-100 dark:hover:bg-emerald-900/70 transition-colors">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Download Template Excel
                        </a>
                    </div>
                    <form action="{{ route('dashboard.invitations.guests.import', $invitation) }}" method="POST" enctype="multipart/form-data" class="flex flex-col md:flex-row items-end gap-4">
                        @csrf
                        <div class="flex-1 w-full">
                            <label for="file" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1.5">File Excel Tamu</label>
                            <input type="file" name="file" id="file" required accept=".csv,.xlsx,.xls,.txt,text/csv,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
                                class="block w-full border border-neutral-300 dark:border-secondary-600 dark:bg-secondary-900 dark:text-neutral-200 rounded-xl shadow-sm focus:border-primary-500 focus:ring-primary-500 text-sm file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-primary-50 dark:file:bg-primary-900/50 file:text-primary-700 dark:file:text-primary-300 hover:file:bg-primary-100 dark:hover:file:bg-primary-900/70">
                        </div>
                        <div class="flex-shrink-0 w-full md:w-auto">
                            <button type="submit" class="w-full bg-gradient-to-r from-primary to-primary-600 text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:shadow-lg transition-all">
                                <span class="flex items-center gap-2 justify-center">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                    </svg>
                                    Import Excel
                                </span>
                            </button>
                        </div>
                    </form>
                    <p class="mt-2.5 text-xs text-neutral-500 dark:text-neutral-400">
                        Format file <strong class="text-primary">.xlsx</strong> atau <strong class="text-primary">.csv</strong>. Baris pertama (header) wajib memiliki kolom: <strong class="text-primary">Nama Tamu</strong>, <strong class="text-primary">Nomor WhatsApp</strong>, <strong class="text-primary">Kategori</strong>, dan <strong class="text-primary">Acara</strong> (dipisah dengan tanda | untuk multi-acara). Download template untuk contoh format.
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
                        <div class="flex flex-wrap gap-2">
                            <button id="bulkSendBtn" disabled
                                class="inline-flex items-center justify-center gap-1.5 bg-emerald-600 text-white px-3 py-2 rounded-xl text-sm font-medium hover:bg-emerald-700 disabled:opacity-50 disabled:cursor-not-allowed transition-colors"
                                onclick="bulkSend()">
                                <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                </svg>
                                <span class="hidden sm:inline">Kirim WA Massal</span>
                            </button>
                            <button id="bulkDeleteBtn" disabled
                                class="inline-flex items-center justify-center gap-1.5 bg-red-500 text-white px-3 py-2 rounded-xl text-sm font-medium hover:bg-red-600 disabled:opacity-50 disabled:cursor-not-allowed transition-colors"
                                onclick="bulkDelete()">
                                <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                <span class="hidden sm:inline">Hapus Dipilih</span>
                            </button>
                            <form action="{{ route('dashboard.invitations.guests.destroy-all', $invitation) }}" method="POST" class="inline-block" onsubmit="return confirmSwal(event, 'Yakin ingin menghapus SEMUA tamu?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="inline-flex items-center justify-center gap-1.5 bg-red-100 dark:bg-red-900/50 text-red-700 dark:text-red-300 px-3 py-2 rounded-xl text-sm font-medium hover:bg-red-200 dark:hover:bg-red-900/70 transition-colors">
                                    <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    <span class="hidden sm:inline">Hapus Semua</span>
                                </button>
                            </form>
                            <a href="{{ route('dashboard.invitations.guests.create', $invitation) }}"
                               class="inline-flex items-center justify-center gap-1.5 bg-gradient-to-r from-primary to-primary-600 text-white px-3 py-2 rounded-xl text-sm font-medium hover:shadow-lg transition-all">
                                <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                <span class="hidden sm:inline">Tambah Tamu</span>
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
                            @if(request('search'))
                                <h3 class="text-base font-bold text-secondary-800 dark:text-neutral-100">Tamu tidak ditemukan</h3>
                                <p class="mt-1 text-sm text-neutral-500 dark:text-neutral-400">Tidak ada tamu yang cocok dengan pencarian "<strong>{{ request('search') }}</strong>".</p>
                                <div class="mt-6">
                                    <a href="{{ route('dashboard.invitations.guests.index', $invitation) }}"
                                       class="inline-flex items-center gap-2 bg-neutral-200 dark:bg-secondary-700 text-neutral-700 dark:text-neutral-300 px-5 py-2.5 rounded-xl text-sm font-semibold hover:bg-neutral-300 dark:hover:bg-secondary-600 transition-colors">
                                        Reset Pencarian
                                    </a>
                                </div>
                            @else
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
                            @endif
                        </div>
                    @else
                        <form method="GET" class="flex flex-col sm:flex-row gap-3 mb-4">
                            <div class="relative flex-1">
                                <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-neutral-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                                <input type="text" name="search" value="{{ request('search') }}"
                                    placeholder="Cari nama, nomor, atau kategori..."
                                    class="block w-full pl-10 pr-3 py-2 rounded-xl border-neutral-300 dark:border-secondary-600 dark:bg-secondary-700 dark:text-neutral-200 shadow-sm focus:border-primary-500 focus:ring-primary-500 text-sm">
                            </div>
                            <div class="flex flex-wrap gap-2">
                                <select name="per_page" onchange="this.form.submit()"
                                    class="rounded-xl border-neutral-300 dark:border-secondary-600 dark:bg-secondary-700 dark:text-neutral-200 shadow-sm focus:border-primary-500 focus:ring-primary-500 text-sm">
                                    <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                                    <option value="20" {{ request('per_page', 20) == 20 ? 'selected' : '' }}>20</option>
                                    <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                                    <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                                    <option value="all" {{ request('per_page') == 'all' ? 'selected' : '' }}>Semua</option>
                                </select>
                                <button type="submit" class="bg-primary text-white px-4 py-2 rounded-xl text-sm font-semibold hover:bg-primary-600 transition-colors">Cari</button>
                                @if(request('search'))
                                    <a href="{{ route('dashboard.invitations.guests.index', $invitation) }}"
                                       class="inline-flex items-center px-3 py-2 rounded-xl border border-neutral-300 dark:border-secondary-600 text-neutral-600 dark:text-neutral-300 text-sm hover:bg-neutral-50 dark:hover:bg-secondary-700 transition-colors">
                                        Reset
                                    </a>
                                @endif
                            </div>
                        </form>
                        <div class="overflow-x-auto border border-neutral-200 dark:border-secondary-700 rounded-2xl">
                                <table class="min-w-full divide-y divide-neutral-200 dark:divide-secondary-700">
                                    <thead class="bg-neutral-50 dark:bg-secondary-900">
                                        <tr>
                                            <th scope="col" class="px-3 py-3.5 text-left">
                                                <input type="checkbox" id="selectAll"
                                                    class="rounded-lg border-neutral-300 dark:border-secondary-600 dark:bg-secondary-900 text-primary focus:ring-primary-500 shadow-sm">
                                            </th>
                                            <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Nama Tamu</th>
                                            <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Kategori</th>
                                            <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Acara</th>
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
                                            <tr class="guest-row hover:bg-neutral-50 dark:hover:bg-secondary-700/50 transition-colors cursor-pointer">
                                                <td class="px-3 py-4 whitespace-nowrap">
                                                    <input type="checkbox" name="guest_ids[]" value="{{ $guest->id }}"
                                                        class="guest-checkbox rounded-lg border-neutral-300 dark:border-secondary-600 dark:bg-secondary-900 text-primary focus:ring-primary-500 shadow-sm"
                                                        data-has-phone="{{ ($guest->whatsapp_number ?? $guest->phone) ? '1' : '0' }}">
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <span class="text-sm font-semibold text-secondary-800 dark:text-neutral-200">{{ $guest->name }}</span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    @if($guest->guestCategory)
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                                                              style="background-color: {{ $guest->guestCategory->color_code }}20; color: {{ $guest->guestCategory->color_code }}; border: 1px solid {{ $guest->guestCategory->color_code }}40;">
                                                            {{ $guest->guestCategory->name }}
                                                        </span>
                                                    @else
                                                        <span class="text-xs text-neutral-400 dark:text-neutral-500">—</span>
                                                    @endif
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    @if($guest->events->isNotEmpty())
                                                        <div class="flex flex-wrap gap-1">
                                                            @foreach($guest->events as $event)
                                                            <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-medium bg-primary-50 dark:bg-primary-900/30 text-primary-700 dark:text-primary-300 border border-primary-200 dark:border-primary-800">
                                                                {{ $event->event_title }}
                                                            </span>
                                                            @endforeach
                                                        </div>
                                                    @else
                                                        <span class="text-xs text-neutral-400 dark:text-neutral-500">Semua Acara</span>
                                                    @endif
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-500 dark:text-neutral-400">
                                                    {{ $guest->whatsapp_number ?? $guest->phone ?? '—' }}
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
                                                        @if($guest->whatsapp_number ?? $guest->phone)
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
                        @if(method_exists($guests, 'links'))
                            <div class="mt-6">
                                {{ $guests->links() }}
                            </div>
                        @endif

                        <form id="bulkSendForm" action="{{ route('dashboard.invitations.whatsapp.send', $invitation) }}" method="POST" class="hidden">
                            @csrf
                        </form>

                        <form id="bulkDeleteForm" action="{{ route('dashboard.invitations.guests.destroy-selected', $invitation) }}" method="POST" class="hidden">
                            @csrf
                        </form>

                        <style>
                            [x-cloak] { display: none !important; }
                        </style>

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

                            document.querySelectorAll('.guest-row').forEach(row => {
                                row.addEventListener('click', function(e) {
                                    if (e.target.closest('a') || e.target.closest('button') || e.target.closest('form')) return;
                                    const cb = this.querySelector('.guest-checkbox');
                                    if (cb) {
                                        cb.checked = !cb.checked;
                                        updateBulkButton();
                                    }
                                });
                            });

                            function updateBulkButton() {
                                const checked = document.querySelectorAll('.guest-checkbox:checked').length;
                                const sendBtn = document.getElementById('bulkSendBtn');
                                const deleteBtn = document.getElementById('bulkDeleteBtn');
                                sendBtn.disabled = checked === 0;
                                deleteBtn.disabled = checked === 0;
                                sendBtn.innerHTML = checked > 0
                                    ? `<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg> Kirim WA Massal (${checked})`
                                    : `<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg> Kirim WA Massal`;
                                deleteBtn.innerHTML = checked > 0
                                    ? `<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg> Hapus Dipilih (${checked})`
                                    : `<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg> Hapus Dipilih`;
                            }

                            function bulkSend() {
                                const checked = document.querySelectorAll('.guest-checkbox:checked');
                                if (checked.length === 0) return;

                                const noPhone = Array.from(checked).filter(cb => cb.dataset.hasPhone === '0');
                                if (noPhone.length > 0) {
                                    if (typeof Swal !== 'undefined') {
                                        Swal.fire({
                                            title: 'Tidak Dapat Dikirim',
                                            text: noPhone.length + ' tamu terpilih tidak memiliki nomor WhatsApp. Hanya tamu dengan nomor HP yang bisa dikirim undangan.',
                                            icon: 'error',
                                            confirmButtonColor: '#FF7A00',
                                            confirmButtonText: 'Mengerti',
                                        });
                                    }
                                    return;
                                }

                                if (typeof Swal !== 'undefined') {
                                    Swal.fire({
                                        title: 'Konfirmasi',
                                        text: 'Kirim WhatsApp ke ' + checked.length + ' tamu yang dipilih? Pesan akan dikirim secara bertahap.',
                                        icon: 'question',
                                        showCancelButton: true,
                                        confirmButtonColor: '#FF7A00',
                                        cancelButtonColor: '#EF4444',
                                        confirmButtonText: 'Ya, kirim!',
                                        cancelButtonText: 'Batal',
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            submitBulkForm('bulkSendForm', checked);
                                        }
                                    });
                                } else {
                                    submitBulkForm('bulkSendForm', checked);
                                }
                            }

                            function bulkDelete() {
                                const checked = document.querySelectorAll('.guest-checkbox:checked');
                                if (checked.length === 0) return;

                                if (typeof Swal !== 'undefined') {
                                    Swal.fire({
                                        title: 'Hapus Tamu?',
                                        text: 'Yakin ingin menghapus ' + checked.length + ' tamu yang dipilih?',
                                        icon: 'warning',
                                        showCancelButton: true,
                                        confirmButtonColor: '#EF4444',
                                        cancelButtonColor: '#6b7280',
                                        confirmButtonText: 'Ya, hapus!',
                                        cancelButtonText: 'Batal',
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            submitBulkForm('bulkDeleteForm', checked);
                                        }
                                    });
                                }
                            }

                            function submitBulkForm(formId, checked) {
                                const form = document.getElementById(formId);
                                form.querySelectorAll('.dynamic-guest-id').forEach(el => el.remove());
                                checked.forEach(cb => {
                                    const input = document.createElement('input');
                                    input.type = 'hidden';
                                    input.name = 'guest_ids[]';
                                    input.value = cb.value;
                                    input.className = 'dynamic-guest-id';
                                    form.appendChild(input);
                                });
                                form.submit();
                            }
                        </script>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
