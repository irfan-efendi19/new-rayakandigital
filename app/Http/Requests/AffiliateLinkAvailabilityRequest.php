<?php

namespace App\Http\Requests;

use App\Models\AffiliateLink;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AffiliateLinkAvailabilityRequest extends AffiliateBankRequest
{
    protected function prepareForValidation(): void
    {
        if (is_string($this->input('slug'))) {
            $this->merge([
                'slug' => Str::of($this->input('slug'))->trim()->lower()->toString(),
            ]);
        }
    }

    public function rules(): array
    {
        $affiliateId = $this->user()?->affiliate()->eligible()->value('id');

        return [
            'slug' => ['required', 'string', 'min:3', 'max:60', 'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/'],
            'ignore_link_id' => [
                'nullable',
                'integer',
                Rule::exists((new AffiliateLink)->getTable(), 'id')
                    ->where(fn (Builder $query) => $query->where('affiliate_id', $affiliateId)),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'slug.regex' => 'Alamat link hanya boleh berisi huruf kecil, angka, dan tanda hubung.',
            'ignore_link_id.exists' => 'Link yang dikecualikan tidak ditemukan.',
        ];
    }
}
