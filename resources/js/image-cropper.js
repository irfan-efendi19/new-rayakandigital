import Cropper from 'cropperjs';

document.addEventListener('DOMContentLoaded', function () {
    let cropper = null;
    let currentInput = null;
    let currentPreviewId = null;

    const modal = document.getElementById('crop-modal');
    const cropContainer = document.getElementById('crop-container');
    const saveBtn = document.getElementById('crop-save');
    const zoomInBtn = document.getElementById('crop-zoom-in');
    const zoomOutBtn = document.getElementById('crop-zoom-out');
    const rotateBtn = document.getElementById('crop-rotate');

    function destroyCropper() {
        if (cropper) {
            cropper.destroy();
            cropper = null;
        }
        if (cropContainer) {
            cropContainer.innerHTML = '';
        }
    }

    function openCropModal(fileInput, previewId) {
        const file = fileInput.files[0];
        if (!file) return;

        currentInput = fileInput;
        currentPreviewId = previewId;

        const reader = new FileReader();
        reader.onload = function () {
            destroyCropper();

            const img = new Image();
            img.src = reader.result;

            img.onload = function () {
                cropContainer.appendChild(img);
                cropper = new Cropper(img, {
                    container: cropContainer,
                    template: [
                        '<cropper-canvas background>',
                        '<cropper-image rotatable scalable skewable translatable></cropper-image>',
                        '<cropper-shade hidden></cropper-shade>',
                        '<cropper-selection initial-coverage="0.8" aspect-ratio="1" movable resizable>',
                        '<cropper-grid role="grid" bordered covered></cropper-grid>',
                        '<cropper-crosshair centered></cropper-crosshair>',
                        '<cropper-handle action="move" theme-color="rgba(255, 255, 255, 0.35)"></cropper-handle>',
                        '<cropper-handle action="ne-resize"></cropper-handle>',
                        '<cropper-handle action="nw-resize"></cropper-handle>',
                        '<cropper-handle action="se-resize"></cropper-handle>',
                        '<cropper-handle action="sw-resize"></cropper-handle>',
                        '</cropper-selection>',
                        '</cropper-canvas>',
                    ].join(''),
                });
            };

            modal.classList.remove('hidden');
            modal.classList.add('flex');
        };
        reader.readAsDataURL(file);
    }

    function updatePreview(previewId, dataUrl) {
        const previewEl = document.getElementById(previewId);
        const placeholderEl = document.getElementById(previewId + '-placeholder');
        if (previewEl) {
            previewEl.src = dataUrl;
            previewEl.classList.remove('hidden');
        }
        if (placeholderEl) {
            placeholderEl.classList.add('hidden');
        }
    }

    function closeCropModal() {
        destroyCropper();
        modal.classList.add('hidden');
        modal.classList.remove('flex');

        if (currentInput) {
            currentInput.value = '';
            currentInput = null;
            currentPreviewId = null;
        }
    }

    document.querySelectorAll('[data-crop-target]').forEach(function (trigger) {
        trigger.addEventListener('click', function () {
            const targetId = this.dataset.cropTarget;
            const fileInput = document.getElementById(targetId);
            if (fileInput) fileInput.click();
        });
    });

    document.querySelectorAll('.crop-file-input').forEach(function (input) {
        input.addEventListener('change', function () {
            const previewId = this.dataset.preview;
            openCropModal(this, previewId);
        });
    });

    saveBtn.addEventListener('click', function () {
        if (!cropper || !currentInput) return;

        const selection = cropper.getCropperSelection();
        if (!selection) return;

        selection.$toCanvas({ width: 400, height: 400 }).then(function (canvas) {
            canvas.toBlob(function (blob) {
                const file = new File([blob], 'cropped.jpg', { type: 'image/jpeg' });

                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);
                currentInput.files = dataTransfer.files;

                updatePreview(currentPreviewId, canvas.toDataURL('image/jpeg'));

                destroyCropper();
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                currentInput = null;
                currentPreviewId = null;
            }, 'image/jpeg', 0.9);
        });
    });

    document.querySelectorAll('.crop-close').forEach(function (el) {
        el.addEventListener('click', closeCropModal);
    });

    modal.addEventListener('click', function (e) {
        if (e.target === modal) closeCropModal();
    });

    zoomInBtn.addEventListener('click', function () {
        if (cropper) {
            const imageEl = cropper.getCropperImage();
            if (imageEl) imageEl.$zoom(0.1);
        }
    });

    zoomOutBtn.addEventListener('click', function () {
        if (cropper) {
            const imageEl = cropper.getCropperImage();
            if (imageEl) imageEl.$zoom(-0.1);
        }
    });

    rotateBtn.addEventListener('click', function () {
        if (cropper) {
            const imageEl = cropper.getCropperImage();
            if (imageEl) imageEl.$rotate(Math.PI / 2);
        }
    });
});
