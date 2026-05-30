<?php

namespace App\Filament\Resources\PaymentMethodConfigs\Pages;

use App\Filament\Resources\PaymentMethodConfigs\PaymentMethodConfigResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPaymentMethodConfig extends EditRecord
{
    protected static string $resource = PaymentMethodConfigResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
