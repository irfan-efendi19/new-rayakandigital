<x-qr-page-layout
    :title="$invitation->couple_name.' — Pusat Acara'"
    :description="'Akses undangan, RSVP, lokasi, kado digital, dan ucapan untuk '.$invitation->couple_name.'.'"
    section="QR Interaktif"
    heading="Satu pindai. Semua kebutuhan."
    intro="Pilih kebutuhan Anda tanpa perlu mencari tautan lain. Seluruh informasi acara tersusun di satu tempat."
    :couple="$invitation->couple_name"
    :back-url="route('invitation.show', $invitation->slug)"
    :wide="true"
>
    <div class="qr-content">
        <section class="qr-hub-overview" aria-labelledby="hub-overview-title">
            <div>
                <p class="qr-label">Pusat akses tamu</p>
                <h2 id="hub-overview-title" class="qr-hub-overview__title">
                    Selamat datang di acara {{ $invitation->couple_name }}.
                </h2>
                <p class="qr-hub-overview__copy">
                    Buka undangan, konfirmasi kehadiran, temukan lokasi, atau tinggalkan tanda kasih langsung dari halaman ini.
                </p>
            </div>

            <dl class="qr-hub-facts">
                <div class="qr-hub-fact">
                    <dt>Tanggal</dt>
                    <dd>{{ $eventDate ? $eventDate->translatedFormat('d M Y') : 'Segera diumumkan' }}</dd>
                </div>
                <div class="qr-hub-fact">
                    <dt>Lokasi</dt>
                    <dd title="{{ $venueName ?: 'Segera diumumkan' }}">{{ $venueName ?: 'Segera diumumkan' }}</dd>
                </div>
            </dl>
        </section>

        <section class="qr-section mt-10" aria-labelledby="hub-actions-title">
            <div class="qr-section__heading">
                <div>
                    <p class="qr-label">Pilih tujuan</p>
                    <h2 id="hub-actions-title" class="qr-section-title">Apa yang ingin Anda lakukan?</h2>
                </div>
                <span class="qr-count">{{ $canUseSharedGallery ? '6' : '5' }} pilihan</span>
            </div>

            <div class="qr-hub-grid">
                <a href="{{ route('invitation.show', $invitation->slug) }}" class="group qr-hub-card qr-hub-card--featured">
                    <div class="qr-hub-card__top">
                        <span class="qr-hub-card__icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7">
                                <path d="M4 6.5h16v11H4z" />
                                <path d="m4 7 8 6 8-6" />
                            </svg>
                        </span>
                        <span class="qr-hub-card__number" aria-hidden="true">01</span>
                    </div>
                    <div class="qr-hub-card__body">
                        <p class="qr-hub-card__eyebrow">Mulai dari sini</p>
                        <h3 class="qr-hub-card__title">Buka undangan digital</h3>
                        <p class="qr-hub-card__copy">Lihat rangkaian acara, kisah, galeri, dan seluruh detail dari kedua mempelai.</p>
                        <span class="qr-hub-card__action">
                            Lihat undangan
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="m9 5 7 7-7 7" /></svg>
                        </span>
                    </div>
                </a>

                <a href="{{ route('qr-gateway', $invitation->slug) }}" class="group qr-hub-card">
                    <div class="qr-hub-card__top">
                        <span class="qr-hub-card__icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7">
                                <path d="M9 11.5 11.5 14 16 9.5" />
                                <path d="M12 3.5 19 6v5.5c0 4.2-2.7 7.3-7 9-4.3-1.7-7-4.8-7-9V6z" />
                            </svg>
                        </span>
                        <span class="qr-hub-card__number" aria-hidden="true">02</span>
                    </div>
                    <div class="qr-hub-card__body">
                        <p class="qr-hub-card__eyebrow">RSVP</p>
                        <h3 class="qr-hub-card__title">Konfirmasi kehadiran</h3>
                        <p class="qr-hub-card__copy">Beritahu kedua mempelai apakah Anda dapat hadir dan jumlah tamu yang datang.</p>
                        <span class="qr-hub-card__action">
                            Isi konfirmasi
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="m9 5 7 7-7 7" /></svg>
                        </span>
                    </div>
                </a>

                <a href="{{ route('qr-maps', $invitation->slug) }}" class="group qr-hub-card">
                    <div class="qr-hub-card__top">
                        <span class="qr-hub-card__icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7">
                                <path d="M19 10c0 5-7 10-7 10S5 15 5 10a7 7 0 1 1 14 0Z" />
                                <circle cx="12" cy="10" r="2.2" />
                            </svg>
                        </span>
                        <span class="qr-hub-card__number" aria-hidden="true">03</span>
                    </div>
                    <div class="qr-hub-card__body">
                        <p class="qr-hub-card__eyebrow">Lokasi</p>
                        <h3 class="qr-hub-card__title">Petunjuk arah acara</h3>
                        <p class="qr-hub-card__copy">Buka navigasi menuju venue dan lihat informasi akses atau parkir.</p>
                        <span class="qr-hub-card__action">
                            Lihat lokasi
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="m9 5 7 7-7 7" /></svg>
                        </span>
                    </div>
                </a>

                <a href="{{ route('qr-kado', $invitation->slug) }}" class="group qr-hub-card">
                    <div class="qr-hub-card__top">
                        <span class="qr-hub-card__icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7">
                                <path d="M4 10h16v10H4zM3 7h18v3H3zM12 7v13" />
                                <path d="M12 7H8.5a2 2 0 1 1 2-2c0 1.1 1.5 2 1.5 2Zm0 0h3.5a2 2 0 1 0-2-2c0 1.1-1.5 2-1.5 2Z" />
                            </svg>
                        </span>
                        <span class="qr-hub-card__number" aria-hidden="true">04</span>
                    </div>
                    <div class="qr-hub-card__body">
                        <p class="qr-hub-card__eyebrow">Tanda kasih</p>
                        <h3 class="qr-hub-card__title">Kado digital</h3>
                        <p class="qr-hub-card__copy">Kirim hadiah melalui rekening, dompet digital, atau QRIS yang disiapkan.</p>
                        <span class="qr-hub-card__status">
                            <span class="qr-hub-card__status-dot" aria-hidden="true"></span>
                            {{ $giftOptionCount > 0 ? $giftOptionCount.' metode tersedia' : 'Informasi belum disiapkan' }}
                        </span>
                        <span class="qr-hub-card__action">
                            Lihat kado
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="m9 5 7 7-7 7" /></svg>
                        </span>
                    </div>
                </a>

                <a href="{{ route('qr-ucapan', $invitation->slug) }}" class="group qr-hub-card">
                    <div class="qr-hub-card__top">
                        <span class="qr-hub-card__icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7">
                                <path d="M20 11.5a7.5 7.5 0 0 1-8 7.5 9.5 9.5 0 0 1-3.8-.8L4 19l1.2-3.4A7 7 0 0 1 4 11.5 7.5 7.5 0 0 1 12 4a7.5 7.5 0 0 1 8 7.5Z" />
                                <path d="M8.5 11.5h.01M12 11.5h.01M15.5 11.5h.01" />
                            </svg>
                        </span>
                        <span class="qr-hub-card__number" aria-hidden="true">05</span>
                    </div>
                    <div class="qr-hub-card__body">
                        <p class="qr-hub-card__eyebrow">Pesan & doa</p>
                        <h3 class="qr-hub-card__title">Kirim ucapan</h3>
                        <p class="qr-hub-card__copy">Tinggalkan doa dan pesan hangat yang akan tersimpan untuk kedua mempelai.</p>
                        <span class="qr-hub-card__status">
                            <span class="qr-hub-card__status-dot" aria-hidden="true"></span>
                            {{ $invitation->wishes->count() }} ucapan terbaru ditampilkan
                        </span>
                        <span class="qr-hub-card__action">
                            Tulis ucapan
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="m9 5 7 7-7 7" /></svg>
                        </span>
                    </div>
                </a>

                @if($canUseSharedGallery)
                    <a href="{{ route('qr-shared-gallery', $invitation->slug) }}" class="group qr-hub-card qr-hub-card--wide">
                        <div>
                            <div class="qr-hub-card__top">
                                <span class="qr-hub-card__icon" aria-hidden="true">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7">
                                        <rect x="3.5" y="5" width="17" height="14" rx="1" />
                                        <circle cx="9" cy="10" r="1.5" />
                                        <path d="m5 17 4.5-4 3 2.5 2.5-2 4 3.5" />
                                    </svg>
                                </span>
                                <span class="qr-hub-card__number" aria-hidden="true">06</span>
                            </div>
                            <div class="qr-hub-card__body">
                                <p class="qr-hub-card__eyebrow">Momen bersama</p>
                                <h3 class="qr-hub-card__title">Bagikan foto acara</h3>
                                <p class="qr-hub-card__copy">Unggah foto dari kamera Anda dan ikut melengkapi album kebahagiaan hari ini.</p>
                            </div>
                        </div>
                        <span class="qr-hub-card__action">
                            Buka galeri bersama
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="m9 5 7 7-7 7" /></svg>
                        </span>
                    </a>
                @endif
            </div>
        </section>

        @if($invitation->wishes->isNotEmpty())
            <section class="qr-section" aria-labelledby="hub-wishes-title">
                <div class="qr-section__heading">
                    <div>
                        <p class="qr-label">Dari orang terdekat</p>
                        <h2 id="hub-wishes-title" class="qr-section-title">Ucapan terbaru</h2>
                    </div>
                    <a href="{{ route('qr-ucapan', $invitation->slug) }}" class="qr-text-link">Lihat semua</a>
                </div>

                <div class="qr-wishes">
                    @foreach($invitation->wishes->take(3) as $wish)
                        <article class="qr-wish">
                            <span class="qr-wish__initial" aria-hidden="true">{{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($wish->guest_name ?: 'T', 0, 1)) }}</span>
                            <div>
                                <h3 class="qr-wish__name">{{ $wish->guest_name ?: 'Tamu undangan' }}</h3>
                                <p class="qr-wish__message">{{ \Illuminate\Support\Str::limit($wish->message, 160) }}</p>
                            </div>
                        </article>
                    @endforeach
                </div>
            </section>
        @endif

        <aside class="qr-section" aria-labelledby="hub-tip-title">
            <div class="qr-hub-note">
                <span class="qr-hub-note__step" aria-hidden="true">01</span>
                <div>
                    <h2 id="hub-tip-title" class="qr-hub-note__title">Simpan halaman ini untuk akses cepat</h2>
                    <p class="qr-hub-note__copy">Tambahkan ke layar utama ponsel atau bagikan tautannya kepada keluarga yang hadir bersama Anda.</p>
                </div>
            </div>
        </aside>
    </div>
</x-qr-page-layout>
