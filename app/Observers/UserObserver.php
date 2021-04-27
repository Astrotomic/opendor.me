<?php

namespace App\Observers;

use App\Models\Repository;
use App\Models\User;

class UserObserver
{
    public function deleting(User $user): void
    {
        $user->contributions()->detach();
        $user->organizations()->detach();
        $user->repositories()->each(fn (Repository $repository) => $repository->delete());
    }
}
