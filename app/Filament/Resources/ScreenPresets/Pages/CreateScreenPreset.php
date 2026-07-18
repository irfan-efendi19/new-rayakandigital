<?php

namespace App\Filament\Resources\ScreenPresets\Pages;

use App\Filament\Resources\ScreenPresets\ScreenPresetResource;
use App\Services\ScreenPresetUploaderService;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;
use Illuminate\Validation\ValidationException;

class CreateScreenPreset extends CreateRecord
{
    protected static string $resource = ScreenPresetResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $zipFilePath = $data['zip_file'] ?? null;

        if (!$zipFilePath) {
            throw ValidationException::withMessages([
                'zip_file' => 'File ZIP wajib diunggah.',
            ]);
        }

        try {
            $uploader = app(ScreenPresetUploaderService::class);
            $result = $uploader->deploy($zipFilePath, $data['name']);

            $data['html_content'] = $result['html_content'];
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
