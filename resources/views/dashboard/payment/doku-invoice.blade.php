<x-app-layout>
    <x-slot name="header">
        <h2 class="font-heading text-2xl font-bold text-secondary-800 dark:text-neutral-100">
            Instruksi Pembayaran (Virtual Account)
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            
            @if (session('success'))
                <div class="mb-6 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 text-emerald-700 dark:text-emerald-300 px-5 py-4 rounded-xl text-sm flex items-center gap-3">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white dark:bg-secondary-800 rounded-2xl shadow-soft border border-neutral-200 dark:border-secondary-700 overflow-hidden">
                <div class="p-6 md:p-8 border-b border-neutral-100 dark:border-secondary-700 flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div>
                        <h3 class="font-heading text-lg font-bold text-secondary-800 dark:text-neutral-100">
                            Order ID: {{ $order->order_id }}
                        </h3>
                        <p class="text-sm text-neutral-500 mt-1">Selesaikan pembayaran sebelum batas waktu berakhir.</p>
                    </div>
                    
                    <div class="flex flex-col items-start md:items-end">
                        <span class="text-xs font-semibold text-neutral-500 uppercase tracking-wider mb-1">Status Pembayaran</span>
                        @if($order->payment_status === 'pending')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                Menunggu Pembayaran
                            </span>
                        @elseif($order->payment_status === 'success' || $order->payment_status === 'settlement')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Berhasil
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                {{ ucfirst($order->payment_status) }}
                            </span>
                        @endif
                    </div>
                </div>

                <div class="p-6 md:p-8 bg-neutral-50 dark:bg-secondary-800/50">
                    <div class="max-w-md mx-auto space-y-6">
                        
                        <div class="text-center">
                            <p class="text-sm text-neutral-500 dark:text-neutral-400 font-medium mb-1">Total Pembayaran</p>
                            <p class="font-heading text-4xl font-extrabold text-primary-600 dark:text-primary-400">
                                Rp {{ number_format($order->gross_amount + $order->unique_code, 0, ',', '.') }}
                            </p>
                        </div>

                        <div class="bg-white dark:bg-secondary-900 rounded-xl p-5 border border-neutral-200 dark:border-secondary-700 shadow-sm relative overflow-hidden">
                            <div class="absolute top-0 right-0 p-3 opacity-10">
                                <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 14.5v-9l6 4.5-6 4.5z"/></svg>
                            </div>
                            
                            <p class="text-xs font-semibold text-neutral-500 uppercase tracking-wider mb-2">Nomor Virtual Account</p>
                            
                            @php
                                // Retrieve channel label based on order channel code
                                $channels = \App\Services\DokuService::getAvailableChannels();
                                $channelCode = $order->doku_channel_code;
                                $channelInfo = collect($channels)->firstWhere('code', $channelCode);
                                $channelLabel = $channelInfo ? $channelInfo['label'] : 'Virtual Account';
                            @endphp
                            
                            <p class="text-sm font-medium text-secondary-800 dark:text-neutral-200 mb-2">
                                {{ $channelLabel }}
                            </p>
                            
                            <div class="flex items-center justify-between bg-neutral-100 dark:bg-secondary-800 rounded-lg p-3">
                                <span class="font-mono text-xl font-bold text-secondary-900 dark:text-white tracking-widest break-all" id="va-number">
                                    {{ $order->doku_va_number }}
                                </span>
                                
                                <button onclick="copyToClipboard('va-number')" class="ml-3 p-2 text-primary-600 hover:bg-primary-50 dark:hover:bg-primary-900/30 rounded-md transition-colors tooltip" data-tip="Salin">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                    </svg>
                                </button>
                            </div>
                            
                            <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-4 text-center">
                                Berlaku hingga: <br>
                                <strong class="text-secondary-700 dark:text-neutral-300">{{ $order->doku_expired_at ? $order->doku_expired_at->format('d M Y, H:i') : '-' }}</strong>
                            </p>
                        </div>
                    </div>
                </div>
                
                <div class="p-6 border-t border-neutral-100 dark:border-secondary-700 bg-white dark:bg-secondary-800 flex justify-center">
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center px-6 py-2.5 bg-neutral-100 text-neutral-700 hover:bg-neutral-200 dark:bg-secondary-700 dark:text-neutral-200 dark:hover:bg-secondary-600 font-semibold rounded-lg transition-colors text-sm">
                        Kembali ke Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function copyToClipboard(elementId) {
            var text = document.getElementById(elementId).innerText;
            navigator.clipboard.writeText(text).then(function() {
                // simple feedback
                let btn = event.currentTarget;
                let originalHtml = btn.innerHTML;
                btn.innerHTML = '<svg class="w-5 h-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>';
                setTimeout(() => {
                    btn.innerHTML = originalHtml;
                }, 2000);
            }, function(err) {
                console.error('Could not copy text: ', err);
            });
        }
    </script>
    @endpush
</x-app-layout>
