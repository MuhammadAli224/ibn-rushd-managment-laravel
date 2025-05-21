<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
use App\Models\Center;
use App\Models\Guardian;
use App\Models\User;
use Illuminate\Database\Seeder;

class GuardianSeeder extends Seeder
{
    public function run()
    {
        $guardianUsers = User::role(RoleEnum::PARENT->value)->take(20)->get();

        if ($guardianUsers->count() < 20) {
            $additionalNeeded = 20 - $guardianUsers->count();
            (new UserSeeder())->createUsersWithRole(
                RoleEnum::PARENT,
                $additionalNeeded,
                Center::pluck('id')->toArray(),
                ['Mohammed', 'Ali', 'Ahmed', 'Omar', 'Khalid'],
                ['Fatima', 'Mariam', 'Aisha', 'Noor', 'Layla'],
                ['Al-Thani', 'Al-Sulaiti', 'Al-Mansoori', 'Al-Kuwari', 'Al-Hajri'],
                ['Al Sadd', 'West Bay', 'Al Waab', 'Al Khor', 'Al Wakrah', 'Doha']
            );
            $guardianUsers = User::role(RoleEnum::PARENT->value)->take(20)->get();
        }

        $occupations = [
            'Government Employee', 'Business Owner', 'Engineer', 'Doctor', 
            'Teacher', 'Banker', 'Oil & Gas Professional', 'Military'
        ];

        $adminId = User::role(RoleEnum::ADMIN->value)->first()?->id;

        foreach ($guardianUsers as $user) {
            Guardian::updateOrCreate([
                'user_id' => $user->id
            ], [
                'occupation' => $occupations[array_rand($occupations)],
                'whatsapp' => '974' . rand(33, 77) . str_pad(rand(0, 999999), 6, '0'),
                'created_by' => $adminId,
                'updated_by' => $adminId,
            ]);
        }
    }
}