<?php

namespace App\Policies;

use App\Models\Repository;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RepositoryPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $auth): bool
    {
        return true;
    }

    public function view(User $auth, Repository $repository): bool
    {
        return true;
    }

    public function create(User $auth): bool
    {
        return false;
    }

    public function update(User $auth, Repository $repository): bool
    {
        return false;
    }

    public function delete(User $auth, Repository $repository): bool
    {
        return $auth->is_superadmin;
    }

    public function restore(User $auth, Repository $repository): bool
    {
        return false;
    }

    public function forceDelete(User $auth, Repository $repository): bool
    {
        return false;
    }

    public function attachAnyUser(User $auth, Repository $repository): bool
    {
        return false;
    }

    public function block(User $auth, Repository $repository): bool
    {
        return $auth->is_admin;
    }

    public function unblock(User $auth, Repository $repository): bool
    {
        return $auth->is_admin;
    }

    public function add(User $auth): bool
    {
        return $auth->is_admin;
    }

    public function license(User $auth, Repository $repository): bool
    {
        return $auth->is_admin;
    }
}
