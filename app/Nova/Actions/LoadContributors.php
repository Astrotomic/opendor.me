<?php

namespace App\Nova\Actions;

use App\Eloquent\Model;
use App\Enums\License;
use App\Jobs\LoadRepositoryContributors;
use App\Models\Repository;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Http\Requests\ActionRequest;
use Laravel\Nova\Http\Requests\NovaRequest;

class LoadContributors extends Action
{
    use InteractsWithQueue;
    use Queueable;

    public $name = 'Load Contributors';

    public function __construct()
    {
        $this
            ->onlyOnDetail()
            ->canSee(fn (NovaRequest $request): bool => true)
            ->canRun(fn (ActionRequest $request, Repository $repository): bool => true);
    }

    public function handle(ActionFields $fields, Collection $models): void
    {
        $models->each(fn (Repository $repository) => LoadRepositoryContributors::dispatch($repository));
    }

    public function fields(): array
    {
        return [];
    }
}
