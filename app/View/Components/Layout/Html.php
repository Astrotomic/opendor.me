<?php

namespace App\View\Components\Layout;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Illuminate\View\Component;

class Html extends Component
{
    public string $title;
    public string $lang;

    public function __construct(?string $title = null)
    {
        $this->title = $title
            ? Str::finish($title, ' | ' . config('app.name'))
            : config('app.name');

        $this->lang = str_replace('_', '-', app()->getLocale());
    }

    public function render(): View
    {
        return view('components.layout.html');
    }
}
