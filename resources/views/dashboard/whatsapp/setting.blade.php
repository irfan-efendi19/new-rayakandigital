<x-app-layout>
    @php
        $status = $waSetting->status ?? 'PENDING_VERIFICATION';
        $phone  = $waSetting->phone_number ?? '';
    @endphp

    <div class="min-h-screen">

        {{-- ─── HERO ─── --}}
        <div class="hero-mesh grain-overlay border-b border-neutral-200/60 dark:border-secondary-700/40">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-7 sm:py-8">

                {{-- Breadcrumb --}}
                <nav class="flex items-center gap-1.5 text-xs text-neutral-400 dark:text-neutral-500 mb-4">
                    <a href="{{ route('dashboard') }}" class="hover:text-primary dark:hover:text-primary-400 transition-colors">Dashboard</a>
                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                    <a href="{{ route('dashboard.invitations.show', $invitation) }}" class="hover:text-primary dark:hover:text-primary-400 transition-colors truncate max-w-[150px]">{{ $invitation->title }}</a>
                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                    <span class="text-neutral-600 dark:text-neutral-400 font-medium">WA Gateway</span>
                </nav>

                <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
                    <div class="flex items-start gap-3">
                        <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center text-white shadow-lg shadow-emerald-500/20 shrink-0">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                            </svg>
                        </div>
                        <div>
                            <h1 class="font-heading text-2xl sm:text-3xl font-bold text-secondary-800 dark:text-neutral-50 leading-tight">
                                WhatsApp Gateway
                            </h1>
                            <p class="text-sm text-neutral-500 dark:text-neutral-400 mt-1">
                                Pengirim pesan untuk undangan <strong class="text-secondary-700 dark:text-neutral-300">"{{ $invitation->title }}"</strong>
                            </p>
                        </div>
                    </div>
                    <a href="{{ route('dashboard.invitations.guests.index', $invitation) }}"
                       class="inline-flex items-center gap-1.5 px-3.5 py-2 text-xs font-semibold text-secondary-700 dark:text-neutral-300 border border-neutral-300/80 dark:border-secondary-600 rounded-xl hover:bg-white dark:hover:bg-secondary-700 transition-all bg-white/70 dark:bg-secondary-800/50 backdrop-blur-sm shrink-0">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Kembali
                    </a>
                </div>

            </div>
        </div>

        {{-- ─── MAIN CONTENT ─── --}}
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-7 sm:py-8 space-y-6">

            {{-- Flash Messages --}}
            @if (session('success'))
                <div class="p-4 rounded-2xl bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-700/60 flex items-center gap-3 shadow-sm">
                    <div class="w-8 h-8 rounded-xl bg-emerald-100 dark:bg-emerald-900/40 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <span class="text-sm font-medium text-emerald-800 dark:text-emerald-300">{{ session('success') }}</span>
                </div>
            @endif

            @if (session('error'))
                <div class="p-4 rounded-2xl bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-700/60 flex items-center gap-3 shadow-sm">
                    <div class="w-8 h-8 rounded-xl bg-red-100 dark:bg-red-900/40 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4 text-red-600 dark:text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </div>
                    <span class="text-sm font-medium text-red-800 dark:text-red-300">{{ session('error') }}</span>
                </div>
            @endif

            <div x-data="waSettingManager({
                status: '{{ $status }}',
                phone: '{{ $phone }}'
            })" class="space-y-6">

                 {{-- ── STATUS BANNER ── --}}
                 @if($status === 'PENDING_VERIFICATION' && !empty($phone))
                    <div class="p-4 rounded-2xl bg-amber-50/80 dark:bg-amber-900/20 border border-amber-200/80 dark:border-amber-700/50 shadow-sm">
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-xl bg-amber-100 dark:bg-amber-900/40 flex items-center justify-center shrink-0 mt-0.5">
                                <svg class="w-4 h-4 text-amber-600 dark:text-amber-400 animate-pulse" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="font-semibold text-amber-800 dark:text-amber-300 text-sm">Nomor Sedang Ditinjau Admin</p>
                                <p class="text-amber-700 dark:text-amber-400/80 text-xs mt-0.5">Nomor WhatsApp yang kamu daftarkan masih diperiksa oleh admin. Biasanya proses ini selesai dalam 1×24 jam.</p>
                            </div>
                        </div>
                        @if(!empty($adminWa))
                            @php
                                $adminWaClean = preg_replace('/[^0-9]/', '', $adminWa);
                                if (str_starts_with($adminWaClean, '0')) {
                                    $adminWaClean = '62' . substr($adminWaClean, 1);
                                } elseif (!str_starts_with($adminWaClean, '62')) {
                                    $adminWaClean = '62' . $adminWaClean;
                                }
                            @endphp
                            <div class="mt-3 pt-3 border-t border-amber-200/60 dark:border-amber-700/30">
                                <a href="https://wa.me/{{ $adminWaClean }}?text={{ urlencode('Halo Admin Rayakan Digital, saya sudah mengajukan nomor WhatsApp pengirim untuk undangan "'.$invitation->title.'". Mohon bantuannya untuk diverifikasi. Terima kasih.') }}"
                                   target="_blank" rel="noopener"
                                   class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold transition-all shadow-sm shadow-emerald-500/20 hover:shadow-md hover:shadow-emerald-500/30 active:translate-y-0">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                                    Hubungi Admin via WhatsApp
                                </a>
                            </div>
                        @endif
                    </div>
                @elseif($status === 'REJECTED')
                    <div class="p-4 rounded-2xl bg-red-50/80 dark:bg-red-900/20 border border-red-200/80 dark:border-red-700/50 flex items-start gap-3 shadow-sm">
                        <div class="w-8 h-8 rounded-xl bg-red-100 dark:bg-red-900/40 flex items-center justify-center shrink-0 mt-0.5">
                            <svg class="w-4 h-4 text-red-600 dark:text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </div>
                        <div>
                            <p class="font-semibold text-red-800 dark:text-red-300 text-sm">Nomor Ditolak</p>
                            @if($waSetting->admin_notes)
                                <p class="text-red-700 dark:text-red-400/80 text-xs mt-0.5">Alasan: {{ $waSetting->admin_notes }}</p>
                            @endif
                            <p class="text-red-600 dark:text-red-400 text-xs mt-1">Ganti nomor di bawah lalu ajukan ulang.</p>
                        </div>
                    </div>
                @elseif($status === 'READY_TO_PAIR')
                    <div class="p-4 rounded-2xl bg-blue-50/80 dark:bg-blue-900/20 border border-blue-200/80 dark:border-blue-700/50 flex items-start gap-3 shadow-sm">
                        <div class="w-8 h-8 rounded-xl bg-blue-100 dark:bg-blue-900/40 flex items-center justify-center shrink-0 mt-0.5">
                            <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="font-semibold text-blue-800 dark:text-blue-300 text-sm">Nomor Disetujui — Siap Dihubungkan!</p>
                            <p class="text-blue-700 dark:text-blue-400/80 text-xs mt-0.5">Nomormu sudah disetujui admin. Gulir ke bawah, klik <strong>"Tampilkan QR Code"</strong> lalu pindai dengan WhatsApp.</p>
                        </div>
                    </div>
                @elseif($status === 'CONNECTED')
                    <div class="p-4 rounded-2xl bg-emerald-50/80 dark:bg-emerald-900/20 border border-emerald-200/80 dark:border-emerald-700/50 flex items-start gap-3 shadow-sm">
                        <div class="w-8 h-8 rounded-xl bg-emerald-100 dark:bg-emerald-900/40 flex items-center justify-center shrink-0 mt-0.5">
                            <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <div>
                            <p class="font-semibold text-emerald-800 dark:text-emerald-300 text-sm">WhatsApp Sudah Terhubung</p>
                            <p class="text-emerald-700 dark:text-emerald-400/80 text-xs mt-0.5">
                                Nomor <strong>{{ $waSetting->phone_number ? '+'.ltrim($waSetting->phone_number, '+') : '-' }}</strong> sudah aktif dan bisa dipakai kirim undangan ke tamu.
                            </p>
                        </div>
                    </div>
                @endif

                {{-- ── KUOTA WA BLAST ── --}}
                @php
                    $hasWaQuota = $invitation->hasWaQuotaLimit();
                    $waQuotaLimit = $invitation->waQuotaLimit();
                    $waSent = $invitation->waSentCount();
                    $waRemaining = $invitation->remainingWaQuota();
                    $waUsedPct = $waQuotaLimit > 0 ? min(100, round(($waSent / $waQuotaLimit) * 100)) : 0;
                @endphp
                <div class="bg-white/80 dark:bg-secondary-800/80 backdrop-blur-xl rounded-2xl p-6 border border-neutral-200/80 dark:border-secondary-700/80 shadow-sm">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-primary-100 dark:bg-primary-900/40 text-primary dark:text-primary-400 flex items-center justify-center shrink-0">
                            <svg class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-sm font-bold text-secondary-800 dark:text-neutral-100">Kuota WA Blast</h2>
                            <p class="text-[11px] text-neutral-500 dark:text-neutral-400">
                                @if($hasWaQuota)
                                    {{ $waSent }} dari {{ $waQuotaLimit }} pesan telah dipakai untuk undangan ini.
                                @else
                                    Kuota WA Blast undangan ini tidak terbatas.
                                @endif
                            </p>
                        </div>
                    </div>
                    @if($hasWaQuota)
                        <div class="mt-4">
                            <div class="h-2.5 rounded-full bg-neutral-200 dark:bg-secondary-700 overflow-hidden">
                                <div class="h-full rounded-full transition-all {{ $waRemaining <= 0 ? 'bg-red-500' : ($waRemaining <= 5 ? 'bg-amber-500' : 'bg-emerald-500') }}" style="width: {{ $waUsedPct }}%"></div>
                            </div>
                            <div class="mt-2 flex items-center justify-between text-xs">
                                <span class="font-semibold {{ $waRemaining <= 0 ? 'text-red-600 dark:text-red-400' : 'text-emerald-600 dark:text-emerald-400' }}">
                                    @if($waRemaining <= 0)
                                        Kuota Habis — Hubungi Admin untuk menambah kuota.
                                    @else
                                        Sisa kuota: {{ $waRemaining }} pesan
                                    @endif
                                </span>
                                <span class="text-neutral-400 dark:text-neutral-500 tabular-nums">{{ $waUsedPct }}%</span>
                            </div>
                        </div>
                    @endif
                </div>

                {{-- ── ALUR PROSES ── --}}
                <div class="bg-white/80 dark:bg-secondary-800/80 backdrop-blur-xl rounded-2xl p-6 border border-neutral-200/80 dark:border-secondary-700/80 shadow-sm">
                    <h2 class="text-xs font-bold text-neutral-400 dark:text-neutral-500 uppercase tracking-widest mb-5">Panduan Aktivasi</h2>
                    @php
                        $steps = [
                            ['label' => 'Masukkan Nomor WA',     'icon' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z', 'statuses' => ['PENDING_VERIFICATION','READY_TO_PAIR','PAIRING','CONNECTED','REJECTED']],
                            ['label' => 'Tunggu Konfirmasi Admin',  'icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z', 'statuses' => ['READY_TO_PAIR','PAIRING','CONNECTED']],
                            ['label' => 'Pindai QR',           'icon' => 'M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z', 'statuses' => ['PAIRING','CONNECTED']],
                            ['label' => 'Siap Digunakan',           'icon' => 'M5 13l4 4L19 7', 'statuses' => ['CONNECTED']],
                        ];
                        $totalSteps = count($steps);
                    @endphp

                    {{-- Mobile: vertical --}}
                    <div class="sm:hidden space-y-0">
                        @foreach($steps as $i => $step)
                            @php $active = in_array($status, $step['statuses']); @endphp
                            <div class="flex items-start gap-3">
                                <div class="flex flex-col items-center">
                                    <div class="w-9 h-9 rounded-full flex items-center justify-center border-2 transition-all shrink-0
                                        {{ $active
                                            ? 'bg-primary border-primary text-white shadow-md shadow-primary/20'
                                            : 'border-neutral-200 dark:border-secondary-600 text-neutral-300 dark:text-neutral-600' }}">
                                        @if($active && $status === 'CONNECTED' && $i === $totalSteps - 1)
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $step['icon'] }}" /></svg>
                                        @else
                                            <span class="text-xs font-bold">{{ $i + 1 }}</span>
                                        @endif
                                    </div>
                                    @if(!$loop->last)
                                        <div class="w-0.5 h-6 {{ $active ? 'bg-primary/40' : 'bg-neutral-200 dark:bg-secondary-600' }}"></div>
                                    @endif
                                </div>
                                <p class="text-xs font-semibold pt-2 {{ $active ? 'text-primary dark:text-primary-400' : 'text-neutral-400 dark:text-neutral-500' }}">
                                    {{ $step['label'] }}
                                </p>
                            </div>
                        @endforeach
                    </div>

                    {{-- Desktop: horizontal --}}
                    <div class="hidden sm:flex items-start">
                        @foreach($steps as $i => $step)
                            @php $active = in_array($status, $step['statuses']); @endphp
                            <div class="flex-1 flex flex-col items-center text-center {{ $i < $totalSteps - 1 ? 'pr-2' : '' }}">
                                <div class="flex items-center w-full">
                                    {{-- Left connector --}}
                                    @if($i > 0)
                                        <div class="flex-1 h-0.5 {{ $active ? 'bg-primary/40' : 'bg-neutral-200 dark:bg-secondary-600' }}"></div>
                                    @else
                                        <div class="flex-1"></div>
                                    @endif

                                    {{-- Circle --}}
                                    <div class="w-9 h-9 rounded-full flex items-center justify-center border-2 transition-all shrink-0
                                        {{ $active
                                            ? 'bg-primary border-primary text-white shadow-md shadow-primary/20'
                                            : 'border-neutral-200 dark:border-secondary-600 text-neutral-300 dark:text-neutral-600' }}">
                                        @if($active && $status === 'CONNECTED' && $i === $totalSteps - 1)
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $step['icon'] }}" /></svg>
                                        @else
                                            <span class="text-xs font-bold">{{ $i + 1 }}</span>
                                        @endif
                                    </div>

                                    {{-- Right connector --}}
                                    @if($i < $totalSteps - 1)
                                        <div class="flex-1 h-0.5 {{ $active ? 'bg-primary/40' : 'bg-neutral-200 dark:bg-secondary-600' }}"></div>
                                    @else
                                        <div class="flex-1"></div>
                                    @endif
                                </div>
                                <p class="text-[11px] font-semibold mt-2.5 {{ $active ? 'text-primary dark:text-primary-400' : 'text-neutral-400 dark:text-neutral-500' }}">
                                    {{ $step['label'] }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- ── STEP 1: INPUT NOMOR HP ── --}}
                <div class="bg-white/80 dark:bg-secondary-800/80 backdrop-blur-xl rounded-2xl border border-neutral-200/80 dark:border-secondary-700/80 shadow-sm overflow-hidden">
                    {{-- Header --}}
                    <div class="px-6 py-4 border-b border-neutral-100 dark:border-secondary-700/60 flex items-center gap-3">
                        <span class="w-7 h-7 rounded-lg bg-primary-100 dark:bg-primary-900/50 text-primary dark:text-primary-400 text-xs font-extrabold flex items-center justify-center">1</span>
                        <div>
                            <h2 class="text-sm font-bold text-secondary-800 dark:text-neutral-100">Nomor WhatsApp Pengirim</h2>
                            <p class="text-[11px] text-neutral-500 dark:text-neutral-400">Nomor ini yang akan dipakai untuk kirim pesen ke tamu undangan</p>
                        </div>
                    </div>

                    {{-- Body --}}
                    <div class="px-6 py-5">
                        <form method="POST" action="{{ route('dashboard.whatsapp.setting.update-phone', $invitation) }}" class="space-y-4">
                            @csrf
                            <div>
                                    <label for="phone_number" class="block text-xs font-semibold text-neutral-600 dark:text-neutral-400 mb-2">
                                        Nomor WhatsApp Kamu <span class="text-red-500">*</span>
                                    </label>
                                <div class="flex gap-2">
                                    <div class="flex items-center px-3.5 rounded-xl border border-neutral-200 dark:border-secondary-600 bg-neutral-50 dark:bg-secondary-900/50 text-neutral-500 dark:text-neutral-400 text-sm font-mono select-none shrink-0">
                                        62
                                    </div>
                                    <input type="text" id="phone_number" name="phone_number"
                                           value="{{ old('phone_number', $waSetting->phone_number) }}"
                                           placeholder="81234567890"
                                           required
                                           class="flex-1 min-w-0 px-4 py-2.5 rounded-xl border border-neutral-200 dark:border-secondary-600 bg-white dark:bg-secondary-900 text-neutral-800 dark:text-neutral-100 text-sm focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all font-mono placeholder:text-neutral-300 dark:placeholder:text-neutral-600" />
                                </div>
                                <p class="text-[11px] text-neutral-400 dark:text-neutral-500 mt-2 leading-relaxed">
                                    Bisa pakai format: <code class="bg-neutral-100 dark:bg-secondary-700/80 px-1.5 py-0.5 rounded-md text-[10px]">0812xxx</code>,
                                    <code class="bg-neutral-100 dark:bg-secondary-700/80 px-1.5 py-0.5 rounded-md text-[10px]">812xxx</code>, atau
                                    <code class="bg-neutral-100 dark:bg-secondary-700/80 px-1.5 py-0.5 rounded-md text-[10px]">62812xxx</code>
                                    — nanti dibenerin otomatis.
                                </p>
                                @error('phone_number')
                                    <p class="text-xs text-red-500 dark:text-red-400 mt-2 flex items-center gap-1.5">
                                        <svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                            <div class="flex justify-end pt-1">
                                <button type="submit" id="btn-simpan-nomor"
                                        class="px-5 py-2.5 rounded-xl bg-primary hover:bg-primary-600 text-white font-semibold text-sm transition-all shadow-sm hover:shadow-md hover:shadow-primary/20 active:translate-y-0">
                                        Simpan & Minta Persetujuan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- ── STEP 2: QR CODE ── --}}
                @if(in_array($status, ['READY_TO_PAIR', 'PAIRING', 'CONNECTED']))
                    <div class="bg-white/80 dark:bg-secondary-800/80 backdrop-blur-xl rounded-2xl border border-neutral-200/80 dark:border-secondary-700/80 shadow-sm overflow-hidden">
                        {{-- Header --}}
                        <div class="px-6 py-4 border-b border-neutral-100 dark:border-secondary-700/60 flex items-center gap-3">
                            <span class="w-7 h-7 rounded-lg bg-primary-100 dark:bg-primary-900/50 text-primary dark:text-primary-400 text-xs font-extrabold flex items-center justify-center">2</span>
                            <div>
                                <h2 class="text-sm font-bold text-secondary-800 dark:text-neutral-100">Hubungkan WhatsApp</h2>
                                <p class="text-[11px] text-neutral-500 dark:text-neutral-400">Tampilkan QR lalu pindai pakai WhatsApp kamu</p>
                            </div>
                        </div>

                        {{-- Body --}}
                        <div class="px-6 py-6">
                            <div class="flex flex-col items-center text-center gap-5">
                                @if($status === 'CONNECTED')
                                    {{-- Connected State --}}
                                    <div class="w-20 h-20 rounded-full bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center">
                                        <svg class="w-10 h-10 text-emerald-500 dark:text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-emerald-700 dark:text-emerald-400 text-sm">WhatsApp Sudah Terhubung!</p>
                                        <p class="text-neutral-500 dark:text-neutral-400 text-xs mt-1">Nomormu sudah aktif dan siap kirim undangan ke tamu.</p>
                                    </div>
                                    <button @click="checkStatus()" :disabled="loadingStatus"
                                            class="inline-flex items-center gap-2 px-4 py-2 rounded-xl border border-neutral-200 dark:border-secondary-600 text-sm font-medium text-neutral-600 dark:text-neutral-300 hover:bg-neutral-50 dark:hover:bg-secondary-700/50 transition-colors disabled:opacity-50">
                                        <svg class="w-4 h-4" :class="{'animate-spin': loadingStatus}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                        </svg>
                                        Cek Ulang Status
                                    </button>

                                @else
                                    {{-- Not Connected: Show QR Button --}}
                                    <template x-if="!qrUrl && !loadingQr">
                                        <div class="space-y-4">
                                            <div class="w-20 h-20 rounded-full bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center">
                                                <svg class="w-10 h-10 text-emerald-500 dark:text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="font-semibold text-secondary-800 dark:text-neutral-100 text-sm">Siap Memindai?</p>
                                                <p class="text-neutral-500 dark:text-neutral-400 text-xs mt-1 max-w-xs mx-auto">
                                                    Klik tombol di bawah untuk generate QR Code, lalu buka WhatsApp → Perangkat Tertaut → Tautkan Perangkat.
                                                </p>
                                            </div>
                                            <button @click="connectWa()" id="btn-tampilkan-qr"
                                                    class="px-8 py-3 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white font-bold text-sm transition-all shadow-lg shadow-emerald-500/25 hover:shadow-xl hover:shadow-emerald-500/30 hover:-translate-y-0.5 active:translate-y-0 flex items-center gap-2.5">
                                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                                                </svg>
                                                Tampilkan QR Code
                                            </button>
                                        </div>
                                    </template>

                                    {{-- Loading QR --}}
                                    <template x-if="loadingQr">
                                        <div class="py-10 flex flex-col items-center gap-4">
                                            <div class="relative">
                                                <div class="w-12 h-12 border-4 border-emerald-200 dark:border-emerald-800 rounded-full"></div>
                                                <div class="w-12 h-12 border-4 border-emerald-500 border-t-transparent rounded-full animate-spin absolute inset-0"></div>
                                            </div>
                                            <div class="text-center">
                                                <p class="text-sm font-medium text-secondary-800 dark:text-neutral-200">Meminta QR Code...</p>
                                                <p class="text-xs text-neutral-400 dark:text-neutral-500 mt-1">Menghubungkan ke server Fonnte</p>
                                            </div>
                                        </div>
                                    </template>

                                    {{-- QR Code Displayed --}}
                                    <template x-if="qrUrl">
                                        <div class="space-y-5 flex flex-col items-center">
                                            <div class="relative">
                                                <div class="p-4 bg-white rounded-2xl border-2 border-emerald-200 dark:border-emerald-700/50 shadow-xl shadow-emerald-500/10">
                                                    <img :src="qrUrl" alt="WhatsApp QR Code" class="w-56 h-56 sm:w-64 sm:h-64 object-contain" />
                                                </div>
                                                <div class="absolute -top-2 -right-2 w-6 h-6 rounded-full bg-emerald-500 flex items-center justify-center shadow-md">
                                                    <svg class="w-3 h-3 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                                    </svg>
                                                </div>
                                            </div>

                                            <div class="p-3.5 rounded-xl bg-amber-50 dark:bg-amber-900/20 border border-amber-200/80 dark:border-amber-700/50 max-w-sm">
                                                <div class="flex items-start gap-2.5">
                                                    <svg class="w-4 h-4 text-amber-500 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                    <p class="text-xs text-amber-800 dark:text-amber-300 leading-relaxed">
                                                        Buka <strong>WhatsApp</strong> → <strong>Perangkat Tertaut</strong> → <strong>Tautkan Perangkat</strong> → Scan QR di atas. Status akan otomatis terupdate.
                                                    </p>
                                                </div>
                                            </div>

                                            <button @click="connectWa()"
                                                    class="inline-flex items-center gap-2 px-4 py-2 rounded-xl border border-neutral-200 dark:border-secondary-600 text-xs font-semibold text-neutral-600 dark:text-neutral-300 hover:bg-neutral-50 dark:hover:bg-secondary-700/50 transition-colors">
                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                                </svg>
                                                Generate Ulang QR Code
                                            </button>
                                        </div>
                                    </template>

                                    {{-- QR Error --}}
                                    <template x-if="qrError">
                                        <div class="w-full max-w-sm p-4 rounded-xl bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-700/50">
                                            <div class="flex items-start gap-2.5">
                                                <svg class="w-4 h-4 text-red-500 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                                </svg>
                                                <div>
                                                    <p class="text-xs font-semibold text-red-800 dark:text-red-300">Gagal Memuat QR Code</p>
                                                    <p class="text-xs text-red-600 dark:text-red-400/80 mt-1" x-text="qrError"></p>
                                                    <button @click="qrError = null; connectWa()"
                                                            class="mt-2 text-xs font-semibold text-red-700 dark:text-red-400 underline underline-offset-2 hover:no-underline">
                                                        Coba Lagi
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif

                {{-- ── DISCONNECT ── --}}
                @if(in_array($status, ['CONNECTED', 'PAIRING', 'READY_TO_PAIR']))
                    <div class="flex justify-end">
                        <form method="POST" action="{{ route('dashboard.whatsapp.setting.disconnect', $invitation) }}"
                              onsubmit="return confirm('Yakin ingin memutus koneksi WhatsApp? Anda perlu melakukan pairing ulang.');">
                            @csrf
                            <button type="submit"
                                    class="inline-flex items-center gap-2 px-4 py-2 rounded-xl border border-red-200 dark:border-red-800/50 text-red-600 dark:text-red-400 text-xs font-semibold hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                                </svg>
                                Putuskan Koneksi
                            </button>
                        </form>
                    </div>
                @endif

            </div>
        </div>
    </div>

    {{-- Alpine Script --}}
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('waSettingManager', (config) => ({
                status: config.status || 'PENDING_VERIFICATION',
                phone: config.phone || '',
                loadingStatus: false,
                loadingQr: false,
                qrUrl: null,
                qrError: null,
                pollTimer: null,

                init() {
                    if (['PAIRING', 'READY_TO_PAIR'].includes(this.status)) {
                        this.checkStatus();
                    }
                },

                async checkStatus() {
                    this.loadingStatus = true;
                    try {
                        const res = await fetch("{{ route('dashboard.whatsapp.setting.check-status', $invitation) }}");
                        const data = await res.json();
                        this.status = data.status || this.status;
                        if (data.phone_number) {
                            this.phone = data.phone_number;
                        }
                        if (this.status === 'CONNECTED') {
                            this.qrUrl = null;
                            if (this.pollTimer) clearInterval(this.pollTimer);
                            window.location.reload();
                        }
                    } catch (e) {
                        console.error('Status check error:', e);
                    } finally {
                        this.loadingStatus = false;
                    }
                },

                async connectWa() {
                    this.loadingQr = true;
                    this.qrError = null;
                    try {
                        const res = await fetch("{{ route('dashboard.whatsapp.setting.get-qr', $invitation) }}", {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json',
                                'Content-Type': 'application/json',
                            },
                        });
                        const data = await res.json();
                        if (data.success && data.url) {
                            let url = data.url;
                            if (url && !url.startsWith('http') && !url.startsWith('data:image')) {
                                url = 'data:image/png;base64,' + url;
                            }
                            this.qrUrl = url;
                            this.status = 'PAIRING';
                            this.startPolling();
                        } else {
                            this.qrError = data.message || 'Gagal mendapatkan QR Code dari Fonnte.';
                        }
                    } catch (e) {
                        this.qrError = 'Terjadi kesalahan jaringan saat meminta QR Code.';
                    } finally {
                        this.loadingQr = false;
                    }
                },

                startPolling() {
                    if (this.pollTimer) clearInterval(this.pollTimer);
                    this.pollTimer = setInterval(async () => {
                        await this.checkStatus();
                    }, 4000);
                },
            }));
        });
    </script>
</x-app-layout>
