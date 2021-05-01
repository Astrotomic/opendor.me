<?php

namespace App\Eloquent\Casts;

use Spatie\Enum\Laravel\Casts\EnumCast as SpatieEnumCast;

class EnumCast extends SpatieEnumCast
{
    public function get($model, string $key, $value, array $attributes)
    {
        if ($value === '') {
            $value = null;
        }

        return parent::get($model, $key, $value, $attributes);
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  mixed  $value
     * @param  array  $attributes
     *
     * @return mixed
     */
    public function set($model, string $key, $value, array $attributes)
    {
        if ($value === '') {
            $value = null;
        }

        return parent::set($model, $key, $value, $attributes);
    }
}
