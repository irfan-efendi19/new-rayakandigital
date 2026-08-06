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
            color: #1A1A1A;
            line-height: 1.55;
            padding: 0;
            background: #ffffff;
        }

        /* top accent band */
        .band {
            height: 8px;
            background: #FF7A00;
        }

        .page {
            padding: 36px 44px;
        }

        /* ── Header ── */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 28px;
        }
        .brand-side .logo {
            height: 34px;
            width: auto;
        }
        .brand-side .name {
            font-size: 15px;
            font-weight: 800;
            color: #1A1A1A;
            margin-top: 10px;
        }
        .brand-side .tagline {
            font-size: 9px;
            color: #A1A1AA;
            margin-top: 2px;
        }
        .doc-no {
            text-align: right;
        }
        .doc-no .label {
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: #A1A1AA;
        }
        .doc-no .value {
            font-size: 22px;
            font-weight: 800;
            color: #1A1A1A;
            margin-top: 3px;
        }
        .doc-no .date {
            font-size: 10px;
            color: #52525B;
            margin-top: 4px;
        }

        /* ── Info grid ── */
        .info-grid {
            display: table;
            width: 100%;
            border: 1px solid #E4E4E7;
            border-radius: 10px;
            overflow: hidden;
            margin-bottom: 28px;
        }
        .info-row { display: table-row; }
        .info-cell {
            display: table-cell;
            padding: 14px 18px;
            vertical-align: top;
            border-top: 1px solid #F5F5F5;
        }
        .info-cell:first-child { border-left: none; }
        .info-cell h4 {
            font-size: 8.5px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #A1A1AA;
            font-weight: 700;
            margin-bottom: 5px;
        }
        .info-cell p {
            font-size: 12px;
            font-weight: 600;
            color: #1A1A1A;
            word-break: break-word;
        }
        .info-cell p.muted {
            font-weight: 400;
            font-size: 10px;
            color: #52525B;
            margin-top: 2px;
        }

        /* ── Items table ── */
        table.items {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 22px;
        }
        table.items thead th {
            text-align: left;
            padding: 9px 12px;
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: #52525B;
            border-bottom: 2px solid #E4E4E7;
        }
        table.items thead th.num,
        table.items tbody td.num {
            text-align: right;
        }
        table.items tbody td {
            padding: 12px;
            font-size: 11px;
            border-bottom: 1px solid #F5F5F5;
        }
        table.items tbody td.num {
            font-weight: 600;
            color: #1A1A1A;
        }
        table.items tbody tr.package-row td {
            font-weight: 700;
            color: #1A1A1A;
        }
        table.items tbody tr.addon-row td {
            color: #52525B;
            padding-left: 20px;
        }
        .item-title {
            font-size: 11px;
            font-weight: 600;
            color: #1A1A1A;
        }
        .item-sub {
            font-size: 9px;
            color: #A1A1AA;
            margin-top: 1px;
        }

        /* ── Totals ── */
        .bottom {
            display: table;
            width: 100%;
        }
        .amount-box {
            display: table-cell;
            vertical-align: bottom;
            width: 46%;
            padding-top: 6px;
        }
        .amount-box .terbilang {
            font-size: 9px;
            color: #52525B;
            background: #F5F5F5;
            border: 1px solid #F5F5F5;
            border-radius: 8px;
            padding: 8px 12px;
            line-height: 1.5;
        }
        .totals {
            display: table-cell;
            width: 42%;
            vertical-align: bottom;
        }
        .totals table { width: 100%; }
        .totals td {
            padding: 6px 0 6px 14px;
            font-size: 12px;
        }
        .totals td.label { text-align: left; color: #52525B; }
        .totals td.value { text-align: right; font-weight: 600; color: #1A1A1A; }
        .totals tr.subtotal {
            border-bottom: 1px solid #F5F5F5;
        }
        .totals .grand-total td {
            padding: 12px 0 12px 14px;
        }
        .grand-total-box {
            background: #FF7A00;
            color: #ffffff;
            border-radius: 10px;
            padding: 12px 16px;
        }
        .grand-total-box .row {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .grand-total-box .lbl {
            font-size: 10px;
            letter-spacing: 0.5px;
        }
        .grand-total-box .amt {
            font-size: 18px;
            font-weight: 800;
        }

        /* ── Footer ── */
        .footer {
            margin-top: 34px;
            padding-top: 16px;
            border-top: 1px solid #E4E4E7;
            text-align: center;
            font-size: 9.5px;
            color: #A1A1AA;
        }
        .footer .brand {
            color: #FF7A00;
            font-weight: 700;
        }
    </style>
</head>
<body>

    <div class="band"></div>

    <div class="page">

        {{-- Header --}}
        <div class="header">
            <div class="brand-side">
                <img src="{{ public_path('img/logolong.png') }}" alt="Rayakan Digital" class="logo">
                <div class="name">Rayakan Digital</div>
                <div class="tagline">Digital Invitation Platform</div>
            </div>
            <div class="doc-no">
                <div class="label">Invoice</div>
                <div class="value">#{{ $invoice_number }}</div>
                <div class="doc-no date" style="margin-top:2px;">Tanggal Terbit: {{ $issue_date }}</div>
            </div>
        </div>

        {{-- Info grid --}}
        <div class="info-grid">
            <div class="info-row">
                <div class="info-cell">
                    <h4>Ditagihkan Kepada</h4>
                    <p>{{ $user->name }}</p>
                    <p class="muted">{{ $user->email }}</p>
                </div>
                <div class="info-cell">
                    <h4>Untuk Undangan</h4>
                    <p>{{ $invitation->title }}</p>
                    <p class="muted">{{ $invitation->couple_name }}</p>
                </div>
                <div class="info-cell">
                    <h4>Paket</h4>
                    <p>Paket {{ ucfirst($invitation->currentTier()) }}</p>
                    <p class="muted">{{ $addons->count() }} add-on terjual</p>
                </div>
            </div>
        </div>

        {{-- Items table --}}
        <table class="items">
            <thead>
                <tr>
                    <th>Deskripsi</th>
                    <th class="num">Qty</th>
                    <th class="num">Harga Satuan</th>
                    <th class="num">Jumlah</th>
                </tr>
            </thead>
            <tbody>
                <tr class="package-row">
                    <td>
                        <div class="item-title">Paket {{ ucfirst($invitation->currentTier()) }}</div>
                        <div class="item-sub">Langganan undangan digital</div>
                    </td>
                    <td class="num">1</td>
                    <td class="num">Rp {{ number_format($package_price, 0, ',', '.') }}</td>
                    <td class="num">Rp {{ number_format($package_price, 0, ',', '.') }}</td>
                </tr>
                @foreach($addons as $addon)
                    <tr class="addon-row">
                        <td><div class="item-title">{{ $addon->name }}</div></td>
                        <td class="num">1</td>
                        <td class="num">Rp {{ number_format($addon->pivot->purchased_price, 0, ',', '.') }}</td>
                        <td class="num">Rp {{ number_format($addon->pivot->purchased_price, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Totals --}}
        <div class="bottom">
            <div class="amount-box">
                <div class="terbilang">
                    <strong>Terbilang:</strong><br>
                    {{ \Illuminate\Support\Number::spell($grand_total, locale: 'id') }} rupiah
                </div>
            </div>
            <div class="totals">
                <table>
                    <tr class="grand">
                        <td class="label">Subtotal Paket</td>
                        <td class="value">Rp {{ number_format($package_price, 0, ',', '.') }}</td>
                    </tr>
                    @if($addons->count())
                        <tr>
                            <td class="label">Subtotal Add-On</td>
                            <td class="value">Rp {{ number_format($addons->sum('pivot.purchased_price'), 0, ',', '.') }}</td>
                        </tr>
                    @endif
                    <tr class="grand-total">
                        <td colspan="2">
                            <div class="grand-total-box">
                                <div class="row">
                                    <span class="lbl">Grand Total</span>
                                    <span class="amt">Rp {{ number_format($grand_total, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        {{-- Footer --}}
        <div class="footer">
            <p>Terima kasih telah menggunakan layanan <span class="brand">Rayakan Digital</span> &mdash; Dokumen ini dicetak secara otomatis.</p>
            <p style="margin-top: 4px;">{{ config('app.url') }}</p>
        </div>

    </div>

</body>
</html>