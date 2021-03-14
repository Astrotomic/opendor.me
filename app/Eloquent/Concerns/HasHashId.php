<?php

namespace App\Eloquent\Concerns;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Vinkla\Hashids\Facades\Hashids;

trait HasHashId
{
    public function getRouteKey(): string
    {
        return $this->getHashId();
    }

    public function getHashId(?string $key = null): string
    {
        return Hashids::encode($this->getAttribute($key ?? $this->getRouteKeyName()));
    }

    /**
     * @param mixed $value
     * @param string|null $field
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function resolveRouteBinding($value, $field = null): ?Model
    {
        if ($field === null) {
            $value = Arr::first(Hashids::decode($value));
        }

        return parent::resolveRouteBinding($value, $field);
    }
}
