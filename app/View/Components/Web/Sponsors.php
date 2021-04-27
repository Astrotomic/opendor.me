<?php

namespace App\View\Components\Web;

use App\Models\Sponsor;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class Sponsors extends Component
{
    public function __construct(protected ?int $limit = null)
    {
    }

    public function render(): View
    {
        return view('components.web.sponsors');
    }

    public function sponsors(): Collection
    {
        return Sponsor::orderBy('name')->get();
    }
}
