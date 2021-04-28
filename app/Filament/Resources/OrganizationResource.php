<?php

namespace App\Filament\Resources;

use App\Enums\BlockReason as BlockReasonEnum;
use App\Filament\Resources\OrganizationResource\Pages\EditOrganization;
use App\Filament\Resources\OrganizationResource\Pages\ListOrganizations;
use App\Filament\Resources\Tables\Columns\Avatar;
use App\Models\Organization;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Forms\Components\Select;
use Filament\Resources\Forms\Components\TextInput;
use Filament\Resources\Forms\Form;
use Filament\Resources\Resource;
use Filament\Resources\Tables\Columns\Boolean;
use Filament\Resources\Tables\Columns\Text;
use Filament\Resources\Tables\Table;
use Illuminate\Support\Arr;

class OrganizationResource extends Resource
{
    public static $model = Organization::class;
    public static $label = 'Organizations';
    public static $icon = 'bx-buildings';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('id')->disabled(),
                TextInput::make('full_name')->disabled(),
                TextInput::make('description')->disabled(),
                TextInput::make('location')->disabled(),
                TextInput::make('twitter')->disabled(),
                TextInput::make('website')->disabled(),
                Select::make('block_reason') // ToDo: cast empty string to null
                      ->options(Arr::prepend(BlockReasonEnum::toArray(), '—', null))
                      ->nullable(),
                TextInput::make('blocked_at')->disabled(),
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
