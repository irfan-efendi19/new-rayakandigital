<?php

namespace App\Filament\Resources\ScreenPresets\Pages;

use App\Filament\Resources\ScreenPresets\ScreenPresetResource;
use App\Services\ScreenPresetUploaderService;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Validation\ValidationException;

class CreateScreenPreset extends CreateRecord
{
    protected static string $resource = ScreenPresetResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $zipFilePath = $data['zip_file'] ?? null;

        if (! $zipFilePath) {
            throw ValidationException::withMessages([
                'zip_file' => 'File ZIP wajib diunggah.',
            ]);
        }

        try {
            $uploader = app(ScreenPresetUploaderService::class);
            $result = $uploader->deploy($zipFilePath, $data['name']);

            // PRD §2: simpan storage_path, bukan html_content
            $data['storage_path'] = $result['storage_path'];
            $data['zip_path'] = $result['zip_path'];
            unset($data['zip_file']);

            return $data;
        } catch (\Exception $e) {
            Notification::make()
                ->title('Gagal Mengunggah')
                ->body($e->getMessage())
                ->danger()
                ->send();

            $this->halt();
        }
    }
}
