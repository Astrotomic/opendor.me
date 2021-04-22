<?php

namespace App\Console;

use Algolia\ScoutExtended\Console\Commands\ReImportCommand;
use App\Console\Commands\GithubOrganizationDetails;
use App\Console\Commands\GithubOrganizationRepositories;
use App\Console\Commands\GithubRepositoryContributors;
use App\Console\Commands\GithubRepositoryDetails;
use App\Console\Commands\GithubUserDetails;
use App\Console\Commands\GithubUserRepositories;
use App\Models\User;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Laravel\Horizon\Console\SnapshotCommand;
use Laravel\Scout\Console\FlushCommand;
use Laravel\Scout\Console\ImportCommand;
use Spatie\Backup\Commands\BackupCommand;
use Spatie\Backup\Commands\CleanupCommand;
use Spatie\Backup\Commands\MonitorCommand;
use Spatie\ScheduleMonitor\Commands\CleanLogCommand;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule): void
    {
        // github:*:repositories
        $schedule->command(GithubOrganizationRepositories::class)->dailyAt('03:00')->onOneServer();
        $schedule->command(GithubUserRepositories::class)->dailyAt('03:00')->onOneServer();
        // github:*:details
        $schedule->command(GithubUserDetails::class)->dailyAt('12:00')->onOneServer();
        $schedule->command(GithubOrganizationDetails::class)->dailyAt('12:00')->onOneServer();
        $schedule->command(GithubRepositoryDetails::class)->dailyAt('12:00')->onOneServer();
        // github:repository:contributors
        $schedule->command(GithubRepositoryContributors::class)->dailyAt('15:00')->onOneServer();

        // laravel/horizon
        $schedule->command(SnapshotCommand::class)->everyFiveMinutes()->onOneServer()->environments('gorgeous-moon');

        // laravel/scout
        $schedule->command(ReImportCommand::class)->dailyAt('02:00')->onOneServer();

        // spatie/laravel-schedule-monitor
        $schedule->command(CleanLogCommand::class)->dailyAt('01:00')->onOneServer();

        // spatie/laravel-backup
        $schedule->command(BackupCommand::class)->twiceDaily(1, 13);
        $schedule->command(CleanupCommand::class)->dailyAt('09:00');
        $schedule->command(MonitorCommand::class)->dailyAt('10:00');
    }

    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');
    }
}
