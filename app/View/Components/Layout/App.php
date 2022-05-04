<?php

namespace App\View\Components\Layout;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class App extends Component
{
    public string $title;

    public function __construct(
        public string $pageTitle,
        ?string $title = null
    ) {
        $this->title = $title ?? $pageTitle;
    }

    public function render(): View
    {
        return view('components.layout.app');
    }
}
