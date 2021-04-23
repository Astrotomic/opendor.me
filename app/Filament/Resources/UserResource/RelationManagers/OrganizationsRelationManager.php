<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use App\Filament\Resources\Tables\Columns\Avatar;
use Filament\Resources\Forms\Form;
use Filament\Resources\RelationManager;
use Filament\Resources\Tables\Columns;
use Filament\Resources\Tables\Table;

class OrganizationsRelationManager extends RelationManager
{
    public static $primaryColumn = '';

    public static $relationship = 'organizations';

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
}
