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

            <!-- Scanner Kehadiran (QR Check-In) -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border {{ $invitation->hasFeature('qr_checkin') ? 'border-emerald-100' : 'border-amber-100 bg-amber-50/20' }}">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="flex-shrink-0 inline-flex items-center justify-center w-10 h-10 rounded-full {{ $invitation->hasFeature('qr_checkin') ? 'bg-emerald-100 text-emerald-600' : 'bg-amber-100 text-amber-500' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 3.5a.5.5 0 11-1 0 .5.5 0 011 0zm-7.5 0a.5.5 0 11-1 0 .5.5 0 011 0zm7.5-7.5a.5.5 0 11-1 0 .5.5 0 011 0zm-7.5 0a.5.5 0 11-1 0 .5.5 0 011 0z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 flex items-center gap-2">
                                    Scanner Kehadiran (QR Check-In)
                                    @if(!$invitation->hasFeature('qr_checkin'))
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold bg-amber-100 text-amber-800">✨ Platinum</span>
                                    @endif
                                </h3>
                                <p class="text-sm text-gray-500 mt-0.5">
                                    @if($invitation->hasFeature('qr_checkin'))
                                        @php
                                            $checkedIn = $invitation->guests()->where('attendance_status', 'hadir')->count();
                                            $totalGuests = $invitation->guests()->count();
                                        @endphp
                                        <span class="font-semibold text-emerald-600">{{ $checkedIn }}</span> / {{ $totalGuests }} tamu sudah check-in
                                    @else
                                        Scan QR Code tamu saat hari H dan cetak tiket kehadiran
                                    @endif
                                </p>
                            </div>
                        </div>

                        @if($invitation->hasFeature('qr_checkin'))
                            <a href="{{ route('dashboard.invitations.guestbook', $invitation) }}"
                               class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2.5 rounded-lg text-sm font-semibold shadow-sm transition-all duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                Buka Scanner
                            </a>
                        @else
                            <a href="{{ route('dashboard.checkout') }}"
                               class="inline-flex items-center gap-2 bg-amber-500 hover:bg-amber-600 text-white px-5 py-2.5 rounded-lg text-sm font-semibold shadow-sm transition-all duration-200">
                                ✨ Upgrade ke Platinum
                            </a>
                        @endif
                    </div>

                    @if($invitation->hasFeature('qr_checkin') && $totalGuests > 0)
                        <div class="mt-4 w-full bg-gray-100 rounded-full h-2">
                            <div class="bg-emerald-500 h-2 rounded-full transition-all duration-500"
                                 style="width: {{ $totalGuests > 0 ? round(($checkedIn / $totalGuests) * 100) : 0 }}%">
                            </div>
                        </div>
                        <p class="text-xs text-gray-400 mt-1 text-right">
                            {{ $totalGuests > 0 ? round(($checkedIn / $totalGuests) * 100) : 0 }}% kehadiran
                        </p>
                    @endif
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
                                <form id="gallery-upload-form" action="{{ route('dashboard.invitations.gallery.update', $invitation) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                                    @csrf
                                    <div id="gallery-dropzone" class="relative border-2 border-dashed border-indigo-300 rounded-xl p-6 text-center cursor-pointer hover:border-indigo-400 hover:bg-indigo-50/50 transition-all duration-200">
                                        <input type="file" name="photos[]" id="gallery-file-input" multiple accept="image/*" class="hidden">
                                        <div id="dropzone-empty" class="space-y-2">
                                            <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-indigo-100 text-indigo-600">
                                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                                </svg>
                                            </div>
                                            <p class="text-sm font-medium text-gray-700">Seret foto ke sini atau <span class="text-indigo-600 underline">klik untuk memilih</span></p>
                                            <p class="text-xs text-gray-400">JPG, PNG, WEBP. Maks 5MB per foto. Bisa pilih banyak sekaligus.</p>
                                        </div>
                                        <div id="dropzone-preview" class="hidden space-y-3">
                                            <div id="preview-thumbnails" class="flex flex-wrap gap-2 justify-center max-h-48 overflow-y-auto"></div>
                                            <div class="flex items-center justify-center gap-2 text-sm text-gray-500">
                                                <span id="file-count"></span>
                                                <button type="button" id="gallery-change-files" class="text-indigo-600 hover:text-indigo-800 underline text-xs">Ganti pilihan</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex items-center justify-end gap-3">
                                        <span id="dropzone-error" class="text-xs text-red-500 hidden"></span>
                                        <button type="submit" id="gallery-submit-btn" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-lg text-sm font-semibold shadow-sm transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                                            Unggah <span id="upload-count"></span>
                                        </button>
                                    </div>
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
                            @php
                                $maxGift = $invitation->maxGiftAccounts();
                                $oldBanks = old('gift_banks', $invitation->gift_banks ?? []);
                                $oldEwallets = old('gift_ewallets', $invitation->gift_ewallets ?? []);

                                if (empty($oldBanks) && ($invitation->gift_bank_name || $invitation->gift_bank_account)) {
                                    $oldBanks = [['bank_name' => $invitation->gift_bank_name, 'account_number' => $invitation->gift_bank_account, 'account_holder' => $invitation->gift_bank_holder]];
                                }
                                if (empty($oldEwallets) && ($invitation->gift_ewallet_name || $invitation->gift_ewallet_number)) {
                                    $oldEwallets = [['wallet_name' => $invitation->gift_ewallet_name, 'wallet_number' => $invitation->gift_ewallet_number]];
                                }
                            @endphp
                            <form id="gift-form" action="{{ route('dashboard.invitations.gift.update', $invitation) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                                @csrf
                                <div class="flex items-center justify-between">
                                    <span class="text-xs text-gray-500 font-semibold">Maksimal {{ $maxGift }} akun</span>
                                    <span id="gift-account-count" class="text-xs text-gray-400">0 / {{ $maxGift }}</span>
                                </div>

                                <!-- Bank Accounts Repeater -->
                                <div id="gift-banks-container" class="space-y-3">
                                    <div class="flex items-center justify-between">
                                        <label class="text-xs font-semibold text-gray-700">Transfer Bank</label>
                                        <button type="button" id="add-bank-btn" class="text-xs text-indigo-600 hover:text-indigo-800 font-semibold">+ Tambah Bank</button>
                                    </div>
                                    @foreach($oldBanks as $bankIdx => $bank)
                                        @php $bank = (object) $bank; @endphp
                                        <div class="gift-bank-card bg-gray-50 p-3 rounded-lg border border-gray-200 space-y-2">
                                            <div class="flex items-center justify-between">
                                                <span class="text-xs font-semibold text-gray-500">Bank #{{ $loop->iteration }}</span>
                                                <button type="button" class="remove-bank text-red-400 hover:text-red-600 text-xs font-semibold">Hapus</button>
                                            </div>
                                            <div class="grid grid-cols-2 gap-2">
                                                <div>
                                                    <input type="text" name="gift_banks[{{ $bankIdx }}][bank_name]" value="{{ old('gift_banks.' . $bankIdx . '.bank_name', $bank->bank_name ?? '') }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-xs" placeholder="Nama Bank">
                                                    @error('gift_banks.' . $bankIdx . '.bank_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                                </div>
                                                <div>
                                                    <input type="text" name="gift_banks[{{ $bankIdx }}][account_number]" value="{{ old('gift_banks.' . $bankIdx . '.account_number', $bank->account_number ?? '') }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-xs" placeholder="No. Rekening">
                                                    @error('gift_banks.' . $bankIdx . '.account_number') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                                </div>
                                                <div class="col-span-2">
                                                    <input type="text" name="gift_banks[{{ $bankIdx }}][account_holder]" value="{{ old('gift_banks.' . $bankIdx . '.account_holder', $bank->account_holder ?? '') }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-xs" placeholder="Atas Nama">
                                                    @error('gift_banks.' . $bankIdx . '.account_holder') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <!-- E-Wallet Repeater -->
                                <div id="gift-ewallets-container" class="space-y-3">
                                    <div class="flex items-center justify-between">
                                        <label class="text-xs font-semibold text-gray-700">Dompet Digital</label>
                                        <button type="button" id="add-ewallet-btn" class="text-xs text-indigo-600 hover:text-indigo-800 font-semibold">+ Tambah E-Wallet</button>
                                    </div>
                                    @foreach($oldEwallets as $ewalletIdx => $ewallet)
                                        @php $ewallet = (object) $ewallet; @endphp
                                        <div class="gift-ewallet-card bg-gray-50 p-3 rounded-lg border border-gray-200 space-y-2">
                                            <div class="flex items-center justify-between">
                                                <span class="text-xs font-semibold text-gray-500">E-Wallet #{{ $loop->iteration }}</span>
                                                <button type="button" class="remove-ewallet text-red-400 hover:text-red-600 text-xs font-semibold">Hapus</button>
                                            </div>
                                            <div class="grid grid-cols-2 gap-2">
                                                <div>
                                                    <input type="text" name="gift_ewallets[{{ $ewalletIdx }}][wallet_name]" value="{{ old('gift_ewallets.' . $ewalletIdx . '.wallet_name', $ewallet->wallet_name ?? '') }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-xs" placeholder="Nama E-Wallet">
                                                    @error('gift_ewallets.' . $ewalletIdx . '.wallet_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                                </div>
                                                <div>
                                                    <input type="text" name="gift_ewallets[{{ $ewalletIdx }}][wallet_number]" value="{{ old('gift_ewallets.' . $ewalletIdx . '.wallet_number', $ewallet->wallet_number ?? '') }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-xs" placeholder="Nomor E-Wallet">
                                                    @error('gift_ewallets.' . $ewalletIdx . '.wallet_number') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <hr class="border-gray-100">

                                <!-- QRIS -->
                                <div>
                                    <label class="block text-xs font-semibold text-gray-700">Barcode QRIS</label>
                                    <div class="mt-1 flex items-center gap-4">
                                        @if($invitation->gift_qris_image)
                                            <img src="{{ asset('storage/' . $invitation->gift_qris_image) }}" alt="QRIS" class="w-16 h-16 object-contain border">
                                        @endif
                                        <input type="file" name="gift_qris_image" id="gift_qris_image" class="text-xs text-gray-500 file:mr-4 file:py-1 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                                    </div>
                                    @error('gift_qris_image') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>

                                <div class="pt-2 flex justify-end">
                                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-xs font-semibold shadow-sm transition-all duration-200">
                                        Simpan Kado Digital
                                    </button>
                                </div>
                            </form>

                            <script>
                                document.addEventListener('DOMContentLoaded', function () {
                                    const maxAccounts = {{ $maxGift }};
                                    const banksContainer = document.getElementById('gift-banks-container');
                                    const ewalletsContainer = document.getElementById('gift-ewallets-container');
                                    const bankTemplate = document.getElementById('gift-bank-template');
                                    const ewalletTemplate = document.getElementById('gift-ewallet-template');
                                    const accountCountEl = document.getElementById('gift-account-count');

                                    function updateAccountCount() {
                                        const total = banksContainer.querySelectorAll('.gift-bank-card').length + ewalletsContainer.querySelectorAll('.gift-ewallet-card').length;
                                        accountCountEl.textContent = total + ' / ' + maxAccounts;
                                        document.getElementById('add-bank-btn').style.display = total >= maxAccounts ? 'none' : '';
                                        document.getElementById('add-ewallet-btn').style.display = total >= maxAccounts ? 'none' : '';
                                    }

                                    function reindexItems(container, prefix) {
                                        const cards = container.querySelectorAll('[class*="gift-' + prefix + '-card"]');
                                        cards.forEach(function (card, idx) {
                                            const inputs = card.querySelectorAll('[name]');
                                            inputs.forEach(function (input) {
                                                const name = input.getAttribute('name');
                                                if (name) {
                                                    input.setAttribute('name', name.replace(new RegExp(prefix + 's\\[\\d+\\]'), prefix + 's[' + idx + ']'));
                                                }
                                            });
                                            const label = card.querySelector('span.text-xs.font-semibold.text-gray-500');
                                            if (label) {
                                                const prefixLabel = prefix === 'bank' ? 'Bank' : 'E-Wallet';
                                                label.textContent = prefixLabel + ' #' + (idx + 1);
                                            }
                                        });
                                    }

                                    function addItem(container, templateId, prefix) {
                                        const total = banksContainer.querySelectorAll('.gift-bank-card').length + ewalletsContainer.querySelectorAll('.gift-ewallet-card').length;
                                        if (total >= maxAccounts) return;

                                        const template = document.getElementById(templateId);
                                        const clone = template.content.cloneNode(true);
                                        const card = clone.querySelector('[class*="gift-' + prefix + '-card"]');
                                        container.appendChild(card);
                                        reindexItems(container, prefix);
                                        updateAccountCount();
                                    }

                                    banksContainer.addEventListener('click', function (e) {
                                        if (e.target.closest('.remove-bank')) {
                                            e.target.closest('.gift-bank-card').remove();
                                            reindexItems(banksContainer, 'bank');
                                            updateAccountCount();
                                        }
                                    });

                                    ewalletsContainer.addEventListener('click', function (e) {
                                        if (e.target.closest('.remove-ewallet')) {
                                            e.target.closest('.gift-ewallet-card').remove();
                                            reindexItems(ewalletsContainer, 'ewallet');
                                            updateAccountCount();
                                        }
                                    });

                                    document.getElementById('add-bank-btn').addEventListener('click', function () {
                                        addItem(banksContainer, 'gift-bank-template', 'bank');
                                    });

                                    document.getElementById('add-ewallet-btn').addEventListener('click', function () {
                                        addItem(ewalletsContainer, 'gift-ewallet-template', 'ewallet');
                                    });

                                    updateAccountCount();
                                });
                            </script>

                            <template id="gift-bank-template">
                                <div class="gift-bank-card bg-gray-50 p-3 rounded-lg border border-gray-200 space-y-2">
                                    <div class="flex items-center justify-between">
                                        <span class="text-xs font-semibold text-gray-500">Bank Baru</span>
                                        <button type="button" class="remove-bank text-red-400 hover:text-red-600 text-xs font-semibold">Hapus</button>
                                    </div>
                                    <div class="grid grid-cols-2 gap-2">
                                        <div>
                                            <input type="text" name="gift_banks[999][bank_name]" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-xs" placeholder="Nama Bank">
                                        </div>
                                        <div>
                                            <input type="text" name="gift_banks[999][account_number]" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-xs" placeholder="No. Rekening">
                                        </div>
                                        <div class="col-span-2">
                                            <input type="text" name="gift_banks[999][account_holder]" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-xs" placeholder="Atas Nama">
                                        </div>
                                    </div>
                                </div>
                            </template>

                            <template id="gift-ewallet-template">
                                <div class="gift-ewallet-card bg-gray-50 p-3 rounded-lg border border-gray-200 space-y-2">
                                    <div class="flex items-center justify-between">
                                        <span class="text-xs font-semibold text-gray-500">E-Wallet Baru</span>
                                        <button type="button" class="remove-ewallet text-red-400 hover:text-red-600 text-xs font-semibold">Hapus</button>
                                    </div>
                                    <div class="grid grid-cols-2 gap-2">
                                        <div>
                                            <input type="text" name="gift_ewallets[999][wallet_name]" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-xs" placeholder="Nama E-Wallet">
                                        </div>
                                        <div>
                                            <input type="text" name="gift_ewallets[999][wallet_number]" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-xs" placeholder="Nomor E-Wallet">
                                        </div>
                                    </div>
                                </div>
                            </template>
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

            <!-- Gallery Upload Script -->
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const dropzone = document.getElementById('gallery-dropzone');
                    const fileInput = document.getElementById('gallery-file-input');
                    const dropzoneEmpty = document.getElementById('dropzone-empty');
                    const dropzonePreview = document.getElementById('dropzone-preview');
                    const previewThumbnails = document.getElementById('preview-thumbnails');
                    const fileCount = document.getElementById('file-count');
                    const uploadCount = document.getElementById('upload-count');
                    const submitBtn = document.getElementById('gallery-submit-btn');
                    const dropzoneError = document.getElementById('dropzone-error');
                    const changeFilesBtn = document.getElementById('gallery-change-files');
                    let selectedFiles = [];

                    const maxFileSize = 5 * 1024 * 1024;
                    const allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];

                    function updatePreview() {
                        previewThumbnails.innerHTML = '';
                        let validFiles = [];
                        let errorMsg = '';

                        for (const file of selectedFiles) {
                            if (!allowedTypes.includes(file.type)) {
                                errorMsg = 'Format tidak didukung. Gunakan JPG, PNG, atau WEBP.';
                                continue;
                            }
                            if (file.size > maxFileSize) {
                                errorMsg = 'Ukuran file maksimal 5MB per foto.';
                                continue;
                            }
                            validFiles.push(file);

                            const reader = new FileReader();
                            const wrapper = document.createElement('div');
                            wrapper.className = 'relative group w-16 h-16 rounded-lg overflow-hidden border border-gray-200 flex-shrink-0';

                            const img = document.createElement('img');
                            img.className = 'w-full h-full object-cover';

                            const removeBtn = document.createElement('button');
                            removeBtn.type = 'button';
                            removeBtn.className = 'absolute top-0.5 right-0.5 w-4 h-4 bg-red-500 text-white rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity text-xs leading-none';
                            removeBtn.innerHTML = '&times;';
                            removeBtn.dataset.index = selectedFiles.indexOf(file).toString();

                            removeBtn.addEventListener('click', function (e) {
                                e.stopPropagation();
                                const idx = parseInt(this.dataset.index);
                                selectedFiles.splice(idx, 1);
                                updatePreview();
                            });

                            wrapper.appendChild(img);
                            wrapper.appendChild(removeBtn);
                            previewThumbnails.appendChild(wrapper);

                            reader.onload = function (e) {
                                img.src = e.target.result;
                            };
                            reader.readAsDataURL(file);
                        }

                        selectedFiles = validFiles;

                        if (selectedFiles.length === 0) {
                            dropzoneEmpty.classList.remove('hidden');
                            dropzonePreview.classList.add('hidden');
                            submitBtn.disabled = true;
                            submitBtn.querySelector('#upload-count').textContent = '';
                            dropzoneError.textContent = errorMsg;
                            dropzoneError.classList.toggle('hidden', !errorMsg);
                            return;
                        }

                        dropzoneError.classList.add('hidden');
                        dropzoneEmpty.classList.add('hidden');
                        dropzonePreview.classList.remove('hidden');
                        fileCount.textContent = selectedFiles.length + ' foto dipilih';
                        uploadCount.textContent = '(' + selectedFiles.length + ')';
                        submitBtn.disabled = false;
                    }

                    dropzone.addEventListener('click', function () {
                        fileInput.click();
                    });

                    dropzone.addEventListener('dragover', function (e) {
                        e.preventDefault();
                        this.classList.add('border-indigo-500', 'bg-indigo-100');
                    });

                    dropzone.addEventListener('dragleave', function () {
                        this.classList.remove('border-indigo-500', 'bg-indigo-100');
                    });

                    dropzone.addEventListener('drop', function (e) {
                        e.preventDefault();
                        this.classList.remove('border-indigo-500', 'bg-indigo-100');
                        const files = Array.from(e.dataTransfer.files).filter(f => allowedTypes.includes(f.type));
                        if (files.length > 0) {
                            selectedFiles = selectedFiles.concat(files);
                            updatePreview();
                        }
                    });

                    fileInput.addEventListener('change', function () {
                        const files = Array.from(this.files);
                        if (files.length > 0) {
                            selectedFiles = selectedFiles.concat(files);
                            updatePreview();
                        }
                        this.value = '';
                    });

                    if (changeFilesBtn) {
                        changeFilesBtn.addEventListener('click', function (e) {
                            e.stopPropagation();
                            fileInput.click();
                        });
                    }

                    document.getElementById('gallery-upload-form').addEventListener('submit', function (e) {
                        if (selectedFiles.length === 0) {
                            e.preventDefault();
                            return;
                        }

                        const dataTransfer = new DataTransfer();
                        selectedFiles.forEach(f => dataTransfer.items.add(f));
                        fileInput.files = dataTransfer.files;
                    });
                });
            </script>

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
