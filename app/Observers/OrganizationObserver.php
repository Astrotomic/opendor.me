<?php

namespace App\Observers;

use App\Jobs\LoadOrganizationRepositories;
use App\Jobs\UpdateOrganizationDetails;
use App\Models\Organization;
use App\Models\Repository;

class OrganizationObserver
{
    public function created(Organization $organization): void
    {
        UpdateOrganizationDetails::dispatch($organization);
        LoadOrganizationRepositories::dispatch($organization);
    }

    public function deleting(Organization $organization): void
    {
        $organization->members()->detach();
        $organization->repositories()->each(fn (Repository $repository) => $repository->delete());
    }
}
