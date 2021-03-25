<?php

namespace App\Observers;

use App\Enums\BlockReason;
use App\Enums\License;
use App\Jobs\LoadRepositoryContributors;
use App\Models\Repository;

class RepositoryObserver
{
    public function creating(Repository $repository): void
    {
        if($repository->license->equals(License::NOASSERTION())) {
            $repository->blocked_at = now();
            $repository->block_reason = BlockReason::REVIEW();
        }
    }

    public function created(Repository $repository): void
    {
        LoadRepositoryContributors::dispatch($repository);
    }
}
