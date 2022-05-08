<?php

namespace App\Filament\Resources;

use App\Filament\Resource;
use App\Filament\Resources\OrganizationResource\Pages\EditOrganization;
use App\Filament\Resources\OrganizationResource\Pages\ListOrganizations;
use App\Models\Organization;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class OrganizationResource extends Resource
{
    protected static ?string $model = Organization::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';

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
                ImageColumn::make('avatar_url')->label('Avatar')->rounded(),
                TextColumn::make('id')->sortable()->searchable(),
                TextColumn::make('name')->sortable()->searchable(),
                TextColumn::make('full_name')->sortable()->searchable(),
                BooleanColumn::make('is_verified')->sortable()->label('Verified'),
                BooleanColumn::make('is_blocked')->label('Blocked'),
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
     * @param \App\Models\Organization $record
     *
     * @return array
     */
    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'ID' => $record->id,
            'Name' => $record->display_name,
        ];
    }
}
