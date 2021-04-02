<?php

namespace App\Eloquent\Concerns;

use App\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\Authorizable as IlluminateAuthorizable;
use Illuminate\Support\Str;

trait Authorizable
{
    use IlluminateAuthorizable;

    public function isAllowedTo(string $ability, Model | string | null $entity = null): bool
    {
        if ($entity === null) {
            return $this->can($ability);
        }

        return $this->can(implode('.', array_filter([
            Str::of(is_string($entity) ? $entity : get_class($entity))->classBasename()->slug('_')->pluralStudly(),
            $ability,
            $entity instanceof Model ? $entity->getKey() : null,
        ])));
    }
}
