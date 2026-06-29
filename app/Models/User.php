<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Notifications\ResetPassword;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;

#[Fillable(['name', 'email', 'password', 'role', 'is_banned', 'is_super_admin', 'google_id', 'google_token', 'google_refresh_token', 'avatar'])]
#[Hidden(['password', 'remember_token', 'google_token', 'google_refresh_token'])]
class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->isAdmin() && !$this->is_banned;
    }

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_banned' => 'boolean',
            'is_super_admin' => 'boolean',
        ];
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function getIsAdminAttribute(): bool
    {
        return $this->isAdmin();
    }

    public function isSuperAdmin(): bool
    {
        return $this->isAdmin() && ($this->getAttribute('is_super_admin') ?? false);
    }

    public function getIsSuperAdminAttribute(): bool
    {
        return $this->isSuperAdmin();
    }

    public function invitations(): HasMany
    {
        return $this->hasMany(Invitation::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    public function sendPasswordResetNotification(#[\SensitiveParameter] $token): void
    {
        $this->notify(new ResetPassword($token));
    }

}
