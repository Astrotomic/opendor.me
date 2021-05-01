<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use App\Filament\Resources\Tables\Columns\Avatar;
use App\Models\Organization;
use Filament\Resources\Forms\Form;
use Filament\Resources\RelationManager;
use Filament\Resources\Tables\Columns\Boolean;
use Filament\Resources\Tables\Columns\Text;
use Filament\Resources\Tables\Table;

class OrganizationsRelationManager extends RelationManager
{
    public static $primaryColumn = '';

    public static $relationship = 'organizations';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Avatar::make('avatar_url')->label(''),
                Text::make('id')
                    ->primary()
                    ->sortable()
                    ->searchable(),
                Text::make('name')
                    ->url(fn (Organization $record) => $record->github_url, true)
                    ->sortable(),
                Boolean::make('blocked_at')
                    ->sortable(),
            ])
            ->defaultSort('id', 'desc')
            ->filters([]);
    }
}
