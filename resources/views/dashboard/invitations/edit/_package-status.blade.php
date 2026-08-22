{{-- Package Status --}}
                            @php
                                $tierCode = $invitation->currentTier();
                                $tierBadgeColor = match ($tierCode) {
                                    'bronze' => 'bg-orange-100 dark:bg-orange-900/50 text-orange-700
                                                            dark:text-orange-300
                                                            border-orange-200 dark:border-orange-800',
                                    'silver' => 'bg-neutral-100 dark:bg-neutral-700 text-neutral-700
                                                            dark:text-neutral-300
                                                            border-neutral-200 dark:border-neutral-600',
                                    'gold' => 'bg-amber-100 dark:bg-amber-900/50 text-amber-700
                                                            dark:text-amber-300
                                                            border-amber-200 dark:border-amber-800',
                                    'platinum' => 'bg-primary-100 dark:bg-primary-900/50
                                                            text-primary-700 dark:text-primary-300
                                                            border-primary-200 dark:border-primary-800',
                                    default => 'bg-neutral-100 dark:bg-neutral-700 text-neutral-500
                                                            dark:text-neutral-400
                                                            border-neutral-200 dark:border-neutral-600'
                                };
                                $isExpired = $invitation->isTrialExpired();
                                $isTrial = $invitation->expires_at !== null &&
                                    !$invitation->hasPremiumFeatures();
                                $daysLeft = $invitation->expires_at ? (int) 
                                    max(
                                        0,
                                        now()->diffInDays(
                                            $invitation->expires_at,
                                            false
                                        )
                                    ) : null;
                            @endphp
                            <div
                                class="bg-white dark:bg-secondary-800 border rounded-2xl p-5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 {{ $isExpired ? 'border-red-200 dark:border-red-800 bg-red-50/50 dark:bg-red-900/10' : ($isTrial ? 'border-amber-200 dark:border-amber-800 bg-amber-50/50 dark:bg-amber-900/10' : 'border-neutral-200 dark:border-neutral-700') }}">
                                <div class="flex items-center gap-4">
                                    <div
                                        class="flex-shrink-0 w-10 h-10 rounded-xl flex items-center justify-center
                                        {{ $isExpired ? 'bg-red-100 dark:bg-red-900/50 text-red-500' : ($isTrial ? 'bg-amber-100 dark:bg-amber-900/50 text-amber-500' : 'bg-primary-100 dark:bg-primary-900/50 text-primary') }}">
                                        @if($isExpired)
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z" />
                            </svg>
                                        @else
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="flex items-center gap-2">
                                            <span
                                                class="font-heading text-base font-bold text-secondary-800 dark:text-neutral-100">Paket</span>
                                            <span
                                                class="inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold uppercase tracking-wider {{ $tierBadgeColor }}">
                                                {{ $tierCode === 'free' ? 'Gratis' : $tierCode }}
                                            </span>
                                        </div>
                                        <p class="text-sm text-neutral-500 dark:text-neutral-400 mt-0.5">
                                            @if($isExpired)
                                                Undangan telah kedaluwarsa.
                                            @elseif($invitation->expires_at)
                                                @if($isTrial)
                                                    Masa percobaan tersisa
                                                    <strong>{{ $daysLeft }}
                                                        hari</strong>.
                                                @else
                                                    Aktif hingga
                                                    <strong>{{ $invitation->expires_at->format('d F Y') }}</strong>
                                                    @if(
                                                            $daysLeft !== null &&
                                                            $daysLeft > 0
                                                        )
                                                        ({{ $daysLeft }} hari lagi)
                                                    @endif
                                                @endif
                                            @else
                                                Paket aktif tanpa batas
                                                waktu.
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                @if(!$isExpired && $tierCode === 'free')
                                    <a href="{{ route('dashboard.checkout', ['invitation_id' => $invitation->id]) }}"
                                        class="inline-flex items-center justify-center gap-2 w-full sm:w-auto px-4 py-2 text-sm font-semibold text-white bg-primary rounded-xl hover:bg-primary-600 focus:ring-2 focus:ring-primary focus:ring-offset-2 transition-all flex-shrink-0">
                                        Upgrade
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                        </svg>
                                    </a>
                                @endif
                            </div>
