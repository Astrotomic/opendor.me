<?php

namespace App\Nova;

use App\Enums\BlockReason as BlockReasonEnum;
use App\Enums\Language;
use App\Enums\License;
use App\Nova\Actions\AddRepository;
use App\Nova\Actions\BlockEntity;
use App\Nova\Actions\LoadContributors;
use App\Nova\Actions\SetLicense;
use App\Nova\Actions\UnblockEntity;
use App\Nova\Filters\BlockReason;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\MorphTo;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Repository extends Resource
{
    public static $model = \App\Models\Repository::class;
    public static $title = 'name';
    public static $search = [
        'id', 'name', 'license', 'language',
    ];

    public function fields(Request $request): array
    {
        return [
            ID::make()->sortable(),

            Text::make('Name')
                ->sortable()
                ->readonly(),

            Select::make('License')
                ->options(License::toArray())
                ->sortable()
                ->readonly()
                ->displayUsingLabels(),

            Select::make('Language')
                ->options(Language::toArray())
                ->sortable()
                ->readonly(fn (NovaRequest $request) => $request->isResourceIndexRequest() || $request->findModelOrFail()->language !== null)
                ->displayUsingLabels(),

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

            MorphTo::make('Owner')
                ->exceptOnForms(),

            BelongsToMany::make('Contributors', null, User::class),
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
            AddRepository::make(),
            BlockEntity::make(),
            UnblockEntity::make(),
            SetLicense::make(),
            LoadContributors::make(),
        ];
    }
}