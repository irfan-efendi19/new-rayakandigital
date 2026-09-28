<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateWelcomeScreenRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $invitation = $this->route('invitation');

        return $this->user()?->can('update', $invitation) && $invitation->hasFeature('qr_checkin');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'screen_bride_names' => ['nullable', 'string', 'max:255'],
            'screen_background_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'extensions:jpg,jpeg,png,webp', 'max:10240', 'prohibits:screen_background_video'],
            'screen_background_video' => ['nullable', 'file', 'mimetypes:video/mp4,video/webm', 'extensions:mp4,webm', 'max:51200', 'prohibits:screen_background_image'],
            'screen_gallery_photos' => ['nullable', 'array', 'max:50'],
            'screen_gallery_photos.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'extensions:jpg,jpeg,png,webp', 'max:10240'],
            'remove_background' => ['nullable', 'boolean'],
            'selected_theme' => ['nullable', 'string', Rule::exists('screen_presets', 'slug')->where('is_active', true)],
            'custom_title' => ['nullable', 'string', 'max:255'],
            'show_wishes_wall' => ['nullable', 'boolean'],
        ];
    }
}
