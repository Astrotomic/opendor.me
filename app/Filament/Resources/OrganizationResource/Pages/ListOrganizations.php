<?php

namespace App\Filament\Resources\OrganizationResource\Pages;

use App\Filament\Resources\OrganizationResource;
use Filament\Resources\Pages\ListRecords;

class ListOrganizations extends ListRecords
{
    public static $resource = OrganizationResource::class;

    public function canCreate(): bool
    {
        return false;
    }
}
