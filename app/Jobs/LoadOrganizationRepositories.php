<?php

namespace App\Jobs;

use App\Jobs\Concerns\RateLimited;
use App\Models\Organization;
use App\Models\Repository;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class LoadOrganizationRepositories implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;
    use RateLimited;

    public $deleteWhenMissingModels = true;
    public $timeout = 600; // seconds

    public function __construct(protected Organization $organization)
    {
        $this->queue = 'github';
    }

    public function handle(): void
    {
        try {
            $repositories = $this->loadRepositories();
        } catch (ClientException $exception) {
            $this->rateLimit($exception);

            return;
        }

        $repositories->each(function (array $repository): ?Repository {
            return Repository::fromGithub($repository);
        });
    }

    protected function loadRepositories(): Collection
    {
        $repositories = collect();

        $page = 1;
        do {
            $response = $this->organization->github()->get("/orgs/{$this->organization->name}/repos", [
                'type' => 'public',
                'per_page' => 100,
                'page' => $page,
            ])->collect();

            $repositories->push(...$response->all());

            $page++;
        } while ($response->count() >= 100);

        return $repositories;
    }

    public function tags(): array
    {
        return [
            Str::snake(class_basename($this->organization)).':'.$this->organization->id,
            $this->organization->name,
        ];
    }
}
