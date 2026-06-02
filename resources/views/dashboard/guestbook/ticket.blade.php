<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tiket - {{ $guest->name }} | {{ config('app.name') }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Courier New', monospace;
            font-size: 12px;
            color: #1a1a1a;
            background: #fff;
        }

        .ticket {
            width: 58mm;
            max-width: 58mm;
            margin: 0 auto;
            padding: 4mm 3mm;
        }

        .ticket-brand {
            text-align: center;
            font-size: 10px;
            color: #FF7A00;
            font-family: 'Georgia', serif;
            font-style: italic;
            margin-bottom: 2mm;
            font-weight: bold;
        }

        .ticket-header {
            text-align: center;
            border-top: 2px solid #1a1a1a;
            border-bottom: 1px dashed #1a1a1a;
            padding: 2mm 0 3mm;
            margin-bottom: 3mm;
        }

        .ticket-header h1 {
            font-size: 13px;
            font-weight: bold;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        .ticket-header .couple {
            font-size: 16px;
            font-weight: bold;
            margin: 3px 0;
        }

        .ticket-body {
            border-bottom: 1px dashed #1a1a1a;
            padding-bottom: 3mm;
            margin-bottom: 3mm;
        }

        .ticket-body .guest-name {
            font-size: 16px;
            font-weight: bold;
            text-align: center;
            margin: 3mm 0;
            padding: 2mm;
            border: 2px solid #1a1a1a;
            border-radius: 2mm;
        }

        .ticket-number {
            font-size: 22px;
            font-weight: bold;
            text-align: center;
            margin: 2mm 0;
            color: #FF7A00;
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
            border-bottom: 1px dashed #1a1a1a;
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

        .ticket-footer .brand {
            color: #FF7A00;
            font-weight: bold;
            margin-top: 1mm;
        }

        @media screen {
            body {
                background: #f4f4f5;
                padding: 20px;
            }

            .screen-controls {
                text-align: center;
                margin-bottom: 20px;
            }

            .screen-controls button {
                border: none;
                padding: 10px 24px;
                border-radius: 12px;
                font-size: 14px;
                cursor: pointer;
                margin: 0 4px;
                font-weight: 600;
                transition: all 0.2s;
            }

            .screen-controls .btn-print {
                background: #FF7A00;
                color: white;
            }

            .screen-controls .btn-print:hover {
                background: #D96500;
                box-shadow: 0 4px 12px rgba(255, 122, 0, 0.3);
            }

            .screen-controls .btn-width {
                background: #e4e4e7;
                color: #3f3f46;
            }

            .screen-controls .btn-width:hover {
                background: #d4d4d8;
            }

            .screen-controls .btn-close {
                background: #6b7280;
                color: white;
            }

            .screen-controls .btn-close:hover {
                background: #4b5563;
            }

            .ticket {
                background: white;
                box-shadow: 0 4px 20px rgba(0,0,0,0.08);
                border-radius: 12px;
                padding: 6mm 4mm;
            }
        }

        @media print {
            @page {
                size: 58mm auto;
                margin: 0;
            }
            body { width: 58mm; }
            .screen-controls { display: none !important; }
        }

        body.width-80 .ticket { width: 80mm; max-width: 80mm; }
        @media print {
            body.width-80 { width: 80mm; }
            body.width-80 @page { size: 80mm auto; }
        }
    </style>
</head>
<body>
    <div class="screen-controls">
        <button class="btn-print" onclick="window.print()">
            <svg style="display:inline;width:16px;height:16px;margin-right:6px;vertical-align:middle" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
            </svg>
            Cetak Tiket
        </button>
        <button class="btn-width" onclick="toggleWidth()" id="btn-width">Ubah ke 80mm</button>
        <button class="btn-close" onclick="window.close()">Tutup</button>
    </div>

    <div class="ticket">
        <div class="ticket-brand">{{ config('app.name') }}</div>

        <div class="ticket-header">
            <h1>Tiket Masuk</h1>
            <div class="couple">{{ $invitation->bride_nickname ?? $invitation->bride_name }} & {{ $invitation->groom_nickname ?? $invitation->groom_name }}</div>
            <div style="font-size: 10px; margin-top: 2px;">{{ $invitation->venue_name ?? 'Undangan Pernikahan' }}</div>
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
            <p class="brand">{{ config('app.name') }}</p>
        </div>
    </div>

    <script>
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
