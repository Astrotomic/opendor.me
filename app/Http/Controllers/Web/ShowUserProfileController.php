<?php

namespace App\Http\Controllers\Web;

use App\Enums\Language;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class ShowUserProfileController
{
    public function __invoke(User $user): View
    {
        abort_unless(
            auth()->user()?->is_superadmin || $user->isRegistered(),
            Response::HTTP_NOT_FOUND
        );

        $contributions = $user->contributions()->with('owner')->cursor();
        $organizations = $user->organizations->filter(fn (Organization $organization): bool => $organization->repositories()->exists());
        $languages = $contributions->pluck('language')->reject(Language::NOASSERTION())->collect()->values();
        $contributions = $contributions->groupBy('vendor_name')->sortBy(fn (Collection $repositories, string $owner): string => Str::lower($owner));

        return view('web.profile.user', [
            'user' => $user,
            'organizations' => $organizations,
            'languages' => $languages,
            'contributions' => $contributions,
        ]);
    }
}
