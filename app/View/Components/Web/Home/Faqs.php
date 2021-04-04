<?php

namespace App\View\Components\Web\Home;

use App\Models\FAQ;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class Faqs extends Component
{
    public function render(): View
    {
        return view('components.web.home.faqs');
    }

    public function faqs(): Collection
    {
        return FAQ::ordered()->get();
    }
}
