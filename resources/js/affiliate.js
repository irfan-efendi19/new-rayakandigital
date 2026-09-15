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
