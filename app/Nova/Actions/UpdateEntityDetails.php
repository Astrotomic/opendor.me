<?php

namespace App\Nova\Actions;

use App\Eloquent\Model;
use App\Jobs\UpdateOrganizationDetails;
use App\Jobs\UpdateRepositoryDetails;
use App\Jobs\UpdateUserDetails;
use App\Models\Organization;
use App\Models\Repository;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Http\Requests\ActionRequest;
use Laravel\Nova\Http\Requests\NovaRequest;

class UpdateEntityDetails extends Action
{
    use InteractsWithQueue;
    use Queueable;

    public $name = 'Update details';

    public function __construct()
    {
        $this
            ->canSee(fn (NovaRequest $request): bool => true)
            ->canRun(fn (ActionRequest $request, Model $model): bool => $request->user()->can('block', $model));
    }

    public function handle(ActionFields $fields, Collection $models): bool | array
    {
        return $models->every(function (Model $model): void {
            if ($model instanceof User) {
                UpdateUserDetails::dispatch($model);
            } elseif ($model instanceof Organization) {
                UpdateOrganizationDetails::dispatch($model);
            } elseif ($model instanceof Repository) {
                UpdateRepositoryDetails::dispatch($model);
            }
        });
    }

    public function fields(): array
    {
        return [];
    }
}
