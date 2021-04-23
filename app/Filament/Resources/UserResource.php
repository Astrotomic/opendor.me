<?php

namespace App\Filament\Resources;

use App\Enums\BlockReason as BlockReasonEnum;
use App\Filament\Resources\Tables\Columns\Avatar;
use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Resources\Forms\Form;
use Filament\Resources\Forms\Components;
use Filament\Resources\Resource;
use Filament\Resources\Tables\Columns;
use Filament\Resources\Tables\Table;
use Illuminate\Support\Arr;

class UserResource extends Resource
{
    public static $model = User::class;
    public static $icon = 'heroicon-o-users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Components\TextInput::make('id')->disabled(),
                Components\TextInput::make('name')->disabled(),
                Components\TextInput::make('full_name')->disabled(),
                Components\TextInput::make('description')->disabled(),
                Components\TextInput::make('email')->disabled(),
                Components\TextInput::make('location')->disabled(),
                Components\TextInput::make('twitter')->disabled(),
                Components\TextInput::make('website')->disabled(),
                Components\Select::make('block_reason') // ToDo: cast empty string to null
                    ->options(Arr::prepend(BlockReasonEnum::toArray(), '—', null))
                    ->nullable(),
                Components\TextInput::make('blocked_at')->disabled(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Avatar::make('avatar_url')->label(''),
                Columns\Text::make('id')
                    ->primary()
                    ->searchable(),
                Columns\Text::make('name')
                    ->url(fn (User $record): string => $record->github_url, true)
                    ->searchable(),
                Columns\Text::make('full_name')
                    ->searchable(),
                Columns\Boolean::make('github_access_token')
                    ->label('GitHub')
                    ->sortable(),
                Columns\Boolean::make('blocked_at')
                    ->label('Blocked')
                    ->sortable(),
            ])
            ->defaultSort('id', 'desc')
            ->filters([]);
    }

    public static function relations(): array
    {
        return [
            RelationManagers\OrganizationsRelationManager::class,
            RelationManagers\RepositoriesRelationManager::class,
            RelationManagers\ContributionsRelationManager::class,
        ];
    }

    public static function routes(): array
    {
        return [
            Pages\ListUsers::routeTo('/', 'index'),
            Pages\EditUser::routeTo('/{record}/edit', 'edit'),
        ];
    }
}
