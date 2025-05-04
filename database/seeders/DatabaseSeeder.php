<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
use App\Models\Center;
use App\Models\Teacher;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Contracts\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PermissionSeeder::class,
            RoleSeeder::class,
            CenterSeeder::class,
            UserSeeder::class,
            ExpenseCategorySeeder::class

        ]);
    }
}
