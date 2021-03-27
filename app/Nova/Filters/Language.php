<?php

namespace App\Nova\Filters;

use App\Enums\Language as LanguageEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Laravel\Nova\Filters\Filter;

class Language extends Filter
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
        return $query->where('language', LanguageEnum::make($value));
    }

    public function options(Request $request): array
    {
        return array_flip(LanguageEnum::toArray());
    }
}
