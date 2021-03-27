<?php

namespace App\Nova;

use App\Enums\BlockReason as BlockReasonEnum;
use App\Nova\Actions\BlockEntity;
use App\Nova\Actions\LoadRepositories;
use App\Nova\Actions\SyncOrganizations;
use App\Nova\Actions\UnblockEntity;
use App\Nova\Fields\Avatar;
use App\Nova\Filters\BlockReason;
use App\Nova\Metrics\EntitiesPerBlockReason;
use App\Nova\Metrics\RegisteredUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inspheric\Fields\Url;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\MorphMany;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;

class User extends Resource
{
    public static $model = \App\Models\User::class;
    public static $title = 'name';
    public static $search = [
        'id', 'name', 'email',
    ];

    public function fields(Request $request): array
    {
        return [
            Avatar::make('Avatar', 'avatar_url'),

            ID::make()->sortable(),

            Url::make('Name', 'github_url')
                ->sortable()
                ->readonly()
                ->alwaysClickable()
                ->labelUsing(fn (string $url, \App\Models\User $user): string => $user->name),

            Text::make('Email')
                ->sortable()
                ->readonly()
                ->displayUsing(fn (string $email) => Str::endsWith($email, '@users.noreply.github.com') ? null : $email),

            Boolean::make('Admin', 'is_admin')
                ->sortable(),

            Boolean::make('GitHub', 'github_access_token')
                ->sortable()
                ->readonly()
                ->exceptOnForms(),

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

            BelongsToMany::make('Organizations', null, Organization::class),

            MorphMany::make('Repositories', null, Repository::class),

            BelongsToMany::make('Contributions', null, Repository::class),
        ];
    }

    public function cards(Request $request): array
    {
        return [
            RegisteredUsers::make(),
            EntitiesPerBlockReason::make(\App\Models\User::class),
        ];
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
            SyncOrganizations::make(),
            LoadRepositories::make(),
        ];
    }
}
