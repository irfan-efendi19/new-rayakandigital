<?php

namespace App\Filament\Resources\MarketingAssets\Pages;

use App\Filament\Resources\MarketingAssetResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageMarketingAssets extends ManageRecords
{
    protected static string $resource = MarketingAssetResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()];
    }
}
