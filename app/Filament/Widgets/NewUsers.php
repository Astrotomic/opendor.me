<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Carbon\Carbon;
use Filament\Widgets\Widget;
use Illuminate\Contracts\View\View;

class NewUsers extends Widget
{
    public static $view = 'filament.widgets.new-users';

    public string $title = 'New Users';
    public string $selectedOption = '1m';
    public array $options = [
        '1d' => 'Today',
        '7d' => 'Last 7 days',
        '1m' => 'This month',
    ];

    protected $records;

    public function mount(): void
    {
        $this->updatedSelectedOption($this->selectedOption);
    }

    public function updatedSelectedOption(string $value): void
    {
        $this->records = match ($value) {
            '1d' => User::where('created_at', Carbon::today()),
            '7d' => User::where('created_at', Carbon::now()->subtract($value)),
            default => User::whereMonth('created_at', Carbon::now()->month),
        };
    }

    public function render(): View
    {
        return view(self::$view, [
            'count' => $this->records->count(),
        ]);
    }
}
