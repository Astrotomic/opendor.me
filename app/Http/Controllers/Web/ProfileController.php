<?php

namespace App\Http\Controllers\Web;

use App\Models\Organization;
use App\Models\User;
use Illuminate\Contracts\View\View;

class ProfileController
{
    public function __invoke(User | Organization $profile): View
    {
        return match ($profile::class) {
            User::class => $this->user($profile),
            Organization::class => $this->organization($profile),
        };
    }

    protected function user(User $user): View
    {
        if (! $user->isRegistered()) {
            return view('web.profile.missing', [
                'user' => $user,
            ]);
        }

        return view('web.profile.user', [
            'user' => $user,
        ]);
    }

    protected function organization(Organization $organization): View
    {
        $members = $organization->members->filter(fn (User $user): bool => $user->isRegistered());

        return view('web.profile.organization', [
            'organization' => $organization,
            'members' => $members,
        ]);
    }
}
