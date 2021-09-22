<?php

namespace App\Observers;

use App\Models\Repository;

class RepositoryObserver
{
    public function creating(Repository $repository): void
    {
        if ($repository->block_reason !== null) {
            $repository->blocked_at = now();
        }
    }

    public function deleting(Repository $repository): void
    {
        $repository->contributors()->detach();
    }
}
