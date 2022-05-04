<?php

namespace App\Console\Commands;

use App\Jobs\UpdateOrganizationDetails;
use App\Models\Organization;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;

class GithubOrganizationDetails extends Command
{
    protected $signature = 'github:organization:details {name?}';

    protected $description = 'Load organization details.';

    public function handle(): void
    {
        Organization::query()
            ->whereHas('members', fn (Builder $query) => $query->whereIsRegistered())
            ->when(
                $this->argument('name'),
                fn (Builder $query, string $name) => $query->where('name', $name)
            )
            ->each(static function (Organization $organization): void {
                UpdateOrganizationDetails::dispatch($organization);
            });
    }
}
