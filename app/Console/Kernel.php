<?php

namespace App\Console;

use App\Console\Commands\GithubOrganizationDetails;
use App\Console\Commands\GithubOrganizationRepositories;
use App\Console\Commands\GithubRepositoryContributors;
use App\Console\Commands\GithubRepositoryDetails;
use App\Console\Commands\GithubUserDetails;
use App\Console\Commands\GithubUserRepositories;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Laravel\Horizon\Console\SnapshotCommand;
use Spatie\ScheduleMonitor\Commands\CleanLogCommand;
use Spatie\ScheduleMonitor\Commands\SyncCommand;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command(SnapshotCommand::class)->everyFiveMinutes();

        $schedule->command(GithubOrganizationRepositories::class)->dailyAt('03:00');
        $schedule->command(GithubUserRepositories::class)->dailyAt('03:00');
        $schedule->command(GithubRepositoryContributors::class)->dailyAt('15:00');

        $schedule->command(GithubUserDetails::class)->dailyAt('12:00');
        $schedule->command(GithubOrganizationDetails::class)->dailyAt('12:00');
        $schedule->command(GithubRepositoryDetails::class)->dailyAt('12:00');

        $schedule->command(CleanLogCommand::class)->dailyAt('01:00');
    }

    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');
    }
}
