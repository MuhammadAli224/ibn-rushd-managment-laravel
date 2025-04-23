<?php

namespace Database\Factories;

use App\Models\Teacher;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class TeacherFactory extends Factory
{
    protected $model = Teacher::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->unique()->phoneNumber,
            'address' => $this->faker->address,
            'national_id' => $this->faker->unique()->numberBetween(100000, 999999),
            'gender' => $this->faker->randomElement(['male', 'female']),
            'date_of_birth' => $this->faker->date,
            'qualification' => $this->faker->word,
            'specialization' => $this->faker->word,
            'experience' => $this->faker->word,
            'status' => $this->faker->randomElement(['active', 'inactive']),
            'profile_picture' => $this->faker->imageUrl,
            'password' => bcrypt('password'),
        ];
    }
}
