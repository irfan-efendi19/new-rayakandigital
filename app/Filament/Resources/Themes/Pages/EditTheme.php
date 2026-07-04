<?php

namespace App\Filament\Resources\Themes\Pages;

use App\Filament\Resources\Themes\ThemeResource;
use App\Models\ThemePreviewData;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditTheme extends EditRecord
{
    protected static string $resource = ThemeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $preview = $this->record->previewData;

        if ($preview) {
            $data = array_merge($data, $preview->toFormData());
        }

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $this->previewFormData = ThemePreviewData::fromFormData($data);

        foreach (array_values(ThemePreviewData::FORM_FIELD_MAP) as $formField) {
            unset($data[$formField]);
        }

        return $data;
    }

    protected function afterSave(): void
    {
        if (! isset($this->previewFormData)) {
            return;
        }

        ThemePreviewData::updateOrCreate(
            ['theme_id' => $this->record->id],
            $this->previewFormData,
        );
    }

    /** @var array<string, mixed> */
    protected array $previewFormData = [];
}
