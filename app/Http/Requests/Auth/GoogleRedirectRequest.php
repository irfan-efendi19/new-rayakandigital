<?php

namespace App\Http\Requests\Auth;

use App\Models\Theme;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class GoogleRedirectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'theme_id' => ['nullable', 'integer', 'min:1'],
            'theme' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function selectedTheme(): ?Theme
    {
        $data = $this->validated();
        $query = Theme::query()->where('is_active', true);

        if (isset($data['theme_id'])) {
            return $query->find($data['theme_id']);
        }

        return isset($data['theme'])
            ? $query->where('view_path', 'themes.'.$data['theme'])->first()
            : null;
    }
}
