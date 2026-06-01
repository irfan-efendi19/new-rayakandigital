<?php

namespace App\Filament\Resources\ThemeCategories\Pages;

use App\Filament\Resources\ThemeCategories\ThemeCategoryResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListThemeCategories extends ListRecords
{
    protected static string $resource = ThemeCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
