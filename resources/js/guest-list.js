export function registerGuestList(Alpine) {
    Alpine.data('waTemplateEditor', () => ({
        expanded: false,
        templateText: window.__WA_TEMPLATE_DATA?.templateText || '',
        templateEnabled: window.__WA_TEMPLATE_DATA?.templateEnabled || false,
        openPresetModal: false,
        presets: window.__WA_TEMPLATE_DATA?.presets || [],
        insertVariable(variable) {
            const field = this.$refs.messageField;
            const start = field.selectionStart;
            const end = field.selectionEnd;

            this.templateText = this.templateText.substring(0, start)
                + variable
                + this.templateText.substring(end);

            this.$nextTick(() => {
                field.focus();
                field.setSelectionRange(start + variable.length, start + variable.length);
            });
        },
        selectPreset(presetText) {
            const applyPreset = () => {
                this.templateText = presetText;
                this.templateEnabled = true;
                this.openPresetModal = false;
                this.expanded = true;
            };

            if (this.templateText.trim().length === 0 || typeof window.Swal === 'undefined') {
                applyPreset();
                return;
            }

            window.Swal.fire({
                title: 'Ganti Template?',
                text: 'Memilih template ini akan menghapus teks draf yang sudah Anda tulis. Apakah Anda yakin?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, ganti!',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) {
                    applyPreset();
                }
            });
        },
    }));
}

function selectedGuests() {
    return document.querySelectorAll('.guest-checkbox:checked');
}

function submitBulkForm(formId, checkboxes) {
    const form = document.getElementById(formId);

    form.querySelectorAll('.dynamic-guest-id').forEach((input) => input.remove());
    checkboxes.forEach((checkbox) => {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'guest_ids[]';
        input.value = checkbox.value;
        input.className = 'dynamic-guest-id';
        form.appendChild(input);
    });

    form.submit();
}

function updateBulkControls() {
    const checked = selectedGuests().length;
    const total = document.querySelectorAll('.guest-checkbox').length;
    const sendButton = document.getElementById('bulkSendBtn');
    const deleteButton = document.getElementById('bulkDeleteBtn');
    const selectedCount = document.getElementById('selectedCount');
    const selectAllControls = [
        document.getElementById('selectAll'),
        document.getElementById('selectAllMobile'),
    ];

    sendButton.disabled = checked === 0;
    deleteButton.disabled = checked === 0;
    selectedCount.textContent = `${checked} dipilih`;
    selectedCount.classList.toggle('hidden', checked === 0);
    selectedCount.classList.toggle('inline-flex', checked > 0);
    document.getElementById('bulkSendLabel').textContent = checked > 0 ? `Kirim WA (${checked})` : 'Kirim WA';
    document.getElementById('bulkDeleteLabel').textContent = checked > 0 ? `Hapus (${checked})` : 'Hapus';

    selectAllControls.forEach((control) => {
        control.checked = total > 0 && checked === total;
        control.indeterminate = checked > 0 && checked < total;
    });

    document.querySelectorAll('.guest-row').forEach((row) => {
        const selected = row.querySelector('.guest-checkbox')?.checked ?? false;
        row.classList.toggle('bg-primary-50/60', selected);
        row.classList.toggle('dark:bg-primary-900/10', selected);
    });
}

async function copyToClipboard(id) {
    const field = document.getElementById(id);

    try {
        await navigator.clipboard.writeText(field.value);
    } catch (error) {
        field.select();
        field.setSelectionRange(0, field.value.length);
        document.execCommand('copy');
    }

    if (typeof window.Swal !== 'undefined') {
        window.Swal.fire({
            icon: 'success',
            title: 'Tersalin!',
            text: 'Link berhasil disalin!',
            timer: 1500,
            showConfirmButton: false,
        });
    }
}

function bulkSend() {
    const checked = selectedGuests();
    if (checked.length === 0) return;

    const withoutPhone = Array.from(checked).filter((checkbox) => checkbox.dataset.hasPhone === '0');
    if (withoutPhone.length > 0) {
        window.Swal?.fire({
            title: 'Tidak Dapat Dikirim',
            text: `${withoutPhone.length} tamu terpilih tidak memiliki nomor WhatsApp. Hanya tamu dengan nomor HP yang bisa dikirim undangan.`,
            icon: 'error',
            confirmButtonColor: '#FF7A00',
            confirmButtonText: 'Mengerti',
        });
        return;
    }

    if (typeof window.Swal === 'undefined') {
        submitBulkForm('bulkSendForm', checked);
        return;
    }

    window.Swal.fire({
        title: 'Konfirmasi',
        text: `Kirim WhatsApp ke ${checked.length} tamu yang dipilih? Pesan akan dikirim secara bertahap.`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#FF7A00',
        cancelButtonColor: '#EF4444',
        confirmButtonText: 'Ya, kirim!',
        cancelButtonText: 'Batal',
    }).then((result) => {
        if (result.isConfirmed) submitBulkForm('bulkSendForm', checked);
    });
}

function bulkDelete() {
    const checked = selectedGuests();
    if (checked.length === 0) return;

    if (typeof window.Swal === 'undefined') {
        if (window.confirm(`Yakin ingin menghapus ${checked.length} tamu yang dipilih?`)) {
            submitBulkForm('bulkDeleteForm', checked);
        }
        return;
    }

    window.Swal.fire({
        title: 'Hapus Tamu?',
        text: `Yakin ingin menghapus ${checked.length} tamu yang dipilih?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#EF4444',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal',
    }).then((result) => {
        if (result.isConfirmed) submitBulkForm('bulkDeleteForm', checked);
    });
}

function initializeGuestList() {
    const selectAllControls = [
        document.getElementById('selectAll'),
        document.getElementById('selectAllMobile'),
    ];

    if (selectAllControls.some((control) => control === null)) return;

    selectAllControls.forEach((control) => {
        control.addEventListener('change', () => {
            document.querySelectorAll('.guest-checkbox').forEach((checkbox) => {
                checkbox.checked = control.checked;
            });
            updateBulkControls();
        });
    });

    document.querySelectorAll('.guest-checkbox').forEach((checkbox) => {
        checkbox.addEventListener('change', updateBulkControls);
    });

    document.querySelectorAll('.guest-row').forEach((row) => {
        row.addEventListener('click', (event) => {
            if (event.target.closest('a, button, form, input, label')) return;

            const checkbox = row.querySelector('.guest-checkbox');
            checkbox.checked = !checkbox.checked;
            updateBulkControls();
        });
    });
}

window.copyToClipboard = copyToClipboard;
window.bulkSend = bulkSend;
window.bulkDelete = bulkDelete;

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initializeGuestList);
} else {
    initializeGuestList();
}
