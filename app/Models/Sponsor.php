<?php

namespace App\Models;

use App\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Orbit\Concerns\Orbital;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Sponsor extends Model implements Sortable
{
    use SortableTrait;
    use Orbital;
    use HasSlug;

    public static $driver = 'yaml';

    public $incrementing = false;
    public $timestamps = false;

    protected $table = 'sponsors';
    protected $keyType = 'string';
    protected $primaryKey = 'slug';
    protected $guarded = [];

    protected $sortable = [
        'order_column_name' => 'priority',
        'sort_when_creating' => false,
    ];

    public static function schema(Blueprint $table): void
    {
        $table->string('slug')->primary();
        $table->integer('priority')->unsigned();
        $table->string('name');
        $table->string('url');
        $table->string('image');
    }

    public static function getOrbitalName(): string
    {
        return static::table();
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
                          ->generateSlugsFrom('name')
                          ->saveSlugsTo('slug');
    }
}
