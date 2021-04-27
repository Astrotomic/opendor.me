<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrganizationResource\Pages\EditOrganization;
use App\Filament\Resources\OrganizationResource\Pages\ListOrganizations;
use App\Filament\Resources\Tables\Columns\Avatar;
use App\Models\Organization;
use Filament\Resources\Forms\Form;
use Filament\Resources\Resource;
use Filament\Resources\Tables\Columns\Boolean;
use Filament\Resources\Tables\Columns\Text;
use Filament\Resources\Tables\Table;

class OrganizationResource extends Resource
{
    public static $model = Organization::class;
    public static $label = 'Organizations';
    public static $icon = 'bx-buildings';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Avatar::make('avatar_url')->label(''),
                Text::make('id')->primary()->sortable()->searchable(),
                Text::make('name')->url(fn (Organization $record) => $record->github_url, true)->sortable(),
                Boolean::make('blocked_at')->sortable(),
            ])
            ->defaultSort('id', 'desc')
            ->filters([]);
    }

    public static function relations(): array
    {
        return [];
    }

    public static function routes(): array
    {
        return [
            ListOrganizations::routeTo('/', 'index'),
            EditOrganization::routeTo('/{record}/edit', 'edit'),
        ];
    }
}
