<?php

namespace App\Console\Commands;

use App\Jobs\LoadUserRepositories;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class GithubUserRepositories extends Command
{
    protected $signature = 'github:user:repositories {name?}';

    protected $description = 'Load all repositories for users.';

    public function handle(): void
    {
        $query = User::query()
            ->whereIsRegistered()
            ->when(
                $this->argument('name'),
                fn (Builder $query, string $name) => $query->where('name', $name)
            );

        $this->withProgressBar($query, static function (User $use): void {
            LoadUserRepositories::dispatch($use);
        });
    }
}
