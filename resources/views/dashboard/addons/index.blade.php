<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div class="flex items-center gap-3">
                <div>
                    <h2 class="font-heading text-2xl font-bold text-secondary-800 dark:text-neutral-100">
                        Add-On & Fitur Tambahan
                    </h2>
                    <p class="text-sm text-neutral-500 dark:text-neutral-400 mt-0.5">
                        {{ $invitation->title }} &mdash; Kelola add-on undangan Anda
                    </p>
                </div>
            </div>
            <a href="{{ route('dashboard.invitations.show', $invitation) }}"
                class="inline-flex items-center gap-2 px-4 py-2 bg-white dark:bg-secondary-800 border border-neutral-300 dark:border-neutral-600 rounded-xl text-sm font-semibold text-neutral-700 dark:text-neutral-300 hover:bg-neutral-50 dark:hover:bg-secondary-700 transition-all">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Kembali ke Undangan
            </a>
        </div>
    </x-slot>

    @if($paymentMethod === 'midtrans')
    <script src="{{ config('midtrans.snap_url') }}" data-client-key="{{ $clientKey }}"></script>
    <style>[x-cloak] { display: none !important }</style>
    @endif

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            @if(session('success'))
                <div class="bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 rounded-xl p-4 text-sm text-emerald-700 dark:text-emerald-300">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl p-4 text-sm text-red-700 dark:text-red-300">
                    {{ session('error') }}
                </div>
            @endif

            @if(session('info'))
                <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-xl p-4 text-sm text-blue-700 dark:text-blue-300">
                    {{ session('info') }}
                </div>
            @endif

            <div class="bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-2xl p-4 sm:p-5">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <div class="flex items-start gap-3">
                        <div class="flex-shrink-0 w-11 h-11 rounded-xl bg-emerald-100 dark:bg-emerald-900/40 flex items-center justify-center text-emerald-600 dark:text-emerald-400">
                            <i class="fa-solid fa-headset text-lg"></i>
                        </div>
                        <div>
                            <p class="font-semibold text-secondary-800 dark:text-neutral-100">PIC WhatsApp Konfirmasi & Bantuan</p>
                            <p class="text-sm text-neutral-600 dark:text-neutral-400 mt-1">
                                Sudah melakukan order add-on atau butuh bantuan terkait pesanan? Hubungi tim kami langsung melalui WhatsApp agar bisa kami bantu cek dan konfirmasi.
                            </p>
                        </div>
                    </div>
                    <a href="https://wa.me/{{ config('app.whatsapp_number', '62895349823366') }}?text={{ urlencode('Halo, saya sudah order add-on undangan dan ingin konfirmasi / butuh bantuan.') }}"
                       target="_blank"
                       rel="noopener noreferrer"
                       class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold transition-all shadow-sm">
                        <i class="fa-brands fa-whatsapp"></i>
                        Hubungi PIC WhatsApp
                    </a>
                </div>
            </div>

            {{-- Payment Method Info --}}
            @if($paymentMethod === 'manual_bank')
                <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 text-blue-700 dark:text-blue-300 px-5 py-4 rounded-2xl text-sm flex items-center gap-3">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>Saat ini pembayaran menggunakan <strong>Transfer Bank Manual</strong>. Setelah membeli add-on, Anda akan melihat instruksi transfer dan tombol kirim bukti via WhatsApp.</span>
                </div>
            @else
                <div class="bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 text-emerald-700 dark:text-emerald-300 px-5 py-4 rounded-2xl text-sm flex items-center gap-3">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>Setelah pilih add-on, layar pembayaran akan langsung terbuka. Kamu bisa bayar dengan QRIS, Transfer Bank, atau Dompet Digital.</span>
                </div>
            @endif

            @forelse($availableAddons as $addon)
                @php
                    $pivot = $invitation->addons->firstWhere('id', $addon->id);
                    $isOwned = $pivot !== null;
                    $isActive = $pivot?->pivot->status_active ?? false;
                    $pendingTx = $pendingTransactions->get($addon->id);
                @endphp
                <div class="bg-white dark:bg-secondary-800 rounded-2xl shadow-soft border overflow-hidden
                    {{ $isActive ? 'border-emerald-200 dark:border-emerald-800' : ($pendingTx ? 'border-amber-200 dark:border-amber-800' : 'border-neutral-100 dark:border-secondary-700') }}">
                    <div class="p-5">
                        <div class="flex items-start justify-between gap-4">
                            <div class="flex items-start gap-4 flex-1">
                                <div class="flex-shrink-0 w-12 h-12 rounded-xl bg-primary-50 dark:bg-primary-900/50 flex items-center justify-center text-primary dark:text-primary-400">
                                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 00-1-1H4a2 2 0 110-4h1a1 1 0 001-1V7a1 1 0 011-1h3a1 1 0 001-1V4z" />
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-2 flex-wrap">
                                        <h3 class="text-base font-bold text-secondary-800 dark:text-neutral-100">
                                            {{ $addon->name }}
                                        </h3>
                                        @if($isActive)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 dark:bg-emerald-900/50 text-emerald-700 dark:text-emerald-300">
                                                Aktif
                                            </span>
                                        @elseif($pendingTx && $pendingTx->payment_status === 'verifying')
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-blue-100 dark:bg-blue-900/50 text-blue-700 dark:text-blue-300">
                                                Verifikasi (WA)
                                            </span>
                                        @elseif($pendingTx)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-amber-100 dark:bg-amber-900/50 text-amber-700 dark:text-amber-300">
                                                Menunggu Pembayaran
                                            </span>
                                        @elseif($isOwned)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-neutral-100 dark:bg-secondary-700 text-neutral-600 dark:text-neutral-400">
                                                Belum Aktif
                                            </span>
                                        @endif
                                    </div>
                                    @if($addon->description)
                                        <p class="text-sm text-neutral-500 dark:text-neutral-400 mt-1">
                                            {{ $addon->description }}
                                        </p>
                                    @endif
                                    <div class="flex items-center gap-3 mt-2">
                                        <span class="text-sm font-semibold text-primary-600 dark:text-primary-400">
                                            Rp {{ number_format($addon->price, 0, ',', '.') }}
                                        </span>
                                        @if($isOwned && $pivot->pivot->purchased_price)
                                            <span class="text-xs text-neutral-400 dark:text-neutral-500">
                                                (Dibeli seharga Rp {{ number_format($pivot->pivot->purchased_price, 0, ',', '.') }})
                                            </span>
                                        @endif
                                        @if($isActive && $pivot->pivot->activated_at)
                                            <span class="text-xs text-neutral-400 dark:text-neutral-500">
                                                Diaktifkan {{ \Carbon\Carbon::parse($pivot->pivot->activated_at)->diffForHumans() }}
                                            </span>
                                        @endif
                                        @if($pendingTx && $pendingTx->payment_status === 'pending')
                                            <span class="text-xs text-amber-500 dark:text-amber-400">
                                                {{ $pendingTx->created_at->diffForHumans() }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="flex-shrink-0">
                                @if($pendingTx && $pendingTx->payment_status === 'pending')
                                    @if($paymentMethod === 'midtrans')
                                        <form action="{{ route('dashboard.invitations.addons.purchase', [$invitation, $addon]) }}" method="POST"
                                            x-data="addonCheckout" @submit.prevent="handleSubmit">
                                            @csrf
                                            <button type="submit"
                                                x-bind:disabled="processing"
                                                class="inline-flex items-center gap-2 px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-xl text-sm font-semibold transition-all">
                                                <span x-show="!processing">Bayar Sekarang</span>
                                                <span x-show="processing" x-cloak>Memproses...</span>
                                            </button>
                                        </form>
                                    @else
                                        <a href="{{ route('dashboard.invitations.addons.invoice', [$invitation, $pendingTx]) }}"
                                            class="inline-flex items-center gap-2 px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-xl text-sm font-semibold transition-all">
                                            Lihat Invoice
                                        </a>
                                    @endif
                                @elseif($pendingTx && $pendingTx->payment_status === 'verifying')
                                    <a href="{{ route('dashboard.invitations.addons.invoice', [$invitation, $pendingTx]) }}"
                                        class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-semibold transition-all">
                                        Cek Status
                                    </a>
                                @elseif(!$isOwned)
                                    @if($paymentMethod === 'midtrans')
                                        <form action="{{ route('dashboard.invitations.addons.purchase', [$invitation, $addon]) }}" method="POST"
                                            x-data="addonCheckout" @submit.prevent="handleSubmit">
                                            @csrf
                                            <button type="submit"
                                                x-bind:disabled="processing"
                                                class="inline-flex items-center gap-2 px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-xl text-sm font-semibold transition-all">
                                                <span x-show="!processing">Beli Rp {{ number_format($addon->price, 0, ',', '.') }}</span>
                                                <span x-show="processing" x-cloak>Memproses...</span>
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('dashboard.invitations.addons.purchase', [$invitation, $addon]) }}" method="POST">
                                            @csrf
                                            <button type="submit"
                                                class="inline-flex items-center gap-2 px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-xl text-sm font-semibold transition-all">
                                                Beli Rp {{ number_format($addon->price, 0, ',', '.') }}
                                            </button>
                                        </form>
                                    @endif
                                @elseif($isOwned && !$isActive)
                                    <form action="{{ route('dashboard.invitations.addons.activate', [$invitation, $addon]) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="inline-flex items-center gap-2 px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-xl text-sm font-semibold transition-all">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                            Aktifkan
                                        </button>
                                    </form>
                                @elseif($isOwned && $isActive)
                                    <form action="{{ route('dashboard.invitations.addons.deactivate', [$invitation, $addon]) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="inline-flex items-center gap-2 px-4 py-2 bg-white dark:bg-secondary-800 border border-neutral-300 dark:border-neutral-600 rounded-xl text-sm font-semibold text-neutral-700 dark:text-neutral-300 hover:bg-neutral-50 dark:hover:bg-secondary-700 transition-all">
                                            Nonaktifkan
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white dark:bg-secondary-800 rounded-2xl shadow-soft border border-neutral-100 dark:border-secondary-700 p-8 text-center">
                    <div class="w-16 h-16 mx-auto rounded-full bg-neutral-100 dark:bg-secondary-700 flex items-center justify-center">
                        <svg class="w-8 h-8 text-neutral-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                    </div>
                    <h3 class="mt-4 text-base font-semibold text-secondary-800 dark:text-neutral-100">Belum Ada Add-On</h3>
                    <p class="mt-1 text-sm text-neutral-500 dark:text-neutral-400">Saat ini belum ada add-on yang tersedia.</p>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>
