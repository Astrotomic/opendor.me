<?php

namespace App\Nova;

use App\Enums\BlockReason as BlockReasonEnum;
use App\Nova\Actions\BlockEntity;
use App\Nova\Actions\UnblockEntity;
use App\Nova\Fields\Avatar;
use App\Nova\Filters\BlockReason;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\MorphMany;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;

class Organization extends Resource
{
    public static $model = \App\Models\Organization::class;
    public static $title = 'name';
    public static $search = [
        'id', 'name',
    ];

    public function fields(Request $request): array
    {
        return [
            Avatar::make('Avatar', 'avatar_url'),

            ID::make()->sortable(),

            Text::make('Name')
                ->sortable()
                ->readonly(),

            Boolean::make('Blocked', 'blocked_at')
                ->sortable()
                ->readonly()
                ->onlyOnIndex(),

            DateTime::make('Blocked at', 'blocked_at')
                ->readonly()
                ->hideFromIndex(),

            Select::make('Block Reason', 'block_reason')
                ->options(BlockReasonEnum::toArray())
                ->nullable()
                ->hideFromIndex()
                ->displayUsingLabels(),

            BelongsToMany::make('Members', null, User::class),

            MorphMany::make('Repositories', null, Repository::class),
        ];
    }

    public function cards(Request $request): array
    {
        return [];
    }

    public function filters(Request $request): array
    {
        return [
            BlockReason::make(),
        ];
    }

    public function lenses(Request $request): array
    {
        return [];
    }

    public function actions(Request $request): array
    {
        return [
            BlockEntity::make(),
            UnblockEntity::make(),
        ];
    }
}
