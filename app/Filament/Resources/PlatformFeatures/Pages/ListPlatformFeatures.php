<?php

namespace App\Filament\Resources\PlatformFeatures\Pages;

use App\Filament\Resources\PlatformFeatures\PlatformFeatureResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPlatformFeatures extends ListRecords
{
    protected static string $resource = PlatformFeatureResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
