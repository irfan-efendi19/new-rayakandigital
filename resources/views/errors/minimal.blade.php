<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('code') — @yield('message')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;600&family=Space+Mono:wght@400;700&display=swap"
        rel="stylesheet">

    <style>
    *,
    *::before,
    *::after {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    :root {
        --bg: #ffffff;
        --bg-secondary: #f7f7f5;
        --text-primary: #1a1a18;
        --text-secondary: #6b6b66;
        --text-tertiary: #a8a8a2;
        --border: rgba(0, 0, 0, 0.1);
        --border-muted: rgba(0, 0, 0, 0.06);
        --danger-bg: #fff1f0;
        --danger-text: #c0392b;
    }

    @media (prefers-color-scheme: dark) {
        :root {
            --bg: #111110;
            --bg-secondary: #1c1c1a;
            --text-primary: #f0efe8;
            --text-secondary: #9a9a94;
            --text-tertiary: #5a5a55;
            --border: rgba(255, 255, 255, 0.1);
            --border-muted: rgba(255, 255, 255, 0.05);
            --danger-bg: #2a1210;
            --danger-text: #f08070;
        }
    }

    html,
    body {
        height: 100%;
    }

    body {
        font-family: 'Sora', ui-sans-serif, system-ui, sans-serif;
        background-color: var(--bg);
        color: var(--text-primary);
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
    }

    .page {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem;
        position: relative;
        overflow: hidden;
    }

    /* Decorative corner marks */
    .corner {
        position: fixed;
        width: 22px;
        height: 22px;
    }

    .corner--tl {
        top: 24px;
        left: 24px;
        border-top: 1px solid var(--border);
        border-left: 1px solid var(--border);
    }

    .corner--tr {
        top: 24px;
        right: 24px;
        border-top: 1px solid var(--border);
        border-right: 1px solid var(--border);
    }

    .corner--bl {
        bottom: 24px;
        left: 24px;
        border-bottom: 1px solid var(--border);
        border-left: 1px solid var(--border);
    }

    .corner--br {
        bottom: 24px;
        right: 24px;
        border-bottom: 1px solid var(--border);
        border-right: 1px solid var(--border);
    }

    /* Large background glyph */
    .bg-glyph {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-family: 'Space Mono', monospace;
        font-size: clamp(160px, 30vw, 340px);
        font-weight: 700;
        color: var(--text-primary);
        opacity: 0.04;
        user-select: none;
        pointer-events: none;
        letter-spacing: -0.04em;
        white-space: nowrap;
        line-height: 1;
    }

    /* Main card */
    .card {
        position: relative;
        z-index: 1;
        max-width: 520px;
        width: 100%;
        animation: reveal 0.5s cubic-bezier(0.22, 1, 0.36, 1) both;
    }

    @keyframes reveal {
        from {
            opacity: 0;
            transform: translateY(18px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Status badge */
    .badge {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        font-family: 'Space Mono', monospace;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 0.14em;
        text-transform: uppercase;
        color: var(--danger-text);
        background: var(--danger-bg);
        border: 1px solid rgba(192, 57, 43, 0.15);
        border-radius: 100px;
        padding: 5px 14px 5px 10px;
        margin-bottom: 2rem;
        animation: reveal 0.5s 0.05s cubic-bezier(0.22, 1, 0.36, 1) both;
    }

    .badge__dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: var(--danger-text);
        animation: pulse 2.2s ease-in-out infinite;
        flex-shrink: 0;
    }

    @keyframes pulse {

        0%,
        100% {
            opacity: 1;
            transform: scale(1);
        }

        50% {
            opacity: 0.3;
            transform: scale(0.65);
        }
    }

    /* Error code */
    .code {
        font-family: 'Space Mono', monospace;
        font-size: clamp(56px, 10vw, 80px);
        font-weight: 700;
        line-height: 1;
        color: var(--text-primary);
        letter-spacing: -0.03em;
        animation: reveal 0.5s 0.1s cubic-bezier(0.22, 1, 0.36, 1) both;
    }

    .divider {
        width: 36px;
        height: 2px;
        background: var(--text-primary);
        border-radius: 2px;
        margin: 1.4rem 0;
        animation: reveal 0.5s 0.15s cubic-bezier(0.22, 1, 0.36, 1) both;
    }

    .message {
        font-size: 17px;
        font-weight: 300;
        color: var(--text-secondary);
        line-height: 1.65;
        margin-bottom: 2.5rem;
        animation: reveal 0.5s 0.2s cubic-bezier(0.22, 1, 0.36, 1) both;
    }

    /* Actions */
    .actions {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
        animation: reveal 0.5s 0.25s cubic-bezier(0.22, 1, 0.36, 1) both;
    }

    .btn {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        font-family: 'Sora', sans-serif;
        font-size: 13px;
        font-weight: 600;
        padding: 10px 20px;
        border-radius: 8px;
        cursor: pointer;
        transition: transform 0.15s ease, opacity 0.15s ease, background 0.15s ease;
        text-decoration: none;
        white-space: nowrap;
    }

    .btn--primary {
        background: var(--text-primary);
        color: var(--bg);
        border: none;
    }

    .btn--primary:hover {
        opacity: 0.82;
        transform: translateY(-1px);
    }

    .btn--primary:active {
        transform: translateY(0);
        opacity: 1;
    }

    .btn--ghost {
        background: transparent;
        color: var(--text-secondary);
        border: 1px solid var(--border);
    }

    .btn--ghost:hover {
        background: var(--bg-secondary);
        color: var(--text-primary);
        transform: translateY(-1px);
    }

    .btn--ghost:active {
        transform: translateY(0);
    }

    /* SVG icons inline */
    .icon {
        width: 15px;
        height: 15px;
        display: inline-block;
        vertical-align: middle;
        flex-shrink: 0;
    }

    /* Meta footer */
    .meta {
        margin-top: 3rem;
        padding-top: 1.5rem;
        border-top: 1px solid var(--border-muted);
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
        animation: reveal 0.5s 0.3s cubic-bezier(0.22, 1, 0.36, 1) both;
    }

    .meta__item {
        font-family: 'Space Mono', monospace;
        font-size: 10px;
        letter-spacing: 0.08em;
        color: var(--text-tertiary);
        text-transform: uppercase;
    }

    .meta__sep {
        width: 3px;
        height: 3px;
        border-radius: 50%;
        background: var(--border);
        flex-shrink: 0;
    }
    </style>
    </head>
<body>

    <div class="page" role="main">

        <!-- Corner decorations -->
        <div class="corner corner--tl" aria-hidden="true"></div>
        <div class="corner corner--tr" aria-hidden="true"></div>
        <div class="corner corner--bl" aria-hidden="true"></div>
        <div class="corner corner--br" aria-hidden="true"></div>

        <!-- Background glyph -->
        <div class="bg-glyph" aria-hidden="true">@yield('code')</div>

        <!-- Main content -->
        <div class="card">

            <div class="badge">
                <span class="badge__dot" aria-hidden="true"></span>
                HTTP Error
            </div>

            <div class="code" aria-label="Error code @yield('code')">@yield('code')</div>

            <div class="divider" aria-hidden="true"></div>

            <p class="message">@yield('message')</p>

            <div class="actions">
                <a href="javascript:history.back()" class="btn btn--primary">
                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"
                        stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M19 12H5M12 5l-7 7 7 7" />
                    </svg>
                    Kembali
                </a>
                <a href="/" class="btn btn--ghost">
                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"
                        stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                        <polyline points="9 22 9 12 15 12 15 22" />
                    </svg>
                    Beranda
                </a>
            </div>
<div class="meta" aria-label="Informasi tambahan">
    <span class="meta__item">{{ config('app.name', 'Laravel') }}</span>
    <span class="meta__sep" aria-hidden="true"></span>
    <span class="meta__item">@yield('message')</span>
    <span class="meta__sep" aria-hidden="true"></span>
    <span class="meta__item">HTTP/@yield('code')</span>
            </div>

        </div>
        </div>

</body>

</html>