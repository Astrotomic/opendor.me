<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GithubOrganizationResource\Pages;
use App\Filament\Resources\GithubOrganizationResource\RelationManagers;
use App\Filament\Resources\Tables\Columns\Avatar;
use App\Filament\Roles;
use App\Models\Organization;
use Filament\Resources\Forms\Components;
use Filament\Resources\Forms\Form;
use Filament\Resources\Resource;
use Filament\Resources\Tables\Columns;
use Filament\Resources\Tables\Filter;
use Filament\Resources\Tables\Table;

class GithubOrganizationResource extends Resource
{
    public static $model = Organization::class;
    public static $label = 'Organizations';
    public static $icon = 'heroicon-o-globe-alt';

    public static function form(Form $form)
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table)
    {
        return $table
            ->columns([
                Avatar::make('avatar_url')->label(''),
                Columns\Text::make('id')->primary()->sortable()->searchable(),
                Columns\Text::make('github_url')->url(fn ($record) => $record->github_url, true)->label('Name')->sortable(),
                Columns\Boolean::make('blocked_at')->sortable(),
            ])
            ->defaultSort('id', 'desc')
            ->filters([
                //
            ]);
    }

    public static function relations()
    {
        return [
            //
        ];
    }

    public static function routes()
    {
        return [
            Pages\ListGithubOrganizations::routeTo('/', 'index'),
            Pages\CreateGithubOrganization::routeTo('/create', 'create'),
            Pages\EditGithubOrganization::routeTo('/{record}/edit', 'edit'),
        ];
    }
}
