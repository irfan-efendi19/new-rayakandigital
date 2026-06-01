<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tiket - {{ $guest->name }}</title>
    <style>
        /* Reset */
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Courier New', monospace;
            font-size: 12px;
            color: #000;
            background: #fff;
        }

        .ticket {
            width: 58mm;
            max-width: 58mm;
            margin: 0 auto;
            padding: 4mm 3mm;
        }

        .ticket-header {
            text-align: center;
            border-bottom: 1px dashed #000;
            padding-bottom: 3mm;
            margin-bottom: 3mm;
        }

        .ticket-header h1 {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 2px;
        }

        .ticket-header .couple {
            font-size: 16px;
            font-weight: bold;
            margin: 4px 0;
        }

        .ticket-body {
            border-bottom: 1px dashed #000;
            padding-bottom: 3mm;
            margin-bottom: 3mm;
        }

        .ticket-body .guest-name {
            font-size: 16px;
            font-weight: bold;
            text-align: center;
            margin: 3mm 0;
            padding: 2mm;
            border: 1px solid #000;
        }

        .ticket-body .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 1mm;
            font-size: 11px;
        }

        .ticket-body .info-row .label {
            font-weight: bold;
        }

        .ticket-qr {
            text-align: center;
            padding: 2mm 0;
            border-bottom: 1px dashed #000;
            margin-bottom: 2mm;
        }

        .ticket-qr svg {
            width: 25mm;
            height: 25mm;
        }

        .ticket-footer {
            text-align: center;
            font-size: 10px;
            color: #666;
        }

        .ticket-number {
            font-size: 20px;
            font-weight: bold;
            text-align: center;
            margin: 2mm 0;
        }

        /* Screen-only styles */
        @media screen {
            body {
                background: #f3f4f6;
                padding: 20px;
            }

            .screen-controls {
                text-align: center;
                margin-bottom: 20px;
            }

            .screen-controls button {
                background: #4f46e5;
                color: white;
                border: none;
                padding: 10px 24px;
                border-radius: 8px;
                font-size: 14px;
                cursor: pointer;
                margin: 0 4px;
            }

            .screen-controls button:hover {
                background: #4338ca;
            }

            .screen-controls .btn-close {
                background: #6b7280;
            }

            .ticket {
                background: white;
                box-shadow: 0 4px 6px rgba(0,0,0,.1);
                border-radius: 8px;
                padding: 6mm 4mm;
            }
        }

        /* Print styles */
        @media print {
            @page {
                size: 58mm auto;
                margin: 0;
            }

            body {
                width: 58mm;
            }

            .screen-controls {
                display: none !important;
            }
        }

        /* 80mm variant */
        body.width-80 .ticket {
            width: 80mm;
            max-width: 80mm;
        }

        @media print {
            body.width-80 {
                width: 80mm;
            }

            body.width-80 @page {
                size: 80mm auto;
            }
        }
    </style>
</head>
<body>
    <div class="screen-controls">
        <button onclick="window.print()">🖨 Cetak Tiket</button>
        <button onclick="toggleWidth()" id="btn-width">Ubah ke 80mm</button>
        <button class="btn-close" onclick="window.close()">✕ Tutup</button>
    </div>

    <div class="ticket">
        <div class="ticket-header">
            <h1>TIKET TAMU</h1>
            <div class="couple">{{ $invitation->bride_nickname ?? $invitation->bride_name }} & {{ $invitation->groom_nickname ?? $invitation->groom_name }}</div>
            <div style="font-size: 10px;">{{ $invitation->venue_name }}</div>
        </div>

        <div class="ticket-body">
            <div class="guest-name">{{ $guest->name }}</div>

            <div class="ticket-number">
                #{{ str_pad($checkinOrder, 3, '0', STR_PAD_LEFT) }}
            </div>

            <div class="info-row">
                <span class="label">Check-In:</span>
                <span>{{ $guest->checked_in_at?->format('H:i') }}</span>
            </div>
            <div class="info-row">
                <span class="label">Tanggal:</span>
                <span>{{ $guest->checked_in_at?->format('d/m/Y') }}</span>
            </div>
            @if($guest->phone)
            <div class="info-row">
                <span class="label">Telp:</span>
                <span>{{ $guest->phone }}</span>
            </div>
            @endif
        </div>

        <div class="ticket-qr">
            {!! $guest->qr_code_svg !!}
            <div style="font-size: 9px; margin-top: 1mm; color: #999;">{{ Str::limit($guest->qr_code_token, 12) }}</div>
        </div>

        <div class="ticket-footer">
            <p>Terima kasih atas kehadiran Anda</p>
            <p style="margin-top: 1mm;">{{ config('app.name') }}</p>
        </div>
    </div>

    <script>
        // Auto-print when opened
        window.addEventListener('load', function() {
            setTimeout(() => window.print(), 500);
        });

        function toggleWidth() {
            document.body.classList.toggle('width-80');
            const btn = document.getElementById('btn-width');
            btn.textContent = document.body.classList.contains('width-80') ? 'Ubah ke 58mm' : 'Ubah ke 80mm';
        }
    </script>
</body>
</html>
