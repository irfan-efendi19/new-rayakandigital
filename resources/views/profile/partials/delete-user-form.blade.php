<section class="space-y-6">
    <header>
        <h2 class="font-heading text-xl font-bold text-red-700">
            {{ __('Hapus Akun') }}
        </h2>
        <p class="mt-1 text-sm text-neutral-500">
            {{ __('Setelah akun Anda dihapus, semua sumber daya dan data akan dihapus secara permanen. Sebelum menghapus akun, silakan unduh data atau informasi yang ingin Anda simpan.') }}
        </p>
    </header>

    <x-danger-button x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')">
        {{ __('Hapus Akun') }}</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-8">
            @csrf
            @method('delete')

            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <div>
                    <h2 class="font-heading text-lg font-bold text-secondary-800">
                        {{ __('Apakah Anda yakin ingin menghapus akun Anda?') }}
                    </h2>
                    <p class="mt-1 text-sm text-neutral-500">
                        {{ __('Tindakan ini tidak dapat dibatalkan.') }}
                    </p>
                    </div>
                    </div>

            <p class="mb-6 text-sm text-neutral-600 bg-neutral-50 rounded-xl p-4">
                {{ __('Setelah akun Anda dihapus, semua sumber daya dan data akan dihapus secara permanen. Silakan masukkan kata sandi Anda untuk mengonfirmasi bahwa Anda ingin menghapus akun secara permanen.') }}
            </p>

            <div class="mb-6">
                <x-input-label for="password" value="{{ __('Kata Sandi') }}" class="sr-only" />
                <x-text-input id="password" name="password" type="password" class="mt-1 block w-full"
                    placeholder="{{ __('Masukkan kata sandi Anda untuk konfirmasi') }}" />
                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

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