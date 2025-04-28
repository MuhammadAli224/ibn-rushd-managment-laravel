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
        $this->call(RoleAndPermissionSeeder::class);

       $user= User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole(RoleEnum::ADMIN);
        $this->call(CenterSeeder::class);
        $this->call(ExpenseCategorySeeder::class);


    }
}
