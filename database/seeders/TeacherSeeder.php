<?php

namespace Database\Seeders;

use App\Enums\QualificationEnum;
use App\Enums\RoleEnum;
use App\Models\Center;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Database\Seeder;

class TeacherSeeder extends Seeder
{
    public function run()
    {
        $teacherUsers = User::role(RoleEnum::TEACHER->value)->take(20)->get();

        if ($teacherUsers->count() < 20) {
            $additionalNeeded = 20 - $teacherUsers->count();
            (new UserSeeder())->createUsersWithRole(
                RoleEnum::TEACHER,
                $additionalNeeded,
                Center::pluck('id')->toArray(),
                ['Mohammed', 'Ali', 'Ahmed', 'Omar', 'Khalid'],
                ['Fatima', 'Mariam', 'Aisha', 'Noor', 'Layla'],
                ['Al-Thani', 'Al-Sulaiti', 'Al-Mansoori', 'Al-Kuwari', 'Al-Hajri'],
                ['Al Sadd', 'West Bay', 'Al Waab', 'Al Khor', 'Al Wakrah', 'Doha']
            );
            $teacherUsers = User::role(RoleEnum::TEACHER->value)->take(20)->get();
        }

        $qualifications = array_column(QualificationEnum::cases(), 'value');
        $specializations = [
            'Mathematics',
            'Science',
            'English',
            'Arabic',
            'Islamic Studies',
            'Qatari History',
            'Physics',
            'Chemistry',
            'Biology',
            'Computer Science'
        ];
        $experiences = ['1-3 years', '3-5 years', '5-10 years', '10+ years'];

        $adminId = User::role(RoleEnum::ADMIN->value)->first()->id;

        foreach ($teacherUsers as $user) {
            Teacher::create([
                'user_id' => $user->id,
                'date_of_birth' => now()->subYears(rand(25, 50))->format('Y-m-d'),
                'qualification' => $qualifications[array_rand($qualifications)],
                'commission' => rand(30, 50),
                'specialization' => $specializations[array_rand($specializations)],
                'experience' => $experiences[array_rand($experiences)],
                'created_by' => $adminId,
                'updated_by' => $adminId,
            ]);
        }
    }
}
