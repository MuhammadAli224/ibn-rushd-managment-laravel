<?php

namespace Database\Seeders;

use App\Enums\GenderEnum;
use App\Enums\RoleEnum;
use App\Enums\StatusEnum;
use App\Models\Center;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    public function run()
    {
        

        $centers = Center::pluck('id')->toArray();

        $maleNames = ['Mohammed', 'Ali', 'Ahmed', 'Omar', 'Khalid', 'Abdullah', 'Yousef', 'Ibrahim', 'Hamad', 'Fahad'];
        $femaleNames = ['Fatima', 'Mariam', 'Aisha', 'Noor', 'Layla', 'Hessa', 'Shaikha', 'Noura', 'Amal', 'Maha'];
        $lastNames = ['Al-Thani', 'Al-Sulaiti', 'Al-Mansoori', 'Al-Kuwari', 'Al-Hajri'];
        $addresses = ['Al Sadd', 'West Bay', 'Al Waab', 'Al Khor', 'Al Wakrah', 'Doha'];

        // Admin
        $admin = User::create([
            'center_id' => $centers[0] ?? null,
            'name' => 'Mohammed Al-Thani',
            'email' => 'admin@test.qa',
            'phone' => '97433123456',
            'password' => Hash::make('password'),
            'status' => StatusEnum::ACTIVE->value,
            'gender' => GenderEnum::MALE->value,
            'country' => 'QA',
            'national_id' => '271' . str_pad(rand(0, 9999999), 7, '0', STR_PAD_LEFT),
            'is_active' => true,
        ]);
        $admin->assignRole(RoleEnum::ADMIN->value);

        // Management
        $management = User::create([
            'center_id' => $centers[0] ?? null,
            'name' => 'Fatima Al-Sulaiti',
            'email' => 'management@test.qa',
            'phone' => '97433123457',
            'password' => Hash::make('password'),
            'status' => StatusEnum::ACTIVE->value,
            'gender' => GenderEnum::FEMALE->value,
            'country' => 'QA',
            'national_id' => '282' . str_pad(rand(0, 9999999), 7, '0', STR_PAD_LEFT),
            'is_active' => true,
        ]);
        $management->assignRole(RoleEnum::MANAGMENT->value);

        // Seed other roles
        $this->createUsersWithRole(RoleEnum::TEACHER,  10, $centers, $maleNames, $femaleNames, $lastNames, $addresses);
        $this->createUsersWithRole(RoleEnum::DRIVER, 10, $centers, $maleNames, [], $lastNames, $addresses);
        $this->createUsersWithRole(RoleEnum::PARENT, 10, $centers, $maleNames, $femaleNames, $lastNames, $addresses);
        $this->createUsersWithRole(RoleEnum::ACCOUNTING, 5, $centers, $maleNames, $femaleNames, $lastNames, $addresses);
        $this->createUsersWithRole(RoleEnum::DISPATCHER, 5, $centers, $maleNames, $femaleNames, $lastNames, $addresses);
    }

    public function createUsersWithRole(RoleEnum $role, int $count, array $centers, array $maleNames, array $femaleNames, array $lastNames, array $addresses)
    {
        for ($i = 1; $i <= $count; $i++) {
            $gender = (!empty($femaleNames) && rand(0, 1)) ? GenderEnum::FEMALE->value : GenderEnum::MALE->value;

            $firstName = $gender === GenderEnum::MALE->value
                ? $maleNames[array_rand($maleNames)]
                : $femaleNames[array_rand($femaleNames)];

            $lastName = $lastNames[array_rand($lastNames)];
            $fullName = "$firstName $lastName";

            $user = User::create([
                'center_id' => $centers[0] ?? null,
                'name' => $fullName,
                'email' => strtolower(str_replace(' ', '.', $fullName)) . '_' . strtolower($role->value) . $i . '@test.qa',
                'phone' => '974' . rand(33, 77) . str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT),
                'password' => Hash::make('password'),
                'status' => StatusEnum::ACTIVE->value,
                'gender' => $gender,
                'address' => $addresses[array_rand($addresses)] . ', Qatar',
                'national_id' => (rand(0, 1) ? '271' : '282') . str_pad(rand(0, 9999999), 7, '0', STR_PAD_LEFT),
                'country' => 'QA',
                'is_active' => true,
            ]);

            $user->assignRole($role->value);
        }
    }

    
}
