<?php

namespace App\Policies;

use App\Models\Organization;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrganizationPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $auth): bool
    {
        return true;
    }

    public function view(User $auth, Organization $organization): bool
    {
        return true;
    }

    public function create(User $auth): bool
    {
        return false;
    }

    public function update(User $auth, Organization $organization): bool
    {
        return false;
    }

    public function delete(User $auth, Organization $organization): bool
    {
        return false;
    }

    public function restore(User $auth, Organization $organization): bool
    {
        return false;
    }

    public function forceDelete(User $auth, Organization $organization): bool
    {
        return false;
    }

    public function attachAnyUser(User $auth, Organization $organization): bool
    {
        return false;
    }

    public function block(User $auth, Organization $organization): bool
    {
        return $auth->is_admin;
    }

    public function unblock(User $auth, Organization $organization): bool
    {
        return $auth->is_admin;
    }
}
