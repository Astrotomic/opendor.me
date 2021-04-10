<?php

namespace App\View\Components\Web;

use App\Models\FAQ;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class Faqs extends Component
{
    public function __construct(protected ?int $limit = null)
    {
    }

    public function render(): View
    {
        return view('components.web.faqs');
    }

    public function faqs(): Collection
    {
        return FAQ::ordered()
            ->when($this->limit, fn (Builder $q) => $q->limit($this->limit))
            ->get();
    }
}
