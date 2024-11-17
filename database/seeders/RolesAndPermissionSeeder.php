<?php

namespace Database\Seeders;

use App\Domains\Auth\Models\RolesEnum;
use App\Domains\Auth\Models\Permission;
use App\Domains\Auth\Models\Role;
use App\Domains\Auth\Models\User;
use Illuminate\Database\Seeder;

class RolesAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create Roles
        $role = Role::firstOrCreate(['id' => RolesEnum::Administrator->value, 'name' => RolesEnum::Administrator->label(),]);
        $role->syncPermissions(Permission::all());

    }
}
