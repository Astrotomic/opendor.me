<?php

namespace App\Jobs;

use App\Models\Repository;
use App\Models\User;

class AddRepositoryContributor extends GithubJob
{
    public function __construct(protected Repository $repository, protected array $contributor)
    {
        parent::__construct();
    }

    protected function run(): void
    {
        if ($this->contributor['type'] === 'User') {
            $user = User::fromGithub($this->contributor);
        } elseif ($this->contributor['type'] === 'Anonymous') {
            $user = User::byEmail($this->contributor['email'])->first();
        }

        if (empty($user)) {
            return;
        }

        $this->repository->contributors()->syncWithoutDetaching([
            $user->id,
        ]);
    }
}
