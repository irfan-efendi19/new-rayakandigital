<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Invoice {{ $invoiceNumber }}</title>
    <style>
        @page { margin: 42px 42px 76px; }
        * { box-sizing: border-box; }
        body { margin: 0; font-family: 'DejaVu Sans', sans-serif; font-size: 10px; line-height: 1.6; color: #27272a; }
        h1, h2, p { margin: 0; }
        table { width: 100%; border-collapse: collapse; table-layout: fixed; }
        td, th { vertical-align: top; overflow-wrap: break-word; }
        .right { text-align: right; }
        .muted { color: #71717a; font-size: 9px; }
        .eyebrow { color: #71717a; font-size: 8px; font-weight: bold; letter-spacing: 1.2px; text-transform: uppercase; }
        .header { border-top: 5px solid #ff7a00; }
        .header td { padding: 25px 0 21px; vertical-align: middle; }
        .brand-logo { width: 186px; height: auto; }
        .brand-caption { margin-top: 9px; font-size: 8px; color: #71717a; letter-spacing: 0.6px; }
        .header .eyebrow { color: #bc5100; }
        h1 { font-size: 29px; letter-spacing: 1px; line-height: 1.25; color: #18181b; }
        .document-meta { border-top: 1px solid #e4e4e7; border-bottom: 1px solid #e4e4e7; }
        .document-meta td { padding: 11px 0; }
        .meta-value { margin-top: 3px; font-size: 10px; font-weight: bold; }
        .summary { margin-top: 22px; padding: 19px 21px; background: #fff5eb; border: 1px solid #ffdfbe; border-radius: 10px; page-break-inside: avoid; }
        .summary td { vertical-align: middle; }
        .summary .amount-cell { width: 63%; }
        .summary .eyebrow { color: #9a4809; }
        .amount { margin-top: 3px; font-size: 28px; font-weight: bold; color: #18181b; letter-spacing: -0.8px; white-space: nowrap; }
        .badge { display: inline-block; padding: 5px 9px; border-radius: 5px; font-size: 8px; font-weight: bold; background: #fef3c7; color: #92400e; }
        .badge-approved { background: #dbeafe; color: #1e40af; }
        .badge-paid { background: #dcfce7; color: #166534; }
        .badge-rejected { background: #fee2e2; color: #991b1b; }
        .status-label { margin-bottom: 7px; }
        .section { margin-top: 23px; }
        .section-title { margin-bottom: 10px; font-size: 11px; font-weight: bold; color: #18181b; }
        .parties { page-break-inside: avoid; }
        .parties .partner { width: 46%; padding-right: 24px; }
        .parties .bank { padding-left: 22px; border-left: 1px solid #e4e4e7; }
        .party-name { margin: 5px 0 4px; font-size: 13px; font-weight: bold; overflow-wrap: break-word; }
        .bank-number { margin: 3px 0; font-size: 16px; font-weight: bold; letter-spacing: 0.4px; }
        .bank-holder { margin-bottom: 7px; overflow-wrap: break-word; }
        .items { page-break-inside: avoid; }
        .items th { padding: 10px 12px; background: #27272a; color: #ffffff; text-align: left; font-size: 8px; letter-spacing: 0.5px; text-transform: uppercase; }
        .items td { padding: 14px 12px; border-bottom: 1px solid #e4e4e7; }
        .items .number { width: 8%; text-align: center; }
        .items .money { width: 33%; text-align: right; white-space: nowrap; }
        .item-title { font-weight: bold; }
        .item-caption { margin-top: 3px; font-size: 9px; color: #71717a; }
        .total td { padding: 11px 12px; background: #fafafa; font-size: 11px; font-weight: bold; }
        .details td { padding: 4px 0; }
        .details .label { width: 31%; color: #71717a; }
        .transfer { page-break-inside: avoid; }
        .note { white-space: pre-line; overflow-wrap: break-word; color: #52525b; }
        .notice { margin-top: 22px; padding: 12px 15px; background: #fafafa; border-left: 3px solid #ff7a00; font-size: 9px; color: #52525b; page-break-inside: avoid; }
        .notice-title { margin-bottom: 3px; font-weight: bold; color: #27272a; }
        .footer { position: fixed; bottom: -47px; left: 0; right: 0; border-top: 1px solid #e4e4e7; padding-top: 10px; font-size: 8px; color: #71717a; }
        .footer-brand { font-weight: bold; color: #bc5100; }
        .page-number:after { content: counter(page); }
    </style>
</head>
<body>
    <footer class="footer">
        <table>
            <tr>
                <td><span class="footer-brand">Rayakan Digital</span><br>Dokumen diterbitkan secara elektronik.</td>
                <td class="right">{{ $invoiceNumber }}<br>Halaman <span class="page-number"></span></td>
            </tr>
        </table>
    </footer>

    <table class="header">
        <tr>
            <td>
                <img src="{{ public_path('img/logolong.png') }}" alt="Rayakan Digital" class="brand-logo">
                <p class="brand-caption">PROGRAM MITRA &amp; RESELLER</p>
            </td>
            <td class="right">
                <p class="eyebrow">Pencairan komisi mitra</p>
                <h1>INVOICE</h1>
            </td>
        </tr>
    </table>

    <table class="document-meta">
        <tr>
            <td><p class="eyebrow">Nomor invoice</p><p class="meta-value">{{ $invoiceNumber }}</p></td>
            <td class="right"><p class="eyebrow">Tanggal pengajuan</p><p class="meta-value">{{ $payout->created_at->timezone('Asia/Jakarta')->translatedFormat('d F Y, H:i') }} WIB</p></td>
        </tr>
    </table>

    <div class="summary">
        <table>
            <tr>
                <td class="amount-cell"><p class="eyebrow">Nominal pencairan</p><p class="amount">Rp {{ number_format($payout->amount, 0, ',', '.') }}</p></td>
                <td class="right">
                    <p class="muted status-label">Status pencairan</p>
                    <span class="badge badge-{{ $payout->status }}">{{ \App\Models\AffiliatePayout::STATUSES[$payout->status] }}</span>
                </td>
            </tr>
        </table>
    </div>

    <table class="parties section">
        <tr>
            <td class="partner">
                <p class="eyebrow">Nama mitra</p>
                <p class="party-name">{{ $affiliate->business_name }}</p>
                <p class="muted">Penerima pencairan komisi<br>Program Mitra Rayakan Digital</p>
            </td>
            <td class="bank">
                <p class="eyebrow">Rekening tujuan</p>
                <p class="party-name">{{ $payout->bank_name }}</p>
                <p class="bank-number">{{ $payout->bank_account_number }}</p>
                <p class="bank-holder">Atas nama {{ $payout->bank_account_holder }}</p>
                <p class="muted">Rekening yang tercatat saat pengajuan pencairan.</p>
            </td>
        </tr>
    </table>

    <div class="section">
        <h2 class="section-title">Rincian pencairan</h2>
        <table class="items">
            <thead><tr><th class="number">No.</th><th>Deskripsi</th><th class="money">Nominal</th></tr></thead>
            <tbody>
                <tr>
                    <td class="number muted">01</td>
                    <td><p class="item-title">Penarikan saldo komisi mitra</p><p class="item-caption">Sesuai pengajuan pencairan yang tercatat.</p></td>
                    <td class="money item-title">Rp {{ number_format($payout->amount, 0, ',', '.') }}</td>
                </tr>
                <tr class="total"><td colspan="2">Total pencairan</td><td class="money">Rp {{ number_format($payout->amount, 0, ',', '.') }}</td></tr>
            </tbody>
        </table>
    </div>

    @if($payout->status === 'paid')
        <div class="section transfer">
            <h2 class="section-title">Informasi transfer</h2>
            <table class="details">
                <tr><td class="label">Tanggal transfer</td><td>{{ $payout->paid_at ? $payout->paid_at->timezone('Asia/Jakarta')->translatedFormat('d F Y, H:i').' WIB' : '-' }}</td></tr>
                <tr><td class="label">Referensi transfer</td><td>{{ $payout->transfer_reference ?? '-' }}</td></tr>
            </table>
        </div>
    @endif

    @if($payout->review_note)
        <div class="section">
            <h2 class="section-title">Catatan admin</h2>
            <p class="note">{{ $payout->review_note }}</p>
        </div>
    @endif

    <div class="notice">
        <p class="notice-title">Informasi dokumen</p>
        @if($payout->status === 'paid')
            Pencairan telah ditandai selesai oleh admin dengan referensi transfer di atas.
        @elseif($payout->status === 'rejected')
            Pengajuan pencairan ditolak. Dokumen ini merupakan catatan pengajuan dan bukan bukti transfer.
        @else
            Pencairan masih dalam proses. Dokumen ini merupakan catatan pengajuan dan bukan bukti transfer.
        @endif
    </div>
</body>
</html>
