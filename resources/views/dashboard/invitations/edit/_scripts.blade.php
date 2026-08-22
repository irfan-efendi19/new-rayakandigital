<script>
    document.addEventListener('DOMContentLoaded', function() {
        const container = document.getElementById(
            'events-container');

        // Timezone conversion
        var tzSelect = document.getElementById('timezone');
        if (tzSelect) {
            var tzOffsets = {
                'Asia/Jakarta': 7,
                'Asia/Makassar': 8,
                'Asia/Jayapura': 9
            };
            var oldTz = tzSelect.value;

            tzSelect.addEventListener('change', function () {
                var newTz = this.value;
                var oldOffset = tzOffsets[oldTz] || 7;
                var newOffset = tzOffsets[newTz] || 7;
                var diff = newOffset - oldOffset;

                if (diff === 0) return;

                container.querySelectorAll('.event-card').forEach(function (card) {
                    var dateInput = card.querySelector('input[name$="[event_date]"]');
                    var startInput = card.querySelector('input[name$="[start_time]"]');
                    var endInput = card.querySelector('input[name$="[end_time]"]');

                    function convertTime(input, dateInput) {
                        if (!input || !input.value) return;
                        var parts = input.value.split(':');
                        var hours = parseInt(parts[0]);
                        var minutes = parseInt(parts[1]);
                        hours += diff;
                        if (hours >= 24) {
                            hours -= 24;
                            if (dateInput && dateInput.value) {
                                var d = new Date(dateInput.value + 'T00:00:00');
                                d.setDate(d.getDate() + 1);
                                dateInput.value = d.toISOString().slice(0, 10);
                            }
                        } else if (hours < 0) {
                            hours += 24;
                            if (dateInput && dateInput.value) {
                                var d = new Date(dateInput.value + 'T00:00:00');
                                d.setDate(d.getDate() - 1);
                                dateInput.value = d.toISOString().slice(0, 10);
                            }
                        }
                        input.value = String(hours).padStart(2, '0') + ':' + String(minutes).padStart(2, '0');
                    }

                    convertTime(startInput, dateInput);
                    convertTime(endInput, dateInput);
                });

                oldTz = newTz;
            });
        }
        const template = document.getElementById(
            'event-card-template');
        const addBtn = document.getElementById('add-event-btn');
        let eventIndex = container ? container.children.length :
            0;

        function reindexEvents() {
            const cards = container.querySelectorAll(
                '.event-card');
            cards.forEach(function(card, idx) {
                const inputs = card.querySelectorAll(
                    '[name]');
                inputs.forEach(function(input) {
                    const name = input
                        .getAttribute('name');
                    if (name) {
                        input.setAttribute(
                            'name', name
                            .replace(
                                /events\[\d+\]/,
                                'events[' +
                                idx + ']'));
                    }
                });
                const datalists = card.querySelectorAll(
                    '[id^="event-titles-"]');
                datalists.forEach(function(dl) {
                    dl.id = 'event-titles-' +
                        idx;
                });
                const inputsWithList = card
                    .querySelectorAll(
                        '[list^="event-titles-"]');
                inputsWithList.forEach(function(inp) {
                    inp.setAttribute('list',
                        'event-titles-' +
                        idx);
                });
                const title = card.querySelector(
                    'h4.event-card-title');
                if (title) {
                    title.textContent = 'Acara #' + (
                        idx + 1);
                }
            });
        }

        function addEventCard() {
            const clone = template.content.cloneNode(true);
            const html = clone.querySelector('.event-card')
                .outerHTML.replace(
                    /__INDEX__/g, eventIndex);
            const wrapper = document.createElement('div');
            wrapper.innerHTML = html;
            const card = wrapper.firstElementChild;
            container.appendChild(card);
            eventIndex++;
            bindCardEvents(card);
            reindexEvents();
        }

        function removeEventCard(btn) {
            const card = btn.closest('.event-card');
            if (!card) return;
            Swal.fire({
                title: 'Hapus Acara?',
                text: 'Acara ini akan dihapus dari undangan.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) {
                    card.remove();
                    reindexEvents();
                }
            });
        }

        function moveUp(btn) {
            const card = btn.closest('.event-card');
            const prev = card ? card.previousElementSibling :
                null;
            if (prev) {
                card.parentNode.insertBefore(card, prev);
                reindexEvents();
            }
        }

        function moveDown(btn) {
            const card = btn.closest('.event-card');
            const next = card ? card.nextElementSibling : null;
            if (next) {
                card.parentNode.insertBefore(next, card);
                reindexEvents();
            }
        }

        function bindCardEvents(card) {
            card.querySelector('.remove-event')
                ?.addEventListener('click', function() {
                    removeEventCard(this);
                });
            card.querySelector('.move-up')?.addEventListener(
                'click',
                function() {
                    moveUp(this);
                });
            card.querySelector('.move-down')?.addEventListener(
                'click',
                function() {
                    moveDown(this);
                });
        }

        container.querySelectorAll('.event-card').forEach(
            function(card) {
                bindCardEvents(card);
            });

        addBtn.addEventListener('click', addEventCard);

        const storiesContainer = document.getElementById(
            'stories-container');
        const storyTemplate = document.getElementById(
            'story-card-template');
        const addStoryBtn = document.getElementById(
            'add-story-btn');

        function reindexStories() {
            const cards = storiesContainer.querySelectorAll(
                '.story-card');
            cards.forEach(function(card, idx) {
                const inputs = card.querySelectorAll(
                    '[name]');
                inputs.forEach(function(input) {
                    const name = input
                        .getAttribute('name');
                    if (name) {
                        input.setAttribute(
                            'name', name
                            .replace(
                                /stories\[\d+\]/,
                                'stories[' +
                                idx + ']'));
                    }
                });
                const label = card.querySelector(
                    'span.text-xs.font-semibold');
                if (label) {
                    label.textContent = 'Momen #' + (
                        idx + 1);
                }
            });
        }

        function addStoryCard() {
            const clone = storyTemplate.content.cloneNode(true);
            const html = clone.querySelector('.story-card')
                .outerHTML.replace(
                    /__INDEX__/g, storiesContainer
                    .children.length);
            const wrapper = document.createElement('div');
            wrapper.innerHTML = html;
            const card = wrapper.firstElementChild;
            storiesContainer.appendChild(card);
            reindexStories();
        }

        function storyMoveUp(btn) {
            const card = btn.closest('.story-card');
            const prev = card ? card.previousElementSibling : null;
            if (prev) {
                card.parentNode.insertBefore(card, prev);
                reindexStories();
            }
        }

        function storyMoveDown(btn) {
            const card = btn.closest('.story-card');
            const next = card ? card.nextElementSibling : null;
            if (next) {
                card.parentNode.insertBefore(next, card);
                reindexStories();
            }
        }

        storiesContainer.addEventListener('click', function(e) {
            if (e.target.closest('.remove-story')) {
                e.target.closest('.story-card')
                    .remove();
                reindexStories();
            }
            if (e.target.closest('.story-move-up')) {
                storyMoveUp(e.target.closest('.story-move-up'));
            }
            if (e.target.closest('.story-move-down')) {
                storyMoveDown(e.target.closest('.story-move-down'));
            }
        });

        if (addStoryBtn) {
            addStoryBtn.addEventListener('click', addStoryCard);
        }
    });
    </script>

    <script>
    @php
        $categoryIdPlaceholder = 'CATEGORY_ID';
        $guestCategoryUpdateUrl = str_replace(
            $categoryIdPlaceholder,
            '',
            route('dashboard.invitations.guest-categories.update', [$invitation, $categoryIdPlaceholder])
        );
        $guestCategoryDestroyUrl = str_replace(
            $categoryIdPlaceholder,
            '',
            route('dashboard.invitations.guest-categories.destroy', [$invitation, $categoryIdPlaceholder])
        );
    @endphp
    // Guest Categories Alpine Component (defined before DOMContentLoaded so Alpine can find it)
    window.guestCategories = function() {
        return {
            categories: @json($invitation->guestCategories()->get()),
            editing: false,
            form: {
                id: null,
                name: '',
                color_code: '#6b7280'
            },
            init() {},
            saveCategory() {
                if (!this.form.name.trim()) return;
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
                const url = this.editing ?
                    '{{ $guestCategoryUpdateUrl }}' + this.form.id :
                    '{{ route("dashboard.invitations.guest-categories.store", $invitation) }}';
                const method = this.editing ? 'PUT' : 'POST';

                fetch(url, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({
                            _method: method,
                            name: this.form.name,
                            color_code: this.form.color_code
                        }),
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (this.editing) {
                            const idx = this.categories.findIndex(c => c.id === data.id);
                            if (idx !== -1) this.categories.splice(idx, 1, data);
                        } else {
                            this.categories.push(data);
                        }
                        this.cancelEdit();
                    })
                    .catch(() => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: 'Gagal menyimpan kategori.'
                        });
                    });
            },
            editCategory(category) {
                this.editing = true;
                this.form = {
                    id: category.id,
                    name: category.name,
                    color_code: category.color_code
                };
            },
            cancelEdit() {
                this.editing = false;
                this.form = {
                    id: null,
                    name: '',
                    color_code: '#6b7280'
                };
            },
            deleteCategory(category) {
                Swal.fire({
                    title: 'Hapus Kategori?',
                    text: 'Tamu dengan kategori ini tidak akan terhapus, hanya kategorinya yang hilang.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal',
                }).then((result) => {
                    if (!result.isConfirmed) return;
                    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
                    fetch('{{ $guestCategoryDestroyUrl }}' + category.id, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'Accept': 'application/json',
                                    'X-CSRF-TOKEN': csrfToken
                                },
                                body: JSON.stringify({
                                    _method: 'DELETE'
                                }),
                            })
                        .then(() => {
                            this.categories = this.categories.filter(c => c.id !== category.id);
                        })
                        .catch(() => {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: 'Gagal menghapus kategori.'
                            });
                        });
                });
            },
        };
    };
    </script>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

        // Gallery upload (auto-upload saat foto dipilih)
        const galleryFileInput = document.getElementById('gallery-file-input');
        const galleryDropzone = document.getElementById('gallery-dropzone');
        const uploadStatus = document.getElementById('upload-status');
        const dropzoneError = document.getElementById('dropzone-error');

        if (galleryFileInput) {
            let uploading = false;

            function saveActiveSectionBeforeReload() {
                const sections = document.querySelectorAll('[id^="sec-"]');
                for (const s of sections) {
                    if (window.getComputedStyle(s).display !== 'none') {
                        sessionStorage.setItem('invitation-edit-section', s.id);
                        break;
                    }
                }
            }

            function uploadGalleryFiles(files) {
                if (!files.length || uploading) return;

                uploading = true;
                if (galleryDropzone) {
                    galleryDropzone.classList.add('pointer-events-none', 'opacity-70');
                }
                if (uploadStatus) uploadStatus.classList.remove('hidden');
                if (dropzoneError) dropzoneError.classList.add('hidden');

                const formData = new FormData();
                for (const file of files) {
                    formData.append('photos[]', file);
                }
                if (csrfToken) formData.append('_token', csrfToken);

                fetch('{{ route("dashboard.invitations.gallery.update", $invitation) }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'Accept': 'application/json'
                    },
                }).then(response => {
                    if (!response.ok) throw new Error('Upload failed');
                    saveActiveSectionBeforeReload();
                    window.location.reload();
                }).catch(() => {
                    uploading = false;
                    if (galleryDropzone) {
                        galleryDropzone.classList.remove('pointer-events-none', 'opacity-70');
                    }
                    if (uploadStatus) uploadStatus.classList.add('hidden');
                    if (dropzoneError) {
                        dropzoneError.textContent = 'Gagal mengunggah foto. Silakan coba lagi.';
                        dropzoneError.classList.remove('hidden');
                    }
                });
            }

            galleryFileInput.addEventListener('change', function() {
                uploadGalleryFiles(this.files);
                this.value = '';
            });

            // Click on dropzone to open file picker
            if (galleryDropzone) {
                galleryDropzone.addEventListener('click', function(e) {
                    if (e.target === galleryDropzone || e.target.closest('#dropzone-empty')) {
                        galleryFileInput.click();
                    }
                });
                galleryDropzone.addEventListener('dragover', function(e) {
                    e.preventDefault();
                    this.classList.add('border-primary-500', 'bg-primary-100/50');
                });
                galleryDropzone.addEventListener('dragleave', function() {
                    this.classList.remove('border-primary-500', 'bg-primary-100/50');
                });
                galleryDropzone.addEventListener('drop', function(e) {
                    e.preventDefault();
                    this.classList.remove('border-primary-500', 'bg-primary-100/50');
                    uploadGalleryFiles(Array.from(e.dataTransfer.files));
                });
            }
        }

        // Gallery photo delete
        document.querySelectorAll('.delete-photo-btn').forEach(function(btn) {
            btn.addEventListener('click', function() {
                const index = this.dataset.index;
                Swal.fire({
                    title: 'Konfirmasi',
                    text: 'Hapus foto ini?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal',
                }).then((result) => {
                    if (!result.isConfirmed) return;

                    const formData = new FormData();
                    formData.append('_token', csrfToken);
                    formData.append('_method', 'DELETE');
                    formData.append('photo_index', index);

                    fetch('{{ route("dashboard.invitations.gallery.destroy", $invitation) }}', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'Accept': 'application/json'
                        },
                    }).then(() => {
                        saveActiveSectionBeforeReload();
                        window.location.reload();
                    });
                });
            });
        });

        // RSVP Pax Limit toggle
        const rsvpPaxToggle = document.getElementById('is_rsvp_pax_limited');
        const rsvpPaxSettings = document.getElementById('rsvp-pax-settings');
        if (rsvpPaxToggle && rsvpPaxSettings) {
            rsvpPaxToggle.addEventListener('change', function() {
                rsvpPaxSettings.classList.toggle('hidden', !this.checked);
            });
        }

        // Quote template picker
        document.querySelectorAll('.quote-template-btn').forEach(function(btn) {
            btn.addEventListener('click', function() {
                document.getElementById('quote_content').value = this.dataset.quoteContent;
                document.getElementById('quote_source').value = this.dataset.quoteSource;

                document.querySelectorAll('.quote-template-btn').forEach(function(b) {
                    b.classList.remove('bg-primary-50', 'dark:bg-primary-900/30',
                        'border-primary-300', 'dark:border-primary-600',
                        'text-primary-700', 'dark:text-primary-300');
                    b.classList.add('border-neutral-200', 'dark:border-neutral-600',
                        'text-neutral-600', 'dark:text-neutral-400');
                });
                this.classList.remove('border-neutral-200', 'dark:border-neutral-600',
                    'text-neutral-600', 'dark:text-neutral-400');
                this.classList.add('bg-primary-50', 'dark:bg-primary-900/30',
                    'border-primary-300', 'dark:border-primary-600',
                    'text-primary-700', 'dark:text-primary-300');
            });
        });

        // Activate / Deactivate toggle
        const activateBtn = document.getElementById('activate-btn');
        const deactivateBtn = document.getElementById('deactivate-btn');
        const activeInput = document.querySelector('input[name="is_active"]');

        function setActiveState(active) {
            activeInput.value = active ? '1' : '0';
            activateBtn.className = `inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold transition-all ${active ? 'bg-emerald-100 dark:bg-emerald-900/50 text-emerald-700 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800' : 'bg-white dark:bg-secondary-800 border border-neutral-300 dark:border-neutral-600 text-neutral-600 dark:text-neutral-400 hover:border-emerald-300 hover:text-emerald-600'}`;
            deactivateBtn.className = `inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold transition-all ${!active ? 'bg-red-100 dark:bg-red-900/50 text-red-700 dark:text-red-300 border border-red-200 dark:border-red-800' : 'bg-white dark:bg-secondary-800 border border-neutral-300 dark:border-neutral-600 text-neutral-600 dark:text-neutral-400 hover:border-red-300 hover:text-red-600'}`;
            const dot1 = activateBtn.querySelector('span');
            const dot2 = deactivateBtn.querySelector('span');
            if (dot1) dot1.className = `w-2 h-2 rounded-full ${active ? 'bg-emerald-500' : 'bg-neutral-300 dark:bg-neutral-500'}`;
            if (dot2) dot2.className = `w-2 h-2 rounded-full ${!active ? 'bg-red-500' : 'bg-neutral-300 dark:bg-neutral-500'}`;
        }

        if (activateBtn && deactivateBtn) {
            activateBtn.addEventListener('click', function() { setActiveState(true); });
            deactivateBtn.addEventListener('click', function() { setActiveState(false); });
        }

        // Save confirmation with smart section validation
        const saveBtn = document.getElementById('save-invitation-btn');
        if (saveBtn) {
            saveBtn.addEventListener('click', function(e) {
                const form = document.getElementById('invitation-form');
                if (!form.checkValidity()) {
                    // Temukan input pertama yang tidak valid
                    const invalidEl = form.querySelector(':invalid');
                    if (invalidEl) {
                        const section = invalidEl.closest('[id^=sec-]');
                        if (section) {
                            // Pindahkan section aktif via event global
                            window.dispatchEvent(new CustomEvent('set-active-section', { detail: section.id }));
                        }
                        // Tampilkan tooltip validasi bawaan browser
                        setTimeout(() => {
                            form.reportValidity();
                        }, 100);
                    } else {
                        form.reportValidity();
                    }
                    return;
                }

                Swal.fire({
                    title: 'Simpan Perubahan?',
                    text: 'Pastikan semua data sudah diisi dengan benar.',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#6366f1',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Ya, simpan!',
                    cancelButtonText: 'Batal',
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        }
    });
    </script>
