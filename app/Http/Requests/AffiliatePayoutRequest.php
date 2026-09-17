<?php

namespace App\Http\Requests;

use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AffiliatePayoutRequest extends AffiliateBankRequest
{
    protected function prepareForValidation(): void
    {
        if (is_string($this->input('amount'))) {
            $rawAmount = $this->input('amount');
            $digits = Str::of($rawAmount)->replaceMatches('/\D+/', '')->toString();

            $this->merge([
                'amount' => Str::contains($rawAmount, '-') ? '-'.$digits : $digits,
            ]);
        }
    }

    public function rules(): array
    {
        return [
            'amount' => [Rule::requiredIf(! $this->boolean('withdraw_all')), 'nullable', 'integer', 'min:1', 'max:100000000000'],
            'withdraw_all' => ['nullable', 'boolean'],
        ];
    }
}
