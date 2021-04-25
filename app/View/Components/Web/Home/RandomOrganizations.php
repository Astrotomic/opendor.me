<?php

namespace App\View\Components\Web\Home;

use App\Models\Organization;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class RandomOrganizations extends Component
{
    public function __construct(public int $limit = 6)
    {
    }

    public function render(): View
    {
        return view('components.web.home.random-organizations');
    }

    public function organizations(): Collection
    {
        return Organization::query()
            ->has('repositories')
            ->takeRandom($this->limit);
    }
}
