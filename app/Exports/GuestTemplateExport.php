<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class GuestTemplateExport implements FromArray, WithHeadings, WithStyles
{
    public function array(): array
    {
        return [
            ['Rina Wijaya', '081234567890', 'Keluarga', 'Akad Nikah|Resepsi'],
            ['Bambang Santoso', '+628123456789', 'Keluarga', 'Akad Nikah'],
            ['Dewi Lestari', '081298765432', 'Teman', 'Resepsi'],
            ['Ahmad Fauzi', '628123456788', 'Rekan Kerja', ''],
        ];
    }

    public function headings(): array
    {
        return [
            'Nama Tamu',
            'Nomor WhatsApp',
            'Kategori',
            'Acara',
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'FFF3E0'],
                ],
            ],
        ];
    }
}
