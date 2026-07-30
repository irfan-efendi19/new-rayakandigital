<?php

namespace App\Filament\Resources\WaSettings\Pages;

use App\Filament\Resources\WaSettings\WaSettingResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListWaSettings extends ListRecords
{
    protected static string $resource = WaSettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
