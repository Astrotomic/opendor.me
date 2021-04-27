<?php

namespace App\Filament\Resources\OrganizationResource\Pages;

use App\Filament\Resources\OrganizationResource;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListOrganizations extends ListRecords
{
    public static $resource = OrganizationResource::class;

    public static function getQuery(): Builder
    {
        return static::getModel()::query()->withoutGlobalScopes();
    }

    public function canCreate(): bool
    {
        return false;
    }
}
