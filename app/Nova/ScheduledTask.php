<?php

namespace App\Nova;

use Carbon\Carbon;
use Cron\CronExpression;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\Text;
use Lorisleiva\CronTranslator\CronTranslator;
use Spatie\ScheduleMonitor\Models\MonitoredScheduledTask;

class ScheduledTask extends Resource
{
    public static $model = MonitoredScheduledTask::class;
    public static $group = 'Admin';
    public static $title = 'name';
    public static $searchable = false;
    public static $polling = true;

    public static function authorizedToViewAny(Request $request): bool
    {
        return $request->user()->can('viewHorizon');
    }

    public static function authorizedToCreate(Request $request): bool
    {
        return false;
    }

    public function authorizedToView(Request $request): bool
    {
        return $request->user()->can('viewHorizon');
    }

    public function authorizedToDelete(Request $request): bool
    {
        return false;
    }

    public function authorizedToUpdate(Request $request): bool
    {
        return false;
    }

    public function fields(Request $request): array
    {
        return [
            Boolean::make('Healthy')
                ->resolveUsing(function ($value, MonitoredScheduledTask $model): bool {
                    $previous = Carbon::instance((new CronExpression($model->cron_expression))->getPreviousRunDate());

                    return $previous->lessThanOrEqualTo($model->last_started_at);
                }),

            Text::make('Name')
                ->sortable(),

            Text::make('Cron Expression')
                ->resolveUsing(function (string $cron): string {
                    $readable = CronTranslator::translate($cron, 'en', true);

                    $next = Carbon::instance((new CronExpression($cron))->getNextRunDate());

                    return <<<HTML
                    <p style="white-space:nowrap;">
                        <code class="block">{$cron}</code>
                        <span class="block text-sm">{$readable}</span>
                        <time datetime="{$next->toIso8601String()}" class="block text-xs">
                            {$next->format('D, d M Y H:i')}
                        </time>
                        <time datetime="{$next->toIso8601String()}" class="block text-xs">
                            {$next->diffForHumans()}
                        </time>
                    </p>
                    HTML;
                })
                ->textAlign('right')
                ->asHtml(),

            DateTime::make('Last Started At')
                ->sortable()
                ->textAlign('right'),

            DateTime::make('Last Finished At')
                ->sortable()
                ->textAlign('right'),

            DateTime::make('Last Skipped At')
                ->sortable()
                ->textAlign('right'),

            DateTime::make('Last Failed At')
                ->sortable()
                ->textAlign('right'),
        ];
    }
}
