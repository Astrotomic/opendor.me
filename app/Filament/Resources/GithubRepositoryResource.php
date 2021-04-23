<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GithubRepositoryResource\Pages;
use App\Models\Repository;
use Filament\Resources\Forms\Components;
use Filament\Resources\Forms\Form;
use Filament\Resources\Resource;
use Filament\Resources\Tables\Columns;
use Filament\Resources\Tables\Table;

class GithubRepositoryResource extends Resource
{
    public static $model = Repository::class;
    public static $label = 'Repositories';
    public static $icon = 'heroicon-o-collection';

    public static function form(Form $form)
    {
        return $form
            ->schema([
                Components\TextInput::make('id')->label('ID')->disabled(),
                Components\TextInput::make('github_url')->label('Github')->disabled(),
                Components\TextInput::make('licence')->disabled(),
                Components\TextInput::make('language')->disabled(),
                Components\TextInput::make('website')->disabled(),
                Components\TextInput::make('stargazer_count')->label('Stars')->disabled(),
                Components\TextInput::make('blocked_at'),
                Components\TextInput::make('block_reason'),

            ]);
    }

    public static function table(Table $table)
    {
        return $table
            ->columns([
                Columns\Text::make('id')->primary()->sortable()->searchable(),
                Columns\Text::make('github_url')->url(fn ($record) => $record->github_url, true)->label('Name')->sortable(),
                Columns\Text::make('license')->sortable(),
                Columns\Text::make('language')->sortable()->searchable(),
                Columns\Boolean::make('blocked_at')->sortable(),
            ])
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
            Pages\ListGithubRepositories::routeTo('/', 'index'),
            Pages\CreateGithubRepository::routeTo('/create', 'create'),
            Pages\EditGithubRepository::routeTo('/{record}/edit', 'edit'),
        ];
    }
}
