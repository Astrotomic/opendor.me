<?php

namespace App\Jobs;

use App\Models\Repository;
use App\Models\User;
use Carbon\CarbonInterval;
use Illuminate\Support\Collection;

class LoadUserRepositories extends GithubJob
{
    public function __construct(
        protected User $user
    ) {
        parent::__construct();
        $this->timeout = CarbonInterval::minutes(15)->totalSeconds;
    }

    public function run(): void
    {
        $this->paginated(function (int $page, int $perPage): Collection {
            $response = $this->user->github()->get("/users/{$this->user->name}/repos", [
                'type' => 'public',
                'per_page' => $perPage,
                'page' => $page,
            ])->collect();

            $response->each(fn (array $repository): ?Repository => Repository::fromGithub($repository));

            return $response;
        });
    }
}
