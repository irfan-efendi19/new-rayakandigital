<?php

namespace App\Filament\Resources\ScreenPresets\Pages;

use App\Filament\Resources\ScreenPresets\ScreenPresetResource;
use App\Services\ScreenPresetUploaderService;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;

class EditScreenPreset extends EditRecord
{
    protected static string $resource = ScreenPresetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $zipFilePath = $data['zip_file_edit'] ?? null;

        if ($zipFilePath) {
            try {
                $uploader = app(ScreenPresetUploaderService::class);
                $result = $uploader->deploy($zipFilePath, $data['name']);

                $data['html_content'] = $result['html_content'];
                $data['zip_path'] = $result['zip_path'];
            } catch (\Exception $e) {
                Notification::make()
                    ->title('Gagal Mengunggah')
                    ->body($e->getMessage())
                    ->danger()
                    ->send();

                $this->halt();
            }
        }

        unset($data['zip_file_edit'], $data['zip_file']);

        return $data;
    }
}
