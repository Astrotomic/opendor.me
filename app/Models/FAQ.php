<?php

namespace App\Models;

use App\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Orbit\Concerns\Orbital;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

/**
 * App\Models\FAQ.
 *
 * @property string $slug
 * @property int $priority
 * @property string $question
 * @property string|null $content
 *
 * @method static \Illuminate\Database\Eloquent\Builder|FAQ newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FAQ newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FAQ ordered(string $direction = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|FAQ query()
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class FAQ extends Model implements Sortable
{
    use SortableTrait;
    use Orbital;
    use HasSlug;

    public $incrementing = false;
    public $timestamps = false;

    protected $table = 'faqs';
    protected $keyType = 'string';
    protected $primaryKey = 'slug';
    protected $guarded = [];

    protected $sortable = [
        'order_column_name' => 'priority',
        'sort_when_creating' => false,
    ];

    protected $casts = [
        'priority' => 'int',
    ];

    public static function schema(Blueprint $table): void
    {
        $table->string('slug')->primary();
        $table->integer('priority')->unsigned();
        $table->string('question');
        $table->boolean('is_draft')->default(false);
    }

    public static function getOrbitalName(): string
    {
        return static::table();
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('question')
            ->saveSlugsTo('slug');
    }
}
