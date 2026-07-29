<x-app-layout>
    @php
        $hour = now()->setTimezone('Asia/Jakarta')->hour;
        $greeting = match(true) {
            $hour >= 4  && $hour < 11 => 'Selamat Pagi',
            $hour >= 11 && $hour < 15 => 'Selamat Siang',
            $hour >= 15 && $hour < 19 => 'Selamat Sore',
            default                   => 'Selamat Malam',
        };
        $greetingIcon = match(true) {
            $hour >= 4  && $hour < 11 => '☀️',
            $hour >= 11 && $hour < 15 => '🌤️',
            $hour >= 15 && $hour < 19 => '🌇',
            default                   => '🌙',
        };
        $totalInvitations   = $invitations->count();
        $activeInvitations  = $invitations->filter(fn($i) => !$i->isTrialExpired())->count();
        $trialCount         = $trialInvitations->count();
        $pendingCount       = $pendingOrders->count();
    @endphp

    <div class="min-h-screen">

        {{-- ─────────────────────────────────────────────────────────────────────
             HERO SECTION
        ──────────────────────────────────────────────────────────────────────── --}}
        <div class="hero-mesh grain-overlay border-b border-neutral-200/60 dark:border-secondary-700/40">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-10">

                {{-- Greeting + CTA --}}
                <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-5">
                    <div>
                        <p class="text-sm font-medium text-primary dark:text-primary-400 tracking-wide flex items-center gap-1.5 mb-1">
                            <span>{{ $greetingIcon }}</span>
                            <span>{{ $greeting }}</span>
                        </p>
                        <h1 class="font-heading text-2xl sm:text-3xl font-bold text-secondary-800 dark:text-neutral-50 leading-tight">
                            {{ Auth::user()->name }}
                        </h1>
                        <p class="text-sm text-neutral-500 dark:text-neutral-400 mt-1.5 max-w-sm">
                            Kelola undangan digital Anda dan buat setiap momen menjadi tak terlupakan.
                        </p>
                    </div>

                    <a href="{{ route('dashboard.invitations.create') }}"
                        class="group self-start inline-flex items-center gap-2.5 px-5 py-3 bg-gradient-to-br from-primary to-primary-600 text-white rounded-2xl font-semibold text-sm shadow-lg shadow-primary/25 hover:shadow-xl hover:shadow-primary/30 hover:-translate-y-0.5 active:translate-y-0 active:shadow-md transition-all duration-200 whitespace-nowrap">
                        <span class="flex items-center justify-center w-5 h-5 rounded-full bg-white/20 group-hover:bg-white/30 transition-colors">
                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                            </svg>
                        </span>
                        Buat Undangan Baru
                    </a>
                </div>

                {{-- Stat Strip --}}
                <div class="mt-7 grid grid-cols-4 gap-px bg-neutral-200/70 dark:bg-secondary-700/50 rounded-2xl overflow-hidden border border-neutral-200/80 dark:border-secondary-700/50">
                    @php
                        $stats = [
                            ['label' => 'Total Undangan',  'value' => $totalInvitations,  'color' => 'text-secondary-800 dark:text-neutral-100'],
                            ['label' => 'Aktif',           'value' => $activeInvitations,  'color' => 'text-emerald-600 dark:text-emerald-400'],
                            ['label' => 'Masa Percobaan',  'value' => $trialCount,         'color' => 'text-amber-600 dark:text-amber-400'],
                            ['label' => 'Pesanan Tertunda','value' => $pendingCount,        'color' => 'text-blue-600 dark:text-blue-400'],
                        ];
                    @endphp

                    @foreach($stats as $stat)
                        <div class="bg-white/80 dark:bg-secondary-800/70 px-3 sm:px-5 py-4 flex flex-col items-center sm:items-start text-center sm:text-left backdrop-blur-sm">
                            <span class="stat-value text-xl sm:text-2xl font-bold {{ $stat['color'] }} tabular-nums">{{ $stat['value'] }}</span>
                            <span class="text-[10px] sm:text-xs text-neutral-500 dark:text-neutral-400 font-medium mt-0.5 leading-tight">{{ $stat['label'] }}</span>
                        </div>
                    @endforeach
                </div>

            </div>
        </div>

        {{-- ─────────────────────────────────────────────────────────────────────
             MAIN CONTENT
        ──────────────────────────────────────────────────────────────────────── --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-7 sm:py-8 space-y-6">

            {{-- ── Trial Countdown Banners ── --}}
            @foreach($trialInvitations as $invitation)
                @php
                    $days      = $invitation->trialRemainingDays();
                    $hours     = $invitation->trialRemainingHours();
                    $isUrgent  = $invitation->isTrialUrgent();
                    $isExpired = $invitation->isTrialExpired();
                @endphp

                <div class="relative overflow-hidden rounded-2xl border transition-all duration-300
                    {{ $isExpired
                        ? 'bg-red-50/80 dark:bg-red-950/30 border-red-200/80 dark:border-red-800/50'
                        : ($isUrgent
                            ? 'bg-amber-50/80 dark:bg-amber-950/30 border-amber-200/80 dark:border-amber-800/50'
                            : 'bg-primary-50/70 dark:bg-secondary-800/90 border-primary-200/70 dark:border-primary-800/40')
                    }}">

                    {{-- Accent left border --}}
                    <div class="absolute left-0 top-0 bottom-0 w-1 rounded-l-2xl
                        {{ $isExpired ? 'bg-red-400' : ($isUrgent ? 'bg-amber-400' : 'bg-primary') }}"></div>

                    <div class="pl-5 pr-4 py-4 sm:pl-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 text-secondary-800 dark:text-neutral-200">
                        <div class="flex items-start gap-3">
                            {{-- Status dot --}}
                            <div class="mt-1 flex-shrink-0 w-2 h-2 rounded-full {{ $isExpired ? 'bg-red-500' : ($isUrgent ? 'bg-amber-500 animate-pulse' : 'bg-primary animate-pulse') }}"></div>

                            <div>
                                <h4 class="font-semibold text-sm
                                    {{ $isExpired ? 'text-red-800 dark:text-red-300' : ($isUrgent ? 'text-amber-800 dark:text-amber-300' : 'text-secondary-800 dark:text-neutral-100') }}">
                                    {{ $invitation->title }}
                                </h4>
                                @if($isExpired)
                                    <p class="text-xs text-red-600 dark:text-red-400 mt-0.5">
                                        Masa uji coba <strong>telah berakhir</strong> — aktifkan kembali untuk melanjutkan.
                                    </p>
                                @else
                                    <p class="text-xs mt-0.5 {{ $isUrgent ? 'text-amber-700 dark:text-amber-400' : 'text-neutral-600 dark:text-neutral-400' }}">
                                        Masa uji coba tersisa
                                        <strong class="font-semibold">{{ $days }}h {{ $hours }}j</strong>
                                        @if($isUrgent)
                                            <span class="ml-1 text-amber-600 dark:text-amber-400 font-semibold">— Segera aktifkan!</span>
                                        @endif
                                    </p>
                                @endif
                            </div>
                        </div>

                        <a href="{{ route('dashboard.checkout', ['invitation_id' => $invitation->id]) }}"
                           class="self-start sm:self-auto inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-semibold transition-all whitespace-nowrap
                               {{ $isExpired
                                   ? 'bg-red-600 text-white hover:bg-red-700 shadow-sm shadow-red-500/20'
                                   : ($isUrgent
                                       ? 'bg-amber-500 text-white hover:bg-amber-600 shadow-sm shadow-amber-500/20'
                                       : 'bg-primary text-white hover:bg-primary-600 shadow-sm shadow-primary/20')
                               }}">
                            Aktifkan Sekarang
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                            </svg>
                        </a>
                    </div>
                </div>
            @endforeach

            {{-- ── Pending Orders ── --}}
            @if($pendingOrders->isNotEmpty())
                <div class="bg-white dark:bg-secondary-800 rounded-2xl border border-neutral-200/80 dark:border-secondary-700/60 overflow-hidden shadow-sm">
                    {{-- Header --}}
                    <div class="px-5 sm:px-6 py-4 flex items-center justify-between border-b border-neutral-100 dark:border-secondary-700/60">
                        <div class="flex items-center gap-2.5">
                            <div class="w-2 h-2 rounded-full bg-amber-400 animate-pulse"></div>
                            <h2 class="font-semibold text-sm sm:text-base text-secondary-800 dark:text-neutral-100">
                                Menunggu Pembayaran
                            </h2>
                            <span class="inline-flex items-center justify-center w-5 h-5 rounded-full bg-amber-100 dark:bg-amber-900/40 text-amber-700 dark:text-amber-400 text-xs font-bold">
                                {{ $pendingOrders->count() }}
                            </span>
                        </div>
                    </div>

                    {{-- Orders list --}}
                    <div class="divide-y divide-neutral-100 dark:divide-secondary-700/60">
                        @foreach($pendingOrders as $order)
                            <div class="px-5 sm:px-6 py-4 hover:bg-neutral-50/70 dark:hover:bg-secondary-700/20 transition-colors">
                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                                    <div class="flex-1 min-w-0">
                                        <div class="flex flex-wrap items-center gap-2 mb-1.5">
                                            <span class="font-mono font-bold text-primary dark:text-primary-400 text-xs tracking-wider">{{ $order->invoice_id }}</span>
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-semibold
                                                {{ $order->payment_status === 'pending'
                                                    ? 'bg-amber-100 dark:bg-amber-900/40 text-amber-700 dark:text-amber-300'
                                                    : 'bg-blue-100 dark:bg-blue-900/40 text-blue-700 dark:text-blue-300' }}">
                                                <span class="w-1.5 h-1.5 rounded-full {{ $order->payment_status === 'pending' ? 'bg-amber-500' : 'bg-blue-500' }}"></span>
                                                {{ $order->payment_status === 'pending' ? 'Menunggu Pembayaran' : 'Verifikasi (WA)' }}
                                            </span>
                                        </div>
                                        <div class="flex flex-wrap gap-x-4 gap-y-0.5 text-xs text-neutral-500 dark:text-neutral-400">
                                            <span>Paket <span class="font-semibold text-secondary-700 dark:text-neutral-300">{{ ucfirst($order->package_type) }}</span></span>
                                            <span>Total <span class="font-semibold text-secondary-700 dark:text-neutral-300">Rp{{ $order->total_with_code }}</span></span>
                                            <span>Kode unik <span class="font-semibold text-primary dark:text-primary-400 font-mono">{{ $order->unique_code }}</span></span>
                                        </div>
                                    </div>
                                    <div class="flex-shrink-0">
                                        @if($order->payment_status === 'pending' && $order->is_manual_whatsapp)
                                            <a href="{{ route('dashboard.payment.invoice', $order) }}"
                                               class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-emerald-600 text-white rounded-xl text-xs font-semibold hover:bg-emerald-700 transition-colors shadow-sm shadow-emerald-500/20">
                                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                                                </svg>
                                                Kirim Bukti WA
                                            </a>
                                        @elseif($order->payment_status === 'pending' && $order->payment_method_used === 'doku')
                                            <a href="{{ route('dashboard.payment.doku.invoice', $order) }}"
                                               class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-red-600 text-white rounded-xl text-xs font-semibold hover:bg-red-700 transition-colors shadow-sm shadow-red-500/20">
                                                Lanjutkan Bayar
                                            </a>
                                        @elseif($order->payment_status === 'verifying')
                                            <a href="{{ route('dashboard.payment.invoice', $order) }}"
                                               class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-blue-100 dark:bg-blue-900/40 text-blue-700 dark:text-blue-300 rounded-xl text-xs font-semibold hover:bg-blue-200 dark:hover:bg-blue-900/60 transition-colors">
                                                Lihat Status
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- ── Invitation List ── --}}
            <div>
                {{-- Section header --}}
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h2 class="font-heading text-lg sm:text-xl font-bold text-secondary-800 dark:text-neutral-100">
                            Undangan Saya
                        </h2>
                        @if($invitations->isNotEmpty())
                            <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-0.5">{{ $invitations->count() }} undangan dibuat</p>
                        @endif
                    </div>
                    @if($invitations->isNotEmpty())
                        <a href="{{ route('dashboard.invitations.create') }}"
                            class="inline-flex items-center gap-1.5 px-3.5 py-2 text-xs font-semibold text-primary dark:text-primary-400 border border-primary/30 dark:border-primary-700/50 rounded-xl hover:bg-primary-50 dark:hover:bg-primary-900/20 transition-all">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                            </svg>
                            Tambah Baru
                        </a>
                    @endif
                </div>

                @if($invitations->isEmpty())
                    {{-- ── Empty State ── --}}
                    <div class="bg-white dark:bg-secondary-800 rounded-2xl border border-neutral-200/70 dark:border-secondary-700/60 px-6 py-16 sm:py-20 text-center">
                        {{-- Decorative ring --}}
                        <div class="relative inline-flex mb-6">
                            <div class="w-20 h-20 rounded-full bg-primary-50 dark:bg-primary-900/20 flex items-center justify-center">
                                <div class="w-14 h-14 rounded-full bg-primary-100 dark:bg-primary-900/40 flex items-center justify-center">
                                    <svg class="w-7 h-7 text-primary dark:text-primary-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            </div>
                            {{-- Floating sparkle dots --}}
                            <span class="absolute top-1 right-1 w-3 h-3 rounded-full bg-primary-200 dark:bg-primary-700 opacity-70"></span>
                            <span class="absolute bottom-2 left-0 w-2 h-2 rounded-full bg-amber-300 dark:bg-amber-600 opacity-60"></span>
                        </div>

                        <h3 class="font-heading text-xl font-bold text-secondary-800 dark:text-neutral-100 mb-2">
                            Belum ada undangan
                        </h3>
                        <p class="text-sm text-neutral-500 dark:text-neutral-400 max-w-xs mx-auto mb-7 leading-relaxed">
                            Buat undangan digital pertama Anda dan mulai rayakan setiap momen spesial dengan elegan.
                        </p>
                        <a href="{{ route('dashboard.invitations.create') }}"
                            class="inline-flex items-center gap-2.5 px-6 py-3 bg-gradient-to-br from-primary to-primary-600 text-white rounded-2xl font-semibold text-sm shadow-lg shadow-primary/25 hover:shadow-xl hover:shadow-primary/30 hover:-translate-y-0.5 transition-all duration-200">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                            </svg>
                            Buat Undangan Pertama
                        </a>
                    </div>

                @else
                    {{-- ── Invitation Grid ── --}}
                    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-3 sm:gap-4">
                        @foreach($invitations as $invitation)
                            @php
                                $tierCode = $invitation->currentTier();
                                $tierLabel = match($tierCode) {
                                    'bronze'   => 'Bronze',
                                    'silver'   => 'Silver',
                                    'gold'     => 'Gold',
                                    'platinum' => 'Platinum',
                                    'free'     => 'Gratis',
                                    default    => ucfirst($tierCode),
                                };
                                $tierStyle = match($tierCode) {
                                    'bronze'   => 'bg-orange-500/80 text-white',
                                    'silver'   => 'bg-neutral-500/70 text-white',
                                    'gold'     => 'bg-amber-500/80 text-white',
                                    'platinum' => 'bg-primary/80 text-white',
                                    default    => 'bg-neutral-900/50 text-white',
                                };
                                $isExpired = $invitation->isTrialExpired();
                                $isTrial   = $invitation->expires_at !== null && !$invitation->hasPremiumFeatures();
                                $daysLeft  = $invitation->expires_at
                                    ? (int) max(0, now()->diffInDays($invitation->expires_at, false))
                                    : null;
                            @endphp

                            <div class="inv-card group relative bg-white dark:bg-secondary-800 rounded-xl overflow-hidden border border-neutral-200/80 dark:border-secondary-700/60
                                hover:shadow-lg hover:shadow-black/8 dark:hover:shadow-black/30 hover:-translate-y-1 hover:border-primary-200/60 dark:hover:border-primary-800/40
                                transition-all duration-250 shimmer-on-hover
                                {{ $isExpired ? 'opacity-65 grayscale-[30%]' : '' }}">

                                {{-- Cover Image --}}
                                <a href="{{ route('dashboard.invitations.show', $invitation) }}" class="block">
                                    <div class="relative aspect-[4/3] bg-neutral-100 dark:bg-secondary-700 overflow-hidden">
                                        @if($invitation->cover_photo)
                                            <img src="{{ asset('storage/' . $invitation->cover_photo) }}"
                                                 alt="{{ $invitation->title }}"
                                                 class="w-full h-full object-cover group-hover:scale-[1.06] transition-transform duration-500 ease-out">
                                        @else
                                            <div class="w-full h-full flex flex-col items-center justify-center gap-2 bg-gradient-to-br from-neutral-100 to-neutral-200 dark:from-secondary-700 dark:to-secondary-800">
                                                <svg class="w-9 h-9 text-neutral-300 dark:text-neutral-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                        @endif

                                        {{-- Gradient overlay on hover --}}
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-black/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

                                        {{-- Tier badge --}}
                                        <span class="absolute top-2 left-2 inline-flex items-center px-2 py-0.5 rounded-md text-[9px] sm:text-[10px] font-bold uppercase tracking-wider backdrop-blur-sm {{ $tierStyle }}">
                                            {{ $tierLabel }}
                                        </span>

                                        {{-- Expiry date --}}
                                        @if($invitation->expires_at)
                                            <span class="absolute bottom-2 left-2 inline-flex items-center gap-1 px-1.5 py-0.5 rounded-md text-[9px] sm:text-[10px] font-medium bg-black/50 text-white backdrop-blur-sm">
                                                <svg class="w-2.5 h-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                                {{ $invitation->expires_at->format('d/m/Y') }}
                                            </span>
                                        @endif
                                    </div>
                                </a>

                                {{-- Card body --}}
                                <div class="p-3">
                                    <a href="{{ route('dashboard.invitations.show', $invitation) }}" class="block">
                                        <h3 class="font-semibold text-xs sm:text-sm text-secondary-800 dark:text-neutral-100 truncate leading-snug">{{ $invitation->title }}</h3>
                                        <p class="text-[10px] sm:text-xs text-neutral-500 dark:text-neutral-400 mt-0.5 truncate">{{ $invitation->couple_name }}</p>
                                    </a>

                                    {{-- Status + days --}}
                                    <div class="flex items-center gap-1.5 mt-2">
                                        @if($isExpired)
                                            <span class="inline-flex items-center gap-1 px-1.5 py-0.5 rounded-md text-[9px] sm:text-[10px] font-semibold bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400">
                                                <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>Kedaluwarsa
                                            </span>
                                        @elseif($isTrial)
                                            <span class="inline-flex items-center gap-1 px-1.5 py-0.5 rounded-md text-[9px] sm:text-[10px] font-semibold bg-amber-100 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400">
                                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>Percobaan
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 px-1.5 py-0.5 rounded-md text-[9px] sm:text-[10px] font-semibold bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>Aktif
                                            </span>
                                        @endif
                                        @if($daysLeft !== null)
                                            <span class="text-[9px] sm:text-[10px] font-medium ml-auto {{ $daysLeft <= 7 ? 'text-red-500 dark:text-red-400' : 'text-neutral-400 dark:text-neutral-500' }}">
                                                {{ $daysLeft }}h
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                {{-- Action bar — slides up on hover --}}
                                <div class="inv-card-actions absolute bottom-0 inset-x-0 flex items-stretch bg-white/95 dark:bg-secondary-800/95 backdrop-blur-sm border-t border-neutral-100 dark:border-secondary-700/60">
                                    <a href="{{ route('invitation.show', $invitation->slug) }}" target="_blank" rel="noopener"
                                        class="flex-1 flex items-center justify-center gap-1.5 py-2.5 text-[10px] sm:text-xs font-medium text-neutral-600 dark:text-neutral-400 hover:text-primary dark:hover:text-primary-400 hover:bg-primary-50/50 dark:hover:bg-primary-900/10 transition-colors border-r border-neutral-100 dark:border-secondary-700/60"
                                        title="Lihat Undangan">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                        </svg>
                                        <span class="hidden sm:inline">Lihat</span>
                                    </a>
                                    <a href="{{ route('dashboard.invitations.edit', $invitation) }}"
                                        class="flex-1 flex items-center justify-center gap-1.5 py-2.5 text-[10px] sm:text-xs font-medium text-neutral-600 dark:text-neutral-400 hover:text-secondary-800 dark:hover:text-neutral-200 hover:bg-neutral-50 dark:hover:bg-secondary-700/40 transition-colors border-r border-neutral-100 dark:border-secondary-700/60"
                                        title="Edit Undangan">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                        <span class="hidden sm:inline">Edit</span>
                                    </a>
                                    <form action="{{ route('dashboard.invitations.destroy', $invitation) }}" method="POST"
                                        onsubmit="return confirmSwal(event, 'Yakin ingin menghapus undangan &quot;{{ $invitation->title }}&quot;?');"
                                        class="flex-1">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="w-full h-full flex items-center justify-center gap-1.5 py-2.5 text-[10px] sm:text-xs font-medium text-neutral-500 dark:text-neutral-500 hover:text-red-600 dark:hover:text-red-400 hover:bg-red-50/50 dark:hover:bg-red-900/10 transition-colors"
                                            title="Hapus Undangan">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                            <span class="hidden sm:inline">Hapus</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
