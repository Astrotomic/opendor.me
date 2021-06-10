<?php

namespace App\Eloquent\Concerns;

use App\Eloquent\Scopes\BlockableScope;
use App\Enums\BlockReason;
use Illuminate\Database\Eloquent\Model;

/**
 * @property \Carbon\Carbon|null $blocked_at
 * @property \App\Enums\BlockReason|null $block_reason
 *
 * @method static static|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder withBlocked()
 * @method static static|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder onlyBlocked()
 * @mixin \Illuminate\Database\Eloquent\Model
 */
trait Blockable
{
    public static function bootBlockable(): void
    {
        static::addGlobalScope(new BlockableScope());

        static::saving(static function (Model $model): void {
            if ($model->block_reason !== null) {
                $model->blocked_at = now();
            } else {
                $model->blocked_at = null;
            }
        });
    }

    public function initializeBlockable(): void
    {
        if (! isset($this->casts['blocked_at'])) {
            $this->casts['blocked_at'] = 'datetime';
        }

        if (! isset($this->casts['block_reason'])) {
            $this->casts['block_reason'] = BlockReason::class.':nullable';
        }

        $this->makeHidden(['blocked_at', 'block_reason']);
    }

    public function isBlocked(): bool
    {
        return $this->blocked_at !== null;
    }
}
