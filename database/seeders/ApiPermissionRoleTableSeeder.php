<?php
namespace Database\Seeders;

use App\Domains\Auth\Models\RolesEnum;
use App\Domains\Auth\Models\User;
use Database\Seeders\Traits\DisableForeignKeys;
use Illuminate\Database\Seeder;
use Ramsey\Uuid\Uuid as PackageUuid;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

/**
 * Class PermissionRoleTableSeeder.
 */
class ApiPermissionRoleTableSeeder extends Seeder
{
    use DisableForeignKeys;

    /**
     * Run the database seed.
     */
    public function run()
    {
        $this->disableForeignKeys();

        // Create Roles
        $apirole = Role::firstOrCreate(['id' => RolesEnum::API->value, 'name' => 'Api']);

        Permission::updateOrCreate([
            'id' => 23,
            'name' => 'api.view',
            'description' => 'Πρόσβαση API',
        ]);



        // Assign Permissions to other Roles
        $apirole->givePermissionTo('api.view');

        $api = User::create([
            'name' => 'API',
            'email' => 'api@test.com',
            'password' => bcrypt('123456'),
            'email_verified_at' => now(),
            'active' => true,
            'user_verified' => true,
            'user_verified_at' => now(),
            'uuid' => PackageUuid::uuid4()->toString(),
        ]);

        $api->assignRole($apirole);
        $this->enableForeignKeys();
    }
}
