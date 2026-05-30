<?php

namespace App\Filament\Resources\PaymentMethodConfigs\Pages;

use App\Filament\Resources\PaymentMethodConfigs\PaymentMethodConfigResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPaymentMethodConfigs extends ListRecords
{
    protected static string $resource = PaymentMethodConfigResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
