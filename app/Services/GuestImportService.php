<?php

namespace App\Services;

use App\Imports\GuestsImport;
use App\Models\Invitation;
use Illuminate\Http\UploadedFile;
use Maatwebsite\Excel\Facades\Excel;

class GuestImportService
{
    public function import(Invitation $invitation, UploadedFile $file): array
    {
        $import = new GuestsImport($invitation->id);

        try {
            Excel::import($import, $file);
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $errors = [];
            foreach ($e->failures() as $failure) {
                $errors[] = "Baris {$failure->row()}: " . implode(', ', $failure->errors());
            }

            return [
                'imported' => $import->getImportedCount(),
                'skipped' => $import->getSkippedCount(),
                'errors' => $errors,
            ];
        } catch (\Exception $e) {
            return [
                'imported' => 0,
                'skipped' => 0,
                'errors' => [$e->getMessage()],
            ];
        }

        $errors = [];
        foreach ($import->failures() as $failure) {
            $errors[] = "Baris {$failure->row()}, kolom {$failure->attribute()}: " . implode(', ', $failure->errors());
        }

        $imported = $import->getImportedCount();
        $skipped = $import->getSkippedCount();

        return [
            'imported' => $imported,
            'skipped' => $skipped + count($errors),
            'errors' => $errors,
        ];
    }
}
