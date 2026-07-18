<?php

namespace App\Filament\Resources\ScreenPresets\Pages;

use App\Filament\Resources\ScreenPresets\ScreenPresetResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListScreenPresets extends ListRecords
{
    protected static string $resource = ScreenPresetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
