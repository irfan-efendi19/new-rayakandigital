<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
            <div>
                <h2 class="font-heading text-2xl font-bold text-secondary-800">
                    Log WhatsApp: {{ $invitation->title }}
                </h2>
                <p class="text-sm text-neutral-500 mt-0.5">Riwayat pengiriman pesan WhatsApp ke tamu undangan.</p>
            </div>
            <div class="flex gap-2">
                @if($invitation->hasFeature('personal_link'))
                <a href="{{ route('dashboard.invitations.guests.index', $invitation) }}"
                   class="inline-flex items-center gap-1.5 bg-white border border-neutral-200 text-neutral-700 px-4 py-2 rounded-xl text-sm font-medium hover:bg-neutral-50 transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali ke Daftar Tamu
                </a>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-soft border border-neutral-100">
                <div class="p-6">
                    @if($logs->isEmpty())
                        <div class="text-center py-16">
                            <div class="w-16 h-16 mx-auto bg-neutral-100 rounded-full flex items-center justify-center mb-4">
                                <svg class="w-8 h-8 text-neutral-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                </svg>
                            </div>
                            <h3 class="text-base font-bold text-secondary-800">Belum ada pengiriman</h3>
                            <p class="mt-1 text-sm text-neutral-500">Riwayat WhatsApp akan muncul setelah Anda mengirim undangan ke tamu.</p>
                        </div>
                    @else
                        <div class="overflow-x-auto border border-neutral-200 rounded-2xl">
                            <table class="min-w-full divide-y divide-neutral-200">
                                <thead class="bg-neutral-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-neutral-500 uppercase tracking-wider">Tamu</th>
                                        <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-neutral-500 uppercase tracking-wider">Status</th>
                                        <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-neutral-500 uppercase tracking-wider">Pesan</th>
                                        <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-neutral-500 uppercase tracking-wider">Error</th>
                                        <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-neutral-500 uppercase tracking-wider">Waktu Kirim</th>
                                        <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-neutral-500 uppercase tracking-wider">Dibuat</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-neutral-100">
                                    @foreach($logs as $log)
                                        <tr class="hover:bg-neutral-50 transition-colors">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="text-sm font-semibold text-secondary-800">{{ $log->guest?->name ?? 'Unknown' }}</span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @php
                                                    $statusBadge = match($log->status) {
                                                        'sent' => ['bg-emerald-100 text-emerald-800', 'Terkirim'],
                                                        'failed' => ['bg-red-100 text-red-800', 'Gagal'],
                                                        'queued' => ['bg-blue-100 text-blue-800', 'Terjadwal'],
                                                        'pending' => ['bg-amber-100 text-amber-800', 'Diproses'],
                                                        default => ['bg-neutral-100 text-neutral-600', ucfirst($log->status)],
                                                    };
                                                @endphp
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusBadge[0] }}">
                                                    {{ $statusBadge[1] }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-sm text-neutral-500 max-w-xs truncate">
                                                {{ Str::limit($log->message_content, 80) }}
                                            </td>
                                            <td class="px-6 py-4 text-sm text-red-500 max-w-xs truncate">
                                                {{ $log->error_message ?? '—' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-500">
                                                {{ $log->sent_at ? $log->sent_at->format('d/m/Y H:i') : '—' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-500">
                                                {{ $log->created_at->format('d/m/Y H:i') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-6">
                            {{ $logs->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
