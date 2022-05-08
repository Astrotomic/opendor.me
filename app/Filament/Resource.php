<?php

namespace App\Filament;

use Filament\Resources\Resource as FilamentResource;
use Illuminate\Database\Eloquent\Model;

abstract class Resource extends FilamentResource
{
    protected static ?string $recordTitleAttribute = 'name';

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canDelete(Model $record): bool
    {
        return false;
    }

    public static function canDeleteAny(): bool
    {
        return false;
    }
}
