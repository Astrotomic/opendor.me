<?php

namespace App\Filament\Resources\GithubUserResource\RelationManagers;

use Filament\Resources\Forms\Components;
use Filament\Resources\Forms\Form;
use Filament\Resources\RelationManager;
use Filament\Resources\Tables\Columns;
use Filament\Resources\Tables\Filter;
use Filament\Resources\Tables\Table;

class ContributionsRelationManager extends RelationManager
{
    public static $primaryColumn = '';

    public static $relationship = 'contributions';

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
                Columns\Text::make('id')->primary()->sortable('id')->searchable(),
                Columns\Text::make('github_url')->url(fn ($record) => $record->github_url, true)->label('Name')->sortable(),
                Columns\Text::make('license')->sortable(),
                Columns\Text::make('language')->sortable()->searchable(),
                Columns\Boolean::make('blocked_at')->sortable(),
            ])
            ->defaultSort('id', 'desc')
            ->filters([
                //
            ]);
    }
}
