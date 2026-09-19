<x-app-layout>
    @php
        $status = $waSetting->status ?? 'PENDING_VERIFICATION';
        $phone = $waSetting->phone_number ?? '';
        $phoneInput = old('phone_number', str_starts_with($phone, '62') ? substr($phone, 2) : $phone);
        $phoneDisplay = $phone ? '+'.ltrim($phone, '+') : 'Belum ditambahkan';

        $statusMeta = match ($status) {
            'CONNECTED' => [
                'label' => 'Terhubung', 'eyebrow' => 'Gateway aktif',
                'title' => 'WhatsApp siap mengirim undangan',
                'description' => 'Nomor pengirim sudah terhubung dan dapat digunakan dari daftar tamu.',
                'badge' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300',
                'panel' => 'border-emerald-200/80 bg-emerald-50/70 dark:border-emerald-800/60 dark:bg-emerald-950/20',
                'icon' => 'bg-emerald-500 text-white shadow-emerald-500/25',
            ],
            'READY_TO_PAIR' => [
                'label' => 'Siap dipasangkan', 'eyebrow' => 'Nomor disetujui',
                'title' => 'Satu langkah lagi untuk terhubung',
                'description' => 'Tampilkan QR Code lalu pindai melalui menu Perangkat Tertaut di WhatsApp.',
                'badge' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-300',
                'panel' => 'border-blue-200/80 bg-blue-50/70 dark:border-blue-800/60 dark:bg-blue-950/20',
                'icon' => 'bg-blue-500 text-white shadow-blue-500/25',
            ],
            'PAIRING' => [
                'label' => 'Menunggu pemindaian', 'eyebrow' => 'Proses pairing',
                'title' => 'Pindai QR Code dari WhatsApp',
                'description' => 'Biarkan halaman ini terbuka. Status akan diperbarui otomatis setelah QR dipindai.',
                'badge' => 'bg-violet-100 text-violet-700 dark:bg-violet-900/40 dark:text-violet-300',
                'panel' => 'border-violet-200/80 bg-violet-50/70 dark:border-violet-800/60 dark:bg-violet-950/20',
                'icon' => 'bg-violet-500 text-white shadow-violet-500/25',
            ],
            'REJECTED' => [
                'label' => 'Perlu diperbaiki', 'eyebrow' => 'Pengajuan ditolak',
                'title' => 'Periksa kembali nomor WhatsApp',
                'description' => 'Perbarui nomor pengirim sesuai catatan admin, lalu kirim ulang pengajuan.',
                'badge' => 'bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-300',
                'panel' => 'border-red-200/80 bg-red-50/70 dark:border-red-800/60 dark:bg-red-950/20',
                'icon' => 'bg-red-500 text-white shadow-red-500/25',
            ],
            default => [
                'label' => empty($phone) ? 'Belum diatur' : 'Menunggu verifikasi',
                'eyebrow' => empty($phone) ? 'Mulai aktivasi' : 'Sedang ditinjau admin',
                'title' => empty($phone) ? 'Hubungkan nomor WhatsApp Anda' : 'Pengajuan sedang diperiksa',
                'description' => empty($phone)
                    ? 'Tambahkan nomor yang akan digunakan untuk mengirim pesan kepada tamu.'
                    : 'Kami akan memberi akses pairing setelah nomor pengirim disetujui.',
                'badge' => 'bg-amber-100 text-amber-700 dark:bg-amber-900/40 dark:text-amber-300',
                'panel' => 'border-amber-200/80 bg-amber-50/70 dark:border-amber-800/60 dark:bg-amber-950/20',
                'icon' => 'bg-amber-500 text-white shadow-amber-500/25',
            ],
        };

        $hasWaQuota = $invitation->hasWaQuotaLimit();
        $waQuotaLimit = $invitation->waQuotaLimit();
        $waSent = $invitation->waSentCount();
        $waRemaining = $invitation->remainingWaQuota();
        $waUsedPct = $waQuotaLimit > 0 ? min(100, round(($waSent / $waQuotaLimit) * 100)) : 0;

        $currentStep = match ($status) {
            'CONNECTED' => 4,
            'PAIRING', 'READY_TO_PAIR' => 3,
            'PENDING_VERIFICATION' => empty($phone) ? 1 : 2,
            default => 1,
        };

        $steps = [
            ['title' => 'Nomor pengirim', 'description' => 'Tambahkan nomor aktif'],
            ['title' => 'Verifikasi admin', 'description' => 'Tunggu persetujuan'],
            ['title' => 'Pindai QR', 'description' => 'Tautkan perangkat'],
            ['title' => 'Siap kirim', 'description' => 'Gateway aktif'],
        ];

        $adminWaClean = preg_replace('/[^0-9]/', '', $adminWa ?? '');
        if ($adminWaClean && str_starts_with($adminWaClean, '0')) {
            $adminWaClean = '62'.substr($adminWaClean, 1);
        } elseif ($adminWaClean && ! str_starts_with($adminWaClean, '62')) {
            $adminWaClean = '62'.$adminWaClean;
        }
    @endphp

    <div class="min-h-screen bg-neutral-50/70 dark:bg-secondary-900" x-data="{ showServiceInfo: false }">
        <header class="relative overflow-hidden border-b border-neutral-200/80 bg-white dark:border-secondary-700 dark:bg-secondary-900">
            <div class="absolute inset-0 bg-gradient-to-br from-emerald-50 via-white to-primary-50/50 dark:from-emerald-950/20 dark:via-secondary-900 dark:to-primary-900/10"></div>
            <div class="absolute -right-16 -top-24 h-72 w-72 rounded-full bg-emerald-200/30 blur-3xl dark:bg-emerald-800/10"></div>

            <div class="relative mx-auto max-w-7xl px-4 py-7 sm:px-6 sm:py-9 lg:px-8">
                <nav aria-label="Breadcrumb" class="flex items-center gap-2 text-xs text-neutral-500 dark:text-neutral-400">
                    <a href="{{ route('dashboard') }}" class="transition-colors hover:text-primary dark:hover:text-primary-400">Dashboard</a>
                    <svg class="h-3 w-3 text-neutral-300 dark:text-secondary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="m9 5 7 7-7 7" /></svg>
                    <a href="{{ route('dashboard.invitations.show', $invitation) }}" class="max-w-[160px] truncate transition-colors hover:text-primary dark:hover:text-primary-400 sm:max-w-xs">{{ $invitation->title }}</a>
                    <svg class="h-3 w-3 text-neutral-300 dark:text-secondary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="m9 5 7 7-7 7" /></svg>
                    <span class="font-semibold text-secondary-700 dark:text-neutral-200">WhatsApp</span>
                </nav>

                <div class="mt-5 flex flex-col gap-5 sm:flex-row sm:items-end sm:justify-between">
                    <div class="flex items-start gap-4">
                        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-600 text-white shadow-lg shadow-emerald-500/20">
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs font-bold uppercase tracking-[0.2em] text-emerald-600 dark:text-emerald-400">Integrasi pesan</p>
                            <h1 class="mt-1 font-heading text-2xl font-bold text-secondary-900 dark:text-white sm:text-3xl">WhatsApp Gateway</h1>
                            <p class="mt-1.5 max-w-2xl text-sm leading-6 text-neutral-500 dark:text-neutral-400">Kelola nomor pengirim untuk <span class="font-semibold text-secondary-700 dark:text-neutral-200">{{ $invitation->title }}</span>.</p>
                        </div>
                    </div>

                    <div class="flex flex-wrap items-center gap-2">
                        <button type="button" @click="showServiceInfo = true" class="inline-flex items-center gap-2 rounded-xl border border-neutral-200 bg-white/80 px-3.5 py-2 text-xs font-semibold text-neutral-600 shadow-sm transition hover:border-emerald-200 hover:text-emerald-700 dark:border-secondary-700 dark:bg-secondary-800/80 dark:text-neutral-300 dark:hover:border-emerald-800 dark:hover:text-emerald-400">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
                            Tentang layanan
                        </button>
                        <a href="{{ route('dashboard.invitations.guests.index', $invitation) }}" class="inline-flex items-center gap-2 rounded-xl border border-neutral-200 bg-white/80 px-3.5 py-2 text-xs font-semibold text-secondary-700 shadow-sm transition hover:bg-white dark:border-secondary-700 dark:bg-secondary-800/80 dark:text-neutral-200 dark:hover:bg-secondary-800">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m10 19-7-7m0 0 7-7m-7 7h18" /></svg>
                            Daftar tamu
                        </a>
                    </div>
                </div>
            </div>
        </header>

        <main class="mx-auto max-w-7xl px-4 py-6 sm:px-6 sm:py-8 lg:px-8">
            @if (session('success') || session('error'))
                @php $flashSuccess = session('success'); @endphp
                <div role="status" class="mb-6 flex items-start gap-3 rounded-2xl border p-4 {{ $flashSuccess ? 'border-emerald-200 bg-emerald-50 text-emerald-800 dark:border-emerald-800/60 dark:bg-emerald-950/30 dark:text-emerald-300' : 'border-red-200 bg-red-50 text-red-800 dark:border-red-800/60 dark:bg-red-950/30 dark:text-red-300' }}">
                    <svg class="mt-0.5 h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        @if($flashSuccess)<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="m5 13 4 4L19 7" />@else<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />@endif
                    </svg>
                    <p class="text-sm font-medium">{{ $flashSuccess ?: session('error') }}</p>
                </div>
            @endif

            <div x-data="waSettingManager({ status: {{ Js::from($status) }}, phone: {{ Js::from($phone) }} })" class="grid gap-6 lg:grid-cols-12 lg:items-start">
                <div class="space-y-6 lg:col-span-8">
                    <section class="overflow-hidden rounded-3xl border shadow-sm {{ $statusMeta['panel'] }}">
                        <div class="p-5 sm:p-6">
                            <div class="flex flex-col gap-5 sm:flex-row sm:items-start sm:justify-between">
                                <div class="flex items-start gap-4">
                                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl shadow-lg {{ $statusMeta['icon'] }}">
                                        @if($status === 'CONNECTED')
                                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="m5 13 4 4L19 7" /></svg>
                                        @elseif($status === 'READY_TO_PAIR' || $status === 'PAIRING')
                                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.75 4.5h4.5v4.5h-4.5V4.5Zm0 10.5h4.5v4.5h-4.5V15Zm12-10.5h4.5v4.5h-4.5V4.5ZM15 15h1.5v1.5H15V15Zm3 0h2.25v5.25H15V18h3v-3Zm-6-10.5h1.5V9H12V4.5Zm0 6h4.5V12H15v3h-3v-4.5Zm6 0h2.25V13H18v-2.5ZM9.75 12h1.5v8.25h-1.5V12Zm3 4.5h1.5v3.75h-1.5V16.5Z" /></svg>
                                        @elseif($status === 'REJECTED')
                                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 18 6M6 6l12 12" /></svg>
                                        @else
                                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6l4 2m5-2a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="flex flex-wrap items-center gap-2">
                                            <p class="text-xs font-bold uppercase tracking-[0.16em] text-neutral-500 dark:text-neutral-400">{{ $statusMeta['eyebrow'] }}</p>
                                            <span class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-[11px] font-bold {{ $statusMeta['badge'] }}"><span class="h-1.5 w-1.5 rounded-full bg-current"></span>{{ $statusMeta['label'] }}</span>
                                        </div>
                                        <h2 class="mt-2 text-lg font-bold text-secondary-900 dark:text-white sm:text-xl">{{ $statusMeta['title'] }}</h2>
                                        <p class="mt-1 max-w-xl text-sm leading-6 text-neutral-600 dark:text-neutral-300">{{ $statusMeta['description'] }}</p>
                                    </div>
                                </div>

                                @if(in_array($status, ['READY_TO_PAIR', 'PAIRING', 'CONNECTED']))
                                    <button type="button" @click="checkStatus()" :disabled="loadingStatus" class="inline-flex shrink-0 items-center justify-center gap-2 rounded-xl border border-white/80 bg-white/70 px-3.5 py-2 text-xs font-semibold text-neutral-700 shadow-sm transition hover:bg-white disabled:cursor-wait disabled:opacity-60 dark:border-secondary-700 dark:bg-secondary-800/80 dark:text-neutral-200 dark:hover:bg-secondary-800">
                                        <svg class="h-4 w-4" :class="{ 'animate-spin': loadingStatus }" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 0 0 4.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 0 1-15.357-2m15.357 2H15" /></svg>
                                        <span x-text="loadingStatus ? 'Memeriksa...' : 'Periksa status'"></span>
                                    </button>
                                @endif
                            </div>

                            <div class="mt-5 grid gap-3 border-t border-black/5 pt-5 dark:border-white/10 sm:grid-cols-2">
                                <div class="rounded-2xl bg-white/60 px-4 py-3 dark:bg-secondary-900/40">
                                    <p class="text-[11px] font-semibold uppercase tracking-wider text-neutral-400 dark:text-neutral-500">Nomor pengirim</p>
                                    <p class="mt-1 font-mono text-sm font-bold text-secondary-800 dark:text-neutral-100" x-text="phone ? '+' + phone.replace(/^\+/, '') : 'Belum ditambahkan'">{{ $phoneDisplay }}</p>
                                </div>
                                <div class="rounded-2xl bg-white/60 px-4 py-3 dark:bg-secondary-900/40">
                                    <p class="text-[11px] font-semibold uppercase tracking-wider text-neutral-400 dark:text-neutral-500">Undangan</p>
                                    <p class="mt-1 truncate text-sm font-bold text-secondary-800 dark:text-neutral-100">{{ $invitation->title }}</p>
                                </div>
                            </div>

                            @if($status === 'REJECTED' && $waSetting->admin_notes)
                                <div class="mt-4 rounded-2xl border border-red-200/80 bg-white/60 p-4 text-sm text-red-700 dark:border-red-800/50 dark:bg-secondary-900/40 dark:text-red-300"><span class="font-bold">Catatan admin:</span> {{ $waSetting->admin_notes }}</div>
                            @endif
                        </div>
                    </section>

                    <section aria-labelledby="activation-heading" class="rounded-3xl border border-neutral-200 bg-white p-5 shadow-sm dark:border-secondary-700 dark:bg-secondary-800 sm:p-6">
                        <div class="flex items-center justify-between gap-4">
                            <div><p class="text-xs font-bold uppercase tracking-[0.18em] text-primary dark:text-primary-400">Progres aktivasi</p><h2 id="activation-heading" class="mt-1 text-lg font-bold text-secondary-900 dark:text-white">Empat langkah hingga siap kirim</h2></div>
                            <span class="rounded-full bg-neutral-100 px-3 py-1 text-xs font-bold text-neutral-500 dark:bg-secondary-700 dark:text-neutral-300">{{ min($currentStep, 4) }}/4</span>
                        </div>
                        <ol class="mt-6 grid grid-cols-2 gap-3 sm:grid-cols-4">
                            @foreach($steps as $index => $step)
                                @php
                                    $stepNumber = $index + 1;
                                    $stepDone = $status === 'CONNECTED' || $stepNumber < $currentStep;
                                    $stepActive = $stepNumber === $currentStep && $status !== 'CONNECTED';
                                @endphp
                                <li class="relative rounded-2xl border p-3.5 {{ $stepActive ? 'border-primary-300 bg-primary-50 dark:border-primary-700/70 dark:bg-primary-900/25' : ($stepDone ? 'border-emerald-200 bg-emerald-50/60 dark:border-emerald-800/50 dark:bg-emerald-950/20' : 'border-neutral-200 bg-neutral-50 dark:border-secondary-700 dark:bg-secondary-900/50') }}">
                                    <div class="flex h-7 w-7 items-center justify-center rounded-lg text-xs font-extrabold {{ $stepActive ? 'bg-primary text-white' : ($stepDone ? 'bg-emerald-500 text-white' : 'bg-neutral-200 text-neutral-500 dark:bg-secondary-700 dark:text-neutral-400') }}">
                                        @if($stepDone)<svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="m5 13 4 4L19 7" /></svg>@else{{ $stepNumber }}@endif
                                    </div>
                                    <p class="mt-3 text-xs font-bold text-secondary-800 dark:text-neutral-100">{{ $step['title'] }}</p>
                                    <p class="mt-1 text-[11px] leading-4 text-neutral-500 dark:text-neutral-400">{{ $step['description'] }}</p>
                                </li>
                            @endforeach
                        </ol>
                    </section>

                    <section aria-labelledby="phone-heading" class="overflow-hidden rounded-3xl border border-neutral-200 bg-white shadow-sm dark:border-secondary-700 dark:bg-secondary-800">
                        <div class="flex items-start gap-3 border-b border-neutral-100 px-5 py-4 dark:border-secondary-700 sm:px-6">
                            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-primary-50 text-primary dark:bg-primary-900/30 dark:text-primary-400">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102A1.125 1.125 0 0 0 5.872 2.25H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" /></svg>
                            </div>
                            <div><h2 id="phone-heading" class="text-sm font-bold text-secondary-900 dark:text-white">Nomor WhatsApp pengirim</h2><p class="mt-0.5 text-xs leading-5 text-neutral-500 dark:text-neutral-400">Gunakan nomor aktif yang dapat membuka menu Perangkat Tertaut.</p></div>
                        </div>

                        <form method="POST" action="{{ route('dashboard.whatsapp.setting.update-phone', $invitation) }}" class="p-5 sm:p-6">
                            @csrf
                            <label for="phone_number" class="text-xs font-bold text-secondary-700 dark:text-neutral-200">Nomor WhatsApp</label>
                            <div class="mt-2 flex rounded-2xl border border-neutral-300 bg-white transition focus-within:border-primary focus-within:ring-4 focus-within:ring-primary/10 dark:border-secondary-600 dark:bg-secondary-900 dark:focus-within:border-primary-500">
                                <span class="inline-flex items-center gap-2 border-r border-neutral-200 px-4 text-sm font-bold text-neutral-600 dark:border-secondary-700 dark:text-neutral-300"><span class="text-base" aria-hidden="true">🇮🇩</span> +62</span>
                                <input id="phone_number" name="phone_number" type="tel" inputmode="numeric" autocomplete="tel" value="{{ $phoneInput }}" placeholder="812 3456 7890" required aria-describedby="phone-help" class="min-w-0 flex-1 rounded-r-2xl border-0 bg-transparent px-4 py-3.5 font-mono text-sm text-secondary-900 placeholder:text-neutral-300 focus:ring-0 dark:text-white dark:placeholder:text-secondary-600" />
                            </div>
                            <div id="phone-help" class="mt-2.5 flex items-start gap-2 text-xs leading-5 text-neutral-500 dark:text-neutral-400">
                                <svg class="mt-0.5 h-4 w-4 shrink-0 text-neutral-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
                                <p>Cukup masukkan nomor setelah +62. Contoh: <span class="font-mono font-semibold text-neutral-700 dark:text-neutral-300">81234567890</span>.</p>
                            </div>
                            @error('phone_number')
                                <p class="mt-2 flex items-center gap-1.5 text-xs font-medium text-red-600 dark:text-red-400"><svg class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" /></svg>{{ $message }}</p>
                            @enderror
                            <div class="mt-5 flex flex-col-reverse gap-3 border-t border-neutral-100 pt-5 dark:border-secondary-700 sm:flex-row sm:items-center sm:justify-between">
                                <p class="text-xs leading-5 text-neutral-400 dark:text-neutral-500">Mengganti nomor akan memulai ulang proses verifikasi.</p>
                                <button id="btn-simpan-nomor" type="submit" class="inline-flex items-center justify-center gap-2 rounded-xl bg-primary px-5 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-primary-600 hover:shadow-md focus:outline-none focus:ring-4 focus:ring-primary/20">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.25" d="M4.5 12.75 10.5 18l9-13.5" /></svg>{{ empty($phone) ? 'Ajukan nomor' : 'Simpan perubahan' }}
                                </button>
                            </div>
                        </form>
                    </section>

                    @if(in_array($status, ['READY_TO_PAIR', 'PAIRING', 'CONNECTED']))
                        <section aria-labelledby="pairing-heading" class="overflow-hidden rounded-3xl border border-neutral-200 bg-white shadow-sm dark:border-secondary-700 dark:bg-secondary-800">
                            <div class="flex items-start gap-3 border-b border-neutral-100 px-5 py-4 dark:border-secondary-700 sm:px-6">
                                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 dark:bg-emerald-900/30 dark:text-emerald-400">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.75 4.5h4.5v4.5h-4.5V4.5Zm0 10.5h4.5v4.5h-4.5V15Zm12-10.5h4.5v4.5h-4.5V4.5Z" /></svg>
                                </div>
                                <div><h2 id="pairing-heading" class="text-sm font-bold text-secondary-900 dark:text-white">Hubungkan perangkat</h2><p class="mt-0.5 text-xs leading-5 text-neutral-500 dark:text-neutral-400">Pindai QR Code menggunakan WhatsApp pada nomor pengirim.</p></div>
                            </div>
                            <div class="flex min-h-[260px] flex-col items-center justify-center p-6 text-center sm:p-8" aria-live="polite">
                                @if($status === 'CONNECTED')
                                    <div class="flex h-20 w-20 items-center justify-center rounded-full bg-emerald-100 text-emerald-600 ring-8 ring-emerald-50 dark:bg-emerald-900/40 dark:text-emerald-300 dark:ring-emerald-950/30"><svg class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="m5 13 4 4L19 7" /></svg></div>
                                    <h3 class="mt-5 text-lg font-bold text-secondary-900 dark:text-white">Perangkat sudah terhubung</h3>
                                    <p class="mt-1 max-w-sm text-sm leading-6 text-neutral-500 dark:text-neutral-400">Kembali ke daftar tamu untuk mulai mengirim undangan melalui WhatsApp.</p>
                                    <a href="{{ route('dashboard.invitations.guests.index', $invitation) }}" class="mt-5 inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-5 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-emerald-700">Buka daftar tamu<svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 5 7 7-7 7" /></svg></a>
                                @else
                                    <template x-if="!qrUrl && !loadingQr">
                                        <div class="flex flex-col items-center">
                                            <div class="flex h-20 w-20 items-center justify-center rounded-3xl bg-emerald-50 text-emerald-600 dark:bg-emerald-900/30 dark:text-emerald-400"><svg class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.75 4.5h4.5v4.5h-4.5V4.5Zm0 10.5h4.5v4.5h-4.5V15Zm12-10.5h4.5v4.5h-4.5V4.5ZM15 15h1.5v1.5H15V15Zm3 0h2.25v5.25H15V18h3v-3Zm-6-10.5h1.5V9H12V4.5Zm0 6h4.5V12H15v3h-3v-4.5Zm6 0h2.25V13H18v-2.5ZM9.75 12h1.5v8.25h-1.5V12Zm3 4.5h1.5v3.75h-1.5V16.5Z" /></svg></div>
                                            <h3 class="mt-5 text-lg font-bold text-secondary-900 dark:text-white">Siapkan WhatsApp Anda</h3>
                                            <p class="mt-1 max-w-md text-sm leading-6 text-neutral-500 dark:text-neutral-400">Buka WhatsApp → Perangkat Tertaut → Tautkan Perangkat, lalu tampilkan QR Code.</p>
                                            <button id="btn-tampilkan-qr" type="button" @click="connectWa()" class="mt-5 inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-6 py-3 text-sm font-bold text-white shadow-lg shadow-emerald-500/20 transition hover:-translate-y-0.5 hover:bg-emerald-700 hover:shadow-xl"><svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.75 4.5h4.5v4.5h-4.5V4.5Zm0 10.5h4.5v4.5h-4.5V15Zm12-10.5h4.5v4.5h-4.5V4.5Z" /></svg>Tampilkan QR Code</button>
                                        </div>
                                    </template>
                                    <template x-if="loadingQr"><div class="flex flex-col items-center"><div class="h-12 w-12 animate-spin rounded-full border-4 border-emerald-100 border-t-emerald-500 dark:border-emerald-900 dark:border-t-emerald-400"></div><p class="mt-4 text-sm font-bold text-secondary-800 dark:text-neutral-100">Menyiapkan QR Code...</p><p class="mt-1 text-xs text-neutral-500 dark:text-neutral-400">Proses ini biasanya hanya beberapa detik.</p></div></template>
                                    <template x-if="qrUrl">
                                        <div class="flex flex-col items-center"><div class="rounded-3xl border-2 border-emerald-200 bg-white p-4 shadow-xl shadow-emerald-500/10 dark:border-emerald-800"><img :src="qrUrl" alt="QR Code untuk menghubungkan WhatsApp" class="h-56 w-56 object-contain sm:h-64 sm:w-64" /></div><p class="mt-4 max-w-md text-sm leading-6 text-neutral-600 dark:text-neutral-300">Arahkan kamera pemindai WhatsApp ke QR Code. Halaman akan memperbarui status secara otomatis.</p><button type="button" @click="connectWa()" class="mt-3 text-xs font-bold text-emerald-700 underline decoration-emerald-300 underline-offset-4 hover:text-emerald-800 dark:text-emerald-400">Buat ulang QR Code</button></div>
                                    </template>
                                    <template x-if="qrError">
                                        <div class="mt-5 flex w-full max-w-md items-start gap-3 rounded-2xl border border-red-200 bg-red-50 p-4 text-left dark:border-red-800/60 dark:bg-red-950/30"><svg class="mt-0.5 h-5 w-5 shrink-0 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" /></svg><div><p class="text-sm font-bold text-red-800 dark:text-red-300">QR Code belum dapat dimuat</p><p class="mt-1 text-xs leading-5 text-red-700 dark:text-red-400" x-text="qrError"></p><button type="button" @click="qrError = null; connectWa()" class="mt-2 text-xs font-bold text-red-700 underline underline-offset-2 dark:text-red-400">Coba lagi</button></div></div>
                                    </template>
                                @endif
                            </div>
                        </section>
                    @endif
                </div>

                <aside class="space-y-6 lg:sticky lg:top-6 lg:col-span-4">
                    <section aria-labelledby="quota-heading" class="rounded-3xl border border-neutral-200 bg-white p-5 shadow-sm dark:border-secondary-700 dark:bg-secondary-800 sm:p-6">
                        <div class="flex items-start justify-between gap-4"><div><p class="text-xs font-bold uppercase tracking-[0.18em] text-primary dark:text-primary-400">Pemakaian</p><h2 id="quota-heading" class="mt-1 text-base font-bold text-secondary-900 dark:text-white">Kuota WA Blast</h2></div><div class="flex h-10 w-10 items-center justify-center rounded-2xl bg-primary-50 text-primary dark:bg-primary-900/30 dark:text-primary-400"><svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7Z" /></svg></div></div>
                        @if($hasWaQuota)
                            <div class="mt-5 flex items-end gap-2"><span class="text-3xl font-extrabold tracking-tight text-secondary-900 dark:text-white">{{ $waRemaining }}</span><span class="pb-1 text-sm text-neutral-500 dark:text-neutral-400">pesan tersisa</span></div>
                            <div class="mt-4 h-2 overflow-hidden rounded-full bg-neutral-100 dark:bg-secondary-700"><div class="h-full rounded-full {{ $waRemaining <= 0 ? 'bg-red-500' : ($waRemaining <= 5 ? 'bg-amber-500' : 'bg-emerald-500') }}" style="width: {{ $waUsedPct }}%"></div></div>
                            <div class="mt-2 flex justify-between text-xs text-neutral-500 dark:text-neutral-400"><span>{{ $waSent }} terpakai</span><span>{{ $waQuotaLimit }} total</span></div>
                        @else
                            <div class="mt-5 rounded-2xl bg-emerald-50 p-4 dark:bg-emerald-950/30"><p class="text-2xl font-extrabold text-emerald-700 dark:text-emerald-300">Tanpa batas</p><p class="mt-1 text-xs leading-5 text-emerald-700/80 dark:text-emerald-400">Paket undangan ini tidak memiliki batas kuota WhatsApp.</p></div>
                        @endif
                    </section>

                    <section aria-labelledby="safe-heading" class="rounded-3xl border border-amber-200/80 bg-amber-50/70 p-5 dark:border-amber-800/50 dark:bg-amber-950/20 sm:p-6">
                        <div class="flex items-start gap-3"><div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-amber-100 text-amber-600 dark:bg-amber-900/50 dark:text-amber-300"><svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" /></svg></div><div><h2 id="safe-heading" class="text-sm font-bold text-amber-900 dark:text-amber-200">Kirim pesan secara bertahap</h2><p class="mt-1 text-xs leading-5 text-amber-800/80 dark:text-amber-300/80">Pengiriman massal ke nomor yang belum mengenal Anda dapat meningkatkan risiko pembatasan dari WhatsApp.</p></div></div>
                        <ul class="mt-4 space-y-2.5 border-t border-amber-200/70 pt-4 text-xs leading-5 text-amber-900/80 dark:border-amber-800/50 dark:text-amber-200/80"><li class="flex gap-2"><svg class="mt-1 h-3.5 w-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="m5 13 4 4L19 7" /></svg><span>Kirim hanya kepada tamu yang Anda kenal.</span></li><li class="flex gap-2"><svg class="mt-1 h-3.5 w-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="m5 13 4 4L19 7" /></svg><span>Gunakan jeda dan hindari jumlah besar sekaligus.</span></li></ul>
                    </section>

                    @if($adminWaClean)
                        <section class="rounded-3xl border border-neutral-200 bg-white p-5 shadow-sm dark:border-secondary-700 dark:bg-secondary-800">
                            <div class="flex items-start gap-3"><div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-600 dark:bg-emerald-900/30 dark:text-emerald-400"><svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.625 12h-.75m4.5 0h-.75m4.5 0h-.75m-7.5 4.5h8.25a2.25 2.25 0 0 0 2.25-2.25v-4.5a2.25 2.25 0 0 0-2.25-2.25H7.5a2.25 2.25 0 0 0-2.25 2.25v4.5A2.25 2.25 0 0 0 7.5 16.5Zm-3.75 3.75 3.188-3.188" /></svg></div><div><h2 class="text-sm font-bold text-secondary-900 dark:text-white">Butuh bantuan verifikasi?</h2><p class="mt-1 text-xs leading-5 text-neutral-500 dark:text-neutral-400">Tim kami dapat membantu memeriksa pengajuan nomor Anda.</p></div></div>
                            <a href="https://wa.me/{{ $adminWaClean }}?text={{ urlencode('Halo Admin Rayakan Digital, saya ingin meminta bantuan untuk pengaturan WhatsApp pada undangan "'.$invitation->title.'". Terima kasih.') }}" target="_blank" rel="noopener" class="mt-4 inline-flex w-full items-center justify-center gap-2 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-2.5 text-xs font-bold text-emerald-700 transition hover:bg-emerald-100 dark:border-emerald-800 dark:bg-emerald-950/30 dark:text-emerald-300 dark:hover:bg-emerald-900/40">Hubungi admin<svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.5 4.5H19.5V10.5M19.5 4.5 10.5 13.5M10.5 6.75H6.75A2.25 2.25 0 0 0 4.5 9v8.25a2.25 2.25 0 0 0 2.25 2.25H15a2.25 2.25 0 0 0 2.25-2.25V13.5" /></svg></a>
                        </section>
                    @endif

                    @if(in_array($status, ['CONNECTED', 'PAIRING', 'READY_TO_PAIR']))
                        <form method="POST" action="{{ route('dashboard.whatsapp.setting.disconnect', $invitation) }}" onsubmit="return confirm('Yakin ingin memutus koneksi WhatsApp? Anda perlu melakukan pairing ulang.');" class="rounded-3xl border border-neutral-200 bg-white p-5 shadow-sm dark:border-secondary-700 dark:bg-secondary-800">
                            @csrf
                            <p class="text-sm font-bold text-secondary-900 dark:text-white">Kelola koneksi</p><p class="mt-1 text-xs leading-5 text-neutral-500 dark:text-neutral-400">Putuskan perangkat jika ingin mengganti sesi WhatsApp.</p>
                            <button type="submit" class="mt-4 inline-flex w-full items-center justify-center gap-2 rounded-xl border border-red-200 px-4 py-2.5 text-xs font-bold text-red-600 transition hover:bg-red-50 dark:border-red-800/60 dark:text-red-400 dark:hover:bg-red-950/30"><svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 0 0 5.636 5.636m12.728 12.728A9 9 0 0 1 5.636 5.636m12.728 12.728L5.636 5.636" /></svg>Putuskan koneksi</button>
                        </form>
                    @endif
                </aside>
            </div>
        </main>

        <div x-show="showServiceInfo" x-cloak x-transition.opacity class="fixed inset-0 z-[70] flex items-center justify-center p-4" role="dialog" aria-modal="true" aria-labelledby="service-info-title" @keydown.escape.window="showServiceInfo = false">
            <button type="button" class="absolute inset-0 bg-secondary-950/60 backdrop-blur-sm" aria-label="Tutup informasi layanan" @click="showServiceInfo = false"></button>
            <div x-show="showServiceInfo" x-transition class="relative w-full max-w-xl overflow-hidden rounded-3xl bg-white shadow-2xl dark:bg-secondary-800">
                <div class="flex items-start justify-between gap-4 border-b border-neutral-100 p-5 dark:border-secondary-700 sm:p-6">
                    <div class="flex items-start gap-3"><div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-2xl bg-emerald-100 text-emerald-600 dark:bg-emerald-900/40 dark:text-emerald-300"><svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 12 2 2 4-4m5.618-4.016A11.955 11.955 0 0 1 12 2.944a11.955 11.955 0 0 1-8.618 3.04A12.02 12.02 0 0 0 3 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016Z" /></svg></div><div><h2 id="service-info-title" class="text-base font-bold text-secondary-900 dark:text-white">Tentang WhatsApp Gateway</h2><p class="mt-1 text-xs leading-5 text-neutral-500 dark:text-neutral-400">Koneksi pesan Rayakan Digital ditenagai oleh Fonnte.</p></div></div>
                    <button type="button" @click="showServiceInfo = false" class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-neutral-100 text-neutral-500 transition hover:bg-neutral-200 dark:bg-secondary-700 dark:text-neutral-300 dark:hover:bg-secondary-600" aria-label="Tutup"><svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18 18 6M6 6l12 12" /></svg></button>
                </div>
                <div class="grid gap-3 p-5 sm:grid-cols-2 sm:p-6">
                    @foreach([['Aman ditautkan', 'Koneksi menggunakan QR Code seperti WhatsApp Web.'], ['Nomor Anda sendiri', 'Pesan diterima tamu dari nomor yang sudah mereka kenal.'], ['Diverifikasi admin', 'Setiap nomor diperiksa sebelum akses pairing dibuka.'], ['Riwayat tercatat', 'Status pengiriman dapat dipantau dari log WhatsApp.']] as [$title, $description])
                        <div class="rounded-2xl border border-neutral-200 bg-neutral-50 p-4 dark:border-secondary-700 dark:bg-secondary-900/50"><div class="flex items-center gap-2 text-sm font-bold text-secondary-800 dark:text-neutral-100"><svg class="h-4 w-4 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="m5 13 4 4L19 7" /></svg>{{ $title }}</div><p class="mt-2 text-xs leading-5 text-neutral-500 dark:text-neutral-400">{{ $description }}</p></div>
                    @endforeach
                </div>
                <div class="border-t border-neutral-100 px-5 py-4 text-xs text-neutral-500 dark:border-secondary-700 dark:text-neutral-400 sm:px-6">Pelajari penyedia layanan di <a href="https://fonnte.com/" target="_blank" rel="noopener" class="font-bold text-emerald-600 underline underline-offset-2 dark:text-emerald-400">fonnte.com</a>.</div>
            </div>
        </div>
    </div>

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
                    if (['PAIRING', 'READY_TO_PAIR'].includes(this.status)) this.checkStatus();
                },

                destroy() {
                    if (this.pollTimer) clearInterval(this.pollTimer);
                },

                async checkStatus() {
                    this.loadingStatus = true;
                    try {
                        const response = await fetch("{{ route('dashboard.whatsapp.setting.check-status', $invitation) }}", { headers: { 'Accept': 'application/json' } });
                        const data = await response.json();
                        if (!response.ok) throw new Error(data.error || 'Status perangkat belum dapat diperiksa.');
                        this.status = data.status || this.status;
                        if (data.phone_number) this.phone = data.phone_number;
                        if (this.status === 'CONNECTED') {
                            this.qrUrl = null;
                            if (this.pollTimer) clearInterval(this.pollTimer);
                            window.location.reload();
                        }
                    } catch (error) {
                        console.error('WhatsApp status check failed:', error);
                    } finally {
                        this.loadingStatus = false;
                    }
                },

                async connectWa() {
                    this.loadingQr = true;
                    this.qrError = null;
                    try {
                        const response = await fetch("{{ route('dashboard.whatsapp.setting.get-qr', $invitation) }}", {
                            method: 'POST',
                            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json', 'Content-Type': 'application/json' },
                        });
                        const data = await response.json();
                        if (!response.ok || !data.success || !data.url) throw new Error(data.message || 'QR Code belum dapat dibuat.');
                        this.qrUrl = data.url.startsWith('http') || data.url.startsWith('data:image') ? data.url : `data:image/png;base64,${data.url}`;
                        this.status = 'PAIRING';
                        this.startPolling();
                    } catch (error) {
                        this.qrError = error.message || 'Terjadi gangguan jaringan saat meminta QR Code.';
                    } finally {
                        this.loadingQr = false;
                    }
                },

                startPolling() {
                    if (this.pollTimer) clearInterval(this.pollTimer);
                    this.pollTimer = setInterval(() => this.checkStatus(), 4000);
                },
            }));
        });
    </script>
</x-app-layout>
