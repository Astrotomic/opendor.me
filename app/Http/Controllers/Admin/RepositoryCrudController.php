<?php

namespace App\Http\Controllers\Admin;

use App\Enums\BlockReason;
use App\Enums\Language;
use App\Enums\License;
use App\Http\Requests\RepositoryRequest;
use App\Models\Organization;
use App\Models\Repository;
use App\Models\User;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class RepositoryCrudController.
 *
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class RepositoryCrudController extends CrudController
{
    use ListOperation;
    use ShowOperation;
    use UpdateOperation;

    public function setup(): void
    {
        $this->crud->setModel(Repository::class);
        $this->crud->setRoute(config('backpack.base.route_prefix').'/repository');
        $this->crud->setEntityNameStrings('repository', 'repositories');
        $this->crud->addClause('withBlocked');
        $this->crud->setOperationSetting('setFromDb', false);
    }

    protected function setupListOperation(): void
    {
        $this->setupFilters();

        $this->crud->column('id');
        $this->crud->column('name');
        $this->crud->column('is_blocked')
            ->type('boolean')
            ->label('Blocked');
    }

    protected function setupShowOperation(): void
    {
        $this->crud->column('id');
        $this->crud->column('owner')
            ->type('relationship');
        $this->crud->column('name');
        $this->crud->column('description');
        $this->crud->column('stargazers_count');
        $this->crud->column('website');
        $this->crud->addColumn([
            'name' => 'license',
            'type' => 'select_from_array',
            'options' => License::toArray(),
        ]);
        $this->crud->addColumn([
            'name' => 'language',
            'type' => 'select_from_array',
            'options' => Language::toArray(),
        ]);
        $this->crud->column('is_blocked')
            ->type('boolean')
            ->label('Blocked');
        $this->crud->column('blocked_at')
            ->type('datetime');
        $this->crud->addColumn([
            'name' => 'block_reason',
            'type' => 'select_from_array',
            'options' => BlockReason::toArray(),
        ]);
        $this->crud->column('contributors')
            ->type('relationship_count');
    }

    protected function setupUpdateOperation(): void
    {
        $this->crud->setValidation(RepositoryRequest::class);

        $this->crud->field('id')->attributes([
            'readonly' => 'readonly',
        ]);
        $this->crud->field('name')->attributes([
            'readonly' => 'readonly',
        ]);
        $this->crud->addField([
            'name' => 'block_reason',
            'type' => 'select_from_array',
            'allows_null' => true,
            'options' => BlockReason::toArray(),
            'default' => null,
        ]);
    }

    protected function setupFilters(): void
    {
        $this->crud->addFilter(
            [
                'type'  => 'dropdown',
                'name'  => 'block_reason',
                'label' => 'Blocked',
            ],
            BlockReason::toArray(),
            fn ($value) => $this->crud->addClause('where', 'block_reason', $value)
        );

        $this->crud->addFilter(
            [
                'type'  => 'select2',
                'name'  => 'user',
                'label' => 'User',
            ],
            fn () => User::query()->pluck('name', 'id')->toArray(),
            fn ($value) => $this->crud->query->whereHasMorph(
                'owner',
                User::class,
                fn (Builder $q) => $q->where('id', $value)
            )
        );

        $this->crud->addFilter(
            [
                'type'  => 'select2',
                'name'  => 'organization',
                'label' => 'Organization',
            ],
            fn () => Organization::query()->pluck('name', 'id')->toArray(),
            fn ($value) => $this->crud->query->whereHasMorph(
                'owner',
                Organization::class,
                fn (Builder $q) => $q->where('id', $value)
            )
        );

        $this->crud->addFilter(
            [
                'type'  => 'select2',
                'name'  => 'contributors',
                'label' => 'Contributor',
            ],
            fn () => User::query()
                ->pluck('name', 'id')
                ->toArray(),
            fn ($value) => $this->crud->query->whereHas(
                'contributors',
                fn (Builder $q) => $q->where('id', $value)
            )
        );
    }
}
