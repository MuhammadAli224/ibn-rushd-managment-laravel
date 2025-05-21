<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubjectTeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $subjects = Subject::all();
        $teachers = Teacher::all();

        foreach ($subjects as $subject) {
            $randomTeachers = $teachers->random(rand(4, 6));
            foreach ($randomTeachers as $teacher) {
                DB::table('subject_teacher')->updateOrInsert([
                    'subject_id' => $subject->id,
                    'teacher_id' => $teacher->id,
                ]);
            }
        }
    }
}
