<?php

namespace App\Jobs;

use App\Jobs\Concerns\RateLimited;
use App\Models\Organization;
use App\Models\User;
use Carbon\CarbonInterval;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Str;

class SyncUserOrganizations extends Job
{
    use RateLimited;

    public function __construct(protected User $user)
    {
        $this->queue = 'github';
        $this->timeout = CarbonInterval::minutes(5)->totalSeconds;
    }

    public function handle(): void
    {
        try {
            $organizations = $this->user->github()->get('/user/orgs')->collect();
        } catch (ClientException $exception) {
            $this->rateLimit($exception);

            return;
        }

        $this->user->organizations()->sync(
            $organizations
                ->map(fn (array $org): Organization => Organization::fromGithub($org))
                ->pluck('id')
        );
    }

    public function tags(): array
    {
        return [
            Str::snake(class_basename($this->user)).':'.$this->user->id,
            $this->user->name,
        ];
    }
}
