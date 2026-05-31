import Swal from 'sweetalert2/dist/sweetalert2.js';

class SlugEditor {
    constructor() {
        console.log('🔧 SlugEditor constructor started');
        
        this.input = document.getElementById('slug-input');
        this.indicator = document.getElementById('slug-indicator');
        this.form = this.input?.closest('form');
        this.slugOriginal = this.input?.dataset.original || '';
        this.invitationId = this.input?.dataset.id || '';
        this.debounceTimer = null;
        this.isAvailable = true;

        console.log('🔍 SlugEditor elements:', {
            inputFound: !!this.input,
            indicatorFound: !!this.indicator,
            formFound: !!this.form,
            slugOriginal: this.slugOriginal,
            invitationId: this.invitationId
        });

        if (!this.input) {
            console.warn('⚠️ SlugEditor: slug-input element not found!');
            return;
        }

        this.setupAutoSanitize();
        this.setupFormSubmit();
        
        console.log('✅ SlugEditor initialized successfully');
    }

    setupAutoSanitize() {
        this.input.addEventListener('input', () => {
            let value = this.input.value;

            value = value.toLowerCase().replace(/\s+/g, '-').replace(/[^a-z0-9-]/g, '');

            if (value !== this.input.value) {
                this.input.value = value;
            }

            this.checkAvailability();
        });
    }

    checkAvailability() {
        clearTimeout(this.debounceTimer);

        const slug = this.input.value.trim();

        if (!slug) {
            this.setIndicator('idle', '');
            return;
        }

        if (slug === this.slugOriginal) {
            this.setIndicator('same', '');
            this.isAvailable = true;
            return;
        }

        this.setIndicator('checking', 'Memeriksa ketersediaan...');

        this.debounceTimer = setTimeout(() => {
            const params = new URLSearchParams({ slug });
            if (this.invitationId) params.append('exclude', this.invitationId);

            fetch(`/dashboard/invitations/check-slug?${params}`, {
                headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
            })
                .then(res => res.json())
                .then(data => {
                    if (data.available) {
                        this.setIndicator('available', 'Tersedia');
                        this.isAvailable = true;
                    } else {
                        this.setIndicator('unavailable', 'Link sudah digunakan');
                        this.isAvailable = false;
                    }
                })
                .catch(err => {
                    console.error('Fetch error:', err);
                    this.setIndicator('error', 'Gagal memeriksa');
                    this.isAvailable = true;
                });
        }, 500);
    }

    setIndicator(state, message) {
        if (!this.indicator) return;

        this.indicator.className = 'mt-1 text-xs flex items-center gap-1';

        const iconSpan = this.indicator.querySelector('.slug-icon');
        const textSpan = this.indicator.querySelector('.slug-text');

        switch (state) {
            case 'idle':
                this.indicator.className += ' text-gray-400';
                if (iconSpan) iconSpan.textContent = '🔗';
                if (textSpan) textSpan.textContent = 'Masukkan tautan kustom';
                break;
            case 'same':
                this.indicator.className += ' text-gray-400';
                if (iconSpan) iconSpan.textContent = '🔗';
                if (textSpan) textSpan.textContent = 'Tautan saat ini';
                break;
            case 'checking':
                this.indicator.className += ' text-amber-500';
                if (iconSpan) iconSpan.textContent = '⏳';
                if (textSpan) textSpan.textContent = message;
                break;
            case 'available':
                this.indicator.className += ' text-green-600';
                if (iconSpan) iconSpan.textContent = '✓';
                if (textSpan) textSpan.textContent = message;
                break;
            case 'unavailable':
                this.indicator.className += ' text-red-600';
                if (iconSpan) iconSpan.textContent = '✗';
                if (textSpan) textSpan.textContent = message;
                break;
            case 'error':
                this.indicator.className += ' text-gray-500';
                if (iconSpan) iconSpan.textContent = '⚠';
                if (textSpan) textSpan.textContent = message;
                break;
        }
    }

    setupFormSubmit() {
        if (!this.form) {
            console.warn('⚠️ Form not found, skipping setupFormSubmit');
            return;
        }

        console.log('📝 Attaching form submit listener');

        this.form.addEventListener('submit', (e) => {
            const slug = this.input.value.trim();

            console.log('📤 Form submit event fired!', {
                slug,
                original: this.slugOriginal,
                available: this.isAvailable
            });

            // If slug unchanged - allow normal submission
            if (slug === this.slugOriginal) {
                console.log('➡️ Slug unchanged, allowing normal submission');
                return;
            }

            // If slug is empty
            if (!slug) {
                e.preventDefault();
                console.log('❌ Slug is empty');
                Swal.fire('Peringatan', 'Tautan kustom tidak boleh kosong', 'warning');
                return;
            }

            // If still checking availability
            const indicatorText = this.indicator?.querySelector('.slug-text')?.textContent || '';
            if (indicatorText === 'Memeriksa ketersediaan...') {
                e.preventDefault();
                console.log('⏳ Still checking slug availability');
                Swal.fire('Tunggu', 'Sedang memeriksa ketersediaan tautan...', 'info');
                return;
            }

            // If slug not available
            if (!this.isAvailable) {
                e.preventDefault();
                console.log('❌ Slug not available');
                Swal.fire('Peringatan', 'Tautan sudah digunakan atau tidak tersedia', 'warning');
                return;
            }

            // Slug changed and valid - show confirmation
            e.preventDefault();
            console.log('✅ Slug valid, showing confirmation');

            const self = this;
            Swal.fire({
                title: 'Apakah Anda yakin?',
                html: `
                    <div class="text-left text-sm space-y-3">
                        <p class="text-gray-700">Tautan lama <strong>${window.location.origin}/${this.slugOriginal}</strong> tidak akan bisa diakses lagi setelah diubah.</p>
                        <p class="text-gray-700">Pastikan Anda belum menyebarkan tautan lama ke tamu undangan.</p>
                        <p class="text-amber-700 font-semibold">Tautan baru: <strong>${window.location.origin}/${slug}</strong></p>
                    </div>
                `,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, simpan!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    console.log('✅ Confirmation accepted, submitting form');
                    self.form.submit();
                }
            });
        });
    }
}

document.addEventListener('DOMContentLoaded', () => {
    console.log('📄 DOMContentLoaded event triggered');
    new SlugEditor();
});
