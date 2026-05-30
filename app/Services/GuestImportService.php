<?php

namespace App\Services;

use App\Models\Invitation;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class GuestImportService
{
    /**
     * Import guests from a CSV/Excel file.
     *
     * @return array{imported: int, skipped: int, errors: array<string>}
     */
    public function import(Invitation $invitation, UploadedFile $file): array
    {
        $imported = 0;
        $skipped = 0;
        $errors = [];

        $handle = fopen($file->getRealPath(), 'r');

        if ($handle === false) {
            return ['imported' => 0, 'skipped' => 0, 'errors' => ['Gagal membaca file.']];
        }

        $header = fgetcsv($handle);

        if ($header === false) {
            fclose($handle);

            return ['imported' => 0, 'skipped' => 0, 'errors' => ['File kosong atau format tidak valid.']];
        }

        // Normalize headers
        $header = array_map(fn ($h) => strtolower(trim($h)), $header);
        $nameIndex = $this->findColumnIndex($header, ['nama', 'name', 'nama tamu', 'guest name']);
        $phoneIndex = $this->findColumnIndex($header, ['phone', 'telepon', 'no hp', 'no telp', 'nomor hp', 'whatsapp', 'wa']);

        if ($nameIndex === null) {
            fclose($handle);

            return ['imported' => 0, 'skipped' => 0, 'errors' => ['Kolom "Nama" tidak ditemukan di header file. Pastikan ada kolom dengan header: Nama, Name, atau Nama Tamu.']];
        }

        $rowNumber = 1;
        $existingNames = $invitation->guests()->pluck('name')->map(fn ($n) => strtolower(trim($n)))->toArray();

        while (($row = fgetcsv($handle)) !== false) {
            $rowNumber++;
            $name = trim($row[$nameIndex] ?? '');

            if (empty($name)) {
                $skipped++;

                continue;
            }

            if (in_array(strtolower($name), $existingNames)) {
                $skipped++;
                $errors[] = "Baris {$rowNumber}: \"{$name}\" sudah ada, dilewati.";

                continue;
            }

            $phone = $phoneIndex !== null ? trim($row[$phoneIndex] ?? '') : null;

            try {
                $invitation->guests()->create([
                    'name' => $name,
                    'slug' => Str::slug($name, '_'),
                    'phone' => $phone ?: null,
                ]);
                $existingNames[] = strtolower($name);
                $imported++;
            } catch (\Exception $e) {
                $skipped++;
                $errors[] = "Baris {$rowNumber}: Gagal import \"{$name}\".";
            }
        }

        fclose($handle);

        return [
            'imported' => $imported,
            'skipped' => $skipped,
            'errors' => $errors,
        ];
    }

    /**
     * @param  array<string>  $headers
     * @param  array<string>  $possibleNames
     */
    private function findColumnIndex(array $headers, array $possibleNames): ?int
    {
        foreach ($possibleNames as $possibleName) {
            $index = array_search(strtolower($possibleName), $headers);
            if ($index !== false) {
                return $index;
            }
        }

        return null;
    }
}
