<?php

namespace App\Models;

use App\Eloquent\Model;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

/**
 * App\Models\FAQ.
 *
 * @property int $id
 * @property int $priority
 * @property string $question
 * @property string $answer
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
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

    protected $table = 'faqs';

    protected array $sortable = [
        'order_column_name' => 'priority',
        'sort_when_creating' => true,
    ];

    protected $casts = [
        'priority' => 'int',
    ];
}
