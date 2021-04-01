<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Spatie\Permission\Models\Role;

class RolePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $auth): bool
    {
        return $auth->is_superadmin;
    }

    public function view(User $auth, Role $role): bool
    {
        return $auth->is_superadmin;
    }

    public function create(User $auth): bool
    {
        return $auth->is_superadmin;
    }

    public function update(User $auth, Role $role): bool
    {
        return $auth->is_superadmin;
    }

    public function delete(User $auth, Role $role): bool
    {
        return $auth->is_superadmin;
    }

    public function restore(User $auth, Role $role): bool
    {
        return false;
    }

    public function forceDelete(User $auth, Role $role): bool
    {
        return false;
    }
}
