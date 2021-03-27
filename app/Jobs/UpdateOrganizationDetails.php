<?php

namespace App\Jobs;

use App\Models\Organization;
use Carbon\CarbonInterval;

class UpdateOrganizationDetails extends GithubJob
{
    public function __construct(protected Organization $organization)
    {
        parent::__construct();
        $this->timeout = CarbonInterval::minutes(5)->totalSeconds;
    }

    public function run(): void
    {
        $data = $this->organization->github()->get("/orgs/{$this->organization->name}")->json();

        $this->organization->update([
            'full_name' => $data['name'],
            'is_verified' => $data['is_verified'],
            'description' => $data['description'],
            'twitter' => $data['twitter_username'],
            'website' => $data['blog'],
            'location' => $data['location'],
        ]);
    }
}
