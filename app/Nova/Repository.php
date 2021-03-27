<?php

namespace App\Nova;

use App\Enums\BlockReason as BlockReasonEnum;
use App\Enums\Language as LanguageEnum;
use App\Enums\License as LicenseEnum;
use App\Nova\Actions\AddRepository;
use App\Nova\Actions\BlockEntity;
use App\Nova\Actions\LoadContributors;
use App\Nova\Actions\SetLanguage;
use App\Nova\Actions\SetLicense;
use App\Nova\Actions\UnblockEntity;
use App\Nova\Actions\UpdateEntityDetails;
use App\Nova\Filters\BlockReason;
use App\Nova\Filters\Language;
use App\Nova\Filters\License;
use App\Nova\Metrics\EntitiesPerBlockReason;
use App\Nova\Metrics\RepositoriesPerLanguage;
use App\Nova\Metrics\RepositoriesPerLicense;
use Illuminate\Http\Request;
use Inspheric\Fields\Url;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\MorphTo;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;

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

            Url::make('Name', 'github_url')
                ->sortable()
                ->readonly()
                ->alwaysClickable()
                ->labelUsing(fn (string $url, \App\Models\Repository $repository): string => $repository->name),

            Text::make('Description')
                ->readonly()
                ->hideFromIndex(),

            Select::make('License')
                ->options(LicenseEnum::toArray())
                ->sortable()
                ->displayUsingLabels(),

            Select::make('Language')
                ->options(LanguageEnum::toArray())
                ->sortable()
                ->displayUsingLabels(),

            Url::make('Website')
                ->readonly()
                ->alwaysClickable()
                ->hideFromIndex(),

            Number::make('Stars', 'stargazers_count')
                ->readonly()
                ->hideFromIndex(),

            Boolean::make('Blocked', 'blocked_at')
                ->sortable()
                ->readonly()
                ->onlyOnIndex(),

            DateTime::make('Blocked at', 'blocked_at')
                ->exceptOnForms()
                ->hideFromIndex(),

            Select::make('Block Reason', 'block_reason')
                ->options(BlockReasonEnum::toArray())
                ->nullable()
                ->exceptOnForms()
                ->hideFromIndex()
                ->displayUsingLabels(),

            MorphTo::make('Owner')
                ->exceptOnForms(),

            BelongsToMany::make('Contributors', null, User::class),
        ];
    }

    public function cards(Request $request): array
    {
        return [
            RepositoriesPerLicense::make(),
            RepositoriesPerLanguage::make(),
            EntitiesPerBlockReason::make(\App\Models\Repository::class),
        ];
    }

    public function filters(Request $request): array
    {
        return [
            BlockReason::make(),
            License::make(),
            Language::make(),
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
            SetLanguage::make(),
            LoadContributors::make(),
            UpdateEntityDetails::make(),
        ];
    }
}
