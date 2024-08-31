<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Date;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Classes>
 */
class ClassesFactory extends Factory
{
    // $table->id();
    // $table->foreignId('user_id')->constrained()->onDelete('cascade');
    // $table->string('subject');
    // $table->string('grade_section');
    // $table->time('time_from');
    // $table->time('time_to');
    // $table->year('academic_year'); 
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'subject' => fake()->randomElement(['Math', 'Filipino', 'Science', 'English', 'Physical Education']),
            'grade_section' => fake()->randomElement(['5 - 1', '5 - 2', '5 - 3']),
            'time_from' => date('h:i'),
            'time_to' => date('h:i'),
            'academic_year' => '2023'
        ];
    }

    public function userId($value): static
    {
        return $this->state(fn (array $attributes) => [
            'user_id' => $value,
        ]);
    }
}
