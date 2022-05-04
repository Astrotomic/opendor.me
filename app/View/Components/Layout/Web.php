<?php

namespace App\View\Components\Layout;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Web extends Component
{
    public ?string $title;

    public function __construct(
        public ?string $pageTitle = null,
        ?string $title = null,
        public ?string $description = null
    ) {
        $this->title = $title ?? $pageTitle;
    }

    public function render(): View
    {
        return view('components.layout.web');
    }
}
