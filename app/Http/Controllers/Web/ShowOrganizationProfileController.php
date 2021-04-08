<?php

namespace App\Http\Controllers\Web;

use App\Enums\Language;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Contracts\View\View;

class ShowOrganizationProfileController
{
    public function __invoke(Organization $organization)
    {
        $repositories = $organization->repositories()->with('owner')->cursor();
        $members = $organization->members->filter(fn (User $user): bool => $user->isRegistered());
        $languages = $repositories->pluck('language')->reject(Language::NOASSERTION())->unique()->collect()->values();

        return view('web.profile.organization', [
            'organization' => $organization,
            'members' => $members,
            'languages' => $languages,
            'repositories' => $repositories,
        ]);
    }
}
