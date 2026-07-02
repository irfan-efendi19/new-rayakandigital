<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Invoice {{ $invoice_number }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 11px;
            color: #1e293b;
            line-height: 1.6;
            padding: 40px;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            border-bottom: 3px solid #6366f1;
            padding-bottom: 20px;
            margin-bottom: 24px;
        }
        .header-left h1 {
            font-size: 28px;
            color: #6366f1;
            font-weight: 800;
            letter-spacing: -0.5px;
        }
        .header-left p {
            color: #64748b;
            font-size: 11px;
            margin-top: 4px;
        }
        .header-right {
            text-align: right;
        }
        .header-right h3 {
            font-size: 14px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 4px;
        }
        .header-right p {
            color: #64748b;
            font-size: 10px;
        }
        .info-section {
            display: flex;
            justify-content: space-between;
            margin-bottom: 24px;
            padding: 16px;
            background: #f8fafc;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
        }
        .info-section .block {
            flex: 1;
        }
        .info-section .block h4 {
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #94a3b8;
            margin-bottom: 4px;
        }
        .info-section .block p {
            font-size: 12px;
            font-weight: 600;
            color: #1e293b;
        }
        table.items {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 24px;
        }
        table.items thead th {
            background: #6366f1;
            color: #fff;
            text-align: left;
            padding: 10px 12px;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        table.items thead th:last-child {
            text-align: right;
        }
        table.items tbody td {
            padding: 10px 12px;
            border-bottom: 1px solid #e2e8f0;
            font-size: 11px;
        }
        table.items tbody td:last-child {
            text-align: right;
            font-weight: 600;
        }
        table.items tbody tr.package-row td {
            font-weight: 700;
            color: #1e293b;
            background: #f1f5f9;
        }
        table.items tbody tr.addon-row td {
            color: #475569;
        }
        .totals {
            width: 100%;
            max-width: 360px;
            margin-left: auto;
        }
        .totals table {
            width: 100%;
        }
        .totals td {
            padding: 6px 12px;
            font-size: 12px;
        }
        .totals td.label {
            text-align: left;
            color: #64748b;
        }
        .totals td.value {
            text-align: right;
            font-weight: 600;
        }
        .totals .grand-total td {
            padding-top: 10px;
            border-top: 2px solid #1e293b;
            font-size: 16px;
            font-weight: 800;
            color: #1e293b;
        }
        .footer {
            margin-top: 40px;
            padding-top: 16px;
            border-top: 1px solid #e2e8f0;
            text-align: center;
            font-size: 10px;
            color: #94a3b8;
        }
    </style>
</head>
<body>

    {{-- Header --}}
    <div class="header">
        <div class="header-left">
            <h1>INVOICE</h1>
            <p>Billing Statement &mdash; Digital Invitation</p>
        </div>
        <div class="header-right">
            <h3>Invoice #{{ $invoice_number }}</h3>
            <p>Tanggal Cetak: {{ $issue_date }}</p>
        </div>
    </div>

    {{-- Info --}}
    <div class="info-section">
        <div class="block">
            <h4>Kepada</h4>
            <p>{{ $user->name }}</p>
            <p style="font-weight: 400; font-size: 10px;">{{ $user->email }}</p>
        </div>
        <div class="block">
            <h4>Undangan</h4>
            <p>{{ $invitation->title }}</p>
            <p style="font-weight: 400; font-size: 10px;">{{ $invitation->couple_name }}</p>
        </div>
        <div class="block">
            <h4>Nomor Invoice</h4>
            <p>{{ $invoice_number }}</p>
        </div>
    </div>

    {{-- Items Table --}}
    <table class="items">
        <thead>
            <tr>
                <th style="width: 60%;">Deskripsi</th>
                <th style="width: 20%;">Qty</th>
                <th style="width: 20%;">Harga</th>
            </tr>
        </thead>
        <tbody>
            <tr class="package-row">
                <td>Paket {{ ucfirst($invitation->currentTier()) }}</td>
                <td style="text-align: right;">1</td>
                <td>Rp{{ number_format($package_price, 0, ',', '.') }}</td>
            </tr>
            @forelse($addons as $addon)
                <tr class="addon-row">
                    <td>{{ $addon->name }}</td>
                    <td style="text-align: right;">1</td>
                    <td>Rp{{ number_format($addon->pivot->purchased_price, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr class="addon-row">
                    <td colspan="3" style="text-align: center; color: #94a3b8; font-style: italic;">
                        Tidak ada add-on premium
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Totals --}}
    <div class="totals">
        <table>
            <tr>
                <td class="label">Subtotal Paket</td>
                <td class="value">Rp{{ number_format($package_price, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="label">Subtotal Add-On</td>
                <td class="value">Rp{{ number_format($addons->sum('pivot.purchased_price'), 0, ',', '.') }}</td>
            </tr>
            <tr class="grand-total">
                <td class="label">Grand Total</td>
                <td class="value">Rp{{ number_format($grand_total, 0, ',', '.') }}</td>
            </tr>
        </table>
    </div>

    {{-- Footer --}}
    <div class="footer">
        <p>Terima kasih telah menggunakan layanan Rayakan Digital &mdash; Dokumen ini dicetak secara otomatis.</p>
        <p style="margin-top: 4px;">{{ config('app.url') }}</p>
    </div>

</body>
</html>
