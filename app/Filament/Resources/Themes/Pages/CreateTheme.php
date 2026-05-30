<?php

namespace App\Filament\Resources\Themes\Pages;

use App\Filament\Resources\Themes\ThemeResource;
use App\Services\ThemeUploaderService;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;
use Illuminate\Validation\ValidationException;

class CreateTheme extends CreateRecord
{
    protected static string $resource = ThemeResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $zipFilePath = $data['zip_file'] ?? null;

        if (!$zipFilePath) {
            throw ValidationException::withMessages([
                'zip_file' => 'A ZIP file is required.',
            ]);
        }

        try {
            $uploader = app(ThemeUploaderService::class);
            $viewPath = $uploader->deploy($zipFilePath, $data['name']);
            
            $data['view_path'] = $viewPath;
            unset($data['zip_file']); // Don't try to save this to DB
            
            return $data;
        } catch (\Exception $e) {
            Notification::make()
                ->title('Upload Failed')
                ->body($e->getMessage())
                ->danger()
                ->send();

            $this->halt(); // Stop the creation process
        }
    }
}
