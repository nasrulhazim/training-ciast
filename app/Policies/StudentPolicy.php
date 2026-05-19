<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Student;
use App\Models\User;

class StudentPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    public function view(User $user, Student $student): bool
    {
        return $user->isAdmin() || $student->user_id === $user->id;
    }

    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    public function update(User $user, Student $student): bool
    {
        return $user->isAdmin() || $student->user_id === $user->id;
    }

    public function delete(User $user, Student $student): bool
    {
        return $user->isAdmin();
    }

    public function verify(User $user, Student $student): bool
    {
        return $user->isAdmin() && $student->payment_receipt !== null;
    }
}
