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
                ->merge(GithubSponsors::fromUser('Gummibeer')->select('databaseId', 'login')->all())
                ->merge(GithubSponsors::fromUser('SarahSibert')->select('databaseId', 'login')->all())
                ->unique('databaseId')
                ->map(static function (Fluent $sponsor): User | Organization | null {
                    $sponsor['id'] = $sponsor['databaseId'];

                    if ($sponsor['__typename'] === 'User') {
                        return User::fromGithub($sponsor->getAttributes());
                    }

                    if ($sponsor['__typename'] === 'Organization') {
                        return Organization::fromGithub($sponsor->getAttributes());
                    }

                    return null;
                })
                ->filter()
                ->sortBy(fn (User | Organization $sponsor): string => Str::lower($sponsor->name))
                ->values()
        );
    }
}
