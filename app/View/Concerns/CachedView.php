<?php

namespace App\View\Concerns;

use Carbon\CarbonInterval;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\HtmlString;

trait CachedView
{
    protected ?CarbonInterval $ttl = null;

    abstract protected function view(): View;

    public function render(): HtmlString
    {
        return new HtmlString(Cache::remember(
            $this->cacheMutex(),
            $this->ttl ?? CarbonInterval::minute(),
            fn (): string => $this->view()->with($this->data())->render()
        ));
    }

    protected function cacheMutex(): string
    {
        return $this->componentName.':'.collect($this->extractPublicProperties())
                ->except('componentName', 'attributes')
                ->map(static function (mixed $value) {
                    if (is_scalar($value)) {
                        return $value;
                    }

                    if ($value instanceof Model) {
                        if ($value->exists) {
                            return get_class($value).'#'.$value->getKey();
                        }

                        return null;
                    }

                    return collect($value)->toJson();
                })
                ->sortKeys()
                ->toJson();
    }
}
