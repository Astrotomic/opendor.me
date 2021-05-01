<?php

namespace App\Enums;

use Closure;
use Illuminate\Support\Str;

/**
 * @method static self DUPLICATE()
 * @method static self FORK()
 * @method static self INAPPROPRIATE()
 * @method static self REVIEW()
 * @method static self SPAM()
 * @method static self UNRELEASED()
 * @method static self NON_REUSABLE()
 * @method static self DELETED()
 * @method static self DOTFILES()
 */
final class BlockReason extends Enum
{
    protected static function labels(): Closure
    {
        return fn (string $value): string => Str::of($value)->replace('_', ' ')->title();
    }
}
