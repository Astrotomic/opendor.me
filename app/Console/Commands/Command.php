<?php

namespace App\Console\Commands;

use Closure;
use Illuminate\Console\Command as IlluminateCommand;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\LazyCollection;

abstract class Command extends IlluminateCommand
{
    /**
     * @param  int|iterable|Builder  $totalSteps
     */
    public function withProgressBar($totalSteps, Closure $callback): void
    {
        if ($totalSteps instanceof Builder) {
            $query = $totalSteps;

            $this->output->progressStart($query->count());
            $query->eachById(function (Model $value) use ($callback): void {
                $callback($value);
                $this->output->progressAdvance();
            });
            $this->output->progressFinish();

            return;
        }

        if (is_iterable($totalSteps)) {
            $this->output->progressStart(count($totalSteps));
            LazyCollection::make($totalSteps)->each(function (mixed $value) use ($callback): void {
                $callback($value);
                $this->output->progressAdvance();
            });
            $this->output->progressFinish();

            return;
        }

        $this->output->progressStart($totalSteps);

        LazyCollection::range(1, $totalSteps)->each(function (int $value) use ($callback): void {
            $callback($value);
            $this->output->progressAdvance();
        });

        $this->output->progressFinish();
    }
}
