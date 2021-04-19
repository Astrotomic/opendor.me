<?php

namespace App\Jobs;

use DateTimeInterface;
use Illuminate\Bus\Batch;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Bus;

abstract class Job implements ShouldQueue
{
    use Batchable;
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public bool $deleteWhenMissingModels = true;
    public ?int $timeout = null;
    public ?int $tries = null;
    public ?int $maxExceptions = null;

    public static function dispatchBatch(): Batch
    {
        $job = new static(...func_get_args());

        $batch = Bus::batch([$job]);

        if ($job->queue) {
            $batch->onQueue($job->queue);
        }

        return $batch->dispatch();
    }

    abstract public function handle(): ?bool;

    abstract public function tags(): array;

    public function retryUntil(): ?DateTimeInterface
    {
        return null;
    }
}
