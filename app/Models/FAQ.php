<?php

namespace App\Models;

use App\Eloquent\Orbit;
use Illuminate\Database\Schema\Blueprint;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\Sluggable\SlugOptions;

/**
 * @property string $slug
 * @property int $priority
 * @property string $question
 * @property int $is_draft
 * @property string|null $content
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FAQ ordered(string $direction = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FAQ query()
 */
class FAQ extends Orbit implements Sortable
{
    use SortableTrait;

    protected $table = 'faqs';

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

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('question')
            ->saveSlugsTo('slug');
    }
}
