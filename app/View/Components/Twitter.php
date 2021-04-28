<?php

namespace App\View\Components;

use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\HtmlString;
use Illuminate\View\Component;

class Twitter extends Component
{
    public function render(): Htmlable
    {
        return new HtmlString(
            \Astrotomic\OpenGraph\Twitter::summary(config('app.name'))
                                         ->title(config('app.name'))
        );
    }
}
