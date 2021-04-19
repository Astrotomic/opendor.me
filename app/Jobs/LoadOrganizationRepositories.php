<?php

namespace App\Jobs;

use App\Models\Organization;
use App\Models\Repository;
use Illuminate\Support\Collection;

class LoadOrganizationRepositories extends GithubJob
{
    public function __construct(protected Organization $organization)
    {
        parent::__construct();
    }

    public function run(): void
    {
        $this->paginated(function (int $page, int $perPage): Collection {
            $response = $this->organization->github()->get("/orgs/{$this->organization->name}/repos", [
                'type' => 'public',
                'per_page' => $perPage,
                'page' => $page,
            ])->collect();

            $response->each(fn (array $repository): ?Repository => Repository::fromGithub($repository));

            return $response;
        });
    }
}
