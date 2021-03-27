<?php

namespace App\Enums;

use Spatie\Enum\Laravel\Enum;

/**
 * @method static self BLADE()
 * @method static self CSS()
 * @method static self GO()
 * @method static self HTML()
 * @method static self JAVASCRIPT()
 * @method static self MARKDOWN()
 * @method static self PHP()
 * @method static self PYTHON()
 * @method static self RUBY()
 * @method static self SCSS()
 * @method static self SHELL()
 * @method static self TYPESCRIPT()
 * @method static self VUE()
 * @method static self NOASSERTION()
 */
final class Language extends Enum
{
    public function color(): string
    {
        return match($this->value) {
            'BLADE' => 'red',
            'CSS' => 'blue',
            'GO' => 'blue',
            'HTML' => 'red',
            'JAVASCRIPT' => 'yellow',
            'PHP' => 'indigo',
            'VUE' => 'green',
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
            'BLADE' => 'Blade',
            'GO' => 'Go',
            'JAVASCRIPT' => 'JavaScript',
            'MARKDOWN' => 'Markdown',
            'PHP' => 'PHP',
            'PYTHON' => 'Python',
            'RUBY' => 'Ruby',
            'SHELL' => 'Shell',
            'TYPESCRIPT' => 'Typescript',
            'VUE' => 'Vue.js',
            'NOASSERTION' => 'Other',
        ];
    }
}
