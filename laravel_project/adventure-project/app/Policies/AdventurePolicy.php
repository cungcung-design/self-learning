<?php

namespace App\Policies;

use App\Models\Adventure;
use App\Models\User;

class AdventurePolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Adventure $adventure): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    public function update(User $user, Adventure $adventure): bool
    {
        return $user->isAdmin();
    }

    public function delete(User $user, Adventure $adventure): bool
    {
        return $user->isAdmin();
    }
}
