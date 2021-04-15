<?php

namespace App\View\Components\Web\Home;

use App\Models\Organization;
use App\View\Concerns\CachedView;
use Carbon\CarbonInterval;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class RandomOrganizations extends Component
{
    use CachedView;

    public function __construct(public int $limit = 6)
    {
        $this->ttl = CarbonInterval::minutes(15);
    }

    public function organizations(): Collection
    {
        return Organization::query()
            ->inRandomOrder()
            ->has('repositories')
            ->limit($this->limit)
            ->get();
    }

    protected function view(): View
    {
        return view('components.web.home.random-organizations');
    }
}
