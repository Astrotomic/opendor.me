<?php

namespace App\Console\Commands;

use App\Jobs\SyncUserContributions;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class GithubUserContributions extends Command
{
    protected $signature = 'github:user:contributions {name?}';

    protected $description = 'Load user contributions.';

    public function handle(): void
    {
        $query = User::query()
            ->whereIsRegistered()
            ->when(
                $this->argument('name'),
                fn (Builder $query, string $name) => $query->where('name', $name)
            );

        $this->withProgressBar($query, static function (User $user): void {
            SyncUserContributions::dispatch($user);
        });
    }
}
