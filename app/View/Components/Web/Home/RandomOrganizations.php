<?php

namespace App\View\Components\Web\Home;

use App\Models\Organization;
use Carbon\CarbonInterval;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\Component;

class RandomOrganizations extends Component
{
    public function __construct(protected int $limit = 6)
    {
    }

    public function render(): View
    {
        return view('components.web.home.random-organizations');
    }

    public function organizations(): Collection
    {
        return Cache::remember(
            __METHOD__.$this->limit,
            CarbonInterval::minutes(15),
            fn (): Collection => Organization::inRandomOrder()->limit($this->limit)->get()
        );
    }
}
