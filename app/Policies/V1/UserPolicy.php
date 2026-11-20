<?php

namespace App\Policies\V1;

use App\Models\User;
use App\Permissions\V1\Abilities;

class UserPolicy
{
    // May the logged-in user create a new user?
    public function store(User $user): bool
    {
        return $user->tokenCan(Abilities::CreateUser);
    }

    // May the logged-in user update the user model?
    public function update(User $user, User $model): bool
    {
        return $user->tokenCan(Abilities::UpdateUser);
    }

    // May the logged-in user replace the user model?
    public function replace(User $user, User $model): bool
    {
        return $user->tokenCan(Abilities::ReplaceUser);
    }

    // May the logged-in user delete the user model?
    public function delete(User $user, User $model): bool
    {
        return $user->tokenCan(Abilities::DeleteUser);
    }
}
