<?php

namespace App\Auth;

use Illuminate\Support\Facades\Crypt;
use Laravel\Socialite\Two\GoogleProvider as SocialiteGoogleProvider;

class GoogleProvider extends SocialiteGoogleProvider
{
    private ?int $themeId = null;

    public function withThemeId(?int $themeId): static
    {
        $this->themeId = $themeId;

        return $this;
    }

    protected function getState(): string
    {
        return Crypt::encryptString(json_encode([
            'nonce' => parent::getState(),
            'theme_id' => $this->themeId,
        ], JSON_THROW_ON_ERROR));
    }

    public function themeIdFromState(): ?int
    {
        $state = json_decode(
            Crypt::decryptString($this->request->input('state')),
            true,
            flags: JSON_THROW_ON_ERROR,
        );

        return $state['theme_id'] ?? null;
    }
}
