<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Graduation;
use App\Models\User;

class GraduationPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    public function view(User $user, Graduation $graduation): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return $graduation->students()
            ->where('user_id', $user->id)
            ->exists();
    }

    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    public function update(User $user, Graduation $graduation): bool
    {
        return $user->isAdmin();
    }

    public function delete(User $user, Graduation $graduation): bool
    {
        if (! $user->isAdmin()) {
            return false;
        }

        return $graduation->students()
            ->whereNotNull('paid_at')
            ->doesntExist();
    }

    public function restore(User $user, Graduation $graduation): bool
    {
        return $user->isAdmin();
    }
}
