<?php

namespace App\Console\Commands;

use App\Jobs\LoadOrganizationRepositories;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Builder;

class GithubOrganizationRepositories extends Command
{
    protected $signature = 'github:organization:repositories {name?}';

    protected $description = 'Load all repositories for organizations.';

    public function handle(): void
    {
        $query = Organization::query()
            ->whereHas('members', fn (Builder $query) => $query->whereIsRegistered())
            ->when(
                $this->argument('name'),
                fn (Builder $query, string $name) => $query->where('name', $name)
            );

        $this->withProgressBar($query, static function (Organization $organization): void {
            LoadOrganizationRepositories::dispatch($organization);
        });
    }
}
