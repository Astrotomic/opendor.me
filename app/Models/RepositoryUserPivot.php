<?php

namespace App\Models;

use App\Eloquent\Pivot;

/**
 * @property int $repository_id
 * @property int $user_id
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RepositoryUserPivot query()
 */
class RepositoryUserPivot extends Pivot
{
    //
}
