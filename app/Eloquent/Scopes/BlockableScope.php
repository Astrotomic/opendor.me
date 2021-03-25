<?php

namespace App\Eloquent\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

final class BlockableScope implements Scope
{
    public function apply(Builder $builder, Model $model): void
    {
        $builder->whereNull('blocked_at');
    }

    public function extend(Builder $builder): void
    {
        $builder->macro('withBlocked', function (Builder $builder, bool $withBlocked = true): Builder {
            if (! $withBlocked) {
                return $builder->withoutBlocked();
            }

            return $builder->withoutGlobalScope($this);
        });
    }
}
