<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Invoice {{ $invoice_number }}</title>
    <style>
        @page { margin: 0; }
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            background: #ffffff;
            color: #27272a;
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 10px;
            line-height: 1.5;
        }

        .top-band {
            height: 9px;
            background: #ff7a00;
            border-bottom: 3px solid #1a1a1a;
        }

        .page { padding: 30px 40px 26px; }
        .header-table, .party-table, .summary-layout, .footer-table { width: 100%; border-collapse: collapse; }
        .header-table td { vertical-align: top; }
        .brand-logo { width: 184px; height: auto; }

        .brand-tagline {
            margin-top: 7px;
            color: #71717a;
            font-size: 8.5px;
            letter-spacing: 0.6px;
            text-transform: uppercase;
        }

        .invoice-head { text-align: right; }

        .invoice-kicker {
            color: #ff7a00;
            font-size: 9px;
            font-weight: 700;
            letter-spacing: 1.8px;
            text-transform: uppercase;
        }

        .invoice-title {
            margin-top: 2px;
            color: #18181b;
            font-size: 28px;
            font-weight: 700;
            letter-spacing: -0.8px;
            line-height: 1.1;
        }

        .invoice-number {
            margin-top: 7px;
            color: #52525b;
            font-size: 10px;
            font-weight: 700;
            word-break: break-all;
        }

        .invoice-date { margin-top: 3px; color: #a1a1aa; font-size: 9px; }
        .intro-line { margin: 24px 0 16px; border-top: 1px solid #e4e4e7; }

        .party-table {
            table-layout: fixed;
            margin-bottom: 22px;
            page-break-inside: avoid;
        }

        .party-table td { width: 50%; vertical-align: top; }
        .party-table td:first-child { padding-right: 6px; }
        .party-table td:last-child { padding-left: 6px; }

        .party-card {
            min-height: 92px;
            padding: 13px 15px;
            border: 1px solid #e4e4e7;
            background: #fafafa;
        }

        .party-card.accent {
            border-left: 4px solid #ff7a00;
            background: #fff8f2;
        }

        .eyebrow {
            color: #a1a1aa;
            font-size: 8px;
            font-weight: 700;
            letter-spacing: 1.1px;
            text-transform: uppercase;
        }

        .party-name { margin-top: 5px; color: #18181b; font-size: 12px; font-weight: 700; }
        .party-detail { margin-top: 2px; color: #71717a; font-size: 9px; word-break: break-word; }
        .meta-row { margin-top: 9px; color: #52525b; font-size: 8.5px; }
        .meta-label { color: #a1a1aa; }

        .section-head { width: 100%; margin-bottom: 8px; border-collapse: collapse; }
        .section-head td { vertical-align: bottom; }
        .section-title { color: #18181b; font-size: 13px; font-weight: 700; }
        .section-note { color: #a1a1aa; font-size: 8.5px; text-align: right; }

        table.items {
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
            table-layout: fixed;
        }

        table.items thead { display: table-header-group; }

        table.items th {
            padding: 9px 10px;
            background: #27272a;
            color: #ffffff;
            font-size: 8px;
            font-weight: 700;
            letter-spacing: 0.7px;
            text-align: left;
            text-transform: uppercase;
        }

        table.items th:first-child { width: 7%; text-align: center; }
        table.items th.description { width: 45%; }
        table.items th.qty { width: 8%; text-align: center; }
        table.items th.money { width: 20%; text-align: right; }
        table.items tbody tr { page-break-inside: avoid; }

        table.items td {
            padding: 10px;
            border-bottom: 1px solid #e4e4e7;
            color: #3f3f46;
            vertical-align: middle;
        }

        table.items tbody tr:nth-child(even) td { background: #fafafa; }
        table.items td.index, table.items td.qty { color: #a1a1aa; text-align: center; }

        table.items td.money {
            color: #27272a;
            font-weight: 700;
            text-align: right;
            white-space: nowrap;
        }

        .item-name { color: #18181b; font-size: 10px; font-weight: 700; }
        .item-description { margin-top: 2px; color: #a1a1aa; font-size: 8.5px; }

        .item-badge {
            display: inline-block;
            margin-top: 4px;
            padding: 2px 6px;
            background: #fff1e6;
            color: #d96500;
            font-size: 7px;
            font-weight: 700;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .summary-layout { table-layout: fixed; page-break-inside: avoid; }
        .summary-layout > tbody > tr > td { vertical-align: top; }
        .words-cell { width: 53%; padding-right: 18px; }
        .totals-cell { width: 47%; }

        .words-box {
            padding: 11px 13px;
            border-left: 4px solid #ff7a00;
            background: #fafafa;
        }

        .words-title {
            color: #a1a1aa;
            font-size: 8px;
            font-weight: 700;
            letter-spacing: 0.9px;
            text-transform: uppercase;
        }

        .words-value {
            margin-top: 4px;
            color: #52525b;
            font-size: 9px;
            font-style: italic;
            line-height: 1.55;
            text-transform: capitalize;
        }

        .document-note { margin-top: 9px; color: #a1a1aa; font-size: 8px; line-height: 1.5; }
        .totals-table { width: 100%; border-collapse: collapse; }
        .totals-table td { padding: 5px 0 5px 12px; font-size: 9.5px; }
        .totals-table td:first-child { color: #71717a; }

        .totals-table td:last-child {
            color: #27272a;
            font-weight: 700;
            text-align: right;
            white-space: nowrap;
        }

        .totals-table tr.divider td { padding-bottom: 8px; border-bottom: 1px solid #e4e4e7; }
        .total-box { margin-top: 8px; padding: 12px 14px; background: #ff7a00; color: #ffffff; }
        .total-box-table { width: 100%; border-collapse: collapse; }
        .total-box-table td { color: #ffffff; vertical-align: middle; }

        .total-label {
            font-size: 8.5px;
            font-weight: 700;
            letter-spacing: 0.8px;
            text-transform: uppercase;
        }

        .total-amount { font-size: 17px; font-weight: 700; text-align: right; white-space: nowrap; }
        .footer { margin-top: 28px; padding-top: 12px; border-top: 1px solid #e4e4e7; page-break-inside: avoid; }
        .footer-table td { color: #a1a1aa; font-size: 8px; vertical-align: top; }
        .footer-table td:last-child { text-align: right; }
        .footer-brand { color: #ff7a00; font-weight: 700; }
        .footer-reference { margin-top: 3px; color: #71717a; font-weight: 700; }
    </style>
</head>
<body>
    <div class="top-band"></div>

    <main class="page">
        <table class="header-table">
            <tr>
                <td>
                    <img src="{{ public_path('img/logolong.png') }}" alt="Rayakan Digital" class="brand-logo">
                    <div class="brand-tagline">Digital invitation and event platform</div>
                </td>
                <td class="invoice-head">
                    <div class="invoice-kicker">Dokumen Tagihan</div>
                    <div class="invoice-title">INVOICE</div>
                    <div class="invoice-number">#{{ $invoice_number }}</div>
                    <div class="invoice-date">Diterbitkan {{ $issue_date }}</div>
                </td>
            </tr>
        </table>

        <div class="intro-line"></div>

        <table class="party-table">
            <tr>
                <td>
                    <div class="party-card accent">
                        <div class="eyebrow">Ditagihkan Kepada</div>
                        <div class="party-name">{{ $user->name }}</div>
                        <div class="party-detail">{{ $user->email }}</div>
                        <div class="meta-row"><span class="meta-label">Pelanggan Rayakan Digital</span></div>
                    </div>
                </td>
                <td>
                    <div class="party-card">
                        <div class="eyebrow">Detail Undangan</div>
                        <div class="party-name">{{ $invitation->title }}</div>
                        <div class="party-detail">{{ $invitation->couple_name }}</div>
                        <div class="meta-row">
                            <span class="meta-label">Paket:</span> {{ $package_name }}
                            &nbsp;&nbsp;|&nbsp;&nbsp;
                            <span class="meta-label">Add-on aktif:</span> {{ $addons->count() }}
                        </div>
                    </div>
                </td>
            </tr>
        </table>

        <table class="section-head">
            <tr>
                <td class="section-title">Rincian Layanan</td>
                <td class="section-note">{{ 1 + $addons->count() }} item tercatat</td>
            </tr>
        </table>

        <table class="items">
            <thead>
                <tr>
                    <th>No.</th>
                    <th class="description">Deskripsi</th>
                    <th class="qty">Qty</th>
                    <th class="money">Harga Satuan</th>
                    <th class="money">Jumlah</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="index">01</td>
                    <td>
                        <div class="item-name">Paket {{ $package_name }}</div>
                        <div class="item-description">Layanan undangan digital</div>
                        <span class="item-badge">Paket Utama</span>
                    </td>
                    <td class="qty">1</td>
                    <td class="money">Rp {{ number_format($package_price, 0, ',', '.') }}</td>
                    <td class="money">Rp {{ number_format($package_price, 0, ',', '.') }}</td>
                </tr>
                @foreach($addons as $addon)
                    <tr>
                        <td class="index">{{ str_pad((string) ($loop->iteration + 1), 2, '0', STR_PAD_LEFT) }}</td>
                        <td>
                            <div class="item-name">{{ $addon->name }}</div>
                            <div class="item-description">Fitur tambahan undangan digital</div>
                            <span class="item-badge">Add-on</span>
                        </td>
                        <td class="qty">1</td>
                        <td class="money">Rp {{ number_format($addon->pivot->purchased_price, 0, ',', '.') }}</td>
                        <td class="money">Rp {{ number_format($addon->pivot->purchased_price, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <table class="summary-layout">
            <tr>
                <td class="words-cell">
                    <div class="words-box">
                        <div class="words-title">Terbilang</div>
                        <div class="words-value">{{ \Illuminate\Support\Number::spell($grand_total, locale: 'id') }} rupiah</div>
                    </div>
                    <div class="document-note">
                        Invoice ini merangkum paket dan add-on aktif pada undangan. Dokumen dibuat otomatis oleh sistem dan tidak memerlukan tanda tangan.
                    </div>
                </td>
                <td class="totals-cell">
                    <table class="totals-table">
                        <tr>
                            <td>Subtotal paket</td>
                            <td>Rp {{ number_format($package_price, 0, ',', '.') }}</td>
                        </tr>
                        <tr class="divider">
                            <td>Subtotal add-on</td>
                            <td>Rp {{ number_format($addon_total, 0, ',', '.') }}</td>
                        </tr>
                    </table>
                    <div class="total-box">
                        <table class="total-box-table">
                            <tr>
                                <td class="total-label">Grand Total</td>
                                <td class="total-amount">Rp {{ number_format($grand_total, 0, ',', '.') }}</td>
                            </tr>
                        </table>
                    </div>
                </td>
            </tr>
        </table>

        <footer class="footer">
            <table class="footer-table">
                <tr>
                    <td>
                        Terima kasih telah menggunakan <span class="footer-brand">Rayakan Digital</span>.<br>
                        {{ config('app.url') }}
                    </td>
                    <td>
                        Referensi dokumen
                        <div class="footer-reference">{{ $invoice_number }}</div>
                    </td>
                </tr>
            </table>
        </footer>
    </main>
</body>
</html>
