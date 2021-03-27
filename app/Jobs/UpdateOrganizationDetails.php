<?php

namespace App\Jobs;

use App\Jobs\Concerns\RateLimited;
use App\Models\Organization;
use Carbon\CarbonInterval;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Str;

class UpdateOrganizationDetails extends Job
{
    use RateLimited;

    public function __construct(protected Organization $organization)
    {
        $this->queue = 'github';
        $this->timeout = CarbonInterval::minutes(5)->totalSeconds;
    }

    public function handle(): void
    {
        try {
            $data = $this->organization->github()->get("/orgs/{$this->organization->name}")->json();
        } catch (ClientException $exception) {
            $this->rateLimit($exception);

            return;
        }

        $this->organization->update([
            'full_name' => $data['name'],
            'is_verified' => $data['is_verified'],
            'description' => $data['description'],
            'twitter' => $data['twitter_username'],
            'website' => $data['blog'],
            'location' => $data['location'],
        ]);
    }

    public function tags(): array
    {
        return [
            Str::snake(class_basename($this->organization)).':'.$this->organization->id,
            $this->organization->name,
        ];
    }
}
