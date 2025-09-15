<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Semester;
use App\Models\Course;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create test user
        $user = User::create([
            'name' => 'M Abyan',
            'email' => 'abyan@gmail.com',
            'password' => Hash::make('abyan123'),
        ]);

        // Create current semester
        $currentSemester = Semester::create([
            'user_id' => $user->id,
            'name' => 'Fall 2024',
            'start_date' => now()->subMonth(),
            'end_date' => now()->addMonths(4),
        ]);

        // Create courses for current semester
        $courses = [
            ['Mathematics 101', 'MATH101', 3],
            ['Physics Fundamentals', 'PHYS101', 4],
            ['Introduction to Programming', 'CS101', 3],
            ['English Composition', 'ENG101', 2],
        ];

        foreach ($courses as $course) {
            Course::create([
                'semester_id' => $currentSemester->id,
                'name' => $course[0],
                'code' => $course[1],
                'sks' => $course[2],
                'total_modules' => rand(8, 12),
            ]);
        }

        // Create past semester
        $pastSemester = Semester::create([
            'user_id' => $user->id,
            'name' => 'Spring 2024',
            'start_date' => now()->subMonths(6),
            'end_date' => now()->subMonths(2),
        ]);

        // Create courses for past semester
        $pastCourses = [
            ['Calculus I', 'MATH201', 4],
            ['Chemistry Basics', 'CHEM101', 3],
        ];

        foreach ($pastCourses as $course) {
            Course::create([
                'semester_id' => $pastSemester->id,
                'name' => $course[0],
                'code' => $course[1],
                'sks' => $course[2],
                'total_modules' => rand(8, 12),
            ]);
        }
    }
}
