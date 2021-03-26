<?php

namespace App\Console;

use App\Console\Commands\GithubOrganizationRepositories;
use App\Console\Commands\GithubRepositoryContributors;
use App\Console\Commands\GithubUserRepositories;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Laravel\Horizon\Console\SnapshotCommand;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command(SnapshotCommand::class)->everyFiveMinutes();

        $schedule->command(GithubOrganizationRepositories::class)->dailyAt('03:00');
        $schedule->command(GithubUserRepositories::class)->dailyAt('03:00');
        $schedule->command(GithubRepositoryContributors::class)->dailyAt('15:00');
    }

    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');
    }
}
