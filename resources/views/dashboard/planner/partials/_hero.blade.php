@php
    $plannerProgress = max(0, min(100, (int) $checklistProgressPercent));
    $firstName = \Illuminate\Support\Str::before($user->name, ' ');
@endphp

<section class="relative isolate overflow-hidden border-b border-secondary-700 bg-secondary-900 text-white">
    <div class="absolute inset-0 -z-20 bg-gradient-to-br from-secondary-900 via-secondary-900 to-primary-900/50"></div>
    <div class="absolute -left-24 top-16 -z-10 h-72 w-72 rounded-full bg-primary-500/15 blur-3xl"></div>
    <div class="absolute -right-24 bottom-0 -z-10 h-96 w-96 rounded-full bg-primary-600/15 blur-3xl"></div>
    <div class="absolute inset-0 -z-10 opacity-[0.06]"
        style="background-image: radial-gradient(circle, #fff 1px, transparent 1px); background-size: 28px 28px;"></div>

    <div class="mx-auto max-w-7xl px-4 pb-7 pt-6 sm:px-6 sm:pb-9 sm:pt-8 lg:px-8">
        <nav aria-label="Breadcrumb" class="flex items-center gap-2 text-xs text-white/40">
            <a href="{{ route('dashboard') }}" class="transition hover:text-primary-300">Dashboard</a>
            <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
            </svg>
            <span class="font-medium text-white/70">Wedding Planner</span>
        </nav>

        <div class="mt-6 grid items-stretch gap-6 lg:grid-cols-[1.15fr_0.85fr]">
            <div class="flex flex-col justify-center">
                <div class="inline-flex w-fit items-center gap-2 rounded-full border border-white/10 bg-white/5 px-3 py-1.5 text-[10px] font-bold uppercase tracking-[0.18em] text-primary-300">
                    <span class="h-1.5 w-1.5 rounded-full bg-primary-400"></span>
                    Ruang persiapan {{ $firstName }}
                </div>
                <h1 class="mt-5 max-w-3xl font-heading text-3xl font-bold leading-tight sm:text-4xl lg:text-5xl">
                    Rancang hari bahagia, <span class="text-primary-400">satu langkah setiap hari.</span>
                </h1>
                <p class="mt-4 max-w-2xl text-sm leading-7 text-white/55 sm:text-base">
                    Kelola jadwal, checklist, vendor, dan anggaran pernikahan dalam satu workspace yang mudah dipantau bersama.
                </p>

                <div class="mt-7 flex flex-col gap-3 sm:flex-row sm:flex-wrap">
                    <button type="button" x-data @click="$dispatch('open-modal', 'add-checklist')"
                        class="inline-flex items-center justify-center gap-2 rounded-xl bg-primary-500 px-4 py-3 text-sm font-bold text-white shadow-lg shadow-primary-500/20 transition hover:-translate-y-0.5 hover:bg-primary-400">
                        <i class="fa-solid fa-plus text-xs" aria-hidden="true"></i>
                        Tambah checklist
                    </button>
                    <button type="button" x-data @click="$dispatch('open-modal', 'add-vendor')"
                        class="inline-flex items-center justify-center gap-2 rounded-xl border border-white/15 bg-white/5 px-4 py-3 text-sm font-semibold text-white transition hover:border-white/30 hover:bg-white/10">
                        <i class="fa-solid fa-handshake text-xs text-primary-300" aria-hidden="true"></i>
                        Tambah vendor
                    </button>
                    <a href="{{ route('dashboard.planner.export-pdf') }}"
                        class="inline-flex items-center justify-center gap-2 rounded-xl border border-white/15 bg-white/5 px-4 py-3 text-sm font-semibold text-white transition hover:border-white/30 hover:bg-white/10">
                        <i class="fa-regular fa-file-pdf text-xs text-red-300" aria-hidden="true"></i>
                        Export PDF
                    </a>
                </div>
            </div>

            <div class="rounded-3xl border border-white/10 bg-white/[0.07] p-4 shadow-2xl backdrop-blur-sm sm:p-5">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-white/40">Kesiapan pernikahan</p>
                        <p class="mt-1 text-sm font-semibold text-white/80">Progress checklist utama</p>
                    </div>
                    <div class="relative flex h-16 w-16 shrink-0 items-center justify-center">
                        <svg class="h-16 w-16 -rotate-90" viewBox="0 0 36 36" aria-hidden="true">
                            <circle cx="18" cy="18" r="15.5" fill="none" stroke="currentColor" stroke-width="3" class="text-white/10" />
                            <circle cx="18" cy="18" r="15.5" fill="none" stroke="currentColor" stroke-width="3"
                                stroke-linecap="round" pathLength="100" stroke-dasharray="{{ $plannerProgress }} 100"
                                class="text-primary-400" />
                        </svg>
                        <span class="absolute text-sm font-extrabold">{{ $plannerProgress }}%</span>
                    </div>
                </div>

                <div class="mt-4 h-1.5 overflow-hidden rounded-full bg-white/10">
                    <div class="h-full rounded-full bg-gradient-to-r from-primary-500 to-primary-300"
                        style="width: {{ $plannerProgress }}%"></div>
                </div>
                <div class="mt-2 flex items-center justify-between gap-3 text-[11px] text-white/40">
                    <span>{{ $checklistCompletedItems }} checklist selesai</span>
                    <span>{{ $checklistTotalItems }} total</span>
                </div>

                <div class="mt-5 border-t border-white/10 pt-5">
                    @if($weddingDate)
                        @php
                            $daysLeft = (int) now()->startOfDay()->diffInDays($weddingDate->copy()->startOfDay(), false);
                            $isPast = $daysLeft < 0;
                            $weddingTime = $firstEvent?->start_time ?? $invitation?->event_time;
                        @endphp

                        <div class="flex items-start justify-between gap-4">
                            <div class="min-w-0">
                                <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-primary-300">Countdown Menuju Hari H</p>
                                <p class="mt-2 font-heading text-lg font-bold text-white">{{ $weddingDate->translatedFormat('l, d F Y') }}</p>
                                @if($invitation)
                                    <p class="mt-1 truncate text-[11px] text-white/40">{{ $invitation->title }}</p>
                                @endif
                            </div>
                            <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-primary-500/15 text-primary-300">
                                <i class="fa-solid fa-heart" aria-hidden="true"></i>
                            </span>
                        </div>

                        @if($isPast)
                            <div class="mt-4 flex items-center gap-2 rounded-xl border border-emerald-400/20 bg-emerald-400/10 px-3 py-2.5 text-xs font-semibold text-emerald-200">
                                <i class="fa-solid fa-circle-check" aria-hidden="true"></i>
                                Acara telah dilaksanakan
                            </div>
                        @else
                            <div class="mt-4 grid grid-cols-4 gap-2"
                                x-data="plannerCountdown('{{ $weddingDate->format('Y-m-d') }}', '{{ $weddingTime ?? '' }}')">
                                <template x-if="initialized">
                                    <template x-for="unit in [
                                        { label: 'Hari', value: days },
                                        { label: 'Jam', value: hours },
                                        { label: 'Menit', value: minutes },
                                        { label: 'Detik', value: seconds },
                                    ]" :key="unit.label">
                                        <div class="rounded-xl border border-white/10 bg-black/10 px-1 py-2.5 text-center">
                                            <p class="text-base font-extrabold tabular-nums sm:text-lg" x-text="String(unit.value).padStart(2, '0')"></p>
                                            <p class="mt-0.5 text-[8px] uppercase tracking-wider text-white/35" x-text="unit.label"></p>
                                        </div>
                                    </template>
                                </template>
                                <template x-if="!initialized">
                                    <div class="col-span-4 rounded-xl border border-white/10 bg-white/5 px-3 py-2.5 text-center text-xs font-semibold text-white/70">Hari H telah tiba</div>
                                </template>
                            </div>
                        @endif
                    @else
                        <div class="grid grid-cols-[44px_1fr] items-center gap-3">
                            <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-primary-500/15 text-primary-300">
                                <i class="fa-regular fa-calendar-plus" aria-hidden="true"></i>
                            </span>
                            <div class="min-w-0 flex-1">
                                <p class="text-sm font-semibold">Tanggal pernikahan belum terhubung</p>
                                <p class="mt-1 text-[11px] leading-5 text-white/40">Lengkapi undangan agar countdown dan kalender Hari H aktif otomatis.</p>
                            </div>
                            <a href="{{ $invitation ? route('dashboard.invitations.edit', $invitation) : route('dashboard.invitations.create') }}"
                                class="col-start-2 w-fit rounded-lg border border-white/10 bg-white/5 px-3 py-2 text-[10px] font-bold text-white transition hover:bg-white/10">
                                Atur
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="mt-6 grid grid-cols-3 divide-x divide-white/10 rounded-2xl border border-white/10 bg-black/10 px-2 py-3 sm:px-4">
            <div class="px-2 sm:px-4">
                <p class="text-lg font-extrabold tabular-nums sm:text-xl">{{ $plannerItems->count() }}</p>
                <p class="mt-0.5 text-[9px] uppercase tracking-wider text-white/35 sm:text-[10px]">Item rencana</p>
            </div>
            <div class="px-3 sm:px-6">
                <p class="text-lg font-extrabold tabular-nums sm:text-xl">{{ $rundowns->count() }}</p>
                <p class="mt-0.5 text-[9px] uppercase tracking-wider text-white/35 sm:text-[10px]">Agenda Hari H</p>
            </div>
            <div class="px-3 sm:px-6">
                <p class="text-lg font-extrabold tabular-nums sm:text-xl">8</p>
                <p class="mt-0.5 text-[9px] uppercase tracking-wider text-white/35 sm:text-[10px]">Pilar persiapan</p>
            </div>
        </div>
    </div>
</section>
