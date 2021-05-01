<?php

namespace App\Filament\Resources\RepositoryResource\Pages;

use App\Filament\Resources\RepositoryResource;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListRepositories extends ListRecords
{
    public static $resource = RepositoryResource::class;

    public static function getQuery(): Builder
    {
        return static::getModel()::query()->withoutGlobalScopes();
    }

    public function canCreate(): bool
    {
        return false;
    }
}
