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
        return $auth->isAllowedTo('viewAny', Organization::class);
    }

    public function view(User $auth, Organization $organization): bool
    {
        return $auth->isAllowedTo('view', $organization);
    }

    public function create(User $auth): bool
    {
        return false;
    }

    public function update(User $auth, Organization $organization): bool
    {
        return $auth->isAllowedTo('update', $organization);
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
        return $auth->isAllowedTo('block', $organization);
    }

    public function unblock(User $auth, Organization $organization): bool
    {
        return $auth->isAllowedTo('unblock', $organization);
    }

    public function details(User $auth, Organization $organization): bool
    {
        return $auth->isAllowedTo('details', $organization);
    }
}
