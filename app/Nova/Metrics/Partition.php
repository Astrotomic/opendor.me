<?php

namespace App\Nova\Metrics;

use Laravel\Nova\Metrics\Partition as NovaPartition;
use Laravel\Nova\Metrics\PartitionResult;

abstract class Partition extends NovaPartition
{
    public function result(array $value): PartitionResult
    {
        return new PartitionResult(collect($value)->map(function ($number) {
            return round($number, $this->roundingPrecision, $this->roundingMode);
        })->sortByDesc(null)->toArray());
    }
}
