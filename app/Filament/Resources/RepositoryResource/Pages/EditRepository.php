<?php

namespace App\Filament\Resources\RepositoryResource\Pages;

use App\Eloquent\Model;
use App\Filament\Resources\RepositoryResource;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Builder;

class EditRepository extends EditRecord
{
    public static $resource = RepositoryResource::class;

    public static function getQuery(): Builder
    {
        return static::getModel()::query()->withoutGlobalScopes();
    }

    protected function resolveRecord($key): Model
    {
        return static::getModel()::query()->withoutGlobalScopes()->findOrFail($key);
    }
}
