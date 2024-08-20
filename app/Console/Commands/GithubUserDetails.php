<?php

namespace App\Console\Commands;

use App\Jobs\UpdateUserDetails;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class GithubUserDetails extends Command
{
    protected $signature = 'github:user:details {name?}';

    protected $description = 'Load user details.';

    public function handle(): void
    {
        $query = User::query()
            ->whereIsRegistered()
            ->when(
                $this->argument('name'),
                fn (Builder $query, string $name) => $query->where('name', $name)
            );

        $this->withProgressBar($query, static function (User $user): void {
            UpdateUserDetails::dispatch($user);
        });
    }
}
