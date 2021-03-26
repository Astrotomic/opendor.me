<?php

namespace App\Enums;

use Spatie\Enum\Laravel\Enum;

/**
 * @method static self PHP()
 * @method static self JAVASCRIPT()
 * @method static self VUE()
 * @method static self CSS()
 * @method static self BLADE()
 * @method static self PYTHON()
 * @method static self SHELL()
 * @method static self SCSS()
 * @method static self TYPESCRIPT()
 * @method static self HTML()
 * @method static self RUBY()
 * @method static self NOASSERTION()
 */
final class Language extends Enum
{
    public function color(): string
    {
        return match($this->value) {
            'PHP' => 'indigo',
            'JAVASCRIPT' => 'yellow',
            'VUE' => 'green',
            'CSS' => 'blue',
            'BLADE' => 'red',
        default => 'gray',
        };
    }

    protected static function values(): array
    {
        return [
            'NOASSERTION' => 'OTHER',
        ];
    }

    protected static function labels(): array
    {
        return [
            'NOASSERTION' => 'Other',
        ];
    }
}
