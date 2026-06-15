<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <x-meta
        title="Pernikahan {{ $invitation->groom_name }} &amp; {{ $invitation->bride_name }}"
        description="Undangan Pernikahan {{ $invitation->groom_name }} &amp; {{ $invitation->bride_name }}"
        image="{{ $invitation->cover_photo ? asset('storage/' . $invitation->cover_photo) : null }}"
    />

    @stack('meta')

    <link
        href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;1,400&amp;family=Inter:wght@300;400;500;600&amp;display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('themes/custom/test/assets/css/style.css') }}">
</head>

<body>

    <div id="floatingPetals" class="floating-petals"></div>

    <!-- ==================== COVER ==================== -->
    <div id="cover" class="cover">
        <div class="cover-bg">
            @if($invitation->cover_photo)
                <img src="{{ asset('storage/' . $invitation->cover_photo) }}" alt="Cover" class="cover-bg-img">
            @else
                <img src="{{ asset('themes/custom/test/assets/images/hero-bg.svg') }}" alt="" class="cover-bg-img">
            @endif
            <div class="cover-overlay"></div>
        </div>
        <div class="cover-content">
            <div class="cover-decoration">&#10087;</div>
            <p class="cover-subtitle">The Wedding Of</p>
            <h1 class="cover-title">{{ $invitation->bride_name }}<span
                    class="cover-amp">&amp;</span>{{ $invitation->groom_name }}</h1>
            @php
                $firstEvent = $invitation->events->sortBy(['event_date', 'start_time'])->first();
            @endphp
            @if($firstEvent)
                <p class="cover-date">{{ \Carbon\Carbon::parse($firstEvent->event_date)->translatedFormat('l, d F Y') }}</p>
            @elseif($invitation->event_date)
                <p class="cover-date">{{ \Carbon\Carbon::parse($invitation->event_date)->translatedFormat('l, d F Y') }}</p>
            @endif
            @if($guest)
                <div class="cover-guest">
                    <p class="cover-guest-label">Kepada Yth.</p>
                    <p class="cover-guest-name">{{ $guest->name }}</p>
                </div>
            @endif
            <button id="openBtn" class="cover-btn">Buka Undangan</button>
        </div>
    </div>

    <!-- ==================== MUSIC ==================== -->
    <audio id="bgAudio" loop preload="none">
        @if($invitation->music_url)
            <source src="{{ asset('storage/' . $invitation->music_url) }}" type="audio/mpeg">
        @else
            <source src="https://www.soundhelix.com/examples/mp3/SoundHelix-Song-1.mp3" type="audio/mpeg">
        @endif
    </audio>
    <button id="musicToggle" class="music-btn" aria-label="Toggle Music">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="music-icon">
            <path d="M9 18V5l12-2v13" />
            <circle cx="6" cy="18" r="3" />
            <circle cx="18" cy="16" r="3" />
        </svg>
    </button>

    <!-- ==================== LIGHTBOX ==================== -->
    <div id="lightbox" class="lightbox">
        <span id="lightboxClose" class="lightbox-close">&times;</span>
        <img id="lightboxImg" src="" alt="">
    </div>

    <!-- ==================== MAIN ==================== -->
    <main id="main" class="main">

        <!-- Hero Section -->
        <section class="section hero-section">
            <div class="container text-center">
                <p class="section-subtitle">Assalamu&rsquo;alaikum Warahmatullahi Wabarakatuh</p>
                <p class="hero-text">Dengan memohon rahmat dan ridha Allah SWT, kami bermaksud menyelenggarakan
                    pernikahan putra-putri kami:</p>
                <div class="couple-grid">
                    <div class="couple-card">
                        <div class="couple-photo">
                            @if($invitation->bride_photo)
                                <img src="{{ asset('storage/' . $invitation->bride_photo) }}"
                                    alt="{{ $invitation->bride_name }}">
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($invitation->bride_name) }}&amp;background=d4a574&amp;color=fff&amp;size=400"
                                    alt="{{ $invitation->bride_name }}">
                            @endif
                        </div>
                        <h2 class="couple-name">{{ $invitation->bride_name }}</h2>
                        @if($invitation->bride_nickname)
                            <p class="couple-nickname">{{ $invitation->bride_nickname }}</p>
                        @endif
                        <p class="couple-parents">
                            {{ $invitation->bride_parents ?: 'Putri dari Bapak ... &amp; Ibu ...' }}
                        </p>
                    </div>
                    <div class="couple-amp">&amp;</div>
                    <div class="couple-card">
                        <div class="couple-photo">
                            @if($invitation->groom_photo)
                                <img src="{{ asset('storage/' . $invitation->groom_photo) }}"
                                    alt="{{ $invitation->groom_name }}">
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($invitation->groom_name) }}&amp;background=1a1a2e&amp;color=fff&amp;size=400"
                                    alt="{{ $invitation->groom_name }}">
                            @endif
                        </div>
                        <h2 class="couple-name">{{ $invitation->groom_name }}</h2>
                        @if($invitation->groom_nickname)
                            <p class="couple-nickname">{{ $invitation->groom_nickname }}</p>
                        @endif
                        <p class="couple-parents">
                            {{ $invitation->groom_parents ?: 'Putra dari Bapak ... &amp; Ibu ...' }}
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Quote Section -->
        @if($invitation->quote_content && $invitation->show_quote)
            <section class="section quote-section">
                <div class="container text-center">
                    <div class="quote-card">
                        <span class="quote-mark">&ldquo;</span>
                        <p class="quote-text">{{ $invitation->quote_content }}</p>
                        @if($invitation->quote_source)
                            <p class="quote-source">&mdash; {{ $invitation->quote_source }}</p>
                        @endif
                    </div>
                </div>
            </section>
        @endif

        <!-- YouTube Video Section -->
        @if($invitation->show_video && $invitation->youtube_video_id)
            <section class="section video-section">
                <div class="container text-center">
                    <h2 class="section-title" style="color:#d4a574;">Video</h2>
                    <div class="video-wrapper" style="margin-top:1.5rem;">
                        <iframe src="https://www.youtube.com/embed/{{ $invitation->youtube_video_id }}?autoplay=0&amp;rel=0"
                            allowfullscreen loading="lazy"></iframe>
                    </div>
                </div>
            </section>
        @endif

        <!-- Countdown Section -->
        @if($firstEvent && $invitation->show_countdown)
            <section class="section countdown-section" id="countdownSection">
                <div class="container text-center">
                    <h2 class="section-title">Hitungan Menuju Hari Bahagia</h2>
                    <div class="countdown" id="countdown"
                        data-year="{{ \Carbon\Carbon::parse($firstEvent->event_date)->format('Y') }}"
                        data-month="{{ \Carbon\Carbon::parse($firstEvent->event_date)->format('m') }}"
                        data-day="{{ \Carbon\Carbon::parse($firstEvent->event_date)->format('d') }}"
                        data-hour="{{ $firstEvent->start_time ? \Carbon\Carbon::parse($firstEvent->start_time)->format('H') : '0' }}"
                        data-minute="{{ $firstEvent->start_time ? \Carbon\Carbon::parse($firstEvent->start_time)->format('i') : '0' }}">
                        <div class="countdown-item"><span id="cd-days">00</span><small>Hari</small></div>
                        <div class="countdown-item"><span id="cd-hours">00</span><small>Jam</small></div>
                        <div class="countdown-item"><span id="cd-minutes">00</span><small>Menit</small></div>
                        <div class="countdown-item"><span id="cd-seconds">00</span><small>Detik</small></div>
                    </div>
                </div>
            </section>
        @endif

        <!-- Event Detail Section -->
        @if($invitation->show_event_detail)
            <section class="section event-section">
                <div class="container text-center">
                    <h2 class="section-title">Waktu &amp; Tempat</h2>
                    @php $sortedEvents = $invitation->events->sortBy(['event_date', 'start_time']); @endphp
                    @forelse($sortedEvents as $event)
                        <div class="event-card">
                            <div class="event-dot"></div>
                            <h3 class="event-title">{{ $event->event_title }}</h3>
                            <p class="event-date">{{ \Carbon\Carbon::parse($event->event_date)->translatedFormat('l, d F Y') }}
                            </p>
                            @php
                                $tzLabel = match ($invitation->timezone ?? 'Asia/Jakarta') {
                                    'Asia/Jakarta' => 'WIB', 'Asia/Makassar' => 'WITA', 'Asia/Jayapura' => 'WIT', default => 'WIB'
                                };
                            @endphp
                            <p class="event-time">
                                {{ $event->start_time ? \Carbon\Carbon::parse($event->start_time)->format('H:i') : '-' }}
                                @if($event->is_until_finished) - Selesai
                                @elseif($event->end_time) - {{ \Carbon\Carbon::parse($event->end_time)->format('H:i') }}
                                @else - Selesai
                                @endif {{ $tzLabel }}
                            </p>
                            <p class="event-place">{{ $event->place_name }}</p>
                            <p class="event-address">{{ $event->place_address }}</p>
                            @if($event->google_maps_url)
                                <a href="{{ $event->google_maps_url }}" target="_blank" class="event-maps-btn">
                                    <svg viewBox="0 0 24 24" fill="currentColor">
                                        <path
                                            d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z" />
                                    </svg>
                                    Buka Google Maps
                                </a>
                            @endif
                        </div>
                    @empty
                        <div class="event-card">
                            <p class="event-place">{{ $invitation->venue_name ?: 'Tempat Acara' }}</p>
                            <p class="event-date">
                                {{ $invitation->event_date ? \Carbon\Carbon::parse($invitation->event_date)->translatedFormat('l, d F Y') : '-' }}
                            </p>
                            <p class="event-address">{{ $invitation->venue_address ?: 'Alamat belum ditentukan' }}</p>
                            @if($invitation->venue_maps_url)
                                <a href="{{ $invitation->venue_maps_url }}" target="_blank" class="event-maps-btn">
                                    <svg viewBox="0 0 24 24" fill="currentColor">
                                        <path
                                            d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z" />
                                    </svg>
                                    Buka Google Maps
                                </a>
                            @endif
                        </div>
                    @endforelse
                </div>
            </section>
        @endif

        <!-- Gallery Section -->
        @if(
                $invitation->show_gallery && $invitation->hasFeature('gallery_photos') &&
                !empty($invitation->gallery_photos)
            )
            <section class="section gallery-section">
                <div class="container text-center">
                    <h2 class="section-title">Galeri Foto</h2>
                    <div class="gallery-grid">
                        @foreach($invitation->gallery_photos as $photo)
                            <div class="gallery-item">
                                <img src="{{ str_starts_with($photo, 'http') ? $photo : asset('storage/' . $photo) }}"
                                    alt="Gallery" loading="lazy">
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        <!-- Love Story Section -->
        @php $stories = $invitation->stories; @endphp
        @if($invitation->show_stories && $stories->isNotEmpty())
            <section class="section story-section">
                <div class="container">
                    <h2 class="section-title text-center">Cerita Cinta</h2>
                    <div class="story-timeline">
                        @foreach($stories as $story)
                            <div class="story-item">
                                <div class="story-dot"></div>
                                @if($story->story_date)
                                    <span class="story-date">
                                        @php
                                            try {
                                                $parsedDate = \Carbon\Carbon::parse($story->story_date)->translatedFormat('d F Y');
                                            } catch (\Exception $e) {
                                                $parsedDate = $story->story_date;
                                            }
                                        @endphp
                                        {{ $parsedDate }}
                                    </span>
                                @endif
                                @if($story->story_title)
                                    <h3 class="story-title">{{ $story->story_title }}</h3>
                                @endif
                                <p class="story-text">{{ $story->story_description }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @elseif($invitation->show_stories && $invitation->love_story)
            <section class="section story-section">
                <div class="container text-center">
                    <h2 class="section-title">Cerita Cinta</h2>
                    <p class="story-text-preview">{{ $invitation->love_story }}</p>
                </div>
            </section>
        @endif

        <!-- RSVP Section -->
        @if($invitation->show_rsvp)
            <section class="section rsvp-section">
                <div class="container text-center">
                    <h2 class="section-title">RSVP</h2>
                    <p class="section-desc">Kehadiran Bapak/Ibu/Sdr/i sangat berarti bagi kami.</p>
                    @if($isPreview ?? false)
                        <div class="preview-notice">Fitur RSVP tidak tersedia dalam mode pratinjau.</div>
                    @else
                        <form id="rsvpForm" class="rsvp-form" action="{{ route('rsvp.store', $invitation) }}" method="POST">
                            @csrf
                            <input type="text" name="guest_name" value="{{ $guest ? $guest->name : '' }}"
                                placeholder="Nama Lengkap" required class="form-input">
                            <select name="attendance" required class="form-input">
                                <option value="attending">Ya, Saya Akan Hadir</option>
                                <option value="not_attending">Maaf, Tidak Bisa Hadir</option>
                                <option value="uncertain">Mungkin Hadir</option>
                            </select>
                            <select name="pax" required class="form-input">
                                <option value="1">1 Orang</option>
                                <option value="2">2 Orang</option>
                                <option value="3">3 Orang</option>
                                <option value="4">4 Orang</option>
                                <option value="5">5 Orang</option>
                            </select>
                            <button type="submit" class="btn btn-primary">Konfirmasi Kehadiran</button>
                        </form>
                    @endif
                </div>
            </section>
        @endif

        <!-- Gift Section -->
        @php
            $giftBanks = $invitation->gift_banks ?? [];
            $giftEwallets = $invitation->gift_ewallets ?? [];
            if (empty($giftBanks) && ($invitation->gift_bank_name || $invitation->gift_bank_account)) {
                $giftBanks = [
                    [
                        'bank_name' => $invitation->gift_bank_name,
                        'account_number' => $invitation->gift_bank_account,
                        'account_holder' => $invitation->gift_bank_holder
                    ]
                ];
            }
            if (empty($giftEwallets) && ($invitation->gift_ewallet_name || $invitation->gift_ewallet_number)) {
                $giftEwallets = [
                    [
                        'wallet_name' => $invitation->gift_ewallet_name,
                        'wallet_number' =>
                            $invitation->gift_ewallet_number
                    ]
                ];
            }
        @endphp
        @if(
                $invitation->show_gift && $invitation->canUseGift() && (count($giftBanks) > 0 || count($giftEwallets) > 0 ||
                    $invitation->gift_qris_image)
            )
            <section class="section gift-section">
                <div class="container text-center">
                    <h2 class="section-title">Kado Digital</h2>
                    <p class="section-desc">Doa restu Anda adalah karunia terindah. Namun jika ingin memberi tanda kasih,
                        Anda dapat mengirimkannya melalui:</p>
                    <div class="gift-toggle-wrap">
                        <button id="giftToggleBtn" class="btn btn-primary">Kirim Kado Digital</button>
                        <div id="giftContent" class="gift-content">
                            @foreach($giftBanks as $bank)
                                @php $bank = (object) $bank; @endphp
                                @if($bank->bank_name && $bank->account_number)
                                    <div class="gift-card">
                                        <span class="gift-label">Transfer Bank</span>
                                        <h4>{{ $bank->bank_name }}</h4>
                                        <p class="gift-account">{{ $bank->account_number }}</p>
                                        <p class="gift-holder">a.n. {{ $bank->account_holder ?: 'Mempelai' }}</p>
                                        <button class="btn-copy" data-copy="{{ $bank->account_number }}">Salin Rekening</button>
                                    </div>
                                @endif
                            @endforeach
                            @foreach($giftEwallets as $ewallet)
                                @php $ewallet = (object) $ewallet; @endphp
                                @if($ewallet->wallet_name && $ewallet->wallet_number)
                                    <div class="gift-card">
                                        <span class="gift-label">Dompet Digital</span>
                                        <h4>{{ $ewallet->wallet_name }}</h4>
                                        <p class="gift-account">{{ $ewallet->wallet_number }}</p>
                                        <button class="btn-copy" data-copy="{{ $ewallet->wallet_number }}">Salin Nomor</button>
                                    </div>
                                @endif
                            @endforeach
                            @if($invitation->gift_qris_image)
                                <div class="gift-card gift-qris">
                                    <span class="gift-label">Scan QRIS</span>
                                    <img src="{{ asset('storage/' . $invitation->gift_qris_image) }}" alt="QRIS"
                                        class="qris-img">
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </section>
        @endif

        <!-- QR Check-In Section -->
        @if($invitation->show_qr_checkin && $guest)
            <section class="section qr-section">
                <div class="container text-center">
                    <h2 class="section-title">QR Check-In</h2>
                    <p class="section-desc">Tunjukkan kode ini saat check-in acara.</p>
                    <div class="qr-card">
                        {!! $guest->qr_code_svg !!}
                        <p class="qr-name">{{ $guest->name }}</p>
                    </div>
                </div>
            </section>
        @endif

        <!-- Guestbook Section -->
        @if($invitation->show_comments)
            <section class="section guestbook-section">
                <div class="container text-center">
                    <h2 class="section-title">Buku Tamu</h2>
                    <p class="section-desc">Berikan doa dan ucapan untuk kami berdua.</p>
                    @if($isPreview ?? false)
                        <div class="preview-notice">Fitur buku tamu tidak tersedia dalam mode pratinjau.</div>
                    @else
                        <form id="wishForm" class="wish-form" action="{{ route('wish.store', $invitation) }}" method="POST">
                            @csrf
                            <input type="text" name="guest_name" value="{{ $guest ? $guest->name : '' }}"
                                placeholder="Nama Anda" required class="form-input">
                            <textarea name="message" rows="4" placeholder="Tulis ucapan dan doa..." required
                                class="form-input"></textarea>
                            <button type="submit" class="btn btn-primary">Kirim Ucapan</button>
                        </form>
                    @endif
                    <div class="wish-list" id="wishList">
                        @forelse($invitation->wishes()->latest()->get() as $wish)
                            <div class="wish-item">
                                <h4>{{ $wish->guest_name }}</h4>
                                <p>{{ $wish->message }}</p>
                                <small>{{ $wish->created_at->diffForHumans() }}</small>
                            </div>
                        @empty
                            <p class="wish-empty">Jadilah yang pertama memberikan ucapan.</p>
                        @endforelse
                    </div>
                </div>
            </section>
        @endif

        <!-- Footer -->
        <footer class="footer">
            <div class="container text-center">
                <p class="footer-thanks">Merupakan suatu kehormatan dan kebahagiaan apabila Bapak/Ibu/Sdr/i berkenan
                    hadir.</p>
                <p class="footer-couple">{{ $invitation->groom_name }} &amp; {{ $invitation->bride_name }}</p>
                @php
                    $appUrl = config('app.url');
                @endphp
                <p class="footer-credit">Dibuat dengan <a href="{{ $appUrl }}" target="_blank">RayakanDigital</a></p>
            </div>
        </footer>

    </main>

    <script src="{{ asset('themes/custom/test/assets/js/script.js') }}"></script>
</body>

</html>