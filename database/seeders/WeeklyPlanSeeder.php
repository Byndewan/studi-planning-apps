<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WeeklyPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('weekly_plans')->insert([
            [
                'id' => 1,
                'user_id' => 1,
                'course_id' => 1,
                'week_number' => 1,
                'target_text' => 'Chapter 1: Algebra basics',
                'num_pages' => 20,
                'media' => '{"book":"Algebra I"}',
                'planned_hours' => 5.0,
                'status' => 'planned',
                'created_at' => '2025-09-16 06:55:03',
                'updated_at' => '2025-09-16 06:55:03',
            ],
            [
                'id' => 2,
                'user_id' => 1,
                'course_id' => 2,
                'week_number' => 1,
                'target_text' => 'Intro to programming: Variables & Loops',
                'num_pages' => 15,
                'media' => '{"book":"CS Fundamentals"}',
                'planned_hours' => 4.0,
                'status' => 'planned',
                'created_at' => '2025-09-16 06:55:03',
                'updated_at' => '2025-09-16 06:55:03',
            ],
            [
                'id' => 3,
                'user_id' => 2,
                'course_id' => 3,
                'week_number' => 1,
                'target_text' => 'Chapter 1: Algebra basics',
                'num_pages' => 20,
                'media' => '{"book":"Algebra I"}',
                'planned_hours' => 5.0,
                'status' => 'planned',
                'created_at' => '2025-09-16 06:55:03',
                'updated_at' => '2025-09-16 06:55:03',
            ],
        ]);
    }
}
