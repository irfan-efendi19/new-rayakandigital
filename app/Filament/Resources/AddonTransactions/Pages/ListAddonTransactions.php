<?php

namespace App\Filament\Resources\AddonTransactions\Pages;

use App\Filament\Resources\AddonTransactions\AddonTransactionResource;
use Filament\Resources\Pages\ListRecords;

class ListAddonTransactions extends ListRecords
{
    protected static string $resource = AddonTransactionResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
