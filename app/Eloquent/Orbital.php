<?php

namespace App\Eloquent;

use Illuminate\Database\Schema\Blueprint;
use Spatie\Sluggable\HasSlug;

abstract class Orbital extends Model
{
    use \Orbit\Concerns\Orbital;
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
