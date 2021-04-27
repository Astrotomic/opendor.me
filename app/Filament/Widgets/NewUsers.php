<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Carbon\Carbon;
use Filament\Widgets\Widget;

class NewUsers extends Widget
{
    public static $view = 'filament.widgets.new-users';

    public string $title = 'New users';
    public string $selectedOption = '1m';
    public array $options = [
        '1d' => 'Today',
        '7d' => 'Last 7 days',
        '1m' => 'This month',
    ];

    private $records;

    public function mount()
    {
        $this->updatedSelectedOption($this->selectedOption);
    }

    public function updatedSelectedOption($value)
    {
        $this->records = match ($value) {
            '1d' => User::where('created_at', Carbon::today()),
            '7d' => User::where('created_at', Carbon::now()->subtract($value)),
            default => User::whereMonth('created_at', Carbon::now()->month),
        };
    }

    public function render()
    {
        return view(self::$view, [
            'count' => $this->records->count(),
        ]);
    }
}
