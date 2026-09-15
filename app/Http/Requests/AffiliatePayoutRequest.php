<?php

namespace App\Http\Requests;

class AffiliatePayoutRequest extends AffiliateBankRequest
{
    public function rules(): array
    {
        return ['amount' => ['required', 'integer', 'min:1', 'max:100000000000']];
    }
}
