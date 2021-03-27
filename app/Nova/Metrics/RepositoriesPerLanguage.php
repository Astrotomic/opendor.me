<?php

namespace App\Nova\Metrics;

use App\Eloquent\Scopes\OrderByScope;
use App\Enums\Language;
use App\Models\Repository;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Partition;
use Laravel\Nova\Metrics\PartitionResult;

class RepositoriesPerLanguage extends Partition
{
    public function calculate(NovaRequest $request): PartitionResult
    {
        return $this->count(
            $request,
            Repository::query()
                ->withoutGlobalScope(OrderByScope::class)
                ->withCasts(['language' => 'string'])
                ->orderBy('language'),
            'language'
        )
            ->label(function (string $value) {
                return Language::make($value)->label;
            });
    }
}
