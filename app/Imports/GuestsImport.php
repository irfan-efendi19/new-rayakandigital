<?php

namespace App\Imports;

use App\Models\Guest;
use App\Models\GuestCategory;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;

class GuestsImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure
{
    use Importable, SkipsFailures;

    protected $invitationId;
    protected $imported = 0;
    protected $skipped = 0;

    public function __construct(int $invitationId)
    {
        $this->invitationId = $invitationId;
    }

    public function model(array $row)
    {
        $whatsapp = $this->normalizeWhatsapp($row['nomor_whatsapp'] ?? null);

        $categoryId = null;
        $categoryName = trim($row['kategori'] ?? '');

        if ($categoryName !== '') {
            $category = GuestCategory::firstOrCreate([
                'invitation_id' => $this->invitationId,
                'name' => $categoryName,
            ]);
            $categoryId = $category->id;
        }

        $name = trim($row['nama_tamu']);

        $guest = Guest::updateOrCreate(
            [
                'invitation_id' => $this->invitationId,
                'name' => $name,
                'whatsapp_number' => $whatsapp,
            ],
            [
                'guest_category_id' => $categoryId,
                'phone' => $whatsapp,
            ]
        );

        if ($guest->wasRecentlyCreated) {
            $this->imported++;
        } else {
            $this->skipped++;
        }

        return $guest;
    }

    public function rules(): array
    {
        return [
            'nama_tamu' => 'required|max:255',
            'nomor_whatsapp' => 'nullable|max:20',
            'kategori' => 'nullable|max:50',
        ];
    }

    public function getImportedCount(): int
    {
        return $this->imported;
    }

    public function getSkippedCount(): int
    {
        return $this->skipped;
    }

    private function normalizeWhatsapp(mixed $number): ?string
    {
        if ($number === null) {
            return null;
        }

        $number = (string) $number;

        if (trim($number) === '') {
            return null;
        }

        $number = preg_replace('/[^0-9]/', '', $number);

        if (str_starts_with($number, '08')) {
            return '628' . substr($number, 2);
        }

        if (str_starts_with($number, '8')) {
            return '628' . substr($number, 1);
        }

        return $number;
    }
}
