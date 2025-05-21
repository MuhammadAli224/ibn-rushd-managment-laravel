<?php

namespace Database\Seeders;

use App\Enums\LessonStatusEnum;
use App\Enums\RoleEnum;
use App\Models\Center;
use App\Models\Lesson;
use App\Models\Student;
use App\Models\Subject;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class LessonSeeder extends Seeder
{
    public function run()
    {
        $centers = Center::pluck('id')->toArray();
        $subjects = Subject::with('teachers')->get(); // make sure you have this relationship
        // $teachers = User::role(RoleEnum::TEACHER->value)->pluck('id')->toArray();
        $drivers = User::role(RoleEnum::DRIVER->value)->pluck('id')->toArray();
        $students = Student::pluck('id')->toArray();

        $statuses = array_column(LessonStatusEnum::cases(), 'value');
        $locations = [
            'Al Sadd Center',
            'West Bay Center',
            'Education City',
            'Student Home',
            'Online',
            'Al Waab Center'
        ];

        $adminId = User::role(RoleEnum::ADMIN->value)->first()?->id;

        for ($i = 1; $i <= 20; $i++) {
            $subject = $subjects->random();
            $teachersForSubject = $subject->teachers;

            if ($teachersForSubject->isEmpty()) {
                continue;
            }
            $teacher = $teachersForSubject->random();

            $lessonDate = Carbon::today()->addDays(rand(-30, 30));
            $startTime = Carbon::createFromTime(rand(8, 20), [0, 30][rand(0, 1)], 0);
            $endTime = (clone $startTime)->addHours(rand(1, 2));

            Lesson::create([
                'center_id' => $centers[array_rand($centers)] ?? null,
                'subject_id' => $subject->id,
                'teacher_id' => $teacher->id,
                'driver_id' => rand(0, 1) && !empty($drivers) ? $drivers[array_rand($drivers)] : null,
                'student_id' => $students[array_rand($students)] ?? null,
                'lesson_date' => $lessonDate,
                'lesson_start_time' => $startTime,
                'lesson_end_time' => $endTime,
                'lesson_location' => $locations[array_rand($locations)],
                'lesson_notes' => rand(0, 1) ? 'Notes for lesson in ' . $locations[array_rand($locations)] : null,
                'status' => $statuses[array_rand($statuses)],
                'lesson_duration' => $startTime->diffInMinutes($endTime),
                'check_in_time' => rand(0, 1) ? $startTime->copy()->subMinutes(rand(5, 15)) : null,
                'check_out_time' => rand(0, 1) ? $endTime->copy()->addMinutes(rand(5, 15)) : null,
                'uber_charge' => rand(0, 1) ? rand(20, 100) : null,
                'lesson_price' => rand(100, 300),
                'commission_rate' => rand(30, 50),
                'is_active' => rand(0, 1),
                'created_by' => $adminId,
                'updated_by' => $adminId,
            ]);
        }
    }
}
