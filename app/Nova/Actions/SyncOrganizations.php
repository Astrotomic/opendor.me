<?php

namespace App\Nova\Actions;

use App\Jobs\SyncUserOrganizations;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Http\Requests\ActionRequest;
use Laravel\Nova\Http\Requests\NovaRequest;

class SyncOrganizations extends Action
{
    use InteractsWithQueue;
    use Queueable;

    public $name = 'Sync Organizations';

    public function __construct()
    {
        $this
            ->onlyOnDetail()
            ->canSee(fn (NovaRequest $request): bool => true)
            ->canRun(fn (ActionRequest $request, User $user): bool => true);
    }

    public function handle(ActionFields $fields, Collection $models): void
    {
        $models->each(fn (User $user) => SyncUserOrganizations::dispatch($user));
    }

    public function fields(): array
    {
        return [];
    }
}
