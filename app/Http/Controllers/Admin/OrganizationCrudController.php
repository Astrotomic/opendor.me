<?php

namespace App\Http\Controllers\Admin;

use App\Enums\BlockReason;
use App\Http\Requests\OrganizationRequest;
use App\Models\Organization;
use App\Models\Repository;
use App\Models\User;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class OrganizationCrudController.
 *
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class OrganizationCrudController extends CrudController
{
    use ListOperation;
    use ShowOperation;
    use UpdateOperation;

    public function setup(): void
    {
        $this->crud->setModel(Organization::class);
        $this->crud->setRoute(config('backpack.base.route_prefix').'/organization');
        $this->crud->setEntityNameStrings('organization', 'organizations');
        $this->crud->addClause('withBlocked');
        $this->crud->setOperationSetting('setFromDb', false);
    }

    protected function setupListOperation(): void
    {
        $this->setupFilters();

        $this->crud->column('avatar_url')
            ->type('image')
            ->label('')
            ->makeFirst();
        $this->crud->column('id');
        $this->crud->column('name');
        $this->crud->column('display_name');
        $this->crud->column('is_blocked')
            ->type('boolean')
            ->label('Blocked');
    }

    protected function setupShowOperation(): void
    {
        $this->crud->column('avatar_url')
            ->type('image')
            ->label('')
            ->makeFirst();
        $this->crud->column('is_verified')
            ->type('boolean')
            ->label('Verified');
        $this->crud->column('id');
        $this->crud->column('name');
        $this->crud->column('display_name');
        $this->crud->column('description');
        $this->crud->column('location');
        $this->crud->column('twitter');
        $this->crud->column('website');
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
        $this->crud->column('repositories')
            ->type('relationship_count');
        $this->crud->column('members')
            ->type('relationship_count');
    }

    protected function setupUpdateOperation(): void
    {
        $this->crud->setValidation(OrganizationRequest::class);

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
                'name'  => 'members',
                'label' => 'Member',
            ],
            fn () => User::query()->pluck('name', 'id')->toArray(),
            fn ($value) => $this->crud->query->whereHas(
                'members',
                fn (Builder $q) => $q->where('id', $value)
            )
        );

        $this->crud->addFilter(
            [
                'type'  => 'select2',
                'name'  => 'repositories',
                'label' => 'Repository',
            ],
            fn () => Repository::query()
                ->where('owner_type', (new Organization())->getMorphClass())
                ->pluck('name', 'id')
                ->toArray(),
            fn ($value) => $this->crud->query->whereHas(
                'repositories',
                fn (Builder $q) => $q->where('id', $value)
            )
        );
    }
}
