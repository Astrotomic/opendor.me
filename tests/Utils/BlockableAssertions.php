<?php

namespace Tests\Utils;

use App\Eloquent\Concerns\Blockable;
use App\Enums\BlockReason;
use Carbon\Carbon;
use PHPUnit\Framework\Assert as PHPUnit;
use Spatie\Enum\Phpunit\EnumAssertions;

trait BlockableAssertions
{
    /**
     * @param  \App\Eloquent\Concerns\Blockable|mixed  $actual
     */
    public static function assertBlockable($actual): void
    {
        PHPUnit::assertIsObject($actual);
        PHPUnit::assertArrayHasKey(Blockable::class, class_uses_recursive($actual));

        if ($actual->isBlocked()) {
            EnumAssertions::assertIsEnum($actual->block_reason);
            PHPUnit::assertInstanceOf(BlockReason::class, $actual->block_reason);

            PHPUnit::assertInstanceOf(Carbon::class, $actual->blocked_at);
        } else {
            PHPUnit::assertNull($actual->block_reason);
            PHPUnit::assertNull($actual->blocked_at);
        }
    }
}
