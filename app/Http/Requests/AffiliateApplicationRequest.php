<?php

namespace App\Http\Requests;

use App\Models\Affiliate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AffiliateApplicationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null && ! $this->user()->is_banned;
    }

    public function rules(): array
    {
        return [
            'business_name' => ['required', 'string', 'max:150'],
            'partner_type' => ['required', Rule::in(array_keys(Affiliate::TYPES))],
            'phone' => ['required', 'string', 'regex:/^\+?[0-9]{9,20}$/'],
            ...AffiliateBankRequest::bankRules(),
        ];
    }
}
