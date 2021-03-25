<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $auth): bool
    {
        return true;
    }

    public function view(User $auth, User $user): bool
    {
        return true;
    }

    public function create(User $auth): bool
    {
        return false;
    }

    public function update(User $auth, User $user): bool
    {
        return false;
    }

    public function delete(User $auth, User $user): bool
    {
        return false;
    }

    public function restore(User $auth, User $user): bool
    {
        return false;
    }

    public function forceDelete(User $auth, User $user): bool
    {
        return false;
    }

    public function attachAnyOrganization(User $auth, User $user): bool
    {
        return false;
    }

    public function attachAnyRepository(User $auth, User $user): bool
    {
        return false;
    }

    public function block(User $auth, User $user): bool
    {
        return $auth->is_admin;
    }

    public function unblock(User $auth, User $user): bool
    {
        return $auth->is_admin;
    }
}
