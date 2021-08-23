<?php

namespace App\View\Components\Layout;

use Astrotomic\OpenGraph\StructuredProperties\Image;
use Astrotomic\OpenGraph\Twitter;
use Astrotomic\OpenGraph\Type;
use Illuminate\Contracts\View\View;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;
use Illuminate\View\Component;

class Html extends Component
{
    public string $title;
    public string $lang;
    public ?string $description;

    public function __construct(
        ?string $title = null,
        ?string $description = null
    ){
        $this->title = $title
            ? Str::finish($title, ' | '.config('app.name'))
            : config('app.name');

        $this->lang = str_replace('_', '-', app()->getLocale());
        $this->description = $description;
    }

    public function render(): View
    {
        return view('components.layout.html');
    }

    public function opengraph(): HtmlString
    {
        $image = match (request()->route()->action['as'] ?? null) {
            'home' => asset('images/og-home.png'),
            default => null,
        };

        return new HtmlString(implode(PHP_EOL, [
            app(Type::class)
                ->title($this->title)
                ->locale(app()->getLocale())
                ->siteName(config('app.name'))
                ->url(request()->url())
                ->when($this->description)->description($this->description)
                ->when($image, fn (Type $type) => $type->image(
                    Image::make($image)
                        ->width(2048)
                        ->height(1170)
                )),
            ($image
                ? Twitter::summaryLargeImage()
                : Twitter::summary()
            )
                ->title($this->title)
                ->site('@astrotomic_oss')
                ->when($this->description)->description($this->description)
                ->when($image)->image($image),
        ]));
    }
}
