<?php

namespace App\Filament\Widgets;

use App\Models\User;

class UsersPerBlockReason extends EntitiesPerBlockReason
{
    protected static string $model = User::class;
}
