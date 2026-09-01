@php
    $allVendors = $vendorsByType->flatten(1);
    $totalVendors = $allVendors->count();
    $bookedVendors = $allVendors->where('status', 'COMPLETED')->count();
    $pendingVendors = $totalVendors - $bookedVendors;
    $totalEstimate = (float) $allVendors->sum('estimated_cost');
@endphp
<div class="relative mb-5 overflow-hidden rounded-[28px] border border-orange-200/70 bg-gradient-to-br from-orange-600 via-orange-600 to-red-700 p-5 text-white shadow-[0_20px_50px_-24px_rgba(234,88,12,0.62)] dark:border-orange-800/50 sm:p-6">
    <div class="pointer-events-none absolute -right-12 -top-14 h-44 w-44 rounded-full bg-white/10 blur-2xl"></div>
    <div class="relative flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">
    <div class="flex items-center gap-4">
        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-white/15 ring-1 ring-white/20 backdrop-blur-sm">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 21h18M5 21V6l7-3 7 3v15M9 9h1m4 0h1m-6 4h1m4 0h1m-5 8v-4h4v4" /></svg>
        </div>
        <div>
        <p class="text-[10px] font-bold uppercase tracking-[0.24em] text-orange-100">Partner Hari Bahagia</p>
        <h3 class="mt-1 font-heading text-xl font-bold sm:text-2xl">Vendor Pernikahan</h3>
        <p class="mt-1 text-xs text-orange-100/85">{{ $totalVendors }} vendor terdaftar · {{ $bookedVendors }} sudah booked</p>
        </div>
    </div>
    <button type="button" x-data @click="$dispatch('open-modal', 'add-vendor')"
        class="inline-flex items-center gap-1.5 self-start rounded-xl bg-white px-3.5 py-2 text-xs font-bold text-orange-700 shadow-sm transition-all hover:-translate-y-0.5 hover:bg-orange-50 sm:self-auto">
        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
        Tambah Vendor
    </button>
    </div>
</div>

{{-- Summary --}}
<div class="mb-4 grid grid-cols-2 gap-2 sm:grid-cols-4">
    <div
        class="rounded-2xl border border-neutral-200/70 bg-neutral-50/70 p-3 text-center dark:border-secondary-700/50 dark:bg-secondary-700/40">
        <p class="text-[10px] text-neutral-500 dark:text-neutral-400">Total</p>
        <p class="mt-1 text-sm font-bold text-secondary-800 dark:text-neutral-100 tabular-nums">
            {{ $totalVendors }}
        </p>
    </div>
    <div
        class="rounded-2xl border border-emerald-200/70 bg-emerald-50/70 p-3 text-center dark:border-emerald-800/50 dark:bg-emerald-900/20">
        <p class="text-[10px] text-emerald-500 dark:text-emerald-400">Booked</p>
        <p class="mt-1 text-sm font-bold text-emerald-600 dark:text-emerald-400 tabular-nums">
            {{ $bookedVendors }}
        </p>
    </div>
    <div
        class="rounded-2xl border border-amber-200/70 bg-amber-50/70 p-3 text-center dark:border-amber-800/50 dark:bg-amber-900/20">
        <p class="text-[10px] text-amber-500 dark:text-amber-400">Pending</p>
        <p class="mt-1 text-sm font-bold text-amber-600 dark:text-amber-400 tabular-nums">
            {{ $pendingVendors }}
        </p>
    </div>
    <div
        class="rounded-2xl border border-orange-200/70 bg-orange-50/70 p-3 text-center dark:border-orange-800/50 dark:bg-orange-900/20">
        <p class="text-[10px] text-orange-500 dark:text-orange-400">Estimasi</p>
        <p class="mt-1 text-sm font-bold text-orange-600 dark:text-orange-400 tabular-nums">Rp
            {{ number_format($totalEstimate, 0, ',', '.') }}
        </p>
    </div>
</div>

{{-- Vendor Grid --}}
<div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
    @foreach(\App\Models\WeddingPlannerItem::VENDOR_TYPES as $type => $vendorLabel)
        @php
            $vendors = $vendorsByType[$type] ?? collect();
            $typeEstimate = (float) $vendors->sum('estimated_cost');
            $typeBooked = $vendors->where('status', 'COMPLETED')->count();
        @endphp
        <div
            class="overflow-hidden rounded-2xl border border-neutral-200/80 bg-white shadow-sm dark:border-secondary-700/60 dark:bg-secondary-800/80">
            {{-- Type Header --}}
            <div
                class="border-b border-neutral-100 bg-neutral-50/80 px-4 py-3 dark:border-secondary-700/50 dark:bg-secondary-700/40">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <span class="h-2 w-2 rounded-full bg-orange-500"></span>
                        <h4 class="text-sm font-semibold text-secondary-800 dark:text-neutral-100">
                            {{ $vendorLabel }}
                        </h4>
                    </div>
                    <div class="flex items-center gap-2">
                        <span
                            class="text-[10px] font-semibold text-neutral-400 dark:text-neutral-500">{{ $vendors->count() }}
                            vendor</span>
                        @if($vendors->isNotEmpty())
                            <span class="text-[10px] font-bold text-orange-600 dark:text-orange-400 tabular-nums">Rp
                                {{ number_format($typeEstimate, 0, ',', '.') }}</span>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Vendor List --}}
            @if($vendors->isEmpty())
                <div class="px-4 py-6 text-center">
                    <svg class="mx-auto mb-2 h-8 w-8 text-neutral-300 dark:text-secondary-600" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    <p class="text-xs text-neutral-400 dark:text-neutral-500">Belum ada vendor</p>
                </div>
            @else
                <div class="space-y-1.5 p-2">
                    @foreach($vendors as $vendor)
                        <div
                            class="group relative flex items-center gap-3 rounded-xl p-2.5 transition-colors hover:bg-neutral-50 dark:hover:bg-secondary-700/30">
                            <div class="min-w-0 flex-1">
                                <div class="flex items-center gap-2">
                                    <p class="truncate text-sm font-medium text-secondary-800 dark:text-neutral-100">
                                        {{ $vendor->title }}
                                    </p>
                                    <span
                                        class="inline-flex shrink-0 items-center rounded px-1.5 py-0.5 text-[9px] font-bold {{ $statusStyles[$vendor->status] ?? $statusStyles['PENDING'] }}">
                                        {{ $statusLabels[$vendor->status] ?? $vendor->status }}
                                    </span>
                                </div>
                                @if($vendor->vendor_contact)
                                    <p
                                        class="mt-0.5 flex items-center gap-1 truncate text-[11px] text-neutral-400 dark:text-neutral-500">
                                        <svg class="h-3 w-3 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                        </svg>
                                        {{ $vendor->vendor_contact }}
                                    </p>
                                @endif
                            </div>
                            <div class="flex shrink-0 items-center gap-2">
                                <span class="text-[11px] font-semibold text-neutral-500 dark:text-neutral-400 tabular-nums">Rp
                                    {{ number_format($vendor->estimated_cost, 0, ',', '.') }}</span>
                <div class="flex items-center gap-0.5 transition-opacity sm:opacity-0 sm:group-hover:opacity-100 sm:focus-within:opacity-100">
                    <button type="button" x-data @click="$dispatch('open-modal', 'edit-item-{{ $vendor->id }}')"
                        aria-label="Edit {{ $vendor->title }}"
                                        class="rounded-lg p-1.5 text-neutral-400 transition-colors hover:bg-primary-50 hover:text-primary dark:hover:bg-primary-900/20">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </button>
                                    <form action="{{ route('dashboard.planner.items.destroy', $vendor) }}" method="POST"
                                        onsubmit="return confirmSwal(event, 'Hapus vendor ini?');">
                                        @csrf
                                        @method('DELETE')
                        <button type="submit"
                            aria-label="Hapus {{ $vendor->title }}"
                                            class="rounded-lg p-1.5 text-neutral-400 transition-colors hover:bg-red-50 hover:text-red-600 dark:hover:bg-red-900/20">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            {{-- Add Button --}}
            <div class="px-3 pb-3">
                <button type="button" x-data
                    @click="$dispatch('open-modal', 'add-vendor'); $dispatch('set-vendor-type', { type: '{{ $type }}' })"
                    class="w-full flex items-center justify-center gap-1.5 px-3 py-2 rounded-lg border border-dashed border-neutral-300 dark:border-secondary-600 text-neutral-500 dark:text-neutral-400 hover:border-orange-400 hover:text-orange-500 dark:hover:border-orange-600 dark:hover:text-orange-400 text-xs font-medium transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah
                </button>
            </div>
        </div>
    @endforeach
</div>
