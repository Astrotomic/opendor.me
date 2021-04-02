<?php

namespace App\Nova;

use App\Models\FAQ as FaqModel;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\Text;
use OptimistDigital\NovaSortable\Traits\HasSortableRows;

class FAQ extends Resource
{
    use HasSortableRows;

    public static $model = FaqModel::class;
    public static $group = 'Content';
    public static $title = 'question';
    public static $search = [
        'id', 'question', 'answer',
    ];

    public static function label(): string
    {
        return 'FAQs';
    }

    public function fields(Request $request): array
    {
        return [
            ID::make()->sortable(),

            Text::make('Question'),

            Markdown::make('Answer')->alwaysShow(),
        ];
    }

    public function cards(Request $request): array
    {
        return [];
    }

    public function filters(Request $request): array
    {
        return [];
    }

    public function lenses(Request $request): array
    {
        return [];
    }

    public function actions(Request $request): array
    {
        return [];
    }
}
