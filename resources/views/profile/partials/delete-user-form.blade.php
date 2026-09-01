<section class="space-y-6">
    <header class="flex items-center gap-3 mb-6">
        <div class="w-9 h-9 rounded-xl bg-red-100 dark:bg-red-900/30 flex items-center justify-center text-red-600 dark:text-red-400 flex-shrink-0">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
            </svg>
        </div>
        <div>
            <h2 class="font-heading text-lg font-bold text-red-700 dark:text-red-300">
                {{ __('Hapus Akun') }}
            </h2>
            <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-0.5">
                {{ __('Hapus akun beserta seluruh data Anda secara permanen.') }}
            </p>
        </div>
    </header>

    <div class="rounded-xl bg-red-50/60 dark:bg-red-950/20 border border-red-100 dark:border-red-800/40 p-4 sm:p-5">
        <p class="text-sm text-neutral-600 dark:text-neutral-400 leading-relaxed">
            {{ __('Setelah akun Anda dihapus, semua sumber daya dan data akan dihapus secara permanen. Sebelum menghapus akun, silakan unduh data atau informasi yang ingin Anda simpan.') }}
        </p>
        <div class="mt-4">
            <x-danger-button x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')">
                {{ __('Hapus Akun') }}</x-danger-button>
        </div>
    </div>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6 sm:p-8">
            @csrf
            @method('delete')

            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-full bg-red-100 dark:bg-red-900/30 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <div>
                    <h2 class="font-heading text-lg font-bold text-secondary-800 dark:text-neutral-100">
                        {{ __('Apakah Anda yakin ingin menghapus akun Anda?') }}
                    </h2>
                    <p class="mt-1 text-sm text-neutral-500">
                        {{ __('Tindakan ini tidak dapat dibatalkan.') }}
                    </p>
                    </div>
                    </div>

            @if (filled($user->google_id))
                <p class="mb-6 text-sm text-neutral-600 dark:text-neutral-400 bg-neutral-50 dark:bg-secondary-700 rounded-xl p-4">
                    {{ __('Setelah akun Anda dihapus, semua sumber daya dan data akan dihapus secara permanen. Karena Anda masuk dengan Google, ketik alamat email akun Anda untuk mengonfirmasi penghapusan.') }}
                </p>

                <div class="mb-6">
                    <x-input-label for="email_confirmation" :value="__('Konfirmasi Email')" />
                    <x-text-input id="email_confirmation" name="email_confirmation" type="email"
                        class="mt-1.5 block w-full" :value="old('email_confirmation')"
                        placeholder="{{ $user->email }}" autocomplete="off" />
                    <x-input-error :messages="$errors->userDeletion->get('email_confirmation')" class="mt-2" />
                </div>
            @else
                <p class="mb-6 text-sm text-neutral-600 dark:text-neutral-400 bg-neutral-50 dark:bg-secondary-700 rounded-xl p-4">
                    {{ __('Setelah akun Anda dihapus, semua sumber daya dan data akan dihapus secara permanen. Silakan masukkan kata sandi Anda untuk mengonfirmasi bahwa Anda ingin menghapus akun secara permanen.') }}
                </p>

                <div class="mb-6">
                    <x-input-label for="password" value="{{ __('Kata Sandi') }}" class="sr-only" />
                    <x-text-input id="password" name="password" type="password" class="mt-1 block w-full"
                        placeholder="{{ __('Masukkan kata sandi Anda untuk konfirmasi') }}" />
                    <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
                </div>
            @endif

            <div class="flex justify-end gap-3">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Batal') }}
                </x-secondary-button>

                <x-danger-button>
                    {{ __('Hapus Akun') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
