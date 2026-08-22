{{-- ======================================== --}}
                            {{-- Section 5: Keuangan & Kado Digital --}}
                            {{-- ======================================== --}}
                            <div id="sec-5"
                                x-show="activeSection === 'sec-5'"
                                x-transition:enter="transition ease-out duration-300"
                                x-transition:enter-start="opacity-0 translate-x-4"
                                x-transition:enter-end="opacity-100 translate-x-0"
                                class="scroll-mt-32"
                                x-cloak>
                                <div class="mb-3">
                                    <h3 class="font-heading text-lg font-bold text-secondary-800 dark:text-neutral-100">
                                        Keuangan & Kado Digital <span class="text-sm font-normal text-neutral-400 dark:text-neutral-500">(Bank & QRIS)</span>
                                    </h3>
                                </div>
                                <p class="text-sm text-neutral-500 dark:text-neutral-400 mb-6">
                                    Atur rekening bank, dompet digital, dan QRIS untuk menerima kado dari tamu.</p>



                                {{-- Kado Digital --}}
                                <div data-tour="gift-digital"
                                    class="mt-6 bg-neutral-50 dark:bg-secondary-700 p-5 rounded-2xl border border-neutral-200 dark:border-secondary-700">
                                    <div class="flex items-start gap-3">
                                        <div
                                            class="w-9 h-9 shrink-0 rounded-xl bg-primary-100 dark:bg-primary-900/50 flex items-center justify-center text-primary dark:text-primary-300">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                            </svg>
                                        </div>
                                        <div class="flex-1">
                                            <h4 class="font-semibold text-sm text-primary-700 dark:text-primary-300">
                                                Kado
                                                Digital</h4>
                                            <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-0.5">Terima kado
                                                berupa transfer bank, dompet digital, atau QRIS dari tamu Anda.</p>
                                        </div>
                                    </div>

                                    @if($invitation->canUseGift())
                                        @php
                                            $maxGift =
                                                $invitation->maxGiftAccounts();
                                            $oldBanks = old(
                                                'gift_banks',
                                                $invitation->gift_banks ??
                                                []
                                            );
                                            $oldEwallets = old(
                                                'gift_ewallets',
                                                $invitation->gift_ewallets ?? []
                                            );

                                            if (
                                                empty($oldBanks) &&
                                                ($invitation->gift_bank_name ||
                                                    $invitation->gift_bank_account)
                                            ) {
                                                $oldBanks = [
                                                    [
                                                        'bank_name' =>
                                                            $invitation->gift_bank_name,
                                                        'account_number' =>
                                                            $invitation->gift_bank_account,
                                                        'account_holder' =>
                                                            $invitation->gift_bank_holder
                                                    ]
                                                ];
                                            }
                                            if (
                                                empty($oldEwallets) &&
                                                ($invitation->gift_ewallet_name ||
                                                    $invitation->gift_ewallet_number)
                                            ) {
                                                $oldEwallets = [
                                                    [
                                                        'wallet_name' =>
                                                            $invitation->gift_ewallet_name,
                                                        'wallet_number' =>
                                                            $invitation->gift_ewallet_number
                                                    ]
                                                ];
                                            }
                                        @endphp

                                        <div class="mt-4 flex items-start gap-2.5 bg-white dark:bg-secondary-800 border border-neutral-200 dark:border-secondary-600 rounded-xl px-3.5 py-2.5">
                                            <svg class="w-4 h-4 text-primary dark:text-primary-300 shrink-0 mt-0.5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <p class="text-xs text-neutral-600 dark:text-neutral-300 leading-relaxed">
                                                Data di bagian ini ikut tersimpan saat Anda menekan tombol
                                                <strong>Simpan</strong> di bagian bawah halaman.
                                            </p>
                                        </div>

                                        <div id="gift-form" class="mt-5 space-y-6">
                                            <div class="flex items-center justify-between gap-2 flex-wrap">
                                                <span
                                                    class="text-xs text-neutral-500 dark:text-neutral-400 font-semibold">Kuota
                                                    Akun Kado
                                                    (Bank + E-Wallet)</span>
                                                <span id="gift-account-count"
                                                    class="text-xs font-bold text-primary-600 dark:text-primary-400">0
                                                    /
                                                    {{ $maxGift }}</span>
                                            </div>
                                            @error('gift_accounts')
                                                <span
                                                    class="block text-red-500 dark:text-red-400 text-xs">{{ $message }}</span>
                                            @enderror

                                            <div id="gift-empty-hint"
                                                class="text-center py-4 border border-dashed border-neutral-200 dark:border-secondary-600 rounded-xl">
                                                <p class="text-xs text-neutral-400 dark:text-neutral-500">Belum ada akun
                                                    kado. Gunakan tombol di bawah untuk menambahkan rekening bank atau
                                                    dompet digital.</p>
                                            </div>

                                            <div id="gift-banks-container" class="space-y-3">
                                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                                                    <div>
                                                        <label
                                                            class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300">Transfer
                                                            Bank</label>
                                                        <p class="text-xs text-neutral-400 dark:text-neutral-500 mt-0.5">Rekening
                                                            yang ditampilkan untuk tamu kirim transfer</p>
                                                    </div>
                                                    <button type="button" id="add-bank-btn"
                                                        class="inline-flex items-center justify-center gap-1 px-3 py-1.5 rounded-xl border border-primary/30 dark:border-primary-700/60 text-xs font-semibold text-primary-600 dark:text-primary-300 bg-white dark:bg-secondary-800 hover:bg-primary-50 dark:hover:bg-primary-900/20 transition-all whitespace-nowrap">
                                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"
                                                            stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2.5" d="M12 4v16m8-8H4" />
                                                        </svg>
                                                        Tambah Bank
                                                    </button>
                                                </div>
                                                @foreach($oldBanks as $bankIdx => $bank)
                                                    @php $bank = (object) $bank;
                                                    @endphp
                                                    <div
                                                        class="gift-bank-card bg-white dark:bg-secondary-800 p-3 rounded-xl border border-neutral-200 dark:border-secondary-600 space-y-2">
                                                        <div class="flex items-center justify-between flex-wrap gap-1">
                                                            <span
                                                                class="text-xs font-semibold text-neutral-500 dark:text-neutral-400">Bank
                                                                #{{ $loop->iteration }}</span>
                                                            <button type="button"
                                                                class="remove-bank text-red-400 dark:text-red-400 hover:text-red-600 dark:hover:text-red-400 text-xs font-semibold">Hapus</button>
                                                        </div>
                                                        <div class="grid grid-cols-2 gap-2">
                                                            <div>
                                                                <input type="text" name="gift_banks[{{ $bankIdx }}][bank_name]"
                                                                    value="{{ old('gift_banks.' . $bankIdx . '.bank_name', $bank->bank_name ?? '') }}"
                                                                    class="block w-full rounded-xl border-neutral-300 dark:border-neutral-600 shadow-sm focus:border-primary-500 focus:ring-primary-500 text-xs dark:bg-secondary-700 dark:text-neutral-200"
                                                                    placeholder="Nama Bank (contoh: BCA)">
                                                                @error('gift_banks.'
                                                                        . $bankIdx .
                                                                    '.bank_name')
                                                                    <span
                                                                        class="text-red-500 dark:text-red-400 text-xs">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                            <div>
                                                                <input type="text"
                                                                    name="gift_banks[{{ $bankIdx }}][account_number]"
                                                                    value="{{ old('gift_banks.' . $bankIdx . '.account_number', $bank->account_number ?? '') }}"
                                                                    class="block w-full rounded-xl border-neutral-300 dark:border-neutral-600 shadow-sm focus:border-primary-500 focus:ring-primary-500 text-xs dark:bg-secondary-700 dark:text-neutral-200"
                                                                    placeholder="No. Rekening">
                                                                @error('gift_banks.'
                                                                        . $bankIdx .
                                                                    '.account_number')
                                                                    <span
                                                                        class="text-red-500 dark:text-red-400 text-xs">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                            <div class="col-span-2">
                                                                <input type="text"
                                                                    name="gift_banks[{{ $bankIdx }}][account_holder]"
                                                                    value="{{ old('gift_banks.' . $bankIdx . '.account_holder', $bank->account_holder ?? '') }}"
                                                                    class="block w-full rounded-xl border-neutral-300 dark:border-neutral-600 shadow-sm focus:border-primary-500 focus:ring-primary-500 text-xs dark:bg-secondary-700 dark:text-neutral-200"
                                                                    placeholder="Atas Nama">
                                                                @error('gift_banks.'
                                                                        . $bankIdx .
                                                                    '.account_holder')
                                                                    <span
                                                                        class="text-red-500 dark:text-red-400 text-xs">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>

                                            <div id="gift-ewallets-container" class="space-y-3">
                                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                                                    <div>
                                                        <label
                                                            class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300">Dompet
                                                            Digital</label>
                                                        <p class="text-xs text-neutral-400 dark:text-neutral-500 mt-0.5">E-wallet
                                                            yang ditampilkan untuk tamu kirim kado</p>
                                                    </div>
                                                    <button type="button" id="add-ewallet-btn"
                                                        class="inline-flex items-center justify-center gap-1 px-3 py-1.5 rounded-xl border border-primary/30 dark:border-primary-700/60 text-xs font-semibold text-primary-600 dark:text-primary-300 bg-white dark:bg-secondary-800 hover:bg-primary-50 dark:hover:bg-primary-900/20 transition-all whitespace-nowrap">
                                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"
                                                            stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2.5" d="M12 4v16m8-8H4" />
                                                        </svg>
                                                        Tambah
                                                        E-Wallet
                                                    </button>
                                                </div>
                                                @foreach($oldEwallets as $ewalletIdx => $ewallet)
                                                    @php $ewallet = (object) 
                                                    $ewallet; @endphp
                                                    <div
                                                        class="gift-ewallet-card bg-white dark:bg-secondary-800 p-3 rounded-xl border border-neutral-200 dark:border-secondary-600 space-y-2">
                                                        <div class="flex items-center justify-between flex-wrap gap-1">
                                                            <span
                                                                class="text-xs font-semibold text-neutral-500 dark:text-neutral-400">E-Wallet
                                                                #{{ $loop->iteration }}</span>
                                                            <button type="button"
                                                                class="remove-ewallet text-red-400 dark:text-red-400 hover:text-red-600 dark:hover:text-red-400 text-xs font-semibold">Hapus</button>
                                                        </div>
                                                        <div class="grid grid-cols-2 gap-2">
                                                            <div>
                                                                <input type="text"
                                                                    name="gift_ewallets[{{ $ewalletIdx }}][wallet_name]"
                                                                    value="{{ old('gift_ewallets.' . $ewalletIdx . '.wallet_name', $ewallet->wallet_name ?? '') }}"
                                                                    class="block w-full rounded-xl border-neutral-300 dark:border-neutral-600 shadow-sm focus:border-primary-500 focus:ring-primary-500 text-xs dark:bg-secondary-700 dark:text-neutral-200"
                                                                    placeholder="Nama E-Wallet (contoh: GoPay)">
                                                                @error('gift_ewallets.'
                                                                        . $ewalletIdx .
                                                                    '.wallet_name')
                                                                    <span
                                                                        class="text-red-500 dark:text-red-400 text-xs">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                            <div>
                                                                <input type="text"
                                                                    name="gift_ewallets[{{ $ewalletIdx }}][wallet_number]"
                                                                    value="{{ old('gift_ewallets.' . $ewalletIdx . '.wallet_number', $ewallet->wallet_number ?? '') }}"
                                                                    class="block w-full rounded-xl border-neutral-300 dark:border-neutral-600 shadow-sm focus:border-primary-500 focus:ring-primary-500 text-xs dark:bg-secondary-700 dark:text-neutral-200"
                                                                    placeholder="Nomor E-Wallet">
                                                                @error('gift_ewallets.'
                                                                        . $ewalletIdx .
                                                                    '.wallet_number')
                                                                    <span
                                                                        class="text-red-500 dark:text-red-400 text-xs">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>

                                            <hr class="border-neutral-200/70 dark:border-secondary-700">

                                            <div>
                                                <label
                                                    class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300">Kode
                                                    QRIS</label>
                                                <p class="text-xs text-neutral-400 dark:text-neutral-500 mt-0.5">Unggah gambar
                                                    QRIS dari aplikasi e-wallet atau m-banking Anda.</p>
                                                <div class="mt-2 flex items-center gap-4">
                                                    @if($invitation->gift_qris_image)
                                                        <img src="{{ asset('storage/' . $invitation->gift_qris_image) }}"
                                                            alt="QRIS"
                                                            class="w-16 h-16 object-contain border border-neutral-200 dark:border-secondary-600 rounded-xl">
                                                    @endif
                                                    <input type="file" name="gift_qris_image" id="gift_qris_image"
                                                        class="text-xs text-neutral-500 dark:text-neutral-400 file:mr-4 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-primary-50 dark:file:bg-primary-900/50 file:text-primary-700 dark:file:text-primary-300 hover:file:bg-primary-100 dark:hover:file:bg-primary-900/80">
                                                </div>
                                                @error('gift_qris_image')
                                                    <span class="text-red-500 dark:text-red-400 text-xs">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <script>
                                        document.addEventListener(
                                            'DOMContentLoaded',
                                            function() {
                                                const maxAccounts = {{ $maxGift }};
                                                const banksContainer =
                                                    document
                                                    .getElementById(
                                                        'gift-banks-container'
                                                    );
                                                const
                                                    ewalletsContainer =
                                                    document
                                                    .getElementById(
                                                        'gift-ewallets-container'
                                                    );
                                                const bankTemplate =
                                                    document
                                                    .getElementById(
                                                        'gift-bank-template'
                                                    );
                                                const ewalletTemplate =
                                                    document
                                                    .getElementById(
                                                        'gift-ewallet-template'
                                                    );
                                                const accountCountEl =
                                                    document
                                                    .getElementById(
                                                        'gift-account-count'
                                                    );

                                                function updateAccountCount() {
                                                    const total =
                                                        banksContainer
                                                        .querySelectorAll(
                                                            '.gift-bank-card'
                                                        )
                                                        .length +
                                                        ewalletsContainer
                                                        .querySelectorAll(
                                                            '.gift-ewallet-card'
                                                        ).length;
                                                    accountCountEl
                                                        .textContent =
                                                        total + ' / ' +
                                                        maxAccounts;
                                                    const emptyHintEl =
                                                        document
                                                        .getElementById(
                                                            'gift-empty-hint'
                                                        );
                                                    if (emptyHintEl) {
                                                        emptyHintEl.style
                                                            .display =
                                                            total > 0 ?
                                                            'none' : '';
                                                    }
                                                    document
                                                        .getElementById(
                                                            'add-bank-btn'
                                                        )
                                                        .style.display =
                                                        total >=
                                                        maxAccounts ?
                                                        'none' : '';
                                                    document
                                                        .getElementById(
                                                            'add-ewallet-btn'
                                                        )
                                                        .style.display =
                                                        total >=
                                                        maxAccounts ?
                                                        'none' : '';
                                                }

                                                function reindexItems(
                                                    container, prefix) {
                                                    const cards =
                                                        container
                                                        .querySelectorAll(
                                                            '[class*="gift-' +
                                                            prefix +
                                                            '-card"]');
                                                    cards.forEach(
                                                        function(
                                                            card,
                                                            idx) {
                                                            const
                                                                inputs =
                                                                card
                                                                .querySelectorAll(
                                                                    '[name]'
                                                                );
                                                            inputs
                                                                .forEach(
                                                                    function(
                                                                        input
                                                                    ) {
                                                                        const
                                                                            name =
                                                                            input
                                                                            .getAttribute(
                                                                                'name'
                                                                            );
                                                                        if (
                                                                            name) {
                                                                            input
                                                                                .setAttribute(
                                                                                    'name',
                                                                                    name
                                                                                    .replace(
                                                                                        new RegExp(
                                                                                            prefix +
                                                                                            's\\[\\d+\\]'
                                                                                        ),
                                                                                        prefix +
                                                                                        's[' +
                                                                                        idx +
                                                                                        ']'
                                                                                    )
                                                                                );
                                                                        }
                                                                    }
                                                                );
                                                            const
                                                                label =
                                                                card
                                                                .querySelector(
                                                                    'span.text-xs.font-semibold.text-neutral-500'
                                                                );
                                                            if (
                                                                label) {
                                                                const
                                                                    prefixLabel =
                                                                    prefix ===
                                                                    'bank' ?
                                                                    'Bank' :
                                                                    'E-Wallet';
                                                                label
                                                                    .textContent =
                                                                    prefixLabel +
                                                                    ' #' +
                                                                    (
                                                                        idx +
                                                                        1
                                                                    );
                                                            }
                                                        });
                                                }

                                                function addItem(
                                                    container,
                                                    templateId,
                                                    prefix) {
                                                    const total =
                                                        banksContainer
                                                        .querySelectorAll(
                                                            '.gift-bank-card'
                                                        )
                                                        .length +
                                                        ewalletsContainer
                                                        .querySelectorAll(
                                                            '.gift-ewallet-card'
                                                        ).length;
                                                    if (total >=
                                                        maxAccounts)
                                                        return;

                                                    const template =
                                                        document
                                                        .getElementById(
                                                            templateId);
                                                    const clone =
                                                        template.content
                                                        .cloneNode(
                                                            true);
                                                    const card = clone
                                                        .querySelector(
                                                            '[class*="gift-' +
                                                            prefix +
                                                            '-card"]');
                                                    container
                                                        .appendChild(
                                                            card);
                                                    reindexItems(
                                                        container,
                                                        prefix);
                                                    updateAccountCount
                                                        ();
                                                }

                                                banksContainer
                                                    .addEventListener(
                                                        'click',
                                                        function(e) {
                                                            if (e.target
                                                                .closest(
                                                                    '.remove-bank'
                                                                )) {
                                                                e.target
                                                                    .closest(
                                                                        '.gift-bank-card'
                                                                    )
                                                                    .remove();
                                                                reindexItems
                                                                    (banksContainer,
                                                                        'bank'
                                                                    );
                                                                updateAccountCount
                                                                    ();
                                                            }
                                                        });

                                                ewalletsContainer
                                                    .addEventListener(
                                                        'click',
                                                        function(e) {
                                                            if (e.target
                                                                .closest(
                                                                    '.remove-ewallet'
                                                                )) {
                                                                e.target
                                                                    .closest(
                                                                        '.gift-ewallet-card'
                                                                    )
                                                                    .remove();
                                                                reindexItems
                                                                    (ewalletsContainer,
                                                                        'ewallet'
                                                                    );
                                                                updateAccountCount
                                                                    ();
                                                            }
                                                        });

                                                document.getElementById(
                                                        'add-bank-btn')
                                                    .addEventListener(
                                                        'click',
                                                        function() {
                                                            addItem(banksContainer,
                                                                'gift-bank-template',
                                                                'bank'
                                                            );
                                                        });

                                                document.getElementById(
                                                        'add-ewallet-btn'
                                                    )
                                                    .addEventListener(
                                                        'click',
                                                        function() {
                                                            addItem(ewalletsContainer,
                                                                'gift-ewallet-template',
                                                                'ewallet'
                                                            );
                                                        });

                                                updateAccountCount();
                                            });
                                        </script>

                                        <template id="gift-bank-template">
                                            <div
                                                class="gift-bank-card bg-white dark:bg-secondary-800 p-3 rounded-xl border border-neutral-200 dark:border-secondary-600 space-y-2">
                                                <div class="flex items-center justify-between flex-wrap gap-1">
                                                    <span
                                                        class="text-xs font-semibold text-neutral-500 dark:text-neutral-400">Bank
                                                        Baru</span>
                                                    <button type="button"
                                                        class="remove-bank text-red-400 dark:text-red-400 hover:text-red-600 dark:hover:text-red-400 text-xs font-semibold">Hapus</button>
                                                </div>
                                                <div class="grid grid-cols-2 gap-2">
                                                    <div>
                                                        <input type="text" name="gift_banks[999][bank_name]"
                                                            class="block w-full rounded-xl border-neutral-300 dark:border-neutral-600 shadow-sm focus:border-primary-500 focus:ring-primary-500 text-xs dark:bg-secondary-700 dark:text-neutral-200"
                                                            placeholder="Nama Bank (contoh: BCA)">
                                                    </div>
                                                    <div>
                                                        <input type="text" name="gift_banks[999][account_number]"
                                                            class="block w-full rounded-xl border-neutral-300 dark:border-neutral-600 shadow-sm focus:border-primary-500 focus:ring-primary-500 text-xs dark:bg-secondary-700 dark:text-neutral-200"
                                                            placeholder="No. Rekening">
                                                    </div>
                                                    <div class="col-span-2">
                                                        <input type="text" name="gift_banks[999][account_holder]"
                                                            class="block w-full rounded-xl border-neutral-300 dark:border-neutral-600 shadow-sm focus:border-primary-500 focus:ring-primary-500 text-xs dark:bg-secondary-700 dark:text-neutral-200"
                                                            placeholder="Atas Nama">
                                                    </div>
                                                </div>
                                            </div>
                                        </template>

                                        <template id="gift-ewallet-template">
                                            <div
                                                class="gift-ewallet-card bg-white dark:bg-secondary-800 p-3 rounded-xl border border-neutral-200 dark:border-secondary-600 space-y-2">
                                                <div class="flex items-center justify-between flex-wrap gap-1">
                                                    <span
                                                        class="text-xs font-semibold text-neutral-500 dark:text-neutral-400">E-Wallet
                                                        Baru</span>
                                                    <button type="button"
                                                        class="remove-ewallet text-red-400 dark:text-red-400 hover:text-red-600 dark:hover:text-red-400 text-xs font-semibold">Hapus</button>
                                                </div>
                                                <div class="grid grid-cols-2 gap-2">
                                                    <div>
                                                        <input type="text" name="gift_ewallets[999][wallet_name]"
                                                            class="block w-full rounded-xl border-neutral-300 dark:border-neutral-600 shadow-sm focus:border-primary-500 focus:ring-primary-500 text-xs dark:bg-secondary-700 dark:text-neutral-200"
                                                            placeholder="Nama E-Wallet (contoh: GoPay)">
                                                    </div>
                                                    <div>
                                                        <input type="text" name="gift_ewallets[999][wallet_number]"
                                                            class="block w-full rounded-xl border-neutral-300 dark:border-neutral-600 shadow-sm focus:border-primary-500 focus:ring-primary-500 text-xs dark:bg-secondary-700 dark:text-neutral-200"
                                                            placeholder="Nomor E-Wallet">
                                                    </div>
                                                </div>
                                            </div>
                                        </template>
                                    @else
                                        <div class="text-center py-6">
                                            <div
                                                class="w-12 h-12 mx-auto rounded-2xl bg-amber-100 dark:bg-amber-900/20 flex items-center justify-center">
                                                <svg class="w-6 h-6 text-amber-500 dark:text-amber-400" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                                </svg>
                                            </div>
                                            <p class="mt-2 text-sm font-semibold text-amber-800 dark:text-amber-300">
                                                Fitur
                                                Kado Digital Terkunci</p>
                                            <p class="mt-1 text-xs text-amber-700 dark:text-amber-400">
                                                Silakan upgrade paket
                                                Anda untuk menerima kado
                                                digital.</p>
                                        </div>
                                    @endif
                                </div>
