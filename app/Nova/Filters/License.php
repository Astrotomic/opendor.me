<?php

namespace App\Nova\Filters;

use App\Enums\License as LicenseEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Laravel\Nova\Filters\Filter;

class License extends Filter
{
    public $component = 'select-filter';

    /**
     * Apply the filter to the given query.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  mixed  $value
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply(Request $request, $query, $value): Builder
    {
        return $query->where('license', LicenseEnum::make($value));
    }

    public function options(Request $request): array
    {
        return array_flip(LicenseEnum::toArray());
    }
}
