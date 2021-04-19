<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Widgets\Widget;

class NewUsers extends Widget
{
    public $title = 'New users';
    public static $view = 'filament.widgets.new-users';

    public string $selectedOption = '';
    public array $options = [
        "today",

    ];

    public function render()
    {
        return view(self::$view, [
            'count' => User::whereIsRegistered()->where('re')
        ]);
    }
}
