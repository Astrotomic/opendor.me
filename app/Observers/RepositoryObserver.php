<?php

namespace App\Observers;

use App\Jobs\LoadRepositoryContributors;
use App\Models\Repository;

class RepositoryObserver
{
    public function created(Repository $repository): void
    {
        LoadRepositoryContributors::dispatch($repository);
    }
}
