<?php

namespace App\Eloquent;

use Illuminate\Database\Schema\Blueprint;
use Orbit\Concerns\Orbital;
use Orbit\Contracts\Orbit as OrbitContract;
use Spatie\Sluggable\HasSlug;

abstract class Orbit extends Model implements OrbitContract
{
    use HasSlug;
    use Orbital;

    public $incrementing = false;

    public $timestamps = false;

    protected $keyType = 'string';

    protected $primaryKey = 'slug';

    abstract public function schema(Blueprint $table): void;

    public function getOrbitSource(): string
    {
        return $this->getTable();
    }
}
