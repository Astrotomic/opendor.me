<?php

namespace App\View\Components\OpenGraph;

use Astrotomic\OpenGraph\OpenGraph;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;
use Illuminate\View\Component;

class Website extends Component
{
    public function __construct(
        protected ?string $title = null,
        protected ?string $description = null,
        protected ?string $url = null,
        protected ?string $image = null,
    ) {
        $this->title = $this->title
            ? Str::finish($this->title, ' | '.config('app.name'))
            : config('app.name');
    }

    public function render(): Htmlable
    {
        return new HtmlString(
            OpenGraph::website($this->title)
                ->locale(app()->getLocale())
                ->siteName(config('app.name'))
                ->title($this->title)
                ->url($this->url ?? request()->url())
                ->when($this->description)->description($this->description)
                ->when($this->image)->image($this->image)
        );
    }
}
