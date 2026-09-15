<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class ProfileDeletionRequest extends FormRequest
{
    /**
     * The error bag used by the account deletion modal.
     *
     * @var string
     */
    protected $errorBag = 'userDeletion';

    public function after(): array
    {
        return [
            function (Validator $validator): void {
                if ($this->user()->hasAffiliateRecords()) {
                    $field = filled($this->user()->google_id) ? 'email_confirmation' : 'password';
                    $validator->errors()->add($field, 'Akun memiliki catatan kemitraan atau komisi. Hubungi admin untuk penutupan akun dan penyelesaian riwayat transaksi.');
                }
            },
        ];
    }

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
