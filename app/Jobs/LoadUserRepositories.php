<?php

namespace App\Jobs;

use App\Models\Repository;
use App\Models\User;
use Carbon\CarbonInterval;

class LoadUserRepositories extends GithubJob
{
    public function __construct(protected User $user)
    {
        parent::__construct();
        $this->timeout = CarbonInterval::minutes(15)->totalSeconds;
    }

    public function run(): void
    {
        $page = 1;
        do {
            $response = $this->user->github()->get("/users/{$this->user->name}/repos", [
                    'type' => 'public',
                    'per_page' => 100,
                    'page' => $page,
                ])->collect();

            $response->each(fn (array $repository): ?Repository => Repository::fromGithub($repository));

            $page++;
        } while ($response->count() >= 100);
    }
}
