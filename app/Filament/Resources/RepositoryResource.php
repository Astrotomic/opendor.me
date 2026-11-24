<?php

namespace App\Filament\Resources;

use App\Filament\Resource;
use App\Filament\Resources\RepositoryResource\Pages\EditRepository;
use App\Filament\Resources\RepositoryResource\Pages\ListRepositories;
use App\Models\Repository;
use Filament\Forms\Form;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class RepositoryResource extends Resource
{
    protected static ?string $model = Repository::class;

    protected static ?string $navigationIcon = 'heroicon-o-archive-box';

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
                IconColumn::make('is_blocked')->boolean()->label('Blocked'),
                TextColumn::make('contributors_count')->counts('contributors')->sortable(),
            ])
            ->filters([
                //
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListRepositories::route('/'),
            'edit' => EditRepository::route('/{record}/edit'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['id', 'name'];
    }

    /**
     * @param  Repository  $record
     */
    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'ID' => $record->id,
        ];
    }
}
