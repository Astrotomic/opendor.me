<?php

namespace App\Observers;

use App\Enums\BlockReason;
use App\Enums\Language;
use App\Enums\License;
use App\Jobs\LoadRepositoryContributors;
use App\Models\Repository;

class RepositoryObserver
{
    public function creating(Repository $repository): void
    {
        if (
            (
                $repository->license->equals(License::NOASSERTION())
                || $repository->language->equals(Language::NOASSERTION())
            )
            && $repository->block_reason === null
        ) {
            $repository->block_reason = BlockReason::REVIEW();
        }

        if ($repository->block_reason !== null) {
            $repository->blocked_at = now();
        }
    }

    public function created(Repository $repository): void
    {
        if (! $repository->isBlocked()) {
            LoadRepositoryContributors::dispatch($repository);
        }
    }

    public function deleting(Repository $repository): void
    {
        $repository->contributors()->detach();
    }
}
