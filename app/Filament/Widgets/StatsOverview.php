<?php

namespace App\Filament\Widgets;

use App\Models\Organization;
use App\Models\Repository;
use App\Models\RepositoryUserPivot;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class StatsOverview extends BaseWidget
{
    protected function getCards(): array
    {
        return [
            Card::make('Indexed Users', User::query()->count()),
            Card::make('Registered Users', User::query()->whereIsRegistered()->count()),
            Card::make('Contributions', RepositoryUserPivot::query()->count()),
            Card::make('Organizations', Organization::query()->count()),
            Card::make('Repositories', Repository::query()->count()),
        ];
    }
}
