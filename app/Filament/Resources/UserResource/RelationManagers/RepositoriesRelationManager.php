<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use App\Models\Repository;
use Filament\Resources\Forms\Form;
use Filament\Resources\RelationManager;
use Filament\Resources\Tables\Columns\Boolean;
use Filament\Resources\Tables\Columns\Text;
use Filament\Resources\Tables\Table;

class RepositoriesRelationManager extends RelationManager
{
    public static $primaryColumn = '';

    public static $relationship = 'repositories';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Text::make('id')
                    ->primary()
                    ->sortable()
                    ->searchable(),
                Text::make('name')
                    ->url(fn (Repository $record) => $record->github_url, true)
                    ->sortable(),
                Text::make('license')
                    ->sortable(),
                Text::make('language')
                    ->sortable()
                    ->searchable(),
                Boolean::make('blocked_at')
                    ->sortable(),
            ])
            ->defaultSort('id', 'desc')
            ->filters([]);
    }
}
