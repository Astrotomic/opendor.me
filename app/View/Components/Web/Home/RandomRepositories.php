<?php

namespace App\View\Components\Web\Home;

use App\Models\Repository;
use App\View\Concerns\CachedView;
use Carbon\CarbonInterval;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class RandomRepositories extends Component
{
    use CachedView;

    public function __construct(protected int $limit = 3)
    {
        $this->ttl = CarbonInterval::minutes(15);
    }

    public function repositories(): Collection
    {
        return Repository::query()
            ->inRandomOrder()
            ->limit($this->limit)
            ->with('owner')
            ->get();
    }

    protected function view(): View
    {
        return view('components.web.home.random-repositories');
    }
}
