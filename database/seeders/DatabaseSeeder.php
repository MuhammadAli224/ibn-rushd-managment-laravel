<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
use App\Models\Center;
use App\Models\Lesson;
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
            ExpenseCategorySeeder::class,
            SubjectSeeder::class,
            // TeacherSeeder::class,
            // SubjectTeacherSeeder::class,
            // GuardianSeeder::class,
            // DriverSeeder::class,
            // StudentSeeder::class,
            // LessonSeeder::class,
           

        ]);
    }
}
