<?php

namespace App\Jobs;

use App\Jobs\Concerns\RateLimited;
use App\Models\Organization;
use App\Models\Repository;
use Carbon\CarbonInterval;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Str;

class LoadOrganizationRepositories extends Job
{
    use RateLimited;

    public function __construct(protected Organization $organization)
    {
        $this->queue = 'github';
        $this->timeout = CarbonInterval::minutes(15)->totalSeconds;
    }

    public function handle(): void
    {
        try {
            $page = 1;
            do {
                $response = $this->organization->github()->get("/orgs/{$this->organization->name}/repos", [
                    'type' => 'public',
                    'per_page' => 100,
                    'page' => $page,
                ])->collect();

                $response->each(fn (array $repository): ?Repository => Repository::fromGithub($repository));

                $page++;
            } while ($response->count() >= 100);
        } catch (ClientException $exception) {
            $this->rateLimit($exception);

            return;
        }
    }

    public function tags(): array
    {
        return [
            Str::snake(class_basename($this->organization)).':'.$this->organization->id,
            $this->organization->name,
        ];
    }
}
