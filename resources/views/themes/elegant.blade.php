@extends('layouts.theme')

@section('fonts')
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;1,400&family=Lato:wght@300;400&display=swap" rel="stylesheet">
@endsection

@section('cover-bg-color', '#fffaf0')
@section('body-class', 'bg-[#fffaf0] font-sans')

@push('styles')
    <style>
        h1, h2, h3, .font-serif { font-family: 'Playfair Display', serif; }
        body { font-family: 'Lato', sans-serif; color: #4a4a4a; }
        .bg-primary { background-color: #d4af37; }
        .text-primary { color: #d4af37; }
        .border-primary { border-color: #d4af37; }
    </style>
@endpush

@section('cover-content')
    <div class="max-w-sm mx-auto flex flex-col items-center justify-center min-h-screen py-12">
        <div class="mb-8" data-aos="fade-down" data-aos-duration="1500">
            <p class="text-sm tracking-widest uppercase mb-4">Pernikahan</p>
            <h1 class="text-5xl md:text-6xl text-primary italic">{{ $invitation->bride_name }} <br>&<br> {{ $invitation->groom_name }}</h1>
        </div>
        
        @if($guest)
            <div class="mt-12 bg-white/50 backdrop-blur-sm p-6 rounded-lg border border-gray-200" data-aos="fade-up" data-aos-duration="1500" data-aos-delay="500">
                <p class="text-sm text-gray-500 mb-2">Kepada Yth. Bapak/Ibu/Sdr/i</p>
                <h3 class="text-xl font-bold font-serif text-gray-800">{{ $guest->name }}</h3>
                <p class="text-xs text-gray-400 mt-2">*Mohon maaf bila ada kesalahan penulisan nama/gelar</p>
            </div>
        @endif
    </div>
@endsection

@section('content')
    @php
        $sortedEvents = $invitation->events->sortBy(['event_date', 'start_time']);
        $firstEvent = $sortedEvents->first();
    @endphp

    <!-- Hero Section -->
    <section class="min-h-screen relative flex items-center justify-center overflow-hidden">
        <div class="absolute inset-0 z-0">
            <!-- Background Image -->
            <img src="https://picsum.photos/seed/wedding-hero/800/1200" alt="Wedding" class="w-full h-full object-cover opacity-30">
            <div class="absolute inset-0 bg-gradient-to-b from-transparent to-[#fffaf0]"></div>
        </div>
        
        <div class="z-10 text-center px-4" data-aos="zoom-in" data-aos-duration="2000">
            <p class="text-sm tracking-widest uppercase mb-6 text-gray-600">The Wedding Of</p>
            <h1 class="text-6xl text-primary italic drop-shadow-sm">{{ $invitation->bride_name }} <br>&<br> {{ $invitation->groom_name }}</h1>
            <p class="mt-8 text-lg font-serif">{{ $firstEvent ? \Carbon\Carbon::parse($firstEvent->event_date)->translatedFormat('l, d F Y') : ($invitation->event_date ? \Carbon\Carbon::parse($invitation->event_date)->translatedFormat('d F Y') : 'TBA') }}</p>
        </div>
    </section>

    <!-- Couple Section -->
    <section class="py-20 px-6 text-center">
        <div data-aos="fade-up">
            <h2 class="text-3xl text-primary italic mb-4">Om Swastiastu</h2>
            <p class="text-sm text-gray-600 leading-relaxed max-w-sm mx-auto">
                Atas asung kertha wara nugraha Ida Sang Hyang Widhi Wasa/Tuhan Yang Maha Esa, kami bermaksud mengundang Bapak/Ibu/Sdr/i pada acara pernikahan putra-putri kami:
            </p>
        </div>

        <div class="mt-16" data-aos="fade-right">
            <div class="w-32 h-32 mx-auto rounded-full border-4 border-primary overflow-hidden mb-4 shadow-lg bg-gray-100">
                <img src="{{ $invitation->bride_photo ? asset('storage/' . $invitation->bride_photo) : 'https://ui-avatars.com/api/?name=' . urlencode($invitation->bride_name) . '&background=d4af37&color=fff&size=200' }}" alt="Bride" class="w-full h-full object-cover">
            </div>
            <h3 class="text-2xl font-serif text-gray-800">
                {{ $invitation->bride_name }}
                @if($invitation->bride_nickname)
                    <span class="block text-xs font-sans font-normal text-gray-500 mt-0.5">({{ $invitation->bride_nickname }})</span>
                @endif
            </h3>
            <p class="text-sm text-gray-500 mt-2 px-6">
                {{ $invitation->bride_parents ?: 'Putri dari Bapak ... & Ibu ...' }}
            </p>
        </div>

        <div class="text-4xl text-primary font-serif italic my-8" data-aos="zoom-in">&</div>

        <div class="mb-16" data-aos="fade-left">
            <div class="w-32 h-32 mx-auto rounded-full border-4 border-primary overflow-hidden mb-4 shadow-lg bg-gray-100">
                <img src="{{ $invitation->groom_photo ? asset('storage/' . $invitation->groom_photo) : 'https://ui-avatars.com/api/?name=' . urlencode($invitation->groom_name) . '&background=d4af37&color=fff&size=200' }}" alt="Groom" class="w-full h-full object-cover">
            </div>
            <h3 class="text-2xl font-serif text-gray-800">
                {{ $invitation->groom_name }}
                @if($invitation->groom_nickname)
                    <span class="block text-xs font-sans font-normal text-gray-500 mt-0.5">({{ $invitation->groom_nickname }})</span>
                @endif
            </h3>
            <p class="text-sm text-gray-500 mt-2 px-6">
                {{ $invitation->groom_parents ?: 'Putra dari Bapak ... & Ibu ...' }}
            </p>
        </div>
    </section>

    <!-- Quote Section -->
    @if($invitation->quote_content && $invitation->show_quote)
    <section class="py-20 px-6 bg-white text-center">
        <div class="max-w-sm mx-auto" data-aos="fade-up">
            <div class="relative">
                <span class="text-6xl text-primary/20 font-serif absolute -top-8 left-0">&ldquo;</span>
                <p class="text-lg md:text-xl font-serif italic text-gray-700 leading-relaxed px-4">
                    {{ $invitation->quote_content }}
                </p>
                <span class="text-6xl text-primary/20 font-serif absolute -bottom-12 right-0">&rdquo;</span>
            </div>
            @if($invitation->quote_source)
                <p class="text-sm text-gray-500 mt-8 font-semibold tracking-wide">
                    &mdash; {{ $invitation->quote_source }}
                </p>
            @endif
        </div>
    </section>
    @endif

    <!-- Countdown Section (references first chronological event) -->
    @if($firstEvent && $invitation->show_countdown)
        <section class="py-20 px-6 bg-[#fffaf0] text-center">
            <div data-aos="fade-up">
                <h2 class="text-3xl font-serif text-primary mb-4">Hitungan Menuju Hari Bahagia</h2>
                <div id="countdown-timer" class="flex justify-center gap-4 mt-8"
                    data-year="{{ \Carbon\Carbon::parse($firstEvent->event_date)->format('Y') }}"
                    data-month="{{ \Carbon\Carbon::parse($firstEvent->event_date)->format('m') }}"
                    data-day="{{ \Carbon\Carbon::parse($firstEvent->event_date)->format('d') }}">
                    <div class="bg-white rounded-xl shadow-md p-4 w-20">
                        <div class="text-3xl font-bold text-primary" id="countdown-days">00</div>
                        <div class="text-xs text-gray-500 mt-1">Hari</div>
                    </div>
                    <div class="bg-white rounded-xl shadow-md p-4 w-20">
                        <div class="text-3xl font-bold text-primary" id="countdown-hours">00</div>
                        <div class="text-xs text-gray-500 mt-1">Jam</div>
                    </div>
                    <div class="bg-white rounded-xl shadow-md p-4 w-20">
                        <div class="text-3xl font-bold text-primary" id="countdown-minutes">00</div>
                        <div class="text-xs text-gray-500 mt-1">Menit</div>
                    </div>
                    <div class="bg-white rounded-xl shadow-md p-4 w-20">
                        <div class="text-3xl font-bold text-primary" id="countdown-seconds">00</div>
                        <div class="text-xs text-gray-500 mt-1">Detik</div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    <!-- Event Detail -->
    @if($invitation->show_event_detail)
    <section class="py-20 px-6 bg-white">
        <div class="text-center mb-12" data-aos="fade-up">
            <h2 class="text-3xl font-serif text-primary mb-4">Waktu & Tempat</h2>
            <p class="text-sm text-gray-600">Rangkaian acara akan diselenggarakan pada:</p>
        </div>

        <div class="space-y-6">
            @forelse($sortedEvents as $event)
                <div class="bg-[#fffaf0] rounded-2xl py-10 px-6 shadow-sm border border-gray-100 text-center relative overflow-hidden" data-aos="flip-up">
                    <div class="absolute top-0 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-primary opacity-20 text-6xl">
                        ✿
                    </div>
                    
                    <h3 class="text-2xl font-serif text-gray-800 mb-6">{{ $event->event_title }}</h3>
                    
                    <div class="mb-6">
                        <p class="font-bold text-gray-800">{{ \Carbon\Carbon::parse($event->event_date)->translatedFormat('l, d F Y') }}</p>
                        @php
                            $tzLabel = match($invitation->timezone ?? 'Asia/Jakarta') {
                                'Asia/Jakarta' => 'WIB',
                                'Asia/Makassar' => 'WITA',
                                'Asia/Jayapura' => 'WIT',
                                default => 'WIB'
                            };
                        @endphp
                        <p class="text-sm text-gray-600 mt-1">
                            Pukul {{ $event->start_time ? \Carbon\Carbon::parse($event->start_time)->format('H:i') : '-' }}
                            @if($event->is_until_finished)
                                - Selesai
                            @elseif($event->end_time)
                                - {{ \Carbon\Carbon::parse($event->end_time)->format('H:i') }}
                            @else
                                - Selesai
                            @endif
                            {{ $tzLabel }}
                        </p>
                    </div>
                    
                    <div class="mb-8">
                        <p class="font-bold text-gray-800">{{ $event->place_name ?: 'Tempat Acara' }}</p>
                        <p class="text-sm text-gray-600 mt-1 px-4">{{ $event->place_address ?: 'Alamat belum ditentukan' }}</p>
                    </div>
                    
                    @if($event->google_maps_url)
                        <a href="{{ $event->google_maps_url }}" target="_blank" class="inline-block bg-primary text-white text-sm px-6 py-3 rounded-full uppercase tracking-wider font-semibold shadow-md hover:bg-opacity-90 transition">
                            Buka Google Maps
                        </a>
                    @endif
                </div>
            @empty
                <div class="bg-[#fffaf0] rounded-2xl py-10 px-6 shadow-sm border border-gray-100 text-center" data-aos="flip-up">
                    <h3 class="text-xl font-serif text-gray-800 mb-4">{{ $invitation->venue_name ?: 'Tempat Acara' }}</h3>
                    <p class="font-bold text-gray-800">{{ $invitation->event_date ? \Carbon\Carbon::parse($invitation->event_date)->translatedFormat('l, d F Y') : '-' }}</p>
                    @php
                        $tzLabel = match($invitation->timezone ?? 'Asia/Jakarta') {
                            'Asia/Jakarta' => 'WIB',
                            'Asia/Makassar' => 'WITA',
                            'Asia/Jayapura' => 'WIT',
                            default => 'WIB'
                        };
                    @endphp
                    <p class="text-sm text-gray-600 mt-1">
                        Pukul {{ $invitation->event_time ? \Carbon\Carbon::parse($invitation->event_time)->format('H:i') : '-' }}
                        @if($invitation->event_time_end)
                            - {{ \Carbon\Carbon::parse($invitation->event_time_end)->format('H:i') }}
                        @else
                            - Selesai
                        @endif
                        {{ $tzLabel }}
                    </p>
                    <p class="text-sm text-gray-600 mt-4">{{ $invitation->venue_address ?: 'Alamat belum ditentukan' }}</p>
                    @if($invitation->venue_maps_url)
                        <a href="{{ $invitation->venue_maps_url }}" target="_blank" class="mt-6 inline-block bg-primary text-white text-sm px-6 py-3 rounded-full uppercase tracking-wider font-semibold shadow-md hover:bg-opacity-90 transition">
                            Buka Google Maps
                        </a>
                    @endif
                </div>
            @endforelse
        </div>
    </section>
    @endif

    <!-- Gallery Section (Gold & Platinum Only) -->
    @if($invitation->show_gallery && $invitation->hasPremiumFeatures() && count($invitation->gallery_photos ?? []) > 0)
        <section class="py-20 px-6 bg-white">
            <div class="text-center mb-10" data-aos="fade-up">
                <h2 class="text-3xl font-serif text-primary mb-4">Galeri Foto</h2>
                <p class="text-sm text-gray-600">Momen-momen indah kebersamaan kami berdua.</p>
            </div>
            
            <div class="grid grid-cols-2 gap-4" data-aos="fade-up">
                @foreach($invitation->gallery_photos as $photo)
                    <div class="aspect-square rounded-xl overflow-hidden shadow bg-gray-50">
                        <img src="{{ str_starts_with($photo, 'http') ? $photo : asset('storage/' . $photo) }}" alt="Gallery Photo" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    <!-- YouTube Video / Live Streaming Section -->
    @if($invitation->show_video && $invitation->youtube_video_id)
    <section class="py-20 px-6 bg-[#fffaf0]">
        <div class="text-center mb-10" data-aos="fade-up">
            <h2 class="text-3xl font-serif text-primary mb-4">Video & Live Streaming</h2>
            <p class="text-sm text-gray-600">Saksikan momen spesial kami secara langsung.</p>
        </div>
        <div class="relative rounded-xl overflow-hidden shadow-lg" style="padding-bottom: 56.25%;" data-aos="zoom-in">
            <iframe
                src="https://www.youtube.com/embed/{{ $invitation->youtube_video_id }}?autoplay=0&rel=0"
                title="YouTube video player"
                frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                allowfullscreen
                loading="lazy"
                class="absolute inset-0 w-full h-full rounded-xl">
            </iframe>
        </div>
    </section>
    @endif

    @if($invitation->show_rsvp)
    <!-- RSVP -->
    <section class="py-20 px-6 bg-[#fffaf0]">
        <div class="text-center mb-10" data-aos="fade-up">
            <h2 class="text-3xl font-serif text-primary mb-4">RSVP</h2>
            <p class="text-sm text-gray-600">Kehadiran Bapak/Ibu/Sdr/i sangat berarti bagi kami.</p>
        </div>

        @if($isPreview ?? false)
            <div class="bg-white p-8 rounded-xl shadow-lg border-t-4 border-primary text-center" data-aos="zoom-in">
                <p class="text-gray-500 italic">Fitur RSVP tidak tersedia dalam mode pratinjau.</p>
            </div>
        @else
            <form id="rsvp-form" action="{{ route('rsvp.store', $invitation) }}" class="bg-white p-8 rounded-xl shadow-lg border-t-4 border-primary" data-aos="zoom-in">
                @csrf
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                        <input type="text" name="guest_name" value="{{ $guest ? $guest->name : '' }}" required class="w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kehadiran</label>
                        <select name="attendance" required class="w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary">
                            <option value="attending">Ya, Saya Akan Hadir</option>
                            <option value="not_attending">Maaf, Saya Tidak Bisa Hadir</option>
                            <option value="uncertain">Mungkin Hadir</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah Orang (Pax)</label>
                        <select name="pax" required class="w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary">
                            <option value="1">1 Orang</option>
                            <option value="2">2 Orang</option>
                            <option value="3">3 Orang</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="w-full bg-primary text-white py-3 rounded-md font-medium shadow-md hover:bg-opacity-90 transition">
                        Konfirmasi Kehadiran
                    </button>
                </div>
            </form>
        @endif
    </section>
    @endif

    <!-- Digital Gift Section (Silver/Gold/Platinum Only) -->
    @php
        $giftBanks = $invitation->gift_banks ?? [];
        $giftEwallets = $invitation->gift_ewallets ?? [];
        if (empty($giftBanks) && ($invitation->gift_bank_name || $invitation->gift_bank_account)) {
            $giftBanks = [['bank_name' => $invitation->gift_bank_name, 'account_number' => $invitation->gift_bank_account, 'account_holder' => $invitation->gift_bank_holder]];
        }
        if (empty($giftEwallets) && ($invitation->gift_ewallet_name || $invitation->gift_ewallet_number)) {
            $giftEwallets = [['wallet_name' => $invitation->gift_ewallet_name, 'wallet_number' => $invitation->gift_ewallet_number]];
        }
    @endphp
    @if($invitation->show_gift && $invitation->canUseGift() && (count($giftBanks) > 0 || count($giftEwallets) > 0 || $invitation->gift_qris_image))
        <section class="py-20 px-6 bg-[#fffaf0] text-center" x-data="{ openGift: false }">
            <div class="text-center mb-8" data-aos="fade-up">
                <h2 class="text-3xl font-serif text-primary mb-4">Kado Digital</h2>
                <p class="text-sm text-gray-600">Doa restu Anda adalah karunia terindah. Namun, jika Anda ingin memberikan tanda kasih secara digital, Anda dapat mengirimkannya melalui metode di bawah ini.</p>
            </div>

            <div class="max-w-md mx-auto" data-aos="zoom-in">
                <button @click="openGift = !openGift" class="bg-primary text-white px-8 py-3 rounded-full uppercase tracking-wider font-semibold shadow-md hover:bg-opacity-90 transition mb-6">
                    🎁 Kirim Kado Digital
                </button>

                <div x-show="openGift" x-cloak class="bg-white p-6 rounded-2xl shadow-xl border border-gray-100 text-left space-y-6" x-transition>
                    @foreach($giftBanks as $bank)
                        @php $bank = (object) $bank; @endphp
                        @if($bank->bank_name && $bank->account_number)
                        <div class="bg-gray-50 p-4 rounded-xl relative overflow-hidden border border-gray-100">
                            <span class="absolute top-2 right-2 text-primary font-serif italic text-sm font-semibold">Transfer Bank</span>
                            <h4 class="font-bold text-gray-800 text-sm mb-1">{{ $bank->bank_name }}</h4>
                            <p class="text-lg font-mono font-bold text-gray-900 tracking-wider mb-1">{{ $bank->account_number }}</p>
                            <p class="text-xs text-gray-500 mb-2">a.n. {{ $bank->account_holder ?: 'Mempelai' }}</p>
                            <button onclick="navigator.clipboard.writeText('{{ $bank->account_number }}'); alert('Nomor rekening disalin!')" class="text-xs bg-indigo-50 text-indigo-700 font-semibold px-3 py-1 rounded hover:bg-indigo-100">Salin Rekening</button>
                        </div>
                        @endif
                    @endforeach

                    @foreach($giftEwallets as $ewallet)
                        @php $ewallet = (object) $ewallet; @endphp
                        @if($ewallet->wallet_name && $ewallet->wallet_number)
                        <div class="bg-gray-50 p-4 rounded-xl relative overflow-hidden border border-gray-100">
                            <span class="absolute top-2 right-2 text-primary font-serif italic text-sm font-semibold">Dompet Digital</span>
                            <h4 class="font-bold text-gray-800 text-sm mb-1">{{ $ewallet->wallet_name }}</h4>
                            <p class="text-lg font-mono font-bold text-gray-900 tracking-wider mb-1">{{ $ewallet->wallet_number }}</p>
                            <p class="text-xs text-gray-500 mb-2">a.n. {{ $ewallet->wallet_name }}</p>
                            <button onclick="navigator.clipboard.writeText('{{ $ewallet->wallet_number }}'); alert('Nomor e-wallet disalin!')" class="text-xs bg-indigo-50 text-indigo-700 font-semibold px-3 py-1 rounded hover:bg-indigo-100">Salin Nomor</button>
                        </div>
                        @endif
                    @endforeach

                    <!-- QRIS -->
                    @if($invitation->gift_qris_image)
                        <div class="text-center pt-2">
                            <p class="text-xs font-semibold text-gray-700 mb-2">Scan QRIS</p>
                            <img src="{{ asset('storage/' . $invitation->gift_qris_image) }}" alt="QRIS" class="w-48 h-48 mx-auto object-contain border rounded-xl p-2 bg-white">
                        </div>
                    @endif
                </div>
            </div>
        </section>
    @endif

    @if($invitation->show_qr_checkin && $guest)
    <section class="py-16 px-6 bg-[#fffaf0]">
        <div class="text-center mb-8" data-aos="fade-up">
            <h2 class="text-3xl font-serif text-primary mb-4">QR Check-In</h2>
            <p class="text-sm text-gray-600">Tunjukkan kode ini saat check-in acara.</p>
        </div>
        <div class="flex justify-center" data-aos="fade-up">
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 inline-block text-center">
                <div class="w-44 h-44 mx-auto flex items-center justify-center">
                    {!! $guest->qr_code_svg !!}
                </div>
                <p class="text-xs text-gray-500 mt-3 font-medium">{{ $guest->name }}</p>
                <p class="text-[10px] text-gray-400 mt-1 font-mono">{{ Str::limit($guest->qr_code_token, 8, '') }}</p>
            </div>
        </div>
    </section>
    @endif

    <!-- Love Story Timeline -->
    @if($invitation->show_stories && $invitation->stories->isNotEmpty())
    <section class="py-20 px-6 bg-[#fffaf0]">
        <div class="max-w-2xl mx-auto">
            <div class="text-center mb-12" data-aos="fade-up">
                <h2 class="text-3xl font-serif text-primary mb-4">Cerita Cinta</h2>
                <p class="text-sm text-gray-600">Perjalanan cinta kami hingga ke hari bahagia ini.</p>
            </div>

            <div class="relative">
                <div class="absolute left-4 md:left-1/2 top-0 bottom-0 w-0.5 bg-primary/20 transform md:-translate-x-1/2"></div>

                @foreach($invitation->stories as $story)
                <div class="relative mb-10 md:odd:pr-[50%] md:even:pl-[50%] md:odd:text-right" data-aos="fade-up">
                    <div class="absolute left-2 md:left-1/2 top-1 w-5 h-5 bg-primary rounded-full border-4 border-white shadow transform -translate-x-1/2 z-10"></div>
                    <div class="ml-10 md:ml-0 md:mx-6 bg-white p-5 rounded-xl shadow-sm border border-gray-100">
                        @if($story->story_date)
                        <span class="inline-block text-xs font-bold text-primary bg-primary/10 px-3 py-1 rounded-full mb-2">{{ $story->story_date }}</span>
                        @endif
                        @if($story->story_title)
                        <h4 class="text-base font-semibold text-gray-800 mb-1">{{ $story->story_title }}</h4>
                        @endif
                        <p class="text-sm text-gray-700 leading-relaxed">{{ $story->story_description }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif
                        <p class="text-sm text-gray-700 leading-relaxed">{{ $story->story_description }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @elseif($invitation->show_stories && isset($isPreview) && $isPreview && $invitation->love_story)
    <section class="py-20 px-6 bg-[#fffaf0]">
        <div class="max-w-2xl mx-auto text-center" data-aos="fade-up">
            <h2 class="text-3xl font-serif text-primary mb-4">Cerita Cinta</h2>
            <p class="text-sm text-gray-600 leading-relaxed">{{ $invitation->love_story }}</p>
        </div>
    </section>
    @endif

    @if($invitation->show_comments)
    <section class="py-20 px-6 bg-white">
        <div class="text-center mb-10" data-aos="fade-up">
            <h2 class="text-3xl font-serif text-primary mb-4">Buku Tamu</h2>
            <p class="text-sm text-gray-600">Berikan doa dan ucapan untuk kami berdua.</p>
        </div>

        @if($isPreview ?? false)
            <div class="mb-10 p-6 bg-gray-50 rounded-xl text-center" data-aos="fade-up">
                <p class="text-gray-500 italic">Fitur buku tamu tidak tersedia dalam mode pratinjau.</p>
            </div>
        @else
            <form id="wish-form" action="{{ route('wish.store', $invitation) }}" class="mb-10" data-aos="fade-up">
                @csrf
                <div class="space-y-4">
                    <input type="text" name="guest_name" value="{{ $guest ? $guest->name : '' }}" placeholder="Nama Anda" required class="w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary">
                    <textarea name="message" rows="4" placeholder="Tulis ucapan dan doa..." required class="w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary"></textarea>
                    <button type="submit" class="bg-primary text-white px-6 py-2 rounded-md font-medium shadow hover:bg-opacity-90 transition">
                        Kirim Ucapan
                    </button>
                </div>
            </form>
        @endif

        <div class="space-y-4 max-h-96 overflow-y-auto pr-2" data-aos="fade-up">
            @forelse($invitation->wishes()->latest()->get() as $wish)
                <div class="bg-[#fffaf0] p-4 rounded-lg border border-gray-100">
                    <h4 class="font-bold text-gray-800 text-sm">{{ $wish->guest_name }}</h4>
                    <p class="text-gray-600 text-sm mt-2">{{ $wish->message }}</p>
                    <p class="text-xs text-gray-400 mt-2">{{ $wish->created_at->diffForHumans() }}</p>
                </div>
            @empty
                <p class="text-center text-gray-500 text-sm italic">Jadilah yang pertama memberikan ucapan.</p>
            @endforelse
        </div>
    </section>
    @endif

@endsection
