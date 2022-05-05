<?php

namespace App\Console\Commands;

use App\Jobs\SyncUserContributions;
use App\Jobs\SyncUserOrganizations;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;

class GithubUserOrganizations extends Command
{
    protected $signature = 'github:user:organizations {name?}';

    protected $description = 'Load user organizations.';

    public function handle(): void
    {
        User::query()
            ->whereIsRegistered()
            ->when(
                $this->argument('name'),
                fn (Builder $query, string $name) => $query->where('name', $name)
            )
            ->each(static function (User $user): void {
                SyncUserOrganizations::dispatch($user);
            });
    }
}
