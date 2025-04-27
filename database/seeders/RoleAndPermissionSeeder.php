<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Enums\RoleEnum;
use App\Enums\PermissionEnum;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (PermissionEnum::cases() as $permission) {
            Permission::firstOrCreate(['name' => $permission->value]);
        }


        $adminRole = Role::firstOrCreate(['name' => RoleEnum::ADMIN->value]);
        $teacherRole = Role::firstOrCreate(['name' => RoleEnum::TEACHER->value]);
        $driverRole = Role::firstOrCreate(['name' => RoleEnum::DRIVER->value]);
        $accountingRole = Role::firstOrCreate(['name' => RoleEnum::ACCOUNTING->value]);
        $dispatcherRole = Role::firstOrCreate(['name' => RoleEnum::DISPATCHER->value]);
        $studentRole = Role::firstOrCreate(['name' => RoleEnum::STUDENT->value]);
        $managementRole = Role::firstOrCreate(['name' => RoleEnum::MANAGMENT->value]);

        
        $adminRole->syncPermissions(Permission::all());



    }
}
