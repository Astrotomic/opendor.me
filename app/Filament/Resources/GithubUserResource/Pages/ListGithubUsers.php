<?php

namespace App\Filament\Resources\GithubUserResource\Pages;

use App\Filament\Resources\GithubUserResource;
use Filament\Resources\Pages\ListRecords;

class ListGithubUsers extends ListRecords
{
    public static $resource = GithubUserResource::class;
}
