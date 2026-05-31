<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Trial Countdown Banners --}}
            @foreach($trialInvitations as $invitation)
                @php
                    $days = $invitation->trialRemainingDays();
                    $hours = $invitation->trialRemainingHours();
                    $isUrgent = $invitation->isTrialUrgent();
                    $isExpired = $invitation->isTrialExpired();
                @endphp

                <div class="mb-4 rounded-xl overflow-hidden shadow-sm border transition-all duration-300
                    {{ $isExpired ? 'bg-red-50 border-red-300' : ($isUrgent ? 'bg-orange-50 border-orange-300' : 'bg-indigo-50 border-indigo-200') }}">
                    <div class="p-5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div class="flex items-start gap-4">
                            <div class="flex-shrink-0 mt-1">
                                @if($isExpired)
                                    <svg class="w-6 h-6 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z" />
                                    </svg>
                                @elseif($isUrgent)
                                    <svg class="w-6 h-6 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                @else
                                    <svg class="w-6 h-6 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                @endif
                            </div>
                            <div>
                                <h4 class="font-semibold text-sm {{ $isExpired ? 'text-red-800' : ($isUrgent ? 'text-orange-800' : 'text-indigo-800') }}">
                                    Undangan: {{ $invitation->title }}
                                </h4>
                                @if($isExpired)
                                    <p class="text-sm text-red-600 mt-1">
                                        Masa uji coba gratis Anda telah <strong>berakhir</strong>. Aktifkan kembali untuk melanjutkan penggunaan.
                                    </p>
                                @else
                                    <p class="text-sm mt-1 {{ $isUrgent ? 'text-orange-700' : 'text-indigo-700' }}">
                                        Masa uji coba gratis Anda tersisa
                                        <strong>{{ $days }} Hari {{ $hours }} Jam</strong> lagi
                                        @if($isUrgent)
                                            <span class="inline-block ml-2 animate-pulse">⚠️ Segera aktifkan!</span>
                                        @endif
                                    </p>
                                @endif
                            </div>
                        </div>
                        <div class="flex-shrink-0">
                            <a href="{{ route('dashboard.checkout', ['invitation_id' => $invitation->id]) }}"
                               class="inline-flex items-center px-5 py-2.5 rounded-lg text-sm font-semibold shadow-sm transition-all
                                {{ $isExpired ? 'bg-red-600 text-white hover:bg-red-700' : ($isUrgent ? 'bg-orange-600 text-white hover:bg-orange-700' : 'bg-indigo-600 text-white hover:bg-indigo-700') }}">
                                Aktifkan Undangan Sekarang
                                <svg class="w-4 h-4 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach

            {{-- Pending Orders / Payment Info --}}
            @if($pendingOrders->isNotEmpty())
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Pesanan Menunggu Pembayaran</h3>
                    <div class="space-y-4">
                        @foreach($pendingOrders as $order)
                            <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm hover:shadow-md transition-shadow">
                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                                    <div class="flex-1">
                                        <div class="flex items-center gap-3 mb-2">
                                            <span class="font-mono font-bold text-indigo-700">{{ $order->invoice_id }}</span>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                {{ $order->payment_status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-blue-100 text-blue-800' }}">
                                                {{ $order->payment_status === 'pending' ? 'Menunggu Pembayaran' : 'Verifikasi (WA)' }}
                                            </span>
                                        </div>
                                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-2 text-sm text-gray-600">
                                            <div>
                                                <span class="text-gray-400">Paket:</span>
                                                <span class="font-medium text-gray-800 ml-1">{{ ucfirst($order->package_type) }}</span>
                                            </div>
                                            <div>
                                                <span class="text-gray-400">Total:</span>
                                                <span class="font-medium text-gray-800 ml-1">Rp{{ $order->total_with_code }}</span>
                                            </div>
                                            <div>
                                                <span class="text-gray-400">Kode Unik:</span>
                                                <span class="font-medium text-indigo-600 ml-1">{{ $order->unique_code }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-shrink-0">
                                        @if($order->payment_status === 'pending' && $order->is_manual_whatsapp)
                                            <a href="{{ route('dashboard.payment.invoice', $order) }}"
                                               class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg text-sm font-semibold hover:bg-green-700 transition-colors">
                                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                                                </svg>
                                                Kirim Bukti via WA
                                            </a>
                                        @elseif($order->payment_status === 'verifying')
                                            <a href="{{ route('dashboard.payment.invoice', $order) }}"
                                               class="inline-flex items-center px-4 py-2 bg-blue-100 text-blue-700 rounded-lg text-sm font-semibold hover:bg-blue-200 transition-colors">
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

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium">Daftar Undangan Anda</h3>
                        <a href="{{ route('dashboard.invitations.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-indigo-700">
                            + Buat Undangan Baru
                        </a>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse($invitations as $invitation)
                            <div class="border rounded-lg overflow-hidden shadow-sm flex flex-col
                                {{ $invitation->isTrialExpired() ? 'opacity-60' : '' }}">
                                <div class="bg-gray-100 h-32 flex items-center justify-center">
                                    @if($invitation->cover_photo)
                                        <img src="{{ asset('storage/' . $invitation->cover_photo) }}" alt="Cover" class="w-full h-full object-cover">
                                    @else
                                        <span class="text-gray-400 font-medium">No Cover</span>
                                    @endif
                                </div>
                                <div class="p-4 flex-1">
                                    <h4 class="font-bold text-lg mb-1">{{ $invitation->title }}</h4>
                                    <p class="text-sm text-gray-600 mb-2">{{ $invitation->bride_name }} & {{ $invitation->groom_name }}</p>
                                    <div class="flex items-center gap-2 mb-4">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            {{ $invitation->themeLabel() }}
                                        </span>
                                        @php
                                            $isTrial = $invitation->expires_at !== null && !$invitation->hasPremiumFeatures();
                                            $isExpired = $invitation->isTrialExpired();
                                        @endphp
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            {{ $isExpired ? 'bg-red-100 text-red-800' : ($isTrial ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800') }}">
                                            {{ $isExpired ? 'Kadaluarsa' : ($isTrial ? 'Masa Percobaan' : 'Aktif') }}
                                        </span>
                                    </div>
                                    <div class="flex flex-col gap-2">
                                        <a href="{{ route('dashboard.invitations.show', $invitation) }}" class="text-center bg-gray-100 hover:bg-gray-200 text-gray-800 px-3 py-1.5 rounded-md text-sm transition">
                                            Kelola Undangan
                                        </a>
                                        <a href="{{ route('invitation.show', $invitation->slug) }}" target="_blank" class="text-center text-indigo-600 hover:text-indigo-800 text-sm font-medium transition">
                                            Lihat Halaman
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full py-12 text-center text-gray-500">
                                Belum ada undangan. Silakan buat undangan pertama Anda.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
