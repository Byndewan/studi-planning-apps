<?php

namespace App\Http\Controllers;

use App\Models\Semester;
use App\Models\Course;
use App\Models\WeeklyPlan;
// Tambahkan model untuk StudySession dan ConceptMap
use App\Models\StudySession;
use App\Models\ConceptMap;
use App\Models\SQ3RSession;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Get current semester
        $currentSemester = Semester::where('user_id', $user->id)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->first();

        // Get statistics
        $coursesCount = Course::whereHas('semester', function($query) use ($user) {
            $query->where('user_id', $user->id);
        })->count();

        // HITUNG RENCANA SELESAI (COMPLETED PLANS) & TOTAL RENCANA (TOTAL PLANS)
        $completedPlans = WeeklyPlan::whereHas('course.semester', function($query) use ($user) {
            $query->where('user_id', $user->id);
        })->where('status', 'completed')
        ->count();

        $totalPlans = WeeklyPlan::whereHas('course.semester', function($query) use ($user) {
            $query->where('user_id', $user->id);
        })->count();

        // Calculate completion rate (persentase)
        $completionRate = $totalPlans > 0 ? round(($completedPlans / $totalPlans) * 100) : 0;

        // HITUNG SESI BELAJAR (STUDY SESSIONS)
        $studySessionsCount = SQ3RSession::whereHas('course.semester', function($query) use ($user) {
            $query->where('user_id', $user->id);
        })->count();

        // HITUNG PETA KONSEP (CONCEPT MAPS)
        $conceptMapsCount = ConceptMap::whereHas('course.semester', function($query) use ($user) {
            $query->where('user_id', $user->id);
        })->count();

        // Get upcoming tasks
        $upcomingTasks = WeeklyPlan::whereHas('course.semester', function($query) use ($user) {
            $query->where('user_id', $user->id);
        })->where('status', '!=', 'completed')
        ->where('week_number', '<=', now()->weekOfYear)
        ->count();

        // Recent activities
        $recentActivities = [
            [
                'icon' => 'book',
                'title' => 'Added new course',
                'description' => 'Mathematics 101',
                'time' => '2 hours ago'
            ],
            [
                'icon' => 'plan',
                'title' => 'Completed weekly plan',
                'description' => 'Week 5 - Physics',
                'time' => '1 day ago'
            ]
        ];

        // Upcoming deadlines
        $upcomingDeadlines = [
            [
                'title' => 'Assignment 1',
                'course' => 'Mathematics',
                'date' => 'Tomorrow',
                'urgent' => true
            ],
            [
                'title' => 'Quiz 2',
                'course' => 'Physics',
                'date' => 'In 3 days',
                'urgent' => false
            ]
        ];

        return view('dashboard', compact(
            'currentSemester',
            'coursesCount',
            'completionRate',
            'upcomingTasks',
            'recentActivities',
            'upcomingDeadlines',
            'completedPlans',
            'totalPlans',
            'studySessionsCount',
            'conceptMapsCount'
        ));
    }
}
