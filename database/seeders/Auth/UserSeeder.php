<?php

namespace Database\Seeders\Auth;


use Illuminate\Database\Seeder;
use Ramsey\Uuid\Uuid as PackageUuid;
use App\Domains\Auth\Models\User;

/**
 * Class UserTableSeeder.
 */
class UserSeeder extends Seeder
{

    /**
     * Run the database seed.
     */
    public function run()
    {
        // Add the master administrator, user id of 1
        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@admin.gr',
            'password' => bcrypt('123456'),
            'email_verified_at' => now(),
            'active' => true,
            'user_verified' => true,
            'user_verified_at' => now(),
            'uuid' => PackageUuid::uuid4()->toString(),
        ]);

    }
}
