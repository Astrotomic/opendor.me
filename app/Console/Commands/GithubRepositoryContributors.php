<?php

namespace App\Console\Commands;

use App\Jobs\LoadRepositoryContributors;
use App\Models\Organization;
use App\Models\Repository;
use App\Models\User;
use Carbon\CarbonInterval;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Bus;

class GithubRepositoryContributors extends Command
{
    protected $signature = 'github:repository:contributors {name?}';
    protected $description = 'Load all contributors for repositories.';

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
                return $repository->owner instanceof Organization && $repository->owner->members()->whereIsRegistered()->doesntExist();
            })
            ->groupBy('vendor_name')
            ->each(static function (Collection $repositories): void {
                $repositories
                    ->chunk(100)
                    ->each(static function (Collection $repositories, int $i) {
                        $repositories->each(fn (Repository $repository) => Bus::batch([
                            (new LoadRepositoryContributors($repository))->delay(CarbonInterval::minutes($i * 5)),
                        ])->onQueue('github')->dispatch());
                    });
            });
    }
}
