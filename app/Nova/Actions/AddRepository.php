<?php

namespace App\Nova\Actions;

use App\Models\Repository;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\ActionRequest;
use Laravel\Nova\Http\Requests\NovaRequest;

class AddRepository extends Action
{
    use InteractsWithQueue;
    use Queueable;

    public $name = 'Add Repository';

    public function __construct()
    {
        $this
            ->onlyOnIndex()
            ->standalone()
            ->canSee(fn (NovaRequest $request): bool => true)
            ->canRun(fn (ActionRequest $request): bool => $request->user()->can('add', Repository::class));
    }

    public function handle(ActionFields $fields): array
    {
        $repository = Repository::fromName($fields->name, true);

        if ($repository === null) {
            return Action::danger("Failed to add [{$fields->name}] repository.");
        }

        return Action::push("/resources/repositories/{$repository->id}", [
            'viaResource' => 'repositories',
            'viaResourceId' => null,
            'viaRelationship' => null,
        ]);
    }

    public function fields(): array
    {
        return [
            Text::make('Repository Name', 'name')
                ->required(),
        ];
    }
}
