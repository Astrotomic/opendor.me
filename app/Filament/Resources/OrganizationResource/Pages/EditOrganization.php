<?php

namespace App\Filament\Resources\OrganizationResource\Pages;

use App\Eloquent\Model;
use App\Filament\Resources\OrganizationResource;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Builder;

class EditOrganization extends EditRecord
{
    public static $resource = OrganizationResource::class;

    public static function getQuery(): Builder
    {
        return static::getModel()::query()->withoutGlobalScopes();
    }

    protected function resolveRecord($key): Model
    {
        return static::getModel()::query()->withoutGlobalScopes()->findOrFail($key);
    }
}
