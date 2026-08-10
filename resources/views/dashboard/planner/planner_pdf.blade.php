<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Wedding Planner – Rundown & Budget</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 11px;
            color: #1A1A1A;
            line-height: 1.55;
            background: #ffffff;
        }

        .band { height: 8px; background: #FF7A00; }

        .page { padding: 32px 40px; }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 24px;
        }
        .brand-side .logo { height: 30px; width: auto; }
        .brand-side .name { font-size: 15px; font-weight: 800; margin-top: 8px; }
        .brand-side .tagline { font-size: 9px; color: #A1A1AA; margin-top: 2px; }
        .doc-no { text-align: right; }
        .doc-no .label {
            font-size: 9px; text-transform: uppercase; letter-spacing: 1.5px; color: #A1A1AA;
        }
        .doc-no .value { font-size: 20px; font-weight: 800; margin-top: 3px; }
        .doc-no .date { font-size: 10px; color: #52525B; margin-top: 4px; }

        .section-title {
            font-size: 12px; font-weight: 800; text-transform: uppercase; letter-spacing: 1px;
            color: #FF7A00; margin-bottom: 12px; padding-top: 4px;
            border-bottom: 2px solid #F5F5F5; padding-bottom: 6px;
        }

        table.items { width: 100%; border-collapse: collapse; margin-bottom: 26px; }
        table.items thead th {
            text-align: left; padding: 9px 10px; font-size: 8.5px; text-transform: uppercase;
            letter-spacing: 0.8px; color: #52525B; border-bottom: 2px solid #E4E4E7;
        }
        table.items thead th.num, table.items tbody td.num { text-align: right; }
        table.items tbody td { padding: 10px; font-size: 11px; border-bottom: 1px solid #F5F5F5; }
        table.items tbody td.num { font-weight: 600; }
        table.items tbody tr:nth-child(even) { background: #FAFAFA; }

        .badge {
            display: inline-block; padding: 1px 8px; border-radius: 8px; font-size: 8.5px;
            font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;
        }
        .badge-pending { background: #F5F5F5; color: #52525B; }
        .badge-progress { background: #DBEAFE; color: #1D4ED8; }
        .badge-completed { background: #D1FAE5; color: #047857; }
        .badge-cancelled { background: #FEE2E2; color: #B91C1C; }

        .totals { margin-top: 6px; }
        .totals table { width: 100%; }
        .totals td { padding: 6px 0; font-size: 11px; }
        .totals td.label { color: #52525B; }
        .totals td.value { text-align: right; font-weight: 600; }
        .grand-total-box {
            background: #FF7A00; color: #ffffff; border-radius: 10px;
            padding: 10px 16px; margin-top: 8px;
        }
        .grand-total-box .row { display: flex; justify-content: space-between; align-items: center; }
        .grand-total-box .lbl { font-size: 10px; letter-spacing: 0.5px; }
        .grand-total-box .amt { font-size: 16px; font-weight: 800; }

        .footer {
            margin-top: 28px; padding-top: 14px; border-top: 1px solid #E4E4E7;
            text-align: center; font-size: 9px; color: #A1A1AA;
        }
        .footer .brand { color: #FF7A00; font-weight: 700; }
        .muted { color: #A1A1AA; }
    </style>
</head>
<body>

    <div class="band"></div>

    <div class="page">

        {{-- Header --}}
        <div class="header">
            <div class="brand-side">
                <img src="{{ public_path('img/logolong.png') }}" alt="Rayakan Digital" class="logo">
                <div class="name">Wedding Planner & Organizer</div>
                <div class="tagline">Rundown Acara & Rincian Budget</div>
            </div>
            <div class="doc-no">
                <div class="label">Laporan</div>
                <div class="value">Rundown & Budget</div>
                <div class="date">Dicetak: {{ $generatedAt }}</div>
                <div class="date">Oleh: {{ $user->name }}</div>
            </div>
        </div>

        {{-- Rundown Acara --}}
        <div class="section-title">Rundown Acara Hari H</div>

        @if($rundowns->isEmpty())
            <p class="muted" style="margin-bottom:26px;">Belum ada rundown acara.</p>
        @else
            <table class="items">
                <thead>
                    <tr>
                        <th style="width:15%;">Urutan</th>
                        <th style="width:20%;">Waktu</th>
                        <th style="width:32%;">Kegiatan</th>
                        <th style="width:17%;">PIC</th>
                        <th style="width:16%;">Catatan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rundowns as $index => $rundown)
                        <tr>
                            <td>#{{ $index + 1 }}</td>
                            <td class="num">{{ $rundown->time_start->format('H:i') }}
                                @if($rundown->time_end)
                                    – {{ $rundown->time_end->format('H:i') }}
                                @endif
                            </td>
                            <td>{{ $rundown->activity_name }}</td>
                            <td>{{ $rundown->person_in_charge ?: '—' }}</td>
                            <td class="muted">{{ $rundown->notes ?: '—' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

        {{-- Rincian Budget --}}
        <div class="section-title">Rincian Budget & Vendor</div>

        @if($budgets->isEmpty())
            <p class="muted" style="margin-bottom:26px;">Belum ada item budget atau vendor.</p>
        @else
            <table class="items">
                <thead>
                    <tr>
                        <th style="width:30%;">Item</th>
                        <th class="num" style="width:15%;">Estimasi</th>
                        <th class="num" style="width:15%;">Realisasi</th>
                        <th class="num" style="width:15%;">Terbayar</th>
                        <th class="num" style="width:13%;">Sisa</th>
                        <th style="width:12%;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($budgets as $item)
                        <tr>
                            <td>
                                <strong>{{ $item->title }}</strong>
                                @if($item->vendor_contact)
                                    <div class="muted">{{ $item->vendor_contact }}</div>
                                @endif
                            </td>
                            <td class="num">Rp {{ number_format($item->estimated_cost, 0, ',', '.') }}</td>
                            <td class="num">Rp {{ number_format($item->actual_cost, 0, ',', '.') }}</td>
                            <td class="num">Rp {{ number_format($item->paid_amount, 0, ',', '.') }}</td>
                            <td class="num">Rp {{ number_format(max(0, $item->remaining_balance), 0, ',', '.') }}</td>
                            <td>
                                @php
                                    $badgeClass = match ($item->status) {
                                        'IN_PROGRESS' => 'badge-progress',
                                        'COMPLETED' => 'badge-completed',
                                        'CANCELLED' => 'badge-cancelled',
                                        default => 'badge-pending',
                                    };
                                    $label = match ($item->status) {
                                        'IN_PROGRESS' => 'Proses',
                                        'COMPLETED' => 'Selesai',
                                        'CANCELLED' => 'Batal',
                                        default => 'Pending',
                                    };
                                @endphp
                                <span class="badge {{ $badgeClass }}">{{ $label }}</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="totals">
                <table>
                    <tr>
                        <td class="label">Total Estimasi</td>
                        <td class="value">Rp {{ number_format($totalEstimated, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td class="label">Total Realisasi</td>
                        <td class="value">Rp {{ number_format($totalActual, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td class="label">Total Terbayar (DP/Lunas)</td>
                        <td class="value">Rp {{ number_format($totalPaid, 0, ',', '.') }}</td>
                    </tr>
                    <tr class="grand-total">
                        <td colspan="2">
                            <div class="grand-total-box">
                                <div class="row">
                                    <span class="lbl">Sisa Tagihan Vendor</span>
                                    <span class="amt">Rp {{ number_format(max(0, $totalActual - $totalPaid), 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        @endif

        {{-- Footer --}}
        <div class="footer">
            <p>Dokumen ini dihasilkan otomatis oleh <span class="brand">Rayakan Digital</span> — Wedding Planner & Organizer.</p>
            <p style="margin-top:4px;">{{ config('app.url') }}</p>
        </div>

    </div>

</body>
</html>
