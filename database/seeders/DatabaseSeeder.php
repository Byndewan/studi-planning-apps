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
        $this->call([
            UserSeeder::class,
            SemesterSeeder::class,
            CourseSeeder::class,
            StudyGoalSeeder::class,
            WeeklyPlanSeeder::class,
            MonitoringSeeder::class,
            Sq3rSessionSeeder::class,
            ConceptMapSeeder::class,
        ]);
    }
}
