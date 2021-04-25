<?php

namespace App\Filament\Resources\RepositoryResource\Pages;

use App\Filament\Resources\RepositoryResource;
use Filament\Resources\Pages\ListRecords;

class ListRepositories extends ListRecords
{
    public static $resource = RepositoryResource::class;

    public function canCreate(): bool
    {
        return false;
    }
}
