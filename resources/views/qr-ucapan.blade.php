<x-qr-page-layout
    :title="'Ucapan & Doa — '.$invitation->couple_name"
    :description="'Sampaikan ucapan dan doa untuk '.$invitation->couple_name.'.'"
    section="Ucapan & Doa"
    heading="Titip kata untuk mereka."
    intro="Tak perlu panjang atau sempurna. Tulis yang benar-benar ingin Anda sampaikan kepada kedua mempelai."
    :couple="$invitation->couple_name"
    :back-url="route('invitation.show', $invitation->slug)"
    wide
>
    <div class="qr-content">
        <div class="qr-split">
            <section aria-labelledby="wish-form-title">
                <div class="qr-section__heading">
                    <div>
                        <p class="qr-label">Dari Anda</p>
                        <h2 id="wish-form-title" class="qr-section-title">Satu pesan yang berarti</h2>
                    </div>
                </div>

                <div data-wish-form-wrap>
                    <form action="{{ route('wish.store', $invitation) }}" method="POST" class="qr-form" data-wish-form>
                        @csrf
                        <input type="hidden" name="invitation_id" value="{{ $invitation->id }}">

                        <div class="qr-field">
                            <label for="wish-name" class="qr-field__label">Nama Anda</label>
                            <input id="wish-name" name="guest_name" type="text" required autocomplete="name"
                                placeholder="Contoh: Dimas & keluarga" class="qr-input">
                        </div>

                        <div class="qr-field">
                            <label for="wish-message" class="qr-field__label">Pesan dan doa</label>
                            <textarea id="wish-message" name="message" maxlength="500" required
                                placeholder="Semoga rumah yang kalian bangun selalu menjadi tempat pulang…"
                                class="qr-input" data-wish-message></textarea>
                            <p class="qr-field__meta"><span data-wish-counter>0</span> / 500</p>
                        </div>

                        <p class="qr-feedback qr-feedback--error" role="alert" data-feedback></p>

                        <button type="submit" class="qr-button qr-button--primary" data-submit>Kirim Ucapan</button>
                    </form>
                </div>

                <div class="hidden qr-success" data-wish-success aria-live="polite">
                    <h2>Sudah sampai.</h2>
                    <p>Terima kasih sudah ikut mengisi hari mereka dengan kata-kata baik.</p>
                    <button type="button" class="qr-text-link mt-5" data-wish-reset>Tulis ucapan lain</button>
                </div>
            </section>

            <section aria-labelledby="latest-wishes-title">
                <div class="qr-section__heading">
                    <div>
                        <p class="qr-label">Dari orang-orang terdekat</p>
                        <h2 id="latest-wishes-title" class="qr-section-title">Ucapan terbaru</h2>
                    </div>
                    <span class="qr-count">{{ $invitation->wishes->count() }}</span>
                </div>

                @if ($invitation->wishes->isNotEmpty())
                    <div class="qr-wishes">
                        @foreach ($invitation->wishes as $wish)
                            <article class="qr-wish">
                                <span class="qr-wish__initial" aria-hidden="true">
                                    {{ mb_strtoupper(mb_substr($wish->guest_name ?? 'T', 0, 1)) }}
                                </span>
                                <div>
                                    <h3 class="qr-wish__name">{{ $wish->guest_name ?? 'Tamu' }}</h3>
                                    <p class="qr-wish__message">{{ $wish->message }}</p>
                                </div>
                            </article>
                        @endforeach
                    </div>
                @else
                    <div class="qr-empty">
                        <h3 class="qr-empty__title">Belum ada yang menulis.</h3>
                        <p class="qr-empty__copy">Ucapan pertama sering kali menjadi yang paling diingat.</p>
                    </div>
                @endif
            </section>
        </div>
    </div>
</x-qr-page-layout>
