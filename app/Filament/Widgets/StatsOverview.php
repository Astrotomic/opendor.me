<?php

namespace App\Filament\Widgets;

use App\Models\Organization;
use App\Models\Repository;
use App\Models\RepositoryUserPivot;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Indexed Users', User::query()->count()),
            Stat::make('Registered Users', User::query()->whereIsRegistered()->count()),
            Stat::make('Contributions', RepositoryUserPivot::query()->count()),
            Stat::make('Organizations', Organization::query()->count()),
            Stat::make('Repositories', Repository::query()->count()),
        ];
    }
}
