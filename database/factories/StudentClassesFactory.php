<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\StudentClasses>
 */
class StudentClassesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
        ];
    }

    public function classId($value): static
    {
        return $this->state(fn (array $attributes) => [
            'class_id' => $value,
        ]);
    }

    public function studentId($value): static
    {
        return $this->state(fn (array $attributes) => [
            'student_id' => $value,
        ]);
    }
}
