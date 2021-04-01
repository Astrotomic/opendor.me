<?php

namespace App\Console\Commands;

use App\Models\FAQ;
use App\Models\Organization;
use App\Models\Repository;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class EnsurePermissions extends Command
{
    protected $signature = 'permission:ensure';
    protected $description = 'Ensure that all default roles and permissions exist.';

    public function handle(): void
    {
        foreach ([User::class, FAQ::class, Repository::class, Organization::class] as $model) {
            $entity = Str::of($model)->classBasename()->slug('_')->pluralStudly();

            /** @var \Spatie\Permission\Models\Role $role */
            $role = Role::findOrCreate("{$entity}.manager");

            $role->givePermissionTo(
                Permission::findOrCreate("{$entity}.*"),
                Permission::findOrCreate('viewNova')
            );
        }

        /** @var \Spatie\Permission\Models\Role $role */
        $role = Role::findOrCreate('admin');
        $role->givePermissionTo(
            Permission::findOrCreate('viewHorizon'),
            Permission::findOrCreate('viewNova'),
        );
    }
}
