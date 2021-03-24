<?php

namespace App\Jobs;

use App\Jobs\Concerns\RateLimited;
use App\Models\Organization;
use App\Models\User;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

class SyncUserOrganizations implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;
    use RateLimited;

    public $deleteWhenMissingModels = true;
    public $timeout = 120; // seconds

    public function __construct(protected User $user)
    {
        $this->queue = 'github';
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
                ->map(fn(array $org): Organization => Organization::fromGithub($org))
                ->pluck('id')
        );
    }

    public function tags(): array
    {
        return [
            Str::snake(class_basename($this->user)) . ':' . $this->user->id,
            $this->user->name,
        ];
    }
}
