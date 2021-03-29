<?php

namespace App\View\Components\Layout;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class App extends Component
{
    public string $title;
    public string $pageTitle;

    public function __construct(string $pageTitle, ?string $title = null)
    {
        $this->pageTitle = $pageTitle;
        $this->title = $title ?? $pageTitle;
    }

    public function render(): View
    {
        return view('components.layout.app');
    }
}
