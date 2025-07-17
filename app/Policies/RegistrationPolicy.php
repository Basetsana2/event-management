<?php

namespace App\Policies;

use App\Models\Registration;
use App\Models\User;

class RegistrationPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->role === 'organizer';
    }

    public function update(User $user, Registration $registration): bool
    {
        return $user->id === $registration->event->user_id;
    }
}
