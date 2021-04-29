<?php

namespace App\Eloquent;

use Illuminate\Database\Schema\Blueprint;
use Orbit\Concerns\Orbital;
use Spatie\Sluggable\HasSlug;

abstract class Orbit extends Model
{
    use Orbital;
    use HasSlug;

    public $incrementing = false;
    public $timestamps = false;

    protected $keyType = 'string';
    protected $primaryKey = 'slug';

    abstract public static function schema(Blueprint $table): void;

    public static function getOrbitalName(): string
    {
        return static::table();
    }
}
