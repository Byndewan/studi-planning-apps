<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Semester;
use App\Models\Course;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // USERS
        DB::table('users')->insert([
            'name' => 'M Abyan',
            'email' => 'abyan@gmail.com',
            'password' => Hash::make('abyan123'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // SEMESTERS
        DB::table('semesters')->insert([
            [
                'user_id' => 1,
                'name' => 'Fall 2024',
                'start_date' => '2025-08-15',
                'end_date' => '2026-01-15',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 1,
                'name' => 'Spring 2024',
                'start_date' => '2025-03-15',
                'end_date' => '2025-07-15',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // COURSES
        DB::table('courses')->insert([
            [
                'semester_id' => 1,
                'code' => 'MATH101',
                'name' => 'Mathematics 101',
                'sks' => 3,
                'total_modules' => 10,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'semester_id' => 1,
                'code' => 'CS101',
                'name' => 'Introduction to Programming',
                'sks' => 3,
                'total_modules' => 11,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'semester_id' => 2,
                'code' => 'CHEM101',
                'name' => 'Chemistry Basics',
                'sks' => 3,
                'total_modules' => 11,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // STUDY GOALS
        DB::table('study_goals')->insert([
            [
                'semester_id' => 1,
                'title' => 'Finish all assignments on time',
                'description' => 'Discipline with deadlines',
                'completed' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'semester_id' => 2,
                'title' => 'Improve GPA above 3.5',
                'description' => 'Focus more on daily study',
                'completed' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // WEEKLY PLANS
        DB::table('weekly_plans')->insert([
            [
                'course_id' => 1,
                'week_number' => 1,
                'target_text' => 'Chapter 1: Algebra basics',
                'num_pages' => 20,
                'media' => json_encode(['book' => 'Algebra I']),
                'planned_hours' => 5,
                'status' => 'planned',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'course_id' => 2,
                'week_number' => 1,
                'target_text' => 'Intro to programming: Variables & Loops',
                'num_pages' => 15,
                'media' => json_encode(['book' => 'CS Fundamentals']),
                'planned_hours' => 4,
                'status' => 'planned',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // MONITORINGS
        DB::table('monitorings')->insert([
            [
                'user_id' => 1,
                'course_id' => 1,
                'date' => Carbon::today(),
                'week_number' => 1,
                'planned' => 'Read Algebra basics',
                'actual' => 'Read 15/20 pages',
                'cause' => 'Too much distraction',
                'solution' => 'Study in library',
                'achieved' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // SQ3R SESSIONS
        DB::table('sq3r_sessions')->insert([
            [
                'user_id' => 1,
                'course_id' => 2,
                'module_title' => 'Intro to Programming - Variables',
                'survey_notes' => 'Skimmed chapter quickly',
                'questions' => json_encode(['What is a variable?', 'How to declare variables?']),
                'read_notes' => 'Variables store data',
                'recite_notes' => 'Explained examples aloud',
                'review_notes' => 'Reviewed summary at end of chapter',
                'timestamps' => json_encode(['start' => now(), 'end' => now()->addHour()]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // CONCEPT MAPS
        DB::table('concept_maps')->insert([
            [
                'user_id' => 1,
                'course_id' => 2,
                'title' => 'Programming Concepts',
                'nodes' => json_encode([
                    ['id' => 1, 'label' => 'Variables'],
                    ['id' => 2, 'label' => 'Loops'],
                ]),
                'edges' => json_encode([
                    ['from' => 1, 'to' => 2],
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
