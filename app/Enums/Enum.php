<?php

namespace App\Enums;

use App\Eloquent\Casts\EnumCast;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Spatie\Enum\Laravel\Casts\EnumCollectionCast;
use Spatie\Enum\Laravel\Enum as SpatieEnum;

abstract class Enum extends SpatieEnum
{
    public static function castUsing(array $arguments): CastsAttributes
    {
        if (in_array('collection', $arguments)) {
            return new EnumCollectionCast(static::class, ...$arguments);
        }

        return new EnumCast(static::class, ...$arguments);
    }
}
