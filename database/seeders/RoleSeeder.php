<?php

namespace Database\Seeders;

use App\Enums\PermissionEnum;
use App\Enums\RoleEnum;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::firstOrCreate(['name' => RoleEnum::ADMIN->value]);
        $teacherRole = Role::firstOrCreate(['name' => RoleEnum::TEACHER->value]);
        $driverRole = Role::firstOrCreate(['name' => RoleEnum::DRIVER->value]);
        $accountingRole = Role::firstOrCreate(['name' => RoleEnum::ACCOUNTING->value]);
        $dispatcherRole = Role::firstOrCreate(['name' => RoleEnum::DISPATCHER->value]);
        $studentRole = Role::firstOrCreate(['name' => RoleEnum::STUDENT->value]);
        $studentRole = Role::firstOrCreate(['name' => RoleEnum::PARENT->value]);
        $managementRole = Role::firstOrCreate(['name' => RoleEnum::MANAGMENT->value]);

        
        $adminRole->syncPermissions(PermissionEnum::all());
    }
}
