<?php

namespace App\Filament\Widgets;

use App\Models\Organization;
use App\Models\Repository;
use App\Models\User;

class RepositoriesPerBlockReason extends EntitiesPerBlockReason
{
    protected static string $model = Repository::class;
}
