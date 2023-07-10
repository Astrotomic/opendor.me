<?php

namespace App\View\Components\Web\Home;

use App\Models\Repository;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class RandomRepositories extends Component
{
    public function __construct(
        protected int $limit = 3
    ) {
    }

    public function render(): View
    {
        return view('components.web.home.random-repositories');
    }

    public function repositories(): Collection
    {
        return Repository::query()
            ->with('owner')
            ->takeRandom($this->limit);
    }
}
