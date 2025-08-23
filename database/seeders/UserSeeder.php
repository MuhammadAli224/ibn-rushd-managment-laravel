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



        $admin = User::create([
            'center_id' => $centers[0] ?? null,
            'name' => 'Admin User',
            'email' => 'amir@ibn-rushd-edu.com',
            'phone' => '97433123456',
            'password' => Hash::make('password'),
            'status' => StatusEnum::ACTIVE->value,
            'gender' => GenderEnum::MALE->value,
            'country' => 'QA',
            'national_id' => '271' . str_pad(rand(0, 9999999), 7, '0', STR_PAD_LEFT),
            'is_active' => true,
            'is_super_admin' => true,
        ]);
        $admin->createWallet([
            'name' => 'Default Wallet',
            'slug' => 'default',
            'balance' => 0,


        ]);
        $admin->assignRole(RoleEnum::ADMIN->value);

        $admin2 = User::create([
            'center_id' => $centers[0] ?? null,
            'name' => 'Admin User',
            'email' => 'muhammad@admin.com',
            'phone' => '97433145456',
            'password' => Hash::make('Mayan@224'),
            'status' => StatusEnum::ACTIVE->value,
            'gender' => GenderEnum::MALE->value,
            'country' => 'QA',
            'national_id' => '271' . str_pad(rand(0, 9999999), 7, '0', STR_PAD_LEFT),
            'is_active' => true,
            'is_super_admin' => true,
        ]);
        $admin2->createWallet([
            'name' => 'Default Wallet',
            'slug' => 'default',
            'balance' => 0,


        ]);
        $admin2->assignRole(RoleEnum::ADMIN->value);
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
