<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class AffiliatePayoutRequest extends AffiliateBankRequest
{
    public function rules(): array
    {
        return [
            'amount' => [Rule::requiredIf(! $this->boolean('withdraw_all')), 'nullable', 'integer', 'min:1', 'max:100000000000'],
            'withdraw_all' => ['nullable', 'boolean'],
        ];
    }
}
