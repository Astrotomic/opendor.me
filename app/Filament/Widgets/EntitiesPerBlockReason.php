<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\DB;

class EntitiesPerBlockReason extends Widget
{
    public static $view = 'filament.widgets.entities-per-block-reason';

    public string $title = 'Users per Block-Reason';

    public function render()
    {
        $records = DB::table(User::table())
                     ->selectRaw('block_reason, count(*) AS quantity')
                     ->groupBy('block_reason')
                     ->orderBy('quantity', 'desc')
                     ->get();

        $reasons = $records->reject(function ($item) {
            return $item->block_reason === null;
        })->transform(function ($item) use ($records) {
            $item->percentage = $item->quantity / $records->count();
            $item->block_reason = ucfirst(strtolower($item->block_reason));

            return $item;
        })->sortByDesc('quantity');

        return view(self::$view, [
            'reasons' => $reasons,
        ]);
    }
}
