<?php

namespace App\Nova\Actions;

use App\Eloquent\Model;
use App\Enums\BlockReason;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Http\Requests\ActionRequest;
use Laravel\Nova\Http\Requests\NovaRequest;

class BlockEntity extends Action
{
    use InteractsWithQueue;
    use Queueable;

    public $name = 'Block';

    public function __construct()
    {
        $this
            ->onlyOnDetail()
            ->canSee(function (NovaRequest $request): bool {
                if ($request instanceof ActionRequest) {
                    return true;
                }

                return ! ($request->findModelQuery()->first()?->is_blocked ?? false);
            })
            ->canRun(fn (ActionRequest $request, Model $model): bool => $request->user()->can('block', $model));
    }

    public function handle(ActionFields $fields, Collection $models): bool | array
    {
        if ($models->count() !== 1) {
            return Action::danger('You can only block one entity at a time.');
        }

        return $models->every(fn (Model $model): bool => $model->update([
            'blocked_at' => now(),
            'block_reason' => $fields->block_reason,
        ]));
    }

    public function fields(): array
    {
        return [
            Select::make('Block Reason', 'block_reason')
                ->options(BlockReason::toArray())
                ->required()
                ->displayUsingLabels(),
        ];
    }
}
