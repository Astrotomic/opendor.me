<?php

namespace App\Repositories;

use App\Models\Organization;
use App\Models\User;
use Carbon\CarbonInterval;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class GithubSponsorRepository extends Repository
{
    public function all(): Collection
    {
        return Cache::remember(
            'github:sponsors',
            CarbonInterval::hour(),
            fn (): Collection => Http::github()
                ->withToken(config('services.github.sponsors_access_token'))
                ->post('/graphql', ['query' => $this->query()])
                ->collect('data.viewer.sponsorshipsAsMaintainer.nodes.*.sponsorEntity')
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

    protected function query(): string
    {
        return <<<'GRAPHQL'
        {
            viewer {
                sponsorshipsAsMaintainer(first: 100) {
                    nodes {
                        sponsorEntity {
                            __typename
                            ... on User {
                                databaseId
                                login
                            }
                            ... on Organization {
                                databaseId
                                login
                            }
                        }
                    }
                }
            }
        }
        GRAPHQL;
    }
}
