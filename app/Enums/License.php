<?php

namespace App\Enums;

use Spatie\Enum\Laravel\Enum;

/**
 * @method static self MIT()
 * @method static self BSD_3_CLAUSE()
 * @method static self APACHE_20()
 * @method static self NOASSERTION()
 */
final class License extends Enum
{
    protected static function values(): array
    {
        return [
            'MIT' => 'MIT',
            'BSD_3_CLAUSE' => 'BSD-3-Clause',
            'APACHE_20' => 'Apache-2.0',
            'NOASSERTION' => 'OTHER',
        ];
    }

    protected static function labels(): array
    {
        return [
            'MIT' => 'MIT',
            'BSD_3_CLAUSE' => 'BSD 3-Clause',
            'APACHE_20' => 'Apache 2.0',
            'NOASSERTION' => 'Other',
        ];
    }
}
