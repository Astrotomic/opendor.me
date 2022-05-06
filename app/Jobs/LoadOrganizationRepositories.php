<?php

namespace App\Jobs;

use App\Models\Organization;
use App\Models\Repository;
use Carbon\CarbonInterval;
use Illuminate\Support\Collection;

class LoadOrganizationRepositories extends GithubJob
{
    public function __construct(
        protected Organization $organization
    ) {
        parent::__construct();
        $this->timeout = CarbonInterval::minutes(15)->totalSeconds;
    }

    public function run(): void
    {
        $this->paginated(function (int $page, int $perPage): Collection {
            $response = $this->organization->github()->get("/organizations/{$this->organization->id}/repos", [
                'type' => 'public',
                'per_page' => $perPage,
                'page' => $page,
            ])->collect();

            $response->each(fn (array $repository): ?Repository => Repository::fromGithub($repository));

            return $response;
        });
    }
}
