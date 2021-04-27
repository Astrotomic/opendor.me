<?php

namespace App\Filament\Resources;

use App\Enums\BlockReason as BlockReasonEnum;
use App\Filament\Resources\Tables\Columns\Avatar;
use App\Filament\Resources\UserResource\Pages\EditUser;
use App\Filament\Resources\UserResource\Pages\ListUsers;
use App\Filament\Resources\UserResource\RelationManagers\ContributionsRelationManager;
use App\Filament\Resources\UserResource\RelationManagers\OrganizationsRelationManager;
use App\Filament\Resources\UserResource\RelationManagers\RepositoriesRelationManager;
use App\Models\User;
use Filament\Resources\Forms\Components\Select;
use Filament\Resources\Forms\Components\TextInput;
use Filament\Resources\Forms\Form;
use Filament\Resources\Resource;
use Filament\Resources\Tables\Columns\Boolean;
use Filament\Resources\Tables\Columns\Text;
use Filament\Resources\Tables\Table;
use Illuminate\Support\Arr;

class UserResource extends Resource
{
    public static $model = User::class;
    public static $icon = 'bx-user';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('id')->disabled(),
                TextInput::make('name')->disabled(),
                TextInput::make('full_name')->disabled(),
                TextInput::make('description')->disabled(),
                TextInput::make('email')->disabled(),
                TextInput::make('location')->disabled(),
                TextInput::make('twitter')->disabled(),
                TextInput::make('website')->disabled(),
                Select::make('block_reason') // ToDo: cast empty string to null
                    ->options(Arr::prepend(BlockReasonEnum::toArray(), '—', null))
                    ->nullable(),
                TextInput::make('blocked_at')->disabled(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Avatar::make('avatar_url')->label(''),
                Text::make('id')
                    ->primary()
                    ->searchable(),
                Text::make('name')
                    ->url(fn (User $record): string => $record->github_url, true)
                    ->searchable(),
                Text::make('full_name')
                    ->searchable(),
                Boolean::make('github_access_token')
                    ->label('GitHub')
                    ->sortable(),
                Boolean::make('blocked_at')
                    ->label('Blocked')
                    ->sortable(),
            ])
            ->defaultSort('id', 'desc')
            ->filters([]);
    }

    public static function relations(): array
    {
        return [
            OrganizationsRelationManager::class,
            RepositoriesRelationManager::class,
            ContributionsRelationManager::class,
        ];
    }

    public static function routes(): array
    {
        return [
            ListUsers::routeTo('/', 'index'),
            EditUser::routeTo('/{record}/edit', 'edit'),
        ];
    }
}
