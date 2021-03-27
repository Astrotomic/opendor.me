<?php

namespace App\Jobs;

use DateTimeInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

abstract class Job implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public bool $deleteWhenMissingModels = true;
    public ?int $timeout = null;
    public ?int $tries = null;
    public ?int $maxExceptions = null;

    abstract public function handle(): ?bool;

    abstract public function tags(): array;

    public function retryUntil(): ?DateTimeInterface
    {
        return null;
    }
}
