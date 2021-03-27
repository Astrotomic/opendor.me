<?php

namespace App\Nova\Actions;

use App\Enums\Language;
use App\Models\Repository;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Http\Requests\ActionRequest;
use Laravel\Nova\Http\Requests\NovaRequest;

class SetLanguage extends Action
{
    use InteractsWithQueue;
    use Queueable;

    public $name = 'Set Language';

    public function __construct()
    {
        $this
            ->onlyOnDetail()
            ->canSee(function (NovaRequest $request): bool {
                if ($request instanceof ActionRequest) {
                    return true;
                }

                return $request->findModelQuery()->first()?->language->equals(Language::NOASSERTION()) ?? false;
            })
            ->canRun(fn (ActionRequest $request, Repository $repository): bool => $request->user()->can('language', $repository));
    }

    public function handle(ActionFields $fields, Collection $models): bool | array
    {
        return $models->every(fn (Repository $repository): bool => $repository->update([
            'language' => $fields->language,
        ]));
    }

    public function fields(): array
    {
        return [
            Select::make('Language')
                ->options(Language::toArray())
                ->displayUsingLabels(),
        ];
    }
}
