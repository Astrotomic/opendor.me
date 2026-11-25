<?php

namespace App\Filament\Resources;

use App\Filament\Resource;
use App\Filament\Resources\OrganizationResource\Pages\EditOrganization;
use App\Filament\Resources\OrganizationResource\Pages\ListOrganizations;
use App\Models\Organization;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class OrganizationResource extends Resource
{
    protected static ?string $model = Organization::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-briefcase';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            //
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('avatar_url')->label('Avatar')->rounded(),
                TextColumn::make('id')->sortable()->searchable(),
                TextColumn::make('name')->sortable()->searchable(),
                TextColumn::make('full_name')->sortable()->searchable(),
                IconColumn::make('is_verified')->boolean()->sortable()->label('Verified'),
                IconColumn::make('is_blocked')->boolean()->label('Blocked'),
                TextColumn::make('members_count')->counts('members')->sortable(),
            ])
            ->filters([
                Filter::make('is_blocked')->query(fn (Builder $query): Builder => $query->onlyBlocked()),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListOrganizations::route('/'),
            'edit' => EditOrganization::route('/{record}/edit'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['id', 'name', 'full_name'];
    }

    /**
     * @param  Organization  $record
     */
    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'ID' => $record->id,
            'Name' => $record->display_name,
        ];
    }
}
