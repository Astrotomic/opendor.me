<?php

namespace App\Console;

use App\Console\Commands\GithubOrganizationRepositories;
use App\Console\Commands\GithubRepositoryContributors;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command(GithubOrganizationRepositories::class)->daily();
        $schedule->command(GithubRepositoryContributors::class)->weekly();
    }

    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');
    }
}
