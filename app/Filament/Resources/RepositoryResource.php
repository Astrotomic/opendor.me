<?php

namespace App\Filament\Resources;

use App\Enums\BlockReason as BlockReasonEnum;
use App\Filament\Resources\RepositoryResource\Pages\EditRepository;
use App\Filament\Resources\RepositoryResource\Pages\ListRepositories;
use App\Models\Repository;
use Filament\Resources\Forms\Components\Select;
use Filament\Resources\Forms\Components\TextInput;
use Filament\Resources\Forms\Form;
use Filament\Resources\Resource;
use Filament\Resources\Tables\Columns\Boolean;
use Filament\Resources\Tables\Columns\Text;
use Filament\Resources\Tables\Table;
use Illuminate\Support\Arr;

class RepositoryResource extends Resource
{
    public static $model = Repository::class;
    public static $label = 'Repositories';
    public static $icon = 'bx-package';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('id')->disabled(),
                TextInput::make('name')->disabled(),
                TextInput::make('licence')->disabled(),
                TextInput::make('language')->disabled(),
                TextInput::make('website')->disabled(),
                TextInput::make('stargazer_count')->label('Stars')->disabled(),
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
                Text::make('id')->primary()->sortable()->searchable(),
                Text::make('github_url')->url(fn ($record) => $record->github_url, true)->label('Name')->sortable(),
                Text::make('license')->sortable(),
                Text::make('language')->sortable()->searchable(),
                Boolean::make('blocked_at')->sortable(),
            ])
            ->filters([]);
    }

    public static function relations(): array
    {
        return [];
    }

    public static function routes(): array
    {
        return [
            ListRepositories::routeTo('/', 'index'),
            EditRepository::routeTo('/{record}/edit', 'edit'),
        ];
    }
}
