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
            color: #1a1a1a;
            line-height: 1.6;
            padding: 40px;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 3px solid #FF7A00;
            padding-bottom: 20px;
            margin-bottom: 24px;
        }
        .header-left {
            display: flex;
            align-items: center;
            gap: 16px;
        }
        .header-left .logo {
            width: 130px;
            height: auto;
        }
        .header-left .divider {
            width: 1px;
            height: 40px;
            background: #e4e4e7;
        }
        .header-left .title-group h1 {
            font-size: 24px;
            color: #FF7A00;
            font-weight: 800;
            letter-spacing: -0.5px;
        }
        .header-left .title-group p {
            color: #737373;
            font-size: 10px;
            margin-top: 2px;
        }
        .header-right {
            text-align: right;
        }
        .header-right h3 {
            font-size: 14px;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 4px;
        }
        .header-right p {
            color: #737373;
            font-size: 10px;
        }
        .info-section {
            display: flex;
            justify-content: space-between;
            margin-bottom: 24px;
            padding: 16px 20px;
            background: #FFF4EB;
            border-radius: 8px;
            border: 1px solid #FFE4CC;
        }
        .info-section .block {
            flex: 1;
        }
        .info-section .block h4 {
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #FF7A00;
            margin-bottom: 4px;
        }
        .info-section .block p {
            font-size: 12px;
            font-weight: 600;
            color: #1a1a1a;
        }
        table.items {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 24px;
        }
        table.items thead th {
            background: #FF7A00;
            color: #fff;
            text-align: left;
            padding: 10px 14px;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        table.items thead th:last-child {
            text-align: right;
        }
        table.items tbody td {
            padding: 10px 14px;
            border-bottom: 1px solid #e4e4e7;
            font-size: 11px;
        }
        table.items tbody td:last-child {
            text-align: right;
            font-weight: 600;
        }
        table.items tbody tr.package-row td {
            font-weight: 700;
            color: #1a1a1a;
            background: #f5f5f5;
        }
        table.items tbody tr.addon-row td {
            color: #525252;
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
            padding: 6px 14px;
            font-size: 12px;
        }
        .totals td.label {
            text-align: left;
            color: #737373;
        }
        .totals td.value {
            text-align: right;
            font-weight: 600;
        }
        .totals .grand-total td {
            padding-top: 10px;
            border-top: 2px solid #1a1a1a;
            font-size: 16px;
            font-weight: 800;
            color: #1a1a1a;
        }
        .footer {
            margin-top: 40px;
            padding-top: 16px;
            border-top: 1px solid #e4e4e7;
            text-align: center;
            font-size: 10px;
            color: #a1a1aa;
        }
        .footer .brand {
            color: #FF7A00;
            font-weight: 700;
        }
    </style>
</head>
<body>

    {{-- Header with Logo --}}
    <div class="header">
        <div class="header-left">
            <img src="{{ public_path('img/logolong.png') }}" alt="Rayakan Digital" class="logo">
            <div class="divider"></div>
            <div class="title-group">
                <h1>INVOICE</h1>
                <p>Billing Statement &mdash; Digital Invitation</p>
            </div>
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
                    <td colspan="3" style="text-align: center; color: #a1a1aa; font-style: italic;">
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
        <p>Terima kasih telah menggunakan layanan <span class="brand">Rayakan Digital</span> &mdash; Dokumen ini dicetak secara otomatis.</p>
        <p style="margin-top: 4px;">{{ config('app.url') }}</p>
    </div>

</body>
</html>
