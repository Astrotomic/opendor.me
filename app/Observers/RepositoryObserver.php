<?php

namespace App\Observers;

use App\Jobs\LoadRepositoryContributors;
use App\Models\Repository;

class RepositoryObserver
{
    public function creating(Repository $repository): void
    {
        if ($repository->block_reason !== null) {
            $repository->blocked_at = now();
        }
    }

    public function created(Repository $repository): void
    {
        if (! $repository->isBlocked()) {
            LoadRepositoryContributors::dispatchBatch($repository);
        }
    }

    public function deleting(Repository $repository): void
    {
        $repository->contributors()->detach();
    }
}
