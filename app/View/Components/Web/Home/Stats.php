<?php

namespace App\View\Components\Web\Home;

use App\Models\Repository;
use App\Models\RepositoryUserPivot;
use App\Models\User;
use App\View\Concerns\CachedView;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Stats extends Component
{
    use CachedView;

    protected function view(): View
    {
        return view('components.web.home.stats');
    }

    public function contributorsCount(): int
    {
        return User::whereIsRegistered()->count();
    }

    public function repositoriesCount(): int
    {
        return Repository::count();
    }

    public function contributionsCount(): int
    {
        return RepositoryUserPivot::query()
            ->whereIn(
                'user_id',
                User::query()->select('id')->whereIsRegistered()
            )
            ->whereIn(
                'repository_id',
                Repository::query()->select('id')
            )
            ->count();
    }
}
