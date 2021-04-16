<?php

namespace App\Observers;

use App\Models\User;

class UserObserver
{
    public function saving(User $user): void
    {
        if (empty($user->github_access_token)) {
            $user->email = "{$user->id}+{$user->name}@users.noreply.github.com";
            $user->email_verified_at = null;
            $user->full_name = null;
            $user->description = null;
            $user->twitter = null;
            $user->website = null;
            $user->location = null;
        }
    }
}
