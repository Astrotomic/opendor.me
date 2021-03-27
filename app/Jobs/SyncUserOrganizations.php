<?php

namespace App\Jobs;

use App\Models\Organization;
use App\Models\User;
use Carbon\CarbonInterval;

class SyncUserOrganizations extends GithubJob
{
    public function __construct(protected User $user)
    {
        parent::__construct();
        $this->timeout = CarbonInterval::minutes(5)->totalSeconds;
    }

    public function run(): void
    {
        $organizations = $this->user->github()->get("/users/{$this->user->name}/orgs")->collect();

        $this->user->organizations()->sync(
            $organizations
                ->map(fn (array $org): Organization => Organization::fromGithub($org))
                ->pluck('id')
        );
    }
}
