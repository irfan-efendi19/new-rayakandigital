<?php

namespace App\Services;

use App\Models\PaymentMethodConfig;

class PaymentRoutingService
{
    protected ?PaymentMethodConfig $config = null;

    public function config(): PaymentMethodConfig
    {
        if (!$this->config) {
            $this->config = PaymentMethodConfig::getActive();

            if (!$this->config) {
                $this->config = PaymentMethodConfig::create([
                    'active_method' => 'manual_bank',
                ]);
            }
        }

        return $this->config;
    }

    public function isManualBank(): bool
    {
        return $this->config()->isManualBank();
    }

    public function isMidtrans(): bool
    {
        return $this->config()->isMidtrans();
    }

    public function activeMethod(): string
    {
        return $this->config()->active_method;
    }

    public function getAdminWhatsappNumber(): ?string
    {
        return $this->config()->admin_whatsapp_number;
    }

    public function getBankName(): ?string
    {
        return $this->config()->manual_bank_name;
    }

    public function getBankAccountNumber(): ?string
    {
        return $this->config()->manual_account_number;
    }

    public function getBankAccountHolder(): ?string
    {
        return $this->config()->manual_account_name;
    }

    public function isMidtransConfigured(): bool
    {
        $cfg = $this->config();
        return !empty($cfg->midtrans_client_key) && !empty($cfg->midtrans_server_key);
    }

    public function isManualBankConfigured(): bool
    {
        $cfg = $this->config();
        return !empty($cfg->manual_bank_name)
            && !empty($cfg->manual_account_number)
            && !empty($cfg->admin_whatsapp_number);
    }
}
