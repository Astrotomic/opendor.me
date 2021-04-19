<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GithubUserResource\Pages;
use App\Filament\Resources\GithubUserResource\RelationManagers;
use App\Filament\Resources\Tables\Columns\Avatar;
use App\Filament\Roles;
use App\Models\User;
use Filament\Resources\Forms\Form;
use Filament\Resources\Forms\Components;
use Filament\Resources\Resource;
use Filament\Resources\Tables\Columns;
use Filament\Resources\Tables\Filter;
use Filament\Resources\Tables\Table;

class GithubUserResource extends Resource
{
    public static $model = User::class;
    public static $label = 'Github users';
    public static $icon = 'heroicon-o-users';

    public static function form(Form $form)
    {
        return $form
            ->schema([
                Components\TextInput::make('id')->label('ID')->disabled(),
                Components\TextInput::make('github_url')->label('Github')->disabled(),
                Components\TextInput::make('fullname')->label('Full Name')->disabled(),
                Components\TextInput::make('description')->disabled(),
                Components\TextInput::make('email')->label('Email')->disabled(),
                Components\TextInput::make('location')->disabled(),
                Components\TextInput::make('twitter')->disabled(),
                Components\TextInput::make('website')->disabled(),
                Components\TextInput::make('github_access_token')->label('Github')->disabled(),
                Components\TextInput::make('blocked_at'),
                Components\TextInput::make('block_reason')

            ]);
    }

    public static function table(Table $table)
    {
        return $table
            ->columns([
                Avatar::make('avatar_url')->label(''),
                Columns\Text::make('id')->primary()->sortable()->searchable(),
                Columns\Text::make('github_url')->url(fn ($record) => $record->github_url, true)
                                                ->label('Name')
                                                ->formatUsing(fn () => 'Github')
                                                ->sortable(),
                Columns\Text::make('email')->sortable(),
                Columns\Boolean::make('github_access_token')->label('Github')->sortable(),
                Columns\Boolean::make('blocked_at')->sortable(),
            ])
            ->defaultSort('id', 'desc')
            ->filters([

            ]);
    }

    public static function relations()
    {
        return [
            RelationManagers\OrganizationsRelationManager::class,
            RelationManagers\RepositoriesRelationManager::class,
            RelationManagers\ContributionsRelationManager::class,
        ];
    }

    public static function routes()
    {
        return [
            Pages\ListGithubUsers::routeTo('/', 'index'),
            Pages\CreateGithubUser::routeTo('/create', 'create'),
            Pages\EditGithubUser::routeTo('/{record}/edit', 'edit'),
        ];
    }
}
