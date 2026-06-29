<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

class ResetPassword extends Notification implements ShouldQueue
{
    use Queueable;

    public string $token;

    public function __construct(string $token)
    {
        $this->token = $token;
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): \Illuminate\Notifications\Messages\MailMessage
    {
        $url = url(route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));

        $expire = config('auth.passwords.' . config('auth.defaults.passwords') . '.expire');

        return (new \Illuminate\Notifications\Messages\MailMessage)
            ->subject('Reset Kata Sandi - Rayakan Digital')
            ->view('emails.forgot-password', [
                'resetUrl' => $url,
                'expire' => $expire,
                'user' => $notifiable,
                'appName' => config('app.name'),
            ]);
    }

    public function toArray(object $notifiable): array
    {
        return [];
    }
}
