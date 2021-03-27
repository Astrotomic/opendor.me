<?php

namespace App\Jobs;

use App\Jobs\Concerns\RateLimited;
use App\Models\Repository;
use App\Models\User;
use Carbon\CarbonInterval;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Str;

class LoadRepositoryContributors extends Job
{
    use RateLimited;

    public function __construct(protected Repository $repository)
    {
        $this->queue = 'github';
        $this->timeout = CarbonInterval::hour()->totalSeconds;
    }

    public function handle(): void
    {
        try {
            $page = 1;
            do {
                $response = $this->repository->github()->get("/repos/{$this->repository->name}/contributors", [
                    'anon' => true,
                    'per_page' => 100,
                    'page' => $page,
                ])->collect();

                $contributors = $response->map(function (array $contributor): ?User {
                    if ($contributor['type'] === 'User') {
                        return User::fromGithub($contributor);
                    } elseif ($contributor['type'] === 'Anonymous') {
                        return User::cursor()->first(fn (User $user): bool => in_array($contributor['email'], $user->emails));
                    }

                    return null;
                })->filter();

                $this->repository->contributors()->syncWithoutDetaching(
                    $contributors->pluck('id')
                );

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
            Str::snake(class_basename($this->repository)).':'.$this->repository->id,
            $this->repository->name,
        ];
    }
}
