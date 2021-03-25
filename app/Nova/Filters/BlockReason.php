<?php

namespace App\Nova\Filters;

use App\Enums\BlockReason as BlockReasonEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Laravel\Nova\Filters\Filter;

class BlockReason extends Filter
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
        return $query->where('block_reason', BlockReasonEnum::make($value));
    }

    public function options(Request $request): array
    {
        return array_flip(BlockReasonEnum::toArray());
    }
}
