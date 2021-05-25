<?php

namespace App\Filament\Resources\Tables\Columns;

use Carbon\Carbon;
use Cron\CronExpression;
use Filament\Tables\Columns\Text;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\HtmlString;
use Lorisleiva\CronTranslator\CronTranslator;

class Cron extends Text
{
    protected $view = 'tables::cells.text';

    public function __construct($name)
    {
        parent::__construct($name);

        $this->getValueUsing(function (Model $model) use ($name): HtmlString {
            $readable = CronTranslator::translate($model->{$name}, 'en', true);

            $next = Carbon::instance((new CronExpression($model->{$name}))->getNextRunDate());

            return new HtmlString(<<<HTML
                <code class="block text-xs">{$model->{$name}}</code>
                <span class="block text-sm">{$readable}</span>
                <time datetime="{$next->toIso8601String()}" class="block text-xs">
                    {$next->format('D, d M Y H:i')}
                </time>
                <time datetime="{$next->toIso8601String()}" class="block text-xs">
                    {$next->diffForHumans()}
                </time>
            HTML);
        });
    }
}
