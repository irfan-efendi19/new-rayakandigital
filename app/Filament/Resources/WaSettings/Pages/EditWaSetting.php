<?php

namespace App\Filament\Resources\WaSettings\Pages;

use App\Filament\Resources\WaSettings\WaSettingResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditWaSetting extends EditRecord
{
    protected static string $resource = WaSettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
