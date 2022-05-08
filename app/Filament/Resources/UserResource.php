<?php

namespace App\Filament\Resources;

use App\Eloquent\QueryBuilders\UserQueryBuilder;
use App\Enums\BlockReason;
use App\Filament\Resource;
use App\Filament\Resources\UserResource\Pages\EditUser;
use App\Filament\Resources\UserResource\Pages\ListUsers;
use App\Models\User;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('id')->disabled(),
            TextInput::make('name')->disabled(),
            TextInput::make('full_name')->disabled(),
            DateTimePicker::make('registered_at')->disabled(),
            Toggle::make('is_registered')->inline(false)->disabled(),
            Toggle::make('is_superadmin')->inline(false)->disabled(),
            TextInput::make('description')->disabled(),
            TextInput::make('location')->disabled(),
            TextInput::make('twitter')->disabled(),
            TextInput::make('website')->url()->disabled(),
            TagsInput::make('referrer')->disabled(),
            Toggle::make('is_blocked')->inline(false)->disabled(),
            Select::make('block_reason')->options(BlockReason::toArray()),
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
                BooleanColumn::make('is_registered')->label('Registered'),
                BooleanColumn::make('is_blocked')->label('Blocked'),
                TextColumn::make('contributions_count')->counts('contributions')->sortable(),
            ])
            ->filters([
                Filter::make('is_registered')->default()->query(fn (UserQueryBuilder $query): UserQueryBuilder => $query->whereIsRegistered()),
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
            'index' => ListUsers::route('/'),
            'edit' => EditUser::route('/{record}/edit'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['id', 'name', 'full_name'];
    }

    /**
     * @param \App\Models\User $record
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
