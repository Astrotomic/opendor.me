<?php

namespace App\Nova;

use App\Enums\BlockReason as BlockReasonEnum;
use App\Models\User as UserModel;
use App\Nova\Actions\AnonymizeUser;
use App\Nova\Actions\BlockEntity;
use App\Nova\Actions\LoadRepositories;
use App\Nova\Actions\SyncOrganizations;
use App\Nova\Actions\UnblockEntity;
use App\Nova\Actions\UpdateEntityDetails;
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
use Vyuldashev\NovaPermission\RoleBooleanGroup;

class User extends Resource
{
    public static $model = UserModel::class;
    public static $group = 'GitHub';
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
                ->labelUsing(fn (string $url, UserModel $user): string => $user->name),

            Text::make('Full Name', 'full_name')
                ->readonly()
                ->hideFromIndex(),

            Text::make('Description')
                ->readonly()
                ->hideFromIndex(),

            Text::make('Email')
                ->sortable()
                ->readonly()
                ->displayUsing(fn (string $email) => Str::endsWith($email, '@users.noreply.github.com') ? null : $email),

            Text::make('Location')
                ->readonly()
                ->hideFromIndex(),

            Url::make('Twitter', 'twitter_url')
                ->readonly()
                ->hideFromIndex()
                ->alwaysClickable()
                ->labelUsing(fn (?string $url, UserModel $user): string => '@'.$user->twitter),

            Url::make('Website')
                ->readonly()
                ->alwaysClickable()
                ->hideFromIndex()
                ->domainLabel(),

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
                ->exceptOnForms()
                ->hideFromIndex(),

            Select::make('Block Reason', 'block_reason')
                ->options(BlockReasonEnum::toArray())
                ->nullable()
                ->exceptOnForms()
                ->hideFromIndex()
                ->displayUsingLabels(),

            BelongsToMany::make('Organizations', null, Organization::class),

            MorphMany::make('Repositories', null, Repository::class),

            BelongsToMany::make('Contributions', null, Repository::class),

            RoleBooleanGroup::make('Roles'),
        ];
    }

    public function cards(Request $request): array
    {
        return [
            RegisteredUsers::make(),
            EntitiesPerBlockReason::make(UserModel::class),
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
            UpdateEntityDetails::make(),
            AnonymizeUser::make(),
        ];
    }
}
