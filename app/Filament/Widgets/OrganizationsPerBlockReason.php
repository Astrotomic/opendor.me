<?php

namespace App\Filament\Widgets;

use App\Models\Organization;

class OrganizationsPerBlockReason extends EntitiesPerBlockReason
{
    protected static string $model = Organization::class;
}
