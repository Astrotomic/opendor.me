<?php

namespace App\Filament\Widgets;

use App\Models\Organization;
use App\Models\User;

class OrganizationsPerBlockReason extends EntitiesPerBlockReason
{
    protected static string $model = Organization::class;
}
