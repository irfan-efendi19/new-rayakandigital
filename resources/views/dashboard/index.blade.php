<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-heading text-2xl font-bold text-secondary-800 dark:text-neutral-100">Dashboard</h2>
                <p class="text-sm text-neutral-500 dark:text-neutral-400 mt-0.5">Selamat datang kembali, {{ Auth::user()->name }}!</p>
            </div>
            <a href="{{ route('dashboard.invitations.create') }}"
                class="inline-flex items-center gap-2 px-3 sm:px-5 py-2.5 bg-gradient-to-r from-primary to-primary-600 text-white rounded-xl font-semibold text-sm shadow-soft hover:shadow-md hover:scale-[1.02] active:scale-[0.98] transition-all duration-200">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                <span class="hidden sm:inline">Buat Undangan Baru</span>
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- Stats Cards --}}
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
                <div class="relative bg-white dark:bg-secondary-800 rounded-xl sm:rounded-2xl shadow-sm p-4 sm:p-5 border border-neutral-100 dark:border-secondary-700 overflow-hidden">
                    <div class="absolute top-0 right-0 w-20 h-20 bg-primary-500/5 rounded-bl-full"></div>
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs sm:text-sm text-neutral-500 dark:text-neutral-400 font-medium">Total Undangan</p>
                            <p class="text-xl sm:text-2xl font-bold text-secondary-800 dark:text-neutral-100 mt-0.5">{{ $invitations->count() }}</p>
                        </div>
                        <div class="w-9 h-9 sm:w-11 sm:h-11 rounded-lg sm:rounded-xl bg-primary-50 dark:bg-primary-900/50 flex items-center justify-center text-primary dark:text-primary-400">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="relative bg-white dark:bg-secondary-800 rounded-xl sm:rounded-2xl shadow-sm p-4 sm:p-5 border border-neutral-100 dark:border-secondary-700 overflow-hidden">
                    <div class="absolute top-0 right-0 w-20 h-20 bg-green-500/5 rounded-bl-full"></div>
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs sm:text-sm text-neutral-500 dark:text-neutral-400 font-medium">Aktif</p>
                            <p class="text-xl sm:text-2xl font-bold text-green-600 dark:text-green-400 mt-0.5">{{ $invitations->filter(fn($i) => !$i->isTrialExpired())->count() }}</p>
                        </div>
                        <div class="w-9 h-9 sm:w-11 sm:h-11 rounded-lg sm:rounded-xl bg-green-50 dark:bg-green-900/50 flex items-center justify-center text-green-500 dark:text-green-400">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="relative bg-white dark:bg-secondary-800 rounded-xl sm:rounded-2xl shadow-sm p-4 sm:p-5 border border-neutral-100 dark:border-secondary-700 overflow-hidden">
                    <div class="absolute top-0 right-0 w-20 h-20 bg-amber-500/5 rounded-bl-full"></div>
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs sm:text-sm text-neutral-500 dark:text-neutral-400 font-medium">Masa Percobaan</p>
                            <p class="text-xl sm:text-2xl font-bold text-amber-600 dark:text-amber-400 mt-0.5">{{ $trialInvitations->count() }}</p>
                        </div>
                        <div class="w-9 h-9 sm:w-11 sm:h-11 rounded-lg sm:rounded-xl bg-amber-50 dark:bg-amber-900/50 flex items-center justify-center text-amber-500 dark:text-amber-400">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="relative bg-white dark:bg-secondary-800 rounded-xl sm:rounded-2xl shadow-sm p-4 sm:p-5 border border-neutral-100 dark:border-secondary-700 overflow-hidden">
                    <div class="absolute top-0 right-0 w-20 h-20 bg-blue-500/5 rounded-bl-full"></div>
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs sm:text-sm text-neutral-500 dark:text-neutral-400 font-medium">Pesanan Tertunda</p>
                            <p class="text-xl sm:text-2xl font-bold text-blue-600 dark:text-blue-400 mt-0.5">{{ $pendingOrders->count() }}</p>
                        </div>
                        <div class="w-9 h-9 sm:w-11 sm:h-11 rounded-lg sm:rounded-xl bg-blue-50 dark:bg-blue-900/50 flex items-center justify-center text-blue-500 dark:text-blue-400">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Trial Countdown Banners --}}
            @foreach($trialInvitations as $invitation)
                @php
                    $days = $invitation->trialRemainingDays();
                    $hours = $invitation->trialRemainingHours();
                    $isUrgent = $invitation->isTrialUrgent();
                    $isExpired = $invitation->isTrialExpired();
                @endphp

                <div class="rounded-xl overflow-hidden border transition-all duration-300
                    {{ $isExpired ? 'bg-red-50 dark:bg-red-900/20 border-red-200 dark:border-red-800' : ($isUrgent ? 'bg-amber-50 dark:bg-amber-900/20 border-amber-200 dark:border-amber-800' : 'bg-primary-50 dark:bg-primary-900/20 border-primary-200 dark:border-primary-800') }}">
                    <div class="p-4 sm:p-5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div class="flex items-start gap-3 sm:gap-4">
                            <div class="flex-shrink-0 mt-0.5 w-8 h-8 sm:w-10 sm:h-10 rounded-lg flex items-center justify-center
                                {{ $isExpired ? 'bg-red-100 dark:bg-red-900/50 text-red-500' : ($isUrgent ? 'bg-amber-100 dark:bg-amber-900/50 text-amber-500' : 'bg-primary-100 dark:bg-primary-900/50 text-primary') }}">
                                @if($isExpired)
                                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z" />
                                    </svg>
                                @elseif($isUrgent)
                                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                @else
                                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                @endif
                            </div>
                            <div>
                                <h4 class="font-semibold text-sm {{ $isExpired ? 'text-red-800 dark:text-red-300' : ($isUrgent ? 'text-amber-800 dark:text-amber-300' : 'text-primary-800 dark:text-primary-300') }}">
                                    {{ $invitation->title }}
                                </h4>
                                @if($isExpired)
                                    <p class="text-sm text-red-600 dark:text-red-400 mt-1">
                                        Masa uji coba telah <strong>berakhir</strong>. Aktifkan kembali untuk melanjutkan penggunaan.
                                    </p>
                                @else
                                    <p class="text-sm mt-1 {{ $isUrgent ? 'text-amber-700 dark:text-amber-400' : 'text-primary-700 dark:text-primary-400' }}">
                                        Masa uji coba tersisa <strong>{{ $days }} Hari {{ $hours }} Jam</strong>
                                        @if($isUrgent)
                                            <span class="inline-block ml-2 animate-pulse text-amber-600 dark:text-amber-400 font-semibold">Segera aktifkan!</span>
                                        @endif
                                    </p>
                                @endif
                            </div>
                        </div>
                        <a href="{{ route('dashboard.checkout', ['invitation_id' => $invitation->id]) }}"
                           class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl text-sm font-semibold shadow-sm transition-all whitespace-nowrap
                            {{ $isExpired ? 'bg-red-600 text-white hover:bg-red-700' : ($isUrgent ? 'bg-amber-600 text-white hover:bg-amber-700' : 'bg-gradient-to-r from-primary to-primary-600 text-white hover:shadow-md') }}">
                            Aktifkan Undangan
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                            </svg>
                        </a>
                    </div>
                </div>
            @endforeach

            {{-- Pending Orders --}}
            @if($pendingOrders->isNotEmpty())
                <div class="bg-white dark:bg-secondary-800 rounded-xl sm:rounded-2xl shadow-sm border border-neutral-100 dark:border-secondary-700 overflow-hidden">
                    <div class="px-4 sm:px-6 py-4 border-b border-neutral-100 dark:border-secondary-700">
                        <div class="flex items-center gap-2">
                            <div class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></div>
                            <h3 class="font-heading text-base sm:text-lg font-bold text-secondary-800 dark:text-neutral-100">Pesanan Menunggu Pembayaran</h3>
                        </div>
                    </div>
                    <div class="divide-y divide-neutral-100 dark:divide-secondary-700">
                        @foreach($pendingOrders as $order)
                            <div class="px-4 sm:px-6 py-4 hover:bg-neutral-50 dark:hover:bg-secondary-700/30 transition-colors">
                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center gap-2 mb-1.5">
                                            <span class="font-mono font-bold text-primary-700 dark:text-primary-400 text-sm">{{ $order->invoice_id }}</span>
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium
                                                {{ $order->payment_status === 'pending' ? 'bg-amber-100 dark:bg-amber-900/50 text-amber-800 dark:text-amber-300' : 'bg-blue-100 dark:bg-blue-900/50 text-blue-800 dark:text-blue-300' }}">
                                                {{ $order->payment_status === 'pending' ? 'Menunggu Pembayaran' : 'Verifikasi (WA)' }}
                                            </span>
                                        </div>
                                        <div class="flex flex-wrap gap-x-4 gap-y-1 text-xs sm:text-sm text-neutral-600 dark:text-neutral-400">
                                            <span>Paket: <strong class="text-secondary-800 dark:text-neutral-200">{{ ucfirst($order->package_type) }}</strong></span>
                                            <span>Total: <strong class="text-secondary-800 dark:text-neutral-200">Rp{{ $order->total_with_code }}</strong></span>
                                            <span>Kode: <strong class="text-primary-600 dark:text-primary-400">{{ $order->unique_code }}</strong></span>
                                        </div>
                                    </div>
                                    <div class="flex-shrink-0">
                                        @if($order->payment_status === 'pending' && $order->is_manual_whatsapp)
                                            <a href="{{ route('dashboard.payment.invoice', $order) }}"
                                               class="inline-flex items-center gap-2 px-4 py-2 bg-green-600 text-white rounded-lg text-sm font-semibold hover:bg-green-700 transition-colors">
                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                                                </svg>
                                                Kirim Bukti via WA
                                            </a>
                                        @elseif($order->payment_status === 'verifying')
                                            <a href="{{ route('dashboard.payment.invoice', $order) }}"
                                               class="inline-flex items-center gap-2 px-4 py-2 bg-blue-100 dark:bg-blue-900/50 text-blue-700 dark:text-blue-300 rounded-lg text-sm font-semibold hover:bg-blue-200 dark:hover:bg-blue-900/70 transition-colors">
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

            {{-- Invitation List --}}
            <div class="bg-white dark:bg-secondary-800 rounded-xl sm:rounded-2xl shadow-sm border border-neutral-100 dark:border-secondary-700 overflow-hidden">
                <div class="px-4 sm:px-6 py-4 border-b border-neutral-100 dark:border-secondary-700">
                    <div class="flex items-center justify-between">
                        <h3 class="font-heading text-base sm:text-lg font-bold text-secondary-800 dark:text-neutral-100">Daftar Undangan</h3>
                        <a href="{{ route('dashboard.invitations.create') }}"
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 sm:px-4 sm:py-2 bg-gradient-to-r from-primary to-primary-600 text-white rounded-lg sm:rounded-xl text-xs sm:text-sm font-semibold hover:shadow-md transition-all">
                            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            <span class="hidden sm:inline">Undangan Baru</span>
                            <span class="sm:hidden">Baru</span>
                        </a>
                    </div>
                </div>

                <div class="p-4 sm:p-6">
                    @if($invitations->isEmpty())
                        <div class="text-center py-12 sm:py-16">
                            <div class="w-14 h-14 sm:w-16 sm:h-16 mx-auto mb-4 rounded-xl sm:rounded-2xl bg-neutral-100 dark:bg-secondary-700 flex items-center justify-center">
                                <svg class="w-7 h-7 sm:w-8 sm:h-8 text-neutral-400 dark:text-neutral-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <h4 class="text-base sm:text-lg font-semibold text-secondary-800 dark:text-neutral-100 mb-1">Belum Ada Undangan</h4>
                            <p class="text-sm text-neutral-500 dark:text-neutral-400 mb-6">Buat undangan digital pertama Anda dan mulai rayakan momen spesial.</p>
                            <a href="{{ route('dashboard.invitations.create') }}"
                                class="inline-flex items-center gap-2 px-5 py-2.5 sm:px-6 sm:py-3 bg-gradient-to-r from-primary to-primary-600 text-white rounded-lg sm:rounded-xl font-semibold text-sm shadow-soft hover:shadow-md transition-all">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                Buat Undangan
                            </a>
                        </div>
                    @else
                        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-3 sm:gap-4">
                            @foreach($invitations as $invitation)
                                <div class="group relative bg-neutral-50 dark:bg-secondary-900/50 rounded-lg sm:rounded-xl overflow-hidden border border-neutral-200 dark:border-secondary-700 hover:shadow-md hover:border-primary-200 dark:hover:border-primary-800 transition-all duration-200
                                    {{ $invitation->isTrialExpired() ? 'opacity-50' : '' }}">
                                    <a href="{{ route('dashboard.invitations.show', $invitation) }}" class="block">
                                        <div class="aspect-[4/3] bg-neutral-100 dark:bg-secondary-700 overflow-hidden">
                                            @if($invitation->cover_photo)
                                                <img src="{{ asset('storage/' . $invitation->cover_photo) }}" alt="Cover" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center text-neutral-300 dark:text-neutral-600">
                                                    <svg class="w-8 h-8 sm:w-10 sm:h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="p-2.5 sm:p-3">
                                            <div class="flex items-start justify-between gap-1">
                                                <h4 class="font-semibold text-xs sm:text-sm text-secondary-800 dark:text-neutral-100 truncate flex-1">{{ $invitation->title }}</h4>
                                                @php
                                                    $tierCode = $invitation->currentTier();
                                                    $tierBadgeColor = match($tierCode) {
                                                        'bronze' => 'bg-orange-100 dark:bg-orange-900/50 text-orange-700 dark:text-orange-300',
                                                        'silver' => 'bg-neutral-100 dark:bg-neutral-700 text-neutral-700 dark:text-neutral-300',
                                                        'gold' => 'bg-amber-100 dark:bg-amber-900/50 text-amber-700 dark:text-amber-300',
                                                        'platinum' => 'bg-primary-100 dark:bg-primary-900/50 text-primary-700 dark:text-primary-300',
                                                        default => 'bg-neutral-100 dark:bg-neutral-700 text-neutral-500 dark:text-neutral-400'
                                                    };
                                                @endphp
                                                <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] sm:text-xs font-semibold whitespace-nowrap uppercase tracking-wider {{ $tierBadgeColor }}">
                                                    {{ $tierCode === 'free' ? 'Gratis' : $tierCode }}
                                                </span>
                                            </div>
                                            <p class="text-[10px] sm:text-xs text-neutral-500 dark:text-neutral-400 mt-0.5 truncate">{{ $invitation->bride_name }} & {{ $invitation->groom_name }}</p>
                                            <div class="flex items-center gap-1.5 mt-1">
                                                @php
                                                    $isExpired = $invitation->isTrialExpired();
                                                    $isTrial = $invitation->expires_at !== null && !$invitation->hasPremiumFeatures();
                                                    $daysLeft = $invitation->expires_at ? (int) max(0, now()->diffInDays($invitation->expires_at, false)) : null;
                                                @endphp
                                                @if($isExpired)
                                                    <span class="inline-flex items-center px-1 py-0.5 rounded text-[9px] sm:text-[10px] font-medium bg-red-100 dark:bg-red-900/50 text-red-700 dark:text-red-300">Kedaluwarsa</span>
                                                @elseif($isTrial)
                                                    <span class="inline-flex items-center px-1 py-0.5 rounded text-[9px] sm:text-[10px] font-medium bg-amber-100 dark:bg-amber-900/50 text-amber-700 dark:text-amber-300">Masa Percobaan</span>
                                                @endif
                                                @if($invitation->expires_at)
                                                    <span class="text-[9px] sm:text-[10px] text-neutral-400 dark:text-neutral-500">{{ $invitation->expires_at->format('d/m/Y') }}</span>
                                                    @if($daysLeft !== null)
                                                        <span class="text-[9px] sm:text-[10px] font-medium {{ $daysLeft <= 7 ? 'text-red-500' : 'text-neutral-400 dark:text-neutral-500' }}">{{ $daysLeft }} Hari</span>
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                    </a>
                                    <div class="absolute top-1.5 right-1.5 sm:top-2 sm:right-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                        <form action="{{ route('dashboard.invitations.destroy', $invitation) }}" method="POST"
                                            onsubmit="return confirmSwal(event, 'Yakin ingin menghapus undangan &quot;{{ $invitation->title }}&quot;?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="w-6 h-6 sm:w-7 sm:h-7 rounded-full bg-white/90 dark:bg-secondary-800/90 shadow-sm flex items-center justify-center text-red-400 hover:text-red-600 transition-colors backdrop-blur-sm"
                                                title="Hapus Undangan">
                                                <svg class="w-3 h-3 sm:w-3.5 sm:h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
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
    </div>
</x-app-layout>
