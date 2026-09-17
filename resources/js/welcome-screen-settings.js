export function registerWelcomeScreenSettings(Alpine) {
    Alpine.data('welcomeScreenSettings', () => ({
        theme: '', title: '', names: '', defaultNames: '', wishes: true,
        presets: [], savedBackground: '', backgroundPreview: '', backgroundName: '',
        removeBackground: false, backgroundError: '', galleryError: '', galleryActionError: '',
        pendingPhotos: [], removedGalleryIds: [], savedGalleryCount: 0, deletingId: null,
        dirty: false, submitting: false,

        init() {
            Object.assign(this, JSON.parse(this.$el.dataset.screenSettings));
        },

        get selectedPreset() {
            return this.presets.find(preset => preset.slug === this.theme);
        },

        get previewBackground() {
            return this.backgroundPreview || (this.removeBackground ? '' : this.savedBackground);
        },

        get galleryCount() {
            return this.savedGalleryCount - this.removedGalleryIds.length + this.pendingPhotos.length;
        },

        imageError(file) {
            if (!['image/jpeg', 'image/png', 'image/webp'].includes(file.type)) {
                return `Format ${file.name} tidak didukung. Gunakan JPG, PNG, atau WebP.`;
            }
            if (file.size > 10 * 1024 * 1024) return `${file.name} melebihi batas 10 MB.`;
            return '';
        },

        selectBackground(event) {
            const file = event.target.files[0];
            if (!file) return;
            this.backgroundError = this.imageError(file);
            if (this.backgroundPreview) URL.revokeObjectURL(this.backgroundPreview);
            this.backgroundPreview = '';
            this.backgroundName = '';
            if (this.backgroundError) {
                event.target.value = '';
                return;
            }
            this.backgroundPreview = URL.createObjectURL(file);
            this.backgroundName = file.name;
            this.removeBackground = false;
            this.dirty = true;
        },

        clearBackground() {
            if (this.backgroundPreview) URL.revokeObjectURL(this.backgroundPreview);
            this.backgroundPreview = '';
            this.backgroundName = '';
            this.backgroundError = '';
            this.$refs.backgroundInput.value = '';
        },

        selectGallery(event) {
            const files = Array.from(event.target.files);
            if (!files.length) return;
            this.galleryError = files.map(file => this.imageError(file)).find(Boolean) || '';
            this.pendingPhotos.forEach(photo => URL.revokeObjectURL(photo.url));
            this.pendingPhotos = [];
            if (this.galleryError) {
                event.target.value = '';
                return;
            }
            this.pendingPhotos = files.map(file => ({ name: file.name, url: URL.createObjectURL(file) }));
            this.dirty = true;
        },

        clearGallery() {
            this.pendingPhotos.forEach(photo => URL.revokeObjectURL(photo.url));
            this.pendingPhotos = [];
            this.$refs.galleryInput.value = '';
            this.galleryError = '';
        },

        async deleteGallery(button) {
            if (this.deletingId !== null) return;
            const id = Number(button.dataset.galleryId);
            const result = await window.Swal.fire({
                title: 'Hapus foto slideshow?',
                text: 'Foto ini akan langsung dihapus dari slideshow. Isian lainnya tetap tersimpan di halaman ini.',
                icon: 'warning', showCancelButton: true,
                confirmButtonText: 'Hapus foto', cancelButtonText: 'Batal', confirmButtonColor: '#dc2626',
            });
            if (!result.isConfirmed) return;
            this.deletingId = id;
            this.galleryActionError = '';
            try {
                const response = await fetch(button.dataset.deleteUrl, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        Accept: 'application/json',
                    },
                });
                if (!response.ok) throw new Error('delete-failed');
                const data = await response.json();
                if (!data.success) throw new Error('delete-failed');
                this.removedGalleryIds.push(id);
            } catch {
                this.galleryActionError = 'Foto belum berhasil dihapus. Periksa koneksi Anda, lalu coba lagi.';
            } finally {
                this.deletingId = null;
            }
        },

        destroy() {
            if (this.backgroundPreview) URL.revokeObjectURL(this.backgroundPreview);
            this.pendingPhotos.forEach(photo => URL.revokeObjectURL(photo.url));
        },
    }));
}
