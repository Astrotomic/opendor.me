<?php

namespace App\Repositories;

use App\Models\Organization;
use App\Models\User;
use Astrotomic\GithubSponsors\Facades\GithubSponsors;
use Carbon\CarbonInterval;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Fluent;
use Illuminate\Support\Str;

class GithubSponsorRepository extends Repository
{
    public function all(): Collection
    {
        return Cache::remember(
            'github:sponsors',
            CarbonInterval::hour(),
            fn (): Collection => collect()
                ->merge(GithubSponsors::user('Gummibeer')->sponsors(['databaseId', 'login']))
                ->merge(GithubSponsors::user('SarahSibert')->sponsors(['databaseId', 'login']))
                ->unique('databaseId')
                ->map(static function (array $sponsor): User | Organization | null {
                    $sponsor['id'] = $sponsor['databaseId'];

                    if ($sponsor['__typename'] === 'User') {
                        return User::fromGithub($sponsor);
                    }

                    if ($sponsor['__typename'] === 'Organization') {
                        return Organization::fromGithub($sponsor);
                    }

                    return null;
                })
                ->filter()
                ->sortBy(fn (User | Organization $sponsor): string => Str::lower($sponsor->name))
                ->values()
        );
    }
}
