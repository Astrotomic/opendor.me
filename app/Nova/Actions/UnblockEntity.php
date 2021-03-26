<?php

namespace App\Nova\Actions;

use App\Eloquent\Model;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Http\Requests\ActionRequest;
use Laravel\Nova\Http\Requests\NovaRequest;

class UnblockEntity extends Action
{
    use InteractsWithQueue;
    use Queueable;

    public $name = 'Unblock';

    public function __construct()
    {
        $this
            ->canSee(fn (NovaRequest $request): bool => true)
            ->canRun(fn (ActionRequest $request, Model $model): bool => $request->user()->can('unblock', $model));
    }

    public function handle(ActionFields $fields, Collection $models): bool | array
    {
        return $models->every(fn (Model $model): bool => $model->update([
            'blocked_at' => null,
            'block_reason' => null,
        ]));
    }

    public function fields(): array
    {
        return [];
    }
}
