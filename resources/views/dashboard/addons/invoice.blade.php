<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-neutral-100 leading-tight">
            {{ __('Konfirmasi Pembayaran Add-On') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white dark:bg-secondary-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8">

                    <div class="text-center mb-8">
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-neutral-100">Tagihan Pembayaran Add-On</h3>
                        <p class="text-sm text-gray-500 dark:text-neutral-400 mt-2">Lakukan transfer ke rekening berikut dan kirim bukti via WhatsApp</p>
                    </div>

                    {{-- Invoice Info --}}
                    <div class="bg-gray-50 dark:bg-secondary-700/50 rounded-xl p-6 mb-6 border border-gray-200 dark:border-secondary-600">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <p class="text-xs text-gray-500 dark:text-neutral-400 uppercase tracking-wide">ID Transaksi</p>
                                <p class="text-lg font-bold text-gray-900 dark:text-neutral-100 font-mono">{{ $transaction->reference_order_id }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 dark:text-neutral-400 uppercase tracking-wide">Add-On</p>
                                <p class="text-lg font-bold text-gray-900 dark:text-neutral-100">{{ $transaction->addon->name }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 dark:text-neutral-400 uppercase tracking-wide">Undangan</p>
                                <p class="text-lg font-bold text-gray-900 dark:text-neutral-100">{{ $invitation->title }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 dark:text-neutral-400 uppercase tracking-wide">Status</p>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                    {{ $transaction->payment_status === 'pending' ? 'bg-yellow-100 dark:bg-yellow-900/50 text-yellow-800 dark:text-yellow-300' : '' }}
                                    {{ $transaction->payment_status === 'verifying' ? 'bg-blue-100 dark:bg-blue-900/50 text-blue-800 dark:text-blue-300' : '' }}
                                    {{ $transaction->payment_status === 'settlement' ? 'bg-green-100 dark:bg-green-900/50 text-green-800 dark:text-green-300' : '' }}
                                ">
                                    {{ $transaction->payment_status === 'pending' ? 'Menunggu Pembayaran' : '' }}
                                    {{ $transaction->payment_status === 'verifying' ? 'Verifikasi (Menunggu Validasi Admin via WA)' : '' }}
                                    {{ $transaction->payment_status === 'settlement' ? 'Lunas' : '' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- Bank Account Info --}}
                    <div class="border-2 border-dashed border-indigo-300 dark:border-indigo-700 rounded-xl p-6 mb-6 bg-indigo-50 dark:bg-indigo-900/20">
                        <h4 class="font-semibold text-indigo-800 dark:text-indigo-300 mb-4">Rekening Tujuan Transfer</h4>
                        <div class="space-y-2">
                            @if($routing->getBankName())
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-neutral-400">Bank</span>
                                <span class="font-semibold text-gray-900 dark:text-neutral-100">{{ $routing->getBankName() }}</span>
                            </div>
                            @endif
                            @if($routing->getBankAccountNumber())
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-neutral-400">Nomor Rekening</span>
                                <span class="font-semibold text-gray-900 dark:text-neutral-100 font-mono text-lg">{{ $routing->getBankAccountNumber() }}</span>
                            </div>
                            @endif
                            @if($routing->getBankAccountHolder())
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-neutral-400">Atas Nama</span>
                                <span class="font-semibold text-gray-900 dark:text-neutral-100">{{ $routing->getBankAccountHolder() }}</span>
                            </div>
                            @endif
                        </div>
                    </div>

                    {{-- Total Amount --}}
                    <div class="bg-gray-900 rounded-xl p-6 mb-6 text-white">
                        <div class="text-center">
                            <p class="text-sm text-gray-400 mb-1">Total yang Harus Ditransfer</p>
                            <p class="text-4xl font-extrabold tracking-tight">Rp{{ number_format((int) $transaction->amount, 0, ',', '.') }}</p>
                        </div>
                    </div>

                    {{-- Important Notes --}}
                    <div class="bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-xl p-4 mb-6 text-sm text-amber-800 dark:text-amber-300">
                        <p class="font-medium mb-1">Perhatian:</p>
                        <ul class="list-disc list-inside space-y-1 text-amber-700 dark:text-amber-400">
                            <li>Transfer tepat sejumlah <strong>Rp{{ number_format((int) $transaction->amount, 0, ',', '.') }}</strong>.</li>
                            <li>Setelah transfer, kirim bukti via WhatsApp dengan menekan tombol di bawah.</li>
                            <li>Add-on akan aktif setelah pembayaran diverifikasi oleh admin.</li>
                        </ul>
                    </div>

                    {{-- WhatsApp Button --}}
                    @if($transaction->payment_status === 'pending')
                        <a href="{{ route('dashboard.invitations.addons.send-whatsapp', [$invitation, $transaction]) }}"
                           onclick="event.preventDefault(); document.getElementById('send-wa-form').submit();"
                           class="block w-full text-center bg-green-600 hover:bg-green-700 text-white font-bold py-4 px-6 rounded-xl text-lg transition-all shadow-lg shadow-green-200 dark:shadow-green-900/50">
                            <span class="flex items-center justify-center gap-3">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                                </svg>
                                Kirim Bukti Transfer via WhatsApp
                            </span>
                        </a>

                        <form id="send-wa-form" action="{{ route('dashboard.invitations.addons.send-whatsapp', [$invitation, $transaction]) }}" method="POST" class="hidden">
                            @csrf
                        </form>
                    @elseif($transaction->payment_status === 'verifying')
                        <div class="text-center bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-xl p-6">
                            <svg class="w-12 h-12 text-blue-500 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="text-blue-800 dark:text-blue-300 font-semibold">Menunggu Validasi Admin via WhatsApp</p>
                            <p class="text-sm text-blue-600 dark:text-blue-400 mt-1">Bukti transfer Anda sedang diverifikasi oleh tim admin.</p>
                        </div>
                    @elseif($transaction->payment_status === 'settlement')
                        <div class="text-center bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-xl p-6">
                            <svg class="w-12 h-12 text-green-500 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="text-green-800 dark:text-green-300 font-semibold">Pembayaran Sukses!</p>
                            <p class="text-sm text-green-600 dark:text-green-400 mt-1">Add-on {{ $transaction->addon->name }} sudah aktif.</p>
                        </div>
                    @endif

                    <div class="mt-6 text-center">
                        <a href="{{ route('dashboard.invitations.addons.index', $invitation) }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300 text-sm font-medium">
                            &larr; Kembali ke Add-On
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
