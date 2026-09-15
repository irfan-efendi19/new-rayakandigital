document.addEventListener('click', async (event) => {
    const button = event.target.closest('[data-affiliate-copy]');
    if (!button) return;

    const input = document.getElementById(button.dataset.affiliateCopy);
    const status = document.querySelector('[data-affiliate-copy-status]');
    if (!input) return;

    try {
        if (!navigator.clipboard?.writeText) throw new Error('Clipboard unavailable');
        await navigator.clipboard.writeText(input.value);
        if (status) status.textContent = 'Berhasil disalin.';
    } catch {
        input.focus();
        input.select();
        if (status) status.textContent = 'Teks sudah dipilih. Gunakan menu Salin atau Ctrl+C.';
    }
});

const slugChecks = new WeakMap();
const slugPattern = /^[a-z0-9]+(?:-[a-z0-9]+)*$/;

const showSlugState = (status, state, message = null) => {
    status.querySelectorAll('[data-affiliate-slug-state]').forEach((element) => {
        element.classList.toggle('hidden', element.dataset.affiliateSlugState !== state);
    });

    const activeState = status.querySelector(`[data-affiliate-slug-state="${state}"]`);
    const messageElement = activeState?.querySelector('[data-affiliate-slug-message]');

    if (messageElement && message) {
        messageElement.textContent = message;
    }
};

const checkSlugAvailability = async (input, status) => {
    slugChecks.get(input)?.abort();

    input.value = input.value.toLowerCase();
    const slug = input.value.trim();

    if (slug === '') {
        input.setCustomValidity('');
        input.removeAttribute('aria-invalid');
        showSlugState(status, 'default');
        return;
    }

    if (slug.length < 3 || !slugPattern.test(slug)) {
        input.setCustomValidity('Gunakan minimal 3 karakter berupa huruf kecil, angka, atau tanda hubung.');
        input.setAttribute('aria-invalid', 'true');
        showSlugState(status, 'invalid');
        return;
    }

    const controller = new AbortController();
    slugChecks.set(input, controller);
    input.setCustomValidity('Sedang memeriksa ketersediaan alamat link.');
    input.removeAttribute('aria-invalid');
    showSlugState(status, 'checking');

    try {
        const url = new URL(input.dataset.affiliateSlugAvailabilityUrl, window.location.origin);
        url.searchParams.set('slug', slug);

        if (input.dataset.affiliateSlugIgnore) {
            url.searchParams.set('ignore_link_id', input.dataset.affiliateSlugIgnore);
        }

        const response = await fetch(url, {
            headers: { Accept: 'application/json' },
            signal: controller.signal,
        });
        const result = await response.json();

        if (!response.ok) {
            throw new Error(result.message || 'Validasi alamat link gagal.');
        }

        input.setCustomValidity(result.available ? '' : result.message);
        input.toggleAttribute('aria-invalid', !result.available);
        showSlugState(status, result.available ? 'available' : 'unavailable', result.message);
    } catch (error) {
        if (error.name === 'AbortError') {
            return;
        }

        input.setCustomValidity('');
        input.removeAttribute('aria-invalid');
        showSlugState(status, 'error');
    }
};

document.querySelectorAll('[data-affiliate-slug-check]').forEach((input) => {
    const status = document.getElementById(input.getAttribute('aria-describedby'));

    if (!status) {
        return;
    }

    let timeout;
    input.addEventListener('input', () => {
        window.clearTimeout(timeout);
        timeout = window.setTimeout(() => checkSlugAvailability(input, status), 350);
    });
});
