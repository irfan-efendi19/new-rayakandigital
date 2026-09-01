<x-app-layout>
    <div class="min-h-screen"
        x-data="{
            activeSection: 'sec-1',
            sections: [
                { id: 'sec-1', num: 1, name: 'Mempelai' },
                { id: 'sec-2', num: 2, name: 'Waktu & Tempat' },
                { id: 'sec-3', num: 3, name: 'Visual & Tema' },
                { id: 'sec-4', num: 4, name: 'Konten' },
                { id: 'sec-5', num: 5, name: 'Keuangan' },
                { id: 'sec-6', num: 6, name: 'RSVP' },
                { id: 'sec-7', num: 7, name: 'Kategori Tamu' },
                { id: 'sec-8', num: 8, name: 'Visibilitas' }
            ],
            init() {
                // Pertahankan section aktif saat halaman di-reload (mis. setelah unggah/hapus foto)
                const savedSection = sessionStorage.getItem('invitation-edit-section');
                if (savedSection && this.sections.some(s => s.id === savedSection)) {
                    this.activeSection = savedSection;
                    sessionStorage.removeItem('invitation-edit-section');
                    return;
                }
                // Temukan error validasi pertama jika ada, dan arahkan ke section tersebut
                const firstErrorEl = document.querySelector('.text-red-500, .border-red-500');
                if (firstErrorEl) {
                    const section = firstErrorEl.closest('[id^=sec-]');
                    if (section) {
                        this.activeSection = section.id;
                    }
                }
            },
            scrollTo(id) {
                this.activeSection = id;
                const formEl = document.getElementById('invitation-form');
                if (formEl) {
                    formEl.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
                const navEl = document.getElementById('nav-item-' + id);
                if (navEl && navEl.offsetParent !== null) {
                    navEl.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
                }
            },
            nextStep() {
                const idx = this.sections.findIndex(s => s.id === this.activeSection);
                if (idx < this.sections.length - 1) {
                    this.scrollTo(this.sections[idx + 1].id);
                }
            },
            prevStep() {
                const idx = this.sections.findIndex(s => s.id === this.activeSection);
                if (idx > 0) {
                    this.scrollTo(this.sections[idx - 1].id);
                }
            }
        }"
        @set-active-section.window="scrollTo($event.detail)"
    >

        {{-- ─── HERO ─── --}}
        @include('dashboard.invitations.edit._hero')

        {{-- ─── STICKY SECTION NAV (8 STEPS) ─── --}}
        @include('dashboard.invitations.edit._nav-stepper')

        {{-- ─── INLINE STYLES ─── --}}
        @include('dashboard.invitations.edit._styles')

        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-7 sm:py-8 relative overflow-hidden">
            {{-- Decorative soft background glows --}}
            <div class="absolute -top-10 left-0 w-72 h-72 bg-primary/10 dark:bg-primary/5 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -bottom-10 right-0 w-72 h-72 bg-indigo-500/10 dark:bg-indigo-500/5 rounded-full blur-3xl pointer-events-none"></div>

            <div
                class="relative bg-white/95 dark:bg-secondary-800/95 backdrop-blur-sm rounded-3xl border border-neutral-200/50 dark:border-secondary-700/40 shadow-[0_15px_50px_-15px_rgba(0,0,0,0.06)] dark:shadow-[0_25px_60px_-15px_rgba(0,0,0,0.3)] overflow-hidden">
                {{-- Premium top accent gradient --}}
                <div class="h-1.5 w-full bg-gradient-to-r from-primary-500 via-primary-600 to-primary-700"></div>
                <div class="p-6 sm:p-8 md:p-10">
                    <form id="invitation-form" action="{{ route('dashboard.invitations.update', $invitation) }}"
                        method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="title" value="{{ old('title', $invitation->title) }}">

                        {{-- Step Header Indicator --}}
                        @include('dashboard.invitations.edit._step-header')

                        <div class="flex flex-col gap-6">

                            {{-- Package Status --}}
                            @include('dashboard.invitations.edit._package-status')

                            {{-- Section 1: Mempelai --}}
                            @include('dashboard.invitations.edit._sec1-mempelai')

                            {{-- Section 2: Waktu & Tempat --}}
                            @include('dashboard.invitations.edit._sec2-waktu-tempat')

                            {{-- Section 3: Visual & Tema --}}
                            @include('dashboard.invitations.edit._sec3-visual-tema')

                            {{-- Section 4: Konten --}}
                            @include('dashboard.invitations.edit._sec4-konten')

                            {{-- Section 5: Keuangan --}}
                            @include('dashboard.invitations.edit._sec5-keuangan')

                        </div>

                        {{-- Section 6: RSVP --}}
                        @include('dashboard.invitations.edit._sec6-rsvp')

                        {{-- Section 7: Kategori Tamu --}}
                        @include('dashboard.invitations.edit._sec7-kategori-tamu')

                        {{-- Section 8: Visibilitas --}}
                        @include('dashboard.invitations.edit._sec8-visibilitas')

                    </div>
                </form>
            </div>
        </div>
        </div>

        {{-- Fixed Bottom Bar --}}
        @include('dashboard.invitations.edit._bottom-bar')

    {{-- Spacer for fixed bottom bar --}}
    <div class="h-28 sm:h-24"></div>

    {{-- Crop Modal --}}
    <x-invitations.crop-modal />

    {{-- Scripts --}}
    @include('dashboard.invitations.edit._scripts')

    </div>
</x-app-layout>
