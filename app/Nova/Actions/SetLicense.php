<?php

namespace App\Nova\Actions;

use App\Eloquent\Model;
use App\Enums\License;
use App\Models\Repository;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Http\Requests\ActionRequest;
use Laravel\Nova\Http\Requests\NovaRequest;

class SetLicense extends Action
{
    use InteractsWithQueue;
    use Queueable;

    public $name = 'Set License';

    public function __construct()
    {
        $this
            ->onlyOnDetail()
            ->canSee(function (NovaRequest $request): bool {
                if ($request instanceof ActionRequest) {
                    return true;
                }

                return $request->findModelQuery()->first()?->license->equals(License::NOASSERTION()) ?? false;
            })
            ->canRun(fn (ActionRequest $request, Repository $repository): bool => $request->user()->can('license', $repository));
    }

    public function handle(ActionFields $fields, Collection $models): bool | array
    {
        if ($models->count() !== 1) {
            return Action::danger('You can only license one repository at a time.');
        }

        return $models->every(fn (Repository $repository): bool => $repository->update([
            'license' => $fields->license,
        ]));
    }

    public function fields(): array
    {
        return [
            Select::make('License')
                ->options(License::toArray())
                ->displayUsingLabels(),
        ];
    }
}
