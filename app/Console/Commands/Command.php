<?php

namespace App\Console\Commands;

use Closure;
use Illuminate\Console\Command as IlluminateCommand;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\LazyCollection;

abstract class Command extends IlluminateCommand
{
    public function progress(int|iterable|Builder $items, Closure $callback, ?Closure $default = null): void
    {
        if ($items instanceof Builder) {
            $query = $items;

            if ($query->doesntExist()) {
                if ($default) {
                    $this->comment('Executing default...');
                    $default();
                }

                return;
            }

            $this->output->progressStart($query->count());
            $query->eachById(function (Model $value) use ($callback): void {
                $callback($value);
                $this->output->progressAdvance();
            });
            $this->output->progressFinish();

            return;
        }

        if (is_iterable($items)) {
            if (empty($items)) {
                if ($default) {
                    $this->comment('Executing default...');
                    $default();
                }

                return;
            }

            $this->output->progressStart(count($items));
            LazyCollection::make($items)->each(function (mixed $value) use ($callback): void {
                $callback($value);
                $this->output->progressAdvance();
            });
            $this->output->progressFinish();

            return;
        }

        if ($items === 0) {
            if ($default) {
                $this->comment('Executing default...');
                $default();
            }

            return;
        }

        $this->output->progressStart($items);

        LazyCollection::range(1, $items)->each(function (int $value) use ($callback): void {
            $callback($value);
            $this->output->progressAdvance();
        });

        $this->output->progressFinish();
    }
}
