<?php

namespace App\Jobs;

use App\Models\Organization;
use App\Models\Repository;
use Carbon\CarbonInterval;

class LoadOrganizationRepositories extends GithubJob
{
    public function __construct(protected Organization $organization)
    {
        parent::__construct();
        $this->timeout = CarbonInterval::minutes(15)->totalSeconds;
    }

    public function run(): void
    {
        $page = 1;
        do {
            $response = $this->organization->github()->get("/orgs/{$this->organization->name}/repos", [
                    'type' => 'public',
                    'per_page' => 100,
                    'page' => $page,
                ])->collect();

            $response->each(fn (array $repository): ?Repository => Repository::fromGithub($repository));

            $page++;
        } while ($response->count() >= 100);
    }
}
