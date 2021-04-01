<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Spatie\Permission\Models\Permission;

class PermissionPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $auth): bool
    {
        return $auth->is_superadmin;
    }

    public function view(User $auth, Permission $permission): bool
    {
        return $auth->is_superadmin;
    }

    public function create(User $auth): bool
    {
        return $auth->is_superadmin;
    }

    public function update(User $auth, Permission $permission): bool
    {
        return $auth->is_superadmin;
    }

    public function delete(User $auth, Permission $permission): bool
    {
        return $auth->is_superadmin;
    }

    public function restore(User $auth, Permission $permission): bool
    {
        return false;
    }

    public function forceDelete(User $auth, Permission $permission): bool
    {
        return false;
    }
}
