<?php

namespace App\View\Components\Web\Home;

use App\Models\Repository;
use Carbon\CarbonInterval;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\Component;

class RandomRepositories extends Component
{
    public function __construct(protected int $limit = 3)
    {
    }

    public function render(): View
    {
        return view('components.web.home.random-repositories');
    }

    public function repositories(): Collection
    {
        return Cache::remember(
            __METHOD__,
            CarbonInterval::minutes(15),
            fn (): Collection => Repository::inRandomOrder()->limit($this->limit)->with('owner')->get()
        );
    }
}
