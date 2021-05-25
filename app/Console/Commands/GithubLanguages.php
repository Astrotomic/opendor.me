<?php

namespace App\Console\Commands;

use App\Enums\Language;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class GithubLanguages extends Command
{
    protected $signature = 'github:languages';
    protected $description = 'Load all languages from GitHub.';

    public function handle(): void
    {
        $this->info('retrieve all languages from ozh/github-colors');
        $languages = Http::get('https://raw.githubusercontent.com/ozh/github-colors/master/colors.json')
            ->collect()
            ->map(fn (array $language, string $name): array => array_merge(
                $language,
                [
                    'name' => $name,
                    'enum' => (string) Str::of($name)
                        ->slug('_')
                        ->upper(),
                ]
            ))
            ->map(fn (array $language): array => array_merge($language, [
                'enum' => match ($language['name']) {
                    'C++' => 'C_PLUSPLUS',
                    'Objective-C++' => 'OBJECTIVE_C_PLUSPLUS',
                    'C#' => 'C_SHARP',
                    'F#' => 'F_SHARP',
                    'Q#' => 'Q_SHARP',
                    default => $language['enum'],
                },
            ]))
            ->sortBy('name')
            ->values();
        $this->comment("found {$languages->count()} languages");

        $this->comment('store all languages');
        $this->line(resource_path('languages.json'));
        File::put(
            resource_path('languages.json'),
            $languages->toJson(JSON_PRETTY_PRINT)
        );

        $this->comment('store tailwind colors');
        $this->line('https://github.com/Astrotomic/tailwind-programming-language-colors');
        $colors = $languages
            ->mapWithKeys(fn (array $language): array => [$language['enum'] => $language['color']])
            ->filter()
            ->keyBy(
                fn (string $color, string $enum): string => Str::of($enum)
                ->slug()
                ->prepend('lang-')
            );
        $this->line(storage_path('tailwind.colors.json'));
        File::put(
            storage_path('tailwind.colors.json'),
            $colors->toJson(JSON_PRETTY_PRINT)
        );

        $this->comment('write new language enum doc-block');
        $loader = require 'vendor/autoload.php';
        $file = $loader->findFile(Language::class);
        $content = Str::of(File::get($file));

        $before = Str::before($content, 'final class Language extends Enum');
        $after = Str::after($content, $before);
        $doctag = '/**'.Str::after($before, '/**');
        $before = Str::before($before, $doctag);

        $doctag = '/**'.PHP_EOL
            .$languages
                ->reject(fn (array $language): bool => preg_match('/^\d.*/', $language['enum']) === 1)
                ->map(fn (array $language) => " * @method static self {$language['enum']}()")
                ->implode(PHP_EOL).PHP_EOL
            .' * @method static self NOASSERTION()'.PHP_EOL
            .' */';

        File::put($file, trim($before).PHP_EOL.PHP_EOL.trim($doctag).PHP_EOL.trim($after).PHP_EOL);
    }
}
