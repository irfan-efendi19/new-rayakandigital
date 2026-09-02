const savedTheme = localStorage.getItem('dark-mode');
const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

if (savedTheme === 'true' || (savedTheme === null && prefersDark)) {
    document.documentElement.classList.add('dark');
}

document.addEventListener('DOMContentLoaded', () => {
    document.querySelector('[data-theme-toggle]')?.addEventListener('click', () => {
        const isDark = document.documentElement.classList.toggle('dark');
        localStorage.setItem('dark-mode', String(isDark));
    });

    document.querySelectorAll('[data-copy]').forEach((button) => {
        button.addEventListener('click', async () => {
            const originalLabel = button.textContent.trim();

            try {
                await navigator.clipboard.writeText(button.dataset.copy);
                button.textContent = 'Tersalin';
            } catch {
                button.textContent = 'Gagal menyalin';
            }

            window.setTimeout(() => {
                button.textContent = originalLabel;
            }, 1800);
        });
    });

    const wishForm = document.querySelector('[data-wish-form]');

    if (wishForm) {
        const message = wishForm.querySelector('[data-wish-message]');
        const counter = wishForm.querySelector('[data-wish-counter]');
        const submit = wishForm.querySelector('[data-submit]');
        const feedback = wishForm.querySelector('[data-feedback]');

        message?.addEventListener('input', () => {
            counter.textContent = String(message.value.length);
        });

        wishForm.addEventListener('submit', async (event) => {
            event.preventDefault();
            submit.disabled = true;
            submit.innerHTML = '<span class="qr-button__spinner" aria-hidden="true"></span><span>Mengirim…</span>';
            feedback.classList.remove('is-visible');

            try {
                const response = await fetch(wishForm.action, {
                    method: 'POST',
                    body: new FormData(wishForm),
                    headers: {
                        Accept: 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                });
                const payload = await response.json().catch(() => ({}));

                if (!response.ok) {
                    const validationMessages = payload.errors
                        ? Object.values(payload.errors).flat().join(' ')
                        : null;

                    throw new Error(validationMessages || payload.message || 'Ucapan belum dapat dikirim.');
                }

                document.querySelector('[data-wish-form-wrap]')?.classList.add('hidden');
                document.querySelector('[data-wish-success]')?.classList.remove('hidden');
            } catch (error) {
                feedback.textContent = error.message || 'Terjadi kendala. Silakan coba lagi.';
                feedback.classList.add('is-visible');
                submit.disabled = false;
                submit.textContent = 'Kirim Ucapan';
            }
        });
    }

    document.querySelector('[data-wish-reset]')?.addEventListener('click', () => {
        document.querySelector('[data-wish-success]')?.classList.add('hidden');
        document.querySelector('[data-wish-form-wrap]')?.classList.remove('hidden');
        wishForm?.reset();

        const counter = wishForm?.querySelector('[data-wish-counter]');
        const submit = wishForm?.querySelector('[data-submit]');
        if (counter) counter.textContent = '0';
        if (submit) {
            submit.disabled = false;
            submit.textContent = 'Kirim Ucapan';
        }
    });

    const photoInput = document.querySelector('[data-photo-input]');

    photoInput?.addEventListener('change', () => {
        const [file] = photoInput.files;
        const prompt = document.querySelector('[data-dropzone-prompt]');
        const preview = document.querySelector('[data-dropzone-preview]');
        const previewImage = document.querySelector('[data-preview-image]');
        const fileName = document.querySelector('[data-file-name]');
        const submit = document.querySelector('[data-gallery-submit]');

        if (!file) return;

        previewImage.src = URL.createObjectURL(file);
        fileName.textContent = file.name;
        prompt.classList.add('hidden');
        preview.classList.remove('hidden');
        submit.disabled = false;
    });

    document.querySelector('[data-gallery-form]')?.addEventListener('submit', () => {
        const submit = document.querySelector('[data-gallery-submit]');
        submit.disabled = true;
        submit.textContent = 'Mengunggah…';
    });

    const rsvpForm = document.querySelector('[data-rsvp-form]');

    if (rsvpForm) {
        const attendanceOptions = rsvpForm.querySelectorAll('[data-rsvp-attendance]');
        const paxField = rsvpForm.querySelector('[data-rsvp-pax-field]');
        const paxValue = rsvpForm.querySelector('[data-pax-value]');
        const paxMinus = rsvpForm.querySelector('[data-pax-minus]');
        const paxPlus = rsvpForm.querySelector('[data-pax-plus]');
        const message = rsvpForm.querySelector('[data-rsvp-message]');
        const counter = rsvpForm.querySelector('[data-rsvp-counter]');
        const feedback = rsvpForm.querySelector('[data-rsvp-feedback]');
        const submit = rsvpForm.querySelector('[data-rsvp-submit]');
        const maxPax = Number(rsvpForm.dataset.maxPax) || 1;

        const updatePax = (value) => {
            const nextValue = Math.min(Math.max(value, 1), maxPax);
            paxValue.value = String(nextValue);
            paxMinus.disabled = nextValue <= 1;
            paxPlus.disabled = nextValue >= maxPax;
        };

        const updateAttendance = () => {
            const selected = rsvpForm.querySelector('[data-rsvp-attendance]:checked');
            const isAttending = selected?.value === 'attending';
            paxField.classList.toggle('hidden', !isAttending);

            if (!isAttending) updatePax(1);
        };

        attendanceOptions.forEach((option) => option.addEventListener('change', updateAttendance));
        paxMinus.addEventListener('click', () => updatePax(Number(paxValue.value) - 1));
        paxPlus.addEventListener('click', () => updatePax(Number(paxValue.value) + 1));
        message.addEventListener('input', () => {
            counter.textContent = String(message.value.length);
        });

        updatePax(1);
        updateAttendance();

        rsvpForm.addEventListener('submit', async (event) => {
            event.preventDefault();
            const attendance = rsvpForm.querySelector('[data-rsvp-attendance]:checked');
            const formData = new FormData(rsvpForm);
            formData.set('pax', attendance?.value === 'attending' ? paxValue.value : '1');

            submit.disabled = true;
            submit.innerHTML = '<span class="qr-button__spinner" aria-hidden="true"></span><span>Mengirim…</span>';
            feedback.classList.remove('is-visible');

            try {
                const response = await fetch(rsvpForm.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        Accept: 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                });
                const payload = await response.json().catch(() => ({}));

                if (!response.ok || !payload.success) {
                    const validationMessages = payload.errors
                        ? Object.values(payload.errors).flat().join(' ')
                        : null;

                    throw new Error(validationMessages || payload.message || 'Konfirmasi belum dapat dikirim.');
                }

                document.querySelector('[data-rsvp-form-wrap]')?.classList.add('hidden');
                document.querySelector('[data-rsvp-success]')?.classList.remove('hidden');
            } catch (error) {
                feedback.textContent = error.message || 'Terjadi kendala. Silakan coba lagi.';
                feedback.classList.add('is-visible');
                submit.disabled = false;
                submit.textContent = 'Kirim Konfirmasi';
            }
        });
    }

    document.querySelector('[data-rsvp-reset]')?.addEventListener('click', () => {
        document.querySelector('[data-rsvp-success]')?.classList.add('hidden');
        document.querySelector('[data-rsvp-form-wrap]')?.classList.remove('hidden');
        rsvpForm?.reset();

        const paxField = rsvpForm?.querySelector('[data-rsvp-pax-field]');
        const paxValue = rsvpForm?.querySelector('[data-pax-value]');
        const paxMinus = rsvpForm?.querySelector('[data-pax-minus]');
        const paxPlus = rsvpForm?.querySelector('[data-pax-plus]');
        const counter = rsvpForm?.querySelector('[data-rsvp-counter]');
        const feedback = rsvpForm?.querySelector('[data-rsvp-feedback]');
        const submit = rsvpForm?.querySelector('[data-rsvp-submit]');
        if (paxField) paxField.classList.add('hidden');
        if (paxValue) paxValue.value = '1';
        if (paxMinus) paxMinus.disabled = true;
        if (paxPlus) paxPlus.disabled = Number(rsvpForm?.dataset.maxPax) <= 1;
        if (counter) counter.textContent = '0';
        if (feedback) feedback.classList.remove('is-visible');
        if (submit) {
            submit.disabled = false;
            submit.textContent = 'Kirim Konfirmasi';
        }
    });

    const qrisDialog = document.querySelector('[data-qris-dialog]');
    document.querySelector('[data-qris-open]')?.addEventListener('click', () => qrisDialog?.showModal());
    document.querySelector('[data-qris-close]')?.addEventListener('click', () => qrisDialog?.close());
    qrisDialog?.addEventListener('click', (event) => {
        if (event.target === qrisDialog) qrisDialog.close();
    });
});
