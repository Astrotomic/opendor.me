<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Eloquent\Model;
use App\Filament\Resources\UserResource;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Builder;

class EditUser extends EditRecord
{
    public static $resource = UserResource::class;

    public static function getQuery(): Builder
    {
        return static::getModel()::query()->withoutGlobalScopes();
    }

    protected function resolveRecord($key): Model
    {
        return static::getModel()::query()->withoutGlobalScopes()->findOrFail($key);
    }
}
