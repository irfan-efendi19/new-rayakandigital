import Cropper from 'cropperjs';

document.addEventListener('DOMContentLoaded', function () {
    let cropper = null;
    let currentInput = null;
    let currentPreviewId = null;
    let currentOutputWidth = 400;
    let currentOutputHeight = 400;

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

        const aspectRatio = fileInput.dataset.aspectRatio || '1';
        const outputWidth = parseInt(fileInput.dataset.width) || 400;
        const outputHeight = parseInt(fileInput.dataset.height) || 400;

        currentOutputWidth = outputWidth;
        currentOutputHeight = outputHeight;

        const reader = new FileReader();
        reader.onload = function () {
            destroyCropper();

            modal.classList.remove("hidden");
            modal.classList.add("flex");

            const img = new Image();
            img.src = reader.result;

            img.onload = function () {
                cropContainer.appendChild(img);
                cropper = new Cropper(img, {
                    container: cropContainer,
                    viewMode: 1,
                    responsive: true,
                    center: true,
                    autoCrop: true,
                    autoCropArea: 1,
                    movable: true,
                    scalable: true,
                    zoomable: true,
                    zoomOnTouch: true,
                    zoomOnWheel: true,
                    minContainerWidth: 500,
                    minContainerHeight: 350,
                    template: [
                        "<cropper-canvas background>",
                        "<cropper-image rotatable scalable skewable translatable></cropper-image>",
                        "<cropper-shade hidden></cropper-shade>",
                        '<cropper-selection initial-coverage="0.8" aspect-ratio="' + aspectRatio + '" movable resizable>',
                        '<cropper-grid role="grid" bordered covered></cropper-grid>',
                        "<cropper-crosshair centered></cropper-crosshair>",
                        '<cropper-handle action="move" theme-color="rgba(255, 255, 255, 0.35)"></cropper-handle>',
                        '<cropper-handle action="ne-resize"></cropper-handle>',
                        '<cropper-handle action="nw-resize"></cropper-handle>',
                        '<cropper-handle action="se-resize"></cropper-handle>',
                        '<cropper-handle action="sw-resize"></cropper-handle>',
                        "</cropper-selection>",
                        "</cropper-canvas>",
                    ].join(""),
                });

                if (cropper && typeof cropper.resize === "function") {
                    cropper.resize();
                }
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

    if (saveBtn) saveBtn.addEventListener('click', function () {
        if (!cropper || !currentInput) return;

        const selection = cropper.getCropperSelection();
        if (!selection) return;

        selection.$toCanvas({ width: currentOutputWidth, height: currentOutputHeight }).then(function (canvas) {
            canvas.toBlob(function (blob) {
                const file = new File([blob], 'cropped.webp', { type: 'image/webp' });

                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);
                currentInput.files = dataTransfer.files;

                updatePreview(currentPreviewId, canvas.toDataURL('image/webp'));

                destroyCropper();
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                currentInput = null;
                currentPreviewId = null;
            }, 'image/webp', 0.85);
        });
    });

    document.querySelectorAll('.crop-close').forEach(function (el) {
        el.addEventListener('click', closeCropModal);
    });

    if (modal) modal.addEventListener('click', function (e) {
        if (e.target === modal) closeCropModal();
    });

    if (zoomInBtn) zoomInBtn.addEventListener('click', function () {
        if (cropper) {
            const imageEl = cropper.getCropperImage();
            if (imageEl) imageEl.$zoom(0.1);
        }
    });

    if (zoomOutBtn) zoomOutBtn.addEventListener('click', function () {
        if (cropper) {
            const imageEl = cropper.getCropperImage();
            if (imageEl) imageEl.$zoom(-0.1);
        }
    });

    if (rotateBtn) rotateBtn.addEventListener('click', function () {
        if (cropper) {
            const imageEl = cropper.getCropperImage();
            if (imageEl) imageEl.$rotate(Math.PI / 2);
        }
    });
});
