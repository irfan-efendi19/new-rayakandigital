<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\GoogleRedirectRequest;
use App\Models\Theme;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    public function redirectToGoogle(GoogleRedirectRequest $request): RedirectResponse
    {
        return Socialite::driver('google')
            ->withThemeId($request->selectedTheme()?->id)
            ->redirect();
    }

    public function handleGoogleCallback(Request $request): RedirectResponse
    {
        try {
            if ($request->has('error') || ! is_string($request->input('state'))) {
                throw new \RuntimeException('Google authorization was not completed.');
            }

            $provider = Socialite::driver('google');
            $googleUser = $provider->user();
            $themeId = $provider->themeIdFromState();
        } catch (\Exception $e) {
            $request->session()->forget('state');

            return redirect()->route('login')->withErrors([
                'email' => 'Login dengan Google gagal. Silakan coba lagi.',
            ]);
        }

        $theme = Theme::query()->where('is_active', true)->find($themeId);
        $user = User::where('email', $googleUser->getEmail())->first();

        if ($user) {
            if (is_null($user->google_id)) {
                $user->update([
                    'google_id' => $googleUser->getId(),
                    'google_token' => $googleUser->token,
                    'google_refresh_token' => $googleUser->refreshToken,
                    'avatar' => $googleUser->getAvatar(),
                ]);
            }

            if (! $user->hasInvitation() && $theme) {
                $user->update(['theme_id' => $theme->id]);
            }
        } else {
            $user = User::create([
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'google_id' => $googleUser->getId(),
                'google_token' => $googleUser->token,
                'google_refresh_token' => $googleUser->refreshToken,
                'avatar' => $googleUser->getAvatar(),
                'password' => Hash::make(Str::random(32)),
                'theme_id' => ($theme ?? Theme::defaultForRegistration())?->id,
            ]);
        }

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->intended(route('dashboard', absolute: false));
    }
}
