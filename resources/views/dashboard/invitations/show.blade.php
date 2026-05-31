<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $invitation->title }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('invitation.show', $invitation->slug) }}" target="_blank" class="bg-indigo-100 text-indigo-700 px-4 py-2 rounded-md text-sm font-medium hover:bg-indigo-200">
                    Lihat Website
                </a>
                <a href="{{ route('dashboard.invitations.edit', $invitation) }}" class="bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-md text-sm font-medium hover:bg-gray-50">
                    Edit Detail
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Current Slug Info -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Tautan Undangan</h3>
                            <p class="mt-1">
                                <a href="{{ route('invitation.show', $invitation->slug) }}" target="_blank" class="text-indigo-600 hover:text-indigo-800 font-mono text-sm">
                                    {{ parse_url(config('app.url'), PHP_URL_HOST) }}/<strong>{{ $invitation->slug }}</strong>
                                </a>
                            </p>
                        </div>
                        <div class="text-right text-xs text-gray-500">
                            @if($invitation->slug_change_count > 0)
                                <span class="inline-flex items-center px-2 py-1 rounded-full bg-amber-100 text-amber-700 font-medium">
                                    Diubah {{ $invitation->slug_change_count }} kali
                                </span>
                            @else
                                <span class="inline-flex items-center px-2 py-1 rounded-full bg-gray-100 text-gray-600 font-medium">
                                    Belum pernah diubah
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <!-- Data Tamu -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-medium text-gray-900">Data Tamu</h3>
                            <a href="{{ route('dashboard.invitations.guests.index', $invitation) }}" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">Kelola Tamu &rarr;</a>
                        </div>
                        <div class="text-3xl font-bold text-gray-900">{{ $invitation->guests->count() }}</div>
                        <p class="text-sm text-gray-500 mt-1">Total tamu yang diundang</p>
                    </div>
                </div>

                <!-- Data RSVP -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-medium text-gray-900">RSVP / Konfirmasi</h3>
                        </div>
                        <div class="text-3xl font-bold text-gray-900">{{ $invitation->rsvps->where('attendance', 'attending')->count() }} <span class="text-lg font-normal text-gray-500">Hadir</span></div>
                        <p class="text-sm text-gray-500 mt-1">Total: {{ $invitation->rsvps->sum('pax') }} pax / orang</p>
                    </div>
                </div>

                <!-- Buku Tamu -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-medium text-gray-900">Buku Tamu</h3>
                        </div>
                        <div class="text-3xl font-bold text-gray-900">{{ $invitation->wishes->count() }}</div>
                        <p class="text-sm text-gray-500 mt-1">Total ucapan dan doa</p>
                    </div>
                </div>

                <!-- Pengunjung Website -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-medium text-gray-900">Pengunjung</h3>
                        </div>
                        <div class="text-3xl font-bold text-gray-900">{{ $totalUniques }}</div>
                        <p class="text-sm text-gray-500 mt-1">Total pengunjung unik</p>
                    </div>
                </div>
            </div>

            <!-- Chart Pengunjung -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Statistik Pengunjung (30 Hari Terakhir)</h3>
                        <span class="text-xs text-gray-500">{{ $totalViews }} total kunjungan</span>
                    </div>
                    <div class="relative" style="height: 260px;">
                        <canvas id="visitorChart"
                            data-labels='@json($chartLabels)'
                            data-totals='@json($chartTotals)'
                            data-uniques='@json($chartUniques)'
                        ></canvas>
                    </div>
                </div>
            </div>

            <!-- Galeri Foto & Kado Digital (Premium Sections) -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Galeri Foto -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border {{ $invitation->hasPremiumFeatures() ? 'border-indigo-100' : 'border-amber-100 bg-amber-50/20' }}">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-medium text-gray-900 flex items-center gap-2">
                                🖼️ Galeri Foto
                                @if(!$invitation->hasPremiumFeatures())
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold bg-amber-100 text-amber-800">✨ Premium</span>
                                @endif
                            </h3>
                            @if($invitation->hasPremiumFeatures())
                                <span class="text-xs text-gray-500 font-semibold">{{ count($invitation->gallery_photos ?? []) }} / {{ $invitation->maxGalleryPhotos() }} Foto</span>
                            @endif
                        </div>

                        @if($invitation->hasPremiumFeatures())
                            <div class="space-y-6">
                                <!-- Upload Form -->
                                <form action="{{ route('dashboard.invitations.gallery.update', $invitation) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                                    @csrf
                                    <div class="flex items-center gap-3">
                                        <input type="file" name="photos[]" multiple required accept="image/*" class="text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 flex-1">
                                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-sm font-semibold shadow-sm transition-all duration-200">Unggah</button>
                                    </div>
                                    <p class="text-xs text-gray-500">Mendukung format JPG, PNG, WEBP. Maks 5MB per foto.</p>
                                </form>

                                <!-- Gallery Grid -->
                                @if(empty($invitation->gallery_photos))
                                    <p class="text-gray-500 text-center py-4 text-sm">Belum ada foto galeri.</p>
                                @else
                                    <div class="grid grid-cols-3 sm:grid-cols-4 gap-3">
                                        @foreach($invitation->gallery_photos as $index => $photo)
                                            <div class="relative group aspect-square rounded-lg overflow-hidden border border-gray-100 bg-gray-50">
                                                <img src="{{ asset('storage/' . $photo) }}" alt="Gallery photo" class="w-full h-full object-cover">
                                                <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                                    <form action="{{ route('dashboard.invitations.gallery.destroy', $invitation) }}" method="POST" onsubmit="return confirmSwal(event, 'Hapus foto ini?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <input type="hidden" name="photo_index" value="{{ $index }}">
                                                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white rounded-full p-1.5 shadow-md">
                                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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
                        @else
                            <div class="text-center py-8">
                                <span class="text-4xl">🔒</span>
                                <h4 class="mt-3 font-semibold text-gray-900">Fitur Galeri Foto Terkunci</h4>
                                <p class="mt-1 text-xs text-gray-500 max-w-sm mx-auto">Upgrade paket Anda ke Silver, Gold, atau Platinum untuk menampilkan galeri cerita cinta dalam bentuk foto-foto cantik.</p>
                                <a href="{{ route('dashboard.checkout') }}" class="mt-4 inline-flex items-center justify-center px-4 py-2 border border-transparent text-xs font-semibold rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 shadow-md transition-all duration-200">
                                    Upgrade Sekarang
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Kado Digital -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border {{ $invitation->canUseGift() ? 'border-indigo-100' : 'border-amber-100 bg-amber-50/20' }}">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-medium text-gray-900 flex items-center gap-2">
                                🎁 Kado Digital
                                @if(!$invitation->canUseGift())
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold bg-amber-100 text-amber-800">✨ Premium</span>
                                @endif
                            </h3>
                        </div>

                        @if($invitation->canUseGift())
                            <form action="{{ route('dashboard.invitations.gift.update', $invitation) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                                @csrf
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="col-span-2 sm:col-span-1">
                                        <label for="gift_bank_name" class="block text-xs font-semibold text-gray-700">Nama Bank</label>
                                        <input type="text" name="gift_bank_name" id="gift_bank_name" value="{{ old('gift_bank_name', $invitation->gift_bank_name) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-xs" placeholder="BCA / Mandiri / BNI">
                                        @error('gift_bank_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-span-2 sm:col-span-1">
                                        <label for="gift_bank_account" class="block text-xs font-semibold text-gray-700">Nomor Rekening</label>
                                        <input type="text" name="gift_bank_account" id="gift_bank_account" value="{{ old('gift_bank_account', $invitation->gift_bank_account) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-xs" placeholder="1234567890">
                                        @error('gift_bank_account') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-span-2">
                                        <label for="gift_bank_holder" class="block text-xs font-semibold text-gray-700">Nama Pemilik Rekening</label>
                                        <input type="text" name="gift_bank_holder" id="gift_bank_holder" value="{{ old('gift_bank_holder', $invitation->gift_bank_holder) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-xs" placeholder="Mempelai / Pihak Keluarga">
                                        @error('gift_bank_holder') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <hr class="border-gray-100 my-2">

                                <div class="grid grid-cols-2 gap-4">
                                    <div class="col-span-2 sm:col-span-1">
                                        <label for="gift_ewallet_name" class="block text-xs font-semibold text-gray-700">Nama E-Wallet</label>
                                        <input type="text" name="gift_ewallet_name" id="gift_ewallet_name" value="{{ old('gift_ewallet_name', $invitation->gift_ewallet_name) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-xs" placeholder="Gopay / OVO / Dana">
                                        @error('gift_ewallet_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-span-2 sm:col-span-1">
                                        <label for="gift_ewallet_number" class="block text-xs font-semibold text-gray-700">Nomor E-Wallet</label>
                                        <input type="text" name="gift_ewallet_number" id="gift_ewallet_number" value="{{ old('gift_ewallet_number', $invitation->gift_ewallet_number) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-xs" placeholder="08123456789">
                                        @error('gift_ewallet_number') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-span-2">
                                        <label class="block text-xs font-semibold text-gray-700">Barcode QRIS</label>
                                        <div class="mt-1 flex items-center gap-4">
                                            @if($invitation->gift_qris_image)
                                                <img src="{{ asset('storage/' . $invitation->gift_qris_image) }}" alt="QRIS" class="w-16 h-16 object-contain border">
                                            @endif
                                            <input type="file" name="gift_qris_image" id="gift_qris_image" class="text-xs text-gray-500 file:mr-4 file:py-1 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                                        </div>
                                        @error('gift_qris_image') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <div class="pt-2 flex justify-end">
                                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-xs font-semibold shadow-sm transition-all duration-200">
                                        Simpan Kado Digital
                                    </button>
                                </div>
                            </form>
                        @else
                            <div class="text-center py-8">
                                <span class="text-4xl">🔒</span>
                                <h4 class="mt-3 font-semibold text-gray-900">Fitur Kado Digital Terkunci</h4>
                                <p class="mt-1 text-xs text-gray-500 max-w-sm mx-auto">Upgrade paket Anda ke Silver, Gold, atau Platinum untuk memudahkan para tamu mengirim kado digital (amplop) secara instan via rekening bank, e-wallet, atau QRIS.</p>
                                <a href="{{ route('dashboard.checkout') }}" class="mt-4 inline-flex items-center justify-center px-4 py-2 border border-transparent text-xs font-semibold rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 shadow-md transition-all duration-200">
                                    Upgrade Sekarang
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Daftar Ucapan -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Buku Tamu Terbaru</h3>
                    
                    @if($invitation->wishes->isEmpty())
                        <p class="text-gray-500 text-center py-4">Belum ada ucapan dari tamu.</p>
                    @else
                        <div class="space-y-4">
                            @foreach($invitation->wishes->take(5) as $wish)
                                <div class="border-b border-gray-100 pb-4 last:border-0 last:pb-0">
                                    <h4 class="font-bold text-gray-900">{{ $wish->guest_name }}</h4>
                                    <p class="text-gray-600 mt-1">{{ $wish->message }}</p>
                                    <p class="text-xs text-gray-400 mt-2">{{ $wish->created_at->diffForHumans() }}</p>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Daftar RSVP -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">RSVP Terbaru</h3>
                    
                    @if($invitation->rsvps->isEmpty())
                        <p class="text-gray-500 text-center py-4">Belum ada konfirmasi kehadiran dari tamu.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Tamu</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kehadiran</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah (Pax)</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Waktu</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($invitation->rsvps->take(10) as $rsvp)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $rsvp->guest_name }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                                    {{ $rsvp->attendance === 'attending' ? 'bg-green-100 text-green-800' : 
                                                      ($rsvp->attendance === 'not_attending' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                                    {{ $rsvp->attendanceLabel() }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $rsvp->pax }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $rsvp->created_at->format('d/m/Y H:i') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Danger Zone -->
            <div class="bg-red-50 overflow-hidden shadow-sm sm:rounded-lg border border-red-200 mt-8">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-red-800 mb-2">Danger Zone</h3>
                    <p class="text-sm text-red-600 mb-4">Menghapus undangan akan menghapus semua data tamu, RSVP, dan buku tamu yang terkait. Tindakan ini tidak dapat dibatalkan.</p>
                    
                    <form action="{{ route('dashboard.invitations.destroy', $invitation) }}" method="POST" onsubmit="return confirmSwal(event, 'Apakah Anda yakin ingin menghapus undangan ini secara permanen?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-red-700">
                            Hapus Undangan
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
