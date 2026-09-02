<x-qr-page-layout
    :title="'Lokasi Acara — '.$invitation->couple_name"
    :description="'Lokasi, waktu, dan petunjuk arah acara '.$invitation->couple_name.'.'"
    section="Lokasi Acara"
    heading="Lokasi, waktu, dan arah."
    intro="Simpan alamatnya, cek waktu acara, lalu buka rute dari posisi Anda saat berangkat."
    :couple="$invitation->couple_name"
    :back-url="route('invitation.show', $invitation->slug)"
>
    <div class="qr-content">
        <section class="qr-section" aria-labelledby="venue-name">
            <div class="qr-location">
                <p class="qr-label">Tujuan</p>
                <h2 id="venue-name" class="qr-location__name">{{ $venueName }}</h2>
                @if ($venueAddress)
                    <p class="qr-location__address">{{ $venueAddress }}</p>
                @endif
            </div>

            @if ($eventDate || $eventTime)
                <dl class="qr-meta-list">
                    @if ($eventDate)
                        <div class="qr-meta-list__item">
                            <dt class="qr-label">Tanggal</dt>
                            <dd class="qr-meta-list__value">{{ $eventDate->translatedFormat('l, d F Y') }}</dd>
                        </div>
                    @endif
                    @if ($eventTime)
                        <div class="qr-meta-list__item">
                            <dt class="qr-label">Mulai</dt>
                            <dd class="qr-meta-list__value">
                                {{ mb_substr((string) $eventTime, 0, 5) }} {{ $invitation->timezoneAbbreviation() }}
                            </dd>
                        </div>
                    @endif
                </dl>
            @endif

            <a href="{{ $mapsUrl }}" target="_blank" rel="noopener noreferrer"
                class="qr-button qr-button--primary mt-7 w-full">
                <span>Buka di Google Maps</span>
            </a>
        </section>

        <section class="qr-section" aria-labelledby="parking-title">
            <div class="qr-notice">
                <p id="parking-title" class="qr-notice__title">Parkir dan pintu masuk</p>
                @if ($invitation->venue_parking_info)
                    <p>{!! nl2br(e($invitation->venue_parking_info)) !!}</p>
                @else
                    <p>Belum ada petunjuk parkir khusus. Ikuti penanda dan arahan panitia ketika tiba di lokasi.</p>
                @endif
            </div>
        </section>
    </div>
</x-qr-page-layout>
