<x-app-layout>
    @php
        $guestCount = (int) $guestStats->total;
        $hadirCount = (int) $guestStats->hadir;
        $absenCount = (int) $guestStats->absen;
        $pendingCount = (int) $guestStats->pending;
        $displayedCount = $guests->count();
    @endphp

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
                    <span class="text-neutral-600 dark:text-neutral-400 font-medium">Tamu Undangan</span>
                </nav>

                <div class="flex flex-col gap-5 lg:flex-row lg:items-start lg:justify-between">
                    <div>
                        <h1 class="font-heading text-2xl sm:text-3xl font-bold text-secondary-800 dark:text-neutral-50 leading-tight">
                            Tamu Undangan
                        </h1>
                        <p class="mt-1 max-w-xl text-sm leading-relaxed text-neutral-500 dark:text-neutral-400">Kelola daftar tamu, link personal, status kehadiran, dan pengiriman WhatsApp dalam satu tempat.</p>
                    </div>
                    <div class="flex flex-wrap items-center gap-2 lg:justify-end">
                        <a href="{{ route('dashboard.invitations.guests.create', $invitation) }}"
                           class="inline-flex min-h-[40px] items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-primary to-primary-600 px-4 py-2 text-sm font-semibold text-white shadow-sm shadow-primary/20 transition-all hover:-translate-y-0.5 hover:shadow-lg hover:shadow-primary/20 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 dark:focus:ring-offset-secondary-900">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Tambah Tamu
                        </a>
                        @if($invitation->hasFeature('qr_checkin'))
                            <a href="{{ route('dashboard.invitations.guestbook', $invitation) }}"
                               class="inline-flex min-h-[40px] items-center gap-1.5 rounded-xl border border-primary/30 bg-white/70 px-3.5 py-2 text-xs font-semibold text-primary backdrop-blur-sm transition-colors hover:bg-primary-50 dark:border-primary-700/50 dark:bg-secondary-800/50 dark:text-primary-400 dark:hover:bg-primary-900/20">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                                </svg>
                                Scanner Tamu
                            </a>
                        @endif
                        <details class="group relative">
                            <summary class="inline-flex min-h-[40px] cursor-pointer list-none items-center gap-2 rounded-xl border border-neutral-300/80 bg-white/70 px-3.5 py-2 text-xs font-semibold text-secondary-700 backdrop-blur-sm transition-colors hover:bg-white [&::-webkit-details-marker]:hidden dark:border-secondary-600 dark:bg-secondary-800/50 dark:text-neutral-300 dark:hover:bg-secondary-700">
                                Lainnya
                                <svg class="h-3.5 w-3.5 transition-transform group-open:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                            </summary>
                            <div class="absolute right-0 z-30 mt-2 w-56 overflow-hidden rounded-xl border border-neutral-200 bg-white p-1.5 shadow-xl dark:border-secondary-700 dark:bg-secondary-800">
                                <a href="{{ route('dashboard.whatsapp.setting', $invitation) }}" class="flex items-center gap-2 rounded-lg px-3 py-2.5 text-xs font-semibold text-neutral-700 hover:bg-neutral-50 dark:text-neutral-200 dark:hover:bg-secondary-700">Atur Pengirim WA</a>
                                <a href="{{ route('dashboard.invitations.whatsapp.logs', $invitation) }}" class="flex items-center gap-2 rounded-lg px-3 py-2.5 text-xs font-semibold text-neutral-700 hover:bg-neutral-50 dark:text-neutral-200 dark:hover:bg-secondary-700">Riwayat Pengiriman</a>
                                <a href="{{ route('dashboard.invitations.show', $invitation) }}" class="flex items-center gap-2 rounded-lg px-3 py-2.5 text-xs font-semibold text-neutral-700 hover:bg-neutral-50 dark:text-neutral-200 dark:hover:bg-secondary-700">Kembali ke Undangan</a>
                            </div>
                        </details>
                    </div>
                </div>

                {{-- WA Status Bar Scoped Per Invitation --}}
                <div class="mt-5 flex flex-col gap-3 rounded-xl border p-3.5 text-xs sm:flex-row sm:items-center sm:justify-between
                    {{ $waStatus === 'CONNECTED' ? 'bg-emerald-50 border-emerald-200 text-emerald-800 dark:bg-emerald-900/20 dark:border-emerald-700 dark:text-emerald-300' : '' }}
                    {{ $waStatus === 'READY_TO_PAIR' ? 'bg-blue-50 border-blue-200 text-blue-800 dark:bg-blue-900/20 dark:border-blue-700 dark:text-blue-300' : '' }}
                    {{ in_array($waStatus, ['PENDING_VERIFICATION', 'PAIRING']) ? 'bg-amber-50 border-amber-200 text-amber-800 dark:bg-amber-900/20 dark:border-amber-700 dark:text-amber-300' : '' }}
                    {{ $waStatus === 'REJECTED' ? 'bg-red-50 border-red-200 text-red-800 dark:bg-red-900/20 dark:border-red-700 dark:text-red-300' : '' }}">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                        </svg>
                        <span>
                            <strong>WA Pengirim Undangan Ini:</strong>
                            @if($waStatus === 'CONNECTED')
                                Terhubung ({{ $waSetting->phone_number ? '+'.$waSetting->phone_number : 'Valid' }})
                            @elseif($waStatus === 'READY_TO_PAIR')
                                Siap Pairing — Silakan scan QR Code
                            @elseif($waStatus === 'PAIRING')
                                Sedang Pairing (Menunggu Scan)
                            @elseif($waStatus === 'REJECTED')
                                Ditolak Admin {{ $waSetting->admin_notes ? '('.$waSetting->admin_notes.')' : '' }}
                            @else
                                Belum Terhubung / Menunggu Verifikasi Admin
                            @endif
                        </span>
                    </div>
                    <a href="{{ route('dashboard.whatsapp.setting', $invitation) }}" class="underline font-semibold shrink-0 hover:opacity-80">
                        @if(in_array($waStatus, ['READY_TO_PAIR', 'PAIRING']))
                            Scan QR Now →
                        @else
                            Atur Pengirim →
                        @endif
                    </a>
                </div>

                {{-- WA Blast Quota Card --}}
                @if($waQuota)
                    <div class="mt-3 p-3.5 rounded-xl border border-neutral-200/80 dark:border-secondary-700/60 bg-white/70 dark:bg-secondary-800/50 backdrop-blur-sm flex flex-col sm:flex-row sm:items-center gap-3">
                        <div class="flex items-center gap-2 shrink-0">
                            <span class="w-8 h-8 rounded-lg bg-primary-100 dark:bg-primary-900/40 text-primary dark:text-primary-400 flex items-center justify-center">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </span>
                            <div>
                                <p class="text-xs font-bold text-secondary-800 dark:text-neutral-100">Kuota WA Blast</p>
                                <p class="text-[11px] text-neutral-500 dark:text-neutral-400">{{ $waQuota['sent'] }} dari {{ $waQuota['limit'] }} pesan terpakai</p>
                            </div>
                        </div>
                        <div class="flex-1">
                            <div class="h-2 rounded-full bg-neutral-200 dark:bg-secondary-700 overflow-hidden">
                                <div class="h-full rounded-full transition-all {{ $waQuota['remaining'] <= 0 ? 'bg-red-500' : ($waQuota['remaining'] <= 5 ? 'bg-amber-500' : 'bg-emerald-500') }}" style="width: {{ $waQuota['used_percentage'] }}%"></div>
                            </div>
                        </div>
                        <span class="text-xs font-bold shrink-0 {{ $waQuota['remaining'] <= 0 ? 'text-red-600 dark:text-red-400' : 'text-emerald-600 dark:text-emerald-400' }}">
                            @if($waQuota['remaining'] <= 0)
                                Kuota Habis — Hubungi Admin
                            @else
                                Sisa {{ $waQuota['remaining'] }} pesan
                            @endif
                        </span>
                    </div>
                @endif

                {{-- Stat Strip --}}
                <div class="mt-5 grid grid-cols-2 gap-px overflow-hidden rounded-2xl border border-neutral-200/80 bg-neutral-200/70 dark:border-secondary-700/50 dark:bg-secondary-700/50 sm:grid-cols-4">
                    <div class="bg-white/80 dark:bg-secondary-800/70 px-3 sm:px-5 py-4 flex flex-col items-center sm:items-start text-center sm:text-left backdrop-blur-sm">
                        <span class="stat-value text-xl sm:text-2xl font-bold text-secondary-800 dark:text-neutral-100 tabular-nums">{{ $guestCount }}</span>
                        <span class="text-[10px] sm:text-xs text-neutral-500 dark:text-neutral-400 font-medium mt-0.5">Total Tamu</span>
                    </div>
                    <div class="bg-white/80 dark:bg-secondary-800/70 px-3 sm:px-5 py-4 flex flex-col items-center sm:items-start text-center sm:text-left backdrop-blur-sm">
                        <span class="stat-value text-xl sm:text-2xl font-bold text-emerald-600 dark:text-emerald-400 tabular-nums">{{ $hadirCount }}</span>
                        <span class="text-[10px] sm:text-xs text-neutral-500 dark:text-neutral-400 font-medium mt-0.5">Hadir</span>
                    </div>
                    <div class="bg-white/80 dark:bg-secondary-800/70 px-3 sm:px-5 py-4 flex flex-col items-center sm:items-start text-center sm:text-left backdrop-blur-sm">
                        <span class="stat-value text-xl sm:text-2xl font-bold text-rose-600 dark:text-rose-400 tabular-nums">{{ $absenCount }}</span>
                        <span class="text-[10px] sm:text-xs text-neutral-500 dark:text-neutral-400 font-medium mt-0.5">Absen</span>
                    </div>
                    <div class="bg-white/80 dark:bg-secondary-800/70 px-3 sm:px-5 py-4 flex flex-col items-center sm:items-start text-center sm:text-left backdrop-blur-sm">
                        <span class="stat-value text-xl sm:text-2xl font-bold text-amber-600 dark:text-amber-400 tabular-nums">{{ $pendingCount }}</span>
                        <span class="text-[10px] sm:text-xs text-neutral-500 dark:text-neutral-400 font-medium mt-0.5">Pending</span>
                    </div>
                </div>

            </div>
        </div>

        {{-- ─── MAIN CONTENT ─── --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-7 sm:py-8 space-y-6">

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
            <script>
                window.__WA_TEMPLATE_DATA = {
                    presets: @json($presets ?? []),
                    templateText: @js($invitation->wa_message_template ?? ''),
                    templateEnabled: @js((bool) $invitation->wa_template_enabled),
                };
            </script>
            <div
                x-data="waTemplateEditor"
                id="message-template"
                class="scroll-mt-6 overflow-hidden rounded-2xl border border-neutral-200/80 bg-white dark:border-secondary-700/60 dark:bg-secondary-800"
            >
                <div class="flex flex-col gap-3 px-5 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-6">
                    <div class="flex items-center gap-3">
                        <span class="flex h-9 w-9 flex-shrink-0 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 dark:bg-emerald-900/30 dark:text-emerald-400">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 4v-4z" /></svg>
                        </span>
                        <div>
                            <h2 class="text-sm font-semibold text-secondary-800 dark:text-neutral-100">Template Pesan WhatsApp</h2>
                            <p class="mt-0.5 text-xs text-neutral-500 dark:text-neutral-400">Opsional · Sesuaikan pesan sebelum dikirim ke tamu.</p>
                        </div>
                    </div>
                    <button type="button" @click="expanded = !expanded" :aria-expanded="expanded"
                        class="inline-flex items-center justify-center gap-2 rounded-xl border border-neutral-200 px-3.5 py-2 text-xs font-semibold text-neutral-700 transition-colors hover:bg-neutral-50 dark:border-secondary-600 dark:text-neutral-200 dark:hover:bg-secondary-700">
                        <span x-text="expanded ? 'Tutup pengaturan' : 'Atur template'"></span>
                        <svg class="h-3.5 w-3.5 transition-transform" :class="expanded && 'rotate-180'" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                    </button>
                </div>
                <div x-show="expanded" x-collapse class="border-t border-neutral-100 p-5 dark:border-secondary-700/60 sm:p-6">
                    <form id="wa_template_form" action="{{ route('dashboard.invitations.whatsapp.template', $invitation) }}" method="POST">
                        @csrf
                        <input type="hidden" name="wa_template_enabled" :value="templateEnabled ? '1' : '0'">
                        <div class="mb-4 flex items-center justify-between gap-3 rounded-xl border border-neutral-100 bg-neutral-50 p-3 dark:border-secondary-700 dark:bg-secondary-900/50">
                            <div>
                                <p class="text-xs font-semibold text-secondary-700 dark:text-neutral-200">Gunakan template kustom</p>
                                <p class="mt-0.5 text-[11px] text-neutral-500 dark:text-neutral-400">Otomatis aktif saat memilih template contoh.</p>
                            </div>
                            <label class="inline-flex cursor-pointer items-center gap-2 select-none">
                                <span class="sr-only">Aktifkan template kustom</span>
                                <input type="checkbox" x-model="templateEnabled"
                                    class="rounded-lg border-neutral-300 text-primary shadow-sm focus:ring-primary-500 dark:border-secondary-600 dark:bg-secondary-900">
                            </label>
                        </div>
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
                                                    Gunakan
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

            {{-- Import Card --}}
            @if($invitation->hasFeature('guest_import'))
            <details id="import-guests" class="group scroll-mt-6 overflow-hidden rounded-2xl border border-neutral-200/80 bg-white dark:border-secondary-700/60 dark:bg-secondary-800">
                <summary class="flex cursor-pointer list-none items-center justify-between gap-4 px-5 py-4 [&::-webkit-details-marker]:hidden sm:px-6">
                    <div class="flex items-center gap-3">
                        <span class="flex h-9 w-9 flex-shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-900/30 dark:text-blue-400">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 13l3-3m0 0l3 3m-3-3v12" /></svg>
                        </span>
                        <div>
                            <h2 class="text-sm font-semibold text-secondary-800 dark:text-neutral-100">Import Tamu Massal</h2>
                            <p class="mt-0.5 text-xs text-neutral-500 dark:text-neutral-400">Opsional · Tambahkan banyak tamu dari Excel atau CSV.</p>
                        </div>
                    </div>
                    <svg class="h-4 w-4 flex-shrink-0 text-neutral-400 transition-transform group-open:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                </summary>
                <div class="p-5 sm:p-6">
                    <div class="mb-4 flex justify-end">
                        <a href="{{ asset('template-import-tamu.xlsx') }}"
                           class="inline-flex items-center gap-1.5 rounded-xl border border-emerald-300/80 bg-white px-3.5 py-2 text-xs font-semibold text-emerald-700 transition-colors hover:bg-emerald-50 dark:border-emerald-700/50 dark:bg-secondary-800 dark:text-emerald-300 dark:hover:bg-emerald-900/20">
                            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                            Unduh Template
                        </a>
                    </div>
                    <form action="{{ route('dashboard.invitations.guests.import', $invitation) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="flex flex-col md:flex-row items-end gap-4">
                            <div class="flex-1 w-full">
                                <label for="file" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1.5">File Excel Tamu</label>
                                <input type="file" name="file" id="file" required accept=".csv,.xlsx,.xls,.txt,text/csv,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
                                    class="block w-full border border-neutral-300 dark:border-secondary-600 dark:bg-secondary-900 dark:text-neutral-200 rounded-xl shadow-sm focus:border-primary-500 focus:ring-primary-500 text-sm file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-primary-50 dark:file:bg-primary-900/50 file:text-primary-700 dark:file:text-primary-300 hover:file:bg-primary-100 dark:hover:file:bg-primary-900/70">
                            </div>
                            <div class="flex-shrink-0 w-full md:w-auto">
                                <button type="submit" class="w-full inline-flex items-center justify-center gap-2 bg-gradient-to-r from-primary to-primary-600 text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:shadow-lg transition-all">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                    </svg>
                                    Import Excel
                                </button>
                            </div>
                        </div>
                        <p class="mt-3 text-xs text-neutral-500 dark:text-neutral-400">
                            Format file <strong class="text-primary">.xlsx</strong> atau <strong class="text-primary">.csv</strong>. Baris pertama (header) wajib memiliki kolom: <strong class="text-primary">Nama Tamu</strong>, <strong class="text-primary">Nomor WhatsApp</strong>, <strong class="text-primary">Kategori</strong>, dan <strong class="text-primary">Acara</strong> (dipisah dengan tanda | untuk multi-acara). Download template untuk contoh format.
                        </p>
                    </form>
                </div>
            </details>
            @endif

            {{-- Guest List --}}
            <div id="guest-list" class="scroll-mt-6 overflow-hidden rounded-2xl border border-neutral-200/80 bg-white dark:border-secondary-700/60 dark:bg-secondary-800">
                <div class="px-5 sm:px-6 py-4 border-b border-neutral-100 dark:border-secondary-700/60">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                        <div>
                            <div class="flex items-center gap-2">
                                <h2 class="font-semibold text-sm text-secondary-800 dark:text-neutral-100">Daftar Tamu</h2>
                                <span class="inline-flex items-center justify-center min-w-[1.5rem] h-6 px-2 rounded-full bg-primary-50 dark:bg-primary-900/50 text-primary-700 dark:text-primary-300 text-xs font-bold">{{ $guestCount }}</span>
                            </div>
                            <p class="mt-1 text-xs text-neutral-500 dark:text-neutral-400">Pilih tamu untuk mengirim pesan atau melakukan aksi massal.</p>
                        </div>
                        <div class="flex flex-wrap gap-2">
                            <span id="selectedCount" class="hidden items-center rounded-xl bg-neutral-100 px-3 py-2 text-xs font-semibold text-neutral-600 dark:bg-secondary-700 dark:text-neutral-300" aria-live="polite"></span>
                            <button id="bulkSendBtn" type="button" aria-label="Kirim WhatsApp ke tamu terpilih" disabled
                                class="inline-flex items-center justify-center gap-1.5 rounded-xl bg-emerald-600 px-3 py-2 text-sm font-medium text-white transition-colors hover:bg-emerald-700 disabled:cursor-not-allowed disabled:opacity-40"
                                onclick="bulkSend()">
                                <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                </svg>
                                <span id="bulkSendLabel" class="hidden sm:inline">Kirim WA</span>
                            </button>
                            <button id="bulkDeleteBtn" type="button" aria-label="Hapus tamu terpilih" disabled
                                class="inline-flex items-center justify-center gap-1.5 rounded-xl border border-red-200 bg-red-50 px-3 py-2 text-sm font-medium text-red-700 transition-colors hover:bg-red-100 disabled:cursor-not-allowed disabled:opacity-40 dark:border-red-800 dark:bg-red-900/30 dark:text-red-300 dark:hover:bg-red-900/50"
                                onclick="bulkDelete()">
                                <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                <span id="bulkDeleteLabel" class="hidden sm:inline">Hapus</span>
                            </button>
                            <a href="{{ route('dashboard.invitations.guests.create', $invitation) }}"
                               class="inline-flex items-center justify-center gap-1.5 bg-gradient-to-r from-primary to-primary-600 text-white px-3 py-2 rounded-xl text-sm font-medium hover:shadow-lg transition-all">
                                <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                <span class="hidden sm:inline">Tambah Tamu</span>
                            </a>
                            <details class="group relative">
                                <summary aria-label="Aksi lainnya" class="inline-flex h-10 w-10 cursor-pointer list-none items-center justify-center rounded-xl border border-neutral-200 text-neutral-500 transition-colors hover:bg-neutral-50 [&::-webkit-details-marker]:hidden dark:border-secondary-600 dark:text-neutral-300 dark:hover:bg-secondary-700">
                                    <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20"><path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zm6 0a2 2 0 11-4 0 2 2 0 014 0zm6 0a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                                </summary>
                                <div class="absolute right-0 z-20 mt-2 w-48 rounded-xl border border-neutral-200 bg-white p-1.5 shadow-xl dark:border-secondary-700 dark:bg-secondary-800">
                                    <form action="{{ route('dashboard.invitations.guests.destroy-all', $invitation) }}" method="POST" onsubmit="return confirmSwal(event, 'Yakin ingin menghapus SEMUA tamu?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="flex w-full items-center gap-2 rounded-lg px-3 py-2.5 text-left text-xs font-semibold text-red-600 transition-colors hover:bg-red-50 dark:text-red-400 dark:hover:bg-red-900/30">
                                            Hapus semua tamu
                                        </button>
                                    </form>
                                </div>
                            </details>
                        </div>
                    </div>
                </div>

                <div class="p-5 sm:p-6">
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
                                       class="inline-flex items-center gap-2 px-5 py-2.5 bg-neutral-200 dark:bg-secondary-700 text-neutral-700 dark:text-neutral-300 rounded-xl text-sm font-semibold hover:bg-neutral-300 dark:hover:bg-secondary-600 transition-colors">
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
                        <form method="GET" class="mb-4 flex flex-col gap-3 sm:flex-row" role="search">
                            <input type="hidden" name="sort" value="{{ request('sort', 'created_at') }}">
                            <input type="hidden" name="direction" value="{{ request('direction', 'desc') }}">
                            <div class="relative flex-1">
                                <label for="guest-search" class="sr-only">Cari tamu</label>
                                <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-neutral-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                                <input id="guest-search" type="search" name="search" value="{{ request('search') }}"
                                    placeholder="Cari nama, nomor, atau kategori..."
                                    class="block w-full pl-10 pr-3 py-2 rounded-xl border-neutral-300 dark:border-secondary-600 dark:bg-secondary-700 dark:text-neutral-200 shadow-sm focus:border-primary-500 focus:ring-primary-500 text-sm">
                            </div>
                            <div class="flex flex-wrap gap-2">
                                <label for="guest-per-page" class="sr-only">Jumlah tamu per halaman</label>
                                <select id="guest-per-page" name="per_page" onchange="this.form.submit()" aria-label="Jumlah tamu per halaman"
                                    class="rounded-xl border-neutral-300 dark:border-secondary-600 dark:bg-secondary-700 dark:text-neutral-200 shadow-sm focus:border-primary-500 focus:ring-primary-500 text-sm">
                                    <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                                    <option value="20" {{ request('per_page', 20) == 20 ? 'selected' : '' }}>20</option>
                                    <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                                    <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                                    <option value="all" {{ request('per_page') == 'all' ? 'selected' : '' }}>Semua</option>
                                </select>
                                <button type="submit" class="bg-gradient-to-r from-primary to-primary-600 text-white px-4 py-2 rounded-xl text-sm font-semibold hover:shadow-lg transition-all">Cari</button>
                                @if(request('search'))
                                    <a href="{{ route('dashboard.invitations.guests.index', ['invitation' => $invitation, 'per_page' => request('per_page', 20)]) }}"
                                       class="inline-flex items-center px-3 py-2 rounded-xl border border-neutral-300 dark:border-secondary-600 text-neutral-600 dark:text-neutral-300 text-sm hover:bg-neutral-50 dark:hover:bg-secondary-700 transition-colors">
                                        Reset
                                    </a>
                                @endif
                            </div>
                        </form>

                        <div class="mb-4 flex flex-col gap-2 text-xs text-neutral-500 dark:text-neutral-400 sm:flex-row sm:items-center sm:justify-between">
                            <p>
                                Menampilkan <strong class="text-secondary-700 dark:text-neutral-200">{{ $displayedCount }}</strong>
                                @if(request('search'))
                                    hasil untuk “<strong class="text-secondary-700 dark:text-neutral-200">{{ request('search') }}</strong>”
                                @else
                                    dari <strong class="text-secondary-700 dark:text-neutral-200">{{ $guestCount }}</strong> tamu
                                @endif
                            </p>
                            <p class="hidden md:block">Klik baris untuk memilih tamu.</p>
                            <label class="inline-flex cursor-pointer items-center gap-2 font-semibold text-neutral-600 dark:text-neutral-300 md:hidden">
                                <input id="selectAllMobile" type="checkbox" class="rounded-lg border-neutral-300 text-primary shadow-sm focus:ring-primary-500 dark:border-secondary-600 dark:bg-secondary-900">
                                Pilih semua di halaman ini
                            </label>
                        </div>

                        <div class="overflow-x-auto rounded-2xl md:border md:border-neutral-200/80 md:dark:border-secondary-700/60">
                            <table class="table-stacked min-w-full divide-y divide-neutral-200 dark:divide-secondary-700">
                                <thead class="bg-neutral-50 dark:bg-secondary-900">
                                    <tr>
                                        <th scope="col" class="px-3 py-3.5 text-left">
                                            <input type="checkbox" id="selectAll"
                                                aria-label="Pilih semua tamu di halaman ini"
                                                class="rounded-lg border-neutral-300 dark:border-secondary-600 dark:bg-secondary-900 text-primary focus:ring-primary-500 shadow-sm">
                                        </th>
                                        <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                                            @php
                                                $sortUrl = fn ($field) => request()->fullUrlWithQuery([
                                                    'sort' => $field,
                                                    'direction' => (request('sort') === $field && request('direction', 'desc') === 'asc') ? 'desc' : 'asc',
                                                ]);
                                                $sortIcon = function ($field) {
                                                    if (request('sort') !== $field) {
                                                        return '<svg class="w-3 h-3 text-neutral-300 dark:text-neutral-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/></svg>';
                                                    }
                                                    return request('direction', 'desc') === 'asc'
                                                        ? '<svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/></svg>'
                                                        : '<svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>';
                                                };
                                            @endphp
                                            <a href="{{ $sortUrl('name') }}"
                                               class="inline-flex items-center gap-1 hover:text-secondary-800 dark:hover:text-neutral-200 transition-colors {{ request('sort') === 'name' ? 'text-primary dark:text-primary-400' : '' }}">
                                                Nama Tamu {!! $sortIcon('name') !!}
                                            </a>
                                        </th>
                                        <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Kategori</th>
                                        <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Acara</th>
                                        <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">No HP</th>
                                        <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                                            <a href="{{ $sortUrl('wa_status') }}"
                                               class="inline-flex items-center gap-1 hover:text-secondary-800 dark:hover:text-neutral-200 transition-colors {{ request('sort') === 'wa_status' ? 'text-primary dark:text-primary-400' : '' }}">
                                                Status WA {!! $sortIcon('wa_status') !!}
                                            </a>
                                        </th>
                                        <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Kehadiran</th>
                                        <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Link Personal</th>
                                        <th scope="col" class="px-6 py-3.5 text-right text-xs font-semibold text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-secondary-800 divide-y divide-neutral-100 dark:divide-secondary-700">
                                    @foreach($guests as $guest)
                                        @php $waStatus = $guest->wa_status; @endphp
                                        <tr class="guest-row hover:bg-neutral-50 dark:hover:bg-secondary-700/50 transition-colors cursor-pointer">
                                            <td data-label="Pilih" class="px-3 py-4 whitespace-nowrap">
                                                <input type="checkbox" name="guest_ids[]" value="{{ $guest->id }}"
                                                    aria-label="Pilih {{ $guest->name }}"
                                                    class="guest-checkbox rounded-lg border-neutral-300 dark:border-secondary-600 dark:bg-secondary-900 text-primary focus:ring-primary-500 shadow-sm"
                                                    data-has-phone="{{ ($guest->whatsapp_number ?? $guest->phone) ? '1' : '0' }}">
                                            </td>
                                            <td data-label="Nama" class="px-6 py-4 whitespace-nowrap">
                                                <span class="text-sm font-semibold text-secondary-800 dark:text-neutral-200">{{ $guest->name }}</span>
                                            </td>
                                            <td data-label="Kategori" class="px-6 py-4 whitespace-nowrap">
                                                @if($guest->guestCategory)
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                                                          style="background-color: {{ $guest->guestCategory->color_code }}20; color: {{ $guest->guestCategory->color_code }}; border: 1px solid {{ $guest->guestCategory->color_code }}40;">
                                                        {{ $guest->guestCategory->name }}
                                                    </span>
                                                @else
                                                    <span class="text-xs text-neutral-400 dark:text-neutral-500">—</span>
                                                @endif
                                            </td>
                                            <td data-label="Acara" class="px-6 py-4 whitespace-nowrap">
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
                                            <td data-label="No. WhatsApp" class="px-6 py-4 whitespace-nowrap text-sm text-neutral-500 dark:text-neutral-400 font-mono">
                                                {{ $guest->whatsapp_number ?? $guest->phone ?? '—' }}
                                            </td>
                                            <td data-label="Status WA" class="px-6 py-4 whitespace-nowrap">
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
                                            <td data-label="Kehadiran" class="px-6 py-4 whitespace-nowrap">
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
                                            <td data-label="Link Personal" class="px-6 py-4 whitespace-nowrap text-sm text-neutral-500 dark:text-neutral-400">
                                                <div class="flex items-center gap-1.5">
                                                    <input type="text" readonly value="{{ $guest->personalized_link }}"
                                                        class="text-xs border-neutral-200 dark:border-secondary-600 rounded-lg shadow-sm w-36 bg-neutral-50 dark:bg-secondary-900 dark:text-neutral-300 focus:ring-0 cursor-default"
                                                        id="link-{{ $guest->id }}">
                                                    <button type="button" onclick="copyToClipboard('link-{{ $guest->id }}')"
                                                        title="Copy" aria-label="Copy"
                                                        class="p-1.5 rounded-lg text-primary hover:bg-primary-50 dark:hover:bg-primary-900/30 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">
                                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            </td>
                                            <td data-label="Aksi" class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <div class="flex items-center justify-end gap-1.5">
                                                    @if($guest->whatsapp_number ?? $guest->phone)
                                                        <form action="{{ route('dashboard.invitations.whatsapp.send-single', [$invitation, $guest]) }}" method="POST" class="inline-block">
                                                            @csrf
                                                            <button type="submit" title="Kirim WA" aria-label="Kirim WA"
                                                                class="p-2 rounded-lg text-emerald-600 hover:bg-emerald-50 dark:hover:bg-emerald-900/30 hover:text-emerald-700 transition-colors">
                                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                                                                </svg>
                                                            </button>
                                                        </form>
                                                    @endif
                                                    <a href="{{ route('dashboard.invitations.guests.edit', [$invitation, $guest]) }}"
                                                       title="Edit" aria-label="Edit"
                                                       class="p-2 rounded-lg text-primary hover:bg-primary-50 dark:hover:bg-primary-900/30 hover:text-primary-600 transition-colors">
                                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                        </svg>
                                                    </a>
                                                    <form action="{{ route('dashboard.invitations.guests.destroy', [$invitation, $guest]) }}" method="POST" class="inline-block" onsubmit="return confirmSwal(event, 'Yakin ingin menghapus tamu ini?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" title="Hapus" aria-label="Hapus"
                                                            class="p-2 rounded-lg text-red-500 hover:bg-red-50 dark:hover:bg-red-900/30 hover:text-red-700 transition-colors">
                                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                            </svg>
                                                        </button>
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

                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
