<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-heading text-2xl font-bold text-secondary-800">
                Pilih Paket
            </h2>
            <p class="text-sm text-neutral-500 mt-0.5">Upgrade undangan Anda untuk fitur yang lebih lengkap.</p>
        </div>
    </x-slot>

    @if($activeMethod === 'midtrans')
        <script src="{{ config('midtrans.snap_url') }}" data-client-key="{{ $clientKey }}"></script>
        <style>
            [x-cloak] {
                display: none !important
            }
        </style>
    @endif
    
    <div class="py-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
    
            @php
                $invitationId = $invitation?->id ?? request('invitation_id');
                $currentPackage = $packages->firstWhere('package_code', $currentTier);
                $currentRank = $currentPackage ? $currentPackage->sort_order : -1;
            @endphp
    
            @if($invitation)
                <div class="mb-6 bg-white border border-neutral-200 rounded-2xl px-5 py-4 flex items-center gap-3 shadow-soft">
                    <svg class="w-5 h-5 text-neutral-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    <span class="text-sm text-neutral-600">
                        Memperbarui paket untuk undangan: <strong class="text-secondary-800">{{ $invitation->title }}</strong>
                    </span>
                </div>
            @endif
    
            {{-- Payment Method Info --}}
            @if($activeMethod === 'manual_bank')
                <div
                    class="mb-6 bg-blue-50 border border-blue-200 text-blue-700 px-5 py-4 rounded-2xl text-sm flex items-center gap-3">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>Saat ini pembayaran menggunakan <strong>Transfer Bank Manual</strong>. Setelah memilih paket, Anda
                        akan melihat instruksi transfer dan tombol kirim bukti via WhatsApp.</span>
                </div>
            @else
                <div
                    class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-700 px-5 py-4 rounded-2xl text-sm flex items-center gap-3">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>Setelah pilih paket, layar pembayaran akan langsung terbuka. Kamu bisa bayar dengan praktis pakai
                        QRIS, Transfer Bank, atau Dompet Digital kesukaanmu.</span>
                </div>
            @endif
    
            {{-- Current Tier --}}
            <div
                class="mb-8 bg-white rounded-2xl shadow-soft border border-neutral-100 p-5 flex items-center justify-between">
                <div>
                    <h3 class="font-heading text-lg font-bold text-secondary-800">Paket Anda Saat Ini</h3>
                    <p class="text-sm text-neutral-500 mt-0.5">Upgrade untuk membuka fitur premium.</p>
                </div>
                <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-bold
                        {{ $currentTier === 'free' ? 'bg-neutral-100 text-neutral-700' : '' }}
                        {{ $currentTier === 'silver' ? 'bg-blue-100 text-blue-700' : '' }}
                        {{ $currentTier === 'gold' ? 'bg-amber-100 text-amber-700' : '' }}
                        {{ $currentTier === 'platinum' ? 'bg-primary-100 text-primary-700' : '' }}
                    ">
                    {{ $currentPackage ? $currentPackage->package_name : ucfirst($currentTier) }}
                </span>
            </div>
    
            {{-- Package Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
    
                @forelse($packages as $pkg)
                    <div class="bg-white rounded-3xl shadow-soft border overflow-hidden hover:shadow-lg transition-all duration-300 flex flex-col relative
                                {{ $pkg->is_popular ? 'border-2 border-primary-500 shadow-lg scale-[1.02] md:scale-105' : 'border-neutral-200' }}
                                {{ $currentTier === $pkg->package_code ? 'ring-2 ring-primary-400' : '' }}
                            ">
                        @if($pkg->is_popular)
                            <div
                                class="absolute top-0 left-0 right-0 bg-gradient-to-r from-primary to-primary-600 text-center py-2.5 z-10">
                                <span class="text-white text-xs font-bold tracking-wider uppercase">Paling Populer</span>
                            </div>
                            <div class="absolute -top-2 -right-2 z-20">
                                <div class="w-10 h-10 rounded-full bg-amber-400 flex items-center justify-center shadow-lg">
                                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                </div>
                            </div>
                        @endif

                        <div class="p-8 {{ $pkg->is_popular ? 'pt-14' : '' }} flex-1">
                            <div class="flex items-center justify-between mb-4">
                                <h3
                                    class="font-heading text-xl font-bold {{ $pkg->is_popular ? 'text-primary' : 'text-secondary-800' }}">
                                    {{ $pkg->package_name }}
                                </h3>
                                @if($currentTier === $pkg->package_code)
                                    <span
                                        class="text-xs font-bold px-3 py-1 rounded-full text-primary-700 bg-primary-50">AKTIF</span>
                                @endif
                            </div>
                            @if($pkg->description)
                                <p class="text-sm text-neutral-500 mb-6">{{ $pkg->description }}</p>
                            @endif

                            <div class="mb-8">
                                @if($pkg->slashed_price && $pkg->slashed_price > $pkg->price)
                                    <span class="text-lg text-neutral-300 line-through">Rp
                                        {{ number_format($pkg->slashed_price, 0, ',', '.') }}</span>
                                @endif
                                <div class="flex items-baseline gap-1">
                                    <span class="text-4xl font-extrabold text-secondary-800">Rp
                                        {{ number_format($pkg->price, 0, ',', '.') }}</span>
                                    <span class="text-sm text-neutral-500">/
                                        {{ $pkg->active_period_days === 0 ? 'Lifetime' : $pkg->active_period_days . ' Hari' }}</span>
                                </div>
                            </div>

                            <ul class="space-y-3 text-sm text-neutral-600">
                                @forelse($pkg->features as $feature)
                                    <li class="flex items-start gap-3">
                                        <svg class="w-4 h-4 text-emerald-500 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                d="M5 13l4 4L19 7" />
                                        </svg>
                                        <span>{{ $feature->feature_name }}</span>
                                    </li>
                                @empty
                                    <li class="text-sm text-neutral-400 italic">Fitur dasar</li>
                                @endforelse
                            </ul>
                        </div>
                        <div class="px-8 pb-8">
                            @if($currentTier === $pkg->package_code || $currentRank >= $pkg->sort_order)
                                <button disabled
                                    class="w-full py-3 bg-neutral-100 text-neutral-400 rounded-2xl font-semibold cursor-not-allowed">
                                    {{ $currentTier === $pkg->package_code ? 'Paket Aktif' : 'Sudah Lebih Tinggi' }}
                                </button>
                            @else
                                <form action="{{ route('dashboard.checkout.process') }}" method="POST"
                                    @if($activeMethod === 'midtrans') x-data="checkout" @submit.prevent="handleSubmit" @endif>
                                    @csrf
                                    <input type="hidden" name="tier" value="{{ $pkg->package_code }}">
                                    @if($invitationId)
                                        <input type="hidden" name="invitation_id" value="{{ $invitationId }}">
                                    @endif
                                    <button type="submit" @if($activeMethod === 'midtrans') x-bind:disabled="processing" @endif
                                        class="w-full py-3 rounded-2xl font-semibold transition-all shadow-sm hover:scale-[1.02] active:scale-[0.98]
                                                    @if($activeMethod === 'manual_bank')
                                                        bg-emerald-600 text-white hover:bg-emerald-700
                                                    @else
                                                                                        {{ $pkg->is_popular
                                                        ? 'bg-gradient-to-r from-primary to-primary-600 text-white hover:shadow-lg shadow-primary-200'
                                                        : 'bg-secondary-800 text-white hover:bg-secondary-700' }}
                                                    @endif
                                                ">
                                        @if($activeMethod === 'manual_bank')
                                            Pilih {{ $pkg->package_name }}
                                        @else
                                            <span x-show="!processing">Pilih {{ $pkg->package_name }}</span>
                                            <span x-show="processing" x-cloak>Memproses...</span>
                                        @endif
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-12 text-center text-neutral-500">
                        <p class="text-lg">Belum ada paket tersedia. Silakan hubungi admin.</p>
                    </div>
                @endforelse
    
            </div>
    
            {{-- Footer Note --}}
            <div class="mt-12 text-center">
                <div class="bg-neutral-50 border border-neutral-200 rounded-2xl p-6 inline-block max-w-2xl mx-auto">
                    <p class="text-sm text-neutral-500">
                        Semua paket termasuk fitur RSVP, Buku Tamu, Link Personal per Tamu, dan Template Pesan WhatsApp.
                    </p>
                    <p class="text-sm text-neutral-500 mt-1">
                        Pembayaran hanya satu kali, bukan langganan bulanan.
                    </p>
                </div>
            </div>
        </div>
    </div>
    </x-app-layout>