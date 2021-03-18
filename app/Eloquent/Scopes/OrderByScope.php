<?php

namespace App\Eloquent\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

final class OrderByScope implements Scope
{
    public function __construct(protected string $column, protected string $direction = 'asc')
    {
    }

    public function apply(Builder $builder, Model $model): void
    {
        $builder->orderBy($this->column, $this->direction);
    }
}
