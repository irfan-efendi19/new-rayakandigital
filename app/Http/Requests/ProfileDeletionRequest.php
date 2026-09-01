<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileDeletionRequest extends FormRequest
{
    /**
     * The error bag used by the account deletion modal.
     *
     * @var string
     */
    protected $errorBag = 'userDeletion';

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        if (filled($this->user()->google_id)) {
            return [
                'email_confirmation' => [
                    'required',
                    'string',
                    Rule::in([$this->user()->email]),
                ],
            ];
        }

        return [
            'password' => ['required', 'current_password'],
        ];
    }

    /**
     * Get the validation error messages.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'email_confirmation.required' => 'Masukkan alamat email akun Anda untuk melanjutkan.',
            'email_confirmation.in' => 'Alamat email yang dimasukkan tidak sesuai dengan akun Anda.',
        ];
    }
}
