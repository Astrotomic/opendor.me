<?php

namespace App\View\Components\Layout;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Web extends Component
{
    public ?string $title;
    public ?string $pageTitle;

    public function __construct(?string $pageTitle = null, ?string $title = null)
    {
        $this->pageTitle = $pageTitle;
        $this->title = $title ?? $pageTitle;
    }

    public function render(): View
    {
        return view('components.layout.web');
    }
}
