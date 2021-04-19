<?php

namespace App\Jobs;

use App\Models\Organization;

class UpdateOrganizationDetails extends GithubJob
{
    public function __construct(protected Organization $organization)
    {
        parent::__construct();
    }

    public function run(): void
    {
        $data = $this->organization->github()->get("/orgs/{$this->organization->name}")->json();

        $this->organization->update([
            'full_name' => $data['name'] ?? null,
            'is_verified' => $data['is_verified'],
            'description' => $data['description'],
            'twitter' => $data['twitter_username'] ?? null,
            'website' => $data['blog'] ?? null,
            'location' => $data['location'] ?? null,
        ]);
    }
}
