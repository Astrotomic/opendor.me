<?php

namespace App\Filament\Resources\Tables\Columns;

use Filament\Tables\Columns\Text;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\HtmlString;

class DateTimeDiff extends Text
{
    protected $view = 'tables::cells.text';

    public function __construct($name)
    {
        parent::__construct($name);

        $this->getValueUsing(function (Model $model) use ($name): ?HtmlString {
            if ($model->{$name} === null) {
                return null;
            }

            return new HtmlString(<<<HTML
                <time datetime="{$model->{$name}->toIso8601String()}" class="block text-sm">
                    {$model->{$name}->diffForHumans()}
                </time>
                <time datetime="{$model->{$name}->toIso8601String()}" class="block text-xs">
                    {$model->{$name}->format('D, d M Y')}
                    <br/>
                    {$model->{$name}->format('H:i:s')}
                </time>
            HTML);
        });
    }
}
