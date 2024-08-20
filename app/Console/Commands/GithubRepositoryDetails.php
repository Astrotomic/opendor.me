<?php

namespace App\Console\Commands;

use App\Jobs\UpdateRepositoryDetails;
use App\Models\Organization;
use App\Models\Repository;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class GithubRepositoryDetails extends Command
{
    protected $signature = 'github:repository:details {name?}';

    protected $description = 'Load repository details.';

    public function handle(): void
    {
        $query = Repository::query()
            ->when(
                $this->argument('name'),
                fn (Builder $query, string $name) => $query->where('name', $name)
            )
            ->with('owner');

        $this->progress(
            items: $query,
            callback: static function (Repository $repository): void {
                if ($repository->owner instanceof User && $repository->owner->github_access_token === null) {
                    return;
                }

                if ($repository->owner instanceof Organization && $repository->owner->members()->whereIsRegistered()->doesntExist()) {
                    return;
                }

                UpdateRepositoryDetails::dispatch($repository);
            },
            default: fn () => $this->argument('name') ? Repository::fromName($this->argument('name')) : null
        );
    }
}
