<?php

namespace App\Nova\Fields;

use Laravel\Nova\Fields\Gravatar;

class Avatar extends Gravatar
{
    public function __construct($name = 'Avatar', $attribute = null, $resolveCallback = null)
    {
        parent::__construct($name, $attribute, $resolveCallback);

        $this->maxWidth(64);

        $this->squared();
    }

    protected function resolveAttribute($resource, $attribute)
    {
        $callback = function () use ($resource, $attribute) {
            return data_get($resource, str_replace('->', '.', $attribute));
        };

        $this->preview($callback)->thumbnail($callback);
    }
}
