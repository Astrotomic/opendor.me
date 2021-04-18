<?php

namespace App\Enums;

use Illuminate\Support\Str;
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
 * @method static self DOCKERFILE()
 * @method static self C_SHARP()
 * @method static self F_SHARP()
 * @method static self C_PLUSPLUS()
 * @method static self JAVA()
 * @method static self COFFEESCRIPT()
 * @method static self SMARTY()
 * @method static self ELIXIR()
 * @method static self POWERSHELL()
 * @method static self YAML()
 * @method static self PERL()
 * @method static self OBJECTIVE_C()
 * @method static self LUA()
 * @method static self SWIFT()
 * @method static self XML()
 * @method static self KOTLIN()
 * @method static self VIM_SCRIPT()
 * @method static self VIM_L()
 * @method static self VISUAL_BASIC()
 * @method static self HCL()
 * @method static self C()
 * @method static self PUPPET()
 * @method static self ACTIONSCRIPT()
 * @method static self ARDUINO()
 * @method static self ASSEMBLY()
 * @method static self CLOJURE()
 * @method static self COLDFUSION()
 * @method static self DART()
 * @method static self EAGLE()
 * @method static self ELM()
 * @method static self GLSL()
 * @method static self GNUPLOT()
 * @method static self GROOVY()
 * @method static self HACK()
 * @method static self HAML()
 * @method static self HANDLEBARS()
 * @method static self JULIA()
 * @method static self LESS()
 * @method static self MAKEFILE()
 * @method static self MATHEMATICA()
 * @method static self MUSTACHE()
 * @method static self NGINX()
 * @method static self OCAML()
 * @method static self OZ()
 * @method static self PLPGSQL()
 * @method static self POSTSCRIPT()
 * @method static self RESCRIPT()
 * @method static self RUST()
 * @method static self SASS()
 * @method static self SCALA()
 * @method static self SQLPL()
 * @method static self TEX()
 * @method static self TSQL()
 * @method static self TWIG()
 * @method static self VHDL()
 * @method static self WEBASSEMBLY()
 * @method static self NOASSERTION()
 */
final class Language extends Enum
{
    protected static function values(): array
    {
        return [
            'C_SHARP' => 'C#',
            'F_SHARP' => 'F#',
            'C_PLUSPLUS' => 'C++',
            'OBJECTIVE_C' => 'Objective-C',
            'VIM_SCRIPT' => 'Vim script',
            'VIM_L' => 'VimL',
            'VISUAL_BASIC' => 'Visual Basic',
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
            'DOCKERFILE' => 'Dockerfile',
            'COFFEESCRIPT' => 'CoffeeScript',
            'JAVA' => 'Java',
            'ELIXIR' => 'Elixir',
            'SMARTY' => 'Smarty',
            'POWERSHELL' => 'PowerShell',
            'PERL' => 'Perl',
            'LUA' => 'Lua',
            'SWIFT' => 'Swift',
            'KOTLIN' => 'Kotlin',
            'XML' => 'XML',
            'OBJECTIVE_C' => 'Objective-C',
            'C_SHARP' => 'C#',
            'F_SHARP' => 'F#',
            'C_PLUSPLUS' => 'C++',
            'VIM_SCRIPT' => 'Vim script',
            'VIM_L' => 'VimL',
            'VISUAL_BASIC' => 'Visual Basic',
            'PUPPET' => 'Puppet',
            'ACTIONSCRIPT' => 'ActionScript',
            'ARDUINO' => 'Arduino',
            'ASSEMBLY' => 'Assembly',
            'CLOJURE' => 'Clojure',
            'COLDFUSION' => 'ColdFusion',
            'DART' => 'Dart',
            'EAGLE' => 'Eagle',
            'ELM' => 'Elm',
            'GLSL' => 'GLSL',
            'GNUPLOT' => 'Gnuplot',
            'GROOVY' => 'Groovy',
            'HACK' => 'Hack',
            'HAML' => 'Haml',
            'HANDLEBARS' => 'Handlebars',
            'JULIA' => 'Julia',
            'LESS' => 'Less',
            'MAKEFILE' => 'Makefile',
            'MATHEMATICA' => 'Mathematica',
            'MUSTACHE' => 'Mustache',
            'NGINX' => 'Nginx',
            'OCAML' => 'OCaml',
            'OZ' => 'Oz',
            'PLPGSQL' => 'PLpgSQL',
            'POSTSCRIPT' => 'PostScript',
            'RESCRIPT' => 'ReScript',
            'RUST' => 'Rust',
            'SASS' => 'Sass',
            'SCALA' => 'Scala',
            'SQLPL' => 'SQLPL',
            'TEX' => 'TeX',
            'TSQL' => 'TSQL',
            'TWIG' => 'Twig',
            'VHDL' => 'VHDL',
            'WEBASSEMBLY' => 'WebAssembly',
            'NOASSERTION' => 'Other',
        ];
    }

    public function color(): string
    {
        return Str::slug(match ($this->value) {
            static::NOASSERTION()->value => 'gray-300',
            static::SMARTY()->value => 'gray-300',
            static::XML()->value => 'gray-300',
            static::HCL()->value => 'gray-300',
            static::ARDUINO()->value => 'gray-300',
            static::EAGLE()->value => 'gray-300',
            static::GLSL()->value => 'gray-300',
            static::MATHEMATICA()->value => 'gray-300',
            static::NGINX()->value => 'gray-300',
            static::PLPGSQL()->value => 'gray-300',
            static::SQLPL()->value => 'gray-300',
            static::TSQL()->value => 'gray-300',
            static::VIM_L()->value => static::VIM_SCRIPT()->value,
            static::VISUAL_BASIC()->value => 'visual-basic-net',
            default => $this->value,
        });
    }
}
