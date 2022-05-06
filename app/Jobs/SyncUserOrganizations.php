<?php

namespace App\Jobs;

use App\Models\Organization;
use App\Models\User;

class SyncUserOrganizations extends GithubJob
{
    public function __construct(
        protected User $user
    ) {
        parent::__construct();
    }

    public function run(): void
    {
        $organizations = $this->user->github()->get("/user/{$this->user->id}/orgs")->collect();

        $this->user->organizations()->sync(
            $organizations
                ->map(fn (array $org): Organization => Organization::fromGithub($org))
                ->pluck('id')
        );
    }
}
