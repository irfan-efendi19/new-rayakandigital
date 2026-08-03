<section>
    <header class="flex items-center gap-3 mb-6">
        <div
            class="w-9 h-9 rounded-xl bg-primary-100 dark:bg-primary-900/50 flex items-center justify-center text-primary dark:text-primary-400 flex-shrink-0">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
        </div>
        <div>
            <h2 class="font-heading text-lg font-bold text-secondary-800 dark:text-neutral-100">
                {{ __('Informasi Profil') }}
            </h2>
            <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-0.5">
                {{ __('Perbarui informasi profil akun Anda dan alamat email.') }}
            </p>
        </div>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-5">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Nama')" />
            <x-text-input id="name" name="name" type="text" class="mt-1.5 block w-full px-4 py-2.5"
                :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-1.5" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1.5 block w-full px-4 py-2.5"
                :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-1.5" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                <div class="mt-3 flex items-start gap-2.5 p-3 bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800/60 rounded-xl">
                    <svg class="w-4 h-4 text-amber-600 dark:text-amber-400 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <div class="text-xs text-amber-800 dark:text-amber-300 leading-relaxed">
                        <p>
                            {{ __('Alamat email Anda belum diverifikasi.') }}

                            <button form="send-verification"
                                class="underline font-semibold text-amber-700 dark:text-amber-400 hover:text-amber-900 dark:hover:text-amber-200 rounded focus:outline-none focus:ring-2 focus:ring-amber-500">
                                {{ __('Klik di sini untuk mengirim ulang email verifikasi.') }}
                            </button>
                        </p>

                        @if (session('status') === 'verification-link-sent')
                            <p class="mt-1.5 font-semibold text-emerald-600 dark:text-emerald-400">
                                {{ __('Tautan verifikasi baru telah dikirim ke alamat email Anda.') }}
                            </p>
                        @endif
                    </div>
                </div>
            @endif
        </div>

        <div class="flex flex-wrap items-center gap-4 pt-4 border-t border-neutral-100 dark:border-secondary-700/60">
            <x-primary-button>{{ __('Simpan') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="inline-flex items-center gap-1.5 text-sm text-emerald-600 dark:text-emerald-400 font-medium">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                    {{ __('Tersimpan.') }}
                </p>
            @endif
        </div>
    </form>
</section>
