<?php

namespace App\Filament\Resources;

use App\Filament\Resource;
use App\Filament\Resources\RepositoryResource\Pages;
use App\Models\Repository;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;

class RepositoryResource extends Resource
{
    protected static ?string $model = Repository::class;

    protected static ?string $navigationIcon = 'heroicon-o-archive';

    public static function form(Form $form): Form
    {
        return $form->schema([
            //
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable()->searchable(),
                TextColumn::make('name')->sortable()->searchable(),
                TextColumn::make('license')->sortable()->searchable(),
                TextColumn::make('language')->sortable()->searchable(),
                TextColumn::make('stargazers_count')->sortable()->label('Stars'),
                BooleanColumn::make('is_blocked')->label('Blocked'),
                TextColumn::make('contributors_count')->counts('contributors')->sortable(),
            ])
            ->filters([
                //
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRepositories::route('/'),
            'edit' => Pages\EditRepository::route('/{record}/edit'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['id', 'name'];
    }

    /**
     * @param \App\Models\Repository $record
     *
     * @return array
     */
    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'ID' => $record->id,
        ];
    }
}
