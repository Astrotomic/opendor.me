<?php

namespace App\Filament\Resources\MonitoredScheduledTaskResourceResource\Pages;

use App\Filament\Resources\MonitoredScheduledTaskResourceResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Tables\Table;

class ListMonitoredScheduledTaskResources extends ListRecords
{
    public static $resource = MonitoredScheduledTaskResourceResource::class;

    public $hasPagination = false;

    public function table(Table $table): Table
    {
        return static::getResource()::table($table);
    }

    public function canCreate(): bool
    {
        return false;
    }

    public function canDelete(): bool
    {
        return false;
    }
}
