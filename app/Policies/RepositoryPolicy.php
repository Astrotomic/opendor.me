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
        return $auth->isAllowedTo('viewAny', Repository::class);
    }

    public function view(User $auth, Repository $repository): bool
    {
        return $auth->isAllowedTo('view', $repository);
    }

    public function create(User $auth): bool
    {
        return false;
    }

    public function update(User $auth, Repository $repository): bool
    {
        return $auth->isAllowedTo('update', $repository);
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
        return $auth->isAllowedTo('block', $repository);
    }

    public function unblock(User $auth, Repository $repository): bool
    {
        return $auth->isAllowedTo('unblock', $repository);
    }

    public function add(User $auth): bool
    {
        return $auth->isAllowedTo('add', Repository::class);
    }

    public function license(User $auth, Repository $repository): bool
    {
        return $auth->isAllowedTo('license', $repository);
    }

    public function language(User $auth, Repository $repository): bool
    {
        return $auth->isAllowedTo('language', $repository);
    }

    public function details(User $auth, Repository $repository): bool
    {
        return $auth->isAllowedTo('details', $repository);
    }
}
