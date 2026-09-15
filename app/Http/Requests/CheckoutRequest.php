<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CheckoutRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'tier' => ['required', 'string', Rule::exists('packages', 'package_code')->where('is_visible', true)],
            'invitation_id' => ['nullable', 'integer', 'exists:invitations,id'],
            'promotion_code' => ['nullable', 'string', 'max:50'],
            'expected_amount' => ['nullable', 'integer', 'min:0'],
        ];
    }
}
