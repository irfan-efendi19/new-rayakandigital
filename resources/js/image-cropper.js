import Cropper from 'cropperjs';

document.addEventListener('DOMContentLoaded', function () {
    let cropper = null;
    let currentInput = null;
    let currentPreviewId = null;
    let currentOutputWidth = 400;
    let currentOutputHeight = 400;
    let previewRafId = null;
    let pageScrollLocked = false;
    let rootOverflowWasHidden = false;
    let bodyOverflowWasHidden = false;

    const modal = document.getElementById('crop-modal');
    const modalTitle = document.getElementById('crop-modal-title');
    const modalSubtitle = document.getElementById('crop-modal-subtitle');
    const ratioHint = document.getElementById('crop-ratio-hint');
    const cropLoading = document.getElementById('crop-loading');
    const cropLoadingText = document.getElementById('crop-loading-text');
    const cropContainer = document.getElementById('crop-container');
    const saveBtn = document.getElementById('crop-save');
    const zoomInBtn = document.getElementById('crop-zoom-in');
    const zoomOutBtn = document.getElementById('crop-zoom-out');
    const rotateBtn = document.getElementById('crop-rotate');

    if (modal && modal.parentElement !== document.body) {
        document.body.appendChild(modal);
    }

    function lockPageScroll() {
        if (pageScrollLocked) return;

        rootOverflowWasHidden = document.documentElement.classList.contains('overflow-hidden');
        bodyOverflowWasHidden = document.body.classList.contains('overflow-hidden');
        document.documentElement.classList.add('overflow-hidden');
        document.body.classList.add('overflow-hidden');
        pageScrollLocked = true;
    }

    function unlockPageScroll() {
        if (!pageScrollLocked) return;

        if (!rootOverflowWasHidden) document.documentElement.classList.remove('overflow-hidden');
        if (!bodyOverflowWasHidden) document.body.classList.remove('overflow-hidden');
        pageScrollLocked = false;
    }

    function showModalShell() {
        if (!modal) return;

        lockPageScroll();
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        modal.scrollTop = 0;
    }

    function hideModalShell() {
        if (!modal) return;

        modal.classList.add('hidden');
        modal.classList.remove('flex');
        unlockPageScroll();
    }

    // All preview ring elements (desktop + mobile badge)
    function getPreviewRings() {
        return document.querySelectorAll('.crop-preview-ring');
    }

    function destroyCropper() {
        if (previewRafId) { cancelAnimationFrame(previewRafId); previewRafId = null; }
        if (cropper) {
            cropper.destroy();
            cropper = null;
        }
        if (cropContainer) {
            cropContainer.innerHTML = '';
        }
    }

    function showLoading(show, text) {
        if (!cropLoading) return;
        cropLoading.classList.toggle('hidden', !show);
        if (text && cropLoadingText) cropLoadingText.textContent = text;
    }

    function aspectLabel(raw) {
        if (raw.includes('/')) return raw.replace('/', ':');
        const val = parseFloat(raw);
        if (Number.isInteger(val)) return val + ':1';
        return raw + ':1';
    }

    function fitImageToSelection(activeCropper) {
        const image = activeCropper.getCropperImage();
        const selection = activeCropper.getCropperSelection();

        if (!image || !selection) return Promise.resolve();

        return image.$ready().then(function (sourceImage) {
            return new Promise(function (resolve) {
                function applyFit(remainingFrames) {
                    if (cropper !== activeCropper) {
                        resolve();
                        return;
                    }

                    const { x, y, width, height } = selection;
                    if ((!width || !height) && remainingFrames > 0) {
                        requestAnimationFrame(function () {
                            applyFit(remainingFrames - 1);
                        });
                        return;
                    }

                    const scale = Math.max(
                        width / sourceImage.naturalWidth,
                        height / sourceImage.naturalHeight,
                    );

                    if (!Number.isFinite(scale) || scale <= 0) {
                        resolve();
                        return;
                    }

                    image.$setTransform(
                        scale,
                        0,
                        0,
                        scale,
                        x + width / 2 - sourceImage.naturalWidth / 2,
                        y + height / 2 - sourceImage.naturalHeight / 2,
                    );

                    resolve();
                }

                requestAnimationFrame(function () {
                    applyFit(30);
                });
            });
        });
    }

    // Render the current cropped area into all preview rings
    function renderPreview() {
        if (!cropper) return;
        const selection = cropper.getCropperSelection();
        if (!selection) return;

        // Use a small, fast canvas for the preview thumbnail
        selection.$toCanvas({ width: 96, height: 96 }).then(function (canvas) {
            const url = canvas.toDataURL('image/jpeg', 0.6);
            getPreviewRings().forEach(function (ring) {
                let img = ring.querySelector('img.crop-preview-img');
                if (!img) {
                    ring.innerHTML = '';
                    img = document.createElement('img');
                    img.className = 'crop-preview-img w-full h-full object-cover';
                    img.alt = 'Pratinjau';
                    ring.appendChild(img);
                }
                img.src = url;
            });
        }).catch(function () {});
    }

    // Poll preview while modal is open
    function startPreviewLoop() {
        function loop() {
            if (!modal || modal.classList.contains('hidden')) return;
            renderPreview();
            previewRafId = requestAnimationFrame(function () {
                setTimeout(loop, 200); // ~5fps, light on CPU
            });
        }
        loop();
    }

    function openCropModal(fileInput, previewId) {
        const file = fileInput.files[0];
        if (!file) return;

        currentInput = fileInput;
        currentPreviewId = previewId;

        const aspectRatioRaw = fileInput.dataset.aspectRatio || '1';
        const aspectRatio = aspectRatioRaw.includes('/')
            ? aspectRatioRaw.split('/').reduce((a, b) => parseFloat(a) / parseFloat(b))
            : parseFloat(aspectRatioRaw);
        const outputWidth = parseInt(fileInput.dataset.width) || 400;
        const outputHeight = parseInt(fileInput.dataset.height) || 400;

        currentOutputWidth = outputWidth;
        currentOutputHeight = outputHeight;

        if (modalTitle) modalTitle.textContent = 'Sesuaikan Foto';
        if (modalSubtitle) modalSubtitle.textContent = fileInput.dataset.title || 'Geser & perbesar untuk memilih area';
        if (ratioHint) ratioHint.textContent = 'Rasio ' + aspectLabel(aspectRatioRaw);

        // Clear preview rings
        getPreviewRings().forEach(function (ring) { ring.innerHTML = ''; });

        showModalShell();
        showLoading(true, 'Memuat foto...');

        const reader = new FileReader();
        reader.onload = function () {
            const img = new Image();
            img.src = reader.result;

            img.onload = function () {
                destroyCropper();
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
                    minContainerWidth: 300,
                    minContainerHeight: 240,
                    template: [
                        "<cropper-canvas background>",
                        '<cropper-image initial-center-size="cover" rotatable scalable skewable translatable></cropper-image>',
                        "<cropper-shade theme-color=\"rgba(0, 0, 0, 0.55)\"></cropper-shade>",
                        '<cropper-selection initial-coverage="0.85" aspect-ratio="' + aspectRatio + '" movable resizable>',
                        '<cropper-grid role="grid" bordered covered></cropper-grid>',
                        "<cropper-crosshair centered></cropper-crosshair>",
                        '<cropper-handle action="move" theme-color="rgba(255, 255, 255, 0.25)"></cropper-handle>',
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

                const activeCropper = cropper;
                fitImageToSelection(activeCropper)
                    .catch(function () {})
                    .finally(function () {
                        if (cropper !== activeCropper) return;
                        showLoading(false);
                        startPreviewLoop();
                    });
            };

            img.onerror = function () {
                showLoading(true, 'Gagal memuat foto. Silakan pilih file gambar lain.');
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        title: 'Gagal Memuat Foto',
                        text: 'File yang dipilih tidak dapat dibaca sebagai gambar. Silakan pilih file gambar lain.',
                        icon: 'error',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Oke',
                    }).then(() => closeCropModal());
                } else {
                    setTimeout(closeCropModal, 1500);
                }
            };
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
        if (previewRafId) { cancelAnimationFrame(previewRafId); previewRafId = null; }
        destroyCropper();
        showLoading(false);
        hideModalShell();

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

        const saveBtnEl = saveBtn;
        saveBtnEl.disabled = true;
        saveBtnEl.innerHTML = '<svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v3m6.366-.366l-2.12 2.12M21 12h-3m.366 6.366l-2.12-2.12M12 21v-3m-6.366.366l2.12-2.12M3 12h3m-.366-6.366l2.12 2.12"/></svg> Memproses...';

        selection.$toCanvas({ width: currentOutputWidth, height: currentOutputHeight }).then(function (canvas) {
            canvas.toBlob(function (blob) {
                const file = new File([blob], 'cropped.webp', { type: 'image/webp' });

                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);
                currentInput.files = dataTransfer.files;

                updatePreview(currentPreviewId, canvas.toDataURL('image/webp'));

                if (previewRafId) { cancelAnimationFrame(previewRafId); previewRafId = null; }
                destroyCropper();
                showLoading(false);
                hideModalShell();
                currentInput = null;
                currentPreviewId = null;

                saveBtnEl.disabled = false;
                saveBtnEl.innerHTML = '<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0z" /></svg> Gunakan Foto Ini';
            }, 'image/webp', 0.85);
        });
    });

    document.querySelectorAll('.crop-close').forEach(function (el) {
        el.addEventListener('click', closeCropModal);
    });

    if (modal) modal.addEventListener('click', function (e) {
        if (e.target === modal) closeCropModal();
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && modal && !modal.classList.contains('hidden')) {
            closeCropModal();
        }
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
