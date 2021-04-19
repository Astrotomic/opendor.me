<?php

namespace App\Jobs;

use App\Models\User;

class UpdateUserDetails extends GithubJob
{
    public function __construct(protected User $user)
    {
        parent::__construct();
    }

    public function run(): void
    {
        $data = $this->user->github()->get("/users/{$this->user->name}")->json();

        $this->user->update([
            'full_name' => $data['name'],
            'description' => $data['bio'],
            'twitter' => $data['twitter_username'],
            'website' => $data['blog'],
            'location' => $data['location'],
        ]);

        if (! $this->user->hasGithubToken()) {
            return;
        }

        $emails = $this->user->github()->get('/user/emails')->collect()
            ->filter->verified
            ->pluck('email')
            ->unique()
            ->toArray();

        $this->user->update(['emails' => $emails]);
    }
}
