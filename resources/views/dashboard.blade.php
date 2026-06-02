<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-heading text-2xl font-bold text-secondary-800">
                {{ __('Dashboard') }}
            </h2>
            <p class="text-sm text-neutral-500 mt-0.5">Selamat datang kembali, {{ Auth::user()->name }}!</p>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-soft border border-neutral-100 overflow-hidden">
                <div class="p-6 text-secondary-800">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
