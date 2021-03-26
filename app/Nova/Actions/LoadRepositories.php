<?php

namespace App\Nova\Actions;

use App\Eloquent\Model;
use App\Jobs\LoadOrganizationRepositories;
use App\Jobs\LoadUserRepositories;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Http\Requests\ActionRequest;
use Laravel\Nova\Http\Requests\NovaRequest;

class LoadRepositories extends Action
{
    use InteractsWithQueue;
    use Queueable;

    public $name = 'Load Repositories';

    public function __construct()
    {
        $this
            ->onlyOnDetail()
            ->canSee(fn (NovaRequest $request): bool => true)
            ->canRun(fn (ActionRequest $request, Model $model): bool => true);
    }

    public function handle(ActionFields $fields, Collection $models): void
    {
        $models->each(function (Model $model) {
            if ($model instanceof User) {
                LoadUserRepositories::dispatch($model);
            } elseif ($model instanceof Organization) {
                LoadOrganizationRepositories::dispatch($model);
            }
        });
    }

    public function fields(): array
    {
        return [];
    }
}
