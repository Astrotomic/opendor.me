<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MonitoredScheduledTaskResourceResource\Pages\ListMonitoredScheduledTaskResources;
use App\Filament\Resources\Tables\Columns\Cron;
use App\Filament\Resources\Tables\Columns\DateTimeDiff;
use Carbon\Carbon;
use Cron\CronExpression;
use Filament\Resources\Resource;
use Filament\Resources\Tables\Table;
use Filament\Tables\Columns\Boolean;
use Filament\Tables\Columns\Text;
use Spatie\ScheduleMonitor\Models\MonitoredScheduledTask;

class MonitoredScheduledTaskResourceResource extends Resource
{
    public static $model = MonitoredScheduledTask::class;
    public static $label = 'Scheduler';
    public static $icon = 'bx-timer';

    public static function table(Table $table): Table
    {
        return $table
            ->pagination(false)
            ->columns([
                Boolean::make('')
                    ->getValueUsing(function (MonitoredScheduledTask $model): bool {
                        $previous = Carbon::instance((new CronExpression($model->cron_expression))->getPreviousRunDate());

                        return $previous->lessThanOrEqualTo($model->last_started_at);
                    }),
                Text::make('name')
                    ->sortable()
                    ->searchable(),
                Cron::make('cron_expression')
                    ->label('Cron'),
                DateTimeDiff::make('last_started_at')
                    ->label('Started at'),
                DateTimeDiff::make('last_finished_at')
                    ->label('Finished at'),
                DateTimeDiff::make('last_failed_at')
                    ->label('Failed at'),
                DateTimeDiff::make('last_skipped_at')
                    ->label('Skipped at'),
            ])
            ->filters([]);
    }

    public static function relations(): array
    {
        return [];
    }

    public static function routes(): array
    {
        return [
            ListMonitoredScheduledTaskResources::routeTo('/', 'index'),
        ];
    }
}
