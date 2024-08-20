<?php

namespace App\Console\Commands;

use App\Jobs\SyncUserOrganizations;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class GithubUserOrganizations extends Command
{
    protected $signature = 'github:user:organizations {name?}';

    protected $description = 'Load user organizations.';

    public function handle(): void
    {
        $query = User::query()
            ->whereIsRegistered()
            ->when(
                $this->argument('name'),
                fn (Builder $query, string $name) => $query->where('name', $name)
            );

        $this->progress(
            items: $query,
            callback: fn (User $user) => SyncUserOrganizations::dispatch($user)
        );
    }
}
