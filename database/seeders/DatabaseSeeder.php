<?php

namespace Database\Seeders;

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

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
        $this->call(CenterSeeder::class);
        $this->call(RoleAndPermissionSeeder::class);
        $this->call(ExpenseCategorySeeder::class);


    }
}
