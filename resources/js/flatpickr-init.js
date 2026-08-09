import flatpickr from 'flatpickr';
import 'flatpickr/dist/flatpickr.min.css';
import { Indonesian } from 'flatpickr/dist/l10n/id.js';

flatpickr.localize(Indonesian);
window.flatpickr = flatpickr;

export function initFlatpickr(container = document) {
    const dateInputs = container.querySelectorAll('input[type="date"], .js-datepicker');
    dateInputs.forEach(input => {
        if (input._flatpickr) return;

        const initialValue = input.value;
        input.type = 'text';
        input.setAttribute('autocomplete', 'off');
        if (!input.placeholder) {
            input.placeholder = 'Pilih tanggal';
        }

        flatpickr(input, {
            locale: Indonesian,
            dateFormat: 'Y-m-d',
            altInput: true,
            altFormat: 'j F Y',
            altInputClass: input.className + ' js-flatpickr-alt',
            defaultDate: initialValue || null,
            allowInput: true,
            disableMobile: true,
        });
    });

    const timeInputs = container.querySelectorAll('input[type="time"], .js-timepicker');
    timeInputs.forEach(input => {
        if (input._flatpickr) return;

        const initialValue = input.value;
        input.type = 'text';
        input.setAttribute('autocomplete', 'off');
        if (!input.placeholder) {
            input.placeholder = '00:00';
        }

        flatpickr(input, {
            enableTime: true,
            noCalendar: true,
            dateFormat: 'H:i',
            time_24hr: true,
            defaultDate: initialValue || null,
            altInput: true,
            altFormat: 'H:i',
            altInputClass: input.className + ' js-flatpickr-alt',
            allowInput: true,
            disableMobile: true,
        });
    });
}

document.addEventListener('DOMContentLoaded', () => {
    initFlatpickr();
});

window.initFlatpickr = initFlatpickr;
