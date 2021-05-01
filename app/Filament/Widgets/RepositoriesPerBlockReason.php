<?php

namespace App\Filament\Widgets;

use App\Models\Repository;

class RepositoriesPerBlockReason extends EntitiesPerBlockReason
{
    protected static string $model = Repository::class;
}
