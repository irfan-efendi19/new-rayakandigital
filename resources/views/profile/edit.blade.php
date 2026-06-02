<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-heading text-2xl font-bold text-secondary-800">
                {{ __('Profile') }}
            </h2>
            <p class="text-sm text-neutral-500 mt-0.5">Kelola informasi akun dan pengaturan keamanan.</p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white rounded-2xl shadow-soft border border-neutral-100 p-8">
                @include('profile.partials.update-profile-information-form')
            </div>

            <div class="bg-white rounded-2xl shadow-soft border border-neutral-100 p-8">
                @include('profile.partials.update-password-form')
            </div>

            <div class="bg-white rounded-2xl shadow-soft border border-red-100 p-8">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</x-app-layout>
