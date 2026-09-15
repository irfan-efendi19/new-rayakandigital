<?php

namespace App\Http\Requests;

use App\Models\AffiliateLink;
use Illuminate\Validation\Rule;

class AffiliateLinkRequest extends AffiliateBankRequest
{
    protected function prepareForValidation(): void
    {
        if (is_string($this->input('slug'))) {
            $this->merge(['slug' => mb_strtolower(trim($this->input('slug')))]);
        }
    }

    public function rules(): array
    {
        return [
            'label' => ['required', 'string', 'max:100'],
            'slug' => ['required', 'string', 'min:3', 'max:60', 'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/', 'unique:affiliate_links,slug'],
            'destination' => ['required', Rule::in(array_keys(AffiliateLink::DESTINATIONS))],
        ];
    }
}
