<?php

namespace App\View\Components\Layout;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Web extends Component
{
    public ?string $title;
    public ?string $pageTitle;
    public ?string $description;

    public function __construct(
        ?string $pageTitle = null,
        ?string $title = null,
        ?string $description = null
    ) {
        $this->pageTitle = $pageTitle;
        $this->title = $title ?? $pageTitle;
        $this->description = $description;
    }

    public function render(): View
    {
        return view('components.layout.web');
    }
}
