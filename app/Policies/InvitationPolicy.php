<?php

namespace App\Policies;

use App\Models\Invitation;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class InvitationPolicy
{
    public function before(User $user, string $ability): bool|null
    {
        if ($user->isSuperAdmin()) {
            return true;
        }

        return null;
    }

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Invitation $invitation): bool
    {
        return $user->id === $invitation->user_id;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Invitation $invitation): bool
    {
        return $user->id === $invitation->user_id;
    }

    public function delete(User $user, Invitation $invitation): bool
    {
        return $user->id === $invitation->user_id;
    }

    public function restore(User $user, Invitation $invitation): bool
    {
        return $user->id === $invitation->user_id;
    }

    public function forceDelete(User $user, Invitation $invitation): bool
    {
        return $user->id === $invitation->user_id;
    }
}
