<x-qr-page-layout
    :title="'Kado Digital — '.$invitation->couple_name"
    :description="'Pilihan rekening dan QRIS untuk mengirim kado kepada '.$invitation->couple_name.'.'"
    section="Kado Digital"
    heading="Tanda kasih, jika Anda berkenan."
    intro="Kehadiran dan doa Anda sudah lebih dari cukup. Jika tetap ingin memberi, gunakan salah satu tujuan berikut."
    :couple="$invitation->couple_name"
    :back-url="route('invitation.show', $invitation->slug)"
>
    <div class="qr-content">
        @if ($giftBanks->isNotEmpty() || $giftEwallets->isNotEmpty() || $qrisUrl)
            @if ($giftBanks->isNotEmpty() || $giftEwallets->isNotEmpty())
                <section class="qr-section" aria-labelledby="gift-accounts-title">
                    <div class="qr-section__heading">
                        <div>
                            <p class="qr-label">Transfer</p>
                            <h2 id="gift-accounts-title" class="qr-section-title">Pilih tujuan</h2>
                        </div>
                    </div>

                    <div class="qr-accounts">
                        @foreach ($giftBanks as $bank)
                            <article class="qr-account">
                                <div>
                                    <p class="qr-account__type">Rekening bank</p>
                                    <h3 class="qr-account__name">{{ $bank['bank_name'] }}</h3>
                                    @if (filled($bank['account_holder'] ?? null))
                                        <p class="qr-account__holder">Atas nama {{ $bank['account_holder'] }}</p>
                                    @endif
                                </div>
                                <div class="qr-account__number">
                                    <code>{{ $bank['account_number'] }}</code>
                                    <button type="button" class="qr-copy"
                                        data-copy="{{ $bank['account_number'] }}"
                                        aria-label="Salin nomor rekening {{ $bank['bank_name'] }}">
                                        Salin
                                    </button>
                                </div>
                            </article>
                        @endforeach

                        @foreach ($giftEwallets as $ewallet)
                            <article class="qr-account">
                                <div>
                                    <p class="qr-account__type">Dompet digital</p>
                                    <h3 class="qr-account__name">{{ $ewallet['wallet_name'] }}</h3>
                                    @if (filled($ewallet['account_holder'] ?? null))
                                        <p class="qr-account__holder">Atas nama {{ $ewallet['account_holder'] }}</p>
                                    @endif
                                </div>
                                <div class="qr-account__number">
                                    <code>{{ $ewallet['wallet_number'] }}</code>
                                    <button type="button" class="qr-copy"
                                        data-copy="{{ $ewallet['wallet_number'] }}"
                                        aria-label="Salin nomor {{ $ewallet['wallet_name'] }}">
                                        Salin
                                    </button>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </section>
            @endif

            @if ($qrisUrl)
                <section class="qr-section qr-qris" aria-labelledby="qris-title">
                    <div>
                        <p class="qr-label">Pindai</p>
                        <h2 id="qris-title" class="qr-section-title">Bayar lewat QRIS</h2>
                        <p class="mt-2 max-w-sm text-sm leading-6 text-neutral-600 dark:text-neutral-400">
                            Buka aplikasi pembayaran, pilih pindai QR, lalu arahkan kamera ke kode ini.
                        </p>
                    </div>
                    <button type="button" data-qris-open aria-label="Perbesar kode QRIS">
                        <img src="{{ $qrisUrl }}" alt="Kode QRIS untuk {{ $invitation->couple_name }}">
                    </button>
                </section>

                <dialog class="qr-dialog" data-qris-dialog>
                    <div class="qr-dialog__bar">
                        <p class="text-xs font-bold">QRIS · {{ $invitation->couple_name }}</p>
                        <button type="button" class="qr-text-link" data-qris-close>Tutup</button>
                    </div>
                    <img src="{{ $qrisUrl }}" alt="Kode QRIS diperbesar untuk {{ $invitation->couple_name }}">
                </dialog>
            @endif
        @else
            <div class="qr-empty">
                <h2 class="qr-empty__title">Belum ada tujuan kado.</h2>
                <p class="qr-empty__copy">Kedua mempelai belum menambahkan rekening, dompet digital, atau QRIS.</p>
            </div>
        @endif
    </div>
</x-qr-page-layout>
