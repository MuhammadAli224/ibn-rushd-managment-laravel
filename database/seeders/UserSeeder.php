<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user= User::firstOrCreate([
            'name' => 'Test User',
            'email' => 'admin@example.com',
            'phone'=>"0500000000",
            'center_id'=>1,
            'password' => bcrypt('password'),
            
        ]);
        $user->assignRole(RoleEnum::ADMIN->value);
    }
}
