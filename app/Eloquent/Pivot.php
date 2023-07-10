<?php

namespace App\Eloquent;

use Illuminate\Database\Eloquent\Relations\Concerns\AsPivot;
use Illuminate\Support\Str;

abstract class Pivot extends Model
{
    use AsPivot;

    public $incrementing = false;

    public function getTable(): string
    {
        return $this->table ?? Str::of(static::class)
            ->classBasename()
            ->replaceLast('Pivot', '')
            ->singular()
            ->snake();
    }
}
