<x-app-layout>
    @include('dashboard.invitations.create._styles')
    @include('dashboard.invitations.create._hero-header')
    @include('dashboard.invitations.create._step-progress')

    <div class="py-8">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div
                class="bg-white dark:bg-secondary-800/90 rounded-2xl sm:rounded-3xl border border-neutral-200/80 dark:border-secondary-700/80 shadow-[0_8px_30px_rgb(0,0,0,0.04)] dark:shadow-[0_8px_30px_rgba(0,0,0,0.25)] overflow-hidden">
                <div class="p-6 md:p-8">
                    <form action="{{ route('dashboard.invitations.store') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="space-y-8">
                            @include('dashboard.invitations.create._step-1-concept')
                            @include('dashboard.invitations.create._step-2-mempelai')
                            @include('dashboard.invitations.create._step-3-events')
                        </div>
                        @include('dashboard.invitations.create._form-actions')
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Spacer for fixed bottom bar (if needed) --}}
    <div class="h-16"></div>

    @include('dashboard.invitations.create._crop-modal')
    @include('dashboard.invitations.create._scripts')
</x-app-layout>