<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AffiliateBankRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null && ! $this->user()->is_banned && $this->user()->affiliate()->eligible()->exists();
    }

    public static function bankRules(): array
    {
        return [
            'bank_name' => ['required', 'string', 'max:100'],
            'bank_account_number' => ['required', 'string', 'regex:/^[0-9]{5,30}$/'],
            'bank_account_holder' => ['required', 'string', 'max:150'],
        ];
    }

    public function rules(): array
    {
        return static::bankRules();
    }
}
