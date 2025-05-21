<?php

namespace Database\Seeders;

use App\Enums\GenderEnum;
use App\Enums\RoleEnum;
use App\Enums\StatusEnum;
use App\Models\Guardian;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class StudentSeeder extends Seeder
{
    public function run()
    {
        $guardians = Guardian::with('user')->get();
        $classes = [
            'Grade 1', 'Grade 2', 'Grade 3', 'Grade 4', 'Grade 5', 
            'Grade 6', 'Grade 7', 'Grade 8', 'Grade 9', 'Grade 10',
            'Grade 11', 'Grade 12'
        ];

        $maleNames = ['Mohammed', 'Ali', 'Ahmed', 'Omar', 'Khalid', 'Abdullah', 'Yousef'];
        $femaleNames = ['Fatima', 'Mariam', 'Aisha', 'Noor', 'Layla', 'Hessa'];

        $adminId = User::role(RoleEnum::ADMIN->value)->first()?->id;

        for ($i = 1; $i <= 20; $i++) {
            $guardian = $guardians->random();
            $gender = rand(0, 1) ? GenderEnum::MALE->value : GenderEnum::FEMALE->value;
            $lastName = explode(' ', trim($guardian->user->name))[1] ?? 'Guardian';
            $name = $gender === GenderEnum::MALE->value
                ? $maleNames[array_rand($maleNames)] . ' ' . $lastName
                : $femaleNames[array_rand($femaleNames)] . ' ' . $lastName;

           
            Student::create([
                'guardian_id' => $guardian->id,
                
                'name' => $name,
                'class' => $classes[array_rand($classes)],
                'phone' => '974' . rand(33, 77) . str_pad(rand(0, 999999), 6, '0'),
                'address' => $guardian->user->address,
                'created_by' => $adminId,
                'updated_by' => $adminId,
            ]);
        }
    }
}