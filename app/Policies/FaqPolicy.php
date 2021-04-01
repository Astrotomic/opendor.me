<?php

namespace App\Policies;

use App\Models\FAQ;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FaqPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $auth): bool
    {
        return $auth->isAllowedTo('viewAny', FAQ::class);
    }

    public function view(User $auth, FAQ $faq): bool
    {
        return $auth->isAllowedTo('view', $faq);
    }

    public function create(User $auth): bool
    {
        return $auth->isAllowedTo('create', FAQ::class);
    }

    public function update(User $auth, FAQ $faq): bool
    {
        return $auth->isAllowedTo('update', $faq);
    }

    public function delete(User $auth, FAQ $faq): bool
    {
        return $auth->isAllowedTo('delete', $faq);
    }

    public function restore(User $auth, FAQ $faq): bool
    {
        return false;
    }

    public function forceDelete(User $auth, FAQ $faq): bool
    {
        return false;
    }
}
