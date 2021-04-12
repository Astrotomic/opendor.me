<?php

namespace App\Enums;

use Spatie\Enum\Laravel\Enum;

/**
 * @method static self AGPL_30()
 * @method static self APACHE_20()
 * @method static self BSD_2_CLAUSE()
 * @method static self BSD_3_CLAUSE()
 * @method static self CC0_10()
 * @method static self CC_BY_40()
 * @method static self CC_BY_NC_SA_30()
 * @method static self CC_BY_SA_30()
 * @method static self CC_BY_SA_40()
 * @method static self GPL_20()
 * @method static self GPL_30()
 * @method static self LGPL_21()
 * @method static self MIT()
 * @method static self MPL_20()
 * @method static self WTFPL()
 * @method static self ISC()
 * @method static self NOASSERTION()
 */
final class License extends Enum
{
    protected static function values(): array
    {
        return [
            'AGPL_30' => 'AGPL-3.0',
            'APACHE_20' => 'Apache-2.0',
            'BSD_2_CLAUSE' => 'BSD-2-Clause',
            'BSD_3_CLAUSE' => 'BSD-3-Clause',
            'CC0_10' => 'CC0-1.0',
            'CC_BY_40' => 'CC-BY-4.0',
            'CC_BY_NC_SA_30' => 'CC-BY-NC-SA-3.0',
            'CC_BY_SA_30' => 'CC-BY-SA-3.0',
            'CC_BY_SA_40' => 'CC-BY-SA-4.0',
            'GPL_20' => 'GPL-2.0',
            'GPL_30' => 'GPL-3.0',
            'LGPL_21' => 'LGPL-2.1',
            'MIT' => 'MIT',
            'MPL_20' => 'MPL-2.0',
            'NOASSERTION' => 'OTHER',
        ];
    }

    protected static function labels(): array
    {
        return [
            'AGPL_30' => 'AGPL 3.0',
            'APACHE_20' => 'Apache 2.0',
            'BSD_2_CLAUSE' => 'BSD 2-Clause',
            'BSD_3_CLAUSE' => 'BSD 3-Clause',
            'CC0_10' => 'CC0 1.0',
            'CC_BY_40' => 'CC BY 4.0',
            'CC_BY_NC_SA_30' => 'CC BY-NC-SA 3.0',
            'CC_BY_SA_30' => 'CC BY-SA 3.0',
            'CC_BY_SA_40' => 'CC BY-SA 4.0',
            'GPL_20' => 'GPL 2.0',
            'GPL_30' => 'GPL 3.0',
            'LGPL_21' => 'LGPL 2.1',
            'MIT' => 'MIT',
            'MPL_20' => 'MPL 2.0',
            'NOASSERTION' => 'Other',
        ];
    }
}
