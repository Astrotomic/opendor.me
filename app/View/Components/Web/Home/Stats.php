<?php

namespace App\View\Components\Web\Home;

use App\Models\Repository;
use App\Models\RepositoryUserPivot;
use App\Models\User;
use Carbon\CarbonInterval;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\Component;

class Stats extends Component
{
    public function render(): View
    {
        return view('components.web.home.stats');
    }

    public function contributorsCount(): int
    {
        return Cache::remember(
            __METHOD__,
            CarbonInterval::minute(),
            fn (): int => User::whereIsRegistered()->count()
        );
    }

    public function repositoriesCount(): int
    {
        return Cache::remember(
            __METHOD__,
            CarbonInterval::minute(),
            fn (): int => Repository::count()
        );
    }

    public function contributionsCount(): int
    {
        return Cache::remember(
            __METHOD__,
            CarbonInterval::minute(),
            fn (): int => RepositoryUserPivot::query()
            ->whereIn(
                'user_id',
                User::query()->select('id')->whereIsRegistered()
            )
            ->whereIn(
                'repository_id',
                Repository::query()->select('id')
            )
            ->count()
        );
    }
}
