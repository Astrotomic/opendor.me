<?php

namespace App\Jobs;

use App\Enums\Language;
use App\Enums\License;
use App\Jobs\Concerns\RateLimited;
use App\Models\Repository;
use Carbon\CarbonInterval;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Str;

class UpdateRepositoryDetails extends Job
{
    use RateLimited;

    public function __construct(protected Repository $repository)
    {
        $this->queue = 'github';
        $this->timeout = CarbonInterval::minutes(5)->totalSeconds;
    }

    public function handle(): void
    {
        try {
            $data = $this->repository->github()->get("/repos/{$this->repository->name}")->json();
        } catch (ClientException $exception) {
            $this->rateLimit($exception);

            return;
        }

        $this->repository->fill([
            'description' => $data['description'],
            'stargazers_count' => $data['stargazers_count'],
            'website' => $data['homepage'],
        ]);

        if ($this->repository->language->equals(Language::NOASSERTION())) {
            $this->repository->language = $data['language'] ?? Language::NOASSERTION();
        }

        if ($this->repository->license->equals(License::NOASSERTION())) {
            $this->repository->license = $data['license']['spdx_id'] ?? License::NOASSERTION();
        }

        $this->repository->save();
    }

    public function tags(): array
    {
        return [
            Str::snake(class_basename($this->repository)).':'.$this->repository->id,
            $this->repository->name,
        ];
    }
}
