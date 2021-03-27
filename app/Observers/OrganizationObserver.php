<?php

namespace App\Observers;

use App\Jobs\LoadOrganizationRepositories;
use App\Jobs\UpdateOrganizationDetails;
use App\Models\Organization;

class OrganizationObserver
{
    public function created(Organization $organization): void
    {
        UpdateOrganizationDetails::dispatch($organization);
        LoadOrganizationRepositories::dispatch($organization);
    }
}
