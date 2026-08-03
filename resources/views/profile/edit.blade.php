<x-app-layout>
    @php
        $hour = now()->setTimezone('Asia/Jakarta')->hour;
        $greeting = match(true) {
            $hour >= 4  && $hour < 11 => 'Selamat Pagi',
            $hour >= 11 && $hour < 15 => 'Selamat Siang',
            $hour >= 15 && $hour < 19 => 'Selamat Sore',
            default                   => 'Selamat Malam',
        };
        $greetingIcon = match(true) {
            $hour >= 4  && $hour < 11 => '☀️',
            $hour >= 11 && $hour < 15 => '🌤️',
            $hour >= 15 && $hour < 19 => '🌇',
            default                   => '🌙',
        };
        $initials = collect(preg_split('/\s+/', trim($user->name)))
            ->map(fn($word) => mb_substr($word, 0, 1))
            ->filter()
            ->take(2)
            ->implode('');
        $memberSince = $user->created_at ? $user->created_at->translatedFormat('d M Y') : '-';
    @endphp

    <div class="min-h-screen">

        {{-- ─────────────────────────────────────────────────────────────────────
             HERO SECTION
        ──────────────────────────────────────────────────────────────────────── --}}
        <div class="hero-mesh grain-overlay border-b border-neutral-200/60 dark:border-secondary-700/40">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-7 sm:py-8">

                {{-- Breadcrumb --}}
                <nav class="flex items-center gap-1.5 text-xs text-neutral-400 dark:text-neutral-500 mb-5">
                    <a href="{{ route('dashboard') }}" class="hover:text-primary dark:hover:text-primary-400 transition-colors">Dashboard</a>
                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                    <span class="text-neutral-600 dark:text-neutral-400 font-medium">Profil</span>
                </nav>

                {{-- Profile header + CTA --}}
                <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-5">
                    <div class="flex items-start gap-4 min-w-0">
                        <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-2xl bg-gradient-to-br from-primary to-primary-600 text-white flex items-center justify-center font-heading font-bold text-xl sm:text-2xl shadow-lg shadow-primary/25 flex-shrink-0">
                            {{ $initials }}
                        </div>
                        <div class="min-w-0">
                            <p class="text-sm font-medium text-primary dark:text-primary-400 tracking-wide flex flex-wrap items-center gap-1.5 mb-1">
                                <span>{{ $greetingIcon }}</span>
                                <span class="break-words">{{ $greeting }}, {{ $user->name }}</span>
                            </p>
                            <h1 class="font-heading text-2xl sm:text-3xl font-bold text-secondary-800 dark:text-neutral-50 leading-tight">
                                Profil & Pengaturan
                            </h1>
                            <p class="text-sm text-neutral-500 dark:text-neutral-400 mt-1.5 max-w-sm">
                                Kelola informasi akun, kata sandi, dan pengaturan keamanan Anda.
                            </p>
                        </div>
                    </div>

                    <a href="{{ route('dashboard') }}"
                        class="inline-flex items-center justify-center gap-2 px-3.5 py-2 text-xs font-semibold text-neutral-700 dark:text-neutral-300 bg-white/70 dark:bg-secondary-800/50 border border-neutral-300/80 dark:border-secondary-600 rounded-xl hover:bg-white dark:hover:bg-secondary-700 transition-all backdrop-blur-sm w-full sm:w-auto">
                        <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Kembali ke Dashboard
                    </a>
                </div>

                {{-- Stat Strip --}}
                <div class="mt-7 grid grid-cols-1 sm:grid-cols-3 gap-px bg-neutral-200/70 dark:bg-secondary-700/50 rounded-2xl overflow-hidden border border-neutral-200/80 dark:border-secondary-700/50">
                    <div class="bg-white/80 dark:bg-secondary-800/70 px-4 sm:px-5 py-4 flex flex-col items-center sm:items-start text-center sm:text-left backdrop-blur-sm min-w-0">
                        <span class="stat-value text-base sm:text-lg font-bold text-secondary-800 dark:text-neutral-100 tabular-nums truncate max-w-full" title="{{ $user->email }}">{{ $user->email }}</span>
                        <span class="text-[10px] sm:text-xs text-neutral-500 dark:text-neutral-400 font-medium mt-0.5 leading-tight">Alamat Email</span>
                    </div>
                    <div class="bg-white/80 dark:bg-secondary-800/70 px-4 sm:px-5 py-4 flex flex-col items-center sm:items-start text-center sm:text-left backdrop-blur-sm min-w-0">
                        <span class="stat-value text-base sm:text-2xl font-bold text-primary dark:text-primary-300 tabular-nums">{{ $memberSince }}</span>
                        <span class="text-[10px] sm:text-xs text-neutral-500 dark:text-neutral-400 font-medium mt-0.5 leading-tight">Bergabung Sejak</span>
                    </div>
                    <div class="bg-white/80 dark:bg-secondary-800/70 px-4 sm:px-5 py-4 flex flex-col items-center sm:items-start text-center sm:text-left backdrop-blur-sm min-w-0">
                        <span class="stat-value text-base sm:text-2xl font-bold text-emerald-600 dark:text-emerald-400 tabular-nums">{{ $invitationCount }}</span>
                        <span class="text-[10px] sm:text-xs text-neutral-500 dark:text-neutral-400 font-medium mt-0.5 leading-tight">Total Undangan</span>
                    </div>
                </div>

            </div>
        </div>

        {{-- ─────────────────────────────────────────────────────────────────────
             MAIN CONTENT
        ──────────────────────────────────────────────────────────────────────── --}}
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-7 sm:py-8 space-y-6">

            <div class="bg-white dark:bg-secondary-800 rounded-2xl shadow-soft border border-neutral-100 dark:border-secondary-700/60 p-6 md:p-8">
                @include('profile.partials.update-profile-information-form')
            </div>

            <div class="bg-white dark:bg-secondary-800 rounded-2xl shadow-soft border border-neutral-100 dark:border-secondary-700/60 p-6 md:p-8">
                @include('profile.partials.update-password-form')
            </div>

            <div class="bg-white dark:bg-secondary-800 rounded-2xl shadow-soft border border-red-100 dark:border-red-800/50 p-6 md:p-8">
                @include('profile.partials.delete-user-form')
            </div>

        </div>
    </div>
</x-app-layout>
