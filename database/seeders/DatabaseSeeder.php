<?php

namespace Database\Seeders;

use App\Models\Classes;
use App\Models\Student;
use App\Models\StudentClasses;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(100)->role('teacher')->create();

        // User::factory()
        //     ->has(
        //     Classes::factory()
        //            ->count(3)
        // )->create(); 
        // Classes::factory()->userId(5)
        //     ->has(
        //     Student::factory()
        //            ->count(33)
        // )->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // Student::factory(200)->create();

        // StudentClasses::factory()->classId(10)->studentId(4)->create();

    }
}
