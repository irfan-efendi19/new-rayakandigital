<x-qr-page-layout
    :title="'Konfirmasi Kehadiran — '.$invitation->couple_name"
    :description="'Konfirmasi kehadiran untuk acara '.$invitation->couple_name.'.'"
    section="RSVP"
    heading="Bisa hadir?"
    intro="Jawaban Anda membantu kedua mempelai menyiapkan tempat dan jamuan dengan lebih tepat."
    :couple="$invitation->couple_name"
    :back-url="route('invitation.show', $invitation->slug)"
>
    <div class="qr-content">
        @if ($eventDate)
            <div class="qr-event-date">
                <span class="qr-label">Tanggal acara</span>
                <span>{{ $eventDate->translatedFormat('l, d F Y') }}</span>
            </div>
        @endif

        <section class="qr-section {{ $eventDate ? 'mt-10' : '' }}" aria-labelledby="rsvp-form-title">
            <div data-rsvp-form-wrap>
                <div class="qr-section__heading">
                    <div>
                        <p class="qr-label">Konfirmasi Anda</p>
                        <h2 id="rsvp-form-title" class="qr-section-title">Berikan jawaban</h2>
                    </div>
                </div>

                <form action="{{ route('rsvp.store', $invitation) }}" method="POST" class="qr-form"
                    data-rsvp-form data-max-pax="{{ $maxPax }}">
                    @csrf

                    <div class="qr-field">
                        <label for="rsvp-guest-name" class="qr-field__label">Nama lengkap</label>
                        <input id="rsvp-guest-name" type="text" name="guest_name" required autocomplete="name"
                            placeholder="Nama Anda atau nama keluarga" class="qr-input">
                    </div>

                    <fieldset class="qr-field">
                        <legend class="qr-field__label">Kehadiran</legend>
                        <div class="qr-attendance">
                            <label class="qr-attendance__option">
                                <input type="radio" name="attendance" value="attending" required class="sr-only"
                                    data-rsvp-attendance>
                                <span class="qr-attendance__marker" aria-hidden="true"></span>
                                <strong>Hadir</strong>
                                <small>Saya akan datang</small>
                            </label>
                            <label class="qr-attendance__option qr-attendance__option--decline">
                                <input type="radio" name="attendance" value="not_attending" required class="sr-only"
                                    data-rsvp-attendance>
                                <span class="qr-attendance__marker" aria-hidden="true"></span>
                                <strong>Tidak hadir</strong>
                                <small>Saya belum bisa datang</small>
                            </label>
                        </div>
                    </fieldset>

                    <div class="hidden qr-field" data-rsvp-pax-field>
                        <label for="rsvp-pax" class="qr-field__label">Jumlah yang hadir</label>
                        <div class="qr-pax">
                            <button type="button" class="qr-pax__button" aria-label="Kurangi jumlah tamu"
                                data-pax-minus>-</button>
                            <input id="rsvp-pax" type="number" name="pax" value="1" min="1" max="{{ $maxPax }}"
                                readonly class="qr-pax__value" data-pax-value>
                            <span class="qr-pax__unit">orang</span>
                            <button type="button" class="qr-pax__button" aria-label="Tambah jumlah tamu"
                                data-pax-plus>+</button>
                        </div>
                        <p class="text-[11px] leading-5 text-neutral-500 dark:text-neutral-400">
                            Termasuk Anda, maksimal {{ $maxPax }} orang.
                        </p>
                    </div>

                    <div class="qr-field">
                        <label for="rsvp-message" class="qr-field__label">
                            Pesan untuk pengantin <span class="qr-field__optional">· opsional</span>
                        </label>
                        <textarea id="rsvp-message" name="message" maxlength="500"
                            placeholder="Tulis pesan singkat jika Anda berkenan" class="qr-input"
                            data-rsvp-message></textarea>
                        <p class="qr-field__meta"><span data-rsvp-counter>0</span> / 500</p>
                    </div>

                    <p class="qr-feedback qr-feedback--error" role="alert" data-rsvp-feedback></p>

                    <button type="submit" class="qr-button qr-button--primary" data-rsvp-submit>
                        Kirim Konfirmasi
                    </button>
                </form>
            </div>

            <div class="hidden qr-success" data-rsvp-success aria-live="polite">
                <p class="qr-label">Konfirmasi diterima</p>
                <h2>Terima kasih.</h2>
                <p>Jawaban dan pesan Anda sudah tercatat untuk kedua mempelai.</p>
                <button type="button" class="qr-text-link mt-5" data-rsvp-reset>Ubah konfirmasi</button>
            </div>
        </section>
    </div>
</x-qr-page-layout>
