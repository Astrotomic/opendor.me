<?php

namespace App\Console\Commands;

use App\Jobs\UpdateRepositoryDetails;
use App\Models\Organization;
use App\Models\Repository;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;

class GithubRepositoryDetails extends Command
{
    protected $signature = 'github:repository:details {name?}';
    protected $description = 'Load repository details.';

    public function handle(): void
    {
        Repository::query()
            ->when(
                $this->argument('name'),
                fn (Builder $query, string $name) => $query->where('name', $name)
            )
            ->with('owner')
            ->get()
            ->reject(function (Repository $repository): bool {
                return $repository->owner instanceof User && $repository->owner->github_access_token === null;
            })
            ->reject(function (Repository $repository): bool {
                return $repository->owner instanceof Organization && $repository->owner->members()->whereNotNull('github_access_token')->doesntExist();
            })
            ->each(static function (Repository $repository): void {
                UpdateRepositoryDetails::dispatch($repository);
            });
    }
}
