<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h2 class="font-heading text-2xl font-bold text-secondary-800">
                    Dashboard
                </h2>
                <p class="text-sm text-neutral-500 mt-0.5">Selamat datang kembali, {{ Auth::user()->name }}!</p>
            </div>
            <a href="{{ route('dashboard.invitations.create') }}"
                class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-primary to-primary-600 text-white rounded-xl font-semibold text-sm shadow-soft hover:shadow-md hover:scale-[1.02] active:scale-[0.98] transition-all duration-200">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Buat Undangan Baru
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Stats Cards --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                <div class="bg-white rounded-2xl shadow-soft p-5 border border-neutral-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-neutral-500 font-medium">Total Undangan</p>
                            <p class="text-2xl font-bold text-secondary-800 mt-1">{{ $invitations->count() }}</p>
                        </div>
                        <div class="w-11 h-11 rounded-xl bg-primary-50 flex items-center justify-center text-primary">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-2xl shadow-soft p-5 border border-neutral-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-neutral-500 font-medium">Aktif</p>
                            <p class="text-2xl font-bold text-green-600 mt-1">{{ $invitations->filter(fn($i) => !$i->isTrialExpired())->count() }}</p>
                        </div>
                        <div class="w-11 h-11 rounded-xl bg-green-50 flex items-center justify-center text-green-500">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-2xl shadow-soft p-5 border border-neutral-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-neutral-500 font-medium">Masa Percobaan</p>
                            <p class="text-2xl font-bold text-amber-600 mt-1">{{ $trialInvitations->count() }}</p>
                        </div>
                        <div class="w-11 h-11 rounded-xl bg-amber-50 flex items-center justify-center text-amber-500">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-2xl shadow-soft p-5 border border-neutral-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-neutral-500 font-medium">Pesanan Tertunda</p>
                            <p class="text-2xl font-bold text-blue-600 mt-1">{{ $pendingOrders->count() }}</p>
                        </div>
                        <div class="w-11 h-11 rounded-xl bg-blue-50 flex items-center justify-center text-blue-500">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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

                <div class="mb-4 rounded-2xl overflow-hidden border transition-all duration-300
                    {{ $isExpired ? 'bg-red-50 border-red-200' : ($isUrgent ? 'bg-amber-50 border-amber-200' : 'bg-primary-50 border-primary-200') }}">
                    <div class="p-5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div class="flex items-start gap-4">
                            <div class="flex-shrink-0 mt-1">
                                @if($isExpired)
                                    <svg class="w-6 h-6 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z" />
                                    </svg>
                                @elseif($isUrgent)
                                    <svg class="w-6 h-6 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                @else
                                    <svg class="w-6 h-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                @endif
                            </div>
                            <div>
                                <h4 class="font-semibold text-sm {{ $isExpired ? 'text-red-800' : ($isUrgent ? 'text-amber-800' : 'text-primary-800') }}">
                                    Undangan: {{ $invitation->title }}
                                </h4>
                                @if($isExpired)
                                    <p class="text-sm text-red-600 mt-1">
                                        Masa uji coba gratis Anda telah <strong>berakhir</strong>. Aktifkan kembali untuk melanjutkan penggunaan.
                                    </p>
                                @else
                                    <p class="text-sm mt-1 {{ $isUrgent ? 'text-amber-700' : 'text-primary-700' }}">
                                        Masa uji coba gratis Anda tersisa
                                        <strong>{{ $days }} Hari {{ $hours }} Jam</strong> lagi
                                        @if($isUrgent)
                                            <span class="inline-block ml-2 animate-pulse text-amber-600">Segera aktifkan!</span>
                                        @endif
                                    </p>
                                @endif
                            </div>
                        </div>
                        <div class="flex-shrink-0">
                            <a href="{{ route('dashboard.checkout', ['invitation_id' => $invitation->id]) }}"
                               class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-semibold shadow-sm transition-all
                                {{ $isExpired ? 'bg-red-600 text-white hover:bg-red-700' : ($isUrgent ? 'bg-amber-600 text-white hover:bg-amber-700' : 'bg-gradient-to-r from-primary to-primary-600 text-white hover:shadow-md') }}">
                                Aktifkan Undangan
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach

            {{-- Pending Orders --}}
            @if($pendingOrders->isNotEmpty())
                <div class="mb-8">
                    <h3 class="font-heading text-lg font-bold text-secondary-800 mb-4">Pesanan Menunggu Pembayaran</h3>
                    <div class="space-y-4">
                        @foreach($pendingOrders as $order)
                            <div class="bg-white border border-neutral-200 rounded-2xl p-5 shadow-soft hover:shadow-md transition-shadow">
                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                                    <div class="flex-1">
                                        <div class="flex items-center gap-3 mb-2">
                                            <span class="font-mono font-bold text-primary-700">{{ $order->invoice_id }}</span>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                {{ $order->payment_status === 'pending' ? 'bg-amber-100 text-amber-800' : 'bg-blue-100 text-blue-800' }}">
                                                {{ $order->payment_status === 'pending' ? 'Menunggu Pembayaran' : 'Verifikasi (WA)' }}
                                            </span>
                                        </div>
                                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-2 text-sm text-neutral-600">
                                            <div>
                                                <span class="text-neutral-400">Paket:</span>
                                                <span class="font-medium text-secondary-800 ml-1">{{ ucfirst($order->package_type) }}</span>
                                            </div>
                                            <div>
                                                <span class="text-neutral-400">Total:</span>
                                                <span class="font-medium text-secondary-800 ml-1">Rp{{ $order->total_with_code }}</span>
                                            </div>
                                            <div>
                                                <span class="text-neutral-400">Kode Unik:</span>
                                                <span class="font-medium text-primary-600 ml-1">{{ $order->unique_code }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-shrink-0">
                                        @if($order->payment_status === 'pending' && $order->is_manual_whatsapp)
                                            <a href="{{ route('dashboard.payment.invoice', $order) }}"
                                               class="inline-flex items-center gap-2 px-5 py-2.5 bg-green-600 text-white rounded-xl text-sm font-semibold hover:bg-green-700 transition-colors">
                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                                                </svg>
                                                Kirim Bukti via WA
                                            </a>
                                        @elseif($order->payment_status === 'verifying')
                                            <a href="{{ route('dashboard.payment.invoice', $order) }}"
                                               class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-100 text-blue-700 rounded-xl text-sm font-semibold hover:bg-blue-200 transition-colors">
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
            <div class="bg-white rounded-2xl shadow-soft border border-neutral-100 overflow-hidden">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="font-heading text-lg font-bold text-secondary-800">Daftar Undangan Anda</h3>
                        <a href="{{ route('dashboard.invitations.create') }}"
                            class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-primary to-primary-600 text-white rounded-xl text-sm font-semibold hover:shadow-md transition-all">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Undangan Baru
                        </a>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse($invitations as $invitation)
                            <div class="border border-neutral-200 rounded-2xl overflow-hidden shadow-sm flex flex-col hover:shadow-md transition-all duration-200 group
                                {{ $invitation->isTrialExpired() ? 'opacity-60' : '' }}">
                                <div class="bg-neutral-100 h-40 flex items-center justify-center overflow-hidden">
                                    @if($invitation->cover_photo)
                                        <img src="{{ asset('storage/' . $invitation->cover_photo) }}" alt="Cover" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                    @else
                                        <div class="flex flex-col items-center text-neutral-400">
                                            <svg class="w-10 h-10 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            <span class="text-sm">Belum ada cover</span>
                                        </div>
                                    @endif
                                </div>
                                <div class="p-5 flex-1 flex flex-col">
                                    <h4 class="font-bold text-lg text-secondary-800 mb-1">{{ $invitation->title }}</h4>
                                    <p class="text-sm text-neutral-500 mb-3">{{ $invitation->bride_name }} & {{ $invitation->groom_name }}</p>

                                    <div class="flex items-center gap-2 mb-4">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-primary-50 text-primary-700">
                                            {{ $invitation->themeLabel() }}
                                        </span>
                                        @php
                                            $isTrial = $invitation->expires_at !== null && !$invitation->hasPremiumFeatures();
                                            $isExpired = $invitation->isTrialExpired();
                                        @endphp
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            {{ $isExpired ? 'bg-red-100 text-red-700' : ($isTrial ? 'bg-amber-100 text-amber-700' : 'bg-green-100 text-green-700') }}">
                                            {{ $isExpired ? 'Kadaluarsa' : ($isTrial ? 'Masa Percobaan' : 'Aktif') }}
                                        </span>
                                    </div>

                                    <div class="flex flex-col gap-2 mt-auto">
                                        <a href="{{ route('dashboard.invitations.show', $invitation) }}"
                                            class="text-center w-full bg-gradient-to-r from-primary to-primary-600 text-white px-3 py-2 rounded-xl text-sm font-medium hover:shadow-md transition-all">
                                            Kelola Undangan
                                        </a>
                                        <a href="{{ route('invitation.show', $invitation->slug) }}" target="_blank"
                                            class="text-center text-primary-600 hover:text-primary-700 text-sm font-medium transition-colors">
                                            Lihat Halaman &rarr;
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full py-16 text-center">
                                <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-neutral-100 flex items-center justify-center">
                                    <svg class="w-8 h-8 text-neutral-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <h4 class="text-lg font-semibold text-secondary-800 mb-1">Belum Ada Undangan</h4>
                                <p class="text-sm text-neutral-500 mb-6">Buat undangan digital pertama Anda dan mulai rayakan momen spesial.</p>
                                <a href="{{ route('dashboard.invitations.create') }}"
                                    class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-primary to-primary-600 text-white rounded-xl font-semibold text-sm shadow-soft hover:shadow-md transition-all">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                    Buat Undangan
                                </a>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
