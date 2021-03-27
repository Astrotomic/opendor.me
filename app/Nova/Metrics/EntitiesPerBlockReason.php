<?php

namespace App\Nova\Metrics;

use App\Enums\BlockReason;
use Illuminate\Support\Str;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Partition;
use Laravel\Nova\Metrics\PartitionResult;

class EntitiesPerBlockReason extends Partition
{
    /**
     * @param string|\Illuminate\Database\Eloquent\Model $model
     */
    public function __construct(protected string $model)
    {
        parent::__construct(null);
    }

    public function calculate(NovaRequest $request): PartitionResult
    {
        return $this->count(
            $request,
            $this->model::query()
                ->withoutGlobalScopes()
                ->withCasts(['block_reason' => 'string'])
                ->orderBy('block_reason'),
            'block_reason'
        )
            ->label(function (?string $value) {
                return $value ? BlockReason::make($value)->label : 'n/a';
            });
    }

    public function name(): string
    {
        return Str::of($this->model)
            ->classBasename()
            ->pluralStudly()
            ->append(' per Block-Reason');
    }
}
