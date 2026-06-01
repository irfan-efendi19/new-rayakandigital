<?php

namespace App\Filament\Resources\ThemeCategories\Pages;

use App\Filament\Resources\ThemeCategories\ThemeCategoryResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditThemeCategory extends EditRecord
{
    protected static string $resource = ThemeCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
