<?php

namespace Database\Seeders;

use App\Domains\Spies\Models\Spy;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AuthSeeder::class,
            ApiPermissionRoleTableSeeder::class
        ]);

        Spy::factory()->count(10)->create();
    }
}
