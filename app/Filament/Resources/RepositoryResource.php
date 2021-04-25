<?php

namespace App\Filament\Resources;

use App\Enums\BlockReason as BlockReasonEnum;
use App\Filament\Resources\RepositoryResource\Pages;
use App\Models\Repository;
use Filament\Resources\Forms\Components;
use Filament\Resources\Forms\Form;
use Filament\Resources\Resource;
use Filament\Resources\Tables\Columns;
use Filament\Resources\Tables\Table;
use Illuminate\Support\Arr;

class RepositoryResource extends Resource
{
    public static $model = Repository::class;
    public static $label = 'Repositories';
    public static $icon = 'bx-package';

    public static function form(Form $form)
    {
        return $form
            ->schema([
                Components\TextInput::make('id')->disabled(),
                Components\TextInput::make('name')->disabled(),
                Components\TextInput::make('licence')->disabled(),
                Components\TextInput::make('language')->disabled(),
                Components\TextInput::make('website')->disabled(),
                Components\TextInput::make('stargazer_count')->label('Stars')->disabled(),
                Components\Select::make('block_reason') // ToDo: cast empty string to null
                ->options(Arr::prepend(BlockReasonEnum::toArray(), '—', null))
                    ->nullable(),
                Components\TextInput::make('blocked_at')->disabled(),

            ]);
    }

    public static function table(Table $table)
    {
        return $table
            ->columns([
                Columns\Text::make('id')->primary()->sortable()->searchable(),
                Columns\Text::make('github_url')->url(fn ($record) => $record->github_url, true)->label('Name')->sortable(),
                Columns\Text::make('license')->sortable(),
                Columns\Text::make('language')->sortable()->searchable(),
                Columns\Boolean::make('blocked_at')->sortable(),
            ])
            ->filters([
                //
            ]);
    }

    public static function relations()
    {
        return [
            //
        ];
    }

    public static function routes()
    {
        return [
            Pages\ListRepositories::routeTo('/', 'index'),
            Pages\EditRepository::routeTo('/{record}/edit', 'edit'),
        ];
    }
}
