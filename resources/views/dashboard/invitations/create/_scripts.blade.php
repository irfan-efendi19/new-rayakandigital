<script>
    document.addEventListener('DOMContentLoaded', function () {
        const container = document.getElementById('events-container');

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
        const template = document.getElementById('event-card-template');
        const addBtn = document.getElementById('add-event-btn');
        let eventIndex = container ? container.children.length : 0;

        function reindexEvents() {
            const cards = container.querySelectorAll('.event-card');
            cards.forEach(function (card, idx) {
                const inputs = card.querySelectorAll('[name]');
                inputs.forEach(function (input) {
                    const name = input.getAttribute('name');
                    if (name) {
                        input.setAttribute('name', name.replace(/events\[\d+\]/, 'events[' + idx + ']'));
                    }
                });
                const datalists = card.querySelectorAll('[id^="event-titles-"]');
                datalists.forEach(function (dl) {
                    dl.id = 'event-titles-' + idx;
                });
                const inputsWithList = card.querySelectorAll('[list^="event-titles-"]');
                inputsWithList.forEach(function (inp) {
                    inp.setAttribute('list', 'event-titles-' + idx);
                });
                const title = card.querySelector('h4.event-card-title');
                if (title) {
                    title.textContent = 'Acara #' + (idx + 1);
                }
            });
        }

        function addEventCard() {
            const clone = template.content.cloneNode(true);
            const html = clone.querySelector('.event-card').outerHTML.replace(/__INDEX__/g, eventIndex);
            const wrapper = document.createElement('div');
            wrapper.innerHTML = html;
            const card = wrapper.firstElementChild;
            container.appendChild(card);
            eventIndex++;
            bindCardEvents(card);
            reindexEvents();
            if (window.initFlatpickr) window.initFlatpickr(card);
            card.scrollIntoView({ behavior: 'smooth', block: 'center' });
            const firstField = card.querySelector('input');
            if (firstField) firstField.focus({ preventScroll: true });
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
                cancelButtonColor: '#3085d6',
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
            const prev = card ? card.previousElementSibling : null;
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
            card.querySelector('.remove-event')?.addEventListener('click', function () {
                removeEventCard(this);
            });
            card.querySelector('.move-up')?.addEventListener('click', function () {
                moveUp(this);
            });
            card.querySelector('.move-down')?.addEventListener('click', function () {
                moveDown(this);
            });
        }

        container.querySelectorAll('.event-card').forEach(function (card) {
            bindCardEvents(card);
        });

        if (addBtn) {
            addBtn.addEventListener('click', addEventCard);
        }

        function getFieldLabel(field) {
            if (field.id) {
                const label = document.querySelector('label[for="' + field.id + '"]');
                if (label) return label.textContent.trim();
            }
            const parent = field.closest('[class*="col-span"]') || field.parentElement;
            const label = parent?.querySelector('label');
            if (label) return label.textContent.trim();
            return field.getAttribute('name') || 'Field';
        }

        function markInvalid(field) {
            if (!field) return;
            field.classList.add('field-invalid');
            ['input', 'change'].forEach(function (evt) {
                field.addEventListener(evt, function clear() {
                    field.classList.remove('field-invalid');
                    field.removeEventListener('input', clear);
                    field.removeEventListener('change', clear);
                });
            });
        }

        function validateForm() {
            form.querySelectorAll('.field-invalid').forEach(function (f) { f.classList.remove('field-invalid'); });

            const invalidFields = [];
            const checkedNames = new Set();

            form.querySelectorAll('input[required], select[required], textarea[required]').forEach(function (field) {
                if (field.type === 'hidden') return;
                if (field.disabled) return;
                if (field.closest('.event-card') && !field.closest('.event-card').offsetParent) return;

                const name = field.getAttribute('name') || '';
                if (checkedNames.has(name)) return;
                checkedNames.add(name);

                const value = field.value.trim();
                if (!value) {
                    invalidFields.push(field);
                    markInvalid(field);
                }
            });

            const themeInput = form.querySelector('input[name="theme"]');
            if (themeInput && !themeInput.value.trim()) {
                invalidFields.push(themeInput);
            }

            return invalidFields;
        }

        const submitBtn = document.getElementById('submit-btn');
        const form = submitBtn?.closest('form');

        function resetSubmitButton() {
            if (!submitBtn) return;
            submitBtn.disabled = false;
            submitBtn.classList.remove('opacity-70', 'cursor-not-allowed', 'pointer-events-none');
            submitBtn.innerHTML = 'Simpan & Lanjutkan <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" /></svg>';
        }

        function requestSubmitForm() {
            let submitted = false;
            const onFormSubmit = function (e) {
                submitted = true;
                form.removeEventListener('submit', onFormSubmit);
                if (e.defaultPrevented) {
                    resetSubmitButton();
                }
            };
            form.addEventListener('submit', onFormSubmit);
            form.requestSubmit();
            if (!submitted) {
                resetSubmitButton();
            }
        }

        if (submitBtn && form) {
            submitBtn.addEventListener('click', function (e) {
                e.preventDefault();
                const invalidFields = validateForm();
                if (invalidFields.length > 0) {
                    const list = invalidFields.map(function (f) {
                        return '<li>' + (f.getAttribute('name') === 'theme' ? 'Pilih Tema Undangan' : getFieldLabel(f)) + '</li>';
                    }).join('');
                    const firstVisible = invalidFields.find(function (f) {
                        return !(f.closest('.event-card') && !f.closest('.event-card').offsetParent);
                    }) || invalidFields[0];
                    if (firstVisible && firstVisible.type !== 'hidden') {
                        firstVisible.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }
                    Swal.fire({
                        title: '<span class="text-lg">Form Belum Lengkap!</span>',
                        html: '<div class="text-left">' +
                            '<p class="text-sm text-neutral-600 dark:text-neutral-400 mb-3">Harap lengkapi bagian berikut sebelum menyimpan:</p>' +
                            '<ul class="list-none space-y-1.5 text-sm text-red-600 dark:text-red-400 font-medium">' + list + '</ul>' +
                            '</div>',
                        icon: 'warning',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Oke, lengkapi',
                        allowOutsideClick: false,
                    });
                    return;
                }

                const slugVal = slugInput?.value.trim();
                if (slugVal && slugAvailable === false) {
                    Swal.fire({
                        title: 'Tautan Kustom Tidak Tersedia',
                        html: '<p class="text-sm text-neutral-600 dark:text-neutral-400">Tautan <strong class="font-mono text-red-500 dark:text-red-400">' + slugVal + '</strong> sudah digunakan oleh undangan lain. Silakan ganti dengan tautan kustom lain.</p>',
                        icon: 'warning',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Oke',
                    });
                    return;
                }

                Swal.fire({
                    title: 'Buat Undangan?',
                    text: 'Pastikan semua data sudah benar. Undangan akan dibuat dalam mode trial.',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Ya, buat!',
                    cancelButtonText: 'Cek Lagi',
                }).then((result) => {
                    if (result.isConfirmed) {
                        submitBtn.disabled = true;
                        submitBtn.classList.add('opacity-70', 'cursor-not-allowed', 'pointer-events-none');
                        submitBtn.innerHTML = '<svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v3m6.366-.366l-2.12 2.12M21 12h-3m.366 6.366l-2.12-2.12M12 21v-3m-6.366.366l2.12-2.12M3 12h3m-.366-6.366l2.12 2.12"/></svg> Menyimpan Undangan...';
                        requestSubmitForm();
                    }
                });
            });
        }

        const titleInput = document.getElementById('title');
        const brideNameInput = document.getElementById('bride_name');
        const groomNameInput = document.getElementById('groom_name');
        function autoGenerateTitle() {
            const bride = brideNameInput?.value.trim();
            const groom = groomNameInput?.value.trim();
            if (bride && groom) {
                titleInput.value = 'Pernikahan ' + groom + ' & ' + bride;
            } else if (bride) {
                titleInput.value = 'Pernikahan ' + bride;
            } else if (groom) {
                titleInput.value = 'Pernikahan ' + groom;
            } else {
                titleInput.value = '';
            }
        }

        // ---- Live slug check & auto-suggestion ----
        const slugInput = document.getElementById('slug-input');
        const slugIconEl = document.getElementById('slug-icon');
        const slugTextEl = document.getElementById('slug-text');
        const slugPreviewText = document.getElementById('slug-preview-text');
        const slugPreviewBox = document.getElementById('slug-preview-box');
        let slugTouched = {{ old('slug') ? 'true' : 'false' }};
        let slugCheckTimer = null;
        let slugAvailable = null;
        const slugCheckUrl = @json(route('dashboard.invitations.check-slug'));

        const SLUG_ICONS = {
            neutral: '🔗',
            loading: '<svg class="w-3.5 h-3.5 animate-spin" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 3v3m6.366-.366l-2.12 2.12M21 12h-3m.366 6.366l-2.12-2.12M12 21v-3m-6.366.366l2.12-2.12M3 12h3m-.366-6.366l2.12 2.12"/></svg>',
            success: '<svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>',
            error: '<svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>',
        };

        function setSlugStatus(kind, text) {
            const indicator = document.getElementById('slug-indicator');
            if (!indicator) return;
            slugIconEl.innerHTML = SLUG_ICONS[kind] || SLUG_ICONS.neutral;
            slugTextEl.textContent = text;
            indicator.classList.remove(
                'text-neutral-400', 'dark:text-neutral-500',
                'text-green-600', 'dark:text-green-400',
                'text-red-500', 'dark:text-red-400',
                'text-amber-500', 'dark:text-amber-400'
            );
            const colorMap = {
                neutral: ['text-neutral-400', 'dark:text-neutral-500'],
                success: ['text-green-600', 'dark:text-green-400'],
                error: ['text-red-500', 'dark:text-red-400'],
                loading: ['text-amber-500', 'dark:text-amber-400'],
            };
            indicator.classList.add(...(colorMap[kind] || colorMap.neutral));
        }

        function slugify(value) {
            return String(value || '')
                .toLowerCase()
                .replace(/['"]/g, '')
                .replace(/[^a-z0-9]+/g, '-')
                .replace(/^-+|-+$/g, '')
                .replace(/-{2,}/g, '-');
        }

        function firstNameOf(name) {
            const parts = String(name || '').trim().split(/\s+/);
            return parts[0] || '';
        }

        function updateSlugPreview() {
            const value = slugInput.value.trim();
            if (value) {
                slugPreviewText.textContent = value;
                slugPreviewBox.style.display = 'block';
            } else {
                slugPreviewBox.style.display = 'none';
            }
        }

        function suggestSlug() {
            if (slugTouched) return;
            const groom = slugify(firstNameOf(groomNameInput?.value));
            const bride = slugify(firstNameOf(brideNameInput?.value));
            const parts = [groom, bride].filter(Boolean);
            if (parts.length >= 2 && !slugInput.value.trim()) {
                slugInput.value = parts.join('-');
                updateSlugPreview();
                checkSlugAvailability();
            }
        }

        function checkSlugAvailability() {
            const value = slugInput.value.trim();
            if (!value) {
                slugAvailable = null;
                setSlugStatus('neutral', 'Masukkan tautan kustom');
                return;
            }
            if (!/^[a-z0-9\-]+$/.test(value)) {
                slugAvailable = false;
                setSlugStatus('error', 'Hanya huruf kecil (a-z), angka, dan tanda hubung (-)');
                return;
            }
            slugAvailable = null;
            setSlugStatus('loading', 'Memeriksa ketersediaan...');
            fetch(slugCheckUrl + '?slug=' + encodeURIComponent(value), {
                headers: { 'Accept': 'application/json' },
                credentials: 'same-origin',
            })
                .then(function (res) { return res.json(); })
                .then(function (data) {
                    if (data.available) {
                        slugAvailable = true;
                        setSlugStatus('success', 'Tautan tersedia!');
                    } else {
                        slugAvailable = false;
                        setSlugStatus('error', data.message || 'Tautan sudah digunakan oleh undangan lain.');
                    }
                })
                .catch(function () {
                    slugAvailable = null;
                    setSlugStatus('neutral', 'Masukkan tautan kustom');
                });
        }

        function scheduleSlugCheck() {
            clearTimeout(slugCheckTimer);
            slugCheckTimer = setTimeout(checkSlugAvailability, 350);
        }

        if (slugInput) {
            slugInput.addEventListener('input', function () {
                slugTouched = true;
                const sanitized = slugInput.value.toLowerCase().replace(/\s+/g, '-').replace(/[^a-z0-9-]/g, '');
                if (sanitized !== slugInput.value) {
                    slugInput.value = sanitized;
                }
                updateSlugPreview();
                scheduleSlugCheck();
            });
            slugInput.addEventListener('blur', checkSlugAvailability);
            updateSlugPreview();
        }

        brideNameInput?.addEventListener('input', function () { autoGenerateTitle(); suggestSlug(); });
        groomNameInput?.addEventListener('input', function () { autoGenerateTitle(); suggestSlug(); });
        autoGenerateTitle();

        // Mark server-side validation errors (without auto-scrolling)
        form.querySelectorAll('input, select, textarea').forEach(function (field) {
            const parent = field.parentElement;
            if (parent && parent.querySelector('span.text-red-500')) {
                markInvalid(field);
            }
        });
    });
</script>
