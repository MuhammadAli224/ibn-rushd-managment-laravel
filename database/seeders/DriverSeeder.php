<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
use App\Models\Center;
use App\Models\Driver;
use App\Models\User;
use Illuminate\Database\Seeder;

class DriverSeeder extends Seeder
{
    public function run()
    {
        $driverUsers = User::role(RoleEnum::DRIVER->value)->take(20)->get();

        if ($driverUsers->count() < 20) {
            $additionalNeeded = 20 - $driverUsers->count();
            (new UserSeeder())->createUsersWithRole(
                RoleEnum::DRIVER,
                $additionalNeeded,
                Center::pluck('id')->toArray(),
                ['Mohammed', 'Ali', 'Ahmed', 'Omar', 'Khalid'],
                ['Fatima', 'Mariam', 'Aisha', 'Noor', 'Layla'],
                ['Al-Thani', 'Al-Sulaiti', 'Al-Mansoori', 'Al-Kuwari', 'Al-Hajri'],
                ['Al Sadd', 'West Bay', 'Al Waab', 'Al Khor', 'Al Wakrah', 'Doha']   );
            $driverUsers = User::role(RoleEnum::DRIVER->value)->take(20)->get();
        }

        $vehicleTypes = ['Toyota Land Cruiser', 'Nissan Patrol', 'Toyota Camry', 'Hyundai Santa Fe', 'Kia Carnival'];
        $adminId = User::role(RoleEnum::ADMIN->value)->first()->id;

        foreach ($driverUsers as $user) {
            Driver::create([
                'user_id' => $user->id,
                'license_number' => 'QDL' . str_pad(rand(1, 999999), 6, '0', STR_PAD_LEFT),
                'vehicle_type' => $vehicleTypes[array_rand($vehicleTypes)],
                'vehicle_number' => 'Q' . strtoupper(substr(md5(rand()), 0, 5)),
                'attachment' => rand(0, 1) ? 'documents/license_' . rand(1, 10) . '.pdf' : null,
                'created_by' => $adminId,
                'updated_by' => $adminId,
            ]);
        }
    }
}
