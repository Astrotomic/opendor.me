<?php

namespace App\Http\Controllers\Web;

use App\Enums\Language;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
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

        throw new ModelNotFoundException();
    }

    protected function user(User $user): View
    {
        abort_unless(
            auth()->user()?->is_superadmin || $user->isRegistered(),
            Response::HTTP_NOT_FOUND
        );

        $contributions = $user->contributions()->with('owner')->get();
        $languages = $contributions->pluck('language')->reject(Language::NOASSERTION())->collect()->values();
        $contributions = $contributions->groupBy('vendor_name')->sortBy(fn (Collection $repositories, string $owner): string => Str::lower($owner));

        return view('web.profile.user', [
            'user' => $user,
            'languages' => $languages,
            'contributions' => $contributions,
        ]);
    }

    protected function organization(Organization $organization): View
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
