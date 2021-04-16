<?php

namespace App\Nova\Actions;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Http\Requests\ActionRequest;
use Laravel\Nova\Http\Requests\NovaRequest;

class AnonymizeUser extends Action
{
    use InteractsWithQueue;
    use Queueable;

    public $name = 'Anonymize User';

    public function __construct()
    {
        $this
            ->onlyOnDetail()
            ->canSee(fn (NovaRequest $request): bool => true)
            ->canRun(fn (ActionRequest $request, User $user): bool => true);
    }

    public function handle(ActionFields $fields, Collection $models): void
    {
        $models->each(function (User $user) {
            $user->forceFill(['github_access_token' => null])->save();
        });
    }

    public function fields(): array
    {
        return [];
    }
}
