<style>
    #crop-container {
        width: 100%;
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    #crop-container cropper-canvas {
        flex: 1;
        min-height: 0;
    }

    /* Crop Modal modern styles */
    #crop-modal {
        backdrop-filter: blur(4px);
        -webkit-backdrop-filter: blur(4px);
    }

    #crop-modal-inner {
        animation: cropModalIn 0.22s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    @keyframes cropModalIn {
        from {
            opacity: 0;
            transform: translateY(24px) scale(0.97);
        }

        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    .crop-preview-ring {
        overflow: hidden;
        border-radius: 9999px;
        border: 3px solid rgba(var(--color-primary-400), 1);
        box-shadow: 0 0 0 4px rgba(var(--color-primary-400), 0.18);
        background: #111;
    }

    .crop-tool-btn {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 4px;
        padding: 10px 14px;
        border-radius: 12px;
        background: rgba(255, 255, 255, 0.06);
        border: 1px solid rgba(255, 255, 255, 0.1);
        color: #d4d4d8;
        transition: background 0.15s, border-color 0.15s, color 0.15s;
        cursor: pointer;
        flex-shrink: 0;
        white-space: nowrap;
    }

    @media (max-width: 480px) {
        .crop-tool-btn {
            padding: 8px 10px;
        }
    }

    .crop-tool-btn:hover {
        background: rgba(255, 255, 255, 0.13);
        border-color: rgba(255, 255, 255, 0.2);
        color: #fff;
    }

    .crop-tool-btn span {
        font-size: 10px;
        font-weight: 600;
        letter-spacing: 0.02em;
        line-height: 1;
    }

    [x-cloak] {
        display: none !important;
    }

    .scrollbar-thin::-webkit-scrollbar {
        height: 6px;
    }

    .scrollbar-thin::-webkit-scrollbar-track {
        background: transparent;
    }

    .scrollbar-thin::-webkit-scrollbar-thumb {
        background-color: #E4E4E7;
        border-radius: 10px;
    }

    .dark .scrollbar-thin::-webkit-scrollbar-thumb {
        background-color: #27272A;
    }

    .photo-upload-zone {
        transition: border-color 0.2s, background-color 0.2s;
    }

    .theme-card {
        transition: all 0.2s ease-in-out;
    }
</style>
