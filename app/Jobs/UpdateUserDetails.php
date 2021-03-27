<?php

namespace App\Jobs;

use App\Jobs\Concerns\RateLimited;
use App\Models\User;
use Carbon\CarbonInterval;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Str;

class UpdateUserDetails extends Job
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
            $data = $this->user->github()->get("/users/{$this->user->name}")->json();
        } catch (ClientException $exception) {
            $this->rateLimit($exception);

            return;
        }

        $this->user->update([
            'full_name' => $data['name'],
            'description' => $data['bio'],
            'twitter' => $data['twitter_username'],
            'website' => $data['blog'],
            'location' => $data['location'],
        ]);
    }

    public function tags(): array
    {
        return [
            Str::snake(class_basename($this->user)).':'.$this->user->id,
            $this->user->name,
        ];
    }
}
