<?php

namespace App\Jobs;

use App\Jobs\Concerns\RateLimited;
use App\Models\Repository;
use App\Models\User;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class LoadRepositoryContributors implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;
    use RateLimited;

    public $deleteWhenMissingModels = true;
    public $timeout = 600; // seconds

    public function __construct(protected Repository $repository)
    {
        $this->queue = 'github';
    }

    public function handle(): void
    {
        try {
            $contributors = $this->loadContributors();
        } catch (ClientException $exception) {
            $this->rateLimit($exception);

            return;
        }

        $contributors = $contributors->map(function (array $contributor): ?User {
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
    }

    protected function loadContributors(): Collection
    {
        $contributors = collect();

        $page = 1;
        do {
            $response = $this->repository->github()->get("/repos/{$this->repository->name}/contributors", [
                'anon' => true,
                'per_page' => 100,
                'page' => $page,
            ])->collect();

            $contributors->push(...$response->all());

            $page++;
        } while ($response->count() >= 100);

        return $contributors;
    }

    public function tags(): array
    {
        return [
            Str::snake(class_basename($this->repository->owner)) . ':' . $this->repository->owner->id,
            $this->repository->owner->name,

            Str::snake(class_basename($this->repository)) . ':' . $this->repository->id,
            $this->repository->name,
        ];
    }
}
