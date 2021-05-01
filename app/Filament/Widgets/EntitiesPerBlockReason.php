<?php

namespace App\Filament\Widgets;

use App\Enums\BlockReason;
use App\Models\User;
use Filament\Widgets\Widget;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Fluent;
use Illuminate\Support\Str;
use stdClass;

abstract class EntitiesPerBlockReason extends Widget
{
    public static $view = 'filament.widgets.entities-per-block-reason';

    protected static string $model;

    public string $title;
    public int $total;
    public Collection $reasons;

    public function mount(): void
    {
        $this->title = $this->title();
        $this->total = $this->total();
        $this->reasons = $this->reasons();
    }

    protected function title(): string
    {
        return Str::of(static::$model)
            ->classBasename()
            ->plural()
            ->append(' per Block-Reason');
    }

    protected function total(): int
    {
        return DB::table(static::$model::table())->whereNotNull('block_reason')->count();
    }

    protected function reasons(): Collection
    {
        $records = DB::table(static::$model::table())
            ->selectRaw('block_reason, count(*) AS quantity')
            ->groupBy('block_reason')
            ->get();

        return $records
            ->reject(fn (stdClass $item): bool => $item->block_reason === null)
            ->transform(fn (stdClass $item): Fluent => new Fluent([
                'quantity' => $item->quantity,
                'percentage' => $item->quantity / $this->total * 100,
                'block_reason' => BlockReason::make($item->block_reason),
            ]))
            ->sortByDesc('quantity');
    }
}
