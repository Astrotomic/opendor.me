<?php

namespace App\Observers;

use App\Jobs\LoadOrganizationRepositories;
use App\Models\Organization;

class OrganizationObserver
{
    public function created(Organization $organization): void
    {
        LoadOrganizationRepositories::dispatch($organization);
    }
}
