<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListUsers extends ListRecords
{
    public static $resource = UserResource::class;

    public static function getQuery(): Builder
    {
        return static::getModel()::query()->withoutGlobalScopes();
    }

    public function canCreate(): bool
    {
        return false;
    }
}
