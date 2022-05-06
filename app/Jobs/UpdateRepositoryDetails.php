<?php

namespace App\Jobs;

use App\Enums\BlockReason;
use App\Models\Repository;

class UpdateRepositoryDetails extends GithubJob
{
    public function __construct(
        protected Repository $repository
    ) {
        parent::__construct();
    }

    public function run(): void
    {
        $data = $this->repository->github()->get("/repositories/{$this->repository->id}")->json();

        $repository = Repository::fromGithub($data);

        if ($repository === null) {
            $this->repository->update([
                'block_reason' => BlockReason::REVIEW(),
            ]);
        }
    }
}
