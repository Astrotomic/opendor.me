<?php

namespace App\Eloquent\Concerns;

use App\Eloquent\Scopes\BlockableScope;
use App\Enums\BlockReason;

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
    }

    public function initializeBlockable(): void
    {
        if (! isset($this->casts['blocked_at'])) {
            $this->casts['blocked_at'] = 'datetime';
        }

        if (! isset($this->casts['block_reason'])) {
            $this->casts['block_reason'] = BlockReason::class.':nullable';
        }
    }

    public function getIsBlockedAttribute(): bool
    {
        return $this->blocked_at !== null;
    }
}
