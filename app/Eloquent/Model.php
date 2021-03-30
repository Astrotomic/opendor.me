<?php

namespace App\Eloquent;

use Astrotomic\CachableAttributes\CachesAttributes;
use Carbon\CarbonInterval;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model as IlluminateModel;
use Illuminate\Support\Str;

abstract class Model extends IlluminateModel
{
    use HasFactory;
    use CachesAttributes;

    protected $guarded = [];

    public static function table(): string
    {
        return (new static())->getTable();
    }

    public function delete()
    {
        return $this->getConnection()->transaction(fn (): ?bool => parent::delete());
    }

    public function getAttribute($key)
    {
        $value = parent::getAttribute($key);

        if ($value !== null) {
            return $value;
        }

        if (Str::endsWith($key, '_count')) {
            $method = Str::before($key, '_count');

            if (method_exists($this, $method)) {
                return $this->remember(
                    $key,
                    CarbonInterval::minutes(1)->totalSeconds,
                    fn () => $this->$method()->count()
                );
            }
        }
    }
}
