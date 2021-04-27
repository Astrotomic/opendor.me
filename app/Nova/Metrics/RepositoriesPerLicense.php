<?php

namespace App\Nova\Metrics;

use App\Enums\License;
use App\Models\Repository;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\PartitionResult;

class RepositoriesPerLicense extends Partition
{
    public function calculate(NovaRequest $request): PartitionResult
    {
        return $this->count(
            $request,
            Repository::query()
                ->withCasts(['license' => 'string'])
                ->orderBy('license'),
            'license'
        )
            ->label(function (string $value) {
                return License::make($value)->label;
            });
    }
}