<?php

namespace App\Models;

use Illuminate\Database\Schema\Blueprint;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
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
class FAQ extends \App\Eloquent\Orbital implements Sortable
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
