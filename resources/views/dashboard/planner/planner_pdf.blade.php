<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Wedding Planner Lengkap</title>
    <style>
        @page { size: A4; margin: 0; }
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            color: #27272A;
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 9px;
            line-height: 1.45;
        }

        .page-accent {
            position: fixed;
            top: 0;
            right: 0;
            left: 0;
            height: 7px;
            background: #FF7A00;
            border-bottom: 2px solid #27272A;
        }

        .page-footer {
            position: fixed;
            right: 34px;
            bottom: 10px;
            left: 34px;
            padding: 8px 0 0;
            border-top: 1px solid #E4E4E7;
            color: #A1A1AA;
            font-size: 7.5px;
        }

        .page-footer table,
        .header-table,
        .profile-table,
        .metric-table,
        .module-table,
        .items-table,
        .totals-table {
            width: 100%;
            border-collapse: collapse;
        }

        .page-footer td:last-child { text-align: right; }
        .page-number::after { content: counter(page); }
        .brand { color: #FF7A00; font-weight: 700; }
        .content { padding: 28px 34px 46px 34px; }

        .header-table { margin-bottom: 19px; }
        .header-table td { vertical-align: top; }
        .header-table td:last-child { text-align: right; }
        .logo { width: 170px; height: auto; }

        .document-kicker {
            color: #FF7A00;
            font-size: 8px;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
        }

        .document-title {
            margin-top: 3px;
            color: #18181B;
            font-size: 23px;
            font-weight: 700;
            line-height: 1.1;
        }

        .document-date { margin-top: 7px; color: #71717A; font-size: 8px; }

        .hero {
            margin-bottom: 15px;
            padding: 16px 18px;
            background: #27272A;
            color: #FFFFFF;
        }

        .hero-label {
            color: #FDBA74;
            font-size: 7.5px;
            font-weight: 700;
            letter-spacing: 1.2px;
            text-transform: uppercase;
        }

        .hero-title { margin-top: 5px; font-size: 16px; font-weight: 700; }
        .hero-copy { margin-top: 5px; color: #D4D4D8; font-size: 8.5px; }

        .profile-table { table-layout: fixed; margin-bottom: 12px; }
        .profile-table td { width: 50%; padding: 10px 12px; border: 1px solid #E4E4E7; vertical-align: top; }
        .profile-table td + td { border-left: 0; }
        .eyebrow { color: #A1A1AA; font-size: 7px; font-weight: 700; letter-spacing: 0.9px; text-transform: uppercase; }
        .profile-value { margin-top: 4px; color: #18181B; font-size: 10px; font-weight: 700; }
        .profile-note { margin-top: 2px; color: #71717A; font-size: 8px; }

        .metric-table { table-layout: fixed; margin-bottom: 16px; }
        .metric-table td { width: 25%; padding-right: 7px; vertical-align: top; }
        .metric-table td:last-child { padding-right: 0; }

        .metric-card { min-height: 62px; padding: 10px; border: 1px solid #E4E4E7; background: #FAFAFA; }
        .metric-card.accent { border-color: #FED7AA; background: #FFF7ED; }
        .metric-label { color: #71717A; font-size: 7px; font-weight: 700; letter-spacing: 0.5px; text-transform: uppercase; }
        .metric-value { margin-top: 4px; color: #18181B; font-size: 13px; font-weight: 700; white-space: nowrap; }
        .metric-note { margin-top: 2px; color: #A1A1AA; font-size: 7px; }

        .overview-title,
        .section-title {
            color: #18181B;
            font-size: 12px;
            font-weight: 700;
        }

        .overview-title { margin-bottom: 7px; }

        .section-header {
            margin-bottom: 10px;
            padding-bottom: 8px;
            border-bottom: 2px solid #27272A;
            page-break-after: avoid;
        }

        .section-kicker {
            color: #FF7A00;
            font-size: 7px;
            font-weight: 700;
            letter-spacing: 1.1px;
            text-transform: uppercase;
        }

        .section-title { margin-top: 3px; font-size: 16px; }
        .section-description { margin-top: 3px; color: #71717A; font-size: 8px; }
        .page-break { page-break-before: always; padding-top: 28px; padding-bottom: 46px; }

        .module-table { margin-bottom: 16px; table-layout: fixed; }
        .module-table th { padding: 7px 8px; background: #27272A; color: #FFFFFF; font-size: 7px; text-align: left; text-transform: uppercase; }
        .module-table td { padding: 7px 8px; border-bottom: 1px solid #E4E4E7; vertical-align: middle; }
        .module-table tr:nth-child(even) td { background: #FAFAFA; }
        .module-table td.number { text-align: right; white-space: nowrap; }

        .items-table { margin-bottom: 13px; table-layout: fixed; }
        .items-table thead { display: table-header-group; }
        .items-table tr { page-break-inside: avoid; }
        .items-table th { padding: 7px; background: #27272A; color: #FFFFFF; font-size: 7px; text-align: left; text-transform: uppercase; }
        .items-table td { padding: 7px; border-bottom: 1px solid #E4E4E7; vertical-align: top; }
        .items-table tbody tr:nth-child(even) td { background: #FAFAFA; }
        .items-table .number { text-align: right; white-space: nowrap; }
        .items-table .center { text-align: center; }
        .item-title { color: #18181B; font-weight: 700; }
        .item-note { margin-top: 2px; color: #A1A1AA; font-size: 7.5px; }

        .group-title {
            margin: 11px 0 5px;
            padding: 6px 8px;
            border-left: 3px solid #FF7A00;
            background: #FFF7ED;
            color: #9A3412;
            font-size: 8px;
            font-weight: 700;
            page-break-after: avoid;
        }

        .status {
            display: inline-block;
            padding: 2px 6px;
            font-size: 6.5px;
            font-weight: 700;
            letter-spacing: 0.3px;
            text-transform: uppercase;
            white-space: nowrap;
        }

        .status-done { background: #D1FAE5; color: #047857; }
        .status-progress { background: #DBEAFE; color: #1D4ED8; }
        .status-pending { background: #F4F4F5; color: #52525B; }
        .status-cancelled { background: #FEE2E2; color: #B91C1C; }

        .empty-state { margin-bottom: 14px; padding: 13px; border: 1px dashed #D4D4D8; background: #FAFAFA; color: #71717A; }
        .section-summary { margin-bottom: 10px; padding: 9px 11px; background: #FFF7ED; color: #9A3412; font-weight: 700; }

        .totals-wrap { width: 44%; margin-left: 56%; page-break-inside: avoid; }
        .totals-table td { padding: 5px 0 5px 9px; }
        .totals-table td:first-child { color: #71717A; }
        .totals-table td:last-child { color: #18181B; font-weight: 700; text-align: right; white-space: nowrap; }
        .grand-total td { padding: 9px; background: #FF7A00; color: #FFFFFF !important; }
    </style>
</head>
<body>
    @php
        $statusLabels = [
            'PENDING' => 'Belum mulai',
            'IN_PROGRESS' => 'Dalam proses',
            'COMPLETED' => 'Selesai',
            'CANCELLED' => 'Dibatalkan',
        ];
        $statusClasses = [
            'PENDING' => 'status-pending',
            'IN_PROGRESS' => 'status-progress',
            'COMPLETED' => 'status-done',
            'CANCELLED' => 'status-cancelled',
        ];
        $checklistPercent = $checklistTotal > 0 ? round(($checklistCompleted / $checklistTotal) * 100) : 0;
        $administrationPercent = $administrationTotal > 0 ? round(($administrationCompleted / $administrationTotal) * 100) : 0;
        $budgetRows = $budgetItems->concat($vendorItems);
    @endphp

    <div class="page-accent"></div>
    <footer class="page-footer">
        <table>
            <tr>
                <td><span class="brand">Rayakan Digital</span> - Wedding Planner</td>
                <td>Halaman <span class="page-number"></span></td>
            </tr>
        </table>
    </footer>

    <main class="content">

    <table class="header-table">
        <tr>
            <td><img src="{{ public_path('img/logolong.png') }}" alt="Rayakan Digital" class="logo"></td>
            <td>
                <div class="document-kicker">Laporan Perencanaan</div>
                <div class="document-title">Wedding Planner</div>
                <div class="document-date">Dicetak {{ $generatedAt }}</div>
            </td>
        </tr>
    </table>

    <div class="hero">
        <div class="hero-label">Ringkasan lengkap persiapan pernikahan</div>
        <div class="hero-title">Semua rencana dalam satu dokumen.</div>
        <div class="hero-copy">Checklist, lamaran, pre-wedding, seserahan, administrasi, budget, vendor, dan rundown Hari H.</div>
    </div>

    <table class="profile-table">
        <tr>
            <td>
                <div class="eyebrow">Pemilik Planner</div>
                <div class="profile-value">{{ $user->name }}</div>
                <div class="profile-note">{{ $user->email }}</div>
            </td>
            <td>
                <div class="eyebrow">Detail Pernikahan</div>
                <div class="profile-value">{{ $invitation?->title ?? 'Undangan belum dibuat' }}</div>
                <div class="profile-note">
                    {{ $invitation?->couple_name ?? 'Nama pasangan belum tersedia' }}
                    @if($invitation?->event_date)
                        - {{ $invitation->event_date->translatedFormat('d F Y') }}
                    @endif
                </div>
            </td>
        </tr>
    </table>

    <table class="metric-table">
        <tr>
            <td><div class="metric-card accent"><div class="metric-label">Checklist</div><div class="metric-value">{{ $checklistPercent }}%</div><div class="metric-note">{{ $checklistCompleted }}/{{ $checklistTotal }} tugas selesai</div></div></td>
            <td><div class="metric-card"><div class="metric-label">Administrasi</div><div class="metric-value">{{ $administrationPercent }}%</div><div class="metric-note">{{ $administrationCompleted }}/{{ $administrationTotal }} centang siap</div></div></td>
            <td><div class="metric-card"><div class="metric-label">Total Rencana</div><div class="metric-value">Rp {{ number_format($totalPlanned, 0, ',', '.') }}</div><div class="metric-note">Semua modul finansial</div></div></td>
            <td><div class="metric-card"><div class="metric-label">Belum Terbayar</div><div class="metric-value">Rp {{ number_format($totalRemaining, 0, ',', '.') }}</div><div class="metric-note">Terbayar Rp {{ number_format($totalPaid, 0, ',', '.') }}</div></div></td>
        </tr>
    </table>

    <div class="overview-title">Ikhtisar Modul</div>
    <table class="module-table">
        <thead><tr><th>Modul</th><th class="number">Jumlah Item</th><th class="number">Status / Nilai</th></tr></thead>
        <tbody>
            <tr><td>Checklist</td><td class="number">{{ $mainChecklists->count() }}</td><td class="number">{{ $checklistCompleted }}/{{ $checklistTotal }} selesai</td></tr>
            <tr><td>Lamaran</td><td class="number">{{ $engagementItems->count() }}</td><td class="number">Rp {{ number_format($engagementItems->sum('cost_pria') + $engagementItems->sum('cost_wanita'), 0, ',', '.') }}</td></tr>
            <tr><td>Pre-Wedding</td><td class="number">{{ $preWeddingItems->count() }}</td><td class="number">Rp {{ number_format($preWeddingItems->sum('estimated_cost'), 0, ',', '.') }}</td></tr>
            <tr><td>Seserahan</td><td class="number">{{ $seserahanItems->count() }}</td><td class="number">Rp {{ number_format($seserahanItems->sum('estimated_cost'), 0, ',', '.') }}</td></tr>
            <tr><td>Administrasi</td><td class="number">{{ $administrationItems->count() }}</td><td class="number">{{ $administrationCompleted }}/{{ $administrationTotal }} siap</td></tr>
            <tr><td>Budget & Vendor</td><td class="number">{{ $budgetRows->count() }}</td><td class="number">Rp {{ number_format($budgetRows->sum('estimated_cost'), 0, ',', '.') }}</td></tr>
        </tbody>
    </table>

    <div class="section-header">
        <div class="section-kicker">Agenda</div>
        <div class="section-title">Rundown Hari H</div>
        <div class="section-description">Urutan acara, waktu, dan penanggung jawab.</div>
    </div>
    @if($rundowns->isEmpty())
        <div class="empty-state">Belum ada rundown acara.</div>
    @else
        <table class="items-table">
            <thead><tr><th style="width: 7%;">No.</th><th style="width: 16%;">Waktu</th><th style="width: 31%;">Kegiatan</th><th style="width: 21%;">PIC</th><th style="width: 25%;">Catatan</th></tr></thead>
            <tbody>
                @foreach($rundowns as $rundown)
                    <tr><td class="center">{{ $loop->iteration }}</td><td>{{ $rundown->time_start->format('H:i') }}@if($rundown->time_end) - {{ $rundown->time_end->format('H:i') }}@endif</td><td><span class="item-title">{{ $rundown->activity_name }}</span></td><td>{{ $rundown->person_in_charge ?: '-' }}</td><td>{{ $rundown->notes ?: '-' }}</td></tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <section class="page-break">

        <div class="section-header"><div class="section-kicker">Modul 01</div><div class="section-title">Checklist Persiapan</div><div class="section-description">{{ $checklistCompleted }} dari {{ $checklistTotal }} tugas selesai ({{ $checklistPercent }}%). Administrasi ditampilkan pada modul tersendiri.</div></div>
        @forelse($mainChecklists->groupBy('category_code') as $categoryCode => $items)
            <div class="group-title">{{ $items->first()->category_name }} - {{ $items->where('is_completed', true)->count() }}/{{ $items->count() }} selesai</div>
            <table class="items-table">
                <thead><tr><th style="width: 7%;">No.</th><th style="width: 68%;">Tugas</th><th style="width: 25%;">Status</th></tr></thead>
                <tbody>@foreach($items as $item)<tr><td class="center">{{ $loop->iteration }}</td><td><span class="item-title">{{ $item->title }}</span>@if($item->description)<div class="item-note">{{ $item->description }}</div>@endif</td><td><span class="status {{ $item->is_completed ? 'status-done' : 'status-pending' }}">{{ $item->is_completed ? 'Selesai' : 'Belum' }}</span></td></tr>@endforeach</tbody>
            </table>
        @empty
            <div class="empty-state">Belum ada checklist persiapan.</div>
        @endforelse
    </section>

    <section class="page-break">

        <div class="section-header"><div class="section-kicker">Modul 02</div><div class="section-title">Rencana Lamaran</div><div class="section-description">Pembagian biaya pihak pria dan wanita untuk setiap kebutuhan lamaran.</div></div>
        <div class="section-summary">Total Lamaran: Rp {{ number_format($engagementItems->sum('cost_pria') + $engagementItems->sum('cost_wanita'), 0, ',', '.') }}</div>
        @forelse($engagementItems->groupBy(fn ($item) => $item->subcategory ?: 'OTHER') as $groupCode => $items)
            <div class="group-title">{{ \App\Models\WeddingPlannerItem::ENGAGEMENT_GROUP_LABELS[$groupCode] ?? 'Lain-lain' }}</div>
            <table class="items-table">
                <thead><tr><th style="width: 31%;">Item</th><th class="number" style="width: 19%;">Pria</th><th class="number" style="width: 19%;">Wanita</th><th class="number" style="width: 19%;">Total</th><th style="width: 12%;">Status</th></tr></thead>
                <tbody>@foreach($items as $item)<tr><td><span class="item-title">{{ $item->title }}</span></td><td class="number">Rp {{ number_format($item->cost_pria, 0, ',', '.') }}</td><td class="number">Rp {{ number_format($item->cost_wanita, 0, ',', '.') }}</td><td class="number">Rp {{ number_format($item->cost_pria + $item->cost_wanita, 0, ',', '.') }}</td><td><span class="status {{ $statusClasses[$item->status] ?? 'status-pending' }}">{{ $statusLabels[$item->status] ?? $item->status }}</span></td></tr>@endforeach</tbody>
            </table>
        @empty
            <div class="empty-state">Belum ada rencana lamaran.</div>
        @endforelse
    </section>

    <section class="page-break">

        <div class="section-header"><div class="section-kicker">Modul 03</div><div class="section-title">Pre-Wedding</div><div class="section-description">Kebutuhan dokumentasi, anggaran, realisasi, dan progres pembayaran.</div></div>
        <div class="section-summary">Total Rencana: Rp {{ number_format($preWeddingItems->sum('estimated_cost'), 0, ',', '.') }} | Terbayar: Rp {{ number_format($preWeddingItems->sum('paid_amount'), 0, ',', '.') }}</div>
        @if($preWeddingItems->isEmpty())
            <div class="empty-state">Belum ada item pre-wedding.</div>
        @else
            <table class="items-table">
                <thead><tr><th style="width: 28%;">Item</th><th class="number" style="width: 18%;">Rencana</th><th class="number" style="width: 18%;">Realisasi</th><th class="number" style="width: 18%;">Terbayar</th><th style="width: 18%;">Status</th></tr></thead>
                <tbody>@foreach($preWeddingItems as $item)<tr><td><span class="item-title">{{ $item->title }}</span>@if($item->event_date)<div class="item-note">{{ $item->event_date->translatedFormat('d F Y') }}</div>@endif</td><td class="number">Rp {{ number_format($item->estimated_cost, 0, ',', '.') }}</td><td class="number">Rp {{ number_format($item->actual_cost, 0, ',', '.') }}</td><td class="number">Rp {{ number_format($item->paid_amount, 0, ',', '.') }}</td><td><span class="status {{ $statusClasses[$item->status] ?? 'status-pending' }}">{{ $statusLabels[$item->status] ?? $item->status }}</span></td></tr>@endforeach</tbody>
            </table>
        @endif
    </section>

    <section class="page-break">

        <div class="section-header"><div class="section-kicker">Modul 04</div><div class="section-title">Seserahan</div><div class="section-description">Daftar kebutuhan seserahan yang dikelompokkan berdasarkan pihak.</div></div>
        <div class="section-summary">Total Seserahan: Rp {{ number_format($seserahanItems->sum('estimated_cost'), 0, ',', '.') }}</div>
        @forelse($seserahanItems->groupBy(fn ($item) => $item->subcategory ?: 'OTHER') as $partyCode => $items)
            <div class="group-title">{{ \App\Models\WeddingPlannerItem::SESERAHAN_PARTIES[$partyCode] ?? 'Seserahan Lainnya' }}</div>
            <table class="items-table">
                <thead><tr><th style="width: 8%;">No.</th><th style="width: 52%;">Item</th><th class="number" style="width: 22%;">Rencana</th><th style="width: 18%;">Status</th></tr></thead>
                <tbody>@foreach($items as $item)<tr><td class="center">{{ $loop->iteration }}</td><td><span class="item-title">{{ $item->title }}</span>@if($item->description)<div class="item-note">{{ $item->description }}</div>@endif</td><td class="number">Rp {{ number_format($item->estimated_cost, 0, ',', '.') }}</td><td><span class="status {{ $statusClasses[$item->status] ?? 'status-pending' }}">{{ $statusLabels[$item->status] ?? $item->status }}</span></td></tr>@endforeach</tbody>
            </table>
        @empty
            <div class="empty-state">Belum ada daftar seserahan.</div>
        @endforelse
    </section>

    <section class="page-break">

        <div class="section-header"><div class="section-kicker">Modul 05</div><div class="section-title">Administrasi & Legal</div><div class="section-description">Kesiapan dokumen pihak pria dan wanita untuk keperluan pencatatan pernikahan.</div></div>
        <div class="section-summary">{{ $administrationCompleted }} dari {{ $administrationTotal }} centang dokumen siap ({{ $administrationPercent }}%).</div>
        @if($administrationItems->isEmpty())
            <div class="empty-state">Belum ada checklist administrasi.</div>
        @else
            <table class="items-table">
                <thead><tr><th style="width: 7%;">No.</th><th style="width: 57%;">Dokumen / Tugas</th><th class="center" style="width: 18%;">Pria</th><th class="center" style="width: 18%;">Wanita</th></tr></thead>
                <tbody>
                    @foreach($administrationItems as $item)
                        <tr><td class="center">{{ $loop->iteration }}</td><td><span class="item-title">{{ $item->title }}</span></td>@if($item->is_document)<td class="center"><span class="status {{ $item->is_completed_pria ? 'status-done' : 'status-pending' }}">{{ $item->is_completed_pria ? 'Siap' : 'Belum' }}</span></td><td class="center"><span class="status {{ $item->is_completed_wanita ? 'status-done' : 'status-pending' }}">{{ $item->is_completed_wanita ? 'Siap' : 'Belum' }}</span></td>@else<td colspan="2" class="center"><span class="status {{ $item->is_completed ? 'status-done' : 'status-pending' }}">{{ $item->is_completed ? 'Selesai' : 'Belum' }}</span></td>@endif</tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </section>

    <section class="page-break">

        <div class="section-header"><div class="section-kicker">Modul 06</div><div class="section-title">Budget & Vendor</div><div class="section-description">Ringkasan rencana biaya, realisasi, pembayaran, dan sisa kebutuhan.</div></div>
        <div class="section-summary">Total Rencana: Rp {{ number_format($budgetRows->sum('estimated_cost'), 0, ',', '.') }} | Terbayar: Rp {{ number_format($budgetRows->sum('paid_amount'), 0, ',', '.') }}</div>
        @if($budgetRows->isEmpty())
            <div class="empty-state">Belum ada item budget atau vendor.</div>
        @else
            <table class="items-table">
                <thead><tr><th style="width: 26%;">Item</th><th style="width: 10%;">Jenis</th><th class="number" style="width: 16%;">Rencana</th><th class="number" style="width: 16%;">Realisasi</th><th class="number" style="width: 16%;">Terbayar</th><th class="number" style="width: 16%;">Sisa</th></tr></thead>
                <tbody>@foreach($budgetRows as $item)<tr><td><span class="item-title">{{ $item->title }}</span>@if($item->vendor_contact)<div class="item-note">{{ $item->vendor_contact }}</div>@endif</td><td>{{ $item->category === 'VENDOR' ? 'Vendor' : 'Budget' }}</td><td class="number">Rp {{ number_format($item->estimated_cost, 0, ',', '.') }}</td><td class="number">Rp {{ number_format($item->actual_cost, 0, ',', '.') }}</td><td class="number">Rp {{ number_format($item->paid_amount, 0, ',', '.') }}</td><td class="number">Rp {{ number_format(max(0, $item->estimated_cost - $item->paid_amount), 0, ',', '.') }}</td></tr>@endforeach</tbody>
            </table>
            <div class="totals-wrap"><table class="totals-table"><tr><td>Total Rencana</td><td>Rp {{ number_format($budgetRows->sum('estimated_cost'), 0, ',', '.') }}</td></tr><tr><td>Total Realisasi</td><td>Rp {{ number_format($budgetRows->sum('actual_cost'), 0, ',', '.') }}</td></tr><tr><td>Total Terbayar</td><td>Rp {{ number_format($budgetRows->sum('paid_amount'), 0, ',', '.') }}</td></tr><tr class="grand-total"><td>Sisa Rencana</td><td>Rp {{ number_format(max(0, $budgetRows->sum('estimated_cost') - $budgetRows->sum('paid_amount')), 0, ',', '.') }}</td></tr></table></div>
        @endif
    </section>
    </main>
</body>
</html>
