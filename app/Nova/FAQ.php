<?php

namespace App\Nova;

use App\Models\FAQ as FaqModel;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use OptimistDigital\NovaSortable\Traits\HasSortableRows;

class FAQ extends Resource
{
    use HasSortableRows;

    public static $model = FaqModel::class;
    public static $group = 'Content';
    public static $title = 'question';
    public static $search = [
        'question', 'content',
    ];

    public static function label(): string
    {
        return 'FAQs';
    }

    public function fields(Request $request): array
    {
        return [
            Boolean::make('Draft', 'is_draft'),

            Number::make('Priority')->sortable()->textAlign('right'),

            Text::make('Question'),

            Markdown::make('Answer', 'content')->alwaysShow(),
        ];
    }

    protected function shouldAddActionsField($request): bool
    {
        return false;
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
