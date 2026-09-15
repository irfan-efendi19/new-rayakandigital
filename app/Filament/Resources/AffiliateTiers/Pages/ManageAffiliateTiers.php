<?php

namespace App\Filament\Resources\AffiliateTiers\Pages;

use App\Filament\Resources\AffiliateTierResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageAffiliateTiers extends ManageRecords
{
    protected static string $resource = AffiliateTierResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()];
    }
}
