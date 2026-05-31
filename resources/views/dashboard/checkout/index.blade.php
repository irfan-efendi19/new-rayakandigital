<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pilih Paket') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

            @php
                $invitationId = request('invitation_id');
                $currentPackage = $packages->firstWhere('package_code', $currentTier);
                $currentRank = $currentPackage ? $currentPackage->sort_order : -1;
            @endphp

            @if($activeMethod === 'manual_bank')
                <div class="mb-6 bg-indigo-50 border border-indigo-200 text-indigo-700 px-6 py-4 rounded-xl text-sm flex items-center gap-3">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>Saat ini pembayaran menggunakan <strong>Transfer Bank Manual</strong>. Setelah memilih paket, Anda akan melihat instruksi transfer dan tombol kirim bukti via WhatsApp.</span>
                </div>
            @else
                <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-700 px-6 py-4 rounded-xl text-sm flex items-center gap-3">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>Saat ini pembayaran menggunakan <strong>Midtrans Gateway</strong>. Setelah memilih paket, Anda akan diarahkan ke pop-up pembayaran (QRIS/VA/E-Wallet).</span>
                </div>
            @endif

            <!-- Current Tier Badge -->
            <div class="mb-8 bg-white rounded-xl shadow-sm border p-6 flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Paket Anda Saat Ini</h3>
                    <p class="text-sm text-gray-500 mt-1">Upgrade untuk membuka fitur premium.</p>
                </div>
                <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-bold
                    {{ $currentTier === 'free' ? 'bg-gray-100 text-gray-700' : '' }}
                    {{ $currentTier === 'silver' ? 'bg-blue-100 text-blue-700' : '' }}
                    {{ $currentTier === 'gold' ? 'bg-amber-100 text-amber-700' : '' }}
                    {{ $currentTier === 'platinum' ? 'bg-purple-100 text-purple-700' : '' }}
                ">
                    {{ $currentPackage ? $currentPackage->package_name : ucfirst($currentTier) }}
                </span>
            </div>

            <!-- Package Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

                @forelse($packages as $pkg)
                    <div class="bg-white rounded-2xl shadow-sm border overflow-hidden hover:shadow-lg transition-all duration-300 flex flex-col relative
                        {{ $pkg->is_popular ? 'border-2 border-indigo-500 shadow-lg' : 'border-gray-200' }}
                        {{ $currentTier === $pkg->package_code ? 'ring-2 ring-indigo-400' : '' }}
                    ">
                        @if($pkg->is_popular)
                            <div class="absolute top-0 left-0 right-0 bg-gradient-to-r from-indigo-500 to-indigo-600 text-center py-2">
                                <span class="text-white text-xs font-bold tracking-wider uppercase">⭐ Paling Populer</span>
                            </div>
                        @endif

                        <div class="p-8 {{ $pkg->is_popular ? 'pt-14' : '' }} flex-1">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-xl font-bold {{ $pkg->is_popular ? 'text-indigo-600' : 'text-gray-900' }}">{{ $pkg->package_name }}</h3>
                                @if($currentTier === $pkg->package_code)
                                    <span class="text-xs font-bold px-3 py-1 rounded-full text-indigo-600 bg-indigo-50">AKTIF</span>
                                @endif
                            </div>
                            @if($pkg->description)
                                <p class="text-sm text-gray-500 mb-6">{{ $pkg->description }}</p>
                            @endif

                            <div class="mb-8">
                                @if($pkg->slashed_price && $pkg->slashed_price > $pkg->price)
                                    <span class="text-lg text-gray-400 line-through">Rp {{ number_format($pkg->slashed_price, 0, ',', '.') }}</span>
                                @endif
                                <span class="text-4xl font-extrabold text-gray-900">Rp {{ number_format($pkg->price, 0, ',', '.') }}</span>
                                <span class="text-sm text-gray-500 ml-1">/ {{ $pkg->active_period_days === 0 ? 'Lifetime' : $pkg->active_period_days . ' Hari' }}</span>
                            </div>

                            <ul class="space-y-3 text-sm text-gray-600">
                                @forelse($pkg->features as $feature)
                                    <li class="flex items-start"><span class="text-emerald-500 mr-2 mt-0.5 flex-shrink-0">✓</span>{{ $feature->feature_name }}</li>
                                @empty
                                    <li class="text-sm text-gray-400 italic">Fitur dasar</li>
                                @endforelse
                            </ul>
                        </div>
                        <div class="px-8 pb-8">
                            @if($currentTier === $pkg->package_code || $currentRank >= $pkg->sort_order)
                                <button disabled class="w-full py-3 bg-gray-100 text-gray-400 rounded-xl font-semibold cursor-not-allowed">
                                    {{ $currentTier === $pkg->package_code ? 'Paket Aktif' : 'Sudah Lebih Tinggi' }}
                                </button>
                            @else
                                <form action="{{ route('dashboard.checkout.process') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="tier" value="{{ $pkg->package_code }}">
                                    @if($invitationId)
                                        <input type="hidden" name="invitation_id" value="{{ $invitationId }}">
                                    @endif
                                    <button type="submit"
                                        class="w-full py-3 rounded-xl font-semibold transition-all shadow-sm
                                        @if($activeMethod === 'manual_bank')
                                            bg-green-600 text-white hover:bg-green-700
                                        @else
                                            {{ $pkg->is_popular ? 'bg-gradient-to-r from-indigo-600 to-indigo-700 text-white hover:from-indigo-700 hover:to-indigo-800 shadow-lg shadow-indigo-200' : 'bg-gray-800 text-white hover:bg-gray-900' }}
                                        @endif
                                    ">
                                        @if($activeMethod === 'manual_bank')
                                            Pilih {{ $pkg->package_name }} (Transfer Manual)
                                        @else
                                            Pilih {{ $pkg->package_name }}
                                        @endif
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-12 text-center text-gray-500">
                        <p class="text-lg">Belum ada paket tersedia. Silakan hubungi admin.</p>
                    </div>
                @endforelse

            </div>

            <!-- Comparison Note -->
            <div class="mt-12 text-center">
                <p class="text-sm text-gray-500">
                    Semua paket termasuk fitur RSVP, Buku Tamu, Link Personal per Tamu, dan Template Pesan WhatsApp.<br>
                    Pembayaran hanya satu kali, bukan langganan bulanan.
                </p>
            </div>
        </div>
    </div>
</x-app-layout>
