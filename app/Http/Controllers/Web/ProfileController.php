<?php

namespace App\Http\Controllers\Web;

use App\Models\Organization;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Symfony\Component\HttpFoundation\Response;

class ProfileController
{
    public function __invoke(User | Organization $profile): View
    {
        if ($profile instanceof User) {
            return $this->user($profile);
        }

        if ($profile instanceof Organization) {
            return $this->organization($profile);
        }
    }

    protected function user(User $user): View
    {
        abort_unless(
            auth()->user()?->is_superadmin || $user->isRegistered(),
            Response::HTTP_NOT_FOUND
        );

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
